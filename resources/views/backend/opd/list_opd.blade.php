@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header info">
                    <h3 class="card-title">Daftar Organisasi Perangkat Daerah</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- <a href="{{ route('opd.show') }}" class="btn btn-mm btn-info mb-2">+ Tambah OPD</a> --}}
                    <a href="#" class="btn btn-mm btn-info mb-4" data-toggle="modal" data-target="#addOPDModal">+
                        Tambah OPD</a>
                    <form action="{{ route('opd.index') }}" method="GET" class="mb-2">
                        <div class="row justify-content-end">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ request()->query('nama') }}" placeholder="Cari OPD">
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($opd as $key => $o)
                                <tr>
                                    <td>{{ $opd->firstItem() + $key }}</td>
                                    <td>{{ $o->name }}</td>

                                    <td>

                                        <a href="{{ route('opd.edit', ['id' => $o->id]) }}" class="btn btn-sm btn-info"
                                            data-toggle="modal" data-target="#editOPDModal{{ $o->id }}"><i
                                                class="fas fa-edit"></i></a>
                                        <a href="{{ route('opd.delete', ['id' => $o->id]) }}"
                                            class="btn btn-sm btn-danger" id="delete" class="middle-align"><i
                                                class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>

                                {{-- MODAL EDIT --}}
                                <div class="modal fade" id="editOPDModal{{ $o->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit OPD</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form role="form" action="{{ route('opd.update', ['id' => $o->id]) }}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <!-- Isi modal untuk mengedit OPD -->
                                                    <div class="form-group">
                                                        <label for="text">Nama</label>
                                                        <input type="text" name="name" value="{{ $o->name }}"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            id="text" placeholder="Masukkan Nama OPD">
                                                        @error('name')
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
                        {{ $opd->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    {{-- Modal Tambah OPD --}}
    <div class="modal fade" id="addOPDModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah OPD Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" action="{{ route('opd.insert') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!-- Isi modal untuk menambahkan OPD -->
                        <div class="form-group">
                            <label for="text">Nama</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="text" placeholder="Masukan Nama OPD" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
@endsection
