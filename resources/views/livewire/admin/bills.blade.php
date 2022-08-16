<div>
    @if($data != null)
    <x-jet-dialog-modal wire:model="contentFormVisible">
        <x-slot name="title">{{ __('معلومات الطلب') }}</x-slot>
        <x-slot name="content">
            @if($data != null)
                <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dollar-sign"></i> سعر المنتج : {{number_format($data->total_price - $data->total_shipping, 2)}} ريال </li>
                    <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dolly-flatbed"></i> الشحن : {{number_format($data->total_shipping, 2)}} ريال </li>
                    <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-calculator"></i> المجموع : {{number_format($data->total_price, 2)}} ريال </li>
                </ul>
                <br>
                <h4>التفاصيل</h4>
                <br>
                @if(json_decode($data->item_data)->model == \App\Models\Gift::class ||
                        json_decode($data->item_data)->model == \App\Models\Reesh::class||
                        json_decode($data->item_data)->model == \App\Models\GiftTicket::class||
                        json_decode($data->item_data)->model == \App\Models\Package::class)
                    <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dollar-sign"></i> اسم المنتج : {{json_decode($data->item_data)->name}}</li>
                        <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dollar-sign"></i> سعر المنتج :  {{number_format($data->item_price, 2)}} </li>
                        <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dolly-flatbed"></i> سعر الشحن : {{number_format($data->shipping, 2)}} ريال </li>
                        <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-calculator"></i> المجموع : {{number_format($data->total_price, 2)}} ريال </li>
                    </ul>
                    <br>
                @else
                    <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dollar-sign"></i> اسم المنتج : {{json_decode($data->item_data)->product->name}}</li>
                        <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dollar-sign"></i> سعر المنتج :  {{number_format(json_decode($data->item_data)->product->price, 2)}} </li>
                        <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dolly-flatbed"></i> ايام التسليم : {{json_decode($data->item_data)->product->receipt_days}} </li>
                        <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-calculator"></i> الكمية : {{json_decode($data->item_data)->product->qty}} </li>
                    </ul>
                    @if(!empty(json_decode($data->item_data)->extra))
                        @foreach(json_decode($data->item_data)->extra as $extra)
                            <br><h4>الاضافات</h4><br>
                            <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dollar-sign"></i> اسم المنتج : {{$extra->name}}</li>
                                <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dollar-sign"></i> سعر المنتج :  {{number_format($extra->price, 2)}} </li>
                                <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-calculator"></i> الكمية : {{$extra->qty}} </li>

                            </ul>
                        @endforeach
                    @endif
                @endif
                <br>
                <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> الرقم الشحنه : {{( json_decode($data->shipping_method_data) != null ? json_decode($data->shipping_method_data)->shipment_id : '') }}</li>
                    <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> الرقم تتبع الشحنه - readbox : {{( json_decode($data->shipping_method_data) != null ? json_decode($data->shipping_method_data)->tracking_number : '' )}}</li>
                    <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> رابط فاتورة الشحنه : {{( json_decode($data->shipping_method_data) != null ?  json_decode($data->shipping_method_data)->url_shipping_label : '') }}</li>
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
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{($bill->shipping_data != null ? \App\Models\ShippingMethod::findOrFail(json_decode($bill->shipping_data)->shipping_method_id)->name : '-') }}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        {{$bill->reference_number}}
                    </td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        {{number_format($bill->item_price, 2)}} SAR
                    </td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        {{number_format($bill->shipping, 2)}} SAR
                    </td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        {{number_format($bill->total_price, 2)}} SAR
                    </td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{ date('g:i A', strtotime($bill->created_at))}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{ date('d-m-Y', strtotime($bill->created_at))}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">

                        @if($bill->shipping_method_data != null && isset(json_decode($bill->shipping_method_data)->url_shipping_label))
                            <a target="_blank" href="{{json_decode($bill->shipping_method_data)->url_shipping_label}}"
                               class="items-center px-4 py-2 bg-gray-800 border border-transparent
                        rounded-md font-semibold text-xs text-white uppercase tracking-widest
                        hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                        focus:ring focus:ring-gray-300 disabled:opacity-25 transition w-full block ml-2 mb-1">
                                <i class="mr-2 fas fa-receipt"></i> رابط فاتورة الشحنه
                            </a>
                        @endif
                        <x-jet-button wire:click="showContent({{$bill->id}})" class="bg-green-600 mb-1 main-btn w-full block"><i class="mr-2 fas fa-info"></i> {{__(' المعلومات')}}</x-jet-button>
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
