<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 single-receipt">
            <div class="shadow bg-white p-3 rounded">
                <h2 class="text-3xl">بيانات الفاتورة</h2>
                <ul class="main-data">
                    <ul>
                        <li class="mb-2 mt-2"> اسم المشتري : {{$row->client->name}} </li>
                        <li class="mb-2"> تاريخ الاصدار : {{date('d-m-Y', strtotime($row->created_at))}} </li>
                        <li class="mb-2"> الساعة : {{date('h:i A', strtotime($row->created_at))}} </li>
                        <li class="mb-2 print"><x-jet-button onclick="window.print()"><i class="fas fa-print"></i> طباعة </x-jet-button></li>

                    </ul>
                    <li>
                        <img src="{{asset('images/logo.png')}}" class="block h-24 w-auto ml-2.5" />
                    </li>
                    <li>
                        <div class="qrcode-thumb lg:w-32 w-9">
                            @if($row->qr_code == null)
                                <div id="qrcode"></div>
                            @else
                                <img src="{{$row->qr_code}}" alt="">
                        @endif
                    </li>
                </ul>
                <br>
                <hr>
                <br>
                <h2 class="text-lg">المنتجات</h2>
                <div class="mx-1 richness-table clients-table">
                    <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
                        <thead class="text-white mob-text-aline">
                        @foreach(json_decode($row->bills_data) as $data)
                            <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                                <th class="p-3"> البائع</th>
                                <th class="p-3"> المنتج</th>
                                <th class="p-3"> الكمية</th>
                                <th class="p-3">السعر</th>
                            </tr>
                        @endforeach
                        </thead>
                        <tbody class="flex-1 sm:flex-none">
                        @foreach(json_decode($row->bills_data) as $data)
                            @if(json_decode($data->item_data)->model == \App\Models\Product::class)
                                <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{\App\Models\Product::with('client:id,name')->findOrFail(json_decode($data->item_data)->product->id)->client->name}}</td>
                                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{json_decode($data->item_data)->product->name}}</td>
                                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{json_decode($data->item_data)->product->qty}}</td>
                                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format( (json_decode($data->item_data)->product->price / json_decode($data->item_data)->product->qty) , 2)}} SAR</td>
                                </tr>
                                @foreach(json_decode($data->item_data)->extra as $extraData)
                                    <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{\App\Models\Product::with('client:id,name')->findOrFail(json_decode($data->item_data)->product->id)->client->name}}</td>
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$extraData->name}}</td>
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$extraData->qty}}</td>
                                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($extraData->price, 2)}} SAR</td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <br>
                <h2 class="text-lg">الاجمالي</h2>
                <div class="mx-1 richness-table clients-table">
                    <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
                        <thead class="text-white mob-text-aline">
                        <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                            <th class="p-3">سعر المنتجات</th>
                            <th class="p-3">الشحن</th>
                            <th class="p-3">الاجمالي</th>
                            <th class="p-3">وسيلة الدفع</th>
                        </tr>
                        </thead>
                        <tbody class="flex-1 sm:flex-none">
                        <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($row->total_price)}} SAR</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($row->total_shipping, 2)}} SAR</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($row->total_price + $row->total_shipping, 2)}} SAR</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$row->paymentmethod}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if($row->qr_code == null)
        @push('scripts')
            <script src="{{asset('js/jquery.min.js')}}"></script>
            <script src="{{asset('js/qrcode.min.js')}}"></script>
            <script>
                let qrcode = new QRCode("qrcode");
                qrcode.makeCode(window.location.href);
                setTimeout(() => {
                    let qrCodeSrc = document.querySelector('#qrcode img').getAttribute('src');
                    $.ajax({
                        type: "PATCH",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: window.location.origin+'/collections/update-receipts-for-user/'+"{{$row->id}}",
                        data: {
                            _token:$('meta[name="csrf-token"]').attr('content'),
                            qrcode:qrCodeSrc
                        },

                        success: function(msg) {

                        },
                        error: function (msg) {

                        }
                    });
                }, 2000);
            </script>
        @endpush
    @endif
</x-guest-layout>
