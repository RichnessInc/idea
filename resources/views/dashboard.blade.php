<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2>الدول</h2>
                <div class="dashboard-container tow">
                    @foreach ($CountriesWithClientsCount as $item)
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h3>{{$item->name}}
                            <span style="display: block"><b>{{$item->clients_count}} عضو</b></span>
                        </h3>
                    </div>
                    @endforeach
                </div>
            </div>
            <hr>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2>المدن</h2>
                <div class="dashboard-container tow">
                    @foreach ($GovernmentsWithClientsCount as $item)
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h3>{{$item->name}}
                            <span style="display: block"><b>{{$item->clients_count}} عضو</b></span>
                        </h3>
                    </div>
                    @endforeach
                </div>
            </div>
            <hr>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2>الاعضاء</h2>
                <div class="dashboard-container">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h3>عدد المشترين
                            <span style="display: block"><b>{{$payers}}</b></span>
                        </h3>
                    </div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h3>عدد التجار
                            <span style="display: block"><b>{{$providors}}</b></span>
                        </h3>
                    </div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h3>عدد الصناع
                            <span style="display: block"><b>{{$createor}}</b></span>
                        </h3>
                    </div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h3>عدد المندوبين
                            <span style="display: block"><b>{{$sender}}</b></span>
                        </h3>
                    </div>
                </div>
            </div>
            <hr>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2>الطلبات</h2>
                <div class="dashboard-container">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h3>عدد الطلبات هذا الشهر
                            <span style="display: block"><b>{{$thisMonthRequests}}</b></span>
                        </h3>
                    </div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h3>عدد الطلبات الشهر الماضي
                            <span style="display: block"><b>{{$lastMonthRequests}}</b></span>
                        </h3>
                    </div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h3>عدد الطلبات اخر ثلاثة اشهر
                            <span style="display: block"><b>{{$lastThreeMonthsRequests}}</b></span>
                        </h3>
                    </div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h3>عدد الطلبات هذة السنه
                            <span style="display: block"><b>{{$thisYearRequests}}</b></span>
                        </h3>
                    </div>
                </div>
            </div>
            <hr>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2>وسائل الدفع</h2>
                <div class="dashboard-container paymthd">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h3>عدد مرات استخدام باي بال
                            <span style="display: block"><b>{{$paypalCountUsage}}</b></span>
                        </h3>
                    </div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h3>عدد مرات استخدام الدفع عند الاستلام
                            <span style="display: block"><b>{{$onReciveCountUsage}}</b></span>
                        </h3>
                    </div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h3>عدد مرات استخدام الدفع باي لينك
                            <span style="display: block"><b>{{$paylinkCountUsage}}</b></span>
                        </h3>
                    </div>

                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2>اجمالي المبيعات</h2>
                <div class="dashboard-container">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h3> اجمالي المبيعات هذا الشهر
                            <span style="display: block"><b>{{$thisMonthReceipts}} SAR</b></span>
                        </h3>
                    </div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h3> اجمالي المبيعات الشهر الماضي
                            <span style="display: block"><b>{{$lastMonthReceipts}} SAR</b></span>
                        </h3>
                    </div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h3> اجمالي المبيعات اخر ثلاثة اشهر
                            <span style="display: block"><b>{{$lastThreeMonthsReceipts}} SAR</b></span>
                        </h3>
                    </div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h3> اجمالي المبيعات هذة السنة
                            <span style="display: block"><b>{{$thisYearReceipts}} SAR</b></span>
                        </h3>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>
</x-app-layout>
