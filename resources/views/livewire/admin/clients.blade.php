<div>
    <div class="search-container mx-1 md:mx-0 clients-counter grid grid-cols-12 gap-4">
        <div class="col-span-6 lg:col-span-3">
            <div class="rounded overflow-hidden shadow-lg bg-white w-full border-2 border-blue-400">
                <div class="px-6 py-4 w-full text-center">
                    <h3 class="text-xl">عدد المشتريين</h3>
                    <span class="text-2xl text-blue-400 font-extrabold">{{$type0}}</span>
                </div>
            </div>
        </div>
        <div class="col-span-6 lg:col-span-3">
            <div class="rounded overflow-hidden shadow-lg bg-white w-full border-2 border-blue-400">
                <div class="px-6 py-4 w-full text-center">
                    <h3 class="text-xl">عدد التجار</h3>
                    <span class="text-2xl text-blue-400 font-extrabold">{{$type1}}</span>
                </div>
            </div>
        </div>
        <div class="col-span-6 lg:col-span-3">
            <div class="rounded overflow-hidden shadow-lg bg-white w-full border-2 border-blue-400">
                <div class="px-6 py-4 w-full text-center">
                    <h3 class="text-xl">عدد الصناع</h3>
                    <span class="text-2xl text-blue-400 font-extrabold">{{$type2}}</span>
                </div>
            </div>
        </div>
        <div class="col-span-6 lg:col-span-3">
            <div class="rounded overflow-hidden shadow-lg bg-white w-full border-2 border-blue-400">
                <div class="px-6 py-4 w-full text-center">
                    <h3 class="text-xl">عدد المندوبين</h3>
                    <span class="text-2xl text-blue-400 font-extrabold">{{$type3}}</span>
                </div>
            </div>
        </div>
    </div>
    <br>
    <hr>
    <br>
    <div class="search-container grid grid-cols-12 gap-4">
        <div class="md:col-span-6 col-span-12">
            <form autocomplete="off">
                <input wire:model='searchForm'
                       class="dark:bg-gray-900 dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                       type="text"
                       value=" "
                       autocomplete="off"
                       placeholder="البحث">
            </form>
        </div>
        <div class="md:col-span-3 col-span-12">
            <x-jet-button  wire:click='createShowModel' class="mb-2 w-full h-10 text-center main-btn">
                <i class="fas fa-plus"></i> {{__('اضافة عضو')}}
            </x-jet-button>
        </div>
        <div class="md:col-span-3 col-span-12">
            <x-jet-button  wire:click='balanceModel' class="mb-2 w-full h-10 text-center">
                <i class="fas fa-sack-dollar"></i> {{__('تسويه الديون')}}
            </x-jet-button>
        </div>
    </div>

    {{-- Start Create New User Model --}}
    <x-jet-dialog-modal wire:model="createFormVisible">
        <x-slot name="title">{{__('اضافة عضو')}}</x-slot>
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
                <x-jet-label for='whatsapp_phone' value="{{__('رقم الهاتف')}}" />
                <x-jet-input type='tel' id="whatsapp_phone" max='11' wire:model='whatsapp_phone' class="block mt-1 w-full" />
                @error('whatsapp_phone')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='spare_phone' value="{{__('رقم الهاتف الاحتياطي')}}" />
                <x-jet-input type='tel' id="spare_phone" max='11' wire:model='spare_phone' class="block mt-1 w-full" />
                @error('whatsapp_phone')
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
            <div class="mt-4">
                <x-jet-label for='type' value="{{__('نوع الإشتراك')}}" />
                <div class="w-full">
                    <div class="relative">
                        <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                wire:model='type'
                                name='type'
                                id="type">
                            <option>نوع الإشتراك</option>
                            <option value="0">مشتري</option>
                            <option value="1">تاجر</option>
                            <option value="2">صانع</option>
                            <option value="3">مندوب</option>
                        </select>
                    </div>
                </div>
                @error('role_id')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            @if ($type != 0)
                <div class="mt-4">
                    <x-jet-label for='files'  value="{{__('الملفات')}}" />
                    <x-jet-input type='file' id="files" multiple wire:model='files' class="block mt-1 w-full" accept="image/*,application/pdf"/>
                    @if ($type == 1)
                        <span class=" text-yellow-500 mt-1">يجب رفع بطاقة الهوية والسجل التجاري والبطاقة الضريبية ليتم تفعيل حسابك (يمكنك تجميع صور المستندات في ملف PdF)</span>
                    @elseif($type == 2)
                        <span class=" text-yellow-500 mt-1">يجب رفع بطاقة الهوية ليتم تفعيل حسابك (يمكنك تجميع صور المستندات في ملف PdF)</span>
                    @elseif($type == 3)
                        <span class=" text-yellow-500 mt-1">يجب رفع بطاقة الهوية ليتم تفعيل حسابك (يمكنك تجميع صور المستندات في ملف PdF)</span>
                    @endif
                    @error('files')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
            @endif


            <div class="mt-4">
                <x-jet-label for='country_id' value="{{__('الدولة')}}" />
                <div class="w-full">
                    <div class="relative">
                        <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                wire:model='country_id'
                                wire:change='country_change'
                                name='country_id'
                                id="country_id">
                            <option>الدولة</option>
                            @foreach ($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @error('country_id')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='government_id' value="{{__('المدينة')}}" />
                <div class="w-full">
                    <div class="relative">
                        <select {{($governorates == null ? 'disabled' : '')}} class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                wire:model='government_id'
                                name='government_id'
                                id="government_id">
                            <option>المدينة</option>
                            @if ($governorates != null)
                                @foreach ($governorates as $governorate)
                                    <option value="{{$governorate->id}}">{{$governorate->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                @error('government_id')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-6">
                        <div class="mt-4">
                            <x-jet-label for='sector' value="{{__('المحافظة')}}" />
                            <x-jet-input type='text' id="sector"  wire:model='sector' class="block mt-1 w-full" />
                            @error('sector')
                            <span class="text-red-500 mt-1">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-6">
                        <div class="mt-4">
                            <x-jet-label for='street' value="{{__('الشارع')}}" />
                            <x-jet-input type='text' id="street"  wire:model='street' class="block mt-1 w-full" />
                            @error('street')
                            <span class="text-red-500 mt-1">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-4">
                        <div class="mt-4">
                            <x-jet-label for='build_no' value="{{__('رقم العمارة')}}" />
                            <x-jet-input type='number' id="build_no"  wire:model='build_no' class="block mt-1 w-full" />
                            @error('build_no')
                            <span class="text-red-500 mt-1">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-4">
                        <div class="mt-4">
                            <x-jet-label for='floor' value="{{__('الطابق')}}" />
                            <x-jet-input type='number' id="floor"  wire:model='floor' class="block mt-1 w-full" />
                            @error('floor')
                            <span class="text-red-500 mt-1">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-4">
                        <div class="mt-4">
                            <x-jet-label for='unit_no' value="{{__('رقم الوحدة')}}" />
                            <x-jet-input type='number' id="unit_no"  wire:model='unit_no' class="block mt-1 w-full" />
                            @error('unit_no')
                            <span class="text-red-500 mt-1">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-span-12">
                        <div class="mt-4">
                            <x-jet-label for='details' value="{{__('التفاصيل')}}" />
                            <x-jet-input type='text' id="details"  wire:model='details' class="block mt-1 w-full" />
                            @error('details')
                            <span class="text-red-500 mt-1">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6">
                    <div class="mt-4 relative">
                        <i wire:click="showPasswordF" class="fas fa-eye" style="position: absolute; top: 37px; left: 10px; color: #006EB9FF; cursor: pointer;"></i>
                        <x-jet-label for='password' value="{{__('كلمة المرور')}}" />
                        <x-jet-input type="{{$showPassword == false ? 'password' : 'text'}}" id="password" wire:model='password' class="block mt-1 w-full" />
                        @error('password')
                        <span class="text-red-500 mt-1">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-6">
                    <div class="mt-4 relative">
                        <i wire:click="showPasswordF" class="fas fa-eye" style="position: absolute; top: 37px; left: 10px; color: #006EB9FF; cursor: pointer;"></i>
                        <x-jet-label for='repassword' value="{{__('إعادة كلمة المرور')}}" />
                        <x-jet-input type="{{$showPassword == false ? 'password' : 'text'}}" id="repassword" wire:model='repassword' class="block mt-1 w-full" />
                        @error('repassword')
                        <span class="text-red-500 mt-1">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
        <x-jet-button wire:click='store' class="ml-2 main-btn"><i class="fas fa-plus"></i> {{__(' اضافة')}}</x-jet-button>
        <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    {{-- Start Create New User Model --}}
    {{-- Start Update User Model --}}
    <form autocomplete="off">
        <x-jet-dialog-modal wire:model="updateFormVisible" class="">
            <x-slot name="title">{{ __('تعديل بيانات العضو') }}</x-slot>
            <x-slot name="content">
                <hr style="border-color:#000 !important">
                <br>
                <div class="images">
                    @if($myFiles != null)
                        @foreach(explode(',', $myFiles) as $file)
                            @php
                                $infoPath = pathinfo(public_path('/uploads/'.$file));
                                $extension = $infoPath['extension'];
                            @endphp
                            <x-jet-button data-filename="{{$file}}" class="ml-2 main-btn downloadFileBtn"><i class="fas fa-download"></i> {{__(' تحمبل الملف ')}} ({{$extension}})</x-jet-button>

                        @endforeach
                    @endif
                </div>
                <br>
                <hr>
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
                <div class="mt-4">
                    <x-jet-label for='whatsapp_phone' value="{{__('رقم الواتساب')}}" />
                    <x-jet-input type='text' id="whatsapp_phone" wire:model='whatsapp_phone' class="block mt-1 w-full" />
                    @error('whatsapp_phone')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='spare_phone' value="{{__('الرقم الإحتياطي')}}" />
                    <x-jet-input type='text' id="spare_phone" wire:model='spare_phone' class="block mt-1 w-full" />
                    @error('spare_phone')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='wallet' value="{{__('الرصيد المتاح')}}" />
                    <x-jet-input type='text' id="wallet" wire:model='wallet' class="block mt-1 w-full" />
                    @error('wallet')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='debt' value="{{__('الديون')}}" />
                    <x-jet-input type='text' id="debt" wire:model='debt' class="block mt-1 w-full" />
                    @error('debt')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='points' value="{{__('عدد النقاط')}}" />
                    <x-jet-input type='number' id="points" wire:model='points' class="block mt-1 w-full" />
                    @error('points')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='shift_from' value="{{__('يبدء العمل من')}}" />
                    <x-jet-input type='time' id="shift_from" wire:model='shift_from' class="block mt-1 w-full" />
                    @error('shift_from')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='shift_to' value="{{__('الى')}}" />
                    <x-jet-input type='time' id="shift_to" wire:model='shift_to' class="block mt-1 w-full" />
                    @error('shift_to')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='spasial_com' value="{{__('العمولة الخاصة')}}" />
                    <x-jet-input type='text' id="spasial_com" wire:model='spasial_com' class="block mt-1 w-full" />
                    @error('spasial_com')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='ref' value="{{__('رابط التسويق')}}" />
                    <x-jet-input type='text' id="ref" wire:model='ref' class="block mt-1 w-full" />
                    @error('ref')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-jet-button wire:click='update' class="ml-2 main-btn"><i class="fas fa-edit"></i> {{__('التعديل')}}</x-jet-button>
                <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
            </x-slot>
        </x-jet-dialog-modal>
    </form>
    @if($recordData != null)
    <form autocomplete="off" action="{{route('dashboard.clients-update-password', $recordData->id)}}" method="POST">
        @csrf
        @method('PATCH')
        <x-jet-dialog-modal wire:model="updatePasswordFormVisible" class="">
            <x-slot name="title">{{ __('تعديل بيانات العضو') }}</x-slot>
            <x-slot name="content">
                <hr style="border-color:#000 !important">
                <div >
                    <div class="mt-4 relative">
                        <i wire:click="showPasswordF" class="fas fa-eye" style="position: absolute; top: 37px; left: 10px; color: #006EB9FF; cursor: pointer;"></i>
                        <x-jet-label for='password' value="{{__('كلمة المرور الجديدة')}}" />
                        <x-jet-input type="{{$showPassword == false ? 'password' : 'text'}}" id="password" name='password' wire:model='password' class="block mt-1 w-full"  autocomplete="new-password" />
                        @error('password')
                        <span class="text-red-500 mt-1">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mt-4 relative">
                        <i wire:click="showPasswordF" class="fas fa-eye" style="position: absolute; top: 37px; left: 10px; color: #006EB9FF; cursor: pointer;"></i>
                        <x-jet-label for='repassword' value="{{__('إعادة كلمة المرور الجديدة')}}" />
                        <x-jet-input type="{{$showPassword == false ? 'password' : 'text'}}" id="repassword" name='repassword' wire:model='repassword' class="block mt-1 w-full"  autocomplete="new-password" />
                        @error('repassword')
                        <span class="text-red-500 mt-1">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-jet-button wire:click='update' class="ml-2 main-btn"><i class="fas fa-edit"></i> {{__('التعديل')}}</x-jet-button>
                <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
            </x-slot>
        </x-jet-dialog-modal>
    </form>
    @endif
    {{-- End Update User Model --}}
    {{-- Start Delete User Model --}}
    @if (Auth::user()->role == 1)
    <x-jet-dialog-modal wire:model="deleteFormVisible">
        <x-slot name="title">{{ __('حذف العضو') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من قرار حذف العضو') }}</x-slot>
        <x-slot name="footer">
            <x-jet-danger-button wire:click='destroy' class="ml-2"><i class="fas fa-trash"></i> {{__('حذف')}}</x-jet-danger-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    @endif
    <x-jet-dialog-modal wire:model="balanceModelVisible">
        <x-slot name="title">{{ __('تسويه الديون') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من قرار تسويه ديون الاعضاء و خصم ديونهم من مستحقاتهم') }}</x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click='balanceFun' class="ml-2"><i class="fas fa-sack-dollar"></i>{{__('تسوية')}}</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    {{-- End Delete User Model --}}
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
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{ date('d-m-Y', strtotime($user->created_at))}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        <div class="grid grid-cols-12 gap-4 relative">
                            <div class="md:col-span-6 col-span-12">
                                <a href="{{route('admin.client-products', ['id' => $user->id])}}"
                                    class="w-full block items-center px-4 py-2 bg-gray-800 border border-transparent
                                    rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                    hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                                    focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-2">
                                    <i class="mr-2 fas fa-boxes"></i> {{__(' منتجات العضو')}}
                                </a>
                            </div>
                            <div class="md:col-span-6 col-span-12">
                                <x-jet-button wire:click="showUpdatePasswordModel({{$user->id}})" class="w-full block ml-2 main-btn editBtn"><i class="mr-2 fas fa-lock"></i> {{__(' تعديل كلمة المرور')}}</x-jet-button>
                            </div>
                            <div class="md:col-span-6 col-span-12">
                                <x-jet-button wire:click="showUpdateModel({{$user->id}})" class="w-full block ml-2 main-btn editBtn"><i class="mr-2 fas fa-edit"></i> {{__(' تعديل')}}</x-jet-button>
                            </div>
                            <div class="md:col-span-6 col-span-12">
                                @if (Auth::user()->role == 1)
                                    <x-jet-danger-button wire:click="confirmUserDelete({{$user->id}})" class="w-full block ml-2"><i class="mr-2 fas fa-trash-alt"></i> {{__(' حذف')}}</x-jet-danger-button>
                                @endif
                            </div>
                        </div>


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
@push('scripts')
    <script>
        document.querySelectorAll('.editBtn').forEach(Main => {
            Main.addEventListener('click', (e) => {
                Livewire.emit('mainTrigger');
            });
        });
        Livewire.on('editTrigger', function () {
            let get_download_buttons = document.querySelectorAll('.downloadFileBtn');
            get_download_buttons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    get_download_buttons = document.querySelectorAll('.downloadFileBtn');
                    console.log();
                    let data = e.target.dataset.filename;
                    Livewire.emit('download', data);

                });
            });
        });

    </script>
@endpush
