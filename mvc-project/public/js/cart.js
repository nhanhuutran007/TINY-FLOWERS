// Cart management logic
let cart = JSON.parse(localStorage.getItem('tiny_flowers_cart')) || [];

function updateCartUI() {
    const badge = document.querySelector('.badge-count');
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    if(badge) badge.textContent = totalItems;

    const cartContainer = document.querySelector('.cart-items-container');
    const totalAmount = document.querySelector('.cart-total-amount');
    
    if(cartContainer) {
        cartContainer.innerHTML = '';
        let total = 0;

        if (cart.length === 0) {
            cartContainer.innerHTML = '<p style="text-align:center; color:#94a3b8; margin-top:20px;">Giỏ hàng trống</p>';
        } else {
            cart.forEach((item, index) => {
                total += item.price * item.quantity;
                cartContainer.innerHTML += `
                    <div class="cart-item">
                        <img src="${item.image}" class="cart-item-img" alt="${item.name}">
                        <div class="cart-item-info">
                            <div class="cart-item-name">${item.name}</div>
                            <div class="cart-item-price">${new Intl.NumberFormat('vi-VN').format(item.price)}đ</div>
                            <div class="cart-item-actions">
                                <div class="qty-wrapper">
                                    <button class="qty-btn" onclick="updateQty(${index}, -1)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line></svg></button>
                                    <span class="qty-display">${item.quantity}</span>
                                    <button class="qty-btn" onclick="updateQty(${index}, 1)"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></button>
                                </div>
                                <button class="remove-item-btn" onclick="removeItem(${index})"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        if(totalAmount) totalAmount.textContent = new Intl.NumberFormat('vi-VN').format(total) + 'đ';
    }
    localStorage.setItem('tiny_flowers_cart', JSON.stringify(cart));
}

function addToCart(id, name, price, image) {
    const existing = cart.find(item => item.id == id);
    if (existing) {
        existing.quantity += 1;
    } else {
        cart.push({ id, name, price, image, quantity: 1 });
    }
    updateCartUI();
    const sidebar = document.querySelector('.cart-sidebar');
    const overlay = document.querySelector('.cart-overlay');
    if(sidebar) sidebar.classList.add('active');
    if(overlay) overlay.classList.add('active');
}

window.updateQty = function(index, change) {
    cart[index].quantity += change;
    if (cart[index].quantity <= 0) {
        cart.splice(index, 1);
    }
    updateCartUI();
};

window.removeItem = function(index) {
    cart.splice(index, 1);
    updateCartUI();
};
