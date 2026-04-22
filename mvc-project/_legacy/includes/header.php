<?php
$conn = require __DIR__ . '/db.php';
require_once __DIR__ . '/../models/UserModel.php';

// Kiểm tra session và timeout (1 giờ)
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) ||
    (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 3600))) {
    session_destroy();
    header("Location: /mvc-project/views/auth/login.php?error=session_expired");
    exit();
}

$_SESSION['last_activity'] = time();

$userRole = strtolower($_SESSION['role']);
$userId   = $_SESSION['user_id'];

// URL dashboard theo role
$dashboardUrls = [
    'admin'      => '/mvc-project/views/admin/dashboard.php',
    'staff'      => '/mvc-project/views/staff/dashboard.php',
    'technician' => '/mvc-project/views/technician/dashboard.php',
];
$dashboardUrl = $dashboardUrls[$userRole] ?? '/mvc-project/views/auth/login.php';

// Lấy thông tin người dùng
$userModel = new UserModel($conn);
$userData  = $userModel->getUserById($userId);

if (!$userData) {
    session_destroy();
    header("Location: /mvc-project/views/auth/login.php?error=user_not_found");
    exit();
}

$profilePicture = "/mvc-project/assets/images/" . htmlspecialchars($userData['profile_picture'] ?? 'default.jpg');
?>

<div class="header">
    <div class="header-left active">
        <a href="<?php echo $dashboardUrl; ?>" class="logo">
            <img src="/mvc-project/assets/img/logo.png" alt="Logo" width="140" height="60">
        </a>
        <a id="toggle_btn" href="javascript:void(0);"></a>
    </div>

    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
        <span class="bar-icon">
            <span></span><span></span><span></span>
        </span>
    </a>

    <ul class="nav user-menu">
        <!-- User Profile Dropdown -->
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img src="<?php echo $profilePicture; ?>" alt="Avatar">
                    <span class="status online"></span>
                </span>
            </a>
            <div class="dropdown-menu menu-drop-user">
                <div class="profilename">
                    <div class="profileset">
                        <span class="user-img">
                            <img src="<?php echo $profilePicture; ?>" alt="Avatar">
                            <span class="status online"></span>
                        </span>
                        <div class="profilesets">
                            <h6><?php echo htmlspecialchars($userData['fullname'] ?? 'User'); ?></h6>
                            <h5><?php echo htmlspecialchars($userData['role'] ?? ''); ?></h5>
                        </div>
                    </div>
                    <hr class="m-0">
                    <a class="dropdown-item" href="/mvc-project/views/profile.php">
                        <i class="me-2" data-feather="user"></i>Hồ sơ cá nhân
                    </a>
                    <hr class="m-0">
                    <a class="dropdown-item logout pb-0" href="/mvc-project/views/auth/logout.php">
                        Đăng xuất
                    </a>
                </div>
            </div>
        </li>
    </ul>
</div>
