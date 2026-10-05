const formatMoney = (amount) =>
    `$${Number(amount).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

const getConfig = () => {
    const body = document.body;

    return {
        indexUrl: body.dataset.cartIndex ?? null,
        storeUrl: body.dataset.cartStore ?? null,
        checkoutUrl: body.dataset.checkoutStore ?? null,
        loginUrl: body.dataset.loginUrl ?? null,
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
    ["cart-count-badge", "cart-count-badge-mobile"].forEach((id) => {
        const badge = document.getElementById(id);

        if (!badge) {
            return;
        }

        badge.textContent = String(count);
        badge.hidden = count < 1;
    });
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

    itemsContainer.innerHTML = payload.items
        .map(
            (item) => `
            <tr data-cart-item-id="${item.id}">
                <td>
                    <div class="d-flex align-items-center gap-3">
                        ${
                            item.image
                                ? `<img src="${item.image}" alt="${item.name}" class="cart-item-image rounded-3">`
                                : `<div class="cart-item-placeholder rounded-3"></div>`
                        }
                        <div>
                            <p class="text-white mb-0 fw-semibold">${item.name}</p>
                            <p class="text-muted-raven small mb-0">${item.product_type}${item.brand ? ` · ${item.brand}` : ""}</p>
                        </div>
                    </div>
                </td>
                <td class="text-gold">${formatMoney(item.unit_price)}</td>
                <td>
                    <input type="number" min="1" max="${item.stock}" value="${item.quantity}"
                        class="form-control input-dark rounded-3 cart-qty-input" style="width: 5rem"
                        data-cart-item-id="${item.id}">
                </td>
                <td class="text-gold fw-semibold cart-item-subtotal">${formatMoney(item.subtotal)}</td>
                <td>
                    <button type="button" class="btn btn-filter btn-sm rounded-pill cart-remove-btn"
                        data-cart-item-id="${item.id}">Remove</button>
                </td>
            </tr>
        `,
        )
        .join("");

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

const addToCart = async (productType, productId) => {
    const { storeUrl, loginUrl } = getConfig();

    if (!storeUrl) {
        window.location.href = loginUrl ?? "/login";

        return;
    }

    const { data } = await window.axios.post(storeUrl, {
        product_type: productType,
        product_id: productId,
        quantity: 1,
    });

    renderCart(data);
    showToast(data.message ?? "Product added to cart.");
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

const checkout = async (shippingAddress = null) => {
    const { checkoutUrl } = getConfig();

    if (!checkoutUrl) {
        return;
    }

    const { data } = await window.axios.post(checkoutUrl, shippingAddress ? { shipping_address: shippingAddress } : {});

    renderCart(data);
    showToast(data.message ?? "Order placed successfully.");
};

const saveAddress = async (shippingAddress) => {
    try {
        const { data } = await window.axios.patch('/profile/address', {
            shipping_address: shippingAddress,
        });
        return data;
    } catch (error) {
        throw error;
    }
};

const bindAddressModalEvents = () => {
    const addressModal = document.getElementById('addressModal');
    const saveAddressBtn = document.getElementById('saveAddressBtn');
    const addressForm = document.getElementById('addressForm');
    const shippingAddressInput = document.getElementById('shippingAddress');

    if (!addressModal || !saveAddressBtn) {
        return;
    }

    saveAddressBtn.addEventListener('click', async () => {
        if (!shippingAddressInput.value.trim()) {
            showToast('Please enter a shipping address.', true);
            return;
        }

        saveAddressBtn.disabled = true;

        try {
            await saveAddress(shippingAddressInput.value);

            // Close modal
            const modal = window.bootstrap.Modal.getInstance(addressModal);
            if (modal) {
                modal.hide();
            }

            // Show success and proceed to checkout
            showToast('Address saved successfully!');
            await new Promise((resolve) => setTimeout(resolve, 500));

            try {
                await checkout();
            } catch (error) {
                showToast(
                    error.response?.data?.message ?? "Checkout failed.",
                    true,
                );
            }
        } catch (error) {
            showToast(
                error.response?.data?.message ?? "Unable to save address.",
                true,
            );
        } finally {
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

        const checkoutButton = event.target.closest("#checkout-btn");

        if (checkoutButton) {
            event.preventDefault();
            checkoutButton.disabled = true;

            try {
                await checkout();
            } catch (error) {
                if (error.response?.status === 422 && error.response?.data?.requires_address) {
                    showToast(error.response?.data?.message ?? "Please add a shipping address.");
                    const addressModal = new window.bootstrap.Modal(document.getElementById('addressModal'));
                    addressModal.show();
                } else {
                    showToast(
                        error.response?.data?.message ?? "Checkout failed.",
                        true,
                    );
                }
            } finally {
                checkoutButton.disabled = false;
            }
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
    fetchCart().catch(() => {});
};
