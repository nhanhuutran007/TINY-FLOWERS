# MVC Project - PHP

Dự án PHP theo mô hình MVC thuần, không dùng framework.

## Cấu trúc thư mục

```
mvc-project/
├── index.php               # Entry point, router chính
├── .htaccess               # Bảo vệ file, rewrite rules
├── composer.json           # Dependencies
│
├── includes/               # Shared components
│   ├── db.php              # Kết nối database
│   ├── header.php          # Header + session check
│   ├── footer.php          # Footer + scripts
│   ├── sidebar.php         # Sidebar theo role
│   └── 404.php             # Trang lỗi 404
│
├── controllers/            # Xử lý logic request
│   ├── AuthLoginController.php
│   ├── AuthRegisterController.php
│   ├── AuthForgotController.php
│   ├── AuthResetController.php
│   ├── UserController.php
│   └── ProfileController.php
│
├── models/                 # Tương tác database
│   ├── AuthLoginModel.php
│   ├── AuthRegisterModel.php
│   ├── AuthResetModel.php
│   └── UserModel.php
│
├── repositories/           # Lớp entity/repository (CRUD phức tạp)
│   └── (thêm file tại đây)
│
├── functions/              # Business logic theo module
│   └── (thêm module tại đây)
│
├── views/                  # Giao diện người dùng
│   ├── auth/               # Login, register, forgot, reset, logout
│   ├── admin/              # Trang dành cho admin
│   ├── staff/              # Trang dành cho staff
│   ├── technician/         # Trang dành cho technician
│   └── profile.php         # Hồ sơ cá nhân
│
├── api/                    # API endpoints (AJAX/fetch)
│   └── (thêm endpoint tại đây)
│
├── report/                 # Xuất Excel, PDF
│   ├── export_excel.php
│   └── export_pdf.php
│
├── database/               # SQL schema và seed data
│   └── schema.sql
│
├── assets/                 # Static files
│   ├── css/
│   ├── js/
│   ├── img/
│   └── images/             # Upload files
│
└── vendor/                 # Composer packages (sau khi install)
```

## Cài đặt

1. Import database:
   ```
   mysql -u root -p < database/schema.sql
   ```

2. Cài dependencies:
   ```
   composer install
   ```

3. Cấu hình database trong `includes/db.php`

4. Trỏ web server (XAMPP/Laragon) vào thư mục dự án

5. Truy cập: `http://localhost/mvc-project/`

## Luồng hoạt động MVC

```
Request → index.php (Router)
              ↓
         Controller  ←→  Model (DB)
              ↓
            View (HTML)
```

## Phân quyền

| Role        | Dashboard                        |
|-------------|----------------------------------|
| admin       | /views/admin/dashboard.php       |
| staff       | /views/staff/dashboard.php       |
| technician  | /views/technician/dashboard.php  |
