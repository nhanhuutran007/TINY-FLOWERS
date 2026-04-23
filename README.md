# 🌸 TINY FLOWERS - Fashion & Streetwear Shop

**Tiny Flowers** là một nền tảng thương mại điện tử chuyên biệt về thời trang Streetwear dành cho giới trẻ (Gen Z). Dự án được xây dựng với phong cách thiết kế tối giản, hiện đại, tập trung vào trải nghiệm hình ảnh và chuyển động sinh động để thu hút khách hàng.

---

## 🚀 Tính năng nổi bật

- **Giao diện hiện đại (Modern UI):** Thiết kế theo phong cách tối giản, sử dụng hệ màu tinh tế, bo góc mềm mại và các hiệu ứng micro-interaction cao cấp.
- **Video Lookbook:** Tích hợp video thực tế giúp khách hàng cảm nhận rõ nét phom dáng và chuyển động của sản phẩm qua ống kính Cinema.
- **Style Explorer Carousel:** Thanh trượt phong cách tự động (Infinite Loop) với tính năng dừng khi di chuột, giúp khám phá đa dạng cách phối đồ.
- **Dashboard Search:** Thanh tìm kiếm thông minh được thiết kế theo phong cách quản trị hiện đại, tích hợp ngay tại header.
- **Custom Pagination:** Hệ thống phân trang được thiết kế riêng biệt, đồng bộ với phong cách tối giản của thương hiệu.
- **SEO Optimized:** Cấu trúc HTML semantic, tối ưu hóa thẻ Meta và Title cho các công cụ tìm kiếm.

---

## 📂 Cấu trúc thư mục dự án

```text
TINY-FLOWERS/
├── mvc-project/                 # Thư mục chính của mã nguồn Laravel
│   ├── app/                     # Logic nghiệp vụ (Models, Controllers, Middleware)
│   ├── config/                  # Các tệp cấu hình hệ thống
│   ├── database/                # Migrations & Seeders (Dữ liệu mẫu sản phẩm)
│   ├── public/                  # Tài nguyên công khai
│   │   ├── css/                 # Các file style (welcome.css, shop.css, ...)
│   │   ├── images/              # Kho tài nguyên hình ảnh & video đã tối ưu
│   │   │   └── source/          # Media chính thức (Lookbook, Style, Products)
│   │   └── js/                  # Các script xử lý tương tác
│   ├── resources/               # Giao diện (Blade Templates)
│   │   └── views/
│   │       ├── welcome.blade.php # Trang chủ với Lookbook & Sliders
│   │       ├── shop/            # Trang danh sách sản phẩm & lọc
│   │       └── vendor/          # Custom Pagination (custom.blade.php)
│   ├── routes/                  # Định nghĩa đường dẫn (web.php)
│   └── .env                     # Cấu hình môi trường (Database, App URL)
└── README.md                    # Tài liệu hướng dẫn dự án
```

---

## 🛠 Công nghệ sử dụng

- **Backend:** PHP 8.x, Laravel Framework.
- **Database:** MySQL / MariaDB.
- **Frontend:** HTML5, CSS3 (Vanilla CSS), JavaScript (Vanilla JS).
- **Icons:** Font Awesome 6.
- **Fonts:** Google Fonts (Inter).

---

## 🔧 Hướng dẫn cài đặt

1. **Clone dự án:**
   ```bash
   git clone https://github.com/nhanhuutran007/TINY-FLOWERS.git
   ```

2. **Cấu hình môi trường:**
   - Di chuyển vào thư mục `mvc-project`.
   - Copy file `.env.example` thành `.env`.
   - Cấu hình thông tin Database (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

3. **Cài đặt thư viện:**
   ```bash
   composer install
   npm install && npm run dev
   ```

4. **Khởi tạo dữ liệu mẫu:**
   ```bash
   php artisan migrate --seed
   ```

5. **Chạy server:**
   ```bash
   php artisan serve
   ```

---

## 🖼 Quản lý Media

Dự án sử dụng cấu trúc thư mục Media đã được tối ưu hóa tại `public/images/source/`:
- **Products:** Phân loại theo mã form (F1, F2, F5).
- **VideoLookbook:** Các tệp video mp4 chất lượng cao.
- **WeekendVibesSection:** Ảnh đại diện cho các phong cách Minimalism, Relax, Sport.
- **StyleSetSection:** Các bộ phối đồ thực tế.

---

## ✍️ Tác giả
Dự án được phát triển bởi **nhanhuutran007** với tâm huyết mang lại một làn gió mới cho thời trang Streetwear Việt Nam.

---
*&copy; 2026 Tiny Flowers. All rights reserved. Made with ❤️ in Vietnam.*
