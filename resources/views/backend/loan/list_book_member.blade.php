@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header info">
                    <h3 class="card-title">List Peminjaman Buku</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Judul Buku</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Tanggal Pengembalian</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loanRequests as $loanRequest)
                                <tr>
                                    <td>{{ $loanRequest->book->judul_buku }}</td>
                                    <td>{{ $loanRequest->tanggal_peminjaman }}</td>
                                    <td>{{ $loanRequest->tanggal_pengembalian }}</td>
                                    <td>{{ ucfirst($loanRequest->status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
