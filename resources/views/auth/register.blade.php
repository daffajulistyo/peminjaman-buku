<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ 'backend/plugins/fontawesome-free/css/all.min.css' }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ 'backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css' }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ 'backend/dist/css/adminlte.min.css' }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo_pasaman.png') }}" />
    <style>
        .logo {
            margin-top: 20px;
            max-width: 140px; /* Sesuaikan ukuran sesuai kebutuhan */
            display: block;
            margin: 20px auto 20px; Menyusun logo ke tengah dan memberi jarak dari teks
        }
    </style>
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><b>Register </b> </a>
                <img src="{{ asset('images/logo_pasaman.png') }}" alt="Your Logo" class="logo">
            </div>
            <div class="card-body">
                <p class="login-box-msg">Register a new membership</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Full name" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input id="email" type="email" placeholder="Email"
                            class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="new-password" placeholder="Password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>


                    <div class="input-group mb-3">
                        <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control"
                            name="password_confirmation" required autocomplete="new-password">


                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <p class="mb-0">
                                {{-- <a href="{{ route('login') }}" class="text-center">Login</a> --}}
                            </p>
                        </div>
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->
    {{-- <p class="login-box-msg m-3" style="color:#808080">Absensi Pegawai Dinas Komunikasi dan Informatika<br>Kabupaten Pasaman <br>&copy2023</p> --}}

    <!-- jQuery -->
    <script src="{{ 'backend/plugins/jquery/jquery.min.js' }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ 'backend/plugins/bootstrap/js/bootstrap.bundle.min.js' }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ 'backend/dist/js/adminlte.min.js' }}"></script>
</body>

</html>
