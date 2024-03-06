@php
$opds = \App\Models\Opd::all();
$bidangs = \App\Models\Bidang::all();
$jabatans = \App\Models\Jabatan::all();
$pangkats = \App\Models\Pangkat::all();
$eselons = \App\Models\Eselon::all();

@endphp
<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Akun {{ $user->name }}</h5>
            <button type="button" class="close" data-dismiss="modal"
                aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form role="form"
                action="{{ route('user.update', ['id' => $user->id]) }}"
                method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="text">Nama</label>
                                    <input type="text" name="name"
                                        value="{{ $user->name }}"
                                        class="form-control @error('title') is-invalid @enderror"
                                        id="text"
                                        placeholder="Enter User Name">

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">NIP</label>
                                    <input type="text" name="nip"
                                        value="{{ $user->nip }}"
                                        class="form-control @error('title') is-invalid @enderror"
                                        id="exampleInputEmail1"
                                        placeholder="Enter Your NIP">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="eselon_id">Eselon</label>
                                    <select name="eselon_id"
                                        class="form-control @error('eselon_id') is-invalid @enderror"
                                        id="eselon_id">
                                        <option value="">Pilih Eselon
                                        </option>
                                        <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
                                        @foreach ($eselons as $eselon)
                                            <option value="{{ $eselon->id }}"
                                                {{ $eselon->id == old('eselon_id', $user->eselon_id) ? 'selected' : '' }}>
                                                {{ $eselon->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('eselon_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Role</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="role" required>
                                        <option value="" disabled selected>Pilih Role</option>
                                        @if(Auth::user()->role==3)

                                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                                        @endif
                                        <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>User</option>
                                    </select>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label for="text">No HP</label>
                                    <input type="number" name="nohp"
                                        value="{{ $user->nohp }}"
                                        class="form-control @error('title') is-invalid @enderror"
                                        id="text"
                                        placeholder="Enter Your Phone Number    ">

                                    @error('no_hp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Akses</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="akses" required>
                                            <option value="" disabled selected>Hak Akses</option>
                                            <option value="1" {{ $user->akses == 1 ? 'selected' : '' }}>Aplikasi</option>
                                            <option value="2" {{ $user->akses == 2 ? 'selected' : '' }}>Website</option>
                                        </select>
                            </div>
                                
                            </div>

                            <!-- Continue with other form fields for the left column -->
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                @if (Auth::user()->role == 1)
                                <div class="form-group">
                                    <label for="opd_id">OPD</label>
                                    <select name="opd_id" class="form-control @error('opd_id') is-invalid @enderror" id="opd_id" readonly>
                                        <option value="">Pilih OPD</option>
                                        @foreach ($opds as $opd)
                                        <option value="{{ $opd->id }}" 
                                            {{ Auth::user()->opd_id == $opd->id || $opd->id == old('opd_id', $user->opd_id) ? 'selected' : '' }}>
                                        {{ $opd->name }}
                                    </option>
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
                                    <select name="bidang_id"
                                        class="form-control @error('bidang_id') is-invalid @enderror"
                                        id="bidang_id">
                                        <option value="">Pilih Bidang
                                        </option>
                                        <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
                                        @foreach ($bidangs as $bidang)
                                        @if (Auth::user()->opd_id == $bidang->opd_id)

                                            <option value="{{ $bidang->id }}"
                                                {{ $bidang->id == old('bidang_id', $user->bidang_id) ? 'selected' : '' }}>
                                                {{ $bidang->name }}</option>
                                                @endif
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
                                    <select name="jabatan_id"
                                        class="form-control @error('jabatan_id') is-invalid @enderror"
                                        id="jabatan_id">
                                        <option value="">Pilih Jabatan
                                        </option>
                                        <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
                                        @foreach ($jabatans as $jabatan)
                                        @if (Auth::user()->opd_id == $jabatan->opd_id)

                                            <option value="{{ $jabatan->id }}"
                                                {{ $jabatan->id == old('jabatan_id', $user->jabatan_id) ? 'selected' : '' }}>
                                                {{ $jabatan->name }}</option>
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
                                    class="form-control @error('opd_id') is-invalid @enderror"
                                    id="opd_id">
                                        <option value="">Pilih OPD</option>
                                        <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
                                        @foreach ($opds as $opd)
                                            <option value="{{ $opd->id }}"
                                                {{ $opd->id == old('opd_id', $user->opd_id) ? 'selected' : '' }}>
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
                                    <label for="bidang_id">Bidang</label>
                                    <select name="bidang_id"
                                    class="form-control @error('bidang_id') is-invalid @enderror"
                                    id="bidang_id">
                                    <option value="">Pilih Bidang
                                        </option>
                                        <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
                                        @foreach ($bidangs as $bidang)
                                            <option value="{{ $bidang->id }}"
                                                {{ $bidang->id == old('bidang_id', $user->bidang_id) ? 'selected' : '' }}>
                                                {{ $bidang->name }}</option>
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
                                        <select name="jabatan_id"
                                            class="form-control @error('jabatan_id') is-invalid @enderror"
                                            id="jabatan_id">
                                            <option value="">Pilih Jabatan
                                            </option>
                                            <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
                                            @foreach ($jabatans as $jabatan)
                                                <option value="{{ $jabatan->id }}"
                                                    {{ $jabatan->id == old('jabatan_id', $user->jabatan_id) ? 'selected' : '' }}>
                                                    {{ $jabatan->name }}</option>
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
                                        class="form-control @error('pangkat_id') is-invalid @enderror"
                                        id="pangkat_id">
                                        <option value="">Pilih Pangkat
                                        </option>
                                        <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
                                        @foreach ($pangkats as $pangkat)
                                            <option value="{{ $pangkat->id }}"
                                                {{ $pangkat->id == old('pangkat_id', $user->pangkat_id) ? 'selected' : '' }}>
                                                {{ $pangkat->name }}</option>
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
                                    <select class="form-control"
                                        id="exampleFormControlSelect1"
                                        name="status" required>
                                        <option value="">Please Select
                                        </option>
                                        <!-- Opsi kosong jika tidak ada opsi yang dipilih -->
                                        <option value="PNS"
                                            {{ old('status', $user->status) == 'PNS' ? 'selected' : '' }}>
                                            PNS</option>
                                        <option value="PPPK"
                                            {{ old('status', $user->status) == 'PPPK' ? 'selected' : '' }}>
                                            PPPK</option>
                                        <option value="Honor Daerah"
                                            {{ old('status', $user->status) == 'Honor Daerah' ? 'selected' : '' }}>
                                            Honor Daerah
                                        </option>
                                        <option value="Kontrak"
                                            {{ old('status', $user->status) == 'Kontrak' ? 'selected' : '' }}>
                                            Kontrak</option>
                                    </select>

                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Akses Laporan</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="laporan_akses" required>
                                        <option value="" disabled selected>Hak Akses Laporan</option>
                                        <option value="1" {{ $user->laporan_akses == 1 ? 'selected' : '' }}>Iya</option>
                                        <option value="2" {{ $user->laporan_akses == 2 ? 'selected' : '' }}>Tidak</option>
                                        @if(Auth::user()->role==3)
                                        <option value="3" {{ $user->laporan_akses == 3 ? 'selected' : '' }}>Bupati / Sekda</option>
                                        @endif
                                    </select>
                        </div>
                            </div>

                            <!-- Continue with other form fields for the right column -->
                        </div>
                           
                        
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">Tutup</button>

                </div>
            </form>
        </div>
    </div>
</div>
</div>