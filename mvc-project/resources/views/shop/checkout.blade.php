<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - Tiny Flowers</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; margin: 0; color: #0f172a; }
        .checkout-header { background: white; padding: 20px 5%; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; align-items: center; }
        .logo-area { text-decoration: none; display: flex; align-items: center; gap: 10px; color: #0f172a; }
        .logo-circle { width: 40px; height: 40px; background: linear-gradient(135deg, #FF7EB3, #7AF5FF); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; color: white; font-size: 18px; box-shadow: 0 2px 5px rgba(255,126,179,0.3); }
        .brand-name { font-size: 20px; font-weight: 800; letter-spacing: -0.5px; }
        
        .checkout-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; display: grid; grid-template-columns: 1.5fr 1fr; gap: 40px; }
        @media (max-width: 768px) { .checkout-container { grid-template-columns: 1fr; } }
        
        .card { background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .card-title { font-size: 18px; font-weight: 700; margin-top: 0; margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; color: #475569; margin-bottom: 8px; }
        .form-control { width: 100%; padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 15px; font-family: 'Inter', sans-serif; transition: border-color 0.2s; box-sizing: border-box; }
        .form-control:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
        
        .payment-methods { display: flex; flex-direction: column; gap: 10px; }
        .payment-method { border: 1px solid #cbd5e1; border-radius: 8px; padding: 15px; display: flex; align-items: center; gap: 15px; cursor: pointer; transition: all 0.2s; }
        .payment-method:hover { border-color: #94a3b8; background: #f8fafc; }
        .payment-method input[type="radio"] { width: 18px; height: 18px; accent-color: #0f172a; }
        .payment-method.active { border-color: #0f172a; background: #f8fafc; }

        .order-summary { position: sticky; top: 20px; }
        .cart-items { display: flex; flex-direction: column; gap: 15px; margin-bottom: 20px; max-height: 400px; overflow-y: auto; padding-right: 10px; }
        .cart-item { display: flex; gap: 15px; align-items: center; }
        .item-image { width: 64px; height: 64px; border-radius: 8px; object-fit: cover; background: #f1f5f9; }
        .item-details { flex: 1; }
        .item-name { font-weight: 600; font-size: 15px; margin: 0 0 4px 0; }
        .item-qty { font-size: 13px; color: #64748B; margin: 0; }
        .item-price { font-weight: 600; font-size: 15px; margin: 0; }
        
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 15px; color: #475569; }
        .summary-total { display: flex; justify-content: space-between; margin-top: 15px; padding-top: 15px; border-top: 1px solid #e2e8f0; font-size: 18px; font-weight: 700; color: #0f172a; }
        
        .btn-checkout { background: #0f172a; color: white; border: none; width: 100%; padding: 16px; border-radius: 8px; font-size: 16px; font-weight: 700; cursor: pointer; transition: background 0.2s; margin-top: 20px; }
        .btn-checkout:hover { background: #1e293b; }
        
        /* Alert */
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; }
        .alert-error { background: #fef2f2; color: #ef4444; border: 1px solid #fecaca; }
        
        .empty-cart-msg { text-align: center; padding: 40px 0; color: #64748b; }
    </style>
</head>
<body>

    <header class="checkout-header">
        <a href="{{ route('home') }}" class="logo-area">
            <div class="logo-circle">TF</div>
            <span class="brand-name">Tiny Flowers</span>
        </a>
        <div style="margin-left: auto; font-weight: 600; color: #64748b;">
            <svg style="vertical-align: middle; margin-right: 5px;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            Thanh toán an toàn
        </div>
    </header>

    <div class="checkout-container">
        @if(session('error'))
            <div class="alert alert-error" style="grid-column: 1 / -1;">
                {{ session('error') }}
            </div>
        @endif

        <div class="checkout-form-area">
            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                @csrf
                <input type="hidden" name="cart_data" id="cart_data">
                
                <div class="card">
                    <h2 class="card-title">1. Thông tin giao hàng</h2>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label>Họ và tên</label>
                            <input type="text" name="name" class="form-control" required placeholder="Nhập họ và tên người nhận">
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label>Số điện thoại</label>
                            <input type="tel" name="phone" class="form-control" required placeholder="Ví dụ: 0912345678">
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label>Địa chỉ nhận hàng chi tiết</label>
                            <input type="text" name="address" class="form-control" required placeholder="Số nhà, Tên đường, Phường/Xã, Quận/Huyện, Tỉnh/Thành phố">
                        </div>
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label>Ghi chú đơn hàng (tuỳ chọn)</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Ghi chú thêm về đơn hàng hoặc thời gian giao hàng..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h2 class="card-title">2. Phương thức thanh toán</h2>
                    <div class="payment-methods">
                        <label class="payment-method active">
                            <input type="radio" name="payment_method" value="cash" checked onchange="updatePaymentUI(this)">
                            <div>
                                <div style="font-weight: 600;">Thanh toán khi nhận hàng (COD)</div>
                                <div style="font-size: 13px; color: #64748B;">Thanh toán bằng tiền mặt khi giao hàng.</div>
                            </div>
                        </label>
                        <label class="payment-method">
                            <input type="radio" name="payment_method" value="transfer" onchange="updatePaymentUI(this)">
                            <div>
                                <div style="font-weight: 600;">Chuyển khoản ngân hàng</div>
                                <div style="font-size: 13px; color: #64748B;">Chuyển khoản trực tiếp tới tài khoản ngân hàng của chúng tôi.</div>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-checkout" id="submit-btn" style="display: none;">ĐẶT HÀNG NGAY</button>
            </form>
        </div>

        <div class="order-summary-area">
            <div class="card order-summary">
                <h2 class="card-title">Tổng quan đơn hàng</h2>
                
                <div id="cart-items-container" class="cart-items">
                    <!-- Items injected via JS -->
                </div>
                
                <div id="summary-calculations" style="display: none;">
                    <div class="summary-row">
                        <span>Tạm tính</span>
                        <span id="summary-subtotal">0đ</span>
                    </div>
                    <div class="summary-row">
                        <span>Phí giao hàng</span>
                        <span id="summary-shipping">30,000đ</span>
                    </div>
                    <div class="summary-total">
                        <span>Tổng cộng</span>
                        <span id="summary-total" style="color: #ef4444;">0đ</span>
                    </div>
                    
                    <button onclick="document.getElementById('checkout-form').submit();" class="btn-checkout">ĐẶT HÀNG NGAY</button>
                </div>
                
                <div id="empty-cart-msg" class="empty-cart-msg">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 10px;"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    <p>Giỏ hàng của bạn đang trống.</p>
                    <a href="{{ route('home') }}" style="color: #3b82f6; text-decoration: none; font-weight: 600;">Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updatePaymentUI(radio) {
            document.querySelectorAll('.payment-method').forEach(el => el.classList.remove('active'));
            radio.closest('.payment-method').classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', function() {
            let cart = JSON.parse(localStorage.getItem('tiny_flowers_cart')) || [];
            
            const cartItemsContainer = document.getElementById('cart-items-container');
            const summaryCalc = document.getElementById('summary-calculations');
            const emptyMsg = document.getElementById('empty-cart-msg');
            const cartDataInput = document.getElementById('cart_data');
            
            if (cart.length === 0) {
                cartItemsContainer.style.display = 'none';
                summaryCalc.style.display = 'none';
                emptyMsg.style.display = 'block';
                
                // Disable form inputs
                document.querySelectorAll('#checkout-form input, #checkout-form textarea').forEach(el => el.disabled = true);
            } else {
                cartDataInput.value = JSON.stringify(cart);
                
                cartItemsContainer.style.display = 'flex';
                summaryCalc.style.display = 'block';
                emptyMsg.style.display = 'none';
                
                let subtotal = 0;
                let itemsHtml = '';
                
                cart.forEach(item => {
                    subtotal += (item.price * item.quantity);
                    itemsHtml += `
                        <div class="cart-item">
                            <img src="${item.image}" alt="${item.name}" class="item-image" onerror="this.src='{{ asset('images/default-product.png') }}'">
                            <div class="item-details">
                                <h3 class="item-name">${item.name}</h3>
                                <p class="item-qty">Số lượng: ${item.quantity}</p>
                            </div>
                            <div class="item-price">${(item.price * item.quantity).toLocaleString('vi-VN')}đ</div>
                        </div>
                    `;
                });
                
                cartItemsContainer.innerHTML = itemsHtml;
                
                let shippingFee = subtotal > 1000000 ? 0 : 30000;
                let total = subtotal + shippingFee;
                
                document.getElementById('summary-subtotal').innerText = subtotal.toLocaleString('vi-VN') + 'đ';
                document.getElementById('summary-shipping').innerText = shippingFee === 0 ? 'Miễn phí' : shippingFee.toLocaleString('vi-VN') + 'đ';
                document.getElementById('summary-total').innerText = total.toLocaleString('vi-VN') + 'đ';
            }
        });
        
        // Prevent normal button click if cart is empty
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            let cart = JSON.parse(localStorage.getItem('tiny_flowers_cart')) || [];
            if(cart.length === 0) {
                e.preventDefault();
                alert('Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi thanh toán.');
            }
        });
    </script>
</body>
</html>
