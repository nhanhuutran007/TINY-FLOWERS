<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiny Flowers - Fashion & Streetwear</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
                <div class="search-bar">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" placeholder="Tìm sản phẩm..." class="search-input">
                </div>
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

    <main>
        <section class="hero-section">
            <div class="hero-container">
                <div class="hero-content">
                    <h1 class="hero-title">FORM CHUẨN GEN Z <br><span>TINY FLOWERS</span></h1>
                    <p class="hero-description">
                        BST Streetwear cao cấp dành riêng cho giới trẻ Việt. Tinh tế từ chất liệu Cotton 100% đến từng đường may Boxy chuẩn phom dáng.
                    </p>
                    <a href="{{ route('shop') }}" class="btn-cta">KHÁM PHÁ NGAY</a>
                </div>
                <div class="hero-visual">
                    <div class="form-card">
                        <div class="form-img">
                            <img src="{{ asset('uploads/products/p1.png') }}" alt="Form Boxy">
                        </div>
                        <div class="form-info">
                            <p class="form-id">F1 - FORM BOXY</p>
                            <p class="form-sub">(Dáng Hộp Chuẩn Trend)</p>
                        </div>
                    </div>
                    <div class="form-card" style="transform: translateY(30px);">
                        <div class="form-img">
                            <img src="{{ asset('uploads/products/p2.png') }}" alt="Form Baggy">
                        </div>
                        <div class="form-info">
                            <p class="form-id">F2 - FORM BAGGY</p>
                            <p class="form-sub">(Dáng Rộng Thoải Mái)</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="products-section">
            <div class="section-header">
                <h2 class="section-title">BST MỚI NHẤT</h2>
                <a href="{{ route('shop') }}" style="color: #64748b; font-weight: 700; font-size: 14px; text-decoration: none;">XEM TẤT CẢ <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="product-grid">
                @forelse($products as $product)
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ Str::startsWith($product->image, 'source/') ? asset('images/' . $product->image) : asset('uploads/products/' . ($product->image ?: 'p1.png')) }}" alt="{{ $product->name }}">
                            <button class="add-cart-btn">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <div class="product-details">
                            <p class="product-category">{{ $product->category->name ?? 'FASHION' }}</p>
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <p class="product-price">{{ number_format($product->selling_price) }}đ</p>
                        </div>
                    </div>
                @empty
                    <!-- Placeholder products if DB is empty -->
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ asset('images/welcome/tshirt.png') }}" alt="Sample Product">
                            <button class="add-cart-btn"><i class="fas fa-plus"></i></button>
                        </div>
                        <div class="product-details">
                            <p class="product-category">T-SHIRT</p>
                            <h3 class="product-name">Áo Boxy Heavyweight Cream</h3>
                            <p class="product-price">350,000đ</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>
        <!-- Video Lookbook Section -->
        <section class="video-lookbook-section">
            <div class="section-header" style="text-align: center;">
                <h2 class="section-title">LOOKBOOK PHONG CÁCH</h2>
            </div>
            <div class="slider-container">
                <div class="slider-track" id="video-track">
                    <div class="slider-item video-item">
                        <video autoplay muted loop playsinline><source src="{{ asset('images/source/VideoLookbook/f1.mp4') }}" type="video/mp4"></video>
                    </div>
                    <div class="slider-item video-item">
                        <video autoplay muted loop playsinline><source src="{{ asset('images/source/VideoLookbook/f2.mp4') }}" type="video/mp4"></video>
                    </div>
                    <div class="slider-item video-item">
                        <video autoplay muted loop playsinline><source src="{{ asset('images/source/VideoLookbook/f3.mp4') }}" type="video/mp4"></video>
                    </div>
                    <div class="slider-item video-item">
                        <video autoplay muted loop playsinline><source src="{{ asset('images/source/VideoLookbook/f4.mp4') }}" type="video/mp4"></video>
                    </div>
                </div>
            </div>
        </section>

        <!-- Style Explorer Section -->
        <section class="style-explorer-section">
            <div class="section-header" style="text-align: center;">
                <h2 class="section-title">KHÁM PHÁ STYLE</h2>
            </div>
            <div class="slider-container">
                <div class="slider-track" id="style-track">
                    <div class="slider-item style-item">
                        <img src="{{ asset('images/source/WeekendVibesSection/minimal/f1.png') }}" alt="Minimal">
                    </div>
                    <div class="slider-item style-item">
                        <img src="{{ asset('images/source/WeekendVibesSection/relax/f1.png') }}" alt="Relax">
                    </div>
                    <div class="slider-item style-item">
                        <img src="{{ asset('images/source/WeekendVibesSection/sport/f1.png') }}" alt="Sport">
                    </div>
                    <div class="slider-item style-item">
                        <img src="{{ asset('images/source/StyleSetSection/f1.png') }}" alt="Street">
                    </div>
                    <div class="slider-item style-item">
                        <img src="{{ asset('images/source/WeekendVibesSection/minimal/f2.png') }}" alt="Minimal 2">
                    </div>
                    <div class="slider-item style-item">
                        <img src="{{ asset('images/source/WeekendVibesSection/relax/f2.png') }}" alt="Relax 2">
                    </div>
                </div>
            </div>
        </section>

        <script>
            function initSlider(trackId, speed = 1) {
                const track = document.getElementById(trackId);
                const container = track.parentElement;
                
                // Clone for infinite loop
                track.innerHTML += track.innerHTML;
                
                let scrollAmount = 0;
                let isPaused = false;
                const halfWidth = track.scrollWidth / 2;

                container.addEventListener('mouseenter', () => isPaused = true);
                container.addEventListener('mouseleave', () => isPaused = false);

                function step() {
                    if (!isPaused) {
                        scrollAmount += speed;
                        if (scrollAmount >= halfWidth) {
                            scrollAmount = 0;
                        }
                        track.style.transform = `translateX(-${scrollAmount}px)`;
                    }
                    requestAnimationFrame(step);
                }
                
                requestAnimationFrame(step);
            }

            window.addEventListener('load', () => {
                // Delay slightly to ensure images are fully rendered for width calculation
                setTimeout(() => {
                    initSlider('style-track', 0.8);
                }, 500);
            });
        </script>
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
</body>
</html>
