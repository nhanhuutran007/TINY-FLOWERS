<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUserById($userId) {
        $stmt = $this->conn->prepare(
            "SELECT user_id, username, email, fullname, role, status, phone, profile_picture, created_at
             FROM users WHERE user_id = ? LIMIT 1"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows === 1 ? $result->fetch_assoc() : null;
    }

    public function getAllUsers($filters = [], $limit = 50, $offset = 0) {
        $query  = "SELECT user_id, username, email, fullname, role, status, created_at FROM users WHERE 1=1";
        $params = [];
        $types  = "";

        if (!empty($filters['role'])) {
            $query   .= " AND role = ?";
            $params[] = $filters['role'];
            $types   .= "s";
        }
        if (!empty($filters['status'])) {
            $query   .= " AND status = ?";
            $params[] = $filters['status'];
            $types   .= "s";
        }

        $query   .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types   .= "ii";

        $stmt = $this->conn->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function createUser($data) {
        $stmt = $this->conn->prepare(
            "INSERT INTO users (username, email, fullname, role, status, phone) VALUES (?, ?, ?, ?, 'active', ?)"
        );
        $stmt->bind_param(
            "sssss",
            $data['username'],
            $data['email'],
            $data['fullname'],
            $data['role'],
            $data['phone'] ?? null
        );
        $stmt->execute();
        return $this->conn->insert_id;
    }

    public function updateUser($userId, $data) {
        $fields = [];
        $params = [];
        $types  = "";

        $allowed = ['fullname', 'email', 'phone', 'status', 'role', 'profile_picture'];
        foreach ($allowed as $field) {
            if (isset($data[$field])) {
                $fields[] = "$field = ?";
                $params[] = $data[$field];
                $types   .= "s";
            }
        }

        if (empty($fields)) return false;

        $params[] = $userId;
        $types   .= "i";

        $query = "UPDATE users SET " . implode(", ", $fields) . " WHERE user_id = ?";
        $stmt  = $this->conn->prepare($query);
        $stmt->bind_param($types, ...$params);
        return $stmt->execute();
    }

    public function deleteUser($userId) {
        // Soft delete
        $stmt = $this->conn->prepare("UPDATE users SET status = 'ban' WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        return $stmt->execute();
    }
}
?>
