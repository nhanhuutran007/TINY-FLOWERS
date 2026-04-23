<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - TINY FLOWERS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="auth-body">
    <!-- Logo -->
    <div class="auth-logo">
        <div class="auth-logo-icon">
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M29.4507 36.1804C27.045 38.5429 23.7471 40 20.109 40C16.4708 40 13.1729 38.5428 10.7672 36.1803C7.5184 35.2781 4.6076 33.1507 2.7886 30C0.9695 26.8492 0.5825 23.2647 1.4256 20C0.5825 16.7353 0.9695 13.1507 2.7886 10C4.6076 6.8492 7.5185 4.7218 10.7673 3.8196C13.1731 1.4571 16.4709 0 20.109 0C23.7472 0 27.045 1.4571 29.4507 3.8196C32.6996 4.7217 35.6105 6.8492 37.4297 10C39.2488 13.1508 39.6357 16.7354 38.7926 20.0001C39.6357 23.2647 39.2487 26.8493 37.4296 30C35.6105 33.1508 32.6996 35.2782 29.4507 36.1804Z" fill="white"/>
                <path d="M33.4424 13.3333C33.4424 20.6971 27.4729 26.6667 20.1091 26.6667C12.7453 26.6667 6.7757 20.6971 6.7757 13.3333C6.7757 5.9695 12.7453 0 20.1091 0C27.4729 0 33.4424 5.9695 33.4424 13.3333Z" fill="#FF7A00" fill-opacity="0.2"/>
                <path d="M33.4424 26.6667C33.4424 34.0305 27.4729 40 20.1091 40C12.7453 40 6.7757 34.0305 6.7757 26.6667C6.7757 19.3029 12.7453 13.3333 20.1091 13.3333C27.4729 13.3333 33.4424 19.3029 33.4424 26.6667Z" fill="#FF7A00" fill-opacity="0.2"/>
                <path d="M21.0022 5.1197C27.3795 8.8016 29.5645 16.9561 25.8826 23.3333C22.2007 29.7106 14.0461 31.8956 7.6689 28.2137C1.2917 24.5318 -0.8933 16.3772 2.7886 10C6.4705 3.6228 14.625 1.4378 21.0022 5.1197Z" fill="#FF7A00" fill-opacity="0.2"/>
                <path d="M32.5492 11.7863C38.9265 15.4682 41.1115 23.6228 37.4296 30C33.7477 36.3772 25.5931 38.5622 19.2159 34.8803C12.8387 31.1984 10.6537 23.0439 14.3356 16.6667C18.0175 10.2894 26.172 8.1044 32.5492 11.7863Z" fill="#FF7A00" fill-opacity="0.2"/>
                <path d="M7.6689 11.7863C14.0462 8.1044 22.2007 10.2894 25.8826 16.6667C29.5645 23.0439 27.3795 31.1984 21.0023 34.8803C14.625 38.5622 6.4705 36.3772 2.7886 30C-0.8933 23.6228 1.2917 15.4682 7.6689 11.7863Z" fill="#FF7A00" fill-opacity="0.2"/>
                <path d="M19.2159 5.1197C25.5932 1.4378 33.7477 3.6228 37.4296 10C41.1115 16.3772 38.9265 24.5318 32.5493 28.2137C26.172 31.8956 18.0175 29.7106 14.3356 23.3333C10.6537 16.9561 12.8387 8.8016 19.2159 5.1197Z" fill="#FF7A00" fill-opacity="0.2"/>
            </svg>
        </div>
        <span class="auth-logo-text">TINY FLOWERS</span>
    </div>
    
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
        
        <div class="back-link">
            <a href="{{ route('login') }}">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M15.8333 10H4.16667M4.16667 10L10 15.8333M4.16667 10L10 4.16667" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Quay lại Đăng nhập
            </a>
        </div>
    </div>
</body>
</html>
