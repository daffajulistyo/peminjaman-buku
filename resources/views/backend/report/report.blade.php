@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-body">
                    <form id="filterForm" action="{{ route('filter') }}" method="get">
                        @csrf

                        <div class="form-group row ml-3">
                            <label for="opd" class="col-sm-2 col-form-label">Pilih OPD</label>
                            <div class="col-sm-10">
                                @if (Auth::user()->role == 3 || Auth::user()->role == 4)
                                    <select name="opd" id="opd" class="form-control select2">
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


                        <!-- Bagian Bulan -->
                        <div class="form-group row ml-3">
                            <label for="bulan" class="col-sm-2 col-form-label">Pilih Bulan</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="month" name="bulan" value="{{ request('bulan') }}"
                                    required>
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
                                                        strcasecmp($selectedOpd->name, 'ASISTEN PEREKONOMIAN PEMBANGUNAN DAN KESEJAHTERAAN RAKYAT') == 0 ||
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
                                                <h4>REKAPITULASI DAFTAR HADIR BULANAN</h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="kiri">
                                                <h6>Satuan Kerja :
                                                    @if (strcasecmp($selectedOpd->name, 'ASISTEN PEMERINTAHAN') == 0 ||
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
                                                @php
                                                    $carbonDate = \Carbon\Carbon::parse(request('bulan'));
                                                @endphp

                                                <h6>
                                                    Bulan :
                                                    @if (request()->has('bulan'))
                                                        {{ $carbonDate->locale('id_ID')->translatedFormat('F Y') }}
                                                    @else
                                                        {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                                                    @endif
                                                </h6>

                                            </td>

                                        </tr>
                                    </table>
                                    <table border="1" width="100%">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="rata-tengah">No</th>
                                                <th rowspan="2" class="rata-tengah">Nama</th>
                                                <th rowspan="2" class="rata-tengah">NIP / NIK</th>
                                                <th rowspan="2" class="rata-tengah">Gol</th>
                                                <th rowspan="2" class="rata-tengah">Jabatan</th>
                                                <th colspan="7" class="rata-tengah">Keterangan</th>
                                            </tr>
                                            <tr>
                                                <th class="rata-tengah">H</th>
                                                <th class="rata-tengah">D</th>
                                                <th class="rata-tengah">I</th>
                                                <th class="rata-tengah">C</th>
                                                <th class="rata-tengah">S</th>
                                                <th class="rata-tengah">TK</th>
                                                <th class="rata-tengah">JML HARI<br>KERJA</th>
                                            </tr>


                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($users as $user)
                                                @if ($user->role == 2)
                                                    @php

                                                        $filterByMonthYear = function ($collection, $dateField) use (
                                                            $month,
                                                            $year,
                                                        ) {
                                                            return $collection->filter(function ($entry) use (
                                                                $dateField,
                                                                $month,
                                                                $year,
                                                            ) {
                                                                $tanggal = \Carbon\Carbon::parse($entry->{$dateField});
                                                                return $tanggal->month === (int) $month &&
                                                                    $tanggal->year === (int) $year;
                                                            });
                                                        };

                                                        $absensi = $filterByMonthYear($user->absensi, 'tanggal');
                                                        $dinas = $filterByMonthYear($user->dinas, 'tanggal');
                                                        $cuti = $filterByMonthYear($user->cuti, 'tanggal_mulai');
                                                        $sakit = $filterByMonthYear($user->sakit, 'tanggal');
                                                        $izin = $filterByMonthYear($user->izin, 'tanggal');
                                                        $jumlahHariHadir = 0;

                                                        $liburNasionals = App\Models\LiburNasional::pluck(
                                                            'tanggal',
                                                        )->toArray();

                                                        $daftarHariLiburNasional = $liburNasionals;

                                                        foreach ($absensi as $entry) {
                                                            if ($entry->jam_masuk || $entry->jam_keluar) {
                                                                $tanggal = $entry->tanggal;

                                                                $hari = \Carbon\Carbon::createFromFormat(
                                                                    'Y-m-d',
                                                                    $tanggal,
                                                                )->format('l'); // Menentukan hari dari tanggal

                                                                // Memeriksa apakah hari adalah Sabtu atau Minggu
                                                                if ($hari == 'Saturday' || $hari == 'Sunday') {
                                                                    continue; // Lewati iterasi jika hari adalah Sabtu atau Minggu
                                                                }

                                                                if (in_array($tanggal, $daftarHariLiburNasional)) {
                                                                    continue; // Lewati iterasi jika tanggal adalah hari libur nasional
                                                                }

                                                                $jamMasuk = \Carbon\Carbon::parse($entry->jam_masuk); // Konversi jam_masuk ke objek Carbon
                                                                $jamKeluar = \Carbon\Carbon::parse($entry->jam_keluar); // Konversi jam_keluar ke objek Carbon

                                                                $jumlahHariHadir++;
                                                            }
                                                        }

                                                        $jumlahHariDinas = 0;

                                                        foreach ($dinas as $entry) {
                                                            $tanggalDinas = \Carbon\Carbon::parse($entry->tanggal);

                                                            $tanggalDinasString = $tanggalDinas->format('Y-m-d');
                                                            if (
                                                                $tanggalDinas->dayOfWeek != 6 &&
                                                                $tanggalDinas->dayOfWeek != 0 &&
                                                                !in_array($tanggalDinasString, $daftarHariLiburNasional)
                                                            ) {
                                                                $jumlahHariDinas++;
                                                            }
                                                        }
                                                        $jumlahHariCuti = 0;

                                                        foreach ($cuti as $entry) {
                                                            $tanggalMulai = \Carbon\Carbon::parse(
                                                                $entry->tanggal_mulai,
                                                            );
                                                            $tanggalSelesai = \Carbon\Carbon::parse(
                                                                $entry->tanggal_selesai,
                                                            );

                                                            while ($tanggalMulai <= $tanggalSelesai) {
                                                                if (
                                                                    $tanggalMulai->dayOfWeek != 6 &&
                                                                    $tanggalMulai->dayOfWeek != 0
                                                                ) {
                                                                    $tanggalString = $tanggalMulai->format('Y-m-d');
                                                                    if (
                                                                        !in_array(
                                                                            $tanggalString,
                                                                            $daftarHariLiburNasional,
                                                                        )
                                                                    ) {
                                                                        $jumlahHariCuti++;
                                                                    }
                                                                }

                                                                $tanggalMulai->addDay(); // Tambahkan 1 hari
                                                            }
                                                        }

                                                        $jumlahHariIzin = 0;
                                                        $jumlahHariSakit = 0;

                                                        foreach ($izin as $entry) {
                                                            $tanggalIzin = \Carbon\Carbon::parse($entry->tanggal);

                                                            $tanggalIzinString = $tanggalIzin->format('Y-m-d');
                                                            if (
                                                                $tanggalIzin->dayOfWeek != 6 &&
                                                                $tanggalIzin->dayOfWeek != 0 &&
                                                                !in_array($tanggalIzinString, $daftarHariLiburNasional)
                                                            ) {
                                                                $jumlahHariIzin++;
                                                            }
                                                        }

                                                        foreach ($sakit as $entry) {
                                                            $tanggalSakit = \Carbon\Carbon::parse($entry->tanggal);

                                                            $tanggalSakitString = $tanggalSakit->format('Y-m-d');
                                                            if (
                                                                $tanggalSakit->dayOfWeek != 6 &&
                                                                $tanggalSakit->dayOfWeek != 0 &&
                                                                !in_array($tanggalSakitString, $daftarHariLiburNasional)
                                                            ) {
                                                                $jumlahHariSakit++;
                                                            }
                                                        }

                                                        $tanggalAwal = \Carbon\Carbon::create($year, $month, 1);
                                                        $tanggalAkhir = $tanggalAwal->copy()->endOfMonth();

                                                        // Ambil semua libur nasional untuk bulan dan tahun yang dipilih
                                                        $liburNasionals = App\Models\LiburNasional::whereMonth(
                                                            'tanggal',
                                                            '=',
                                                            $month,
                                                        )
                                                            ->whereYear('tanggal', '=', $year)
                                                            ->pluck('tanggal')
                                                            ->toArray();

                                                        // Inisialisasi jumlah hari kerja tanpa libur nasional
                                                        $hariKerjaTanpaLiburNasional = 0;

                                                        // Loop setiap tanggal dari tanggalAwal hingga tanggalAkhir
                                                        $currentDate = $tanggalAwal->copy();
                                                        while ($currentDate->lte($tanggalAkhir)) {
                                                            // Periksa apakah hari ini bukan Sabtu atau Minggu dan bukan libur nasional
                                                            if (
                                                                $currentDate->dayOfWeek != 0 &&
                                                                $currentDate->dayOfWeek != 6 &&
                                                                !in_array($currentDate->toDateString(), $liburNasionals)
                                                            ) {
                                                                $hariKerjaTanpaLiburNasional++;
                                                            }

                                                            // Tambahkan 1 hari ke tanggal saat ini
                                                            $currentDate->addDay();
                                                        }

                                                        $total = $hariKerjaTanpaLiburNasional;
                                                        $totalHadirDinasIzinCutiSakit =
                                                            $jumlahHariHadir +
                                                            $jumlahHariDinas +
                                                            $jumlahHariIzin +
                                                            $jumlahHariCuti +
                                                            $jumlahHariSakit;

                                                        // Hitung TK
                                                        $tk = $total - $totalHadirDinasIzinCutiSakit;

                                                        // Inisialisasi $tkToShow dengan nilai 0
                                                        $tkToShow = 0;

                                                        // Jika total hari hadir, dinas, izin, cuti, dan sakit mendekati atau sama dengan total, ubah nilai $tkToShow
                                                        if ($totalHadirDinasIzinCutiSakit >= $total - 3) {
                                                            $tkToShow = $tk;
                                                        }

                                                    @endphp
                                                <tr style="background-color: {{ ($user->status === 'PNS' || $user->status === 'PPPK') ? '#f4f4f9' : '#FFFFFF' }};">
                                                    <td class="rata-tengah">{{ $no++ }}</td>
                                                        <td class="name-nowrap">{{ $user->name }}</td>
                                                        <td class="rata-tengah">{{ $user->nip }}</td>
                                                        <td class="rata-tengah">
                                                            {{ substr($user->pangkat->name ?? '-', 0, 5) }}
                                                        </td>
                                                        <td class="rata-tengah">{{ $user->jabatan->name ?? '-' }}</td>
                                                        <td class="rata-tengah">{{ $jumlahHariHadir }}</td>
                                                        <td class="rata-tengah">{{ $jumlahHariDinas }}</td>
                                                        <td class="rata-tengah">{{ $jumlahHariIzin }}</td>
                                                        <td class="rata-tengah">{{ $jumlahHariCuti }}</td>
                                                        <td class="rata-tengah">{{ $jumlahHariSakit }}</td>
                                                        <td class="rata-tengah">{{ $tkToShow }}</td>
                                                        <td class="rata-tengah">{{ $total }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>


                                    <br>
                                    <table width="100%" align="center" border="0">
                                        <tr>
                                            <td style="text-align: center; padding-right: 15%;">DIKETAHUI OLEH</td>
                                            <td style="text-align: center; padding-left: 20%;">
                                                Lubuk Sikaping, &emsp;&emsp;
                                                @php
                                                    $carbonDate = \Carbon\Carbon::parse(request('bulan'));
                                                @endphp

                                                {{ $carbonDate->locale('id_ID')->translatedFormat('F Y') }}

                                            </td>


                                        </tr>
                                        <tr>
                                            <td style="text-align: center; padding-right: 15%; ">
                                                @if ($kepalaDinas)
                                                    KEPALA DINAS<br>
                                                @elseif ($kepalaBadan)
                                                    KEPALA BADAN<br>
                                                @elseif ($sekda)
                                                    SEKRETARIS DAERAH<br>
                                                @elseif ($inspektur)
                                                    INSPEKTUR<br>
                                                @elseif ($camat)
                                                    CAMAT<br>
                                                @elseif ($direktur)
                                                    DIREKTUR<br>
                                                @elseif ($kepalaSatuan)
                                                    KEPALA SATUAN<br>
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
                                                @if ($kasubagTu)
                                                    KASUBBAG TU PIMPINAN, STAF AHLI<br>DAN KEPEGAWAIAN
                                                @else
                                                    KASUBAG UMUM DAN KEPEGAWAIAN<br>
                                                @endif
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
                                                        {{ $kepalaDinas
                                                            ? $kepalaDinas->name ?? '-'
                                                            : ($kepalaBadan
                                                                ? $kepalaBadan->name ?? '-'
                                                                : ($asisten1
                                                                    ? $asisten1->name ?? '-'
                                                                    : ($asisten2
                                                                        ? $asisten2->name ?? '-'
                                                                        : ($asisten3
                                                                            ? $asisten3->name ?? '-'
                                                                            : ($sekda
                                                                                ? $sekda->name ?? '-'
                                                                                : ($inspektur
                                                                                    ? $inspektur->name ?? '-'
                                                                                    : ($camat
                                                                                        ? $camat->name ?? '-'
                                                                                        : ($direktur
                                                                                            ? $direktur->name ?? '-'
                                                                                            : ($kepalaSatuan
                                                                                                ? $kepalaSatuan->name ?? '-'
                                                                                                : '-'))))))))) }}
                                                    </u></strong><br>
                                                <strong>NIP.
                                                    {{ $kepalaDinas
                                                        ? $kepalaDinas->nip ?? '-'
                                                        : ($kepalaBadan
                                                            ? $kepalaBadan->nip ?? '-'
                                                            : ($sekda
                                                                ? $sekda->nip ?? '-'
                                                                : ($asisten1
                                                                    ? $asisten1->nip ?? '-'
                                                                    : ($asisten2
                                                                        ? $asisten2->nip ?? '-'
                                                                        : ($asisten3
                                                                            ? $asisten3->nip ?? '-'
                                                                            : ($inspektur
                                                                                ? $inspektur->nip ?? '-'
                                                                                : ($camat
                                                                                    ? $camat->nip ?? '-'
                                                                                    : ($direktur
                                                                                        ? $direktur->nip ?? '-'
                                                                                        : ($kepalaSatuan
                                                                                            ? $kepalaSatuan->nip ?? '-'
                                                                                            : '-'))))))))) }}
                                                </strong>
                                            </td>


                                            <td style="text-align: center; padding-left: 20%;">
                                                <strong><u>
                                                        @if ($kasubag)
                                                            {{ $kasubag->name ?? '-' }}
                                                        @elseif ($kasubagTu)
                                                            {{ $kasubagTu->name ?? '-' }}
                                                        @else
                                                            -
                                                        @endif
                                                    </u></strong><br>
                                                <strong> NIP.@if ($kasubag)
                                                        {{ $kasubag->nip ?? '-' }}
                                                    @elseif ($kasubagTu)
                                                        {{ $kasubagTu->nip ?? '-' }}
                                                    @else
                                                        -
                                                    @endif
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
@endsection
