-- MySQL dump 10.13  Distrib 8.4.8, for Linux (x86_64)
--
-- Host: localhost    Database: mvc_project_db
-- ------------------------------------------------------
-- Server version	8.4.8-0ubuntu1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'parent',
  `position` int NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,14,'child',0,'Áo Sơ Mi','Các loại áo sơ mi nam cao cấp',NULL,'2026-04-23 09:09:49','2026-05-01 23:19:31'),(2,10,'child',0,'Quần Tây','Quần tây công sở, slim fit',NULL,'2026-04-23 09:09:49','2026-05-01 23:20:35'),(3,NULL,'parent',2,'Phụ Kiện','Thắt lưng, ví da, cà vạt',NULL,'2026-04-23 09:09:49','2026-05-06 15:21:10'),(4,14,'child',0,'Vest','Bộ vest complet sang trọng',NULL,'2026-04-23 09:09:49','2026-05-01 23:20:17'),(5,14,'child',0,'Áo Khoác',NULL,NULL,'2026-04-23 10:00:30','2026-05-01 23:19:43'),(6,14,'child',0,'Áo Thun',NULL,NULL,'2026-04-23 10:00:30','2026-05-01 23:19:52'),(7,14,'child',0,'Áo Polo',NULL,NULL,'2026-04-23 10:00:30','2026-05-01 23:19:59'),(8,10,'child',0,'Tank Top',NULL,NULL,'2026-04-23 10:00:30','2026-05-01 23:20:42'),(9,14,'child',0,'Form Oversized',NULL,NULL,'2026-04-23 10:00:30','2026-05-01 23:20:49'),(10,NULL,'parent',1,'Quần',NULL,NULL,'2026-04-23 10:00:30','2026-05-06 15:21:10'),(11,10,'child',0,'Quần Jean',NULL,NULL,'2026-04-23 10:00:30','2026-05-01 23:20:57'),(12,3,'child',0,'thắt lưng',NULL,NULL,'2026-05-01 14:53:39','2026-05-01 23:21:05'),(14,NULL,'parent',0,'Áo',NULL,NULL,'2026-05-01 23:19:21','2026-05-06 15:21:10'),(15,NULL,'parent',3,'Bộ Sưu Tập','Các bộ sưu tập thời trang mới nhất',NULL,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(16,15,'child',0,'Style Sets','Set đồ phối sẵn cực chất',NULL,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(17,15,'child',0,'Weekend Vibes','Trang phục dạo phố cuối tuần',NULL,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(18,15,'child',0,'Sport Active','Đồ thể thao năng động',NULL,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(19,15,'child',0,'Minimalist Style','Phong cách tối giản tinh tế',NULL,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(20,15,'child',0,'Relax & Homewear','Trang phục mặc nhà thoải mái',NULL,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(21,15,'child',0,'Sale Banners','Các sản phẩm ưu đãi đặc biệt',NULL,'2026-05-08 22:30:00','2026-05-08 22:30:00');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_spent` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_phone_unique` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'Nguyễn Văn A',NULL,'0912345678','Hà Nội',1300000.00,'2026-04-23 09:09:49','2026-04-23 09:09:49'),(2,'Trần Thị B',NULL,'0987654321','TP. HCM',450000.00,'2026-04-23 09:09:49','2026-04-23 09:09:49'),(3,'Trần Hữu Nhân','nhanhuutran007@gmail.com','0869918250','Ấp bình hòa xã bình thạnh huyện lấp vò tỉnh đồng tháp, Tỉnh đồng tháp 81000, Vietnam',7064000.00,'2026-04-25 07:56:51','2026-04-30 21:54:48'),(4,'X','user1@example.com','0909175160','ggg, hv 3, Vietnam',1005000.00,'2026-05-01 00:06:01','2026-05-01 19:57:17'),(5,'Tran Huu Nhan','nhanhuutran007@gmail.com','0869918255','19 Nguyễn Hữu Thọ, phường Tân Hưng, TP. Hồ Chí Minh, Hồ chí minh 7000, Vietnam',223000.00,'2026-05-02 07:34:50','2026-05-02 07:34:50'),(6,'Trần Hữu Nhân','nhanhuutran009@gmail.com','08699133333','Ấp bình hòa xã bình thạnh, Tỉnh đồng tháp 81000, Vietnam',1699000.00,'2026-05-02 13:34:38','2026-05-05 16:20:10');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favorites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorites`
--

LOCK TABLES `favorites` WRITE;
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
INSERT INTO `favorites` VALUES (38,4,4,'2026-04-28 08:38:22','2026-04-28 08:38:22'),(39,3,4,'2026-04-28 09:13:18','2026-04-28 09:13:18'),(40,3,22,'2026-04-30 14:38:32','2026-04-30 14:38:32'),(42,5,6,'2026-05-01 14:45:15','2026-05-01 14:45:15'),(45,3,5,'2026-05-04 17:17:50','2026-05-04 17:17:50');
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_04_20_072429_create_categories_table',1),(5,'2026_04_20_072429_create_customers_table',1),(6,'2026_04_20_072430_create_products_table',1),(7,'2026_04_20_072431_create_activity_logs_table',1),(8,'2026_04_23_155828_create_orders_table',1),(9,'2026_04_23_155834_create_order_items_table',1),(10,'2026_04_24_174038_add_phone_and_address_to_users_table',2),(11,'2026_04_24_183404_add_parent_id_to_categories_table',2),(12,'2026_04_24_194149_create_reviews_table',2),(13,'2026_04_24_195659_create_favorites_table',2),(14,'2026_04_25_151200_add_missing_fields_to_orders_table',3),(15,'2026_04_25_151700_add_email_to_customers_table',4),(16,'2026_04_25_171138_make_user_id_nullable_in_orders_table',5),(17,'2026_04_28_000001_add_google_id_to_users_table',6),(18,'2026_04_30_221645_add_description_to_products_table',7),(19,'2026_05_01_225756_add_type_to_categories_table',8),(20,'2026_05_01_234328_add_position_to_categories_table',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost_price` decimal(15,2) NOT NULL,
  `selling_price` decimal(15,2) NOT NULL,
  `quantity` int NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `size` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (4,3,5,'Áo Khoác Gió Form Boxy Phối Trắng',147000.00,210000.00,1,210000.00,NULL,'2026-04-25 10:13:01','2026-04-25 10:13:01'),(5,4,4,'Áo Khoác Dù Parachute Bội Bặm',135100.00,193000.00,1,193000.00,NULL,'2026-04-25 11:36:29','2026-04-25 11:36:29'),(6,5,22,'Quần Hộp Oversize Trượt Ván',203000.00,290000.00,1,290000.00,NULL,'2026-04-25 11:57:05','2026-04-25 11:57:05'),(7,6,4,'Áo Khoác Dù Parachute Bội Bặm',135100.00,193000.00,1,193000.00,NULL,'2026-04-26 08:22:29','2026-04-26 08:22:29'),(8,7,4,'Áo Khoác Dù Parachute Bội Bặm',135100.00,193000.00,2,386000.00,NULL,'2026-04-28 08:38:59','2026-04-28 08:38:59'),(9,8,4,'Áo Khoác Dù Parachute Bội Bặm',135100.00,193000.00,1,193000.00,NULL,'2026-04-28 09:35:14','2026-04-28 09:35:14'),(10,9,4,'Áo Khoác Dù Parachute Bội Bặm',135100.00,193000.00,3,579000.00,NULL,'2026-04-29 14:03:18','2026-04-29 14:03:18'),(11,10,5,'Áo Khoác Gió Form Boxy Phối Trắng',147000.00,210000.00,1,210000.00,NULL,'2026-04-29 14:06:09','2026-04-29 14:06:09'),(12,10,6,'Áo Khoác Chống Nắng UV Phom Rộng',129500.00,185000.00,1,185000.00,NULL,'2026-04-29 14:06:09','2026-04-29 14:06:09'),(13,10,22,'Quần Hộp Oversize Trượt Ván',203000.00,290000.00,1,290000.00,NULL,'2026-04-29 14:06:09','2026-04-29 14:06:09'),(14,10,25,'Quần Tây Oversize',266000.00,380000.00,1,380000.00,NULL,'2026-04-29 14:06:09','2026-04-29 14:06:09'),(15,10,1,'Áo Sơ Mi Oxford Trắng',350000.00,550000.00,1,550000.00,NULL,'2026-04-29 14:06:09','2026-04-29 14:06:09'),(16,10,2,'Quần Tây Slim Fit Đen',450000.00,750000.00,1,750000.00,NULL,'2026-04-29 14:06:09','2026-04-29 14:06:09'),(17,10,3,'Thắt Lưng Da Bò Thật',250000.00,450000.00,1,450000.00,NULL,'2026-04-29 14:06:09','2026-04-29 14:06:09'),(18,11,1,'Áo Sơ Mi Oxford Trắng',350000.00,550000.00,1,550000.00,NULL,'2026-04-29 15:59:58','2026-04-29 15:59:58'),(19,12,3,'Thắt Lưng Da Bò Thật',250000.00,450000.00,1,450000.00,NULL,'2026-04-29 16:02:08','2026-04-29 16:02:08'),(20,13,3,'Thắt Lưng Da Bò Thật',250000.00,450000.00,1,450000.00,NULL,'2026-04-30 13:16:28','2026-04-30 13:16:28'),(21,14,5,'Áo Khoác Gió Form Boxy Phối Trắng',147000.00,210000.00,1,210000.00,NULL,'2026-04-30 13:18:20','2026-04-30 13:18:20'),(22,15,6,'Áo Khoác Chống Nắng UV Phom Rộng',129500.00,185000.00,1,185000.00,NULL,'2026-04-30 21:54:48','2026-04-30 21:54:48'),(23,16,5,'Áo Khoác Gió Form Boxy Phối Trắng',147000.00,210000.00,1,210000.00,NULL,'2026-05-01 00:06:01','2026-05-01 00:06:01'),(24,17,6,'Áo Khoác Chống Nắng UV Phom Rộng',129500.00,185000.00,1,185000.00,NULL,'2026-05-01 19:57:17','2026-05-01 19:57:17'),(25,17,1,'Áo Sơ Mi Oxford Trắng',350000.00,550000.00,1,550000.00,NULL,'2026-05-01 19:57:17','2026-05-01 19:57:17'),(26,18,4,'Áo Khoác Dù Parachute Bội Bặm',135100.00,193000.00,1,193000.00,NULL,'2026-05-02 07:34:50','2026-05-02 07:34:50'),(27,19,4,'Áo Khoác Dù Parachute Bội Bặm',135100.00,193000.00,1,193000.00,NULL,'2026-05-02 13:34:38','2026-05-02 13:34:38'),(28,20,4,'Áo Khoác Dù Parachute Bội Bặm',135100.00,193000.00,1,193000.00,NULL,'2026-05-04 16:33:41','2026-05-04 16:33:41'),(29,20,6,'Áo Khoác Chống Nắng UV Phom Rộng',129500.00,185000.00,1,185000.00,NULL,'2026-05-04 16:33:41','2026-05-04 16:33:41'),(30,21,5,'Áo Khoác Gió Form Boxy Phối Trắng',147000.00,210000.00,2,420000.00,NULL,'2026-05-04 17:20:00','2026-05-04 17:20:00'),(31,21,6,'Áo Khoác Chống Nắng UV Phom Rộng',129500.00,185000.00,1,185000.00,NULL,'2026-05-04 17:20:00','2026-05-04 17:20:00'),(32,22,4,'Áo Khoác Dù Parachute Bội Bặm',135100.00,193000.00,1,193000.00,NULL,'2026-05-05 16:20:10','2026-05-05 16:20:10'),(33,22,5,'Áo Khoác Gió Form Boxy Phối Trắng',147000.00,210000.00,1,210000.00,NULL,'2026-05-05 16:20:10','2026-05-05 16:20:10'),(34,23,4,'Áo Khoác Dù Parachute Bội Bặm',135100.00,193000.00,1,193000.00,NULL,'2026-01-10 19:08:00','2026-01-10 19:08:00'),(35,23,22,'Quần Hộp Oversize Trượt Ván',203000.00,290000.00,2,580000.00,NULL,'2026-01-10 19:08:00','2026-01-10 19:08:00'),(36,23,45,'Áo Khoác Dạo Phố Weekend',150000.00,280000.00,2,560000.00,NULL,'2026-01-10 19:08:00','2026-01-10 19:08:00'),(37,24,2,'Quần Tây Slim Fit Đen',450000.00,750000.00,1,750000.00,NULL,'2026-01-04 11:04:00','2026-01-04 11:04:00'),(38,25,1,'Áo Sơ Mi Oxford Trắng',350000.00,550000.00,2,1100000.00,NULL,'2026-01-14 11:01:00','2026-01-14 11:01:00'),(39,25,68,'Đồ Mặc Nhà Relax v1',180000.00,320000.00,2,640000.00,NULL,'2026-01-14 11:01:00','2026-01-14 11:01:00'),(40,26,1,'Áo Sơ Mi Oxford Trắng',350000.00,550000.00,1,550000.00,NULL,'2026-01-18 10:08:00','2026-01-18 10:08:00'),(41,26,48,'Đồ Tập Gym Năng Động v1',220000.00,390000.00,1,390000.00,NULL,'2026-01-18 10:08:00','2026-01-18 10:08:00'),(42,27,4,'Áo Khoác Dù Parachute Bội Bặm',135100.00,193000.00,1,193000.00,NULL,'2026-01-20 16:33:00','2026-01-20 16:33:00'),(43,27,48,'Đồ Tập Gym Năng Động v1',220000.00,390000.00,2,780000.00,NULL,'2026-01-20 16:33:00','2026-01-20 16:33:00'),(44,27,68,'Đồ Mặc Nhà Relax v1',180000.00,320000.00,1,320000.00,NULL,'2026-01-20 16:33:00','2026-01-20 16:33:00'),(45,28,5,'Áo Khoác Gió Form Boxy Phối Trắng',147000.00,210000.00,1,210000.00,NULL,'2026-02-15 12:33:00','2026-02-15 12:33:00'),(46,28,4,'Áo Khoác Dù Parachute Bội Bặm',135100.00,193000.00,1,193000.00,NULL,'2026-02-15 12:33:00','2026-02-15 12:33:00'),(47,28,38,'Set Đồ Urban Style',300000.00,550000.00,1,550000.00,NULL,'2026-02-15 12:33:00','2026-02-15 12:33:00'),(48,29,45,'Áo Khoác Dạo Phố Weekend',150000.00,280000.00,1,280000.00,NULL,'2026-02-08 12:31:00','2026-02-08 12:31:00'),(49,30,38,'Set Đồ Urban Style',300000.00,550000.00,1,550000.00,NULL,'2026-02-07 09:44:00','2026-02-07 09:44:00'),(50,30,58,'Áo Minimalist Basic v1',120000.00,220000.00,2,440000.00,NULL,'2026-02-07 09:44:00','2026-02-07 09:44:00'),(51,30,5,'Áo Khoác Gió Form Boxy Phối Trắng',147000.00,210000.00,2,420000.00,NULL,'2026-02-07 09:44:00','2026-02-07 09:44:00'),(52,31,68,'Đồ Mặc Nhà Relax v1',180000.00,320000.00,1,320000.00,NULL,'2026-02-19 15:48:00','2026-02-19 15:48:00'),(53,32,68,'Đồ Mặc Nhà Relax v1',180000.00,320000.00,1,320000.00,NULL,'2026-02-16 10:24:00','2026-02-16 10:24:00'),(54,32,22,'Quần Hộp Oversize Trượt Ván',203000.00,290000.00,1,290000.00,NULL,'2026-02-16 10:24:00','2026-02-16 10:24:00'),(55,33,5,'Áo Khoác Gió Form Boxy Phối Trắng',147000.00,210000.00,2,420000.00,NULL,'2026-02-11 13:40:00','2026-02-11 13:40:00'),(56,33,1,'Áo Sơ Mi Oxford Trắng',350000.00,550000.00,2,1100000.00,NULL,'2026-02-11 13:40:00','2026-02-11 13:40:00'),(57,33,58,'Áo Minimalist Basic v1',120000.00,220000.00,1,220000.00,NULL,'2026-02-11 13:40:00','2026-02-11 13:40:00'),(58,34,2,'Quần Tây Slim Fit Đen',450000.00,750000.00,1,750000.00,NULL,'2026-02-14 17:56:00','2026-02-14 17:56:00'),(59,34,4,'Áo Khoác Dù Parachute Bội Bặm',135100.00,193000.00,1,193000.00,NULL,'2026-02-14 17:56:00','2026-02-14 17:56:00'),(60,35,58,'Áo Minimalist Basic v1',120000.00,220000.00,2,440000.00,NULL,'2026-02-17 18:56:00','2026-02-17 18:56:00'),(61,35,45,'Áo Khoác Dạo Phố Weekend',150000.00,280000.00,2,560000.00,NULL,'2026-02-17 18:56:00','2026-02-17 18:56:00'),(62,36,38,'Set Đồ Urban Style',300000.00,550000.00,2,1100000.00,NULL,'2026-03-01 20:14:00','2026-03-01 20:14:00'),(63,37,4,'Áo Khoác Dù Parachute Bội Bặm',135100.00,193000.00,1,193000.00,NULL,'2026-03-13 18:26:00','2026-03-13 18:26:00'),(64,37,45,'Áo Khoác Dạo Phố Weekend',150000.00,280000.00,2,560000.00,NULL,'2026-03-13 18:26:00','2026-03-13 18:26:00'),(65,37,68,'Đồ Mặc Nhà Relax v1',180000.00,320000.00,2,640000.00,NULL,'2026-03-13 18:26:00','2026-03-13 18:26:00'),(66,38,58,'Áo Minimalist Basic v1',120000.00,220000.00,1,220000.00,NULL,'2026-03-26 19:44:00','2026-03-26 19:44:00'),(67,38,48,'Đồ Tập Gym Năng Động v1',220000.00,390000.00,1,390000.00,NULL,'2026-03-26 19:44:00','2026-03-26 19:44:00'),(68,39,48,'Đồ Tập Gym Năng Động v1',220000.00,390000.00,2,780000.00,NULL,'2026-03-03 12:20:00','2026-03-03 12:20:00'),(69,39,1,'Áo Sơ Mi Oxford Trắng',350000.00,550000.00,1,550000.00,NULL,'2026-03-03 12:20:00','2026-03-03 12:20:00'),(70,40,4,'Áo Khoác Dù Parachute Bội Bặm',135100.00,193000.00,1,193000.00,NULL,'2026-03-23 17:26:00','2026-03-23 17:26:00'),(71,41,48,'Đồ Tập Gym Năng Động v1',220000.00,390000.00,1,390000.00,NULL,'2026-03-21 20:17:00','2026-03-21 20:17:00'),(72,42,22,'Quần Hộp Oversize Trượt Ván',203000.00,290000.00,2,580000.00,NULL,'2026-03-21 14:46:00','2026-03-21 14:46:00'),(73,42,38,'Set Đồ Urban Style',300000.00,550000.00,2,1100000.00,NULL,'2026-03-21 14:46:00','2026-03-21 14:46:00'),(74,42,58,'Áo Minimalist Basic v1',120000.00,220000.00,2,440000.00,NULL,'2026-03-21 14:46:00','2026-03-21 14:46:00'),(75,43,1,'Áo Sơ Mi Oxford Trắng',350000.00,550000.00,2,1100000.00,NULL,'2026-03-25 21:28:00','2026-03-25 21:28:00'),(76,44,22,'Quần Hộp Oversize Trượt Ván',203000.00,290000.00,2,580000.00,NULL,'2026-03-14 15:06:00','2026-03-14 15:06:00'),(77,44,45,'Áo Khoác Dạo Phố Weekend',150000.00,280000.00,2,560000.00,NULL,'2026-03-14 15:06:00','2026-03-14 15:06:00'),(78,45,38,'Set Đồ Urban Style',300000.00,550000.00,2,1100000.00,NULL,'2026-03-14 09:08:00','2026-03-14 09:08:00'),(79,45,58,'Áo Minimalist Basic v1',120000.00,220000.00,2,440000.00,NULL,'2026-03-14 09:08:00','2026-03-14 09:08:00'),(80,46,58,'Áo Minimalist Basic v1',120000.00,220000.00,2,440000.00,NULL,'2026-03-26 21:16:00','2026-03-26 21:16:00'),(81,46,22,'Quần Hộp Oversize Trượt Ván',203000.00,290000.00,2,580000.00,NULL,'2026-03-26 21:16:00','2026-03-26 21:16:00'),(82,47,22,'Quần Hộp Oversize Trượt Ván',203000.00,290000.00,1,290000.00,NULL,'2026-03-13 10:26:00','2026-03-13 10:26:00'),(83,48,48,'Đồ Tập Gym Năng Động v1',220000.00,390000.00,1,390000.00,NULL,'2026-04-25 17:50:00','2026-04-25 17:50:00'),(84,48,4,'Áo Khoác Dù Parachute Bội Bặm',135100.00,193000.00,1,193000.00,NULL,'2026-04-25 17:50:00','2026-04-25 17:50:00'),(85,49,22,'Quần Hộp Oversize Trượt Ván',203000.00,290000.00,1,290000.00,NULL,'2026-04-13 15:45:00','2026-04-13 15:45:00'),(86,50,5,'Áo Khoác Gió Form Boxy Phối Trắng',147000.00,210000.00,1,210000.00,NULL,'2026-04-08 15:59:00','2026-04-08 15:59:00'),(87,50,45,'Áo Khoác Dạo Phố Weekend',150000.00,280000.00,1,280000.00,NULL,'2026-04-08 15:59:00','2026-04-08 15:59:00'),(88,51,1,'Áo Sơ Mi Oxford Trắng',350000.00,550000.00,1,550000.00,NULL,'2026-04-13 09:23:00','2026-04-13 09:23:00'),(89,51,68,'Đồ Mặc Nhà Relax v1',180000.00,320000.00,1,320000.00,NULL,'2026-04-13 09:23:00','2026-04-13 09:23:00'),(90,52,4,'Áo Khoác Dù Parachute Bội Bặm',135100.00,193000.00,2,386000.00,NULL,'2026-04-15 10:09:00','2026-04-15 10:09:00'),(91,53,2,'Quần Tây Slim Fit Đen',450000.00,750000.00,1,750000.00,NULL,'2026-04-20 15:58:00','2026-04-20 15:58:00'),(92,53,48,'Đồ Tập Gym Năng Động v1',220000.00,390000.00,1,390000.00,NULL,'2026-04-20 15:58:00','2026-04-20 15:58:00'),(93,53,38,'Set Đồ Urban Style',300000.00,550000.00,1,550000.00,NULL,'2026-04-20 15:58:00','2026-04-20 15:58:00'),(94,54,1,'Áo Sơ Mi Oxford Trắng',350000.00,550000.00,2,1100000.00,NULL,'2026-04-15 17:19:00','2026-04-15 17:19:00'),(95,55,68,'Đồ Mặc Nhà Relax v1',180000.00,320000.00,2,640000.00,NULL,'2026-04-19 19:30:00','2026-04-19 19:30:00'),(96,55,22,'Quần Hộp Oversize Trượt Ván',203000.00,290000.00,2,580000.00,NULL,'2026-04-19 19:30:00','2026-04-19 19:30:00'),(97,55,45,'Áo Khoác Dạo Phố Weekend',150000.00,280000.00,2,560000.00,NULL,'2026-04-19 19:30:00','2026-04-19 19:30:00'),(98,56,2,'Quần Tây Slim Fit Đen',450000.00,750000.00,2,1500000.00,NULL,'2026-04-10 11:07:00','2026-04-10 11:07:00'),(99,56,48,'Đồ Tập Gym Năng Động v1',220000.00,390000.00,2,780000.00,NULL,'2026-04-10 11:07:00','2026-04-10 11:07:00'),(100,56,5,'Áo Khoác Gió Form Boxy Phối Trắng',147000.00,210000.00,2,420000.00,NULL,'2026-04-10 11:07:00','2026-04-10 11:07:00'),(101,57,68,'Đồ Mặc Nhà Relax v1',180000.00,320000.00,2,640000.00,NULL,'2026-04-16 15:50:00','2026-04-16 15:50:00'),(102,58,5,'Áo Khoác Gió Form Boxy Phối Trắng',147000.00,210000.00,1,210000.00,NULL,'2026-04-24 16:51:00','2026-04-24 16:51:00'),(103,59,5,'Áo Khoác Gió Form Boxy Phối Trắng',147000.00,210000.00,1,210000.00,NULL,'2026-04-10 09:36:00','2026-04-10 09:36:00'),(104,59,68,'Đồ Mặc Nhà Relax v1',180000.00,320000.00,2,640000.00,NULL,'2026-04-10 09:36:00','2026-04-10 09:36:00'),(105,60,2,'Quần Tây Slim Fit Đen',450000.00,750000.00,2,1500000.00,NULL,'2026-04-08 12:31:00','2026-04-08 12:31:00'),(106,61,68,'Đồ Mặc Nhà Relax v1',180000.00,320000.00,1,320000.00,NULL,'2026-04-04 18:04:00','2026-04-04 18:04:00'),(107,62,38,'Set Đồ Urban Style',300000.00,550000.00,1,550000.00,NULL,'2026-04-22 13:51:00','2026-04-22 13:51:00'),(108,62,68,'Đồ Mặc Nhà Relax v1',180000.00,320000.00,2,640000.00,NULL,'2026-04-22 13:51:00','2026-04-22 13:51:00');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `discount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `shipping_fee` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(15,2) NOT NULL,
  `amount_paid` decimal(15,2) NOT NULL,
  `change_amount` decimal(15,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (3,'ORD-Y4MSZW',3,NULL,210000.00,0.00,30000.00,240000.00,0.00,0.00,'cash','pending',NULL,'Ấp bình hòa xã bình thạnh huyện lấp vò tỉnh đồng tháp, Tỉnh đồng tháp 81000, Vietnam',NULL,'Delivered','2026-04-25 10:13:01','2026-04-26 19:40:20'),(4,'ORD-ACBMHQ',3,2,193000.00,0.00,30000.00,223000.00,0.00,0.00,'cash','pending',NULL,'Ấp bình hòa xã bình thạnh huyện lấp vò tỉnh đồng tháp, Tỉnh đồng tháp 81000, Vietnam',NULL,'Delivered','2026-04-25 11:36:29','2026-04-26 09:15:18'),(5,'ORD-V1K9K3',3,2,290000.00,0.00,30000.00,320000.00,0.00,0.00,'cash','pending',NULL,'Ấp bình hòa xã bình thạnh huyện lấp vò tỉnh đồng tháp, Tỉnh đồng tháp 81000, Vietnam',NULL,'pending','2026-04-25 11:57:05','2026-04-25 11:57:05'),(6,'ORD-2OMPKQ',3,2,193000.00,0.00,30000.00,223000.00,0.00,0.00,'qr','pending',NULL,'Ấp bình hòa xã bình thạnh huyện lấp vò tỉnh đồng tháp, Tỉnh đồng tháp 81000, Vietnam',NULL,'Processing','2026-04-26 08:22:29','2026-04-26 08:24:12'),(7,'ORD-KNUH7M',3,4,386000.00,0.00,30000.00,416000.00,0.00,0.00,'qr','pending',NULL,'Ấp bình hòa xã bình thạnh huyện lấp vò tỉnh đồng tháp, Tỉnh đồng tháp 81000, Vietnam',NULL,'Shipped','2026-04-28 08:38:59','2026-04-28 08:40:42'),(8,'ORD-VU0T6K',3,3,193000.00,0.00,30000.00,223000.00,0.00,0.00,'cash','pending',NULL,'Ấp bình hòa xã bình thạnh huyện lấp vò tỉnh đồng tháp, Tỉnh đồng tháp 81000, Vietnam',NULL,'Delivered','2026-04-28 09:35:14','2026-04-29 14:02:19'),(9,'ORD-KXIMVD',3,2,579000.00,0.00,30000.00,609000.00,609000.00,0.00,'qr','paid',NULL,'Ấp bình hòa xã bình thạnh huyện lấp vò tỉnh đồng tháp, Tỉnh đồng tháp 81000, Vietnam',NULL,'pending','2026-04-29 14:03:18','2026-04-29 14:03:18'),(10,'ORD-AIVUVS',3,2,2815000.00,0.00,0.00,2815000.00,2815000.00,0.00,'qr','paid',NULL,'Ấp bình minh xã bình thạnh huyện lấp vò tỉnh An Giang, Tỉnh An Giang 81000, Vietnam',NULL,'pending','2026-04-29 14:06:09','2026-04-29 14:06:09'),(11,'ORD-4HXBBQ',3,2,550000.00,0.00,30000.00,580000.00,580000.00,0.00,'qr','paid',NULL,'Ấp bình hòa xã bình thạnh huyện lấp vò tỉnh đồng tháp, Tỉnh đồng tháp 81000, Vietnam',NULL,'pending','2026-04-29 15:59:58','2026-04-29 15:59:58'),(12,'ORD-D5K4PY',3,2,450000.00,0.00,30000.00,480000.00,0.00,0.00,'cash','pending',NULL,'Ấp bình hòa xã bình thạnh huyện lấp vò tỉnh đồng tháp, Tỉnh đồng tháp 81000, Vietnam',NULL,'pending','2026-04-29 16:02:08','2026-04-29 16:02:08'),(13,'ORD-KZUFYK',3,3,450000.00,0.00,30000.00,480000.00,480000.00,0.00,'qr','paid',NULL,'Ấp bình hòa xã bình thạnh huyện lấp vò tỉnh đồng tháp, Tỉnh đồng tháp 81000, Vietnam',NULL,'pending','2026-04-30 13:16:28','2026-04-30 13:16:28'),(14,'ORD-3LWJQ3',3,3,210000.00,0.00,30000.00,240000.00,240000.00,0.00,'qr','paid',NULL,'Ấp bình hòa xã bình thạnh huyện lấp vò tỉnh đồng tháp, Tỉnh đồng tháp 81000, Vietnam',NULL,'pending','2026-04-30 13:18:20','2026-04-30 13:18:20'),(15,'ORD-TY3C91',3,3,185000.00,0.00,30000.00,215000.00,0.00,0.00,'cash','pending',NULL,'Ấp bình hòa xã bình thạnh huyện lấp vò tỉnh đồng tháp, Tỉnh đồng tháp 81000, Vietnam',NULL,'pending','2026-04-30 21:54:48','2026-04-30 21:54:48'),(16,'ORD-0PGFG9',4,5,210000.00,0.00,30000.00,240000.00,240000.00,0.00,'qr','paid',NULL,'ggg, vl 3, Vietnam',NULL,'Delivered','2026-05-01 00:06:01','2026-05-01 00:07:16'),(17,'ORD-ZRXKPM',4,NULL,735000.00,0.00,30000.00,765000.00,0.00,0.00,'cash','pending',NULL,'ggg, hv 3, Vietnam',NULL,'pending','2026-05-01 19:57:17','2026-05-01 19:57:17'),(18,'ORD-BND4KK',5,2,193000.00,0.00,30000.00,223000.00,223000.00,0.00,'qr','paid',NULL,'19 Nguyễn Hữu Thọ, phường Tân Hưng, TP. Hồ Chí Minh, Hồ chí minh 7000, Vietnam',NULL,'Delivered','2026-05-02 07:34:50','2026-05-02 13:59:48'),(19,'ORD-FCJLO8',6,1,193000.00,0.00,30000.00,223000.00,223000.00,0.00,'qr','paid',NULL,'Ấp bình hòa xã bình thạnh, Tỉnh đồng tháp 81000, Vietnam',NULL,'Delivered','2026-05-02 13:34:38','2026-05-02 13:59:37'),(20,'ORD-NO7FZF',6,3,378000.00,0.00,30000.00,408000.00,408000.00,0.00,'qr','paid',NULL,'Ấp bình hòa xã bình thạnh, Tỉnh đồng tháp 81000, Vietnam',NULL,'pending','2026-05-04 16:33:41','2026-05-04 16:33:41'),(21,'ORD-ZAYWRY',6,3,605000.00,0.00,30000.00,635000.00,635000.00,0.00,'qr','paid',NULL,'Ấp bình hòa xã bình thạnh, Tỉnh đồng tháp 81000, Vietnam',NULL,'pending','2026-05-04 17:20:00','2026-05-04 17:20:00'),(22,'ORD-D8WMQV',6,3,403000.00,0.00,30000.00,433000.00,433000.00,0.00,'qr','paid',NULL,'Ấp bình hòa xã bình thạnh, Tỉnh đồng tháp 81000, Vietnam',NULL,'pending','2026-05-05 16:20:10','2026-05-05 16:20:10'),(23,'ORD-N26785',2,3,1333000.00,0.00,30000.00,1363000.00,1363000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-01-10 19:08:00','2026-01-10 19:08:00'),(24,'ORD-Q13131',5,3,750000.00,0.00,30000.00,780000.00,780000.00,0.00,'cash','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-01-04 11:04:00','2026-01-04 11:04:00'),(25,'ORD-Z11502',2,3,1740000.00,0.00,30000.00,1770000.00,1770000.00,0.00,'cash','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-01-14 11:01:00','2026-01-14 11:01:00'),(26,'ORD-I84234',1,3,940000.00,0.00,30000.00,970000.00,0.00,0.00,'cash','pending',NULL,'Sample Address','Automated Sample Data','pending','2026-01-18 10:08:00','2026-01-18 10:08:00'),(27,'ORD-U71295',1,3,1293000.00,0.00,30000.00,1323000.00,0.00,0.00,'cash','pending',NULL,'Sample Address','Automated Sample Data','pending','2026-01-20 16:33:00','2026-01-20 16:33:00'),(28,'ORD-Q11547',3,3,953000.00,0.00,30000.00,983000.00,983000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-02-15 12:33:00','2026-02-15 12:33:00'),(29,'ORD-E85575',6,3,280000.00,0.00,30000.00,310000.00,310000.00,0.00,'cash','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-02-08 12:31:00','2026-02-08 12:31:00'),(30,'ORD-Z82046',4,3,1410000.00,0.00,30000.00,1440000.00,0.00,0.00,'cash','pending',NULL,'Sample Address','Automated Sample Data','pending','2026-02-07 09:44:00','2026-02-07 09:44:00'),(31,'ORD-J35379',5,3,320000.00,0.00,30000.00,350000.00,350000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-02-19 15:48:00','2026-02-19 15:48:00'),(32,'ORD-X43226',2,3,610000.00,0.00,30000.00,640000.00,640000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-02-16 10:24:00','2026-02-16 10:24:00'),(33,'ORD-W65937',4,3,1740000.00,0.00,30000.00,1770000.00,1770000.00,0.00,'cash','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-02-11 13:40:00','2026-02-11 13:40:00'),(34,'ORD-C25950',6,3,943000.00,0.00,30000.00,973000.00,973000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-02-14 17:56:00','2026-02-14 17:56:00'),(35,'ORD-F34797',3,3,1000000.00,0.00,30000.00,1030000.00,1030000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-02-17 18:56:00','2026-02-17 18:56:00'),(36,'ORD-P41902',2,3,1100000.00,0.00,30000.00,1130000.00,1130000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-03-01 20:14:00','2026-03-01 20:14:00'),(37,'ORD-E55764',4,3,1393000.00,0.00,30000.00,1423000.00,1423000.00,0.00,'cash','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-03-13 18:26:00','2026-03-13 18:26:00'),(38,'ORD-V98008',1,3,610000.00,0.00,30000.00,640000.00,640000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-03-26 19:44:00','2026-03-26 19:44:00'),(39,'ORD-E80716',2,3,1330000.00,0.00,30000.00,1360000.00,1360000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-03-03 12:20:00','2026-03-03 12:20:00'),(40,'ORD-L78374',4,3,193000.00,0.00,30000.00,223000.00,223000.00,0.00,'cash','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-03-23 17:26:00','2026-03-23 17:26:00'),(41,'ORD-H21618',2,3,390000.00,0.00,30000.00,420000.00,420000.00,0.00,'cash','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-03-21 20:17:00','2026-03-21 20:17:00'),(42,'ORD-D59921',6,3,2120000.00,0.00,30000.00,2150000.00,2150000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-03-21 14:46:00','2026-03-21 14:46:00'),(43,'ORD-V74489',4,3,1100000.00,0.00,30000.00,1130000.00,1130000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-03-25 21:28:00','2026-03-25 21:28:00'),(44,'ORD-A74723',1,3,1140000.00,0.00,30000.00,1170000.00,1170000.00,0.00,'cash','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-03-14 15:06:00','2026-03-14 15:06:00'),(45,'ORD-L62641',3,3,1540000.00,0.00,30000.00,1570000.00,1570000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-03-14 09:08:00','2026-03-14 09:08:00'),(46,'ORD-E58055',4,3,1020000.00,0.00,30000.00,1050000.00,1050000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-03-26 21:16:00','2026-03-26 21:16:00'),(47,'ORD-D21908',3,3,290000.00,0.00,30000.00,320000.00,320000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-03-13 10:26:00','2026-03-13 10:26:00'),(48,'ORD-I32851',6,3,583000.00,0.00,30000.00,613000.00,613000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-04-25 17:50:00','2026-04-25 17:50:00'),(49,'ORD-M72987',3,3,290000.00,0.00,30000.00,320000.00,320000.00,0.00,'cash','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-04-13 15:45:00','2026-04-13 15:45:00'),(50,'ORD-P17824',6,3,490000.00,0.00,30000.00,520000.00,520000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-04-08 15:59:00','2026-04-08 15:59:00'),(51,'ORD-B96948',6,3,870000.00,0.00,30000.00,900000.00,900000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-04-13 09:23:00','2026-04-13 09:23:00'),(52,'ORD-K50784',1,3,386000.00,0.00,30000.00,416000.00,416000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-04-15 10:09:00','2026-04-15 10:09:00'),(53,'ORD-W45979',1,3,1690000.00,0.00,30000.00,1720000.00,1720000.00,0.00,'cash','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-04-20 15:58:00','2026-04-20 15:58:00'),(54,'ORD-D54679',5,3,1100000.00,0.00,30000.00,1130000.00,1130000.00,0.00,'cash','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-04-15 17:19:00','2026-04-15 17:19:00'),(55,'ORD-G73231',5,3,1780000.00,0.00,30000.00,1810000.00,1810000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-04-19 19:30:00','2026-04-19 19:30:00'),(56,'ORD-O26476',5,3,2700000.00,0.00,30000.00,2730000.00,0.00,0.00,'cash','pending',NULL,'Sample Address','Automated Sample Data','pending','2026-04-10 11:07:00','2026-04-10 11:07:00'),(57,'ORD-R30458',3,3,640000.00,0.00,30000.00,670000.00,0.00,0.00,'cash','pending',NULL,'Sample Address','Automated Sample Data','pending','2026-04-16 15:50:00','2026-04-16 15:50:00'),(58,'ORD-M78755',4,3,210000.00,0.00,30000.00,240000.00,240000.00,0.00,'cash','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-04-24 16:51:00','2026-04-24 16:51:00'),(59,'ORD-I90628',1,3,850000.00,0.00,30000.00,880000.00,880000.00,0.00,'cash','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-04-10 09:36:00','2026-04-10 09:36:00'),(60,'ORD-U84228',2,3,1500000.00,0.00,30000.00,1530000.00,1530000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-04-08 12:31:00','2026-04-08 12:31:00'),(61,'ORD-H46327',6,3,320000.00,0.00,30000.00,350000.00,350000.00,0.00,'cash','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-04-04 18:04:00','2026-04-04 18:04:00'),(62,'ORD-X20376',6,3,1190000.00,0.00,30000.00,1220000.00,1220000.00,0.00,'qr','paid',NULL,'Sample Address','Automated Sample Data','Delivered','2026-04-22 13:51:00','2026-04-22 13:51:00');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category_id` bigint unsigned NOT NULL,
  `cost_price` decimal(15,2) NOT NULL,
  `selling_price` decimal(15,2) NOT NULL,
  `material` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default-product.png',
  `stock_quantity` int NOT NULL DEFAULT '0',
  `sizes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_barcode_unique` (`barcode`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'SP001','Áo Sơ Mi Oxford Trắng',NULL,1,350000.00,550000.00,'Cotton Oxford','p1.png',47,'S,M,L,XL',1,'2026-04-23 09:09:49','2026-05-01 19:57:17'),(2,'SP002','Quần Tây Slim Fit Đen',NULL,2,450000.00,750000.00,'Wool Blend','p2.png',29,'S,M,L,XL',1,'2026-04-23 09:09:49','2026-04-29 14:06:09'),(3,'SP003','Thắt Lưng Da Bò Thật',NULL,12,250000.00,450000.00,'Leather','p4.png',0,'S,M,L,XL',1,'2026-04-23 09:09:49','2026-05-04 10:20:05'),(4,'J1','Áo Khoác Dù Parachute Bội Bặm','Thông tin sản phẩm đang cập nhật. Sản phẩm được sản xuất với chất liệu cao cấp, đường may tỉ mỉ, mang lại cảm giác thoải mái và phong cách cho người mặc.',5,135100.00,193000.00,'Premium Fabric','source/SalePage/j1.png',70,'S,M,L,XL',1,'2026-04-23 10:00:30','2026-05-05 16:20:10'),(5,'J2','Áo Khoác Gió Form Boxy Phối Trắng',NULL,5,147000.00,210000.00,'Premium Fabric','source/SalePage/j2.png',57,'S,M,L,XL',1,'2026-04-23 10:00:30','2026-05-05 16:20:10'),(6,'J3','Áo Khoác Chống Nắng UV Phom Rộng',NULL,5,129500.00,185000.00,'Premium Fabric','source/SalePage/j3.png',-1,'S,M,L,XL',1,'2026-04-23 10:00:30','2026-05-04 17:20:00'),(22,'F103','Quần Hộp Oversize Trượt Ván',NULL,10,203000.00,290000.00,'Premium Fabric','source/Products/F1/3.png',34,'S,M,L,XL',1,'2026-04-23 10:00:30','2026-04-29 14:06:09'),(25,'F106','Quần Tây Oversize',NULL,10,266000.00,380000.00,'Premium Fabric','source/Products/F1/6.png',73,'S,M,L,XL',1,'2026-04-23 10:00:30','2026-04-29 14:06:09'),(38,'SS001','Set Đồ Urban Style','Phối hợp năng động giữa áo thun và quần jogger urban.',16,300000.00,550000.00,'Mixed Fabric','source/StyleSetSection/f1.png',50,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(39,'SS002','Set Đồ Streetwear','Phong cách đường phố bùng nổ cá tính.',16,350000.00,650000.00,'Cotton & Kaki','source/StyleSetSection/f2.png',45,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(40,'SS003','Set Đồ Classic','Nét cổ điển pha chút hiện đại sang trọng.',16,400000.00,750000.00,'Wool & Silk','source/StyleSetSection/f3.png',30,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(41,'SL001','Voucher Ưu Đãi 50%','Voucher giảm giá 50% cho đơn hàng tiếp theo.',21,0.00,10000.00,'Digital','source/SalePage/banner1.png',1000,'S,M,L,XL',0,'2026-05-08 22:30:00','2026-05-08 23:55:33'),(42,'SL002','Voucher Mua 1 Tặng 1','Ưu đãi mua 1 tặng 1 áp dụng toàn sàn.',21,0.00,10000.00,'Digital','source/SalePage/banner2.png',1000,'S,M,L,XL',0,'2026-05-08 22:30:00','2026-05-08 23:55:42'),(43,'SL003','Voucher Giảm 100k','Voucher giảm trực tiếp 100.000đ.',21,0.00,5000.00,'Digital','source/SalePage/banner3.png',1000,'S,M,L,XL',0,'2026-05-08 22:30:00','2026-05-08 23:55:58'),(44,'SL004','Voucher Khách Hàng Thân Thiết','Ưu đãi đặc quyền cho hội viên Tiny Flowers.',21,0.00,0.00,'Digital','source/SalePage/banner4.png',9999,'S,M,L,XL',0,'2026-05-08 22:30:00','2026-05-08 23:56:19'),(45,'WV001','Áo Khoác Dạo Phố Weekend','Áo khoác nhẹ nhàng cho những buổi dạo phố cuối tuần.',17,150000.00,280000.00,'Nylon','source/WeekendVibesSection/f1.png',60,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(46,'WV002','Quần Jogger Weekend','Quần jogger thoải mái, phù hợp mọi hoạt động.',17,180000.00,320000.00,'Cotton','source/WeekendVibesSection/f2.png',55,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(47,'WV003','Set Đồ Picnic','Set đồ lý tưởng cho các chuyến dã ngoại.',17,320000.00,580000.00,'Linen','source/WeekendVibesSection/f3.png',25,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(48,'SP011','Đồ Tập Gym Năng Động v1','Thoáng khí, co giãn cực tốt.',18,220000.00,390000.00,'Polyester','source/WeekendVibesSection/sport/f1.png',40,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(49,'SP012','Đồ Tập Gym Năng Động v2','Thiết kế hiện đại, tôn dáng.',18,220000.00,390000.00,'Polyester','source/WeekendVibesSection/sport/f2.png',40,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(50,'SP013','Đồ Tập Gym Năng Động v3','Bền bỉ trong mọi bài tập cường độ cao.',18,220000.00,390000.00,'Polyester','source/WeekendVibesSection/sport/f3.png',40,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(51,'SP014','Đồ Tập Gym Năng Động v4','Màu sắc đa dạng, trẻ trung.',18,220000.00,390000.00,'Polyester','source/WeekendVibesSection/sport/f4.png',40,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(52,'SP015','Đồ Tập Gym Năng Động v5','Phù hợp cả chạy bộ và gym.',18,220000.00,390000.00,'Polyester','source/WeekendVibesSection/sport/f5.png',40,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(53,'SP016','Đồ Tập Gym Năng Động v6','Chất liệu cao cấp, thấm hút mồ hôi.',18,220000.00,390000.00,'Polyester','source/WeekendVibesSection/sport/f6.png',40,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(54,'SP017','Đồ Tập Gym Năng Động v7','Kiểu dáng sport-chic thời thượng.',18,220000.00,390000.00,'Polyester','source/WeekendVibesSection/sport/f7.png',40,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(55,'SP018','Đồ Tập Gym Năng Động v8','Tối ưu hóa chuyển động.',18,220000.00,390000.00,'Polyester','source/WeekendVibesSection/sport/f8.png',40,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(56,'SP019','Đồ Tập Gym Năng Động v9','Sự lựa chọn hàng đầu cho vận động viên.',18,220000.00,390000.00,'Polyester','source/WeekendVibesSection/sport/f9.png',40,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(57,'SP020','Đồ Tập Gym Năng Động v10','Hoàn hảo cho lối sống năng động.',18,220000.00,390000.00,'Polyester','source/WeekendVibesSection/sport/f10.png',40,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(58,'MN001','Áo Minimalist Basic v1','Tối giản là đỉnh cao của sự tinh tế.',19,120000.00,220000.00,'Organic Cotton','source/WeekendVibesSection/minimal/f1.png',80,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(59,'MN002','Áo Minimalist Basic v2','Dễ phối đồ, phong cách bền vững.',19,120000.00,220000.00,'Organic Cotton','source/WeekendVibesSection/minimal/f2.png',80,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(60,'MN003','Áo Minimalist Basic v3','Chất lượng trong từng đường kim mũi chỉ.',19,120000.00,220000.00,'Organic Cotton','source/WeekendVibesSection/minimal/f3.png',80,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(61,'MN004','Áo Minimalist Basic v4','Sự lựa chọn cho người yêu sự đơn giản.',19,120000.00,220000.00,'Organic Cotton','source/WeekendVibesSection/minimal/f4.png',80,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(62,'MN005','Áo Minimalist Basic v5','Form dáng chuẩn, bền màu.',19,120000.00,220000.00,'Organic Cotton','source/WeekendVibesSection/minimal/f5.png',80,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(63,'MN006','Áo Minimalist Basic v6','Thoải mái suốt ngày dài.',19,120000.00,220000.00,'Organic Cotton','source/WeekendVibesSection/minimal/f6.png',80,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(64,'MN007','Áo Minimalist Basic v7','Đơn giản mà không đơn điệu.',19,120000.00,220000.00,'Organic Cotton','source/WeekendVibesSection/minimal/f7.png',80,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(65,'MN008','Áo Minimalist Basic v8','Vẻ đẹp vượt thời gian.',19,120000.00,220000.00,'Organic Cotton','source/WeekendVibesSection/minimal/f8.png',80,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(66,'MN009','Áo Minimalist Basic v9','Mềm mại và thân thiện với làn da.',19,120000.00,220000.00,'Organic Cotton','source/WeekendVibesSection/minimal/f9.png',80,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(67,'MN010','Áo Minimalist Basic v10','Nâng tầm phong cách cá nhân.',19,120000.00,220000.00,'Organic Cotton','source/WeekendVibesSection/minimal/f10.png',80,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(68,'RX001','Đồ Mặc Nhà Relax v1','Thư giãn tối đa sau giờ làm việc.',20,180000.00,320000.00,'Silk Blend','source/WeekendVibesSection/relax/f1.png',60,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(69,'RX002','Đồ Mặc Nhà Relax v2','Mát mẻ, nhẹ tênh.',20,180000.00,320000.00,'Silk Blend','source/WeekendVibesSection/relax/f2.png',60,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(70,'RX003','Đồ Mặc Nhà Relax v3','Thiết kế đơn giản, thanh lịch.',20,180000.00,320000.00,'Silk Blend','source/WeekendVibesSection/relax/f3.png',60,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(71,'RX004','Đồ Mặc Nhà Relax v4','Cảm giác như được ôm ấp.',20,180000.00,320000.00,'Silk Blend','source/WeekendVibesSection/relax/f4.png',60,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(72,'RX005','Đồ Mặc Nhà Relax v5','Chất liệu thiên nhiên, an toàn.',20,180000.00,320000.00,'Silk Blend','source/WeekendVibesSection/relax/f5.png',60,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(73,'RX006','Đồ Mặc Nhà Relax v6','Gọn gàng và lịch sự.',20,180000.00,320000.00,'Silk Blend','source/WeekendVibesSection/relax/f6.png',60,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(74,'RX007','Đồ Mặc Nhà Relax v7','Phù hợp cho cả nghỉ ngơi và tiếp khách.',20,180000.00,320000.00,'Silk Blend','source/WeekendVibesSection/relax/f7.png',60,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(75,'RX008','Đồ Mặc Nhà Relax v8','Độ bền cao, không nhăn.',20,180000.00,320000.00,'Silk Blend','source/WeekendVibesSection/relax/f8.png',60,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(76,'RX009','Đồ Mặc Nhà Relax v9','Tận hưởng không gian sống.',20,180000.00,320000.00,'Silk Blend','source/WeekendVibesSection/relax/f9.png',60,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00'),(77,'RX010','Đồ Mặc Nhà Relax v10','Đỉnh cao của sự thoải mái.',20,180000.00,320000.00,'Silk Blend','source/WeekendVibesSection/relax/f10.png',60,'S,M,L,XL',1,'2026-05-08 22:30:00','2026-05-08 22:30:00');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `rating` tinyint NOT NULL DEFAULT '5',
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,2,4,5,'okkk','2026-04-26 09:01:31','2026-04-26 09:01:31'),(2,5,5,5,NULL,'2026-05-01 00:08:42','2026-05-01 00:08:42');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('MNh6DgAqXNSaD9nMpuvM78RrHhzWbUh5BqaFWboD',NULL,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoialdiQ1NveFZYSVE3YzhFZ0lDYTF6T2JKNEwydGhHaXYxcFplellUMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTk6Imh0dHA6Ly9sb2NhbGhvc3QvVElOWS1GTE9XRVJTL212Yy1wcm9qZWN0L3B1YmxpYy9jYXRlZ29yaWVzIjtzOjU6InJvdXRlIjtzOjE2OiJjYXRlZ29yaWVzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1777257797);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staff',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `must_change_password` tinyint(1) NOT NULL DEFAULT '0',
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activation_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_expiry` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_google_id_unique` (`google_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','Admin User','admin@admin.com','08699133333','Ấp bình hòa xã bình thạnh, Tỉnh đồng tháp 81000, Vietnam',NULL,'$2y$12$5/xSqveuBqxuwkPCmdCUYu0rXFELLjGRkcAezVYPD3AMQp4kQ47om',NULL,'admin','active',1,0,NULL,NULL,NULL,'VEmrVyYgbd56WEcHeSmSGqfEISRkAkeforo4JBi9yNcY0TLE8PZGxRQ6W8KV','2026-04-23 09:09:49','2026-05-02 13:34:38'),(2,'52300235','Nguyễn Văn Dũng','nhanhuutran007@gmail.com','0869918255','19 Nguyễn Hữu Thọ, phường Tân Hưng, TP. Hồ Chí Minh, Hồ chí minh 7000, Vietnam',NULL,'$2y$12$Dpbx.pY45Bw//xX2rLMJqe9ETv1/729zQuQ5safLD1q.kTFauS0xq','117700415587667958552','customer','active',1,0,NULL,NULL,NULL,'bzl414WZjdaL8VAaIsdTOZQfdwxzsWovZX4pvRq8xGpiOiORoNTLMDnq8N9v','2026-04-25 11:21:28','2026-05-02 07:34:50'),(3,'tran.nhan','Trần Nhân','nhanhuutran009@gmail.com','08699133333','Ấp bình hòa xã bình thạnh, Tỉnh đồng tháp 81000, Vietnam',NULL,'$2y$12$1h8UTQijJDNyd2T1YJkd1uPWWdvO1F2j6ZOG.1ZJcVRy0qoZ2aGEq','114199343913908936666','customer','active',1,0,'1777650107_69f4c9bb3c2eb.jpg',NULL,NULL,'jwGX1PT7j05Gc33avhxwAkMvxVVT4OkMPP2YnlODzqgHhbHN1PuhqEYr64NQ','2026-04-28 08:35:00','2026-05-04 16:33:41'),(4,'tran.huu.nhan','Trần Hữu Nhân','52300235@student.tdtu.edu.vn','0869918250','Ấp bình hòa xã bình thạnh huyện lấp vò tỉnh đồng tháp, Tỉnh đồng tháp 81000, Vietnam',NULL,'$2y$12$okq7n9hNsSPuZE98WqnF6.ZfdJUyQpH7w.CQW4tA3ihEFdHIBnqpm','101497975643004101269','customer','active',1,0,NULL,NULL,NULL,'H2ETMYiEFpxvHOAXiZZNhbux4ORSwVQp898l1yZlwK2e85p46n0yZEooTnNV','2026-04-28 08:36:50','2026-05-01 14:47:39'),(5,'tran.xuan.nghi','Trần Xuân Nghi','xuanvinh15011999@gmail.com','09091751600','ggg, vl 3, Vietnammmm',NULL,'$2y$12$sonc.2hP6BxY5QZEMCQgGO9SpowY7ipNcYq6sRA7b/4aOA6franta','100292119478376950656','customer','1',0,0,NULL,NULL,NULL,'BlOv1BHq6K7RG7yb9t58Oli4c59v2Quf230ln4rl4QPCt1YT7nEsDU3U35qT','2026-05-01 00:02:32','2026-05-01 14:44:34'),(6,'tran.xuan.nghi1','Trần Xuân Nghi','52300226@student.tdtu.edu.vn',NULL,NULL,NULL,'$2y$12$aRCMnj0ko9AE2dPKEEJTEelEW.e1fMx/Aj9BIlOeV88IfwexKfpIS','111554286277325499582','customer','1',0,0,NULL,NULL,NULL,'meboXRr43tMwlq5dw96xnAcHM9FMv1XiD7voih1rhYRMykRAmbLz0sa7sfQ2','2026-05-01 00:07:52','2026-05-01 00:07:52'),(7,'xuan.nghi.tran','Xuân Nghi Trần','xuannghi31012005@gmail.com',NULL,NULL,NULL,'$2y$12$8930wpmCA8jgKtk/y0HKf.ahnBTr87LKG3S2cuxj2M4Lxr.cdYcXm','108043159648211824670','customer','1',0,0,NULL,NULL,NULL,'2Rdx5HQfQnQbvMMbhVzKO4y83Y5fgA2Ms7kztLguesG3AI5zScdeagU0ltxH','2026-05-01 00:08:09','2026-05-01 00:08:09'),(8,'XUANNGHI','XNnn','user@example.com',NULL,NULL,NULL,'$2y$12$V/bmugD77MQ2.o3FziqI4Ojz5rxp9ld.Q0AnpwcRLY/HkBIfV5W/a',NULL,'customer','locked',0,0,NULL,NULL,NULL,NULL,'2026-05-01 14:41:20','2026-05-07 02:32:44');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-08 17:13:10
