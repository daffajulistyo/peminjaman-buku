@extends('backend.layouts.app')
@section('content')
    <div class="row" id="filterRow">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-body">
                    <form id="filterForm" action="{{ route('filter.admin') }}" method="get">
                        @csrf

                        <div class="form-group row ml-3">
                            <label for="opd" class="col-sm-2 col-form-label">Pilih OPD</label>
                            <div class="col-sm-10">
                                <select name="opd" id="opd" class="form-control select2" onchange="this.form.submit()">
                                    {{-- <option value="" disabled selected>PILIH OPD</option> --}}
                                    @php
                                        $opds = App\Models\Opd::all();
                                    @endphp
                                    @foreach ($opds as $skpd)
                                        <option value="{{ $skpd->id }}"
                                            @if (request('opd') == $skpd->id) selected @endif>{{ $skpd->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if (request('opd'))
                            <div class="form-group row ml-3">
                                <label for="user_id" class="col-sm-2 col-form-label">Pilih Pegawai</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" name="user_id" id="userSelect" required>
                                        <option value="" disabled selected>Pilih Pegawai</option>
                                        @php
                                            $users = App\Models\User::where('opd_id', request('opd'))->where('role', 2)->get();
                                        @endphp
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="form-group row ml-3">
                            <label for="tanggal_mulai" class="col-sm-2 col-form-label">Tanggal Awal</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="date" name="tanggal_mulai"
                                    value="{{ request('tanggal_mulai') }}" required>
                            </div>
                        </div>
                        <div class="form-group row ml-3">
                            <label for="tanggal_selesai" class="col-sm-2 col-form-label">Tanggal Akhir</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="date" name="tanggal_selesai"
                                    value="{{ request('tanggal_selesai') }}" required>
                            </div>
                        </div>

                        <div class="form-group row ml-3">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-success"> <i class="fas fa-edit"></i>
                                    Tampilkan</button>
                                @if (isset($opd))
                                    <button type="button" id="btnPrint" class="btn btn-success ml-2" target="_blank">
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

    @if (isset($opd) && isset($selectedUser))
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
                                                @if (strcasecmp($opd->name, 'ASISTEN PEMERINTAHAN') == 0 ||
                                                strcasecmp($opd->name, 'ASISTEN PEREKONOMIAN DAN PEMBANGUNAN') == 0 ||
                                                strcasecmp($opd->name, 'ASISTEN ADMINISTRASI UMUM') == 0)
                                            <h3
                                                style="font-weight: bold; padding-left:50px; padding-right:50px; text-transform: uppercase">
                                                SEKRETARIAT DAERAH</h3>
                                        @else
                                            <h3
                                                style="font-weight: bold; padding-left:50px; padding-right:50px; text-transform: uppercase">
                                                {{ $opd->name }}</h3>
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
                                                <h6 class="mt-3">NAMA :
                                                    @if (isset($selectedUser))
                                                        {{ $selectedUser->name }}
                                                    @else
                                                        Nama Tidak Tersedia
                                                    @endif
                                                </h6>
                                                <h6>NIP / NIK :
                                                    @if (isset($selectedUser))
                                                        {{ $selectedUser->nip }}
                                                    @else
                                                        NIP Tidak Tersedia
                                                    @endif
                                                </h6>
                                                <h6 style="text-transform: uppercase;">JABATAN :
                                                    @if (isset($selectedUser))
                                                        {{ $selectedUser->jabatan->name ?? '-' }}
                                                    @else
                                                        Jabatan Tidak Tersedia
                                                    @endif
                                                </h6>
                                            </td>

                                        </tr>
                                    </table>
                                    <table border="1" width="100%" class="mt-3">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="rata-tengah">HARI</th>
                                                <th rowspan="2" class="rata-tengah">TANGGAL</th>
                                                <th rowspan="2" class="rata-tengah">JAM MASUK</th>
                                                <th rowspan="2" class="rata-tengah">JAM PULANG</th>
                                                <th rowspan="2" class="rata-tengah">JAM KERJA</th>
                                            </tr>
                                            <tr></tr>

                                        </thead>
                                        <tbody>
                                            @foreach ($dates as $date)
                                                <tr>
                                                    <td class="rata-tengah">
                                                        {{ \Carbon\Carbon::parse($date)->locale('id_ID')->translatedFormat('l') }}
                                                    </td>
                                                    <td class="rata-tengah">
                                                        {{ \Carbon\Carbon::parse($date)->locale('id_ID')->translatedFormat('j F Y') }}
                                                    </td>

                                                    @if ($attendanceData[$date]['jam_masuk'] == 'Libur Nasional')
                                                        <td colspan="4" class="rata-tengah">
                                                            Libur Nasional
                                                        </td>
                                                    @elseif ($dutyData[$date] == 'Dinas')
                                                        <td class="rata-tengah" colspan="4">
                                                            Dinas
                                                        </td>
                                                    @elseif ($leaveData[$date] == 'Cuti')
                                                        <td class="rata-tengah" colspan="4">
                                                            Cuti
                                                        </td>
                                                    @elseif ($permissionData[$date] == 'Izin')
                                                        <td class="rata-tengah" colspan="4">
                                                            Izin
                                                        </td>
                                                    @elseif ($sickData[$date] == 'Sakit')
                                                        <td class="rata-tengah" colspan="4">
                                                            Sakit
                                                        </td>
                                                    @elseif (isset($attendanceData[$date]['jam_masuk']))
                                                        @php
                                                            $attendance = $attendanceData[$date];
                                                            $jamMasuk = $attendance['jam_masuk'];
                                                            $jamKeluar = $attendance['jam_keluar'] ?? '-';
                                                            $telat = false;
                                                            $durasiKerja = '-';

                                                            if ($jamMasuk !== null && $jamMasuk !== '-' && $jamMasuk !== 'Libur Nasional') {
                                                                $jamMasuk = \Carbon\Carbon::parse($jamMasuk)->format('H:i');
                                                                $jamKeluar = $jamKeluar !== '-' ? \Carbon\Carbon::parse($jamKeluar)->format('H:i') : '-';
                                                                $durasiKerja = $jamKeluar !== '-' ? \Carbon\Carbon::parse($jamKeluar)->diffInMinutes(\Carbon\Carbon::parse($jamMasuk)) : '-';
                                                                $telat = \Carbon\Carbon::parse($attendance['jam_masuk'])->greaterThan(\Carbon\Carbon::parse($date)->setHour(7)->setMinute(30));
                                                            }
                                                        @endphp
                                                        @if ($jamMasuk !== null && $jamMasuk !== '-' && $jamMasuk !== 'Libur Nasional')
                                                            <td class="rata-tengah">
                                                                {{ $jamMasuk }}
                                                            </td>
                                                        @else
                                                            <td colspan="4" class="rata-tengah">
                                                                Tanpa Keterangan
                                                            </td>
                                                        @endif

                                                        @if ($jamMasuk !== null && $jamMasuk !== '-' && $jamMasuk !== 'Libur Nasional')
                                                            <td class="rata-tengah">
                                                                @if ($jamKeluar !== '-')
                                                                    {{ $jamKeluar }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        @endif

                                                        @if ($jamKeluar !== '-')
                                                            <td class="rata-tengah">
                                                                @if ($durasiKerja !== '-')
                                                                    {{ floor($durasiKerja / 60) - 1 }} jam
                                                                    {{ $durasiKerja % 60 }}
                                                                    menit
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        @endif
                                                    @endif
                                                </tr>
                                            @endforeach



                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('opd').addEventListener('change', function() {
                var selectedOpdId = this.value;

                fetch('/get-users/' + selectedOpdId)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('userSelect').innerHTML =
                            '<option value="" disabled selected>Pilih Pegawai</option>';

                        data.forEach(user => {
                            var option = document.createElement('option');
                            option.value = user.id;
                            option.text = user.name;
                            document.getElementById('userSelect').add(option);
                        });
                    });
            });
        </script>

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
