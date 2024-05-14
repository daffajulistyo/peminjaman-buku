<?php

namespace App\Http\Controllers\Backend\API;

use App\Models\Opd;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\User;
use App\Models\Dinas;
use App\Models\Sakit;
use App\Models\Absensi;
use App\Models\Koordinat;
use Illuminate\Http\Request;
use App\Models\LiburNasional;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class ReportApiController extends Controller
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

            $isKepalaDinas = $opd->users()->whereHas('eselon', function ($query) {
                $query->where('name', 'Eselon II B');
            })->exists();

            $isAjudan = $opd->users()->whereHas('eselon', function ($query) {
                $query->where('name', 'Eselon II C');
            });

            if ($isKepalaDinas) {
                $absensi += 1;
            }

            if ($isAjudan) {
                $absensi += 1;
            }

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
                ->with(['absensi' => function ($query) use ($request) {
                    $query->whereDate('tanggal', $request->input('tanggal'));
                }])
                ->get()
                ->map(function ($user) {
                    // Periksa apakah properti 'eselon' tersedia dan bukan null sebelum mengakses properti 'name'
                    if ($user->eselon && ($user->eselon->name === 'Eselon II B' || $user->eselon->name === 'Ajudan') && $user->absensi->isEmpty()) {
                        return [
                            'name' => $user->name,
                            'keterangan' => '★',
                        ];
                    }

                    // Jika ada data absensi, map setiap absensi ke dalam format yang diinginkan
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

    public function rekapLaporan(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
        $selectedOpdId = $request->input('opd');

        $opd = Opd::find($selectedOpdId);

        $selectedUserId = $request->input('user_id');
        $selectedUser = User::find($selectedUserId);

        $dates = [];
        $currentDate = Carbon::parse($tanggalMulai);

        while ($currentDate->lte(Carbon::parse($tanggalSelesai))) {
            if ($currentDate->dayOfWeek >= Carbon::MONDAY && $currentDate->dayOfWeek <= Carbon::FRIDAY) {
                $dates[] = $currentDate->format('Y-m-d');
            }
            $currentDate->addDay();
        }

        $nationalHolidays = LiburNasional::whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])->get();

        $attendanceData = [];
        $dutyData = [];
        $sickData = [];
        $permissionData = [];
        $leaveData = [];

        foreach ($dates as $date) {
            $isNationalHoliday = $nationalHolidays->contains('tanggal', $date);

            if ($selectedUser && is_object($selectedUser)) {
                $userAttendance = Absensi::where('user_id', $selectedUser->id)
                    ->whereDate('tanggal', $date)
                    ->first();

                $hasDuty = Dinas::where('user_id', $selectedUser->id)
                    ->whereDate('tanggal', $date)
                    ->exists();

                $hasSick = Sakit::where('user_id', $selectedUser->id)
                    ->whereDate('tanggal', $date)
                    ->exists();

                $hasPermission = Izin::where('user_id', $selectedUser->id)
                    ->whereDate('tanggal', $date)
                    ->exists();

                $leave = Cuti::where('user_id', $selectedUser->id)
                    ->whereDate('tanggal_mulai', '<=', $date)
                    ->whereDate('tanggal_selesai', '>=', $date)
                    ->exists();

                if ($selectedUser->eselon && ($selectedUser->eselon->name === 'Eselon II B' || $selectedUser->eselon->name === 'Eselon II A' || $selectedUser->eselon->name === 'Ajudan') && Carbon::parse($tanggalMulai)->lte(Carbon::parse($date)) && Carbon::parse($date)->lte(Carbon::parse($tanggalSelesai))) {
                    $attendanceData[$date] = $isNationalHoliday
                    ? ['jam_masuk' => 'Libur Nasional', 'jam_keluar' => 'Libur Nasional']
                    : ['jam_masuk' => optional($userAttendance)->jam_masuk ?? '★', 'jam_keluar' => optional($userAttendance)->jam_keluar ?? '★'];
                } else {
                    $attendanceData[$date] = $isNationalHoliday
                    ? ['jam_masuk' => 'Libur Nasional', 'jam_keluar' => 'Libur Nasional']
                    : ['jam_masuk' => optional($userAttendance)->jam_masuk ?? 'Tanpa Keterangan', 'jam_keluar' => optional($userAttendance)->jam_keluar ?? 'Tanpa Keterangan'];
                }

                $dutyData[$date] = $hasDuty ? 'Dinas' : 'Tanpa Keterangan';
                $sickData[$date] = $hasSick ? 'Sakit' : 'Tanpa Keterangan';
                $permissionData[$date] = $hasPermission ? 'Izin' : 'Tanpa Keterangan';
                $leaveData[$date] = $leave ? 'Cuti' : 'Tanpa Keterangan';
            }
        }

        $data = [
            'opd' => $opd,
            'dates' => $dates,
            'attendanceData' => $attendanceData,
            'dutyData' => $dutyData,
            'permissionData' => $permissionData,
            'sickData' => $sickData,
            'leaveData' => $leaveData,
        ];

        return response()->json(['data' => $data]);
    }
}
