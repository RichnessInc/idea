<div>

<div class="mx-1 md:mx-0 clients-counter grid grid-cols-12 gap-4 mb-6">
<div class="col-span-12 md:col-span-4">
    <div class="rounded overflow-hidden shadow-lg bg-white w-full border-2 border-blue-400">
        <div class="px-6 py-4 w-full text-center">
            <h3 class="text-xl">المستحقات</h3>
            <span class="text-2xl text-blue-400 font-extrabold"  style="direction: ltr;display:block;">{{number_format(Auth::guard('clients')->user()->wallet,2)}} SAR</span>
        </div>
    </div>
</div>
<div class="col-span-12 md:col-span-4">
    <div class="rounded overflow-hidden shadow-lg bg-white w-full border-2 border-blue-400">
        <div class="px-6 py-4 w-full text-center">
            <h3 class="text-xl">الديون</h3>
            <span class="text-2xl text-blue-400 font-extrabold" style="direction: ltr;display:block;">{{number_format(Auth::guard('clients')->user()->debt,2)}} SAR</span>
        </div>
    </div>
</div>
<div class="col-span-12 md:col-span-4">
    <div class="rounded overflow-hidden shadow-lg bg-white w-full border-2 border-blue-400">
        <div class="px-6 py-4 w-full text-center">
            <h3 class="text-xl">النقاط</h3>
            <span class="text-2xl text-blue-400 font-extrabold" style="direction: ltr;display:block;">{{number_format(Auth::guard('clients')->user()->points)}}</span>
        </div>
    </div>
</div>
</div>

<div class="mx-1 md:mx-0 clients-counter grid grid-cols-12 gap-4 mb-6">
@if($packages != null)
    @foreach($packages as $package)
        <div class="col-span-12 md:col-span-4">
            <div class="rounded overflow-hidden shadow-lg bg-white w-full border-2 border-blue-400">
                <div class="px-6 py-4 w-full text-center">
                    <h3 class="text-xl">{{$package->name}}</h3>
                </div>
                <hr>
                <div class="px-6 py-4 w-full text-center">
                    <P class="text-md">{{$package->description}}</P>
                </div>
                <hr>
                <div class="px-6 py-4 w-full text-center">
                    <span class="text-2xl text-blue-400 font-extrabold"  style="direction: ltr;display:block;">{{number_format($package->price, 2)}} SAR</span>
                </div>
                <x-jet-button wire:click="buyPackage({{$package->id}})" class="main-btn w-full rounded-b-none">شراء</x-jet-button>
            </div>
        </div>
    @endforeach
@endif
</div>

<x-jet-button  wire:click='createAddressModel' class="mb-2 h-10 text-center main-btn">
<i class="fas fa-map-marker-alt"></i> {{__('اضافة عنوان')}}
</x-jet-button>
@if (Auth::guard('clients')->user()->type == 1 || Auth::guard('clients')->user()->type == 2)
@if (Auth::guard('clients')->user()->verified == 1)



    @if($hasBranches == true)
    <a href="{{route('frontend.product.create')}}" class="items-center px-4 py-2 bg-gray-800 border
   border-transparent
   rounded-md font-semibold text-xs text-white uppercase tracking-widest
   hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
   focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-2 mb-2 h-10 text-center">
        <i class="fas fa-store"></i> {{__('اضافة منتج')}}
    </a>
        @else
        <div class="block">
            <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 rounded shadow mb-4 g-alert" role="alert">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                <p>قبل اضافة منتج عليك اضافة فرع اولا</p>
            </div>
        </div>
    @endif
