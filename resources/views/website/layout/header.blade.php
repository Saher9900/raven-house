<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Raven House — Luxury Sunglasses & Perfumes</title>
    <meta name="description" content="Raven House — curated luxury sunglasses and signature fragrances." />
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
    @auth
        data-cart-index="{{ route('cart.index') }}"
        data-cart-store="{{ route('cart.store') }}"
        data-checkout-store="{{ route('checkout.store') }}"
    @else
        data-login-url="{{ route('login') }}"
    @endauth>

    <nav id="site-header" class="navbar navbar-expand-lg navbar-dark fixed-top navbar-raven bg-raven py-3">
        <div class="container">
            <a class="navbar-brand site-brand-lockup me-0" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="" class="site-logo site-logo--emblem" width="96"
                    height="96" aria-hidden="true" />
                <span class="site-brand-divider" aria-hidden="true"></span>
                <img src="{{ asset('images/logo-details.png') }}" alt="Raven House — Perfume &amp; Sunglasses"
                    class="site-logo site-logo--details" width="196" height="88" />
            </a>
            <button class="navbar-toggler navbar-toggler-raven" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarMain">
                <ul class="navbar-nav gap-lg-3" aria-label="Main navigation">
                    <li class="nav-item">
                        <a class="nav-link site-nav-link @if(request()->is('/')) active @endif" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link site-nav-link @if(request()->routeIs('about.page')) active @endif" href="{{ route("about.page") }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link site-nav-link @if(request()->routeIs('perfumes.page')) active @endif" href="{{ route("perfumes.page") }}">Perfumes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link site-nav-link @if(request()->routeIs('sunglasses.page')) active @endif" href="{{ route("sunglasses.page") }}">Sunglasses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link site-nav-link @if(request()->routeIs('contact.page')) active @endif" href="{{ route("contact.page") }}">Contact</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link site-nav-link d-flex align-items-center gap-1" href="{{ route('home') }}#cart">
                                Cart
                                <span class="cart-badge badge rounded-pill" id="cart-count-badge" hidden>0</span>
                            </a>
                        </li>
                    @endauth
                    @include('website.layout.auth-nav')
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
                <span class="site-brand-divider" aria-hidden="true"></span>
                <img src="{{ asset('images/logo-details.png') }}" alt="Raven House" class="site-logo site-logo--details" width="140"
                    height="64" />
            </a>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex align-items-center justify-content-center">
            <ul class="nav flex-column text-center gap-3 w-100" aria-label="Mobile navigation">
                <li class="nav-item">
                    <a class="nav-link @if(request()->is('/')) active @endif" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('about.page')) active @endif" href="{{ route("about.page") }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('perfumes.page')) active @endif" href="{{ route("perfumes.page") }}">Perfumes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('sunglasses.page')) active @endif" href="{{ route("sunglasses.page") }}">Sunglasses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('contact.page')) active @endif" href="{{ route("contact.page") }}">Contact</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center justify-content-center gap-1" href="{{ route('home') }}#cart">
                            Cart
                            <span class="cart-badge badge rounded-pill" id="cart-count-badge-mobile" hidden>0</span>
                        </a>
                    </li>
                @endauth
                @include('website.layout.auth-nav-mobile')
            </ul>
        </div>
    </div>
