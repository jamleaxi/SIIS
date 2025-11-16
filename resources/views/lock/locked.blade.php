<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIIS Account | On Hold</title>

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
            background-color: #16709f;
        }

        .responsive-img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body class="d-flex flex-column align-items-center text-center p-4">

    <img src="{{ asset('img/alerts/validation.gif') }}" class="responsive-img mb-4" alt="Validation" style="display:block; margin-left:auto; margin-right:auto;" class="mt-5" height="600px">

    <h1 class="text-light">ACCOUNT ON HOLD</h1>

    <h5 class="text-light mb-4">
        Your account registration was successful!<br>
        However, it requires administrator verification before activation.<br>
        Please wait for approval, and you'll be able to access your account shortly.
    </h5>

    <hr class="w-100">

    <a class="btn btn-link mybtl" href="/login">
        <i class="fas fa-sign-in mr-2"></i>Back to Login
    </a>

    <hr class="w-100">

    <img src="{{ asset('img/siis-logo.png') }}" class="responsive-img" style="height: 50px;" alt="SIIS Logo">

</body>
</html>
