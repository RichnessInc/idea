<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('تذاكر الشراء') }}
        </h2>
    </x-slot>

    <div class="py-12" id="ticket-gifts-page">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('admin.ticket-gifts')
        </div>
    </div>
</x-app-layout>
