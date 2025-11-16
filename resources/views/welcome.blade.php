<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/source-sans.css') }}">
    <title>Welcome to JRMSU SIIS!</title>

    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .background {
            background-image: url('img/Google-Oddfellows.gif');
            background-size: cover;
            background-position: center;
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -3;
        }

        .overlay {
            background-image: url('img/siis-newbg.jpg');
            background-size: cover;
            background-position: center;
            position: fixed;
            width: 100%;
            height: 100%;
            opacity: 0.80;
            z-index: -1;
        }

        .blur {
            position: fixed;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(100px);
            -webkit-backdrop-filter: blur(100px);
            z-index: -2;
        }

        .blur-overlay {
            max-width: 90%;
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 15px;
            padding: 20px;
            color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            margin: 5vh auto;
        }

        .text-center img {
            max-width: 40%;
            height: auto;
        }

        @media (min-width: 576px) {
            .blur-overlay {
                width: 500px;
            }
            .text-center img {
                max-width: 35%;
            }
        }
    </style>
</head>
<body class="login-page bg-body-secondary">
    <div class="background"></div>
    <div class="blur"></div>
    {{-- <div class="overlay"></div> --}}

    <div class="card blur-overlay text-center">
        <div class="text-center">
            <img src="{{ asset('img/JRMSU.png') }}" width="80px" class="mr-3">
            <img src="{{ asset('img/siis-logo.png') }}" width="200px">
        </div>
        <hr>

        @if (Route::has('login'))
            @auth
                <a class="btn bg-yellow w-100" href="{{ url('/home') }}"><b>YOU ARE LOGGED IN</b><br><sub>Continue my session</sub></a>
            @else
                <a class="btn bg-blue w-100" href="{{ route('login') }}"><b>SIGN ME IN</b><br><sub>I have an account</sub></a>

                @if (Route::has('register'))
                    <a class="btn bg-yellow w-100 mt-2" href="{{ route('register') }}"><b>SIGN ME UP</b><br><sub>I want to register</sub></a>
                @endif
            @endauth
        @endif

        <hr>
        <span class="text-blue text-xs">JRMSU SIIS Version 1.0 &copy; 2025</span>
    </div>
</body>
</html>
