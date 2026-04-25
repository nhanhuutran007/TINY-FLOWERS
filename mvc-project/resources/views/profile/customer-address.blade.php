@extends('layouts.profile')

@section('title', 'Sổ địa chỉ - Tiny Flowers')

@section('profile_styles')
<style>
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; color: #475569; margin-bottom: 8px; font-size: 14px; }
    .form-control { width: 100%; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 15px; color: #1e293b; transition: all 0.2s; }
    .form-control:focus { outline: none; border-color: #319DFF; box-shadow: 0 0 0 3px rgba(49, 157, 255, 0.1); }
    .btn-primary { background: #0f172a; color: white; border: none; padding: 14px 28px; border-radius: 10px; font-weight: 600; font-size: 15px; cursor: pointer; transition: all 0.2s; }
    .btn-primary:hover { background: #1e293b; transform: translateY(-1px); }
    .alert-success { background: #ecfdf5; color: #065f46; padding: 16px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #a7f3d0; }
</style>
@endsection

@section('profile_content')
<div class="content-header">
    <h2>Sổ địa chỉ</h2>
    <p>Quản lý địa chỉ giao hàng của bạn</p>
</div>

@if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<form action="{{ route('profile.address.update') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Số điện thoại liên lạc</label>
        <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone }}" required placeholder="0xxx.xxx.xxx">
    </div>
    <div class="form-group">
        <label>Địa chỉ nhận hàng</label>
        <textarea name="address" class="form-control" rows="4" required placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố">{{ Auth::user()->address }}</textarea>
    </div>
    <div style="margin-top: 20px;">
        <button type="submit" class="btn-primary">Cập nhật địa chỉ</button>
    </div>
</form>
@endsection
