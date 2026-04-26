@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng ' . $order->order_number)

@section('content')
<div class="page-title-bar">
    <div style="display: flex; align-items: center; gap: 12px;">
        <a href="{{ route('profile.orders') }}" class="btn-icon"><i class="fas fa-arrow-left"></i></a>
        <h1 class="page-title-text">Chi tiết đơn hàng {{ $order->order_number }}</h1>
    </div>
</div>

<div class="page-content">
    <div class="analytics-grid">
        <!-- Order Info -->
        <div class="panel">
            <div class="panel-header">
                <h2 class="panel-title">Thông tin đơn hàng</h2>
            </div>
            <div style="padding: 15px;">
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Trạng thái:</span>
                        <strong>{{ strtoupper($order->status) }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Ngày đặt:</span>
                        <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Phương thức thanh toán:</span>
                        <span>{{ ucfirst($order->payment_method) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Địa chỉ nhận hàng:</span>
                        <span style="text-align: right; max-width: 200px;">{{ $order->shipping_address }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="panel">
            <div class="panel-header">
                <h2 class="panel-title">Tổng cộng</h2>
            </div>
            <div style="padding: 15px;">
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($order->subtotal) }}đ</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Phí vận chuyển:</span>
                        <span>{{ number_format($order->shipping_fee) }}đ</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 18px; color: var(--accent-blue); margin-top: 10px; border-top: 1px solid #EEE; padding-top: 10px;">
                        <span>Tổng tiền:</span>
                        <span>{{ number_format($order->total_amount) }}đ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items & Reviews -->
    <div class="panel" style="margin-top: 20px;">
        <div class="panel-header">
            <h2 class="panel-title">Sản phẩm & Đánh giá</h2>
        </div>
        <table class="ecom-orders-table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Đánh giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td class="product-cell">
                        <img src="{{ asset('images/' . ($item->product ? $item->product->image : 'default-product.png')) }}" class="product-img" alt="">
                        {{ $item->product_name }}
                    </td>
                    <td>{{ number_format($item->selling_price) }}đ</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->subtotal) }}đ</td>
                    <td>
                        @if($order->status == 'delivered')
                            <button class="btn btn-sm btn-outline" onclick="openReviewModal({{ $item->product_id }}, '{{ $item->product_name }}')">
                                <i class="fas fa-star"></i> Đánh giá
                            </button>
                        @else
                            <span style="font-size: 12px; color: #999;">Cần hoàn thành đơn hàng để đánh giá</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Review Modal -->
<div id="reviewModal" class="modal" style="display:none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center;">
    <div style="background: #fff; padding: 25px; border-radius: 12px; width: 400px; max-width: 90%;">
        <h3 id="modalProductName" style="margin-bottom: 20px;">Đánh giá sản phẩm</h3>
        <form action="{{ route('reviews.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" id="modalProductId">
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px;">Số sao:</label>
                <div class="star-rating" style="display: flex; gap: 5px; font-size: 24px; color: #DDD; cursor: pointer;">
                    <i class="fas fa-star" onclick="setRating(1)"></i>
                    <i class="fas fa-star" onclick="setRating(2)"></i>
                    <i class="fas fa-star" onclick="setRating(3)"></i>
                    <i class="fas fa-star" onclick="setRating(4)"></i>
                    <i class="fas fa-star" onclick="setRating(5)"></i>
                </div>
                <input type="hidden" name="rating" id="ratingInput" value="5">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px;">Nhận xét:</label>
                <textarea name="comment" style="width: 100%; padding: 10px; border: 1px solid #DDD; border-radius: 8px; height: 100px;" placeholder="Cảm nhận của bạn về sản phẩm..."></textarea>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">Gửi đánh giá</button>
                <button type="button" class="btn" style="flex: 1; background: #EEE;" onclick="closeReviewModal()">Hủy</button>
            </div>
        </form>
    </div>
</div>

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
                star.style.color = '#F0950C';
            } else {
                star.style.color = '#DDD';
            }
        });
    }
</script>
@endsection
