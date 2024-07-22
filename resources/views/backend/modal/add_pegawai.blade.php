<div class="modal fade" id="addPegawaiModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:hidden;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambahkan Akun Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" action="{{ route('user.insert') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text">Name</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" id="text"
                                        placeholder="Masukkan Nama" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="text">Nip</label>
                                    <input type="number" name="nip"
                                        class="form-control @error('nip') is-invalid @enderror" id="text"
                                        placeholder="Masukan NIP / NIK">
                                    @error('nip')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @php
                                    $eselon = \App\Models\Eselon::all();
                                @endphp
                                <div class="form-group">
                                    <label for="eselon_id">Eselon</label>
                                    <select name="eselon_id"
                                        class="form-control select2 @error('eselon_id') is-invalid @enderror"
                                        style="width: 100%" id="eselon_id">
                                        <option value="">Pilih Eselon</option>
                                        @foreach ($eselon as $e)
                                            <option value="{{ $e->id }}">{{ $e->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('eselon_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Password</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        id="exampleInputEmail1" placeholder="Enter Password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                            <!-- Right Column -->
                            <div class="col-md-6">

                                @php
                                    $opds = \App\Models\Opd::all();
                                    $bidangs = \App\Models\Bidang::all();
                                    $jabatans = \App\Models\Jabatan::all();
                                    $pangkats = \App\Models\Pangkat::all();
                                @endphp
                                @if (Auth::user()->role == 1)
                                    <div class="form-group">
                                        <label for="opd_id">OPD</label>
                                        <input type="text" class="form-control" value="{{ Auth::user()->opd->name }}"
                                            disabled>
                                        <input type="hidden" name="opd_id" value="{{ Auth::user()->opd_id }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="jabatan_id">Jabatan</label>
                                        <select name="jabatan_id"
                                            class="form-control select2 @error('jabatan_id') is-invalid @enderror"
                                            style="width: 100%;" id="jabatan_id">
                                            <option value="">Pilih Jabatan</option>
                                            @foreach ($jabatans as $jabatan)
                                                @if (Auth::user()->opd_id == $jabatan->opd_id)
                                                    <option value="{{ $jabatan->id }}">{{ $jabatan->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('jabatan_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label for="opd_id">OPD</label>
                                        <select name="opd_id"
                                            class="form-control select2 @error('opd_id') is-invalid @enderror"
                                            id="opd_id" style="width: 100%">
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
                                        <label for="jabatan_id">Jabatan</label>
                                        <select name="jabatan_id"
                                            class="form-control select2 @error('jabatan_id') is-invalid @enderror"
                                            id="jabatan_id" style="width: 100%">
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
                                @endif

                                <div class="form-group">
                                    <label for="pangkat_id">Pangkat</label>
                                    <select name="pangkat_id"
                                        class="form-control select2 @error('pangkat_id') is-invalid @enderror"
                                        style="width: 100%" id="pangkat_id">
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
                                    <select class="form-control @error('status') is-invalid @enderror"
                                        id="exampleFormControlSelect1" name="status" required>
                                        <option value="PNS">PNS</option>
                                        <option value="PPPK">PPPK</option>
                                        <option value="Honor Daerah">Honor Daerah</option>
                                        <option value="Kontrak">Kontrak</option>
                                        <option value="Suspend">Suspend</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col">
                                <label for="exampleInputEmail1">Jenis Kelamin</label>
                                <select class="form-control @error('jk') is-invalid @enderror"
                                    id="exampleFormControlSelect1" name="jk" required>
                                    <option value="Lk">Laki Laki</option>
                                    <option value="Pr">Perempuan</option>
                                </select>
                                @error('jk')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var select_jabatan = documen.querySelector('#jabatan_id');
    dselect(select_jabatan, {
        search: true,
    })
</script>
