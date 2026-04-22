-- ============================================================
-- Database Schema cho MVC Project
-- ============================================================

CREATE DATABASE IF NOT EXISTS mvc_project_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mvc_project_db;

-- Bảng người dùng
CREATE TABLE IF NOT EXISTS users (
    user_id        INT AUTO_INCREMENT PRIMARY KEY,
    username       VARCHAR(50)  NOT NULL UNIQUE,
    email          VARCHAR(100) NOT NULL UNIQUE,
    fullname       VARCHAR(100) NOT NULL,
    role           ENUM('admin', 'staff', 'technician') NOT NULL DEFAULT 'staff',
    status         ENUM('active', 'inactive', 'ban')    NOT NULL DEFAULT 'active',
    phone          VARCHAR(20)  DEFAULT NULL,
    profile_picture VARCHAR(255) DEFAULT 'images/default.jpg',
    created_at     DATETIME     DEFAULT CURRENT_TIMESTAMP,
    updated_at     DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng xác thực
CREATE TABLE IF NOT EXISTS auth_accounts (
    auth_id               INT AUTO_INCREMENT PRIMARY KEY,
    user_id               INT          NOT NULL UNIQUE,
    password              VARCHAR(255) NOT NULL,
    is_active             TINYINT(1)   NOT NULL DEFAULT 1,
    last_login            DATETIME     DEFAULT NULL,
    failed_login_attempts INT          NOT NULL DEFAULT 0,
    reset_token           VARCHAR(100) DEFAULT NULL,
    reset_token_expires   DATETIME     DEFAULT NULL,
    created_at            DATETIME     DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- ============================================================
-- Dữ liệu mẫu
-- ============================================================

-- Tài khoản admin mặc định (password: Admin@123)
INSERT INTO users (username, email, fullname, role, status) VALUES
('admin', 'admin@example.com', 'Quản trị viên', 'admin', 'active');

INSERT INTO auth_accounts (user_id, password, is_active) VALUES
(1, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);
-- password: password (bcrypt hash mẫu - hãy đổi lại)
