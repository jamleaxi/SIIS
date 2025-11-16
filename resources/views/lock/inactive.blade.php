<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIIS Account | Deactivated</title>

    @include('includes.header')

    @livewireStyles
    <style>
        .mybtl {
            color: yellow;
        }

        .mybtl:hover {
            color: white;
            text-decoration: underline;
        }

        body {
            background-color: #eb5240;
        }

        .responsive-img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body class="d-flex flex-column align-items-center text-center p-4">

    <img src="{{ asset('img/alerts/lock.gif') }}" class="responsive-img mb-4" alt="Account Locked" style="display:block; margin-left:auto; margin-right:auto;" class="mt-5" height="600px">

    <h1 class="text-light">ACCOUNT SUSPENDED</h1>

    <h5 class="text-light mb-4">
        Your account has been deactivated.<br>
        Please contact the account administrator for reactivation.
    </h5>

    <hr class="w-100">

    <a class="btn btn-link mybtl" href="/">
        <i class="fas fa-home mr-2"></i>Go Back Home
    </a>

    <hr class="w-100">

    <img src="{{ asset('img/siis-logo.png') }}" class="responsive-img" style="height: 50px;" alt="SIIS Logo">

</body>
</html>
