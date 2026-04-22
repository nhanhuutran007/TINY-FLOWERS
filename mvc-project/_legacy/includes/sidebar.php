<?php
// sidebar.php - Sidebar chung, hiển thị menu theo role
$userRole = strtolower($_SESSION['role'] ?? '');
?>

<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <?php if ($userRole === 'admin'): ?>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Admin</h6>
                    <ul>
                        <li>
                            <a href="/mvc-project/views/admin/dashboard.php">
                                <img src="/mvc-project/assets/img/icons/dashboard.svg" alt="Dashboard">
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="/mvc-project/views/admin/users.php">
                                <img src="/mvc-project/assets/img/icons/users1.svg" alt="Users">
                                <span>Quản lý người dùng</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php elseif ($userRole === 'staff'): ?>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Staff</h6>
                    <ul>
                        <li>
                            <a href="/mvc-project/views/staff/dashboard.php">
                                <img src="/mvc-project/assets/img/icons/dashboard.svg" alt="Dashboard">
                                <span>Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php elseif ($userRole === 'technician'): ?>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Technician</h6>
                    <ul>
                        <li>
                            <a href="/mvc-project/views/technician/dashboard.php">
                                <img src="/mvc-project/assets/img/icons/dashboard.svg" alt="Dashboard">
                                <span>Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- Menu chung -->
                <li>
                    <a href="/mvc-project/views/profile.php">
                        <img src="/mvc-project/assets/img/icons/settings.svg" alt="Profile">
                        <span>Hồ sơ cá nhân</span>
                    </a>
                </li>
                <li>
                    <a href="/mvc-project/views/auth/logout.php">
                        <img src="/mvc-project/assets/img/icons/log-out.svg" alt="Logout">
                        <span>Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
