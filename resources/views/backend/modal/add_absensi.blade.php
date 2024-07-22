<div class="modal fade" id="absenModal" role="dialog" aria-labelledby="dinasModalLabel" aria-hidden="true">
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
                    <input type="hidden" name="opd_id" value="{{ Auth::user()->opd_id }}">
                    <input type="hidden" name="jabatan_id" id="jabatan_id" value="">

                    <div class="form-group" hidden>
                        <label for="opd">Nama OPD</label>
                        <input type="text" class="form-control" id="opd" name="opd"
                            value="{{ Auth::user()->opd->name }}" disabled>
                    </div>
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
                            <option value="{{ $user->id }}" data-jabatan-id="{{ $user->jabatan_id }}">
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @php
                        $today = \Carbon\Carbon::today();

                        // Mendapatkan hari Senin pada minggu ini
                        $startOfWeek = $today->copy()->startOfWeek(\Carbon\Carbon::MONDAY);

                        // Mendapatkan tanggal dalam format YYYY-MM-DD
                        $startOfWeekDate = $startOfWeek->toDateString();
                        $todayDate = $today->toDateString();
                    @endphp
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input class="form-control" type="date" name="tanggal" required min="{{ $startOfWeekDate }}"
                            max="{{ $todayDate }}">
                    </div>
                    <div class="form-group">
                        <label for="jam_masuk">Jam Masuk</label>
                        <input class="form-control" type="time" name="jam_masuk" required step="1">
                    </div>
                    <div class="form-group">
                        <label hidden for="jam_keluar">Jam Pulang</label>
                        <input hidden class="form-control" type="time" name="jam_keluar" step="1">
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
<script>
    // Script to set the selected user's jabatan_id when user changes
    document.getElementById('user_id').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var jabatanId = selectedOption.getAttribute('data-jabatan-id');
        document.getElementById('jabatan_id').value = jabatanId;
    });
</script>
