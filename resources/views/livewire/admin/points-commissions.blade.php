<div>
    <x-jet-button  wire:click='createShowModel' class="mb-2 h-10 text-center main-btn">
        <i class="fas fa-plus"></i> {{__('اضافة فئة')}}
    </x-jet-button>
    {{-- Start Create New User Model --}}
    <x-jet-dialog-modal wire:model="createFormVisible">
        <x-slot name="title">{{__('اضافة فئة')}}</x-slot>
        <x-slot name="content">
            <hr style="border-color:#000 !important">
            <div class="mt-4">
                <x-jet-label for='name' value="{{__('الاسم')}}" />
                <x-jet-input type='text' id="name" wire:model='name' class="block mt-1 w-full" />
                @error('name')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='points' value="{{__('القاط المستهدفة')}}" />
                <x-jet-input type='text' id="points" wire:model='points' class="block mt-1 w-full" />
                @error('points')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <div class="relative">
                    <x-jet-label for='type' value="{{__('نوع الحساب')}}" />
                    <select
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        wire:model='type'
                        id="type">
                        <option>نوع الحساب</option>
                        <option value="0">مشتري</option>
                        <option value="1">تاجر</option>
                        <option value="2">صانع</option>
                        <option value="3">مندوب</option>
                    </select>
                </div>
                @error('type')
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
        <x-slot name="title">{{ __('تعديل بيانات فئة') }}</x-slot>
        <x-slot name="content">
            <hr style="border-color:#000 !important">
            <div class="mt-4">
                <x-jet-label for='name' value="{{__('الاسم')}}" />
                <x-jet-input type='text' id="name" wire:model='name' class="block mt-1 w-full" />
                @error('name')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='points' value="{{__('القاط المستهدفة')}}" />
                <x-jet-input type='text' id="points" wire:model='points' class="block mt-1 w-full" />
                @error('points')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <div class="relative">
                    <x-jet-label for='type' value="{{__('نوع الحساب')}}" />
                    <select
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        wire:model='type'
                        id="type">
                        <option>نوع الحساب</option>
                        <option value="0" {{($type == 0  ? 'selected' : '')}}>مشتري</option>
                        <option value="1" {{($type == 1  ? 'selected' : '')}}>تاجر</option>
                        <option value="2" {{($type == 2  ? 'selected' : '')}}>صانع</option>
                        <option value="3" {{($type == 3  ? 'selected' : '')}}>مندوب</option>
                    </select>
                </div>
                @error('type')
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
            <x-slot name="title">{{ __('حذف فئة') }}</x-slot>
            <x-slot name="content">{{ __('انت متأكد من قرار حذف فئة') }}</x-slot>
            <x-slot name="footer">
                <x-jet-danger-button wire:click='destroy' class="ml-2"><i class="fas fa-trash"></i> {{__('حذف')}}</x-jet-danger-button>
                <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
            </x-slot>
        </x-jet-dialog-modal>
@endif

{{-- End Delete User Model --}}
{{-- Start Users Table --}}
<!-- This example requires Tailwind CSS v2.0+ -->
    <div id="vipRequestAdmin">
    <div class="mx-1 richness-table">
        <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
            <thead class="text-white mob-text-aline">
            @foreach ($rows as $user)
                <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                    <th class="p-3">الاسم</th>
                    <th class="p-3">نوع الحساب المستهدف</th>
                    <th class="p-3">عدد النقاط</th>
                    <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                </tr>
            @endforeach
            </thead>
            <tbody class="flex-1 sm:flex-none">
            @foreach ($rows as $country)
                <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$country->name}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">

                        @if($country->type == 0)
                            مشتري
                        @elseif($country->type == 1)
                            تاجر
                        @elseif($country->type == 2)
                            صانع
                        @elseif($country->type == 3)
                            مندوب
                        @endif

                    </td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$country->points}} نقطة</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        <x-jet-button wire:click="showUpdateModel({{$country->id}})" class="ml-2 main-btn"><i class="mr-2 fas fa-edit"></i> {{__(' تعديل')}}</x-jet-button>
                        @if (Auth::user()->role == 1)
                            <x-jet-danger-button wire:click="confirmUserDelete({{$country->id}})" class="ml-2"><i class="mr-2 fas fa-trash-alt"></i> {{__(' حذف')}}</x-jet-danger-button>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </div>
</div>
