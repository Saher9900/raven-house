@extends('website.layout.main')
@section('content')
    <main>
        <section class="hero-glow hero-cinema position-relative d-flex align-items-center overflow-hidden pt-5">
            <div class="hero-orb hero-orb-1" aria-hidden="true"></div>
            <div class="hero-orb hero-orb-2" aria-hidden="true"></div>
            <div class="position-absolute top-0 start-0 w-100 h-100 hero-pattern"></div>
            <div class="container position-relative z-1 text-center py-5">
                <p class="section-eyebrow mb-4 reveal">Est. MMXXVI — Cairo</p>
                <div class="luxury-divider reveal" aria-hidden="true">
                    <span>◆</span>
                </div>
                <h1 class="font-display hero-title fw-bold text-white lh-sm mt-2 reveal reveal-delay-1">
                    See the World.<br />
                    <span class="logo-gold">Smell the Moment.</span>
                </h1>
                <p class="hero-lead mx-auto mt-4 text-muted-raven reveal reveal-delay-2">
                    Raven House unites artisan eyewear and signature fragrances —
                    crafted for those who move through life with intention, poise, and
                    unmistakable presence.
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3 mt-5 reveal reveal-delay-3">
                    <a href="{{ route('sunglasses.page') }}" class="btn btn-gold rounded-pill">Explore Sunglasses</a>
                    <a href="{{ route('perfumes.page') }}" class="btn btn-outline-gold rounded-pill">Discover Perfumes</a>
                </div>
            </div>
            <div class="scroll-cue d-none d-md-flex" aria-hidden="true">
                <span>Scroll</span>
                <div class="scroll-cue-line"></div>
            </div>
            <div class="position-absolute bottom-0 start-0 w-100 hero-fade-bottom"></div>
        </section>

        <div class="marquee-luxury" aria-hidden="true">
            <div class="marquee-track">
                <span>Artisan Eyewear</span>
                <span>Signature Fragrances</span>
                <span>Timeless Elegance</span>
                <span>Curated Luxury</span>
                <span>Artisan Eyewear</span>
                <span>Signature Fragrances</span>
                <span>Timeless Elegance</span>
                <span>Curated Luxury</span>
            </div>
        </div>

        @include('website.layout.cart-section')

        <section class="quote-luxury">
            <div class="container px-4 text-center reveal">
                <blockquote>
                    “True luxury is not loud — it lingers. In the frame you choose and
                    the scent you leave behind.”
                </blockquote>
                <cite>— The Raven House Manifesto</cite>
            </div>
        </section>

        <section class="section-luxury">
            <div class="container">
                <div class="text-center mb-5 reveal">
                    <p class="section-eyebrow mb-3">Curated For You</p>
                    <h2 class="font-display section-title fw-semibold text-white">
                        Our Collections
                    </h2>
                    <div class="luxury-divider" aria-hidden="true">
                        <span>◆</span>
                    </div>
                    <p class="text-muted-raven mt-3 col-lg-7 mx-auto">
                        Two worlds of luxury, one house of distinction — each piece
                        selected to elevate how you see and how you are remembered.
                    </p>
                </div>
                <div class="row g-4 g-lg-5">
                    <div class="col-md-6 reveal">
                        <a href="{{ route('sunglasses.page') }}"
                            class="collection-card rounded-4 d-block text-decoration-none position-relative">
                            <div class="card-visual bg-raven-surface d-flex align-items-center justify-content-center">
                                <svg class="collection-icon" width="128" height="128" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.75"
                                        d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z" />
                                    <circle cx="12" cy="12" r="3" stroke-width="0.75" />
                                </svg>
                            </div>
                            <div class="position-absolute top-0 start-0 w-100 h-100 card-overlay"></div>
                            <div class="position-absolute bottom-0 start-0 w-100 p-4">
                                <h3 class="font-display h2 fw-semibold text-white">
                                    Sunglasses
                                </h3>
                                <p class="text-muted-raven mb-2">
                                    Premium lenses. Timeless frames.
                                </p>
                                <span class="text-gold small fw-medium">Shop collection →</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 reveal reveal-delay-1">
                        <a href="{{ route('perfumes.page') }}"
                            class="collection-card rounded-4 d-block text-decoration-none position-relative">
                            <div class="card-visual bg-raven-surface d-flex align-items-center justify-content-center"
                                style="
                    background: linear-gradient(
                      to bottom right,
                      #27272a,
                      rgba(69, 26, 3, 0.2),
                      #09090b
                    );
                  ">
                                <svg class="collection-icon" width="112" height="112" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.75"
                                        d="M12 2v4m0 12v4M8 6h8M7 10h10l-1 10H8L7 10z" />
                                </svg>
                            </div>
                            <div class="position-absolute top-0 start-0 w-100 h-100 card-overlay"></div>
                            <div class="position-absolute bottom-0 start-0 w-100 p-4">
                                <h3 class="font-display h2 fw-semibold text-white">
                                    Perfumes
                                </h3>
                                <p class="text-muted-raven mb-2">
                                    Signature scents. Lasting impressions.
                                </p>
                                <span class="text-gold small fw-medium">Shop collection →</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-muted section-luxury">
            <div class="container">
                <div class="stats-luxury mb-5 pb-4 reveal">
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Curated Pieces</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">12</div>
                        <div class="stat-label">Signature Scents</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Hand Selected</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">1</div>
                        <div class="stat-label">House of Luxury</div>
                    </div>
                </div>
                <div class="text-center mb-5 reveal">
                    <p class="section-eyebrow mb-3">The Raven Standard</p>
                    <h2 class="font-display section-title fw-semibold text-white">
                        Why Raven House
                    </h2>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 reveal">
                        <div class="feature-luxury text-center text-lg-start">
                            <div
                                class="feature-badge rounded-circle d-inline-flex align-items-center justify-content-center mb-3 mx-auto mx-lg-0">
                                <span class="font-display fs-4 text-gold">01</span>
                            </div>
                            <h3 class="font-display h4 fw-semibold text-white">
                                Curated Quality
                            </h3>
                            <p class="text-muted-raven mt-2 mb-0">
                                Every piece is hand-selected for craftsmanship and lasting
                                appeal — nothing enters our house without meeting the standard.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 reveal reveal-delay-1">
                        <div class="feature-luxury text-center text-lg-start">
                            <div
                                class="feature-badge rounded-circle d-inline-flex align-items-center justify-content-center mb-3 mx-auto mx-lg-0">
                                <span class="font-display fs-4 text-gold">02</span>
                            </div>
                            <h3 class="font-display h4 fw-semibold text-white">
                                Timeless Design
                            </h3>
                            <p class="text-muted-raven mt-2 mb-0">
                                Classic silhouettes and notes that transcend seasons — made to
                                feel as relevant years from now as the day you discover them.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 reveal reveal-delay-2">
                        <div class="feature-luxury text-center text-lg-start">
                            <div
                                class="feature-badge rounded-circle d-inline-flex align-items-center justify-content-center mb-3 mx-auto mx-lg-0">
                                <span class="font-display fs-4 text-gold">03</span>
                            </div>
                            <h3 class="font-display h4 fw-semibold text-white">
                                Personal Service
                            </h3>
                            <p class="text-muted-raven mt-2 mb-0">
                                Expert guidance to find your perfect frame and fragrance —
                                because luxury should feel personal, never generic.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-luxury pb-0">
            <div class="container">
                <div class="cta-luxury text-center reveal">
                    <p class="section-eyebrow mb-3">Your Invitation</p>
                    <h2 class="font-display section-title fw-semibold text-white">
                        Begin Your Journey
                    </h2>
                    <p class="text-muted-raven mt-3 col-lg-8 mx-auto">
                        Visit our boutique or reach out — we would love to help you
                        discover your signature look and scent, in an atmosphere worthy of
                        the name Raven House.
                    </p>
                    <a href="{{ route('contact.page') }}" class="btn btn-gold rounded-pill mt-4">Contact Us</a>
                </div>
            </div>
        </section>
    </main>
@endsection
