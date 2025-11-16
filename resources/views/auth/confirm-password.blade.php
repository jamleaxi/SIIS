<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password | JRMSU SIIS</title>
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/source-sans.css') }}">

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .background {
            background-image: url('/img/Google-Oddfellows.gif');
            background-size: cover;
            background-position: center;
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -3;
        }

        .overlay {
            background-image: url('/img/siis-newbg.jpg');
            background-size: cover;
            background-position: center;
            position: fixed;
            width: 100%;
            height: 100%;
            opacity: 0.65;
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
    </style>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400">

    <!-- Background Layers -->
    <div class="background"></div>
    <div class="overlay"></div>
    <div class="blur"></div>

    <!-- Centered Form -->
    <div class="min-h-screen flex items-center justify-center px-4 py-8 overflow-auto">
        <x-guest-layout>
            <x-authentication-card class="w-full max-w-md bg-white/10 backdrop-blur-md border border-white/20 shadow-lg rounded-lg p-6">
                <x-slot name="logo">
                    <x-authentication-card-logo class="mx-auto w-20 h-20" />
                </x-slot>

                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                </div>

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div>
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" autofocus />
                    </div>

                    <div class="flex justify-end mt-4">
                        <x-button class="w-full sm:w-auto justify-center text-center">
                            {{ __('Confirm') }}
                        </x-button>
                    </div>
                </form>
            </x-authentication-card>
        </x-guest-layout>
    </div>

</body>
</html>
