<div class="modal fade" id="addJabatanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jabatan Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" action="{{ route('jabatan.insert') }}" method="post" enctype="multipart/form-data">
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