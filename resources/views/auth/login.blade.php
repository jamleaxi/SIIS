<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | JRMSU SIIS</title>
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
    </style>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400">

    <!-- Background + Blur -->
    <div class="background"></div>
    {{-- <div class="overlay"></div> --}}
    <div class="blur"></div>

    <!-- Form -->
    <div class="min-h-screen flex items-center justify-center px-4 py-8 overflow-auto">
        <x-guest-layout>
            <x-authentication-card class="w-full max-w-md bg-white/10 backdrop-blur-md border border-white/20 shadow-lg rounded-lg p-6 mx-auto">
                <div align="center">
                    <img src="{{ asset('img/JRMSU.png') }}" class="mb-3" width="100px" />
                </div>
                
                <x-slot name="logo">
                    <x-authentication-card-logo class="mx-auto w-20 h-20" />
                </x-slot>

                <x-validation-errors class="mb-4" />

                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        
                        <div class="relative mt-1">
                            <x-input id="password" class="block w-full pr-10" type="password" name="password" required autocomplete="current-password" />
                            
                            <i class="fa-solid fa-eye cursor-pointer text-gray-500 absolute right-3 top-1/2 -translate-y-1/2 mt-0.5"
                                onclick="togglePassword('password', this)"></i>
                        </div>
                    </div>
                    

                    <!-- Remember Me -->
                    {{-- <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ms-2 text-sm">{{ __('Remember me') }}</span>
                        </label>
                    </div> --}}

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row sm:justify-between items-center mt-4">
                        <x-button class="w-full sm:w-auto justify-center text-center">
                            {{ __('Log in') }}
                        </x-button>
                        
                        <br/>

                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                                {{ __('I forgot my password') }}
                            </a>
                        @endif
                    </div>

                    <hr class="mt-3">
                    <div class="text-blue text-xs mt-3" align="center">JRMSU SIIS Version 1.0 &copy; 2025</div>
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
