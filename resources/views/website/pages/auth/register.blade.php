@extends('website.layout.main')
@section('content')
    <main class="pt-5">
        <section class="hero-glow page-hero py-5 mt-4">
            <div class="container text-center py-3 reveal">
                <p class="section-eyebrow">Join Raven House</p>
                <div class="luxury-divider" aria-hidden="true"><span>◆</span></div>
                <h1 class="font-display display-4 fw-bold text-white mt-3">Create Account</h1>
                <p class="text-muted-raven col-lg-6 mx-auto mt-2">Register to explore our curated perfumes and eyewear collection.</p>
            </div>
        </section>

        <section class="pb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <form action="{{ route('register') }}" method="POST" class="card-raven auth-form rounded-4 p-4 p-lg-5">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Full name</label>
                                <input type="text" class="form-control input-dark rounded-3 @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required autofocus
                                    placeholder="Your name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control input-dark rounded-3 @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required
                                    placeholder="you@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone number</label>
                                <input type="tel" class="form-control input-dark rounded-3 @error('phone_number') is-invalid @enderror"
                                    id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required
                                    placeholder="+1 (555) 000-0000">
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control input-dark rounded-3 @error('password') is-invalid @enderror"
                                    id="password" name="password" required placeholder="At least 8 characters">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm password</label>
                                <input type="password" class="form-control input-dark rounded-3"
                                    id="password_confirmation" name="password_confirmation" required
                                    placeholder="Repeat your password">
                            </div>

                            <div class="mb-4">
                                <label for="shipping_address" class="form-label">Shipping Address (Optional)</label>
                                <textarea class="form-control input-dark rounded-3 @error('shipping_address') is-invalid @enderror"
                                    id="shipping_address" name="shipping_address" rows="3"
                                    placeholder="Enter your full shipping address or add it later">{{ old('shipping_address') }}</textarea>
                                <small class="text-muted-raven">You can add or update this later in your account settings</small>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-gold rounded-pill px-5">Create Account</button>

                            <p class="text-muted-raven small mt-4 mb-0">
                                Already have an account?
                                <a href="{{ route('login') }}" class="text-gold">Sign in</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
