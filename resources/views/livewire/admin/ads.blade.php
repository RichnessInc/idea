<div>
    <h2 class="text-3xl mb-2">اعلانات البار العلوي</h2>
    <div class="bg-white p-2 shadow rounded">
        <div class="ads-container">
            <div>
                <h3>البنر</h3>
                <div class="mt-4">
                    <x-jet-label for='script' value="{{__('كود الاعلان')}}" />
                    <textarea class="form-input rounded-md shadow-sm mt-1 block w-full"
                    wire:model='script'
                    id="script" ></textarea>
                    @error('script')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='link' value="{{__('رابط الضغط على صورة الاعلان')}}" />
                    <input wire:model='link'
                    class="dark:bg-gray-900 dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                    type="url"
                    value=" ">
                    @error('link')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='image' value="{{__('صورة الاعلان')}}" />
                    <input wire:model='image'
                    class="dark:bg-gray-900 bg-white dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                    type="file" >
                    @error('image')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <br>
            <hr>
            <br>
            <div>
                <h3>الاعلان الاول</h3>
                <div class="mt-4">
                    <x-jet-label for='script2' value="{{__('كود الاعلان')}}" />
                    <textarea
                    class="page_text form-input rounded-md shadow-sm mt-1 block w-full"
                    wire:model='script2'
                    id="script2"></textarea>
                    @error('script2')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='link2' value="{{__('رابط الضغط على صورة الاعلان')}}" />
                    <input wire:model='link2'
                    class="dark:bg-gray-900 dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                    type="url"
                    value=" ">
                    @error('link2')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='image2' value="{{__('صورة الاعلان')}}" />
                    <input wire:model='image2'
                    class="dark:bg-gray-900 bg-white dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                    type="file" >
                    @error('image2')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <br>
            <hr>
            <br>
            <div>
                <h3>الاعلان الثاني</h3>
                <div class="mt-4">
                    <x-jet-label for='spare_phone' value="{{__('كود الاعلان')}}" />
                    <textarea class="page_text form-input rounded-md shadow-sm mt-1 block w-full"
                    wire:model='script3'
                    id="script3"></textarea>
                    @error('script3')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='link3' value="{{__('رابط الضغط على صورة الاعلان')}}" />
                    <input wire:model='link3'
                    class="dark:bg-gray-900 dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                    type="url"
                    value="">
                    @error('link3')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='image3' value="{{__('صورة الاعلان')}}" />
                    <input wire:model='image3'
                    class="dark:bg-gray-900 bg-white dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                    type="file" >
                    @error('image3')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-4">
                <x-jet-label for='status' value="{{__('حالة الاعلان')}}" />
                <div class="w-full">
                    <div class="relative">
                        <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        wire:model='status'
                        name='status'
                        id="status">
                            <option>حالة الاعلان</option>
                            <option value="0" {{($status == 0 ? 'selected' : '')}}>نشط</option>
                            <option value="1" {{($status == 1 ? 'selected' : '')}}>غير نشط</option>
                        </select>
                    </div>
                </div>
                @error('status')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <br>
            <x-jet-button wire:click="ads" class="main-btn mb-1 w-full"><i class="mr-2 fas fa-save"></i> {{__(' تحديث الاعلانات')}}</x-jet-button>
        </div>
    </div>
    <br><br>
    <h2 class="text-3xl mb-2">اعلانات البار السفلي</h2>
    <div class="bg-white p-2 shadow rounded">
        <div class="ads-container">
            <div>
                <h3>البنر</h3>
                <div class="mt-4">
                    <x-jet-label for='ads_2_script' value="{{__('كود الاعلان')}}" />
                    <textarea class="form-input rounded-md shadow-sm mt-1 block w-full"
                    wire:model='ads_2_script'
                    id="ads_2_script" ></textarea>
                    @error('ads_2_script')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='ads_2_link' value="{{__('رابط الضغط على صورة الاعلان')}}" />
                    <input wire:model='ads_2_link'
                    class="dark:bg-gray-900 dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                    type="url"
                    value=" ">
                    @error('ads_2_link')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='ads_2_image' value="{{__('صورة الاعلان')}}" />
                    <input wire:model='ads_2_image'
                    class="dark:bg-gray-900 bg-white dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                    type="file" >
                    @error('image')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <br>
            <hr>
            <br>
            <div>
                <h3>الاعلان الاول</h3>
                <div class="mt-4">
                    <x-jet-label for='ads_2_script2' value="{{__('كود الاعلان')}}" />
                    <textarea
                    class="page_text form-input rounded-md shadow-sm mt-1 block w-full"
                    wire:model='ads_2_script2'
                    id="ads_2_script2"></textarea>
                    @error('ads_2_script2')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='ads_2_link2' value="{{__('رابط الضغط على صورة الاعلان')}}" />
                    <input wire:model='ads_2_link2'
                    class="dark:bg-gray-900 dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                    type="url"
                    value=" ">
                    @error('ads_2_link2')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='ads_2_image2' value="{{__('صورة الاعلان')}}" />
                    <input wire:model='ads_2_image2'
                    class="dark:bg-gray-900 bg-white dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                    type="file" >
                    @error('ads_2_image2')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <br>
            <hr>
            <br>
            <div>
                <h3>الاعلان الثاني</h3>
                <div class="mt-4">
                    <x-jet-label for='ads_2_script3' value="{{__('كود الاعلان')}}" />
                    <textarea class="page_text form-input rounded-md shadow-sm mt-1 block w-full"
                    wire:model='ads_2_script3'
                    id="ads_2_script3"></textarea>
                    @error('ads_2_script3')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='ads_2_link3' value="{{__('رابط الضغط على صورة الاعلان')}}" />
                    <input wire:model='ads_2_link3'
                    class="dark:bg-gray-900 dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                    type="url"
                    value="">
                    @error('ads_2_link3')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for='ads_2_image3' value="{{__('صورة الاعلان')}}" />
                    <input wire:model='ads_2_image3'
                    class="dark:bg-gray-900 bg-white dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                    type="file" >
                    @error('ads_2_image3')
                    <span class="text-red-500 mt-1">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-4">
                <x-jet-label for='ads_2_status' value="{{__('حالة الاعلان')}}" />
                <div class="w-full">
                    <div class="relative">
                        <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        wire:model='ads_2_status'
                        name='ads_2_status'
                        id="ads_2_status">
                            <option>حالة الاعلان</option>
                            <option value="0" {{($ads_2_status == 0 ? 'selected' : '')}}>نشط</option>
                            <option value="1" {{($ads_2_status == 1 ? 'selected' : '')}}>غير نشط</option>
                        </select>
                    </div>
                </div>
                @error('ads_2_status')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <br>
            <x-jet-button wire:click="ads2" class="main-btn mb-1 w-full"><i class="mr-2 fas fa-save"></i> {{__(' تحديث الاعلانات')}}</x-jet-button>
        </div>
    </div>
</div>
