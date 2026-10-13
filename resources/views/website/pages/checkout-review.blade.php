@extends('website.layout.main')
@section('content')
    <main class="pt-5">
        <section class="hero-glow page-hero py-5 mt-4">
            <div class="container text-center py-3 reveal">
                <h1 class="font-display display-4 fw-bold text-white mt-3">{{ __('website.checkout.review_title') }}</h1>
                <p class="text-muted-raven col-lg-6 mx-auto mt-3 mb-0">{{ __('website.checkout.review_intro') }}</p>
            </div>
        </section>

        <section class="section-luxury pt-0">
            <div class="container">
                <form action="{{ route('checkout.store') }}" method="POST" class="row g-4">
                    @csrf
                    <input type="hidden" name="payment_method" value="{{ $paymentMethod }}">
                    @if($errors->any())
                        <div class="col-12">
                            <div class="alert alert-raven-error rounded-4 mb-0" role="alert">
                                {{ __('website.checkout.review_errors') }}
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-7">
                        <div class="card-raven auth-form rounded-4 p-4 p-lg-5 h-100">
                            <p class="filter-bar__title mb-0">{{ __('website.checkout.delivery_information') }}</p>
                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label for="customerName" class="form-label">{{ __('website.checkout.full_name') }}</label>
                                    <input class="form-control input-dark rounded-3 @error('customer_name') is-invalid @enderror" id="customerName" name="customer_name"
                                        type="text" maxlength="255" value="{{ old('customer_name', $details['customer_name'] ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="customerEmail" class="form-label">
                                        {{ __('website.checkout.email') }}
                                        <span class="text-muted-raven fw-normal text-lowercase">({{ __('website.general.optional') }})</span>
                                    </label>
                                    <input class="form-control input-dark rounded-3 @error('customer_email') is-invalid @enderror" id="customerEmail" name="customer_email"
                                        type="email" maxlength="255" value="{{ old('customer_email', $details['customer_email'] ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="customerPhone" class="form-label">{{ __('website.checkout.phone') }}</label>
                                    <input class="form-control input-dark rounded-3 @error('customer_phone') is-invalid @enderror" id="customerPhone" name="customer_phone"
                                        type="tel" maxlength="20" value="{{ old('customer_phone', $details['customer_phone'] ?? '') }}" required>
                                </div>
                                <div class="col-12">
                                    <label for="shippingAddress" class="form-label">{{ __('website.checkout.shipping_address') }}</label>
                                    <textarea class="form-control input-dark rounded-3 @error('shipping_address') is-invalid @enderror" id="shippingAddress" name="shipping_address"
                                        rows="4" required>{{ old('shipping_address', $details['shipping_address'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card-raven rounded-4 p-4 p-lg-5 h-100">
                            <p class="filter-bar__title mb-0">{{ __('website.checkout.order_summary') }}</p>
                            <ul class="list-unstyled d-flex flex-column gap-3 mt-4 mb-0">
                                @foreach($cartItems as $item)
                                    <li class="d-flex justify-content-between align-items-start gap-3">
                                        <span class="text-white">
                                            {{ $item['productable']->name }}
                                            <span class="text-muted-raven small">× {{ $item['quantity'] }}</span>
                                        </span>
                                        <span class="text-gold fw-semibold text-nowrap">
                                            ${{ number_format((float) $item['unit_price'] * $item['quantity'], 2) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top border-raven">
                                <span class="text-muted-raven">{{ __('website.checkout.total') }}</span>
                                <span class="text-gold fs-5 fw-semibold">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="text-muted-raven">{{ __('website.checkout.payment_method') }}</span>
                                <span class="text-white">{{ __('website.checkout.cash_on_delivery') }}</span>
                            </div>
                            <button type="submit" class="btn btn-gold rounded-pill w-100 py-3 mt-4">
                                {{ __('website.checkout.place_order') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection
