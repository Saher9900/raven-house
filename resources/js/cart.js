const formatMoney = (amount) =>
    `$${Number(amount).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

const escapeHtml = (value) =>
    String(value).replace(/[&<>"']/g, (character) => ({
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#039;",
    })[character]);

const getConfig = () => {
    const body = document.body;

    return {
        indexUrl: body.dataset.cartIndex ?? null,
        storeUrl: body.dataset.cartStore ?? null,
        deliveryUrl: body.dataset.checkoutDelivery ?? null,
        authenticated: body.dataset.authenticated === "true",
    };
};

const showToast = (message, isError = false) => {
    const toast = document.getElementById("cart-toast");
    const feedback = document.getElementById("cart-feedback");

    if (toast) {
        toast.textContent = message;
        toast.classList.remove("d-none", "cart-toast--error");

        if (isError) {
            toast.classList.add("cart-toast--error");
        }

        window.clearTimeout(showToast.timer);
        showToast.timer = window.setTimeout(() => {
            toast.classList.add("d-none");
        }, 3200);
    }

    if (feedback) {
        feedback.textContent = message;
        feedback.classList.remove("d-none", "alert-raven-error");

        if (isError) {
            feedback.classList.add("alert-raven-error");
        } else {
            feedback.classList.remove("alert-raven-error");
        }
    }
};

const updateBadges = (count) => {
    const badge = document.getElementById("cart-count-badge");

    if (!badge) {
        return;
    }

    badge.textContent = String(count);
    badge.hidden = count < 1;
    badge.parentElement.setAttribute(
        "aria-label",
        `Open shopping cart, ${count} ${count === 1 ? "item" : "items"}`,
    );
};

const renderCart = (payload) => {
    const emptyState = document.getElementById("cart-empty");
    const content = document.getElementById("cart-content");
    const itemsContainer = document.getElementById("cart-items");
    const totalEl = document.getElementById("cart-total");

    updateBadges(payload.count ?? 0);

    if (!itemsContainer || !emptyState || !content) {
        return;
    }

    if (!payload.items?.length) {
        emptyState.classList.remove("d-none");
        content.classList.add("d-none");
        itemsContainer.innerHTML = "";

        if (totalEl) {
            totalEl.textContent = formatMoney(0);
        }

        return;
    }

    emptyState.classList.add("d-none");
    content.classList.remove("d-none");

    itemsContainer.innerHTML = payload.items.map((item) => {
        const itemId = escapeHtml(item.id);
        const name = escapeHtml(item.name);
        const image = item.image
            ? `<img src="${escapeHtml(item.image)}" alt="${name}" class="cart-item-image rounded-3">`
            : `<div class="cart-item-placeholder rounded-3"></div>`;
        const description = [item.product_type, item.brand].filter(Boolean).map(escapeHtml).join(" · ");

        return `
            <article class="cart-item-card">
                <div class="d-flex gap-3">
                    ${image}
                    <div class="flex-grow-1 min-w-0">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div class="min-w-0">
                                <h3 class="cart-item-name">${name}</h3>
                                <p class="cart-item-description">${description}</p>
                            </div>
                            <button type="button" class="cart-remove-btn" data-cart-item-id="${itemId}"
                                aria-label="Remove ${name} from cart" title="Remove item">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"
                                    stroke-width="1.6" stroke-linecap="round" aria-hidden="true">
                                    <path d="M4 7h16M10 11v6m4-6v6M5 7l1 13h12l1-13M9 7V4h6v3" />
                                </svg>
                            </button>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="cart-quantity-control">
                                <button type="button" class="cart-quantity-step" data-cart-step="-1"
                                    data-cart-item-id="${itemId}" aria-label="Decrease quantity of ${name}"
                                    ${item.quantity <= 1 ? "disabled" : ""}>−</button>
                                <input type="number" min="1" max="${item.stock}" value="${item.quantity}"
                                    class="form-control cart-qty-input" data-cart-item-id="${itemId}"
                                    aria-label="Quantity of ${name}">
                                <button type="button" class="cart-quantity-step" data-cart-step="1"
                                    data-cart-item-id="${itemId}" aria-label="Increase quantity of ${name}"
                                    ${item.quantity >= item.stock ? "disabled" : ""}>+</button>
                            </div>
                            <span class="text-gold fw-semibold">${formatMoney(item.subtotal)}</span>
                        </div>
                        <p class="cart-item-unit-price">${formatMoney(item.unit_price)} each</p>
                    </div>
                </div>
            </article>
        `;
    }).join("");

    if (totalEl) {
        totalEl.textContent = formatMoney(payload.total ?? 0);
    }
};

const fetchCart = async () => {
    const { indexUrl } = getConfig();

    if (!indexUrl) {
        return;
    }

    const { data } = await window.axios.get(indexUrl);
    renderCart(data);
};

const addToCart = async (productType, productId, { openDrawer = true } = {}) => {
    const { storeUrl } = getConfig();

    if (!storeUrl) {
        throw new Error("Cart is unavailable.");
    }

    const { data } = await window.axios.post(storeUrl, {
        product_type: productType,
        product_id: productId,
        quantity: 1,
    });

    renderCart(data);
    showToast(data.message ?? "Product added to cart.");

    if (openDrawer) {
        window.bootstrap.Offcanvas.getOrCreateInstance(document.getElementById("cartDrawer")).show();
    }
};

const updateCartItem = async (cartItemId, quantity) => {
    const { indexUrl } = getConfig();

    const { data } = await window.axios.patch(`${indexUrl}/${cartItemId}`, {
        quantity,
    });

    renderCart(data);
    showToast(data.message ?? "Cart updated.");
};

const removeCartItem = async (cartItemId) => {
    const { indexUrl } = getConfig();

    const { data } = await window.axios.delete(`${indexUrl}/${cartItemId}`);

    renderCart(data);
    showToast(data.message ?? "Item removed.");
};

const saveDelivery = async (customerDetails) => {
    const { deliveryUrl } = getConfig();

    if (!deliveryUrl) {
        throw new Error("Checkout is unavailable.");
    }

    const { data } = await window.axios.post(deliveryUrl, customerDetails);

    window.location.href = data.redirect;
};

const saveAddress = async (shippingAddress) => {
    const { data } = await window.axios.patch('/profile/address', {
        shipping_address: shippingAddress,
    });

    return data;
};

const bindAddressModalEvents = () => {
    const addressModal = document.getElementById('addressModal');
    const saveAddressBtn = document.getElementById('saveAddressBtn');
    const addressForm = document.getElementById('addressForm');

    if (!addressModal || !saveAddressBtn || !addressForm) {
        return;
    }

    saveAddressBtn.addEventListener('click', async () => {
        if (!addressForm.reportValidity()) {
            return;
        }

        saveAddressBtn.disabled = true;

        try {
            const { authenticated } = getConfig();
            const customerDetails = Object.fromEntries(new FormData(addressForm).entries());

            if (authenticated) {
                await saveAddress(customerDetails.shipping_address);
            }

            await saveDelivery(customerDetails);
        } catch (error) {
            showToast(
                error.response?.data?.message ?? "Unable to continue to payment.",
                true,
            );
            saveAddressBtn.disabled = false;
        }
    });
};

const bindCartEvents = () => {
    document.addEventListener("click", async (event) => {
        const addButton = event.target.closest(".add-to-cart-btn");

        if (addButton) {
            event.preventDefault();

            if (addButton.disabled) {
                return;
            }

            try {
                await addToCart(
                    addButton.dataset.productType,
                    addButton.dataset.productId,
                );
            } catch (error) {
                showToast(
                    error.response?.data?.message ?? "Unable to add item to cart.",
                    true,
                );
            }

            return;
        }

        const orderNowButton = event.target.closest(".order-now-btn");

        if (orderNowButton) {
            event.preventDefault();

            if (orderNowButton.disabled) {
                return;
            }

            orderNowButton.disabled = true;

            try {
                await addToCart(
                    orderNowButton.dataset.productType,
                    orderNowButton.dataset.productId,
                    { openDrawer: false },
                );

                const addressModal = new window.bootstrap.Modal(document.getElementById('addressModal'));
                addressModal.show();
            } catch (error) {
                showToast(
                    error.response?.data?.message ?? "Unable to add item to cart.",
                    true,
                );
            } finally {
                orderNowButton.disabled = false;
            }

            return;
        }

        const removeButton = event.target.closest(".cart-remove-btn");

        if (removeButton) {
            event.preventDefault();

            try {
                await removeCartItem(removeButton.dataset.cartItemId);
            } catch (error) {
                showToast(
                    error.response?.data?.message ?? "Unable to remove item.",
                    true,
                );
            }

            return;
        }

        const quantityStep = event.target.closest(".cart-quantity-step");

        if (quantityStep) {
            event.preventDefault();
            const input = document.querySelector(
                `.cart-qty-input[data-cart-item-id="${CSS.escape(quantityStep.dataset.cartItemId)}"]`,
            );
            const nextQuantity = Number(input?.value) + Number(quantityStep.dataset.cartStep);

            if (!input || nextQuantity < 1 || nextQuantity > Number(input.max)) {
                return;
            }

            try {
                await updateCartItem(quantityStep.dataset.cartItemId, nextQuantity);
            } catch (error) {
                showToast(error.response?.data?.message ?? "Unable to update quantity.", true);
            }

            return;
        }

        const checkoutButton = event.target.closest("#checkout-btn");

        if (checkoutButton) {
            event.preventDefault();

            const addressModal = new window.bootstrap.Modal(document.getElementById('addressModal'));
            addressModal.show();
        }
    });

    document.addEventListener(
        "change",
        async (event) => {
            const quantityInput = event.target.closest(".cart-qty-input");

            if (!quantityInput) {
                return;
            }

            try {
                await updateCartItem(
                    quantityInput.dataset.cartItemId,
                    Number(quantityInput.value),
                );
            } catch (error) {
                showToast(
                    error.response?.data?.message ?? "Unable to update quantity.",
                    true,
                );
                await fetchCart();
            }
        },
        true,
    );
};

export const initCart = () => {
    const config = getConfig();

    if (!config.indexUrl && !config.storeUrl) {
        return;
    }

    bindCartEvents();
    bindAddressModalEvents();
    fetchCart().catch((error) => {
        showToast(error.response?.data?.message ?? "Unable to load your cart.", true);
    });
};
