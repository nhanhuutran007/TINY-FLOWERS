<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực mã - TINY FLOWERS</title>
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
        <h1>Xác thực mã</h1>
        <p class="description">
            Nhập mã gồm 6 chữ số mà bạn đã nhận được tại<br>
            <span class="email-display">{{ $email ?? 'user@example.com' }}</span>
        </p>
        
        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('password.verify') }}" id="codeForm">
            @csrf
            <input type="hidden" name="email" value="{{ $email ?? '' }}">
            <input type="hidden" name="code" id="fullCode">
            
            <div class="code-inputs">
                <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric" data-index="0">
                <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric" data-index="1">
                <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric" data-index="2">
                <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric" data-index="3">
                <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric" data-index="4">
                <input type="text" class="code-input" maxlength="1" pattern="[0-9]" inputmode="numeric" data-index="5">
            </div>
            
            <button type="submit" class="auth-btn" style="margin-top: 15px;">Xác thực mã</button>
        </form>
        
        <div class="auth-link" style="margin-top: 15px; text-align: center;">
            <a href="{{ route('login') }}">Quay lại đăng nhập</a>
        </div>
        <div style="text-align: center; margin-top: 15px;">
            <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; gap: 5px; color: #64748B; text-decoration: none; font-size: 14px; font-weight: 500;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Quay về Trang chủ
            </a>
        </div>
    </div>
    
    <script>
        const inputs = document.querySelectorAll('.code-input');
        const fullCodeInput = document.getElementById('fullCode');
        
        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                const value = e.target.value;
                
                if (value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                
                updateFullCode();
            });
            
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
            
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').slice(0, 6);
                
                pastedData.split('').forEach((char, i) => {
                    if (inputs[i]) {
                        inputs[i].value = char;
                    }
                });
                
                updateFullCode();
                inputs[Math.min(pastedData.length, 5)].focus();
            });
        });
        
        function updateFullCode() {
            const code = Array.from(inputs).map(input => input.value).join('');
            fullCodeInput.value = code;
        }
        
        inputs[0].focus();
    </script>
</body>
</html>
