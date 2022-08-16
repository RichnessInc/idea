<div>
    <x-jet-button  wire:click='createShowModel' class="mb-2 h-10 text-center main-btn">
        <i class="fas fa-plus"></i> {{__('اضافة خلفية')}}
    </x-jet-button>
    {{-- Start Create New User Model --}}
    <x-jet-dialog-modal wire:model="createFormVisible">
        <x-slot name="title">{{__('اضافة خلفية')}}</x-slot>
        <x-slot name="content">
            <hr style="border-color:#000 !important">
            <div class="mt-4">
                <x-jet-label for='image' value="{{__('خلفية')}}" />
                <x-jet-input type='file' id="image" wire:model='image' class="block mt-1 w-full" accept="image/*" />
                @error('image')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click='store' class="ml-2 main-btn"><i class="fas fa-plus"></i> {{__(' اضافة')}}</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    @if (Auth::user()->role == 1)
        <x-jet-dialog-modal wire:model="deleteFormVisible">
            <x-slot name="title">{{ __('حذف خلفية') }}</x-slot>
            <x-slot name="content">{{ __('انت متأكد من قرار حذف خلفية') }}</x-slot>
            <x-slot name="footer">
                <x-jet-danger-button wire:click='destroy' class="ml-2"><i class="fas fa-trash"></i> {{__('حذف')}}</x-jet-danger-button>
                <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
            </x-slot>
        </x-jet-dialog-modal>
    @endif
    {{-- Start Create New User Model --}}

    <div class="grid grid-cols-12 gap-4">
        @foreach($rows as $row)
            <div class="col-span-3">
                <div class="card bg-white rounded shadow-md p-2">
                    <img class="rounded" src="{{asset('uploads/'.$row->background_name)}}" style="width: 100%;height: 200px">
                    @if (Auth::user()->role == 1)
                        <x-jet-danger-button wire:click="confirmUserDelete({{$row->id}})" class="mt-1 w-full"><i class="mr-2 fas fa-trash-alt"></i> {{__(' حذف')}}</x-jet-danger-button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

</div>
