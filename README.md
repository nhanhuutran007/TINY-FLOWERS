# TINY-FLOWERS# TINY FLOWERS - Hệ Thống Quản Lý Cửa Hàng Thời Trang Nam

## 👔 Giới Thiệu Dự Án
**TINY FLOWERS** (Định hướng: Cửa hàng Thời trang Nam) là một ứng dụng web quản lý bán hàng chuyên nghiệp dành cho các thương hiệu thời trang nam giới. Dự án được xây dựng trên nền tảng framework Laravel theo kiến trúc **MVC** (Model-View-Controller), tập trung vào phong cách tối giản, sang trọng và trải nghiệm mua sắm mượt mà.

---

## 📂 Cấu Trúc Thư Mục Dự Án
Dự án tuân thủ cấu trúc chuẩn của Laravel để đảm bảo tính bảo mật và khả năng mở rộng:

- **`app/`**: Chứa logic nghiệp vụ chính (Controllers xử lý đơn hàng, Models sản phẩm thời trang).
- **`bootstrap/`**: Chứa các file khởi tạo và cache của hệ thống.
- **`config/`**: Lưu trữ các file cấu hình ứng dụng (Database, Session, Mail...).
- **`database/`**: Quản lý cơ sở dữ liệu qua các file Migrations (Bảng sản phẩm, size, màu sắc) và Seeders.
- **`public/`**: **Web Root** - Chứa các tài nguyên tĩnh công khai (CSS giao diện, JS, Hình ảnh sản phẩm, `.htaccess`).
- **`resources/views/`**: Chứa giao diện người dùng (Blade templates cho trang chủ, bộ sưu tập, chi tiết sản phẩm).
- **`routes/`**: Định nghĩa các đường dẫn URL của ứng dụng (`web.php`).
- **`storage/`**: Lưu trữ hình ảnh sản phẩm, logs và các tệp tạm thời.
- **`vendor/`**: Chứa các thư viện của bên thứ ba được quản lý bởi Composer.

---

## 🚀 Các Chức Năng Dự Kiến
Hệ thống quản lý thời trang nam bao gồm các module chính:

1.  **Hệ Thống Xác Thực (Auth)**:
    - [x] Giao diện Đăng nhập sang trọng dành cho khách hàng/quản trị.
    - [x] Giao diện Đăng ký thành viên mới.
    - [ ] Tích hợp đăng nhập mạng xã hội (Google, Facebook).
2.  **Quản Lý Sản Phẩm (Inventory)**:
    - Quản lý danh mục (Áo sơ mi, Quần tây, Suit, Phụ kiện).
    - Quản lý biến thể sản phẩm (Size: S, M, L, XL; Màu sắc).
3.  **Quản Lý Đơn Hàng (Orders)**:
    - Giỏ hàng, thanh toán và theo dõi tình trạng đơn hàng.
4.  **Bảng Điều Khiển (Admin Dashboard)**:
    - Thống kê doanh thu theo mùa, quản lý kho hàng và khách hàng thân thiết.
5.  **Marketing & Khuyến Mãi**:
    - Quản lý mã giảm giá (Coupon) và các chương trình ưu đãi.

---

## 💻 Hướng Dẫn Chạy Trên XAMPP (Local)

Để chạy dự án trên máy tính cá nhân, hãy làm theo các bước sau:

1.  **Chuẩn bị**: Copy thư mục dự án vào `C:\xampp\htdocs\TINY-FLOWERS`.
2.  **Khởi động XAMPP**: Start **Apache** và **MySQL**.
3.  **Cấu hình .env**: 
    - Đảm bảo `SESSION_DRIVER=file` để test giao diện không cần DB.
    - Cấu hình thông tin kết nối DB tại các dòng `DB_DATABASE`, `DB_USERNAME`.
4.  **Truy cập trình duyệt**:
    - Trang chủ: `http://localhost/TINY-FLOWERS/mvc-project/public/`
    - Trang Đăng nhập: `http://localhost/TINY-FLOWERS/mvc-project/public/login`
    - Trang Đăng ký: `http://localhost/TINY-FLOWERS/mvc-project/public/register`

---

## 🌐 Triển Khai Hosting & Tên Miền (Trong Tương Lai)

Khi bạn muốn đưa cửa hàng thời trang của mình lên internet:

### 1. Chuẩn bị Hosting
- Sử dụng hosting hỗ trợ PHP 8.1+ và MySQL.
- Upload toàn bộ mã nguồn (trừ `node_modules` và `tests`).

### 2. Cấu hình Tên Miền (Domain)
- **Document Root**: Phải trỏ trực tiếp vào thư mục `/public/` của dự án để đảm bảo bảo mật mã nguồn phía sau.
- *Ví dụ:* `mensfashion.com` -> `/public_html/mvc-project/public`.

### 3. Tối ưu vận hành
- Chạy các lệnh tối ưu: `php artisan config:cache`, `php artisan route:cache`.
- Gắn **SSL** (HTTPS) là bắt buộc để khách hàng tin tưởng khi thanh toán online.

---
*Dự án được xây dựng nhằm mang lại phong cách thời trang lịch lãm cho phái mạnh.*
