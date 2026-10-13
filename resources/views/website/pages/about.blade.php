@extends('website.layout.main')
@section('content')
    <main class="pt-5">
        <section class="hero-glow page-hero py-5 mt-4">
            <div class="container text-center py-4 reveal">
                <h1 class="font-display display-4 fw-bold text-white mt-3">{{ __('website.about.title') }}</h1>
                <p class="col-lg-8 mx-auto fs-5 text-muted-raven mt-3">{{ __('website.about.intro') }}</p>
            </div>
        </section>

        <section class="section-luxury pt-0">
            <div class="container">
                <div class="card-raven rounded-4 p-4 p-lg-5 reveal">
                    <div class="row g-4 g-lg-5 align-items-start">
                        <div class="col-lg-4">
                            <h2 class="font-display h2 fw-semibold text-white">{{ __('website.about.vision_title') }}</h2>
                        </div>
                        <div class="col-lg-8">
                            <p class="text-muted-raven lh-lg white-space-pre-wrap mb-0">{{ __('website.about.vision') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
