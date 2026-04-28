// Product detail page logic
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('add-to-cart-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!window.PRODUCT_DATA) return;

            const qty = parseInt(document.getElementById('qty').value) || 1;
            const id = window.PRODUCT_DATA.id;
            const name = window.PRODUCT_DATA.name;
            const price = window.PRODUCT_DATA.price;
            const image = window.PRODUCT_DATA.image;

            // Use the global cart array from the layout
            if (typeof cart !== 'undefined') {
                const existing = cart.find(item => item.id == id);
                if (existing) {
                    existing.quantity += qty;
                } else {
                    cart.push({ id, name, price, image, quantity: qty });
                }
                if (typeof updateCartUI === 'function') {
                    updateCartUI();
                }

                const sidebar = document.querySelector('.cart-sidebar');
                const overlay = document.querySelector('.cart-overlay');
                if (sidebar) sidebar.classList.add('active');
                if (overlay) overlay.classList.add('active');

                // Visual feedback on button
                const btn = form.querySelector('button[type="submit"]');
                if (btn) {
                    const original = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-check"></i> ĐÃ THÊM VÀO GIỎ';
                    btn.style.background = '#22c55e';
                    setTimeout(() => {
                        btn.innerHTML = original;
                        btn.style.background = '';
                    }, 1500);
                }
            }
        });
    }
});

function decreaseQty() {
    const input = document.getElementById('qty');
    if (input && input.value > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function increaseQty() {
    const input = document.getElementById('qty');
    if (input) {
        const max = parseInt(input.getAttribute('max')) || 999;
        if (input.value < max) {
            input.value = parseInt(input.value) + 1;
        }
    }
}

function toggleFavorite(productId, btnElement) {
    if (!window.TF_CONFIG) return;

    fetch(window.TF_CONFIG.favoritesToggleUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': window.TF_CONFIG.csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => {
        if (response.status === 401) {
            window.location.href = window.TF_CONFIG.loginUrl;
            return Promise.reject('Unauthorized');
        }
        return response.json();
    })
    .then(data => {
        if(data.success) {
            const icon = btnElement.querySelector('i');
            if (data.action === 'added') {
                btnElement.classList.add('active');
                icon.classList.remove('far');
                icon.classList.add('fas');
            } else {
                btnElement.classList.remove('active');
                icon.classList.remove('fas');
                icon.classList.add('far');
            }
        }
    })
    .catch(error => console.error('Error:', error));
}

// Make functions global for onclick handlers
window.decreaseQty = decreaseQty;
window.increaseQty = increaseQty;
window.toggleFavorite = toggleFavorite;
