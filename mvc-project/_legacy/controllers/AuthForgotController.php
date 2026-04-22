<?php
ob_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../models/AuthResetModel.php';

class AuthForgotController {
    private $authResetModel;

    public function __construct($db) {
        $this->authResetModel = new AuthResetModel($db);
    }

    public function forgot() {
        $error   = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email không hợp lệ!";
            } else {
                $token = bin2hex(random_bytes(32));
                $result = $this->authResetModel->saveResetToken($email, $token);

                if ($result) {
                    // TODO: Gửi email chứa link reset
                    // $resetLink = "http://localhost/mvc-project/index.php?route=reset&token=$token";
                    $success = "Đã gửi link đặt lại mật khẩu về email của bạn!";
                } else {
                    $error = "Email không tồn tại trong hệ thống!";
                }
            }
        }

        require_once __DIR__ . '/../views/auth/forgot_password.php';
    }
}
?>
