<div>
    <x-jet-dialog-modal wire:model="createAddressVisible">

        <x-slot name="title">{{__('اضافة عنوان')}}</x-slot>
        <x-slot name="content">
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
            <x-jet-button wire:click='store' class="ml-2 main-btn"><i class="fas fa-plus"></i> {{__('اضافة عنوان')}}</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>



@if(!\Illuminate\Support\Facades\Auth::guard('clients')->check())
    <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 rounded shadow mb-4 g-alert" role="alert">
        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
        <p>عميلنا العزيز ، لا يمكنك شراء المنتج إلا اذا كنت مسجل في موقنا يمكنك <a href="{{route('frontend.register')}}">التسجيل</a> او <a href="{{route('frontend.login')}}">الدخول الى حسابك</a> </p>
    </div>
    @endif
    <div class="single-product-container">
        <div class="box relative images-container">
            <div class="main-image-box">
                <img class="shadow rounded" src="{{asset('uploads/'.$product->main_image)}}">
            </div>
            <div class="imgs">
                <img src="{{asset('uploads/'.$product->main_image)}}" class="active">
                @foreach(explode(',', $product->images) as $img)
                    <img src="{{asset('uploads/'.$img)}}">
                @endforeach
            </div>
            <h4 class="holder-head rounded">
                الإضافات
                <br>
                اضف منتجات تابعة مع المنتج تضاف مع الفاتورة او اضغط شراء دون اضافة شيء
            </h4>
            <div class="extras">
                @foreach($product->extras as $extra)
                    <div class="extra bg-white shadow rounded mb-2 p-2">
                        <ul>
                            <li>
                                <img src="{{asset('uploads/'.$extra->main_image)}}" class="rounded">
                            </li>
                            <li>{{$extra->name}}</li>
                            <li>{{number_format($extra->price, 2)}} SAR</li>
                            <li> <x-jet-input class="w-full mt-2" type="number" wire:model="extraQtyModel" /></li>
                            <li><x-jet-button class="w-full mt-2 main-btn" wire:click="addExtra({{$extra->id}})"><i class="fas fa-plus"></i></x-jet-button></li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="box product-info">
            <span class="store_name">{{$product->client->name}}</span>
            <h2 class="product_name">{{$product->name}}</h2>
            @if($discount > 0)
                <small class="price-dis">({{$discount}}%)-{{number_format( $product->price, 2)}} SAR</small>
                <p class="price">{{number_format(  $product->price - (($product->price * $discount) / 100 ), 2)}} SAR</p>
            @else
            <p class="price">{{number_format( $product->price, 2)}} SAR</p>
            @endif
            <hr>
            <p class="desc">{{$product->desc}}</p>
            <hr>
            <ul class="py-2">



                <li class="mb-1">الوزن :  {{$product->wight}} جرام </li>
                <li class="mb-1">الطول : {{$product->height}} cm</li>
                <li>العرض :  {{$product->width}} cm</li>
            </ul>
            <hr>
            <br>
            <h3>فروع التاجر</h3>
            <ul class="address-list">
                @foreach($branches as $branch)
                    <li class="shadow rounded {{$branch_id == $branch->id ? 'active' : ''}}" wire:click="chooseBranch({{$branch->id}})">
                        {{$branch->government->name}}
                        <small>{{$branch->sector}}</small>
                    </li>
                @endforeach
            </ul>
            <hr
            @if(\Illuminate\Support\Facades\Auth::guard('clients')->check())
                @if($address != null && count($address) > 0)
                    <h3>عناوين المشتري</h3>
                    <ul class="address-list">
                        @foreach($address as $add)
                            <li class="shadow rounded {{$address_id == $add->id ? 'active' : ''}}" wire:click="chooseAddress({{$add->id}})">
                                {{$add->government->name}}
                                <small>{{$add->sector}}</small>
                            </li>
                        @endforeach
                        <li class="shadow rounded" wire:click='createAddressModel'>
                            اضافة عنوان
                        </li>
                    </ul>
                @else
                    <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 rounded shadow mb-4 g-alert" role="alert">
                        <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                        <p>لا يوجد عناوين مسجله يمكنك اضافة عنوان من  <a href="{{route('frontend.profile')}}">هنا</a> </p>
                    </div>
                @endif
            @endif
            <hr>
            @if(\Illuminate\Support\Facades\Auth::guard('clients')->check())
                <h3>طرق الشحن المتاحة</h3>
                <ul class="shipping-ways">
                    @if($address_id != null && count($shipping_methods) > 0)
                        @foreach($shipping_methods as $shipping_method)
                            @if($shipping_method_q != null)
                                <li class="shadow rounded w-full {{($shipping_method_q->id == $shipping_method->id ? 'active' : '')}}" wire:click="choose_shipping_method({{$shipping_method->id}})">
                                @else
                                <li class="shadow rounded w-full" wire:click="choose_shipping_method({{$shipping_method->id}})">
                                @endif
                                {{$shipping_method->name}}
                                <span class="block">{{number_format($shipping_method->price, 2)}} SAR</span>
                            </li>
                        @endforeach
                    @else
                        <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 rounded shadow mb-4 g-alert" role="alert">
                            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                            <p>يجب عليك اختيار عنوان اولا</p>
                        </div>
                    @endif
                </ul>
            @endif
        </div>
        <div class="box">
            <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 rounded shadow mb-4 g-alert" role="alert">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"></path></svg>
                <p> زر شراء يوفر لك دفع لسلعة واحدة او عدة سلع من تجار مختلفين لعدة عنواين مختلفة ووسائل شحن مختلفة .
                    زر شراء سلع مجمعة به ميزة في حالة الشراء عدد من السلع من نفس الفرع للتاجر ونفس وسيلة الشحن ونفس العنوان يوفر لك في ثمن الشحن بحيث يصبح في حقيبة توصيل مجمعة فقط حال توفر الشروط كاملة</p>
            </div>
            <div class="holder shadow bill bg-white rounded mt-4">
                <div class="flex justify-between p-1 mb-1">
                    <x-jet-input type="number" wire:model="productQtyModel" value="{{$productQty}}"/>
                    <x-jet-button class="main-btn rounded border-0 outline-none" wire:click="addProductQty">اضافة</x-jet-button>
                </div>
                <hr>
                <h3>الفاتورة</h3>
                <hr>
                <ul class="py-2">
                    <li>
                        <span class="block name">{{$product->name}}</span>
                        <span class="block qty">x<span>{{$productQty}}</span></span>
                        <span class="block total"> <span>{{number_format( $product->price, 2)}}</span> SAR</span>
                    </li>
                </ul>
                <hr>
                @foreach($items as $item)
                    <ul class="py-2">
                        <li>
                            <span class="block name">{{$item['name']}}</span>
                            <span class="block qty">x<span>{{$item['qty']}}</span></span>
                            <span class="block total"> <span>{{number_format($item['price'], 2)}}</span> SAR</span>
                        </li>
                    </ul>
                    <hr>
                @endforeach
                <ul class="py-2 total">
                    <li>الشحن : <span>{{number_format($shipping_cost, 2)}} SAR</span></li>
                    <li>الاجمالي : <span>{{number_format(($product->price * $productQty) + $shipping_cost + $totalPrice, 2)}} SAR</span></li>
                </ul>
                <hr>
                @if(\Illuminate\Support\Facades\Auth::guard('clients')->check())
                <div class="btns-container">
                    <x-jet-button class="main-btn w-full" wire:click="add_fev"><i class="fas fa-heart"></i>المفضلة </x-jet-button>
                    <x-jet-button class="main-btn w-full" wire:click="buy">شراء</x-jet-button>
                </div>
                <br>
                <x-jet-button class="main-btn w-full" wire:click="buyCollection">شراء سلع مجمعة</x-jet-button>
                <br>
                @endif
            </div>
        </div>
    </div>
    <br>
    <hr>
    <br>
    @if($hasTestimonial != null)
    <div class="card bg-white shadow rounded p-4 mb-4">
        <div class="mt-4">
            <label for="#rating-message" class="block">اترك رسالة</label>
            <label class="block">
                <textarea id="rating-message" wire:model="rating_message" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full" style="height: 200px"></textarea>
            </label>
            @error('rating_message')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>
        <div class="mt-4">
            <label for="#rating" class="block">قيم من 0 الى 5</label>
            <x-jet-input id="rating" wire:model="rate" type="number" min="0" max="5" class="w-full" />
            @error('rating')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>

        <div class="mt-4">
            <x-jet-button wire:click="submit_rate({{$hasTestimonial->id}})" class="main-btn">تقيم</x-jet-button>
        </div>
    </div>
    @endif
    @if($testimonials->count() == 0)
        <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 rounded shadow mb-4 g-alert" role="alert">
            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
            لا يوجد تقييمات متاحة للمنتج حتى الان
        </div>
    @else
        {{-- <div class="grid grid-cols-12 gap-4 relative"> --}}
            @foreach($testimonials as $testimonial)
            {{-- <div class="md:col-span-4 col-span-12"> --}}
                <div class="shadow bg-white rounded overflow-hidden mb-3">
                    <div class="px-6 py-4">
                        <div class="max-w-xl">
                            <div class="flex mr-3">
                                <div class="ml-3">
                                    <img style="width: 45px;" src="https://ui-avatars.com/api/?name={{$testimonial->client->name}}&color=7F9CF5&background=EBF4FF" alt="" class="rounded-full">
                                </div>
                                <div>
                                    <h1 class="font-semibold">{{$testimonial->client->name}}</h1>
                                    <p class="text-xs text-gray-500">{{ date('d-m-Y', strtotime($testimonial->created_at))}}</p>
                                </div>
                            </div>
                            <p class="mb-2 mt-2">{{$testimonial->message}}</p>
                            @for($i = 1; $i <= $testimonial->rate; $i++)
                                <i class="fas fa-star" style="color:#FFD700;"></i>
                            @endfor
                        </div>
                    </div>
                </div>
            {{-- </div> --}}
            @endforeach
        {{-- </div> --}}
    @endif
    <br>
    <div class="mx-1">
        {{$testimonials->links()}}
    </div>
</div>