@endif
@endif

  <x-jet-dialog-modal wire:model="changeRequestStatus">
      <x-slot name="title">{{__('بيانات الطلب')}}</x-slot>
      <x-slot name="content">
          @if($reqs != null)
              @if(json_decode($reqs->item_data)->model == \App\Models\Product::class)
                  <ul>

                      <li>اسم المنتج : {{json_decode($reqs->item_data)->product->name}}</li>
                      <li>سعر المنتج : {{(float)json_decode($reqs->item_data)->product->price / (float)json_decode($reqs->item_data)->product->qty}} SAR</li>
                      <li>الكمية : {{json_decode($reqs->item_data)->product->qty}}</li>
                      <li> اجمالي المنتج : {{number_format((float)json_decode($reqs->item_data)->product->price, 2)}} SAR</li>
                  </ul>
                  <br>
                  <hr>
                  <ul>
                      @if(json_decode($reqs->item_data)->extra != null)
                          <h3>الاضافات</h3>
                          @php
                              $c = 1;
                          @endphp
                          @foreach(json_decode($reqs->item_data)->extra as $extra)
                              <ul>
                                  <li>#{{$c++}}</li>
                                  <li>الاسم : {{$extra->name}}</li>
                                  <li>السعر : {{number_format($extra->price, 2)}} SAR</li>
                                  <li>الكمية : {{$extra->qty}}</li>
                                  <li> اجمالي الملحق : {{number_format((float)$extra->qty *  (float)$extra->price, 2)}} SAR</li>
                              </ul>
                              @if(!$loop->last)
                                  <hr>
                                  <br>
                              @endif
                          @endforeach
                      @endif
                  </ul>
              @else
                  <ul>
                      @if(json_decode($reqs->item_data)->model != \App\Models\Product::class)
                          <li>الاسم : {{json_decode($reqs->item_data)->name}}</li>
                      @endif
                  </ul>
              @endif
              <br><hr><br>
              <h3 class="text-lg">معلومات الفاتورة</h3>
              <ul>
                  <li>السعر : {{number_format($reqs->item_price, 2)}} SAR</li>
                  <li>الشحن : {{number_format($reqs->shipping, 2)}} SAR</li>
                  <li>اجمالي الفاتورة : {{number_format($reqs->total_price,2)}} SAR</li>
                  @if(json_decode($reqs->item_data)->model == \App\Models\Product::class)
                      <li>عدد ايام التسليم : {{json_decode($reqs->item_data)->product->receipt_days}}</li>
                  @endif
                  <li>رقم التتبع : {{$reqs->reference_number}}</li>
              </ul>
          @endif
          @if($request != null)
              <div class="mt-4">
                  <x-jet-label for='productStatus' value="{{__('الحالة')}}" />
                  <div class="w-full">
                      <div class="relative">
                          <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                  wire:model='productStatus'
                                  name='productStatus'
                                  id="productStatus">
                              <option>الحالة</option>
                              @if($request->status == 0)
                                  <option value="1"> جاري اعداد المنتج</option>
                              @elseif($request->status == 1)
                                  <option value="2"> في الطريق اليك</option>
                              @elseif($request->status == 2)
                                  <option value="3"> تم التسليم بنجاح</option>
                              @elseif($request->status == 3)
                              @endif
                          </select>
                      </div>
                  </div>
                  @error('productStatus')
                  <span class="text-red-500 mt-1">{{$message}}</span>
                  @enderror
              </div>
          @endif
          @if($request != null)
              @if($request->status == 0)
                  @if($productStatus == 1 )
                      @if(\App\Models\GeneralInfo::findOrFail(1)->senders_status == 1)
                          @if($request->shipping_method_id == 1 || $request->shipping_method_id == 2)
                              <div class="mt-4">
                                  <small>الافتراضي هو التكفل بالتوصيل</small>
                                  <x-jet-label for='senderStatus' value="{{__('الاستعانة بمندوب')}}" />
                                  <div class="w-full">
                                      <div class="relative">
                                          <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                  wire:model='senderStatus'
                                                  name='senderStatus'
                                                  id="senderStatus">
                                              <option>الاستعانة بمندوب</option>
                                              <option value="0"> لا</option>
                                              <option value="1"> نعم</option>
                                          </select>
                                      </div>
                                  </div>
                                  @error('senderStatus')
                                  <span class="text-red-500 mt-1">{{$message}}</span>
                                  @enderror
                              </div>
                          @endif
                      @endif
                  @endif
              @endif
          @endif

      </x-slot>
      <x-slot name="footer">
          <x-jet-button wire:click='changeRequestStatusFun' class="ml-2 main-btn"><i class="fas fa-edit"></i> {{__(' تعديل')}}</x-jet-button>
          <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
      </x-slot>
  </x-jet-dialog-modal>

          <x-jet-dialog-modal wire:model="BillVisible">
              <x-slot name="title">{{__('بيانات الفاتورة')}}</x-slot>
              <x-slot name="content">
                  <hr style="border-color:#000 !important">

                    @if($billInfo != null)
                    @foreach(json_decode($billInfo) as $data)
                    @if(json_decode($data->item_data)->model == \App\Models\Product::class)
                    <ul>
                    <li>اسم المنتج : {{json_decode($data->item_data)->product->name}}</li>
                    <li>سعر المنتج : {{(float)json_decode($data->item_data)->product->price / (float)json_decode($data->item_data)->product->qty}} SAR</li>
                    <li>الكمية : {{json_decode($data->item_data)->product->qty}}</li>
                    <li> اجمالي المنتج : {{number_format((float)json_decode($data->item_data)->product->price, 2)}} SAR</li>
                    </ul>
                    <br>
                    <hr>
                    <ul>
                    @if(json_decode($data->item_data)->extra != null)
                    <h3>الاضافات</h3>
                    @php
                    $c = 1;
                    @endphp
                    @foreach(json_decode($data->item_data)->extra as $extra)
                    <ul>
                    <li>#{{$c++}}</li>
                    <li>الاسم : {{$extra->name}}</li>
                    <li>السعر : {{number_format($extra->price, 2)}} SAR</li>
                    <li>الكمية : {{$extra->qty}}</li>
                    <li> اجمالي الملحق : {{number_format((float)$extra->qty *  (float)$extra->price, 2)}} SAR</li>
                    </ul>
                    @if(!$loop->last)
                    <hr>
                    <br>
                    @endif
                    @endforeach
                    @endif
                    </ul>
                    @else
                    <ul>
                    @if(json_decode($data->item_data)->model != \App\Models\Product::class)
                    <li>الاسم : {{json_decode($data->item_data)->name}}</li>
                    @endif
                    </ul>
                    @endif
                    <br><hr><br>
                    <h3 class="text-lg">معلومات الفاتورة</h3>
                    <ul>
                    <li>السعر : {{number_format($data->item_price, 2)}} SAR</li>
                    <li>الشحن : {{number_format($data->shipping, 2)}} SAR</li>
                    <li>اجمالي الفاتورة : {{number_format($data->total_price,2)}} SAR</li>
                    @if(json_decode($data->item_data)->model == \App\Models\Product::class)
                    <li>عدد ايام التسليم : {{json_decode($data->item_data)->product->receipt_days}}</li>
                    @endif
                    <li>رقم التتبع : {{$data->reference_number}}</li>
                    </ul>
                    @endforeach
                    @endif
              </x-slot>
              <x-slot name="footer">
                  <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
              </x-slot>
          </x-jet-dialog-modal>

          <x-jet-dialog-modal wire:model="createAddressVisible">
              <x-slot name="title">{{__('اضافة عنوان')}}</x-slot>
              <x-slot name="content">
                  <hr style="border-color:#000 !important">
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
                  <div class="mt-4">
                      <x-jet-label for='details' value="{{__('GPS')}}" />
                      <x-jet-input type='text' id="gps" wire:model='gps' class="block mt-1 w-full" />
                      @error('gps')
                      <span class="text-red-500 mt-1">{{$message}}</span>
                      @enderror
                  </div>
              </x-slot>
              <x-slot name="footer">
                  <x-jet-button wire:click='storeAddress' class="ml-2 main-btn"><i class="fas fa-plus"></i> {{__(' اضافة')}}</x-jet-button>
                  <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
              </x-slot>
          </x-jet-dialog-modal>


          <x-jet-dialog-modal wire:model="updateAddressVisible">
              <x-slot name="title">{{__('تعديل عنوان')}}</x-slot>
              <x-slot name="content">
                  <hr style="border-color:#000 !important">
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
                                      name='country_id'
                                      id="country_id">
                                  <option>الدولة</option>
                                  @foreach ($countries as $country)
                                      <option value="{{$country->id}}" {{($country->id == $country_id ? 'selected' : '')}}>{{$country->name}}</option>
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
                              <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                      wire:model='government_id'
                                      name='government_id'
                                      id="government_id">
                                  <option>المدينة</option>
                                  @if($country_id != null)
                                      @foreach (\App\Models\Government::where('country_id', '=', $country_id)->get() as $governorate)
                                          <option value="{{$governorate->id}}" {{($governorate->id == $government_id ? 'selected' : '')}}>{{$governorate->name}}</option>
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
                      <x-jet-label for='details' value="{{__('GPS')}}" />
                      <x-jet-input type='text' id="gps" wire:model='gps' class="block mt-1 w-full" />
                      @error('gps')
                      <span class="text-red-500 mt-1">{{$message}}</span>
                      @enderror
                  </div>
              </x-slot>
              <x-slot name="footer">
                  <x-jet-button wire:click='updateAddressModel' class="ml-2 main-btn"><i class="fas fa-plus"></i> {{__(' اضافة')}}</x-jet-button>
                  <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
              </x-slot>
          </x-jet-dialog-modal>

          <x-jet-dialog-modal wire:model="clientUpdateFormVisible">
              <x-slot name="title"></x-slot>
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
                      @error('spare_phone')
                      <span class="text-red-500 mt-1">{{$message}}</span>
                      @enderror
                  </div>
                  <div class="grid grid-cols-12 gap-4">
                      <div class="col-span-6">
                          <div class="mt-4">
                              <x-jet-label for='shift_from' value="{{__('تبدء مواعيد عملك من')}}" />
                              <x-jet-input type='time' id="shift_from" wire:model='shift_from' class="block mt-1 w-full" />
                              @error('shift_from')
                              <span class="text-red-500 mt-1">{{$message}}</span>
                              @enderror
                          </div>
                      </div>
                      <div class="col-span-6">
                          <div class="mt-4">
                              <x-jet-label for='shift_to' value="{{__('تنتهي مواعيد عملك في')}}" />
                              <x-jet-input type='time' id="shift_to" wire:model='shift_to' class="block mt-1 w-full" />
                              @error('shift_to')
                              <span class="text-red-500 mt-1">{{$message}}</span>
                              @enderror
                          </div>
                      </div>
                  </div>
                  <div class="mt-4">
                      <x-jet-label for='email' value="{{__('البريد الإلكتروني')}}" />
                      <x-jet-input type='email' id="email" wire:model='email' class="block mt-1 w-full" />
                      @error('email')
                      <span class="text-red-500 mt-1">{{$message}}</span>
                      @enderror
                  </div>
                  <div class="grid grid-cols-12 gap-4">
                      <div class="lg:col-span-4 col-span-12">
                          <div class="mt-4 relative">
                              <i wire:click="showPasswordF" class="fas fa-eye" style="position: absolute; top: 37px; left: 10px; color: #006EB9FF; cursor: pointer;"></i>
                              <x-jet-label for='oldpassword' value="{{__('كلمة المرور القديمة')}}" />
                              <x-jet-input type="{{$showPassword == false ? 'password' : 'text'}}" id="oldpassword" wire:model='oldpassword' class="block mt-1 w-full" />
                              @error('oldpassword')
                              <span class="text-red-500 mt-1">{{$message}}</span>
                              @enderror
                          </div>
                      </div>
                      <div class="lg:col-span-4 col-span-12">
                          <div class="mt-4 relative">
                              <i wire:click="showPasswordF" class="fas fa-eye" style="position: absolute; top: 37px; left: 10px; color: #006EB9FF; cursor: pointer;"></i>
                              <x-jet-label for='password' value="{{__('كلمة المرور')}}" />
                              <x-jet-input type="{{$showPassword == false ? 'password' : 'text'}}" id="password" wire:model='password' class="block mt-1 w-full" />
                              @error('password')
                              <span class="text-red-500 mt-1">{{$message}}</span>
                              @enderror
                          </div>
                      </div>
                      <div class="lg:col-span-4 col-span-12">
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
                  <x-jet-button  wire:click='updateInformation' class="ml-2 main-btn"><i class="fas fa-user-save"></i> {{__(' تعديل')}}</x-jet-button>
                  <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
              </x-slot>
          </x-jet-dialog-modal>
          @if (Auth::guard('clients')->user()->type == 1 || Auth::guard('clients')->user()->type == 2)
              <x-jet-dialog-modal wire:model="ProductExtraVisible">
                  <x-slot name="title">{{__('ملحقات المنتج')}}</x-slot>
                  <x-slot name="content">
                      <hr style="border-color:#000 !important">
                      @if ($extras != null)
                          @foreach ($extras as $extra)
                              <br>
                              <img src="{{asset('uploads/'.$extra->main_image)}}" style="width: 50px" alt="">
                              <ul>
                                  <li>الاسم : {{$extra->name}}</li>
                                  <li>السعر : {{number_format($extra->price, 2)}} SAR</li>
                              </ul>
                              <br>
                          @endforeach
                      @endif
                  </x-slot>
                  <x-slot name="footer">
                      <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
                  </x-slot>
              </x-jet-dialog-modal>

              <x-jet-dialog-modal wire:model="deleteProductVisible">
                  <x-slot name="title">{{ __('حذف منتج') }}</x-slot>
                  <x-slot name="content">{{ __('انت متأكد من قرار حذف المنتج') }}</x-slot>
                  <x-slot name="footer">
                      <x-jet-danger-button wire:click='destroyProduct' class="ml-2"><i class="fas fa-trash"></i> {{__('حذف')}}</x-jet-danger-button>
                      <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
                  </x-slot>
              </x-jet-dialog-modal>
          @endif
          <x-jet-dialog-modal wire:model="senderAcceptRequest">
              <x-slot name="title">{{ __('قبول توصيل الطلب') }}</x-slot>
              <x-slot name="content">{{ __('انت متأكد من قرار قبول توصيل الطلب') }}</x-slot>
              <x-slot name="footer">
                  <x-jet-button wire:click='senderAcceptRequestFun' class="ml-2"><i class="fas fa-check"></i> {{__('قبول')}}</x-jet-button>
                  <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
              </x-slot>
          </x-jet-dialog-modal>
          <x-jet-dialog-modal wire:model="deleteAddressVisible">
              <x-slot name="title">{{ __('حذف العنوان') }}</x-slot>
              <x-slot name="content">{{ __('انت متأكد من قرار حذف العنوان') }}</x-slot>
              <x-slot name="footer">
                  <x-jet-danger-button wire:click='deleteAddress'><i class="fas fa-trash"></i> {{__('حذف')}}</x-jet-danger-button>
                  <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
              </x-slot>
          </x-jet-dialog-modal>
          <x-jet-dialog-modal wire:model="blockProductStatusVisible">
              <x-slot name="title">{{ __('ايقاف المنتج') }}</x-slot>
              <x-slot name="content">{{ __('انت متأكد من قرار ايقاف المنتج') }}</x-slot>
              <x-slot name="footer">
                  <x-jet-danger-button wire:click='blockProductStatusFun'><i class="fas fa-ban"></i> {{__('ايقاف')}}</x-jet-danger-button>
                  <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
              </x-slot>
          </x-jet-dialog-modal>
          <x-jet-dialog-modal wire:model="onProductStatusVisible">
              <x-slot name="title">{{ __('تشغيل المنتج') }}</x-slot>
              <x-slot name="content">{{ __('انت متأكد من قرار تشغيل المنتج') }}</x-slot>
              <x-slot name="footer">
                  <x-jet-button wire:click='onProductStatusFun'>{{__('تشغيل')}}</x-jet-button>
                  <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
              </x-slot>
          </x-jet-dialog-modal>
          <x-jet-dialog-modal wire:model="BillIbfoVisible">
              <x-slot name="title">{{ __('تفاصيل') }}</x-slot>
              <x-slot name="content">
                  @if($billInform != null)
                      <h4>العناصر</h4>
                      <ul>
                          <h3 class="text-lg">معلومات المنتج</h3>
                          @if(json_decode($billInform->item_data)->model == \App\Models\Product::class)
                              <ul>

                                  <li>اسم المنتج : {{json_decode($billInform->item_data)->product->name}}</li>
                                  <li>سعر المنتج : {{(float)json_decode($billInform->item_data)->product->price / (float)json_decode($billInform->item_data)->product->qty}} SAR</li>
                                  <li>الكمية : {{json_decode($billInform->item_data)->product->qty}}</li>
                                  <li> اجمالي المنتج : {{number_format((float)json_decode($billInform->item_data)->product->price, 2)}} SAR</li>
                              </ul>
                              <br>
                              <hr>
                              <ul>
                                  @if(json_decode($billInform->item_data)->extra != null)
                                      <h3>الاضافات</h3>
                                        @php
                                        $c = 1;
                                        @endphp
                                      @foreach(json_decode($billInform->item_data)->extra as $extra)
                                          <ul>
                                              <li>#{{$c++}}</li>
                                              <li>الاسم : {{$extra->name}}</li>
                                              <li>السعر : {{number_format($extra->price, 2)}} SAR</li>
                                              <li>الكمية : {{$extra->qty}}</li>
                                              <li> اجمالي الملحق : {{number_format((float)$extra->qty *  (float)$extra->price, 2)}} SAR</li>
                                          </ul>
                                          @if(!$loop->last)
                                              <hr>
                                              <br>
                                          @endif
                                      @endforeach
                                  @endif
                              </ul>
                          @else
                              <ul>
                                  @if(json_decode($billInform->item_data)->model != \App\Models\Product::class)
                                  <li>الاسم : {{json_decode($billInform->item_data)->name}}</li>
                                  @endif
                              </ul>
                          @endif
                          <br><hr><br>
                          <h3 class="text-lg">معلومات الفاتورة</h3>
                          <ul>
                              <li>السعر : {{number_format($billInform->item_price, 2)}} SAR</li>
                              <li>الشحن : {{number_format($billInform->shipping, 2)}} SAR</li>
                              <li>اجمالي الفاتورة : {{number_format($billInform->total_price,2)}} SAR</li>
                              @if(json_decode($billInform->item_data)->model == \App\Models\Product::class)
                              <li>عدد ايام التسليم : {{json_decode($billInform->item_data)->product->receipt_days}}</li>
                              @endif
                              <li>رقم التتبع : {{$billInform->reference_number}}</li>
                          </ul>

                      </ul>
                      <br>
                      <hr>
                      <br>
                      <ul>
                          <h4>عنوان المشتري</h4>
                          <li>
                              <p>الدولة</p>
                              <p>{{$billInform->address->country->name}}</p>
                          </li>
                          <li>
                              <p>المدينة</p>
                              <p>{{$billInform->address->government->name}}</p>
                          </li>
                          <li>
                              <p>الشارع</p>
                              <p>{{$billInform->address->street}}</p>
                          </li>
                          <li>
                              <p>المحافظة</p>
                              <p>{{$billInform->address->sector}}</p>
                          </li>
                          <li>
                              <p>رقم البناء</p>
                              <p>{{$billInform->address->build_no}}</p>
                          </li>

                          <li>
                              <p>الدور</p>
                              <p>{{$billInform->address->floor}}</p>
                          </li>
                          <li>
                              <p>رقم الوحدة</p>
                              <p>{{$billInform->address->unit_no}}</p>
                          </li>
                          <li>
                              <p>Gps</p>
                              @if($billInform->address->gps != null)
                                  <p><a class="block items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700
                              active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25
                              transition mb-2 mt-2" href="{{$billInform->address->gps}}" target="_blank">رابط GPS</a></p>
                              @endif
                          </li>
                          <li>
                              <p>{{$billInform->address->details}}</p>
                          </li>
                      </ul>
                      <br>
                      <hr>
                      <br>
                      <ul>
                          <h4>عنوان التاجر</h4>
                          <li>
                              <p>الدولة</p>
                              <p>
                                  {{\App\Models\Address::findOrFail(json_decode($billInform->shipping_data)->branch_id)->country->name}}
                              </p>
                          </li>
                          <li>
                              <p>المدينة</p>
                              <p>
                                  {{\App\Models\Address::findOrFail(json_decode($billInform->shipping_data)->branch_id)->government->name}}
                              </p>
                          </li>
                          <li>
                              <p>الشارع</p>
                              <p>{{$billInform->product->client->address[0]->street}}</p>
                          </li>
                          <li>
                              <p>المحافظة</p>
                              <p>{{$billInform->product->client->address[0]->sector}}</p>
                          </li>
                          <li>
                              <p>رقم البناء</p>
                              <p>{{$billInform->product->client->address[0]->build_no}}</p>
                          </li>

                          <li>
                              <p>الدور</p>
                              <p>{{$billInform->product->client->address[0]->floor}}</p>
                          </li>
                          <li>
                              <p>رقم الوحدة</p>
                              <p>{{$billInform->product->client->address[0]->unit_no}}</p>
                          </li>
                          <li>
                              <p>Gps</p>
                              @if($billInform->product->client->address[0]->gps != null)
                                  <p><a class="block items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700
                              active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25
                              transition mb-2 mt-2" href="{{$billInform->product->client->address[0]->gps}}" target="_blank">رابط GPS</a></p>
                              @endif
                          </li>
                          <li>
                              <p>{{$billInform->product->client->address[0]->details}}</p>
                          </li>
                      </ul>


                  @endif
              </x-slot>
              <x-slot name="footer">
                  <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
              </x-slot>
          </x-jet-dialog-modal>
    <x-jet-dialog-modal wire:model="addressBranchVisible">
        <x-slot name="title">{{ __('تحويل عنوان لفرع') }}</x-slot>
        <x-slot name="content">
            هل انت متاكد
        </x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click='ComfirmBranchAddressFun' class="ml-2">تحويل</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    <x-jet-dialog-modal wire:model="addressNormalVisible">
        <x-slot name="title">{{ __('تحويل فرع لعنوان') }}</x-slot>
        <x-slot name="content">
            هل انت متاكد
        </x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click='ComfirmNormalAddressFun' class="ml-2">تحويل</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

          <nav class="shadow-md">
              <ul>
                  <li data-targget="address" class="{{$addressSection == true ? 'active' : ''}}">العناوين</li>
                  <li data-targget="infomation" class="{{$infomationSection == true ? 'active' : ''}}">معلومات الحساب</li>
                  <li data-targget="bills" class="{{$billsSection == true ? 'active' : ''}}">فواتير الشراء</li>
                  @if (Auth::guard('clients')->user()->type == 1 || Auth::guard('clients')->user()->type == 2)
                      <li data-targget="salse"  class="{{$salseSection  == true ? 'active' : ''}}">منتجاتي</li>
                  @endif

                  @if (Auth::guard('clients')->user()->type == 1 || Auth::guard('clients')->user()->type == 2 || Auth::guard('clients')->user()->type == 3)
                      <li data-targget="buyRequests" class="{{$buyRequestsSection == true ? 'active' : ''}}">طلبات شراء العملاء</li>
                  @endif
                  @if (Auth::guard('clients')->user()->type == 3 && Auth::guard('clients')->user()->verified == 1)
                      <li data-targget="nowRequests" class="{{$nowRequestsSection == true ? 'active' : ''}}">طلبات الحالية</li>
                  @endif
                  <li data-targget="my-products"  class=" {{$myProductsSection == true ? 'active' : ''}}"  >طلبات الشراء الخاصة بي</li>
                  <a href="{{route('frontend.receipts')}}"><li>الفواتير المجمعة</li></a>
              </ul>
          </nav>

             @if ($addressSection == true)
                 <h2>العناوين</h2>
                 <div class="grid grid-cols-12 gap-4 thiadderss">
                     @foreach ($address as $add)
                         <div class="col-span-12 sm:col-span-4">
                             <div class="bg-white shadow-xl sm:rounded-lg p-4 relative">
                                 @if (Auth::guard('clients')->user()->address_id == $add->id)
                                     <span class="main-address">أساسي</span>
                                 @endif
                                 <div class="main-content">
                                     <p>{{$add->country->name}}</p>
                                     <p>{{$add->government->name}}</p>
                                 </div>
                                 <div class="address-list">
                                     <ul>
                                         <li>
                                             <p>الشارع</p>
                                             <p>{{$add->street}}</p>
                                         </li>
                                         <li>
                                             <p>المحافظة</p>
                                             <p>{{$add->sector}}</p>
                                         </li>
                                         <li>
                                             <p>رقم البناء</p>
                                             <p>{{$add->build_no}}</p>
                                         </li>

                                         <li>
                                             <p>الدور</p>
                                             <p>{{$add->floor}}</p>
                                         </li>
                                         <li>
                                             <p>رقم الوحدة</p>
                                             <p>{{$add->unit_no}}</p>
                                         </li>
                                         <li>
                                             <p>{{$add->details}}</p>
                                         </li>
                                     </ul>
                                 </div>
                                 <hr>
                                 <ul class="controls">
                                     <li>
                                         <x-jet-button class="main-btn w-full" wire:click="ComfirmUpdateAddressModel({{$add->id}})"><i class="fas fa-edit"></i> تعديل </x-jet-button>
                                     </li>
                                     @if (Auth::guard('clients')->user()->type == 1 || Auth::guard('clients')->user()->type == 2)

                                     <li>
                                         @if($add->branch == 0)
                                         <x-jet-button class="w-full" wire:click="ComfirmBranchAddressModel({{$add->id}})">فرع</x-jet-button>
                                         @else
                                         <x-jet-button class="w-full" wire:click="ComfirmNormalAddressModel({{$add->id}})">عنوان توصيل</x-jet-button>
                                         @endif
                                     </li>
                                     @endif
                                     <li>
                                         <x-jet-danger-button class="w-full" wire:click="ConfermdeleteAddress({{$add->id}})"><i class="fas fa-trash"></i> حذف </x-jet-danger-button>
                                     </li>
                                 </ul>
                             </div>
                         </div>
                     @endforeach
                 </div>
             @endif

                @if ($infomationSection == true)
                    <h2>معلومات الحساب</h2>
                    <div class="bg-white shadow-xl sm:rounded-lg p-4 relative">
                        <div class="holder">
                            <x-jet-label for='' class="mb-1"  value="{{__('رابط دعوة الاصدقاء للحصول على عمولات دائمة كلما اشترى هذا العميل')}}" />
                            <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white service_area">
                                <li style="direction: ltr" class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600">
                                    <p>{{URL::to('/register?ref='.Auth::guard('clients')->user()->ref)}}</p>
                                    <x-jet-button data-url="{{URL::to('/register?ref='.Auth::guard('clients')->user()->ref)}}" class="copy-btn"><i class="fas fa-copy"></i></x-jet-button>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <x-jet-button  wire:click='updateInformationModel' class="ml-2 main-btn"><i class="fas fa-user-save"></i> اضغط هنا لتغير رقمك السري ووضع خطة مواعيد العمل وتغير بياناتك ومعلومات حسابك</x-jet-button>
                        </div>

                    </div>

                    @if(Auth::guard('clients')->user()->type == 3)
                        <br><br>
                        <div class="bg-white shadow-xl sm:rounded-lg p-4 relative">

                            <h2>مناطق الخدمات</h2>
                            <div class="mt-4">
                                <x-jet-label for='government_id' value="{{__('المدينة')}}" />
                                <div class="w-full">
                                    <div class="relative">
                                        <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                wire:model='government_id'
                                                name='government_id'
                                                id="government_id">
                                            <option>المدينة</option>
                                            @if ($senderGovs != null)
                                                @foreach ($senderGovs as $governorate)
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
                                <x-jet-button wire:click='add_service_available_in' class="ml-2 main-btn"><i class="fas fa-user-plus"></i> {{__(' اضافة')}}</x-jet-button>
                            </div>
                            <br><hr><br>
                            @if ($areas != null)
                                <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white service_area">
                                    @foreach(json_decode($areas) as $gov)
                                        <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600">
                                            <p>{{$gov->title}}</p>
                                            <x-jet-danger-button wire:click="delete_area({{$gov->id}})"><i class="fas fa-trash"></i></x-jet-danger-button>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endif
                @endif

                    @if ($salseSection == true)
                        <h2>منتجاتي</h2>

                        <div class="mx-1 richness-table clients-table">
                            <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
                                <thead class="text-white mob-text-aline">
                                @foreach ($productsArray as $user)

                                    <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                                        <th class="p-3">الاسم</th>
                                        <th class="p-3">التصنيف</th>
                                        <th class="p-3">الوزن</th>
                                        <th class="p-3">العرض</th>
                                        <th class="p-3">الطول</th>
                                        <th class="p-3">السعر</th>
                                        <th class="p-3">الكمية المتاحة</th>
                                        <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                                    </tr>
                                @endforeach
                                </thead>
                                <tbody class="flex-1 sm:flex-none">
                                @foreach ($productsArray as $user)
                                    <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->name}}</td>
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->category->name}}</td>
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->wight}} جرام</td>
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->width}} cm</td>
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->height}} cm</td>
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($user->price, 2)}} SAR</td>
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->aval_count}}</td>
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                                            <x-jet-button wire:click="showProductExtrasModel({{$user->id}})" class="ml-2 block w-full mb-2"><i class="fas fa-boxes"></i> {{__('الملحقات')}}</x-jet-button>
                                            <a href="{{route('frontend.product.create-extra', ['id' => $user->id])}}"  class="items-center px-4 py-2 bg-gray-800 border
                                        border-transparent block w-full mb-2
                                        rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                        hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                                        focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-2 text-center main-btn">
                                                <i class="fas fa-plus"></i> {{__(' اضافة ملحق')}}
                                            </a>
                                            <a href="{{route('frontend.product.edit', ['id' => $user->id])}}"  class="items-center px-4 py-2 bg-gray-800 border
                                        border-transparent block w-full mb-2
                                        rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                        hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                                        focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-2 text-center main-btn">
                                                <i class="mr-2 fas fa-edit"></i> {{__(' تعديل')}}
                                            </a>
                                            @if($user->status == 1)
                                                <x-jet-danger-button wire:click="blockProductStatusModel({{$user->id}})" class="ml-2 block w-full mb-2"><i class="mr-2 fas fa-ban"></i> {{__(' ايقاف')}}</x-jet-danger-button>
                                            @else
                                                <x-jet-button wire:click="onProductStatusModel({{$user->id}})" class="ml-2 block w-full mb-2 bg-green-600"><i class="mr-2 fas fa-check"></i> {{__(' تشغيل')}}</x-jet-button>
                                            @endif
                                            <x-jet-danger-button wire:click="confirmUserProductDelete({{$user->id}})" class="ml-2 block w-full mb-2"><i class="mr-2 fas fa-trash-alt"></i> {{__(' حذف')}}</x-jet-danger-button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="mx-1">
                            {{$productsArray->links()}}
                        </div>

                    @endif

                    @if($billsSection == true)
                        <h2>فواتير الشراء</h2>

                        <div class="mx-1 richness-table clients-table">
                            <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
                                <thead class="text-white mob-text-aline">
                                @foreach ($bills as $bill)

                                    <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                                        <th class="p-3">سعر المنتجات</th>
                                        <th class="p-3">الشحن</th>
                                        <th class="p-3">الاجمالي</th>
                                        <th class="p-3">وسيلة الدفع</th>
                                        <th class="p-3">الحالة</th>
                                        <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                                    </tr>
                                @endforeach
                                </thead>
                                <tbody class="flex-1 sm:flex-none">
                                @foreach ($bills as $user)
                                    <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($user->total_price - $user->total_shipping)}} SAR</td>
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($user->total_shipping, 2)}} SAR</td>
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($user->total_price, 2)}} SAR</td>
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->paymentmethod}}</td>
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                                            @if($user->status == 1)
                                                مدفوع
                                            @else
                                                غير مدفوع
                                            @endif
                                        </td>
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                                            <x-jet-button wire:click="showBillModel({{$user->id}})" class="ml-2 main-btn"><i class="mr-2 fas fa-info"></i> {{__(' البيانات')}}</x-jet-button>
                                            <a href="{{URL::to('receipts-for-user/'.$user->id)}}"
                                               class="items-center px-4 py-2 bg-gray-800 border border-transparent
                                                   rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                                    hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                                                     focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-2 main-btn">
                                                <i class="mr-2 fas fa-receipt"></i> {{__(' الفاتورة')}}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="mx-1">
                            {{$bills->links()}}
                        </div>
                    @endif

                       @if($myProductsSection == true)
                           <h2>طلبات الشراء الخاصة بي</h2>

                           <div class="mx-1 richness-table clients-table">
                               <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
                                   <thead class="text-white mob-text-aline">
                                   @foreach ($my_products_requests as $user)

                                       <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                                           <th class="p-3">#</th>
                                           <th class="p-3"> المنتج</th>
                                           <th class="p-3"> السعر</th>
                                           <th class="p-3"> الشحن</th>
                                           <th class="p-3"> الاجمالي</th>
                                           <th class="p-3"> البائع</th>
                                           <th class="p-3">المندوب</th>
                                           <th class="p-3">حالة الدفع</th>
                                           <th class="p-3">حالة الطلب</th>
                                           <th class="p-3">موعد الاستلام</th>
                                           <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                                       </tr>
                                   @endforeach
                                   </thead>
                                   <tbody class="flex-1 sm:flex-none">
                                   @foreach ($my_products_requests as $user)
                                       <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                                           <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3"><img style="width: 50px;height: 50px" class="rounded shadow" src="{{asset('uploads/'.$user->product->main_image)}}"></td>
                                           <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->product->name}}</td>
                                           <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($user->bill->item_price, 2)}} SAR</td>
                                           <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($user->bill->shipping, 2)}} SAR</td>
                                           <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($user->bill->total_price, 2)}} SAR</td>
                                           <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->provider->name}}</td>
                                           <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                                               @if($user->sender != null)
                                                   {{$user->sender->name}}
                                               @else
                                                   غير محدد بعد
                                               @endif
                                           </td>
                                           <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                                               @if($user->payment_status == 0)
                                                   غير مدفوع
                                               @else
                                                   مدفوع
                                               @endif
                                           </td>
                                           <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                                               @if($user->status == 0)
                                                   قيد الانتظار
                                               @elseif($user->status == 1)
                                                   جاري اعداد المنتج
                                               @elseif($user->status == 2)
                                                   في الطريق اليك
                                               @elseif($user->status == 3)
                                                   تم التسليم بنجاح
                                               @endif
                                           </td>
                                           <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                                               @if($user->receipt_time != null)
                                                   {{ date('d-m-Y', strtotime($user->receipt_time))}}
                                               @else
                                                   غير محدد
                                               @endif
                                           </td>
                                           <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                                               @if($user->group != null)
                                                   <x-jet-button wire:click="goToGroup({{$user->group->id}})" class="mb-2 w-full"><i class="mr-2 fas fa-users"></i> {{__('الدخول للمجموعة')}}</x-jet-button>
                                               @endif
                                               @if($user->status == 3)
                                                   <x-jet-button wire:click="showBillInfoModel({{$user->bill->id}})" class="w-full main-btn"><i class="mr-2 fas fa-info"></i> {{__(' البيانات')}}</x-jet-button>
                                               @endif
                                               @if($user->status == 0 && $user->group == null)
                                                   -
                                               @endif
                                           </td>
                                       </tr>
                                   @endforeach
                                   </tbody>
                               </table>
                           </div>
                           <br>
                           <div class="mx-1">
                               {{$my_products_requests->links()}}
                           </div>
                       @endif

                          @if($buyRequestsSection == true)
                              @if($productsRequests != null)
                                  <h2>طلبات  شراء العملاء</h2>
                                  <div class="mx-1 richness-table clients-table">
                                      <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
                                          <thead class="text-white mob-text-aline">

                                          @foreach ($productsRequests as $user)
                                              <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                                                  <th class="p-3"> السعر</th>
                                                  <th class="p-3"> الشحن</th>
                                                  <th class="p-3"> الاجمالي</th>
                                                  <th class="p-3"> المشتري</th>
                                                  <th class="p-3">المندوب</th>
                                                  <th class="p-3">حالة الدفع</th>
                                                  <th class="p-3">حالة الطلب</th>
                                                  <th class="p-3">موعد الاستلام</th>
                                                  <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                                              </tr>
                                          @endforeach
                                          </thead>
                                          <tbody class="flex-1 sm:flex-none">
                                          @foreach ($productsRequests as $user)
                                              <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                                                  <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($user->bill->item_price, 2)}} SAR</td>
                                                  <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($user->bill->shipping, 2)}} SAR</td>
                                                  <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($user->bill->total_price, 2)}} SAR</td>
                                                  <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->buyer->name}}</td>
                                                  <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                                                      @if($user->status == 0)
                                                          -
                                                      @else
                                                          @if($user->shipping_method_id == 1 || $user->shipping_method_id == 2)
                                                              @if($user->senderStatus == 1)
                                                                  @if($user->sender != null)
                                                                      {{$user->sender->name}}
                                                                  @else
                                                                      غير محدد بعد
                                                                  @endif
                                                              @else
                                                                  التوصيل من خلال المتجر
                                                              @endif
                                                          @else
                                                              {{$user->shipping_method->name}}
                                                          @endif
                                                      @endif
                                                  </td>
                                                  <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                                                      @if($user->payment_status == 0)

                                                          <span class="p-2 block rounded shadow bg-red-500"> غير مدفوع</span>
                                                      @else
                                                          <span class="p-2 block rounded shadow bg-green-300">  مدفوع</span>

                                                      @endif
                                                  </td>
                                                  <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                                                      @if($user->status == 0)
                                                          <span class="p-2 block rounded shadow bg-blue-300"> قيد الانتظار</span>
                                                      @elseif($user->status == 1)
                                                          <span class="p-2 block rounded shadow bg-indigo-300">جاري اعداد المنتج</span>
                                                      @elseif($user->status == 2)
                                                          <span class="p-2 block rounded shadow bg-teal-300"> في الطريق اليك</span>
                                                      @elseif($user->status == 3)
                                                          <span class="p-2 block rounded shadow bg-green-300"> تم التسليم بنجاح</span>
                                                      @endif
                                                  </td>
                                                  <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                                                      @if($user->receipt_time != null)
                                                          {{ date('d-m-Y', strtotime($user->receipt_time))}}
                                                      @else
                                                          غير محدد
                                                      @endif
                                                  </td>
                                                  <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3" style="max-width:203px;">
                                                      <a href="{{URL::to('receipts-for-provider/'.$user->id)}}"
                                                         class="items-center px-4 py-2 bg-gray-800 border border-transparent
                                                          rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                                          hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                                                          focus:ring focus:ring-gray-300 disabled:opacity-25 transition w-full block ml-2 mb-1">
                                                          <i class="mr-2 fas fa-receipt"></i> {{__(' الفاتورة')}}
                                                      </a>
                                                      <x-jet-button wire:click="showBillInfoModel({{$user->bill->id}})" class="ml-2 mb-1 w-full"><i class="mr-2 fas fa-info"></i> {{__(' تفاصيل الطلب')}}</x-jet-button>
                                                      @if(\Illuminate\Support\Facades\Auth::guard('clients')->user()->type != 3)
                                                          <x-jet-button wire:click="editRequestStatus({{$user->id}})" class="ml-2 main-btn mb-1 w-full"><i class="mr-2 fas fa-edit"></i> {{__(' تغير الحالة')}}</x-jet-button>
                                                      @endif
                                                      @if($user->group != null)
                                                          <x-jet-button wire:click="goToGroup({{$user->group->id}})" class="ml-2 w-full"><i class="mr-2 fas fa-users"></i> {{__('الدخول للمجموعة')}}</x-jet-button>
                                                      @endif
                                                  </td>
                                              </tr>
                                          @endforeach
                                          </tbody>
                                      </table>
                                  </div>
                                  <br>
                                  <div class="mx-1">
                                      {{$productsRequests->links()}}
                                  </div>
                              @endif
                          @endif

                          @if($nowRequestsSection == true)
                              <h2>طلبات  الشراء الحالية</h2>
                                @if($nowProductsRequests != null)
                              <div class="mx-1 richness-table clients-table">
                                  <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
                                      <thead class="text-white mob-text-aline">
                                      @foreach ($nowProductsRequests as $user)

                                          <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                                              <th class="p-3"> السعر</th>
                                              <th class="p-3"> الشحن</th>
                                              <th class="p-3"> الاجمالي</th>
                                              <th class="p-3"> المشتري</th>
                                              <th class="p-3">حالة الدفع</th>
                                              <th class="p-3">حالة الطلب</th>
                                              <th class="p-3">معاد التسليم للعميل</th>
                                              <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                                          </tr>
                                      @endforeach
                                      </thead>
                                      <tbody class="flex-1 sm:flex-none">
                                      @foreach ($nowProductsRequests as $user)
                                          <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                                              <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($user->bill->item_price, 2)}} SAR</td>
                                              <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($user->bill->shipping, 2)}} SAR</td>
                                              <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($user->bill->total_price, 2)}} SAR</td>
                                              <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->buyer->name}}</td>
                                              <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                                                  @if($user->payment_status == 0)

                                                      <span class="p-2 block rounded shadow bg-red-500"> غير مدفوع</span>
                                                  @else
                                                      <span class="p-2 block rounded shadow bg-green-300">  مدفوع</span>

                                                  @endif
                                              </td>
                                              <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                                                  @if($user->status == 0)
                                                      <span class="p-2 block rounded shadow bg-blue-300"> قيد الانتظار</span>
                                                  @elseif($user->status == 1)
                                                      <span class="p-2 block rounded shadow bg-indigo-300">جاري اعداد المنتج</span>
                                                  @elseif($user->status == 2)
                                                      <span class="p-2 block rounded shadow bg-teal-300">في الطريق اليك</span>
                                                  @elseif($user->status == 3)
                                                      <span class="p-2 block rounded shadow bg-green-300"> تم التسليم بنجاح</span>
                                                  @endif
                                              </td>
                                              <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                                                  @if($user->receipt_time != null)
                                                      {{ date('d-m-Y', strtotime($user->receipt_time))}}
                                                  @else
                                                      غير محدد
                                                  @endif
                                              </td>
                                              <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3" style="max-width:203px;">
                                                  <x-jet-button wire:click="showBillInfoModel({{$user->bill->id}})" class="ml-2 mb-1 w-full"><i class="mr-2 fas fa-info"></i> {{__(' تفاصيل الطلب')}}</x-jet-button>
                                                  <x-jet-button wire:click="showSenderAcceptRequest({{$user->id}})" class="ml-2 w-full main-btn mb-1"><i class="mr-2 fas fa-check"></i> {{__(' قبول')}}</x-jet-button>
                                              </td>
                                          </tr>
                                      @endforeach
                                      </tbody>
                                  </table>
                              </div>
                              <br>
                              <div class="mx-1">
                                  {{$nowProductsRequests->links()}}
                              </div>
