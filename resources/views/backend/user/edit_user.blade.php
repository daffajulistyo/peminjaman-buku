@extends('backend.layouts.app')
@section('content')
    <div class="card-body">
        <div class="row">

            <div class="col-md-2">

            </div>
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit User for {{ $user->name }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('user.update', ['id' => $user->id]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="text">Nama</label>
                                <input type="text" name="name" value="{{ $user->name }}"
                                    class="form-control @error('title') is-invalid @enderror" id="text"
                                    placeholder="Enter User Name">

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">NIP</label>
                                <input type="number" name="nip" value="{{ $user->nip }}"
                                    class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1"
                                    placeholder="Enter Your NIP">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" value="{{ $user->email }}"
                                    class="form-control @error('title') is-invalid @enderror" id="text"
                                    placeholder="Enter Your Email">

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                @php
                                    if ($user->role == 1) {
                                        echo 'Present Permission is : <b>Admin</b>';
                                    }
                                    if ($user->role == 2) {
                                        echo 'Present Permission is : <b>User</b>';
                                    }
                                @endphp
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Change the Permission</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="role" required>
                                    <option required> Please Select </option>
                                    <option value="1">Admin </option>
                                    <option value="2">User </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="opd_id">OPD</label>
                                <select name="opd_id" class="form-control @error('opd_id') is-invalid @enderror" id="opd_id">
                                    <option value="">Pilih OPD</option> <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
                                    @foreach ($opds as $opd)
                                        <option value="{{ $opd->id }}" {{ $opd->id == old('opd_id', $user->opd_id) ? 'selected' : '' }}>{{ $opd->name }}</option>
                                    @endforeach
                                </select>
                            
                                @error('opd_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="bidang_id">Bidang</label>
                                <select name="bidang_id" class="form-control @error('bidang_id') is-invalid @enderror" id="bidang_id">
                                    <option value="">Pilih Bidang</option> <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
                                    @foreach ($bidangs as $bidang)
                                        <option value="{{ $bidang->id }}" {{ $bidang->id == old('bidang_id', $user->bidang_id) ? 'selected' : '' }}>{{ $bidang->name }}</option>
                                    @endforeach
                                </select>
                            
                                @error('bidang_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="pangkat_id">Pangkat</label>
                                <select name="pangkat_id" class="form-control @error('pangkat_id') is-invalid @enderror" id="pangkat_id">
                                    <option value="">Pilih Pangkat</option> <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
                                    @foreach ($pangkats as $pangkat)
                                        <option value="{{ $pangkat->id }}" {{ $pangkat->id == old('pangkat_id', $user->pangkat_id) ? 'selected' : '' }}>{{ $pangkat->name }}</option>
                                    @endforeach
                                </select>
                            
                                @error('pangkat_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="jabatan_id">Jabatan</label>
                                <select name="jabatan_id" class="form-control @error('jabatan_id') is-invalid @enderror" id="jabatan_id">
                                    <option value="">Pilih Jabatan</option> <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
                                    @foreach ($jabatans as $jabatan)
                                        <option value="{{ $jabatan->id }}" {{ $jabatan->id == old('jabatan_id', $user->jabatan_id) ? 'selected' : '' }}>{{ $jabatan->name }}</option>
                                    @endforeach
                                </select>
                            
                                @error('jabatan_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                                                                                    
                            
                            <div class="form-group">
                                <label for="exampleInputEmail1">Status</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="status" required>
                                    <option value="">Please Select</option> <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
                                    <option value="PNS" {{ old('status', $user->status) == 'PNS' ? 'selected' : '' }}>PNS</option>
                                    <option value="PPPK" {{ old('status', $user->status) == 'PPPK' ? 'selected' : '' }}>PPPK</option>
                                    <option value="Honor Daerah" {{ old('status', $user->status) == 'Honor Daerah' ? 'selected' : '' }}>Honor Daerah</option>
                                    <option value="Kontrak" {{ old('status', $user->status) == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                </select>
                                
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="text">No HP</label>
                                <input type="number" name="nohp"
                                    class="form-control @error('title') is-invalid @enderror" id="text"
                                    placeholder="Enter Your Phone Number    ">

                                @error('no_hp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-2">
            </div>
        </div>
        <!-- /.row -->
    </div>
@endsection
