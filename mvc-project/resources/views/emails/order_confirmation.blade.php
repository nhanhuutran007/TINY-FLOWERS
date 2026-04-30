<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Xác nhận đơn hàng - Tiny Flowers</title>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        body { 
            margin: 0; 
            padding: 0; 
            background-color: #FAFAFA; 
            font-family: 'Plus Jakarta Sans', Arial, Helvetica, sans-serif;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        
        table { border-collapse: collapse !important; mso-table-lspace: 0; mso-table-rspace: 0; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; outline: 0; text-decoration: none; }
        
        .container { width: 100%; max-width: 630px !important; margin: 0 auto; background-color: #ffffff; border: 1px solid #E2E8F0; }
        
        .header-content { background-color: #000000; padding: 40px 20px; text-align: center; }
        .logo-img { width: 60px; height: 60px; display: block; margin: 0 auto 10px; }
        .brand-name { color: #ffffff; font-size: 22px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; display: block; }
        
        .body-content { padding: 40px 30px; color: #1E293B; font-size: 15px; line-height: 160%; text-align: left; }
        .footer-content { background-color: #F8FAFC; border-top: 1px solid #E2E8F0; padding: 40px 20px; text-align: center; color: #64748B; font-size: 12px; }
        
        .title { color: #000000; font-size: 26px; font-weight: 700; line-height: 34px; text-align: center; margin-bottom: 25px; font-family: 'Plus Jakarta Sans', Arial, Helvetica, sans-serif; }
        .greeting { color: #000000; font-size: 16px; font-weight: 700; margin-bottom: 10px; }
        
        .invoice-box { background-color: #F8FAFC; padding: 25px; margin: 25px 0; border: 1px solid #E2E8F0; border-radius: 4px; }
        .invoice-row { padding: 10px 0; display: table; width: 100%; }
        .invoice-label { display: table-cell; width: 45%; font-weight: 500; color: #64748B; font-size: 14px; }
        .invoice-value { display: table-cell; width: 55%; text-align: right; font-weight: 700; color: #000000; font-size: 14px; }
        .dashed-border { border-top: 1px dashed #CBD5E1; border-bottom: 1px dashed #CBD5E1; }
        
        .items-table { width: 100%; margin: 30px 0; border-collapse: collapse; }
        .items-table th { border-bottom: 2px solid #000000; padding: 12px 10px; text-align: left; font-size: 13px; color: #000000; font-weight: 800; }
        .items-table td { padding: 15px 10px; border-bottom: 1px solid #F1F5F9; font-size: 14px; color: #1E293B; }
        
        .summary-table { width: 100%; margin-top: 20px; }
        .summary-row td { padding: 6px 0; font-size: 14px; color: #64748B; }
        .total-row td { padding-top: 15px; font-size: 18px; font-weight: 800; color: #000000; border-top: 1px solid #E2E8F0; }
        
        .button { background-color: #000000; color: #ffffff !important; padding: 16px 35px; text-decoration: none; border-radius: 4px; font-weight: 700; display: inline-block; margin: 30px 0; font-size: 14px; letter-spacing: 1px; }
        
        .social-icons { margin-bottom: 25px; }
        .social-icons a { margin: 0 10px; text-decoration: none; }
        
        @media only screen and (max-width: 640px) {
            .container { width: 100% !important; border: none !important; }
            .body-content { padding: 30px 20px !important; }
        }
    </style>
</head>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    <center>
        <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
            <tr>
                <td align="center" valign="top" id="bodyCell" style="padding: 20px 0;">
                    <table border="0" cellpadding="0" cellspacing="0" class="container">
                        <!-- Header with Brand Name Only -->
                        <tr>
                            <td align="center" valign="top" class="header-content">
                                <span class="brand-name">Tiny Flowers</span>
                            </td>
                        </tr>
                        
                        <!-- Main Content -->
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td valign="top" class="body-content">
                                            <div class="title">Xác nhận đơn hàng thành công</div>
                                            
                                            <div class="greeting">Chào {{ $order->customer->name ?? 'bạn' }},</div>
                                            <div>Cảm ơn bạn đã lựa chọn <strong>Tiny Flowers</strong>. Đơn hàng của bạn đã được hệ thống ghi nhận và đang bắt đầu quá trình chuẩn bị.</div>
                                            
                                            <!-- Order Summary Box -->
                                            <div class="invoice-box">
                                                <div class="invoice-row">
                                                    <span class="invoice-label">Mã đơn hàng:</span>
                                                    <span class="invoice-value">#{{ $order->order_number }}</span>
                                                </div>
                                                <div class="invoice-row dashed-border">
                                                    <span class="invoice-label">Ngày đặt:</span>
                                                    <span class="invoice-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                                </div>
                                                <div class="invoice-row dashed-border">
                                                    <span class="invoice-label">Thanh toán:</span>
                                                    <span class="invoice-value">
                                                        @if($order->payment_method == 'qr') Chuyển khoản QR
                                                        @elseif($order->payment_method == 'card') Thẻ tín dụng
                                                        @else COD (Nhận hàng trả tiền)
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="invoice-row">
                                                    <span class="invoice-label">Trạng thái:</span>
                                                    <span class="invoice-value" style="color: {{ $order->payment_status == 'paid' ? '#10B981' : '#F59E0B' }}">
                                                        {{ $order->payment_status == 'paid' ? 'Đã thanh toán' : 'Chờ xác nhận' }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Shipping Details -->
                                            <div style="font-weight: 800; color: #000000; font-size: 15px; letter-spacing: 0.5px; margin-bottom: 10px;">Thông tin nhận hàng</div>
                                            <div style="background-color: #F8FAFC; padding: 20px; border-radius: 4px; border-left: 4px solid #000000;">
                                                <div style="margin-bottom: 4px;"><strong>{{ $order->customer->name ?? 'Khách hàng' }}</strong></div>
                                                <div style="margin-bottom: 4px;">SĐT: {{ $order->customer->phone ?? 'N/A' }}</div>
                                                <div style="color: #64748B; font-size: 14px;">{{ $order->shipping_address }}</div>
                                            </div>
                                            
                                            <!-- Items Table -->
                                            <table class="items-table" border="0" cellpadding="0" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th width="65%">Sản phẩm</th>
                                                        <th width="10%" style="text-align: center;">SL</th>
                                                        <th width="25%" style="text-align: right;">Giá</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order->items as $item)
                                                    <tr>
                                                        <td><strong>{{ $item->product_name }}</strong></td>
                                                        <td style="text-align: center;">{{ $item->quantity }}</td>
                                                        <td style="text-align: right; font-weight: 700;">{{ number_format($item->subtotal) }}đ</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            
                                            <!-- Totals Summary -->
                                            <table class="summary-table" border="0" cellpadding="0" cellspacing="0">
                                                <tr class="summary-row">
                                                    <td width="70%" style="text-align: right; padding-right: 20px;">Tạm tính:</td>
                                                    <td width="30%" style="text-align: right;">{{ number_format($order->subtotal) }}đ</td>
                                                </tr>
                                                <tr class="summary-row">
                                                    <td style="text-align: right; padding-right: 20px;">Phí giao hàng:</td>
                                                    <td style="text-align: right;">{{ number_format($order->shipping_fee) }}đ</td>
                                                </tr>
                                                @if($order->discount > 0)
                                                <tr class="summary-row">
                                                    <td style="text-align: right; padding-right: 20px;">Giảm giá:</td>
                                                    <td style="text-align: right; color: #10B981;">-{{ number_format($order->discount) }}đ</td>
                                                </tr>
                                                @endif
                                                <tr class="total-row">
                                                    <td style="text-align: right; padding-right: 20px; font-weight: 800;">Tổng cộng:</td>
                                                    <td style="text-align: right;">{{ number_format($order->total_amount) }}đ</td>
                                                </tr>
                                            </table>
                                            
                                            <div style="text-align: center;">
                                                <a href="{{ route('profile.orders') }}" class="button">Theo dõi đơn hàng</a>
                                            </div>
                                            
                                            <div style="margin-top: 30px; border-top: 1px solid #F1F5F9; padding-top: 25px; text-align: center;">
                                                <div style="font-weight: 700; color: #000000; margin-bottom: 5px;">Cần hỗ trợ?</div>
                                                <div style="font-size: 14px; color: #64748B;">
                                                    Hotline: 1900 1234<br>
                                                    Email: support@tinyflowers.com
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                        <!-- Footer Section -->
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer-content">
                                    <tr>
                                        <td align="center" valign="top">
                                            <div class="social-icons">
                                                <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" width="18" height="18" alt="FB" /></a>
                                                <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" width="18" height="18" alt="IG" /></a>
                                                <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/3046/3046121.png" width="18" height="18" alt="TikTok" /></a>
                                            </div>
                                            
                                            <div style="color: #1E293B; font-weight: 800; font-size: 14px; letter-spacing: 1px; margin-bottom: 15px;">TINY FLOWERS STREETWEAR</div>
                                            
                                            <div class="contact-info">
                                                <div class="contact-item">265 Hồng Lạc, Phường 7, Quận Tân Bình, TP. HCM</div>
                                                <div class="contact-item">© {{ date('Y') }} Tiny Flowers. All rights reserved.</div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>



