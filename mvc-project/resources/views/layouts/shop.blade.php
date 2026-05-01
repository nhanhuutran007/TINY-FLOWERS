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
    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">
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
                
                @foreach($globalCategories as $cat)
                    @if($cat->children->count() > 0)
                        <div class="nav-item-dropdown">
                            <a href="{{ route('shop', ['category' => $cat->name]) }}" class="nav-link {{ request('category') == $cat->name ? 'active' : '' }}">
                                {{ $cat->name }} <i class="fas fa-chevron-down" style="font-size: 10px; margin-left: 4px;"></i>
                            </a>
                            <div class="dropdown-menu-custom">
                                @foreach($cat->children as $child)
                                    <a href="{{ route('shop', ['category' => $child->name]) }}">{{ $child->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ route('shop', ['category' => $cat->name]) }}" class="nav-link {{ request('category') == $cat->name ? 'active' : '' }}">{{ $cat->name }}</a>
                    @endif
                @endforeach

                <a href="{{ route('profile.favorites') }}" class="nav-link {{ request()->routeIs('profile.favorites') ? 'active' : '' }}">Yêu thích</a>
            </nav>

            <style>
                .nav-item-dropdown {
                    position: relative;
                    display: inline-block;
                }
                .dropdown-menu-custom {
                    display: none;
                    position: absolute;
                    top: 100%;
                    left: 50%;
                    transform: translateX(-50%);
                    background-color: white;
                    min-width: 180px;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
                    border-radius: 12px;
                    padding: 10px 0;
                    z-index: 1000;
                    border: 1px solid #f1f5f9;
                    margin-top: 10px;
                }
                .dropdown-menu-custom::before {
                    content: '';
                    position: absolute;
                    top: -6px;
                    left: 50%;
                    transform: translateX(-50%) rotate(45deg);
                    width: 12px;
                    height: 12px;
                    background: white;
                    border-left: 1px solid #f1f5f9;
                    border-top: 1px solid #f1f5f9;
                }
                .dropdown-menu-custom a {
                    color: #475569;
                    padding: 10px 20px;
                    text-decoration: none;
                    display: block;
                    font-size: 14px;
                    font-weight: 500;
                    transition: all 0.2s;
                }
                .dropdown-menu-custom a:hover {
                    background-color: #f8fafc;
                    color: #319DFF;
                    padding-left: 25px;
                }
                .nav-item-dropdown:hover .dropdown-menu-custom {
                    display: block;
                    animation: fadeIn 0.2s ease-out;
                }
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateX(-50%) translateY(10px); }
                    to { opacity: 1; transform: translateX(-50%) translateY(0); }
                }
            </style>

            <div class="header-actions">
                <form action="{{ route('shop') }}" method="GET" class="search-bar">
                    <button type="submit" style="background: none; border: none; cursor: pointer; display: flex; align-items: center;"><i class="fas fa-search search-icon"></i></button>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm sản phẩm..." class="search-input">
                </form>
                <div class="auth-group">
                    @if(Auth::check())
                        <div class="user-menu-container">
                            <button class="user-avatar-btn" id="userMenuBtn">
                                <img src="{{ Auth::user()->profile_picture ? asset('images/avatars/' . Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->fullname) . '&background=319DFF&color=fff' }}" alt="Avatar">
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

    <!-- Chatbot Assistant -->
    <div id="chatbot-launcher">
        TF
    </div>

    <div id="chatbot-window">
        <div class="chatbot-header">
            <div class="chatbot-header-info">
                <div class="chatbot-avatar">TF</div>
                <div class="chatbot-name">
                    <h4>TF Assistant</h4>
                    <span>Trực tuyến</span>
                </div>
            </div>
            <div class="chatbot-close">
                <i class="fas fa-times"></i>
            </div>
        </div>

        <div id="chatbot-content">
            <div class="message bot">
                Chào mừng bạn đến với TINY FLOWERS! Tôi có thể giúp gì cho bạn?
            </div>
            <div class="typing" id="chatbot-typing">
                <span></span><span></span><span></span>
            </div>
        </div>

        <div class="chatbot-options" id="chatbot-options">
            <button class="option-btn" data-question="Sản phẩm còn hàng không?" data-answer="Tất cả sản phẩm hiển thị trên website đều đang có sẵn tại kho bạn nhé. Bạn có thể đặt mua ngay!">Sản phẩm còn hàng không?</button>
            <button class="option-btn" data-question="Thời gian giao hàng bao lâu?" data-answer="Shop hỗ trợ giao hàng toàn quốc với thời gian từ 2-4 ngày làm việc tùy khu vực ạ.">Thời gian giao hàng bao lâu?</button>
            <button class="option-btn" data-question="Chính sách đổi trả thế nào?" data-answer="Bạn có thể đổi trả sản phẩm trong vòng 7 ngày nếu còn nguyên tem mác và chưa qua sử dụng ạ.">Chính sách đổi trả thế nào?</button>
        </div>
    </div>

    <script>
        window.TF_CONFIG = {
            favoritesToggleUrl: '{{ route('favorites.toggle') }}',
            csrfToken: '{{ csrf_token() }}',
            loginUrl: '{{ route('login') }}'
        };
    </script>
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/chatbot.js') }}"></script>
    <script src="{{ asset('js/shop-init.js') }}"></script>
    @yield('scripts')
</body>
</html>
