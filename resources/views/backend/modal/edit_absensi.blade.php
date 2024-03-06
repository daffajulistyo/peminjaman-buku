<div class="modal fade" id="editAbsensiModal{{ $absensi->id }}" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Presensi </h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form"
                action="{{ route('absensi.update', ['id' => $absensi->id]) }}"
                method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group" hidden>
                        <label for="user_id">Nama Pegawai</label>
                        @php
                            $users = \App\Models\User::all();
                            $selectedUserId = $absensi->user_id;
                        @endphp

                        <select class="form-control" name="user_id" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ $user->id == $selectedUserId ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group" hidden>
                        <label for="text">Tanggal</label>
                        <input type="date" name="tanggal"
                            value="{{ $absensi->tanggal }}"
                            class="form-control @error('tanggal') is-invalid @enderror">
                        @error('tanggal')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jam_masuk">Jam Masuk</label>
                        <input class="form-control" type="time" name="jam_masuk"
                            required step="1" value="{{ $absensi->jam_masuk }}">
                    </div>
                    <div class="form-group">
                        <label for="jam_keluar">Jam Pulang</label>
                        <input class="form-control" type="time" name="jam_keluar"
                            step="1" value="{{ $absensi->jam_keluar }}">
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