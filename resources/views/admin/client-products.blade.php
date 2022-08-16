<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('منتجات العضو ' . $client->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" id="clientProductsPage">
            @livewire('admin.client-products', [
                'cid' => $client->id
            ])

        </div>
    </div>
</x-app-layout>
