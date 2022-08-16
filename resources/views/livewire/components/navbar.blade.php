<div>
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-md">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-28">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a  aria-label="Home Page"  href="{{ route('frontend.home') }}">
                            <img src="{{asset('images/logo.png')}}" class="block h-24 w-auto ml-2.5" alt="Altaawus Logo" />
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden sm:-my-px sm:ml-10 sm:flex">
                        <x-jet-nav-link class="mr-2" href="{{ route('frontend.gifts') }}" :active="request()->routeIs('frontend.gifts')">
                            <i class="fas fa-box-open"></i> {{ __('صناديق الحظ') }}
                        </x-jet-nav-link>
                        <x-jet-nav-link class="mr-2" href="{{ route('frontend.reesh') }}" :active="request()->routeIs('frontend.reesh')">
                            <i class="fas fa-feather"></i> {{ __('ريشة المرح') }}
                        </x-jet-nav-link>

                        <div class="qup-dropdown hidden mr-2 sm:-my-px sm:flex">
                            <x-jet-dropdown class="" align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                        <div><i class="fas fa-file-invoice-dollar ml-1 inline-block"></i> {{ __('الخزنة') }}</div>
                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-jet-dropdown-link href="{{ route('frontend.cart') }}" :active="request()->routeIs('frontend.cart')">
                                        {{ __('الخزنة') }}
                                    </x-jet-dropdown-link>

                                    <x-jet-dropdown-link href="{{route('frontend.cart-collection')}}">
                                        {{ __('خزنة السلع المجمعة') }}
                                    </x-jet-dropdown-link>
                                </x-slot>
                            </x-jet-dropdown>
                        </div>
                        <x-jet-nav-link class="mr-2" href="{{ route('frontend.altaawus-vip') }}" :active="request()->routeIs('frontend.altaawus-vip')">
                            <i class="fas fa-gem"></i> {{ __('الطاووس vip') }}
                        </x-jet-nav-link>
                        @if(\Illuminate\Support\Facades\Auth::guard('clients')->check())
                        <x-jet-nav-link class="mr-2" href="{{ route('frontend.ticket') }}" :active="request()->routeIs('frontend.ticket')">
                            <i class="fas fa-ticket-alt ml-2"></i>  {{ __(' قسائم الشراء ') }}
                        </x-jet-nav-link>
                        <x-jet-nav-link class="mr-2" href="{{ route('frontend.cards.index') }}" :active="request()->routeIs('frontend.cards.index')">
                            <i class="fas fa-book-open"></i>  {{ __(' كروت تهنئة ') }}
                        </x-jet-nav-link>

                        @endif
                    </div>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <!-- Settings Dropdown -->
                    <div class="{{-- ml-3 --}} relative">

                        @if (Auth::guard('clients')->check())
                            @if ($havemessage > 0 || count($unreaded) > 0 || count($unreaded_buyer) > 0)
                                <div class="bellholder">
                                    <i class="fas fa-bell"></i>
                                </div>
                            @endif
                            <x-jet-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button  aria-label="Messages" type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        <i style="margin-left: 3px;" class="fas fa-envelope"></i> {{ __('الرسائل') }}
                                    </button>
                                </span>
                                </x-slot>

                                <x-slot name="content">
                                    <x-jet-dropdown-link href="{{ route('frontend.single-chat') }}" class="relative">
                                        @if ($havemessage > 0)
                                            <div class="bellholder in-drop">
                                                <i class="fas fa-bell"></i>
                                            </div>
                                        @endif
                                        {{ __('الدردشة مع الادارة') }}
                                    </x-jet-dropdown-link>
                                    @if($unreaded_buyer != null)
                                        @if(count($unreaded_buyer) > 0)
                                            @foreach($unreaded_buyer as $room)
                                                <x-jet-dropdown-link href="{{ route('frontend.group-chat', ['id' => $room->id]) }}" class="relative">
                                                    <div class="bellholder in-drop">
                                                        <i class="fas fa-bell"></i>
                                                    </div>
                                                    {{ __(' الدردشة منتج ' . ($room->request != null ? $room->request->product->name : $room->collection_request->product->name) ) }}
                                                </x-jet-dropdown-link>
                                            @endforeach
                                        @endif
                                    @endif

                                    @if($unreaded != null)
                                        @if(count($unreaded) > 0)
                                            @foreach($unreaded as $room)
                                                <x-jet-dropdown-link href="{{ route('frontend.group-chat', ['id' => $room->id]) }}" class="relative">
                                                    {{ __(' الدردشة منتج ' . ($room->request != null ? $room->request->product->name : $room->collection_request->product->name) ) }}
                                                </x-jet-dropdown-link>
                                            @endforeach
                                        @endif
                                    @endif

                                </x-slot>
                            </x-jet-dropdown>
                        @endif
                    </div>
                    <div class="{{-- ml-3 --}} relative">
                        @if (Auth::guard('clients')->check())
                            @if (\App\Models\Notification::where('client_id', '=',Auth::guard('clients')->user()->id)->where('type', '=', 0)->count() > 0)
                                <div class="bellholder">
                                    <i class="fas fa-bell"></i>
                                </div>
                            @endif
                            <x-jet-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button  aria-label="Dropdown Button align" type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        {{ Auth::guard('clients')->user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                                </x-slot>

                                <x-slot name="content">
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('إدارة الحساب') }}
                                    </div>

                                    <x-jet-dropdown-link href="{{ route('frontend.favourites') }}">
                                        <i class="fas fa-heart"></i> {{ __('المفضلة') }}
                                    </x-jet-dropdown-link>

                                    <x-jet-dropdown-link href="{{ route('frontend.profile') }}">
                                        <i class="fas fa-user"></i> {{ __('الحساب') }}
                                    </x-jet-dropdown-link>
                                    <x-jet-dropdown-link class="relative" href="{{ route('frontend.notifications') }}">
                                        @if (\App\Models\Notification::where('client_id', '=',Auth::guard('clients')->user()->id)->where('type', '=', 0)->count() > 0)
                                            <div class="bellholder" style="top: 10px; right: 160px; position: absolute;">
                                                <i class="fas fa-bell"></i>
                                            </div>
                                        @endif
                                        <i class="fas fa-bell"></i> {{ __('الاشعارات') }}
                                    </x-jet-dropdown-link>

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ URL::to('logout') }}">
                                        @csrf

                                        <x-jet-dropdown-link href="{{ URL::to('logout') }}"
                                                             onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                            {{ __('خروج') }}
                                        </x-jet-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-jet-dropdown>
                        @else
                            <x-jet-nav-link class="no-hover-link" href="{{ route('frontend.login') }}" :active="request()->routeIs('frontend.login')" style="font-size: 15px;">
                                <i class="fas fa-sign-in-alt"></i> {{ __('دخول') }}
                            </x-jet-nav-link>
                            <x-jet-nav-link class="no-hover-link" href="{{ route('frontend.register') }}" :active="request()->routeIs('frontend.register')" style="font-size: 15px;">
                                <i class="fas fa-user-plus"></i> {{ __('تسجيل') }}
                            </x-jet-nav-link>
                        @endif
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button  aria-label="Responsive Navbar Button" @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
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
                <x-jet-responsive-nav-link class="mr-2" href="{{ route('frontend.gifts') }}" :active="request()->routeIs('frontend.gifts')">
                    <i class="fas fa-box-open"></i> {{ __('صناديق الحظ') }}
                </x-jet-responsive-nav-link>
                <x-jet-responsive-nav-link class="mr-2" href="{{ route('frontend.reesh') }}" :active="request()->routeIs('frontend.reesh')">
                    <i class="fas fa-feather"></i> {{ __('ريشة المرح') }}
                </x-jet-responsive-nav-link>
                <x-jet-responsive-nav-link class="mr-2" href="{{ route('frontend.cart') }}" :active="request()->routeIs('frontend.cart')">
                    <i class="fas fa-file-invoice-dollar ml-1 inline-block"></i> {{ __('الخزنة') }}
                </x-jet-responsive-nav-link>
                <x-jet-responsive-nav-link class="mr-2" href="{{ route('frontend.altaawus-vip') }}" :active="request()->routeIs('frontend.altaawus-vip')">
                    <i class="fas fa-gem"></i> {{ __('الطاووس vip') }}
                </x-jet-responsive-nav-link>
                @if(\Illuminate\Support\Facades\Auth::guard('clients')->check())
                <x-jet-responsive-nav-link href="{{ route('frontend.favourites') }}">
                    <i class="fas fa-heart"></i> {{ __('المفضلة') }}
                </x-jet-responsive-nav-link>
                <x-jet-responsive-nav-link href="{{ route('frontend.notifications') }}">
                    <i class="fas fa-bell"></i> {{ __('الاشعارات') }}
                </x-jet-responsive-nav-link>
                <x-jet-responsive-nav-link class="mr-2" href="{{ route('frontend.ticket') }}" :active="request()->routeIs('frontend.ticket')">
                    <i class="fas fa-ticket-alt"></i>  {{ __('قسائم الشراء') }}
                </x-jet-responsive-nav-link>
                <x-jet-responsive-nav-link class="mr-2" href="{{ route('frontend.cards.index') }}" :active="request()->routeIs('frontend.cards.index')">
                    <i class="fas fa-book-open"></i>  {{ __(' كروت تهنئة ') }}
                </x-jet-responsive-nav-link>
                @endif
                @if (!Auth::guard('clients')->check())
                <x-jet-responsive-nav-link class="no-hover-link" href="{{ route('frontend.login') }}" :active="request()->routeIs('frontend.login')" style="font-size: 15px;">
                    <i class="fas fa-sign-in-alt"></i> {{ __('دخول') }}
                </x-jet-responsive-nav-link>
                <x-jet-responsive-nav-link class="no-hover-link" href="{{ route('frontend.register') }}" :active="request()->routeIs('frontend.register')" style="font-size: 15px;">
                    <i class="fas fa-user-plus"></i> {{ __('تسجيل') }}
                </x-jet-responsive-nav-link>
                @endif
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="flex items-center px-4">
                    @if (Auth::guard('clients')->check())
                        <div>
                            <div class="font-medium text-base text-gray-800">{{ Auth::guard('clients')->user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::guard('clients')->user()->email }}</div>
                        </div>

                    @endif
                </div>
                <div class="mt-3 space-y-1">
                    @if (Auth::guard('clients')->check())
                    <x-jet-responsive-nav-link href="{{ route('frontend.single-chat') }}" :active="request()->routeIs('frontend.single-chat')">
                        {{ __('الدردشة مع الادارة') }}
                    </x-jet-responsive-nav-link>
                        @if($unreaded_buyer != null)
                            @if(count($unreaded_buyer) > 0)
                                @foreach($unreaded_buyer as $room)
                                    <x-jet-responsive-nav-link href="{{ route('frontend.group-chat', ['id' => $room->id]) }}" class="relative">
                                        <div class="bellholder in-drop">
                                            <i class="fas fa-bell"></i>
                                        </div>
                                        {{ __(' الدردشة منتج ' . ($room->request != null ? $room->request->product->name : $room->collection_request->product->name) ) }}
                                    </x-jet-responsive-nav-link>
                                @endforeach
                            @endif
                        @endif
                    <x-jet-responsive-nav-link href="{{ route('frontend.profile') }}" :active="request()->routeIs('frontend.profile')">
                        {{ __('الحساب') }}
                    </x-jet-responsive-nav-link>
                    <!-- Authentication -->
                    <form method="POST" action="{{ URL::to('logout') }}">
                        @csrf

                        <x-jet-responsive-nav-link href="{{ URL::to('logout') }}"
                                                   onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('خروج') }}
                        </x-jet-responsive-nav-link>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</div>
