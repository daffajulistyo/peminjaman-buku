@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header info">
                    <h3 class="card-title">Daftar Bidang Pemerintahan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a href="#" class="btn btn-mm btn-info mb-4" data-toggle="modal" data-target="#addBidangModal">+
                        Tambah Bidang</a>
                    <form action="{{ route('bidang.index') }}" method="GET" class="mb-2">
                        <div class="row justify-content-end">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ request()->query('nama') }}" placeholder="Cari Bidang">
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
                                @if (Auth::user()->role != 1)
                                    <th>OPD</th>
                                @endif
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bidang as $key => $b)
                                <tr>
                                    <td>{{ $bidang->firstItem() + $key }}</td>
                                    <td>{{ $b->name }}</td>
                                    @if (Auth::user()->role != 1 && $b->opd)
                                    <td>
                                        {{ $b->opd->name }}
                                    </td>
                                @endif

                                    <td>
                                        <a href="{{ route('bidang.edit', ['id' => $b->id]) }}" class="btn btn-sm btn-info"
                                            data-toggle="modal" data-target="#editBidangModal{{ $b->id }}"><i
                                                class="fas fa-edit"></i></a>
                                        <a href="{{ route('bidang.delete', ['id' => $b->id]) }}"
                                            class="btn btn-sm btn-danger" id="delete" class="middle-align"><i
                                                class="fas fa-trash-alt"></i></a>

                                    </td>

                                </tr>
                                {{-- Bidang --}}
                                <div class="modal fade" id="editBidangModal{{ $b->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Bidang</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form role="form" action="{{ route('bidang.update', ['id' => $b->id]) }}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label for="opd_id">Pilih OPD</label>
                                                        <select name="opd_id"
                                                            class="form-control @error('opd') is-invalid @enderror"
                                                            disabled>
                                                            <option value="" disabled>Pilih OPD</option>
                                                            @php
                                                                $opds = App\Models\Opd::all();
                                                            @endphp
                                                            @foreach ($opds as $opd)
                                                                <option value="{{ $opd->id }}"
                                                                    {{ $b->opd_id == $opd->id ? 'selected' : '' }}>
                                                                    {{ $opd->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="text">Nama</label>
                                                        <input type="text" name="name" value="{{ $b->name }}"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            id="text" placeholder="Masukkan Nama Bidang">
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
                        {{ $bidang->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="modal fade" id="addBidangModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Bidang Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" action="{{ route('bidang.insert') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            @if (Auth::user()->role == 1)
                                <select name="opd_id" class="form-control @error('opd_id') is-invalid @enderror"
                                    id="opd_id" readonly hidden>
                                    <option value="">Pilih OPD</option>
                                    @php
                                        $opds = App\Models\Opd::all();
                                    @endphp
                                    @foreach ($opds as $opd)
                                        <option value="{{ $opd->id }}"
                                            {{ Auth::user()->opd_id == $opd->id ? 'selected' : '' }}>
                                            {{ $opd->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('opd')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            @else
                                <label for="opd">Pilih OPD</label>

                                <select name="opd_id" class="form-control @error('opd') is-invalid @enderror" required>
                                    <option value="" selected disabled>Pilih OPD</option>
                                    @php
                                        $opds = App\Models\Opd::all();
                                    @endphp
                                    @foreach ($opds as $opd)
                                        <option value="{{ $opd->id }}">{{ $opd->name }}</option>
                                    @endforeach
                                </select>
                                @error('opd')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="text">Nama</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="text" placeholder="Masukan Nama Bidang" required>
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
