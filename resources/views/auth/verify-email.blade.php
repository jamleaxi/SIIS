<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email | JRMSU SIIS</title>
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/source-sans.css') }}">

    <style>
        html, body {
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

    <!-- Centered Card -->
    <div class="min-h-screen flex items-center justify-center px-4 py-8 overflow-auto">
        <x-guest-layout>
            <x-authentication-card class="w-full max-w-md bg-white/10 backdrop-blur-md border border-white/20 shadow-lg rounded-lg p-6">
                <x-slot name="logo">
                    <x-authentication-card-logo class="mx-auto w-20 h-20" />
                </x-slot>

                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-justify">
                    {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                    </div>
                @endif

                <div class="mt-4 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <x-button type="submit" class="w-full sm:w-auto justify-center text-center">
                            {{ __('Resend Verification Email') }}
                        </x-button>
                    </form>

                    <div class="flex flex-col sm:flex-row items-center gap-3">
                        <a
                            href="{{ route('profile.show') }}"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100"
                        >
                            {{ __('Edit Profile') }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </x-authentication-card>
        </x-guest-layout>
    </div>

</body>
</html>
