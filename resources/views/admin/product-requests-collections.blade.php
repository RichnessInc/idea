
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('طلبات المنتجات الجماعية') }}
        </h2>
    </x-slot>

    <div class="py-12" id="productRequestsPageAdmin">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('admin.product-requests-collections')
        </div>
    </div>
</x-app-layout>
