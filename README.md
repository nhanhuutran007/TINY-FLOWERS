# 🌸 TINY FLOWERS - Fashion & Streetwear Shop

**Tiny Flowers** là một nền tảng thương mại điện tử chuyên biệt về thời trang Streetwear dành cho giới trẻ (Gen Z). Dự án được xây dựng với phong cách thiết kế tối giản, hiện đại, tích hợp các công nghệ mới nhất từ Laravel 12 và quy trình triển khai chuyên nghiệp trên nền tảng đám mây AWS.

---

## 🚀 Tính năng nổi bật

- **Giao diện hiện đại (Modern UI):** Thiết kế tối giản, hiệu ứng micro-interaction cao cấp.
- **Đăng nhập Google (OAuth2):** Tích hợp Socialite cho phép người dùng đăng nhập nhanh chóng qua tài khoản Google.
- **Video Lookbook:** Trải nghiệm sản phẩm sinh động qua các video Cinema chất lượng cao.
- **Style Explorer Carousel:** Thanh trượt phong cách tự động, giúp khám phá đa dạng cách phối đồ.
- **Quản trị thông minh:** Hệ thống Dashboard tìm kiếm và quản lý sản phẩm tối ưu.
- **Triển khai Cloud (AWS EC2):** Cấu hình chạy thực tế trên server Ubuntu với Nginx và PHP-FPM 8.5.

---

## 📂 Cấu trúc thư mục dự án

```text
TINY-FLOWERS/
├── mvc-project/                 # Thư mục chính của mã nguồn Laravel
│   ├── app/                     # Logic nghiệp vụ (Models, Controllers, Middleware)
│   ├── config/                  # Cấu hình hệ thống (Services, Database)
│   ├── database/                # Schema SQL & Migrations
│   ├── public/                  # Tài nguyên công khai (CSS, JS, Media)
│   │   ├── images/source/       # Kho tài nguyên video Lookbook & ảnh sản phẩm
│   ├── resources/               # Giao diện (Blade Templates)
│   └── routes/                  # Định nghĩa đường dẫn (web.php, api.php)
├── setup_db.sql                 # Script khởi tạo User & Database trên Server
├── full_data.sql                # Bản dump dữ liệu đầy đủ từ môi trường Dev
└── tiny-flowers.conf            # Cấu hình Server Block cho Nginx
```

---

## 🛠 Công nghệ sử dụng

- **Framework:** Laravel 12 (PHP 8.5).
- **Database:** MariaDB 10.11 / MySQL 8.4.
- **Web Server:** Nginx 1.24 (Ubuntu 26.04).
- **Authentication:** Laravel Socialite (Google OAuth).
- **Frontend:** Vanilla CSS, JavaScript, Font Awesome 6.

---

## 🔧 Hướng dẫn triển khai (Production)

### 1. Cấu hình Server
Dự án được cấu hình chạy trên AWS EC2 Ubuntu. File cấu hình Nginx nằm tại `/etc/nginx/sites-available/tiny-flowers`.

### 2. Cấu hình Google OAuth (không cần Domain)
Để chạy đăng nhập Google trên địa chỉ IP, dự án sử dụng giải pháp `nip.io`:
- **Redirect URI:** `http://your-ip.nip.io/auth/google/callback`
- **Cấu hình:** Cập nhật `GOOGLE_CLIENT_ID` và `GOOGLE_CLIENT_SECRET` trong `config/services.php`.

### 3. Lệnh bảo trì hệ thống
Khi thay đổi cấu hình, cần chạy các lệnh sau trên server:
```bash
# Xóa và nạp lại cache cấu hình
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan cache:clear

# Cấp quyền thư mục
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

---

## ✍️ Tác giả
Dự án được phát triển và tối ưu hóa bởi **nhanhuutran007** với tâm huyết mang lại một trải nghiệm mua sắm Streetwear đẳng cấp trên nền tảng Web hiện đại.

---
*&copy; 2026 Tiny Flowers. All rights reserved. Deployment powered by AWS EC2.*
