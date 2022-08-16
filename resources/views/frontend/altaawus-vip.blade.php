<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('الطاووس VIP') }}
        </h2>
    </x-slot>

    <div class="py-12 AltawusPage">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('frontend.altaawus-vip')
        </div>
    </div>
</x-guest-layout>