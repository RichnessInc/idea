<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 single-product">
            @livewire('frontend.single-product', [
            'slug'  => $slug
            ])
        </div>
    </div>

</x-guest-layout>
