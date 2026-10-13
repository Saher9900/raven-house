@extends('website.layout.main')
@section('content')
    <main class="pt-5">
        <section class="hero-glow page-hero py-5 mt-4">
            <div class="container text-center py-3 reveal">
                <h1 class="font-display display-4 fw-bold text-white mt-3">{{ __('website.checkout.payment_title') }}</h1>
                <p class="text-muted-raven col-lg-6 mx-auto mt-3 mb-0">{{ __('website.checkout.payment_intro') }}</p>
            </div>
        </section>

        <section class="section-luxury pt-0">
            <div class="container">
                <form action="{{ route('checkout.payment-method') }}" method="POST" class="card-raven checkout-form rounded-4 p-4 p-lg-5">
                    @csrf
                    <div class="d-flex flex-column gap-3">
                        <div class="payment-option">
                            <input class="form-check-input flex-shrink-0 mt-1" type="radio" name="payment_method" value="cod" id="payment-cod" checked>
                            <label class="form-check-label flex-grow-1" for="payment-cod">
                                <span class="d-block text-white fw-semibold">{{ __('website.checkout.cash_on_delivery') }}</span>
                                <span class="d-block small text-muted-raven mt-1">{{ __('website.checkout.cod_description') }}</span>
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-gold rounded-pill w-100 py-3 mt-4">
                        {{ __('website.checkout.checkout_btn') }}
                    </button>
                </form>
            </div>
        </section>
    </main>
@endsection
