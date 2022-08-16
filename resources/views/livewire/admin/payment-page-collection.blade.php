<div>
    <div class="search-container grid grid-cols-12 gap-4">
        <div class="col-span-12">
            <input wire:model='searchForm'
                   class="dark:bg-gray-900 dark:text-gray-100 mb-2 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                   type="text"
                   value=" "
                   autocomplete="new-password"
                   placeholder="البحث">
        </div>
    </div>
    <x-jet-button wire:click='debt_settlement' class="ml-2 bg-green-600">{{__('تسوية الديون')}}</x-jet-button>
    {{-- Start Delete User Model --}}
    <x-jet-dialog-modal wire:model="acceptFormVisible">
        <x-slot name="title">{{ __('قبول طلب الدفع') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من قرار قبول طلب الدفع') }}</x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click='accept' class="ml-2 bg-green-600"><i class="fas fa-check"></i> {{__('قبول')}}</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    <x-jet-dialog-modal wire:model="rejectFormVisible">
        <x-slot name="title">{{ __('رفض الطلب') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من قرار رفض الطلب') }}</x-slot>
        <x-slot name="footer">
            <x-jet-danger-button wire:click='reject' class="ml-2"><i class="fas fa-ban"></i> {{__('رفض')}}</x-jet-danger-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    <x-jet-dialog-modal wire:model="contentFormVisible">
        <x-slot name="title">{{ __('معلومات الطلب') }}</x-slot>
        <x-slot name="content">
            @if($info != null)
                <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-dolly-flatbed"></i> الشحن : {{number_format($info->total_shipping, 2)}} ريال </li>
                    <li class="py-2 px-4 w-full border-b border-gray-200 dark:border-gray-600"><i class="fas fa-calculator"></i> المجموع : {{number_format($info->total_price + $info->total_shipping, 2)}} ريال </li>
                </ul>
                <br>
                <h4>التفاصيل</h4>
                <br>
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
                            @if(!$loop->last) <br><hr> @endif
                        </div>
                    @endif
                @endforeach

            </div>

                <br>
                <ul class="w-full text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> وسيلة الدفع : {{$info->paymentmethod }}</li>
                    @if(!empty(json_decode($info->payment_data)) && $info->paymentmethod == 'paypal')
                        <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> الرقم المرجعي : {{json_decode($info->payment_data)->orderID }}</li>
                    @elseif(!empty(json_decode($info->payment_data)) && $info->paymentmethod == 'paylink')
                        <li class="py-2 px-4 w-full rounded-t-lg border-b border-gray-200 dark:border-gray-600"> الرقم المرجعي : {{json_decode($info->payment_data)->paymentId }}</li>

                    @endif
                </ul>
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    {{-- End Delete User Model --}}
    {{-- Start Users Table --}}
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="mx-1 richness-table users-table">
        <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
            <thead class="text-white mob-text-aline">
            @foreach ($bills as $bill)
                <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                    <th class="p-3"><i class="fas fa-envelope"></i> البريد الالكتروني</th>
                    <th class="p-3"><i class="fas fa-credit-card"></i> وسيلة الدفع  </th>
                    <th class="p-3"><i class="fas fa-sort-numeric-up-alt"></i> رقم التتبع </th>
                    <th class="p-3"><i class="fas fa-toggle-on"></i> الحالة</th>
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
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$bill->paymentmethod}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        {{$bill->reference_number}}
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
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{ date('g:i A', strtotime($bill->created_at))}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{ date('d-m-Y', strtotime($bill->created_at))}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        <a href="{{URL::to('collections/receipts-collection-for-user/'.$bill->id)}}"
                           class="items-center px-4 py-2 bg-gray-800 border border-transparent
                        rounded-md font-semibold text-xs text-white uppercase tracking-widest
                        hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                        focus:ring focus:ring-gray-300 disabled:opacity-25 transition w-full block ml-2 mb-1">
                            <i class="mr-2 fas fa-receipt"></i> {{__(' الفاتورة')}}
                        </a>
                        <x-jet-button wire:click="showContent({{$bill->id}})" class="bg-green-600 mb-1 main-btn w-full block"><i class="mr-2 fas fa-info"></i> {{__(' المعلومات')}}</x-jet-button>
                        <x-jet-button wire:click="confirmAccept({{$bill->id}})" class="bg-green-600 mb-1 w-full block"><i class="mr-2 fas fa-check"></i> {{__(' قبول')}}</x-jet-button>
                        <x-jet-danger-button wire:click="confirmReject({{$bill->id}})" class="mb-1 block w-full"><i class="mr-2 fas fa-ban"></i> {{__(' رفض')}}</x-jet-danger-button>
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
