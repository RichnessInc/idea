<div>
    <div class="bg-white p-2 shadow rounded">
        <div class="home-container">
            <div class="mt-4">
                <x-jet-label for='slider_1'  class="mb-1" value="{{__('الاسليدر الاول')}}" />
                <div class="w-full">
                    <div class="relative">
                        <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                        wire:model='slider_1'
                        name='slider_1'     
                        id="slider_1">
                            <option>الحالة </option>
                            <option value="0" {{($slider_1 == 0 ? 'selected' : '')}}>نشط</option>
                            <option value="1" {{($slider_1 == 1 ? 'selected' : '')}}>غير نشط</option>
                        </select>
                    </div>
                </div>
                @error('slider_1')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='slider_2'  class="mb-1" value="{{__('الاسليدر الثاني')}}" />
                <div class="w-full">
                    <div class="relative">
                        <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                        wire:model='slider_2'
                        name='slider_2'     
                        id="slider_2">
                            <option>الحالة</option>
                            <option value="0" {{($slider_2 == 0 ? 'selected' : '')}}>نشط</option>
                            <option value="1" {{($slider_2 == 1 ? 'selected' : '')}}>غير نشط</option>
                        </select>
                    </div>
                </div>
                @error('slider_2')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='slider_3' class="mb-1"  value="{{__('الاسليدر الثالث')}}" />
                <div class="w-full">
                    <div class="relative">
                        <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                        wire:model='slider_3'
                        name='slider_3'     
                        id="slider_3">
                            <option>الحالة</option>
                            <option value="0" {{($slider_3 == 0 ? 'selected' : '')}}>نشط</option>
                            <option value="1" {{($slider_3 == 1 ? 'selected' : '')}}>غير نشط</option>
                        </select>
                    </div>
                </div>
                @error('slider_3')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='slider_4' class="mb-1" value="{{__('الاسليدر الرابع')}}" />
                <div class="w-full">
                    <div class="relative">
                        <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
                        wire:model='slider_4'
                        name='slider_4'     
                        id="slider_4">
                            <option>الحالة</option>
                            <option value="0" {{($slider_4 == 0 ? 'selected' : '')}}>نشط</option>
                            <option value="1" {{($slider_4 == 1 ? 'selected' : '')}}>غير نشط</option>
                        </select>
                    </div>
                </div>
                @error('slider_4')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <br>
            <x-jet-button wire:click="update" class="main-btn mb-1"><i class="mr-2 fas fa-save"></i> {{__('تحديث')}}</x-jet-button>
        </div>
    </div>
</div>
