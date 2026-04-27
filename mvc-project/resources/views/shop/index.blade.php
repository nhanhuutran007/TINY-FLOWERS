@extends('layouts.shop')

@section('title', $title)

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
    </style>
@endsection

@section('content')
<div class="shop-header">
    <div class="breadcrumb" style="max-width: 1400px; margin: 0 auto; padding: 0 40px; font-size: 13px; color: #94a3b8; margin-bottom: 10px;">
        Cửa hàng / {{ $title }}
    </div>
    <h1 class="shop-title" style="max-width: 1400px; margin: 0 auto; padding: 0 40px; font-size: 36px; font-weight: 900; color: #1e293b;">{{ $title }}</h1>
</div>

<div class="shop-container" style="max-width: 1400px; margin: 40px auto; padding: 0 40px;">
    <div class="shop-filters" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 1px solid #e9ddd2;">
        <div class="filter-group" style="display: flex; gap: 15px;">
            <a href="{{ route('shop') }}" class="filter-btn {{ !request('category') ? 'active' : '' }}">Tất cả</a>
            <a href="#" class="filter-btn">Phổ biến</a>
            <a href="#" class="filter-btn">Mới nhất</a>
        </div>
        <div class="filter-group">
            <span style="font-size: 14px; color: #94a3b8;">Hiển thị {{ $products->count() }} sản phẩm</span>
        </div>
    </div>

    <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
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
                    <div class="price-cart-row" style="display: flex; justify-content: space-between; align-items: center;">
                        <p class="product-price">{{ number_format($product->selling_price) }}đ</p>
                        <div style="display: flex; gap: 8px;">
                            <button type="button" class="wishlist-btn {{ in_array($product->id, $userFavoriteIds ?? []) ? 'active' : '' }}" data-id="{{ $product->id }}" style="width: 36px; height: 36px; background: white; border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #64748b; transition: all 0.3s;">
                                <i class="{{ in_array($product->id, $userFavoriteIds ?? []) ? 'fas' : 'far' }} fa-heart" style="{{ in_array($product->id, $userFavoriteIds ?? []) ? 'color: #ef4444;' : '' }}"></i>
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

    <div class="pagination-area" style="display: flex; justify-content: center; margin-top: 50px;">
        {{ $products->appends(request()->query())->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection

@section('scripts')
<script>
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
                    document.querySelectorAll('.badge-count').forEach(b => b.innerText = data.cartCount);
                    openCart();
                    location.reload(); 
                }
            });
        });
    });
</script>
@endsection
