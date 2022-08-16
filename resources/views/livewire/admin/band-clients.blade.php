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
    <x-jet-button wire:click="banFun" class="main-btn mb-1"><i class="mr-2 fas fa-ban"></i> {{__(' حظر عضو')}}</x-jet-button>

    <x-jet-dialog-modal wire:model="rejectFormVisible">
        <x-slot name="title">{{ __('تفعيل عضو') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من قرار تفعيل عضو') }}</x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click='reject' class="ml-2 main-btn"><i class="fas fa-check"></i> {{__(' تفعيل')}}</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    <x-jet-dialog-modal wire:model="banFormVisible">
        <x-slot name="title">{{ __('حظر عضو') }}</x-slot>
        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for='email' value="{{__('البريد الإلكتروني')}}" />
                <x-jet-input type='email' id="email" wire:model='email' class="block mt-1 w-full" />
                @error('email')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click='ban' class="ml-2 main-btn"><i class="fas fa-ban"></i> {{__(' حظر')}}</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
{{-- Start Users Table --}}
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="mx-1 richness-table clients-table">
        <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
            <thead class="text-white mob-text-aline">
                @foreach ($users as $user)
                <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                    <th class="p-3">الاسم</th>
                    <th class="p-3"><i class="fas fa-envelope"></i> البريد الالكتروني</th>
                    <th class="p-3"><i class="fas fa-user"></i> نوع الحساب</th>
                    <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                </tr>
                @endforeach
            </thead>
            <tbody class="flex-1 sm:flex-none">
                @foreach ($users as $user)
                <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->name}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->email}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        @if ($user->type == 0)
                        مشتري
                        @elseif($user->type == 1)
                        تاجر
                        @elseif($user->type == 2)
                        صانع
                        @elseif($user->type == 3)
                        مندوب
                        @endif
                    </td>

                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        <x-jet-button wire:click="confirmReject({{$user->id}})" class="main-btn mb-1 w-full"><i class="mr-2 fas fa-check"></i> {{__(' تفعيل')}}</x-jet-button>
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
