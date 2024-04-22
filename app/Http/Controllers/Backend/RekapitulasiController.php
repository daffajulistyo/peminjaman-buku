<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Opd;
use App\Models\User;

class RekapitulasiController extends Controller
{
    public function index()
    {
        // Mengambil semua data OPD dari basis data
        $opds = Opd::all();

        // Mengirim data ke view
        return view('backend.master.rekapitulasi', compact('opds'));
    }

    public function show($opdId)
    {
        try {
            // Dapatkan data OPD berdasarkan ID
            $opd = Opd::findOrFail($opdId);
            $userCount = $opd->users()->where('role', 2)->count();

            $users = User::where('opd_id', $opdId)->get();
            
            $absensi = $opd->users()
                ->where('role', 2)
                ->with(['absensi' => function ($query) {
                    $query->whereDate('tanggal', \Carbon\Carbon::today());
                }])
                ->get()
                ->pluck('absensi')
                ->flatten()
                ->count();

                $isKepalaDinas = $opd->users()->whereHas('eselon', function ($query) {
                    $query->where('name', 'Eselon II');
                })->exists();
    
                if ($isKepalaDinas) {
                    $absensi += 1;
                }
                
            $dinas = $opd->users()
                ->where('role', 2)
                ->with(['dinas' => function ($query) {
                    $query->whereDate('tanggal', \Carbon\Carbon::today());

                }])
                ->get()
                ->pluck('dinas')
                ->flatten()
                ->count();

            $izin = $opd->users()
                ->where('role', 2)
                ->with(['izin' => function ($query) {
                    $query->whereDate('tanggal', \Carbon\Carbon::today());
                }])
                ->get()
                ->pluck('izin')
                ->flatten()
                ->count();

            $sakit = $opd->users()
                ->where('role', 2)
                ->with(['sakit' => function ($query) {
                    $query->whereDate('tanggal', \Carbon\Carbon::today());
                }])
                ->get()
                ->pluck('sakit')
                ->flatten()
                ->count();

            $cuti = $opd->users()
                ->where('role', 2)
                ->with(['cuti' => function ($query) {
                    $query->whereDate('tanggal_mulai', '<=', \Carbon\Carbon::today())
                        ->whereDate('tanggal_selesai', '>=', \Carbon\Carbon::today());
                }])
                ->get()
                ->pluck('cuti')
                ->flatten()
                ->count();

                $absensiList = $opd->users()
                ->where('role', 2) // Memeriksa apakah pengguna memiliki peran Eselon II
                ->with(['absensi' => function ($query) {
                    $query->whereDate('tanggal', \Carbon\Carbon::today());
                }])
                ->get()
                ->map(function ($user) {
                    if ($user->eselon && $user->eselon->name === 'Eselon II') {
                        return $user->name;
                    } else {
                        // Periksa apakah ada data absensi untuk pengguna
                        return $user->absensi->isNotEmpty() ? $user->name : null;
                    }
                })
                ->filter() // Hapus nilai null dari array
                ->values() // Reset kembali indeks array
                ->toArray();
            
            
            $dinasList = $opd->users()
                ->where('role', 2)
                ->with(['dinas' => function ($query) {
                    $query->whereDate('tanggal', \Carbon\Carbon::today());

                }])
                ->get()
                ->map(function ($user) {
                    return $user->dinas->isNotEmpty() ? $user->name : null;
                })
                ->filter()
                ->values()
                ->toArray();

            $izinList = $opd->users()
                ->where('role', 2)
                ->with(['izin' => function ($query) {
                    $query->whereDate('tanggal', \Carbon\Carbon::today());
                }])
                ->get()
                ->map(function ($user) {
                    return $user->izin->isNotEmpty() ? $user->name : null;
                })
                ->filter()
                ->values()
                ->toArray();

            $cutiList = $opd->users()
                ->where('role', 2)
                ->with(['cuti' => function ($query) {
                    $query->whereDate('tanggal_mulai', '<=', \Carbon\Carbon::today())
                        ->whereDate('tanggal_selesai', '>=', \Carbon\Carbon::today());
                }])
                ->get()
                ->map(function ($user) {
                    return $user->cuti->isNotEmpty() ? $user->name : null;
                })
                ->filter()
                ->values()
                ->toArray();

            $sakitList = $opd->users()
                ->where('role', 2)
                ->with(['sakit' => function ($query) {
                    $query->whereDate('tanggal', \Carbon\Carbon::today());
                }])
                ->get()
                ->map(function ($user) {
                    return $user->sakit->isNotEmpty() ? $user->name : null;
                })
                ->filter()
                ->values()
                ->toArray();

            $tanpaKeteranganList = $opd->users()
                ->where('role', 2)
                ->get()
                ->pluck('name')
                ->diff($absensiList)
                ->diff($dinasList)
                ->diff($izinList)
                ->diff($cutiList)
                ->diff($sakitList)
                ->values()
                ->toArray();

            $kurang = $userCount - $absensi;
            $tanpaKeteranganCount = $userCount - $absensi - $dinas - $izin - $sakit - $cuti;
            // Kirim data OPD dan pegawai ke tampilan
            return view('backend.master.list_rekapitulasi', [
                'opd_name' => $opd->name,
                'users' => $users,
                'userCount' => $userCount,
                'hadir' => $absensi,
                'dinas' => $dinas,
                'izin' => $izin,
                'cuti' => $cuti,
                'sakit' => $sakit,
                'absensiList' => $absensiList,
                'dinasList' => $dinasList,
                'izinList' => $izinList,
                'cutiList' => $cutiList,
                'sakitList' => $sakitList,
                'tanpaKeteranganList' => $tanpaKeteranganList,
                'kurang' => $kurang,
                'tanpaKeteranganCount' => $tanpaKeteranganCount,

            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'OPD not found'], 404);
        }
    }


