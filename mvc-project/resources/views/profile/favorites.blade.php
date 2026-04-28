@extends('layouts.shop')

@section('title', 'Sản phẩm yêu thích - Tiny Flowers')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
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

        .product-rating-row {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 8px;
        }

        .product-rating-row .stars {
            display: flex;
            gap: 2px;
            color: #f59e0b;
            font-size: 11px;
        }

        .product-rating-row .rating-score {
            font-size: 12px;
            font-weight: 700;
            color: #1e293b;
        }

        .product-rating-row .rating-count {
            font-size: 11px;
            color: #94a3b8;
        }

        .empty-favorites { 
            text-align: center; 
            padding: 100px 20px;
            grid-column: 1 / -1;
        }
    </style>
@endsection

@section('content')
<div class="shop-header">
    <div class="breadcrumb" style="max-width: 1400px; margin: 0 auto; padding: 0 40px; font-size: 13px; color: #94a3b8; margin-bottom: 10px;">
        <a href="{{ route('home') }}" style="color: inherit; text-decoration: none;">CỬA HÀNG</a> / YÊU THÍCH
    </div>
    <h1 class="shop-title" style="max-width: 1400px; margin: 0 auto; padding: 0 40px; font-size: 36px; font-weight: 900; color: #1e293b;">SẢN PHẨM YÊU THÍCH</h1>
</div>

<div class="shop-container" style="max-width: 1400px; margin: 40px auto; padding: 0 40px;">
    <div class="shop-filters" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 1px solid #e9ddd2;">
        <div class="filter-group">
            <a href="{{ route('shop') }}" class="filter-btn">Cửa hàng</a>
            <a href="{{ route('profile.favorites') }}" class="filter-btn active">Đã lưu ({{ $favorites->count() }})</a>
        </div>
        <div class="filter-group">
            <span style="font-size: 14px; color: #94a3b8;">Sản phẩm bạn đã quan tâm</span>
        </div>
    </div>

    @if($favorites->count() > 0)
        <div class="product-grid">
            @foreach($favorites as $fav)
                @php $product = $fav->product; @endphp
                <div class="product-card favorite-item-{{ $product->id }}">
                    <div class="product-image">
                        <img src="{{ $product->image_url ?? asset('images/welcome/tshirt.png') }}" alt="{{ $product->name }}">
                        <div class="view-more-overlay">
                            <a href="{{ route('shop.show', $product->id) }}" class="btn-view-more">Xem chi tiết</a>
                        </div>
                    </div>
                    <div class="product-details">
                        <p class="product-category">{{ $product->category->name ?? 'FASHION' }}</p>
                        <h3 class="product-name" style="font-size: 16px; font-weight: 700; margin-bottom: 4px; color: #1e293b;">{{ $product->name }}</h3>
                        
                        <div class="product-rating-row">
                            <div class="stars">
                                @php $avg = round($product->reviews_avg_rating ?? 0); @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $avg ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                            </div>
                            <span class="rating-score">{{ number_format($product->reviews_avg_rating ?? 0, 1) }}</span>
                            <span class="rating-count">({{ $product->reviews_count ?? 0 }})</span>
                        </div>

                        <div class="price-cart-row" style="display: flex; justify-content: space-between; align-items: center;">
                            <p class="product-price" style="font-weight: 800; color: #FF7EB3; font-size: 18px;">{{ number_format($product->selling_price) }}đ</p>
                            <div style="display: flex; gap: 8px;">
                                <button type="button" class="wishlist-btn active" data-id="{{ $product->id }}" style="width: 36px; height: 36px; background: white; border: 1px solid #e9ddd2; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #ef4444; transition: all 0.3s;">
                                    <i class="fas fa-heart"></i>
                                </button>
                                <button class="add-to-cart-box" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->selling_price }}" data-image="{{ $product->image_url }}" style="width: 36px; height: 36px; background: #1e293b; color: white; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-favorites">
            <div style="background: #fff4ec; width: 120px; height: 120px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px;">
                <i class="far fa-heart" style="font-size: 50px; color: #94a3b8;"></i>
            </div>
            <h2 style="font-size: 24px; font-weight: 900; color: #1e293b; margin-bottom: 10px;">CHƯA CÓ SẢN PHẨM YÊU THÍCH</h2>
            <p style="color: #64748b; font-size: 16px; margin-bottom: 30px;">Hãy dạo quanh cửa hàng và lưu lại những món đồ bạn ưng ý nhé!</p>
            <a href="{{ route('shop') }}" class="btn-cta" style="display: inline-block; text-decoration: none; background: #1e293b; color: white; padding: 16px 40px; border-radius: 50px; font-weight: 700; transition: all 0.3s;">TIẾP TỤC MUA SẮM</a>
        </div>
    @endif
</div>
@endsection
