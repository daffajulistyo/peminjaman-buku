<?php

namespace App\Http\Controllers\Backend\API;

use App\Models\Opd;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;


class ChartApiController extends Controller
{

    public function getTotalKehadiranPerOpd(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
        ]);

        try {
            $opds = Opd::all();

            $opdData = [];

            foreach ($opds as $opd) {
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


                $kurang = $userCount - $absensi;
                $tanpaKeteranganCount = $userCount - $absensi - $dinas - $izin - $sakit - $cuti;

                $opdData[] = [
                    'opd_id' => $opd->id,
                    'nama_opd' => $opd->name,
                    'jumlah_pegawai' => $userCount,
                    'jumlah_kurang' => $kurang,
                    'jumlah_hadir' => $absensi,
                    'jumlah_dinas' => $dinas,
                    'jumlah_izin' => $izin,
                    'jumlah_sakit' => $sakit,
                    'jumlah_cuti' => $cuti,
                    'jumlah_tanpa_keterangan' => $tanpaKeteranganCount

                ];
            }

            return response()->json(['data' => $opdData]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }
}