    public function getUsersCountByOpd(Request $request)
    {
        $request->validate([
            'opd_id' => 'required|exists:opds,id',
            'tanggal' => 'required|date',
        ]);

        try {
            $opd = Opd::findOrFail($request->input('opd_id'));

            $userCount = $opd->users()->where('role', 2)->count();

            $absensi = $opd->users()
                ->where('role', 2)
                ->with(['absensi' => function ($query) use ($request) {
                    $query->whereDate('tanggal', $request->input('tanggal'));
                }])
                ->get()
                ->pluck('absensi')
                ->flatten()
                ->count();

            $dinas = $opd->users()
                ->where('role', 2)
                ->with(['dinas' => function ($query) use ($request) {
                    $query->whereDate('tanggal_mulai', '<=', $request->input('tanggal'))
                        ->whereDate('tanggal_selesai', '>=', $request->input('tanggal'));
                }])
                ->get()
                ->pluck('dinas')
                ->flatten()
                ->count();

            $izin = $opd->users()
                ->where('role', 2)
                ->with(['izin' => function ($query) use ($request) {
                    $query->whereDate('tanggal', $request->input('tanggal'));
                }])
                ->get()
                ->pluck('izin')
                ->flatten()
                ->count();

            $sakit = $opd->users()
                ->where('role', 2)
                ->with(['sakit' => function ($query) use ($request) {
                    $query->whereDate('tanggal', $request->input('tanggal'));
                }])
                ->get()
                ->pluck('sakit')
                ->flatten()
                ->count();

            $cuti = $opd->users()
                ->where('role', 2)
                ->with(['cuti' => function ($query) use ($request) {
                    $query->whereDate('tanggal_mulai', '<=', $request->input('tanggal'))
                        ->whereDate('tanggal_selesai', '>=', $request->input('tanggal'));
                }])
                ->get()
                ->pluck('cuti')
                ->flatten()
                ->count();

            $absensiList = $opd->users()
                ->with(['absensi' => function ($query) use ($request) {
                    $query->whereDate('tanggal', $request->input('tanggal'));
                }])
                ->get()
                ->map(function ($user) {
                    return $user->absensi->isNotEmpty() ? $user->name : null;
                })
                ->flatten() // Menggabungkan array yang bersarang menjadi satu dimensi
                ->filter()
                ->values()
                ->toArray();

            $dinasList = $opd->users()
                ->where('role', 2)
                ->with(['dinas' => function ($query) use ($request) {
                    $query->whereDate('tanggal_mulai', '<=', $request->input('tanggal'))
                        ->whereDate('tanggal_selesai', '>=', $request->input('tanggal'));
                }])
                ->get()
                ->map(function ($user) {
                    return $user->dinas->isNotEmpty() ? $user->name : null;
                })
                ->filter()
                ->values()
                ->toArray();

            $izinList = $opd->users()
                ->where('role', 2)
                ->with(['izin' => function ($query) use ($request) {
                    $query->whereDate('tanggal', $request->input('tanggal'));
                }])
                ->get()
                ->map(function ($user) {
                    return $user->izin->isNotEmpty() ? $user->name : null;
                })
                ->flatten() // Menggabungkan array yang bersarang menjadi satu dimensi
                ->values()
                ->toArray();

            $cutiList = $opd->users()
                ->where('role', 2)
                ->with(['cuti' => function ($query) use ($request) {
                    $query->whereDate('tanggal_mulai', '<=', $request->input('tanggal'))
                        ->whereDate('tanggal_selesai', '>=', $request->input('tanggal'));
                }])
                ->get()
                ->map(function ($user) {
                    return $user->cuti->isNotEmpty() ? $user->name : null;
                })
                ->filter()
                ->values()
                ->toArray();

            $sakitList = $opd->users()
                ->where('role', 2)
                ->with(['sakit' => function ($query) use ($request) {
                    $query->whereDate('tanggal', $request->input('tanggal'));
                }])
                ->get()
                ->map(function ($user) {
                    return $user->sakit->isNotEmpty() ? $user->name : null;
                })
                ->filter()
                ->values()
                ->toArray();

            $tanpaKeteranganList = $opd->users()
                ->where('role', 2)
                ->get()
                ->pluck('name')
                ->diff($absensiList)
                ->diff($dinasList)
                ->diff($izinList)
                ->diff($cutiList)
                ->diff($sakitList)
                ->values()
                ->toArray();

            $kurang = $userCount - $absensi;
            $tanpaKeteranganCount = $userCount - $absensi - $dinas - $izin - $sakit - $cuti;

            return view('backend.master.list_rekapitulasi', [

                'opd_id' => $opd->id,
                'nama_opd' => $opd->name,
                'jumlah_pegawai' => $userCount,
                'jumlah_kurang' => $kurang,
                'jumlah_hadir' => $absensi,
                'jumlah_dinas' => $dinas,
                'jumlah_izin' => $izin,
                'jumlah_sakit' => $sakit,
                'jumlah_cuti' => $cuti,
                'jumlah_tanpa_keterangan' => $tanpaKeteranganCount,
                'pegawai_dinas' => $dinasList,
                'pegawai_hadir' => $absensiList,
                'pegawai_izin' => $izinList,
                'pegawai_sakit' => $sakitList,
                'pegawai_cuti' => $cutiList,
                'pegawai_tanpa_keterangan' => $tanpaKeteranganList,

            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'OPD not found'], 404);
        }
    }
}
