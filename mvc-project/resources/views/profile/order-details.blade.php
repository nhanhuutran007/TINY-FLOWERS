@extends('layouts.profile')

@section('title', 'Chi tiết đơn hàng #' . $order->order_number . ' - Tiny Flowers')

@section('profile_styles')
<style>
    .order-detail-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #f1f5f9; }
    .back-link { color: #64748b; text-decoration: none; font-size: 14px; display: flex; align-items: center; gap: 8px; margin-bottom: 15px; transition: color 0.2s; }
    .back-link:hover { color: #0f172a; }
    
    .status-badge { padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .status-pending { background: #fffbeb; color: #d97706; }
    .status-processing { background: #eff6ff; color: #2563eb; }
    .status-shipped { background: #fdf4ff; color: #c026d3; }
    .status-delivered { background: #ecfdf5; color: #10b981; }
    .status-cancelled { background: #fef2f2; color: #ef4444; }

    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 30px; }
    .info-card { background: #f8fafc; border-radius: 16px; padding: 20px; border: 1px solid #f1f5f9; }
    .info-card h3 { font-size: 13px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 15px; letter-spacing: 0.5px; }
    .info-line { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; }
    .info-line:last-child { margin-bottom: 0; }
    .info-label { color: #94a3b8; }
    .info-value { color: #1e293b; font-weight: 600; text-align: right; }

    .order-items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
    .order-items-table th { text-align: left; padding: 12px 16px; font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; border-bottom: 1px solid #f1f5f9; }
    .order-items-table td { padding: 20px 16px; border-bottom: 1px solid #f8fafc; }
    
    .product-info-cell { display: flex; align-items: center; gap: 15px; }
    .product-img { width: 60px; height: 60px; border-radius: 8px; object-fit: cover; background: #f8fafc; border: 1px solid #f1f5f9; }
    .product-name { font-size: 14px; font-weight: 600; color: #0f172a; }
    
    .review-btn { background: #0f172a; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 6px; }
    .review-btn:hover { background: #1e293b; transform: translateY(-2px); }

    .summary-section { background: #0f172a; border-radius: 16px; padding: 24px; color: white; margin-left: auto; max-width: 350px; }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; }
    .summary-row.total { margin-top: 15px; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 18px; font-weight: 800; }
    .summary-label { color: rgba(255,255,255,0.6); }

    /* Modal Styles */
    .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
    .modal-content { background: white; width: 100%; max-width: 450px; border-radius: 24px; padding: 30px; position: relative; animation: modalSlideUp 0.3s ease; }
    @keyframes modalSlideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    
    .star-rating { display: flex; gap: 10px; margin: 20px 0; justify-content: center; }
    .star-rating i { font-size: 30px; color: #e2e8f0; cursor: pointer; transition: color 0.2s; }
    .star-rating i.active { color: #f59e0b; }
</style>
@section('profile_content')
    <a href="{{ route('profile.orders') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách đơn hàng
    </a>

    <div class="order-detail-header">
        <div>
            <h2 style="margin: 0; font-size: 24px;">Chi tiết đơn hàng #{{ $order->order_number }}</h2>
            <p style="color: #64748b; margin-top: 5px;">Đặt ngày {{ $order->created_at->format('d/m/Y \l\ú\c H:i') }}</p>
        </div>
        <span class="status-badge status-{{ strtolower($order->status) }}">
            {{ $order->status }}
        </span>
    </div>

    <div class="info-grid">
        <div class="info-card">
            <h3>Thông tin vận chuyển</h3>
            <div class="info-line">
                <span class="info-label">Người nhận:</span>
                <span class="info-value">{{ $order->customer->name }}</span>
            </div>
            <div class="info-line">
                <span class="info-label">Số điện thoại:</span>
                <span class="info-value">{{ $order->customer->phone }}</span>
            </div>
            <div class="info-line">
                <span class="info-label">Địa chỉ:</span>
                <span class="info-value">{{ $order->shipping_address }}</span>
            </div>
        </div>
        <div class="info-card">
            <h3>Thông tin thanh toán</h3>
            <div class="info-line">
                <span class="info-label">Phương thức:</span>
                <span class="info-value">
                    @if($order->payment_method == 'qr') 
                        Chuyển khoản QR
                    @elseif($order->payment_method == 'card')
                        Thẻ tín dụng
                    @else
                        Thanh toán khi nhận hàng (COD)
                    @endif
                </span>
            </div>
            <div class="info-line">
                <span class="info-label">Trạng thái:</span>
                <span class="info-value" style="color: {{ ($order->payment_status == 'paid' || strtolower($order->status) == 'delivered') ? '#10b981' : '#f59e0b' }}">
                    {{ ($order->payment_status == 'paid' || strtolower($order->status) == 'delivered') ? 'Đã thanh toán' : 'Chờ thanh toán' }}
                </span>
            </div>
            <div class="info-line">
                <span class="info-label">Số tiền đã trả:</span>
                <span class="info-value" style="color: #10b981;">
                    {{ (strtolower($order->status) == 'delivered' || $order->payment_status == 'paid') ? number_format($order->total_amount) : '0' }}đ
                </span>
            </div>
            <div class="info-line">
                <span class="info-label">Ghi chú:</span>
                <span class="info-value">{{ $order->notes ?? 'Không có' }}</span>
            </div>
        </div>
    </div>

    <table class="order-items-table">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>
                        <div class="product-info-cell">
                            <img src="{{ $item->product->image_url }}" class="product-img">
                            <span class="product-name">{{ $item->product_name }}</span>
                        </div>
                    </td>
                    <td>{{ number_format($item->selling_price) }}đ</td>
                    <td>{{ $item->quantity }}</td>
                    <td style="font-weight: 700;">{{ number_format($item->subtotal) }}đ</td>
                    <td style="text-align: right;">
                        @if($order->status == 'Delivered')
                            <button class="review-btn" onclick="openReviewModal({{ $item->product_id }}, '{{ $item->product_name }}')">
                                <i class="fas fa-star"></i> Đánh giá
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-section">
        <div class="summary-row">
            <span class="summary-label">Tạm tính</span>
            <span>{{ number_format($order->subtotal) }}đ</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Phí vận chuyển</span>
            <span>{{ number_format($order->shipping_fee) }}đ</span>
        </div>
        @if($order->discount > 0)
            <div class="summary-row">
                <span class="summary-label">Giảm giá</span>
                <span style="color: #10b981;">-{{ number_format($order->discount) }}đ</span>
            </div>
        @endif
        <div class="summary-row total">
            <span>Tổng cộng</span>
            <span>{{ number_format($order->total_amount) }}đ</span>
        </div>
        <div class="summary-row" style="margin-top: 10px; font-size: 13px; opacity: 0.8; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 10px;">
            <span class="summary-label">Số tiền đã thanh toán</span>
            <span style="font-weight: 700;">{{ (strtolower($order->status) == 'delivered' || $order->payment_status == 'paid') ? number_format($order->total_amount) : '0' }}đ</span>
        </div>
    </div>

    <!-- Review Modal -->
    <div id="reviewModal" class="modal">
        <div class="modal-content">
            <h3 id="modalProductName" style="margin-top: 0; font-size: 18px;">Đánh giá sản phẩm</h3>
            <p style="color: #64748b; font-size: 14px; margin-bottom: 10px;">Chia sẻ trải nghiệm của bạn về sản phẩm này</p>
            
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" id="modalProductId">
                
                <div class="star-rating">
                    <i class="fas fa-star" data-rating="1"></i>
                    <i class="fas fa-star" data-rating="2"></i>
                    <i class="fas fa-star" data-rating="3"></i>
                    <i class="fas fa-star" data-rating="4"></i>
                    <i class="fas fa-star" data-rating="5"></i>
                </div>
                <input type="hidden" name="rating" id="ratingInput" value="5">

                <textarea name="comment" placeholder="Bạn cảm thấy thế nào về chất lượng sản phẩm, dịch vụ? (Tùy chọn)" style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 15px; font-family: inherit; font-size: 14px; min-height: 120px; outline: none; margin-bottom: 20px; box-sizing: border-box;"></textarea>

                <div style="display: flex; gap: 12px;">
                    <button type="submit" style="flex: 1; background: #0f172a; color: white; border: none; padding: 14px; border-radius: 12px; font-weight: 700; cursor: pointer;">Gửi đánh giá</button>
                    <button type="button" onclick="closeReviewModal()" style="flex: 1; background: #f1f5f9; color: #475569; border: none; padding: 14px; border-radius: 12px; font-weight: 700; cursor: pointer;">Hủy</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function openReviewModal(productId, productName) {
        document.getElementById('modalProductId').value = productId;
        document.getElementById('modalProductName').innerText = 'Đánh giá: ' + productName;
        document.getElementById('reviewModal').style.display = 'flex';
        setRating(5);
    }

    function closeReviewModal() {
        document.getElementById('reviewModal').style.display = 'none';
    }

    function setRating(val) {
        document.getElementById('ratingInput').value = val;
        const stars = document.querySelectorAll('.star-rating i');
        stars.forEach((star, index) => {
            if (index < val) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
    }

    document.querySelectorAll('.star-rating i').forEach(star => {
        star.addEventListener('click', function() {
            setRating(this.getAttribute('data-rating'));
        });
    });

    window.onclick = function(event) {
        if (event.target == document.getElementById('reviewModal')) {
            closeReviewModal();
        }
    }
</script>
@endsection
