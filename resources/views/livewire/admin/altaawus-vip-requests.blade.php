<div>
    <x-jet-dialog-modal wire:model="acceptFormVisible">
        <x-slot name="title">{{ __('اتمام الطلب') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من اتمام الطلب') }}</x-slot>
        <x-slot name="footer">
            <x-jet-button wire:click='acceptReq' class="ml-2 main-btn"><i class="fas fa-check"></i> {{__(' تم بنجاح')}}</x-jet-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    <x-jet-dialog-modal wire:model="informationFormVisible">
        <x-slot name="title">{{ __('معلومات الطلب') }}</x-slot>
        <x-slot name="content">
            @if($infoData != null)
                <ul>
                    <li>اسم العميل : {{ ($infoData->client != null ? $infoData->client->name : '-' )}}</li>
                    <li>البريد الالكتروني : {{ $infoData->email  }}</li>
                    <li>الرقم : {{ $infoData->whatsapp_phone  }}</li>
                    <li>الدولة : {{ $infoData->country->name  }}</li>
                    <li>

                        {{ ($infoData->government != null ? $infoData->government->name : '-') }}
                        :
                        المحافظة
                    </li>
                    <li>المحافظة : {{ $infoData->sector  }}</li>
                    <li>الشارع : {{ $infoData->street  }}</li>
                    <li>رقم العمارة : {{ $infoData->build_no  }}</li>
                    <li>الدور : {{ $infoData->floor  }}</li>
                    <li>
                        رقم الوحدة
                        :
                        {{ $infoData->unit_no  }}

                    </li>
                    <li>التفاصيل : {{ $infoData->details  }}</li>
                    <li>

                        وسيلة التوصيل المخاترة
                        :
                        {{ ($infoData->shipping_method != null ? $infoData->shipping_method->name : '-') }}
                        </li>
                </ul>
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
{{-- Start Users Table --}}
<!-- This example requires Tailwind CSS v2.0+ -->
    <div id="vipRequestAdmin">
        <div class="mx-1 richness-table clients-table">
            <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
                <thead class="text-white mob-text-aline">
                @foreach ($requests as $request)
                    <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                        <th class="p-3">الاسم</th>
                        <th class="p-3"><i class="fas fa-envelope"></i> البريد الالكتروني</th>
                        <th class="p-3"><i class="fas fa-user"></i> الدولة </th>
                        <th class="p-3"><i class="fas fa-user"></i> المدينة </th>
                        <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                    </tr>
                @endforeach
                </thead>
                <tbody class="flex-1 sm:flex-none">
                @foreach ($requests as $request)
                    <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{( $request->client != null ? $request->client->name : '-')}}</td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$request->email}}</td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{($request->country != null ? $request->country->name : '-')}}</td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{($request->government != null ? $request->government->name : '-')}}</td>
                        <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                            <x-jet-button wire:click="information({{$request->id}})" class="mb-1"><i class="mr-2 fas fa-info"></i> {{__(' المعلومات')}}</x-jet-button>
                            <x-jet-button wire:click="accept({{$request->id}})" class="main-btn mb-1"><i class="mr-2 fas fa-check"></i> {{__(' تم بنجاح')}}</x-jet-button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <br>
    <div class="mx-1">
        {{$requests->links()}}
    </div>
</div>
