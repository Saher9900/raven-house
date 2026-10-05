@include('website.layout.header')
@include('website.layout.flash')
@auth
    <div id="cart-toast" class="cart-toast d-none" role="alert"></div>
@endauth
@yield('content')
@include('website.layout.footer')