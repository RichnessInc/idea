<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('الدخول') }}
        </h2>
    </x-slot>

    @livewire('frontend.login')

</x-guest-layout>