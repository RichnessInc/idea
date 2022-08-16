<div>
    <div class="rounded overflow-hidden shadow-lg bg-white w-full">
        <div class="px-6 py-4 w-full">
            <div class="mt-4">
                <x-jet-label for='facebook' value="{{__('فيسبوك')}}" />
                <x-jet-input type='text' id="facebook" wire:model='facebook' class="block mt-1 w-full" value="{{$data->facebook}}"/>
                @error('facebook')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='instgram' value="{{__('انستجرام')}}" />
                <x-jet-input type='text' id="instgram" wire:model='instgram' class="block mt-1 w-full" value="{{$data->instgram}}" />
                @error('instgram')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='twitter' value="{{__('تويتر')}}" />
                <x-jet-input type='text' id="twitter" wire:model='twitter' class="block mt-1 w-full" value="{{$data->twitter}}" />
                @error('twitter')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='snapchat' value="{{__('سناب شات')}}" />
                <x-jet-input type='text' id="snapchat" wire:model='snapchat' class="block mt-1 w-full" value="{{$data->snapchat}}" />
                @error('snapchat')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='whatsapp' value="{{__('واتساب')}}" />
                <x-jet-input type='text' id="whatsapp" wire:model='whatsapp' class="block mt-1 w-full" value="{{$data->whatsapp}}" />
                @error('whatsapp')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='telgram' value="{{__('تليجرام')}}" />
                <x-jet-input type='text' id="telgram" wire:model='telgram' class="block mt-1 w-full" value="{{$data->telgram}}" />
                @error('telgram')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='currency' value="{{__('سعر الدولار الواحد مقابل الريال السعودي')}}" />
                <x-jet-input type='text' id="currency" wire:model='currency' class="block mt-1 w-full" value="{{$data->currency}}" />
                @error('currency')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for='tel_fax' value="{{__('FAX')}}" />
                <x-jet-input type='tel' id="tel_fax" wire:model='tel_fax' class="block mt-1 w-full" value="{{$data->tel_fax}}" />
                @error('tel_fax')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='hot_line' value="{{__('رقم الهاتف')}}" />
                <x-jet-input type='tel' id="hot_line" wire:model='hot_line' class="block mt-1 w-full" value="{{$data->hot_line}}" />
                @error('hot_line')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='email' value="{{__('البريد الالكتروني')}}" />
                <x-jet-input type='email' id="email" wire:model='email' class="block mt-1 w-full" value="{{$data->email}}" />
                @error('email')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='address' value="{{__('العنوان')}}" />
                <x-jet-input type='text' id="address" wire:model='address' class="block mt-1 w-full" value="{{$data->address}}" />
                @error('address')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">

                <x-jet-label for='switch' value="{{__('حالة نظام المندوبين')}}" />
                <div class="w-full">
                    <div class="relative">
                        <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                wire:model='switch'
                                name='switch'
                                id="switch">
                            <option>حالة نظام المدوبين</option>
                            <option value="1" {{($data->senders_status == 1 ? 'selected' : '')}}>فعال</option>
                            <option value="0" {{($data->senders_status == 0 ? 'selected' : '')}}>غير فعال</option>
                        </select>
                    </div>
                </div>
                @error('switch')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror

            </div>
            <div class="mt-4">
            <x-jet-button wire:click='clearCache' class="ml-2 main-btn"><i class="fas fa-trash"></i> {{__(' مسح الكاش')}}</x-jet-button>
            </div>
        </div>
        <div class="px-6 py-4 w-full bg-gray-300">
            <x-jet-button wire:click='update' class="ml-2 main-btn"><i class="fas fa-save"></i> {{__(' تحديث')}}</x-jet-button>

        </div>
    </div>
</div>
