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
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .product-card {
            transition: all 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .product-card:hover .product-image img {
            transform: scale(1.05);
        }
        .product-image img {
            transition: transform 0.5s ease;
        }
        .product-name {
            transition: color 0.2s ease;
        }
        .product-card:hover .product-name {
            color: #3b82f6;
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo-area">
                <img src="{{ asset('images/logo.png') }}" alt="Tiny Flowers" style="width: 40px; height: 40px; object-fit: contain; margin-right: 10px;">
                <span class="brand-name">Tiny Flowers</span>
            </a>

            <nav class="main-nav">
                <a href="{{ route('shop', ['category' => 'Sale']) }}" class="nav-link sale {{ request('category') == 'Sale' ? 'active' : '' }}">SALE</a>
                @foreach($globalCategories as $gCat)
                    @if($gCat->children->count() > 0)
                        <div class="nav-item-dropdown" style="position: relative; display: inline-block;">
                            <a href="{{ route('shop', ['category' => $gCat->name]) }}" class="nav-link {{ request('category') == $gCat->name ? 'active' : '' }}">{{ $gCat->name }}</a>
                            <div class="nav-dropdown-content" style="display: none; position: absolute; top: 100%; left: 0; background: white; min-width: 150px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); border-radius: 8px; padding: 10px 0; z-index: 1000;">
                                @foreach($gCat->children as $child)
                                    <a href="{{ route('shop', ['category' => $child->name]) }}" style="display: block; padding: 8px 20px; color: #334155; text-decoration: none; font-size: 14px; transition: background 0.2s;">{{ $child->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ route('shop', ['category' => $gCat->name]) }}" class="nav-link {{ request('category') == $gCat->name ? 'active' : '' }}">{{ $gCat->name }}</a>
                    @endif
                @endforeach
            </nav>
            <style>
                .nav-item-dropdown::after { content: ''; position: absolute; top: 100%; left: 0; right: 0; height: 15px; background: transparent; }
                .nav-item-dropdown:hover .nav-dropdown-content { display: block !important; animation: fadeIn 0.2s ease-in-out; }
                .nav-dropdown-content a:hover { background: #f1f5f9; color: #0f172a !important; }
            </style>

            <div class="header-actions">
                <div class="search-bar">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" placeholder="Tìm sản phẩm..." class="search-input">
                </div>
                <div class="auth-group">
                    @auth
                        @php
                            $user = Auth::user();
                            $avatarUrl = $user->profile_picture 
                                ? asset('images/avatars/' . $user->profile_picture) 
                                : 'https://ui-avatars.com/api/?name=' . urlencode($user->fullname) . '&background=000&color=fff';
                            $firstNameParts = explode(' ', trim($user->fullname));
                            $firstName = end($firstNameParts);
                        @endphp
                        <div class="user-profile-dropdown" style="position: relative; display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 5px; border-radius: 20px; transition: background 0.3s;">
                            <img src="{{ $avatarUrl }}" alt="{{ $user->fullname }}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid #e2e8f0;">
                            <span style="font-weight: 600; font-size: 14px; color: #1e293b;">{{ $firstName }}</span>
                            <i class="fas fa-chevron-down" style="font-size: 10px; color: #64748b; margin-left: 2px;"></i>
                            
                            <div class="dropdown-content" style="display: none; position: absolute; top: 100%; right: 0; background: white; min-width: 220px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); border-radius: 12px; padding: 12px; z-index: 1000; margin-top: 15px; border: 1px solid #f1f5f9;">
                                <div style="padding: 8px 12px; border-bottom: 1px solid #f1f5f9; margin-bottom: 8px;">
                                    <div style="font-weight: 600; font-size: 14px; color: #0f172a;">{{ $user->fullname }}</div>
                                    <div style="font-size: 12px; color: #64748b; margin-top: 2px;">{{ $user->email }}</div>
                                </div>
                                @if($user->role === 'admin' || $user->role === 'staff')
                                    <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #334155; text-decoration: none; font-size: 14px; border-radius: 8px; transition: all 0.2s;"><i class="fas fa-chart-line" style="width: 20px; text-align: center; color: #64748b;"></i> Quản trị</a>
                                @endif
                                <a href="{{ route('profile.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #334155; text-decoration: none; font-size: 14px; border-radius: 8px; transition: all 0.2s;"><i class="far fa-user" style="width: 20px; text-align: center; color: #64748b;"></i> Hồ sơ</a>
                                <a href="{{ route('profile.orders') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #334155; text-decoration: none; font-size: 14px; border-radius: 8px; transition: all 0.2s;"><i class="fas fa-shopping-bag" style="width: 20px; text-align: center; color: #64748b;"></i> Đơn hàng</a>
                                <a href="{{ route('profile.favorites') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #334155; text-decoration: none; font-size: 14px; border-radius: 8px; transition: all 0.2s;"><i class="fas fa-heart" style="width: 20px; text-align: center; color: #ef4444;"></i> Yêu thích</a>
                                <a href="{{ route('logout') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #ef4444; text-decoration: none; font-size: 14px; border-radius: 8px; transition: all 0.2s; margin-top: 5px; border-top: 1px solid #f1f5f9; padding-top: 12px;"><i class="fas fa-sign-out-alt" style="width: 20px; text-align: center;"></i> Đăng xuất</a>
                            </div>
                        </div>
                        <style>
                            .user-profile-dropdown::after {
                                content: '';
                                position: absolute;
                                top: 100%;
                                left: 0;
                                right: 0;
                                height: 20px;
                                background: transparent;
                            }
                            .user-profile-dropdown:hover {
                                background: #f8fafc;
                            }
                            .user-profile-dropdown:hover .dropdown-content {
                                display: block !important;
                                animation: fadeIn 0.2s ease-in-out;
                            }
                            .dropdown-content a:hover {
                                background: #f1f5f9;
                                color: #0f172a !important;
                            }
                            .dropdown-content a:hover i {
                                color: #0f172a !important;
                            }
                            @keyframes fadeIn {
                                from { opacity: 0; transform: translateY(10px); }
                                to { opacity: 1; transform: translateY(0); }
                            }
                        </style>
                    @else
                        <a href="{{ route('login') }}" class="auth-link">
                            <i class="far fa-user"></i>
                            <span>ĐĂNG NHẬP</span>
                        </a>
                    @endauth
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
                <div class="hero-content" data-aos="fade-right" data-aos-duration="1000">
                    <h1 class="hero-title">FORM CHUẨN GEN Z <br><span>TINY FLOWERS</span></h1>
                    <p class="hero-description">
                        BST Streetwear cao cấp dành riêng cho giới trẻ Việt. Tinh tế từ chất liệu Cotton 100% đến từng đường may Boxy chuẩn phom dáng.
                    </p>
                    <a href="{{ route('shop') }}" class="btn-cta">KHÁM PHÁ NGAY</a>
                </div>
                <div class="hero-visual" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="form-card">
                        <div class="form-img">
                            <img src="{{ asset('images/p1.png') }}" alt="Form Boxy">
                        </div>
                        <div class="form-info">
                            <p class="form-id">F1 - FORM BOXY</p>
                            <p class="form-sub">(Dáng Hộp Chuẩn Trend)</p>
                        </div>
                    </div>
                    <div class="form-card" style="transform: translateY(30px);">
                        <div class="form-img">
                            <img src="{{ asset('images/p2.png') }}" alt="Form Baggy">
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
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">BST MỚI NHẤT</h2>
                <a href="{{ route('shop') }}" style="color: #64748b; font-weight: 700; font-size: 14px; text-decoration: none;">XEM TẤT CẢ <i class="fas fa-arrow-right"></i></a>
            </div>

            @php
                $userFavorites = [];
                if(Auth::check()) {
                    $userFavorites = Auth::user()->favorites()->pluck('product_id')->toArray();
                }
            @endphp
            <div class="product-grid">
                @forelse($products as $index => $product)
                    <div class="product-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <a href="{{ route('shop.show', $product->id) }}" style="text-decoration: none; color: inherit; display: block;">
                            <div class="product-image" style="position: relative;">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                @php $isFavorited = in_array($product->id, $userFavorites); @endphp
                                <button class="favorite-btn" onclick="event.preventDefault(); toggleFavorite({{ $product->id }}, this)" style="position: absolute; top: 10px; left: 10px; background: white; border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); color: {{ $isFavorited ? '#ef4444' : '#94a3b8' }}; z-index: 10; cursor: pointer; transition: all 0.2s;">
                                    <i class="{{ $isFavorited ? 'fas' : 'far' }} fa-heart" style="font-size: 16px;"></i>
                                </button>
                                <button class="add-cart-btn" onclick="event.preventDefault(); /* logic add to cart */">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="product-details">
                                <p class="product-category">{{ $product->category->name ?? 'FASHION' }}</p>
                                <h3 class="product-name">{{ $product->name }}</h3>
                                <p class="product-price">{{ number_format($product->selling_price) }}đ</p>
                            </div>
                        </a>
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
        <section class="video-lookbook-section" data-aos="zoom-in" data-aos-duration="1000">
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
        <section class="style-explorer-section" data-aos="fade-up" data-aos-duration="1000">
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
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({
                duration: 800,
                once: true,
                offset: 100
            });

            function toggleFavorite(productId, btnElement) {
                fetch(`{{ url('favorites') }}/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (response.status === 401) {
                        window.location.href = "{{ route('login') }}";
                        return Promise.reject('Unauthorized');
                    }
                    return response.json();
                })
                .then(data => {
                    if(data.status === 'success') {
                        if (data.action === 'added') {
                            btnElement.style.color = '#ef4444';
                            btnElement.querySelector('i').classList.remove('far');
                            btnElement.querySelector('i').classList.add('fas');
                        } else {
                            btnElement.style.color = '#94a3b8';
                            btnElement.querySelector('i').classList.remove('fas');
                            btnElement.querySelector('i').classList.add('far');
                        }
                    } else if(data.redirect) {
                        window.location.href = data.redirect;
                    }
                })
                .catch(error => console.error('Error:', error));
            }
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
