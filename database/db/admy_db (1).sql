-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 01, 2022 at 09:22 AM
-- Server version: 8.0.28-0ubuntu0.20.04.3
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admy_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_audio_clips`
--

CREATE TABLE `tbl_audio_clips` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clip_path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_audio_clips`
--

INSERT INTO `tbl_audio_clips` (`id`, `category_id`, `title`, `clip_path`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'clip one', 'clips/clip_1662399727.mp3', 1, '2022-09-05 17:42:07', '2022-09-05 17:42:07');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_campaigns`
--

CREATE TABLE `tbl_campaigns` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `schedule_id` bigint UNSIGNED NOT NULL,
  `campaign_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions` int NOT NULL DEFAULT '0',
  `sent` int NOT NULL DEFAULT '0',
  `delivered` int NOT NULL DEFAULT '0',
  `parked` int NOT NULL DEFAULT '0',
  `status` enum('CREATED','RUNNING','PAUSED','ENDED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CREATED',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_campaigns`
--

INSERT INTO `tbl_campaigns` (`id`, `user_id`, `schedule_id`, `campaign_id`, `app_id`, `conversions`, `sent`, `delivered`, `parked`, `status`, `created_at`, `updated_at`) VALUES
(4, 1, 2, '71acdf2a-4867-4d4a-9c6c-842224f12e87', 'abdd34dd', 100, 0, 0, 0, 'CREATED', '2022-09-10 08:02:40', '2022-09-10 08:02:40'),
(5, 1, 3, 'd867abfd-9743-4ad9-9174-1a94a09ad5b5', 'abdd34dd', 50, 0, 0, 0, 'CREATED', '2022-09-10 09:12:25', '2022-09-10 09:12:25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`id`, `title`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Category One', 1, '2022-09-05 11:16:48', '2022-09-05 11:16:48'),
(2, 'Category Two', 1, '2022-09-05 11:16:58', '2022-09-05 11:16:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contacts`
--

CREATE TABLE `tbl_contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_discussions`
--

CREATE TABLE `tbl_discussions` (
  `id` bigint UNSIGNED NOT NULL,
  `ticket_id` bigint UNSIGNED NOT NULL,
  `sender` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_failed_jobs`
--

CREATE TABLE `tbl_failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_forgot_passwords`
--

CREATE TABLE `tbl_forgot_passwords` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login_tokens`
--

CREATE TABLE `tbl_login_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_migrations`
--

CREATE TABLE `tbl_migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_migrations`
--

INSERT INTO `tbl_migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_08_19_000000_create_failed_jobs_table', 1),
(2, '2021_05_06_202330_create_users_table', 1),
(3, '2021_05_06_204417_create_packs_table', 1),
(4, '2021_05_06_204835_create_verifications_table', 1),
(5, '2021_05_06_204853_create_forgot_passwords_table', 1),
(6, '2021_05_06_204932_create_user_packs_table', 1),
(7, '2021_05_06_204950_create_transactions_table', 1),
(8, '2021_05_06_205002_create_categories_table', 1),
(9, '2021_05_06_205022_create_audio_clips_table', 1),
(10, '2021_05_06_205038_create_schedules_table', 1),
(11, '2021_05_06_205056_create_reports_table', 1),
(12, '2021_05_27_105716_create_tickets_table', 1),
(13, '2021_06_02_093519_create_discussions_table', 1),
(14, '2021_07_15_142450_create_contacts_table', 1),
(15, '2021_07_18_170216_add_remaining_fields_to_transactions_table', 1),
(16, '2021_08_19_012014_create_login_tokens_table', 1),
(17, '2022_09_05_234707_create_push_s_m_s_table', 2),
(18, '2022_09_05_234846_create_s_m_s_table', 2),
(19, '2022_09_06_032511_create_s_m_s_schedules_table', 3),
(20, '2022_09_06_033059_create_user_s_m_s_table', 3),
(21, '2022_09_07_165636_create_s_m_s_purchases_table', 4),
(22, '2022_09_08_002719_create_campaigns_table', 5),
(23, '2022_09_10_104533_create_payment_histories_table', 6),
(24, '2022_09_10_223718_create_s_m_s_texts_table', 7),
(25, '2022_09_29_171048_create_web_apis_table', 8),
(26, '2022_10_01_064056_create_user_web_a_p_i_s_table', 9),
(27, '2022_10_01_073736_create_web_payment_histories_table', 10),
(28, '2022_10_01_083628_create_web_a_p_i_schedules_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_packs`
--

CREATE TABLE `tbl_packs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `unit_price` double(8,2) NOT NULL,
  `amount` bigint NOT NULL,
  `validity` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_packs`
--

INSERT INTO `tbl_packs` (`id`, `name`, `price`, `unit_price`, `amount`, `validity`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Starter', 5000.00, 0.07, 500000, 10, 1, '2022-09-05 17:42:59', '2022-09-16 17:03:12'),
(2, 'Basic', 30000.00, 0.06, 50000, 2, 1, '2022-09-16 17:02:51', '2022-09-16 17:02:51'),
(3, 'Popular', 30000.00, 0.05, 50000, 2, 1, '2022-09-16 17:03:45', '2022-09-16 17:03:45'),
(4, 'STANDARD', 30000.00, 0.00, 50000, 3, 1, '2022-09-16 17:04:20', '2022-09-16 17:04:20'),
(5, 'Corporate', 30000.00, 0.04, 50000, 2, 1, '2022-09-16 17:04:47', '2022-09-16 17:04:47');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_histories`
--

CREATE TABLE `tbl_payment_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `user_sms_id` bigint UNSIGNED NOT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trxID` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionStatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Initiated',
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `intent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sale',
  `merchantInvoiceNumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_payment_histories`
--

INSERT INTO `tbl_payment_histories` (`id`, `user_sms_id`, `payment_id`, `trxID`, `transactionStatus`, `amount`, `intent`, `merchantInvoiceNumber`, `created_at`, `updated_at`) VALUES
(1, 1, 'YWFZYMH1662795705612', '9IA35PUA5N', 'Completed', '5', 'sale', '2092396319', '2022-09-10 07:43:06', '2022-09-10 07:43:06'),
(2, 2, 'B47KBD31662800831070', '9IA85RYVJ2', 'Completed', '5', 'sale', '274243746', '2022-09-10 09:08:46', '2022-09-10 09:08:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_push_s_m_s`
--

CREATE TABLE `tbl_push_s_m_s` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reports`
--

CREATE TABLE `tbl_reports` (
  `id` bigint UNSIGNED NOT NULL,
  `schedule_id` bigint UNSIGNED NOT NULL,
  `sent_amount` bigint NOT NULL,
  `success_amount` bigint NOT NULL,
  `failed_amount` bigint NOT NULL,
  `subscribed_amount` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schedules`
--

CREATE TABLE `tbl_schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `clip_id` bigint UNSIGNED NOT NULL,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ussd_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schedule_time` datetime NOT NULL,
  `actual_delivery_time` datetime DEFAULT NULL,
  `obd_amount` bigint NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_s_m_s`
--

CREATE TABLE `tbl_s_m_s` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sms_category` enum('bulk','push') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sms_type` enum('Musking','Non-musking') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `unit_price` double(8,2) NOT NULL,
  `amount` bigint NOT NULL,
  `validity` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_s_m_s`
--

INSERT INTO `tbl_s_m_s` (`id`, `name`, `sms_category`, `sms_type`, `price`, `unit_price`, `amount`, `validity`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SMS Package One', 'push', 'Non-musking', 45000.00, 0.45, 5000, 50, 1, '2022-09-05 19:40:40', '2022-09-16 19:56:43'),
(2, 'Test SMS Package 2', 'push', 'Non-musking', 100000.00, 0.50, 300000, 30, 1, '2022-09-06 04:05:37', '2022-09-16 19:56:54'),
(3, 'Test Package -3', 'push', 'Musking', 5.00, 0.45, 200, 30, 1, '2022-09-07 15:11:11', '2022-09-10 06:19:09'),
(4, 'Test Package -3', 'bulk', 'Musking', 7700.00, 0.00, 300000, 30, 1, '2022-09-14 10:42:56', '2022-09-14 10:42:56'),
(5, 'SMS Package 5', 'bulk', 'Musking', 400000.00, 0.05, 40000, 30, 1, '2022-09-16 19:04:35', '2022-09-16 19:04:35');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_s_m_s_purchases`
--

CREATE TABLE `tbl_s_m_s_purchases` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `conversions` int NOT NULL DEFAULT '0',
  `package_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chanel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'push',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_s_m_s_schedules`
--

CREATE TABLE `tbl_s_m_s_schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sms_text_id` int NOT NULL,
  `app_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ussd_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `schedule_time` datetime NOT NULL,
  `actual_delivery_time` datetime DEFAULT NULL,
  `sms_amount` bigint NOT NULL,
  `is_content_up_to_date` tinyint(1) NOT NULL DEFAULT '0',
  `is_app_uat_done` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_s_m_s_schedules`
--

INSERT INTO `tbl_s_m_s_schedules` (`id`, `user_id`, `app_id`, `sms_text_id`, `app_name`, `ussd_code`, `keyword`, `remark`, `schedule_time`, `actual_delivery_time`, `sms_amount`, `is_content_up_to_date`, `is_app_uat_done`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 'abdd34dd', 1, 'test mane', '*213*234567', NULL, 'Test', '2022-09-11 00:00:00', NULL, 100, 1, 1, 1, '2022-09-10 07:55:22', '2022-09-10 08:02:40'),
(3, 1, 'abdd34dd', 1, 'test mane', '*213*234567', NULL, 'test', '2022-09-11 00:00:00', NULL, 50, 1, 1, 1, '2022-09-10 09:11:05', '2022-09-10 09:12:25'),
(4, 1, 'abdd34dd', 1, 'test mane', '*213*234567', NULL, 'Text', '2022-09-12 00:00:00', NULL, 50, 1, 1, 0, '2022-09-10 18:56:04', '2022-09-10 18:56:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_s_m_s_texts`
--

CREATE TABLE `tbl_s_m_s_texts` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_s_m_s_texts`
--

INSERT INTO `tbl_s_m_s_texts` (`id`, `category_id`, `text`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'This is test text one', 1, '2022-09-10 17:28:00', '2022-09-10 18:03:10'),
(2, 2, 'This is text two', 1, '2022-09-10 17:28:24', '2022-09-10 17:28:24');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tickets`
--

CREATE TABLE `tbl_tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply` text COLLATE utf8mb4_unicode_ci,
  `is_resolved` tinyint NOT NULL DEFAULT '0',
  `admin_seen` tinyint NOT NULL DEFAULT '0',
  `user_seen` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transactions`
--

CREATE TABLE `tbl_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `pack_id` bigint UNSIGNED NOT NULL,
  `transaction_id` text COLLATE utf8mb4_unicode_ci,
  `invoice_id` text COLLATE utf8mb4_unicode_ci,
  `payment_id` text COLLATE utf8mb4_unicode_ci,
  `error_code` text COLLATE utf8mb4_unicode_ci,
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `raw_response` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nid_no` text COLLATE utf8mb4_unicode_ci,
  `nid_path` text COLLATE utf8mb4_unicode_ci,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `mobile_no`, `password`, `email`, `nid_no`, `nid_path`, `role`, `is_verified`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Uzzal', '01788111408', '$2y$10$bXFhTmwAsOF/dv0zgIUn.uQCmvXcW8M/rPFJIqFf009lt0Qs5AR2C', 'hossenismail29@gmail.com', '3456789', NULL, 'user', 1, 1, '2022-09-05 10:59:41', '2022-09-05 10:59:41'),
(2, 'Admin', '01788111408', '$2y$10$iHg4dAvnovfia0TUJODBHuJ49.8zQpr0KtQJuQDPNBDrZZp6bMOnG', 'admin@example.com', '345', NULL, 'admin', 1, 1, '2022-09-05 11:04:54', '2022-09-05 11:04:54');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_packs`
--

CREATE TABLE `tbl_user_packs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `pack_id` bigint UNSIGNED NOT NULL,
  `amount` bigint NOT NULL,
  `valid_till` datetime NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_s_m_s`
--

CREATE TABLE `tbl_user_s_m_s` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `sms_id` bigint UNSIGNED NOT NULL,
  `package_id` text COLLATE utf8mb4_unicode_ci,
  `channel` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'push',
  `amount` bigint NOT NULL,
  `valid_till` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `payment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_user_s_m_s`
--

INSERT INTO `tbl_user_s_m_s` (`id`, `user_id`, `sms_id`, `package_id`, `channel`, `amount`, `valid_till`, `status`, `is_active`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '6d0cc5b2-31be-45b9-ba8e-dd89aee5195b', 'push', 200, '2022-10-10 13:41:42', 1, 1, 'Completed', '2022-09-10 07:41:42', '2022-09-10 07:43:08'),
(2, 1, 3, 'ce0db264-f218-4548-a8eb-074a608f8250', 'push', 200, '2022-10-10 15:07:08', 1, 1, 'Completed', '2022-09-10 09:07:08', '2022-09-10 09:08:47'),
(3, 1, 3, NULL, 'push', 200, '2022-10-11 14:12:40', 1, 0, 'Pending', '2022-09-11 08:12:40', '2022-09-11 08:12:40'),
(4, 1, 3, NULL, 'push', 200, '2022-10-11 14:13:12', 1, 0, 'Pending', '2022-09-11 08:13:12', '2022-09-11 08:13:12'),
(5, 1, 3, NULL, 'push', 200, '2022-10-11 14:13:35', 1, 0, 'Pending', '2022-09-11 08:13:35', '2022-09-11 08:13:35'),
(6, 1, 3, NULL, 'push', 200, '2022-10-11 14:14:47', 1, 0, 'Pending', '2022-09-11 08:14:47', '2022-09-11 08:14:47'),
(7, 1, 3, NULL, 'push', 200, '2022-10-11 14:15:36', 1, 0, 'Pending', '2022-09-11 08:15:36', '2022-09-11 08:15:36'),
(8, 1, 3, NULL, 'push', 200, '2022-10-11 14:16:25', 1, 0, 'Pending', '2022-09-11 08:16:25', '2022-09-11 08:16:25'),
(9, 1, 3, NULL, 'push', 200, '2022-10-11 14:17:16', 1, 0, 'Pending', '2022-09-11 08:17:16', '2022-09-11 08:17:16'),
(10, 1, 3, NULL, 'push', 200, '2022-10-11 14:17:29', 1, 0, 'Pending', '2022-09-11 08:17:29', '2022-09-11 08:17:29'),
(11, 1, 3, NULL, 'push', 200, '2022-10-11 14:17:49', 1, 0, 'Pending', '2022-09-11 08:17:49', '2022-09-11 08:17:49'),
(12, 1, 3, NULL, 'push', 200, '2022-10-11 14:18:05', 1, 0, 'Pending', '2022-09-11 08:18:05', '2022-09-11 08:18:05'),
(13, 1, 3, NULL, 'push', 200, '2022-10-11 14:18:44', 1, 0, 'Pending', '2022-09-11 08:18:44', '2022-09-11 08:18:44'),
(14, 1, 3, NULL, 'push', 200, '2022-10-11 14:19:14', 1, 0, 'Pending', '2022-09-11 08:19:14', '2022-09-11 08:19:14'),
(15, 1, 3, NULL, 'push', 200, '2022-10-11 14:19:51', 1, 0, 'Pending', '2022-09-11 08:19:51', '2022-09-11 08:19:51'),
(16, 1, 3, NULL, 'push', 200, '2022-10-11 14:20:08', 1, 0, 'Pending', '2022-09-11 08:20:08', '2022-09-11 08:20:08'),
(17, 1, 3, NULL, 'push', 200, '2022-10-11 14:21:08', 1, 0, 'Pending', '2022-09-11 08:21:08', '2022-09-11 08:21:08'),
(18, 1, 3, NULL, 'push', 200, '2022-10-11 14:22:02', 1, 0, 'Pending', '2022-09-11 08:22:02', '2022-09-11 08:22:02'),
(19, 1, 3, NULL, 'push', 200, '2022-10-11 14:23:41', 1, 0, 'Pending', '2022-09-11 08:23:41', '2022-09-11 08:23:41'),
(20, 1, 3, NULL, 'push', 200, '2022-10-11 14:25:16', 1, 0, 'Pending', '2022-09-11 08:25:16', '2022-09-11 08:25:16'),
(21, 1, 3, NULL, 'push', 200, '2022-10-11 14:25:54', 1, 0, 'Pending', '2022-09-11 08:25:54', '2022-09-11 08:25:54'),
(22, 1, 3, NULL, 'push', 200, '2022-10-11 14:27:43', 1, 0, 'Pending', '2022-09-11 08:27:43', '2022-09-11 08:27:43'),
(23, 1, 3, NULL, 'push', 200, '2022-10-11 14:27:47', 1, 0, 'Pending', '2022-09-11 08:27:47', '2022-09-11 08:27:47'),
(24, 1, 3, NULL, 'push', 200, '2022-10-11 14:27:50', 1, 0, 'Pending', '2022-09-11 08:27:50', '2022-09-11 08:27:50'),
(25, 1, 3, NULL, 'push', 200, '2022-10-11 14:30:24', 1, 0, 'Pending', '2022-09-11 08:30:24', '2022-09-11 08:30:24'),
(26, 1, 3, NULL, 'push', 200, '2022-10-11 14:31:11', 1, 0, 'Pending', '2022-09-11 08:31:11', '2022-09-11 08:31:11'),
(27, 1, 3, NULL, 'push', 200, '2022-10-11 14:31:40', 1, 0, 'Pending', '2022-09-11 08:31:40', '2022-09-11 08:31:40'),
(28, 1, 3, NULL, 'push', 200, '2022-10-11 14:35:33', 1, 0, 'Pending', '2022-09-11 08:35:33', '2022-09-11 08:35:33'),
(29, 1, 3, NULL, 'push', 200, '2022-10-11 14:36:32', 1, 0, 'Pending', '2022-09-11 08:36:32', '2022-09-11 08:36:32'),
(30, 1, 3, NULL, 'push', 200, '2022-10-11 14:37:22', 1, 0, 'Pending', '2022-09-11 08:37:22', '2022-09-11 08:37:22'),
(31, 1, 3, NULL, 'push', 200, '2022-10-11 14:37:52', 1, 0, 'Pending', '2022-09-11 08:37:52', '2022-09-11 08:37:52'),
(32, 1, 3, NULL, 'push', 200, '2022-10-11 14:38:04', 1, 0, 'Pending', '2022-09-11 08:38:04', '2022-09-11 08:38:04'),
(33, 1, 3, NULL, 'push', 200, '2022-10-11 14:38:18', 1, 0, 'Pending', '2022-09-11 08:38:18', '2022-09-11 08:38:18'),
(34, 1, 3, NULL, 'push', 200, '2022-10-11 14:38:24', 1, 0, 'Pending', '2022-09-11 08:38:24', '2022-09-11 08:38:24'),
(35, 1, 3, NULL, 'push', 200, '2022-10-11 14:38:55', 1, 0, 'Pending', '2022-09-11 08:38:55', '2022-09-11 08:38:55'),
(36, 1, 3, NULL, 'push', 200, '2022-10-11 14:47:10', 1, 0, 'Pending', '2022-09-11 08:47:10', '2022-09-11 08:47:10'),
(37, 1, 2, NULL, 'push', 300000, '2022-10-20 23:27:28', 1, 0, 'Pending', '2022-09-20 17:27:28', '2022-09-20 17:27:28'),
(38, 1, 2, NULL, 'push', 300000, '2022-10-20 23:29:27', 1, 0, 'Pending', '2022-09-20 17:29:27', '2022-09-20 17:29:27'),
(39, 1, 1, NULL, 'push', 5000, '2022-11-09 23:30:51', 1, 0, 'Pending', '2022-09-20 17:30:51', '2022-09-20 17:30:51'),
(40, 1, 1, NULL, 'push', 5000, '2022-11-20 01:54:54', 1, 0, 'Pending', '2022-09-30 19:54:54', '2022-09-30 19:54:54'),
(41, 1, 1, NULL, 'push', 5000, '2022-11-20 01:58:35', 1, 0, 'Pending', '2022-09-30 19:58:35', '2022-09-30 19:58:35'),
(42, 1, 1, NULL, 'push', 5000, '2022-11-20 02:04:25', 1, 0, 'Pending', '2022-09-30 20:04:25', '2022-09-30 20:04:25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_web_a_p_i_s`
--

CREATE TABLE `tbl_user_web_a_p_i_s` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `web_api_id` bigint UNSIGNED NOT NULL,
  `payment_status` enum('Pending','Paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `acquisition` int UNSIGNED NOT NULL DEFAULT '0',
  `price` double(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_user_web_a_p_i_s`
--

INSERT INTO `tbl_user_web_a_p_i_s` (`id`, `user_id`, `web_api_id`, `payment_status`, `acquisition`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Pending', 5000, 100.00, 0, '2022-10-01 01:02:27', '2022-10-01 01:02:27'),
(2, 1, 2, 'Pending', 5000, 100.00, 0, '2022-10-01 01:03:01', '2022-10-01 01:03:01'),
(3, 1, 3, 'Pending', 200, 4000.00, 0, '2022-10-01 01:07:33', '2022-10-01 01:07:33'),
(4, 1, 1, 'Pending', 10, 0.00, 0, '2022-10-01 01:30:41', '2022-10-01 01:30:41'),
(5, 1, 1, 'Pending', 100, 1320.00, 0, '2022-10-01 01:34:06', '2022-10-01 01:34:06'),
(6, 1, 1, 'Pending', 100, 1320.00, 0, '2022-10-01 01:51:31', '2022-10-01 01:51:31'),
(7, 1, 1, 'Pending', 100, 1320.00, 0, '2022-10-01 01:52:48', '2022-10-01 01:52:48'),
(8, 1, 3, 'Pending', 200, 4000.00, 0, '2022-10-01 09:22:05', '2022-10-01 09:22:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_verifications`
--

CREATE TABLE `tbl_verifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_verifications`
--

INSERT INTO `tbl_verifications` (`id`, `user_id`, `token`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '1662375581', 0, '2022-09-05 10:59:41', '2022-09-05 10:59:41'),
(2, 2, '1662375894', 0, '2022-09-05 11:04:54', '2022-09-05 11:04:54');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_web_apis`
--

CREATE TABLE `tbl_web_apis` (
  `id` bigint UNSIGNED NOT NULL,
  `acquisition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_web_apis`
--

INSERT INTO `tbl_web_apis` (`id`, `acquisition`, `price`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, '0', 13.20, NULL, 1, '2022-09-29 11:41:14', '2022-09-30 18:17:58'),
(2, '5000', 100.00, NULL, 1, '2022-09-30 18:18:10', '2022-09-30 18:18:10'),
(3, '200', 4000.00, NULL, 1, '2022-09-30 18:18:21', '2022-09-30 18:18:21'),
(4, '3000', 3400.00, NULL, 1, '2022-09-30 18:19:21', '2022-09-30 18:19:21'),
(5, '1000', 30000.00, NULL, 1, '2022-09-30 18:19:32', '2022-09-30 18:19:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_web_a_p_i_schedules`
--

CREATE TABLE `tbl_web_a_p_i_schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `dev_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dev_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dev_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deposit_slip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int UNSIGNED DEFAULT NULL,
  `schedule_time` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_web_a_p_i_schedules`
--

INSERT INTO `tbl_web_a_p_i_schedules` (`id`, `user_id`, `dev_name`, `dev_email`, `dev_number`, `app_id`, `app_name`, `app_type`, `deposit_slip`, `category_id`, `schedule_time`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ismail', 'ismail@gamil.com', '01788111408', '4567789', 'test name', 'test type', '2022100108568tJ2iZ767XhDsyb42kHA1Be0p.jpeg', 1, '2022-10-11 00:00:00', 1, '2022-10-01 02:56:48', '2022-10-01 03:58:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_web_payment_histories`
--

CREATE TABLE `tbl_web_payment_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `user_web_api_id` bigint UNSIGNED NOT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trxID` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionStatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Initiated',
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `intent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sale',
  `merchantInvoiceNumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_audio_clips`
--
ALTER TABLE `tbl_audio_clips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_audio_clips_category_id_foreign` (`category_id`);

--
-- Indexes for table `tbl_campaigns`
--
ALTER TABLE `tbl_campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_campaigns_user_id_foreign` (`user_id`),
  ADD KEY `tbl_campaigns_schedule_id_foreign` (`schedule_id`);

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contacts`
--
ALTER TABLE `tbl_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_discussions`
--
ALTER TABLE `tbl_discussions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_discussions_ticket_id_foreign` (`ticket_id`);

--
-- Indexes for table `tbl_failed_jobs`
--
ALTER TABLE `tbl_failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_forgot_passwords`
--
ALTER TABLE `tbl_forgot_passwords`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_forgot_passwords_user_id_foreign` (`user_id`);

--
-- Indexes for table `tbl_login_tokens`
--
ALTER TABLE `tbl_login_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_login_tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `tbl_migrations`
--
ALTER TABLE `tbl_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_packs`
--
ALTER TABLE `tbl_packs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_payment_histories`
--
ALTER TABLE `tbl_payment_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_push_s_m_s`
--
ALTER TABLE `tbl_push_s_m_s`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_reports_schedule_id_foreign` (`schedule_id`);

--
-- Indexes for table `tbl_schedules`
--
ALTER TABLE `tbl_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_schedules_user_id_foreign` (`user_id`),
  ADD KEY `tbl_schedules_category_id_foreign` (`category_id`),
  ADD KEY `tbl_schedules_clip_id_foreign` (`clip_id`);

--
-- Indexes for table `tbl_s_m_s`
--
ALTER TABLE `tbl_s_m_s`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_s_m_s_purchases`
--
ALTER TABLE `tbl_s_m_s_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_s_m_s_purchases_user_id_foreign` (`user_id`);

--
-- Indexes for table `tbl_s_m_s_schedules`
--
ALTER TABLE `tbl_s_m_s_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_s_m_s_schedules_user_id_foreign` (`user_id`);

--
-- Indexes for table `tbl_s_m_s_texts`
--
ALTER TABLE `tbl_s_m_s_texts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_s_m_s_texts_category_id_foreign` (`category_id`);

--
-- Indexes for table `tbl_tickets`
--
ALTER TABLE `tbl_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_tickets_user_id_foreign` (`user_id`);

--
-- Indexes for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_transactions_user_id_foreign` (`user_id`),
  ADD KEY `tbl_transactions_pack_id_foreign` (`pack_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_packs`
--
ALTER TABLE `tbl_user_packs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_user_packs_user_id_foreign` (`user_id`),
  ADD KEY `tbl_user_packs_pack_id_foreign` (`pack_id`);

--
-- Indexes for table `tbl_user_s_m_s`
--
ALTER TABLE `tbl_user_s_m_s`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_user_s_m_s_user_id_foreign` (`user_id`),
  ADD KEY `tbl_user_s_m_s_sms_id_foreign` (`sms_id`);

--
-- Indexes for table `tbl_user_web_a_p_i_s`
--
ALTER TABLE `tbl_user_web_a_p_i_s`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_user_web_a_p_i_s_user_id_foreign` (`user_id`),
  ADD KEY `tbl_user_web_a_p_i_s_web_api_id_foreign` (`web_api_id`);

--
-- Indexes for table `tbl_verifications`
--
ALTER TABLE `tbl_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_verifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `tbl_web_apis`
--
ALTER TABLE `tbl_web_apis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_web_a_p_i_schedules`
--
ALTER TABLE `tbl_web_a_p_i_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_web_a_p_i_schedules_user_id_foreign` (`user_id`);

--
-- Indexes for table `tbl_web_payment_histories`
--
ALTER TABLE `tbl_web_payment_histories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_audio_clips`
--
ALTER TABLE `tbl_audio_clips`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_campaigns`
--
ALTER TABLE `tbl_campaigns`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_contacts`
--
ALTER TABLE `tbl_contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_discussions`
--
ALTER TABLE `tbl_discussions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_failed_jobs`
--
ALTER TABLE `tbl_failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_forgot_passwords`
--
ALTER TABLE `tbl_forgot_passwords`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_login_tokens`
--
ALTER TABLE `tbl_login_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_migrations`
--
ALTER TABLE `tbl_migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_packs`
--
ALTER TABLE `tbl_packs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_payment_histories`
--
ALTER TABLE `tbl_payment_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_push_s_m_s`
--
ALTER TABLE `tbl_push_s_m_s`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_schedules`
--
ALTER TABLE `tbl_schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_s_m_s`
--
ALTER TABLE `tbl_s_m_s`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_s_m_s_purchases`
--
ALTER TABLE `tbl_s_m_s_purchases`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_s_m_s_schedules`
--
ALTER TABLE `tbl_s_m_s_schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_s_m_s_texts`
--
ALTER TABLE `tbl_s_m_s_texts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_tickets`
--
ALTER TABLE `tbl_tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_user_packs`
--
ALTER TABLE `tbl_user_packs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user_s_m_s`
--
ALTER TABLE `tbl_user_s_m_s`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tbl_user_web_a_p_i_s`
--
ALTER TABLE `tbl_user_web_a_p_i_s`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_verifications`
--
ALTER TABLE `tbl_verifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_web_apis`
--
ALTER TABLE `tbl_web_apis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_web_a_p_i_schedules`
--
ALTER TABLE `tbl_web_a_p_i_schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_web_payment_histories`
--
ALTER TABLE `tbl_web_payment_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_audio_clips`
--
ALTER TABLE `tbl_audio_clips`
  ADD CONSTRAINT `tbl_audio_clips_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_campaigns`
--
ALTER TABLE `tbl_campaigns`
  ADD CONSTRAINT `tbl_campaigns_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `tbl_s_m_s_schedules` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_campaigns_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_discussions`
--
ALTER TABLE `tbl_discussions`
  ADD CONSTRAINT `tbl_discussions_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tbl_tickets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_forgot_passwords`
--
ALTER TABLE `tbl_forgot_passwords`
  ADD CONSTRAINT `tbl_forgot_passwords_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_login_tokens`
--
ALTER TABLE `tbl_login_tokens`
  ADD CONSTRAINT `tbl_login_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  ADD CONSTRAINT `tbl_reports_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `tbl_schedules` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_schedules`
--
ALTER TABLE `tbl_schedules`
  ADD CONSTRAINT `tbl_schedules_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_schedules_clip_id_foreign` FOREIGN KEY (`clip_id`) REFERENCES `tbl_audio_clips` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_s_m_s_purchases`
--
ALTER TABLE `tbl_s_m_s_purchases`
  ADD CONSTRAINT `tbl_s_m_s_purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_s_m_s_schedules`
--
ALTER TABLE `tbl_s_m_s_schedules`
  ADD CONSTRAINT `tbl_s_m_s_schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_s_m_s_texts`
--
ALTER TABLE `tbl_s_m_s_texts`
  ADD CONSTRAINT `tbl_s_m_s_texts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_tickets`
--
ALTER TABLE `tbl_tickets`
  ADD CONSTRAINT `tbl_tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  ADD CONSTRAINT `tbl_transactions_pack_id_foreign` FOREIGN KEY (`pack_id`) REFERENCES `tbl_packs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_user_packs`
--
ALTER TABLE `tbl_user_packs`
  ADD CONSTRAINT `tbl_user_packs_pack_id_foreign` FOREIGN KEY (`pack_id`) REFERENCES `tbl_packs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_user_packs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_user_s_m_s`
--
ALTER TABLE `tbl_user_s_m_s`
  ADD CONSTRAINT `tbl_user_s_m_s_sms_id_foreign` FOREIGN KEY (`sms_id`) REFERENCES `tbl_s_m_s` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_user_s_m_s_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_user_web_a_p_i_s`
--
ALTER TABLE `tbl_user_web_a_p_i_s`
  ADD CONSTRAINT `tbl_user_web_a_p_i_s_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_user_web_a_p_i_s_web_api_id_foreign` FOREIGN KEY (`web_api_id`) REFERENCES `tbl_web_apis` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_verifications`
--
ALTER TABLE `tbl_verifications`
  ADD CONSTRAINT `tbl_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_web_a_p_i_schedules`
--
ALTER TABLE `tbl_web_a_p_i_schedules`
  ADD CONSTRAINT `tbl_web_a_p_i_schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
