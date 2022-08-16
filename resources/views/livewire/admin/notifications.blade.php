<div>

    <!-- This example requires Tailwind CSS v2.0+ -->
    <input wire:model='searchForm'
           class="dark:bg-gray-900 dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
           type="text"
           value=" "
           autocomplete="new-password"
           placeholder="البحث">
    <br>
    <div class="mx-1 richness-table clients-table">
        <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
            <thead class="text-white mob-text-aline">
            @foreach ($rows as $request)
                <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                    <th class="p-3">الاسم</th>
                    <th class="p-3"><i class="fas fa-envelope"></i> البريد الالكتروني</th>
                    <th class="p-3"><i class="fas fa-user"></i> التاريخ </th>
                    <th class="p-3"><i class="fas fa-user"></i> البيانات </th>
                </tr>
            @endforeach
            </thead>
            <tbody class="flex-1 sm:flex-none">
            @foreach ($rows as $request)
                <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$request->client->name}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$request->client->email}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{date('d-m-Y / h:i A', strtotime($request->created_at))}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        <x-jet-button wire:click="confirmUserDelete({{$request->id}})" class="w-full block ml-2">البيانات</x-jet-button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <x-jet-dialog-modal wire:model="deleteFormVisible">
    <x-slot name="title">{{ __('بيانات الاشعار') }}</x-slot>
    <x-slot name="content">
        @if($rowData != null)
            {!! $rowData !!}
        @endif
    </x-slot>
    <x-slot name="footer">
        <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
    </x-slot>
    </x-jet-dialog-modal>
    <br>
    <div class="mx-1">
        {{$rows->links()}}
    </div>
</div>
