<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" href="/mvc-project/vendor/home/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/mvc-project/assets/css/auth.css">
</head>
<body>
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow p-4" style="width: 100%; max-width: 420px;">
        <h4 class="text-center mb-4">Quên mật khẩu</h4>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" action="/mvc-project/index.php?route=forgot">
            <div class="mb-3">
                <label class="form-label">Email đã đăng ký</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Gửi link đặt lại</button>
        </form>

        <p class="text-center mt-3 small">
            <a href="/mvc-project/views/auth/login.php">Quay lại đăng nhập</a>
        </p>
    </div>
</div>
</body>
</html>
