@extends('layouts.app')

@section('title', 'Bảo mật tài khoản')

@section('styles')
<style>
    /* Premium Password Redesign */
    .password-container {
        max-width: 600px;
        margin: 0 auto;
        padding-bottom: 50px;
    }

    .password-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        overflow: hidden;
        border: 1px solid #f1f5f9;
    }

    .card-banner {
        height: 100px;
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-banner i {
        font-size: 40px;
        color: rgba(255,255,255,0.2);
    }

    .password-body {
        padding: 40px;
    }

    .password-header {
        text-align: center;
        margin-bottom: 35px;
    }

    .password-header h2 {
        font-size: 22px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 10px;
    }

    .password-header p {
        color: #64748b;
        font-size: 14px;
    }

    .form-group-custom {
        margin-bottom: 25px;
    }

    .form-group-custom label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 10px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper input {
        width: 100%;
        padding: 14px 45px 14px 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        color: #1e293b;
        transition: all 0.3s;
    }

    .input-wrapper input:focus {
        background: white;
        border-color: #319DFF;
        box-shadow: 0 0 0 4px rgba(49, 157, 255, 0.1);
        outline: none;
    }

    .input-wrapper .toggle-eye {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        cursor: pointer;
        transition: color 0.3s;
        padding: 5px;
    }

    .input-wrapper .toggle-eye:hover {
        color: #319DFF;
    }

    .password-requirements {
        background: #f1f5f9;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 30px;
    }

    .password-requirements h4 {
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .requirement-item {
        font-size: 12px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
    }

    .requirement-item i {
        font-size: 10px;
        color: #94a3b8;
    }

    .btn-update {
        width: 100%;
        background: #319DFF;
        color: white;
        border: none;
        padding: 16px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(49, 157, 255, 0.2);
    }

    .btn-update:hover {
        background: #2589e6;
        transform: translateY(-2px);
        box-shadow: 0 15px 25px rgba(49, 157, 255, 0.3);
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 25px;
        color: #64748b;
        font-size: 14px;
        text-decoration: none;
        transition: color 0.3s;
    }

    .back-link:hover {
        color: #319DFF;
    }
</style>
@endsection

@section('content')
    <div class="page-title-bar">
        <h1 class="page-title-text">Đổi mật khẩu</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 10px; color: #aaa;"></i>
            <a href="{{ route('profile.index') }}">Hồ sơ</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 10px; color: #aaa;"></i>
            <span>Bảo mật</span>
        </div>
    </div>

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success" style="background: #ecfdf5; border: none; border-left: 4px solid #10b981; color: #065f46; padding: 16px 20px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); max-width: 600px; margin-left: auto; margin-right: auto;">
                <i class="fas fa-check-circle" style="margin-right: 10px; color: #10b981;"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" style="background: #fef2f2; border: none; border-left: 4px solid #ef4444; color: #991b1b; padding: 16px 20px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); max-width: 600px; margin-left: auto; margin-right: auto;">
                <ul style="margin: 0; padding-left: 15px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="password-container">
            <div class="password-card">
                <div class="card-banner">
                    <i class="fas fa-key"></i>
                </div>
                <div class="password-body">
                    <div class="password-header">
                        <h2>Thiết lập mật khẩu mới</h2>
                        <p>Đảm bảo mật khẩu của bạn có tính bảo mật cao để bảo vệ tài khoản.</p>
                    </div>

                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        
                        <div class="form-group-custom">
                            <label>Mật khẩu hiện tại</label>
                            <div class="input-wrapper">
                                <input type="password" name="current_password" id="current_password" required placeholder="Nhập mật khẩu đang sử dụng">
                                <i class="fas fa-eye toggle-eye" onclick="togglePassword('current_password')"></i>
                            </div>
                        </div>

                        <div class="form-group-custom">
                            <label>Mật khẩu mới</label>
                            <div class="input-wrapper">
                                <input type="password" name="new_password" id="new_password" required placeholder="Nhập mật khẩu mới">
                                <i class="fas fa-eye toggle-eye" onclick="togglePassword('new_password')"></i>
                            </div>
                        </div>

                        <div class="form-group-custom">
                            <label>Xác nhận mật khẩu mới</label>
                            <div class="input-wrapper">
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" required placeholder="Nhập lại mật khẩu mới">
                                <i class="fas fa-eye toggle-eye" onclick="togglePassword('new_password_confirmation')"></i>
                            </div>
                        </div>

                        <div class="password-requirements">
                            <h4>Yêu cầu mật khẩu:</h4>
                            <div class="requirement-item"><i class="fas fa-circle"></i> Độ dài tối thiểu 5 ký tự</div>
                            <div class="requirement-item"><i class="fas fa-circle"></i> Nên bao gồm cả chữ và số</div>
                            <div class="requirement-item"><i class="fas fa-circle"></i> Không nên trùng với mật khẩu cũ</div>
                        </div>

                        <button type="submit" class="btn-update">Cập nhật mật khẩu</button>
                    </form>

                    <a href="{{ route('profile.index') }}" class="back-link">
                        <i class="fas fa-arrow-left" style="font-size: 12px; margin-right: 5px;"></i> Quay lại Hồ sơ cá nhân
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const el = document.getElementById(id);
            const icon = el.nextElementSibling;
            if (el.type === 'password') {
                el.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                el.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection
