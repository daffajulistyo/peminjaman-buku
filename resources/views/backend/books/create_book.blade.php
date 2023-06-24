@extends('backend.layouts.app')
@section('content')
    <div class="card-body">
        <div class="row">

            <div class="col-md-2">

            </div>
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Book</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('book.insert') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">


                            <div class="form-group">
                                <label for="text">Kode Buku</label>
                                <input type="text" name="kode_buku"
                                    class="form-control @error('title') is-invalid @enderror" id="text"
                                    placeholder="Enter Book Code">

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="text">Judul Buku</label>
                                <input type="text" name="judul_buku"
                                    class="form-control @error('title') is-invalid @enderror" id="text"
                                    placeholder="Enter Book Title">

                                @error('judul_buku')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="text">Penulis</label>
                                <input type="text" name="penulis"
                                    class="form-control @error('title') is-invalid @enderror" id="text"
                                    placeholder="Enter Author">

                                @error('penulis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="text">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit"
                                    class="form-control @error('title') is-invalid @enderror" id="text"
                                    placeholder="Enter Year">

                                @error('tahun_terbit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="text">Stok</label>
                                <input type="number" name="stok"
                                    class="form-control @error('title') is-invalid @enderror" id="text"
                                    placeholder="Enter Stock">

                                @error('stok')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>



                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
