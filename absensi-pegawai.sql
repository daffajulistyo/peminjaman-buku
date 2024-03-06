-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: absensi-pegawai
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `absensis`
--

DROP TABLE IF EXISTS `absensis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `absensis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `absensis`
--

LOCK TABLES `absensis` WRITE;
/*!40000 ALTER TABLE `absensis` DISABLE KEYS */;
INSERT INTO `absensis` VALUES (1,'Daffa Julistio','2023-09-26','14:59:17','2023-09-26 00:59:17','2023-09-26 00:59:17'),(2,'Daffa Julistio','2023-09-26','15:11:07','2023-09-26 01:11:07','2023-09-26 01:11:07'),(3,'Daffa Julistio','2023-09-26','15:11:08','2023-09-26 01:11:08','2023-09-26 01:11:08'),(4,'Daffa Julistio','2023-09-26','15:11:09','2023-09-26 01:11:09','2023-09-26 01:11:09'),(5,'Dennis Horne','2023-09-26','15:22:24','2023-09-26 01:22:24','2023-09-26 01:22:24'),(6,'Dennis Horne','2023-09-26','15:22:27','2023-09-26 01:22:27','2023-09-26 01:22:27'),(7,'Dennis Horne','2023-09-26','15:22:28','2023-09-26 01:22:28','2023-09-26 01:22:28'),(8,'Daffa Julistio','2023-09-26','15:54:17','2023-09-26 01:54:17','2023-09-26 01:54:17'),(9,'Dennis Horne','2023-09-26','15:54:44','2023-09-26 01:54:44','2023-09-26 01:54:44'),(10,'Daffa Julistio','2023-09-26','21:29:23','2023-09-26 07:29:23','2023-09-26 07:29:23'),(11,'Daffa Julistio','2023-09-26','21:54:58','2023-09-26 07:54:58','2023-09-26 07:54:58');
/*!40000 ALTER TABLE `absensis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bidangs`
--

DROP TABLE IF EXISTS `bidangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bidangs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bidangs`
--

LOCK TABLES `bidangs` WRITE;
/*!40000 ALTER TABLE `bidangs` DISABLE KEYS */;
INSERT INTO `bidangs` VALUES (1,'Teknologi Informasi','2023-09-26 00:59:53','2023-09-26 00:59:53'),(2,'Pemerintahan','2023-09-26 01:26:11','2023-09-26 01:26:11'),(3,'Hubungan Masyarakat','2023-09-26 01:26:23','2023-09-26 01:26:23');
/*!40000 ALTER TABLE `bidangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `books` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_buku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul_buku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penulis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_terbit` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `books_kode_buku_unique` (`kode_buku`),
  KEY `books_user_id_foreign` (`user_id`),
  CONSTRAINT `books_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
-- Table structure for table `hps`
--

DROP TABLE IF EXISTS `hps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nohp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identitas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `odp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hps`
--

LOCK TABLES `hps` WRITE;
/*!40000 ALTER TABLE `hps` DISABLE KEYS */;
INSERT INTO `hps` VALUES (1,'Dennis Horne','Realme','081546467979','Pribadi','Pemerintahan','2023-09-26 01:01:49','2023-09-26 01:01:49');
/*!40000 ALTER TABLE `hps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jabatans`
--

DROP TABLE IF EXISTS `jabatans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jabatans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jabatans`
--

LOCK TABLES `jabatans` WRITE;
/*!40000 ALTER TABLE `jabatans` DISABLE KEYS */;
INSERT INTO `jabatans` VALUES (1,'Kepala Dinas','2023-09-26 01:00:02','2023-09-26 01:00:02'),(2,'SEKRETARIS DAERAH','2023-09-26 01:26:46','2023-09-26 01:26:46'),(3,'KEPALA BAGIAN PEMERINTAHAN','2023-09-26 01:26:56','2023-09-26 01:26:56');
/*!40000 ALTER TABLE `jabatans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `koordinats`
--

DROP TABLE IF EXISTS `koordinats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `koordinats` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_opd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `koordinat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `koordinats`
--

LOCK TABLES `koordinats` WRITE;
/*!40000 ALTER TABLE `koordinats` DISABLE KEYS */;
INSERT INTO `koordinats` VALUES (1,'BUPATI','Lubuk Sikaping','0.1405933183229352, 100.16768078533809','2023-09-26 01:29:06','2023-09-26 01:29:06');
/*!40000 ALTER TABLE `koordinats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loan_requests`
--

DROP TABLE IF EXISTS `loan_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loan_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `book_id` bigint(20) unsigned NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tanggal_peminjaman` date NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `status` enum('pending','approved','returned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `loan_requests_user_id_foreign` (`user_id`),
  KEY `loan_requests_book_id_foreign` (`book_id`),
  CONSTRAINT `loan_requests_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `loan_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loan_requests`
--

LOCK TABLES `loan_requests` WRITE;
/*!40000 ALTER TABLE `loan_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `loan_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2014_10_12_100000_create_password_resets_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2023_06_21_171955_create_books_table',1),(7,'2023_06_23_173601_create_loan_requests_table',1),(8,'2023_06_23_175021_add_user_id_to_books_table',1),(9,'2023_06_23_175325_add_book_id_to_users_table',1),(10,'2023_06_24_045402_add_dates_to_loan_requests_table',1),(11,'2023_06_24_134006_add_status_to_loan_requests',1),(12,'2023_09_26_023230_create_pegawai_table',1),(13,'2023_09_26_032504_create_koordinat_table',1),(14,'2023_09_26_035222_create_absensi_table',1),(15,'2023_09_26_061416_create_opd_table',1),(16,'2023_09_26_061521_create_bidangs_table',1),(17,'2023_09_26_061527_create_jabatans_table',1),(18,'2023_09_26_061539_create_pangkats_table',1),(19,'2023_09_26_071939_create_hps_table',1),(20,'2023_09_26_084710_add_opd_id_to_pegawai',2),(21,'2023_09_26_125235_add_columns_to_users_table',3),(22,'2023_09_26_130431_add_relations_to_users_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opds`
--

DROP TABLE IF EXISTS `opds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opds` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opds`
--

LOCK TABLES `opds` WRITE;
/*!40000 ALTER TABLE `opds` DISABLE KEYS */;
INSERT INTO `opds` VALUES (2,'Sekretariat Daerah','2023-09-26 01:23:49','2023-09-26 01:23:49'),(3,'Sekretariat DPRD','2023-09-26 01:24:00','2023-09-26 01:24:00'),(4,'Inspektorat','2023-09-26 01:24:09','2023-09-26 01:24:09'),(5,'Dinas Pendidikan','2023-09-26 01:24:22','2023-09-26 01:24:22'),(6,'Dinas Kesehatan','2023-09-26 01:24:30','2023-09-26 01:24:30');
/*!40000 ALTER TABLE `opds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pangkats`
--

DROP TABLE IF EXISTS `pangkats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pangkats` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pangkats`
--

LOCK TABLES `pangkats` WRITE;
/*!40000 ALTER TABLE `pangkats` DISABLE KEYS */;
INSERT INTO `pangkats` VALUES (2,'IV A','2023-09-26 01:27:27','2023-09-26 01:27:27'),(3,'IV B','2023-09-26 01:27:33','2023-09-26 01:27:33'),(4,'IV C','2023-09-26 01:27:38','2023-09-26 01:27:38');
/*!40000 ALTER TABLE `pangkats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pegawais`
--

DROP TABLE IF EXISTS `pegawais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pegawais` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bidang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pangkat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('PNS','PPPK','Honor Daerah','Kontrak') COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `opd_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pegawais_nip_unique` (`nip`),
  KEY `pegawais_opd_id_foreign` (`opd_id`),
  CONSTRAINT `pegawais_opd_id_foreign` FOREIGN KEY (`opd_id`) REFERENCES `opds` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pegawais`
--

LOCK TABLES `pegawais` WRITE;
/*!40000 ALTER TABLE `pegawais` DISABLE KEYS */;
INSERT INTO `pegawais` VALUES (1,'Jhon Wick','45457871','Pemerintahan','IT','Pelaksana','Belum','PPPK','081546487979','2023-09-26 01:01:02','2023-09-26 01:01:02',NULL);
/*!40000 ALTER TABLE `pegawais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `book_id` bigint(20) unsigned DEFAULT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('PNS','PPPK','Honor Daerah','Kontrak') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nohp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opd_id` bigint(20) unsigned DEFAULT NULL,
  `bidang_id` bigint(20) unsigned DEFAULT NULL,
  `jabatan_id` bigint(20) unsigned DEFAULT NULL,
  `pangkat_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_book_id_foreign` (`book_id`),
  KEY `users_opd_id_foreign` (`opd_id`),
  KEY `users_bidang_id_foreign` (`bidang_id`),
  KEY `users_jabatan_id_foreign` (`jabatan_id`),
  KEY `users_pangkat_id_foreign` (`pangkat_id`),
  CONSTRAINT `users_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `bidangs` (`id`),
  CONSTRAINT `users_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatans` (`id`),
  CONSTRAINT `users_opd_id_foreign` FOREIGN KEY (`opd_id`) REFERENCES `opds` (`id`),
  CONSTRAINT `users_pangkat_id_foreign` FOREIGN KEY (`pangkat_id`) REFERENCES `pangkats` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Daffa Julistio','daffa@gmail.com',NULL,'$2y$10$2k/GsBRQcDjqER7uG3G10.W479sDX46YYuIwSEWXEUaDnFZeFRv9i','1',NULL,'2023-09-26 00:55:26','2023-09-26 00:55:26',NULL,'12345678','Honor Daerah','084579798484',NULL,NULL,NULL,NULL),(2,'Winifred Navarro','moxukyx@mailinator.com',NULL,'$2y$10$D0UnRJfTnYztHiYcr9.a/OUTnyH1LyJkEPec7p8csjDOawC97PGFy','2',NULL,'2023-09-26 00:58:03','2023-09-26 07:29:00',NULL,'7','PNS','49',6,2,1,4),(11,'Fiona Burt','sereto@mailinator.com',NULL,'$2y$10$flq6ehFvy.kqqnGnIV1nQ.KGYGqHfpZGYagzPbL2krBRfWShLnx66','1',NULL,'2023-09-26 07:06:18','2023-09-26 07:27:34',NULL,'Jaime Castro','PPPK','89465132',6,3,1,2);
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

-- Dump completed on 2023-09-27  2:39:45
