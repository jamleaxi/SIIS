<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | JRMSU SIIS</title>
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/source-sans.css') }}">
    <script src="https://kit.fontawesome.com/yourkit.js" crossorigin="anonymous"></script> <!-- Replace with your FontAwesome kit -->

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

    <!-- Centered Form -->
    <div class="min-h-screen flex items-center justify-center px-4 py-8 overflow-auto">
        <x-guest-layout>
            <x-authentication-card class="w-full max-w-md bg-white/10 backdrop-blur-md border border-white/20 shadow-lg rounded-lg p-6">
                <x-slot name="logo">
                    <x-authentication-card-logo class="mx-auto w-20 h-20" />
                </x-slot>

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email -->
                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />

                        <div class="relative mt-1">
                            <x-input id="password" class="block w-full pr-10" type="password" name="password" required autocomplete="new-password" />
                            
                            <i class="fa-solid fa-eye cursor-pointer text-gray-500 absolute right-3 top-1/2 -translate-y-1/2 mt-0.5"
                                onclick="togglePassword('password', this)"></i>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />

                        <div class="relative mt-1">
                            <x-input id="password_confirmation" class="block w-full pr-10" type="password" name="password_confirmation" required autocomplete="new-password" />
                            
                            <i class="fa-solid fa-eye cursor-pointer text-gray-500 absolute right-3 top-1/2 -translate-y-1/2 mt-0.5"
                                onclick="togglePassword('password_confirmation', this)"></i>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end mt-4">
                        <x-button class="w-full sm:w-auto justify-center text-center">
                            {{ __('Reset Password') }}
                        </x-button>
                    </div>
                </form>
            </x-authentication-card>
        </x-guest-layout>
    </div>

    <script>
        function togglePassword(fieldId, icon) {
            const input = document.getElementById(fieldId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
    </script>
</body>
</html>
