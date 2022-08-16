<div>
    <div class="bg-white rounded shadow p-2 mb-3">
        <h2 class="text-2xl">اضافة ملحق</h2>
        <div class="mt-4">
            <x-jet-label for='name' value="{{__('الاسم')}}" />
            <x-jet-input type='text' id="name" wire:model='name' class="block mt-1 w-full" />
            @error('name')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>
        <div class="mt-4">
            <x-jet-label for='price' value="{{__('السعر')}}" />
            <x-jet-input type='text' id="price" wire:model='price' class="block mt-1 w-full" />
            @error('price')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>
        <div class="mt-4">
            <x-jet-label for='main_image' value="{{__('الصورة المصغرة')}}" />
            <x-jet-input type='file' id="main_image" wire:model='main_image' class="block mt-1 w-full" accept='image/*'/>
            @error('main_image')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>
        <div class="mt-4">
            <x-jet-button wire:click='store' class="ml-2 main-btn"><i class="fas fa-plus"></i> {{__(' اضافة')}}</x-jet-button>
            <x-jet-danger-button wire:click='remove({{$extra->id}})' class="ml-2"><i class="fas fa-trash"></i> {{__(' حذف')}}</x-jet-danger-button>
        </div>
    </div>
    @push('scripts')
        <script>
            window.addEventListener('load', () => {
                Livewire.emit('loadData')
            });
        </script>
    @endpush
</div>
