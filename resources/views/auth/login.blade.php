<!DOCTYPE html>
<html>

<head>
    <title>Login Sipon</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('rlf/css/style.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo_pasaman.png') }}" />

    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body>
    <img class="wave" src="{{ asset('rlf/img/wave.png') }}">
    <div class="container">
        <div class="img">
            <img src="{{ asset("images/cover_web_bupati.png") }}">
        </div>
        <div class="login-content">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <img src="{{ asset('images/logo_pasaman.png') }}">
                <h2 class="title">Login</h2>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Username</h5>
                        <input type="text" class="input" name="email" required>
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Password</h5>
                        <input type="password" class="input" name="password" required>
                    </div>
                </div>
                <a href="#">Forgot Password?</a>
                <input type="submit" class="btn" value="Login">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('rlf/js/main.js') }}"></script>
</body>

</html>
