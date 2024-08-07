<?php

namespace App\Http\Controllers\Backend;

use App\Models\Opd;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\User;
use App\Models\Dinas;
use App\Models\Sakit;
use App\Models\Absensi;
use App\Models\Koordinat;
use App\Models\TugasBelajar;
use Illuminate\Http\Request;
use App\Models\LiburNasional;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;


class ReportController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('backend.report.report', ['users' => $users]); // Mengambil data pegawai dan absen

    }

    public function indexAdmin()
    {
        $users = User::all();

        return view('backend.report.report_admin', ['users' => $users]); // Mengambil data pegawai dan absen

    }

    public function cetakReport()
    {
        $users = User::all();
        return view('backend.report.cetak-report', ['users' => $users]);
    }

    public function filterLaporan(Request $request)
    {
        // Dapatkan daftar OPD dari model
        $opds = Opd::all();

        // Dapatkan data user berdasarkan OPD yang dipilih
        $selectedOpdId = $request->input('opd');
        $opd = Opd::find($selectedOpdId);

        if ($opd && $opd->name === 'Penjaga Pintu Air') {
            $opd_ppu = Opd::where('name', 'Dinas Pekerjaan Umum dan Penataan Ruang')->first();

            $kepala = User::where('opd_id', $opd_ppu->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kepala Dinas')
                        ->orWhere('name', 'Kepala Puskesmas')
                        ->orWhere('name', 'Inspektur')
                        ->orWhere('name', 'Camat')
                        ->orWhere('name', 'Direktur')
                        ->orWhere('name', 'Kepala Satpol PP dan Damkar')
                        ->orWhere('name', 'Kepala Satuan')
                        ->orWhere('name', 'Kepala Badan');
                })->first();

            $kasubag = User::where('opd_id', $opd_ppu->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kasubag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Tata Usaha')
                        ->orWhere('name', 'Kasubbag TU Pimpinan, Staf Ahli dan Kepegawaian');
                })->first();
        } elseif ($opd && $opd->name === 'Penyuluh Pertanian') {
            $opd_pt = Opd::where('name', 'Dinas Pertanian')->first();

            $kepala = User::where('opd_id', $opd_pt->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kepala Dinas')
                        ->orWhere('name', 'Kepala Puskesmas')
                        ->orWhere('name', 'Inspektur')
                        ->orWhere('name', 'Camat')
                        ->orWhere('name', 'Direktur')
                        ->orWhere('name', 'Kepala Satpol PP dan Damkar')
                        ->orWhere('name', 'Kepala Satuan')
                        ->orWhere('name', 'Kepala Badan');
                })->first();

            $kasubag = User::where('opd_id', $opd_pt->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kasubag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Tata Usaha')
                        ->orWhere('name', 'Kasubbag TU Pimpinan, Staf Ahli dan Kepegawaian');
                })->first();
        } elseif ($opd && $opd->name === 'Penyuluh Perikanan') {
            $opd_pp = Opd::where('name', 'Dinas Perikanan Dan Pangan')->first();

            $kepala = User::where('opd_id', $opd_pp->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kepala Dinas')
                        ->orWhere('name', 'Kepala Puskesmas')
                        ->orWhere('name', 'Inspektur')
                        ->orWhere('name', 'Camat')
                        ->orWhere('name', 'Direktur')
                        ->orWhere('name', 'Kepala Satpol PP dan Damkar')
                        ->orWhere('name', 'Kepala Satuan')
                        ->orWhere('name', 'Kepala Badan');
                })->first();

            $kasubag = User::where('opd_id', $opd_pp->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kasubag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Tata Usaha')
                        ->orWhere('name', 'Kasubbag TU Pimpinan, Staf Ahli dan Kepegawaian');
                })->first();
        } else {

            $kepala = User::where('opd_id', $request->input('opd'))
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kepala Dinas')
                        ->orWhere('name', 'Kepala Puskesmas')
                        ->orWhere('name', 'Inspektur')
                        ->orWhere('name', 'Camat')
                        ->orWhere('name', 'Direktur')
                        ->orWhere('name', 'Kepala Satpol PP dan Damkar')
                        ->orWhere('name', 'Kepala Satuan')
                        ->orWhere('name', 'Kepala Badan');
                })->first();

            $kasubag = User::where('opd_id', $request->input('opd'))
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kasubag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Tata Usaha')
                        ->orWhere('name', 'Kasubbag TU Pimpinan, Staf Ahli dan Kepegawaian');
                })->first();
        }

        $sekda = User::where('opd_id', $request->input('opd'))->whereHas('jabatan', function ($query) {
            $query->where('name', 'Sekretaris Daerah');
        })->first();
        $asisten1 = User::where('opd_id', $request->input('opd'))->whereHas('jabatan', function ($query) {
            $query->where('name', 'ASISTEN PEMERINTAHAN');
        })->first();

        $asisten2 = User::where('opd_id', $request->input('opd'))->whereHas('jabatan', function ($query) {
            $query->where('name', 'ASISTEN PEREKONOMIAN DAN PEMBANGUNAN');
        })->first();

        $asisten3 = User::where('opd_id', $request->input('opd'))->whereHas('jabatan', function ($query) {
            $query->where('name', 'ASISTEN ADMINISTRASI UMUM');
        })->first();

        $koordinat = Koordinat::where('opd_id', $selectedOpdId)->first();

        $users = User::where('opd_id', $selectedOpdId)->orderByRaw('eselon_id IS NULL, eselon_id, pangkat_id IS NULL, pangkat_id, status = "PNS" DESC, status')
            ->get();

        $selectedBulan = $request->input('bulan');

        [$year, $month] = explode('-', $selectedBulan);

        // Cari OPD Sekretariat Daerah
        $opdSekretariatDaerah = Opd::where('name', 'Sekretariat Daerah')->first();

        if ($opdSekretariatDaerah && $opdSekretariatDaerah->id == $selectedOpdId) {
            // Ambil ID OPD dari OPD yang ingin digabungkan
            $opdToMergeNames = ['ASISTEN PEMERINTAHAN', 'ASISTEN PEREKONOMIAN DAN PEMBANGUNAN', 'ASISTEN ADMINISTRASI UMUM']; // Misalnya, nama OPD yang ingin Anda gabungkan
            $opdsToMerge = Opd::whereIn('name', $opdToMergeNames)->get();

            // Ambil daftar pengguna dari setiap OPD yang ingin Anda gabungkan
            foreach ($opdsToMerge as $opdToMerge) {
                $usersFromOtherOpd = User::where('opd_id', $opdToMerge->id)->get();
                $users = $users->merge($usersFromOtherOpd);
            }
        }

        return view('backend.report.report', [
            'kepala' => $kepala,
            'sekda' => $sekda,
            'kasubag' => $kasubag,
            'opds' => $opds,
            'selectedOpd' => $opd,
            'users' => $users,
            'koordinat' => $koordinat,
            'selectedBulan' => $selectedBulan,
            'month' => $month,
            'year' => $year,
            'asisten1' => $asisten1,
            'asisten2' => $asisten2,
            'asisten3' => $asisten3
        ])->render();
    }

    public function cetakLaporanByNama(Request $request)
    {

        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
        $selectedOpdId = $request->input('opd');

        $opd = Opd::find($selectedOpdId);
        $koordinat = Koordinat::where('opd_id', $selectedOpdId)->first();

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

                $attendanceData[$date] = $isNationalHoliday
                    ? ['jam_masuk' => 'Libur Nasional', 'jam_keluar' => 'Libur Nasional']
                    : ['jam_masuk' => optional($userAttendance)->jam_masuk ?? '-', 'jam_keluar' => optional($userAttendance)->jam_keluar ?? '-'];

                $dutyData[$date] = $hasDuty ? 'Dinas' : '-';
                $sickData[$date] = $hasSick ? 'Sakit' : '-';
                $permissionData[$date] = $hasPermission ? 'Izin' : '-';
                $leaveData[$date] = $leave ? 'Cuti' : '-';
            }
        }

        return view('backend.report.report_name', [
            'opd' => $opd,
            'koordinat' => $koordinat,
            'selectedUser' => $selectedUser,
            'dates' => $dates,
            'attendanceData' => $attendanceData,
            'dutyData' => $dutyData,
            'permissionData' => $permissionData,
            'sickData' => $sickData,
            'leaveData' => $leaveData,
        ]);
    }

    public function cetakLaporanByOpdNama(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
        $selectedOpdId = $request->input('opd');

        $opd = Opd::find($selectedOpdId);
        $koordinat = Koordinat::where('opd_id', $selectedOpdId)->first();

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

                $attendanceData[$date] = $isNationalHoliday
                    ? ['jam_masuk' => 'Libur Nasional', 'jam_keluar' => 'Libur Nasional']
                    : ['jam_masuk' => optional($userAttendance)->jam_masuk ?? '-', 'jam_keluar' => optional($userAttendance)->jam_keluar ?? '-'];

                $dutyData[$date] = $hasDuty ? 'Dinas' : '-';
                $sickData[$date] = $hasSick ? 'Sakit' : '-';
                $permissionData[$date] = $hasPermission ? 'Izin' : '-';
                $leaveData[$date] = $leave ? 'Cuti' : '-';
            }
        }

        return view('backend.report.report_opd_name', [
            'opd' => $opd,
            'koordinat' => $koordinat,
            'selectedUser' => $selectedUser,
            'dates' => $dates,
            'attendanceData' => $attendanceData,
            'dutyData' => $dutyData,
            'permissionData' => $permissionData,
            'sickData' => $sickData,
            'leaveData' => $leaveData,
        ]);
    }

    public function cetakLaporanByAdmin(Request $request)
    {

        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
        $selectedOpdId = $request->input('opd');

        $opd = Opd::find($selectedOpdId);
        $koordinat = Koordinat::where('opd_id', $selectedOpdId)->first();

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

                $attendanceData[$date] = $isNationalHoliday
                    ? ['jam_masuk' => 'Libur Nasional', 'jam_keluar' => 'Libur Nasional']
                    : ['jam_masuk' => optional($userAttendance)->jam_masuk ?? '-', 'jam_keluar' => optional($userAttendance)->jam_keluar ?? '-'];

                $dutyData[$date] = $hasDuty ? 'Dinas' : '-';
                $sickData[$date] = $hasSick ? 'Sakit' : '-';
                $permissionData[$date] = $hasPermission ? 'Izin' : '-';
                $leaveData[$date] = $leave ? 'Cuti' : '-';
            }
        }


        return view('backend.report.report_admin', [
            'opd' => $opd,
            'koordinat' => $koordinat,
            'selectedUser' => $selectedUser,
            'dates' => $dates,
            'attendanceData' => $attendanceData,
            'dutyData' => $dutyData,
            'permissionData' => $permissionData,
            'sickData' => $sickData,
            'leaveData' => $leaveData,
        ]);
    }

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

            // Return the data to the specified view
            return view('your-view-name', ['opdData' => $opdData]);
        } catch (\Exception $e) {
            // Return an error view
            return view('error-view-name', ['error' => 'An error occurred']);
        }
    }

    public function cetakLaporanMingguan(Request $request)
    {
        $opds = Opd::all();

        $selectedOpdId = $request->input('opd');
        $opd = Opd::find($selectedOpdId);
        $koordinat = Koordinat::where('opd_id', $selectedOpdId)->first();
        $users = User::whereHas('absensi', function ($query) use ($selectedOpdId) {
            $query->where('opd_id', $selectedOpdId);
        })->orderByRaw('eselon_id IS NULL, eselon_id, pangkat_id IS NULL, pangkat_id, status = "PNS" DESC, status')->get();


        $selectedWeek = Carbon::parse($request->input('week'));
        $weekStartDate = $selectedWeek->startOfWeek()->format('Y-m-d');
        $weekEndDate = $selectedWeek->endOfWeek()->format('Y-m-d');

        // Generate the list of dates from Monday to Friday
        $dates = [];
        $currentDate = Carbon::parse($weekStartDate);

        $isPuskesmas = $opd && stripos($opd->name, 'puskesmas') !== false;

        while ($currentDate->lte(Carbon::parse($weekEndDate))) {
            $dates[] = $currentDate->format('Y-m-d');

            $currentDate->addDay();
        }

        $nationalHolidays = LiburNasional::whereBetween('tanggal', [$weekStartDate, $weekEndDate])->get();

        // Fetch attendance, duty, permission, sick, and leave data for each user and date
        $attendanceData = [];
        $dutyData = [];
        $permissionData = [];
        $sickData = [];
        $leaveData = [];
        $tugasData = [];

        foreach ($users as $user) {
            $userAttendance = [];
            $userDuty = [];
            $userPermission = [];
            $userSick = [];
            $userLeave = [];
            $userTugas = [];

            foreach ($dates as $date) {
                // Fetch attendance data
                $attendance = Absensi::where('user_id', $user->id)
                    ->whereDate('tanggal', $date)
                    ->first();

                // Fetch duty data
                $hasDuty = Dinas::where('user_id', $user->id)
                    ->whereDate('tanggal', $date)
                    ->exists();

                // Fetch permission data
                $hasPermission = Izin::where('user_id', $user->id)
                    ->whereDate('tanggal', $date)
                    ->exists();

                // Fetch sick data
                $hasSick = Sakit::where('user_id', $user->id)
                    ->whereDate('tanggal', $date)
                    ->exists();

                // Fetch leave data
                $leave = Cuti::where('user_id', $user->id)
                    ->whereDate('tanggal_mulai', '<=', $date)
                    ->whereDate('tanggal_selesai', '>=', $date)
                    ->exists();

                $tugasBelajar = TugasBelajar::where('user_id', $user->id)
                    ->whereDate('tanggal_mulai', '<=', $date)
                    ->whereDate('tanggal_selesai', '>=', $date)
                    ->exists();

                // Check if the date is a national holiday
                $isNationalHoliday = $nationalHolidays->contains('tanggal', $date);

                // Populate attendance data
                if ($isNationalHoliday) {
                    $userAttendance[$date] = ['jam_masuk' => 'Libur Nasional', 'jam_keluar' => 'Libur Nasional'];
                } else {
                    $userAttendance[$date] = $attendance ? ['jam_masuk' => $attendance->jam_masuk, 'jam_keluar' => $attendance->jam_keluar] : ['jam_masuk' => '-', 'jam_keluar' => '-'];
                }

                // Populate duty, permission, sick, and leave data
                $userDuty[$date] = $hasDuty ? 'Dinas' : '-';
                $userPermission[$date] = $hasPermission ? 'Izin' : '-';
                $userSick[$date] = $hasSick ? 'Sakit' : '-';
                $userLeave[$date] = $leave ? 'Cuti' : '-';
                $userTugas[$date] = $tugasBelajar ? 'TB' : '-';
            }

            // Add data to respective arrays
            $attendanceData[$user->id] = $userAttendance;
            $dutyData[$user->id] = $userDuty;
            $permissionData[$user->id] = $userPermission;
            $sickData[$user->id] = $userSick;
            $leaveData[$user->id] = $userLeave;
            $tugasData[$user->id] = $userTugas;
        }

        // Jika opd yang dipilih adalah Sekretariat Daerah
        if ($opd && $opd->name === 'Sekretariat Daerah') {
            // Ambil ID OPD dari OPD yang ingin digabungkan
            $opdToMergeNames = ['ASISTEN PEMERINTAHAN', 'ASISTEN PEREKONOMIAN DAN PEMBANGUNAN', 'ASISTEN ADMINISTRASI UMUM']; // Misalnya, nama OPD yang ingin Anda gabungkan
            $opdsToMerge = Opd::whereIn('name', $opdToMergeNames)->get();

            // Ambil daftar pengguna dari setiap OPD yang ingin Anda gabungkan
            foreach ($opdsToMerge as $opdToMerge) {
                $usersFromOtherOpd = User::where('opd_id', $opdToMerge->id)->orderByRaw('eselon_id IS NULL, eselon_id, pangkat_id IS NULL, pangkat_id, status = "PNS" DESC, status')->get();
                $users = $users->merge($usersFromOtherOpd);

                // Populate attendance, duty, permission, sick, and leave data for users from merged OPDs
                foreach ($usersFromOtherOpd as $userFromOtherOpd) {
                    $userAttendance = [];
                    $userDuty = [];
                    $userPermission = [];
                    $userSick = [];
                    $userLeave = [];
                    $userTugas = [];

                    foreach ($dates as $date) {
                        // Fetch attendance data
                        $attendance = Absensi::where('user_id', $userFromOtherOpd->id)
                            ->whereDate('tanggal', $date)
                            ->first();

                        // Fetch duty data
                        $hasDuty = Dinas::where('user_id', $userFromOtherOpd->id)
                            ->whereDate('tanggal', $date)
                            ->exists();

                        // Fetch permission data
                        $hasPermission = Izin::where('user_id', $userFromOtherOpd->id)
                            ->whereDate('tanggal', $date)
                            ->exists();

                        // Fetch sick data
                        $hasSick = Sakit::where('user_id', $userFromOtherOpd->id)
                            ->whereDate('tanggal', $date)
                            ->exists();

                        // Fetch leave data
                        $leave = Cuti::where('user_id', $userFromOtherOpd->id)
                            ->whereDate('tanggal_mulai', '<=', $date)
                            ->whereDate('tanggal_selesai', '>=', $date)
                            ->exists();

                        $tugasBelajar = TugasBelajar::where('user_id', $user->id)
                            ->whereDate('tanggal_mulai', '<=', $date)
                            ->whereDate('tanggal_selesai', '>=', $date)
                            ->exists();

                        // Check if the date is a national holiday
                        $isNationalHoliday = $nationalHolidays->contains('tanggal', $date);

                        // Populate attendance data
                        if ($isNationalHoliday) {
                            $userAttendance[$date] = ['jam_masuk' => 'Libur Nasional', 'jam_keluar' => 'Libur Nasional'];
                        } else {
                            $userAttendance[$date] = $attendance ? ['jam_masuk' => $attendance->jam_masuk, 'jam_keluar' => $attendance->jam_keluar] : ['jam_masuk' => '-', 'jam_keluar' => '-'];
                        }

                        // Populate duty, permission, sick, and leave data
                        $userDuty[$date] = $hasDuty ? 'Dinas' : '-';
                        $userPermission[$date] = $hasPermission ? 'Izin' : '-';
                        $userSick[$date] = $hasSick ? 'Sakit' : '-';
                        $userLeave[$date] = $leave ? 'Cuti' : '-';
                        $userTugas[$date] = $tugasBelajar ? 'TB' : '-';
                    }

                    // Add data to respective arrays
                    $attendanceData[$userFromOtherOpd->id] = $userAttendance;
                    $dutyData[$userFromOtherOpd->id] = $userDuty;
                    $permissionData[$userFromOtherOpd->id] = $userPermission;
                    $sickData[$userFromOtherOpd->id] = $userSick;
                    $leaveData[$userFromOtherOpd->id] = $userLeave;
                    $tugasData[$user->id] = $userTugas;
                }
            }
        }

        setlocale(LC_TIME, 'id_ID');
        Carbon::setLocale('id');

        $startOfWeek = $selectedWeek->isoFormat('LL');
        $endOfWeek = $selectedWeek->endOfWeek()->isoFormat('LL');
        $weekNumber = $selectedWeek->isoFormat('W');

        if ($opd && $opd->name === 'Penjaga Pintu Air') {
            $opd_ppu = Opd::where('name', 'Dinas Pekerjaan Umum dan Penataan Ruang')->first();

            $kepala = User::where('opd_id', $opd_ppu->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kepala Dinas')
                        ->orWhere('name', 'Kepala Puskesmas')
                        ->orWhere('name', 'Inspektur')
                        ->orWhere('name', 'Camat')
                        ->orWhere('name', 'Direktur')
                        ->orWhere('name', 'Kepala Satpol PP dan Damkar')
                        ->orWhere('name', 'Kepala Satuan')
                        ->orWhere('name', 'Kepala Badan');
                })->first();

            $kasubag = User::where('opd_id', $opd_ppu->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kasubag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Tata Usaha')
                        ->orWhere('name', 'Kasubbag TU Pimpinan, Staf Ahli dan Kepegawaian');
                })->first();
        } elseif ($opd && $opd->name === 'Penyuluh Pertanian') {
            $opd_pt = Opd::where('name', 'Dinas Pertanian')->first();

            $kepala = User::where('opd_id', $opd_pt->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kepala Dinas')
                        ->orWhere('name', 'Kepala Puskesmas')
                        ->orWhere('name', 'Inspektur')
                        ->orWhere('name', 'Camat')
                        ->orWhere('name', 'Direktur')
                        ->orWhere('name', 'Kepala Satpol PP dan Damkar')
                        ->orWhere('name', 'Kepala Satuan')
                        ->orWhere('name', 'Kepala Badan');
                })->first();

            $kasubag = User::where('opd_id', $opd_pt->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kasubag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Tata Usaha')
                        ->orWhere('name', 'Kasubbag TU Pimpinan, Staf Ahli dan Kepegawaian');
                })->first();
        } elseif ($opd && $opd->name === 'Penyuluh Perikanan') {
            $opd_pp = Opd::where('name', 'Dinas Perikanan Dan Pangan')->first();

            $kepala = User::where('opd_id', $opd_pp->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kepala Dinas')
                        ->orWhere('name', 'Kepala Puskesmas')
                        ->orWhere('name', 'Inspektur')
                        ->orWhere('name', 'Camat')
                        ->orWhere('name', 'Direktur')
                        ->orWhere('name', 'Kepala Satpol PP dan Damkar')
                        ->orWhere('name', 'Kepala Satuan')
                        ->orWhere('name', 'Kepala Badan');
                })->first();

            $kasubag = User::where('opd_id', $opd_pp->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kasubag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Tata Usaha')
                        ->orWhere('name', 'Kasubbag TU Pimpinan, Staf Ahli dan Kepegawaian');
                })->first();
        } else {

            $kepala = User::where('opd_id', $request->input('opd'))
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kepala Dinas')
                        ->orWhere('name', 'Kepala Puskesmas')
                        ->orWhere('name', 'Inspektur')
                        ->orWhere('name', 'Camat')
                        ->orWhere('name', 'Direktur')
                        ->orWhere('name', 'Kepala Satpol PP dan Damkar')
                        ->orWhere('name', 'Kepala Satuan')
                        ->orWhere('name', 'Kepala Badan');
                })->first();

            $kasubag = User::where('opd_id', $request->input('opd'))
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kasubag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Tata Usaha')
                        ->orWhere('name', 'Kasubbag TU Pimpinan, Staf Ahli dan Kepegawaian');
                })->first();
        }

        $sekda = User::where('opd_id', $request->input('opd'))->whereHas('jabatan', function ($query) {
            $query->where('name', 'Sekretaris Daerah');
        })->first();

        $asisten1 = User::where('opd_id', $request->input('opd'))->whereHas('jabatan', function ($query) {
            $query->where('name', 'ASISTEN PEMERINTAHAN');
        })->first();

        $asisten2 = User::where('opd_id', $request->input('opd'))->whereHas('jabatan', function ($query) {
            $query->where('name', 'ASISTEN PEREKONOMIAN DAN PEMBANGUNAN');
        })->first();

        $asisten3 = User::where('opd_id', $request->input('opd'))->whereHas('jabatan', function ($query) {
            $query->where('name', 'ASISTEN ADMINISTRASI UMUM');
        })->first();

        return view('backend.report.report_mingguan', [
            'opds' => $opds,
            'selectedOpdId' => $selectedOpdId,
            'selectedOpd' => $opd,
            'koordinat' => $koordinat,
            'users' => $users,
            'dates' => $dates,
            'attendanceData' => $attendanceData,
            'dutyData' => $dutyData,
            'tbData' => $tugasData,
            'permissionData' => $permissionData,
            'sickData' => $sickData,
            'leaveData' => $leaveData,
            'weekNumber' => $weekNumber,
            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
            'kepala' => $kepala,
            'sekda' => $sekda,
            'kasubag' => $kasubag,
            'asisten1' => $asisten1,
            'asisten2' => $asisten2,
            'asisten3' => $asisten3
        ]);
    }


    public function cetakLaporanHarian(Request $request)
    {
        $opds = Opd::all();
        $selectedOpdId = $request->input('opd');
        $opd = Opd::find($selectedOpdId);
        $koordinat = Koordinat::where('opd_id', $selectedOpdId)->first();
        // $users = User::where('opd_id', $selectedOpdId)->orderByRaw('eselon_id IS NULL, eselon_id, pangkat_id IS NULL, pangkat_id, status = "PNS" DESC, status')->get();
        // $users = User::where('opd_id', $selectedOpdId)->get();

        // Ambil semua user yang terkait dengan opd_id dari model Absensi
        $users = User::whereHas('absensi', function ($query) use ($selectedOpdId) {
            $query->where('opd_id', $selectedOpdId);
        })->get();


        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $dates = [];
        $currentDate = Carbon::parse($startDate);
        $isPuskesmas = $opd && stripos($opd->name, 'puskesmas') !== false;


        while ($currentDate->lte(Carbon::parse($endDate))) {
            // Only include dates from Monday to Friday
            if (
                $currentDate->dayOfWeek >= Carbon::MONDAY &&
                ($currentDate->dayOfWeek <= Carbon::FRIDAY || ($isPuskesmas && $currentDate->dayOfWeek == Carbon::SATURDAY))
            ) {
                $dates[] = $currentDate->format('Y-m-d');
            }
            $currentDate->addDay();
        }

        $nationalHolidays = LiburNasional::whereBetween('tanggal', [$startDate, $endDate])->get();

        // Fetch attendance data for each user and date
        // $nationalHolidays = LiburNasional::whereBetween('tanggal', [$weekStartDate, $weekEndDate])->get();

        // Fetch attendance, duty, permission, sick, and leave data for each user and date
        $attendanceData = [];
        $dutyData = [];
        $permissionData = [];
        $sickData = [];
        $leaveData = [];
        $tugasData = [];

        foreach ($users as $user) {
            $userAttendance = [];
            $userDuty = [];
            $userPermission = [];
            $userSick = [];
            $userLeave = [];
            $userTugas = [];

            foreach ($dates as $date) {
                // Fetch attendance data
                $attendance = Absensi::where('user_id', $user->id)
                    ->whereDate('tanggal', $date)
                    ->first();

                // Fetch duty data
                $hasDuty = Dinas::where('user_id', $user->id)
                    ->whereDate('tanggal', $date)
                    ->exists();

                // Fetch permission data
                $hasPermission = Izin::where('user_id', $user->id)
                    ->whereDate('tanggal', $date)
                    ->exists();

                // Fetch sick data
                $hasSick = Sakit::where('user_id', $user->id)
                    ->whereDate('tanggal', $date)
                    ->exists();

                // Fetch leave data
                $leave = Cuti::where('user_id', $user->id)
                    ->whereDate('tanggal_mulai', '<=', $date)
                    ->whereDate('tanggal_selesai', '>=', $date)
                    ->exists();

                $tugasBelajar = TugasBelajar::where('user_id', $user->id)
                    ->whereDate('tanggal_mulai', '<=', $date)
                    ->whereDate('tanggal_selesai', '>=', $date)
                    ->exists();

                // Check if the date is a national holiday
                $isNationalHoliday = $nationalHolidays->contains('tanggal', $date);

                // Populate attendance data
                if ($isNationalHoliday) {
                    $userAttendance[$date] = ['jam_masuk' => 'Libur Nasional', 'jam_keluar' => 'Libur Nasional'];
                } else {
                    $userAttendance[$date] = $attendance ? ['jam_masuk' => $attendance->jam_masuk, 'jam_keluar' => $attendance->jam_keluar] : ['jam_masuk' => '-', 'jam_keluar' => '-'];
                }

                // Populate duty, permission, sick, and leave data
                $userDuty[$date] = $hasDuty ? 'Dinas' : '-';
                $userPermission[$date] = $hasPermission ? 'Izin' : '-';
                $userSick[$date] = $hasSick ? 'Sakit' : '-';
                $userLeave[$date] = $leave ? 'Cuti' : '-';
                $userTugas[$date] = $tugasBelajar ? 'TB' : '-';
            }

            // Add data to respective arrays
            $attendanceData[$user->id] = $userAttendance;
            $dutyData[$user->id] = $userDuty;
            $permissionData[$user->id] = $userPermission;
            $sickData[$user->id] = $userSick;
            $leaveData[$user->id] = $userLeave;
            $tugasData[$user->id] = $userTugas;
        }

        // Jika opd yang dipilih adalah Sekretariat Daerah
        if ($opd && $opd->name === 'Sekretariat Daerah') {
            // Ambil ID OPD dari OPD yang ingin digabungkan
            $opdToMergeNames = ['ASISTEN PEMERINTAHAN', 'ASISTEN PEREKONOMIAN DAN PEMBANGUNAN', 'ASISTEN ADMINISTRASI UMUM']; // Misalnya, nama OPD yang ingin Anda gabungkan
            $opdsToMerge = Opd::whereIn('name', $opdToMergeNames)->get();

            // Ambil daftar pengguna dari setiap OPD yang ingin Anda gabungkan
            foreach ($opdsToMerge as $opdToMerge) {
                $usersFromOtherOpd = User::where('opd_id', $opdToMerge->id)->orderByRaw('eselon_id IS NULL, eselon_id, pangkat_id IS NULL, pangkat_id, status = "PNS" DESC, status')->get();
                $users = $users->merge($usersFromOtherOpd);

                // Populate attendance, duty, permission, sick, and leave data for users from merged OPDs
                foreach ($usersFromOtherOpd as $userFromOtherOpd) {
                    $userAttendance = [];
                    $userDuty = [];
                    $userPermission = [];
                    $userSick = [];
                    $userLeave = [];
                    $userTugas = [];

                    foreach ($dates as $date) {
                        // Fetch attendance data
                        $attendance = Absensi::where('user_id', $userFromOtherOpd->id)
                            ->whereDate('tanggal', $date)
                            ->first();

                        // Fetch duty data
                        $hasDuty = Dinas::where('user_id', $userFromOtherOpd->id)
                            ->whereDate('tanggal', $date)
                            ->exists();

                        // Fetch permission data
                        $hasPermission = Izin::where('user_id', $userFromOtherOpd->id)
                            ->whereDate('tanggal', $date)
                            ->exists();

                        // Fetch sick data
                        $hasSick = Sakit::where('user_id', $userFromOtherOpd->id)
                            ->whereDate('tanggal', $date)
                            ->exists();

                        // Fetch leave data
                        $leave = Cuti::where('user_id', $userFromOtherOpd->id)
                            ->whereDate('tanggal_mulai', '<=', $date)
                            ->whereDate('tanggal_selesai', '>=', $date)
                            ->exists();

                        $tugasBelajar = TugasBelajar::where('user_id', $user->id)
                            ->whereDate('tanggal_mulai', '<=', $date)
                            ->whereDate('tanggal_selesai', '>=', $date)
                            ->exists();

                        // Check if the date is a national holiday
                        $isNationalHoliday = $nationalHolidays->contains('tanggal', $date);

                        // Populate attendance data
                        if ($isNationalHoliday) {
                            $userAttendance[$date] = ['jam_masuk' => 'Libur Nasional', 'jam_keluar' => 'Libur Nasional'];
                        } else {
                            $userAttendance[$date] = $attendance ? ['jam_masuk' => $attendance->jam_masuk, 'jam_keluar' => $attendance->jam_keluar] : ['jam_masuk' => '-', 'jam_keluar' => '-'];
                        }

                        // Populate duty, permission, sick, and leave data
                        $userDuty[$date] = $hasDuty ? 'Dinas' : '-';
                        $userPermission[$date] = $hasPermission ? 'Izin' : '-';
                        $userSick[$date] = $hasSick ? 'Sakit' : '-';
                        $userLeave[$date] = $leave ? 'Cuti' : '-';
                        $userTugas[$date] = $tugasBelajar ? 'TB' : '-';
                    }

                    // Add data to respective arrays
                    $attendanceData[$userFromOtherOpd->id] = $userAttendance;
                    $dutyData[$userFromOtherOpd->id] = $userDuty;
                    $permissionData[$userFromOtherOpd->id] = $userPermission;
                    $sickData[$userFromOtherOpd->id] = $userSick;
                    $leaveData[$userFromOtherOpd->id] = $userLeave;
                    $tugasData[$user->id] = $userTugas;
                }
            }
        }

        if ($opd && $opd->name === 'Penjaga Pintu Air') {
            $opd_ppu = Opd::where('name', 'Dinas Pekerjaan Umum dan Penataan Ruang')->first();

            $kepala = User::where('opd_id', $opd_ppu->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kepala Dinas')
                        ->orWhere('name', 'Kepala Puskesmas')
                        ->orWhere('name', 'Inspektur')
                        ->orWhere('name', 'Camat')
                        ->orWhere('name', 'Direktur')
                        ->orWhere('name', 'Kepala Satpol PP dan Damkar')
                        ->orWhere('name', 'Kepala Satuan')
                        ->orWhere('name', 'Kepala Badan');
                })->first();

            $kasubag = User::where('opd_id', $opd_ppu->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kasubag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Tata Usaha')
                        ->orWhere('name', 'Kasubbag TU Pimpinan, Staf Ahli dan Kepegawaian');
                })->first();
        } elseif ($opd && $opd->name === 'Penyuluh Pertanian') {
            $opd_pt = Opd::where('name', 'Dinas Pertanian')->first();

            $kepala = User::where('opd_id', $opd_pt->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kepala Dinas')
                        ->orWhere('name', 'Kepala Puskesmas')
                        ->orWhere('name', 'Inspektur')
                        ->orWhere('name', 'Camat')
                        ->orWhere('name', 'Direktur')
                        ->orWhere('name', 'Kepala Satpol PP dan Damkar')
                        ->orWhere('name', 'Kepala Satuan')
                        ->orWhere('name', 'Kepala Badan');
                })->first();

            $kasubag = User::where('opd_id', $opd_pt->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kasubag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Tata Usaha')
                        ->orWhere('name', 'Kasubbag TU Pimpinan, Staf Ahli dan Kepegawaian');
                })->first();
        } elseif ($opd && $opd->name === 'Penyuluh Perikanan') {
            $opd_pp = Opd::where('name', 'Dinas Perikanan Dan Pangan')->first();

            $kepala = User::where('opd_id', $opd_pp->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kepala Dinas')
                        ->orWhere('name', 'Kepala Puskesmas')
                        ->orWhere('name', 'Inspektur')
                        ->orWhere('name', 'Camat')
                        ->orWhere('name', 'Direktur')
                        ->orWhere('name', 'Kepala Satpol PP dan Damkar')
                        ->orWhere('name', 'Kepala Satuan')
                        ->orWhere('name', 'Kepala Badan');
                })->first();

            $kasubag = User::where('opd_id', $opd_pp->id)
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kasubag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Tata Usaha')
                        ->orWhere('name', 'Kasubbag TU Pimpinan, Staf Ahli dan Kepegawaian');
                })->first();
        } else {

            $kepala = User::where('opd_id', $request->input('opd'))
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kepala Dinas')
                        ->orWhere('name', 'Kepala Puskesmas')
                        ->orWhere('name', 'Inspektur')
                        ->orWhere('name', 'Camat')
                        ->orWhere('name', 'Direktur')
                        ->orWhere('name', 'Kepala Satpol PP dan Damkar')
                        ->orWhere('name', 'Kepala Satuan')
                        ->orWhere('name', 'Kepala Badan');
                })->first();

            $kasubag = User::where('opd_id', $request->input('opd'))
                ->whereHas('jabatan', function ($query) {
                    $query->where('name', 'Kasubag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Umum dan Kepegawaian')
                        ->orWhere('name', 'Kasubbag Tata Usaha')
                        ->orWhere('name', 'Kasubbag TU Pimpinan, Staf Ahli dan Kepegawaian');
                })->first();
        }

        $sekda = User::where('opd_id', $request->input('opd'))->whereHas('jabatan', function ($query) {
            $query->where('name', 'Sekretaris Daerah');
        })->first();


        $asisten1 = User::where('opd_id', $request->input('opd'))->whereHas('jabatan', function ($query) {
            $query->where('name', 'ASISTEN PEMERINTAHAN');
        })->first();

        $asisten2 = User::where('opd_id', $request->input('opd'))->whereHas('jabatan', function ($query) {
            $query->where('name', 'ASISTEN PEREKONOMIAN DAN PEMBANGUNAN');
        })->first();

        $asisten3 = User::where('opd_id', $request->input('opd'))->whereHas('jabatan', function ($query) {
            $query->where('name', 'ASISTEN ADMINISTRASI UMUM');
        })->first();

        return view('backend.report.report_harian', [
            'opds' => $opds,
            'selectedOpdId' => $selectedOpdId,
            'selectedOpd' => $opd,
            'koordinat' => $koordinat,
            'users' => $users,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'dates' => $dates,
            'attendanceData' => $attendanceData,
            'dutyData' => $dutyData,
            'permissionData' => $permissionData,
            'sickData' => $sickData,
            'leaveData' => $leaveData,
            'kepala' => $kepala,
            'sekda' => $sekda,
            'tbData' => $tugasData,
            'kasubag' => $kasubag,
            'asisten1' => $asisten1,
            'asisten2' => $asisten2,
            'asisten3' => $asisten3
        ]);
    }
}
