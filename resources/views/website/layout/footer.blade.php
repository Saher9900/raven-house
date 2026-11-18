<footer class="footer-raven">
    <div class="container">
        <div class="footer-raven__content">
            <div class="footer-raven__brand">
                <a href="{{ route('home') }}" class="footer-raven__brand-lockup text-decoration-none">
                    <img src="{{ asset('images/logo.png') }}" alt="" aria-hidden="true"
                        class="site-logo site-logo--footer" width="76" height="76" />
                    <span class="footer-raven__brand-name">Raven House</span>
                </a>
            </div>

            <div class="footer-raven__section">
                <h2 class="footer-raven__heading">{{ __('website.footer.navigation') }}</h2>
                <nav class="footer-raven__links" aria-label="{{ __('website.footer.navigation') }}">
                    <a href="{{ route('home') }}">{{ __('website.navigation.home') }}</a>
                    <a href="{{ route('about.page') }}">{{ __('website.navigation.about') }}</a>
                </nav>
            </div>

            <div class="footer-raven__section">
                <h2 class="footer-raven__heading">{{ __('website.footer.categories') }}</h2>
                <nav class="footer-raven__links" aria-label="{{ __('website.footer.categories') }}">
                    <a href="{{ route('perfumes.page') }}">{{ __('website.navigation.perfumes') }}</a>
                    <a href="{{ route('sunglasses.page') }}">{{ __('website.navigation.sunglasses') }}</a>
                    <a href="{{ route('coming-soon.page') }}">{{ __('website.navigation.coming_soon') }}</a>
                </nav>
            </div>

            <div class="footer-raven__contact">
                <h2 class="footer-raven__heading">{{ __('website.navigation.contact') }}</h2>
                <p class="footer-raven__contact-hours">{{ __('website.contact.available_24_hours') }}</p>
                <div class="d-flex gap-3 footer-raven__socials">
                    <a href="#" class="social-btn rounded-circle d-flex align-items-center justify-content-center"
                        aria-label="{{ __('website.contact.instagram') }}">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                    <a href="#" class="social-btn rounded-circle d-flex align-items-center justify-content-center"
                        aria-label="{{ __('website.contact.facebook') }}">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <p class="footer-raven__copyright text-center small mb-0">
            {{ __('website.footer.copyright', ['year' => now()->year]) }}
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="js/main.js"></script>
</body>

</html>
