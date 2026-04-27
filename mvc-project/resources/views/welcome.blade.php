@extends('layouts.shop')

@section('title', 'Tiny Flowers - Fashion & Streetwear')

@section('styles')
<style>
    .product-image {
        position: relative;
        overflow: hidden;
        aspect-ratio: 1/1.2;
        background: #f1f5f9;
        border-radius: 12px;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .view-more-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .product-card:hover .view-more-overlay {
        opacity: 1;
    }

    .btn-view-more {
        background: #000;
        color: white;
        padding: 10px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transform: translateY(20px);
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .product-card:hover .btn-view-more {
        transform: translateY(0);
    }

    .btn-view-more:hover {
        background: #334155;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
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

<!-- New Arrivals -->
<section class="products-section" id="new-arrivals">
    <div class="section-header">
        <h2 class="section-title">BST MỚI NHẤT</h2>
        <a href="{{ route('shop') }}" style="color: #64748b; font-weight: 700; font-size: 14px; text-decoration: none;">XEM TẤT CẢ <i class="fas fa-arrow-right"></i></a>
    </div>

    <div class="product-grid">
        @foreach($products as $product)
            <div class="product-card">
                <div class="product-image">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    <div class="view-more-overlay">
                        <button class="btn-view-more" onclick="window.location.href='{{ route('shop.show', $product->id) }}'">Xem thêm</button>
                    </div>
                </div>
                <div class="product-details">
                    <p class="product-category">{{ $product->category->name ?? 'FASHION' }}</p>
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <div class="price-cart-row">
                        <p class="product-price">{{ number_format($product->selling_price) }}đ</p>
                        <div style="display: flex; gap: 8px;">
                            <button type="button" class="wishlist-btn {{ in_array($product->id, $userFavoriteIds ?? []) ? 'active' : '' }}" data-id="{{ $product->id }}" style="width: 36px; height: 36px; background: white; border: 1px solid #e9ddd2; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #64748b; transition: all 0.3s;">
                                <i class="{{ in_array($product->id, $userFavoriteIds ?? []) ? 'fas' : 'far' }} fa-heart" style="{{ in_array($product->id, $userFavoriteIds ?? []) ? 'color: #ef4444;' : '' }}"></i>
                            </button>
                            <button class="add-to-cart-box" 
                                    data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->selling_price }}" data-image="{{ $product->image_url }}"
                                    onclick="event.stopPropagation();">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Video Lookbook & Style Explorer (Original) -->
<section class="video-lookbook-section">
    <div class="section-header" style="text-align: center;">
        <h2 class="section-title">LOOKBOOK PHONG CÁCH</h2>
    </div>
    <div class="slider-container">
        <div class="slider-track" id="video-track">
            @for($i = 1; $i <= 4; $i++)
                <div class="slider-item video-item">
                    <video autoplay muted loop playsinline><source src="{{ asset('images/source/VideoLookbook/f'.$i.'.mp4') }}" type="video/mp4"></video>
                </div>
            @endfor
        </div>
    </div>
</section>

<section class="style-explorer-section">
    <div class="section-header" style="text-align: center;">
        <h2 class="section-title">KHÁM PHÁ STYLE</h2>
    </div>
    <div class="slider-container">
        <div class="slider-track" id="style-track">
            @php
                $styles = ['minimal/f1.png', 'relax/f1.png', 'sport/f1.png', 'StyleSetSection/f1.png', 'minimal/f2.png', 'relax/f2.png'];
            @endphp
            @foreach($styles as $style)
                <div class="slider-item style-item">
                    <img src="{{ asset('images/source/' . (strpos($style, '/') === false ? 'WeekendVibesSection/' : '') . $style) }}" alt="Style">
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Slider logic
    function initSlider(trackId, speed = 1) {
        const track = document.getElementById(trackId);
        if(!track) return;
        const container = track.parentElement;
        track.innerHTML += track.innerHTML;
        let scrollAmount = 0;
        let isPaused = false;
        const halfWidth = track.scrollWidth / 2;

        container.addEventListener('mouseenter', () => isPaused = true);
        container.addEventListener('mouseleave', () => isPaused = false);

        function step() {
            if (!isPaused) {
                scrollAmount += speed;
                if (scrollAmount >= halfWidth) scrollAmount = 0;
                track.style.transform = `translateX(-${scrollAmount}px)`;
            }
            requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    window.addEventListener('load', () => {
        setTimeout(() => {
            initSlider('style-track', 0.8);
            initSlider('video-track', 0.5);
        }, 500);
    });

    // AJAX Add to Cart
    document.querySelectorAll('.add-to-cart-box-ajax').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const productId = this.getAttribute('data-id');
            fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId, quantity: 1 })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    // Update badge and open sidebar
                    document.querySelectorAll('.badge-count').forEach(b => b.innerText = data.cartCount);
                    openCart();
                    // Optionally refresh cartItems via AJAX too
                    location.reload(); // Simplest for now to refresh sidebar content
                }
            });
        });
    });
</script>
@endsection
