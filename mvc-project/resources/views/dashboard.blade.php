@extends('layouts.app')

@section('title', 'Bảng điều khiển')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/premium-dashboard.css') }}?v={{ time() }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="premium-dashboard">
    <!-- Page Title / Breadcrumb bar -->
    <div class="page-title-bar">
        <div>
            <h1 class="page-title-text">Tổng quan hệ thống</h1>
            <p style="color: var(--text-secondary); margin: 4px 0 0; font-size: 14px;">Chào mừng bạn quay trở lại, {{ Auth::user()->fullname }}</p>
        </div>

        <nav class="submenu-tabs" aria-label="Dashboard submenu">
            <button class="submenu-tab submenu-tab--active" onclick="switchTab('analytics', this)" id="tab-analytics">
                <i class="fas fa-chart-pie" style="margin-right: 6px;"></i> Phân tích
            </button>
            <button class="submenu-tab" onclick="switchTab('ecommerce', this)" id="tab-ecommerce">
                <i class="fas fa-shopping-bag" style="margin-right: 6px;"></i> E-Commerce
            </button>
        </nav>
    </div>

    <!-- Page Content -->
    <div class="page-content">

        <!-- Analytics Section -->
        <div id="analytics" class="dash-section active">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon" style="background: rgba(60, 80, 224, 0.1); color: var(--accent-blue)">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="trend-indicator {{ $revenueGrowth >= 0 ? 'trend-up' : 'trend-down' }}">
                            <i class="fas fa-arrow-{{ $revenueGrowth >= 0 ? 'up' : 'down' }}"></i> 
                            <span>{{ number_format(abs($revenueGrowth), 1) }}%</span>
                        </div>
                    </div>
                    <div class="stat-value">₫{{ number_format($monthlyRevenue ?? 0) }}</div>
                    <div class="stat-label">Doanh thu tháng này</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--accent-green)">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ number_format($totalOrders ?? 0) }}</div>
                    <div class="stat-label">Tổng đơn hàng</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon" style="background: rgba(240, 149, 12, 0.1); color: var(--accent-orange)">
                            <i class="fas fa-tag"></i>
                        </div>
                    </div>
                    <div class="stat-value">₫{{ number_format($avgOrderValue ?? 0) }}</div>
                    <div class="stat-label">Giá trị TB đơn hàng</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon" style="background: rgba(99, 102, 241, 0.1); color: var(--accent-indigo)">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ number_format($totalCustomers ?? 0) }}</div>
                    <div class="stat-label">Khách hàng mới</div>
                </div>
            </div>

            <div class="analytics-grid">
                <!-- Line Chart -->
                <div class="panel">
                    <div class="panel-header">
                        <h2 class="panel-title">Biểu đồ doanh thu 12 tháng</h2>
                        <div style="display: flex; gap: 8px;">
                            <span style="display: flex; align-items: center; font-size: 12px; color: var(--text-secondary);">
                                <span style="width: 8px; height: 8px; background: var(--accent-blue); border-radius: 50%; margin-right: 4px;"></span> Thực tế
                            </span>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Top Selling List -->
                <div class="panel">
                    <div class="panel-header">
                        <h2 class="panel-title">Sản phẩm bán chạy</h2>
                        <a href="{{ route('products.index') }}" style="font-size: 12px; color: var(--accent-blue); font-weight: 600;">Xem tất cả</a>
                    </div>
                    <div class="progress-list">
                        @php $maxSales = $topSelling->max('total_sales') ?: 1; @endphp
                        @foreach($topSelling as $item)
                        <div class="progress-item">
                            <div class="progress-info">
                                <span style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $item->product ? $item->product->name : 'Sản phẩm đã xóa' }}
                                </span>
                                <span>₫{{ number_format($item->total_sales) }}</span>
                            </div>
                            <div class="progress-bar-bg">
                                @php
                                    $percentage = ($item->total_sales / $maxSales) * 100;
                                    $colors = ['#3C50E0', '#10B981', '#F0950C', '#ef4444', '#8B5CF6'];
                                    $color = $colors[$loop->index % 5];
                                @endphp
                                <div class="progress-bar-fill" style="width: {{ $percentage }}%; background: {{ $color }}"></div>
                            </div>
                        </div>
                        @endforeach

                        @if($topSelling->isEmpty())
                            <div style="text-align: center; color: var(--text-secondary); padding: 20px;">
                                Chưa có dữ liệu bán hàng
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- E-Commerce Section -->
        <div id="ecommerce" class="dash-section">
            <div class="stats-grid ecom-stats">
                <div class="stat-card ecom-card">
                    <div class="ecom-card-body">
                        <div class="ecom-card-label">TỔNG DOANH THU</div>
                        <div class="ecom-card-value">₫{{ number_format($totalRevenue) }}</div>
                        <div class="ecom-card-trend trend-up">
                            <i class="fas fa-check-circle"></i> Đã hoàn thành
                        </div>
                    </div>
                    <div class="ecom-card-icon" style="background: linear-gradient(135deg, #10B981, #059669);">
                        <i class="fas fa-wallet" style="color:#fff;font-size:22px;"></i>
                    </div>
                </div>
                <div class="stat-card ecom-card">
                    <div class="ecom-card-body">
                        <div class="ecom-card-label">SẢN PHẨM</div>
                        <div class="ecom-card-value">{{ number_format($totalProducts) }}</div>
                        <div class="ecom-card-trend" style="color: var(--text-secondary)">
                            <i class="fas fa-box"></i> Trong kho
                        </div>
                    </div>
                    <div class="ecom-card-icon" style="background: linear-gradient(135deg, #3C50E0, #2563EB);">
                        <i class="fas fa-tshirt" style="color:#fff;font-size:22px;"></i>
                    </div>
                </div>
                <div class="stat-card ecom-card">
                    <div class="ecom-card-body">
                        <div class="ecom-card-label">ĐƠN HÀNG MỚI</div>
                        <div class="ecom-card-value">{{ number_format($pendingOrdersCount) }}</div>
                        <div class="ecom-card-trend trend-down">
                            <i class="fas fa-clock"></i> Cần xử lý
                        </div>
                    </div>
                    <div class="ecom-card-icon" style="background: linear-gradient(135deg, #F0950C, #D97706);">
                        <i class="fas fa-shopping-bag" style="color:#fff;font-size:22px;"></i>
                    </div>
                </div>
            </div>

            <div class="ecom-bottom-grid">
                <div class="panel">
                    <div class="panel-header">
                        <h2 class="panel-title">ĐƠN HÀNG GẦN ĐÂY</h2>
                        <a href="{{ route('orders.index') }}" class="submenu-tab" style="text-decoration: none; font-size: 12px;">Xem tất cả</a>
                    </div>
                    <table class="ecom-orders-table">
                        <thead>
                            <tr>
                                <th>Khách hàng</th>
                                <th>Giá trị</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td class="order-customer">
                                    @php
                                        $customerName = $order->customer ? $order->customer->name : ($order->user ? $order->user->fullname : 'Khách lẻ');
                                    @endphp
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($customerName) }}&size=40&background=random&color=fff" class="order-avatar" alt="">
                                    <div>
                                        <div class="order-name">{{ $customerName }}</div>
                                        <div class="order-time">{{ $order->created_at->diffForHumans() }}</div>
                                    </div>
                                </td>
                                <td class="order-price">₫{{ number_format($order->total_amount) }}</td>
                                <td>
                                    @php
                                        $statusLabel = $order->status;
                                        $statusColor = '#64748B';
                                        $statusBg = '#F1F5F9';
                                        
                                        if($order->status == 'Pending') { $statusColor = '#D97706'; $statusBg = '#FEF3C7'; $statusLabel = 'Chờ xử lý'; }
                                        elseif($order->status == 'Processing') { $statusColor = '#2563EB'; $statusBg = '#DBEAFE'; $statusLabel = 'Đang xử lý'; }
                                        elseif($order->status == 'Shipped') { $statusColor = '#7C3AED'; $statusBg = '#EDE9FE'; $statusLabel = 'Đang giao'; }
                                        elseif($order->status == 'Delivered') { $statusColor = '#059669'; $statusBg = '#D1FAE5'; $statusLabel = 'Đã giao'; }
                                        elseif($order->status == 'Cancelled') { $statusColor = '#DC2626'; $statusBg = '#FEE2E2'; $statusLabel = 'Đã hủy'; }
                                    @endphp
                                    <span class="order-status" style="color: {{ $statusColor }}; background: {{ $statusBg }};">
                                        <i class="fas fa-circle" style="font-size: 6px;"></i> {{ $statusLabel }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="panel">
                    <div class="panel-header">
                        <h2 class="panel-title">TĂNG TRƯỞNG TUẦN</h2>
                        <div style="font-size: 12px; color: var(--text-secondary);">7 ngày qua</div>
                    </div>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Products in E-commerce view -->
            <div class="panel" style="margin: 0 30px 30px;">
                <div class="panel-header">
                    <h2 class="panel-title">PHÂN TÍCH SẢN PHẨM</h2>
                </div>
                <table class="top-selling-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng bán</th>
                            <th>Tổng doanh thu</th>
                            <th>Tỷ lệ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topSelling as $item)
                        <tr>
                            <td class="product-cell">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('images/' . $item->product->image) }}" class="product-img" alt="">
                                @else
                                    <div class="product-img" style="display: flex; align-items: center; justify-content: center; font-size: 18px; color: #94A3B8;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                                <span style="font-weight: 700;">{{ $item->product ? $item->product->name : 'Sản phẩm đã xóa' }}</span>
                            </td>
                            <td>₫{{ number_format($item->product ? $item->product->selling_price : 0) }}</td>
                            <td style="text-align: center;">{{ number_format($item->total_quantity) }}</td>
                            <td style="font-weight: 700; color: var(--accent-blue);">₫{{ number_format($item->total_sales) }}</td>
                            <td>
                                @php $percent = ($item->total_sales / $maxSales) * 100; @endphp
                                <div class="sell-bar-wrap">
                                    <div class="sell-bar">
                                        <div class="sell-bar-fill" style="width: {{ $percent }}%; background: var(--accent-blue);"></div>
                                    </div>
                                    <span style="font-size: 12px; font-weight: 700; min-width: 35px;">{{ number_format($percent, 0) }}%</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        function switchTab(tabId, clickedEl) {
            document.querySelectorAll('.dash-section').forEach(s => s.classList.remove('active'));
            var section = document.getElementById(tabId);
            if (section) section.classList.add('active');

            document.querySelectorAll('.submenu-tab').forEach(function(t) {
                t.classList.remove('submenu-tab--active');
            });
            if (clickedEl) clickedEl.classList.add('submenu-tab--active');
        }

        // --- Revenue Chart (Analytics) ---
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(60, 80, 224, 0.2)');
        gradient.addColorStop(1, 'rgba(60, 80, 224, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Doanh thu',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#3C50E0',
                    borderWidth: 3,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#FFF',
                    pointBorderColor: '#3C50E0',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#E2E8F0', drawBorder: false },
                        ticks: {
                            callback: value => '₫' + (value/1000000).toFixed(1) + 'M',
                            font: { size: 11 }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });

        // --- Weekly Chart (E-Commerce) ---
        const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
        if (weeklyCtx) {
            new Chart(weeklyCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($weeklyLabels) !!},
                    datasets: [{
                        label: 'Doanh thu ngày',
                        data: {!! json_encode($weeklyData) !!},
                        backgroundColor: '#3C50E0',
                        borderRadius: 6,
                        barThickness: 20,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [5, 5], color: '#E2E8F0', drawBorder: false },
                            ticks: {
                                callback: value => '₫' + (value/1000).toFixed(0) + 'k',
                                font: { size: 11 }
                            }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    </script>
@endsection

