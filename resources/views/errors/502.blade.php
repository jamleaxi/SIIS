<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIIS: 502 | Bad Gateway</title>

    @include('includes.header')

    @livewireStyles
    <style>
        body {
            background-color: #3e3a61;
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

    <img src="{{ asset('img/alerts/502.gif') }}" class="responsive-img mb-4 mt-5" alt="502 Bad Gateway" style="max-height: 500px;">

    <h1 class="text-yellow mt-3"><strong>BAD GATEWAY</strong></h1>

    <h5 class="text-teal">Invalid response from upstream server. Please contact your administrator.</h5>

    <!-- <div class="mt-3">
        <a href="{{ url('/') }}">[ Go Back Home ]</a>
    </div> -->

    <img src="{{ asset('img/siis-logo.png') }}" class="responsive-img mt-4" style="height: 50px;" alt="SIIS Logo">

</body>
</html>
