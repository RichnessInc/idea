<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __(' صفحة '. $page->name ) }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <div class="content" style="display: flow-root;">
                    <div>
                        <span class="px-1 py-1 block">
                            {!!$page->content !!}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
