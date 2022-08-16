<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-28">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{asset('images/logo.png')}}" class="block h-24 w-auto ml-2.5" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden ml-2 sm:-my-px sm:flex">
                    <x-jet-nav-link href="{{ route('dashboard.users') }}" :active="request()->routeIs('dashboard.users')">
                        {{ __('المشرفين') }}
                    </x-jet-nav-link>
                </div>
                <div class="qup-dropdown hidden ml-2 sm:-my-px sm:flex">
                    <x-jet-dropdown class="" align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>الاعدادات</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-jet-dropdown-link href="{{ route('dashboard.general-info') }}" :active="request()->routeIs('dashboard.general-info')">
                                {{ __('الاعدادات العامة') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link href="{{route('admin.homepage-settings')}}">
                                {{ __('اعدادات الصفحة الرئيسية') }}
                            </x-jet-dropdown-link>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                <div class="qup-dropdown hidden ml-2 sm:-my-px sm:flex">
                    <x-jet-dropdown class="" align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>الصفحات</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @php
                                $pages = \App\Models\mainPage::get();
                            @endphp
                            @foreach ($pages as $page)
                            <x-jet-dropdown-link href="{{route('admin.main-pages', [
                                'slug' => $page->slug
                            ])}}">
                                {{ __($page->name) }}
                            </x-jet-dropdown-link>
                            @endforeach
                            <x-jet-dropdown-link href="{{route('admin.resh-page')}}">
                                ريشة الرح
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{route('admin.gifts-page')}}">
                                صندوق الحظ
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{route('admin.altaawus-vip')}}">
                                {{ __('الطاووس VIP') }}
                            </x-jet-dropdown-link>
                        </x-slot>
                    </x-jet-dropdown>
                </div>

                <div class="qup-dropdown hidden ml-2 sm:-my-px sm:flex">
                    <x-jet-dropdown class="" align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>الأعضاء</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-jet-dropdown-link href="{{route('dashboard.verify-clients')}}">
                                {{ __('العملاء الغير مفعلين') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{route('dashboard.clients')}}">
                                {{ __('الأعضاء') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{route('dashboard.band-clients')}}">
                                {{ __('الأعضاء المحظورين') }}
                            </x-jet-dropdown-link>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                <div class="qup-dropdown hidden ml-2 sm:-my-px sm:flex">
                    <x-jet-dropdown class="" align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>الدول و محافظات</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-jet-dropdown-link href="{{route('dashboard.shipping')}}">
                                {{ __('إعدادات الشحن') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{route('dashboard.countries')}}">
                                {{ __('الدول') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{route('dashboard.governments')}}">
                                {{ __('المدن') }}
                            </x-jet-dropdown-link>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                <div class="qup-dropdown hidden ml-2 sm:-my-px sm:flex">
                    <x-jet-dropdown class="" align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>الإدارة المالية الجماعبة</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-jet-dropdown-link href="{{route('dashboard.payment-page-collection')}}">
                                {{ __('طلبات الدفع') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{route('admin.collection.profit.index')}}">
                                {{ __('تقرير الارباح') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('admin.product-requests-collections') }}" :active="request()->routeIs('admin.product-requests-collections')">
                                {{ __(' طلبات شراء المنتجات') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('admin.bills.collection') }}" :active="request()->routeIs('admin.bills.collection')">
                                {{ __(' الفواتير المفصله') }}
                            </x-jet-dropdown-link>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                <div class="qup-dropdown hidden ml-2 sm:-my-px sm:flex">
                    <x-jet-dropdown class="" align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>الإدارة المالية</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-jet-dropdown-link href="{{route('dashboard.payment.settings')}}">
                                {{ __('الإعدادات') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{route('dashboard.payment-page')}}">
                                {{ __('طلبات الدفع') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{route('dashboard.payment-debt')}}">
                                {{ __('العملاء المديونين') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{route('admin.profit.login')}}">
                                {{ __('تقرير الارباح') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('admin.package-buyers') }}" :active="request()->routeIs('admin.package-buyers')">
                                {{ __(' طلبات شراء الباقات') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('admin.product-requests') }}" :active="request()->routeIs('admin.product-requests')">
                                {{ __(' طلبات شراء المنتجات') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('admin.bills') }}" :active="request()->routeIs('admin.bills')">
                                {{ __(' الفواتير المفصله') }}
                            </x-jet-dropdown-link>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                <div class="qup-dropdown hidden ml-2 sm:-my-px sm:flex">
                    <x-jet-dropdown class="" align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>الهدايا</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-jet-dropdown-link href="{{route('dashboard.ticket-gifts')}}">
                                {{ __('تذاكر الشراء') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{route('dashboard.reesh')}}">
                                {{ __('ريش المرح') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{route('dashboard.giftsbox')}}">
                                {{ __('صناديق الحظ') }}
                            </x-jet-dropdown-link>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                @if (Auth::user()->chat_on == 1)
                <div class="qup-dropdown hidden ml-2 sm:-my-px sm:flex">
                    <x-jet-dropdown class="" align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>الدردشة</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-jet-dropdown-link href="{{route('dashboard.admin.chat.single.all')}}">
                                {{ __('الدردشة الفردية') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{route('dashboard.admin.group.all')}}">
                                {{ __('الدردشة الجماعية') }}
                            </x-jet-dropdown-link>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
                @endif
                <div class="qup-dropdown hidden ml-2 sm:-my-px sm:flex">
                    <x-jet-dropdown class="" align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>كروت تهنئة</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-jet-dropdown-link href="{{route('admin.cards.index')}}">
                                {{ __('العملاء') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link href="{{route('admin.cards.backgrounds')}}">
                                {{ __('الخلفيات') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{route('admin.cards.sounds')}}">
                                {{ __('الاصوات') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{route('admin.cards.videos')}}">
                                {{ __('الفيديوهات') }}
                            </x-jet-dropdown-link>

                        </x-slot>
                    </x-jet-dropdown>
                </div>

                <div class="qup-dropdown hidden ml-2 sm:-my-px sm:flex">
                    <x-jet-dropdown class="" align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>المزيد</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-jet-dropdown-link href="{{route('dashboard.file-manager')}}">
                                {{ __('معرض الملفات') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{route('admin.altaawus-vip-requests')}}">
                                {{ __('طلبات الطاووس') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('admin.ads') }}" :active="request()->routeIs('admin.ads')">
                                {{ __('الإعلانات') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('admin.testimonials') }}" :active="request()->routeIs('admin.testimonials')">
                                {{ __('الآراء و القصص') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('dashboard.points-commissions') }}" :active="request()->routeIs('dashboard.points-commissions')">
                                {{ __('إعدادات النقاط') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('dashboard.points-commissions-requests') }}" :active="request()->routeIs('dashboard.points-commissions-requests')">
                                {{ __('طلبات عمولات النقاط') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('dashboard.categories') }}" :active="request()->routeIs('dashboard.categories')">
                                {{ __('تصنيفات المنتجات') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('admin.packages') }}" :active="request()->routeIs('admin.packages')">
                                {{ __(' الباقات') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link href="{{ route('dashboard.payment-method') }}" :active="request()->routeIs('dashboard.payment-method')">
                                {{ __(' وسائل الدفع') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('dashboard.notifications') }}" :active="request()->routeIs('dashboard.notifications')">
                                {{ __('الاشعارات') }}
                            </x-jet-dropdown-link>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('إعدادات الحساب') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('الحساب') }}
                            </x-jet-dropdown-link>

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('تسجيل الخروج') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">


            <x-jet-responsive-nav-link href="{{ route('dashboard.users') }}" :active="request()->routeIs('dashboard.users')">
                {{ __('المشرفين') }}
            </x-jet-responsive-nav-link>
            <hr>
            <x-jet-responsive-nav-link href="{{ route('dashboard.general-info') }}" :active="request()->routeIs('dashboard.general-info')">
                {{ __('الاعدادات العامة') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{route('admin.homepage-settings')}}" :active="request()->routeIs('dashboard.homepage-settings')">
                {{ __('اعدادات الصفحة الرئيسية') }}
            </x-jet-responsive-nav-link>
            <hr>
            <x-jet-responsive-nav-link href="{{ route('dashboard.clients') }}" :active="request()->routeIs('dashboard.clients')">
                {{ __('الأعضاء') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{route('dashboard.band-clients')}}">
                {{ __('الأعضاء المحظورين') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('dashboard.verify-clients') }}" :active="request()->routeIs('dashboard.verify-clients')">
                {{ __('العملاء الغير مفعلين') }}
            </x-jet-responsive-nav-link>
            <hr>
            <x-jet-responsive-nav-link href="{{ route('dashboard.shipping') }}" :active="request()->routeIs('dashboard.shipping')">
                {{ __('إعدادات الشحن') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('dashboard.countries') }}" :active="request()->routeIs('dashboard.countries')">
                {{ __('الدول') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('dashboard.governments') }}" :active="request()->routeIs('dashboard.governments')">
                {{ __('المدن') }}
            </x-jet-responsive-nav-link>
            <hr>
            <x-jet-responsive-nav-link href="{{route('dashboard.payment-page-collection')}}" :active="request()->routeIs('dashboard.payment-page-collection')">
                {{ __('الفواتير الجماعية - طلبات الدفع') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{route('admin.collection.profit.index')}}" :active="request()->routeIs('admin.collection.profit.index')">
                {{ __('الفواتير الجماعية - تقرير الارباح') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('admin.product-requests-collections') }}" :active="request()->routeIs('admin.product-requests-collections')">
                {{ __('الفواتير الجماعية - طلبات شراء المنتجات') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{route('admin.bills.collection')}}" :active="request()->routeIs('admin.bills.collection')">
                {{ __('الفواتير الجماعية - الفواتير المفصله') }}
            </x-jet-responsive-nav-link>

            <hr>
            <x-jet-responsive-nav-link href="{{ route('dashboard.payment.settings') }}" :active="request()->routeIs('dashboard.payment.settings')">
                {{ __('إعدادات الادارة المالية') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{route('dashboard.payment-page')}}" :active="request()->routeIs('dashboard.payment-page')">
                {{ __('طلبات الدفع') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{route('dashboard.payment-debt')}}" :active="request()->routeIs('dashboard.payment-debt')">
                {{ __('العملاء المديونين') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{route('admin.profit.login')}}" :active="request()->routeIs('admin.profit.login')">
                {{ __('تقرير الارباح') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('admin.package-buyers') }}" :active="request()->routeIs('admin.package-buyers')">
                {{ __(' طلبات شراء الباقات') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('admin.product-requests') }}" :active="request()->routeIs('admin.product-requests')">
                {{ __(' طلبات شراء المنتجات') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('admin.bills') }}" :active="request()->routeIs('admin.bills')">
                {{ __(' الفواتير المفصله') }}
            </x-jet-responsive-nav-link>
            <hr>
            <x-jet-responsive-nav-link href="{{route('dashboard.ticket-gifts')}}" :active="request()->routeIs('dashboard.ticket-gifts')">
                {{ __('تذاكر الشراء') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{route('dashboard.reesh')}}" :active="request()->routeIs('dashboard.reesh')">
                {{ __('ريش المرح') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{route('dashboard.giftsbox')}}" :active="request()->routeIs('dashboard.giftsbox')">
                {{ __('صناديق الحظ') }}
            </x-jet-responsive-nav-link>
            <hr>
            <x-jet-responsive-nav-link href="{{route('admin.cards.index')}}">
                {{ __('العملاء - كروت تهنئة') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{route('admin.cards.backgrounds')}}">
                {{ __('الخلفيات - كروت تهنئة') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{route('admin.cards.sounds')}}">
                {{ __('الاصوات - كروت تهنئة') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{route('admin.cards.videos')}}">
                {{ __('الفيديوهات - كروت تهنئة') }}
            </x-jet-responsive-nav-link>
            @if (Auth::user()->chat_on == 1)
                <hr>
                <x-jet-responsive-nav-link href="{{route('dashboard.admin.chat.single.all')}}">
                    {{ __('الدردشة الفردية') }}
                </x-jet-responsive-nav-link>
                <x-jet-responsive-nav-link href="{{route('dashboard.admin.group.all')}}">
                    {{ __('الدردشة الجماعية') }}
                </x-jet-responsive-nav-link>
            @endif
            <hr>
            <x-jet-responsive-nav-link href="{{ route('dashboard.categories') }}" :active="request()->routeIs('dashboard.categories')">
                {{ __('تصنيفات المنتجات') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('admin.packages') }}" :active="request()->routeIs('admin.packages')">
                {{ __(' الباقات') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('dashboard.payment-method') }}" :active="request()->routeIs('dashboard.payment-method')">
                {{ __(' وسائل الدفع') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('dashboard.notifications') }}" :active="request()->routeIs('dashboard.notifications')">
                {{ __('الاشعارات') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{route('admin.altaawus-vip-requests')}}"  :active="request()->routeIs('admin.altaawus-vip-requests')">
                {{ __('طلبات الطاووس') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{route('admin.altaawus-vip')}}"  :active="request()->routeIs('admin.altaawus-vip')">
                {{ __('الطاووس VIP') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('admin.ads') }}" :active="request()->routeIs('admin.ads')">
                {{ __('الإعلانات') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('admin.testimonials') }}" :active="request()->routeIs('admin.testimonials')">
                {{ __('الآراء و القصص') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('dashboard.points-commissions') }}" :active="request()->routeIs('dashboard.points-commissions')">
                {{ __('إعدادات النقاط') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('dashboard.points-commissions-requests') }}" :active="request()->routeIs('dashboard.points-commissions-requests')">
                {{ __('طلبات عمولات النقاط') }}
            </x-jet-responsive-nav-link>

            <x-jet-responsive-nav-link href="{{route('dashboard.file-manager')}}" :active="request()->routeIs('dashboard.file-manager')">
                {{ __('معرض الملفات') }}
            </x-jet-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="flex-shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('الحساب') }}
                </x-jet-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('تسجيل خروج') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->

            </div>
        </div>
    </div>
</nav>
