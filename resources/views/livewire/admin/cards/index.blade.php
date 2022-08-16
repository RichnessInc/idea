<div>
    <div class="search-container grid grid-cols-12 gap-4">
        <div class="col-span-12">
            <input wire:model='searchForm'
                   class="dark:bg-gray-900 dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                   type="text"
                   value=" "
                   autocomplete="new-password"
                   placeholder="البحث">
        </div>
    </div>

    {{-- End Update User Model --}}
    {{-- Start Delete User Model --}}
    @if (Auth::user()->role == 1)
        <x-jet-dialog-modal wire:model="deleteFormVisible">
            <x-slot name="title">{{ __('حذف الكارت') }}</x-slot>
            <x-slot name="content">{{ __('انت متأكد من قرار حذف الكارت') }}</x-slot>
            <x-slot name="footer">
                <x-jet-danger-button wire:click='destroy' class="ml-2"><i class="fas fa-trash"></i> {{__('حذف')}}</x-jet-danger-button>
                <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
            </x-slot>
        </x-jet-dialog-modal>
    @endif
{{-- End Delete User Model --}}
{{-- Start Users Table --}}
<!-- This example requires Tailwind CSS v2.0+ -->
    <div id="cardIndexAdmin">
        <div class="mx-1 richness-table clients-table">
            <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
                <thead class="text-white mob-text-aline">
                @foreach ($users as $user)
                    <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                        <th class="p-3">من</th>
                        <th class="p-3">الى</th>
                        <th class="p-3">الاسم</th>
                        <th class="p-3"><i class="fas fa-envelope"></i> البريد الالكتروني</th>
                        <th class="p-3"><i class="fas fa-calendar-day"></i> التاريخ</th>
                        <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                    </tr>
                @endforeach
                </thead>
                <tbody class="flex-1 sm:flex-none">
                @foreach ($users as $user)
                    <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->from}}</td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->to}}</td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->client->name}}</td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->client->email}}</td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{ date('d-m-Y', strtotime($user->created_at))}}</td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                            <a href="{{route('frontend.cards.single', ['slug' => $user->slug])}}"
                               class="items-center px-4 py-2 bg-gray-800 border border-transparent
                        rounded-md font-semibold text-xs text-white uppercase tracking-widest
                        hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                        focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-2">
                                <i class="mr-2 fas fa-eye"></i> {{__('عرض الكارت')}}
                            </a>
                            @if (Auth::user()->role == 1)
                                <x-jet-danger-button wire:click="confirmUserDelete({{$user->id}})" class="ml-2"><i class="mr-2 fas fa-trash-alt"></i> {{__(' حذف')}}</x-jet-danger-button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="mx-1">
        {{$users->links()}}
    </div>
</div>
