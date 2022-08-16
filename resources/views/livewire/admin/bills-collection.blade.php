<div>
    @if($data != null)
        <x-jet-dialog-modal wire:model="contentFormVisible">
            <x-slot name="title">{{ __('معلومات الطلب') }}</x-slot>
            <x-slot name="content">
                @if($data != null)
                    <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dolly-flatbed"></i> الشحن : {{number_format($data->total_shipping, 2)}} ريال </li>
                        <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-calculator"></i> المجموع : {{number_format($data->total_price + $data->total_shipping, 2)}} ريال </li>
                    </ul>
                    <br>
                    <h4>التفاصيل</h4>
                    <br>
                    <div class="grid grid-cols-12 gap-4 relative">
                        @foreach(json_decode($data->bills_data) as $dat)
                            @if(json_decode($dat->item_data)->model == \App\Models\Product::class)
                                <div class="md:col-span-6 col-span-12">
                                    <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dollar-sign"></i> اسم المنتج : {{json_decode($dat->item_data)->product->name}}</li>
                                        <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dollar-sign"></i> سعر المنتج :  {{number_format(json_decode($dat->item_data)->product->price / json_decode($dat->item_data)->product->qty, 2)}} </li>
                                        <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dolly-flatbed"></i> ايام التسليم : {{json_decode($dat->item_data)->product->receipt_days}} </li>
                                        <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-calculator"></i> الكمية : {{json_decode($dat->item_data)->product->qty}} </li>
                                        <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dollar-sign"></i> سعر الاجمالي :  {{number_format(json_decode($dat->item_data)->product->price, 2)}} </li>
                                    </ul>
                                    <br>
                                    @if(!empty(json_decode($dat->item_data)->extra))
                                        @foreach(json_decode($dat->item_data)->extra as $extra)
                                            <h4>الاضافات</h4><br>
                                            <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dollar-sign"></i> اسم المنتج : {{$extra->name}}</li>
                                                <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dollar-sign"></i> سعر المنتج :  {{number_format($extra->price, 2)}} </li>
                                                <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-calculator"></i> الكمية : {{$extra->qty}} </li>
                                                <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-calculator"></i> الاجمالي : {{number_format($extra->price * $extra->qty, 2)}} </li>

                                            </ul>
                                        @endforeach
                                    @endif
                                    @if(!$loop->last) <br><hr> @endif
                                </div>
                            @endif
                        @endforeach

                    </div>

                    <br>
                    <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> وسيلة الدفع : {{$data->paymentmethod }}</li>
                        @if(!empty(json_decode($data->payment_data)) && $data->paymentmethod == 'paypal')
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> الرقم المرجعي : {{json_decode($data->payment_data)->orderID }}</li>
                        @elseif(!empty(json_decode($data->payment_data)) && $data->paymentmethod == 'paylink')
                            <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> الرقم المرجعي : {{json_decode($data->payment_data)->paymentId }}</li>

                        @endif
                    </ul>
                @endif
            </x-slot>
            <x-slot name="footer">
                <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
            </x-slot>
        </x-jet-dialog-modal>
    @endif
    <div class="mx-1 richness-table users-table">
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
                    <th class="p-3"><i class="fas fa-clock"></i>  الوقت </th>
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
                    </td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        @if ($bill->status == 0)
                            <span class="p-2 block rounded shadow bg-blue-500  text-gray-50">غير مدفوع</span>
                        @elseif ($bill->status == 2)
                            <span class="p-2 block rounded shadow bg-green-300">مقبول</span>
                        @elseif ($bill->status == 3)
                            <span class="p-2 block rounded shadow bg-red-300" >مرفوض</span>
                        @elseif ($bill->status == 1)
                            <span class="p-2 block rounded shadow bg-yellow-300" >إنتظار</span>
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
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{ date('g:i A', strtotime($bill->created_at))}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{ date('d-m-Y', strtotime($bill->created_at))}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        <x-jet-button wire:click="showContent({{$bill->id}})" class="bg-green-600 mb-1 main-btn w-full block"><i class="mr-2 fas fa-info"></i> {{__(' المعلومات')}}</x-jet-button>
                        @if($bill->shipping_method_data != null && isset(json_decode($bill->shipping_method_data)->url_shipping_label))
                            <a target="_blank" href="{{json_decode($bill->shipping_method_data)->url_shipping_label}}"
                               class="items-center px-4 py-2 bg-gray-800 border border-transparent
                        rounded-md font-semibold text-xs text-white uppercase tracking-widest
                        hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                        focus:ring focus:ring-gray-300 disabled:opacity-25 transition w-full block ml-2 mb-1">
                                <i class="mr-2 fas fa-receipt"></i> رابط فاتورة الشحنه
                            </a>
                        @endif
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
</div>
