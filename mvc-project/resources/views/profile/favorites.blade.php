<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm yêu thích - Tiny Flowers</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
        }
        .main-header {
            background: #0f172a;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .profile-layout {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 30px;
        }
        .profile-sidebar {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            height: fit-content;
        }
        .user-summary {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #f1f5f9;
            margin-bottom: 20px;
        }
        .user-summary img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #f8fafc;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-bottom: 15px;
        }
        .user-summary h3 {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }
        .user-summary p {
            font-size: 14px;
            color: #64748b;
        }
        .nav-sidebar {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            color: #475569;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }
        .nav-item:hover, .nav-item.active {
            background: #f1f5f9;
            color: #0f172a;
        }
        .nav-item.active {
            background: #eff6ff;
            color: #2563eb;
        }
        .nav-item i {
            width: 20px;
            text-align: center;
            font-size: 18px;
        }
        .profile-content {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }
        .content-header {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f1f5f9;
        }
        .content-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }
        .content-header p {
            color: #64748b;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            color: #1e293b;
            transition: all 0.2s;
            font-family: inherit;
        }
        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .form-control:disabled {
            background: #f8fafc;
            color: #94a3b8;
            cursor: not-allowed;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .btn-primary {
            background: #0f172a;
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }
        .btn-primary:hover {
            background: #1e293b;
            transform: translateY(-1px);
        }
        .avatar-upload-box {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }
        .avatar-upload-btn {
            background: white;
            border: 1px solid #e2e8f0;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s;
        }
        .avatar-upload-btn:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }
        .avatar-preview {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }
        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            padding: 16px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            border: 1px solid #a7f3d0;
        }
        @media (max-width: 768px) {
            .profile-layout {
                grid-template-columns: 1fr;
            }
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    

    .profile-container {
        max-width: 1200px;
        margin: 40px auto 80px;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 40px;
    }

    .profile-sidebar {
        background: white;
        border-radius: 16px;
        padding: 30px 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        height: fit-content;
    }

    .user-info {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f1f5f9;
    }

    .user-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 4px solid #f8fafc;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .user-name {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 5px;
    }

    .user-email {
        font-size: 14px;
        color: #64748b;
    }

    .profile-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .profile-menu li {
        margin-bottom: 5px;
    }

    .profile-menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        color: #475569;
        text-decoration: none;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .profile-menu a:hover, .profile-menu a.active {
        background: #f1f5f9;
        color: #0f172a;
    }

    .profile-menu a.active {
        background: #0f172a;
        color: white;
    }

    .profile-content {
        background: white;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }

    .content-title {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f5f9;
    }

    .favorites-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .product-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .product-info {
        padding: 20px;
    }

    .product-name {
        font-size: 16px;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 8px;
        text-decoration: none;
        display: block;
    }

    .product-name:hover {
        color: #3b82f6;
    }

    .product-price {
        font-size: 16px;
        font-weight: 700;
        color: #ef4444;
    }

    .btn-remove {
        position: absolute;
        top: 10px;
        right: 10px;
        background: white;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: 0.2s;
    }

    .btn-remove:hover {
        background: #ef4444;
        color: white;
    }

    @media (max-width: 992px) {
        .profile-container { grid-template-columns: 1fr; }
        .favorites-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .favorites-grid { grid-template-columns: 1fr; }
    }


    </style>
