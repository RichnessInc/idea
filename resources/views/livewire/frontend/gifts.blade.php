<div>
    <div class="gifts-page">
        @if (!Auth::guard('clients')->check())
        <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 rounded shadow mb-4 g-alert" role="alert">
            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
            <p>عميلنا العزيز ، لا يمكنك شراء صناديق الحظ إلا اذا كنت مسجل في موقعنا  يمكنك <a href="{{route('frontend.register')}}">التسجيل</a> او <a href="{{route('frontend.login')}}">الدخول الى حسابك</a> </p>
        </div>
        @endif
        @if($pageInfo->content != null && $pageInfo->content != '')
        <div class="bg-white shadow mb-2 mt-2 py-3 px-4 rounded">
            {!! $pageInfo->content !!}
        </div>
        @endif

            <div class="gifts-container {{(Auth::guard('clients')->check() ? 'sing' : '')}}">
            @foreach ($gifts as $gift)
            <div class="gift" wire:click='createAddressModel({{$gift->id}})'>
                <img src="{{asset('images/giftbox.png')}}" alt="">
                <span>{{$gift->id}}</span>
            </div>
            @endforeach
        </div>
    </div>
    @if (Auth::guard('clients')->check())
    <x-jet-dialog-modal wire:model="createAddressVisible">

        <x-slot name="title">{{__('العناوين')}}</x-slot>
        <x-slot name="content">
            <div class="px-6 py-4">


                <div class="mt-4">

                    <div class="text-lg">
                        {{ __('العناوين السابقة') }}
                    </div>
                    @foreach ($address as $add)
                        <div class="bg-gray-300 shadow-xl sm:rounded-lg p-4 relative select-add {{($address_id == $add->id ? 'selelcted' : '')}}" wire:click="select_address({{$add->id}})">
                            <div class="main-content">
                                <p>{{$add->country->name}}</p>
                                <p>{{$add->government->name}}</p>
                            </div>
                        </div>
                        @endforeach
                </div>
            </div>
            <br><hr><br>
            <div class="text-lg">
                {{ __('اضافة عنوان') }}
            </div>
            <div class="mt-4">
                <x-jet-label for='street' value="{{__('الشارع')}}" />
                <x-jet-input type='text' id="street" wire:model='street' class="block mt-1 w-full" />
                @error('street')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='sector' value="{{__('المحافظة')}}" />
                <x-jet-input type='text' id="sector" wire:model='sector' class="block mt-1 w-full" />
                @error('sector')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='build_no' value="{{__('رقم البناء')}}" />
                <x-jet-input type='number' id="build_no" wire:model='build_no' class="block mt-1 w-full" />
                @error('build_no')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='floor' value="{{__('الدور')}}" />
                <x-jet-input type='number' id="floor" wire:model='floor' class="block mt-1 w-full" />
                @error('floor')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='unit_no' value="{{__('رقم الوحدة')}}" />
                <x-jet-input type='number' id="unit_no" wire:model='unit_no' class="block mt-1 w-full" />
                @error('unit_no')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='details' value="{{__('التفاصيل')}}" />
                <x-jet-input type='text' id="details" wire:model='details' class="block mt-1 w-full" />
                @error('details')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
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
        </x-slot>
        <x-slot name="footer">
        <x-jet-button wire:click='store' class="ml-2 main-btn"><i class="fas fa-receipt"></i> {{__('اضافة فاتورة')}}</x-jet-button>
        <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    @endif
</div>
