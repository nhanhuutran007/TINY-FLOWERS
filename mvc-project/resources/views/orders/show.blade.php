@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng ' . $order->order_number)

@section('content')
    <div class="page-title-bar">
        <h1 class="page-title-text">Chi tiết đơn hàng #{{ $order->order_number }}</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 10px; color: #aaa;"></i>
            <a href="{{ route('orders.index') }}">Đơn hàng</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 10px; color: #aaa;"></i>
            <span>Chi tiết</span>
        </div>
    </div>

    <div class="page-content">
        <div class="analytics-grid">
            <!-- Order Info -->
            <div class="panel">
                <div class="panel-header">
                    <h2 class="panel-title">Thông tin chung</h2>
                    <span style="background: #e0f2fe; color: #0ea5e9; padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                        {{ strtoupper($order->status) }}
                    </span>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
                    <div>
                        <div style="color: #64748b; font-size: 12px; margin-bottom: 5px;">MÃ ĐƠN HÀNG</div>
                        <div style="font-weight: 600; color: #1e293b;">{{ $order->order_number }}</div>
                    </div>
                    <div>
                        <div style="color: #64748b; font-size: 12px; margin-bottom: 5px;">NGÀY TẠO</div>
                        <div style="font-weight: 600; color: #1e293b;">{{ $order->created_at->format('d/m/Y H:i:s') }}</div>
                    </div>
                    <div>
                        <div style="color: #64748b; font-size: 12px; margin-bottom: 5px;">PHƯƠNG THỨC THANH TOÁN</div>
                        <div style="font-weight: 600; color: #1e293b;">{{ ucfirst($order->payment_method) }}</div>
                    </div>
                    <div>
                        <div style="color: #64748b; font-size: 12px; margin-bottom: 5px;">NHÂN VIÊN LẬP</div>
                        <div style="font-weight: 600; color: #1e293b;">{{ $order->user->fullname ?? 'Hệ thống' }}</div>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="panel">
                <div class="panel-header">
                    <h2 class="panel-title">Khách hàng</h2>
                </div>
                @if($order->customer)
                    <div style="display: flex; align-items: center; margin-top: 20px;">
                        <div style="width: 48px; height: 48px; background: #319DFF; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700; margin-right: 15px;">
                            {{ substr($order->customer->name, 0, 1) }}
                        </div>
                        <div>
                            <div style="font-weight: 700; color: #1e293b; font-size: 16px;">{{ $order->customer->name }}</div>
                            <div style="color: #64748b; font-size: 13px;">{{ $order->customer->phone }}</div>
                        </div>
                    </div>
                    <div style="margin-top: 15px; color: #475569; font-size: 14px;">
                        <i class="fas fa-map-marker-alt" style="margin-right: 10px; color: #94a3b8;"></i> {{ $order->customer->address ?: 'Không có địa chỉ' }}
                    </div>
                @else
                    <div style="text-align: center; padding: 20px; color: #94a3b8;">
                        <i class="fas fa-user-slash" style="font-size: 30px; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                        Khách lẻ (Không có thông tin)
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Items -->
        <div class="panel" style="margin-top: 25px;">
            <div class="panel-header">
                <h2 class="panel-title">Danh sách sản phẩm</h2>
            </div>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th style="text-align: center;">Số lượng</th>
                        <th style="text-align: right;">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: #1e293b;">{{ $item->product_name }}</div>
                                <div style="font-size: 12px; color: #64748b;">Mã SP: {{ $item->product->barcode ?? 'N/A' }}</div>
                            </td>
                            <td>{{ number_format($item->selling_price) }}đ</td>
                            <td style="text-align: center;">{{ $item->quantity }}</td>
                            <td style="text-align: right; font-weight: 600;">{{ number_format($item->subtotal) }}đ</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right; padding: 15px; font-weight: 600; color: #64748b;">Tổng phụ:</td>
                        <td style="text-align: right; padding: 15px; font-weight: 600;">{{ number_format($order->subtotal) }}đ</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: right; padding: 15px; font-weight: 600; color: #64748b;">Giảm giá:</td>
                        <td style="text-align: right; padding: 15px; font-weight: 600; color: #ef4444;">-{{ number_format($order->discount) }}đ</td>
                    </tr>
                    <tr style="background: #f8fafc;">
                        <td colspan="3" style="text-align: right; padding: 20px; font-weight: 800; font-size: 18px; color: #1e293b;">TỔNG THANH TOÁN:</td>
                        <td style="text-align: right; padding: 20px; font-weight: 800; font-size: 18px; color: #319DFF;">{{ number_format($order->total_amount) }}đ</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Payment Info -->
        <div class="panel" style="margin-top: 25px; background: #f0fdf4; border: 1px dashed #bbf7d0;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <span style="color: #166534; font-weight: 700; font-size: 14px;">ĐÃ THANH TOÁN:</span>
                    <span style="color: #166534; font-weight: 800; font-size: 20px; margin-left: 10px;">{{ number_format($order->amount_paid) }}đ</span>
                </div>
                <div>
                    <span style="color: #166534; font-weight: 700; font-size: 14px;">TIỀN THỪA:</span>
                    <span style="color: #166534; font-weight: 800; font-size: 20px; margin-left: 10px;">{{ number_format($order->change_amount) }}đ</span>
                </div>
            </div>
        </div>
    </div>
@endsection
