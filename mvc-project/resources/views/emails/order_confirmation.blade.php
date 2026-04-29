<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Xác nhận đơn hàng</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #334155; line-height: 1.6; background-color: #f1f5f9; padding: 20px; margin: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .header { background: #0f172a; padding: 40px 20px; text-align: center; color: white; }
        .logo { width: 50px; height: 50px; background-color: #FF7EB3; border-radius: 50%; display: inline-block; line-height: 50px; font-weight: 900; color: white; font-size: 20px; margin-bottom: 15px; }
        .header h1 { margin: 0; font-size: 26px; font-weight: 800; letter-spacing: 2px; }
        .content { padding: 40px 30px; }
        .success-text { color: #10b981; font-weight: 800; font-size: 20px; margin-bottom: 10px; text-align: center; }
        .order-info { background: #f8fafc; padding: 25px; border-radius: 12px; margin-bottom: 30px; border: 1px solid #e2e8f0; }
        .order-info h3 { margin-top: 0; color: #0f172a; font-size: 15px; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #e2e8f0; padding-bottom: 12px; margin-bottom: 15px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; }
        .info-label { color: #64748b; font-weight: 500; }
        .info-val { font-weight: 700; color: #0f172a; text-align: right; }
        
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .items-table th { text-align: left; padding: 12px 0; font-size: 12px; font-weight: 700; text-transform: uppercase; color: #64748b; border-bottom: 2px solid #e2e8f0; }
        .items-table td { padding: 16px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #0f172a; }
        
        .summary-box { background: #0f172a; color: white; padding: 25px; border-radius: 12px; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: rgba(255,255,255,0.8); }
        .summary-row.total { font-size: 20px; font-weight: 800; color: white; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 15px; margin-top: 15px; }
        
        .btn-track { background: #3b82f6; color: #ffffff !important; text-decoration: none; padding: 14px 30px; border-radius: 30px; font-weight: 700; font-size: 15px; display: inline-block; transition: background 0.3s; }
        .footer { text-align: center; padding: 30px 20px; font-size: 13px; color: #94a3b8; background: #f8fafc; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">TF</div>
            <h1>TINY FLOWERS</h1>
            <p style="margin: 8px 0 0; color: #94a3b8; font-size: 15px; font-weight: 500;">XÁC NHẬN ĐẶT HÀNG THÀNH CÔNG</p>
        </div>
        
        <div class="content">
            <div class="success-text">Cảm ơn bạn đã mua sắm tại Tiny Flowers!</div>
            <p style="text-align: center; font-size: 14px; color: #475569; margin-bottom: 30px;">Đơn hàng <strong>#{{ $order->order_number }}</strong> của bạn đã được tiếp nhận và đang được xử lý.</p>
            
            <div class="order-info">
                <h3>Thông tin giao hàng</h3>
                <div class="info-row">
                    <span class="info-label">Người nhận:</span>
                    <span class="info-val">{{ $order->customer->name ?? 'Khách hàng' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Số điện thoại:</span>
                    <span class="info-val">{{ $order->customer->phone ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Địa chỉ:</span>
                    <span class="info-val">{{ $order->shipping_address }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phương thức thanh toán:</span>
                    <span class="info-val">
                        @if($order->payment_method == 'qr') Chuyển khoản QR
                        @elseif($order->payment_method == 'card') Thẻ tín dụng
                        @else Thanh toán khi nhận hàng (COD)
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Trạng thái thanh toán:</span>
                    <span class="info-val" style="color: {{ $order->payment_status == 'paid' ? '#10b981' : '#f59e0b' }}">
                        {{ $order->payment_status == 'paid' ? 'Đã thanh toán' : 'Chờ thanh toán' }}
                    </span>
                </div>
            </div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>SL</th>
                        <th style="text-align: right;">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td><strong>{{ $item->product_name }}</strong></td>
                        <td>{{ $item->quantity }}</td>
                        <td style="text-align: right; font-weight: 600;">{{ number_format($item->subtotal) }}đ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="summary-box">
                <div class="summary-row">
                    <span>Tạm tính</span>
                    <span>{{ number_format($order->subtotal) }}đ</span>
                </div>
                <div class="summary-row">
                    <span>Phí vận chuyển</span>
                    <span>{{ number_format($order->shipping_fee) }}đ</span>
                </div>
                @if($order->discount > 0)
                <div class="summary-row">
                    <span>Giảm giá</span>
                    <span style="color: #10b981;">-{{ number_format($order->discount) }}đ</span>
                </div>
                @endif
                <div class="summary-row total">
                    <span>Tổng cộng</span>
                    <span>{{ number_format($order->total_amount) }}đ</span>
                </div>
                <div class="summary-row" style="margin-top: 5px; font-size: 13px; opacity: 0.8;">
                    <span>Số tiền đã thanh toán</span>
                    <span>{{ $order->payment_status == 'paid' ? number_format($order->total_amount) : '0' }}đ</span>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 40px;">
                <a href="{{ url('/profile/orders') }}" class="btn-track">XEM CHI TIẾT ĐƠN HÀNG</a>
            </div>
        </div>
        
        <div class="footer">
            Đây là email tự động, vui lòng không trả lời.<br>
            © {{ date('Y') }} Tiny Flowers. All rights reserved.
        </div>
    </div>
</body>
</html>
