<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Tiny Flowers</title>
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
                        <button class="add-cart-btn"><i class="fas fa-plus"></i></button>
                    </div>
                    <div class="product-details">
                        <p class="product-category">{{ $product->category->name ?? 'FASHION' }}</p>
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <p class="product-price">{{ number_format($product->selling_price) }}đ</p>
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
</body>
</html>
