@extends('website.layout.main')
@section('content')
    <main class="pt-5">
        <section class="hero-glow page-hero position-relative overflow-hidden">
            <div class="hero-orb hero-orb-1" aria-hidden="true"></div>
            <div class="hero-orb hero-orb-2" aria-hidden="true"></div>
            <div class="position-absolute top-0 start-0 w-100 h-100 hero-pattern"></div>
            <div class="container position-relative z-1 text-center py-4 reveal">
                <p class="section-eyebrow mb-3">{{ __('website.coming_soon.eyebrow') }}</p>
                <h1 class="font-display display-4 fw-bold text-white mt-3">{{ __('website.coming_soon.title') }}</h1>
                <div class="luxury-divider" aria-hidden="true"><span>◆</span></div>
                <p class="col-lg-8 mx-auto fs-5 text-muted-raven mt-3 mb-0">{{ __('website.coming_soon.intro') }}</p>
            </div>
        </section>

        <div class="marquee-luxury" aria-hidden="true">
            <div class="marquee-track">
                @for($index = 0; $index < 8; $index++)
                    <span>{{ __('website.coming_soon.marquee') }}</span>
                @endfor
            </div>
        </div>

        <section class="section-luxury text-center">
            <a href="{{ route('home') }}" class="btn btn-outline-gold rounded-pill">
                {{ __('website.coming_soon.back_home') }}
            </a>
        </section>
    </main>
@endsection
