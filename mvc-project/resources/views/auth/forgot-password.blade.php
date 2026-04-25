<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - TINY FLOWERS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="auth-body">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="auth-logo" style="text-decoration: none;">
        <div class="auth-logo-icon" style="background: transparent;">
            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #FF7EB3, #7AF5FF); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; color: white; font-size: 22px; box-shadow: 0 4px 10px rgba(255,126,179,0.4);">TF</div>
        </div>
        <span class="auth-logo-text">TINY FLOWERS</span>
    </a>
    
    <div class="auth-container">
        <h1>Quên mật khẩu</h1>
        <p class="description">
            Nhập địa chỉ email của bạn và chúng tôi sẽ gửi liên kết để đặt lại mật khẩu.
        </p>
        
        @if (session('status'))
            <div class="success-message">
                {{ session('status') }}
            </div>
        @endif
        
        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div class="auth-form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@address.com" required autofocus>
            </div>
            
            <button type="submit" class="auth-btn">Gửi liên kết đặt lại</button>
        </form>
        
        <div class="auth-link">
            Nhớ mật khẩu? <a href="{{ route('login') }}">Đăng nhập</a>
        </div>
        <div style="text-align: center; margin-top: 15px;">
            <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; gap: 5px; color: #64748B; text-decoration: none; font-size: 14px; font-weight: 500;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Quay về Trang chủ
            </a>
        </div>
    </div>
</body>
</html>