@endif
                          @endif

    <div class="success-alert"></div>

    @push('scripts')
        <script>
            function copyFunction(text) {
                const elem = document.createElement('textarea');
                elem.value = text;
                document.body.appendChild(elem);
                if (navigator.userAgent.match(/ipad|ipod|iphone/i)) {
                    elem.contentEditable = true;
                    elem.readOnly = true;
                    var range = document.createRange();
                    range.selectNodeContents(elem);
                    var selection = window.getSelection();
                    selection.removeAllRanges();
                    selection.addRange(range);
                    elem.setSelectionRange(0, 999999);
                }
                else {
                    elem.select();
                }
                document.execCommand('copy');
                document.body.removeChild(elem);
            }
            function fun_color()
            {
                let elem = document.querySelector(".success-alert");
                elem.style.transaction = '0.5';
                elem.style.bottom = '10px';
                elem.innerHTML = 'تم النسخ بنجاح';
                setTimeout(() => {
                    elem.style.bottom = '-25%';
                }, 1500)
            }
            let copyBtn = document.querySelector('.copy-btn');
            if (typeof(copyBtn) != 'undefined' && copyBtn != null) {
                copyBtn.addEventListener('click', function (e) {
                    let text = document.querySelector('.copy-btn').dataset.url;
                    copyFunction(text);
                    fun_color();
                });
            }

        </script>
    @endpush
</div>
