<div class="modal fade" id="addTBModal" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tugas Belajar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" action="{{ route('tugas.insert') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="user_id">Nama Pegawai</label>
                            <select class="form-control select2" name="user_id" style="width: 100%;" required>
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
                            <label for="tanggal">Tanggal Mulai</label>
                            <input class="form-control" type="date" name="tanggal_mulai" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal Selesai</label>
                            <input class="form-control" type="date" name="tanggal_selesai" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan" class="mr-2">Keterangan:</label>
                            <textarea class="form-control" name="keterangan" rows="5" placeholder="Tugas Belajar..." required></textarea>
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
