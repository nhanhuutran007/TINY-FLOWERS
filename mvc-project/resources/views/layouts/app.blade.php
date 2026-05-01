<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - TINY FLOWERS</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/new-sidebar.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/new-topbar.css') }}?v={{ time() }}">
    @yield('styles')
</head>

<body class="dashboard-body">

    <!-- Sidebar -->
    <aside class="menu-left-side" aria-label="Primary sidebar navigation">
        <div class="logo">
            <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #FF7EB3, #7AF5FF); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; color: white; font-size: 14px; margin-right: 10px; flex-shrink: 0; box-shadow: 0 2px 5px rgba(255,126,179,0.3);">TF</div>
            <span class="logo-text">TINY FLOWERS</span>
        </div>

        <nav class="nav-frame" aria-label="Main navigation">
            <div class="menu-item-wrap">
                <a href="{{ route('dashboard') }}"
                    class="{{ request()->routeIs('dashboard') ? 'menu-btn-active' : 'menu-btn' }}" id="nav-dashboards">
                    <span class="nav-icon"><i class="fas fa-th-large"></i></span>
                    <span class="nav-label">Dashboards</span>
                </a>
            </div>

            <div class="menu-item-wrap">
                <a href="{{ route('products.index') }}"
                    class="{{ request()->routeIs('products.*') ? 'menu-btn-active' : 'menu-btn' }}" id="nav-products">
                    <span class="nav-icon"><i class="fas fa-box-open"></i></span>
                    <span class="nav-label">Sản phẩm</span>
                </a>
            </div>

            <div class="menu-item-wrap">
                <a href="{{ route('categories.index') }}"
                    class="{{ request()->routeIs('categories.*') ? 'menu-btn-active' : 'menu-btn' }}"
                    id="nav-categories">
                    <span class="nav-icon"><i class="fas fa-tags"></i></span>
                    <span class="nav-label">Danh mục</span>
                </a>
            </div>

            <div class="menu-item-wrap">
                <a href="{{ route('orders.index') }}"
                    class="{{ request()->routeIs('orders.*') ? 'menu-btn-active' : 'menu-btn' }}" id="nav-orders">
                    <span class="nav-icon"><i class="fas fa-shopping-cart"></i></span>
                    <span class="nav-label">Đơn hàng</span>
                </a>
            </div>

            <div class="menu-item-wrap">
                <a href="{{ route('customers.index') }}"
                    class="{{ request()->routeIs('customers.*') ? 'menu-btn-active' : 'menu-btn' }}" id="nav-customers">
                    <span class="nav-icon"><i class="fas fa-users"></i></span>
                    <span class="nav-label">Khách hàng</span>
                </a>
            </div>

            <div class="menu-item-wrap">
                <a href="{{ route('reports.index') }}"
                    class="{{ request()->routeIs('reports.*') ? 'menu-btn-active' : 'menu-btn' }}" id="nav-reports">
                    <span class="nav-icon"><i class="fas fa-chart-line"></i></span>
                    <span class="nav-label">Báo cáo</span>
                </a>
            </div>

            @if(Auth::user()->role !== 'admin')
            <div class="menu-item-wrap">
                <a href="{{ route('profile.orders') }}"
                    class="{{ request()->routeIs('profile.orders') ? 'menu-btn-active' : 'menu-btn' }}" id="nav-my-orders">
                    <span class="nav-icon"><i class="fas fa-history"></i></span>
                    <span class="nav-label">Lịch sử đơn hàng</span>
                </a>
            </div>
            @endif

            <div class="menu-item-wrap">
                <a href="{{ route('logout') }}" class="menu-btn" id="nav-logout">
                    <span class="nav-icon"><i class="fas fa-sign-out-alt"></i></span>
                    <span class="nav-label">Đăng xuất</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <header class="top-bar" role="banner">
            <div class="frame">
                <button class="top-bar-items" type="button" aria-label="Mở menu điều hướng" id="topbar-menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="position-relative" style="flex: 1; max-width: 400px;">
                    <form class="inputs" role="search" onsubmit="return false;">
                        <span class="search-icon"><i class="fas fa-search"></i></span>
                        <input id="top-bar-search" class="type-something" type="search" name="search"
                            placeholder="Tìm kiếm chức năng..." aria-label="Tìm kiếm" autocomplete="off" />
                    </form>
                    <!-- Search Suggestions -->
                    <div id="search-suggestions" class="search-suggestions-dropdown d-none">
                    </div>
                </div>
            </div>

            <nav class="div" aria-label="Hành động thanh trên">
                <div class="position-relative">
                    <button class="top-bar-items-2" type="button" id="topbar-notif">
                        <i class="fas fa-bell"></i>
                        <span id="notif-badge" class="ellipse-2 d-none"></span>
                    </button>
                    <!-- Notification Panel -->
                    <div id="notif-panel" class="notif-panel d-none">
                        <div class="notif-header">
                            <span><i class="fas fa-warehouse"></i> Cảnh báo tồn kho</span>
                            <span id="notif-summary" class="notif-summary-badge"></span>
                        </div>
                        <div id="notif-list" class="notif-list">
                            <div class="notif-loading"><i class="fas fa-spinner fa-spin"></i> Đang kiểm tra...</div>
                        </div>
                        <div class="notif-footer">
                            <a href="{{ route('products.index') }}">Xem toàn bộ sản phẩm →</a>
                        </div>
                    </div>
                </div>

                <button class="top-bar-items" type="button" id="topbar-settings">
                    <i class="fas fa-cog"></i>
                </button>

                <div class="position-relative">
                    <button class="user-pic" type="button" id="topbar-user-btn">
                        @php
                            $user = Auth::user();
                            $avatarUrl = $user && $user->profile_picture
                                ? asset('images/avatars/' . $user->profile_picture)
                                : 'https://ui-avatars.com/api/?name=' . urlencode($user->fullname ?? 'User') . '&background=319DFF&color=fff';
                        @endphp
                        <img src="{{ $avatarUrl }}" alt="Avatar" />
                    </button>
                    <!-- User Dropdown -->
                    <div id="user-dropdown" class="user-dropdown-menu d-none">
                        <div class="user-info-header">
                            <span class="user-name">{{ Auth::user()->fullname }}</span>
                            <span class="user-role">{{ ucfirst(Auth::user()->role) }}</span>
                        </div>
                        <hr>
                        <a href="{{ route('profile.index') }}"><i class="fas fa-user-circle"></i> Hồ sơ của tôi</a>
                        @if(Auth::user()->role !== 'admin')
                        <a href="{{ route('profile.orders') }}"><i class="fas fa-history"></i> Lịch sử đơn hàng</a>
                        @endif
                        <a href="{{ route('profile.password') }}"><i class="fas fa-key"></i> Đổi mật khẩu</a>
                        <hr>
                        <a href="{{ route('logout') }}" class="logout-link"><i class="fas fa-sign-out-alt"></i> Đăng
                            xuất</a>
                    </div>
                </div>
            </nav>
        </header>

        @yield('content')
    </div>

    @yield('scripts')
    <script>
        window.ADMIN_FEATURES = [
            { title: 'Tổng quan Dashboard', route: '{{ route("dashboard") }}', icon: 'fa-th-large' },
            { title: 'Quản lý Sản phẩm', route: '{{ route("products.index") }}', icon: 'fa-box-open' },
            { title: 'Danh mục Sản phẩm', route: '{{ route("categories.index") }}', icon: 'fa-tags' },
            { title: 'Quản lý Đơn hàng', route: '{{ route("orders.index") }}', icon: 'fa-shopping-cart' },
            { title: 'Quản lý Khách hàng', route: '{{ route("customers.index") }}', icon: 'fa-users' },
            { title: 'Báo cáo Doanh thu', route: '{{ route("reports.index") }}', icon: 'fa-chart-line' },
            { title: 'Hồ sơ cá nhân', route: '{{ route("profile.index") }}', icon: 'fa-user-circle' },
            { title: 'Đổi mật khẩu', route: '{{ route("profile.password") }}', icon: 'fa-key' },
            { title: 'Cài đặt hệ thống', route: '#', icon: 'fa-cog' },
        ];
    </script>
    <script src="{{ asset('js/admin-dashboard.js') }}"></script>
</body>

</html>