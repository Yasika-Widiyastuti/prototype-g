-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: sewa_barang_konser
-- ------------------------------------------------------
-- Server version	8.4.3

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
  `admin_id` bigint unsigned NOT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `related_model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `related_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_admin_id_created_at_index` (`admin_id`,`created_at`),
  CONSTRAINT `activity_logs_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,3,'user_status_update','User najwa zayuara (najwa123@gmail.com) has been deactivated','User',6,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:143.0) Gecko/20100101 Firefox/143.0','2025-09-21 11:17:39','2025-09-21 11:17:39'),(2,3,'user_status_update','User najwa zayuara (najwa123@gmail.com) has been activated','User',6,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:143.0) Gecko/20100101 Firefox/143.0','2025-09-21 11:17:45','2025-09-21 11:17:45'),(3,3,'user_status_update','User najwa zayuara (najwa123@gmail.com) has been deactivated','User',6,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:143.0) Gecko/20100101 Firefox/143.0','2025-09-21 11:17:58','2025-09-21 11:17:58'),(4,3,'payment_verification','Set payment verification status to success for user najwa zayuara','Payment',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:143.0) Gecko/20100101 Firefox/143.0','2025-09-21 11:20:54','2025-09-21 11:20:54'),(5,3,'user_status_update','User najwa zayuara (najwa123@gmail.com) has been activated','User',6,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:143.0) Gecko/20100101 Firefox/143.0','2025-09-21 11:21:28','2025-09-21 11:21:28'),(6,3,'payment_verification','Set payment verification status to failed for user katarina clarissa','Payment',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:143.0) Gecko/20100101 Firefox/143.0','2025-09-21 11:21:40','2025-09-21 11:21:40'),(7,3,'payment_verification','Set payment verification status to success for user aisya rizkya hidayah','Payment',3,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:143.0) Gecko/20100101 Firefox/143.0','2025-09-21 18:42:23','2025-09-21 18:42:23'),(8,3,'payment_verification','Set payment verification status to failed for user katarina clarissa','Payment',4,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:143.0) Gecko/20100101 Firefox/143.0','2025-09-21 19:25:28','2025-09-21 19:25:28'),(9,3,'payment_verification','Set payment verification status to success for user najwa zayuara','Payment',5,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','2025-10-06 03:31:37','2025-10-06 03:31:37'),(10,3,'order_status_update','Changed order ORD-20251006-597C65 status from waiting_verification to confirmed for user najwa zayuara','Order',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','2025-10-06 09:22:46','2025-10-06 09:22:46'),(11,3,'payment_verification','Set payment verification status to success for user najwa zayuara','Payment',6,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','2025-10-06 09:22:46','2025-10-06 09:22:46'),(12,3,'user_status_update','User aisya rizkya hidayah (aisyarizkya20@gmail.com) has been deactivated','User',7,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','2025-10-07 05:55:30','2025-10-07 05:55:30'),(13,3,'user_status_update','User aisya rizkya hidayah (aisyarizkya20@gmail.com) has been activated','User',7,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','2025-10-07 05:55:33','2025-10-07 05:55:33'),(14,3,'order_status_update','Changed order ORD-20251007-808556 status from waiting_verification to confirmed for user najwa zayuara','Order',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','2025-10-07 06:30:08','2025-10-07 06:30:08'),(15,3,'payment_verification','Set payment verification status to success for user najwa zayuara','Payment',7,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','2025-10-07 06:30:08','2025-10-07 06:30:08'),(16,3,'order_status_update','Changed order ORD-20251007-A0ADB7 status from waiting_verification to confirmed for user yasika','Order',3,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','2025-10-07 09:39:37','2025-10-07 09:39:37'),(17,3,'payment_verification','Set payment verification status to success for user yasika','Payment',8,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','2025-10-07 09:39:38','2025-10-07 09:39:38'),(18,3,'order_status_update','Changed order ORD-20251007-048BD5 status from waiting_verification to confirmed for user yasika','Order',4,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','2025-10-07 09:44:56','2025-10-07 09:44:56'),(19,3,'payment_verification','Set payment verification status to success for user yasika','Payment',9,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','2025-10-07 09:44:56','2025-10-07 09:44:56'),(20,3,'payment_verification','Set payment verification status to failed for user najwa','Payment',10,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','2025-10-07 09:52:09','2025-10-07 09:52:09'),(21,3,'payment_verification','Set payment verification status to failed for user najwa','Payment',11,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','2025-10-07 10:05:43','2025-10-07 10:05:43');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audit_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `event_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_user_id_index` (`user_id`),
  KEY `audit_logs_event_type_index` (`event_type`),
  KEY `audit_logs_created_at_index` (`created_at`),
  KEY `audit_logs_user_id_event_type_index` (`user_id`,`event_type`),
  CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
INSERT INTO `audit_logs` VALUES (1,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-05 16:40:37\"}','2025-10-05 09:40:37','2025-10-05 09:40:37'),(2,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-06 06:25:26\"}','2025-10-05 23:25:26','2025-10-05 23:25:26'),(3,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 06:26:05\"}','2025-10-05 23:26:05','2025-10-05 23:26:05'),(4,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-06 06:26:27\"}','2025-10-05 23:26:27','2025-10-05 23:26:27'),(5,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 06:26:51\"}','2025-10-05 23:26:51','2025-10-05 23:26:51'),(6,NULL,'failed_login','Percobaan login gagal','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 06:37:37\"}','2025-10-05 23:37:37','2025-10-05 23:37:37'),(7,NULL,'failed_login','Percobaan login gagal','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 06:37:47\"}','2025-10-05 23:37:47','2025-10-05 23:37:47'),(8,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-06 06:37:57\"}','2025-10-05 23:37:57','2025-10-05 23:37:57'),(9,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 06:39:03\"}','2025-10-05 23:39:03','2025-10-05 23:39:03'),(10,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-06 06:39:21\"}','2025-10-05 23:39:21','2025-10-05 23:39:21'),(11,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 07:09:49\"}','2025-10-06 00:09:49','2025-10-06 00:09:49'),(12,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-06 07:10:06\"}','2025-10-06 00:10:06','2025-10-06 00:10:06'),(13,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 07:10:21\"}','2025-10-06 00:10:21','2025-10-06 00:10:21'),(14,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": true, \"timestamp\": \"2025-10-06 07:10:42\"}','2025-10-06 00:10:42','2025-10-06 00:10:42'),(15,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 07:48:47\"}','2025-10-06 00:48:47','2025-10-06 00:48:47'),(16,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-06 07:49:04\"}','2025-10-06 00:49:04','2025-10-06 00:49:04'),(17,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 07:51:03\"}','2025-10-06 00:51:03','2025-10-06 00:51:03'),(18,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": true, \"timestamp\": \"2025-10-06 07:51:26\"}','2025-10-06 00:51:26','2025-10-06 00:51:26'),(19,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 08:12:02\"}','2025-10-06 01:12:02','2025-10-06 01:12:02'),(20,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-06 08:12:14\"}','2025-10-06 01:12:14','2025-10-06 01:12:14'),(21,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 09:32:41\"}','2025-10-06 02:32:41','2025-10-06 02:32:41'),(22,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-06 09:32:51\"}','2025-10-06 02:32:51','2025-10-06 02:32:51'),(23,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 09:58:30\"}','2025-10-06 02:58:30','2025-10-06 02:58:30'),(24,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-06 09:58:50\"}','2025-10-06 02:58:50','2025-10-06 02:58:50'),(25,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 10:31:15\"}','2025-10-06 03:31:15','2025-10-06 03:31:15'),(26,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-06 10:31:31\"}','2025-10-06 03:31:31','2025-10-06 03:31:31'),(27,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 10:54:30\"}','2025-10-06 03:54:30','2025-10-06 03:54:30'),(28,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-06 10:54:49\"}','2025-10-06 03:54:49','2025-10-06 03:54:49'),(29,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": true, \"timestamp\": \"2025-10-06 13:57:50\"}','2025-10-06 06:57:50','2025-10-06 06:57:50'),(30,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 13:59:19\"}','2025-10-06 06:59:19','2025-10-06 06:59:19'),(31,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-06 13:59:49\"}','2025-10-06 06:59:49','2025-10-06 06:59:49'),(32,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 14:10:44\"}','2025-10-06 07:10:44','2025-10-06 07:10:44'),(33,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-06 14:11:03\"}','2025-10-06 07:11:03','2025-10-06 07:11:03'),(34,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 16:13:38\"}','2025-10-06 09:13:38','2025-10-06 09:13:38'),(35,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-06 16:13:53\"}','2025-10-06 09:13:53','2025-10-06 09:13:53'),(36,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 16:20:00\"}','2025-10-06 09:20:00','2025-10-06 09:20:00'),(37,NULL,'failed_login','Percobaan login gagal','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 16:20:54\"}','2025-10-06 09:20:54','2025-10-06 09:20:54'),(38,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-06 16:20:58\"}','2025-10-06 09:20:58','2025-10-06 09:20:58'),(39,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 16:23:37\"}','2025-10-06 09:23:37','2025-10-06 09:23:37'),(40,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-06 16:23:48\"}','2025-10-06 09:23:48','2025-10-06 09:23:48'),(41,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-06 16:24:26\"}','2025-10-06 09:24:26','2025-10-06 09:24:26'),(42,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-06 16:24:49\"}','2025-10-06 09:24:49','2025-10-06 09:24:49'),(43,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 00:47:03\"}','2025-10-06 17:47:03','2025-10-06 17:47:03'),(44,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 00:47:24\"}','2025-10-06 17:47:24','2025-10-06 17:47:24'),(45,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 00:52:36\"}','2025-10-06 17:52:36','2025-10-06 17:52:36'),(46,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 00:52:58\"}','2025-10-06 17:52:58','2025-10-06 17:52:58'),(47,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 01:28:23\"}','2025-10-06 18:28:23','2025-10-06 18:28:23'),(48,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 01:29:26\"}','2025-10-06 18:29:26','2025-10-06 18:29:26'),(49,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 04:35:55\"}','2025-10-06 21:35:55','2025-10-06 21:35:55'),(50,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 04:36:14\"}','2025-10-06 21:36:14','2025-10-06 21:36:14'),(51,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 04:58:06\"}','2025-10-06 21:58:06','2025-10-06 21:58:06'),(52,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 05:00:42\"}','2025-10-06 22:00:42','2025-10-06 22:00:42'),(53,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 11:07:26\"}','2025-10-07 04:07:26','2025-10-07 04:07:26'),(54,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 12:54:30\"}','2025-10-07 05:54:30','2025-10-07 05:54:30'),(55,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 12:55:06\"}','2025-10-07 05:55:06','2025-10-07 05:55:06'),(56,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 13:05:07\"}','2025-10-07 06:05:07','2025-10-07 06:05:07'),(57,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 13:26:57\"}','2025-10-07 06:26:57','2025-10-07 06:26:57'),(58,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 13:28:54\"}','2025-10-07 06:28:54','2025-10-07 06:28:54'),(59,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 13:29:06\"}','2025-10-07 06:29:06','2025-10-07 06:29:06'),(60,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 13:29:22\"}','2025-10-07 06:29:22','2025-10-07 06:29:22'),(61,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 13:29:31\"}','2025-10-07 06:29:31','2025-10-07 06:29:31'),(62,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 13:29:42\"}','2025-10-07 06:29:42','2025-10-07 06:29:42'),(63,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 13:29:58\"}','2025-10-07 06:29:58','2025-10-07 06:29:58'),(64,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 13:30:27\"}','2025-10-07 06:30:27','2025-10-07 06:30:27'),(65,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 13:30:39\"}','2025-10-07 06:30:39','2025-10-07 06:30:39'),(66,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 13:31:06\"}','2025-10-07 06:31:06','2025-10-07 06:31:06'),(67,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 13:31:23\"}','2025-10-07 06:31:23','2025-10-07 06:31:23'),(68,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 13:31:50\"}','2025-10-07 06:31:50','2025-10-07 06:31:50'),(69,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 13:32:01\"}','2025-10-07 06:32:01','2025-10-07 06:32:01'),(70,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 15:50:32\"}','2025-10-07 08:50:32','2025-10-07 08:50:32'),(71,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 15:50:52\"}','2025-10-07 08:50:52','2025-10-07 08:50:52'),(72,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 15:51:46\"}','2025-10-07 08:51:46','2025-10-07 08:51:46'),(73,8,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"yasika123@gmail.com\", \"browser\": \"Chrome\", \"remember\": true, \"timestamp\": \"2025-10-07 15:54:18\"}','2025-10-07 08:54:18','2025-10-07 08:54:18'),(74,8,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"yasika123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 16:39:04\"}','2025-10-07 09:39:04','2025-10-07 09:39:04'),(75,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 16:39:25\"}','2025-10-07 09:39:25','2025-10-07 09:39:25'),(76,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 16:40:27\"}','2025-10-07 09:40:27','2025-10-07 09:40:27'),(77,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 16:40:54\"}','2025-10-07 09:40:54','2025-10-07 09:40:54'),(78,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 16:41:20\"}','2025-10-07 09:41:20','2025-10-07 09:41:20'),(79,8,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"yasika123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 16:41:40\"}','2025-10-07 09:41:40','2025-10-07 09:41:40'),(80,8,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"yasika123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 16:44:12\"}','2025-10-07 09:44:12','2025-10-07 09:44:12'),(81,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 16:44:31\"}','2025-10-07 09:44:31','2025-10-07 09:44:31'),(82,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 16:45:25\"}','2025-10-07 09:45:25','2025-10-07 09:45:25'),(83,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 16:45:54\"}','2025-10-07 09:45:54','2025-10-07 09:45:54'),(84,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 16:46:13\"}','2025-10-07 09:46:13','2025-10-07 09:46:13'),(85,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 16:48:28\"}','2025-10-07 09:48:28','2025-10-07 09:48:28'),(86,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 16:48:49\"}','2025-10-07 09:48:49','2025-10-07 09:48:49'),(87,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 16:51:00\"}','2025-10-07 09:51:00','2025-10-07 09:51:00'),(88,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 16:51:43\"}','2025-10-07 09:51:43','2025-10-07 09:51:43'),(89,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 16:52:02\"}','2025-10-07 09:52:02','2025-10-07 09:52:02'),(90,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 16:52:22\"}','2025-10-07 09:52:22','2025-10-07 09:52:22'),(91,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 16:52:33\"}','2025-10-07 09:52:33','2025-10-07 09:52:33'),(92,6,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 17:05:21\"}','2025-10-07 10:05:21','2025-10-07 10:05:21'),(93,3,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 17:05:35\"}','2025-10-07 10:05:35','2025-10-07 10:05:35'),(94,3,'logout','User logout dari sistem','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"admin@sewakonser.com\", \"browser\": \"Chrome\", \"timestamp\": \"2025-10-07 17:05:51\"}','2025-10-07 10:05:51','2025-10-07 10:05:51'),(95,6,'login','User berhasil login','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','{\"os\": \"Windows 10\", \"email\": \"najwa123@gmail.com\", \"browser\": \"Chrome\", \"remember\": false, \"timestamp\": \"2025-10-07 17:06:03\"}','2025-10-07 10:06:03','2025-10-07 10:06:03');
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
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
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
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
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `duration` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `carts_user_id_product_id_unique` (`user_id`,`product_id`),
  KEY `carts_user_id_product_id_index` (`user_id`,`product_id`),
  KEY `carts_product_id_foreign` (`product_id`),
  CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (41,6,15,2,'2025-10-07','2025-10-07',1,'2025-10-07 10:32:33','2025-10-07 10:51:55');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
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
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(5,'2025_09_21_082420_add_fields_to_users_table',2),(6,'2025_09_21_090201_create_personal_access_tokens_table',3),(7,'2025_09_21_093136_create_payments_table',4),(9,'2025_09_21_095357_create_products_table',5),(10,'2025_09_21_122838_add_role_to_users_table',5),(11,'2025_09_21_122953_create_orders_table',5),(12,'2025_09_21_123022_create_order_items_table',5),(13,'2025_09_21_150452_add_admin_fields_to_payments_table',6),(14,'2025_09_21_150519_create_activity_logs_table',6),(15,'2025_09_21_161105_update_products_table_add_fields',7),(16,'2025_09_27_084001_create_reviews_table',8),(17,'2025_09_27_111823_create_reviews_table',9),(18,'2025_09_27_152215_create_password_reset_tokens_table',9),(19,'2025_09_27_153707_add_audit_columns_to_password_reset_tokens_table',9),(20,'2025_09_27_171423_create_user_notifications_table',9),(21,'2025_10_04_042819_create_audit_logs_table',10),(22,'2025_10_05_160416_create_carts_table',11),(23,'2025_10_06_154306_add_order_id_to_payments_table',12),(24,'2025_10_07_033422_add_order_id_to_reviews_table',13),(25,'2025_10_07_034413_add_user_id_and_order_id_to_reviews_table',13),(26,'2025_10_07_150035_add_user_id_and_order_id_to_reviews_table',14);
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
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,15,1,70000.00,70000.00,'2025-10-06 09:15:17','2025-10-06 09:15:17'),(2,1,18,1,35000.00,35000.00,'2025-10-06 09:15:17','2025-10-06 09:15:17'),(3,2,19,2,45000.00,90000.00,'2025-10-07 06:28:40','2025-10-07 06:28:40'),(4,3,18,1,35000.00,35000.00,'2025-10-07 09:38:50','2025-10-07 09:38:50'),(5,4,14,1,75000.00,225000.00,'2025-10-07 09:44:00','2025-10-07 09:44:00'),(6,5,14,1,75000.00,75000.00,'2025-10-07 09:51:35','2025-10-07 09:51:35'),(7,6,12,1,150000.00,300000.00,'2025-10-07 10:05:16','2025-10-07 10:05:16');
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
  `order_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_proof` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_verified_at` timestamp NULL DEFAULT NULL,
  `rental_date` date NOT NULL,
  `rental_days` int NOT NULL DEFAULT '1',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'ORD-20251006-597C65',6,110000.00,'completed','bca','payment_proofs/payment_1759767317_6.jpg','2025-10-06 09:22:46','2025-10-06',1,NULL,'2025-10-06 09:15:17','2025-10-06 17:56:07'),(2,'ORD-20251007-808556',6,95000.00,'completed','mandiri','payment_proofs/payment_1759818518_6.jpg','2025-10-07 06:30:08','2025-10-07',1,NULL,'2025-10-07 06:28:40','2025-10-07 06:31:36'),(3,'ORD-20251007-A0ADB7',8,40000.00,'completed','bri','payment_proofs/payment_1759829930_8.jpg','2025-10-07 09:39:37','2025-10-07',1,NULL,'2025-10-07 09:38:50','2025-10-07 09:41:03'),(4,'ORD-20251007-048BD5',8,230000.00,'rented','mandiri','payment_proofs/payment_1759830240_8.jpg','2025-10-07 09:44:56','2025-10-07',3,NULL,'2025-10-07 09:44:00','2025-10-07 09:45:12'),(5,'ORD-20251007-76EC1D',6,80000.00,'waiting_verification','bca','payment_proofs/payment_1759830695_6.jpg',NULL,'2025-10-07',1,NULL,'2025-10-07 09:51:35','2025-10-07 09:51:35'),(6,'ORD-20251007-C36AD3',6,305000.00,'waiting_verification','bri','payment_proofs/payment_1759831516_6.jpg',NULL,'2025-10-07',2,NULL,'2025-10-07 10:05:16','2025-10-07 10:05:16');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `bank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_transfer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verified_by` bigint unsigned DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_user_id_foreign` (`user_id`),
  KEY `payments_verified_by_foreign` (`verified_by`),
  KEY `payments_order_id_foreign` (`order_id`),
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,NULL,'bca','bukti_transfer/1758456541_WhatsApp Image 2025-09-18 at 22.56.14_2f28c306.pdf','failed',NULL,'2025-09-21 05:09:01','2025-09-21 11:21:40',3,'2025-09-21 11:21:40'),(2,6,NULL,'mandiri','bukti_transfer/1758478797_WhatsApp Image 2025-09-18 at 22.56.14_0b1a4a09.jpg','success',NULL,'2025-09-21 11:19:57','2025-09-21 11:20:54',3,'2025-09-21 11:20:54'),(3,7,NULL,'bca','bukti_transfer/1758505310_WhatsApp Image 2025-09-18 at 22.56.14_0b1a4a09.jpg','success',NULL,'2025-09-21 18:41:50','2025-09-21 18:42:23',3,'2025-09-21 18:42:23'),(4,1,NULL,'mandiri','bukti_transfer/1758507623_M9-DM1-Decision Tree (1).pdf','failed',NULL,'2025-09-21 19:20:23','2025-09-21 19:25:28',3,'2025-09-21 19:25:28'),(5,6,NULL,'bri','bukti_transfer/1759743370_jas hujan.jpg','success',NULL,'2025-10-06 02:36:11','2025-10-06 03:31:37',3,'2025-10-06 03:31:37'),(6,6,1,'bca','payment_proofs/payment_1759767317_6.jpg','success',NULL,'2025-10-06 09:15:17','2025-10-06 09:22:46',3,'2025-10-06 09:22:46'),(7,6,2,'mandiri','payment_proofs/payment_1759818518_6.jpg','success',NULL,'2025-10-07 06:28:40','2025-10-07 06:30:08',3,'2025-10-07 06:30:08'),(8,8,3,'bri','payment_proofs/payment_1759829930_8.jpg','success',NULL,'2025-10-07 09:38:50','2025-10-07 09:39:37',3,'2025-10-07 09:39:37'),(9,8,4,'mandiri','payment_proofs/payment_1759830240_8.jpg','success',NULL,'2025-10-07 09:44:00','2025-10-07 09:44:56',3,'2025-10-07 09:44:56'),(10,6,5,'bca','payment_proofs/payment_1759830695_6.jpg','failed',NULL,'2025-10-07 09:51:35','2025-10-07 09:52:09',3,'2025-10-07 09:52:09'),(11,6,6,'bri','payment_proofs/payment_1759831516_6.jpg','failed',NULL,'2025-10-07 10:05:16','2025-10-07 10:05:43',3,'2025-10-07 10:05:43');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int NOT NULL DEFAULT '1',
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `features` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (12,'iPhone 15 Pro Max','iphone-15-pro-max','Smartphone flagship terbaru dari Apple dengan kamera pro dan performa tinggi. Cocok untuk konten kreator dan fotografer profesional.','handphone',150000.00,'products/1759683149_c46a1538-4102-496b-b7a2-2d53a4c05eae.jpg',4,1,'[\"48MP Camera\", \"5G Network\", \"Face ID\", \"Wireless Charging\", \"A17 Pro Chip\"]','2025-09-21 09:12:28','2025-10-07 10:05:16'),(13,'Samsung Galaxy S24 Ultra','samsung-galaxy-s24-ultra-1','Android flagship dengan S Pen dan kamera zoom 100x. Perfect untuk productivity dan creative work.','handphone',140000.00,'products/1759683220_samsung-galaxy-s24-ultra.jpg',3,1,'[\"200MP Camera\", \"100x Zoom\", \"S Pen\", \"5G Network\", \"AI Features\"]','2025-09-21 09:12:28','2025-10-06 08:07:07'),(14,'BTS Official Army Bomb Ver.4','bts-official-army-bomb-ver4-1','Official lightstick BTS untuk konser dan fan meeting. Dilengkapi dengan Bluetooth connectivity dan berbagai mode cahaya.','lightstick',75000.00,'products/1759683295_bts-lightstick-map-of-the-soul.jpg',8,1,'[\"Bluetooth Connectivity\", \"Multiple Light Modes\", \"Official Merchandise\", \"Rechargeable Battery\"]','2025-09-21 09:12:28','2025-10-07 09:51:35'),(15,'BLACKPINK Official Light Stick','blackpink-official-light-stick-1','Official lightstick BLACKPINK dengan desain hammer dan LED RGB yang cantik.','lightstick',70000.00,'products/1759683483_download-2.jpg',8,1,'[\"RGB LED\", \"Hammer Design\", \"Official License\", \"App Control\"]','2025-09-21 09:12:28','2025-10-06 17:56:07'),(16,'TWICE Official Candybong Z','twice-official-candybong-z-1','Lightstick resmi TWICE generasi terbaru dengan teknologi canggih dan desain yang eye-catching.','lightstick',65000.00,'products/1759683530_twice-official-candybong-z.jpg',6,1,'[\"Smart Control\", \"Colorful LED\", \"Official Product\", \"Long Battery Life\"]','2025-09-21 09:12:28','2025-10-06 08:07:05'),(17,'Powerbank Xiaomi 20000mAh','powerbank-xiaomi-20000mah-1','Powerbank berkualitas tinggi dengan kapasitas besar dan fast charging support.','powerbank',25000.00,'products/1759681328_powerbank-xiaomi-fast-charge-20000mah-18w-color-negro.jpg',15,1,'[\"20000mAh Capacity\", \"Fast Charging\", \"Dual USB Output\", \"LED Indicator\", \"Safety Protection\"]','2025-09-21 09:12:28','2025-10-06 08:07:14'),(18,'Anker PowerCore 26800mAh','anker-powercore-26800mah-1','Premium powerbank dengan kapasitas super besar dan teknologi PowerIQ untuk charging optimal.','powerbank',35000.00,'products/1759683576_anker-powercore-26800mah.jpg',12,1,'[\"26800mAh Ultra High Capacity\", \"PowerIQ Technology\", \"Triple USB Output\", \"Premium Build Quality\"]','2025-09-21 09:12:28','2025-10-07 09:41:03'),(19,'Powerbank Solar 30000mAh','powerbank-solar-30000mah','Powerbank dengan panel solar untuk charging outdoor. Ideal untuk camping dan event outdoor.','powerbank',45000.00,'products/1759683635_powerbank-solar-30000mah.jpg',8,1,'[\"Solar Panel\", \"30000mAh\", \"Waterproof\", \"LED Flashlight\", \"Wireless Charging\"]','2025-09-21 09:12:28','2025-10-07 06:31:36'),(20,'iPhone 14 Pro','iphone-14-pro-1','iPhone generasi sebelumnya yang masih powerful dengan kamera pro dan Dynamic Island.','handphone',120000.00,'products/1759681315_apple-iphone-14.jpg',2,1,'[\"48MP Camera\", \"Dynamic Island\", \"A16 Bionic\", \"ProRAW\", \"Cinematic Mode\"]','2025-09-21 09:12:28','2025-10-06 07:25:35'),(21,'SEVENTEEN Carat Bong Ver.2','seventeen-carat-bong-ver2-1','Official lightstick SEVENTEEN dengan bentuk diamond yang unik dan fitur Bluetooth.','lightstick',68000.00,'products/1759683701_seventeen-carat-bong.jpg',7,1,'[\"Diamond Shape\", \"Bluetooth Sync\", \"Official Merchandise\", \"Multi Color LED\"]','2025-09-21 09:12:28','2025-10-05 10:01:41'),(23,'iphone 15','iphone-15','baru, no minus, dan masih mulus','handphone',200000.00,'products/1759682610_iphone-15-prices-specs-features-colors-reviews.jpg',5,1,'[\"lengkap\"]','2025-10-05 09:43:30','2025-10-06 08:06:57'),(24,'Baseus Magnetic Powerbank','baseus-magnetic-powerbank','Baseus Magnetic Power Bank Battery Pack 6000mAh Wireless Portable Charger PD 20W with USB-C Cable, for MagSafe, for iPhone 14_13_12 Series','powerbank',100000.00,'products/1759760456_baseus-magnetic-power-bank-battery-pack-6000mah-wireless-portable-charger-pd-20w-with-usb-c-cable-for-magsafe-for-iphone-14-13-12-series-white-cell-phones-accessories.jpg',6,1,'[\"USB-C Cable\", \"6000mAh\", \"20W\"]','2025-10-06 07:20:56','2025-10-06 08:06:56'),(25,'Iphone 17 Pro','iphone-17-pro','New','handphone',300000.00,'products/1759770154_apple-iphone-17-pro.jpg',0,1,'[\"Lengkap\"]','2025-10-06 10:02:34','2025-10-06 10:02:34');
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
  `order_id` bigint unsigned DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  KEY `reviews_order_id_foreign` (`order_id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,6,15,1,'najwa zayuara',5,'lampunya masih terang','2025-10-06 21:00:06','2025-10-06 21:00:06'),(2,6,18,1,'najwa zayuara',5,'baterai powerbank awet','2025-10-06 21:00:06','2025-10-06 21:00:06'),(3,6,19,2,'najwa zayuara',5,'awet untuk pemakaian berjam jam','2025-10-07 08:33:55','2025-10-07 08:33:55'),(4,8,18,3,'yasika',2,'jelek banget boros','2025-10-07 09:42:09','2025-10-07 09:42:09');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
INSERT INTO `sessions` VALUES ('hRbIk5RpBXPq8CI5oprgSLI3RHU8LDtqHvoEIJXk',6,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVlVmSEZWTHRhQTJXN29GY2tFRXNmaFkzaklEb015OURmTmczdWVYWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVja291dCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjY7czoxMDoiY2FydF9jb3VudCI7aToyO30=',1759834315);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_notifications`
--

DROP TABLE IF EXISTS `user_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `user_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_notifications`
--

LOCK TABLES `user_notifications` WRITE;
/*!40000 ALTER TABLE `user_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ktp_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kk_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'katarina clarissa','katarina123@gmail.com','08152963028','jalan gubeng no 23','public/documents/nM2RQMgg0gRmYAS1PzsmtWnHcTWp9bDArmCXh7cO.pdf','public/documents/ffvGtXyHING9PC1RpC69Ff0OVKywnwNBUhxoqG9C.pdf',NULL,'$2y$12$LGrmNYDx6FjhUDKE3J6aVul.uNF.wpxwM7VA1kHjnT1FhCFQIzY1e','x4iqtE4JfC2FJfleoyLUwQqvrHDShB85BpFoNZHuOYmN4JnmYEtWrjFeGx90','customer',1,'2025-09-21 02:11:10','2025-09-21 02:11:10'),(2,'mentari faiza','mentari123@gmail.com','08375027582','jalan wisma permai no 89','public/documents/14Xiaqz90S0IG4u1ffcwac4pvyE9c6zlAaUvZF8J.pdf','public/documents/TqL5j7eYkKyMogbT5Z4QjMp4BGI6PcmoDbbmGT2r.pdf',NULL,'$2y$12$gpvNdfn6XrNDaM.MJOcCoe/yBFA1fHxMgmQNHZn.GUE6a8Xqia2ti',NULL,'customer',1,'2025-09-21 03:18:46','2025-09-21 03:18:46'),(3,'Admin System','admin@sewakonser.com','081234567890','Kantor Pusat Sewa Konser',NULL,NULL,'2025-09-21 05:43:47','$2y$12$tWqMuKkDkDUHuvKyuInHs.5Pf81FoEy1re5ZyA.suVgJl8D4vV2te','xyUBpb8ROaV3e3KahPOZOT6gaXrfjW9R3zmCeKqGdi2YOCu4c7ORwtp7Dm5M','admin',1,'2025-09-21 05:43:47','2025-09-21 05:43:47'),(4,'Admin System','admin@admin.com',NULL,NULL,NULL,NULL,NULL,'$2y$12$qfnZkvaXHdcu9/t0/wnWFuC3n1q1OSY/eMyYKagzJa12xd6/ChNii',NULL,'admin',1,'2025-09-21 08:21:37','2025-09-21 08:21:37'),(6,'najwa','najwa123@gmail.com','081234567890','jambi',NULL,NULL,NULL,'$2y$12$kWgvDHdCguIfbgWjnVIpyuMbE2zAPczxxEaqwYj4YxiKBQ70eufOm','AO1GfWSCI2pJDFlMKbtEgBupuTZEo8OzuINtViRDGysFdH9zDA607HxmUMfc','customer',1,'2025-09-21 11:14:54','2025-10-07 08:50:23'),(7,'aisya rizkya hidayah','aisyarizkya20@gmail.com','082332652757','mulyorejo utara surabaya',NULL,NULL,NULL,'$2y$12$Hccyel3xP7VoBIcXpDK22.dSB.n1GpUp257FKoo/jnWXSyy1OZ1m.',NULL,'customer',1,'2025-09-21 18:40:48','2025-10-07 05:55:33'),(8,'yasika','yasika123@gmail.com','081123456789','surabaya',NULL,NULL,NULL,'$2y$12$Y/6RfQNxyUHxpPNYw3a8Oevg2UAkp.boKts2A757xy3DQuW7Ex1Sy','DzOsEzYegewPgHBuTkV4iza6lWLCv7lurOc4urAt0kmVpkm5vTCjMVXRbPSw','customer',1,'2025-10-07 08:53:46','2025-10-07 08:53:46');
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

-- Dump completed on 2025-10-07 18:45:48
