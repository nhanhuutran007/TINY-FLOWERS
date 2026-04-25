<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công - Tiny Flowers</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .success-card { background: white; border-radius: 24px; padding: 50px 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); text-align: center; max-width: 500px; width: 100%; margin: 20px; }
        .icon-wrapper { width: 80px; height: 80px; background: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; }
        .icon-wrapper i { font-size: 40px; color: #10b981; }
        h1 { font-size: 28px; font-weight: 800; color: #0f172a; margin-bottom: 15px; }
        p { font-size: 16px; color: #64748b; line-height: 1.6; margin-bottom: 30px; }
        .order-info { background: #f8fafc; border-radius: 12px; padding: 20px; margin-bottom: 30px; border: 1px dashed #cbd5e1; }
        .order-info strong { color: #0f172a; font-size: 18px; display: block; margin-bottom: 10px; }
        .btn-home { display: inline-block; background: #0f172a; color: white; padding: 15px 30px; border-radius: 12px; text-decoration: none; font-weight: 600; transition: all 0.3s; }
        .btn-home:hover { background: #1e293b; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(15, 23, 42, 0.2); }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="icon-wrapper">
            <i class="fas fa-check"></i>
        </div>
        <h1>Đặt hàng thành công!</h1>
        <p>Cảm ơn bạn đã mua sắm tại Tiny Flowers. Đơn hàng của bạn đã được ghi nhận và sẽ sớm được xử lý.</p>
        
        <div class="order-info">
            Mã đơn hàng của bạn:
            <strong>{{ $order->order_number }}</strong>
            Tổng thanh toán: <span style="color: #ef4444; font-weight: 700;">{{ number_format($order->total_amount, 0, ',', '.') }}đ</span>
        </div>
        
        <a href="{{ route('home') }}" class="btn-home">Quay lại trang chủ</a>
    </div>
</body>
</html>
