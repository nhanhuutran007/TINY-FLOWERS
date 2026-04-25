@extends('layouts.shop')

@section('styles')
<style>
    body { background-color: #f8fafc; }
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
        font-size: 14.5px;
    }
    .nav-item:hover, .nav-item.active { 
        background: #f1f5f9; 
        color: #0f172a; 
    }
    .nav-item.active { 
        background: #eff6ff; 
        color: #319DFF; 
        font-weight: 600;
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
    @media (max-width: 768px) {
        .profile-layout { grid-template-columns: 1fr; }
    }
</style>
@yield('profile_styles')
@endsection

@section('content')
<div class="profile-layout">
    <aside class="profile-sidebar">
        <div class="user-summary">
            @php
                $user = Auth::user();
                $avatarUrl = $user->profile_picture 
                    ? asset('images/avatars/' . $user->profile_picture) 
                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->fullname) . '&background=319DFF&color=fff';
            @endphp
            <img src="{{ $avatarUrl }}" alt="{{ $user->fullname }}">
            <h3>{{ $user->fullname }}</h3>
            <p>Khách hàng thân thiết</p>
        </div>
        
        <nav class="nav-sidebar">
            <a href="{{ route('profile.index') }}" class="nav-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <i class="far fa-user-circle"></i> Hồ sơ của tôi
            </a>
            <a href="{{ route('profile.password') }}" class="nav-item {{ request()->routeIs('profile.password') ? 'active' : '' }}">
                <i class="fas fa-shield-alt"></i> Đổi mật khẩu
            </a>
            <a href="{{ route('profile.orders') }}" class="nav-item {{ request()->routeIs('profile.orders') ? 'active' : '' }}">
                <i class="fas fa-shopping-bag"></i> Đơn hàng mua
            </a>
            <a href="{{ route('profile.favorites') }}" class="nav-item {{ request()->routeIs('profile.favorites') ? 'active' : '' }}">
                <i class="far fa-heart"></i> Sản phẩm yêu thích
            </a>
            <a href="{{ route('profile.address') }}" class="nav-item {{ request()->routeIs('profile.address') ? 'active' : '' }}">
                <i class="fas fa-map-marker-alt"></i> Sổ địa chỉ
            </a>
            <a href="{{ route('logout') }}" class="nav-item" style="color: #ef4444; margin-top: 10px;">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </a>
        </nav>
    </aside>

    <section class="profile-content">
        @yield('profile_content')
    </section>
</div>
@endsection
