<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - Tiny Flowers</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; }
        .cart-container { max-width: 1200px; margin: 40px auto 80px; padding: 0 20px; }
        .cart-header { font-size: 32px; font-weight: 800; color: #0f172a; margin-bottom: 30px; }
        .cart-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; }
        .cart-items { background: white; border-radius: 24px; padding: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); }
        .cart-item { display: flex; align-items: center; padding: 20px 0; border-bottom: 1px solid #f1f5f9; gap: 20px; }
        .cart-item:last-child { border-bottom: none; padding-bottom: 0; }
        .cart-item-img { width: 100px; height: 100px; border-radius: 12px; object-fit: cover; border: 1px solid #e2e8f0; }
        .cart-item-details { flex: 1; }
        .cart-item-name { font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 5px; text-decoration: none; display: block; }
        .cart-item-price { font-size: 15px; font-weight: 600; color: #ef4444; }
        .cart-qty { display: flex; align-items: center; border: 1px solid #e2e8f0; border-radius: 20px; overflow: hidden; width: max-content; background: #f8fafc; }
        .cart-qty button { background: none; border: none; padding: 6px 12px; cursor: pointer; color: #475569; transition: all 0.2s; font-size: 12px; }
        .cart-qty button:hover { background: #e2e8f0; color: #0f172a; }
        .cart-qty input { width: 30px; text-align: center; border: none; background: transparent; font-weight: 600; color: #0f172a; padding: 0; outline: none; }
        .cart-item-remove { color: #ef4444; background: #fef2f2; border: 1px solid #fecaca; cursor: pointer; font-size: 14px; padding: 8px 12px; border-radius: 8px; transition: all 0.2s; font-weight: 600; display: flex; align-items: center; gap: 6px; }
        .cart-item-remove:hover { background: #ef4444; color: white; border-color: #ef4444; }
        
        .cart-summary { background: white; border-radius: 24px; padding: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); height: fit-content; }
        .cart-summary h3 { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 15px; color: #475569; }
        .summary-total { display: flex; justify-content: space-between; margin-top: 20px; padding-top: 20px; border-top: 1px solid #f1f5f9; font-size: 18px; font-weight: 800; color: #0f172a; }
        .btn-checkout { display: block; width: 100%; background: #0f172a; color: white; text-align: center; padding: 15px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 16px; margin-top: 25px; transition: all 0.3s; }
        .btn-checkout:hover { background: #1e293b; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(15, 23, 42, 0.2); }
        .btn-continue { display: block; width: 100%; background: white; color: #0f172a; text-align: center; padding: 15px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 15px; margin-top: 15px; border: 2px solid #e2e8f0; transition: all 0.3s; }
        .btn-continue:hover { border-color: #cbd5e1; background: #f8fafc; }
        
        .empty-cart { text-align: center; padding: 60px 20px; }
        .empty-cart i { font-size: 60px; color: #cbd5e1; margin-bottom: 20px; }
        .empty-cart p { font-size: 18px; color: #64748b; margin-bottom: 30px; }
        
        @media (max-width: 768px) {
            .cart-layout { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header class="main-header" style="background: #0f172a;">
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo-area">
                <div class="logo-circle">TF</div>
                <span class="brand-name">Tiny Flowers</span>
            </a>
            <div class="header-actions">
                <a href="{{ route('shop') }}" style="color: white; text-decoration: none; font-weight: 600; margin-right: 20px;">Tiếp tục mua sắm</a>
            </div>
        </div>
    </header>

    <div class="cart-container">
        <h1 class="cart-header">Giỏ hàng của bạn</h1>
        
        @if(session('success'))
            <div style="background: #ecfdf5; border: 1px solid #10b981; color: #047857; padding: 15px; border-radius: 12px; margin-bottom: 30px; font-weight: 500;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background: #fef2f2; border: 1px solid #ef4444; color: #b91c1c; padding: 15px; border-radius: 12px; margin-bottom: 30px; font-weight: 500;">
                <i class="fas fa-times-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if(empty($cart))
            <div class="cart-items empty-cart">
                <i class="fas fa-shopping-basket"></i>
                <p>Giỏ hàng của bạn đang trống.</p>
                <a href="{{ route('shop') }}" class="btn-checkout" style="display: inline-block; width: auto; padding: 15px 40px;">Mua sắm ngay</a>
            </div>
        @else
            <div class="cart-layout">
                <div class="cart-items">
                    @foreach($cart as $id => $item)
                        <div class="cart-item">
                            <a href="{{ route('shop.show', $id) }}">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="cart-item-img">
                            </a>
                            <div class="cart-item-details">
                                <a href="{{ route('shop.show', $id) }}" class="cart-item-name">{{ $item['name'] }}</a>
                                <div class="cart-item-price">{{ number_format($item['price'], 0, ',', '.') }}đ</div>
                            </div>
                            <form action="{{ route('cart.update') }}" method="POST" style="margin: 0;">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <div class="cart-qty">
                                    <button type="button" onclick="this.nextElementSibling.value = Math.max(1, parseInt(this.nextElementSibling.value) - 1); this.form.submit();"><i class="fas fa-minus"></i></button>
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['max_quantity'] ?? 99 }}" onchange="this.form.submit()">
                                    <button type="button" onclick="this.previousElementSibling.value = parseInt(this.previousElementSibling.value) + 1; this.form.submit();"><i class="fas fa-plus"></i></button>
                                </div>
                            </form>
                            <div style="font-weight: 700; color: #0f172a; min-width: 100px; text-align: right;">
                                {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ
                            </div>
                            <form action="{{ route('cart.remove') }}" method="POST" style="margin: 0;">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button type="submit" class="cart-item-remove" title="Xóa"><i class="fas fa-trash-alt"></i> Xóa</button>
                            </form>
                        </div>
                    @endforeach
                </div>
                
                <div class="cart-summary">
                    <h3>Tổng đơn hàng</h3>
                    <div class="summary-row">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($total, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="summary-row">
                        <span>Phí vận chuyển:</span>
                        <span>Miễn phí</span>
                    </div>
                    <div class="summary-total">
                        <span>Tổng tiền:</span>
                        <span style="color: #ef4444;">{{ number_format($total, 0, ',', '.') }}đ</span>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn-checkout">Tiến hành thanh toán</a>
                    <a href="{{ route('shop') }}" class="btn-continue">Tiếp tục mua sắm</a>
                </div>
            </div>
        @endif
    </div>
</body>
</html>
