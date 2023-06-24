@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header info">
                    <h3 class="card-title">Daftar Pengajuan Peminjaman Buku</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Anggota</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Tanggal Pengembalian</th>
                                <th>Status</th>
                                @if (Auth::user()->role == 1)
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loanRequests as $loan)
                                <tr>
                                    <td>{{ $loan->user->name }}</td>
                                    <td>{{ $loan->book->judul_buku }}</td>
                                    <td>{{ $loan->tanggal_peminjaman }}</td>
                                    <td>{{ $loan->tanggal_pengembalian }}</td>
                                    <td>
                                        @if ($loan->approved)
                                            Diterima
                                        @elseif (!$loan->approved)
                                            Ditolak
                                        @else
                                            Menunggu
                                        @endif
                                    </td>
                                    @if (Auth::user()->role == 1)
                                        <td>
                                            @if (!$loan->approved)
                                                <form action="{{ route('loan-requests.approve', $loan->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                                </form>
                                            @endif
                                            <form action="{{ route('loan-requests.reject', $loan->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
