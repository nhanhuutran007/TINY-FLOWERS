@extends('layouts.app')

@section('title', 'Quản lý khách hàng')

@section('content')
    <div class="page-title-bar">
        <h1 class="page-title-text">Quản lý khách hàng</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 10px; color: #aaa;"></i>
            <span>Khách hàng</span>
        </div>
    </div>

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success" style="background: #e6fffa; border: 1px solid #38b2ac; color: #234e52; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="panel">
            <div class="panel-header">
                <h2 class="panel-title">Danh sách khách hàng đăng ký (Online)</h2>
            </div>

            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Khách hàng</th>
                        <th>Email / SĐT</th>
                        <th>Số đơn hàng</th>
                        <th>Tổng chi tiêu</th>
                        <th>Ngày tham gia</th>
                        <th style="text-align: right;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $user)
                        @php
                            $avatarUrl = $user->profile_picture 
                                ? asset('images/avatars/' . $user->profile_picture) 
                                : 'https://ui-avatars.com/api/?name=' . urlencode($user->fullname) . '&background=f1f5f9&color=64748b';
                        @endphp
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <img src="{{ $avatarUrl }}" alt="{{ $user->fullname }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                    <div>
                                        <div style="font-weight: 600; color: #1e293b;">{{ $user->fullname }}</div>
                                        <div style="font-size: 13px; color: #64748b;">UID: #{{ $user->user_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>{{ $user->email }}</div>
                                <div style="font-size: 13px; color: #64748b;">{{ $user->phone ?? 'Chưa cập nhật' }}</div>
                            </td>
                            <td><span style="background: #e2e8f0; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 13px;">{{ $user->orders_count }} đơn</span></td>
                            <td><div style="font-weight: 600; color: #10B981;">{{ number_format($user->orders_sum_total_amount ?? 0) }}đ</div></td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td style="text-align: right;">
                                <form action="{{ route('customers.destroy', $user->user_id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này? Toàn bộ dữ liệu của họ sẽ bị mất.')" title="Xóa tài khoản">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">
                                <i class="fas fa-users" style="font-size: 40px; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                Chưa có khách hàng nào đăng ký.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .btn-action { width: 32px; height: 32px; border-radius: 6px; border: none; cursor: pointer; transition: all 0.2s; margin-left: 5px; }
        .btn-action.delete { background: #fee2e2; color: #ef4444; }
        .btn-action.delete:hover { background: #ef4444; color: white; }
    </style>
@endsection
