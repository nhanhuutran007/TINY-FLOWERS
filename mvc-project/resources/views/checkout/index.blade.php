<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - Tiny Flowers</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; }
        .checkout-container { max-width: 1200px; margin: 40px auto 80px; padding: 0 20px; }
        .checkout-header { font-size: 32px; font-weight: 800; color: #0f172a; margin-bottom: 30px; }
        .checkout-layout { display: grid; grid-template-columns: 2fr 1.2fr; gap: 40px; }
        
        .checkout-section { background: white; border-radius: 24px; padding: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); margin-bottom: 30px; }
        .checkout-section h3 { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 24px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 10px; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; font-size: 14px; color: #334155; margin-bottom: 8px; }
        .form-group input, .form-group textarea { width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; font-family: inherit; font-size: 15px; transition: border-color 0.2s; box-sizing: border-box; }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        
        .payment-methods { display: flex; flex-direction: column; gap: 15px; }
        .payment-method { border: 1px solid #cbd5e1; border-radius: 12px; padding: 16px; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 12px; }
        .payment-method:hover { border-color: #94a3b8; background: #f8fafc; }
        .payment-method input[type="radio"] { width: 20px; height: 20px; accent-color: #0f172a; }
        .payment-method .method-info { flex: 1; }
        .payment-method .method-name { font-weight: 600; color: #0f172a; font-size: 15px; display: block; }
        .payment-method .method-desc { font-size: 13px; color: #64748b; margin-top: 4px; display: block; }
        
        .order-summary { background: white; border-radius: 24px; padding: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); position: sticky; top: 20px; }
        .order-summary h3 { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 20px; }
        .summary-items { max-height: 300px; overflow-y: auto; margin-bottom: 20px; padding-right: 10px; }
        .summary-items::-webkit-scrollbar { width: 6px; }
        .summary-items::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        .s-item { display: flex; align-items: center; gap: 15px; margin-bottom: 15px; }
        .s-item-img { width: 60px; height: 60px; border-radius: 8px; object-fit: cover; border: 1px solid #f1f5f9; position: relative; }
        .s-item-qty { position: absolute; top: -8px; right: -8px; background: #64748b; color: white; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; }
        .s-item-info { flex: 1; }
        .s-item-name { font-size: 14px; font-weight: 600; color: #0f172a; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .s-item-price { font-size: 14px; font-weight: 600; color: #ef4444; }
        
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: #475569; }
        .summary-total { display: flex; justify-content: space-between; margin-top: 20px; padding-top: 20px; border-top: 1px solid #f1f5f9; font-size: 18px; font-weight: 800; color: #0f172a; }
        
        .btn-submit { display: block; width: 100%; background: #0f172a; color: white; text-align: center; padding: 18px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 16px; margin-top: 25px; border: none; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(15, 23, 42, 0.15); }
        .btn-submit:hover { background: #1e293b; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(15, 23, 42, 0.25); }
        
        .error-message { color: #ef4444; font-size: 13px; margin-top: 5px; }

        @media (max-width: 992px) {
            .checkout-layout { grid-template-columns: 1fr; }
            .order-summary { position: static; margin-top: 30px; }
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
                <a href="{{ route('cart.index') }}" style="color: white; text-decoration: none; font-weight: 600; margin-right: 20px;">
                    <i class="fas fa-arrow-left"></i> Quay lại giỏ hàng
                </a>
            </div>
        </div>
    </header>

    <div class="checkout-container">
        <h1 class="checkout-header">Thanh toán</h1>
        
        @if(session('error'))
            <div style="background: #fef2f2; border: 1px solid #ef4444; color: #b91c1c; padding: 15px; border-radius: 12px; margin-bottom: 30px; font-weight: 500;">
                <i class="fas fa-times-circle"></i> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="checkout-layout">
                <div class="checkout-forms">
                    <div class="checkout-section">
                        <h3><i class="far fa-address-card"></i> Thông tin giao hàng</h3>
                        
                        <div class="form-group">
                            <label>Họ và tên</label>
                            <input type="text" name="name" value="{{ old('name', $user->fullname) }}" required placeholder="Nhập họ và tên...">
                            @error('name') <div class="error-message">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" required placeholder="Nhập số điện thoại...">
                            @error('phone') <div class="error-message">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Địa chỉ giao hàng chi tiết</label>
                            <textarea name="address" rows="3" required placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố...">{{ old('address', $user->address ?? '') }}</textarea>
                            @error('address') <div class="error-message">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="checkout-section">
                        <h3><i class="far fa-credit-card"></i> Phương thức thanh toán</h3>
                        
                        <div class="payment-methods">
                            <label class="payment-method">
                                <input type="radio" name="payment_method" value="cod" checked>
                                <div class="method-info">
                                    <span class="method-name">Thanh toán khi nhận hàng (COD)</span>
                                    <span class="method-desc">Bạn sẽ thanh toán bằng tiền mặt khi nhân viên giao hàng tới.</span>
                                </div>
                                <i class="fas fa-money-bill-wave" style="font-size: 24px; color: #64748b;"></i>
                            </label>
                            
                            <label class="payment-method">
                                <input type="radio" name="payment_method" value="bank_transfer">
                                <div class="method-info">
                                    <span class="method-name">Chuyển khoản ngân hàng</span>
                                    <span class="method-desc">Chuyển khoản trước qua tài khoản ngân hàng của cửa hàng.</span>
                                </div>
                                <i class="fas fa-university" style="font-size: 24px; color: #64748b;"></i>
                            </label>
                        </div>
                        @error('payment_method') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div>
                    <div class="order-summary">
                        <h3>Đơn hàng của bạn</h3>
                        <div class="summary-items">
                            @foreach($cart as $item)
                                <div class="s-item">
                                    <div style="position: relative;">
                                        <img src="{{ $item['image'] }}" class="s-item-img">
                                        <div class="s-item-qty">{{ $item['quantity'] }}</div>
                                    </div>
                                    <div class="s-item-info">
                                        <div class="s-item-name">{{ $item['name'] }}</div>
                                        <div class="s-item-price">{{ number_format($item['price'], 0, ',', '.') }}đ</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div style="border-top: 1px solid #f1f5f9; padding-top: 20px;">
                            <div class="summary-row">
                                <span>Tạm tính:</span>
                                <span>{{ number_format($total, 0, ',', '.') }}đ</span>
                            </div>
                            <div class="summary-row">
                                <span>Phí vận chuyển:</span>
                                <span>Miễn phí</span>
                            </div>
                            <div class="summary-total">
                                <span>Tổng cộng:</span>
                                <span style="color: #ef4444;">{{ number_format($total, 0, ',', '.') }}đ</span>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-submit">Hoàn tất đặt hàng</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
