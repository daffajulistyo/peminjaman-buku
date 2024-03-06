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

class SakitController extends Controller
{
    public function simpanSakit(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'keterangan' => 'required',
        ]);

        $existingSakit = Sakit::where('tanggal', $request->input('tanggal'))
            ->where('user_id', $request->input('user_id'))
            ->first();

        if ($existingSakit) {
            $existingSakit->update([
                'keterangan' => $request->input('keterangan'),
            ]);

            Absensi::where('tanggal', $request->input('tanggal'))
                ->where('user_id', $request->input('user_id'))
                ->delete();
            Dinas::where('tanggal', $request->input('tanggal'))
                ->where('user_id', $request->input('user_id'))
                ->delete();
            Izin::where('tanggal', $request->input('tanggal'))
                ->where('user_id', $request->input('user_id'))
                ->delete();
            Cuti::where('tanggal_mulai', '<=', $request->input('tanggal'))
                ->where('tanggal_selesai', '>=', $request->input('tanggal'))
                ->where('user_id', $request->input('user_id'))
                ->delete();

            return redirect()->route('sakit.index')->with('success', 'Data Izin berhasil disimpan.');
        } else {
            $sakit = new Sakit;
            $sakit->user_id = $request->input('user_id');
            $sakit->tanggal = $request->input('tanggal');
            $sakit->keterangan = $request->input('keterangan');
            $sakit->save();
        }

        Absensi::where('user_id', $request->input('user_id'))
            ->whereDate('tanggal', $request->input('tanggal'))
            ->delete();

        Izin::where('user_id', $request->input('user_id'))
            ->whereDate('tanggal', $request->input('tanggal'))
            ->delete();

        Cuti::where('tanggal_mulai', '<=', $request->input('tanggal'))
            ->where('tanggal_selesai', '>=', $request->input('tanggal'))
            ->where('user_id', $request->input('user_id'))
            ->delete();

        Dinas::where('user_id', $request->input('user_id'))
            ->whereDate('tanggal', $request->input('tanggal'))
            ->delete();

        return redirect()->route('sakit.index')->with('success', 'Data Sakit berhasil disimpan.');
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
        $sakit = Sakit::query()->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc');;

        // Filter berdasarkan role dan OPD user yang sedang login
        if (Auth::user()->role == 1) {
            // Jika role user adalah 1 (admin), tampilkan semua data sakit berdasarkan OPD
            $sakit->whereHas('user', function ($query) {
                $query->where('opd_id', Auth::user()->opd->id);
            });
        } else {
            // Jika role user bukan admin, tampilkan hanya data sakit milik user tersebut
            $sakit->where('user_id', Auth::id());
        }

        // Filter berdasarkan nama pengguna
        if ($searchName) {
            $sakit->whereHas('user', function ($query) use ($searchName) {
                $query->where('name', 'like', '%' . $searchName . '%');
            });
        }
        $sakit = $sakit->paginate(10); // Jumlah data per halaman disetel menjadi 10, sesuaikan dengan kebutuhan Anda

        return view('backend.absensi.list_sakit', compact('sakit'));
    }

    public function update(Request $request, $id)
    {
        $sakit = Sakit::find($id);
        $sakit->update($request->all());
        return redirect()->route('sakit.index')->with('success', 'Presensi Sakit berhasil Diperbarui!');
    }

    public function destroy($id)
    {
        $sakit = Sakit::find($id);
        $sakit->delete();
        return redirect()->route('sakit.index')->with('success', 'Presensi Sakit berhasil dihapus!');
    }
}
