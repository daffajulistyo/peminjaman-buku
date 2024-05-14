@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header info">
                    <h3 class="card-title">Daftar Koordinat</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a href="" class="btn btn-mm btn-info mr-2" data-toggle="modal"
                            data-target="#addKoordinatModal">+ Tambah Koordinat Kantor</a>
                        @php
                            $coordinate = App\Models\AktifKoordinat::latest()->first();
                            $isActive = $coordinate->active;
                        @endphp

                        <form action="{{ route('toggle.koordinat') }}" method="POST">
                            @csrf <!-- Tambahkan token CSRF untuk keamanan -->
                            <div class="input-group">
                                <input type="text" class="form-control" readonly value="Presensi Kantor Bupati"
                                    aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <button type="submit"
                                        class="btn @if ($isActive) btn-success @else btn-danger @endif">
                                        <i class="fa fa-power-off" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </form>



                    </div>

                    <form action="{{ route('koordinat.index') }}" method="GET" class="mb-2">
                        <div class="row justify-content-end mt-4">
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
                                <th>Nama OPD</th>
                                <th>Alamat</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Kecamatan</th>
                                <th>Jarak</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($koordinat as $key => $lokasi)
                                <tr>
                                    <td>{{ $koordinat->firstItem() + $key }}</td>
                                    <td>{{ $lokasi->opd ? $lokasi->opd->name : '-' }}</td>
                                    <td>{{ $lokasi->alamat }} </td>
                                    <td>{{ $lokasi->latitude }} </td>
                                    <td>{{ $lokasi->longitude }} </td>
                                    <td>{{ $lokasi->kecamatan ?? '-' }} </td>
                                    <td>{{ $lokasi->radius }} M </td>

                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">

                                            <a href="{{ route('koordinat.edit', ['id' => $lokasi->id]) }}"
                                                class="btn btn-sm btn-info" data-toggle="modal"
                                                data-target="#editKoordinatModal{{ $lokasi->id }}"><i
                                                    class="fas fa-edit"></i></a>
                                            <a href="{{ route('koordinat.delete', ['id' => $lokasi->id]) }}"
                                                class="btn btn-sm btn-danger" id="delete" class="middle-align"><i
                                                    class="fas fa-trash-alt"></i></a>
                                        </div>

                                    </td>
                                </tr>
                                <div class="modal fade" id="editKoordinatModal{{ $lokasi->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Koordinat OPD</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form role="form"
                                                action="{{ route('koordinat.update', ['id' => $lokasi->id]) }}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="opd_id">OPD</label>
                                                        <select name="opd_id"
                                                            class="form-control @error('opd_id') is-invalid @enderror"
                                                            id="opd_id">
                                                            <option value="">Pilih OPD</option>
                                                            @php
                                                                $opds = App\Models\OPD::all();
                                                            @endphp
                                                            @foreach ($opds as $opd)
                                                                <option value="{{ $opd->id }}"
                                                                    {{ $opd->id == old('opd_id', $lokasi->opd_id) ? 'selected' : '' }}>
                                                                    {{ $opd->name }}</option>
                                                            @endforeach
                                                        </select>

                                                        @error('opd_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="text">Alamat</label>
                                                        <textarea class="form-control" name="alamat" rows="3" placeholder="Masukkan Alamat" required>{{ $lokasi->alamat }}</textarea>


                                                        @error('alamat')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="text">Kecamatan</label>
                                                        <input type="text" step="any" name="kecamatan"
                                                            value="{{ $lokasi->kecamatan }}"
                                                            class="form-control @error('title') is-invalid @enderror"
                                                            id="text" placeholder="Masukan Kecamatan">

                                                        @error('kecamatan')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="text">Latitude</label>
                                                        <input type="number" step="any" name="latitude"
                                                            value="{{ $lokasi->latitude }}"
                                                            class="form-control @error('title') is-invalid @enderror"
                                                            id="text" placeholder="Enter Your text">

                                                        @error('latitude')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="text">Longitude</label>
                                                        <input type="number" step="any" name="longitude"
                                                            value="{{ $lokasi->longitude }}"
                                                            class="form-control @error('title') is-invalid @enderror"
                                                            id="text" placeholder="Enter Your text">

                                                        @error('longitude')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="text">Radius</label>
                                                        <input type="number" step="any" name="radius"
                                                            value="{{ $lokasi->radius }}"
                                                            class="form-control @error('title') is-invalid @enderror"
                                                            id="text" placeholder="Enter Your text">

                                                        @error('radius')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
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
                        {{ $koordinat->links() }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

    </div>

    <div class="modal fade" id="addKoordinatModal" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Koordinat OPD</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" action="{{ route('koordinat.insert') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @php
                            $opds = \App\Models\Opd::all();

                        @endphp
                        <div class="form-group">
                            <label for="opd_id">OPD</label>
                            <select name="opd_id" class="form-control select2 @error('opd_id') is-invalid @enderror"
                                style="width: 100%;" id="opd_id">
                                <option value="">Pilih OPD</option>
                                <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
                                @foreach ($opds as $opd)
                                    <option value="{{ $opd->id }}">{{ $opd->name }}</option>
                                @endforeach
                            </select>

                            @error('opd_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="text">Alamat</label>
                            {{-- <input type="text" name="alamat"
                                class="form-control @error('title') is-invalid @enderror" id="text"
                                placeholder="Masukkan Alamat"> --}}
                            <textarea class="form-control" name="alamat" rows="3" placeholder="Masukkan Alamat" required></textarea>
                            @error('alamat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="text">Kecamatan</label>
                            <input type="text" step="any" name="kecamatan"
                                class="form-control @error('title') is-invalid @enderror" id="text"
                                placeholder="Masukkan kecamatan">

                            @error('kecamatan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="text">Latitude</label>
                            <input type="number" step="any" name="latitude"
                                class="form-control @error('title') is-invalid @enderror" id="text"
                                placeholder="Masukkan Latitude">

                            @error('latitude')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="text">Longitude</label>
                            <input type="number" step="any" name="longitude"
                                class="form-control @error('title') is-invalid @enderror" id="text"
                                placeholder="Masukkan Longitude">

                            @error('longitude')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="text">Radius</label>
                            <input type="number" step="any" name="radius"
                                class="form-control @error('title') is-invalid @enderror" id="text"
                                placeholder="Masukkan Radius Lokasi Presensi" maxlength="10">

                            @error('radius')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
