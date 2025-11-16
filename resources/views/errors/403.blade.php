<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIIS: 403 | Forbidden</title>

    @include('includes.header')

    @livewireStyles
    <style>
        body {
            background-color: #fec844;
        }

        .responsive-img {
            max-width: 100%;
            height: auto;
        }

        a {
            color: #fc594d;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
            color: #000000;
        }
    </style>
</head>
<body class="d-flex flex-column align-items-center text-center p-4">

    <img src="{{ asset('img/alerts/403.gif') }}" class="responsive-img mb-4 mt-5" alt="403 Forbidden" style="max-height: 500px;">

    <h1 class="text-danger mt-3"><strong>FORBIDDEN</strong></h1>

    <h5 class="text-dark">You don't have permission to access this resource.</h5>

    <div class="mt-3">
        <a href="{{ url('/') }}">[ Go Back Home ]</a>
    </div>

    <img src="{{ asset('img/siis-logo.png') }}" class="responsive-img mt-4" style="height: 50px;" alt="SIIS Logo">

</body>
</html>
