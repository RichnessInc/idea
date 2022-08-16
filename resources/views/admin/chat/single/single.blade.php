<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('الدردشة الفردية مع '. $client_name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('admin.chat.single.single', ['client_id' => $id])
        </div>
    </div>
    
</x-app-layout>