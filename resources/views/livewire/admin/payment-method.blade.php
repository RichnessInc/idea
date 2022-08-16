<div>
    {{-- Start Create New User Model --}}
    <x-jet-dialog-modal wire:model="statusFormVisible">
        <x-slot name="title">{{ __('تغير حالة وسيلة الدفع') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من قرار تغير حالة وسيلة الدفع') }}</x-slot>
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
                    <th class="p-3">الاسم</th>
                    <th class="p-3">الحالة</th>
                    <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                </tr>
            @endforeach
            </thead>
            <tbody class="flex-1 sm:flex-none">
            @foreach ($rows as $row)
                <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$row->name}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        @if ($row->status == 1)
                            <span class="p-2 rounded shadow bg-green-300">فعال</span>
                        @else
                            <span class="p-2 rounded shadow bg-red-300">غير فعال</span>
                        @endif
                    </td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        <x-jet-button wire:click="showStatusModel({{$row->id}})" class="ml-2">
                            @if ($row->status == 0)
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
</div>
