<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $userModel;
    private $userId;
    private $userRole;

    public function __construct($userId, $userRole) {
        $conn = require __DIR__ . '/../includes/db.php';
        $this->userModel = new UserModel($conn);
        $this->userId    = $userId;
        $this->userRole  = $userRole;
    }

    /**
     * Xử lý các request liên quan đến user
     * @param string $action
     * @param array  $params
     * @return array ['success' => bool, 'data' => mixed, 'message' => string]
     */
    public function handleRequest($action, $params = []) {
        try {
            switch ($action) {
                case 'get_all_users':
                    $this->requireRole(['admin']);
                    $data = $this->userModel->getAllUsers(
                        $params['filters'] ?? [],
                        $params['limit']   ?? 50,
                        $params['offset']  ?? 0
                    );
                    return ['success' => true, 'data' => $data];

                case 'get_user_by_id':
                    $data = $this->userModel->getUserById($params['user_id']);
                    return ['success' => true, 'data' => $data];

                case 'create_user':
                    $this->requireRole(['admin']);
                    $id = $this->userModel->createUser($params);
                    return ['success' => true, 'data' => ['user_id' => $id], 'message' => 'Tạo người dùng thành công'];

                case 'update_user':
                    $this->requireRole(['admin']);
                    $result = $this->userModel->updateUser($params['user_id'], $params);
                    return ['success' => $result, 'message' => $result ? 'Cập nhật thành công' : 'Cập nhật thất bại'];

                case 'delete_user':
                    $this->requireRole(['admin']);
                    $result = $this->userModel->deleteUser($params['user_id']);
                    return ['success' => $result, 'message' => $result ? 'Xóa thành công' : 'Xóa thất bại'];

                default:
                    return ['success' => false, 'message' => "Action '$action' không hợp lệ"];
            }
        } catch (Exception $e) {
            error_log("UserController error: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function requireRole(array $roles) {
        if (!in_array($this->userRole, $roles)) {
            throw new Exception("Bạn không có quyền thực hiện hành động này.");
        }
    }
}
?>
