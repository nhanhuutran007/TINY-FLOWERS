-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 25, 2026 lúc 06:33 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `mvc_project_db`
--

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Áo Sơ Mi', 'Các loại áo sơ mi nam cao cấp', NULL, '2026-04-23 16:09:49', '2026-04-23 16:09:49'),
(2, 'Quần Tây', 'Quần tây công sở, slim fit', NULL, '2026-04-23 16:09:49', '2026-04-23 16:09:49'),
(3, 'Phụ Kiện', 'Thắt lưng, ví da, cà vạt', NULL, '2026-04-23 16:09:49', '2026-04-23 16:09:49'),
(4, 'Vest', 'Bộ vest complet sang trọng', NULL, '2026-04-23 16:09:49', '2026-04-23 16:09:49'),
(5, 'Áo Khoác', NULL, NULL, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(6, 'Áo Thun', NULL, NULL, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(7, 'Áo Polo', NULL, NULL, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(8, 'Tank Top', NULL, NULL, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(9, 'Form Oversized', NULL, NULL, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(10, 'Quần', NULL, NULL, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(11, 'Quần Jean', NULL, NULL, '2026-04-23 17:00:30', '2026-04-23 17:00:30');

--
-- Đang đổ dữ liệu cho bảng `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `email`, `address`, `total_spent`, `created_at`, `updated_at`) VALUES
(1, 'Nguyễn Văn A', '0912345678', 'nguyenvana@example.com', 'Hà Nội', 1300000.00, '2026-04-23 16:09:49', '2026-04-23 16:09:49'),
(2, 'Trần Thị B', '0987654321', 'tranthib@example.com', 'TP. HCM', 450000.00, '2026-04-23 16:09:49', '2026-04-23 16:09:49');

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_20_072429_create_categories_table', 1),
(5, '2026_04_20_072429_create_customers_table', 1),
(6, '2026_04_20_072430_create_products_table', 1),
(7, '2026_04_20_072431_create_activity_logs_table', 1),
(8, '2026_04_23_155828_create_orders_table', 1),
(9, '2026_04_23_155834_create_order_items_table', 1),
(10, '2026_04_24_174038_add_phone_and_address_to_users_table', 2),
(11, '2026_04_24_183404_add_parent_id_to_categories_table', 2),
(12, '2026_04_24_194149_create_reviews_table', 2),
(13, '2026_04_24_195659_create_favorites_table', 2),
(14, '2026_04_25_151200_add_missing_fields_to_orders_table', 3),
(15, '2026_04_25_151700_add_email_to_customers_table', 4),
(16, '2026_04_25_171138_make_user_id_nullable_in_orders_table', 5);

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `customer_id`, `user_id`, `subtotal`, `discount`, `shipping_fee`, `total_amount`, `amount_paid`, `change_amount`, `payment_method`, `payment_status`, `transaction_id`, `shipping_address`, `notes`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ORD-001', 1, 1, 1300000.00, 0.00, 0.00, 1300000.00, 1500000.00, 200000.00, 'cash', 'paid', NULL, NULL, NULL, 'completed', '2026-04-21 16:09:49', '2026-04-23 16:09:49'),
(2, 'ORD-002', 2, 1, 450000.00, 0.00, 0.00, 450000.00, 450000.00, 0.00, 'transfer', 'paid', 'TRX-1234', NULL, NULL, 'completed', '2026-04-22 16:09:49', '2026-04-23 16:09:49');

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `cost_price`, `selling_price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Áo Sơ Mi Oxford Trắng', 350000.00, 550000.00, 1, 550000.00, '2026-04-23 16:09:49', '2026-04-23 16:09:49'),
(2, 1, 2, 'Quần Tây Slim Fit Đen', 450000.00, 750000.00, 1, 750000.00, '2026-04-23 16:09:49', '2026-04-23 16:09:49'),
(3, 2, 3, 'Thắt Lưng Da Bò Thật', 250000.00, 450000.00, 1, 450000.00, '2026-04-23 16:09:49', '2026-04-23 16:09:49');

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `barcode`, `name`, `category_id`, `cost_price`, `selling_price`, `material`, `image`, `stock_quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SP001', 'Áo Sơ Mi Oxford Trắng', 1, 350000.00, 550000.00, 'Cotton Oxford', 'p1.png', 50, 1, '2026-04-23 16:09:49', '2026-04-23 16:09:49'),
(2, 'SP002', 'Quần Tây Slim Fit Đen', 2, 450000.00, 750000.00, 'Wool Blend', 'p2.png', 30, 1, '2026-04-23 16:09:49', '2026-04-23 16:09:49'),
(3, 'SP003', 'Thắt Lưng Da Bò Thật', 3, 250000.00, 450000.00, 'Leather', 'p4.png', 100, 1, '2026-04-23 16:09:49', '2026-04-23 16:09:49'),
(4, 'J1', 'Áo Khoác Dù Parachute Bụi Bặm', 5, 135100.00, 193000.00, 'Premium Fabric', 'source/SalePage/j1.png', 82, 1, '2026-04-23 17:00:30', '2026-04-24 08:31:12'),
(5, 'J2', 'Áo Khoác Gió Form Boxy Phối Trắng', 5, 147000.00, 210000.00, 'Premium Fabric', 'source/SalePage/j2.png', 64, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(6, 'J3', 'Áo Khoác Chống Nắng UV Phom Rộng', 5, 129500.00, 185000.00, 'Premium Fabric', 'source/SalePage/j3.png', 12, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(7, 'J4', 'Áo Khoác Nhẹ Cổ Đứng Minimal', 5, 154000.00, 220000.00, 'Premium Fabric', 'source/SalePage/j4.png', 22, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(8, 'J5', 'Áo Khoác Denim Đen Wash Rách', 5, 175000.00, 250000.00, 'Premium Fabric', 'source/SalePage/j5.png', 64, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(9, 'J6', 'Áo Khoác Bomber Da PU Cao Cấp', 5, 224000.00, 320000.00, 'Premium Fabric', 'source/SalePage/j6.png', 48, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(10, 'J7', 'Áo Khoác Nỉ Form Thụng Varsity', 5, 139300.00, 199000.00, 'Premium Fabric', 'source/SalePage/j7.png', 95, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(11, 'J8', 'Jacket Kaki Mỏng Mùa Thu Nhẹ Nhàng', 5, 150500.00, 215000.00, 'Premium Fabric', 'source/SalePage/j8.png', 69, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(12, 'T1', 'Áo Thun Cotton Mát Lạnh Thoáng Khí', 6, 69300.00, 99000.00, 'Premium Fabric', 'source/SalePage/t1.png', 42, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(13, 'T2', 'Áo Baby Tee Thêu Logo Nổi Bật', 6, 84000.00, 120000.00, 'Premium Fabric', 'source/SalePage/t2.png', 48, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(14, 'T3', 'Áo Thun Drop Shoulder Dáng Thụng', 6, 104300.00, 149000.00, 'Premium Fabric', 'source/SalePage/t3.png', 76, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(15, 'T4', 'Áo Thun Wash Bụi Phong Cách Đường Phố', 6, 118300.00, 169000.00, 'Premium Fabric', 'source/SalePage/t4.png', 11, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(16, 'T5', 'Polo Zip Vải Mắt Chim Hút Mồ Hôi', 7, 108500.00, 155000.00, 'Premium Fabric', 'source/SalePage/t5.png', 90, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(17, 'T6', 'Áo Thun Graphic In Nổi Y2K', 6, 94500.00, 135000.00, 'Premium Fabric', 'source/SalePage/t6.png', 51, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(18, 'T7', 'Tank Top Thể Thao Siêu Nhẹ', 8, 62300.00, 89000.00, 'Premium Fabric', 'source/SalePage/t7.png', 62, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(19, 'T8', 'Áo Thun Trơn Basic Dễ Phối Đồ', 6, 77000.00, 110000.00, 'Premium Fabric', 'source/SalePage/t8.png', 32, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(20, 'F101', 'Áo Cardigan Oversize Wash Bụi', 9, 245000.00, 350000.00, 'Premium Fabric', 'source/Products/F1/1.png', 50, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(21, 'F102', 'Hoodie Khổng Lồ Zip Local Brand', 9, 294000.00, 420000.00, 'Premium Fabric', 'source/Products/F1/2.png', 25, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(22, 'F103', 'Quần Hộp Oversize Trượt Ván', 10, 203000.00, 290000.00, 'Premium Fabric', 'source/Products/F1/3.png', 36, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(23, 'F104', 'Áo Len Thủng Oversize Y2K', 9, 245000.00, 350000.00, 'Premium Fabric', 'source/Products/F1/4.png', 80, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(24, 'F105', 'Sơ Mi Flannel Kẻ Caro Form Rộng', 1, 196000.00, 280000.00, 'Premium Fabric', 'source/Products/F1/5.png', 65, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(25, 'F106', 'Quần Tây Oversize', 10, 266000.00, 380000.00, 'Premium Fabric', 'source/Products/F1/6.png', 74, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(26, 'F107', 'Áo Bóng Rổ Layer Phom Rộng', 9, 147000.00, 210000.00, 'Premium Fabric', 'source/Products/F1/7.png', 92, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(27, 'F108', 'Quần Jean Rách Gối Siêu Thụng', 11, 273000.00, 390000.00, 'Premium Fabric', 'source/Products/F1/8.png', 59, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(28, 'F201', 'Quần Jean Baggy Cào Xước', 11, 245000.00, 350000.00, 'Premium Fabric', 'source/Products/F2/1.png', 63, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(29, 'F202', 'Quần Kaki Baggy Túi Hộp Lớn', 10, 224000.00, 320000.00, 'Premium Fabric', 'source/Products/F2/2.png', 84, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(30, 'F203', 'Quần Đùi Baggy Jean Jorts', 11, 196000.00, 280000.00, 'Premium Fabric', 'source/Products/F2/3.png', 14, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(31, 'F204', 'Sơ Mi Denim Dáng Baggy', 1, 217000.00, 310000.00, 'Premium Fabric', 'source/Products/F2/4.png', 85, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(32, 'F205', 'Áo Thun Rộng Phối Tay Đôi', 6, 133000.00, 190000.00, 'Premium Fabric', 'source/Products/F2/5.png', 14, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(33, 'F206', 'Quần Nhung Tăm Corduroy Baggy', 10, 238000.00, 340000.00, 'Premium Fabric', 'source/Products/F2/6.png', 91, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(34, 'F207', 'Quần Dù Parachute Xếp Ly Gối', 10, 252000.00, 360000.00, 'Premium Fabric', 'source/Products/F2/7.png', 71, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(35, 'F208', 'Áo Khoác Kaki Bụi Bặm Dáng Thụng', 5, 315000.00, 450000.00, 'Premium Fabric', 'source/Products/F2/8.png', 16, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(36, 'F501', 'Áo Thun Phom Boxy Trơn', 6, 147000.00, 210000.00, 'Premium Fabric', 'source/Products/F5/1.png', 31, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30'),
(37, 'F503', 'Jacket Kaki Boxy Zip Hai Chiều', 5, 287000.00, 410000.00, 'Premium Fabric', 'source/Products/F5/3.png', 57, 1, '2026-04-23 17:00:30', '2026-04-23 17:00:30');

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `fullname`, `email`, `email_verified_at`, `password`, `role`, `status`, `is_active`, `must_change_password`, `profile_picture`, `activation_token`, `token_expiry`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin User', 'admin@admin.com', NULL, '$2y$12$.wmIovqQi02VgzT0iDwfZeTI5YXLhu4GfpZZcPQmEVXk3UJtsODeK', 'admin', 'active', 1, 0, NULL, NULL, NULL, NULL, '2026-04-23 16:09:49', '2026-04-23 17:00:30');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
