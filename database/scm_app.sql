-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 08, 2026 at 09:43 AM
-- Server version: 11.7.2-MariaDB-log
-- PHP Version: 8.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scm_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `approval_flows`
--

CREATE TABLE `approval_flows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `approval_logs`
--

CREATE TABLE `approval_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `approvable_type` varchar(255) NOT NULL,
  `approvable_id` bigint(20) UNSIGNED NOT NULL,
  `approval_flow_id` bigint(20) UNSIGNED NOT NULL,
  `current_step_order` int(11) NOT NULL DEFAULT 1,
  `current_role_needed` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `approval_steps`
--

CREATE TABLE `approval_steps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `approval_flow_id` bigint(20) UNSIGNED NOT NULL,
  `order` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `approver_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` enum('plant','warehouse','office') NOT NULL DEFAULT 'plant',
  `phone_ext` varchar(255) DEFAULT NULL,
  `manager_name` varchar(255) DEFAULT NULL,
  `total_manpower` int(11) NOT NULL DEFAULT 0,
  `address` text DEFAULT NULL,
  `map_url` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `company_id`, `code`, `name`, `category`, `phone_ext`, `manager_name`, `total_manpower`, `address`, `map_url`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 1, 'PLT-001', 'Schlemmer Main Factory', 'plant', NULL, NULL, 1, NULL, '{\"lat\":-6.357244488885727,\"lng\":107.13917181698545}', 1, '2026-04-07 04:44:36', '2026-04-07 04:51:11', NULL),
(4, 1, 'PLT-002', 'Schlemmer Warehouse', 'warehouse', NULL, NULL, 1, NULL, '{\"lat\":-6.365646590727521,\"lng\":107.15562343597414}', 1, '2026-04-07 04:57:02', '2026-04-07 04:57:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('scm_application_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:96:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:12:\"ViewAny:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:9:\"View:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:11:\"Create:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:11:\"Update:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:11:\"Delete:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:14:\"DeleteAny:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:12:\"Restore:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:16:\"ForceDelete:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:19:\"ForceDeleteAny:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:15:\"RestoreAny:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:14:\"Replicate:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:12:\"Reorder:Role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:12:\"ViewAny:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:9:\"View:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:11:\"Create:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:11:\"Update:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:11:\"Delete:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:14:\"DeleteAny:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:12:\"Restore:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:16:\"ForceDelete:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:19:\"ForceDeleteAny:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:15:\"RestoreAny:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:14:\"Replicate:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:12:\"Reorder:User\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:14:\"ViewAny:Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:11:\"View:Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:13:\"Create:Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:13:\"Update:Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:13:\"Delete:Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:16:\"DeleteAny:Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:14:\"Restore:Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:18:\"ForceDelete:Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:21:\"ForceDeleteAny:Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:17:\"RestoreAny:Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:16:\"Replicate:Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:14:\"Reorder:Branch\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:15:\"ViewAny:Company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:12:\"View:Company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:14:\"Create:Company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:14:\"Update:Company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:14:\"Delete:Company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:17:\"DeleteAny:Company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:15:\"Restore:Company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:19:\"ForceDelete:Company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:22:\"ForceDeleteAny:Company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:18:\"RestoreAny:Company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:17:\"Replicate:Company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:15:\"Reorder:Company\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:16:\"ViewAny:Currency\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:13:\"View:Currency\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:15:\"Create:Currency\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:15:\"Update:Currency\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:15:\"Delete:Currency\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:18:\"DeleteAny:Currency\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:16:\"Restore:Currency\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:20:\"ForceDelete:Currency\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:23:\"ForceDeleteAny:Currency\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:19:\"RestoreAny:Currency\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:18:\"Replicate:Currency\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:16:\"Reorder:Currency\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:16:\"ViewAny:Customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:13:\"View:Customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:15:\"Create:Customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:15:\"Update:Customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:15:\"Delete:Customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:18:\"DeleteAny:Customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:16:\"Restore:Customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:20:\"ForceDelete:Customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:23:\"ForceDeleteAny:Customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:69;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:19:\"RestoreAny:Customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:70;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:18:\"Replicate:Customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:71;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:16:\"Reorder:Customer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:72;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:16:\"ViewAny:Supplier\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:73;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:13:\"View:Supplier\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:74;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:15:\"Create:Supplier\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:75;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:15:\"Update:Supplier\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:15:\"Delete:Supplier\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:18:\"DeleteAny:Supplier\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:78;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:16:\"Restore:Supplier\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:79;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:20:\"ForceDelete:Supplier\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:80;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:23:\"ForceDeleteAny:Supplier\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:81;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:19:\"RestoreAny:Supplier\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:82;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:18:\"Replicate:Supplier\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:83;a:4:{s:1:\"a\";i:84;s:1:\"b\";s:16:\"Reorder:Supplier\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:84;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:16:\"ViewAny:TimeZone\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:85;a:4:{s:1:\"a\";i:86;s:1:\"b\";s:13:\"View:TimeZone\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:86;a:4:{s:1:\"a\";i:87;s:1:\"b\";s:15:\"Create:TimeZone\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:87;a:4:{s:1:\"a\";i:88;s:1:\"b\";s:15:\"Update:TimeZone\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:88;a:4:{s:1:\"a\";i:89;s:1:\"b\";s:15:\"Delete:TimeZone\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:89;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:18:\"DeleteAny:TimeZone\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:90;a:4:{s:1:\"a\";i:91;s:1:\"b\";s:16:\"Restore:TimeZone\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:91;a:4:{s:1:\"a\";i:92;s:1:\"b\";s:20:\"ForceDelete:TimeZone\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:92;a:4:{s:1:\"a\";i:93;s:1:\"b\";s:23:\"ForceDeleteAny:TimeZone\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:93;a:4:{s:1:\"a\";i:94;s:1:\"b\";s:19:\"RestoreAny:TimeZone\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:94;a:4:{s:1:\"a\";i:95;s:1:\"b\";s:18:\"Replicate:TimeZone\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:95;a:4:{s:1:\"a\";i:96;s:1:\"b\";s:16:\"Reorder:TimeZone\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:11:\"super_admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}}}', 1775723223);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `legal_name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `postal_code` varchar(5) DEFAULT NULL,
  `tax_id` varchar(255) DEFAULT NULL,
  `tax_address` varchar(255) DEFAULT NULL,
  `is_pkp` tinyint(1) NOT NULL DEFAULT 0,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account` varchar(255) DEFAULT NULL,
  `bank_beneficiary` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `timezone_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `code`, `name`, `legal_name`, `slug`, `email`, `phone`, `fax`, `website`, `address`, `postal_code`, `tax_id`, `tax_address`, `is_pkp`, `bank_name`, `bank_account`, `bank_beneficiary`, `logo`, `favicon`, `created_at`, `updated_at`, `deleted_at`, `currency_id`, `timezone_id`) VALUES
