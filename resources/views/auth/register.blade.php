<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | JRMSU SIIS</title>
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

    <!-- Form Container -->
    <div class="min-h-screen flex items-center justify-center px-4 py-8 overflow-auto">
        <x-guest-layout>
            <x-authentication-card class="w-full max-w-xl bg-white/10 backdrop-blur-md border border-white/20 shadow-lg rounded-lg p-6">
                <x-slot name="logo">
                    <x-authentication-card-logo class="mx-auto w-20 h-20" />
                </x-slot>

                <x-validation-errors class="mb-4" />

                <!-- Registration Form Starts Here -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Office -->
                    <div>
                        <x-label for="office" value="{{ __('Office') }}" />
                        <select onchange="setValueOffice()" name="office" id="office" class="block mt-1 w-full rounded-md shadow-sm border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-300" wire:model="state.office" required autofocus>
                            <option value="">••• Please select an office:</option>
                            @foreach($offices as $office)
                                <option value="{{ $office->initial }}">{{ $office->office }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4" hidden>
                        <x-label for="office_full" value="{{ __('Office in Full') }}" />
                        <x-input id="office_full" class="block mt-1 w-full" type="text" name="office_full" :value="old('office_full')" required autocomplete="office_full" />
                    </div>

                    <!-- Position -->
                    <div class="mt-4">
                        <x-label for="position" value="{{ __('Position') }}" />
                        <select onchange="setValuePosition()" name="position" id="position" class="block mt-1 w-full rounded-md shadow-sm border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-300" wire:model="state.position" required>
                            <option value="">••• Please select a position/designation:</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->initial }}">{{ $position->position }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4" hidden>
                        <x-label for="position_full" value="{{ __('Position in Full') }}" />
                        <x-input id="position_full" class="block mt-1 w-full" type="text" name="position_full" :value="old('position_full')" required autocomplete="position_full" />
                    </div>

                    <!-- Name -->
                    <div class="mt-4">
                        <x-label for="name" value="{{ __('Name (in Sentence Case: eg. Juan Pedro A. Santos)') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" />
                    </div>

                    <!-- Email -->
                    <div class="mt-4">
                        <x-label for="email" value="{{ __('Valid Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
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

                    <!-- Terms -->
                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-label for="terms">
                                <div class="flex items-center">
                                    <x-checkbox name="terms" id="terms" required />
                                    <div class="ms-2">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-label>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row justify-between items-center mt-6 gap-3">
                        <x-button class="w-full sm:w-auto justify-center text-center">
                            {{ __('Register') }}
                        </x-button>

                        <br/>

                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100" href="{{ route('login') }}">
                            {{ __('I am already registered') }}
                        </a>
                    </div>

                    <hr class="mt-3">
                    <div class="text-blue text-xs mt-3" align="center">JRMSU SIIS Version 1.0 &copy; 2025</div>
                </form>
            </x-authentication-card>
        </x-guest-layout>
    </div>

    <script>
        function setValuePosition() {
            const comboBox = document.getElementById("position");
            const selectedText = comboBox.options[comboBox.selectedIndex].text;
            document.getElementById("position_full").value = selectedText;
        }

        function setValueOffice() {
            const comboBox = document.getElementById("office");
            const selectedText = comboBox.options[comboBox.selectedIndex].text;
            document.getElementById("office_full").value = selectedText;
        }

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
