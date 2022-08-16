<div>
    <div class="search-container">
        <x-jet-button  wire:click='createShowModel' class="mb-2 h-10 text-center main-btn">
            <i class="fas fa-plus"></i> {{__('اضافة الصندوق')}}
        </x-jet-button>
    </div>
    {{-- Start Create New User Model --}}
    <x-jet-dialog-modal wire:model="createFormVisible">
        <x-slot name="title">{{__('اضافة الصندوق')}}</x-slot>
        <x-slot name="content">
            <hr style="border-color:#000 !important">
            <div class="mt-4">
                <x-jet-label for='price' value="{{__('السعر')}}" />
                <x-jet-input type='text' id="price" wire:model='price' class="block mt-1 w-full" />
                @error('price')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='receipt_days' value="{{__('عدد ايام التوصيل')}}" />
                <x-jet-input type='number' id="receipt_days" wire:model='receipt_days' class="block mt-1 w-full" />
                @error('receipt_days')
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
        <x-slot name="title">{{ __('تعديل بيانات الصندوق') }}</x-slot>
        <x-slot name="content">
            <hr style="border-color:#000 !important">
            <div class="mt-4">
                <x-jet-label for='price' value="{{__('السعر')}}" />
                <x-jet-input type='text' id="price" wire:model='price' class="block mt-1 w-full" />
                @error('price')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='receipt_days' value="{{__('عدد ايام التوصيل')}}" />
                <x-jet-input type='text' id="receipt_days" wire:model='receipt_days' class="block mt-1 w-full" />
                @error('receipt_days')
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
    <x-jet-dialog-modal wire:model="statusFormVisible">
        <x-slot name="title">{{ __('تغير حالة صندوق الحظ') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من قرار تغير حالة صندوق الحظ') }}</x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click='updateStatus' class="ml-2">{{__('تغير')}}</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

    {{-- End Delete User Model --}}
    {{-- Start Users Table --}}
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="mx-1 richness-table">
        <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
            <thead class="text-white mob-text-aline">
                @foreach ($rows as $row)
                <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                    <th class="p-3">ID</th>
                    <th class="p-3">السعر</th>
                    <th class="p-3">عدد ايام التوصيل</th>
                    <th class="p-3">الحالة</th>
                    <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                </tr>
                @endforeach
            </thead>
            <tbody class="flex-1 sm:flex-none">
                @foreach ($rows as $row)
                <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$row->id}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{floor($row->price)}} ريال</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        @if ($row->receipt_days == 0)
                        نفس اليوم
                        @elseif($row->receipt_days == 1)
                        يوم واحد
                        @elseif($row->receipt_days == 2)
                        يومين
                        @elseif($row->receipt_days >= 3 && $row->receipt_days <= 10)
                        {{$row->receipt_days}} ايام
                        @elseif($row->receipt_days > 10)
                        {{$row->receipt_days}} يوم
                        @endif
                    </td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        @if ($row->status == 0)
                        <span class="p-2 rounded shadow bg-green-300">فعال</span>
                        @else
                        <span class="p-2 rounded shadow bg-red-300">غير فعال</span>
                        @endif
                    </td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        <x-jet-button wire:click="showUpdateModel({{$row->id}})" class="ml-2 main-btn"><i class="mr-2 fas fa-edit"></i> {{__(' تعديل')}}</x-jet-button>
                        <x-jet-button wire:click="showStatusModel({{$row->id}})" class="ml-2">
                            @if ($row->status == 1)
                            <i class="mr-2 fas fa-check"></i> {{__(' تفعيل')}}
                            @else
                            <i class="fas fa-ban"></i> {{__(' إلغاء تفعيل')}}
                            @endif
                        </x-jet-button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
    <div class="mx-1">
    {{$rows->links()}}
    </div>
</div>
