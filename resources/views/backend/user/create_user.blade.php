@extends('backend.layouts.app')
@section('content')
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Add User</h3>
                    </div>
                    <form role="form" action="{{ route('user.insert') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="text">Nama</label>
                                <input type="text" name="nama"
                                    class="form-control @error('title') is-invalid @enderror" id="text"
                                    placeholder="Enter Your Name">

                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="text" name="email"
                                    class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1"
                                    placeholder="Enter Your Email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1"
                                    placeholder="Enter Password">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">NIP</label>
                                <input type="text" name="nip"
                                    class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1"
                                    placeholder="Enter Your NIP">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="opd_id">OPD</label>
                                <select name="opd_id" class="form-control @error('opd_id') is-invalid @enderror" id="opd_id">
                                    <option value="">Pilih OPD</option> <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
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
                                    <option value="">Pilih Bidang</option> <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
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
                                    <option value="">Pilih Jabatan</option> <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
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
                                    <option value="">Pilih Pangkat</option> <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
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
                                <select class="form-control" id="exampleFormControlSelect1" name="status" required>
                                    <option required> Please Select </option>
                                    <option value="PNS">PNS </option>
                                    <option value="PPPK">PPPK </option>
                                    <option value="Honor Daerah">Honor Daerah </option>
                                    <option value="Kontrak">Kontrak </option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                <label for="text">Status</label>
                                <input type="text" name="nama"
                                    class="form-control @error('title') is-invalid @enderror" id="text"
                                    placeholder="Enter Your Name">

                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}
                            <div class="form-group">
                                <label for="text">No HP</label>
                                <input type="text" name="no_hp"
                                    class="form-control @error('title') is-invalid @enderror" id="text"
                                    placeholder="Enter Your Name">

                                @error('no_hp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Submit</button>
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
