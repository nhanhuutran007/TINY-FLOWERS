<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - TINY FLOWERS</title>
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
    
    <!-- Sign In Container -->
    <div class="auth-container">
        <h1>Đăng nhập</h1>
        
        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <!-- Email Input -->
            <div class="auth-form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@address.com" required autofocus>
            </div>
            
            <!-- Password Input -->
            <div class="auth-form-group">
                <label for="password">Mật khẩu</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Mật khẩu" required>
                    <span class="toggle-password" onclick="togglePassword()">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <mask id="mask0_password" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                                <rect width="20" height="20" fill="#D9D9D9"/>
                            </mask>
                            <g mask="url(#mask0_password)">
                                <path id="eye-icon" d="M16.08 13.75L13.42 11.083C13.53 10.847 13.61 10.608 13.67 10.365C13.72 10.122 13.75 9.861 13.75 9.583C13.75 8.542 13.39 7.656 12.66 6.927C11.93 6.198 11.04 5.833 10 5.833C9.72 5.833 9.46 5.861 9.22 5.917C8.98 5.972 8.74 6.056 8.5 6.167L6.38 4.042C6.94 3.806 7.53 3.628 8.13 3.51C8.72 3.392 9.35 3.333 10 3.333C11.99 3.333 13.77 3.858 15.35 4.906C16.94 5.955 18.13 7.319 18.92 9C18.96 9.069 18.99 9.156 19 9.26C19.01 9.364 19.02 9.472 19.02 9.583C19.02 9.694 19.01 9.802 18.99 9.906C18.97 10.01 18.94 10.097 18.92 10.167C18.6 10.875 18.2 11.535 17.72 12.146C17.24 12.757 16.69 13.292 16.08 13.75ZM15.92 18.25L13 15.375C12.51 15.528 12.02 15.643 11.53 15.719C11.04 15.795 10.53 15.833 10 15.833C8.01 15.833 6.23 15.309 4.65 14.261C3.06 13.212 1.88 11.847 1.08 10.167C1.04 10.097 1.01 10.01 1 9.906C0.99 9.802 0.98 9.694 0.98 9.583C0.98 9.472 0.99 9.368 1 9.271C1.01 9.174 1.04 9.09 1.08 9.021C1.38 8.396 1.72 7.819 2.13 7.292C2.53 6.764 2.97 6.278 3.46 5.833L1.73 4.083C1.58 3.931 1.5 3.739 1.5 3.51C1.5 3.281 1.58 3.083 1.75 2.917C1.9 2.764 2.1 2.688 2.33 2.688C2.57 2.688 2.76 2.764 2.92 2.917L17.08 17.083C17.24 17.236 17.32 17.427 17.32 17.657C17.33 17.886 17.25 18.083 17.08 18.25C16.93 18.403 16.74 18.479 16.5 18.479C16.26 18.479 16.07 18.403 15.92 18.25ZM10 13.333C10.15 13.333 10.3 13.326 10.43 13.313C10.56 13.299 10.7 13.271 10.85 13.229L6.35 8.729C6.31 8.882 6.29 9.024 6.27 9.157C6.26 9.288 6.25 9.431 6.25 9.583C6.25 10.625 6.61 11.511 7.34 12.24C8.07 12.969 8.96 13.333 10 13.333ZM12.21 9.875L9.71 7.375C10.5 7.25 11.15 7.472 11.65 8.042C12.15 8.611 12.33 9.222 12.21 9.875Z" fill="#3B4758"/>
                            </g>
                        </svg>
                    </span>
                </div>
            </div>
            
            <!-- Remember Me & Forgot Password -->
            <div class="remember-forgot">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ghi nhớ đăng nhập</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password">Quên mật khẩu?</a>
                @endif
            </div>
            
            <!-- Sign In Button -->
            <button type="submit" class="auth-btn">Đăng nhập</button>
        </form>

        <div class="auth-link">
            Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
        </div>
        <div style="text-align: center; margin-top: 15px;">
            <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; gap: 5px; color: #64748B; text-decoration: none; font-size: 14px; font-weight: 500;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Quay về Trang chủ
            </a>
        </div>
    </div>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.setAttribute('d', 'M10 7C11.66 7 13 8.34 13 10C13 11.66 11.66 13 10 13C8.34 13 7 11.66 7 10C7 8.34 8.34 7 10 7ZM10 3.5C14 3.5 17.27 6.11 18 10C17.27 13.89 14 16.5 10 16.5C6 16.5 2.73 13.89 2 10C2.73 6.11 6 3.5 10 3.5ZM3.18 10C3.98 12.79 6.81 14.5 10 14.5C13.19 14.5 16.02 12.79 16.82 10C16.02 7.21 13.19 5.5 10 5.5C6.81 5.5 3.98 7.21 3.18 10Z');
            } else {
                passwordInput.type = 'password';
                eyeIcon.setAttribute('d', 'M16.08 13.75L13.42 11.083C13.53 10.847 13.61 10.608 13.67 10.365C13.72 10.122 13.75 9.861 13.75 9.583C13.75 8.542 13.39 7.656 12.66 6.927C11.93 6.198 11.04 5.833 10 5.833C9.72 5.833 9.46 5.861 9.22 5.917C8.98 5.972 8.74 6.056 8.5 6.167L6.38 4.042C6.94 3.806 7.53 3.628 8.13 3.51C8.72 3.392 9.35 3.333 10 3.333C11.99 3.333 13.77 3.858 15.35 4.906C16.94 5.955 18.13 7.319 18.92 9C18.96 9.069 18.99 9.156 19 9.26C19.01 9.364 19.02 9.472 19.02 9.583C19.02 9.694 19.01 9.802 18.99 9.906C18.97 10.01 18.94 10.097 18.92 10.167C18.6 10.875 18.2 11.535 17.72 12.146C17.24 12.757 16.69 13.292 16.08 13.75ZM15.92 18.25L13 15.375C12.51 15.528 12.02 15.643 11.53 15.719C11.04 15.795 10.53 15.833 10 15.833C8.01 15.833 6.23 15.309 4.65 14.261C3.06 13.212 1.88 11.847 1.08 10.167C1.04 10.097 1.01 10.01 1 9.906C0.99 9.802 0.98 9.694 0.98 9.583C0.98 9.472 0.99 9.368 1 9.271C1.01 9.174 1.04 9.09 1.08 9.021C1.38 8.396 1.72 7.819 2.13 7.292C2.53 6.764 2.97 6.278 3.46 5.833L1.73 4.083C1.58 3.931 1.5 3.739 1.5 3.51C1.5 3.281 1.58 3.083 1.75 2.917C1.9 2.764 2.1 2.688 2.33 2.688C2.57 2.688 2.76 2.764 2.92 2.917L17.08 17.083C17.24 17.236 17.32 17.427 17.32 17.657C17.33 17.886 17.25 18.083 17.08 18.25C16.93 18.403 16.74 18.479 16.5 18.479C16.26 18.479 16.07 18.403 15.92 18.25ZM10 13.333C10.15 13.333 10.3 13.326 10.43 13.313C10.56 13.299 10.7 13.271 10.85 13.229L6.35 8.729C6.31 8.882 6.29 9.024 6.27 9.157C6.26 9.288 6.25 9.431 6.25 9.583C6.25 10.625 6.61 11.511 7.34 12.24C8.07 12.969 8.96 13.333 10 13.333ZM12.21 9.875L9.71 7.375C10.5 7.25 11.15 7.472 11.65 8.042C12.15 8.611 12.33 9.222 12.21 9.875Z');
            }
        }
    </script>
</body>
</html>
