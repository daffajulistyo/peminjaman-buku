@extends('backend.layouts.app')
@section('content')
    @if (Auth::user()->role == 2)
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header info">
                        <h3 class="card-title">Input Presensi Pegawai Cuti</h3>
                    </div>
                    <form method="POST" action="{{ route('simpan-cuti') }}">
                        @csrf
                        <div class="card-body mt-3">
                            <div class="form-group row" hidden>
                                <label for="opd" class="col-sm-3 pr-5 col-form-label text-right">Nama OPD</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="opd" name="opd"
                                        value="{{ Auth::user()->opd->name }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row" hidden>
                                <label for="user_id" class="col-sm-3 pr-5 col-form-label text-right">Nama Pegawai</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="user_name"
                                        value="{{ Auth::user()->name }}" disabled>
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal_mulai" class="col-sm-3 pr-5 col-form-label">Tanggal
                                    Mulai</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="date" name="tanggal_mulai" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal_selesai" class="col-sm-3 pr-5 col-form-label">Tanggal
                                    Selesai</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="date" name="tanggal_selesai" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="keterangan" class="col-sm-3 pr-5 col-form-label">Keterangan</label>

                                <div class="col-sm-9">
                                    <textarea class="form-control" name="keterangan" rows="5" placeholder="Keterangan Cuti" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-save pr-1"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                @if (Auth::user()->role == 1)
                    <div class="card-header info">
                        <h3 class="card-title">Daftar Presensi Cuti Pegawai</h3>
                    </div>
                @endif
                <div class="card-body">
                    @if (Auth::user()->role == 1)
                        <a href="#" class="btn btn-mm btn-info mb-4" data-toggle="modal" data-target="#cutiModal">+
                            Tambah Presensi Cuti</a>
                        <div class="modal fade" id="cutiModal" tabindex="-1" role="dialog"
                            aria-labelledby="dinasModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="dinasModalLabel">Input Presensi Pegawai
                                            Cuti</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('simpan-cuti') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="opd">Nama OPD</label>
                                                <input type="text" class="form-control" id="opd" name="opd"
                                                    value="{{ Auth::user()->opd->name }}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="user_id">Nama Pegawai</label>
                                                <select class="form-control" name="user_id" required>
                                                    <option value="" disabled selected>Pilih Pegawai</option>
                                                    @php
                                                        $users = \App\Models\User::where('opd_id', Auth::user()->opd_id)
                                                            ->where('role', 2)
                                                            ->get();
                                                    @endphp
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="tanggal_mulai">Tanggal Mulai</label>
                                                <input class="form-control" type="date" name="tanggal_mulai" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="tanggal_selesai">Tanggal Selesai</label>
                                                <input class="form-control" type="date" name="tanggal_selesai"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="keterangan" class="mr-2">Keterangan:</label>

                                                <textarea class="form-control" name="keterangan" rows="5" placeholder="Keterangan Dinas" required></textarea>
                                            </div>
                                            {{-- <button type="submit" class="btn btn-success">Simpan</button> --}}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-info">Simpan</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    <form action="{{ route('cuti.index') }}" method="GET" class="mb-2">
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
                                <th>Nama</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Keterangan</th>
                                <th>Jumlah Hari</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($cuti as $key => $c)
                                <tr>
                                    <td>{{ $cuti->firstItem() + $key }}</td>
                                    <td>{{ $c->user->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($c->tanggal_mulai)->locale('id_ID')->translatedFormat('j F Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($c->tanggal_selesai)->locale('id_ID')->translatedFormat('j F Y') }}
                                    </td>
                                    <td>{{ $c->keterangan }}</td>
                                    <td>
                                        @php
                                            $tanggalMulai = \Carbon\Carbon::parse($c->tanggal_mulai);
                                            $tanggalSelesai = \Carbon\Carbon::parse($c->tanggal_selesai);

                                            $jumlahHariCuti = 0;

                                            $daftarHariLiburNasional = ['2023-12-25']; // Gantilah ini dengan daftar hari libur nasional

                                            while ($tanggalMulai <= $tanggalSelesai) {
                                                // Periksa apakah hari saat ini bukan Sabtu (6) atau Minggu (0)
                                                if ($tanggalMulai->dayOfWeek != 6 && $tanggalMulai->dayOfWeek != 0) {
                                                    $tanggalString = $tanggalMulai->format('Y-m-d');
                                                    // Periksa apakah hari saat ini bukan hari libur nasional
                                                    if (!in_array($tanggalString, $daftarHariLiburNasional)) {
                                                        $jumlahHariCuti++;
                                                    }
                                                }

                                                $tanggalMulai->addDay(); // Tambahkan 1 hari
                                            }
                                        @endphp

                                        {{ $jumlahHariCuti }} Hari Kerja

                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">

                                            @if (Auth::user()->role == 1)
                                                <a href="{{ route('cuti.edit', ['id' => $c->id]) }}"
                                                    class="btn btn-sm btn-info" data-toggle="modal"
                                                    data-target="#editCutiModal{{ $c->id }}">
                                                    <i class="fas fa-edit"></i> <!-- Ganti dengan ikon Edit -->
                                                </a>
                                            @endif
                                            <a href="{{ route('cuti.delete', ['id' => $c->id]) }}"
                                                class="btn btn-sm btn-danger" id="delete" class="middle-align">
                                                <i class="fas fa-trash-alt"></i> <!-- Ganti dengan ikon Delete -->
                                            </a>
                                        </div>


                                    </td>
                                </tr>
                                <div class="modal fade" id="editCutiModal{{ $c->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Presensi Cuti</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form role="form" action="{{ route('cuti.update', ['id' => $c->id]) }}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="user_id">Nama Pegawai</label>
                                                        @php
                                                            $users = \App\Models\User::all();
                                                            $selectedUserId = $c->user_id;
                                                        @endphp

                                                        <select class="form-control" name="user_id" required>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}"
                                                                    {{ $user->id == $selectedUserId ? 'selected' : '' }}>
                                                                    {{ $user->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="text">Tanggal Mulai</label>
                                                        <input type="date" name="tanggal_mulai"
                                                            value="{{ $c->tanggal_mulai }}"
                                                            class="form-control @error('tanggal_mulai') is-invalid @enderror">
                                                        @error('tanggal_mulai')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="text">Tanggal Selesai</label>
                                                        <input type="date" name="tanggal_selesai"
                                                            value="{{ $c->tanggal_selesai }}"
                                                            class="form-control @error('tanggal_selesai') is-invalid @enderror">
                                                        @error('tanggal_selesai')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="text">Keterangan</label>

                                                        <textarea class="form-control" name="keterangan" rows="5">{{ $c->keterangan }}</textarea>
                                                        @error('keterangan')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-info">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </tbody>

                    </table>
                    <div class="pagination justify-content-center mt-2">
                        {{ $cuti->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

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
@endsection
