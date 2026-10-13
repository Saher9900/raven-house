 <footer class="footer-raven border-top border-raven bg-raven py-5">
     <div class="container">
         <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-4">
             <div class="text-center text-md-start">
                 <a href="{{ route('home') }}" class="d-inline-block text-decoration-none">
                     <img src="{{ asset('images/logo.png') }}" alt="Raven House" class="site-logo site-logo--footer" width="76"
                         height="76" />
                 </a>
                 <p class="footer-tagline mt-2 mb-0">
                     {{ __('website.footer.tagline') }}
                 </p>
             </div>
             <nav class="d-flex flex-wrap justify-content-center gap-3 gap-md-4 small">
                 <a href="{{ route('home') }}">{{ __('website.navigation.home') }}</a>
                 <a href="{{ route('about.page') }}">{{ __('website.navigation.about') }}</a>
                 <a href="{{ route('perfumes.page') }}">{{ __('website.navigation.perfumes') }}</a>
                 <a href="{{ route('sunglasses.page') }}">{{ __('website.navigation.sunglasses') }}</a>
                 <a href="{{ route('contact.page') }}">{{ __('website.navigation.contact') }}</a>
             </nav>
         </div>
         <p class="text-center text-secondary small mt-4 mb-0">
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
