<div class="modal fade" id="absenModal" tabindex="-1" role="dialog"
                            aria-labelledby="dinasModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="dinasModalLabel">Input Presensi Pegawai </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('simpan-absen') }}">
                                            @csrf
                                            <div class="form-group" hidden>
                                                <label for="opd">Nama OPD</label>
                                                <input type="text" class="form-control" id="opd" name="opd"
                                                    value="{{ Auth::user()->opd->name }}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="user_id">Nama Pegawai</label>
                                                <select class="form-control" name="user_id" required>
                                                    <option value="" disabled selected>Pilih Pegawai</option>
                                                    @php
                                                        $users = \App\Models\User::where('opd_id', Auth::user()->opd_id)
                                                            ->where('role', 2)
                                                            ->get();
                                                    @endphp
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">
                                                            {{ $user->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="tanggal">Tanggal</label>
                                                <input class="form-control" type="date" name="tanggal" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="jam_masuk">Jam Masuk</label>
                                                <input class="form-control" type="time" name="jam_masuk" required
                                                    step="1">
                                            </div>
                                            <div class="form-group">
                                                <label hidden for="jam_keluar">Jam Pulang</label>
                                                <input hidden class="form-control" type="time" name="jam_keluar"
                                                    step="1">
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