<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Exports\AbsensiExport;
use Charts;
use Illuminate\Validation\ValidationException;

class AbsensiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $searchName = $request->input('search_name');


        $absenQuery = Absensi::with('user')->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc');

        // Lakukan filter data berdasarkan role dan opd jika user memenuhi syarat
        if (Auth::user()->role == 1) {
            $absenQuery->whereHas('user', function ($query) {
                $query->where('opd_id', Auth::user()->opd_id);
            });
        } else {
            $absenQuery->where('user_id', Auth::user()->id);
        }

        if ($searchName) {
            $absenQuery->whereHas('user', function ($query) use ($searchName) {
                $query->where('name', 'like', '%' . $searchName . '%');
            });
        }

        $absen = $absenQuery->paginate(10);

        $absen->appends(['search_name' => $searchName]);

        return view('backend.absensi.list_absensi', compact('absen'));
    }


    public function create()
    {
        $name = Auth::user()->name;
        $users = User::all();
        return view('backend.absensi.list_absensi', compact('name', 'users'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $currentDate = now()->toDateString();

        $existingAbsensi = Absensi::where('user_id', $user->id)
            ->where('tanggal', $currentDate)
            ->first();

        if ($existingAbsensi) {
            // Jika sudah melakukan absen masuk, periksa apakah sudah absen keluar
            if ($existingAbsensi->jam_keluar) {
                return redirect()->route('absensi.index')->with('error', 'Anda sudah melakukan absen masuk dan keluar hari ini.');
            } else {
                // Jika belum melakukan absen keluar, simpan data jam keluar
                $jamKeluar = Carbon::now('Asia/Jakarta');
                $existingAbsensi->update([
                    'jam_keluar' => $jamKeluar->toTimeString(),
                ]);

                return redirect()->route('absensi.index')->with('success', 'Absen Keluar berhasil disimpan!');
            }
        } else {
            // Jika belum ada absen masuk pada tanggal yang sama, buat entri baru dengan jam masuk
            $jamMasuk = Carbon::now('Asia/Jakarta');
            Absensi::create([
                'user_id' => $user->id,
                'tanggal' => $currentDate,
                'jam_masuk' => $jamMasuk->toTimeString(),
            ]);

            return redirect()->route('absensi.index')->with('success', 'Absen Masuk berhasil disimpan!');
        }
    }


    public function simpanAbsen(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'opd_id' => 'required|integer',
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required',
            'jam_keluar' => '', // Jam keluar bisa kosong atau optional
        ]);

        // Ambil jabatan_id dari user_id yang dipilih
        $user = User::findOrFail($validatedData['user_id']);
        $jabatanId = $user->jabatan_id;

        // Tambahkan jabatan_id ke dalam data yang akan disimpan
        $validatedData['jabatan_id'] = $jabatanId;

        // Simpan data absensi ke dalam database
        Absensi::create($validatedData);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil disimpan.');
    }



    public function insertKeluar(Request $request)
    {
        $user = Auth::user();
        $currentDate = now()->toDateString();

        // Cari entri absensi untuk pengguna dan tanggal saat ini
        $absensi = Absensi::where('user_id', $user->id)
            ->where('tanggal', $currentDate)
            ->first();

        if (!$absensi) {
            return redirect()->route('absensi.index')->with('error', 'Anda belum melakukan absensi masuk hari ini.');
        }

        $jamKeluar = Carbon::now('Asia/Jakarta');
        $absensi->update([
            'jam_keluar' => $jamKeluar->toTimeString(),
        ]);

        return redirect()->route('absensi.index')->with('success', 'Absen Keluar berhasil disimpan!');
    }

    public function show($id)
    {
        $absensi = Absensi::find($id);
        return view('absensi.show', compact('absensi'));
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();

            $absensi = Absensi::find($id);

            if (!$absensi) {
                return redirect()->route('absensi.index')->with('error', 'Absensi not found.');
            }

            $absensi->update($data);

            return redirect()->route('absensi.index')->with('success', 'Jam Pulang berhasil Disimpan!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\PDOException $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan dalam menyimpan data1.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan dalam menyimpan data2.');
        }
    }


    public function destroy($id)
    {
        $absensi = Absensi::find($id);
        $absensi->delete();

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dihapus!');
    }
}
