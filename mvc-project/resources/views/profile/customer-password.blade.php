@extends('layouts.profile')

@section('title', 'Đổi mật khẩu - Tiny Flowers')

@section('profile_styles')
<style>
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; color: #475569; margin-bottom: 8px; font-size: 14px; }
    .form-control { width: 100%; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 15px; color: #1e293b; transition: all 0.2s; }
    .form-control:focus { outline: none; border-color: #319DFF; box-shadow: 0 0 0 3px rgba(49, 157, 255, 0.1); }
    .btn-primary { background: #0f172a; color: white; border: none; padding: 14px 28px; border-radius: 10px; font-weight: 600; font-size: 15px; cursor: pointer; transition: all 0.2s; }
    .btn-primary:hover { background: #1e293b; transform: translateY(-1px); }
    .alert-success { background: #ecfdf5; color: #065f46; padding: 16px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #a7f3d0; }
    .error-message { color: #ef4444; font-size: 13px; margin-top: 5px; }
</style>
@endsection

@section('profile_content')
<div class="content-header">
    <h2>Đổi mật khẩu</h2>
    <p>Để bảo mật tài khoản, vui lòng không chia sẻ mật khẩu cho người khác</p>
</div>

@if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<form action="{{ route('profile.password.update') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Mật khẩu hiện tại</label>
        <input type="password" name="current_password" class="form-control" required>
        @error('current_password') <div class="error-message">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label>Mật khẩu mới</label>
        <input type="password" name="new_password" class="form-control" required>
        @error('new_password') <div class="error-message">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label>Xác nhận mật khẩu mới</label>
        <input type="password" name="new_password_confirmation" class="form-control" required>
    </div>
    <div style="margin-top: 20px;">
        <button type="submit" class="btn-primary">Đổi mật khẩu</button>
    </div>
</form>
@endsection
