@extends('layouts.app')

@section('title', 'Báo cáo doanh thu')

@section('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
    <div class="page-title-bar">
        <h1 class="page-title-text">Báo cáo & Thống kê</h1>
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 10px; color: #aaa;"></i>
            <span>Báo cáo</span>
        </div>
    </div>

    <div class="page-content">
        <!-- Stats Row -->
        <div class="stats-grid" style="grid-template-columns: repeat(4, 1fr);">
            <div class="stat-card">
                <div class="stat-label">TỔNG DOANH THU</div>
                <div class="stat-value" style="color: #10B981;">{{ number_format($stats['total_revenue']) }}đ</div>
                <div class="trend-indicator trend-up"><i class="fas fa-arrow-up"></i> +12%</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">TỔNG ĐƠN HÀNG</div>
                <div class="stat-value">{{ $stats['total_orders'] }}</div>
                <div class="trend-indicator trend-up"><i class="fas fa-arrow-up"></i> +5%</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">SẢN PHẨM</div>
                <div class="stat-value">{{ $stats['total_products'] }}</div>
                <div class="trend-indicator">Ổn định</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">KHÁCH HÀNG</div>
                <div class="stat-value">{{ $stats['total_customers'] }}</div>
                <div class="trend-indicator trend-up"><i class="fas fa-arrow-up"></i> +8%</div>
            </div>
        </div>

        <div class="analytics-grid" style="grid-template-columns: 1fr; margin-top: 25px;">
            <div class="panel">
                <div class="panel-header">
                    <h2 class="panel-title">Biểu đồ doanh thu theo thời gian</h2>
                    <div class="panel-actions">
                        <select class="select-custom">
                            <option>Tháng này</option>
                            <option>Tháng trước</option>
                            <option>Năm nay</option>
                        </select>
                    </div>
                </div>
                <div class="chart-container" style="height: 400px;">
                    <canvas id="revenueChartDetailed"></canvas>
                </div>
            </div>
        </div>

        <div class="analytics-grid">
            <div class="panel">
                <div class="panel-header">
                    <h2 class="panel-title">Tỉ lệ thanh toán</h2>
                </div>
                <div class="chart-container" style="height: 300px;">
                    <canvas id="paymentMethodChart"></canvas>
                </div>
            </div>
            <div class="panel">
                <div class="panel-header">
                    <h2 class="panel-title">Top sản phẩm bán chạy</h2>
                </div>
                <div class="progress-list">
                    <div class="progress-item">
                        <div class="progress-info"><span>Áo Sơ Mi Oxford</span><span>85%</span></div>
                        <div class="progress-bar-bg"><div class="progress-bar-fill" style="width: 85%"></div></div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-info"><span>Quần Tây Slim Fit</span><span>62%</span></div>
                        <div class="progress-bar-bg"><div class="progress-bar-fill" style="width: 62%; background: #10B981;"></div></div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-info"><span>Giày Loafer</span><span>45%</span></div>
                        <div class="progress-bar-bg"><div class="progress-bar-fill" style="width: 45%; background: #F0950C;"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .select-custom { padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; background: white; font-size: 13px; color: #475569; }
    </style>

    <script>
        // Detailed Revenue Chart
        const revCtx = document.getElementById('revenueChartDetailed').getContext('2d');
        new Chart(revCtx, {
            type: 'line',
            data: {
                labels: ['Ngày 1', 'Ngày 5', 'Ngày 10', 'Ngày 15', 'Ngày 20', 'Ngày 25', 'Ngày 30'],
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: [1500000, 2800000, 2100000, 3500000, 4200000, 3800000, 5000000],
                    borderColor: '#319DFF',
                    backgroundColor: 'rgba(49, 157, 255, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5] }, ticks: { callback: v => v.toLocaleString() + 'đ' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Payment Method Chart
        const payCtx = document.getElementById('paymentMethodChart').getContext('2d');
        new Chart(payCtx, {
            type: 'doughnut',
            data: {
                labels: ['Tiền mặt', 'Chuyển khoản', 'Ví điện tử'],
                datasets: [{
                    data: [60, 30, 10],
                    backgroundColor: ['#319DFF', '#10B981', '#F0950C'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'right' } },
                cutout: '70%'
            }
        });
    </script>
@endsection
