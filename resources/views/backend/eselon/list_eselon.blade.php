@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header info">
                    <h3 class="card-title">Daftar Eselon</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a href="#" class="btn btn-mm btn-info mb-4" data-toggle="modal" data-target="#addEselonModal">+
                        Tambah Eselon</a>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($eselon as $eselon)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $eselon->name }}</td>

                                    <td>
                                        <a href="{{ route('eselon.delete', ['id' => $eselon->id]) }}"
                                            class="btn btn-sm btn-danger" id="delete" class="middle-align"><i
                                                class="fas fa-trash-alt"></i></a>

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    @include('backend.modal.add_eselon');
@endsection