(1, 'SIN-001', 'PT.  Schlemmer Automotive Indonesia', 'PT. Schlemmer Automotive Indonesia', 'SIN', 'priyo.ardy@schlemmer.co.id', '02189913741', NULL, NULL, 'Kawasan Industri Delta Silicon 3,\nJl. Johar Blok F8 No. 6\nKec. Cikarang Pusat', '17530', NULL, NULL, 1, NULL, NULL, NULL, 'company-avatar/01KNH3EP1REAVWA3X8235M8HC7.png', 'favicon-avatar/01KNH3F0SXBRCY9V890YTE7W4B.png', '2026-04-06 09:54:47', '2026-04-06 09:58:51', NULL, 1, 25);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `decimal_digits` int(11) NOT NULL DEFAULT 2,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `code`, `name`, `symbol`, `decimal_digits`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'IDR', 'Indonesia Rupiah', 'Rp', 2, 1, '2026-04-06 04:09:59', '2026-04-06 04:09:59', NULL),
(2, 'USD', 'US Dollar', '$', 2, 1, '2026-04-06 04:10:48', '2026-04-06 04:10:48', NULL),
(3, 'CNY', 'China Yuan', '¥', 2, 1, '2026-04-06 04:11:52', '2026-04-06 04:12:36', NULL),
(4, 'JPY', 'Japanese Yen', '¥', 2, 1, '2026-04-06 04:12:24', '2026-04-06 04:12:42', NULL),
(5, 'SGD', 'Singapore Dollar', 'S$', 2, 1, '2026-04-06 04:14:01', '2026-04-06 04:14:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(150) NOT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `contact_person` varchar(150) DEFAULT NULL,
  `contact_person_email` varchar(255) DEFAULT NULL,
  `contact_person_phone` varchar(20) DEFAULT NULL,
  `registration_no` varchar(255) DEFAULT NULL,
  `tax_no` varchar(25) DEFAULT NULL,
  `vat` int(11) NOT NULL DEFAULT 0,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account_no` varchar(25) DEFAULT NULL,
  `bank_account_name` varchar(150) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `payment_method` enum('cash','bank','cheque','term_30','term_60','term_90') NOT NULL DEFAULT 'term_30',
  `remark` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exports`
--

CREATE TABLE `exports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_disk` varchar(255) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `exporter` varchar(255) NOT NULL,
  `processed_rows` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `total_rows` int(10) UNSIGNED NOT NULL,
  `successful_rows` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exports`
--

INSERT INTO `exports` (`id`, `completed_at`, `file_disk`, `file_name`, `exporter`, `processed_rows`, `total_rows`, `successful_rows`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '2026-04-02 04:44:20', 'local', 'export-1-users', 'App\\Filament\\Exports\\UsersExporter', 1, 1, 1, 1, '2026-04-02 04:44:18', '2026-04-02 04:44:20'),
(2, '2026-04-02 04:49:37', 'local', 'users-20260402114934', 'App\\Filament\\Exports\\UsersExporter', 1, 1, 1, 1, '2026-04-02 04:49:34', '2026-04-02 04:49:37'),
(3, '2026-04-02 04:55:02', 'local', 'users-20260402115501', 'App\\Filament\\Exports\\UsersExporter', 1, 1, 1, 1, '2026-04-02 04:55:01', '2026-04-02 04:55:02'),
(4, '2026-04-02 05:04:41', 'local', 'users-20260402120440', 'App\\Filament\\Exports\\UsersExporter', 1, 1, 1, 1, '2026-04-02 05:04:40', '2026-04-02 05:04:41'),
(5, '2026-04-02 05:10:15', 'local', 'users-20260402121014', 'App\\Filament\\Exports\\UsersExporter', 1, 1, 1, 1, '2026-04-02 05:10:14', '2026-04-02 05:10:15'),
(6, '2026-04-02 05:28:05', 'local', 'users-20260402122804', 'App\\Filament\\Exports\\UsersExporter', 1, 1, 1, 1, '2026-04-02 05:28:03', '2026-04-02 05:28:05'),
(7, '2026-04-06 06:14:40', 'local', 'export-7-time-zones', 'App\\Filament\\Exports\\TimeZonesExporter', 33, 33, 33, 1, '2026-04-06 06:14:23', '2026-04-06 06:14:40'),
(8, '2026-04-06 06:33:59', 'local', 'export-8-time-zones', 'App\\Filament\\Exports\\TimeZonesExporter', 33, 33, 33, 1, '2026-04-06 06:33:57', '2026-04-06 06:33:59');

-- --------------------------------------------------------

--
-- Table structure for table `failed_import_rows`
--

CREATE TABLE `failed_import_rows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `import_id` bigint(20) UNSIGNED NOT NULL,
  `validation_error` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `imports`
--

CREATE TABLE `imports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `importer` varchar(255) NOT NULL,
  `processed_rows` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `total_rows` int(10) UNSIGNED NOT NULL,
  `successful_rows` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `imports`
--

INSERT INTO `imports` (`id`, `completed_at`, `file_name`, `file_path`, `importer`, `processed_rows`, `total_rows`, `successful_rows`, `user_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 'timezones.csv', 'C:\\Project\\php\\laravel\\v12\\scm_app\\storage\\app/public\\livewire-tmp/nqZzpz81Gb13EbyNyoOX7XpD4NGrOVOTBAeiQQHF.csv', 'App\\Filament\\Imports\\TimeZonesImporter', 0, 32, 0, 1, '2026-04-06 04:48:55', '2026-04-06 04:48:55');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_batches`
--

INSERT INTO `job_batches` (`id`, `name`, `total_jobs`, `pending_jobs`, `failed_jobs`, `failed_job_ids`, `options`, `cancelled_at`, `created_at`, `finished_at`) VALUES
('a171e2a8-394d-4500-82e1-9367bcca46d8', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:6108:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":8:{s:11:\"\0*\0exporter\";O:34:\"App\\Filament\\Exports\\UsersExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 11:44:18\";s:10:\"created_at\";s:19:\"2026-04-02 11:44:18\";s:2:\"id\";i:1;s:9:\"file_name\";s:14:\"export-1-users\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 11:44:18\";s:10:\"created_at\";s:19:\"2026-04-02 11:44:18\";s:2:\"id\";i:1;s:9:\"file_name\";s:14:\"export-1-users\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:14:\"export-1-users\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:12:\"\0*\0authGuard\";s:3:\"web\";s:7:\"chained\";a:1:{i:0;s:2690:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:34:\"App\\Filament\\Exports\\UsersExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 11:44:18\";s:10:\"created_at\";s:19:\"2026-04-02 11:44:18\";s:2:\"id\";i:1;s:9:\"file_name\";s:14:\"export-1-users\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 11:44:18\";s:10:\"created_at\";s:19:\"2026-04-02 11:44:18\";s:2:\"id\";i:1;s:9:\"file_name\";s:14:\"export-1-users\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:14:\"export-1-users\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"000000000000086b0000000000000000\";}\";s:4:\"hash\";s:44:\"Kq4V0DukoJgn+WMfrsCPoGOjSH66o8rDK9Qjxxkv/ac=\";}}}}', NULL, 1775105060, 1775105060),
('a171e48b-684c-453b-b864-2ff5952ff72c', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:6144:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":8:{s:11:\"\0*\0exporter\";O:34:\"App\\Filament\\Exports\\UsersExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 11:49:34\";s:10:\"created_at\";s:19:\"2026-04-02 11:49:34\";s:2:\"id\";i:2;s:9:\"file_name\";s:20:\"users-20260402114934\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 11:49:34\";s:10:\"created_at\";s:19:\"2026-04-02 11:49:34\";s:2:\"id\";i:2;s:9:\"file_name\";s:20:\"users-20260402114934\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"users-20260402114934\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:2;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:12:\"\0*\0authGuard\";s:3:\"web\";s:7:\"chained\";a:1:{i:0;s:2708:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:34:\"App\\Filament\\Exports\\UsersExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 11:49:34\";s:10:\"created_at\";s:19:\"2026-04-02 11:49:34\";s:2:\"id\";i:2;s:9:\"file_name\";s:20:\"users-20260402114934\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 11:49:34\";s:10:\"created_at\";s:19:\"2026-04-02 11:49:34\";s:2:\"id\";i:2;s:9:\"file_name\";s:20:\"users-20260402114934\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"users-20260402114934\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:2;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"00000000000008510000000000000000\";}\";s:4:\"hash\";s:44:\"PXr3CD8kZBQ3u1T/Ts3pG6By/9I1VYdShdtNBoAUwoY=\";}}}}', NULL, 1775105377, 1775105377),
('a171e67b-f90e-489c-8885-79f017930de7', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:6144:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":8:{s:11:\"\0*\0exporter\";O:34:\"App\\Filament\\Exports\\UsersExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 11:55:01\";s:10:\"created_at\";s:19:\"2026-04-02 11:55:01\";s:2:\"id\";i:3;s:9:\"file_name\";s:20:\"users-20260402115501\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 11:55:01\";s:10:\"created_at\";s:19:\"2026-04-02 11:55:01\";s:2:\"id\";i:3;s:9:\"file_name\";s:20:\"users-20260402115501\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"users-20260402115501\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:3;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:12:\"\0*\0authGuard\";s:3:\"web\";s:7:\"chained\";a:1:{i:0;s:2708:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:34:\"App\\Filament\\Exports\\UsersExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 11:55:01\";s:10:\"created_at\";s:19:\"2026-04-02 11:55:01\";s:2:\"id\";i:3;s:9:\"file_name\";s:20:\"users-20260402115501\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 11:55:01\";s:10:\"created_at\";s:19:\"2026-04-02 11:55:01\";s:2:\"id\";i:3;s:9:\"file_name\";s:20:\"users-20260402115501\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"users-20260402115501\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:3;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000c280000000000000000\";}\";s:4:\"hash\";s:44:\"utZT4npB47qO/50WkPC49kEIZwZ89RFlOOrQx+H24eU=\";}}}}', NULL, 1775105702, 1775105702),
('a171e9ee-ac3d-4fc4-af81-7bdb567d4713', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:6144:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":8:{s:11:\"\0*\0exporter\";O:34:\"App\\Filament\\Exports\\UsersExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 12:04:40\";s:10:\"created_at\";s:19:\"2026-04-02 12:04:40\";s:2:\"id\";i:4;s:9:\"file_name\";s:20:\"users-20260402120440\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 12:04:40\";s:10:\"created_at\";s:19:\"2026-04-02 12:04:40\";s:2:\"id\";i:4;s:9:\"file_name\";s:20:\"users-20260402120440\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"users-20260402120440\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:4;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:12:\"\0*\0authGuard\";s:3:\"web\";s:7:\"chained\";a:1:{i:0;s:2708:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:34:\"App\\Filament\\Exports\\UsersExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 12:04:40\";s:10:\"created_at\";s:19:\"2026-04-02 12:04:40\";s:2:\"id\";i:4;s:9:\"file_name\";s:20:\"users-20260402120440\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 12:04:40\";s:10:\"created_at\";s:19:\"2026-04-02 12:04:40\";s:2:\"id\";i:4;s:9:\"file_name\";s:20:\"users-20260402120440\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"users-20260402120440\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:4;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000c1a0000000000000000\";}\";s:4:\"hash\";s:44:\"S1dF77O7e/YrUoooGyzY01J9fgCbGTvI6xHtWdqAMqk=\";}}}}', NULL, 1775106281, 1775106281),
('a171ebed-3e1f-4752-b5e3-ae1a7445731d', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:6144:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":8:{s:11:\"\0*\0exporter\";O:34:\"App\\Filament\\Exports\\UsersExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 12:10:14\";s:10:\"created_at\";s:19:\"2026-04-02 12:10:14\";s:2:\"id\";i:5;s:9:\"file_name\";s:20:\"users-20260402121014\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 12:10:14\";s:10:\"created_at\";s:19:\"2026-04-02 12:10:14\";s:2:\"id\";i:5;s:9:\"file_name\";s:20:\"users-20260402121014\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"users-20260402121014\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:5;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:12:\"\0*\0authGuard\";s:3:\"web\";s:7:\"chained\";a:1:{i:0;s:2708:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:34:\"App\\Filament\\Exports\\UsersExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 12:10:14\";s:10:\"created_at\";s:19:\"2026-04-02 12:10:14\";s:2:\"id\";i:5;s:9:\"file_name\";s:20:\"users-20260402121014\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 12:10:14\";s:10:\"created_at\";s:19:\"2026-04-02 12:10:14\";s:2:\"id\";i:5;s:9:\"file_name\";s:20:\"users-20260402121014\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"users-20260402121014\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:5;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000c4a0000000000000000\";}\";s:4:\"hash\";s:44:\"b0IJLIwfbiXO2S2p+SKudb4N4beQPYUjv93HFf0wDE0=\";}}}}', NULL, 1775106615, 1775106615),
('a171f24d-013e-4b05-95df-ce117c973e58', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:6324:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":8:{s:11:\"\0*\0exporter\";O:34:\"App\\Filament\\Exports\\UsersExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 12:28:04\";s:10:\"created_at\";s:19:\"2026-04-02 12:28:03\";s:2:\"id\";i:6;s:9:\"file_name\";s:20:\"users-20260402122804\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 12:28:04\";s:10:\"created_at\";s:19:\"2026-04-02 12:28:03\";s:2:\"id\";i:6;s:9:\"file_name\";s:20:\"users-20260402122804\";}s:10:\"\0*\0changes\";a:2:{s:10:\"updated_at\";s:19:\"2026-04-02 12:28:04\";s:9:\"file_name\";s:20:\"users-20260402122804\";}s:11:\"\0*\0previous\";a:1:{s:10:\"updated_at\";s:19:\"2026-04-02 12:28:03\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:6;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:12:\"\0*\0authGuard\";s:3:\"web\";s:7:\"chained\";a:1:{i:0;s:2798:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:34:\"App\\Filament\\Exports\\UsersExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 12:28:04\";s:10:\"created_at\";s:19:\"2026-04-02 12:28:03\";s:2:\"id\";i:6;s:9:\"file_name\";s:20:\"users-20260402122804\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:34:\"App\\Filament\\Exports\\UsersExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-02 12:28:04\";s:10:\"created_at\";s:19:\"2026-04-02 12:28:03\";s:2:\"id\";i:6;s:9:\"file_name\";s:20:\"users-20260402122804\";}s:10:\"\0*\0changes\";a:2:{s:10:\"updated_at\";s:19:\"2026-04-02 12:28:04\";s:9:\"file_name\";s:20:\"users-20260402122804\";}s:11:\"\0*\0previous\";a:1:{s:10:\"updated_at\";s:19:\"2026-04-02 12:28:03\";}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:6;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:9:{s:4:\"name\";s:9:\"Full Name\";s:5:\"email\";s:13:\"Email Address\";s:5:\"phone\";s:12:\"Phone Number\";s:4:\"role\";s:4:\"Role\";s:9:\"is_locked\";s:13:\"Locked Status\";s:10:\"last_login\";s:10:\"Last Login\";s:15:\"last_login_from\";s:15:\"Last Login From\";s:6:\"remark\";s:6:\"Remark\";s:10:\"created_at\";s:10:\"Created At\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000c3c0000000000000000\";}\";s:4:\"hash\";s:44:\"snatZHD0VL0ReXYF3CNJ55EvaKBr2Y1hrrRMev9c8bY=\";}}}}', NULL, 1775107685, 1775107685);
INSERT INTO `job_batches` (`id`, `name`, `total_jobs`, `pending_jobs`, `failed_jobs`, `failed_job_ids`, `options`, `cancelled_at`, `created_at`, `finished_at`) VALUES
('a17a0ee5-28dd-4437-8bb0-ab97135b931a', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:5458:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":8:{s:11:\"\0*\0exporter\";O:38:\"App\\Filament\\Exports\\TimeZonesExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:38:\"App\\Filament\\Exports\\TimeZonesExporter\";s:10:\"total_rows\";i:33;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-06 13:14:23\";s:10:\"created_at\";s:19:\"2026-04-06 13:14:23\";s:2:\"id\";i:7;s:9:\"file_name\";s:19:\"export-7-time-zones\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:38:\"App\\Filament\\Exports\\TimeZonesExporter\";s:10:\"total_rows\";i:33;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-06 13:14:23\";s:10:\"created_at\";s:19:\"2026-04-06 13:14:23\";s:2:\"id\";i:7;s:9:\"file_name\";s:19:\"export-7-time-zones\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:19:\"export-7-time-zones\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:4:{s:4:\"name\";s:4:\"Name\";s:6:\"offset\";s:6:\"Offset\";s:11:\"description\";s:11:\"Description\";s:9:\"is_active\";s:9:\"Is active\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:7;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:4:{s:4:\"name\";s:4:\"Name\";s:6:\"offset\";s:6:\"Offset\";s:11:\"description\";s:11:\"Description\";s:9:\"is_active\";s:9:\"Is active\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:12:\"\0*\0authGuard\";s:3:\"web\";s:7:\"chained\";a:1:{i:0;s:2365:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:38:\"App\\Filament\\Exports\\TimeZonesExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:38:\"App\\Filament\\Exports\\TimeZonesExporter\";s:10:\"total_rows\";i:33;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-06 13:14:23\";s:10:\"created_at\";s:19:\"2026-04-06 13:14:23\";s:2:\"id\";i:7;s:9:\"file_name\";s:19:\"export-7-time-zones\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:38:\"App\\Filament\\Exports\\TimeZonesExporter\";s:10:\"total_rows\";i:33;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-06 13:14:23\";s:10:\"created_at\";s:19:\"2026-04-06 13:14:23\";s:2:\"id\";i:7;s:9:\"file_name\";s:19:\"export-7-time-zones\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:19:\"export-7-time-zones\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:4:{s:4:\"name\";s:4:\"Name\";s:6:\"offset\";s:6:\"Offset\";s:11:\"description\";s:11:\"Description\";s:9:\"is_active\";s:9:\"Is active\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:7;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:4:{s:4:\"name\";s:4:\"Name\";s:6:\"offset\";s:6:\"Offset\";s:11:\"description\";s:11:\"Description\";s:9:\"is_active\";s:9:\"Is active\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"00000000000008e90000000000000000\";}\";s:4:\"hash\";s:44:\"liITs7aDW6qYf5izumvS3CFlNJxoE/iQ2QGeO9XuHI4=\";}}}}', NULL, 1775456080, 1775456080),
('a17a15cd-faaf-4bf7-86d3-c1ca7b293643', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:5458:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":8:{s:11:\"\0*\0exporter\";O:38:\"App\\Filament\\Exports\\TimeZonesExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:38:\"App\\Filament\\Exports\\TimeZonesExporter\";s:10:\"total_rows\";i:33;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-06 13:33:57\";s:10:\"created_at\";s:19:\"2026-04-06 13:33:57\";s:2:\"id\";i:8;s:9:\"file_name\";s:19:\"export-8-time-zones\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:38:\"App\\Filament\\Exports\\TimeZonesExporter\";s:10:\"total_rows\";i:33;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-06 13:33:57\";s:10:\"created_at\";s:19:\"2026-04-06 13:33:57\";s:2:\"id\";i:8;s:9:\"file_name\";s:19:\"export-8-time-zones\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:19:\"export-8-time-zones\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:4:{s:4:\"name\";s:4:\"Name\";s:6:\"offset\";s:6:\"Offset\";s:11:\"description\";s:11:\"Description\";s:9:\"is_active\";s:9:\"Is active\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:8;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:4:{s:4:\"name\";s:4:\"Name\";s:6:\"offset\";s:6:\"Offset\";s:11:\"description\";s:11:\"Description\";s:9:\"is_active\";s:9:\"Is active\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:12:\"\0*\0authGuard\";s:3:\"web\";s:7:\"chained\";a:1:{i:0;s:2365:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:38:\"App\\Filament\\Exports\\TimeZonesExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:38:\"App\\Filament\\Exports\\TimeZonesExporter\";s:10:\"total_rows\";i:33;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-06 13:33:57\";s:10:\"created_at\";s:19:\"2026-04-06 13:33:57\";s:2:\"id\";i:8;s:9:\"file_name\";s:19:\"export-8-time-zones\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:38:\"App\\Filament\\Exports\\TimeZonesExporter\";s:10:\"total_rows\";i:33;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-04-06 13:33:57\";s:10:\"created_at\";s:19:\"2026-04-06 13:33:57\";s:2:\"id\";i:8;s:9:\"file_name\";s:19:\"export-8-time-zones\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:19:\"export-8-time-zones\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:4:{s:4:\"name\";s:4:\"Name\";s:6:\"offset\";s:6:\"Offset\";s:11:\"description\";s:11:\"Description\";s:9:\"is_active\";s:9:\"Is active\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:8;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:4:{s:4:\"name\";s:4:\"Name\";s:6:\"offset\";s:6:\"Offset\";s:11:\"description\";s:11:\"Description\";s:9:\"is_active\";s:9:\"Is active\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"00000000000008b90000000000000000\";}\";s:4:\"hash\";s:44:\"OzI1NJhquiiSCDtB0JlOpCMJQhhP1FVnT6pE4Njw3As=\";}}}}', NULL, 1775457239, 1775457239);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_02_033321_create_notifications_table', 2),
(5, '2026_04_02_113509_add_user_role_to_user_table', 3),
(6, '2026_04_02_113818_create_imports_table', 4),
(7, '2026_04_02_113819_create_exports_table', 4),
(8, '2026_04_02_113820_create_failed_import_rows_table', 4),
(9, '2026_04_02_143645_create_permission_tables', 5),
(10, '2026_04_02_221522_supplies_table', 6),
(11, '2026_04_02_224829_add_avatar_to_supplier_table', 6),
(12, '2026_04_02_230230_add_payment_method_to_supplier_table', 6),
(13, '2026_04_05_174844_customer', 6),
(14, '2026_04_05_220403_currency', 6),
(15, '2026_04_05_220415_time_zone', 6),
(16, '2026_04_05_220432_company', 6),
(17, '2026_04_05_225852_branch', 6),
(21, '2026_04_08_132920_approval_flow', 7);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(1, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8),
(4, 'App\\Models\\User', 9),
(4, 'App\\Models\\User', 10),
(4, 'App\\Models\\User', 11),
(4, 'App\\Models\\User', 12),
(4, 'App\\Models\\User', 13),
(4, 'App\\Models\\User', 14),
(4, 'App\\Models\\User', 15),
(4, 'App\\Models\\User', 16),
(4, 'App\\Models\\User', 17),
(4, 'App\\Models\\User', 18),
(4, 'App\\Models\\User', 19),
(4, 'App\\Models\\User', 21),
(4, 'App\\Models\\User', 22),
(4, 'App\\Models\\User', 23),
(4, 'App\\Models\\User', 24);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'ViewAny:Role', 'web', '2026-04-02 07:41:26', '2026-04-02 07:41:26'),
(2, 'View:Role', 'web', '2026-04-02 07:41:26', '2026-04-02 07:41:26'),
(3, 'Create:Role', 'web', '2026-04-02 07:41:26', '2026-04-02 07:41:26'),
(4, 'Update:Role', 'web', '2026-04-02 07:41:26', '2026-04-02 07:41:26'),
(5, 'Delete:Role', 'web', '2026-04-02 07:41:26', '2026-04-02 07:41:26'),
(6, 'DeleteAny:Role', 'web', '2026-04-02 07:41:26', '2026-04-02 07:41:26'),
(7, 'Restore:Role', 'web', '2026-04-02 07:41:26', '2026-04-02 07:41:26'),
(8, 'ForceDelete:Role', 'web', '2026-04-02 07:41:26', '2026-04-02 07:41:26'),
(9, 'ForceDeleteAny:Role', 'web', '2026-04-02 07:41:26', '2026-04-02 07:41:26'),
(10, 'RestoreAny:Role', 'web', '2026-04-02 07:41:26', '2026-04-02 07:41:26'),
(11, 'Replicate:Role', 'web', '2026-04-02 07:41:26', '2026-04-02 07:41:26'),
(12, 'Reorder:Role', 'web', '2026-04-02 07:41:26', '2026-04-02 07:41:26'),
(13, 'ViewAny:User', 'web', '2026-04-02 08:13:30', '2026-04-02 08:13:30'),
(14, 'View:User', 'web', '2026-04-02 08:13:30', '2026-04-02 08:13:30'),
(15, 'Create:User', 'web', '2026-04-02 08:13:30', '2026-04-02 08:13:30'),
(16, 'Update:User', 'web', '2026-04-02 08:13:30', '2026-04-02 08:13:30'),
(17, 'Delete:User', 'web', '2026-04-02 08:13:30', '2026-04-02 08:13:30'),
(18, 'DeleteAny:User', 'web', '2026-04-02 08:13:30', '2026-04-02 08:13:30'),
(19, 'Restore:User', 'web', '2026-04-02 08:13:30', '2026-04-02 08:13:30'),
(20, 'ForceDelete:User', 'web', '2026-04-02 08:13:30', '2026-04-02 08:13:30'),
(21, 'ForceDeleteAny:User', 'web', '2026-04-02 08:13:30', '2026-04-02 08:13:30'),
(22, 'RestoreAny:User', 'web', '2026-04-02 08:13:30', '2026-04-02 08:13:30'),
(23, 'Replicate:User', 'web', '2026-04-02 08:13:30', '2026-04-02 08:13:30'),
(24, 'Reorder:User', 'web', '2026-04-02 08:13:30', '2026-04-02 08:13:30'),
(25, 'ViewAny:Branch', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(26, 'View:Branch', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(27, 'Create:Branch', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(28, 'Update:Branch', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(29, 'Delete:Branch', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(30, 'DeleteAny:Branch', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(31, 'Restore:Branch', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(32, 'ForceDelete:Branch', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(33, 'ForceDeleteAny:Branch', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(34, 'RestoreAny:Branch', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(35, 'Replicate:Branch', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(36, 'Reorder:Branch', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(37, 'ViewAny:Company', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(38, 'View:Company', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(39, 'Create:Company', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(40, 'Update:Company', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(41, 'Delete:Company', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(42, 'DeleteAny:Company', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(43, 'Restore:Company', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(44, 'ForceDelete:Company', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(45, 'ForceDeleteAny:Company', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(46, 'RestoreAny:Company', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(47, 'Replicate:Company', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(48, 'Reorder:Company', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(49, 'ViewAny:Currency', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(50, 'View:Currency', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(51, 'Create:Currency', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(52, 'Update:Currency', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(53, 'Delete:Currency', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(54, 'DeleteAny:Currency', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(55, 'Restore:Currency', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(56, 'ForceDelete:Currency', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(57, 'ForceDeleteAny:Currency', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(58, 'RestoreAny:Currency', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(59, 'Replicate:Currency', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(60, 'Reorder:Currency', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(61, 'ViewAny:Customer', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(62, 'View:Customer', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(63, 'Create:Customer', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(64, 'Update:Customer', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(65, 'Delete:Customer', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(66, 'DeleteAny:Customer', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(67, 'Restore:Customer', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(68, 'ForceDelete:Customer', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(69, 'ForceDeleteAny:Customer', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(70, 'RestoreAny:Customer', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(71, 'Replicate:Customer', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(72, 'Reorder:Customer', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(73, 'ViewAny:Supplier', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(74, 'View:Supplier', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(75, 'Create:Supplier', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(76, 'Update:Supplier', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(77, 'Delete:Supplier', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(78, 'DeleteAny:Supplier', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(79, 'Restore:Supplier', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(80, 'ForceDelete:Supplier', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(81, 'ForceDeleteAny:Supplier', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(82, 'RestoreAny:Supplier', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(83, 'Replicate:Supplier', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(84, 'Reorder:Supplier', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(85, 'ViewAny:TimeZone', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(86, 'View:TimeZone', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(87, 'Create:TimeZone', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(88, 'Update:TimeZone', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(89, 'Delete:TimeZone', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(90, 'DeleteAny:TimeZone', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(91, 'Restore:TimeZone', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(92, 'ForceDelete:TimeZone', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(93, 'ForceDeleteAny:TimeZone', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(94, 'RestoreAny:TimeZone', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(95, 'Replicate:TimeZone', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48'),
(96, 'Reorder:TimeZone', 'web', '2026-04-06 01:29:48', '2026-04-06 01:29:48');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'web', '2026-04-02 07:41:26', '2026-04-02 07:41:26'),
(2, 'admin', 'web', '2026-04-02 08:14:34', '2026-04-02 08:15:09'),
(3, 'manager', 'web', '2026-04-02 08:15:34', '2026-04-02 08:15:34'),
(4, 'supervisor', 'web', '2026-04-02 08:15:40', '2026-04-02 08:15:40'),
(5, 'leader', 'web', '2026-04-02 08:16:06', '2026-04-02 08:16:06'),
(6, 'staff', 'web', '2026-04-02 08:16:13', '2026-04-02 08:16:13'),
(7, 'guest', 'web', '2026-04-02 08:16:18', '2026-04-02 08:16:18');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(18, 2),
(21, 2),
(24, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('U37N1ITVNJSYv9NByDT67DbsNvMYv0SYvkJDCtrj', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiYnFDSWJERHIyeDBlbGVyV3BqYm9FY2lLZTA5NGR0YWNjRk5yTDg2RSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjUzOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvdXNlcnM/c29ydD1uYW1lJTNBYXNjJnRhYj1hZG1pbiI7czo1OiJyb3V0ZSI7czozNjoiZmlsYW1lbnQuYWRtaW4ucmVzb3VyY2VzLnVzZXJzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiM2YzMGQ0Yjc2ZGMwNjcyNDNmYTYyMDA3NTVkZDc5NDU0YTMwNzA4ZWQxOTI5ZmRmNzI1MWU4ODVlNjFmNjAyYSI7czo2OiJ0YWJsZXMiO2E6NTp7czo0MDoiMTMzNDM3OTA5M2VhZWIxNzIxZTNlMDdhYjU5NmFiMjRfY29sdW1ucyI7YToxOTp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjY6ImF2YXRhciI7czo1OiJsYWJlbCI7czo2OiJBdmF0YXIiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6ImNvZGUiO3M6NToibGFiZWwiO3M6MTM6IlN1cHBsaWVyIENvZGUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6Im5hbWUiO3M6NToibGFiZWwiO3M6MTM6IlN1cHBsaWVyIE5hbWUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjc6ImFkZHJlc3MiO3M6NToibGFiZWwiO3M6NzoiQWRkcmVzcyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToiZW1haWwiO3M6NToibGFiZWwiO3M6MTM6IkVtYWlsIEFkZHJlc3MiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6InBob25lIjtzOjU6ImxhYmVsIjtzOjk6IlBob25lIE5vLiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjY7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MzoiZmF4IjtzOjU6ImxhYmVsIjtzOjc6IkZheCBOby4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo3O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjc6IndlYnNpdGUiO3M6NToibGFiZWwiO3M6NzoiV2Vic2l0ZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjg7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTQ6ImNvbnRhY3RfcGVyc29uIjtzOjU6ImxhYmVsIjtzOjE5OiJDb250YWN0IFBlcnNvbiBOYW1lIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6OTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoyMDoiY29udGFjdF9wZXJzb25fZW1haWwiO3M6NToibGFiZWwiO3M6MjA6IkNvbnRhY3QgUGVyc29uIEVtYWlsIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MjA6ImNvbnRhY3RfcGVyc29uX3Bob25lIjtzOjU6ImxhYmVsIjtzOjIwOiJDb250YWN0IFBlcnNvbiBQaG9uZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjExO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE1OiJyZWdpc3RyYXRpb25fbm8iO3M6NToibGFiZWwiO3M6MjM6IkNvbXBhbnkgUmVnaXN0cmF0b29uIE5vIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NjoidGF4X25vIjtzOjU6ImxhYmVsIjtzOjIwOiJUYXggUmVnaXN0cmF0aW9uIE5vLiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjEzO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjM6InZhdCI7czo1OiJsYWJlbCI7czo3OiJWQVQgKCUpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6OToiYmFua19uYW1lIjtzOjU6ImxhYmVsIjtzOjk6IkJhbmsgTmFtZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE1OiJiYW5rX2FjY291bnRfbm8iO3M6NToibGFiZWwiO3M6MTU6IkJhbmsgQWNjb3VudCBObyI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE3OiJiYW5rX2FjY291bnRfbmFtZSI7czo1OiJsYWJlbCI7czoxNzoiQmFuayBBY2NvdW50IE5hbWUiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxNzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNDoicGF5bWVudF9tZXRob2QiO3M6NToibGFiZWwiO3M6MTQ6IlBheW1lbnQgTWV0aG9kIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTg7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NjoicmVtYXJrIjtzOjU6ImxhYmVsIjtzOjY6IlJlbWFyayI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319czo0MDoiMTMzNDM3OTA5M2VhZWIxNzIxZTNlMDdhYjU5NmFiMjRfZmlsdGVycyI7YToyOntzOjc6InRyYXNoZWQiO2E6MTp7czo1OiJ2YWx1ZSI7Tjt9czoxMDoiY3JlYXRlZF9hdCI7YToyOntzOjEyOiJjcmVhdGVkX2Zyb20iO047czoxMzoiY3JlYXRlZF91bnRpbCI7Tjt9fXM6NDA6IjkwMWMwNjgwOTIwZThmNDdiM2I4NmE5MTZkMzIyYmJiX2NvbHVtbnMiO2E6NDp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ6ImNvZGUiO3M6NToibGFiZWwiO3M6NDoiQ29kZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoibmFtZSI7czo1OiJsYWJlbCI7czo0OiJOYW1lIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoiY3JlYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiQ3JlYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoidXBkYXRlZF9hdCI7czo1OiJsYWJlbCI7czoxMDoiVXBkYXRlZCBhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fX1zOjQwOiJlNjQ0ODMzZjRlNGUwODcxMjMxNWRhNzFiMzNmYWNkMl9jb2x1bW5zIjthOjk6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJhdmF0YXIiO3M6NToibGFiZWwiO3M6NjoiQXZhdGFyIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo0OiJuYW1lIjtzOjU6ImxhYmVsIjtzOjk6IkZ1bGwgTmFtZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToiZW1haWwiO3M6NToibGFiZWwiO3M6MTM6IkVtYWlsIEFkZHJlc3MiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6InBob25lIjtzOjU6ImxhYmVsIjtzOjEyOiJQaG9uZSBOdW1iZXIiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJyb2xlcy5uYW1lIjtzOjU6ImxhYmVsIjtzOjk6IlVzZXIgUm9sZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6OToiaXNfbG9ja2VkIjtzOjU6ImxhYmVsIjtzOjEzOiJMb2NrZWQgU3RhdHVzIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoibGFzdF9sb2dpbiI7czo1OiJsYWJlbCI7czoxMDoiTGFzdCBMb2dpbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjc7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTU6Imxhc3RfbG9naW5fZnJvbSI7czo1OiJsYWJlbCI7czoxNToiTGFzdCBMb2dpbiBGcm9tIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6ODthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJyZW1hcmsiO3M6NToibGFiZWwiO3M6NjoiUmVtYXJrIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX1zOjQxOiJlNjQ0ODMzZjRlNGUwODcxMjMxNWRhNzFiMzNmYWNkMl9wZXJfcGFnZSI7czoyOiI1MCI7fXM6ODoiZmlsYW1lbnQiO2E6MDp7fX0=', 1775641401);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(150) NOT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `contact_person` varchar(150) DEFAULT NULL,
  `contact_person_email` varchar(255) DEFAULT NULL,
  `contact_person_phone` varchar(20) DEFAULT NULL,
  `registration_no` varchar(255) DEFAULT NULL,
  `tax_no` varchar(25) DEFAULT NULL,
  `vat` int(11) NOT NULL DEFAULT 0,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account_no` varchar(25) DEFAULT NULL,
  `bank_account_name` varchar(150) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `payment_method` enum('cash','bank','cheque','30','60','90') NOT NULL DEFAULT '30',
  `remark` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_zones`
--

CREATE TABLE `time_zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `offset` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_zones`
--

INSERT INTO `time_zones` (`id`, `name`, `offset`, `description`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Dateline Standard Time (dst)', '-12:00', 'Baker Island, Howland Island', 1, '2026-04-06 04:51:50', '2026-04-06 04:51:50', NULL),
(2, 'Samoa Standard Time', '-11:00', 'Pago Pago', 1, '2026-04-06 04:51:59', '2026-04-06 04:51:59', NULL),
(3, 'Hawaii Standard Time', '-10:00', 'Honolulu', 1, '2026-04-06 04:52:09', '2026-04-06 04:52:09', NULL),
(4, 'Alaska Standard Time', '-09:00', 'Anchorage', 1, '2026-04-06 04:52:23', '2026-04-06 04:52:23', NULL),
(5, 'Pacific Standard Time (pst)', '-08:00', 'Los Angeles, Vancouver, Seattle', 1, '2026-04-06 04:52:33', '2026-04-06 04:59:34', NULL),
(6, 'Mountain Standard Time (mst)', '-07:00', 'Denver, Phoenix, Edmonton', 1, '2026-04-06 04:52:44', '2026-04-06 04:52:44', NULL),
(7, 'Central Standard Time (cst)', '-06:00', 'Chicago, Mexico City, Guatemala', 1, '2026-04-06 04:52:53', '2026-04-06 04:52:53', NULL),
(8, 'Eastern Standard Time (est)', '-05:00', 'New York, Toronto, Havana', 1, '2026-04-06 04:53:01', '2026-04-06 04:53:01', NULL),
(9, 'Atlantic Standard Time (ast)', '-04:00', 'Halifax, San Juan', 1, '2026-04-06 04:53:11', '2026-04-06 04:53:11', NULL),
(10, 'Brazilia Time / Argentina', '-03:00', 'Brasilia, Buenos Aires, Santiago', 1, '2026-04-06 04:53:20', '2026-04-06 04:53:20', NULL),
(11, 'Mid-atlantic Time', '-02:00', 'Fernando de Noronha', 1, '2026-04-06 04:53:29', '2026-04-06 04:53:29', NULL),
(12, 'Azores Standard Time', '-01:00', 'Azores, Cape Verde', 1, '2026-04-06 04:53:39', '2026-04-06 04:53:39', NULL),
(13, 'Greenwich Mean Time (gmt)', '+00:00', 'London, Lisbon, Casablanca', 1, '2026-04-06 04:53:50', '2026-04-06 04:53:50', NULL),
(14, 'Central European Time (cet)', '+01:00', 'Paris, Berlin, Rome, Madrid', 1, '2026-04-06 04:55:57', '2026-04-06 04:55:57', NULL),
(15, 'Eastern European Time (eet)', '+02:00', 'Cairo, Athens, Helsinki, Kyiv', 1, '2026-04-06 04:56:06', '2026-04-06 04:56:06', NULL),
(16, 'Arabia Standard Time (ast)', '+03:00', 'Riyadh, Baghdad, Doha', 1, '2026-04-06 04:56:18', '2026-04-06 04:56:18', NULL),
(17, 'Iran Standard Time', '+03:30', 'Tehran', 1, '2026-04-06 04:56:27', '2026-04-06 04:56:27', NULL),
(18, 'Gulf Standard Time (gst)', '+04:00', 'Dubai, Abu Dhabi, Muscat', 1, '2026-04-06 04:56:39', '2026-04-06 04:56:39', NULL),
(19, 'Afghanistan Time', '+04:30', 'Kabul', 1, '2026-04-06 04:56:49', '2026-04-06 04:56:49', NULL),
(20, 'Pakistan Standard Time', '+05:00', 'Karachi, Tashkent', 1, '2026-04-06 04:56:59', '2026-04-06 04:56:59', NULL),
(21, 'India Standard Time (ist)', '+05:30', 'New Delhi, Mumbai, Kolkata', 1, '2026-04-06 04:57:09', '2026-04-06 04:57:09', NULL),
(22, 'Nepal Time', '+05:45', 'Kathmandu', 1, '2026-04-06 04:57:18', '2026-04-06 04:57:18', NULL),
(23, 'Bangladesh Time', '+06:00', 'Dhaka, Almaty', 1, '2026-04-06 04:57:27', '2026-04-06 04:57:27', NULL),
(24, 'Myanmar Time', '+06:30', 'Yangon', 1, '2026-04-06 04:57:37', '2026-04-06 04:57:37', NULL),
(25, 'Indochina Time / Wib', '+07:00', 'Jakarta, Bangkok, Hanoi', 1, '2026-04-06 04:57:47', '2026-04-06 04:57:47', NULL),
(26, 'China Standard Time / Wita', '+08:00', 'Beijing, Singapore, Makassar', 1, '2026-04-06 04:57:56', '2026-04-06 04:57:56', NULL),
(27, 'Japan/korea Standard Time', '+09:00', 'Tokyo, Seoul, Jayapura', 1, '2026-04-06 04:58:10', '2026-04-06 04:58:10', NULL),
(28, 'Australia Central Standard Time', '+09:30', 'Darwin, Adelaide', 1, '2026-04-06 04:58:18', '2026-04-06 04:58:18', NULL),
(29, 'Australian Eastern Time (aet)', '+10:00', 'Sydney, Melbourne, Brisbane', 1, '2026-04-06 04:58:26', '2026-04-06 04:58:26', NULL),
(30, 'Solomon Islands Time', '+11:00', 'Honiara', 1, '2026-04-06 04:58:36', '2026-04-06 04:58:36', NULL),
(31, 'New Zealand Standard Time', '+12:00', 'Auckland, Wellington', 1, '2026-04-06 04:58:45', '2026-04-06 04:58:45', NULL),
(32, 'Phoenix Islands Time', '+13:00', 'Canton Island', 1, '2026-04-06 04:58:54', '2026-04-06 04:58:54', NULL),
(33, 'Line Islands Time', '+14:00', 'Kiritimati', 1, '2026-04-06 04:59:05', '2026-04-06 04:59:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `login_attempt` int(11) NOT NULL DEFAULT 0,
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `last_login` datetime DEFAULT NULL,
  `last_login_from` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `login_attempt`, `is_locked`, `last_login`, `last_login_from`, `avatar`, `remark`, `role`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Ardy Priyo Sudiyantoko', 'priyo.ardy@schlemmer.co.id', '081210192858', NULL, '$2y$12$Z6eyIJCv0qDW9hPgSMaUde8t9SApKOVQ9z/j78TOUoTJeyrWIGYBS', 0, 0, '2026-04-08 09:47:50', '127.0.0.1', 'user-avatar/01KN6GFST7Q4PR51EHP6A1D8PX.jpg', NULL, '1', 'OiE2FM2bHFJSlA10FeuzbdBaDyPTdYWvgQ0vetFPeLIK3EsXtMfRKyoNYamQ', '2026-04-01 20:09:24', '2026-04-08 02:47:50', NULL),
(2, 'Super Administrator', 'admin@schlemmer.co.id', '0987654321', NULL, '$2y$12$Pnek.VdMoPCTwNJe8SKOteTDJHkQTLMQ8JSohO6VgAh53jBxx0s.K', 0, 0, NULL, NULL, 'user-avatar/01KN6GB3V3WAS7JF8VM9FHXBWZ.png', 'Super Administrator', '2', NULL, '2026-04-02 07:08:23', '2026-04-02 08:56:29', NULL),
(3, 'Yudi Effendi', 'yudi.effendi@schlemmer.co.id', NULL, NULL, '$2y$12$q1X16.l.fFosUDLKRSQdjujU045QlIA8.D.8efQW.l77w51ZdeorW', 0, 0, NULL, NULL, NULL, NULL, '1', NULL, '2026-04-08 08:55:08', '2026-04-08 08:55:08', NULL),
(4, 'Nanang Yuliatmoko', 'nanang.yuliatmoko@schlemmer.co.id', NULL, NULL, '$2y$12$kbF0nKx.8zjC1bzlCkghs.oX7cp.qQe0XWonmRGBzlFtKB3eVch1a', 0, 0, NULL, NULL, NULL, NULL, '2', NULL, '2026-04-08 08:55:32', '2026-04-08 08:55:32', NULL),
(5, 'Adnan Khasogi', 'adnan.khasogi@schlemmer.co.id', NULL, NULL, '$2y$12$1MuMJHhhFLpJHObMWyOG5.D4EIoPjL5iECwH4URDrvkvqvcZSrH52', 0, 0, NULL, NULL, NULL, NULL, '3', NULL, '2026-04-08 08:55:51', '2026-04-08 08:55:51', NULL),
(6, 'Wahyu Jatmiko', 'wahyu.jatmiko@schlemmer.co.id', NULL, NULL, '$2y$12$U8GalQw6hXK.FziG/0Jn7ecKbmwR/Mo/xPT2J74tPNF23joFAi5JS', 0, 0, NULL, NULL, NULL, NULL, '3', NULL, '2026-04-08 08:56:13', '2026-04-08 08:56:13', NULL),
(7, 'Ferdy Gunawan', 'ferdy.gunawan@schlemmer.co.id', NULL, NULL, '$2y$12$XzRuVJZbD9ylHBYUDLWUM.ze49ifgMYym/FnLCFNusrneiLTNLPAq', 0, 0, NULL, NULL, NULL, NULL, '3', NULL, '2026-04-08 08:56:33', '2026-04-08 08:56:33', NULL),
(8, 'Narsih Suningsih', 'narsih.suningsih@schlemmer.co.id', NULL, NULL, '$2y$12$7wZhO6.l7.hlCOlZQRgOqO5qzenpQBvViX1o64xZwDdQsc8U4hxxK', 0, 0, NULL, NULL, NULL, NULL, '3', NULL, '2026-04-08 08:56:53', '2026-04-08 08:56:53', NULL),
(9, 'Selvia Wulandari', 'selvia.wulandari@schlemmer.co.id', NULL, NULL, '$2y$12$webyJo0.gTZeAaQ5J8R1P.wNWLnTQuM4E8t7cRV10pMQELu7i9sae', 0, 0, NULL, NULL, NULL, NULL, '4', NULL, '2026-04-08 09:09:02', '2026-04-08 09:09:02', NULL),
(10, 'Bayu Saputri', 'bayu.saputri@schlemmer.co.id', NULL, NULL, '$2y$12$UmTMKjAdAbhpANuNi3bmCuD4vMUsYH9naLWnLPEa74fGjG1CVfAlq', 0, 0, NULL, NULL, NULL, NULL, '4', NULL, '2026-04-08 09:09:21', '2026-04-08 09:09:21', NULL),
(11, 'Nadila Isma Rizky Putri', 'nadila.isma@schlemmer.co.id', NULL, NULL, '$2y$12$duuKXnueQsPd6PLKYKALje9Szi6fKb4IXu7SDgfp5aqjgrrBenIq2', 0, 0, NULL, NULL, NULL, NULL, '4', NULL, '2026-04-08 09:09:46', '2026-04-08 09:09:46', NULL),
(12, 'Yakub Guno Wibowo', 'yakub.guno@schlemmer.co.id', NULL, NULL, '$2y$12$.robtQP5jQ9lv1gGsX079O4nNgMnu93l30qOiisA7StivUrC.D2OC', 0, 0, NULL, NULL, NULL, NULL, '4', NULL, '2026-04-08 09:10:03', '2026-04-08 09:10:03', NULL),
(13, 'Fajar Sya\'bani', 'fajar.syabani@schlemmer.co.id', NULL, NULL, '$2y$12$DujajCbtY1hiB.jt3M00MeQiJ/Y.qNEtLUQa1BPYZXVZx6sptu0WC', 0, 0, NULL, NULL, NULL, NULL, '4', NULL, '2026-04-08 09:10:22', '2026-04-08 09:10:22', NULL),
(14, 'Sulistiyanto', 'sulistiyanto@schlemmer.co.id', NULL, NULL, '$2y$12$F4NntLQsqgC/oDL1oOa1h.U612OGXLaV8I5nbfQEYfaX4A/kGhU3S', 0, 0, NULL, NULL, NULL, NULL, '4', NULL, '2026-04-08 09:10:49', '2026-04-08 09:10:49', NULL),
(15, 'Wahyu Hidayatullah', 'wahyu.hidayatullah@schlemmer.co.id', NULL, NULL, '$2y$12$ho4TpcQkg/DCyTnjsn45V.7ahAHz6dNyp15w01LLwGwFEaWqSX0O.', 0, 0, NULL, NULL, NULL, NULL, '4', NULL, '2026-04-08 09:11:12', '2026-04-08 09:11:12', NULL),
(16, 'Ruliyanto', 'ruliyanto@schlemmer.co.id', NULL, NULL, '$2y$12$AsqDXDmvfjGWXAPx2ijMguNbKJlzCpx14510d4JNgVLuZetDjZYwa', 0, 0, NULL, NULL, NULL, NULL, '4', NULL, '2026-04-08 09:11:29', '2026-04-08 09:11:29', NULL),
(17, 'Sari Widya Pengestika', 'sary.widya@schlemmer.co.id', NULL, NULL, '$2y$12$7t7cWE279zJEDdBhrXO7du9glemCbP1rhmKWi0/6XxqRiy7JUhN3K', 0, 0, NULL, NULL, NULL, NULL, '4', NULL, '2026-04-08 09:11:48', '2026-04-08 09:11:48', NULL),
(18, 'Wulan', 'wulan@schlemmer.co.id', NULL, NULL, '$2y$12$UInaO8xWI.Kn7UlV9pBpru1Qg4CzPBf4AydGtLN7Qi.BHnZq4/Hxa', 0, 0, NULL, NULL, NULL, NULL, '4', NULL, '2026-04-08 09:12:05', '2026-04-08 09:12:05', NULL),
(19, 'Agus Setianto', 'shiftleader@schlemmer.co.id', NULL, NULL, '$2y$12$SzfwW7QI45Zf.JXUMDdG4eGuMdqgPcTDTcTn6x2Bphm4IbpDvf3zi', 0, 0, NULL, NULL, NULL, NULL, '4', NULL, '2026-04-08 09:12:35', '2026-04-08 09:12:35', NULL),
(21, 'Edi Saluriyanto', 'edi.saluriyanto@schlemmer.co.id', NULL, NULL, '$2y$12$6Rjwvvj/DXibpQ/1tGtY.uXhKTDCfMZZ5caAumQa7VTeft6WrAPZu', 0, 0, NULL, NULL, NULL, NULL, '4', NULL, '2026-04-08 09:22:52', '2026-04-08 09:22:52', NULL),
(22, 'Joko Prasetyo Utomo', 'joko.prasetyo@schlemmer.co.id', NULL, NULL, '$2y$12$ohIK1EpBxlKJx/prM4uj1ei5.LTykcjZTbOdbqq7UP5zuk4WWXLMS', 0, 0, NULL, NULL, NULL, NULL, '4', NULL, '2026-04-08 09:23:16', '2026-04-08 09:23:16', NULL),
(23, 'Eddy Suyatno', 'eddy.suyatno@schlemmer.co.id', NULL, NULL, '$2y$12$6jPfGRxnhG/vg5CzWQ.FSOwh2go8.L/STrGRLFdhdCbglR2/K/G4y', 0, 0, NULL, NULL, NULL, NULL, '4', NULL, '2026-04-08 09:23:35', '2026-04-08 09:23:35', NULL),
(24, 'Gagah Nara', 'gagah.nara@schlemmer.co.id', NULL, NULL, '$2y$12$JtF.iulDovcYkV90beUDQe4JRhmBQP0jnUMr54BtaVFT7He3ZQI/O', 0, 0, NULL, NULL, NULL, NULL, '4', NULL, '2026-04-08 09:24:12', '2026-04-08 09:24:12', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approval_flows`
--
ALTER TABLE `approval_flows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `approval_flows_code_unique` (`code`);

--
-- Indexes for table `approval_logs`
--
ALTER TABLE `approval_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approval_logs_approvable_type_approvable_id_index` (`approvable_type`,`approvable_id`),
  ADD KEY `approval_logs_approval_flow_id_foreign` (`approval_flow_id`);

--
-- Indexes for table `approval_steps`
--
ALTER TABLE `approval_steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approval_steps_approval_flow_id_foreign` (`approval_flow_id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_code_unique` (`code`),
  ADD KEY `branches_company_id_foreign` (`company_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_code_unique` (`code`),
  ADD UNIQUE KEY `companies_slug_unique` (`slug`),
  ADD KEY `companies_currency_id_foreign` (`currency_id`),
  ADD KEY `companies_timezone_id_foreign` (`timezone_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currencies_code_unique` (`code`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_code_unique` (`code`);

