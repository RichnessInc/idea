<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('الدول') }}
        </h2>
    </x-slot>

    <div class="py-12" id="adminCountriesPage">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('admin.countries')
        </div>
    </div>
</x-app-layout>
