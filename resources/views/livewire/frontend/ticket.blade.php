<div>
    <x-jet-button  wire:click='createShowModel' class="mb-2 h-10 text-center main-btn">
        <i class="fas fa-plus"></i> {{__('اضافة تذكرة')}}
    </x-jet-button>
    <x-jet-dialog-modal wire:model="createFormVisible">
        <x-slot name="title">{{__('اضافة تذكرة')}}</x-slot>
        <x-slot name="content">
            <hr style="border-color:#000 !important">
            <div class="mt-4">
                <x-jet-label for='value' value="{{__('القيمة')}}" />
                <x-jet-input type='text' id="value" wire:model='value' class="block mt-1 w-full" />
                @error('value')
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
    <x-jet-dialog-modal wire:model="updateFormVisible" class="">
        <x-slot name="title">{{ __('تعديل بيانات تذكرة') }}</x-slot>
        <x-slot name="content">
            <hr style="border-color:#000 !important">
            <div class="mt-4">
                <x-jet-label for='value' value="{{__('القيمة')}}" />
                <x-jet-input type='text' id="value" wire:model='value' class="block mt-1 w-full" />
                @error('value')
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
    <x-jet-dialog-modal wire:model="deleteFormVisible">
        <x-slot name="title">{{ __('حذف تذكرة') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من قرار حذف تذكرة') }}</x-slot>
        <x-slot name="footer">
            <x-jet-danger-button wire:click='destroy' class="ml-2"><i class="fas fa-trash"></i> {{__('حذف')}}</x-jet-danger-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    @if($pageInfo->content != null && $pageInfo->content != '')
    <div class="bg-white shadow mb-2 mt-2 py-3 px-4 rounded">
        {!! $pageInfo->content !!}
    </div>
    @endif
    <div class="mx-1 richness-table">
        <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
            <thead class="text-white mob-text-aline">
            @foreach ($rows as $row)
                <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                    <th class="p-3">القيمة</th>
                    <th class="p-3">الرقم المرجعي</th>
                    <th class="p-3">حالة الدفع</th>
                    <th class="p-3">الحالة</th>
                    <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                </tr>
            @endforeach
            </thead>
            <tbody class="flex-1 sm:flex-none">
            @foreach ($rows as $row)
                <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{floor($row->value)}} SAR</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$row->reference_number}} </td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        @if ($row->paid == 1)
                            <span class="p-2 rounded shadow bg-green-300">مدفوع</span>
                        @else
                            <span class="p-2 rounded shadow bg-red-300">غير مدفوع</span>
                        @endif
                    </td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        @if ($row->status == 1)
                            <span class="p-2 rounded shadow bg-red-300">مستخدم</span>
                        @else
                            <span class="p-2 rounded shadow bg-green-300">غير مستخدم</span>
                        @endif
                    </td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        <x-jet-button wire:click="showUpdateModel({{$row->id}})" class="ml-2 main-btn"><i class="mr-2 fas fa-edit"></i> {{__(' تعديل')}}</x-jet-button>
                        <x-jet-danger-button wire:click="confirmUserDelete({{$row->id}})" class="ml-2"><i class="mr-2 fas fa-trash-alt"></i> {{__(' حذف')}}</x-jet-danger-button>
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
