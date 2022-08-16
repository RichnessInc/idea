<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('كروت المعايدة') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{route('frontend.cards.create')}}" class="items-center px-4 py-2 bg-gray-800 border
            border-transparent
            rounded-md font-semibold text-xs text-white uppercase tracking-widest
            hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
            focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-2 mb-2 text-center main-btn">
                <i class="fas fa-plus"></i> {{__('اضافة كرت')}}
            </a>
            <div class="mx-1 richness-table clients-table-cards">
                <table class="w-full flex flex-row flex-no-wrap sm:bg-white sm:dark:bg-gray-900 rounded-lg overflow-hidden sm:shadow-lg my-5">
                    <thead class="text-white mob-text-aline">
                    @foreach ($cards as $card)
                        <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0 table-tr">
                            <th class="p-3">من</th>
                            <th class="p-3">الى</th>
                            <th class="p-3"><i class="fas fa-calendar-day"></i> التاريخ</th>
                            <th class="p-3"><i class="fas fa-tools"></i> التحكم</th>
                        </tr>
                    @endforeach
                    </thead>
                    <tbody class="flex-1 sm:flex-none">
                    @foreach ($cards as $favourite)
                        <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 bg-white dark:bg-gray-900 mob-text-aline">
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$favourite->from}}</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{$favourite->to}}</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">{{ date('d-m-Y', strtotime($favourite->created_at))}}</td>
                            <td class="border-grey-light border dark:text-gray-300 dark:hover:bg-gray-800 hover:bg-gray-100 p-3">
                                <x-jet-button data-url="{{route('frontend.cards.single', ['slug' => $favourite->slug])}}" class="copy-btn block w-full"><i class="fas fa-copy"></i> نسخ </x-jet-button>
                                <a href="{{route('frontend.cards.single', ['slug' => $favourite->slug])}}" class="items-center px-4 py-2 bg-gray-800 border
                                border-transparent  block w-full
                                rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                                focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-2 mb-2 text-center">
                                    <i class="mr-2 fas fa-eye"></i> {{__('مشاهدة')}}
                                </a>
                                <a href="{{route('frontend.cards.edit', ['id' => $favourite->id])}}" class="items-center px-4 py-2 bg-gray-800 border
                                border-transparent  block w-full
                                rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                                focus:ring focus:ring-gray-300 disabled:opacity-25 transition ml-2 mb-2 text-center main-btn">
                                    <i class="mr-2 fas fa-edit"></i> {{__('تعديل')}}
                                </a>

                                <form action="{{route('frontend.cards.process.delete', ['id' => $favourite->id])}}" style="display: inline-block" method="POST">
                                    @csrf
                                    <x-jet-danger-button type="submit" class="ml-2 block w-full"><i class="mr-2 fas fa-trash-alt"></i> {{__(' حذف')}}</x-jet-danger-button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function copyFunction(text) {
            let input = document.createElement("input");
            input.value = text;
            input.select();
            input.setSelectionRange(0, 99999); /* For mobile devices */
            /* Copy the text inside the text field */
            navigator.clipboard.writeText(input.value);
        }

        let copyBtn = document.querySelectorAll('.copy-btn');
        if (typeof(copyBtn) != 'undefined' && copyBtn != null) {

            copyBtn.forEach((el) => {
                el.addEventListener('click', function (e) {
                    let text = el.dataset.url;
                    copyFunction(text);
                });
            });
        }
    </script>
</x-guest-layout>
