<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\Opd;
use App\Models\Izin;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class LaporanApiController extends Controller
{
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
                    $query->whereDate('tanggal', $request->input('tanggal'));
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
                ->where('role', 2)
                ->with(['absensi' => function ($query) use ($request) {
                    $query->whereDate('tanggal', $request->input('tanggal'));
                }])
                ->get()
                ->map(function ($user) {
                    return $user->absensi->map(function ($absensi) use ($user) {
                        $keterangan = $this->getKeterangan($absensi->jam_masuk);
                        return [
                            'name' => $user->name,
                            'keterangan' => $keterangan,
                        ];
                    })->toArray();
                })
                ->flatten() // Menggabungkan array yang bersarang menjadi satu dimensi
                ->filter()
                ->values()
                ->toArray();


            $dinasList = $opd->users()
                ->where('role', 2)
                ->with(['dinas' => function ($query) use ($request) {
                    $query->whereDate('tanggal', $request->input('tanggal'));
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
                    return $user->izin->map(function ($izin) use ($user) {
                        return [
                            'name' => $user->name,
                            'keterangan' => $izin->keterangan, // Sesuaikan dengan nama kolom yang benar
                        ];
                    });
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

            return response()->json([
                'data' => [
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
                ],
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'OPD not found'], 404);
        }
    }

    private function getKeterangan($jamMasuk)
    {
        $jamMasukThreshold = Carbon::parse('07:30'); // Sesuaikan ambang batas yang dibutuhkan

        return Carbon::parse($jamMasuk)->gt($jamMasukThreshold) ? 'TELAT' : 'HADIR';
    }
}
