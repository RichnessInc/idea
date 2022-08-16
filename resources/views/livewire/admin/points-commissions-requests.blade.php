<div>
    {{-- Start Update User Model --}}
    <x-jet-dialog-modal wire:model="updateFormVisible" class="">
        <x-slot name="title">{{ __('تعديل العمولة') }}</x-slot>
        <x-slot name="content">
            <hr style="border-color:#000 !important">
            <div class="mt-4">
                <x-jet-label for='com' value="{{__('العمولة')}}" />
                <x-jet-input type='text' id="com" wire:model='com' class="block mt-1 w-full" />
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
            <x-slot name="title">{{ __('حذف الطلب') }}</x-slot>
            <x-slot name="content">{{ __('انت متأكد من قرار حذف الطلب') }}</x-slot>
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
                    <th class="p-3">البريد الالكتروني</th>
                    <th class="p-3">نوع الفئة المستهدفة</th>
                    <th class="p-3">عدد النقاط</th>
                    <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                </tr>
            @endforeach
            </thead>
            <tbody class="flex-1 sm:flex-none">
            @foreach ($rows as $country)
                <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$country->client->name}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$country->client->email}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        {{$country->type->name}}
                    </td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$country->type->points}} نقطة</td>
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
