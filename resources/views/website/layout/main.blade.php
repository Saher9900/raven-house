@include('website.layout.header')
@include('website.layout.flash')
<div id="cart-toast" class="cart-toast d-none" role="alert"></div>
@yield('content')
@include('website.layout.cart-drawer')
@include('website.layout.footer')