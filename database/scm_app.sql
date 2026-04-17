-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 17, 2026 at 08:41 AM
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
(21, '2026_04_08_132920_approval_flow', 7),
(23, '2026_04_09_092338_exchange_rate', 8),
(24, '2026_04_09_103417_unit_of_measure', 9),
(26, '2026_04_09_132301_workshop_table', 10),
(29, '2026_04_09_142542_tonnage_table', 11),
(32, '2026_04_09_161016_material_category_table', 12),
(35, '2026_04_10_110100_equipment_type_table', 13),
(45, '2026_04_10_133929_equipment_table', 14),
(49, '2026_04_13_145340_material_table', 15),
(50, '2026_04_16_083430_add_user_status_in_user_table', 16),
(52, '2026_04_16_094425_payment_terms', 17),
(57, '2026_04_16_110250_change_payment_term_on_supplier_table', 18),
(58, '2026_04_16_120201_add_is_default_to_companies_table', 19),
(59, '2026_04_16_133556_add_assign_company_to_users_table', 20),
(61, '2026_04_17_152756_payment_method_table', 21),
(62, '2026_04_17_153143_additional_information_to_customer_table', 22);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
