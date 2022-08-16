<div>
    <div class="search-container grid grid-cols-12 gap-4">
        <div class="col-span-9">
            <form autocomplete="off">
                <input wire:model='searchForm'
                       class="dark:bg-gray-900 dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                       type="text"
                       value=" "
                       placeholder="البحث">
            </form>
        </div>
        <div class="col-span-3">
            <x-jet-button  wire:click='createShowModel' class="mb-2 w-full h-10 text-center main-btn">
                <i class="fas fa-plus"></i> {{__('اضافة مشرف')}}
            </x-jet-button>
        </div>
    </div>

    {{-- Start Create New User Model --}}
    <x-jet-dialog-modal wire:model="createFormVisible">
        <x-slot name="title">{{__('اضافة مشرف')}}</x-slot>
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
                <x-jet-label for='email' value="{{__('البريد الإلكتروني')}}" />
                <x-jet-input type='email' id="email" wire:model='email' class="block mt-1 w-full" />
                @error('email')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4 relative">
                <i wire:click="showPasswordF" class="fas fa-eye" style="position: absolute; top: 37px; left: 10px; color: #006EB9FF; cursor: pointer;"></i>
                <x-jet-label for='password' value="{{__('كلمة المرور')}}" />
                <x-jet-input type="{{$showPassword == false ? 'password' : 'text'}}" id="password" wire:model='password' class="block mt-1 w-full" />
                @error('password')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4 relative">
                <i wire:click="showPasswordF" class="fas fa-eye" style="position: absolute; top: 37px; left: 10px; color: #006EB9FF; cursor: pointer;"></i>
                <x-jet-label for='repassword' value="{{__('إعادة كلمة المرور')}}" />
                <x-jet-input type="{{$showPassword == false ? 'password' : 'text'}}" id="repassword" wire:model='repassword' class="block mt-1 w-full" />
                @error('repassword')
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
        <x-slot name="title">{{ __('تعديل بيانات المشرف') }}</x-slot>
        <x-slot name="content">
            <hr style="border-color:#000 !important">
            <div class="mt-4">
                <x-jet-label for='name-ed' value="{{__('الاسم')}}" />
                <x-jet-input type='text' id="name-ed" wire:model='name' class="block mt-1 w-full" />
                @error('name')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='email-ed' value="{{__('البريد الإلكتروني')}}" />
                <x-jet-input type='email' id="email-ed" wire:model='email' class="block mt-1 w-full" />
                @error('email')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4 relative">
                <i wire:click="showPasswordF" class="fas fa-eye" style="position: absolute; top: 37px; left: 10px; color: #006EB9FF; cursor: pointer;"></i>
                <x-jet-label for='password' value="{{__('كلمة المرور')}}" />
                <x-jet-input type="{{$showPassword == false ? 'password' : 'text'}}" id="password" wire:model='password' class="block mt-1 w-full" />
                @error('password')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4 relative">
                <i wire:click="showPasswordF" class="fas fa-eye" style="position: absolute; top: 37px; left: 10px; color: #006EB9FF; cursor: pointer;"></i>
                <x-jet-label for='repassword' value="{{__('إعادة كلمة المرور')}}" />
                <x-jet-input type="{{$showPassword == false ? 'password' : 'text'}}" id="repassword" wire:model='repassword' class="block mt-1 w-full" />
                @error('repassword')
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
        <x-slot name="title">{{ __('حذف المشرف') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من قرار حذف المشرف') }}</x-slot>
        <x-slot name="footer">
            <x-jet-danger-button wire:click='destroy' class="ml-2"><i class="fas fa-trash"></i> {{__('حذف')}}</x-jet-danger-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    @endif

    {{-- End Delete User Model --}}
    {{-- Start Delete User Model --}}
    @if (Auth::user()->chat_on == 0)
    <x-jet-dialog-modal wire:model="chatOnModelVisible">
        <x-slot name="title">{{ __('فتح الدردشة') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من قرار فتح الدردشة') }}</x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click='UserChatOn' class="ml-2"><i class="fas fa-check"></i> {{__('فتح')}}</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    @else
    <x-jet-dialog-modal wire:model="chatOnModelVisible">
        <x-slot name="title">{{ __('اغلاق الدردشة') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من قرار اغلاق الدردشة') }}</x-slot>
        <x-slot name="footer">
            <x-jet-danger-button wire:click='UserChatOn' class="ml-2"><i class="fas fa-ban"></i> {{__('اغلاق')}}</x-jet-danger-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    @endif

    {{-- End Delete User Model --}}
    {{-- Start Users Table --}}
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="mx-1 richness-table users-table">
        <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
            <thead class="text-white mob-text-aline">
                @foreach ($users as $user)
                <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
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
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->name}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->email}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{ date('d-m-Y', strtotime($user->created_at))}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        <x-jet-button wire:click="showUpdateModel({{$user->id}})" class="ml-2 main-btn"><i class="mr-2 fas fa-edit"></i> {{__(' تعديل')}}</x-jet-button>
                        @if (Auth::user()->role == 1)
                            @if($user->id != 1)
                                <x-jet-danger-button wire:click="confirmUserDelete({{$user->id}})" class="ml-2"><i class="mr-2 fas fa-trash-alt"></i> {{__(' حذف')}}</x-jet-danger-button>
                            @endif
                        @endif
                        @if ($user->chat_on == 1)
                        <x-jet-button wire:click="confirmUserChatOn({{$user->id}})" class="ml-2"><i class="mr-2 fas fa-ban"></i> {{__(' اغلاق الدردشة')}}</x-jet-button>
                        @endif
                        @if ($user->chat_on == 0)
                        <x-jet-button wire:click="confirmUserChatOn({{$user->id}})" class="ml-2"><i class="mr-2 fas fa-check"></i> {{__('فتح الدردشة')}}</x-jet-button>
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
