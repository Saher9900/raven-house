@extends('website.layout.main')
@section('content')
    <main class="about-page pt-5">
        <section class="about-hero page-hero mt-4">
            <div class="container about-hero__content text-center">
                <h1 class="font-display about-hero__title fw-bold text-white reveal reveal-delay-1">
                    {{ __('website.about.title') }}
                </h1>
                <div class="luxury-divider reveal reveal-delay-2" aria-hidden="true"><span>◆</span></div>
                <div class="about-hero__copy mx-auto">
                    @foreach (explode("\n\n", __('website.about.intro')) as $paragraphIndex => $paragraph)
                        <p class="about-copy reveal reveal-delay-{{ min($paragraphIndex + 1, 3) }}">
                            {{ $paragraph }}
                        </p>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="about-vision section-luxury pt-0">
            <div class="container">
                <div class="about-vision__card rounded-4 reveal">
                    <div class="about-vision__index" aria-hidden="true">01</div>
                    <div class="row g-4 g-lg-5 align-items-start position-relative">
                        <div class="col-lg-4 reveal">
                            <h2 class="font-display about-section-title fw-semibold text-white">
                                {{ __('website.about.vision_title') }}
                            </h2>
                        </div>
                        <div class="col-lg-8 about-vision__copy">
                            @foreach (explode("\n\n", __('website.about.vision')) as $paragraphIndex => $paragraph)
                                <p class="about-copy reveal reveal-delay-{{ min($paragraphIndex + 1, 3) }}">
                                    {{ $paragraph }}
                                </p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="why-raven section-luxury">
            <div class="container text-center">
            <div class="container text-center">
                <h2 class="font-display section-title fw-semibold text-white reveal">
                    {{ __('website.home.why_title') }}
                </h2>
                <div class="luxury-divider reveal reveal-delay-1" aria-hidden="true"><span>◆</span></div>
                <p class="why-raven__text about-why__text font-display mx-auto mb-0 reveal reveal-delay-2">
                    {{ __('website.home.why_text') }}
                </p>
            </div>
        </section>
    </main>
@endsection
