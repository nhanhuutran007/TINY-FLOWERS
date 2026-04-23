@extends('layouts.app')

@section('title', 'Quản lý đơn hàng')

@section('content')
    <div class="page-title-bar">
        <h1 class="page-title-text">Quản lý đơn hàng</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 10px; color: #aaa;"></i>
            <span>Đơn hàng</span>
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
                <h2 class="panel-title">Danh sách đơn hàng</h2>
                <div class="panel-actions">
                    <button class="btn-secondary-custom"><i class="fas fa-filter"></i> Bộ lọc</button>
                    <button class="btn-secondary-custom"><i class="fas fa-download"></i> Xuất file</button>
                </div>
            </div>

            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Ngày tạo</th>
                        <th>Tổng tiền</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th style="text-align: right;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td style="font-weight: 600; color: #319DFF;">{{ $order->order_number }}</td>
                            <td>
                                @if($order->customer)
                                    <div style="font-weight: 600;">{{ $order->customer->name }}</div>
                                    <div style="font-size: 12px; color: #64748b;">{{ $order->customer->phone }}</div>
                                @else
                                    <span style="color: #94a3b8;">Khách lẻ</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td><div style="font-weight: 600;">{{ number_format($order->total_amount) }}đ</div></td>
                            <td>
                                <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 20px; font-size: 12px; color: #475569;">
                                    {{ ucfirst($order->payment_method) }}
                                </span>
                            </td>
                            <td>
                                @if($order->status === 'completed')
                                    <span style="color: #10B981; font-size: 12px; font-weight: 600;"><i class="fas fa-check-circle"></i> Hoàn thành</span>
                                @else
                                    <span style="color: #F0950C; font-size: 12px; font-weight: 600;"><i class="fas fa-clock"></i> {{ $order->status }}</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn-action view">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: #94a3b8;">
                                <i class="fas fa-shopping-bag" style="font-size: 40px; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                Chưa có đơn hàng nào được thực hiện.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .btn-secondary-custom { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; padding: 8px 15px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; font-size: 13px; margin-left: 5px; }
        .btn-secondary-custom:hover { background: #e2e8f0; }
        .btn-action { width: 32px; height: 32px; border-radius: 6px; border: none; cursor: pointer; transition: all 0.2s; margin-left: 5px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; }
        .btn-action.view { background: #e0f2fe; color: #0ea5e9; }
        .btn-action.view:hover { background: #0ea5e9; color: white; }
        .btn-action.delete { background: #fee2e2; color: #ef4444; }
        .btn-action.delete:hover { background: #ef4444; color: white; }
        .panel-actions { display: flex; align-items: center; }
    </style>
@endsection
