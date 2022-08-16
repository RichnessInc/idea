<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('ريشة المرح') }}
        </h2>
    </x-slot>
    <div class="profilePage">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @livewire('frontend.reesh')
                </div>
        </div>
    </div>
</x-guest-layout>