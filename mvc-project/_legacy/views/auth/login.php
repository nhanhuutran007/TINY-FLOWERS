<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="/mvc-project/vendor/home/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/mvc-project/assets/css/auth.css">
</head>
<body>
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow p-4" style="width: 100%; max-width: 420px;">
        <div class="text-center mb-4">
            <img src="/mvc-project/assets/img/logo.png" alt="Logo" height="50">
            <h4 class="mt-2">Đăng nhập</h4>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" action="/mvc-project/index.php?route=login">
            <div class="mb-3">
                <label class="form-label">Tên đăng nhập</label>
                <input type="text" name="username" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="/mvc-project/index.php?route=forgot" class="text-decoration-none small">Quên mật khẩu?</a>
            </div>
            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        </form>

        <hr>
        <p class="text-center mb-0 small">
            Chưa có tài khoản?
            <a href="/mvc-project/index.php?route=register">Đăng ký</a>
        </p>
    </div>
</div>
<script src="/mvc-project/vendor/home/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
