@extends('website.layout.main')
@section('content')
    <main>
        <section class="hero-glow hero-cinema position-relative d-flex align-items-center overflow-hidden">
            <div class="hero-orb hero-orb-1" aria-hidden="true"></div>
            <div class="hero-orb hero-orb-2" aria-hidden="true"></div>
            <div class="position-absolute top-0 start-0 w-100 h-100 hero-pattern"></div>
            <div class="container position-relative z-1 text-center py-5">
                <h1 class="font-display hero-title fw-bold text-white lh-sm mb-0 reveal reveal-delay-1">
                    <span class="logo-gold">Raven House</span>
                </h1>
                {{-- <p class="hero-lead mx-auto mt-3 mb-0 text-muted-raven reveal reveal-delay-2">
                    {{ __('website.home.intro') }}
                </p> --}}
                {{-- <a href="{{ route('shop.page') }}" class="btn btn-gold rounded-pill mt-4 reveal reveal-delay-3">
                    {{ __('website.home.shop_now') }}
                </a> --}}
                <a href="{{ route('shop.page') }}" class="btn btn-gold home-perfume-cta__button rounded-pill mt-4 reveal reveal-delay-3">
                    {{ __('website.home.check_perfumes') }}
                    <span aria-hidden="true">{{ app()->isLocale('ar') ? '←' : '→' }}</span>
                </a>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 hero-fade-bottom"></div>
        </section>

        <section class="raven-portrait-section">
            <div class="container">
                <figure class="raven-portrait mx-auto mb-0 reveal">
                    <div class="raven-portrait__image" role="img" aria-label="{{ __('website.home.raven_alt') }}"
                        style="background-image: linear-gradient(180deg, transparent 65%, rgba(6, 6, 8, 0.28)), url('{{ asset('images/real-raven.jpeg') }}')">
                    </div>
                    <figcaption class="raven-portrait__caption text-center">
                        <p class="font-display fs-3 text-white mb-2">{{ __('website.home.raven_arrival') }}</p>
                        <p class="text-muted-raven mb-0">
                            {{ __('website.home.raven_portrait') }}<br>
                            {{ __('website.home.raven_location') }}
                        </p>
                    </figcaption>
                </figure>
            </div>
        </section>

        <div class="marquee-luxury" aria-hidden="true">
            <div class="marquee-track">
                @for ($group = 0; $group < 2; $group++)
                    <div class="marquee-group">
                        @for ($index = 0; $index < 12; $index++)
                            <span>{{ __('website.home.marquee') }}</span>
                        @endfor
                    </div>
                @endfor
            </div>
        </div>

        @if ($featuredProducts->isNotEmpty())
            <section class="featured-products" aria-labelledby="featured-products-title">
                <div class="container">
                    <div class="featured-products__heading">
                        <h2 class="font-display text-white mb-0" id="featured-products-title">
                            {{ __('website.home.featured_title') }}
                        </h2>
                        @if ($featuredProducts->count() > 1)
                            <div class="featured-products__controls">
                                <button type="button" class="featured-products__control" data-featured-direction="-1"
                                    aria-label="{{ __('website.home.previous_products') }}">
                                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                        <path d="M19 12H5m7-7-7 7 7 7" />
                                    </svg>
                                </button>
                                <button type="button" class="featured-products__control" data-featured-direction="1"
                                    aria-label="{{ __('website.home.next_products') }}">
                                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                        <path d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="swiper featured-products__swiper" data-featured-products-swiper>
                        <div class="swiper-wrapper">
                            @foreach ($featuredProducts as $featuredProduct)
                                @php
                                    $product = $featuredProduct->perfume ?? $featuredProduct->sunglasses;
                                    $productImage = $product->images->first()?->image_path ?? asset('storage/images/default-product.png');
                                @endphp
                                <article class="swiper-slide">
                                    <div class="featured-product-card">
                                        <a href="{{ $featuredProduct->perfume ? route('perfumes.show', $product) : route('sunglasses.show', $product) }}"
                                            class="featured-product-card__link">
                                            <div class="featured-product-card__image">
                                                <img src="{{ $productImage }}" alt="{{ $product->name }}" draggable="false">
                                            </div>
                                            <div class="featured-product-card__content">
                                                <span class="featured-product-card__type">
                                                    {{ $featuredProduct->perfume ? __('website.navigation.perfumes') : __('website.navigation.sunglasses') }}
                                                </span>
                                                <h3 class="font-display">{{ $product->name }}</h3>
                                                <p class="featured-product-card__price">${{ number_format($product->effectivePrice(), 2) }}</p>
                                            </div>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                    @if ($featuredProducts->count() > 1)
                        <div class="featured-products__pagination" data-featured-products-pagination></div>
                    @endif
                </div>
            </section>
        @endif

        <section class="home-perfume-cta text-center">
            <a href="{{ route('shop.page') }}" class="btn btn-gold home-perfume-cta__button rounded-pill">
                {{ __('website.home.see_more_products') }}
                <span aria-hidden="true">{{ app()->isLocale('ar') ? '←' : '→' }}</span>
            </a>
        </section>
    </main>
@endsection