</head>
<body>
    <header class="main-header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo-area">
                <div class="logo-circle">TF</div>
                <span class="brand-name">Tiny Flowers</span>
            </a>

            <nav class="main-nav">
                <a href="{{ route('shop', ['category' => 'Sale']) }}" class="nav-link sale">SALE</a>
                @foreach($globalCategories as $gCat)
                    @if($gCat->children->count() > 0)
                        <div class="nav-item-dropdown" style="position: relative; display: inline-block;">
                            <a href="{{ route('shop', ['category' => $gCat->name]) }}" class="nav-link">{{ $gCat->name }}</a>
                            <div class="nav-dropdown-content" style="display: none; position: absolute; top: 100%; left: 0; background: white; min-width: 150px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); border-radius: 8px; padding: 10px 0; z-index: 1000;">
                                @foreach($gCat->children as $child)
                                    <a href="{{ route('shop', ['category' => $child->name]) }}" style="display: block; padding: 8px 20px; color: #334155; text-decoration: none; font-size: 14px; transition: background 0.2s;">{{ $child->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ route('shop', ['category' => $gCat->name]) }}" class="nav-link">{{ $gCat->name }}</a>
                    @endif
                @endforeach
            </nav>
            <style>
                .nav-item-dropdown::after { content: ''; position: absolute; top: 100%; left: 0; right: 0; height: 15px; background: transparent; }
                .nav-item-dropdown:hover .nav-dropdown-content { display: block !important; animation: fadeIn 0.2s ease-in-out; }
                .nav-dropdown-content a:hover { background: #f1f5f9; color: #0f172a !important; }
            

    .profile-container {
        max-width: 1200px;
        margin: 40px auto 80px;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 40px;
    }

    .profile-sidebar {
        background: white;
        border-radius: 16px;
        padding: 30px 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        height: fit-content;
    }

    .user-info {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f1f5f9;
    }

    .user-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 4px solid #f8fafc;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .user-name {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 5px;
    }

    .user-email {
        font-size: 14px;
        color: #64748b;
    }

    .profile-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .profile-menu li {
        margin-bottom: 5px;
    }

    .profile-menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        color: #475569;
        text-decoration: none;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .profile-menu a:hover, .profile-menu a.active {
        background: #f1f5f9;
        color: #0f172a;
    }

    .profile-menu a.active {
        background: #0f172a;
        color: white;
    }

    .profile-content {
        background: white;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }

    .content-title {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f5f9;
    }

    .favorites-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .product-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .product-info {
        padding: 20px;
    }

    .product-name {
        font-size: 16px;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 8px;
        text-decoration: none;
        display: block;
    }

    .product-name:hover {
        color: #3b82f6;
    }

    .product-price {
        font-size: 16px;
        font-weight: 700;
        color: #ef4444;
    }

    .btn-remove {
        position: absolute;
        top: 10px;
        right: 10px;
        background: white;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: 0.2s;
    }

    .btn-remove:hover {
        background: #ef4444;
        color: white;
    }

    @media (max-width: 992px) {
        .profile-container { grid-template-columns: 1fr; }
        .favorites-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .favorites-grid { grid-template-columns: 1fr; }
    }


    </style>

            <div class="header-actions">
                <div class="search-bar">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" placeholder="Tìm sản phẩm..." class="search-input">
                </div>
                <div class="auth-group">
                    @auth
                        @php
                            $user = Auth::user();
                            $avatarUrl = $user->profile_picture 
                                ? asset('images/avatars/' . $user->profile_picture) 
                                : 'https://ui-avatars.com/api/?name=' . urlencode($user->fullname) . '&background=000&color=fff';
                            $firstNameParts = explode(' ', trim($user->fullname));
                            $firstName = end($firstNameParts);
                        @endphp
                        <div class="user-profile-dropdown" style="position: relative; display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 5px; border-radius: 20px; transition: background 0.3s;">
                            <img src="{{ $avatarUrl }}" alt="{{ $user->fullname }}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid #e2e8f0;">
                            <span style="font-weight: 600; font-size: 14px; color: white;">{{ $firstName }}</span>
                            <i class="fas fa-chevron-down" style="font-size: 10px; color: #94a3b8; margin-left: 2px;"></i>
                            
                            <div class="dropdown-content" style="display: none; position: absolute; top: 100%; right: 0; background: white; min-width: 220px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); border-radius: 12px; padding: 12px; z-index: 1000; margin-top: 15px; border: 1px solid #f1f5f9;">
                                <div style="padding: 8px 12px; border-bottom: 1px solid #f1f5f9; margin-bottom: 8px;">
                                    <div style="font-weight: 600; font-size: 14px; color: #0f172a;">{{ $user->fullname }}</div>
                                    <div style="font-size: 12px; color: #64748b; margin-top: 2px;">{{ $user->email }}</div>
                                </div>
                                <a href="{{ route('profile.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #334155; text-decoration: none; font-size: 14px; border-radius: 8px; transition: all 0.2s;"><i class="far fa-user" style="width: 20px; text-align: center; color: #64748b;"></i> Hồ sơ</a>
                                <a href="{{ route('profile.orders') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #334155; text-decoration: none; font-size: 14px; border-radius: 8px; transition: all 0.2s;"><i class="fas fa-shopping-bag" style="width: 20px; text-align: center; color: #64748b;"></i> Đơn hàng</a>
                                <a href="{{ route('profile.favorites') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #334155; text-decoration: none; font-size: 14px; border-radius: 8px; transition: all 0.2s;"><i class="fas fa-heart" style="width: 20px; text-align: center; color: #ef4444;"></i> Yêu thích</a>
                                <a href="{{ route('logout') }}" style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; color: #ef4444; text-decoration: none; font-size: 14px; border-radius: 8px; transition: all 0.2s; margin-top: 5px; border-top: 1px solid #f1f5f9; padding-top: 12px;"><i class="fas fa-sign-out-alt" style="width: 20px; text-align: center;"></i> Đăng xuất</a>
                            </div>
                        </div>
                        <style>
                            .user-profile-dropdown::after {
                                content: '';
                                position: absolute;
                                top: 100%;
                                left: 0;
                                right: 0;
                                height: 20px;
                                background: transparent;
                            }
                            .user-profile-dropdown:hover .dropdown-content {
                                display: block !important;
                                animation: fadeIn 0.2s ease-in-out;
                            }
                            .dropdown-content a:hover {
                                background: #f1f5f9;
                                color: #0f172a !important;
                            }
                        

    .profile-container {
        max-width: 1200px;
        margin: 40px auto 80px;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 40px;
    }

    .profile-sidebar {
        background: white;
        border-radius: 16px;
        padding: 30px 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        height: fit-content;
    }

    .user-info {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f1f5f9;
    }

    .user-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 4px solid #f8fafc;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .user-name {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 5px;
    }

    .user-email {
        font-size: 14px;
        color: #64748b;
    }

    .profile-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .profile-menu li {
        margin-bottom: 5px;
    }

    .profile-menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        color: #475569;
        text-decoration: none;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .profile-menu a:hover, .profile-menu a.active {
        background: #f1f5f9;
        color: #0f172a;
    }

    .profile-menu a.active {
        background: #0f172a;
        color: white;
    }

    .profile-content {
        background: white;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }

    .content-title {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f5f9;
    }

    .favorites-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .product-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .product-info {
        padding: 20px;
    }

    .product-name {
        font-size: 16px;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 8px;
        text-decoration: none;
        display: block;
    }

    .product-name:hover {
        color: #3b82f6;
    }

    .product-price {
        font-size: 16px;
        font-weight: 700;
        color: #ef4444;
    }

    .btn-remove {
        position: absolute;
        top: 10px;
        right: 10px;
        background: white;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: 0.2s;
    }

    .btn-remove:hover {
        background: #ef4444;
        color: white;
    }

    @media (max-width: 992px) {
        .profile-container { grid-template-columns: 1fr; }
        .favorites-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 576px) {
        .favorites-grid { grid-template-columns: 1fr; }
    }


    </style>
                    @else
                        <a href="{{ route('login') }}" class="auth-link">
                            <i class="far fa-user"></i>
                            <span>ĐĂNG NHẬP</span>
                        </a>
                    @endauth
                </div>
                <div class="cart-wrapper">
                    <button class="cart-btn">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="cart-label">GIỎ HÀNG</span>
                        <span class="badge-count">0</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main class="profile-layout">
        <aside class="profile-sidebar">
            <div class="user-summary">
                @php
                    $avatarUrl = $user->profile_picture 
                        ? asset('images/avatars/' . $user->profile_picture) 
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->fullname) . '&background=000&color=fff';
                @endphp
                <img src="{{ $avatarUrl }}" alt="{{ $user->fullname }}">
                <h3>{{ $user->fullname }}</h3>
                <p>Khách hàng thân thiết</p>
            </div>
            
            <nav class="nav-sidebar">
                <a href="{{ route('profile.index') }}" class="nav-item">
                    <i class="far fa-user-circle"></i> Hồ sơ của tôi
                </a>
                <a href="{{ route('profile.password') }}" class="nav-item">
                    <i class="fas fa-shield-alt"></i> Đổi mật khẩu
                </a>
                <a href="{{ route('profile.orders') }}" class="nav-item">
                    <i class="fas fa-shopping-bag"></i> Đơn hàng mua
                </a>
                <a href="{{ route('profile.favorites') }}" class="nav-item active">
                    <i class="far fa-heart"></i> Sản phẩm yêu thích
                </a>
                <a href="{{ route('profile.address') }}" class="nav-item">
                    <i class="fas fa-map-marker-alt"></i> Sổ địa chỉ
                </a>
                <a href="{{ route('logout') }}" class="nav-item" style="color: #ef4444; margin-top: 10px;">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </a>
            </nav>
        </aside>

        
