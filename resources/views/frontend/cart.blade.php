<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('الخزنة') }}
        </h2>
    </x-slot>
    <div class="cartPage">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @livewire('frontend.cart')
                </div>
        </div>
    </div>
</x-guest-layout>
