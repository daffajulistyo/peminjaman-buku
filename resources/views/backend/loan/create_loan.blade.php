@extends('backend.layouts.app')
@section('content')
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Pengajuan Peminjaman</h3>
                    </div>
                    <form role="form" action="{{ route('request.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">

                            {{-- <div class="form-group">
                                <label for="user_id">Anggota:</label>
                                <select name="user_id" id="exampleFormControlSelect1" class="form-control" required>
                                    <option value="">Pilih Anggota</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="form-group">
                                <label for="book_id">Buku:</label>
                                <select name="book_id" id="book_id" class="form-control" required>
                                    <option value="">Pilih Buku</option>
                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}">{{ $book->judul_buku }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_peminjaman">Tanggal Peminjaman</label>
                                <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman"
                                    class="form-control">
                                @error('tanggal_peminjaman')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                                <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian"
                                    class="form-control">
                                @error('tanggal_pengembalian')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Ajukan Peminjaman</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-2">
            </div>
        </div>
        <!-- /.row -->
    </div>

    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image')
                        .attr('src', e.target.result)
                        .width(80)
                        .height(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
