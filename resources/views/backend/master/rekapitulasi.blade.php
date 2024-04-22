<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPON - Rekapitulasi Kehadiran Pegawai</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo_pasaman.png') }}" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        h2 {
            font-family: 'Source Sans Pro', sans-serif;

        }
    </style>
</head>

<body>
    <div class="container py-5">
        <h1 class="text-center">REKAPITULASI KEHADIRAN PEGAWAI</h1>
        <h5 class="text-center text-uppercase">Pemerintah Kabupaten Pasaman</h5>
        <div class="row row-cols-1 row-cols-md-3 g-4 py-5 m-2">
            @foreach ($opds as $opd)
                <div class="col">
                    <div class="card border border-success shadow-0">
                        <div class="card-header">Kabupaten Pasaman</div>
                        <div class="card-body">
                            <h5 class="card-title text-uppercase">{{ $opd->name }}</h5>
                            <a class="btn btn-success" href="{{ route('rekap.user', ['opdId' => $opd->id]) }}">Tampilkan</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
