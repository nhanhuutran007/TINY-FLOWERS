@extends('layouts.app')

@section('title', 'Thiết lập tài khoản')

@section('styles')
<style>
    /* Premium Profile Design */
    .profile-container {
        max-width: 900px;
        margin: 0 auto;
        padding-bottom: 50px;
    }

    .profile-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.04);
        overflow: hidden;
        border: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
    }

    .profile-header-banner {
        height: 120px;
        background: linear-gradient(135deg, #319DFF 0%, #70b9ff 100%);
        position: relative;
    }

    .profile-body {
        padding: 0 40px 40px;
        margin-top: -60px;
        position: relative;
    }

    .avatar-wrapper {
        position: relative;
        width: 140px;
        height: 140px;
        margin-bottom: 25px;
    }

    .avatar-img {
        width: 140px;
        height: 140px;
        border-radius: 40px;
        object-fit: cover;
        border: 6px solid white;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        background: white;
    }

    .avatar-edit-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 36px;
        height: 36px;
        background: #319DFF;
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 3px solid white;
        transition: all 0.3s;
        box-shadow: 0 5px 15px rgba(49, 157, 255, 0.4);
    }

    .avatar-edit-btn:hover {
        transform: scale(1.1);
        background: #2589e6;
    }

    .profile-section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .profile-section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #f1f5f9;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    .form-group-custom {
        margin-bottom: 20px;
    }

    .form-group-custom label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 8px;
    }

    .form-group-custom input {
        width: 100%;
        padding: 12px 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        color: #1e293b;
        transition: all 0.3s;
    }

    .form-group-custom input:focus {
        background: white;
        border-color: #319DFF;
        box-shadow: 0 0 0 4px rgba(49, 157, 255, 0.1);
        outline: none;
    }

    .form-group-custom input:disabled {
        background: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
        border-color: #f1f5f9;
    }

    .btn-save {
        background: #319DFF;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(49, 157, 255, 0.2);
    }

    .btn-save:hover {
        background: #2589e6;
        transform: translateY(-2px);
        box-shadow: 0 15px 25px rgba(49, 157, 255, 0.3);
    }

    .btn-password {
        background: white;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 12px 25px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-password:hover {
        background: #f8fafc;
        color: #1e293b;
        border-color: #cbd5e1;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
    <div class="page-title-bar">
        <h1 class="page-title-text">Hồ sơ cá nhân</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 10px; color: #aaa;"></i>
            <span>Thiết lập tài khoản</span>
        </div>
    </div>

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success" style="background: #ecfdf5; border: none; border-left: 4px solid #10b981; color: #065f46; padding: 16px 20px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                <i class="fas fa-check-circle" style="margin-right: 10px; color: #10b981;"></i> {{ session('success') }}
            </div>
        @endif

        <div class="profile-container">
            <div class="profile-card">
                <div class="profile-header-banner"></div>
                <div class="profile-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="avatar-wrapper">
                            <img id="avatarPreview" src="{{ $user->profile_picture ? asset('images/avatars/' . $user->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($user->fullname) . '&background=319DFF&color=fff' }}" class="avatar-img">
                            <label for="avatar" class="avatar-edit-btn" title="Thay đổi ảnh đại diện">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;">
                        </div>

                        <div class="profile-section-title">
                            <i class="fas fa-user-circle" style="color: #319DFF;"></i> Thông tin định danh
                        </div>

                        <div class="form-grid">
                            <div class="form-group-custom">
                                <label>Tên đăng nhập</label>
                                <input type="text" value="{{ $user->username }}" disabled>
                                <small style="color: #94a3b8; font-size: 11px; margin-top: 5px; display: block;">Tên đăng nhập được cấp phát và không thể thay đổi</small>
                            </div>
                            <div class="form-group-custom">
                                <label>Vai trò hệ thống</label>
                                <input type="text" value="{{ $user->role == 'admin' ? 'Quản trị viên (Administrator)' : 'Nhân viên (Staff)' }}" disabled>
                            </div>
                        </div>

                        <div class="profile-section-title" style="margin-top: 40px;">
                            <i class="fas fa-address-card" style="color: #319DFF;"></i> Thông tin liên hệ
                        </div>

                        <div class="form-grid">
                            <div class="form-group-custom">
                                <label>Họ và tên <span style="color: #ef4444;">*</span></label>
                                <input type="text" name="fullname" value="{{ $user->fullname }}" required placeholder="Nhập họ tên đầy đủ">
                            </div>
                            <div class="form-group-custom">
                                <label>Địa chỉ Email <span style="color: #ef4444;">*</span></label>
                                <input type="email" name="email" value="{{ $user->email }}" required placeholder="name@example.com">
                            </div>
                        </div>

                        <div style="margin-top: 40px; display: flex; justify-content: space-between; align-items: center; padding-top: 25px; border-top: 1px solid #f1f5f9;">
                            <a href="{{ route('profile.password') }}" class="btn-password">
                                <i class="fas fa-shield-alt"></i> Bảo mật & Đổi mật khẩu
                            </a>
                            <button type="submit" class="btn-save">Cập nhật hồ sơ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('avatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
