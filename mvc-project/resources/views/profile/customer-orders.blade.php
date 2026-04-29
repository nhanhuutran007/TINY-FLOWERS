@extends('layouts.profile')

@section('title', 'Lịch sử đơn hàng - Tiny Flowers')

@section('profile_styles')
<style>
    .order-card { border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 24px; overflow: hidden; background: white; transition: all 0.3s ease; }
    .order-card:hover { border-color: #319DFF; box-shadow: 0 4px 12px rgba(49, 157, 255, 0.05); }
    .order-header { background: #f8fafc; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; }
    .order-info { display: flex; gap: 24px; }
    .info-item { display: flex; flex-direction: column; }
    .info-label { font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 700; margin-bottom: 4px; letter-spacing: 0.5px; }
    .info-value { font-size: 14px; font-weight: 600; color: #0f172a; }
    .order-status { padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; }
    .status-pending { background: #fffbeb; color: #d97706; }
    .status-delivered { background: #ecfdf5; color: #10b981; }
    .status-cancelled { background: #fef2f2; color: #ef4444; }
    
    .order-items { padding: 20px; border-bottom: 1px dashed #e2e8f0; }
    .item-row { display: flex; gap: 16px; padding-bottom: 12px; margin-bottom: 12px; border-bottom: 1px solid #f8fafc; }
    .item-row:last-child { border-bottom: none; padding-bottom: 0; margin-bottom: 0; }
    .item-image { width: 64px; height: 64px; border-radius: 8px; object-fit: cover; border: 1px solid #f1f5f9; }
    .item-details { flex: 1; }
    .item-name { font-size: 14px; font-weight: 600; color: #0f172a; margin-bottom: 2px; }
    .item-meta { font-size: 12px; color: #64748b; }
    
    .order-footer { padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; background: white; }
    .toggle-details-btn { background: none; border: none; color: #319DFF; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; padding: 0; }
    .toggle-details-btn i { transition: transform 0.3s ease; }
    .toggle-details-btn.active i { transform: rotate(180deg); }
    .order-total-summary { text-align: right; }
    .total-amount { color: #ef4444; font-size: 18px; font-weight: 800; }

    /* Expanded Details */
    .order-details-expanded { display: none; padding: 20px; background: #fafafa; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; }
    .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
    .details-col h4 { font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px; border-left: 3px solid #319DFF; padding-left: 10px; }
    .details-list { list-style: none; padding: 0; margin: 0; }
    .details-list li { font-size: 13.5px; color: #475569; margin-bottom: 8px; display: flex; justify-content: space-between; }
    .details-list li span:first-child { color: #64748b; }
    .details-list li span:last-child { font-weight: 600; color: #1e293b; text-align: right; max-width: 200px; }
    
    .summary-box { background: white; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0; }

    .empty-orders { text-align: center; padding: 80px 20px; }
    .empty-orders i { font-size: 56px; color: #e2e8f0; margin-bottom: 24px; }
</style>
@endsection

@section('profile_content')
<div class="content-header">
    <h2>Đơn hàng của tôi</h2>
    <p>Xem thông tin tóm tắt và trạng thái các đơn hàng của bạn</p>
</div>

@forelse($orders as $order)
    <div class="order-card">
        <div class="order-header">
            <div class="order-info">
                <div class="info-item">
                    <span class="info-label">Mã đơn hàng</span>
                    <span class="info-value">#{{ $order->order_number }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Ngày đặt</span>
                    <span class="info-value">{{ $order->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
            <span class="order-status status-{{ strtolower($order->status) }}">
                {{ $order->status }}
            </span>
        </div>

        <div class="order-items">
            @foreach($order->items as $index => $item)
                <div class="item-row {{ $index >= 2 ? 'extra-item-' . $order->order_number : '' }}" style="{{ $index >= 2 ? 'display: none;' : '' }}">
                    <img src="{{ $item->product->image_url ?? asset('images/welcome/tshirt.png') }}" class="item-image">
                    <div class="item-details">
                        <div class="item-name">{{ $item->product_name }}</div>
                        <div class="item-meta">Số lượng: {{ $item->quantity }} | Đơn giá: {{ number_format($item->selling_price) }}đ</div>
                    </div>
                    <div style="font-weight: 700; color: #0f172a;">{{ number_format($item->selling_price * $item->quantity) }}đ</div>
                </div>
            @endforeach
            @if($order->items->count() > 2)
                <div id="more-items-{{ $order->order_number }}" style="text-align: center; font-size: 12px; color: #94a3b8; margin-top: 10px;">Và {{ $order->items->count() - 2 }} sản phẩm khác...</div>
            @endif
        </div>

        <!-- Hidden Details Section -->
        <div class="order-details-expanded" id="details-{{ $order->order_number }}">
            <div class="details-grid">
                <div class="details-col">
                    <h4>Thông tin vận chuyển</h4>
                    <div class="summary-box">
                        <ul class="details-list">
                            <li><span>Người nhận:</span> <span>{{ $order->customer->name ?? Auth::user()->fullname }}</span></li>
                            <li><span>Số điện thoại:</span> <span>{{ $order->customer->phone ?? 'N/A' }}</span></li>
                            <li><span>Địa chỉ:</span> <span>{{ $order->shipping_address }}</span></li>
                            <li><span>Ghi chú:</span> <span>{{ $order->notes ?? 'Không có' }}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="details-col">
                    <h4>Chi tiết thanh toán</h4>
                    <div class="summary-box">
                        <ul class="details-list">
                            <li><span>Phương thức:</span> <span>{{ $order->payment_method }}</span></li>
                            <li><span>Tạm tính:</span> <span>{{ number_format($order->subtotal) }}đ</span></li>
                            <li><span>Phí ship:</span> <span>{{ number_format($order->shipping_fee) }}đ</span></li>
                            @if($order->discount > 0)
                            <li><span>Giảm giá:</span> <span style="color: #10b981;">-{{ number_format($order->discount) }}đ</span></li>
                            @endif
                            <li style="border-top: 1px solid #f1f5f9; padding-top: 8px; margin-top: 8px;">
                                <span style="font-weight: 700; color: #0f172a;">Tổng tiền:</span> 
                                <span style="font-weight: 800; color: #ef4444; font-size: 16px;">{{ number_format($order->total_amount) }}đ</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @if($order->status == 'Delivered')
            <div style="margin-top: 20px; text-align: right;">
                <a href="{{ route('account.order_details', $order->order_number) }}" class="btn-primary" style="display: inline-block; text-decoration: none; font-size: 13px; padding: 10px 20px; background: #0f172a; color: white; border-radius: 8px;">Đánh giá sản phẩm</a>
            </div>
            @endif
        </div>

        <div class="order-footer">
            <button class="toggle-details-btn" onclick="toggleOrderDetails('{{ $order->order_number }}', this)">
                <span>Xem chi tiết</span> <i class="fas fa-chevron-down"></i>
            </button>
            <div class="order-total-summary">
                <span style="font-size: 13px; color: #64748b;">Thành tiền:</span>
                <span class="total-amount">{{ number_format($order->total_amount) }}đ</span>
            </div>
        </div>
    </div>
@empty
    <div class="empty-orders">
        <i class="fas fa-shopping-bag"></i>
        <p style="color: #64748b; font-size: 16px;">Bạn chưa có đơn hàng nào.</p>
        <a href="{{ route('home') }}" class="btn-primary" style="display: inline-block; margin-top: 20px; text-decoration: none; background: #0f172a; color: white; padding: 12px 24px; border-radius: 8px;">Mua sắm ngay</a>
    </div>
@endforelse
@endsection

@section('scripts')
<script>
    function toggleOrderDetails(orderNumber, btn) {
        const details = document.getElementById('details-' + orderNumber);
        const isVisible = details.style.display === 'block';
        
        // Hide all others if desired, or just toggle this one
        details.style.display = isVisible ? 'none' : 'block';
        btn.classList.toggle('active');
        
        const btnText = btn.querySelector('span');
        btnText.textContent = isVisible ? 'Xem chi tiết' : 'Thu gọn';

        // Toggle extra items
        const extraItems = document.querySelectorAll('.extra-item-' + orderNumber);
        extraItems.forEach(item => {
            item.style.display = isVisible ? 'none' : 'flex';
        });

        // Toggle "more items" text
        const moreText = document.getElementById('more-items-' + orderNumber);
        if (moreText) {
            moreText.style.display = isVisible ? 'block' : 'none';
        }
    }
</script>
@endsection
