<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication | JRMSU SIIS</title>
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/source-sans.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>

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

    <!-- Centered 2FA Form -->
    <div class="min-h-screen flex items-center justify-center px-4 py-8 overflow-auto">
        <x-guest-layout>
            <x-authentication-card class="w-full max-w-md bg-white/10 backdrop-blur-md border border-white/20 shadow-lg rounded-lg p-6">
                <x-slot name="logo">
                    <x-authentication-card-logo class="mx-auto w-20 h-20" />
                </x-slot>

                <div x-data="{ recovery: false }">
                    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400" x-show="!recovery">
                        {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                    </div>

                    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400" x-cloak x-show="recovery">
                        {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                    </div>

                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('two-factor.login') }}">
                        @csrf

                        <div class="mt-4" x-show="!recovery">
                            <x-label for="code" value="{{ __('Code') }}" />
                            <x-input id="code" class="block mt-1 w-full" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                        </div>

                        <div class="mt-4" x-cloak x-show="recovery">
                            <x-label for="recovery_code" value="{{ __('Recovery Code') }}" />
                            <x-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                        </div>

                        <div class="flex flex-col sm:flex-row items-center justify-between mt-4 gap-3">
                            <div class="flex gap-3">
                                <button type="button"
                                    class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 underline"
                                    x-show="!recovery"
                                    x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                                    {{ __('Use a recovery code') }}
                                </button>

                                <button type="button"
                                    class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 underline"
                                    x-cloak
                                    x-show="recovery"
                                    x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                                    {{ __('Use an authentication code') }}
                                </button>
                            </div>

                            <x-button class="w-full sm:w-auto justify-center text-center">
                                {{ __('Log in') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </x-authentication-card>
        </x-guest-layout>
    </div>

</body>
</html>
