<?php
ob_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../models/AuthResetModel.php';

class AuthResetController {
    private $authResetModel;

    public function __construct($db) {
        $this->authResetModel = new AuthResetModel($db);
    }

    public function reset() {
        $error   = '';
        $success = '';
        $token   = $_GET['token'] ?? '';

        if (empty($token)) {
            header("Location: /mvc-project/views/auth/login.php?error=no_token");
            exit();
        }

        $user = $this->authResetModel->getUserByResetToken($token);
        if (!$user) {
            header("Location: /mvc-project/views/auth/login.php?error=invalid_token");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = trim($_POST['password'] ?? '');
            $confirm  = trim($_POST['confirm_password'] ?? '');

            if (empty($password) || $password !== $confirm) {
                $error = "Mật khẩu không khớp hoặc để trống!";
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $this->authResetModel->updatePassword($user['user_id'], $hashed);
                $this->authResetModel->clearResetToken($token);
                header("Location: /mvc-project/views/auth/login.php?success=password_reset");
                exit();
            }
        }

        require_once __DIR__ . '/../views/auth/reset_password.php';
    }
}
?>
