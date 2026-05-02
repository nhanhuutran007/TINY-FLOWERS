# Tiny Flowers - Nền tảng thương mại điện tử thời trang Local Brand

Tiny Flowers là thương hiệu thời trang Local Brand định hướng phong cách Unisex, cung cấp các dòng sản phẩm chủ lực gồm T-shirt, Hoodie, Sweater, Quần Oversize và phụ kiện. Với triết lý "Tự do bứt phá giới hạn", thương hiệu hướng tới tệp khách hàng Gen Z năng động, yêu thích sự phá cách nhưng vẫn đề cao tính ứng dụng.

Doanh nghiệp hoạt động theo mô hình D2C (Direct-to-Consumer) thông qua nền tảng thương mại điện tử, kết hợp Social Commerce để tối ưu chi phí vận hành và tiếp cận trực tiếp khách hàng mục tiêu trên toàn quốc.

Dự án này là hệ thống web xây dựng trên Laravel 12, bao gồm giao diện cửa hàng trực tuyến dành cho khách hàng và bảng quản trị nội bộ dành cho admin/nhân viên.

---

## Mục lục

- [Yêu cầu hệ thống](#yêu-cầu-hệ-thống)
- [Tính năng](#tính-năng)
- [Cấu trúc dự án](#cấu-trúc-dự-án)
- [Hướng dẫn cài đặt](#hướng-dẫn-cài-đặt)
- [Biến môi trường](#biến-môi-trường)
- [Tài khoản mặc định](#tài-khoản-mặc-định)

---

## Yêu cầu hệ thống

- PHP >= 8.2
- Composer >= 2.x
- MySQL hoặc MariaDB >= 10.4
- Node.js >= 18.x và npm
- Web server: Apache hoặc Nginx (hoặc dùng `php artisan serve` để phát triển)

---

## Tính năng

### Phía khách hàng

- Xem danh sách sản phẩm, lọc theo danh mục, tìm kiếm theo tên hoặc mã vạch
- Xem chi tiết sản phẩm, đánh giá và xếp hạng sao
- Giỏ hàng và thanh toán (tiền mặt, QR, thẻ)
- Gửi email xác nhận đơn hàng tự động
- Đăng ký, đăng nhập bằng tài khoản thường hoặc Google OAuth
- Quản lý hồ sơ cá nhân: thông tin, địa chỉ, đổi mật khẩu, ảnh đại diện
- Xem lịch sử đơn hàng
- Danh sách yêu thích

### Phía quản trị (Admin)

- Dashboard tổng quan: doanh thu, đơn hàng, khách hàng, sản phẩm bán chạy, biểu đồ theo tháng/tuần
- Quản lý sản phẩm: thêm, sửa, xóa, upload ảnh, quản lý tồn kho
- Quản lý danh mục: phân cấp cha/con, sắp xếp thứ tự
- Quản lý đơn hàng: xem chi tiết, cập nhật trạng thái, in hóa đơn, xuất PDF
- Quản lý khách hàng: xem thông tin, khóa/mở tài khoản
- Quản lý người dùng nội bộ: thêm, sửa, xóa, phân quyền (admin/staff/customer)
- Báo cáo doanh thu: theo tháng, tháng trước, năm hiện tại, xuất PDF
- Cảnh báo tồn kho thấp và hết hàng (API JSON)

---

## Cấu trúc dự án

```
mvc-project/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Các controller xử lý logic
│   │   └── Middleware/      # Middleware kiểm tra trạng thái người dùng
│   ├── Mail/                # Mailable gửi email xác nhận đơn hàng
│   ├── Models/              # Eloquent models
│   └── Providers/
├── bootstrap/
├── config/                  # Cấu hình app, database, mail, auth, services...
├── database/
│   ├── migrations/          # Migration files
│   ├── schema.sql           # Schema database đầy đủ
│   └── seed.sql             # Dữ liệu mẫu
├── public/
│   ├── css/                 # File CSS tĩnh
│   └── images/              # Ảnh sản phẩm, avatar, banner
├── resources/
│   └── views/               # Blade templates
├── routes/
│   └── web.php              # Định nghĩa toàn bộ routes
└── .env                     # Biến môi trường (không commit lên git)
```

---

## Hướng dẫn cài đặt

### 1. Clone dự án

```bash
git clone <repository-url>
cd mvc-project
```

### 2. Cài đặt dependencies PHP

```bash
composer install
```

### 3. Cài đặt dependencies Node.js

```bash
npm install
```

### 4. Tạo file môi trường

```bash
cp .env.example .env
php artisan key:generate
```

Sau đó chỉnh sửa file `.env` theo hướng dẫn ở phần [Biến môi trường](#biến-môi-trường).

### 5. Tạo database

Tạo một database MySQL/MariaDB mới, ví dụ tên `mvc_project_db`, sau đó import schema:

```bash
mysql -u root -p mvc_project_db < database/schema.sql
```

Nếu muốn có dữ liệu mẫu:

```bash
mysql -u root -p mvc_project_db < database/seed.sql
```

Hoặc chạy migration nếu không dùng schema.sql:

```bash
php artisan migrate
```

### 6. Build assets frontend

```bash
npm run build
```

Hoặc ở chế độ phát triển (watch):

```bash
npm run dev
```

### 7. Khởi động server phát triển

```bash
php artisan serve
```

Ứng dụng sẽ chạy tại `http://localhost:8000`.

Nếu triển khai trên Apache/Nginx với thư mục gốc trỏ vào `public/`, không cần bước này.

---

## Biến môi trường

Dưới đây là toàn bộ biến môi trường được sử dụng trong dự án. Sao chép file `.env.example` thành `.env` và điền giá trị phù hợp.

### Ứng dụng

| Biến | Mô tả | Giá trị mặc định |
|---|---|---|
| `APP_NAME` | Tên ứng dụng hiển thị | `TINY FLOWERS` |
| `APP_ENV` | Môi trường chạy (`local`, `production`) | `local` |
| `APP_KEY` | Khóa mã hóa ứng dụng (tạo bằng `php artisan key:generate`) | _(trống)_ |
| `APP_DEBUG` | Bật/tắt chế độ debug | `true` |
| `APP_URL` | URL gốc của ứng dụng | `http://localhost` |
| `APP_LOCALE` | Ngôn ngữ mặc định | `en` |

### Database

| Biến | Mô tả | Giá trị mặc định |
|---|---|---|
| `DB_CONNECTION` | Loại kết nối database | `mysql` |
| `DB_HOST` | Host database | `127.0.0.1` |
| `DB_PORT` | Cổng kết nối | `3306` |
| `DB_DATABASE` | Tên database | `mvc_project_db` |
| `DB_USERNAME` | Tên đăng nhập database | `root` |
| `DB_PASSWORD` | Mật khẩu database | _(trống)_ |

### Session và Cache

| Biến | Mô tả | Giá trị mặc định |
|---|---|---|
| `SESSION_DRIVER` | Driver lưu session (`file`, `database`, `redis`) | `file` |
| `SESSION_LIFETIME` | Thời gian sống của session (phút) | `120` |
| `CACHE_STORE` | Driver cache (`file`, `redis`, `database`) | `file` |

### Email (SMTP)

Dự án sử dụng Gmail SMTP để gửi email xác nhận đơn hàng.

| Biến | Mô tả | Ví dụ |
|---|---|---|
| `MAIL_MAILER` | Driver gửi mail | `smtp` |
| `MAIL_HOST` | SMTP host | `smtp.gmail.com` |
| `MAIL_PORT` | Cổng SMTP | `465` |
| `MAIL_USERNAME` | Địa chỉ Gmail dùng để gửi | `your@gmail.com` |
| `MAIL_PASSWORD` | App Password của Gmail (không phải mật khẩu thường) | _(app password)_ |
| `MAIL_ENCRYPTION` | Kiểu mã hóa | `ssl` |
| `MAIL_FROM_ADDRESS` | Địa chỉ gửi | `your@gmail.com` |
| `MAIL_FROM_NAME` | Tên hiển thị khi gửi | `${APP_NAME}` |

> Để lấy App Password Gmail: vào Google Account > Bảo mật > Xác minh 2 bước > App passwords.

### Google OAuth

Dùng để cho phép khách hàng đăng nhập bằng tài khoản Google.

| Biến | Mô tả |
|---|---|
| `GOOGLE_CLIENT_ID` | Client ID từ Google Cloud Console |
| `GOOGLE_CLIENT_SECRET` | Client Secret từ Google Cloud Console |
| `GOOGLE_REDIRECT_URI` | URI callback sau khi xác thực (phải khớp với cấu hình trên Google Cloud) |

Ví dụ `GOOGLE_REDIRECT_URI` khi phát triển local:

```
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

Để cấu hình Google OAuth:
1. Truy cập [Google Cloud Console](https://console.cloud.google.com)
2. Tạo project mới hoặc chọn project có sẵn
3. Vào APIs & Services > Credentials > Create Credentials > OAuth 2.0 Client ID
4. Thêm URI redirect vào danh sách Authorized redirect URIs
5. Sao chép Client ID và Client Secret vào file `.env`

### Queue

| Biến | Mô tả | Giá trị mặc định |
|---|---|---|
| `QUEUE_CONNECTION` | Driver xử lý queue (`sync`, `database`, `redis`) | `sync` |

> Với `sync`, các job được xử lý ngay lập tức (phù hợp môi trường phát triển). Trên production nên dùng `database` hoặc `redis`.

### Filesystem

| Biến | Mô tả | Giá trị mặc định |
|---|---|---|
| `FILESYSTEM_DISK` | Disk lưu file mặc định | `local` |

---

## Tài khoản mặc định

Sau khi import `seed.sql`, tài khoản admin mặc định:

| Trường | Giá trị |
|---|---|
| Username | `admin` |
| Email | `admin@admin.com` |
| Mật khẩu | `admin` |

> Nên đổi mật khẩu ngay sau khi đăng nhập lần đầu.

---

## Phân quyền

Hệ thống có 3 vai trò:

- `admin` - Toàn quyền truy cập dashboard và quản trị
- `customer` - Chỉ truy cập giao diện cửa hàng và hồ sơ cá nhân
---


