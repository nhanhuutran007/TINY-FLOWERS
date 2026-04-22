<?php
ob_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../models/AuthLoginModel.php';

class AuthLoginController {
    private $authLoginModel;

    public function __construct($db) {
        $this->authLoginModel = new AuthLoginModel($db);
    }

    public function login() {
        $error   = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($username) || empty($password)) {
                $error = "Vui lòng nhập đầy đủ thông tin!";
            } else {
                $user = $this->authLoginModel->getUserByUsername($username);

                if (!$user) {
                    $error = "Tên đăng nhập không tồn tại!";
                } elseif ($user['is_active'] != 1) {
                    $error = "Tài khoản chưa được kích hoạt!";
                } elseif ($user['status'] === 'inactive') {
                    $error = "Tài khoản đã bị tạm khóa!";
                } elseif ($user['status'] === 'ban') {
                    $error = "Tài khoản không có quyền truy cập!";
                } elseif (password_verify($password, $user['password'])) {
                    $this->authLoginModel->updateLastLogin($user['user_id']);

                    $_SESSION['user_id']       = $user['user_id'];
                    $_SESSION['username']      = $user['username'];
                    $_SESSION['role']          = $user['role'];
                    $_SESSION['last_activity'] = time();

                    $redirectPages = [
                        'admin'      => '/mvc-project/views/admin/dashboard.php',
                        'staff'      => '/mvc-project/views/staff/dashboard.php',
                        'technician' => '/mvc-project/views/technician/dashboard.php',
                    ];

                    if (isset($redirectPages[$user['role']])) {
                        header("Location: " . $redirectPages[$user['role']]);
                        exit();
                    } else {
                        $error = "Tài khoản không có quyền truy cập!";
                    }
                } else {
                    $this->authLoginModel->incrementFailedAttempts($user['user_id']);
                    $error = "Mật khẩu không chính xác!";
                }
            }
        }

        if (isset($_GET['success']) && $_GET['success'] === 'registered') {
            $success = "Đăng ký thành công! Vui lòng đăng nhập.";
        }

        require_once __DIR__ . '/../views/auth/login.php';
    }
}
?>
