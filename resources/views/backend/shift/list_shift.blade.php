@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header info">
                    <h3 class="card-title">Daftar Shift Kerja</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a href="#" class="btn btn-mm btn-info mb-4" data-toggle="modal" data-target="#addShiftModal">+
                        Tambah Shift</a>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($shift as $shift)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $shift->name }}</td>
                                    <td>{{ $shift->jam_masuk }}</td>
                                    <td>{{ $shift->jam_keluar }}</td>

                                    <td>
                                        <a href="{{ route('shift.edit', ['id' => $shift->id]) }}"
                                            class="btn btn-sm btn-info" data-toggle="modal"
                                            data-target="#editShiftModal{{ $shift->id }}"><i
                                                class="fas fa-edit"></i></a>
                                        <a href="{{ route('shift.delete', ['id' => $shift->id]) }}"
                                            class="btn btn-sm btn-danger" id="delete" class="middle-align"><i
                                                class="fas fa-trash-alt"></i></a>

                                    </td>
                                </tr>

                                <!-- Pangkat -->
                                <div class="modal fade" id="editShiftModal{{ $shift->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Shift {{ $shift->name }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form role="form"
                                                action="{{ route('shift.update', ['id' => $shift->id]) }}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <!-- Isi modal untuk mengedit Pangkat -->
                                                    <div class="form-group">
                                                        <label for="text">Nama</label>
                                                        <input type="text" name="name" value="{{ $shift->name }}"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            id="text" placeholder="Masukkan Nama Pangkat">
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="text">Jam Masuk</label>
                                                        <input type="time" name="jam_masuk" value="{{ $shift->jam_masuk }}"
                                                            class="form-control @error('jam_masuk') is-invalid @enderror"
                                                            id="text">
                                                        @error('jam_masuk')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="text">Jam Keluar</label>
                                                        <input type="time" name="jam_keluar" value="{{ $shift->jam_keluar }}"
                                                            class="form-control @error('jam_keluar') is-invalid @enderror"
                                                            id="text">
                                                        @error('jam_keluar')
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
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    @include('backend.modal.add_shift')
@endsection