--
-- Indexes for table `exports`
--
ALTER TABLE `exports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exports_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `failed_import_rows_import_id_foreign` (`import_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `imports`
--
ALTER TABLE `imports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imports_user_id_foreign` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_code_unique` (`code`);

--
-- Indexes for table `time_zones`
--
ALTER TABLE `time_zones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `time_zones_name_unique` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD KEY `users_is_locked_index` (`is_locked`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approval_flows`
--
ALTER TABLE `approval_flows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `approval_logs`
--
ALTER TABLE `approval_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `approval_steps`
--
ALTER TABLE `approval_steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exports`
--
ALTER TABLE `exports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `imports`
--
ALTER TABLE `imports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_zones`
--
ALTER TABLE `time_zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approval_logs`
--
ALTER TABLE `approval_logs`
  ADD CONSTRAINT `approval_logs_approval_flow_id_foreign` FOREIGN KEY (`approval_flow_id`) REFERENCES `approval_flows` (`id`);

--
-- Constraints for table `approval_steps`
--
ALTER TABLE `approval_steps`
  ADD CONSTRAINT `approval_steps_approval_flow_id_foreign` FOREIGN KEY (`approval_flow_id`) REFERENCES `approval_flows` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `companies_timezone_id_foreign` FOREIGN KEY (`timezone_id`) REFERENCES `time_zones` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `exports`
--
ALTER TABLE `exports`
  ADD CONSTRAINT `exports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  ADD CONSTRAINT `failed_import_rows_import_id_foreign` FOREIGN KEY (`import_id`) REFERENCES `imports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `imports`
--
ALTER TABLE `imports`
  ADD CONSTRAINT `imports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
