<?php
class AuthRegisterModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function usernameExists($username) {
        $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function emailExists($email) {
        $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    /**
     * Tạo user mới (role mặc định: staff, is_active: 1)
     */
    public function createUser($username, $email, $hashedPassword, $fullname, $role = 'staff') {
        $this->conn->begin_transaction();
        try {
            // Thêm vào bảng users
            $stmt = $this->conn->prepare(
                "INSERT INTO users (username, email, fullname, role, status) VALUES (?, ?, ?, ?, 'active')"
            );
            $stmt->bind_param("ssss", $username, $email, $fullname, $role);
            $stmt->execute();
            $userId = $this->conn->insert_id;

            // Thêm vào bảng auth_accounts
            $stmt2 = $this->conn->prepare(
                "INSERT INTO auth_accounts (user_id, password, is_active) VALUES (?, ?, 1)"
            );
            $stmt2->bind_param("is", $userId, $hashedPassword);
            $stmt2->execute();

            $this->conn->commit();
            return $userId;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("AuthRegisterModel::createUser - " . $e->getMessage());
            return false;
        }
    }
}
?>
