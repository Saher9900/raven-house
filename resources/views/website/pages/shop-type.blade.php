@extends('website.layout.main')
@section('content')
    <main class="pt-5">
        <section class="hero-glow page-hero py-5 mt-4">
            <div class="container text-center py-3 reveal">
                <p class="section-eyebrow mb-3">{{ __('website.navigation.perfumes') }}</p>
                <h1 class="font-display display-4 fw-bold text-white mt-3">{{ __('website.shop_type.title') }}</h1>
                <p class="text-muted-raven col-lg-6 mx-auto mt-3 mb-0">{{ __('website.shop_type.intro') }}</p>
            </div>
        </section>

        <section class="section-luxury pt-0">
            <div class="container">
                <div class="row g-4 justify-content-center">
                    <div class="col-sm-6 col-lg-4">
                        <a href="{{ route('perfumes.page', ['perfume_type' => 'box']) }}"
                            class="feature-luxury d-flex flex-column align-items-center justify-content-center gap-3 text-center text-decoration-none">
                            <span class="fs-5 text-gold" aria-hidden="true">◆</span>
                            <h2 class="font-display h3 fw-semibold text-white mb-0">{{ __('website.navigation.boxes') }}</h2>
                            <span class="text-muted-raven small">{{ __('website.shop_type.discover') }}</span>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <a href="{{ route('perfumes.page', ['perfume_type' => 'fragrance']) }}"
                            class="feature-luxury d-flex flex-column align-items-center justify-content-center gap-3 text-center text-decoration-none">
                            <span class="fs-5 text-gold" aria-hidden="true">◆</span>
                            <h2 class="font-display h3 fw-semibold text-white mb-0">{{ __('website.navigation.fragrances') }}</h2>
                            <span class="text-muted-raven small">{{ __('website.shop_type.discover') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
