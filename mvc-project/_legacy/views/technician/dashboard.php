<?php
session_start();
require_once __DIR__ . '/../../includes/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Technician Dashboard</title>
    <link rel="stylesheet" href="/mvc-project/vendor/home/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/mvc-project/assets/css/style.css">
</head>
<body>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<div class="content-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <h3 class="page-title">Xin chào, <?php echo htmlspecialchars($userData['fullname'] ?? ''); ?></h3>
        </div>
        <p>Đây là trang dashboard của Technician.</p>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
