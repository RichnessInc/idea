<div>
    <div class="grid grid-cols-12 gap-4 relative">
        <div class="md:col-span-6 col-span-12">
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
                    <span class=" text-yellow-500 mt-1">يجب رفع بطاقة الهوية الوطنية و السجل التجاري
أو إعتماد معروف أو وثيقة العمل الحر لاعتماد الحساب
                    </span>
                    @elseif($type == 2)
                    <span class=" text-yellow-500 mt-1">يجب رفع بطاقة الهوية ليتم تفعيل حسابك (يمكنك تجميع صور المستندات في ملف PdF)</span>
                    @elseif($type == 3)
                    <span class=" text-yellow-500 mt-1"> يجب إرفاق الهوية ورخصة واستمارة أو تفويض قيادة لإعتماد الحساب.</span>
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
                    <div class="mt-4 relative passwordInputValidation">
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
            <div class="mt-4" wire:ignore>
                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display(['data-callback' => 'onCallback']) !!}
            </div>
            <div class="mt-4">
                <input type="checkbox" name="terms" wire:model="terms">
                 يجب الموافقة على <a href="{{URL::to('pages/terms')}}" style="color: #0000ff;text-underline: #00aeef"> الشروط والاحكام </a>
            </div>
            <div class="mt-4">
                <x-jet-button class="ml-2 main-btn" id="regbtn">
                    @if($showSpinner == false)
                     <i class="fas fa-user-plus"></i>{{__(' تسجيل')}}</x-jet-button>
                     @else
                     <img src="{{asset('images/spinners/loading.svg')}}" style='width: 34px'>
                     @endif
            </div>
        </div>
        <div class="md:col-span-6 col-span-12">
           <div class="holder">
               <div class="video">
                   <iframe width="560" height="315" src="https://www.youtube.com/embed/iUEnu96vjjw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
               </div>
           </div>
        </div>
    </div>
    @push('scripts')
    <script>
        var onCallback = function () {
            @this.set('recaptcha', grecaptcha.getResponse());
        };
    </script>
    @endpush
    <script>
        document.getElementById('regbtn').addEventListener('click', function () {
            let data = "{{request()->get('ref')}}";
            Livewire.emit('postAdded', {ref : data})

        });
    </script>
</div>

