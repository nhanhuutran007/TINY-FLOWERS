// Shop initialization and general listeners
document.addEventListener('DOMContentLoaded', () => {
    // Update Cart UI on load
    if (typeof updateCartUI === 'function') {
        updateCartUI();
    }

    // Add to cart button listeners
    document.querySelectorAll('.add-to-cart-box').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const id = btn.getAttribute('data-id');
            const name = btn.getAttribute('data-name');
            const price = parseInt(btn.getAttribute('data-price'));
            const image = btn.getAttribute('data-image');
            if (typeof addToCart === 'function') {
                addToCart(id, name, price, image);
            }
        });
    });

    // Cart Sidebar toggle
    const cartBtn = document.querySelector('.cart-btn');
    const sidebar = document.querySelector('.cart-sidebar');
    const overlay = document.querySelector('.cart-overlay');
    const closeBtn = document.querySelector('.close-cart-btn');

    const openCart = (e) => {
        if(e) e.preventDefault();
        if(sidebar) sidebar.classList.add('active');
        if(overlay) overlay.classList.add('active');
    };

    const closeCart = () => {
        if(sidebar) sidebar.classList.remove('active');
        if(overlay) overlay.classList.remove('active');
    };

    if(cartBtn) cartBtn.addEventListener('click', openCart);
    if(closeBtn) closeBtn.addEventListener('click', closeCart);
    if(overlay) overlay.addEventListener('click', closeCart);

    // User Dropdown logic
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userDropdown = document.getElementById('userDropdown');

    if(userMenuBtn && userDropdown) {
        userMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdown.classList.toggle('active');
        });

        document.addEventListener('click', (e) => {
            if(!userMenuBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.remove('active');
            }
        });
    }

    // Wishlist toggle logic
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!window.TF_CONFIG) {
                console.error('TF_CONFIG is missing');
                return;
            }

            const productId = this.getAttribute('data-id');
            const icon = this.querySelector('i');
            
            // Handle URL with hostname if needed, but relative is usually fine
            let toggleUrl = window.TF_CONFIG.favoritesToggleUrl;
            
            fetch(toggleUrl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.TF_CONFIG.csrfToken
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => {
                if (response.status === 401) {
                    window.location.href = window.TF_CONFIG.loginUrl;
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (data && data.success) {
                    if (data.action === 'added') {
                        this.classList.add('active');
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        icon.style.color = '#ef4444';
                        this.style.transform = 'scale(1.2)';
                        setTimeout(() => this.style.transform = 'scale(1)', 200);
                    } else {
                        this.classList.remove('active');
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        icon.style.color = '#64748b';

                        // Nếu đang ở trang Yêu thích, xóa card khỏi UI
                        if (window.location.pathname.includes('/favorites')) {
                            const card = document.querySelector(`.favorite-item-${productId}`);
                            if (card) {
                                card.style.opacity = '0';
                                card.style.transform = 'scale(0.8)';
                                card.style.transition = 'all 0.3s ease';
                                
                                setTimeout(() => {
                                    card.remove();
                                    const grid = document.querySelector('.product-grid');
                                    if (grid && grid.querySelectorAll('.product-card').length === 0) {
                                        window.location.reload();
                                    }
                                }, 300);
                            }
                        }
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
