<div>
    {{-- Start Delete User Model --}}
    @if (Auth::user()->role == 1)
        <x-jet-dialog-modal wire:model="deleteFormVisible">
            <x-slot name="title">{{ __('تحميل النسخه') }}</x-slot>
            <x-slot name="content">{{ __('انت متأكد من قرار تحميل النسخه') }}</x-slot>
            <x-slot name="footer">
                @if($modelName != null)
                    <form style="display: inline-block" method="post" action="{{route('admin.backups-download', ['file' => $modelName])}}">
                        @csrf
                        <x-jet-button wire:click='download' class="ml-2"><i class="fas fa-download"></i> {{__('تحميل')}}</x-jet-button>
                    </form>
                @endif
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
            @foreach ($filesInfos as $user)
                <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                    <th class="p-3"><i class="fas fa-calendar-day"></i> التاريخ</th>
                    <th class="p-3"><i class="fas fa-calendar-day"></i> الحجم</th>
                    <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                </tr>
            @endforeach
            </thead>
            <tbody class="flex-1 sm:flex-none">
            @foreach ($filesInfos as $file)
                <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$file['name']}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$file['size']}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        @if (Auth::user()->role == 1)
                            <x-jet-button wire:click="confirmUserDelete('{{$file['name']}}')" class="w-full block ml-2"><i class="mr-2 fas fa-trash-alt"></i> {{__(' حذف')}}</x-jet-button>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
