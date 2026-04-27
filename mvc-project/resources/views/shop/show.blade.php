@extends('layouts.shop')

@section('title', $product->name . ' - Tiny Flowers')

@section('styles')
<style>
    .product-detail-container {
        max-width: 1400px;
        margin: 40px auto;
        padding: 0 40px;
    }

    .breadcrumb {
        margin-bottom: 30px;
        font-size: 14px;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .breadcrumb a {
        text-decoration: none;
        color: inherit;
        transition: color 0.2s;
    }

    .breadcrumb a:hover {
        color: #1e293b;
    }

    .product-main {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 60px;
        background: white;
        padding: 40px;
        border-radius: 30px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.03);
    }

    .product-gallery {
        position: sticky;
        top: 120px;
    }

    .main-image-wrapper {
        border-radius: 24px;
        overflow: hidden;
        background: #f8fafc;
        aspect-ratio: 1/1;
        border: 1px solid #f1f5f9;
    }

    .main-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .main-image-wrapper:hover img {
        transform: scale(1.05);
    }

    .product-info-wrapper {
        display: flex;
        flex-direction: column;
    }

    .product-badge {
        display: inline-block;
        padding: 6px 16px;
        background: #f1f5f9;
        color: #64748b;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 20px;
        width: fit-content;
    }

    .product-title {
        font-size: 42px;
        font-weight: 900;
        color: #0f172a;
        margin: 0 0 15px 0;
        line-height: 1.1;
        letter-spacing: -1px;
    }

    .product-meta-row {
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 30px;
        padding-bottom: 25px;
        border-bottom: 1px solid #f1f5f9;
    }

    .product-price-large {
        font-size: 32px;
        font-weight: 900;
        color: #ef4444;
    }

    .product-description {
        font-size: 16px;
        line-height: 1.8;
        color: #64748b;
        margin-bottom: 40px;
    }

    .action-group {
        display: grid;
        grid-template-columns: 140px 1fr 60px;
        gap: 15px;
        margin-bottom: 30px;
    }

    .qty-control {
        display: flex;
        align-items: center;
        background: #f1f5f9;
        border-radius: 16px;
        padding: 5px;
    }

    .qty-btn-circle {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        border: none;
        background: white;
        color: #1e293b;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .qty-btn-circle:hover {
        background: #1e293b;
        color: white;
    }

    .qty-input {
        flex: 1;
        border: none;
        background: transparent;
        text-align: center;
        font-weight: 800;
        font-size: 16px;
        width: 40px;
        outline: none;
    }

    .add-to-cart-large {
        background: #0f172a;
        color: white;
        border: none;
        border-radius: 16px;
        font-weight: 800;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.15);
    }

    .add-to-cart-large:hover {
        background: #334155;
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.25);
    }

    .wishlist-btn-large {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        border: 2px solid #f1f5f9;
        background: white;
        color: #64748b;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .wishlist-btn-large:hover {
        border-color: #ef4444;
        color: #ef4444;
        background: #fff1f2;
    }

    .wishlist-btn-large.active {
        background: #ef4444;
        color: white;
        border-color: #ef4444;
    }

    .delivery-info-card {
        background: #f8fafc;
        border-radius: 20px;
        padding: 25px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 40px;
    }

    .info-item {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .info-icon {
        width: 44px;
        height: 44px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1e293b;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    }

    .review-section {
        margin-top: 80px;
    }

    .review-summary-box {
        background: white;
        border-radius: 24px;
        padding: 40px;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 60px;
        margin-bottom: 40px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.02);
    }

    .related-products {
        margin-top: 100px;
    }

    @media (max-width: 992px) {
        .product-main { grid-template-columns: 1fr; }
        .product-gallery { position: static; }
        .review-summary-box { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="product-detail-container">
    <div class="breadcrumb" data-aos="fade-right">
        <a href="{{ route('home') }}">Trang chủ</a>
        <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
        <a href="{{ route('shop') }}">Cửa hàng</a>
        <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
        @if($product->category)
            <a href="{{ route('shop', ['category' => $product->category->name]) }}">{{ $product->category->name }}</a>
            <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
        @endif
        <span style="color: #1e293b; font-weight: 700;">{{ $product->name }}</span>
    </div>

    <div class="product-main">
        <div class="product-gallery" data-aos="fade-up">
            <div class="main-image-wrapper">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" id="mainProductImage">
            </div>
        </div>

        <div class="product-info-wrapper" data-aos="fade-left">
            <div class="product-badge">BST Streetwear 2026</div>
            <h1 class="product-title">{{ $product->name }}</h1>
            
            <div class="product-meta-row">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="color: #f59e0b; font-size: 16px;">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= round($product->average_rating) ? 'fas' : 'far' }} fa-star"></i>
                        @endfor
                    </div>
                    <span style="font-weight: 700; color: #1e293b;">{{ number_format($product->average_rating, 1) }}</span>
                    <span style="color: #94a3b8;">({{ $product->reviews_count }} đánh giá)</span>
                </div>
                <div style="height: 20px; width: 1px; background: #e2e8f0;"></div>
                <div style="color: #64748b; font-size: 14px;">
                    Trạng thái: <span style="color: #22c55e; font-weight: 700;">{{ $product->stock_quantity > 0 ? 'Còn hàng' : 'Hết hàng' }}</span>
                </div>
            </div>

            <div class="product-price-large">{{ number_format($product->selling_price) }}đ</div>

            <div class="product-description">
                {{ $product->description ?? 'Thông tin sản phẩm đang được cập nhật. Sản phẩm được sản xuất với chất liệu cao cấp, đường may tỉ mỉ, mang lại cảm giác thoải mái và phong cách cho người mặc.' }}
            </div>

            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="action-group">
                    <div class="qty-control">
                        <button type="button" class="qty-btn-circle" onclick="decreaseQty()"><i class="fas fa-minus"></i></button>
                        <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $product->stock_quantity }}" class="qty-input">
                        <button type="button" class="qty-btn-circle" onclick="increaseQty()"><i class="fas fa-plus"></i></button>
                    </div>
                    <button type="submit" class="add-to-cart-large">
                        <i class="fas fa-shopping-bag"></i>
                        THÊM VÀO GIỎ HÀNG
                    </button>
                    <button type="button" class="wishlist-btn-large {{ in_array($product->id, $userFavoriteIds) ? 'active' : '' }}" onclick="toggleFavorite({{ $product->id }}, this)">
                        <i class="{{ in_array($product->id, $userFavoriteIds) ? 'fas' : 'far' }} fa-heart"></i>
                    </button>
                </div>
            </form>

            <div class="delivery-info-card">
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-truck"></i></div>
                    <div>
                        <div style="font-weight: 700; font-size: 14px;">Giao hàng nhanh</div>
                        <div style="font-size: 12px; color: #64748b;">Từ 2 - 4 ngày làm việc</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-undo"></i></div>
                    <div>
                        <div style="font-weight: 700; font-size: 14px;">Đổi trả dễ dàng</div>
                        <div style="font-size: 12px; color: #64748b;">Trong vòng 7 ngày</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-shield-alt"></i></div>
                    <div>
                        <div style="font-weight: 700; font-size: 14px;">Bảo hành 6 tháng</div>
                        <div style="font-size: 12px; color: #64748b;">Lỗi do nhà sản xuất</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-headset"></i></div>
                    <div>
                        <div style="font-weight: 700; font-size: 14px;">Hỗ trợ 24/7</div>
                        <div style="font-size: 12px; color: #64748b;">Hotline: 0123.456.789</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="review-section" id="reviews">
        <h2 style="font-size: 28px; font-weight: 900; margin-bottom: 40px; color: #1e293b;">Đánh giá từ khách hàng</h2>
        
        <div class="review-summary-box">
            <div style="text-align: center;">
                <div style="font-size: 64px; font-weight: 900; color: #0f172a; line-height: 1;">{{ number_format($product->average_rating, 1) }}</div>
                <div style="color: #f59e0b; font-size: 24px; margin: 15px 0;">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="{{ $i <= round($product->average_rating) ? 'fas' : 'far' }} fa-star"></i>
                    @endfor
                </div>
                <p style="color: #64748b; font-weight: 600;">Dựa trên {{ $product->reviews_count }} đánh giá</p>
            </div>

            <div style="display: flex; flex-direction: column; justify-content: center; gap: 12px;">
                @foreach($ratingBreakdown as $star => $data)
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <span style="font-size: 14px; font-weight: 700; color: #475569; width: 50px;">{{ $star }} sao</span>
                        <div style="flex: 1; height: 10px; background: #f1f5f9; border-radius: 50px; overflow: hidden;">
                            <div style="height: 100%; width: {{ $data['percentage'] }}%; background: #f59e0b; border-radius: 50px;"></div>
                        </div>
                        <span style="font-size: 13px; color: #94a3b8; width: 40px;">{{ $data['count'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="review-list">
            @forelse($product->reviews as $review)
                <div style="background: white; padding: 30px; border-radius: 20px; margin-bottom: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <div style="display: flex; gap: 15px; align-items: center;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->fullname) }}&background=f1f5f9&color=1e293b&bold=true" style="width: 50px; height: 50px; border-radius: 50%;">
                            <div>
                                <div style="font-weight: 800; color: #1e293b;">{{ $review->user->fullname }}</div>
                                <div style="font-size: 12px; color: #94a3b8;">{{ $review->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div style="color: #f59e0b; font-size: 14px;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                    </div>
                    <p style="color: #475569; line-height: 1.6; margin: 0;">{{ $review->comment }}</p>
                </div>
            @empty
                <div style="text-align: center; padding: 60px; background: white; border-radius: 20px; color: #94a3b8;">
                    <i class="far fa-comment-dots" style="font-size: 48px; margin-bottom: 20px; opacity: 0.3;"></i>
                    <p>Sản phẩm này chưa có đánh giá nào.</p>
                </div>
            @endforelse
        </div>
    </div>

    @if($relatedProducts->count() > 0)
    <div class="related-products">
        <h2 style="font-size: 28px; font-weight: 900; margin-bottom: 40px; color: #1e293b;">Sản phẩm tương tự</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
            @foreach($relatedProducts as $relProduct)
                <div class="product-card" onclick="window.location.href='{{ route('shop.show', $relProduct->id) }}'" style="cursor: pointer;">
                    <div class="product-image">
                        <img src="{{ $relProduct->image_url }}" alt="{{ $relProduct->name }}">
                        <div class="product-overlay">
                            <button class="quick-view-btn"><i class="fas fa-eye"></i> Xem nhanh</button>
                        </div>
                    </div>
                    <div class="product-details">
                        <p class="product-category">{{ $relProduct->category->name ?? 'FASHION' }}</p>
                        <h3 class="product-name">{{ $relProduct->name }}</h3>
                        <div class="product-rating" style="display: flex; align-items: center; gap: 4px; margin-bottom: 10px;">
                            <div style="color: #f59e0b; font-size: 12px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= round($relProduct->reviews_avg_rating ?? 0) ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                            </div>
                            <span style="font-size: 11px; color: #94a3b8;">({{ $relProduct->reviews_count ?? 0 }})</span>
                        </div>
                        <div class="price-cart-row">
                            <p class="product-price">{{ number_format($relProduct->selling_price) }}đ</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
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
        fetch('{{ route('favorites.toggle') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(response => {
            if (response.status === 401) {
                window.location.href = "{{ route('login') }}";
                return Promise.reject('Unauthorized');
            }
            return response.json();
        })
        .then(data => {
            if(data.success) {
                const icon = btnElement.querySelector('i');
                if (data.action === 'added') {
                    btnElement.classList.add('active');
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                } else {
                    btnElement.classList.remove('active');
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                }
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection
