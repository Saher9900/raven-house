<div class="offcanvas offcanvas-end cart-drawer" tabindex="-1" id="cartDrawer" aria-labelledby="cartDrawerLabel">
    <div class="offcanvas-header cart-drawer-header">
        <div>
            <p class="section-eyebrow mb-1">Your Selection</p>
            <h2 class="offcanvas-title font-display text-white" id="cartDrawerLabel">Shopping Cart</h2>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close cart"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column p-0">
        <div id="cart-feedback" class="alert alert-raven-success rounded-0 mb-0 d-none" role="status"></div>

        <div id="cart-empty" class="cart-empty-state text-center px-4 py-5">
            <div class="cart-empty-icon mx-auto mb-3" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="currentColor"
                    stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 3h2l2.2 11.2a2 2 0 0 0 2 1.6h8.9a2 2 0 0 0 2-1.6L22 7H6" />
                    <circle cx="10" cy="20" r="1" />
                    <circle cx="18" cy="20" r="1" />
                </svg>
            </div>
            <h3 class="font-display h3 text-white">Your cart is waiting</h3>
            <p class="text-muted-raven mb-4">Discover a piece that feels made for you.</p>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('perfumes.page') }}" class="btn btn-outline-gold rounded-pill">Explore Perfumes</a>
                <a href="{{ route('sunglasses.page') }}" class="btn btn-outline-gold rounded-pill">Explore Sunglasses</a>
            </div>
        </div>

        <div id="cart-content" class="cart-content d-none flex-column flex-grow-1 overflow-hidden">
            <div id="cart-items" class="cart-items-list flex-grow-1 overflow-auto p-3"></div>
            <div class="cart-drawer-footer p-3 p-sm-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted-raven">Subtotal</span>
                    <span class="text-gold fs-5 fw-semibold" id="cart-total">$0.00</span>
                </div>
                <p class="small text-muted-raven mb-3">Our team will review your order shortly after you place it.</p>
                <button type="button" class="btn btn-gold rounded-pill w-100 py-3" id="checkout-btn">
                    Continue to checkout
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Delivery Information</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addressForm">
                    @guest
                        <div class="mb-3">
                            <label for="customerName" class="form-label">Full Name</label>
                            <input class="form-control rounded-3" id="customerName" name="customer_name" type="text" maxlength="255" required>
                        </div>
                        <div class="mb-3">
                            <label for="customerPhone" class="form-label">Phone</label>
                            <input class="form-control rounded-3" id="customerPhone" name="customer_phone" type="tel" maxlength="20" required>
                        </div>
                    @endguest
                    <div class="mb-3">
                        <label for="shippingAddress" class="form-label">Shipping Address</label>
                        <textarea class="form-control rounded-3" id="shippingAddress" name="shipping_address" rows="4"
                            placeholder="Enter your full shipping address&#10;(Street, City, State, Zip, Country)" required></textarea>
                        @auth
                            <small class="text-muted-raven">This will be saved to your account for future orders.</small>
                        @endauth
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-gold rounded-pill" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-gold rounded-pill" id="saveAddressBtn">
                    @auth Save & Checkout @else Place Order @endauth
                </button>
            </div>
        </div>
    </div>
</div>
