@if ($message = Session::get('success'))
    <script>
        Swal.fire({
            title: 'Sukses!',
            text: '{{ $message }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif


@if ($message = Session::get('error'))
    <script>
        Swal.fire({
            title: 'Gagal',
            text: '{{ $errors->first() }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
@endif


@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($message = Session::get('info'))
    <div class="alert alert-info alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($errors->any())
    <script>
        Swal.fire({
            title: 'Gagal menyimpan data!',
            text: '{{ $errors->first() }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
@endif
