<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="{{ __('Current Password') }}" />

            <div class="relative mt-1">
                <x-input id="current_password" class="block w-full pr-10" type="password" name="current_password" wire:model="state.current_password" autocomplete="current-password" />
                <x-input-error for="current_password" class="mt-2" />
                
                <i class="fa-solid fa-eye cursor-pointer text-gray-500 absolute right-3 top-1/2 -translate-y-1/2 mt-0.5"
                    onclick="togglePassword('current_password', this)"></i>
            </div>
        </div>

        <!-- Password Field -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('Password') }}" />

            <div class="relative mt-1">
                <x-input id="password" class="block w-full pr-10" type="password" name="password" wire:model="state.password" autocomplete="new-password" />
                <x-input-error for="password" class="mt-2" />
                
                <i class="fa-solid fa-eye cursor-pointer text-gray-500 absolute right-3 top-1/2 -translate-y-1/2 mt-0.5"
                    onclick="togglePassword('password', this)"></i>
            </div>
        </div>

        <!-- Confirm Password Field -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />

            <div class="relative mt-1">
                <x-input id="password_confirmation" class="block w-full pr-10" type="password" name="password_confirmation" wire:model="state.password_confirmation" autocomplete="new-password" />
                <x-input-error for="password_confirmation" class="mt-2" />
                
                <i class="fa-solid fa-eye cursor-pointer text-gray-500 absolute right-3 top-1/2 -translate-y-1/2 mt-0.5"
                    onclick="togglePassword('password_confirmation', this)"></i>
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button>
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
<script>
    function togglePassword(fieldId, icon) {
        const input = document.getElementById(fieldId);
        const isPassword = input.type === 'password';

        input.type = isPassword ? 'text' : 'password';

        // Toggle icon class
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    }
</script>