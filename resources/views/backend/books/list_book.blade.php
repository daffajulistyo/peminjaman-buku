@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header info">
                    <h3 class="card-title">Book Category List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (Auth::user()->role == 1)
                        <a href="{{ route('book.show') }}" class="btn btn-mm btn-info mb-2">+ Tambah Buku</a>
                    @endif
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Buku</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Tahun Terbit</th>
                                <th>Stok</th>
                                @if (Auth::user()->role == 1)
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>

                            @foreach ($books as $book)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $book->kode_buku }}</td>
                                    <td>{{ $book->judul_buku }}</td>
                                    <td>{{ $book->penulis }}</td>
                                    <td>{{ $book->tahun_terbit }}</td>
                                    <td>{{ $book->stok }}</td>
                                    @if (Auth::user()->role == 1)
                                        <td>
                                            <a href="{{ URL::to('book/edit_book/' . $book->id) }}"
                                                class="btn btn-sm btn-info">Edit</a>
                                            <a href="{{ URL::to('book/delete_book/' . $book->id) }}"
                                                class="btn btn-sm btn-danger" id="delete" class="middle-align">Delete</a>

                                        </td>
                                    @endif
                                    </td>
                                </tr>
                                <?php $no++; ?>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
