<?php
class AuthResetModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function saveResetToken($email, $token) {
        // Kiểm tra email tồn tại
        $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) return false;

        $user    = $result->fetch_assoc();
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmt2 = $this->conn->prepare(
            "UPDATE auth_accounts SET reset_token = ?, reset_token_expires = ? WHERE user_id = ?"
        );
        $stmt2->bind_param("ssi", $token, $expires, $user['user_id']);
        return $stmt2->execute();
    }

    public function getUserByResetToken($token) {
        $now  = date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare(
            "SELECT u.user_id FROM users u
             JOIN auth_accounts a ON u.user_id = a.user_id
             WHERE a.reset_token = ? AND a.reset_token_expires > ? LIMIT 1"
        );
        $stmt->bind_param("ss", $token, $now);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows === 1 ? $result->fetch_assoc() : null;
    }

    public function updatePassword($userId, $hashedPassword) {
        $stmt = $this->conn->prepare("UPDATE auth_accounts SET password = ? WHERE user_id = ?");
        $stmt->bind_param("si", $hashedPassword, $userId);
        return $stmt->execute();
    }

    public function clearResetToken($token) {
        $stmt = $this->conn->prepare(
            "UPDATE auth_accounts SET reset_token = NULL, reset_token_expires = NULL WHERE reset_token = ?"
        );
        $stmt->bind_param("s", $token);
        return $stmt->execute();
    }
}
?>
