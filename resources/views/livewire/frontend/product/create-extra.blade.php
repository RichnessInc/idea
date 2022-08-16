<div>
    <form  wire:submit.prevent="store" enctype="multipart/form-data">
        <div class="bg-white rounded shadow p-2 mb-3">
            <h2 class="text-2xl">اضافة ملحق</h2>
            <div class="mt-4">
                <x-jet-label for='name' value="{{__('الاسم')}}" />
                <x-jet-input type='text' id="name" wire:model='name' class="block mt-1 w-full" />
                @error('name')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='price' value="{{__('السعر')}}" />
                <x-jet-input type='text' id="price" wire:model='price' class="block mt-1 w-full" />
                @error('price')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for='main_image' value="{{__('الصورة المصغرة')}}" />
                <x-jet-input type='file' id="main_image" wire:model='main_image' class="block mt-1 w-full" accept='image/*'/>
                @error('main_image')
                <span class="text-red-500 mt-1">{{$message}}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-jet-button type='submit' class="ml-2 main-btn"><i class="fas fa-plus"></i> {{__(' اضافة')}}</x-jet-button>
            </div>
        </div>
    </form>
        <hr>
        <h2 class="text-2xl">الملحقات السابقة</h2>
        <div class="grid grid-cols-12 gap-4">
            @foreach ($product->extras as $extra)
            <div class="md:col-span-4 col-span-12">
                <div class="bg-white rounded shadow p-2 mb-3 mt-2">
                    <br>
                    <img src="{{asset('uploads/'.$extra->main_image)}}" style="width: 50px" alt="">
                    <ul>
                        <li>الاسم : {{$extra->name}}</li>
                        <li>السعر : {{number_format($extra->price, 2)}} SAR</li>
                    </ul>
                    <br>
                    <x-jet-danger-button wire:click='removeExtra({{$extra->id}})' class="ml-2"><i class="fas fa-trash"></i> {{__(' حذف')}}</x-jet-danger-button>
                    <a href="{{route('frontend.product.edit-extra', ['id' => $extra->id])}}"  class="items-center px-4 py-2 bg-gray-800 border
                            border-transparent
                            rounded-md font-semibold text-xs text-white uppercase tracking-widest
                            hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                            focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-2 text-center main-btn">
                        <i class="fas fa-save"></i> {{__(' تعديل ملحق')}}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
</div>
