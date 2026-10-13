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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap"
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

    <nav id="site-header" class="navbar navbar-expand-xxl navbar-dark fixed-top navbar-raven bg-raven py-3">
        <div class="container">
            <a class="navbar-brand site-brand-lockup me-0" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="" class="site-logo site-logo--emblem" width="96"
                    height="96" aria-hidden="true" />
            </a>
            <button type="button" class="btn cart-toggle order-xxl-3" data-bs-toggle="offcanvas"
                data-bs-target="#cartDrawer" aria-controls="cartDrawer" aria-label="Open shopping cart">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor"
                    stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M3 3h2l2.2 11.2a2 2 0 0 0 2 1.6h8.9a2 2 0 0 0 2-1.6L22 7H6" />
                    <circle cx="10" cy="20" r="1" />
                    <circle cx="18" cy="20" r="1" />
                </svg>
                <span class="cart-badge badge rounded-pill" id="cart-count-badge" hidden>0</span>
            </button>
            <button class="navbar-toggler navbar-toggler-raven" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end order-xxl-2" id="navbarMain">
                <ul class="navbar-nav gap-lg-3" aria-label="Main navigation">
                    <li class="nav-item">
                        <a class="nav-link site-nav-link @if(request()->is('/')) active @endif" href="/">{{ __('website.navigation.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link site-nav-link @if(request()->routeIs('about.page')) active @endif" href="{{ route("about.page") }}">{{ __('website.navigation.about') }}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="nav-link site-nav-link dropdown-toggle @if(request()->routeIs('perfumes.*')) active @endif"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('website.navigation.perfumes') }}</button>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-raven">
                            <li><a class="dropdown-item" href="{{ route('perfumes.page') }}">{{ __('website.navigation.all_perfumes') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('perfumes.page', ['gender' => 'men']) }}">{{ __('website.navigation.men') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('perfumes.page', ['gender' => 'women']) }}">{{ __('website.navigation.women') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('perfumes.page', ['gender' => 'men & women']) }}">{{ __('website.navigation.men_and_women') }}</a></li>
                        </ul>
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
        <div class="offcanvas-body d-flex align-items-center justify-content-center">
            <ul class="nav flex-column text-center gap-3 w-100" aria-label="Mobile navigation">
                <li class="nav-item">
                    <a class="nav-link @if(request()->is('/')) active @endif" href="/">{{ __('website.navigation.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('about.page')) active @endif" href="{{ route("about.page") }}">{{ __('website.navigation.about') }}</a>
                </li>
                <li class="nav-item mobile-perfume-nav">
                    <button class="nav-link mobile-perfume-nav__toggle @if(request()->routeIs('perfumes.*')) active @endif"
                        type="button" data-bs-toggle="collapse" data-bs-target="#mobilePerfumeOptions"
                        aria-expanded="false" aria-controls="mobilePerfumeOptions">
                        {{ __('website.navigation.perfumes') }}
                        <span class="mobile-perfume-nav__chevron" aria-hidden="true"></span>
                    </button>
                    <div class="collapse" id="mobilePerfumeOptions">
                        <ul class="mobile-perfume-nav__options">
                            <li><a href="{{ route('perfumes.page') }}">{{ __('website.navigation.all_perfumes') }}</a></li>
                            <li><a href="{{ route('perfumes.page', ['gender' => 'men']) }}">{{ __('website.navigation.men') }}</a></li>
                            <li><a href="{{ route('perfumes.page', ['gender' => 'women']) }}">{{ __('website.navigation.women') }}</a></li>
                            <li><a href="{{ route('perfumes.page', ['gender' => 'men & women']) }}">{{ __('website.navigation.men_and_women') }}</a></li>
                        </ul>
                    </div>
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
                <li class="nav-item mt-3">
                    <form action="{{ route('language.update', app()->isLocale('en') ? 'ar' : 'en') }}" method="POST">
                        @csrf
                        <button type="submit" class="language-switch__button language-switch__button--mobile">
                            {{ __('website.switch_language') }}
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
