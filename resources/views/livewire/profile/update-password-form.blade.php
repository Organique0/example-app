<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\rules;
use function Livewire\Volt\state;

state([
    'current_password' => '',
    'password' => '',
    'password_confirmation' => '',
]);

rules([
    'current_password' => ['required', 'string', 'current_password'],
    'password' => ['required', 'string', Password::defaults(), 'confirmed'],
]);

$updatePassword = function () {
    try {
        $validated = $this->validate();
    } catch (ValidationException $e) {
        $this->reset('current_password', 'password', 'password_confirmation');

        throw $e;
    }

    Auth::user()->update([
        'password' => Hash::make($validated['password']),
    ]);

    $this->reset('current_password', 'password', 'password_confirmation');

    $this->dispatch('password-updated');
};

?>

<section>
    <header>
        <h2 class="text-lg font-medium ">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm ">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <div>
            <x-mary-input label="{{ __('Current Password') }}" wire:model="current_password"
                id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full"
                autocomplete="current-password" />
        </div>

        <div>
            <x-mary-input label="{{ __('New Password') }}" wire:model="password" id="update_password_password"
                name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
        </div>

        <div>
            <x-mary-input label="{{ __('Confirm Password') }}" wire:model="password_confirmation"
                id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full" autocomplete="new-password" />
        </div>

        <div class="flex items-center gap-4">
            <x-mary-button class="btn-primary" type="submit">{{ __('Save') }}</x-mary-button>

            <x-action-message class="me-3" on="password-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>