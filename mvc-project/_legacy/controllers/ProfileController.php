<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../models/UserModel.php';

class ProfileController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    public function showProfile() {
        $userId   = $_SESSION['user_id'];
        $userData = $this->userModel->getUserById($userId);

        if (!$userData) {
            header("Location: /mvc-project/views/auth/login.php");
            exit();
        }

        require_once __DIR__ . '/../views/profile.php';
    }

    public function updateProfile() {
        $userId  = $_SESSION['user_id'];
        $error   = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'fullname' => trim($_POST['fullname'] ?? ''),
                'email'    => trim($_POST['email'] ?? ''),
                'phone'    => trim($_POST['phone'] ?? ''),
            ];

            // Xử lý upload ảnh đại diện
            if (!empty($_FILES['profile_picture']['name'])) {
                $uploadDir  = __DIR__ . '/../assets/images/';
                $ext        = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
                $filename   = 'profile_' . $userId . '_' . time() . '.' . $ext;
                $uploadPath = $uploadDir . $filename;

                $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];
                if (!in_array(strtolower($ext), $allowedTypes)) {
                    $error = "Chỉ chấp nhận file ảnh (jpg, jpeg, png, webp)!";
                } elseif (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadPath)) {
                    $data['profile_picture'] = 'images/' . $filename;
                } else {
                    $error = "Upload ảnh thất bại!";
                }
            }

            if (empty($error)) {
                $result = $this->userModel->updateUser($userId, $data);
                $success = $result ? "Cập nhật hồ sơ thành công!" : "Cập nhật thất bại!";
            }
        }

        $userData = $this->userModel->getUserById($userId);
        require_once __DIR__ . '/../views/profile.php';
    }
}
?>
