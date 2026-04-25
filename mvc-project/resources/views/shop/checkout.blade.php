<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - Tiny Flowers</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0f172a;
            --primary-light: #3b82f6;
            --bg: #f8fafc;
            --text: #0f172a;
            --text-light: #64748b;
            --border: #e2e8f0;
            --card-bg: #ffffff;
            --success: #10b981;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background: var(--bg); 
            margin: 0; 
            color: var(--text); 
            line-height: 1.5;
        }

        .checkout-header { 
            background: white; 
            padding: 15px 5%; 
            box-shadow: 0 1px 2px rgba(0,0,0,0.05); 
            display: flex; 
            align-items: center; 
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .logo-area { text-decoration: none; display: flex; align-items: center; gap: 10px; color: var(--text); }
        .logo-circle { width: 35px; height: 35px; background: linear-gradient(135deg, #FF7EB3, #7AF5FF); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; color: white; font-size: 16px; }
        .brand-name { font-size: 18px; font-weight: 800; letter-spacing: -0.5px; }

        .checkout-container { 
            max-width: 1200px; 
            margin: 30px auto; 
            padding: 0 20px; 
            display: grid; 
            grid-template-columns: 1fr 380px; 
            gap: 30px; 
            align-items: start;
        }

        @media (max-width: 992px) {
            .checkout-container { grid-template-columns: 1fr; }
        }

        /* Stepper */
        .stepper {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .stepper::before {
            content: '';
            position: absolute;
            top: 16px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--border);
            z-index: 1;
        }

        .step {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: white;
            border: 2px solid var(--border);
            color: var(--text-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.3s;
        }

        .step.active .step-circle {
            border-color: var(--primary-light);
            background: var(--primary-light);
            color: white;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .step.completed .step-circle {
            border-color: var(--success);
            background: var(--success);
            color: white;
        }

        .step-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-light);
            white-space: nowrap;
        }

        .step.active .step-label { color: var(--text); }

        /* Forms */
        .card { 
            background: var(--card-bg); 
            border-radius: 16px; 
            padding: 30px; 
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); 
            margin-bottom: 20px;
        }

        .card-title { 
            font-size: 20px; 
            font-weight: 700; 
            margin: 0 0 25px 0; 
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--text);
        }

        .edit-icon {
            color: var(--primary-light);
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group { margin-bottom: 15px; }
        .form-group.full { grid-column: span 2; }
        
        .form-group label { 
            display: block; 
            font-size: 13px; 
            font-weight: 600; 
            color: #475569; 
            margin-bottom: 8px; 
        }

        .form-control { 
            width: 100%; 
            padding: 12px 16px; 
            border: 1px solid var(--border); 
            border-radius: 10px; 
            font-size: 14px; 
            background: #fcfdfe;
            color: var(--text);
            transition: all 0.2s;
            box-sizing: border-box;
        }

        .form-control:focus { 
            outline: none; 
            border-color: var(--primary-light); 
            background: white;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.1); 
        }

        /* Payment Methods */
        .payment-option {
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .payment-option:hover { border-color: var(--primary-light); background: #fbfcfe; }
        .payment-option.active { border-color: var(--primary-light); background: #f0f7ff; }

        .payment-header {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .payment-header input { width: 20px; height: 20px; margin: 0; cursor: pointer; accent-color: var(--primary-light); }
        .payment-header label { font-weight: 600; font-size: 16px; cursor: pointer; flex: 1; color: var(--text); }

        .payment-icons { display: flex; gap: 10px; flex-wrap: wrap; }
        .payment-icon { height: 20px; width: auto; }

        .payment-details {
            padding-left: 35px;
            margin-top: 15px;
            display: none;
        }

        .payment-option.active .payment-details { display: block; }
        .payment-desc { font-size: 13px; color: var(--text-light); margin-bottom: 15px; line-height: 1.6; }

        /* Sidebar Summary */
        .order-summary-card { position: sticky; top: 100px; }
        
        .summary-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            align-items: center;
        }

        .summary-img { width: 56px; height: 56px; border-radius: 10px; background: #f1f5f9; object-fit: cover; }
        .summary-info { flex: 1; }
        .summary-name { font-size: 14px; font-weight: 600; margin: 0 0 4px 0; color: var(--text); }
        .summary-price { font-size: 13px; color: var(--text-light); }
        .summary-qty { font-size: 13px; font-weight: 700; color: var(--text); }

        .payment-box {
            background: white;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .summary-divider { height: 1px; background: var(--border); margin: 20px 0; }
        
        .summary-row { display: flex; justify-content: space-between; font-size: 15px; margin-bottom: 12px; color: var(--text-light); }
        .summary-total { font-size: 20px; font-weight: 800; margin-top: 20px; display: flex; justify-content: space-between; color: var(--text); }

        /* Navigation Buttons */
        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding: 0 10px;
        }

        .btn {
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-outline {
            background: white;
            border: 1.5px solid var(--border);
            color: var(--text);
        }

        .btn-outline:hover { border-color: var(--text); background: #f8fafc; }

        .btn-primary {
            background: #3b82f6;
            border: none;
            color: white;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
        }

        .btn-primary:hover { background: #2563eb; transform: translateY(-1px); }

        /* Transitions */
        .step-content { display: none; }
        .step-content.active { display: block; animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1); }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Review Section Styles */
        .review-block { margin-bottom: 25px; border-bottom: 1px solid var(--border); padding-bottom: 25px; }
        .review-block:last-child { border-bottom: none; }
        .review-title { font-size: 13px; font-weight: 700; color: var(--text-light); margin-bottom: 15px; text-transform: uppercase; letter-spacing: 1px; }
        .review-data { font-size: 15px; color: var(--text); line-height: 1.6; }
        .review-data p { margin: 4px 0; }
    </style>
</head>
<body>

    <header class="checkout-header">
        <a href="{{ route('home') }}" class="logo-area">
            <div class="logo-circle">TF</div>
            <span class="brand-name">Tiny Flowers</span>
        </a>
    </header>

    <div class="checkout-container">
        <div class="checkout-main">
            <!-- Stepper -->
            <div class="stepper">
                <div class="step active" id="step-1-indicator">
                    <div class="step-circle">1</div>
                    <span class="step-label">Thông tin giao hàng</span>
                </div>
                <div class="step" id="step-2-indicator">
                    <div class="step-circle">2</div>
                    <span class="step-label">Thanh toán</span>
                </div>
                <div class="step" id="step-3-indicator">
                    <div class="step-circle">3</div>
                    <span class="step-label">Hoàn tất</span>
                </div>
            </div>

            <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <input type="hidden" name="cart_data" id="cart_data_input">
                
                <!-- Step 1: Billing Info -->
                <div class="step-content active" id="step-1-content">
                    <div class="card">
                        <h2 class="card-title">Thông tin giao hàng</h2>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Họ và tên</label>
                                <input type="text" name="name" id="billing_name" class="form-control" placeholder="Nguyễn Văn A" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" id="billing_email" class="form-control" placeholder="nguyenvana@gmail.com" required>
                            </div>
                            <div class="form-group full">
                                <label>Địa chỉ</label>
                                <input type="text" name="address" id="billing_address" class="form-control" placeholder="Số nhà, Tên đường, Phường/Xã..." required>
                            </div>
                            <div class="form-group">
                                <label>Thành phố / Tỉnh</label>
                                <input type="text" name="city" id="billing_city" class="form-control" placeholder="Hồ Chí Minh">
                            </div>
                            <div class="form-group">
                                <label>Mã ZIP (tuỳ chọn)</label>
                                <input type="text" name="zip" id="billing_zip" class="form-control" placeholder="700000">
                            </div>
                            <div class="form-group">
                                <label>Quốc gia</label>
                                <select name="country" id="billing_country" class="form-control">
                                    <option value="Vietnam" selected>Việt Nam</option>
                                    <option value="USA">Hoa Kỳ</option>
                                    <option value="Japan">Nhật Bản</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="tel" name="phone" id="billing_phone" class="form-control" placeholder="0901 234 567" required>
                            </div>
                        </div>
                        <div style="margin-top: 20px; border-top: 1px solid var(--border); padding-top: 20px;">
                            <label style="display: flex; align-items: center; gap: 12px; font-size: 14px; cursor: pointer; color: var(--text);">
                                <input type="radio" name="delivery_addr" value="same" checked> Sử dụng cùng địa chỉ cho việc giao hàng
                            </label>
                            <label style="display: flex; align-items: center; gap: 12px; font-size: 14px; cursor: pointer; margin-top: 12px; color: var(--text);">
                                <input type="radio" name="delivery_addr" value="other"> Sử dụng địa chỉ giao hàng khác
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Payment Method -->
                <div class="step-content" id="step-2-content">
                    <div class="card">
                        <h2 class="card-title">Phương thức thanh toán</h2>
                        
                        <!-- Credit Card -->
                        <div class="payment-option active" onclick="selectPayment('card')">
                            <div class="payment-header">
                                <input type="radio" name="payment_method" value="card" id="pay_card" checked>
                                <label for="pay_card">Thẻ Tín dụng / Ghi nợ</label>
                                <div class="payment-icons" style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <!-- Visa -->
                                    <div class="payment-box">
                                        <svg width="69" height="39" viewBox="0 0 69 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="0.5" y="0.5" width="68" height="38" rx="5.5" fill="white" stroke="#EEF0F4"/>
                                            <path d="M25.6677 25.4216H22.4367L20.0139 15.9065C19.8989 15.4688 19.6547 15.0819 19.2956 14.8995C18.3992 14.4412 17.4115 14.0764 16.334 13.8925V13.5262H21.5388C22.2571 13.5262 22.7959 14.0764 22.8857 14.7155L24.1428 21.5791L27.3722 13.5262H30.5133L25.6677 25.4216ZM32.3086 25.4216H29.2573L31.7699 13.5262H34.8213L32.3086 25.4216ZM38.7703 16.8197C38.8601 16.1791 39.3989 15.8127 40.0274 15.8127C41.0151 15.7207 42.0911 15.9047 42.989 16.3614L43.5278 13.8003C42.6298 13.434 41.6421 13.25 40.7458 13.25C37.7842 13.25 35.6292 14.8977 35.6292 17.1845C35.6292 18.9242 37.1556 19.8376 38.2332 20.3879C39.3989 20.9366 39.8478 21.3029 39.7581 21.8516C39.7581 22.6747 38.8601 23.041 37.9638 23.041C36.8863 23.041 35.8088 22.7667 34.8226 22.3083L34.2839 24.8711C35.3614 25.3278 36.5271 25.5118 37.6046 25.5118C40.9254 25.6021 42.989 23.956 42.989 21.4853C42.989 18.3739 38.7703 18.1915 38.7703 16.8197ZM53.6661 25.4216L51.2433 13.5262H48.6409C48.1021 13.5262 47.5634 13.8925 47.3838 14.4412L42.8973 25.4216H46.0385L46.6655 23.6835H50.525L50.8841 25.4216H53.6661ZM49.0903 16.7283L49.9866 21.2115H47.474L49.0903 16.7283Z" fill="#172B85"/>
                                        </svg>
                                    </div>
                                    <!-- Mastercard -->
                                    <div class="payment-box">
                                        <svg width="69" height="39" viewBox="74 0 69 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="74.5" y="0.5" width="68" height="38" rx="5.5" fill="white" stroke="#EEF0F4"/>
                                            <path d="M113.102 12.3376H104.9V27.0769H113.102V12.3376Z" fill="#FF5F00"/>
                                            <path d="M105.421 19.7072C105.419 18.2877 105.741 16.8866 106.361 15.6097C106.982 14.3329 107.884 13.214 109.001 12.3376C107.618 11.2507 105.957 10.5747 104.208 10.387C102.46 10.1993 100.693 10.5074 99.1111 11.2762C97.529 12.0449 96.1952 13.2432 95.262 14.7341C94.3288 16.225 93.834 17.9484 93.834 19.7072C93.834 21.4661 94.3288 23.1895 95.262 24.6804C96.1952 26.1713 97.529 27.3696 99.1111 28.1383C100.693 28.907 102.46 29.2152 104.208 29.0275C105.957 28.8398 107.618 28.1638 109.001 27.0769C107.884 26.2005 106.982 25.0815 106.361 23.8047C105.741 22.5279 105.419 21.1267 105.421 19.7072Z" fill="#EB001B"/>
                                            <path d="M124.167 19.7072C124.167 21.4661 123.673 23.1894 122.739 24.6804C121.806 26.1713 120.473 27.3696 118.891 28.1383C117.309 28.907 115.542 29.2152 113.793 29.0275C112.044 28.8398 110.384 28.1638 109.001 27.0769C110.117 26.1996 111.019 25.0805 111.639 23.8039C112.259 22.5273 112.581 21.1265 112.581 19.7072C112.581 18.288 112.259 16.8872 111.639 15.6106C111.019 14.334 110.117 13.2149 109.001 12.3376C110.384 11.2507 112.044 10.5747 113.793 10.387C115.542 10.1993 117.309 10.5075 118.891 11.2762C120.473 12.0449 121.806 13.2432 122.739 14.7341C123.673 16.225 124.167 17.9484 124.167 19.7072Z" fill="#F79E1B"/>
                                        </svg>
                                    </div>
                                    <!-- MoMo -->
                                    <div class="payment-box">
                                        <svg width="69" height="39" viewBox="0 0 69 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="0.5" y="0.5" width="68" height="38" rx="5.5" fill="white" stroke="#EEF0F4"/>
                                            <rect x="22" y="10" width="25" height="19" rx="3" fill="#A50064"/>
                                            <text x="34.5" y="22" fill="white" font-family="Inter" font-weight="900" font-size="7" text-anchor="middle">MOMO</text>
                                        </svg>
                                    </div>
                                    <!-- VNPay -->
                                    <div class="payment-box">
                                        <svg width="69" height="39" viewBox="0 0 69 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="0.5" y="0.5" width="68" height="38" rx="5.5" fill="white" stroke="#EEF0F4"/>
                                            <rect x="18" y="10" width="33" height="19" rx="3" fill="#005BAA"/>
                                            <text x="34.5" y="22" fill="white" font-family="Inter" font-weight="900" font-size="7" text-anchor="middle">VNPAY</text>
                                        </svg>
                                    </div>
                                    <!-- Apple Pay -->
                                    <div class="payment-box">
                                        <svg width="69" height="39" viewBox="296 0 69 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="296.5" y="0.5" width="68" height="38" rx="5.5" fill="white" stroke="#EEF0F4"/>
                                            <path d="M318.414 15.1727C317.949 15.7638 317.205 16.23 316.461 16.1634C316.368 15.3642 316.733 14.515 317.159 13.9905C317.624 13.3827 318.437 12.9498 319.096 12.9165C319.173 13.749 318.871 14.5649 318.414 15.1727ZM319.088 16.3216C318.433 16.281 317.835 16.5333 317.352 16.7371C317.041 16.8682 316.778 16.9793 316.578 16.9793C316.353 16.9793 316.079 16.8623 315.771 16.7309C315.368 16.5588 314.907 16.3621 314.423 16.3715C313.315 16.3882 312.285 17.0625 311.719 18.1365C310.557 20.2845 311.417 23.4648 312.541 25.2131C313.091 26.0789 313.749 27.028 314.617 26.9947C314.999 26.9793 315.274 26.854 315.558 26.7245C315.885 26.5753 316.225 26.4203 316.756 26.4203C317.268 26.4203 317.593 26.5712 317.905 26.7161C318.202 26.8539 318.487 26.9862 318.91 26.9781C319.809 26.9614 320.374 26.1122 320.924 25.2464C321.518 24.3171 321.779 23.4102 321.818 23.2725L321.823 23.2566C321.822 23.2556 321.815 23.252 321.802 23.2456C321.603 23.148 320.087 22.4019 320.072 20.401C320.057 18.7216 321.275 17.8707 321.467 17.7367C321.478 17.7286 321.486 17.7231 321.49 17.7202C320.715 16.4881 319.506 16.3549 319.088 16.3216ZM325.31 26.8865V13.9072H329.843C332.183 13.9072 333.817 15.6389 333.817 18.1698C333.817 20.7007 332.152 22.4491 329.781 22.4491H327.185V26.8865H325.31ZM327.185 15.6057H329.347C330.974 15.6057 331.903 16.5381 331.903 18.1782C331.903 19.8183 330.974 20.7591 329.339 20.7591H327.185V15.6057ZM340.008 25.3296C339.513 26.3453 338.42 26.9864 337.242 26.9864C335.499 26.9864 334.282 25.8708 334.282 24.189C334.282 22.524 335.46 21.5665 337.637 21.425L339.977 21.2752V20.5592C339.977 19.5018 339.334 18.9274 338.188 18.9274C337.242 18.9274 336.553 19.4519 336.413 20.2511H334.724C334.778 18.5694 336.251 17.3456 338.242 17.3456C340.388 17.3456 341.783 18.5527 341.783 20.426V26.8865H340.047V25.3296H340.008ZM337.746 25.4463C336.746 25.4463 336.111 24.9301 336.111 24.1392C336.111 23.3233 336.723 22.8488 337.893 22.7738L339.977 22.6323V23.3649C339.977 24.5804 339.017 25.4463 337.746 25.4463ZM347.54 27.3944C346.788 29.6672 345.928 30.4165 344.099 30.4165C343.96 30.4165 343.495 30.3999 343.387 30.3666V28.8097C343.503 28.8264 343.789 28.843 343.937 28.843C344.766 28.843 345.231 28.4684 345.517 27.4943L345.688 26.9198L342.511 17.4705H344.471L346.68 25.1382H346.718L348.927 17.4705H350.833L347.54 27.3944Z" fill="black"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-details">
                                <p class="payment-desc">Thanh toán an toàn qua tài khoản ngân hàng, ví MoMo, VNPay hoặc thẻ quốc tế Visa/Mastercard.</p>
                                <div class="form-grid">
                                    <div class="form-group full">
                                        <label>Số thẻ</label>
                                        <input type="text" class="form-control" placeholder="XXXX XXXX XXXX XXXX">
                                    </div>
                                    <div class="form-group full">
                                        <label>Tên trên thẻ</label>
                                        <input type="text" class="form-control" placeholder="NGUYEN VAN A">
                                    </div>
                                    <div class="form-group">
                                        <label>Ngày hết hạn</label>
                                        <input type="text" class="form-control" placeholder="MM/YY">
                                    </div>
                                    <div class="form-group">
                                        <label>Mã CVV</label>
                                        <input type="text" class="form-control" placeholder="XXX">
                                    </div>
                                </div>
                                <div style="margin-top: 15px;">
                                    <label style="display: flex; align-items: center; gap: 10px; font-size: 13px; cursor: pointer; color: var(--text-light);">
                                        <input type="checkbox"> Đặt làm thẻ mặc định
                                    </label>
                                    <label style="display: flex; align-items: center; gap: 10px; font-size: 13px; cursor: pointer; margin-top: 8px; color: var(--text-light);">
                                        <input type="checkbox"> Lưu thẻ cho lần thanh toán sau
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- PayPal -->
                        <div class="payment-option" onclick="selectPayment('paypal')">
                            <div class="payment-header">
                                <input type="radio" name="payment_method" value="paypal" id="pay_paypal">
                                <label for="pay_paypal">Ví điện tử PayPal</label>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" class="payment-icon" style="height: 24px; width: auto;" alt="PayPal" onerror="this.style.display='none'">
                            </div>
                            <div class="payment-details">
                                <p class="payment-desc">Bạn sẽ được chuyển hướng đến website PayPal để hoàn tất thanh toán an toàn.</p>
                            </div>
                        </div>

                        <!-- COD -->
                        <div class="payment-option" onclick="selectPayment('cash')">
                            <div class="payment-header">
                                <input type="radio" name="payment_method" value="cash" id="pay_cash">
                                <label for="pay_cash">Thanh toán khi nhận hàng</label>
                                <div style="font-weight: 800; color: #3b82f6; font-size: 14px; background: #eff6ff; padding: 2px 8px; border-radius: 4px;">COD</div>
                            </div>
                            <div class="payment-details">
                                <p class="payment-desc">Thanh toán bằng tiền mặt khi shipper giao hàng đến địa chỉ của bạn.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Review -->
                <div class="step-content" id="step-3-content">
                    <div class="card">
                        <h2 class="card-title">Kiểm tra đơn hàng</h2>
                        
                        <div class="review-block">
                            <div class="review-title">Thông tin thanh toán <span class="edit-icon" onclick="goToStep(1)">Sửa</span></div>
                            <div class="review-data" id="review-billing">
                                <!-- Populated by JS -->
                            </div>
                        </div>

                        <div class="review-block">
                            <div class="review-title">Địa chỉ giao hàng <span class="edit-icon" onclick="goToStep(1)">Sửa</span></div>
                            <div class="review-data" id="review-shipping">
                                <!-- Populated by JS -->
                            </div>
                        </div>

                        <div class="review-block">
                            <div class="review-title">Phương thức thanh toán <span class="edit-icon" onclick="goToStep(2)">Sửa</span></div>
                            <div class="review-data" id="review-payment">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nav Buttons -->
                <div class="nav-buttons">
                    <button type="button" class="btn btn-outline" onclick="goBack()" id="back-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        Trở lại giỏ hàng
                    </button>
                    <button type="button" class="btn btn-primary" onclick="goNext()" id="next-btn">
                        Tiếp theo
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar Summary -->
        <div class="order-summary-sidebar">
            <div class="card order-summary-card">
                <div class="card-title">
                    Đơn hàng - <span id="summary-count">0</span> sản phẩm
                    <span class="edit-icon" title="Chỉnh sửa giỏ hàng" onclick="window.location.href='{{ route('home') }}'">✎</span>
                </div>
                
                <div id="summary-items-list">
                    <!-- Items via JS -->
                </div>

                <div class="summary-divider"></div>

                <div class="summary-row">
                    <span>Tạm tính</span>
                    <span id="summary-subtotal">0đ</span>
                </div>
                <div class="summary-row">
                    <span>Phí vận chuyển</span>
                    <span id="summary-shipping">0đ</span>
                </div>
                <div class="summary-total">
                    <span>Tổng cộng</span>
                    <span id="summary-total" style="color: var(--primary-light);">0đ</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 3;

        function updateStepper() {
            for (let i = 1; i <= totalSteps; i++) {
                const indicator = document.getElementById(`step-${i}-indicator`);
                indicator.classList.remove('active', 'completed');
                
                if (i === currentStep) {
                    indicator.classList.add('active');
                } else if (i < currentStep) {
                    indicator.classList.add('completed');
                }
            }
        }

        function showStep(step) {
            document.querySelectorAll('.step-content').forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById(`step-${step}-content`).classList.add('active');
            
            const nextBtn = document.getElementById('next-btn');
            const backBtn = document.getElementById('back-btn');

            if (step === 1) {
                backBtn.innerHTML = '<svg width=\"18\" height=\"18\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><line x1=\"19\" y1=\"12\" x2=\"5\" y2=\"12\"></line><polyline points=\"12 19 5 12 12 5\"></polyline></svg> Trở lại giỏ hàng';
                nextBtn.innerHTML = 'Tiếp theo <svg width=\"18\" height=\"18\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><line x1=\"5\" y1=\"12\" x2=\"19\" y2=\"12\"></line><polyline points=\"12 5 19 12 12 19\"></polyline></svg>';
            } else if (step === totalSteps) {
                backBtn.innerHTML = '<svg width=\"18\" height=\"18\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><line x1=\"19\" y1=\"12\" x2=\"5\" y2=\"12\"></line><polyline points=\"12 19 5 12 12 5\"></polyline></svg> Quay lại';
                nextBtn.innerHTML = 'Đặt hàng ngay <svg width=\"18\" height=\"18\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"></polyline></svg>';
            } else {
                backBtn.innerHTML = '<svg width=\"18\" height=\"18\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><line x1=\"19\" y1=\"12\" x2=\"5\" y2=\"12\"></line><polyline points=\"12 19 5 12 12 5\"></polyline></svg> Quay lại';
                nextBtn.innerHTML = 'Tiếp theo <svg width=\"18\" height=\"18\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><line x1=\"5\" y1=\"12\" x2=\"19\" y2=\"12\"></line><polyline points=\"12 5 19 12 12 19\"></polyline></svg>';
            }
            
            if (step === 3) {
                populateReview();
            }
        }

        function goNext() {
            if (currentStep < totalSteps) {
                // Check required fields for Step 1
                if (currentStep === 1) {
                    const name = document.getElementById('billing_name').value;
                    const email = document.getElementById('billing_email').value;
                    const address = document.getElementById('billing_address').value;
                    const phone = document.getElementById('billing_phone').value;
                    
                    if (!name || !email || !address || !phone) {
                        alert('Vui lòng điền đầy đủ thông tin bắt buộc.');
                        return;
                    }
                }
                
                currentStep++;
                updateStepper();
                showStep(currentStep);
                window.scrollTo({top: 0, behavior: 'smooth'});
            } else {
                // Final submission
                document.getElementById('checkout-form').submit();
            }
        }

        function goBack() {
            if (currentStep > 1) {
                currentStep--;
                updateStepper();
                showStep(currentStep);
                window.scrollTo({top: 0, behavior: 'smooth'});
            } else {
                window.location.href = "{{ route('home') }}";
            }
        }

        function goToStep(step) {
            currentStep = step;
            updateStepper();
            showStep(currentStep);
            window.scrollTo({top: 0, behavior: 'smooth'});
        }

        function selectPayment(method) {
            document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
            const radio = document.getElementById(`pay_${method}`);
            radio.checked = true;
            radio.closest('.payment-option').classList.add('active');
        }

        function populateReview() {
            const name = document.getElementById('billing_name').value;
            const email = document.getElementById('billing_email').value;
            const address = document.getElementById('billing_address').value;
            const city = document.getElementById('billing_city').value;
            const zip = document.getElementById('billing_zip').value;
            const countrySelect = document.getElementById('billing_country');
            const country = countrySelect.options[countrySelect.selectedIndex].text;
            const phone = document.getElementById('billing_phone').value;
            
            const method = document.querySelector('input[name="payment_method"]:checked').value;
            let methodLabel = 'Thanh toán khi nhận hàng (COD)';
            if (method === 'card') methodLabel = 'Thẻ Tín dụng / Ghi nợ';
            if (method === 'paypal') methodLabel = 'Ví điện tử PayPal';

            document.getElementById('review-billing').innerHTML = `
                <p><strong>${name}</strong></p>
                <p>${address}</p>
                <p>${city}${zip ? ' ' + zip : ''}, ${country}</p>
                <p>Email: ${email}</p>
                <p>Số điện thoại: ${phone}</p>
            `;

            document.getElementById('review-shipping').innerHTML = `
                <p>${address}</p>
                <p>${city}${zip ? ' ' + zip : ''}, ${country}</p>
            `;

            document.getElementById('review-payment').innerHTML = `
                <p><strong>${methodLabel}</strong></p>
                ${method === 'paypal' ? '<p>' + email + '</p>' : ''}
            `;
        }

        document.addEventListener('DOMContentLoaded', function() {
            let cart = JSON.parse(localStorage.getItem('tiny_flowers_cart')) || [];
            
            const itemsList = document.getElementById('summary-items-list');
            const countSpan = document.getElementById('summary-count');
            const cartInput = document.getElementById('cart_data_input');
            
            if (cart.length === 0) {
                window.location.href = "{{ route('home') }}";
                return;
            }

            cartInput.value = JSON.stringify(cart);
            countSpan.innerText = cart.length;
            
            let subtotal = 0;
            let itemsHtml = '';
            
            cart.forEach(item => {
                subtotal += (item.price * item.quantity);
                itemsHtml += `
                    <div class="summary-item">
                        <img src="${item.image}" alt="${item.name}" class="summary-img" onerror="this.src='{{ asset('images/default-product.png') }}'">
                        <div class="summary-info">
                            <h3 class="summary-name">${item.name}</h3>
                            <span class="summary-price">${(item.price).toLocaleString('vi-VN')}đ</span>
                        </div>
                        <div class="summary-qty">${item.quantity} x ${(item.price).toLocaleString('vi-VN')}đ</div>
                    </div>
                `;
            });
            
            itemsList.innerHTML = itemsHtml;
            
            let shipping = subtotal > 1000000 ? 0 : 30000;
            let total = subtotal + shipping;
            
            document.getElementById('summary-subtotal').innerText = subtotal.toLocaleString('vi-VN') + 'đ';
            document.getElementById('summary-shipping').innerText = shipping === 0 ? 'Miễn phí' : shipping.toLocaleString('vi-VN') + 'đ';
            document.getElementById('summary-total').innerText = total.toLocaleString('vi-VN') + 'đ';
        });
    </script>
</body>
</html>
