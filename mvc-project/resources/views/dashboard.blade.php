<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TINY FLOWERS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="dashboard-body">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <svg width="32" height="32" viewBox="0 0 40 40" fill="none">
                <path d="M20 0C8.954 0 0 8.954 0 20s8.954 20 20 20 20-8.954 20-20S31.046 0 20 0z" fill="#3C50E0"/>
                <path d="M20 10L28 25H12L20 10z" fill="white"/>
            </svg>
            <span class="sidebar-logo-text">TINY FLOWERS</span>
        </div>

        <div class="sidebar-menu">
            <div class="menu-label">Menu Chính</div>
            <a href="#" class="menu-item active">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-box"></i> Sản phẩm
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-shopping-cart"></i> Đơn hàng
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-users"></i> Khách hàng
            </a>

            <div class="menu-label">Hệ Thống</div>
            <a href="#" class="menu-item">
                <i class="fas fa-cog"></i> Cài đặt
            </a>
            <a href="{{ route('logout') }}" class="menu-item">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Tìm kiếm...">
            </div>
            <div class="user-nav">
                <div class="user-profile">
                    <div style="text-align: right">
                        <div style="font-weight: 700; font-size: 14px">{{ session('user.name', 'Admin User') }}</div>
                        <div style="font-size: 12px; color: var(--text-secondary)">Quản trị viên</div>
                    </div>
                    <div class="user-avatar">
                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=3C50E0&color=fff" style="width: 100%; border-radius: 50%" alt="">
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px">
                <div>
                    <h1 style="margin: 0; font-size: 28px">Chào mừng trở lại!</h1>
                    <p style="color: var(--text-secondary); margin: 5px 0 0 0">Đây là cái nhìn tổng quan về tình hình kinh doanh thời trang nam hôm nay.</p>
                </div>

                <div class="dash-tabs">
                    <div class="dash-tab active" onclick="switchTab('analytics', this)">Analytics</div>
                    <div class="dash-tab" onclick="switchTab('ecommerce', this)">E-commerce</div>
                </div>
            </div>

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

            <!-- E-commerce Section -->
            <div id="ecommerce" class="dash-section">
                <!-- (Keep original e-commerce content but with minor style fixes) -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-label">Doanh thu hôm nay</div>
                        <div class="stat-value">₫ 1,250,000</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Đơn hàng mới</div>
                        <div class="stat-value">24</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Giá trị trung bình</div>
                        <div class="stat-value">₫ 520,000</div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-header">
                        <h2 class="panel-title">Đơn hàng gần đây</h2>
                    </div>
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#TF1001</td>
                                <td>Nguyễn Văn A</td>
                                <td>22/04/2026</td>
                                <td>₫ 1,500,000</td>
                                <td><span style="color: #10B981; font-weight: 600">Hoàn thành</span></td>
                            </tr>
                            <tr>
                                <td>#TF1002</td>
                                <td>Trần Thị B</td>
                                <td>22/04/2026</td>
                                <td>₫ 850,000</td>
                                <td><span style="color: #F0950C; font-weight: 600">Đang chờ</span></td>
                            </tr>
                            <tr>
                                <td>#TF1003</td>
                                <td>Lê Văn C</td>
                                <td>21/04/2026</td>
                                <td>₫ 2,100,000</td>
                                <td><span style="color: #10B981; font-weight: 600">Hoàn thành</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabId, el) {
            document.querySelectorAll('.dash-tab').forEach(tab => tab.classList.remove('active'));
            el.classList.add('active');
            document.querySelectorAll('.dash-section').forEach(section => section.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
        }

        // Initialize Revenue Chart
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
    </script>
</body>
</html>
