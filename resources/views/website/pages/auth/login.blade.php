@extends('website.layout.main')
@section('content')
    <main class="pt-5">
        <section class="hero-glow page-hero py-5 mt-4">
            <div class="container text-center py-3 reveal">
                <p class="section-eyebrow">Welcome Back</p>
                <div class="luxury-divider" aria-hidden="true"><span>◆</span></div>
                <h1 class="font-display display-4 fw-bold text-white mt-3">Sign In</h1>
                <p class="text-muted-raven col-lg-6 mx-auto mt-2">Access your Raven House account to continue your journey.</p>
            </div>
        </section>

        <section class="pb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <form action="{{ route('login') }}" method="POST" class="card-raven auth-form rounded-4 p-4 p-lg-5">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control input-dark rounded-3 @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required autofocus
                                    placeholder="you@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control input-dark rounded-3 @error('password') is-invalid @enderror"
                                    id="password" name="password" required placeholder="Enter your password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    @checked(old('remember'))>
                                <label class="form-check-label text-muted-raven small" for="remember">
                                    Remember me
                                </label>
                            </div>

                            <button type="submit" class="btn btn-gold rounded-pill px-5">Sign In</button>

                            <p class="text-muted-raven small mt-4 mb-0">
                                Don't have an account?
                                <a href="{{ route('register') }}" class="text-gold">Create one</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
