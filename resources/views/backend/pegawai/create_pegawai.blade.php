@extends('backend.layouts.app')
@section('content')
    <div class="card-body">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Akun Pegawai</h3>
                    </div>
                    <form role="form" action="{{ route('user.insert') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="text">Name</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="text" placeholder="Enter Your Name" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="text">Nip</label>
                                        <input type="number" name="nip" class="form-control @error('nip') is-invalid @enderror" id="text" placeholder="Enter Your Nip">
                                        @error('nip')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" placeholder="Enter Your Email" required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Password</label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputEmail1" placeholder="Enter Password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <!-- Add other left column form fields here -->
                                    <div class="form-group">
                                        <label for="text">No HP</label>
                                        <input type="number" name="nohp" class="form-control @error('nohp') is-invalid @enderror" id="text" placeholder="Enter Your Phone Number">
                                        @error('nohp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Right Column -->
                                <div class="col-md-6">
                                    

                                    <div class="form-group">
                                        <label for="opd_id">OPD</label>
                                        <select name="opd_id" class="form-control @error('opd_id') is-invalid @enderror" id="opd_id">
                                            <option value="">Pilih OPD</option>
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
                                        <label for="bidang_id">Bidang</label>
                                        <select name="bidang_id" class="form-control @error('bidang_id') is-invalid @enderror" id="bidang_id">
                                            <option value="">Pilih Bidang</option>
                                            @foreach ($bidangs as $bidang)
                                                <option value="{{ $bidang->id }}">{{ $bidang->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('bidang_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="jabatan_id">Jabatan</label>
                                        <select name="jabatan_id" class="form-control @error('jabatan_id') is-invalid @enderror" id="jabatan_id">
                                            <option value="">Pilih Jabatan</option>
                                            @foreach ($jabatans as $jabatan)
                                                <option value="{{ $jabatan->id }}">{{ $jabatan->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('jabatan_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="pangkat_id">Pangkat</label>
                                        <select name="pangkat_id" class="form-control @error('pangkat_id') is-invalid @enderror" id="pangkat_id">
                                            <option value="">Pilih Pangkat</option>
                                            @foreach ($pangkats as $pangkat)
                                                <option value="{{ $pangkat->id }}">{{ $pangkat->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('pangkat_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="exampleFormControlSelect1" name="status" required>
                                            <option value="PNS">PNS</option>
                                            <option value="PPPK">PPPK</option>
                                            <option value="Honor Daerah">Honor Daerah</option>
                                            <option value="Kontrak">Kontrak</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Submit</button>
                            <a href="{{ route('user.index') }}" class="btn btn-dark">Back</a>

                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-2"></div>
        </div>
        <!-- /.row -->
    </div>

    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image')
                        .attr('src', e.target.result)
                        .width(80)
                        .height(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
