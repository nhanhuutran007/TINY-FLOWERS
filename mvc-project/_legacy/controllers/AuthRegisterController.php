<?php
ob_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../models/AuthRegisterModel.php';

class AuthRegisterController {
    private $authRegisterModel;

    public function __construct($db) {
        $this->authRegisterModel = new AuthRegisterModel($db);
    }

    public function register() {
        $error   = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username  = trim($_POST['username'] ?? '');
            $email     = trim($_POST['email'] ?? '');
            $password  = trim($_POST['password'] ?? '');
            $confirm   = trim($_POST['confirm_password'] ?? '');
            $fullname  = trim($_POST['fullname'] ?? '');

            if (empty($username) || empty($email) || empty($password) || empty($fullname)) {
                $error = "Vui lòng nhập đầy đủ thông tin!";
            } elseif ($password !== $confirm) {
                $error = "Mật khẩu xác nhận không khớp!";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email không hợp lệ!";
            } elseif ($this->authRegisterModel->usernameExists($username)) {
                $error = "Tên đăng nhập đã tồn tại!";
            } elseif ($this->authRegisterModel->emailExists($email)) {
                $error = "Email đã được sử dụng!";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $result = $this->authRegisterModel->createUser($username, $email, $hashedPassword, $fullname);

                if ($result) {
                    header("Location: /mvc-project/views/auth/login.php?success=registered");
                    exit();
                } else {
                    $error = "Đăng ký thất bại, vui lòng thử lại!";
                }
            }
        }

        require_once __DIR__ . '/../views/auth/register.php';
    }
}
?>
