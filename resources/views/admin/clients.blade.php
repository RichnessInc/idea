<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('الأعضاء') }}
        </h2>
    </x-slot>

    <div class="py-12" id="AdminClintsPage">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="alert alert-success shadow text-white text-lg p-2 m-2" style="background-color: #5faf42; margin: 20px; border-radius: 0.25rem; }">
                    {{ session('message') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error bg-red-600 shadow text-white text-lg p-2 m-2">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @livewire('admin.clients')
        </div>
    </div>
</x-app-layout>
