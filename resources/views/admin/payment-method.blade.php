<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('وسائل الدفع') }}
        </h2>
    </x-slot>

    <div class="py-12" id="adminShippingPage">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('admin.payment-method')
        </div>
    </div>
</x-app-layout>
