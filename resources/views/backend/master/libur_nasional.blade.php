@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <form method="POST" action="{{ route('libur.insert') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <label for="tanggal">Pilih Tanggal </label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ml-3">
                                    <input class="form-control" type="date" name="tanggal"
                                        placeholder="Contoh: 2001-07-01" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <label for="keterangan">Keterangan</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ml-3">
                                    <textarea class="form-control" name="keterangan" rows="2" placeholder="Keterangan Libur Nasional" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-6 ml-3">
                                <button type="submit" class="btn btn-primary">
                                    Tambahkan</button>
                            </div>
                        </div>
                    </div>
                </form>
                <form method="GET" action="{{ route('libur.index') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <label for="tanggal">Pilih Bulan </label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ml-3">
                                    <input class="form-control" type="month" name="bulan" value="{{ request('bulan') }}">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-6 ml-3">
                                <button type="submit" class="btn btn-danger"><i class="fas fa-search"></i>
                                    Filter</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">

                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($liburNasionals as $libur)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $libur->tanggal }}</td>
                                    <td>{{ $libur->keterangan }}</td>
                                    <td>
                                        <a href="{{ route('libur.delete', ['id' => $libur->id]) }}"
                                            class="btn btn-sm btn-danger" id="delete" class="middle-align">
                                            <i class="fas fa-trash-alt"></i> &nbsp; Hapus
                                        </a>
                                    </td>
                                </tr>


                                <?php $no++; ?>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
