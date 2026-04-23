@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
    <!-- Page Title / Breadcrumb bar — thiết kế theo nguon.txt SVG -->
    <div class="page-title-bar">
        <!-- Left: Page title -->
        <h1 class="page-title-text">Dashboards</h1>

        <!-- Right: Submenu tabs -->
        <nav class="submenu-tabs" aria-label="Dashboard submenu">
            <button class="submenu-tab submenu-tab--active" onclick="switchTab('analytics', this)" id="tab-analytics">
                Analytics
            </button>
            <button class="submenu-tab" onclick="switchTab('ecommerce', this)" id="tab-ecommerce">
                E-Commerce
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
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                    <div class="stat-value">12,543</div>
                    <div class="stat-label">Lượt xem trang</div>
                    <div class="trend-indicator trend-up">
                        <i class="fas fa-arrow-up"></i> 12.5% <span>tháng này</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--accent-green)">
                            <i class="fas fa-coins"></i>
                        </div>
                    </div>
                    <div class="stat-value">₫ 45.2M</div>
                    <div class="stat-label">Tổng lợi nhuận</div>
                    <div class="trend-indicator trend-up">
                        <i class="fas fa-arrow-up"></i> 8.2% <span>tháng này</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon" style="background: rgba(240, 149, 12, 0.1); color: var(--accent-orange)">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                    <div class="stat-value">2,450</div>
                    <div class="stat-label">Tổng sản phẩm</div>
                    <div class="trend-indicator trend-down">
                        <i class="fas fa-arrow-down"></i> 2.1% <span>tháng này</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--accent-green)">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-value">1,205</div>
                    <div class="stat-label">Khách hàng mới</div>
                    <div class="trend-indicator trend-up">
                        <i class="fas fa-arrow-up"></i> 15.4% <span>tháng này</span>
                    </div>
                </div>
            </div>

            <div class="analytics-grid">
                <!-- Line Chart -->
                <div class="panel">
                    <div class="panel-header">
                        <h2 class="panel-title">Doanh thu & Chi phí</h2>
                        <select style="border: 1px solid #DDD; padding: 5px; border-radius: 4px; font-size: 12px">
                            <option>7 ngày qua</option>
                            <option>30 ngày qua</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Top Selling List -->
                <div class="panel">
                    <div class="panel-header">
                        <h2 class="panel-title">Sản phẩm bán chạy</h2>
                    </div>
                    <div class="progress-list">
                        <div class="progress-item">
                            <div class="progress-info">
                                <span>Áo Sơ Mi Oxford</span>
                                <span>₫ 12.5M</span>
                            </div>
                            <div class="progress-bar-bg">
                                <div class="progress-bar-fill" style="width: 85%"></div>
                            </div>
                        </div>
                        <div class="progress-item">
                            <div class="progress-info">
                                <span>Quần Tây Slim Fit</span>
                                <span>₫ 8.2M</span>
                            </div>
                            <div class="progress-bar-bg">
                                <div class="progress-bar-fill" style="width: 65%; background: var(--accent-green)"></div>
                            </div>
                        </div>
                        <div class="progress-item">
                            <div class="progress-info">
                                <span>Giày Loafer Da Cừu</span>
                                <span>₫ 5.4M</span>
                            </div>
                            <div class="progress-bar-bg">
                                <div class="progress-bar-fill" style="width: 45%; background: var(--accent-orange)"></div>
                            </div>
                        </div>
                        <div class="progress-item">
                            <div class="progress-info">
                                <span>Vest Comple Cao Cấp</span>
                                <span>₫ 4.1M</span>
                            </div>
                            <div class="progress-bar-bg">
                                <div class="progress-bar-fill" style="width: 35%; background: var(--accent-red)"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- E-Commerce Section — khớp với ảnh thiết kế -->
        <div id="ecommerce" class="dash-section">
            <!-- Stat Cards: REVENUES / CUSTOMERS / SHOP VIEWS -->
            <div class="stats-grid ecom-stats">
                <div class="stat-card ecom-card">
                    <div class="ecom-card-body">
                        <div class="ecom-card-label">REVENUES</div>
                        <div class="ecom-card-value">$ 3,503.26</div>
                        <div class="ecom-card-trend trend-up"><i class="fas fa-arrow-up"></i> +6.90% since last month</div>
                    </div>
                    <div class="ecom-card-icon" style="background:#10B981;"><i class="fas fa-store" style="color:#fff;font-size:22px;"></i></div>
                </div>
                <div class="stat-card ecom-card">
                    <div class="ecom-card-body">
                        <div class="ecom-card-label">CUSTOMERS</div>
                        <div class="ecom-card-value">34</div>
                        <div class="ecom-card-trend trend-down"><i class="fas fa-arrow-down"></i> -2.86% since last month</div>
                    </div>
                    <div class="ecom-card-icon" style="background:#F04438;"><i class="fas fa-users" style="color:#fff;font-size:22px;"></i></div>
                </div>
                <div class="stat-card ecom-card">
                    <div class="ecom-card-body">
                        <div class="ecom-card-label">SHOP VIEWS</div>
                        <div class="ecom-card-value">683</div>
                        <div class="ecom-card-trend trend-up"><i class="fas fa-arrow-up"></i> +1.70% since last month</div>
                    </div>
                    <div class="ecom-card-icon" style="background:#319DFF;"><i class="fas fa-shopping-bag" style="color:#fff;font-size:22px;"></i></div>
                </div>
            </div>

            <!-- Bottom Row: RECENT ORDERS + SALES chart -->
            <div class="ecom-bottom-grid">
                <div class="panel ecom-panel">
                    <div class="panel-header">
                        <h2 class="panel-title">RECENT ORDERS</h2>
                        <button class="panel-more-btn"><i class="fas fa-ellipsis-h"></i></button>
                    </div>
                    <table class="ecom-orders-table">
                        <thead><tr><th>From</th><th>Price</th><th>Status</th></tr></thead>
                        <tbody>
                            <tr>
                                <td class="order-customer"><img src="https://ui-avatars.com/api/?name=Maxima+Smalls&size=32&background=F04438&color=fff" class="order-avatar" alt=""><div><div class="order-name">Maxima Smalls</div><div class="order-time">4 minutes ago</div></div></td>
                                <td class="order-price">$35.22</td><td><span class="order-status status-progress">⬤ In progress</span></td>
                            </tr>
                            <tr>
                                <td class="order-customer"><img src="https://ui-avatars.com/api/?name=Andrew+Robocop&size=32&background=F0950C&color=fff" class="order-avatar" alt=""><div><div class="order-name">Andrew Robocop</div><div class="order-time">12 minutes ago</div></div></td>
                                <td class="order-price">$23.75</td><td><span class="order-status status-progress">⬤ In progress</span></td>
                            </tr>
                            <tr>
                                <td class="order-customer"><img src="https://ui-avatars.com/api/?name=Miru+Xander&size=32&background=319DFF&color=fff" class="order-avatar" alt=""><div><div class="order-name">Miru Xander</div><div class="order-time">1 day ago</div></div></td>
                                <td class="order-price">$18.76</td><td><span class="order-status status-onway">⬤ On the way</span></td>
                            </tr>
                            <tr>
                                <td class="order-customer"><img src="https://ui-avatars.com/api/?name=Lau+Baker&size=32&background=10B981&color=fff" class="order-avatar" alt=""><div><div class="order-name">Lau Baker</div><div class="order-time">1 day ago</div></div></td>
                                <td class="order-price">$32.00</td><td><span class="order-status status-delivered">⬤ Delivered</span></td>
                            </tr>
                            <tr>
                                <td class="order-customer"><img src="https://ui-avatars.com/api/?name=Ragnar+Walls&size=32&background=8B5CF6&color=fff" class="order-avatar" alt=""><div><div class="order-name">Ragnar Walls</div><div class="order-time">1 day ago</div></div></td>
                                <td class="order-price">$55.40</td><td><span class="order-status status-cancelled">⬤ Cancelled</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="panel ecom-panel">
                    <div class="panel-header">
                        <h2 class="panel-title">SALES</h2>
                        <div class="sales-legend">
                            <span class="legend-dot" style="background:#8B5CF6;"></span> Actual
                            <span class="legend-dot" style="background:#CBD5E1;margin-left:12px;"></span> Projections
                        </div>
                    </div>
                    <div class="chart-container"><canvas id="salesChart"></canvas></div>
                </div>
            </div>

            <!-- TOP SELLING -->
            <div class="panel ecom-panel" style="margin-top:20px;">
                <div class="panel-header">
                    <h2 class="panel-title">TOP SELLING</h2>
                    <button class="panel-more-btn"><i class="fas fa-ellipsis-h"></i></button>
                </div>
                <table class="top-selling-table">
                    <thead><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Amount</th><th>Sales</th></tr></thead>
                    <tbody>
                        <tr><td class="product-cell"><img src="https://placehold.co/32x32/333/fff?text=S" class="product-img" alt="">Black-Frame Sunglasses</td><td>$39.00</td><td>705</td><td>$27,500.70</td><td><div class="sell-bar-wrap"><div class="sell-bar" style="width:55%;background:#10B981;"></div><span>55%</span></div></td></tr>
                        <tr><td class="product-cell"><img src="https://placehold.co/32x32/222/fff?text=W" class="product-img" alt="">Black Leather Wallet</td><td>$43.26</td><td>208</td><td>$9,000.16</td><td><div class="sell-bar-wrap"><div class="sell-bar" style="width:18%;background:#10B981;"></div><span>18%</span></div></td></tr>
                        <tr><td class="product-cell"><img src="https://placehold.co/32x32/444/fff?text=B" class="product-img" alt="">Snake Hand Bracelet</td><td>$20.30</td><td>197</td><td>$4,008.99</td><td><div class="sell-bar-wrap"><div class="sell-bar" style="width:8%;background:#10B981;"></div><span>8%</span></div></td></tr>
                        <tr><td class="product-cell"><img src="https://placehold.co/32x32/FFAA04/fff?text=C" class="product-img" alt="">Yellow Cotton Cap</td><td>$18.75</td><td>80</td><td>$1,500.50</td><td><div class="sell-bar-wrap"><div class="sell-bar" style="width:3%;background:#319DFF;"></div><span>3%</span></div></td></tr>
                        <tr><td class="product-cell"><img src="https://placehold.co/32x32/F04438/fff?text=H" class="product-img" alt="">Yellow Hoodie</td><td>$25.86</td><td>178</td><td>$1,498.70</td><td><div class="sell-bar-wrap"><div class="sell-bar" style="width:3%;background:#319DFF;"></div><span>3%</span></div></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // switchTab — hỗ trợ submenu-tab mới
        function switchTab(tabId, clickedEl) {
            document.querySelectorAll('.dash-section').forEach(s => s.classList.remove('active'));
            var section = document.getElementById(tabId);
            if (section) section.classList.add('active');

            document.querySelectorAll('.submenu-tab').forEach(function(t) {
                t.classList.remove('submenu-tab--active');
            });
            if (clickedEl) clickedEl.classList.add('submenu-tab--active');
        }

        // Initialize Revenue Chart (Analytics)
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Th 2', 'Th 3', 'Th 4', 'Th 5', 'Th 6', 'Th 7', 'CN'],
                datasets: [{
                    label: 'Doanh thu',
                    data: [12, 19, 15, 25, 22, 30, 28],
                    borderColor: '#3C50E0',
                    backgroundColor: 'rgba(60, 80, 224, 0.1)',
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Chi phí',
                    data: [8, 12, 10, 15, 18, 20, 15],
                    borderColor: '#80CAEE',
                    backgroundColor: 'transparent',
                    borderDash: [5, 5],
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { usePointStyle: true, boxWidth: 6 }
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Initialize Sales Chart (E-Commerce)
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        if (salesCtx) {
            new Chart(salesCtx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
                    datasets: [{
                        label: 'Actual',
                        data: [3, 3, 4.2, 2, 3, 2, 4.5, 1, 3.2, 4, 3],
                        backgroundColor: '#8B5CF6',
                        borderRadius: 4,
                        barThickness: 12,
                    }, {
                        label: 'Projections',
                        data: [5, 5.5, 6, 4.5, 6.2, 4, 5.8, 3.5, 4.5, 5, 4.8],
                        backgroundColor: '#CBD5E1',
                        borderRadius: 4,
                        barThickness: 12,
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
                            ticks: { callback: value => '$' + value + 'k' },
                            grid: { borderDash: [5, 5], drawBorder: false }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    </script>
@endsection
