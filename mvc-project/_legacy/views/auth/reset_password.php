<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu</title>
    <link rel="stylesheet" href="/mvc-project/vendor/home/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/mvc-project/assets/css/auth.css">
</head>
<body>
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow p-4" style="width: 100%; max-width: 420px;">
        <h4 class="text-center mb-4">Đặt lại mật khẩu</h4>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="/mvc-project/index.php?route=reset&token=<?php echo htmlspecialchars($token); ?>">
            <div class="mb-3">
                <label class="form-label">Mật khẩu mới</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Xác nhận mật khẩu</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Đặt lại mật khẩu</button>
        </form>
    </div>
</div>
</body>
</html>
