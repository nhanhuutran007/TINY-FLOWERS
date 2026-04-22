<?php
session_start();
require_once __DIR__ . '/../../includes/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/mvc-project/vendor/home/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/mvc-project/assets/css/style.css">
</head>
<body>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<div class="content-wrapper">
    <?php require_once __DIR__ . '/../../includes/header.php'; ?>

    <div class="content container-fluid">
        <div class="page-header">
            <h3 class="page-title">Dashboard</h3>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Người dùng</h5>
                        <p class="card-text display-6">0</p>
                    </div>
                </div>
            </div>
            <!-- Thêm các card thống kê khác tại đây -->
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
