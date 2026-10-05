@extends('website.layout.main')
@section('content')
    <main class="pt-5">
        <section class="hero-glow page-hero py-5 mt-4">
            <div class="container text-center py-4 reveal">
                <p class="section-eyebrow">Our Story</p>
                <div class="luxury-divider" aria-hidden="true"><span>◆</span></div>
                <h1 class="font-display display-4 fw-bold text-white mt-3">About <span class="logo-gold">Raven House</span>
                </h1>
                <p class="col-lg-8 mx-auto fs-5 text-muted-raven mt-3">Where vision meets aroma — a house built on elegance,
                    authenticity, and the art of personal expression.</p>
            </div>
        </section>

        <section class="pb-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 reveal">
                        <div class="card-raven rounded-4 p-4 p-lg-5">
                            <h2 class="font-display h2 fw-semibold text-white">The Vision</h2>
                            <p class="text-muted-raven mt-4 lh-lg">Raven House was founded on a simple belief: how you see
                                the world and how you are remembered should both feel unmistakably yours. We bring together
                                two pillars of modern luxury — precision eyewear and masterfully blended fragrances — under
                                one refined brand identity.</p>
                            <p class="text-muted-raven mt-3 lh-lg">From sun-drenched boulevards to intimate evening
                                gatherings, our collections are designed to accompany every chapter of your life with
                                confidence and grace.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 reveal reveal-delay-1">
                        <div class="border-accent-gold mb-4">
                            <h3 class="font-display h4 text-gold">Mission</h3>
                            <p class="text-muted-raven mt-2">To deliver accessible luxury through exceptional products and
                                sincere customer relationships.</p>
                        </div>
                        <div class="border-accent-gold mb-4">
                            <h3 class="font-display h4 text-gold">Values</h3>
                            <p class="text-muted-raven mt-2">Integrity, craftsmanship, sustainability in sourcing, and
                                respect for every client who walks through our door.</p>
                        </div>
                        <div class="border-accent-gold">
                            <h3 class="font-display h4 text-gold">Promise</h3>
                            <p class="text-muted-raven mt-2">Only pieces we would wear and scents we would wear ourselves —
                                nothing less than excellence.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-muted py-5">
            <div class="container text-center py-4">
                <h2 class="font-display h2 fw-semibold text-white">Crafted With Care</h2>
                <p class="col-lg-8 mx-auto text-muted-raven mt-3">Our team partners with skilled artisans and renowned
                    perfumers to ensure every frame and every bottle meets the Raven House standard — bold, refined, and
                    unforgettable.</p>
                <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                    <a href="{{ route('sunglasses.page') }}" class="btn btn-outline-gold rounded-pill px-4 py-2">View Sunglasses</a>
                    <a href="{{ route('perfumes.page') }}" class="btn btn-gold rounded-pill px-4 py-2">View Perfumes</a>
                </div>
            </div>
        </section>
    </main>
@endsection
