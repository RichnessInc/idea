<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mx-1 md:mx-0 clients-counter grid grid-cols-12 gap-4 mb-6">
                <div class="col-span-12 md:col-span-6">
                    <div class="rounded overflow-hidden shadow-lg bg-white w-full border-2 border-blue-400">
                        <div class="px-6 py-4 w-full text-center">
                            <h3 class="text-xl">ارباح هذا الشهر</h3>
                            <span class="text-2xl text-blue-400 font-extrabold"  style="direction: ltr;display:block;">{{$profitThisMonth}} SAR</span>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6">
                    <div class="rounded overflow-hidden shadow-lg bg-white w-full border-2 border-blue-400">
                        <div class="px-6 py-4 w-full text-center">
                            <h3 class="text-xl">ارباح اخر 3 شهور</h3>
                            <span class="text-2xl text-blue-400 font-extrabold" style="direction: ltr;display:block;">{{$profitLastThreeMonth}} SAR</span>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6">
                    <div class="rounded overflow-hidden shadow-lg bg-white w-full border-2 border-blue-400">
                        <div class="px-6 py-4 w-full text-center">
                            <h3 class="text-xl">ارباح اخر 6 شهور</h3>
                            <span class="text-2xl text-blue-400 font-extrabold" style="direction: ltr;display:block;">{{$profitLastSixMonth}} SAR</span>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6">
                    <div class="rounded overflow-hidden shadow-lg bg-white w-full border-2 border-blue-400">
                        <div class="px-6 py-4 w-full text-center">
                            <h3 class="text-xl">ارباح هذة السنة</h3>
                            <span class="text-2xl text-blue-400 font-extrabold" style="direction: ltr;display:block;">{{$profitThisYear}} SAR</span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ------------------------------- --}}
            <br><hr><br>
            <div class="mx-1 richness-table users-table">
                <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
                    <thead class="text-white mob-text-aline">
                    @foreach ($getReceipts as $bill)
                        <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                            <th class="p-3"><i class="fas fa-envelope"></i>الاسم</th>
                            <th class="p-3"><i class="fas fa-envelope"></i> البريد الالكتروني</th>
                            <th class="p-3"><i class="fas fa-credit-card"></i> وسيلة الدفع  </th>
                            <th class="p-3">الارباح من التاجر</th>
                            <th class="p-3">الارباح من الشحن</th>
                            <th class="p-3">اجمالي الارباح</th>
                            <th class="p-3"><i class="fas fa-clock"></i>  الوقت </th>
                            <th class="p-3"><i class="fas fa-calendar-day"></i> التاريخ</th>
                            <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                        </tr>
                    @endforeach
                    </thead>
                    <tbody class="flex-1 sm:flex-none">
                    @foreach ($getReceipts as $bill)
                        <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$bill['client_name']}}</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$bill['client_email']}}</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$bill['paymentmethod']}}</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($bill['profit_provider'], 2)}} SAR</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($bill['profit_sender'], 2)}} SAR</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($bill['profit_total'], 2)}} SAR</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{ date('g:i A', strtotime($bill['created_at']))}}</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{ date('d-m-Y', strtotime($bill['created_at']))}}</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                                <a href="{{URL::to('collections/receipts-collection-for-user/'.$bill['id'])}}"
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
        </div>
    </div>
</div>
