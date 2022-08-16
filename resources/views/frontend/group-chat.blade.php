<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('المناقشة الجماعية') }}
        </h2>
    </x-slot>
    <div class="groupPage">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @livewire('components.chat-group', ['gid' => $id])
            </div>
        </div>
    </div>
</x-guest-layout>
