@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-body">
                    <form id="filterForm" action="{{ route('report.hari') }}" method="get">
                        @csrf

                        <div class="form-group row ml-3">
                            <label for="opd" class="col-sm-2 col-form-label">Pilih OPD</label>
                            <div class="col-sm-10">
                                @if (Auth::user()->role == 3 || Auth::user()->role == 4)
                                    <select name="opd" id="opd" class="form-control select2" required>
                                        <option value="{{ request('opd') }}" disabled selected>Pilih OPD</option>

                                        @php
                                            $opds = App\Models\Opd::all();
                                        @endphp
                                        @foreach ($opds as $opd)
                                            <option value="{{ $opd->id }}">{{ $opd->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select name="opd" id="opd" class="form-control" disabled>
                                        <option value="{{ Auth::user()->opd->id }}" selected>{{ Auth::user()->opd->name }}
                                        </option>
                                    </select>
                                    <input type="hidden" name="opd" value="{{ Auth::user()->opd->id }}">
                                @endif
                            </div>
                        </div>
                        <div class="form-group row ml-3">
                            <label for="start_date" class="col-sm-2 col-form-label">Tanggal Awal</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="date" name="start_date" id="start_date" required>
                            </div>
                        </div>
                        <div class="form-group row ml-3">
                            <label for="end_date" class="col-sm-2 col-form-label">Tanggal Akhir</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="date" name="end_date" id="end_date" required>
                            </div>
                        </div>

                        <div class="form-group row ml-3">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-success"> <i class="fas fa-edit"></i>
                                    Tampilkan</button>
                                @if (isset($selectedOpd))
                                    <button type="button" id="btnPrint" class="btn btn-success ml-2">
                                        <i class="fas fa-print"></i> Cetak
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
    @if (isset($selectedOpd))
        <div id="printContent">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="container">
                                <div class="rangkasurat">

                                    <table width="100%" class="report-absen">
                                        <tr>
                                            <td>
                                                <img src="{{ asset('images/pasaman.png') }}" width="60"
                                                    class="overlay-image">
                                            </td>
                                            <td class="tengah">
                                                <h4><strong>PEMERINTAH KABUPATEN PASAMAN</strong></h4>
                                                @if (strcasecmp($selectedOpd->name, 'ASISTEN PEMERINTAHAN') == 0 ||
                                                        strcasecmp($selectedOpd->name, 'ASISTEN PEREKONOMIAN DAN PEMBANGUNAN') == 0 ||
                                                        strcasecmp($selectedOpd->name, 'ASISTEN ADMINISTRASI UMUM') == 0)
                                                    <h3
                                                        style="font-weight: bold; padding-left:50px; padding-right:50px; text-transform: uppercase">
                                                        SEKRETARIAT DAERAH</h3>
                                                @else
                                                    <h3
                                                        style="font-weight: bold; padding-left:50px; padding-right:50px; text-transform: uppercase">
                                                        {{ $selectedOpd->name }}</h3>
                                                @endif
                                                @if (isset($koordinat))
                                                    <p>{{ $koordinat->alamat }}</p>
                                                @else
                                                    <b>Alamat Tidak Tersedia</b>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <hr style="border-top: 4px double #000">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="tengah">
                                                <h4>REKAPITULASI KEHADIRAN PEGAWAI</h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="kiri">
                                                <h6>Satuan Kerja : @if (strcasecmp($selectedOpd->name, 'ASISTEN PEMERINTAHAN') == 0 ||
                                                        strcasecmp($selectedOpd->name, 'ASISTEN PEREKONOMIAN PEMBANGUNAN DAN KESEJAHTERAAN RAKYAT') == 0 ||
                                                        strcasecmp($selectedOpd->name, 'ASISTEN ADMINISTRASI UMUM') == 0)
                                                        SEKRETARIAT DAERAH
                                                    @else
                                                        {{ $selectedOpd->name }}
                                                    @endif
                                                </h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="kiri">
                                                <h6>Tanggal
                                                    {{ \Carbon\Carbon::parse($startDate)->locale('id_ID')->translatedFormat('d F ') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($endDate)->locale('id_ID')->translatedFormat('d F') }}
                                                </h6>
                                            </td>

                                        </tr>
                                        <tr>
                                    </table>
                                    <table border="1" width="100%">
                                        <thead>
                                            <tr>
                                                <th rowspan="4" class="rata-tengah">No</th>
                                                <th rowspan="4" class="rata-tengah">Nama</th>
                                                <th colspan="{{ count($dates) * 2 + 1 * count($dates) }}"
                                                    class="rata-tengah">Hari /
                                                    Tanggal
                                                </th>
                                                <th rowspan="4" class="rata-tengah">Total Jam</th>
                                                <th rowspan="4" class="rata-tengah">Rata-Rata</th>
                                            </tr>


                                            <tr>
                                                @foreach ($dates as $date)
                                                    <th colspan="3" class="rata-tengah">
                                                        {{ \Carbon\Carbon::parse($date)->locale('id_ID')->translatedFormat('l') }}
                                                    </th>
                                                @endforeach

                                            </tr>
                                            <tr>
                                                @foreach ($dates as $date)
                                                    <th colspan="3" style="font-size: 12px;" class="rata-tengah">
                                                        {{ \Carbon\Carbon::parse($date)->locale('id_ID')->translatedFormat('d F Y') }}
                                                    </th>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                @foreach ($dates as $date)
                                                    <th style="font-size: 12px;" class="rata-tengah">Datang</th>
                                                    <th style="font-size: 12px;" class="rata-tengah">Pulang</th>
                                                    <th style="font-size: 12px;" class="rata-tengah">Jam Kerja</th>
                                                @endforeach
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                                $totalDinas = 0;
                                                $totalIzin = 0;
                                                $totalSakit = 0;
                                                $totalCuti = 0;
                                                $totalTK = 0;
                                                $totalTb = 0;

                                            @endphp

                                            @foreach ($users as $user)
                                                @if ($user->role == 2)
                                                    @php
                                                        $userTotalDurasiDetik = 0;
                                                        $userDaysCount = 0;
                                                    @endphp
                                                    <tr
                                                        style="background-color: {{ $user->status === 'PNS' || $user->status === 'PPPK' ? '#f4f4f9' : '#FFFFFF' }};">
                                                        <td class="rata-tengah" style="font-size: 14px;">
                                                            {{ $i++ }}</td>
                                                        <td class="name-nowrap">{{ $user->name }}</td>

                                                        @foreach ($attendanceData[$user->id] as $key => $attendance)
                                                            @if ($attendance['jam_masuk'] == 'Libur Nasional')
                                                                <td colspan="3" class="rata-tengah">Libur Nasional</td>
                                                            @else
                                                                <?php
                                                                $hasDuty = isset($dutyData[$user->id][$key]) && $dutyData[$user->id][$key] == 'Dinas';
                                                                $hasPermission = isset($permissionData[$user->id][$key]) && $permissionData[$user->id][$key] == 'Izin';
                                                                $hasSick = isset($sickData[$user->id][$key]) && $sickData[$user->id][$key] == 'Sakit';
                                                                $hasLeave = isset($leaveData[$user->id][$key]) && $leaveData[$user->id][$key] == 'Cuti';
                                                                $hasAttendance = $attendance['jam_masuk'] !== '-' && $attendance['jam_keluar'] !== '-';
                                                                $hasTugas = isset($tbData[$user->id][$key]) && $tbData[$user->id][$key] == 'TB';
                                                                $isManual = $user->is_manual == 1;
                                                                $isEselonII = $user->eselon && ($user->eselon->name === 'Ajudan' || $user->eselon->name === 'Eselon II A' || $user->eselon->name === 'Eselon II B');
                                                                $jam_masuk = $attendance['jam_masuk'];
                                                                $jam_keluar = $attendance['jam_keluar'] ?? '-';
                                                                $durasi_kerja = '-';

                                                                if ($hasDuty) {
                                                                    // Jika dinas, tambahkan 8 jam 30 menit (30600 detik)
                                                                    $durasi_detik = 30600;
                                                                    $userTotalDurasiDetik += $durasi_detik;
                                                                    $durasi_kerja = '8 Jam 30 Menit';
                                                                    $userDaysCount++;
                                                                } elseif ($hasLeave) {
                                                                    // Jika cuti, tambahkan 5 jam (18000 detik)
                                                                    $durasi_detik = 18000;
                                                                    $userTotalDurasiDetik += $durasi_detik;
                                                                    $durasi_kerja = '5 Jam';
                                                                    $userDaysCount++;
                                                                } elseif ($jam_masuk !== '-' && $jam_keluar !== '-') {
                                                                    $durasi_detik = strtotime($jam_keluar) - strtotime($jam_masuk) - 3600; // Kurangkan 1 jam
                                                                    if ($durasi_detik < 0) {
                                                                        $durasi_detik = 0; // Pastikan tidak negatif
                                                                    }
                                                                    $userTotalDurasiDetik += $durasi_detik; // Tambahkan ke total durasi pengguna
                                                                    $userDaysCount++; // Tambahkan hitungan hari
                                                                    $jam = floor($durasi_detik / 3600);
                                                                    $menit = floor(($durasi_detik % 3600) / 60);
                                                                    $durasi_kerja = $jam . ' Jam ' . $menit . ' Menit';
                                                                }
                                                                ?>

                                                                @if ($hasAttendance)
                                                                    <td class="rata-tengah"
                                                                        style="font-size: 12px; font-weight: bold; font-style:italic;">
                                                                        {{ $attendance['jam_masuk'] }}</td>
                                                                    <td class="rata-tengah"
                                                                        style="font-size: 12px; font-weight: bold; font-style:italic">
                                                                        {{ $attendance['jam_keluar'] ?? '-' }}</td>
                                                                    <td class="rata-tengah"
                                                                        style="font-size: 12px; font-weight: bold; font-style:italic">
                                                                        {{ $durasi_kerja }}</td>
                                                                @else
                                                                    @if (!$hasDuty && !$hasPermission && !$hasSick && !$hasLeave && !$hasTugas)
                                                                        @if ($isEselonII)
                                                                            <td colspan="3" class="rata-tengah">★</td>
                                                                        @elseif ($isManual)
                                                                            <td colspan="3" class="rata-tengah">M</td>
                                                                        @else
                                                                            <td colspan="3" class="rata-tengah">TK</td>
                                                                            @php
                                                                                $totalTK++;
                                                                            @endphp
                                                                        @endif
                                                                    @else
                                                                        <td @if ($hasDuty || $hasPermission || $hasSick || $hasLeave || $hasTugas) colspan="3" @endif
                                                                            class="rata-tengah">
                                                                            @if ($hasDuty)
                                                                                Dinas
                                                                                @php
                                                                                    $totalDinas++;
                                                                                @endphp
                                                                            @elseif ($hasPermission)
                                                                                Izin
                                                                                @php
                                                                                    $totalIzin++;
                                                                                @endphp
                                                                            @elseif ($hasSick)
                                                                                Sakit
                                                                                @php
                                                                                    $totalSakit++;
                                                                                @endphp
                                                                            @elseif ($hasLeave)
                                                                                Cuti
                                                                                @php
                                                                                    $totalCuti++;
                                                                                @endphp
                                                                            @elseif ($hasTugas)
                                                                                TB
                                                                                @php
                                                                                    $totalTb++;
                                                                                @endphp
                                                                            @else
                                                                                {{ $attendance['jam_masuk'] }}
                                                                            @endif
                                                                        </td>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endforeach

                                                        <?php
                                                        // Menghitung total jam dan menit dari total durasi dalam detik
                                                        $userTotalJam = floor($userTotalDurasiDetik / 3600);
                                                        $userTotalMenit = floor(($userTotalDurasiDetik % 3600) / 60);
                                                        // Menghitung rata-rata jam kerja per hari
                                                        $userAverageJamPerDay = count($dates) > 0 ? floor($userTotalDurasiDetik / count($dates) / 3600) : 0;
                                                        $userAverageMenitPerDay = count($dates) > 0 ? floor((($userTotalDurasiDetik / count($dates)) % 3600) / 60) : 0;
                                                        ?>

                                                        @php
                                                            $starTd = '<td class="rata-tengah">★</td>';
                                                            $timeTd =
                                                                '<td class="name-nowrap" style="font-size: 12px; font-weight: bold; font-style:italic;">';
                                                        @endphp

                                                        {!! $isEselonII ? $starTd : $timeTd . "{$userTotalJam} Jam {$userTotalMenit} Menit</td>" !!}

                                                        {!! $isEselonII ? $starTd : $timeTd . "{$userAverageJamPerDay} Jam {$userAverageMenitPerDay} Menit</td>" !!}
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="mt-4">
                                        <table border="1" cellspacing="1" cellpadding="2">
                                            <thead>
                                                <th class="rata-tengah">NO</th>
                                                <th class="rata-tengah">KETERANGAN</th>
                                                <th class="rata-tengah">TOTAL</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="rata-tengah">1</td>
                                                    <td class="kiri">Dinas</td>
                                                    <td class="rata-tengah">{{ $totalDinas }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="rata-tengah">2</td>
                                                    <td class="kiri">Izin</td>
                                                    <td class="rata-tengah">{{ $totalIzin }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="rata-tengah">3</td>
                                                    <td class="kiri">Cuti</td>
                                                    <td class="rata-tengah">{{ $totalCuti }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="rata-tengah">4</td>
                                                    <td class="kiri">Sakit</td>
                                                    <td class="rata-tengah">{{ $totalSakit }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="rata-tengah">5</td>
                                                    <td class="kiri">Tugas Belajar</td>
                                                    <td class="rata-tengah">{{ $totalTb }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="rata-tengah">6</td>
                                                    <td class="kiri">Tanpa Keterangan</td>
                                                    <td class="rata-tengah">{{ $totalTK }}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <table width="100%" align="center" border="0" class="mt-4">
                                        <tr>
                                            <td style="text-align: center; padding-right: 15%;">DIKETAHUI OLEH</td>
                                            <td style="text-align: center; padding-left: 20%;">
                                                {{ $koordinat->kecamatan }}, &emsp;&emsp;
                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $startDate)->locale('id', 'ID')->translatedFormat(' F Y') }}
                                            </td>


                                        </tr>
                                        <tr>
                                            <td style="text-align: center; padding-right: 15%; ">
                                                @if ($kepala)
                                                    {{ strtoupper($kepala->jabatan->name) }}
                                                    <br>
                                                @elseif ($sekda)
                                                    SEKRETARIS DAERAH<br>
                                                @elseif ($asisten1)
                                                    ASISTEN PEMERINTAHAN<br>
                                                @elseif ($asisten2)
                                                    ASISTEN PEREKONOMIAN DAN PEMBANGUNAN
                                                @elseif ($asisten3)
                                                    ASISTEN ADMINISTRASI UMUM<br>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td style="text-align: center; padding-left: 20%;">
                                                {{ strtoupper($kasubag->jabatan->name) }}

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center; padding-right: 15%;">
                                                <strong><u>
                                                        {{ $kepala
                                                            ? $kepala->name ?? '-'
                                                            : ($asisten1
                                                                ? $asisten1->name ?? '-'
                                                                : ($asisten2
                                                                    ? $asisten2->name ?? '-'
                                                                    : ($asisten3
                                                                        ? $asisten3->name ?? '-'
                                                                        : ($sekda
                                                                            ? $sekda->name ?? '-'
                                                                            : '-')))) }}
                                                    </u></strong><br>
                                                <strong>NIP.
                                                    {{ $kepala
                                                        ? $kepala->nip ?? '-'
                                                        : ($sekda
                                                            ? $sekda->nip ?? '-'
                                                            : ($asisten1
                                                                ? $asisten1->nip ?? '-'
                                                                : ($asisten2
                                                                    ? $asisten2->nip ?? '-'
                                                                    : ($asisten3
                                                                        ? $asisten3->nip ?? '-'
                                                                        : '-')))) }}
                                                </strong>
                                            </td>


                                            <td style="text-align: center; padding-left: 20%;">
                                                <strong><u>
                                                        {{ $kasubag->name ?? '-' }}

                                                    </u></strong><br>
                                                <strong> NIP.{{ $kasubag->nip ?? '-' }}
                                                </strong>
                                            </td>
                                        </tr>

                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('btnPrint').addEventListener('click', function() {
                var printContent = document.getElementById('printContent');
                var originalContents = document.body.innerHTML;

                // Setel konten HTML body menjadi konten di dalam div #printContent
                document.body.innerHTML = printContent.innerHTML;

                // Memicu fungsi cetak
                window.print();

                // Mengembalikan konten HTML asli
                document.body.innerHTML = originalContents;
            });
        </script>

    @endif
    <script>
        // Menambahkan event listener untuk memvalidasi tanggal
        document.getElementById('start_date').addEventListener('change', function() {
            var startDate = new Date(this.value);
            var endDateField = document.getElementById('end_date');
            var endDate = new Date(endDateField.value);

            // Mengatur tanggal minimal di end_date
            var maxEndDate = new Date(startDate);
            maxEndDate.setDate(startDate.getDate() + 5); // Maksimal 5 hari setelah tanggal awal

            if (endDate > maxEndDate) {
                endDateField.value = ''; // Mengosongkan nilai jika tidak valid
                alert('Jarak antara tanggal awal dan akhir maksimal 5 hari.');
            }
        });

        document.getElementById('end_date').addEventListener('change', function() {
            var startDateField = document.getElementById('start_date');
            var startDate = new Date(startDateField.value);
            var endDate = new Date(this.value);

            // Memvalidasi tanggal akhir
            var maxEndDate = new Date(startDate);
            maxEndDate.setDate(startDate.getDate() + 5); // Maksimal 5 hari setelah tanggal awal

            if (endDate > maxEndDate) {
                alert('Jarak antara tanggal awal dan akhir maksimal 5 hari.');
                this.value = ''; // Mengosongkan nilai jika tidak valid
            }
        });
    </script>
@endsection
