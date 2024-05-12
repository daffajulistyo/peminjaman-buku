@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header info">
                    <h3 class="card-title">Daftar Tugas Belajar</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a href="#" class="btn btn-mm btn-info mb-4" data-toggle="modal" data-target="#addTBModal">+
                        Tambah Tugas</a>
                        <form action="{{ route('tugas.index') }}" method="GET" class="mb-2">
                            <div class="row justify-content-end">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ request()->query('nama') }}" placeholder="Cari Pegawai">
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($tugasBelajar as $tb)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $tb->user->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($tb->tanggal_mulai)->locale('id_ID')->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($tb->tanggal_selesai)->locale('id_ID')->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ $tb->keterangan }}</td>
                                    <td>
                                        <a href="{{ route('tugas.edit', ['id' => $tb->id]) }}" class="btn btn-sm btn-info"
                                            data-toggle="modal" data-target="#editTBModal{{ $tb->id }}"><i
                                                class="fas fa-edit"></i></a>
                                        <a href="{{ route('tugas.delete', ['id' => $tb->id]) }}"
                                            class="btn btn-sm btn-danger" id="delete" class="middle-align"><i
                                                class="fas fa-trash-alt"></i></a>

                                    </td>
                                </tr>

                                <!-- Pangkat -->
                                <div class="modal fade" id="editTBModal{{ $tb->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Tugas</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form role="form" action="{{ route('tugas.update', ['id' => $tb->id]) }}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group" hidden>
                                                        <label for="user_id">Nama Pegawai</label>
                                                        @php
                                                            $users = \App\Models\User::all();
                                                            $selectedUserId = $tb->user_id;
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
                                                            value="{{ $tb->tanggal_mulai }}"
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
                                                            value="{{ $tb->tanggal_selesai }}"
                                                            class="form-control @error('tanggal_selesai') is-invalid @enderror">
                                                        @error('tanggal_selesai')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="text">Keterangan</label>

                                                        <textarea class="form-control" name="keterangan" rows="5">{{ $tb->keterangan }}</textarea>
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
                                <?php $no++; ?>
                            @endforeach

                        </tbody>

                    </table>
                    <div class="pagination justify-content-center mt-2">
                        {{-- {{ $tb->links() }} --}}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    @include('backend.modal.add_tugas_belajar')
@endsection
