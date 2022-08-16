<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __(' تقرير الارباح') }}
        </h2>
    </x-slot>

    @livewire('admin.profet.collection')

    </x-app-layout>
