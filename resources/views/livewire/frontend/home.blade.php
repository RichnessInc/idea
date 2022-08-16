<div>
    @if (session()->has('message'))
    <div class="alert alert-success shadow text-white text-lg p-2 m-2" style="background-color: #5faf42; margin: 20px; border-radius: 0.25rem; }">
        {{ session('message') }}
    </div>
    @endif
    {{-- Start Upper Ads --}}
    @if($upper_ads->status == 0)
    <div class="py-12 p-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="head-banner"><i class="fas fa-info"></i>إعلانات</div>
            <section class="upper_ads">
                <div class="upper-container">
                    @if($upper_ads->script != null)
                    <div class="ad shadow">{!! $upper_ads->script!!}</div>
                    @else
                    <div class="ad shadow"><a href="{{$upper_ads->link}}"><img loading="lazy" src="{{asset('uploads/'. $upper_ads->image)}}" alt="Ad"></a></div>
                    @endif
                    @if($upper_ads->script2 != null)
                    <div class="ad shadow">{!!$upper_ads->script2!!}</div>
                    @else
                    <div class="ad shadow"><a href="{{$upper_ads->link2}}"><img loading="lazy" src="{{asset('uploads/'. $upper_ads->image2)}}" alt="Ad"></a></div>
                    @endif
                    @if($upper_ads->script3 != null)
                    <div class="ad shadow">{!! $upper_ads->script3 !!}</div>
                    @else
                    <div class="ad shadow"><a href="{{$upper_ads->link3}}"><img loading="lazy" src="{{asset('uploads/'. $upper_ads->image3)}}" alt="Ad"></a></div>
                    @endifø
                </div>
            </section>
        </div>
    </div>
    @endif
    <hr>
    <header>
        <img src="{{asset('images/peacock.jpg')}}" class="peacock-header" alt="peacock" >
    </header>
    {{-- End Upper Ads --}}
    {{-- Start Search Bar --}}
    <div class="search_bar p-1">
        <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="head-banner"><i class="fas fa-search"></i>  البحث </h2>
        <ul  class="mt-4">
        <li>
        <x-jet-label for='name' value="{{__('اسم المنتج')}}" />
        <x-jet-input type='text' id="name" wire:model='name' class="block mt-1 w-full" />
        @error('name')
        <span class="text-red-500 mt-1">{{$message}}</span>
        @enderror
        </li>
        <li>
        <x-jet-label for='category_id-add' value="{{__('التصنيف')}}" />
        <div class="w-full">
        <div class="relative">
        <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
        wire:model='category_id'
        name='category_id'
        id="category_id-add">
        <option>التصنيف</option>
        @foreach ($categories as $category)
        <option value="{{$category->id}}">{{$category->name}}</option>
        @endforeach
        </select>
        </div>
        </div>
        @error('category_id')
        <span class="text-red-500 mt-1">{{$message}}</span>
        @enderror
        </li>
        <li>
        <x-jet-label for='price' value="{{__('السعر')}}" />
        <div class="w-full">
        <div class="relative">
        <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
        wire:model='price'
        name='price'
        id="price">
        <option>السعر</option>
        <option value="1">السعر اقل اولا</option>
        <option value="0">السعر الاعلى اولا</option>
        </select>
        </div>
        </div>
        @error('price')
        <span class="text-red-500 mt-1">{{$message}}</span>
        @enderror
        </li>
        <li>
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
        </li>
        <li>
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
        </li>
        <li>
        <x-jet-label for='store_id' value="{{__('المتجر')}}" />
        <div class="w-full">
        <div class="relative">
        <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
        wire:model='store_id'
        name='store_id'
        id="store_id">
        <option>المتجر</option>
        @foreach ($stores as $store)
        <option value="{{$store->id}}">{{$store->name}}</option>
        @endforeach
        </select>
        </div>
        </div>
        @error('store_id')
        <span class="text-red-500 mt-1">{{$message}}</span>
        @enderror
        </li>
        </ul>
        <x-jet-label style="opacity: 0" for='category_id-add' value="{{__('بحث')}}" />
        <x-jet-button  aria-label="Search button" wire:click='search' class="ml-2 main-btn"><i class="fas fa-search"></i> {{__(' بحث')}}</x-jet-button>
        <br>
        @if($this->fire_search == true)
        <div class="relative">
        <button  aria-label="Close Search Button" class="close_search" wire:click="close_search"><i class="fas fa-times"></i></button>
        <div class="products-container show mt-10">
        @if($search_data != null)
        @foreach($search_data as $product)
        <a aria-label="Product Link" href="{{($product->slug != null ? route('frontend.single-product', ['slug'=>$product->slug]) : '') }}" class="bg-white shadow product">
        <div class="p-2">
        <img loading="lazy" src="{{asset('uploads/'.$product->main_image)}}" alt="{{($product->slug != null ? $product->slug : 'Image Alt')}}">
        <h3>{{$product->name}}</h3>
        <p class="price">{{number_format($product->price, 2)}} SAR</p>
        </div>
        <hr>
        <div class="p-2">
        <div class="info">
        <p>اسم المتجر</p>
        <p>{{$product->client->name}}</p>
        </div>
        <div class="info">
        <p>التصنيف</p>
        <p>{{$product->category->name}}</p>
        </div>
        </div>
        </a>
        @endforeach
        @endif
        </div>
        @if($search_data != null)
        {{$search_data->links()}}
        @endif
        </div>
        @endif
        </div>
        </div>
        <hr>
    </div>
    {{-- Start Search Bar --}}

    {{-- Start About Us --}}
    <section id="about-us">
    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="head-banner"><i class="fas fa-info"></i> من نحن </h2>
    <div class="landing-container">
    <div class="text">
    <ul>
    <li><span>1</span> مؤسسة سعوديه انشئت عام 2020 بسجل تجاري رقم 5909629033  </li>
    <li><span>2</span> نوفر لكم خدمة الإختيار دون عناء .  </li>
    <li><span>3</span> وفرنا طرق دفع مختلفة لراحة عملائنا .  </li>
    <li><span>4</span> أوجدنا طرق توصيل مختلفه حسب ما يتناسب مع رغبتك .  </li>
    <li><span>5</span> نساهم في صنع بهجتك وبهجة من تحب بكل ود.  </li>
    </ul>
    </div>
    <div class="image"><img loading="lazy" src="{{asset('images/about-us.png')}}" alt="About us"></div>
    </div>
    </div>
    </div>
    </section>
    {{-- End About Us --}}
    <div class="py-12 top-sale-con relative">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="head-banner"><i class="fas fa-fire"></i>المنتجات الاكثر مبيعا</h2>
    <section id="top-sealing-products">
    @if($homepageSettings->slider_1 == 0)
    <?php $c = 0; ?>
    @foreach($top_sales_products as $top_products)
    <?php $c++ ?>
    <div class="products-container {{($loop->first ? 'show' : '')}}" id="top-num-{{$c}}" data-num="{{$c}}" data-status="{{$homepageSettings->slider_1}}">
    @foreach($top_products as $top_product)
    <a aria-label="Product Link"  href="{{($top_product['slug'] != null ? route('frontend.single-product', ['slug'=>$top_product['slug']]) : '') }}" class="bg-white shadow product">
    <div class="p-2">
    <img loading="lazy" src="{{asset('uploads/'.$top_product['main_image'])}}" alt="{{($top_product['slug'] != null ? $top_product['slug'] : 'Image Alt')}}">
    <h3>{{$top_product['name']}}</h3>
    <p class="price">{{number_format($top_product['price'], 2)}} SAR</p>
    </div>
    <hr>
    <div class="p-2">
    <div class="info">
    <p>اسم المتجر</p>
    <p>{{$top_product['store']}}</p>
    </div>
    <div class="info">
    <p>التصنيف</p>
    <p>{{$top_product['category']}}</p>
    </div>
    </div>
    </a>
    @endforeach
    </div>
    @endforeach
    @else
    <div class="products-container show"  data-status="{{$homepageSettings->slider_1}}">
    @foreach($top_sales_products as $top_product)
    <a  aria-label="Product Link" href="{{($top_product->slug != null ? route('frontend.single-product', ['slug'=>$top_product->slug]) : '') }}" class="bg-white shadow product no-slide">
    <div class="p-2">
    <img src="{{asset('uploads/'.$top_product->main_image)}}"  alt="{{($top_product->slug != null ? $top_product->slug : 'Image Alt')}}">
    <h3>{{$top_product->name}}</h3>
    <p class="price">{{number_format($top_product->price, 2)}} SAR</p>
    </div>
    <hr>
    <div class="p-2">
    <div class="info">
    <p>اسم المتجر</p>
    <p>{{$top_product->client->name}}</p>
    </div>
    <div class="info">
    <p>التصنيف</p>
    <p>{{$top_product->category->name}}</p>
    </div>
    </div>
    </a>
    @endforeach
    </div>
    @endif
    </section>
    </div>
    <div class="progressbar"></div>
    </div>
    {{-- Start About Us --}}
    <section id="why-us">
    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="head-banner"><i class="fas fa-question"></i> لماذا نحن</h2>
    <div class="landing-container">
    <div class="text">
    <ul>
    <li><span>1</span> سهلنا وصول التاجر بالعميل بأفضل طريقة.  </li>
    <li><span>2</span> وفرنا الوقت والجهد والمال على العملاء.  </li>
    <li><span>3</span> إستخدام أحدث الطرق في الإهداء وإقامة الحفلات .  </li>
    <li><span>4</span> اتحنا فرصة التسويق بالعمولة للربح من الموقع .  </li>
    <li><span>5</span> اوجدنا نظام للنقاط والإسترداد النقدي لمكافئة العملاء .  </li>
    </ul>
    </div>
    <div class="image"><img loading="lazy" src="{{asset('images/why-us.png')}}" alt="Why Us"></div>
    </div>
    </div>
    </div>
    </section>
    {{-- End About Us --}}
    {{-- End Tickets --}}
    <section id="Tickets">
    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="head-banner"><i class="fas fa-ticket-alt"></i> قسائم الشراء </h2>
    <div class="landing-container">
    <div class="holder">
    <p>يمكنك شراء قسائم شراء لأشخاص يهمك امرهم</p>
    <a aria-label="Ticket Link"  href="{{route('frontend.ticket')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded main-btn">شراء</a>
    </div>
    </div>
    </div>
    </div>
    </section>
    {{-- End Tickets --}}
    <div class="py-12 down-products relative">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="head-banner"><img loading="lazy" src="{{asset('images/icons/dollar.png')}}" alt="products">المنتجات الاقل سعرا</h2>
    <section id="down-products">
    @if($homepageSettings->slider_2 == 0)
    <?php $c = 0; ?>
    @foreach($down_price_products as $top_products)
    <?php $c++ ?>
    <div class="products-container {{($loop->first ? 'show' : '')}}" id="down-num-{{$c}}" data-num="{{$c}}"  data-status="{{$homepageSettings->slider_2}}">
    @foreach($top_products as $top_product)
    <a   aria-label="Product Link" href="{{($top_product['slug'] != null ? route('frontend.single-product', ['slug'=>$top_product['slug']]) : '') }}" class="bg-white shadow product">
    <div class="p-2">
    <img loading="lazy" src="{{asset('uploads/'.$top_product['main_image'])}}"  alt="{{($top_product['slug'] != null ? $top_product['slug'] : 'Image Alt')}}">
    <h3>{{$top_product['name']}}</h3>
    <p class="price">{{number_format($top_product['price'], 2)}} SAR</p>
    </div>
    <hr>
    <div class="p-2">
    <div class="info">
    <p>اسم المتجر</p>
    <p>{{$top_product['store']}}</p>
    </div>
    <div class="info">
    <p>التصنيف</p>
    <p>{{$top_product['category']}}</p>
    </div>
    </div>
    </a>
    @endforeach
    </div>
    @endforeach
    @else
    <div class="products-container show"  data-status="{{$homepageSettings->slider_2}}">
    @foreach($down_price_products as $top_product)
    <a  aria-label="Product Link" href="{{($top_product->slug != null ? route('frontend.single-product', ['slug'=>$top_product->slug]) : '') }}" class="bg-white shadow product no-slide">
    <div class="p-2">
    <img loading="lazy" src="{{asset('uploads/'.$top_product->main_image)}}" alt="{{($top_product->slug != null ? $top_product->slug : 'Image Alt')}}">
    <h3>{{$top_product->name}}</h3>
    <p class="price">{{number_format($top_product->price, 2)}} SAR</p>
    </div>
    <hr>
    <div class="p-2">
    <div class="info">
    <p>اسم المتجر</p>
    <p>{{$top_product->client->name}}</p>
    </div>0
    <div class="info">
    <p>التصنيف</p>
    <p>{{$top_product->category->name}}</p>
    </div>
    </div>
    </a>
    @endforeach
    </div>
    @endif
    </section>
    </div>
    <div class="progressbar"></div>
    </div>
    {{-- Start About Us --}}
    <section id="steps">
    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="head-banner"><img loading="lazy" src="{{asset('images/icons/goal.png')}}" alt="Goal"> خطوات العمل </h2>
    <div class="landing-container">
    <div class="text">
    <ul>
    <li><span>1</span> كتاجر او صانع هدايا ؛ يتوجب عليك إتمام بياناتك حتى يتم الموافقة على حسابك .  </li>
    <li><span>2</span> بإمكانك إضافة عدد لا محدود من المنتجات مع العديد من المزايا بعد تفعيل حسابك. </li>
    <li><span>3</span> لمزيد من ثقة عملائنا لايتم قبول سوى المتاجر المعتمدة من وزارة التجارة.  </li>
    <li><span>4</span>  سيتم إحتساب عموله مدى الحياة لكل مسوق عن كل مشتري من طرفه .  </li>
    <li><span>5</span>  لم ننسى مندوبوا التوصيل من إتاحة الفرصة لهم لزيادة دخلهم .  </li>


    </ul>
    </div>
    <div class="image"><img loading="lazy" src="{{asset('images/steps.png')}}" alt="Steps"></div>
    </div>
    </div>
    </div>
    </section>
    {{-- End About Us --}}
    <div class="py-12 pricetop relative">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="head-banner"><i class="fas fa-coins"></i>المنتجات الاكثر سعرا</h2>
    <section id="top-price-products">
    @if($homepageSettings->slider_3 == 0)
    <?php $c = 0; ?>
    @foreach($top_price_products as $top_products)
    <?php $c++ ?>
    <div class="products-container {{($loop->first ? 'show' : '')}}" id="price-num-{{$c}}" data-num="{{$c}}" data-status="{{$homepageSettings->slider_3}}">
    @foreach($top_products as $top_product)
    <a  aria-label="Product Link" href="{{($top_product['slug'] != null ? route('frontend.single-product', ['slug'=>$top_product['slug']]) : '') }}" class="bg-white shadow product">
    <div class="p-2">
    <img loading="lazy" src="{{asset('uploads/'.$top_product['main_image'])}}" alt="{{($top_product['slug'] != null ? $top_product['slug'] : 'Image Alt')}}">
    <h3>{{$top_product['name']}}</h3>
    <p class="price">{{number_format($top_product['price'], 2)}} SAR</p>
    </div>
    <hr>
    <div class="p-2">
    <div class="info">
    <p>اسم المتجر</p>
    <p>{{$top_product['store']}}</p>
    </div>
    <div class="info">
    <p>التصنيف</p>
    <p>{{$top_product['category']}}</p>
    </div>
    </div>
    </a>
    @endforeach
    </div>
    @endforeach
    @else
    <div class="products-container show" data-status="{{$homepageSettings->slider_3}}">
    @foreach($down_price_products as $top_product)
    <a aria-label="Product Link"  href="{{($top_product->slug != null ? route('frontend.single-product', ['slug'=>$top_product->slug]) : '') }}" class="bg-white shadow product no-slide">
    <div class="p-2">
    <img loading="lazy" src="{{asset('uploads/'.$top_product->main_image)}}" alt="{{($top_product->slug != null ? $top_product->slug : 'Image Alt')}}">
    <h3>{{$top_product->name}}</h3>
    <p class="price">{{number_format($top_product->price, 2)}} SAR</p>
    </div>
    <hr>
    <div class="p-2">
    <div class="info">
    <p>اسم المتجر</p>
    <p>{{$top_product->client->name}}</p>
    </div>
    <div class="info">
    <p>التصنيف</p>
    <p>{{$top_product->category->name}}</p>
    </div>
    </div>
    </a>
    @endforeach
    </div>
    @endif
    </section>
    </div>
    <div class="progressbar"></div>
    </div>
    <hr>
    <div class="py-12 pricetop relative">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="head-banner">المنتجات المضافة حديثا</h2>
    <section id="top-price-products">
    @if($homepageSettings->slider_4 == 0)
    <?php $c = 0; ?>
    @foreach($Latest_products as $top_products)
    <?php $c++ ?>
    <div class="products-container {{($loop->first ? 'show' : '')}}" id="price-num-{{$c}}" data-num="{{$c}}" data-status="{{$homepageSettings->slider_3}}">
    @foreach($top_products as $top_product)
    <a  aria-label="Product Link" href="{{($top_product['slug'] != null ? route('frontend.single-product', ['slug'=>$top_product['slug']]) : '') }}" class="bg-white shadow product">
    <div class="p-2">
    <img loading="lazy" src="{{asset('uploads/'.$top_product['main_image'])}}" alt="{{($top_product['slug'] != null ? $top_product['slug'] : 'Image Alt')}}">
    <h3>{{$top_product['name']}}</h3>
    <p class="price">{{number_format($top_product['price'], 2)}} SAR</p>
    </div>
    <hr>
    <div class="p-2">
    <div class="info">
    <p>اسم المتجر</p>
    <p>{{$top_product['store']}}</p>
    </div>
    <div class="info">
    <p>التصنيف</p>
    <p>{{$top_product['category']}}</p>
    </div>
    </div>
    </a>
    @endforeach
    </div>
    @endforeach
    @else
    <div class="products-container show" data-status="{{$homepageSettings->slider_3}}">
    @foreach($Latest_products as $top_product)
    <a  aria-label="Product Link" href="{{($top_product->slug != null ? route('frontend.single-product', ['slug'=>$top_product->slug]) : '') }}" class="bg-white shadow product no-slide">
    <div class="p-2">
    <img loading="lazy" src="{{asset('uploads/'.$top_product->main_image)}}" alt="{{($top_product['slug'] != null ? $top_product->slug : 'Image Alt')}}">
    <h3>{{$top_product->name}}</h3>
    <p class="price">{{number_format($top_product->price, 2)}} SAR</p>
    </div>
    <hr>
    <div class="p-2">
    <div class="info">
    <p>اسم المتجر</p>
    <p>{{$top_product->client->name}}</p>
    </div>
    <div class="info">
    <p>التصنيف</p>
    <p>{{$top_product->category->name}}</p>
    </div>
    </div>
    </a>
    @endforeach
    </div>
    @endif
    </section>
    </div>
    <div class="progressbar"></div>
    </div>
    <br>
    {{-- Start Down Ads --}}
    @if($down_ads->status == 0)
    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="head-banner"><i class="fas fa-info"></i>إعلانات</div>
    <section class="upper_ads">
    <div class="upper-container">
    @if($down_ads->script != null)
    <div class="ad shadow">{!!$down_ads->script !!}</div>
    @else
    <div class="ad shadow"><a  aria-label="Ad Link"  href="{{$down_ads->link}}"><img loading="lazy" src="{{asset('uploads/'. $down_ads->image)}}" alt="Ad"></a></div>
    @endif

    @if($down_ads->script2 != null)
    <div class="ad shadow">{!! $down_ads->script2 !!}</div>
    @else
    <div class="ad shadow"><a  aria-label="Ad Link"  href="{{$upper_ads->link2}}"><img loading="lazy" src="{{asset('uploads/'. $down_ads->image2)}}" alt="Ad"></a></div>
    @endif

    @if($down_ads->script3 != null)
    <div class="ad shadow">{!! $down_ads->script3!!}</div>
    @else
    <div class="ad shadow"><a  aria-label="Ad Link"  href="{{$down_ads->link3}}"><img loading="lazy" src="{{asset('uploads/'. $down_ads->image3)}}" alt="Ad"></a></div>
    @endif
    </div>
    </section>
    </div>
    </div>
    @endif
    {{-- Start Down Ads --}}
</div>
