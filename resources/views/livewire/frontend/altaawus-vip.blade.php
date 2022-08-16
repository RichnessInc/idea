<div>
    <x-jet-dialog-modal wire:model="createAddressVisible">
        <x-slot name="title">{{__('اضافة طلب')}}</x-slot>
        <x-slot name="content">
            <hr style="border-color:#000 !important">

            <div class="mt-4">
                <x-jet-label for='email' value="{{__('البريد الإلكتروني')}}" />
                <x-jet-input type='email' id="email" wire:model='email' class="block mt-1 w-full" />
                @error('email')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='whatsapp_phone' value="{{__('رقم الواتساب')}}" />
                <x-jet-input type='tel' id="whatsapp_phone" wire:model='whatsapp_phone' class="block mt-1 w-full" />
                @error('whatsapp_phone')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
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
        <x-jet-button wire:click='store' class="ml-2 main-btn"><i class="fas fa-plus"></i> {{__(' اضافة')}}</x-jet-button>
        <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    <div class="bg-white shadow mb-2 mt-2 py-3 px-4 rounded">
        {!! $pageIn->text !!}
    </div>
    <div class="grid grid-cols-12 gap-4">
        @foreach ($methods as $method)
            <div class="col-span-12 lg:col-span-4">
                @if ($method->id != 3)
                    <div class="method shadow" wire:click='createAddressModel({{$method->id}})'>
                        <div>
                            <h3>{{$method->name}}</h3>
                            <p>{{number_format($method->price, 2)}} SAR</p>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
