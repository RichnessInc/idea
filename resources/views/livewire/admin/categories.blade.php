<div>
    <div class="search-container grid grid-cols-12 gap-4">
        <div class="col-span-8">
            <input wire:model='searchForm'
            class="dark:bg-gray-900 dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
            type="text"
            value=" "
            autocomplete="new-password"
            placeholder="البحث">
        </div>
        <div class="col-span-4">
            <x-jet-button  wire:click='createShowModel' class="mb-2 w-full h-10 text-center main-btn">
                <i class="fas fa-plus"></i> {{__('اضافة تصنيف')}}
            </x-jet-button>
        </div>
    </div>

    {{-- Start Create New User Model --}}
    <x-jet-dialog-modal wire:model="createFormVisible">
        <x-slot name="title">{{__('اضافة تصنيف')}}</x-slot>
        <x-slot name="content">
            <hr style="border-color:#000 !important">

            <div class="mt-4">
                <x-jet-label for='name' value="{{__('الاسم')}}" />
                <x-jet-input type='text' id="name" wire:model='name' class="block mt-1 w-full" />
                @error('name')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
        </x-slot>
        <x-slot name="footer">
        <x-jet-button wire:click='store' class="ml-2 main-btn"><i class="fas fa-plus"></i> {{__(' اضافة')}}</x-jet-button>
        <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    {{-- Start Create New User Model --}}
    {{-- Start Update User Model --}}
    <x-jet-dialog-modal wire:model="updateFormVisible" class="">
        <x-slot name="title">{{ __('تعديل بيانات تصنيف') }}</x-slot>
        <x-slot name="content">
            <hr style="border-color:#000 !important">
            <div class="mt-4">
                <x-jet-label for='name-ed' value="{{__('الاسم')}}" />
                <x-jet-input type='text' id="name-ed" wire:model='name' class="block mt-1 w-full" />
                @error('name')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click='update' class="ml-2 main-btn"><i class="fas fa-edit"></i> {{__('التعديل')}}</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    {{-- End Update User Model --}}
    {{-- Start Delete User Model --}}
    @if (Auth::user()->role == 1)
    <x-jet-dialog-modal wire:model="deleteFormVisible">
        <x-slot name="title">{{ __('حذف تصنيف') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من قرار حذف تصنيف') }}</x-slot>
        <x-slot name="footer">
            <x-jet-danger-button wire:click='destroy' class="ml-2"><i class="fas fa-trash"></i> {{__('حذف')}}</x-jet-danger-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    @endif

    {{-- End Delete User Model --}}
    {{-- Start Users Table --}}
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="mx-1 richness-table clients-table">
        <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
            <thead class="text-white mob-text-aline">
                @foreach ($users as $user)
                <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                    <th class="p-3">الاسم</th>
                    <th class="p-3">عدد المنتجات</th>
                    <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                </tr>
                @endforeach
            </thead>
            <tbody class="flex-1 sm:flex-none">
                @foreach ($users as $user)
                <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->name}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->products_count}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        <x-jet-button wire:click="showUpdateModel({{$user->id}})" class="ml-2 main-btn editBtn"><i class="mr-2 fas fa-edit"></i> {{__(' تعديل')}}</x-jet-button>
                        @if (Auth::user()->role == 1)
                        <x-jet-danger-button wire:click="confirmUserDelete({{$user->id}})" class="ml-2"><i class="mr-2 fas fa-trash-alt"></i> {{__(' حذف')}}</x-jet-danger-button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
    <div class="mx-1">
    {{$users->links()}}
    </div>
</div>
@push('scripts')

@endpush
