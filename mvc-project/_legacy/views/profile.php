<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../controllers/ProfileController.php';

$conn = require __DIR__ . '/../includes/db.php';
$profileController = new ProfileController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profileController->updateProfile();
} else {
    $profileController->showProfile();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ sơ cá nhân</title>
    <link rel="stylesheet" href="/mvc-project/vendor/home/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/mvc-project/assets/css/style.css">
</head>
<body>
<?php require_once __DIR__ . '/../includes/sidebar.php'; ?>

<div class="content-wrapper">
    <?php require_once __DIR__ . '/../includes/header.php'; ?>

    <div class="content container-fluid">
        <div class="page-header">
            <h3 class="page-title">Hồ sơ cá nhân</h3>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="text-center mb-4">
                        <img src="/mvc-project/assets/images/<?php echo htmlspecialchars($userData['profile_picture'] ?? 'default.jpg'); ?>"
                             alt="Avatar" class="rounded-circle" width="100" height="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ảnh đại diện</label>
                        <input type="file" name="profile_picture" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" name="fullname" class="form-control"
                               value="<?php echo htmlspecialchars($userData['fullname'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="<?php echo htmlspecialchars($userData['email'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control"
                               value="<?php echo htmlspecialchars($userData['phone'] ?? ''); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
