<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Tiny Flowers</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo-area">
                <div class="logo-circle">TF</div>
                <span class="brand-name">Tiny Flowers</span>
            </a>

            <nav class="main-nav">
                <a href="{{ route('shop', ['category' => 'Sale']) }}" class="nav-link sale {{ request('category') == 'Sale' ? 'active' : '' }}">SALE</a>
                <a href="{{ route('shop', ['category' => 'Trang phục']) }}" class="nav-link {{ request('category') == 'Trang phục' ? 'active' : '' }}">Trang phục</a>
                <a href="{{ route('shop', ['category' => 'Áo']) }}" class="nav-link {{ request('category') == 'Áo' ? 'active' : '' }}">Áo</a>
                <a href="{{ route('shop', ['category' => 'Quần']) }}" class="nav-link {{ request('category') == 'Quần' ? 'active' : '' }}">Quần</a>
                <a href="{{ route('shop', ['category' => 'Phụ kiện']) }}" class="nav-link {{ request('category') == 'Phụ kiện' ? 'active' : '' }}">Phụ kiện</a>
            </nav>

            <div class="header-actions">
                <form action="{{ route('shop') }}" method="GET" class="search-bar">
                    <button type="submit" style="background: none; border: none; cursor: pointer; display: flex; align-items: center;"><i class="fas fa-search search-icon"></i></button>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm sản phẩm..." class="search-input">
                </form>
                <div class="auth-group">
                    <a href="{{ route('login') }}" class="auth-link">
                        <i class="far fa-user"></i>
                        <span>ĐĂNG NHẬP</span>
                    </a>
                </div>
                <div class="cart-wrapper">
                    <button class="cart-btn">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="cart-label">GIỎ HÀNG</span>
                        <span class="badge-count">0</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div class="shop-header">
        <div class="breadcrumb">Cửa hàng / {{ $title }}</div>
        <h1 class="shop-title">{{ $title }}</h1>
    </div>

    <div class="shop-container">
        <div class="shop-filters">
            <div class="filter-group">
                <a href="{{ route('shop') }}" class="filter-btn {{ !request('category') ? 'active' : '' }}">Tất cả</a>
                <a href="#" class="filter-btn">Phổ biến</a>
                <a href="#" class="filter-btn">Mới nhất</a>
            </div>
            <div class="filter-group">
                <span style="font-size: 14px; color: #94a3b8;">Hiển thị {{ $products->count() }} sản phẩm</span>
            </div>
        </div>

        <div class="product-grid">
            @foreach($products as $product)
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    </div>
                    <div class="product-details">
                        <p class="product-category">{{ $product->category->name ?? 'FASHION' }}</p>
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <div class="price-cart-row">
                            <p class="product-price">{{ number_format($product->selling_price) }}đ</p>
                            <button class="add-to-cart-box" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->selling_price }}" data-image="{{ $product->image_url }}">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination-area">
            {{ $products->appends(request()->query())->links('vendor.pagination.custom') }}
        </div>
    </div>

    <footer class="main-footer">
        <div class="footer-grid">
            <div class="footer-col">
                <a href="{{ route('home') }}" class="logo-area" style="color: white; margin-bottom: 20px; display: inline-flex;">
                    <div class="logo-circle">TF</div>
                    <span class="brand-name">Tiny Flowers</span>
                </a>
                <p style="color: #94a3b8; font-size: 14px; line-height: 1.8;">
                    Thương hiệu thời trang Streetwear hàng đầu dành cho Gen Z. Chúng tôi mang đến sự tự tin và phong cách qua từng sản phẩm được thiết kế tỉ mỉ.
                </p>
                <div style="display: flex; gap: 15px; margin-top: 25px;">
                    <a href="#" style="color: white; font-size: 20px;"><i class="fab fa-facebook"></i></a>
                    <a href="#" style="color: white; font-size: 20px;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="color: white; font-size: 20px;"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>CHÍNH SÁCH</h4>
                <ul class="footer-links">
                    <li><a href="#">Chính sách đổi trả</a></li>
                    <li><a href="#">Chính sách bảo hành</a></li>
                    <li><a href="#">Chính sách vận chuyển</a></li>
                    <li><a href="#">Câu hỏi thường gặp</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>VỀ CHÚNG TÔI</h4>
                <ul class="footer-links">
                    <li><a href="#">Câu chuyện thương hiệu</a></li>
                    <li><a href="#">Liên hệ</a></li>
                    <li><a href="#">Tuyển dụng</a></li>
                    <li><a href="#">Hệ thống cửa hàng</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>ĐĂNG KÝ NHẬN TIN</h4>
                <p style="color: #94a3b8; font-size: 13px; margin-bottom: 15px;">Nhận thông báo về các BST mới nhất và ưu đãi đặc quyền.</p>
                <div style="display: flex; gap: 10px;">
                    <input type="email" placeholder="Email của bạn..." style="flex: 1; padding: 10px 15px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); color: white; outline: none;">
                    <button style="background: white; color: black; border: none; padding: 0 20px; border-radius: 8px; font-weight: 700; cursor: pointer;">GỬI</button>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Tiny Flowers. All rights reserved.</p>
            <p>Made with <i class="fas fa-heart" style="color: #ef4444;"></i> in Vietnam</p>
        </div>
    </footer>

    <!-- Cart Sidebar Overlay -->
    <div class="cart-overlay"></div>
    
    <!-- Cart Sidebar -->
    <div class="cart-sidebar">
        <div class="cart-sidebar-header">
            <h2>GIỎ HÀNG</h2>
            <button class="close-cart-btn"><i class="fas fa-times"></i></button>
        </div>
        <div class="cart-items-container">
            <!-- Items will be injected here -->
        </div>
        <div class="cart-sidebar-footer">
            <div class="cart-total-row">
                <span>TỔNG TIỀN:</span>
                <span class="cart-total-amount">0đ</span>
            </div>
            <button class="checkout-btn">THANH TOÁN</button>
        </div>
    </div>

    <script>
        // Cart logic
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

        document.addEventListener('DOMContentLoaded', () => {
            updateCartUI();

            document.querySelectorAll('.add-to-cart-box').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const id = btn.getAttribute('data-id');
                    const name = btn.getAttribute('data-name');
                    const price = parseInt(btn.getAttribute('data-price'));
                    const image = btn.getAttribute('data-image');
                    addToCart(id, name, price, image);
                });
            });

            const cartBtn = document.querySelector('.cart-btn');
            const sidebar = document.querySelector('.cart-sidebar');
            const overlay = document.querySelector('.cart-overlay');
            const closeBtn = document.querySelector('.close-cart-btn');

            if(cartBtn) {
                cartBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    if(sidebar) sidebar.classList.add('active');
                    if(overlay) overlay.classList.add('active');
                });
            }

            const closeCart = () => {
                if(sidebar) sidebar.classList.remove('active');
                if(overlay) overlay.classList.remove('active');
            };

            if(closeBtn) closeBtn.addEventListener('click', closeCart);
            if(overlay) overlay.addEventListener('click', closeCart);
        });
    </script>
</body>
</html>
