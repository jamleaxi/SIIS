<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('SIIS Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your SIIS\'s account and profile preference.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden"
                            wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <b>{{ Auth()->user()->role }} Account</b>

                <x-label class="mt-4" for="photo" value="{{ __('Photo (1MB Max)') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" required autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2 dark:text-white">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="office" value="{{ __('Office') }}" />
            <select onchange="setValueOffice()" name="office" id="office" class="block mt-1 w-full rounded-md shadow-sm border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-300" wire:model="state.office" required autofocus>
                <option value="">••• Please select an office:</option>
                @foreach(App\Models\Office::getOptions() as $office)
                    <option value="{{ $office->initial }}">{{ $office->office }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-span-6 sm:col-span-4" hidden>
            <x-label for="office_full" value="{{ __('Office in Full') }}" />
            <x-input id="office_full" class="block mt-1 w-full" type="text" name="office_full" wire:model="state.office_full" required autocomplete="office_full" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="position" value="{{ __('Position') }}" />
            <select onchange="setValuePosition()" name="position" id="position" class="block mt-1 w-full rounded-md shadow-sm border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-300" wire:model="state.position" required>
                <option value="">••• Please select a position/designation:</option>
                @foreach(App\Models\Position::getOptions() as $position)
                    <option value="{{ $position->initial }}">{{ $position->position }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-span-6 sm:col-span-4" hidden>
            <x-label for="position_full" value="{{ __('Position in Full') }}" />
            <x-input id="position_full" class="block mt-1 w-full" type="text" name="position_full" wire:model="state.position_full" required autocomplete="position_full" />
        </div>

        <!-- Dark Mode -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="dark_mode" value="{{ __('Dark Mode') }}" />
            <select id="dark_mode" class="block mt-1 w-full rounded-md shadow-sm border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400" wire:model="state.dark_mode" style="border-radius:5px">
                <option value="OFF">☀️ OFF</option>
                <option value="ON">🌑 ON</option>
            </select>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
<script>
    function setValuePosition() {
        // Get the select element
        const comboBox = document.getElementById("position");
        // Get the selected option's text
        const selectedText = comboBox.options[comboBox.selectedIndex].text;
        // Display the text in the input field
        document.getElementById("position_full").value = selectedText;
        @this.set('state.position_full',selectedText);
    }

    function setValueOffice() {
        // Get the select element
        const comboBox = document.getElementById("office");
        // Get the selected option's text
        const selectedText = comboBox.options[comboBox.selectedIndex].text;
        // Display the text in the input field
        document.getElementById("office_full").value = selectedText;
        @this.set('state.office_full',selectedText);
    }
</script>