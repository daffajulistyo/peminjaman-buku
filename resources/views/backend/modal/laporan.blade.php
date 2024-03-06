<!-- resources/views/backend/modal/laporan.blade.php -->
<div class="modal fade" id="cetakModal{{ $userId }}" tabindex="-1" role="dialog" aria-labelledby="cetakModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cetakModalLabel">Form Cetak Laporan - {{ $userName }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('report.bkpsdm', ['userId' => $userId]) }}" method="get">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $userId }}">

                    <div class="form-group">
                        <label for="opd">OPD</label>
                        <input type="text" class="form-control" id="opd" name="opd" value="{{ $userOPDName }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama Pegawai</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $userName }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_selesai">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                    </div>

                    <button type="submit" class="btn btn-success"><i class="fas fa-print"></i> Tampilkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

