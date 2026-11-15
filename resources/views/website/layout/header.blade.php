<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ __('website.meta.title') }}</title>
    <meta name="description" content="{{ __('website.meta.description') }}" />
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}" />
    <script>
        (() => {
            const storageKey = "raven-house-loader-shown";
            const root = document.documentElement;
            const navigationEntry = performance.getEntriesByType?.("navigation")?.[0];
            const isReload = navigationEntry?.type === "reload";
            let hasSeenSite;
            let canUseSessionStorage = true;

            try {
                const storage = window.sessionStorage;
                hasSeenSite = storage.getItem(storageKey) !== null;

                if (!hasSeenSite) {
                    storage.setItem(storageKey, "1");
                }
            } catch (error) {
                if (
                    error instanceof DOMException &&
                    ["SecurityError", "QuotaExceededError"].includes(error.name)
                ) {
                    canUseSessionStorage = false;
                } else {
                    throw error;
                }
            }

            const isFirstEntry = canUseSessionStorage && !hasSeenSite;
            if (!isFirstEntry && !isReload) {
                return;
            }

            root.dataset.siteLoaderStartedAt = String(performance.now());
            root.classList.add("site-loader-active");

            window.setTimeout(() => {
                root.classList.remove("site-loader-active", "site-loader-exiting");
                delete root.dataset.siteLoaderStartedAt;
            }, 8000);
        })();
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@700&display=swap"
        rel="stylesheet" />
    {{-- <link rel="stylesheet" href="css/style.css" /> --}}
    {{-- <link rel="stylesheet" href="{{  }}/style.css" /> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-raven page-home"
    data-cart-index="{{ route('cart.index') }}"
    data-cart-store="{{ route('cart.store') }}"
    data-checkout-delivery="{{ route('checkout.delivery') }}"
    data-authenticated="{{ auth()->check() ? 'true' : 'false' }}">

    <div id="site-loader" class="site-loader" role="status" aria-label="{{ __('website.general.loading') }}">
        <div class="site-loader__content">
            <img src="{{ asset('images/logo.png') }}" alt="" width="96" height="96" class="site-loader__logo"
                aria-hidden="true" />
            <span class="site-loader__track" aria-hidden="true">
                <span class="site-loader__progress"></span>
            </span>
        </div>
    </div>

    <nav id="site-header" class="navbar navbar-expand-xxl navbar-dark fixed-top navbar-raven bg-raven py-3">
        <div class="container">
            <a class="navbar-brand site-brand-lockup me-0" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="" class="site-logo site-logo--emblem" width="96"
                    height="96" aria-hidden="true" />
            </a>
            <div class="navbar-actions order-xxl-3">
                @guest
                    <a class="navbar-header-action d-xxl-none" href="{{ route('login') }}"
                        aria-label="{{ __('website.navigation.login') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="8" r="3.25" />
                            <path d="M5 20c.7-3.1 3.2-5 7-5s6.3 1.9 7 5" />
                        </svg>
                    </a>
                @elseif(in_array(auth()->user()->role, ['admin', 'manager']))
                    <a class="navbar-header-action d-xxl-none" href="{{ route('admin.dashboard') }}"
                        aria-label="{{ __('website.navigation.dashboard') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="8" r="3.25" />
                            <path d="M5 20c.7-3.1 3.2-5 7-5s6.3 1.9 7 5" />
                        </svg>
                    </a>
                @endguest
                <form class="navbar-mobile-language-form d-xxl-none"
                    action="{{ route('language.update', app()->isLocale('en') ? 'ar' : 'en') }}" method="POST">
                    @csrf
                    <button type="submit" class="navbar-header-action"
                        aria-label="{{ __('website.switch_language') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M3 12h18M12 3c2.4 2.5 3.5 5.5 3.5 9S14.4 18.5 12 21m0-18c-2.4 2.5-3.5 5.5-3.5 9S9.6 18.5 12 21" />
                        </svg>
                    </button>
                </form>
                <button type="button" class="btn cart-toggle" data-bs-toggle="offcanvas"
                    data-bs-target="#cartDrawer" aria-controls="cartDrawer" aria-label="Open shopping cart">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
                        stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 3h2l2.2 11.2a2 2 0 0 0 2 1.6h8.9a2 2 0 0 0 2-1.6L22 7H6" />
                        <circle cx="10" cy="20" r="1" />
                        <circle cx="18" cy="20" r="1" />
                    </svg>
                    <span class="cart-badge badge rounded-pill" id="cart-count-badge" hidden>0</span>
                </button>
                <button class="navbar-toggler navbar-toggler-raven d-xxl-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <ul class="navbar-nav navbar-desktop-actions d-none d-xxl-flex align-items-center gap-lg-2">
                    @include('website.layout.auth-nav')
                    <li class="nav-item">
                        <form action="{{ route('language.update', app()->isLocale('en') ? 'ar' : 'en') }}" method="POST">
                            @csrf
                            <button type="submit" class="language-switch__button language-switch__button--desktop">
                                {{ __('website.switch_language') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            <div class="collapse navbar-collapse order-xxl-2" id="navbarMain">
                <ul class="navbar-nav site-nav-links gap-lg-2" aria-label="Main navigation">
                    <li class="nav-item">
                        <a class="nav-link site-nav-link @if(request()->is('/')) active @endif" href="/">{{ __('website.navigation.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link site-nav-link @if(request()->routeIs('about.page')) active @endif" href="{{ route("about.page") }}">{{ __('website.navigation.about') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link site-nav-link @if(request()->routeIs('perfumes.*')) active @endif"
                            href="{{ route('perfumes.page') }}">{{ __('website.navigation.perfumes') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link site-nav-link @if(request()->routeIs('sunglasses.page')) active @endif" href="{{ route("sunglasses.page") }}">{{ __('website.navigation.sunglasses') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link site-nav-link @if(request()->routeIs('coming-soon.page')) active @endif" href="{{ route('coming-soon.page') }}">{{ __('website.navigation.coming_soon') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link site-nav-link @if(request()->routeIs('contact.page')) active @endif" href="{{ route("contact.page") }}">{{ __('website.navigation.contact') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-end offcanvas-raven text-bg-dark" tabindex="-1" id="mobileMenu"
        aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header border-bottom border-raven">
            <a href="{{ route('home') }}" class="site-brand-lockup site-brand-lockup--compact mb-0" id="mobileMenuLabel">
                <img src="{{ asset('images/logo.png') }}" alt="" class="site-logo site-logo--emblem" width="48"
                    height="48" aria-hidden="true" />
            </a>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mobile-menu-body">
            <ul class="mobile-menu-nav" aria-label="Mobile navigation">
                <li class="nav-item">
                    <a class="nav-link @if(request()->is('/')) active @endif" href="/">{{ __('website.navigation.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('about.page')) active @endif" href="{{ route("about.page") }}">{{ __('website.navigation.about') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('perfumes.*')) active @endif"
                        href="{{ route('perfumes.page') }}">{{ __('website.navigation.perfumes') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('sunglasses.page')) active @endif" href="{{ route("sunglasses.page") }}">{{ __('website.navigation.sunglasses') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('coming-soon.page')) active @endif" href="{{ route('coming-soon.page') }}">{{ __('website.navigation.coming_soon') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('contact.page')) active @endif" href="{{ route("contact.page") }}">{{ __('website.navigation.contact') }}</a>
                </li>
                @include('website.layout.auth-nav-mobile')
            </ul>
            <form class="mobile-language-switch" action="{{ route('language.update', app()->isLocale('en') ? 'ar' : 'en') }}" method="POST">
                @csrf
                <button type="submit" class="language-switch__button language-switch__button--mobile">
                    {{ __('website.switch_language') }}
                </button>
            </form>
        </div>
    </div>