<section class="profile-content">
        <h2 class="content-title">Sản phẩm yêu thích</h2>

        @if($favorites->count() > 0)
            <div class="favorites-grid">
                @foreach($favorites as $favorite)
                    @if($favorite->product)
                        <div class="product-card" id="favorite-{{ $favorite->product_id }}">
                            <img src="{{ $favorite->product->image_url }}" alt="{{ $favorite->product->name }}" class="product-image">
                            <div style="position: absolute; top: 10px; left: 10px; background: white; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); color: #ef4444; z-index: 10;">
                                <i class="fas fa-heart"></i>
                            </div>
                            <button class="btn-remove" onclick="toggleFavorite({{ $favorite->product_id }})" title="Xóa khỏi danh sách">
                                <i class="fas fa-trash"></i>
                            </button>
                            <div class="product-info">
                                <a href="{{ route('shop.show', $favorite->product_id) }}" class="product-name">{{ $favorite->product->name }}</a>
                                <div class="product-price">{{ number_format($favorite->product->selling_price, 0, ',', '.') }}đ</div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 60px 0;">
                <div style="font-size: 60px; color: #cbd5e1; margin-bottom: 20px;">
                    <i class="far fa-heart"></i>
                </div>
                <h3 style="font-size: 20px; font-weight: 600; color: #0f172a; margin-bottom: 10px;">Chưa có sản phẩm yêu thích</h3>
                <p style="color: #64748b; margin-bottom: 30px;">Lưu lại những sản phẩm bạn quan tâm để dễ dàng tìm lại nhé.</p>
                <a href="{{ route('shop') }}" style="display: inline-block; background: #0f172a; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s;">Khám phá ngay</a>
            </div>
        @endif
    </section>
</section>
    </main>

    <footer class="main-footer" style="background: #0f172a; padding: 40px 0;">
        <div class="footer-grid" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div class="footer-col" style="text-align: center; color: white;">
                <p>&copy; 2026 Tiny Flowers. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('avatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

<script>
    function toggleFavorite(productId) {
        if(!confirm('Bạn có chắc muốn xóa sản phẩm này khỏi danh sách yêu thích?')) return;

        fetch(`{{ url('favorites') }}/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                const card = document.getElementById(`favorite-${productId}`);
                if(card) {
                    card.style.opacity = '0';
                    setTimeout(() => {
                        card.remove();
                        // Reload if empty
                        if(document.querySelectorAll('.product-card').length === 0) {
                            location.reload();
                        }
                    }, 300);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra!');
        });
    }
</script>

</body>
</html>
