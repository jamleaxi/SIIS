<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIIS: 401 | Unauthorized Access</title>

    @include('includes.header')

    @livewireStyles
    <style>
        body {
            background-color: #242424;
        }

        .responsive-img {
            max-width: 100%;
            height: auto;
        }

        a {
            color: #fcd34d;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
            color: #fff;
        }
    </style>
</head>
<body class="d-flex flex-column align-items-center text-center p-4">

    <img src="{{ asset('img/alerts/401.gif') }}" class="responsive-img mb-4 mt-5" alt="401 Unauthorized Access" style="max-height: 500px;">

    <h1 class="text-yellow mt-3"><strong>UNAUTHORIZED ACCESS</strong></h1>

    <h5 class="text-teal">User authentication is required.</h5>

    <div class="mt-3">
        <a href="{{ url('/') }}">[ Go Back Home ]</a>
    </div>

    <img src="{{ asset('img/siis-logo.png') }}" class="responsive-img mt-4" style="height: 50px;" alt="SIIS Logo">

</body>
</html>
