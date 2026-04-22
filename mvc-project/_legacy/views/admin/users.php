<?php
session_start();
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../controllers/UserController.php';

$userController = new UserController($userId, $userRole);
$result = $userController->handleRequest('get_all_users', ['limit' => 50, 'offset' => 0]);
$users  = $result['data'] ?? [];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý người dùng</title>
    <link rel="stylesheet" href="/mvc-project/vendor/home/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/mvc-project/assets/css/style.css">
</head>
<body>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<div class="content-wrapper">
    <div class="content container-fluid">
        <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="page-title">Quản lý người dùng</h3>
            <a href="/mvc-project/views/admin/newuser.php" class="btn btn-primary btn-sm">+ Thêm người dùng</a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên đăng nhập</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $i => $u): ?>
                            <tr>
                                <td><?php echo $i + 1; ?></td>
                                <td><?php echo htmlspecialchars($u['username']); ?></td>
                                <td><?php echo htmlspecialchars($u['fullname']); ?></td>
                                <td><?php echo htmlspecialchars($u['email']); ?></td>
                                <td><?php echo htmlspecialchars($u['role']); ?></td>
                                <td><?php echo htmlspecialchars($u['status']); ?></td>
                                <td>
                                    <a href="/mvc-project/views/admin/updateuser.php?id=<?php echo $u['user_id']; ?>"
                                       class="btn btn-sm btn-warning">Sửa</a>
                                    <a href="/mvc-project/views/admin/deleteuser.php?id=<?php echo $u['user_id']; ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center">Không có dữ liệu</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
