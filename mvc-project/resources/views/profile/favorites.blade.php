@extends('layouts.profile')

@section('title', 'Sản phẩm yêu thích - Tiny Flowers')

@section('profile_styles')
<style>
    .favorites-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
    .product-card { background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; position: relative; transition: all 0.3s; }
    .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    .product-image { width: 100%; height: 200px; object-fit: cover; }
    .product-info { padding: 15px; }
    .product-name { font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 8px; display: block; text-decoration: none; height: 40px; overflow: hidden; }
    .product-price { color: #ef4444; font-weight: 700; font-size: 15px; }
    .btn-remove { position: absolute; top: 10px; right: 10px; background: white; border: none; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ef4444; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.1); z-index: 10; }
    .empty-favorites { text-align: center; padding: 60px 20px; }
    .empty-favorites i { font-size: 48px; color: #cbd5e1; margin-bottom: 20px; }
</style>
@endsection

@section('profile_content')
<div class="content-header">
    <h2>Sản phẩm yêu thích</h2>
    <p>Danh sách các sản phẩm bạn đã lưu để xem sau</p>
</div>

@if($favorites->count() > 0)
    <div class="favorites-grid">
        @foreach($favorites as $fav)
            <div class="product-card">
                <form action="#" method="POST">
                    @csrf
                    <button type="submit" class="btn-remove" title="Xóa khỏi yêu thích">
                        <i class="fas fa-heart"></i>
                    </button>
                </form>
                <a href="#">
                    <img src="{{ $fav->product->image_url ?? asset('images/welcome/tshirt.png') }}" class="product-image">
                </a>
                <div class="product-info">
                    <a href="#" class="product-name">{{ $fav->product->name }}</a>
                    <div class="product-price">{{ number_format($fav->product->selling_price) }}đ</div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="empty-favorites">
        <i class="far fa-heart"></i>
        <p style="color: #64748b; font-size: 16px;">Danh sách yêu thích của bạn đang trống.</p>
        <a href="{{ route('home') }}" class="btn-primary" style="display: inline-flex; align-items: center; justify-content: center; margin-top: 20px; text-decoration: none; background: #0f172a; color: white; padding: 12px 24px; border-radius: 8px; font-weight: 600;">Khám phá sản phẩm</a>
    </div>
@endif
@endsection
