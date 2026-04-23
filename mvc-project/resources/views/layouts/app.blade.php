<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - TINY FLOWERS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/new-sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/new-topbar.css') }}">
    @yield('styles')
</head>
<body class="dashboard-body">

    <!-- Sidebar -->
    <aside class="menu-left-side" aria-label="Primary sidebar navigation">
        <div class="logo">
            <div class="logo-icon-wrap">
                <i class="fas fa-seedling"></i>
            </div>
            <span class="logo-text">TINY FLOWERS</span>
        </div>

        <nav class="nav-frame" aria-label="Main navigation">
            <div class="menu-item-wrap">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'menu-btn-active' : 'menu-btn' }}" id="nav-dashboards">
                    <span class="nav-icon"><i class="fas fa-th-large"></i></span>
                    <span class="nav-label">Dashboards</span>
                </a>
            </div>

            <div class="menu-item-wrap">
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'menu-btn-active' : 'menu-btn' }}" id="nav-products">
                    <span class="nav-icon"><i class="fas fa-box-open"></i></span>
                    <span class="nav-label">Sản phẩm</span>
                </a>
            </div>

            <div class="menu-item-wrap">
                <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'menu-btn-active' : 'menu-btn' }}" id="nav-categories">
                    <span class="nav-icon"><i class="fas fa-tags"></i></span>
                    <span class="nav-label">Danh mục</span>
                </a>
            </div>

            <div class="menu-item-wrap">
                <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'menu-btn-active' : 'menu-btn' }}" id="nav-orders">
                    <span class="nav-icon"><i class="fas fa-shopping-cart"></i></span>
                    <span class="nav-label">Đơn hàng</span>
                </a>
            </div>

            <div class="menu-item-wrap">
                <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'menu-btn-active' : 'menu-btn' }}" id="nav-customers">
                    <span class="nav-icon"><i class="fas fa-users"></i></span>
                    <span class="nav-label">Khách hàng</span>
                </a>
            </div>

            <div class="menu-item-wrap">
                <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'menu-btn-active' : 'menu-btn' }}" id="nav-reports">
                    <span class="nav-icon"><i class="fas fa-chart-line"></i></span>
                    <span class="nav-label">Báo cáo</span>
                </a>
            </div>

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
                <form class="inputs" role="search" action="#" method="get">
                    <span class="search-icon"><i class="fas fa-search"></i></span>
                    <input id="top-bar-search" class="type-something" type="search" name="search"
                           placeholder="Tìm kiếm ở đây..." aria-label="Tìm kiếm" />
                </form>
            </div>

            <nav class="div" aria-label="Hành động thanh trên">
                <button class="select-language" type="button">
                    <span class="frame-2">
                        <span class="flag-icon">🇻🇳</span>
                        <span class="text-wrapper">Tiếng Việt</span>
                    </span>
                    <i class="fas fa-chevron-down chevron-icon"></i>
                </button>

                <span class="nav-divider"></span>

                <button class="switch" type="button" role="switch">
                    <span class="ellipse">
                        <i class="fas fa-sun switch-sun-icon"></i>
                    </span>
                    <i class="fas fa-moon switch-moon-icon"></i>
                </button>

                <button class="top-bar-items" type="button" id="topbar-apps">
                    <i class="fas fa-th"></i>
                </button>

                <button class="top-bar-items-2" type="button" id="topbar-notif">
                    <i class="fas fa-bell"></i>
                    <span class="ellipse-2"></span>
                </button>

                <button class="top-bar-items" type="button" id="topbar-settings">
                    <i class="fas fa-cog"></i>
                </button>

                <button class="user-pic" type="button" id="topbar-user">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(session('user.name', 'Admin')) }}&background=319DFF&color=fff" alt="Avatar" />
                </button>
            </nav>
        </header>

        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>
