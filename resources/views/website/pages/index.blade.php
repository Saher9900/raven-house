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
                <p class="hero-lead mx-auto mt-3 mb-0 text-muted-raven reveal reveal-delay-2">
                    {{ __('website.home.intro') }}
                </p>
                <a href="{{ route('shop.page') }}" class="btn btn-gold rounded-pill mt-4 reveal reveal-delay-3">
                    {{ __('website.home.shop_now') }}
                </a>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 hero-fade-bottom"></div>
        </section>

        <section class="raven-portrait-section">
            <div class="container">
                <figure class="raven-portrait mx-auto mb-0 reveal">
                    <div class="raven-portrait__image" role="img"
                        aria-label="{{ __('website.home.raven_alt') }}"
                        style="background-image: linear-gradient(180deg, transparent 65%, rgba(6, 6, 8, 0.28)), url('{{ asset('images/real-raven.jpeg') }}')"></div>
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
                @for($group = 0; $group < 2; $group++)
                    <div class="marquee-group">
                        @for($index = 0; $index < 12; $index++)
                            <span>{{ __('website.home.marquee') }}</span>
                        @endfor
                    </div>
                @endfor
            </div>
        </div>

        <section class="why-raven section-luxury">
            <div class="container text-center">
                <h2 class="font-display section-title fw-semibold text-white reveal">
                    {{ __('website.home.why_title') }}
                </h2>
                <div class="luxury-divider reveal" aria-hidden="true"><span>◆</span></div>
                <p class="why-raven__text font-display mx-auto mb-0 reveal reveal-delay-1">
                    {{ __('website.home.why_text') }}
                </p>
            </div>
        </section>

        <section class="home-perfume-cta text-center">
            <a href="{{ route('perfumes.page') }}"
                class="btn btn-gold home-perfume-cta__button rounded-pill">
                {{ __('website.home.check_perfumes') }}
                <span aria-hidden="true">{{ app()->isLocale('ar') ? '←' : '→' }}</span>
            </a>
        </section>
    </main>
@endsection
