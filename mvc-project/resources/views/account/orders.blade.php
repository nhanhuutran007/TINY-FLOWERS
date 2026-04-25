@extends('layouts.app')

@section('title', 'Lịch sử đơn hàng')

@section('content')
<div class="page-title-bar">
    <h1 class="page-title-text">Lịch sử đơn hàng</h1>
</div>

<div class="page-content">
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Đơn hàng của bạn</h2>
        </div>
        
        @if($orders->isEmpty())
            <div style="padding: 40px; text-align: center; color: #666;">
                <i class="fas fa-shopping-bag" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
                <p>Bạn chưa có đơn hàng nào.</p>
                <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top: 16px; display: inline-block;">Tiếp tục mua sắm</a>
            </div>
        @else
            <table class="ecom-orders-table">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td><strong>{{ $order->order_number }}</strong></td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format($order->total_amount) }}đ</td>
                        <td>
                            @if($order->status == 'pending')
                                <span class="order-status" style="color: #d97706;">⬤ Chờ xử lý</span>
                            @elseif($order->status == 'processing')
                                <span class="order-status" style="color: #2563eb;">⬤ Đang chuẩn bị</span>
                            @elseif($order->status == 'shipped')
                                <span class="order-status" style="color: #c026d3;">⬤ Đang giao</span>
                            @elseif($order->status == 'delivered')
                                <span class="order-status" style="color: #10B981;">⬤ Đã giao</span>
                            @elseif($order->status == 'cancelled')
                                <span class="order-status" style="color: #ef4444;">⬤ Đã hủy</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('account.order_details', $order->order_number) }}" class="btn-icon" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div style="margin-top: 20px;">
                {{ $orders->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>
</div>
@endsection
