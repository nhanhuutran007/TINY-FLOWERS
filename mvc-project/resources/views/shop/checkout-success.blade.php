<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công - Tiny Flowers</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; margin: 0; color: #0f172a; display: flex; flex-direction: column; min-height: 100vh; }
        .checkout-header { background: white; padding: 20px 5%; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: center;}
        .logo-area { text-decoration: none; display: flex; align-items: center; gap: 10px; color: #0f172a; }
        .logo-circle { width: 40px; height: 40px; background: linear-gradient(135deg, #FF7EB3, #7AF5FF); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; color: white; font-size: 18px; box-shadow: 0 2px 5px rgba(255,126,179,0.3); }
        .brand-name { font-size: 20px; font-weight: 800; letter-spacing: -0.5px; }
        
        .success-container { max-width: 600px; margin: 60px auto; background: white; border-radius: 16px; padding: 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); text-align: center; }
        
        .success-icon { width: 80px; height: 80px; background: #dcfce7; color: #22c55e; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
        .success-title { font-size: 24px; font-weight: 800; margin: 0 0 10px; }
        .success-desc { color: #64748b; margin: 0 0 30px; line-height: 1.6; }
        
        .order-info { background: #f8fafc; border-radius: 8px; padding: 20px; text-align: left; margin-bottom: 30px; border: 1px solid #e2e8f0; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px dashed #cbd5e1; }
        .info-row:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }
        .info-label { color: #64748b; font-weight: 500; }
        .info-value { font-weight: 700; color: #0f172a; }
        
        .btn-home { display: inline-block; background: #0f172a; color: white; text-decoration: none; padding: 14px 30px; border-radius: 8px; font-weight: 600; transition: background 0.2s; }
        .btn-home:hover { background: #1e293b; }
    </style>
</head>
<body>

    <header class="checkout-header">
        <a href="{{ route('home') }}" class="logo-area">
            <div class="logo-circle">TF</div>
            <span class="brand-name">Tiny Flowers</span>
        </a>
    </header>

    <div class="success-container">
        <div class="success-icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>
        <h1 class="success-title">Đặt hàng thành công!</h1>
        <p class="success-desc">Cảm ơn bạn đã mua sắm tại Tiny Flowers.<br>Đơn hàng của bạn đã được ghi nhận và sẽ sớm được xử lý.</p>
        
        <div class="order-info">
            <div class="info-row">
                <span class="info-label">Mã đơn hàng:</span>
                <span class="info-value">{{ $order->order_number }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Khách hàng:</span>
                <span class="info-value">{{ $order->customer->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tổng thanh toán:</span>
                <span class="info-value" style="color: #ef4444;">{{ number_format($order->total_amount) }}đ</span>
            </div>
            <div class="info-row">
                <span class="info-label">Phương thức:</span>
                <span class="info-value">{{ $order->payment_method == 'cash' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản' }}</span>
            </div>
        </div>
        
        <a href="{{ route('home') }}" class="btn-home">Tiếp tục mua sắm</a>
    </div>

    <script>
        // Clear the cart since the order was successful
        localStorage.removeItem('tiny_flowers_cart');
    </script>
</body>
</html>
