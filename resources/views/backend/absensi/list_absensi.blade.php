@extends('backend.layouts.app')
@section('content')
    @if (Auth::user()->role == 2)
        @include('backend.absensi.add_absensi')
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header info">
                    <h3 class="card-title">Daftar Presensi</h3>
                </div>
                <div class="card-body">
                    @if (Auth::user()->role == 1)
                        <a href="#" class="btn btn-mm btn-info mb-4" onclick="konfirmasiTambahPresensi()">
                            <i class="fas fa-plus-circle"></i> Tambah Presensi
                        </a>
                        @include('backend.modal.add_absensi')
                    @endif

                    <form action="{{ route('absensi.index') }}" method="GET" class="mb-2">
                        <div class="row justify-content-end">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="search_name" name="search_name"
                                        value="{{ request()->query('search_name') }}" placeholder="Cari Pegawai">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-info">Cari</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <table id="exampleTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Pegawai</th>
                                <th>Tanggal</th>
                                <th>Jam Datang</th>
                                <th>Jam Pulang</th>
                                <th>Keterangan</th>
                                @if (Auth::user()->role == 1)
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absen as $key => $absensi)
                                <tr>
                                    <td>{{ $absen->firstItem() + $key }}</td>
                                    <td>{{ $absensi->user->name ?? '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->locale('id_ID')->translatedFormat('j F Y') }}
                                    </td>
                                    <td>{{ $absensi->jam_masuk }}</td>
                                    <td>{{ $absensi->jam_keluar ?? 'Belum Absen Pulang' }}</td>
                                    <td>
                                        @if (strtotime($absensi->tanggal) >= strtotime('2024-03-12') && strtotime($absensi->tanggal) <= strtotime('2024-04-09'))
                                            {{-- Jika dalam rentang tanggal yang ditentukan --}}
                                            @if (strtotime($absensi->jam_masuk) > strtotime('08:00:00'))
                                                <span class="badge badge-danger" style="font-size: 12px;"><i
                                                        class="far fa-clock"></i> TELAT</span>
                                            @else
                                                <span class="badge badge-success" style="font-size: 12px;"><i
                                                        class="far fa-clock"></i> MASUK</span>
                                            @endif
                                        @else
                                            {{-- Jika di luar rentang tanggal yang ditentukan --}}
                                            @if (strtotime($absensi->jam_masuk) > strtotime('07:30:00'))
                                                <span class="badge badge-danger" style="font-size: 12px;"><i
                                                        class="far fa-clock"></i> TELAT</span>
                                            @else
                                                <span class="badge badge-success" style="font-size: 12px;"><i
                                                        class="far fa-clock"></i> MASUK</span>
                                            @endif
                                        @endif


                                        @php
                                            $tanggal = $absensi->tanggal; // Ambil tanggal dari database (format: 'YYYY-MM-DD')
                                            $hari = \Carbon\Carbon::createFromFormat('Y-m-d', $tanggal)->format('l');
                                        @endphp

                                        @if ($absensi->jam_keluar == null)
                                            <span class="" style="font-size: 12px;"></span>
                                        @elseif (strtotime($tanggal) >= strtotime('2024-03-12') && strtotime($tanggal) <= strtotime('2024-04-09'))
                                            {{-- Jika dalam rentang tanggal yang ditentukan --}}
                                            @if ($hari == 'Friday' && strtotime($absensi->jam_keluar) < strtotime('15:30:00'))
                                                || <span class="badge badge-danger" style="font-size: 12px;"><i
                                                        class="far fa-clock"></i> PULANG CEPAT</span>
                                            @elseif ($hari != 'Friday' && strtotime($absensi->jam_keluar) < strtotime('15:00:00'))
                                                || <span class="badge badge-danger" style="font-size: 12px;"><i
                                                        class="far fa-clock"></i> PULANG CEPAT</span>
                                            @else
                                                || <span class="badge badge-success" style="font-size: 12px;"><i
                                                        class="far fa-clock"></i> PULANG TEPAT WAKTU</span>
                                            @endif
                                        @else
                                            {{-- Jika di luar rentang tanggal yang ditentukan --}}
                                            @if ($hari == 'Friday' && strtotime($absensi->jam_keluar) < strtotime('16:30:00'))
                                                || <span class="badge badge-danger" style="font-size: 12px;"><i
                                                        class="far fa-clock"></i> PULANG CEPAT</span>
                                            @elseif ($hari != 'Friday' && strtotime($absensi->jam_keluar) < strtotime('16:00:00'))
                                                || <span class="badge badge-danger" style="font-size: 12px;"><i
                                                        class="far fa-clock"></i> PULANG CEPAT</span>
                                            @else
                                                || <span class="badge badge-success" style="font-size: 12px;"><i
                                                        class="far fa-clock"></i> PULANG TEPAT WAKTU</span>
                                            @endif
                                        @endif


                                    </td>

                                    @php
                                        $jumlahHari = 0;
                                        if ($absensi->jam_masuk && $absensi->jam_keluar) {
                                            $jumlahHari = 1;
                                        }
                                    @endphp


                                    @if (Auth::user()->role == 1)
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">

                                                <a href="javascript:void(0)" class="btn btn-sm btn-info"
                                                    onclick="konfirmasiEditAbsensi('{{ $absensi->id }}')">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a href="{{ route('absensi.delete', ['id' => $absensi->id]) }}"
                                                    class="btn btn-sm btn-danger" id="delete" class="middle-align">
                                                    <i class="fas fa-trash-alt"></i> <!-- Ganti dengan ikon Delete -->
                                                </a>
                                            </div>


                                        </td>
                                    @endif
                                </tr>
                                @include('backend.modal.edit_absensi', ['absensiId' => $absensi->id])
                            @endforeach
                        </tbody>
                    </table>

                    <div class="pagination justify-content-center mt-2">
                        {{ $absen->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    @if (session('success'))
        <script>
            showSuccessAlert('{{ session('success') }}');
        </script>
    @endif

    @if (session('error'))
        <script>
            showErrorAlert('{{ session('error') }}');
        </script>
    @endif

    <script>
        document.getElementById('opd').addEventListener('change', function() {
            var selectedOpd = this.value;
            var userOptions = document.querySelectorAll('[data-opd]');

            userOptions.forEach(function(option) {
                option.style.display = 'none';
                if (option.getAttribute('data-opd') === selectedOpd || selectedOpd === 'all') {
                    option.style.display = '';
                }
            });
        });
    </script>
    <script>
        function konfirmasiTambahPresensi() {
            // Menggunakan SweetAlert2 untuk konfirmasi
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menambah presensi?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Menambah kelas animasi sebelum membuka modal
                    $('#absenModal').addClass('animated bounceIn');

                    // Membuka modal setelah animasi
                    setTimeout(function() {
                        $('#absenModal').modal('show');
                    }, 500); // Sesuaikan dengan durasi animasi CSS
                } else {
                    // Tindakan jika pengguna membatalkan
                }
            });
        }

        function konfirmasiEditAbsensi(absensiId) {
            // Menggunakan SweetAlert2 untuk konfirmasi
            Swal.fire({
                title: 'Konfirmasi Edit',
                text: 'Apakah Anda yakin ingin mengedit data presensi?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Menambah kelas animasi sebelum membuka modal edit
                    $(`#editAbsensiModal${absensiId}`).addClass('animated bounceIn');

                    // Membuka modal edit setelah animasi
                    setTimeout(function() {
                        $(`#editAbsensiModal${absensiId}`).modal('show');
                    }, 500); // Sesuaikan dengan durasi animasi CSS
                } else {
                    // Tindakan jika pengguna membatalkan
                }
            });
        }
    </script>
@endsection
