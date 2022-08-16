<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __(' ملحق لمنتج '.$proName) }}
        </h2>
    </x-slot>

    <div class="py-12 AltawusPage">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('frontend.product.create-extra', [
                'mid'   => $id
            ])
        </div>
    </div>
</x-guest-layout>
