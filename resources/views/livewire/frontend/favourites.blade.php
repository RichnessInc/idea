<div>
    <x-jet-dialog-modal wire:model="deleteFormVisible">
        <x-slot name="title">{{ __('حذف الفاتورة') }}</x-slot>
        <x-slot name="content">{{ __('انت متأكد من قرار حذف الفاتورة') }}</x-slot>
        <x-slot name="footer">
            <x-jet-danger-button wire:click='destroy' class="ml-2"><i class="fas fa-trash"></i> {{__('حذف')}}</x-jet-danger-button>
            <x-jet-secondary-button wire:click='hideModel' class="ml-2"><i class="fas fa-times"></i> {{__(' إلغاء')}}</x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
    <div class="mx-1 richness-table "  id="fevTable">
        <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
            <thead class="text-white mob-text-aline">
                @foreach ($favourites as $favourite)
                <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                    <th class="p-3"><i class="fas fa-images"></i> صورة المنتج</th>
                    <th class="p-3">الاسم</th>
                    <th class="p-3"><i class="fas fa-dollar-sign"></i> السعر</th>
                    <th class="p-3"><i class="fas fa-calendar-day"></i> التاريخ</th>
                    <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                </tr>
                @endforeach
            </thead>
            <tbody class="flex-1 sm:flex-none">
                @foreach ($favourites as $favourite)
                <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3"><img class="shadow" style="width: 60px; border-radius: 50%; height: 60px; display: block; margin: auto;" src="{{asset('uploads/'.$favourite->product->main_image)}}" alt=""></td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        <a  href="{{($favourite->product->slug != null ? route('frontend.single-product', ['slug'=> $favourite->product->slug]) : '') }}" >{{$favourite->product->name}}</a>
                    </td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{number_format($favourite->product->price, 2)}} SAR</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{ date('d-m-Y', strtotime($favourite->created_at))}}</td>
                    <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                        <a href="{{($favourite->product->slug != null ? route('frontend.single-product', ['slug'=> $favourite->product->slug]) : '') }}" class="items-center px-4 py-2 bg-gray-800 border
                        border-transparent block
                        rounded-md font-semibold text-xs text-white uppercase tracking-widest
                        hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                        focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-2 mb-2 text-center">
                            <i class="fas fa-eye"></i> {{__('الذهاب للمنتج')}}
                        </a>
                        <x-jet-danger-button wire:click="confirmbillDelete({{$favourite->id}})" class="ml-2"><i class="mr-2 fas fa-trash-alt"></i> {{__(' حذف')}}</x-jet-danger-button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if (count($favourites) == 0)
    <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 rounded shadow mb-4 g-alert" role="alert">
        <p><i class="fas fa-heart-broken"></i> لا يوجد منتجات في المفضلة </p>
    </div>
    @endif
    <br>
    <div class="mx-1">
    {{$favourites->links()}}
    </div>
</div>
