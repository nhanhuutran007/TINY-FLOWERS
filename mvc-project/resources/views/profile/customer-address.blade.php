<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sổ địa chỉ - Tiny Flowers</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; }
        .main-header { background: #0f172a; position: sticky; top: 0; z-index: 50; }
        .profile-layout { max-width: 1200px; margin: 40px auto; padding: 0 20px; display: grid; grid-template-columns: 280px 1fr; gap: 30px; }
        .profile-sidebar { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); height: fit-content; }
        .user-summary { text-align: center; padding-bottom: 20px; border-bottom: 1px solid #f1f5f9; margin-bottom: 20px; }
        .user-summary img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 4px solid #f8fafc; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-bottom: 15px; }
        .user-summary h3 { font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 5px; }
        .user-summary p { font-size: 14px; color: #64748b; }
        .nav-sidebar { display: flex; flex-direction: column; gap: 8px; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 10px; color: #475569; text-decoration: none; font-weight: 500; transition: all 0.2s; }
        .nav-item:hover, .nav-item.active { background: #f1f5f9; color: #0f172a; }
        .nav-item.active { background: #eff6ff; color: #2563eb; }
        .nav-item i { width: 20px; text-align: center; font-size: 18px; }
        .profile-content { background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .content-header { margin-bottom: 30px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9; }
        .content-header h2 { font-size: 24px; font-weight: 700; color: #1e293b; margin-bottom: 5px; }
        .content-header p { color: #64748b; font-size: 14px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; color: #475569; margin-bottom: 8px; font-size: 14px; }
        .form-control { width: 100%; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 15px; color: #1e293b; transition: all 0.2s; font-family: inherit; }
        .form-control:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        .btn-primary { background: #0f172a; color: white; border: none; padding: 14px 28px; border-radius: 10px; font-weight: 600; font-size: 15px; cursor: pointer; transition: all 0.2s; font-family: inherit; display: inline-block; }
        .btn-primary:hover { background: #1e293b; transform: translateY(-1px); }
        .alert-success { background: #ecfdf5; color: #065f46; padding: 16px; border-radius: 10px; margin-bottom: 25px; display: flex; align-items: center; gap: 12px; font-weight: 500; border: 1px solid #a7f3d0; }
        .alert-error { background: #fef2f2; color: #b91c1c; padding: 16px; border-radius: 10px; margin-bottom: 25px; display: flex; align-items: center; gap: 12px; font-weight: 500; border: 1px solid #fecaca; }
        
        .user-profile-dropdown::after { content: ''; position: absolute; top: 100%; left: 0; right: 0; height: 20px; background: transparent; }
        .user-profile-dropdown:hover .dropdown-content { display: block !important; animation: fadeIn 0.2s ease-in-out; }
        .dropdown-content a:hover { background: #f1f5f9; color: #0f172a !important; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        @media (max-width: 768px) { .profile-layout { grid-template-columns: 1fr; } }
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
                <a href="{{ route('shop', ['category' => 'Trang phục']) }}" class="nav-link">Trang phục</a>
                <a href="{{ route('shop', ['category' => 'Áo']) }}" class="nav-link">Áo</a>
                <a href="{{ route('shop', ['category' => 'Quần']) }}" class="nav-link">Quần</a>
                <a href="{{ route('shop', ['category' => 'Phụ kiện']) }}" class="nav-link">Phụ kiện</a>
            </nav>

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
                <a href="{{ route('profile.favorites') }}" class="nav-item">
                    <i class="far fa-heart"></i> Sản phẩm yêu thích
                </a>
                <a href="{{ route('profile.address') }}" class="nav-item active">
                    <i class="fas fa-map-marker-alt"></i> Sổ địa chỉ
                </a>
                <a href="{{ route('logout') }}" class="nav-item" style="color: #ef4444; margin-top: 10px;">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </a>
            </nav>
        </aside>

        <section class="profile-content">
            <div class="content-header">
                <h2>Sổ địa chỉ</h2>
                <p>Cập nhật địa chỉ và số điện thoại để thuận tiện hơn khi mua sắm và thanh toán.</p>
            </div>

            @if(session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div style="margin-bottom: 2px;">{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ route('profile.address.update') }}" method="POST">
                @csrf
                
                <div class="form-group" style="max-width: 600px;">
                    <label>Số điện thoại liên lạc <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" required placeholder="Ví dụ: 0912345678">
                </div>

                <div class="form-group" style="max-width: 600px;">
                    <label>Địa chỉ nhận hàng (Số nhà, Tên đường, Phường/Xã, Quận/Huyện, Tỉnh/TP) <span style="color: #ef4444;">*</span></label>
                    <textarea name="address" class="form-control" required placeholder="Ví dụ: 123 Đường ABC, Phường 1, Quận 1, TP. HCM" rows="4" style="resize: vertical;">{{ $user->address }}</textarea>
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" class="btn-primary">Lưu Sổ Địa Chỉ</button>
                </div>
            </form>
        </section>
    </main>

    <footer class="main-footer" style="background: #0f172a; padding: 40px 0;">
        <div class="footer-grid" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div class="footer-col" style="text-align: center; color: white;">
                <p>&copy; 2026 Tiny Flowers. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
