<div>
    <x-jet-dialog-modal wire:model="senderAcceptRequest">
        <x-slot name="title">{{ __('قبول توصيل الطلب') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من قرار قبول توصيل الطلب') }}</x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click='senderAcceptRequestFun' class="ml-2"><i class="fas fa-check"></i> {{__('قبول')}}</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    <x-jet-dialog-modal wire:model="BillIbfoVisible">
        <x-slot name="title">{{ __('الاسعار') }}</x-slot>
        <x-slot name="content">
            @if($billInform != null)
                <hr><br>
                @if($info != null)
                    <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dolly-flatbed"></i> الشحن : {{number_format($info->total_shipping, 2)}} ريال </li>
                        <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-calculator"></i> المجموع : {{number_format($info->total_price + $info->total_shipping, 2)}} ريال </li>
                    </ul>
                    <br><hr><br>
                    <h4 class="mb-3 block">التفاصيل</h4>
                    <div class="grid grid-cols-12 gap-4 relative">
                        @foreach(json_decode($info->bills_data) as $data)
                            @if(json_decode($data->item_data)->model == \App\Models\Product::class)
                                <div class="md:col-span-6 col-span-12">
                                    <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dollar-sign"></i> اسم المنتج : {{json_decode($data->item_data)->product->name}}</li>
                                        <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dollar-sign"></i> سعر المنتج :  {{number_format(json_decode($data->item_data)->product->price / json_decode($data->item_data)->product->qty, 2)}} </li>
                                        <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dolly-flatbed"></i> ايام التسليم : {{json_decode($data->item_data)->product->receipt_days}} </li>
                                        <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-calculator"></i> الكمية : {{json_decode($data->item_data)->product->qty}} </li>
                                        <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dollar-sign"></i> سعر الاجمالي :  {{number_format(json_decode($data->item_data)->product->price, 2)}} </li>
                                    </ul>
                                    <br>
                                    @if(!empty(json_decode($data->item_data)->extra))
                                        @foreach(json_decode($data->item_data)->extra as $extra)
                                            <h4>الاضافات</h4><br>
                                            <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dollar-sign"></i> اسم المنتج : {{$extra->name}}</li>
                                                <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dollar-sign"></i> سعر المنتج :  {{number_format($extra->price, 2)}} </li>
                                                <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-calculator"></i> الكمية : {{$extra->qty}} </li>
                                                <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-calculator"></i> الاجمالي : {{number_format($extra->price * $extra->qty, 2)}} </li>

                                            </ul>
                                        @endforeach
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <br>
                @endif
                <hr><br>
                <div class="grid grid-cols-12 gap-4 relative">
                    <div class="md:col-span-6 col-span-12">
                        <h4 class="mb-3 block">عنوان المشتري</h4>
                        <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> الدولة : {{$billInform->address->country->name}}</li>
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> المدينة :  {{$billInform->address->government->name}} </li>
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600">الشارع : {{$billInform->address->street}}</li>
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> المحافظة :  {{$billInform->address->sector}} </li>
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> رقم البناء :  {{$billInform->address->build_no}} </li>
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> الدور :  {{$billInform->address->floor}} </li>
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> رقم الوحدة :  {{$billInform->address->unit_no}} </li>
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> Gps :
                                @if($billInform->address->gps != null)
                                    <p><a class="block items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700
                        active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25
                        transition mb-2 mt-2" href="{{$billInform->address->gps}}" target="_blank">رابط GPS</a></p>
                                @endif
                            </li>
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600">
                                <p>{{$billInform->address->details}}</p>
                            </li>
                        </ul>
                        <br>
                    </div>
                    <div class="md:col-span-6 col-span-12">
                        <h4 class="mb-3 block">عنوان التاجر</h4>
                        <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> الدولة : {{\App\Models\Address::findOrFail(json_decode($billInform->shipping_data)->branch_id)->country->name}}</li>
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> المدينة :  {{\App\Models\Address::findOrFail(json_decode($billInform->shipping_data)->branch_id)->government->name}} </li>
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600">الشارع : {{$billInform->product->client->address[0]->street}} </li>
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> المحافظة :  {{$billInform->product->client->address[0]->sector}} </li>
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> رقم البناء :  {{$billInform->product->client->address[0]->build_no}} </li>
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> الدور :  {{$billInform->product->client->address[0]->floor}} </li>
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> رقم الوحدة :  {{$billInform->product->client->address[0]->unit_no}}</li>
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> Gps :
                                @if($billInform->product->client->address[0]->gps != null)
                                    <p><a class="block items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700
                                      active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25
                                      transition mb-2 mt-2" href="{{$billInform->product->client->address[0]->gps}}" target="_blank">رابط GPS</a></p>
                                @endif
                            </li>
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600">
                                <p>{{$billInform->product->client->address[0]->details}}</p>
                            </li>
                        </ul>
                        <br>
                    </div>
                </div>
                <hr><br>
                <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> وسيلة الدفع : {{$info->paymentmethod }}</li>
                </ul>
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    <x-jet-dialog-modal wire:model="changeRequestStatus">
        <x-slot name="title">{{__('تغير حالة الطلب')}}</x-slot>
        <x-slot name="content">
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
    <nav class="shadow-md">
        <ul>
            <li data-targget="bills" class="{{$billsSection == true ? 'active' : ''}}">فواتير الشراء المجمعة</li>

            @if (Auth::guard('clients')->user()->type == 1 || Auth::guard('clients')->user()->type == 2 || Auth::guard('clients')->user()->type == 3)
                <li data-targget="buyRequests" class="{{$buyRequestsSection == true ? 'active' : ''}}">طلبات شراء العملاء المجمعة</li>
            @endif
            @if (Auth::guard('clients')->user()->type == 3 && Auth::guard('clients')->user()->verified == 1)
                <li data-targget="nowRequests" class="{{$nowRequestsSection == true ? 'active' : ''}}">طلبات الحالية المجمعة</li>
            @endif
            <li data-targget="my-products"  class=" {{$myProductsSection == true ? 'active' : ''}}"  >طلبات الشراء المجمعة الخاصة بي</li>
        </ul>
    </nav>

    @if($billsSection == true)
        <h2>فواتير الشراء</h2>
        <div class="mx-1 richness-table clients-table">
            <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
                <thead class="text-white mob-text-aline">
                @foreach ($bills as $bill)
                    <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                        <th class="p-3"><i class="fas fa-envelope"></i> البريد الالكتروني</th>
                        <th class="p-3"> وسيلة الشحن</th>
                        <th class="p-3"><i class="fas fa-toggle-on"></i> الحالة</th>
                        <th class="p-3"><i class="fas fa-sort-numeric-up-alt"></i> رقم التتبع </th>
                        <th class="p-3"> سعر المنتج </th>
                        <th class="p-3"> سعر الشحن </th>
                        <th class="p-3"> سعر الاجمالي </th>
                        <th class="p-3"><i class="fas fa-calendar-day"></i> التاريخ</th>
                        <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                    </tr>
                @endforeach
                </thead>
                <tbody class="flex-1 sm:flex-none">
                @foreach ($bills as $bill)
                    <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$bill->client->email}}</td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                            {{\App\Models\ShippingMethod::findOrFail(json_decode(\App\Models\billsCollection::findOrFail(json_decode($bill->bills_data)[0]->bill_id)->shipping_data)->shipping_method_id)->name}}


                            {{-- {{($bill->shipping_data != null ?  : '-') }} --}}
                        </td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                            @if($bill->status == 1)
                                مدفوع
                            @else
                                غير مدفوع
                            @endif
                        </td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                            {{$bill->reference_number}}
                        </td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                            {{number_format($bill->total_price, 2)}} SAR
                        </td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                            {{number_format($bill->total_shipping, 2)}} SAR
                        </td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                            {{number_format($bill->total_price + $bill->total_shipping, 2)}} SAR
                        </td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{ date('d-m-Y', strtotime($bill->created_at))}}</td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                            <x-jet-button wire:click="showBillInfoModel({{$bill->id}})" class="bg-green-600 mb-1 main-btn w-full block"><i class="mr-2 fas fa-info"></i> {{__(' المعلومات')}}</x-jet-button>
                            <a href="{{URL::to('collections/receipts-collection-for-user/'.$bill->id)}}"
                               class="items-center px-4 py-2 bg-gray-800 border border-transparent
                        rounded-md font-semibold text-xs text-white uppercase tracking-widest
                        hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                        focus:ring focus:ring-gray-300 disabled:opacity-25 transition w-full block ml-2 mb-1">
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
                        <th class="p-3"> السعر</th>
                        <th class="p-3"> الشحن</th>
                        <th class="p-3"> الاجمالي</th>
                        <th class="p-3"> البائع</th>
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
                @foreach ($my_products_requests as $request)
                    @php
                        $user = \App\Models\productRequestsCollection::with('buyer:id,name','provider:id,name', 'sender:id,name', 'product:id,name,main_image', 'bill', 'shipping_method', 'group')
                        ->whereIn('id', json_decode($request->reqsIDs))->first();
                    @endphp
                    <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">

                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($request->total_price, 2)}} SAR</td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($request->total_shipping, 2)}} SAR</td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($request->total_price + $request->total_shipping, 2)}} SAR</td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->provider->name}}</td>
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
                            <x-jet-button wire:click="showBillInfoModel({{$request->id}})" class="ml-2 mb-1 w-full main-btn"><i class="mr-2 fas fa-info"></i> {{__(' تفاصيل الطلب')}}</x-jet-button>
                            <a href="{{URL::to('collections/receipts-collection-for-user/'.$request->id)}}"
                               class="items-center px-4 py-2 bg-gray-800 border border-transparent
                        rounded-md font-semibold text-xs text-white uppercase tracking-widest
                        hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                        focus:ring focus:ring-gray-300 disabled:opacity-25 transition w-full block ml-2 mb-1">
                                <i class="mr-2 fas fa-receipt"></i> {{__(' الفاتورة')}}
                            </a>
                            @if($user->group != null)
                                <x-jet-button wire:click="goToGroup({{$user->group->id}})" class="mb-2 w-full"><i class="mr-2 fas fa-users"></i> {{__('الدخول للمجموعة')}}</x-jet-button>
                            @endif
                            {{--
                                <x-jet-button wire:click="editRequestStatus({{$request->id}})" class="ml-2 main-btn mb-1 w-full"><i class="mr-2 fas fa-edit"></i> {{__(' تغير الحالة')}}</x-jet-button>
                            --}}
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
                            <th class="p-3"> البائع</th>
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
                    @foreach ($productsRequests as $request)
                        @php
                            $user = \App\Models\productRequestsCollection::with('buyer:id,name','provider:id,name', 'sender:id,name', 'product:id,name,main_image', 'bill', 'shipping_method', 'group')
                            ->whereIn('id', json_decode($request->reqsIDs))->first();
                        @endphp
                        <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">

                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($request->total_price, 2)}} SAR</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($request->total_shipping, 2)}} SAR</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($request->total_price + $request->total_shipping, 2)}} SAR</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->provider->name}}</td>
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
                                <x-jet-button wire:click="showBillInfoModel({{$request->id}})" class="ml-2 mb-1 w-full main-btn"><i class="mr-2 fas fa-info"></i> {{__(' تفاصيل الطلب')}}</x-jet-button>
                                <a href="{{URL::to('collections/receipts-collection-for-user/'.$request->id)}}"
                                   class="items-center px-4 py-2 bg-gray-800 border border-transparent
                        rounded-md font-semibold text-xs text-white uppercase tracking-widest
                        hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                        focus:ring focus:ring-gray-300 disabled:opacity-25 transition w-full block ml-2 mb-1">
                                    <i class="mr-2 fas fa-receipt"></i> {{__(' الفاتورة')}}
                                </a>
                                @if($user->group != null)
                                    <x-jet-button wire:click="goToGroup({{$user->group->id}})" class="mb-2 w-full"><i class="mr-2 fas fa-users"></i> {{__('الدخول للمجموعة')}}</x-jet-button>
                                @endif
                                @if(!Auth::guard('clients')->user()->type == 3)
                                <x-jet-button wire:click="editRequestStatus({{$request->id}})" class="ml-2 main-btn mb-1 w-full"><i class="mr-2 fas fa-edit"></i> {{__(' تغير الحالة')}}</x-jet-button>
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
        @if($now_ProductsRequests != null)

            <div class="mx-1 richness-table clients-table">
                <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
                    <thead class="text-white mob-text-aline">
                    @foreach ($now_ProductsRequests as $user)
                        <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                            <th class="p-3"> السعر</th>
                            <th class="p-3"> الشحن</th>
                            <th class="p-3"> الاجمالي</th>
                            <th class="p-3"> البائع</th>
                            <th class="p-3"> المشتري</th>
                            <th class="p-3">حالة الدفع</th>
                            <th class="p-3">حالة الطلب</th>
                            <th class="p-3">موعد الاستلام</th>
                            <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                        </tr>
                    @endforeach
                    </thead>
                    <tbody class="flex-1 sm:flex-none">
                    @foreach ($now_ProductsRequests as $request)
                        @php
                            $user = \App\Models\productRequestsCollection::with('buyer:id,name','provider:id,name', 'sender:id,name', 'product:id,name,main_image', 'bill', 'shipping_method', 'group')
                            ->whereIn('id', json_decode($request->reqsIDs))->first();
                        @endphp
                        <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">

                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($request->total_price, 2)}} SAR</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($request->total_shipping, 2)}} SAR</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($request->total_price + $request->total_shipping, 2)}} SAR</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$user->provider->name}}</td>
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
                                <x-jet-button wire:click="showBillInfoModel({{$request->id}})" class="ml-2 mb-1 w-full"><i class="mr-2 fas fa-info"></i> {{__(' تفاصيل الطلب')}}</x-jet-button>
                                <x-jet-button wire:click="showSenderAcceptRequest({{$request->id}})" class="ml-2 w-full main-btn mb-1"><i class="mr-2 fas fa-check"></i> {{__(' قبول')}}</x-jet-button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <br>
            <div class="mx-1">
                {{$now_ProductsRequests->links()}}
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
