@extends('layouts.shop')

@section('title', $title)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
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
                </div>
                <div class="product-details">
                    <p class="product-category">{{ $product->category->name ?? 'FASHION' }}</p>
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <div class="price-cart-row">
                        <p class="product-price">{{ number_format($product->selling_price) }}đ</p>
                        <button class="add-to-cart-box" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->selling_price }}" data-image="{{ $product->image_url }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pagination-area" style="display: flex; justify-content: center; margin-top: 50px;">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection
