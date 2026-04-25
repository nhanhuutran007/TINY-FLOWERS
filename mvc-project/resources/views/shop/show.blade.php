<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Tiny Flowers</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; }
        .main-header { background: #0f172a; position: sticky; top: 0; z-index: 50; }
        
        .product-detail-container {
            max-width: 1200px;
            margin: 40px auto 80px;
            padding: 0 20px;
        }

        .breadcrumb {
            margin-bottom: 24px;
            font-size: 14px;
            color: #64748b;
        }
        
        .breadcrumb a {
            color: #334155;
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .breadcrumb a:hover {
            color: #0f172a;
            text-decoration: underline;
        }

        .product-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
        }

        .product-image-wrapper {
            border-radius: 16px;
            overflow: hidden;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .product-image-wrapper img {
            width: 100%;
            height: auto;
            object-fit: contain;
            transition: transform 0.5s ease;
        }
        
        .product-image-wrapper:hover img {
            transform: scale(1.05);
        }

        .product-info {
            display: flex;
            flex-direction: column;
        }

        .product-category {
            font-size: 14px;
            font-weight: 600;
            color: #3b82f6;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .product-title {
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 16px;
            line-height: 1.2;
        }

        .product-price {
            font-size: 28px;
            font-weight: 700;
            color: #ef4444;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .product-price .original-price {
            font-size: 18px;
            color: #94a3b8;
            text-decoration: line-through;
            font-weight: 500;
        }

        .product-meta {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid #f1f5f9;
        }

        .meta-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            font-size: 15px;
        }

        .meta-label {
            color: #64748b;
            width: 120px;
            font-weight: 500;
        }

        .meta-value {
            color: #0f172a;
            font-weight: 600;
        }
        
        .stock-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        
        .status-in-stock {
            background: #ecfdf5;
            color: #10b981;
        }
        
        .status-out-stock {
            background: #fef2f2;
            color: #ef4444;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .quantity-label {
            font-weight: 600;
            color: #0f172a;
            margin-right: 20px;
        }

        .quantity-control {
            display: flex;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            background: white;
        }

        .qty-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: none;
            border: none;
            cursor: pointer;
            color: #475569;
            font-size: 16px;
            transition: all 0.2s;
        }

        .qty-btn:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .qty-input {
            width: 50px;
            height: 40px;
            border: none;
            border-left: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
            text-align: center;
            font-weight: 600;
            font-size: 15px;
            color: #0f172a;
        }

        .qty-input:focus {
            outline: none;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 16px;
        }

        .btn-add-cart {
            background: #0f172a;
            color: white;
            border: none;
            height: 56px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(15, 23, 42, 0.2);
        }

        .btn-add-cart:hover {
            background: #1e293b;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.3);
        }

        .btn-favorite {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            background: white;
            border: 2px solid #e2e8f0;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-favorite:hover {
            border-color: #ef4444;
            color: #ef4444;
            background: #fef2f2;
        }

        .delivery-info {
            margin-top: 40px;
            padding: 24px;
            background: #f8fafc;
            border-radius: 16px;
        }

        .delivery-item {
            display: flex;
            gap: 16px;
            margin-bottom: 16px;
        }
        
        .delivery-item:last-child {
            margin-bottom: 0;
        }

        .delivery-icon {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3b82f6;
            font-size: 18px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            flex-shrink: 0;
        }

        .delivery-text h4 {
            font-size: 15px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .delivery-text p {
            font-size: 13px;
            color: #64748b;
        }

        .related-products {
            margin-top: 80px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 30px;
            text-align: center;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }
        
        /* Dropdown fix style */
        .user-profile-dropdown::after { content: ''; position: absolute; top: 100%; left: 0; right: 0; height: 20px; background: transparent; }
        .user-profile-dropdown:hover .dropdown-content { display: block !important; animation: fadeIn 0.2s ease-in-out; }
        .dropdown-content a:hover { background: #f1f5f9; color: #0f172a !important; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        @media (max-width: 992px) {
            .product-layout { grid-template-columns: 1fr; }
            .related-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 576px) {
            .related-grid { grid-template-columns: 1fr; }
            .product-layout { padding: 20px; }
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo-area">
                <div class="logo-circle">TF</div>
                <span class="brand-name">Tiny Flowers</span>
            </a>

            <nav class="main-nav">
                <a href="{{ route('shop', ['category' => 'Sale']) }}" class="nav-link sale">SALE</a>
                @foreach($globalCategories as $gCat)
                    @if($gCat->children->count() > 0)
                        <div class="nav-item-dropdown" style="position: relative; display: inline-block;">
                            <a href="{{ route('shop', ['category' => $gCat->name]) }}" class="nav-link">{{ $gCat->name }}</a>
                            <div class="nav-dropdown-content" style="display: none; position: absolute; top: 100%; left: 0; background: white; min-width: 150px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); border-radius: 8px; padding: 10px 0; z-index: 1000;">
                                @foreach($gCat->children as $child)
                                    <a href="{{ route('shop', ['category' => $child->name]) }}" style="display: block; padding: 8px 20px; color: #334155; text-decoration: none; font-size: 14px; transition: background 0.2s;">{{ $child->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ route('shop', ['category' => $gCat->name]) }}" class="nav-link">{{ $gCat->name }}</a>
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
                            <span style="font-weight: 600; font-size: 14px; color: white;">{{ $firstName }}</span>
                            <i class="fas fa-chevron-down" style="font-size: 10px; color: #94a3b8; margin-left: 2px;"></i>
                            
                            <div class="dropdown-content" style="display: none; position: absolute; top: 100%; right: 0; background: white; min-width: 220px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); border-radius: 12px; padding: 12px; z-index: 1000; margin-top: 15px; border: 1px solid #f1f5f9;">
                                <div style="padding: 8px 12px; border-bottom: 1px solid #f1f5f9; margin-bottom: 8px;">
                                    <div style="font-weight: 600; font-size: 14px; color: #0f172a;">{{ $user->fullname }}</div>
                                    <div style="font-size: 12px; color: #64748b; margin-top: 2px;">{{ $user->email }}</div>
                                </div>
                                <a href="{{ route('profile.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #334155; text-decoration: none; font-size: 14px; border-radius: 8px; transition: all 0.2s;"><i class="far fa-user" style="width: 20px; text-align: center; color: #64748b;"></i> Hồ sơ</a>
                                <a href="{{ route('profile.orders') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #334155; text-decoration: none; font-size: 14px; border-radius: 8px; transition: all 0.2s;"><i class="fas fa-shopping-bag" style="width: 20px; text-align: center; color: #64748b;"></i> Đơn hàng</a>
                                <a href="{{ route('profile.favorites') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #334155; text-decoration: none; font-size: 14px; border-radius: 8px; transition: all 0.2s;"><i class="fas fa-heart" style="width: 20px; text-align: center; color: #ef4444;"></i> Yêu thích</a>
                                <a href="{{ route('logout') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #ef4444; text-decoration: none; font-size: 14px; border-radius: 8px; transition: all 0.2s; margin-top: 5px; border-top: 1px solid #f1f5f9; padding-top: 12px;"><i class="fas fa-sign-out-alt" style="width: 20px; text-align: center;"></i> Đăng xuất</a>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="auth-link">
                            <i class="far fa-user"></i>
                            <span>ĐĂNG NHẬP</span>
                        </a>
                    @endauth
                </div>
                <div class="cart-wrapper">
                    @php
                        $cartCount = 0;
                        if(session('cart')) {
                            foreach(session('cart') as $item) {
                                $cartCount += $item['quantity'];
                            }
                        }
                    @endphp
                    <a href="{{ route('cart.index') }}" class="cart-btn" style="text-decoration: none; color: inherit;">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="cart-label">GIỎ HÀNG</span>
                        <span class="badge-count">{{ $cartCount }}</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="product-detail-container">
        <div class="breadcrumb" data-aos="fade-right">
            <a href="{{ route('home') }}">Trang chủ</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 8px;"></i>
            <a href="{{ route('shop') }}">Cửa hàng</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 8px;"></i>
            @if($product->category)
                <a href="{{ route('shop', ['category' => $product->category->name]) }}">{{ $product->category->name }}</a>
                <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 8px;"></i>
            @endif
            <span>{{ $product->name }}</span>
        </div>

        <div class="product-layout" data-aos="fade-up">
            <div class="product-image-wrapper">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                @if($product->cost_price > $product->selling_price)
                    <div style="position: absolute; top: 20px; left: 20px; background: #ef4444; color: white; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 14px;">
                        -{{ round((($product->cost_price - $product->selling_price) / $product->cost_price) * 100) }}%
                    </div>
                @endif
            </div>

            <div class="product-info">
                @if($product->category)
                    <div class="product-category">{{ $product->category->name }}</div>
                @endif
                <h1 class="product-title">{{ $product->name }}</h1>
                
                <div class="product-price">
                    {{ number_format($product->selling_price, 0, ',', '.') }}đ
                    @if($product->cost_price > $product->selling_price)
                        <span class="original-price">{{ number_format($product->cost_price, 0, ',', '.') }}đ</span>
                    @endif
                </div>

                <div class="product-meta">
                    <div class="meta-item">
                        <span class="meta-label">Đánh giá:</span>
                        <span class="meta-value" style="color: #f59e0b; display: flex; align-items: center; gap: 5px;">
                            @php
                                $avgRating = $product->average_rating ?? 0;
                                $fullStars = floor($avgRating);
                                $halfStar = $avgRating - $fullStars >= 0.5 ? 1 : 0;
                                $emptyStars = 5 - $fullStars - $halfStar;
                                $soldCount = $product->orderItems()->sum('quantity');
                            @endphp
                            @for($i = 0; $i < $fullStars; $i++) <i class="fas fa-star"></i> @endfor
                            @if($halfStar) <i class="fas fa-star-half-alt"></i> @endif
                            @for($i = 0; $i < $emptyStars; $i++) <i class="far fa-star"></i> @endfor
                            <span style="color: #64748b; font-size: 13px; font-weight: 500; margin-left: 5px;">({{ number_format($avgRating, 1) }}) • {{ $soldCount }} người đã mua</span>
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Mã sản phẩm:</span>
                        <span class="meta-value">{{ $product->barcode ?? 'Đang cập nhật' }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Chất liệu:</span>
                        <span class="meta-value">{{ $product->material ?? 'Đang cập nhật' }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Tình trạng:</span>
                        <span class="meta-value">
                            @if($product->stock_quantity > 0)
                                <span class="stock-status status-in-stock">
                                    <i class="fas fa-check-circle"></i> Còn hàng ({{ $product->stock_quantity }})
                                </span>
                            @else
                                <span class="stock-status status-out-stock">
                                    <i class="fas fa-times-circle"></i> Hết hàng
                                </span>
                            @endif
                        </span>
                    </div>
                </div>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    @if(session('success'))
                        <div style="background: #ecfdf5; border: 1px solid #10b981; color: #047857; padding: 10px 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 500;">
                            <i class="fas fa-check-circle" style="margin-right: 5px;"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div style="background: #fef2f2; border: 1px solid #ef4444; color: #b91c1c; padding: 10px 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 500;">
                            <i class="fas fa-times-circle" style="margin-right: 5px;"></i> {{ session('error') }}
                        </div>
                    @endif
                    
                    <div class="quantity-selector">
                        <span class="quantity-label">Số lượng:</span>
                        <div class="quantity-control">
                            <button type="button" class="qty-btn" onclick="decreaseQty()"><i class="fas fa-minus"></i></button>
                            <input type="number" id="qty" name="quantity" class="qty-input" value="1" min="1" max="{{ $product->stock_quantity }}">
                            <button type="button" class="qty-btn" onclick="increaseQty()"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button type="submit" class="btn-add-cart" {{ $product->stock_quantity <= 0 ? 'disabled' : '' }} style="{{ $product->stock_quantity <= 0 ? 'opacity: 0.5; cursor: not-allowed;' : '' }}">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                        </button>
                        @php
                            $isFavorited = false;
                            if(Auth::check()) {
                                $isFavorited = Auth::user()->favorites()->where('product_id', $product->id)->exists();
                            }
                        @endphp
                        <button type="button" class="btn-favorite" title="Thêm vào yêu thích" onclick="toggleFavorite({{ $product->id }}, this)" style="{{ $isFavorited ? 'color: #ef4444; border-color: #ef4444; background: #fef2f2;' : '' }}">
                            <i class="{{ $isFavorited ? 'fas' : 'far' }} fa-heart"></i>
                        </button>
                    </div>
                </form>

                <div class="delivery-info">
                    <div class="delivery-item">
                        <div class="delivery-icon"><i class="fas fa-truck"></i></div>
                        <div class="delivery-text">
                            <h4>Giao hàng miễn phí</h4>
                            <p>Cho đơn hàng từ 500.000đ trở lên. Áp dụng toàn quốc.</p>
                        </div>
                    </div>
                    <div class="delivery-item">
                        <div class="delivery-icon"><i class="fas fa-undo"></i></div>
                        <div class="delivery-text">
                            <h4>Đổi trả dễ dàng</h4>
                            <p>Miễn phí đổi trả trong vòng 7 ngày nếu lỗi từ nhà sản xuất.</p>
                        </div>
                    </div>
                    <div class="delivery-item">
                        <div class="delivery-icon"><i class="fas fa-shield-alt"></i></div>
                        <div class="delivery-text">
                            <h4>Hàng chính hãng</h4>
                            <p>Cam kết chất lượng chuẩn như hình ảnh và mô tả.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-reviews-section" style="margin-top: 60px; background: white; border-radius: 24px; padding: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.03);" data-aos="fade-up">
            <h3 class="section-title" style="text-align: left; margin-bottom: 20px;">Đánh giá sản phẩm ({{ $product->reviews_count }})</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 40px;">
                <div class="review-summary" style="background: #f8fafc; padding: 30px; border-radius: 16px; text-align: center; height: fit-content;">
                    <div style="font-size: 48px; font-weight: 800; color: #0f172a; line-height: 1;">{{ number_format($product->average_rating, 1) }}</div>
                    <div style="color: #f59e0b; font-size: 20px; margin: 10px 0;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($product->average_rating))
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <p style="color: #64748b; font-size: 14px;">Dựa trên {{ $product->reviews_count }} đánh giá</p>
                </div>

                <div class="review-list">
                    @auth
                        <form action="{{ route('reviews.store', $product->id) }}" method="POST" style="margin-bottom: 40px; background: #f8fafc; padding: 24px; border-radius: 16px;">
                            @csrf
                            <h4 style="margin-top: 0; margin-bottom: 16px; font-size: 16px; color: #0f172a;">Viết đánh giá của bạn</h4>
                            <div style="margin-bottom: 16px;">
                                <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 600; color: #334155;">Đánh giá (Sao):</label>
                                <select name="rating" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; outline: none;">
                                    <option value="5">5 Sao (Tuyệt vời)</option>
                                    <option value="4">4 Sao (Rất tốt)</option>
                                    <option value="3">3 Sao (Bình thường)</option>
                                    <option value="2">2 Sao (Tạm được)</option>
                                    <option value="1">1 Sao (Không tốt)</option>
                                </select>
                            </div>
                            <div style="margin-bottom: 16px;">
                                <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 600; color: #334155;">Nhận xét:</label>
                                <textarea name="comment" rows="3" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; outline: none; resize: vertical;" placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..."></textarea>
                            </div>
                            <button type="submit" class="btn-add-cart" style="height: 44px; width: auto; padding: 0 24px; font-size: 14px;">Gửi đánh giá</button>
                        </form>
                    @else
                        <div style="background: #f8fafc; padding: 20px; border-radius: 12px; margin-bottom: 40px; text-align: center;">
                            <p style="color: #64748b; margin-bottom: 12px;">Bạn cần đăng nhập để đánh giá sản phẩm.</p>
                            <a href="{{ route('login') }}" style="display: inline-block; background: #0f172a; color: white; padding: 8px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px;">Đăng nhập ngay</a>
                        </div>
                    @endauth

                    <div class="reviews-container">
                        @forelse($product->reviews->sortByDesc('created_at') as $review)
                            <div class="review-item" style="border-bottom: 1px solid #f1f5f9; padding-bottom: 24px; margin-bottom: 24px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        @php
                                            $reviewerAvatar = $review->user->profile_picture 
                                                ? asset('images/avatars/' . $review->user->profile_picture) 
                                                : 'https://ui-avatars.com/api/?name=' . urlencode($review->user->fullname) . '&background=f1f5f9&color=0f172a';
                                        @endphp
                                        <img src="{{ $reviewerAvatar }}" alt="{{ $review->user->fullname }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                        <div>
                                            <div style="font-weight: 600; color: #0f172a; font-size: 14px;">{{ $review->user->fullname }}</div>
                                            <div style="color: #94a3b8; font-size: 12px;">{{ $review->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    <div style="color: #f59e0b; font-size: 12px;">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                @if($review->comment)
                                    <p style="color: #475569; font-size: 14px; line-height: 1.6; margin: 0;">{{ $review->comment }}</p>
                                @endif
                            </div>
                        @empty
                            <p style="color: #94a3b8; text-align: center; font-style: italic;">Chưa có đánh giá nào cho sản phẩm này.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        @if($relatedProducts->count() > 0)
        <div class="related-products" data-aos="fade-up">
            <h3 class="section-title">Có thể bạn sẽ thích</h3>
            <div class="related-grid">
                @foreach($relatedProducts as $related)
                <div class="product-card" style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: all 0.3s;">
                    <a href="{{ route('shop.show', $related->id) }}" style="text-decoration: none; color: inherit;">
                        <div class="product-image" style="position: relative; aspect-ratio: 3/4; overflow: hidden;">
                            <img src="{{ $related->image_url }}" alt="{{ $related->name }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
                            @if($related->cost_price > $related->selling_price)
                            <div class="sale-badge" style="position: absolute; top: 12px; left: 12px; background: #ef4444; color: white; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 12px;">SALE</div>
                            @endif
                        </div>
                        <div class="product-info-card" style="padding: 16px;">
                            <h3 class="product-title" style="font-size: 15px; font-weight: 600; color: #1e293b; margin: 0 0 8px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $related->name }}</h3>
                            <div class="product-price" style="display: flex; align-items: center; gap: 8px;">
                                <span class="current-price" style="font-weight: 700; color: #ef4444; font-size: 15px;">{{ number_format($related->selling_price, 0, ',', '.') }}đ</span>
                                @if($related->cost_price > $related->selling_price)
                                <span class="old-price" style="color: #94a3b8; text-decoration: line-through; font-size: 13px;">{{ number_format($related->cost_price, 0, ',', '.') }}đ</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <style>
                .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important; }
                .product-card:hover .product-image img { transform: scale(1.05); }
            </style>
        </div>
        @endif
    </div>

    <footer class="main-footer" style="background: #0f172a; padding: 60px 0 20px;">
        <div class="footer-grid" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: grid; grid-template-columns: repeat(4, 1fr); gap: 40px;">
            <div class="footer-col" style="color: white;">
                <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Tiny Flowers</h3>
                <p style="color: #94a3b8; font-size: 14px; line-height: 1.6;">Nơi mang đến cho bạn những thiết kế thời trang tinh tế, thanh lịch và luôn dẫn đầu xu hướng.</p>
            </div>
            <div class="footer-col" style="color: white;">
                <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Liên Hệ</h3>
                <p style="color: #94a3b8; font-size: 14px; line-height: 1.6; margin-bottom: 10px;"><i class="fas fa-map-marker-alt" style="width: 20px;"></i> 123 Đường Fashion, TP. HCM</p>
                <p style="color: #94a3b8; font-size: 14px; line-height: 1.6; margin-bottom: 10px;"><i class="fas fa-phone" style="width: 20px;"></i> 0123.456.789</p>
                <p style="color: #94a3b8; font-size: 14px; line-height: 1.6; margin-bottom: 10px;"><i class="fas fa-envelope" style="width: 20px;"></i> hello@tinyflowers.vn</p>
            </div>
            <div class="footer-col" style="color: white;">
                <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Chính Sách</h3>
                <p style="color: #94a3b8; font-size: 14px; line-height: 1.6; margin-bottom: 10px;">Chính sách đổi trả</p>
                <p style="color: #94a3b8; font-size: 14px; line-height: 1.6; margin-bottom: 10px;">Chính sách bảo mật</p>
                <p style="color: #94a3b8; font-size: 14px; line-height: 1.6; margin-bottom: 10px;">Điều khoản dịch vụ</p>
            </div>
            <div class="footer-col" style="color: white;">
                <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Mạng Xã Hội</h3>
                <div style="display: flex; gap: 15px;">
                    <a href="#" style="width: 40px; height: 40px; border-radius: 50%; background: #1e293b; color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: background 0.2s;"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" style="width: 40px; height: 40px; border-radius: 50%; background: #1e293b; color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: background 0.2s;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="width: 40px; height: 40px; border-radius: 50%; background: #1e293b; color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: background 0.2s;"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </div>
        <div style="text-align: center; color: #64748b; font-size: 14px; margin-top: 40px; padding-top: 20px; border-top: 1px solid #1e293b;">
            &copy; 2026 Tiny Flowers. All rights reserved.
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });

        function decreaseQty() {
            const input = document.getElementById('qty');
            if (input.value > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        function increaseQty() {
            const input = document.getElementById('qty');
            const max = parseInt(input.getAttribute('max'));
            if (input.value < max) {
                input.value = parseInt(input.value) + 1;
            }
        }

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
                        btnElement.style.borderColor = '#ef4444';
                        btnElement.style.background = '#fef2f2';
                        btnElement.querySelector('i').classList.remove('far');
                        btnElement.querySelector('i').classList.add('fas');
                    } else {
                        btnElement.style.color = '#64748b';
                        btnElement.style.borderColor = '#e2e8f0';
                        btnElement.style.background = 'white';
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
</body>
</html>
