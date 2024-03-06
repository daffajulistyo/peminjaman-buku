<?php

namespace App\Http\Controllers\Backend;

use App\Models\Cuti;
use App\Models\Izin;
use App\Models\User;
use App\Models\Dinas;
use App\Models\Sakit;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CutiController extends Controller
{
    public function simpanCuti(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required',

        ]);

        $existingCuti = Cuti::where('tanggal_mulai', '<=', $request->input('tanggal_mulai'))
            ->where('tanggal_selesai', '>=', $request->input('tanggal_selesai'))
            ->where('user_id', $request->input('user_id'))
            ->first();

        if ($existingCuti) {
            $existingCuti->update([
                'tanggal_mulai' => $request->input('tanggal_mulai'),
                'tanggal_selesai' => $request->input('tanggal_selesai'),
                'keterangan' => $request->input('keterangan'),
            ]);

            Absensi::whereBetween('tanggal', [$request->input('tanggal_mulai'), $request->input('tanggal_selesai')])
                ->where('user_id', $request->input('user_id'))
                ->delete();
            Izin::whereBetween('tanggal', [$request->input('tanggal_mulai'), $request->input('tanggal_selesai')])
                ->where('user_id', $request->input('user_id'))
                ->delete();
            Sakit::whereBetween('tanggal', [$request->input('tanggal_mulai'), $request->input('tanggal_selesai')])
                ->where('user_id', $request->input('user_id'))
                ->delete();
            Dinas::whereBetween('tanggal', [$request->input('tanggal_mulai'), $request->input('tanggal_selesai')])
                ->where('user_id', $request->input('user_id'))
                ->delete();



            return redirect()->route('cuti.index')->with('success', 'Data Cuti berhasil disimpan.');
        } else {
            $cuti = new Cuti;
            $cuti->user_id = $request->input('user_id');
            $cuti->tanggal_mulai = $request->input('tanggal_mulai');
            $cuti->tanggal_selesai = $request->input('tanggal_selesai');
            $cuti->keterangan = $request->input('keterangan');
            $cuti->save();
        }

        Absensi::whereBetween('tanggal', [$request->input('tanggal_mulai'), $request->input('tanggal_selesai')])
            ->where('user_id', $request->input('user_id'))
            ->delete();
        Izin::whereBetween('tanggal', [$request->input('tanggal_mulai'), $request->input('tanggal_selesai')])
            ->where('user_id', $request->input('user_id'))
            ->delete();
        Sakit::whereBetween('tanggal', [$request->input('tanggal_mulai'), $request->input('tanggal_selesai')])
            ->where('user_id', $request->input('user_id'))
            ->delete();
        Dinas::whereBetween('tanggal', [$request->input('tanggal_mulai'), $request->input('tanggal_selesai')])
            ->where('user_id', $request->input('user_id'))
            ->delete();



        return redirect()->route('cuti.index')->with('success', 'Data Cuti berhasil disimpan.');
    }

    public function create()
    {
        $users = User::all(); // Mengambil semua pengguna dari tabel 'users'
        return view('backend.absensi.list_absensi', compact('users'));
    }

    public function index(Request $request)
    {
        $searchName = $request->input('search_name');

        // Mengambil data dinas dengan pagination
        $cuti = Cuti::query();

        // Filter berdasarkan role dan OPD user yang sedang login
        if (Auth::user()->role == 1) {
            // Jika role user adalah 1 (admin), tampilkan semua data cuti berdasarkan OPD
            $cuti->whereHas('user', function ($query) {
                $query->where('opd_id', Auth::user()->opd->id);
            });
        } else {
            // Jika role user bukan admin, tampilkan hanya data cuti milik user tersebut
            $cuti->where('user_id', Auth::id());
        }

        // Filter berdasarkan nama pengguna
        if ($searchName) {
            $cuti->whereHas('user', function ($query) use ($searchName) {
                $query->where('name', 'like', '%' . $searchName . '%');
            });
        }
        $cuti = $cuti->paginate(10); // Jumlah data per halaman disetel menjadi 10, sesuaikan dengan kebutuhan Anda

        return view('backend.absensi.list_cuti', compact('cuti'));
    }

    public function update(Request $request, $id)
    {
        $cuti = Cuti::find($id);
        $cuti->update($request->all());
        return redirect()->route('cuti.index')->with('success', 'Cuti berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $cuti = Cuti::find($id);
        $cuti->delete();
        return redirect()->route('cuti.index')->with('success', 'Cuti berhasil dihapus!');
    }
}
