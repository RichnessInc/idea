<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('اعادة كلمة المرور') }}
        </h2>
    </x-slot>
    @livewire('frontend.reset-password', ['token' => $token])

</x-guest-layout>
