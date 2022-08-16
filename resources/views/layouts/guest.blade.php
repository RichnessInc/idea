<!DOCTYPE html>
<html lang="ar">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="google-site-verification" content="BsS5dyp19Q6vG7BoQAALRmeGLsYRMlK7zG4Pdvhh9eU" />
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{asset('images/icon.png')}}" type="image/x-icon" >
        <meta name="description" content="يمكنك شراء الهدايا المميزة من خلال منصة الطاووس بأبسط و اسرع الطرق و بسرع وسيلة شحن حسب اختيارك كما اننا وفرنا لك الكثير من وسائل الدفع  كما وفرنا لك طريقة سريعة للوصول الى التاجر و توضيح ما تحتاجه بالظبط | حتى و ان كنت خارج المملكة العربية السعودية وفرنا لك ميزة الشحن الدولي | اما اذا كنت تاجر فيمكنك بيع منتجات متجرك بكل سهولة للوصول الى عدد اكبر من الجمهور و تحقيق المزيد من الارباح">
        <meta name="keywords" content="altaawus،الطاووس">
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

        <meta name="author" content="Altaawus">
        <meta name="tags" content="altaawus">
        <meta property="og:title" content="منصة الطاووس">
        <meta property="og:site_name" content="الطاووس">
        <meta property="og:url" content="http://altaawws.com/">
        <meta property="og:description" content="يمكنك شراء الهدايا المميزة من خلال منصة الطاووس بأبسط و اسرع الطرق و بسرع وسيلة شحن حسب اختيارك كما اننا وفرنا لك الكثير من وسائل الدفع كما وفرنا لك طريقة سر">
        <meta property="og:type" content="website">
        <script type="application/ld+json">
        {
        "@context": "https://schema.org/",
        "@type": "HowTo",
        "name": "منصة الطاووس",
        "description": "يمكنك شراء الهدايا المميزة من خلال منصة الطاووس بأبسط و اسرع الطرق و بسرع وسيلة شحن حسب اختيارك كما اننا وفرنا لك الكثير من وسائل الدفع كما وفرنا لك طريقة سر",
        "step": {
        "@type": "HowToStep",
        "text": ""
        }
        }
        </script>
        <script type=”application/ld+json”>

        {“@context” : “http://schema.org”,

        “@type” : “Organization”,

        “name” : “altaawus”,

        “url” : “https://altaawws.com/”,

        “sameAs” : [ “https://www.facebook.com/”,
        “https://www.facebook.com/”,

        “https://www.facebook.com/”]

        }

        </script>
        <!-- Fonts -->
        {{--
                 <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        --}}
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/index.css') }}">
        @stack('styles')
        @livewireStyles


    </head>
    <body class="" dir="rtl">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            <div class="print">
            @livewire('components.navbar')
            </div>
            <!-- Page Heading -->
            @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>
        @php
        $data = \App\Models\GeneralInfo::first();
        @endphp
        <div class="print">
            <footer>
                <div class="footer-container">
                    <div class="box">
                        <h3><img src="{{asset('images/logo.png')}}" loading="lazy" alt="Logo"></h3>
                        <ul class="social">
                            <li class="facebook">
                                <a  aria-label="Facebook Link" href="{{$data->facebook}}" target="_blank">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                            <li class="twitter">
                                <a aria-label="Twitter Link"  href="{{$data->twitter}}" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li class="instagram">
                                <a aria-label="instgram Link"  href="{{$data->instgram}}" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                            <li class="snapchat">
                                <a  aria-label="snapchat Link" href="{{$data->snapchat}}" target="_blank">
                                    <i class="fab fa-snapchat-ghost"></i>
                                </a>
                            </li>
                            <li class="telgram">
                                <a  aria-label="telgram Link" href="{{$data->telgram}}" target="_blank">
                                    <i class="fab fa-telegram-plane"></i>
                                </a>
                            </li>
                            <li class="whatsapp">
                                <a  aria-label="whatsapp Link"  href="{{$data->whatsapp}}" target="_blank">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="box">
                        <ul class="links">
                            <li><a  aria-label="Gifts Link" href="{{route('frontend.gifts')}}"><i class="fas fa-angle-double-right"></i>  {{ __('صناديق الحظ') }}</a></li>
                            <li><a  aria-label="Reesh Link" href="{{route('frontend.reesh')}}"><i class="fas fa-angle-double-right"></i> {{ __('ريشة المرح') }}</a></li>
                            <li><a  aria-label="Cart Link" href="{{route('frontend.cart')}}"><i class="fas fa-angle-double-right"></i> {{ __('الخزنة') }}</a></li>
                            <li><a  aria-label="altaawus-vip Link" href="{{route('frontend.altaawus-vip')}}"><i class="fas fa-angle-double-right"></i> {{ __('الطاووس vip') }}</a></li>
                        </ul>
                    </div>
                    <div class="box">
                        <ul class="links">
                            @php
                                $pages = \App\Models\mainPage::get();
                            @endphp
                            @foreach ($pages as $page)
                                <li><a  aria-label="{{$page->slug.' Page '}}" href="{{route('frontend.pages', [
                                    'slug' => $page->slug
                                ])}}"><i class="fas fa-angle-double-right"></i>  {{$page->name}}</a></li>

                            @endforeach
                        </ul>
                    </div>
                    <div class="box">
                        <div class="line">
                            <i class="fas fa-fax"></i>
                            <div class="info">{{$data->tel_fax}}</div>
                        </div>
                        <div class="line">
                            <i class="fas fa-phone"></i>
                            <div class="info"> {{$data->hot_line}}</div>
                        </div>
                        <div class="line">
                            <i class="fas fa-envelope"></i>
                            <div class="info">{{$data->email}}</div>
                        </div>
                        <div class="line">
                            <i class="fas fa-map-marked-alt fa-fw"></i>
                            <div class="info">{{$data->address}}</div>
                        </div>
                    </div>
                </div>
                <div class="copyright">
                    <a aria-label="{{' Page '}}" href="https://unasipt.com/" target="_blank"><p>إشراف وتنفيذ جامعة اليوناسيبت لندن <img loading="lazy"  src="{{asset('images/unasipt.png')}}" alt="unasipt logo"></p></a>
                    <p>جميع الحقوق محفوظة لموقع الطاووس 2019 -  {{date('Y')}} &copy;  </p>
                    <p>تصميم وتطوير شركة ثراء <img loading="lazy" src="{{asset('images/brand.png')}}" alt="Richness Logo"></p>
                </div>
            </footer>
        </div>
        <!-- Scripts -->
        <script src="{{ asset('js/funs.js') }}" defer></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        @stack('modals')
        @livewireScripts
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

        <x-livewire-alert::scripts />

        @stack('scripts')
        <button class="scrollToTop hidden"><img src="{{asset('images/scroll.png')}}"></button>
        <div class="networkStatus online" style="position: fixed;top: 0;left: 0;height: 100vh;z-index: 99999999;background-color: #FFF;width: 100%;">
            <img src="{{asset('images/103.webp')}}" style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);width: 650px;" />
            <span style="  text-align: center;  display: block;  margin-top: 50px;  font-size: 35px;">تأكد من إتصالك بالانترنت</span>
        </div>
    </body>
</html>
