<div>
    @push('styles')
        <script src="https://paylink.sa/assets/js/paylink.js"></script>
        <script src="https://www.paypal.com/sdk/js?client-id=AcODvsk1YcaVLYnbkZyIOX8l_dZc49geTP9aqOjG6WbcW0UTmqeCE9NNZmFWlQsej_uDvGRFshJVpnI2&currency=USD"></script>
    @endpush
    @if(\App\Models\PaymentSetting::first()->text != null)
        <div class="bg-white shadow mb-2 mt-2 py-3 px-4 rounded" style="float: right;">
            {!! \App\Models\PaymentSetting::first()->text  !!}
        </div>
    @endif
    <x-jet-dialog-modal wire:model="deleteFormVisible">
        <x-slot name="title">{{ __('حذف الفاتورة') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من قرار حذف الفاتورة') }}</x-slot>
        <x-slot name="footer">
            <x-jet-danger-button wire:click='destroy' class="ml-2"><i class="fas fa-trash"></i> {{__('حذف')}}</x-jet-danger-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    <x-jet-dialog-modal wire:model="infoFormVisible">
        <x-slot name="title">{{ __('معلومات الفاتورة') }}</x-slot>
        <x-slot name="content">
            @if(count($billInfo) > 0)
                <ul>
                    <li> الاسم : {{$billInfo['name']}} </li>
                    <li> السعر : {{(float)$billInfo['price'] / (float)$billInfo['qty']}} SAR</li>
                    <li> ايام التسليم من وقت تأكيد الطلب : {{$billInfo['receipt_days']}} </li>
                    <li> الكمية : {{$billInfo['qty']}} </li>
                    <li> الدولة : {{$billInfo['country']}} </li>
                    <li> المدينة : {{$billInfo['government']}} </li>
                    <li> الاجمالي : {{(float)$billInfo['price']}} SAR</li>
                </ul>
                <h2 class="font-bold text-lg mt-2 mb-2">الاضافات</h2>

                @foreach(json_decode(json_encode($billInfo['extras'], true), true) as $extra)
                    <hr>
                    <ul>
                        <li> الاسم : {{$extra['name']}} </li>
                        <li> السعر : {{(float)$extra['price']}} SAR</li>
                        <li> الكمية : {{$extra['qty']}} </li>
                        <li> الاجمالي : {{(float)$extra['price'] * (float)$extra['qty']}} SAR</li>
                    </ul>
                @endforeach

            @endif
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    <h3><b>اضافة قسيمة شراء</b></h3>
    <div class="gift_ticket_container">
        <div class="box">
            <x-jet-label for='number' value="{{__('الرقم المرجعي')}}" />
            <x-jet-input type='number' id="number" wire:model='number' class="block mt-1 w-full" />
            @error('number')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>
        <div class="box relative">
            <i wire:click="showPasswordF" class="fas fa-eye" style="position: absolute; top: 37px; left: 10px; color: #006EB9FF; cursor: pointer;"></i>
            <x-jet-label for='password' value="{{__('الرقم السري')}}" />
            <x-jet-input type="{{$showPassword == false ? 'password' : 'text'}}" id="password" wire:model='password' class="block mt-1 w-full" />
            @error('password')
            <span class="text-red-500 mt-1">{{$message}}</span>
            @enderror
        </div>
        <div class="box">
            <x-jet-label for='number' style="opacity: 0" value="{{__('الرقم المرجعي')}}" />
            <x-jet-button wire:click='enterTicket' class="w-full main-btn"><i class="fas fa-check"></i> تحقق </x-jet-button>
        </div>
    </div>
    <div class="mx-1 richness-table clients-table">
        <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
            <thead class="text-white mob-text-aline">
            @foreach ($bills as $bill)
                <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                    <th class="p-3">الاسم</th>
                    <th class="p-3"><i class="fas fa-dollar-sign"></i> السعر</th>
                    <th class="p-3"><i class="fas fa-calendar-day"></i> التاريخ</th>
                    <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                </tr>
            @endforeach
            </thead>
            <tbody class="flex-1 sm:flex-none">
            @foreach ($bills as $bill)
                @if(json_decode($bill->item_data)->model == \App\Models\Product::class)
                    <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{json_decode($bill->item_data)->product->name}}</td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($bill->item_price, 2)}} SAR</td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{ date('d-m-Y', strtotime($bill->created_at))}}</td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                            <x-jet-button wire:click="billInfo({{$bill->id}})" class="ml-2 main-btn"><i class="mr-2 fas fa-info"></i> {{__('معلومات')}}</x-jet-button>
                            <x-jet-danger-button wire:click="confirmbillDelete({{$bill->id}})" class="ml-2"><i class="mr-2 fas fa-trash-alt"></i> {{__(' حذف')}}</x-jet-danger-button>
                        </td>
                    </tr>
                @endif
            @endforeach
            @if ($bills->count() > 0)
                <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">الشحن</td>
                    <td  colspan="4" class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3"><b>{{number_format($shipping, 2)}} SAR</b></td>
                </tr>
                @if($ticketStatus == true)
                    <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">قسيمة الشراء</td>
                        <td  colspan="4" class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3"><b>{{number_format($ticketValue, 2)}} SAR</b></td>
                    </tr>
                @endif
                <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">الاجمالي</td>
                    <td  colspan="4" class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3"><b>{{number_format($total - $ticketValue, 2)}} SAR</b></td>
                </tr>
            @endif

            </tbody>
        </table>
    </div>
    @if ($bills->count() == 0)
        <div role="alert">
            <div class="bg-yellow-500 text-white font-bold rounded-t px-4 py-2 shadow">
                <i class="fas fa-exclamation-triangle"></i> تنبيه
            </div>
            <div class="border border-t-0 border-yellow-400 rounded-b bg-yellow-100 px-4 py-3 text-yellow-700">
                <p>لا يوجد فواتير</p>
            </div>
        </div>
    @endif
    @if ($bills->count() > 0)
        <br>
        <div class="grid grid-cols-12 gap-4">
            @foreach ($paymentmethods as $paymentmethods)
                @if ($paymentmethods->status == 1)
                    @if ($paymentmethods->id == 1)
                        <div class="col-span-12 lg:col-span-3">
                            <div id="paypal-button-container"></div>
                            <script>
                                let usdValue = parseFloat("{{\App\Models\GeneralInfo::findOrFail(1)->currency}}");
                                let total = parseFloat("{{$total}}");
                                let total_price = total / usdValue;
                                paypal.Buttons({
                                    createOrder: function(data, actions) {
                                        // Set up the transaction
                                        return actions.order.create({
                                            purchase_units: [{
                                                amount: {
                                                    value: Math.ceil(total_price)
                                                }
                                            }]
                                        });
                                    },
                                    onApprove: function(data, actions) {
                                        return actions.order.capture().then(function(details) {
                                            let getAmountRequest = new XMLHttpRequest();
                                            getAmountRequest.onreadystatechange = function () {
                                                if (this.readyState === 4 && this.status === 200) {
                                                    let totalAmount = JSON.parse(this.responseText).amount;
                                                    console.log(total, totalAmount);
                                                    if(total == totalAmount) {
                                                        Livewire.emit('paypalProcess', data);
                                                    }
                                                }
                                            }
                                            getAmountRequest.open('GET', location.origin + '/paylink/get-amount-tow', true);
                                            getAmountRequest.send();
//
                                        });
                                    }
                                }).render('#paypal-button-container');
                            </script>
                        </div>
                    @elseif ($paymentmethods->id == 2)
                        <div class="col-span-12 lg:col-span-3">
                            <x-jet-button wire:click="payAtHome({{$total - $ticketValue}})" class=" w-full ml-2 paymentmethod home"><img src="{{asset('images/icons/delivery.png')}}" alt=""> <b>{{__('دفع عند الاستلام في المتجر')}}</b></x-jet-button>
                        </div>
                    @elseif ($paymentmethods->id == 3)
                        <div class="col-span-12 lg:col-span-3">
                            @php
                                $arr = [
                                    'name'              => \Illuminate\Support\Facades\Auth::guard('clients')->user()->name,
                                    'whatsapp_phone'    => \Illuminate\Support\Facades\Auth::guard('clients')->user()->whatsapp_phone,
                                    'email'             => \Illuminate\Support\Facades\Auth::guard('clients')->user()->email,
                                    'amount'            => $total - $ticketValue
                                ];
                            @endphp
                            <x-jet-button class="paymentmethod visapay shadow " style="padding: 0; margin: 0; background-color: transparent; border-radius: 0.25rem; overflow: hidden; width: 292px; height: 50px;" data-info="{{json_encode($arr)}}">
                                <img src="{{asset('images/paylink.jpg')}}" alt="" style="width: 100%; padding: 0; margin: 0; height: 100%;">
                            </x-jet-button>
                        </div>
                    @elseif ($paymentmethods->id == 4 && Auth::guard('clients')->user()->wallet >= ($total - $ticketValue))
                        <div class="col-span-12 lg:col-span-3">
                            <x-jet-button wire:click="payWithWallet({{$total - $ticketValue}})" class=" w-full ml-2 paymentmethod main-ntn"><img src="{{asset('images/icons/wallet.png')}}" alt=""> <b>{{__($paymentmethods->name)}}</b></x-jet-button>
                        </div>
                    @elseif ($paymentmethods->id == 6)
                        <div class="col-span-12 lg:col-span-3">
                            <x-jet-button wire:click="payWithUrway({{$total - $ticketValue}})" class=" w-full ml-2 paymentmethod main-ntn"><i class="fas fa-credit-card"></i> <b>{{__($paymentmethods->name)}}</b></x-jet-button>
                        </div>
                    @endif

                @endif
            @endforeach
        </div>
    @endif
</div>
@push('scripts')

@endpush
