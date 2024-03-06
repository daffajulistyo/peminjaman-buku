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

class DinasController extends Controller
{
    public function simpanDinas(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required',

        ]);

        $existingDinas = Dinas::where('tanggal_mulai', '<=', $request->input('tanggal_mulai'))
            ->where('tanggal_selesai', '>=', $request->input('tanggal_selesai'))
            ->where('user_id', $request->input('user_id'))
            ->first();

        if ($existingDinas) {
            $existingDinas->update([
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
            Cuti::where('tanggal_mulai', '<=', $request->input('tanggal'))
                ->where('tanggal_selesai', '>=', $request->input('tanggal'))
                ->where('user_id', $request->input('user_id'))
                ->delete();

            return redirect()->route('dinas.index')->with('success', 'Data Dinas berhasil disimpan.');
        } else {
            $dinas = new Dinas;
            $dinas->user_id = $request->input('user_id');
            $dinas->tanggal_mulai = $request->input('tanggal_mulai');
            $dinas->tanggal_selesai = $request->input('tanggal_selesai');
            $dinas->keterangan = $request->input('keterangan');
            $dinas->save();
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

        return redirect()->route('dinas.index')->with('success', 'Data Dinas berhasil disimpan.');
    }


    public function create()
    {
        $dinas = User::all(); // Mengambil semua pengguna dari tabel 'dinas'
        return view('backend.absensi.list_dinas', compact('dinas'));
    }

    public function index(Request $request)
    {
        $searchName = $request->input('search_name');

        // Mengambil data dinas dengan pagination
        $dinas = Dinas::query()->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc');

        // Filter berdasarkan role dan OPD user yang sedang login
        if (Auth::user()->role == 1) {
            // Jika role user adalah 1 (admin), tampilkan semua data dinas berdasarkan OPD
            $dinas->whereHas('user', function ($query) {
                $query->where('opd_id', Auth::user()->opd->id);
            });
        } else {
            // Jika role user bukan admin, tampilkan hanya data dinas milik user tersebut
            $dinas->where('user_id', Auth::id());
        }

        // Filter berdasarkan nama pengguna
        if ($searchName) {
            $dinas->whereHas('user', function ($query) use ($searchName) {
                $query->where('name', 'like', '%' . $searchName . '%');
            });
        }
        $dinas = $dinas->paginate(10); // Jumlah data per halaman disetel menjadi 10, sesuaikan dengan kebutuhan Anda

        return view('backend.absensi.list_dinas', compact('dinas'));
    }


    public function update(Request $request, $id)
    {
        $dinas = Dinas::find($id);
        $dinas->update($request->all());
        return redirect()->route('dinas.index')->with('success', 'Dinas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $dinas = Dinas::find($id);
        $dinas->delete();
        return redirect()->route('dinas.index')->with('success', 'Dinas berhasil dihapus!');
    }
}
