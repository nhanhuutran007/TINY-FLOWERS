@extends('layouts.profile')

@section('title', 'Hồ sơ cá nhân - Tiny Flowers')

@section('profile_styles')
<style>
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; color: #475569; margin-bottom: 8px; font-size: 14px; }
    .form-control { width: 100%; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 15px; color: #1e293b; transition: all 0.2s; font-family: inherit; }
    .form-control:focus { outline: none; border-color: #319DFF; box-shadow: 0 0 0 3px rgba(49, 157, 255, 0.1); }
    .form-control:disabled { background: #f8fafc; color: #94a3b8; cursor: not-allowed; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .btn-primary { background: #0f172a; color: white; border: none; padding: 14px 28px; border-radius: 10px; font-weight: 600; font-size: 15px; cursor: pointer; transition: all 0.2s; }
    .btn-primary:hover { background: #1e293b; transform: translateY(-1px); }
    .avatar-upload-box { display: flex; align-items: center; gap: 20px; margin-bottom: 30px; }
    .avatar-upload-btn { background: white; border: 1px solid #e2e8f0; padding: 10px 20px; border-radius: 8px; font-weight: 600; color: #475569; cursor: pointer; transition: all 0.2s; }
    .avatar-preview { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid #e2e8f0; }
    .alert-success { background: #ecfdf5; color: #065f46; padding: 16px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #a7f3d0; display: flex; align-items: center; gap: 12px; }
</style>
@endsection

@section('profile_content')
<div class="content-header">
    <h2>Hồ sơ của tôi</h2>
    <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
</div>

@if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="avatar-upload-box">
        @php
            $avatarUrl = Auth::user()->profile_picture 
                ? asset('images/avatars/' . Auth::user()->profile_picture) 
                : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->fullname) . '&background=319DFF&color=fff';
        @endphp
        <img id="avatarPreview" src="{{ $avatarUrl }}" class="avatar-preview">
        <div>
            <label for="avatar" class="avatar-upload-btn">
                <i class="fas fa-cloud-upload-alt"></i> Thay đổi ảnh
            </label>
            <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;">
            <p style="font-size: 12px; color: #94a3b8; margin-top: 8px;">Định dạng: JPEG, PNG, JPG. Tối đa 2MB.</p>
        </div>
    </div>

    <div class="form-grid">
        <div class="form-group">
            <label>Tên đăng nhập</label>
            <input type="text" class="form-control" value="{{ Auth::user()->username }}" disabled>
        </div>
        <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" class="form-control" value="{{ Auth::user()->phone ?? '' }}" disabled placeholder="Chưa cập nhật">
        </div>
    </div>

    <div class="form-grid">
        <div class="form-group">
            <label>Họ và tên</label>
            <input type="text" name="fullname" class="form-control" value="{{ Auth::user()->fullname }}" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
        </div>
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn-primary">Lưu thay đổi</button>
    </div>
</form>
@endsection

@section('scripts')
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
