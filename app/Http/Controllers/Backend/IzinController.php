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

class IzinController extends Controller
{
    public function simpanIzin(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'keterangan' => 'required',
        ]);

        $existingIzin = Izin::where('tanggal', $request->input('tanggal'))
            ->where('user_id', $request->input('user_id'))
            ->first();

        if ($existingIzin) {
            $existingIzin->update([
                'keterangan' => $request->input('keterangan'),
            ]);
            Absensi::where('tanggal', $request->input('tanggal'))
                ->where('user_id', $request->input('user_id'))
                ->delete();
            Dinas::where('tanggal', $request->input('tanggal'))
                ->where('user_id', $request->input('user_id'))
                ->delete();
            Sakit::where('tanggal', $request->input('tanggal'))
                ->where('user_id', $request->input('user_id'))
                ->delete();
            Cuti::where('tanggal_mulai', '<=', $request->input('tanggal'))
                ->where('tanggal_selesai', '>=', $request->input('tanggal'))
                ->where('user_id', $request->input('user_id'))
                ->delete();

            return redirect()->route('izin.index')->with('success', 'Data Izin berhasil disimpan.');
        } else {
            $izin = new Izin;
            $izin->user_id = $request->input('user_id');
            $izin->tanggal = $request->input('tanggal');
            $izin->keterangan = $request->input('keterangan');
            $izin->save();
        }

        Absensi::where('user_id', $request->input('user_id'))
            ->whereDate('tanggal', $request->input('tanggal'))
            ->delete();

        Dinas::where('user_id', $request->input('user_id'))
            ->whereDate('tanggal', $request->input('tanggal'))
            ->delete();

        Cuti::where('tanggal_mulai', '<=', $request->input('tanggal'))
            ->where('tanggal_selesai', '>=', $request->input('tanggal'))
            ->where('user_id', $request->input('user_id'))
            ->delete();

        Sakit::where('user_id', $request->input('user_id'))
            ->whereDate('tanggal', $request->input('tanggal'))
            ->delete();

        return redirect()->route('izin.index')->with('success', 'Data Izin berhasil disimpan.');
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
        $izin = Izin::query()->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc');;

        // Filter berdasarkan role dan OPD user yang sedang login
        if (Auth::user()->role == 1) {
            // Jika role user adalah 1 (admin), tampilkan semua data izin berdasarkan OPD
            $izin->whereHas('user', function ($query) {
                $query->where('opd_id', Auth::user()->opd->id);
            });
        } else {
            // Jika role user bukan admin, tampilkan hanya data izin milik user tersebut
            $izin->where('user_id', Auth::id());
        }

        // Filter berdasarkan nama pengguna
        if ($searchName) {
            $izin->whereHas('user', function ($query) use ($searchName) {
                $query->where('name', 'like', '%' . $searchName . '%');
            });
        }
        $izin = $izin->paginate(10); // Jumlah data per halaman disetel menjadi 10, sesuaikan dengan kebutuhan Anda

        return view('backend.absensi.list_izin', compact('izin'));
    }

    public function update(Request $request, $id)
    {
        $izin = Izin::find($id);
        $izin->update($request->all());
        return redirect()->route('izin.index')->with('success', 'Izin berhasil Diperbarui!');
    }

    public function destroy($id)
    {
        $izin = Izin::find($id);
        $izin->delete();
        return redirect()->route('izin.index')->with('success', 'Izin berhasil dihapus!');
    }
}
