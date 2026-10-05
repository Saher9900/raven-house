@if(auth()->check())
    <section id="cart" class="section-luxury">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <p class="section-eyebrow mb-3">Your Selection</p>
                <h2 class="font-display section-title fw-semibold text-white">Shopping Cart</h2>
                <div class="luxury-divider" aria-hidden="true"><span>◆</span></div>
            </div>

            <div class="card-raven cart-panel rounded-4 p-4 p-lg-5">
                <div id="cart-feedback" class="alert alert-raven-success rounded-4 d-none" role="alert"></div>

                <div id="cart-empty" class="text-center py-5">
                    <p class="text-muted-raven mb-3">Your cart is empty.</p>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a href="{{ route('perfumes.page') }}" class="btn btn-outline-gold rounded-pill px-4">Browse Perfumes</a>
                        <a href="{{ route('sunglasses.page') }}" class="btn btn-outline-gold rounded-pill px-4">Browse Sunglasses</a>
                    </div>
                </div>

                <div id="cart-content" class="d-none">
                    <div class="table-responsive">
                        <table class="table table-borderless cart-table mb-0">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="cart-items"></tbody>
                        </table>
                    </div>

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-4 pt-4 border-top border-secondary border-opacity-25">
                        <p class="text-white fs-5 mb-0">
                            Total: <span class="text-gold fw-semibold" id="cart-total">$0.00</span>
                        </p>
                        <button type="button" class="btn btn-gold rounded-pill px-5" id="checkout-btn">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Address Modal -->
    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addressModalLabel">Add Shipping Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addressForm">
                        <div class="mb-3">
                            <label for="shippingAddress" class="form-label">Shipping Address</label>
                            <textarea class="form-control rounded-3" id="shippingAddress" name="shipping_address" rows="4" 
                                placeholder="Enter your full shipping address&#10;(Street, City, State, Zip, Country)" required></textarea>
                            <small class="text-muted-raven">This will be saved to your account for future orders.</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-gold rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-gold rounded-pill" id="saveAddressBtn">Save & Checkout</button>
                </div>
            </div>
        </div>
    </div>
@endif
