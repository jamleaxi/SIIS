<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIIS: 419 | Page Expired</title>

    @include('includes.header')

    @livewireStyles
    <style>
        body {
            background-color: #ece5dc;
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

    <img src="{{ asset('img/alerts/419.gif') }}" class="responsive-img mb-4 mt-5" alt="419 Page Expired" style="max-height: 500px;">

    <h1 class="text-dark mt-3"><strong>PAGE EXPIRED</strong></h1>

    <h5 class="text-red">Your session has timed out.</h5>

    <div class="mt-3">
        <a href="{{ url('/') }}">[ Sign In Again ]</a>
    </div>

    <img src="{{ asset('img/siis-logo.png') }}" class="responsive-img mt-4" style="height: 50px;" alt="SIIS Logo">

</body>
</html>
