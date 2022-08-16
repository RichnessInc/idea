<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('ريشة المرح') }}
        </h2>
    </x-slot>

    <div class="py-12" id="adminResh">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('admin.reesh')
        </div>
    </div>
</x-app-layout>
