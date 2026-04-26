<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tiny Flowers - Fashion & Streetwear')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/user-dropdown.css') }}">
    @yield('styles')
</head>
<body>
    <header class="main-header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo-area">
                <div class="logo-circle" style="margin-right: 10px;">TF</div>
                <span class="brand-name">Tiny Flowers</span>
            </a>

            <nav class="main-nav">
                <a href="{{ route('shop', ['category' => 'Sale']) }}" class="nav-link sale {{ request('category') == 'Sale' ? 'active' : '' }}">SALE</a>
                <a href="{{ route('shop', ['category' => 'Trang phục']) }}" class="nav-link {{ request('category') == 'Trang phục' ? 'active' : '' }}">Trang phục</a>
                <a href="{{ route('shop', ['category' => 'Áo']) }}" class="nav-link {{ request('category') == 'Áo' ? 'active' : '' }}">Áo</a>
                <a href="{{ route('shop', ['category' => 'Quần']) }}" class="nav-link {{ request('category') == 'Quần' ? 'active' : '' }}">Quần</a>
                <a href="{{ route('shop', ['category' => 'Phụ kiện']) }}" class="nav-link {{ request('category') == 'Phụ kiện' ? 'active' : '' }}">Phụ kiện</a>
                <a href="{{ route('profile.favorites') }}" class="nav-link {{ request()->routeIs('profile.favorites') ? 'active' : '' }}">Yêu thích</a>
            </nav>

            <div class="header-actions">
                <form action="{{ route('shop') }}" method="GET" class="search-bar">
                    <button type="submit" style="background: none; border: none; cursor: pointer; display: flex; align-items: center;"><i class="fas fa-search search-icon"></i></button>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm sản phẩm..." class="search-input">
                </form>
                <div class="auth-group">
                    @if(Auth::check())
                        <div class="user-menu-container">
                            <button class="user-avatar-btn" id="userMenuBtn">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->fullname) }}&background=319DFF&color=fff" alt="Avatar">
                            </button>
                            <div class="user-dropdown-content" id="userDropdown">
                                <div class="dropdown-user-info">
                                    <strong>{{ Auth::user()->fullname }}</strong>
                                    <span>{{ Auth::user()->email }}</span>
                                </div>
                                <hr>
                                <a href="{{ route('profile.index') }}"><i class="fas fa-user-circle"></i> Hồ sơ của tôi</a>
                                <a href="{{ route('profile.orders') }}"><i class="fas fa-history"></i> Lịch sử đơn hàng</a>
                                <a href="{{ route('profile.password') }}"><i class="fas fa-key"></i> Đổi mật khẩu</a>
                                <hr>
                                <a href="{{ route('logout') }}" class="logout-link"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="auth-link">
                            <i class="far fa-user"></i>
                            <span>ĐĂNG NHẬP</span>
                        </a>
                    @endif
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

    <main>
        @yield('content')
    </main>

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
            <a href="{{ route('checkout') }}" class="checkout-btn" style="display:block; text-align:center; text-decoration:none;">THANH TOÁN</a>
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
                    const productId = this.getAttribute('data-id');
                    const icon = this.querySelector('i');
                    let toggleUrl = new URL('{{ route('favorites.toggle') }}');
                    toggleUrl.hostname = window.location.hostname;
                    toggleUrl.port = window.location.port;
                    toggleUrl.protocol = window.location.protocol;
                    
                    fetch(toggleUrl.toString(), {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ product_id: productId })
                    })
                    .then(response => {
                        if (response.status === 401) {
                            window.location.href = '{{ route('login') }}';
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
                                // Simple scale animation
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
                                        // Hiệu ứng ẩn card mượt mà
                                        card.style.opacity = '0';
                                        card.style.transform = 'scale(0.8)';
                                        card.style.transition = 'all 0.3s ease';
                                        
                                        setTimeout(() => {
                                            card.remove();
                                            
                                            // Kiểm tra nếu không còn sản phẩm nào trong lưới
                                            const grid = document.querySelector('.product-grid');
                                            if (grid && grid.querySelectorAll('.product-card').length === 0) {
                                                // Tải lại trang để hiển thị trạng thái "Danh sách trống"
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
    </script>
    @yield('scripts')
</body>
</html>
