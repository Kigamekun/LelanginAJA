-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 19, 2023 at 09:46 AM
-- Server version: 10.5.19-MariaDB-cll-lve
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lelangin_lelanginaja`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `schedule` datetime NOT NULL,
  `thumb` text NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `status` enum('pending','approved','declined') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `user_id`, `description`, `phone`, `schedule`, `thumb`, `latitude`, `longitude`, `status`, `created_at`, `updated_at`) VALUES
(11, 9, '<p>fdsfsdfsd</p>', '0895331493506', '2023-03-17 10:19:00', '1678936794-1674561319-Screenshot from 2023-01-24 17-56-56.png', '-6.624398816967676', '106.81159864038183', 'approved', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auctions`
--

CREATE TABLE `auctions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `auction_price` double NOT NULL,
  `note` text DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `snap_token` varchar(255) DEFAULT NULL,
  `payment_status` enum('1','2','3','4') DEFAULT NULL COMMENT '1 = menunggu pembayaran, 2 = sudah dibayar, 3 = kadaluarsa, 4 = gagal / batal',
  `transaction_id` varchar(255) DEFAULT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `jumlah_pembayaran` varchar(255) DEFAULT NULL,
  `payment_status_message` varchar(255) DEFAULT NULL,
  `transaction_time` timestamp NULL DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `approval_code_payment` varchar(255) DEFAULT NULL,
  `last_payment` datetime DEFAULT NULL,
  `courier` varchar(255) DEFAULT NULL,
  `airplane` varchar(255) DEFAULT NULL,
  `no_resi` varchar(255) DEFAULT NULL,
  `file_resi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auctions`
--

INSERT INTO `auctions` (`id`, `auction_price`, `note`, `product_id`, `user_id`, `snap_token`, `payment_status`, `transaction_id`, `order_id`, `jumlah_pembayaran`, `payment_status_message`, `transaction_time`, `payment_type`, `approval_code_payment`, `last_payment`, `courier`, `airplane`, `no_resi`, `file_resi`, `created_at`, `updated_at`) VALUES
(2, 3000000, NULL, 1, 29, '5f5b8881-74bc-4e29-bc7f-dbf32ccc9c94', '1', '7090ecce-1edd-46f4-9fb1-86fc48df926a', '1678811183', '3000000.00', 'Success, Credit Card transaction is successful', '2023-03-14 16:26:45', 'credit_card-maybank', NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-14 16:25:52', '2023-03-14 16:26:51'),
(3, 8000000, NULL, 1, 8, '5f5b8881-74bc-4e29-bc7f-dbf32ccc9c94', '2', '7090ecce-1edd-46f4-9fb1-86fc48df926a', '1678811183', '8000000.00', 'Success, Credit Card transaction is successful', '2023-03-14 16:26:45', 'credit_card-maybank', NULL, '2023-03-14 23:36:09', NULL, NULL, NULL, NULL, '2022-02-14 16:25:52', '2023-03-16 06:28:07'),
(5, 15500000, NULL, 6, 9, 'fd851d25-96f9-4d1b-bb4f-541491204752', '2', '579f8b2c-7ba6-49c0-bde7-5fd567ae1328', '1678891997', '15500000.00', 'Success, transaction is found', '2023-03-15 14:53:33', 'bank_transfer', NULL, '2023-03-15 21:58:08', NULL, NULL, NULL, NULL, '2023-03-15 14:52:51', '2023-03-15 14:54:10'),
(6, 21000000, NULL, 2, 9, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-03-16 00:45:42', '2023-03-16 00:46:34'),
(7, 21000100, NULL, 2, 22, 'c53f10d2-bd94-4772-8518-cded1658ac85', '2', 'd96d7400-7b24-46ff-ae11-37bbf310ce7c', '1678927642', '21000100.00', 'Success, transaction is found', '2023-03-16 00:48:08', 'bank_transfer', NULL, '2023-03-16 07:51:58', NULL, NULL, NULL, NULL, '2023-03-16 00:46:34', '2023-03-16 00:48:46');

--
-- Triggers `auctions`
--
DELIMITER $$
CREATE TRIGGER `SET WINNER` BEFORE INSERT ON `auctions` FOR EACH ROW IF (SELECT count(id) AS coun FROM auctions WHERE product_id = NEW.product_id) > 0 THEN
  IF NEW.auction_price < (SELECT MAX(auction_price) FROM auctions WHERE product_id = NEW.product_id) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Price must be greater than the previous record.';
  END IF;  
ELSE   
  IF NEW.auction_price < (SELECT start_from FROM products WHERE id = NEW.product_id) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Price must be greater than the previous record.';
  END IF;
END IF
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `logging_auction_create` AFTER INSERT ON `auctions` FOR EACH ROW INSERT INTO log VALUES('','INSERT','auction',NOW())
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `logging_auction_delete` AFTER DELETE ON `auctions` FOR EACH ROW INSERT INTO log VALUES('','DELETE','auction',NOW())
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `logging_auction_update` AFTER UPDATE ON `auctions` FOR EACH ROW INSERT INTO log VALUES('','UPDATE','auction',NOW())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `auction_histories`
--

CREATE TABLE `auction_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `thumb` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `title`, `description`, `thumb`, `created_at`, `updated_at`) VALUES
(1, 'Art of Europe', 'art of europe in world', '1675347409-sothebys-com.brightspotcdn.webp', NULL, NULL),
(5, 'Fish Arts', 'Just A fish Art', '1676849617-1675347459-sothebys-com.brightspotcdn.webp', NULL, NULL),
(6, 'Supercar Event', 'Supercar auction', '1677252155-sothebys-com.brightspotcdn.webp', NULL, NULL),
(7, 'Luxury Jewel', 'luxury item', '1677252195-sothebys-com.brightspotcdn.webp', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Antique Europe Item', NULL, NULL),
(2, 'Landmark', NULL, NULL),
(4, 'Antique Cars', '2023-03-13 09:49:10', '2023-03-13 09:49:10'),
(5, 'Electronics', '2023-03-13 09:49:35', '2023-03-13 09:49:35');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_at` datetime DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `title`, `start_at`, `location`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Auction offline in KRB', '2023-02-02 21:25:38', 'KRB (Kebun Raya Bogor)', 10000, NULL, NULL),
(3, 'lelang kuyyy (with Qorygore)', '2023-02-15 21:26:53', 'Botani Square', 200000, NULL, NULL),
(4, 'Lelangin Atuuu (Botani Square Lippo PLAZA)', '2023-03-30 11:06:26', 'Lippo', 0, NULL, NULL);

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
-- Table structure for table `help_centers`
--

CREATE TABLE `help_centers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `help_centers`
--

INSERT INTO `help_centers` (`id`, `ticket_id`, `user_id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'XXX1', 4, 'DASDSA', 'DASDASDASFASFASF', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `log_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `action`, `model`, `log_time`) VALUES
(1, 'INSERT', 'product', '2023-02-25 07:07:44'),
(2, 'INSERT', 'auction', '2023-02-26 11:02:33'),
(3, 'UPDATE', 'product', '2023-02-26 11:04:50'),
(4, 'UPDATE', 'auction', '2023-02-26 11:04:50'),
(5, 'UPDATE', 'auction', '2023-02-26 11:05:04'),
(6, 'UPDATE', 'auction', '2023-02-26 11:05:04'),
(7, 'UPDATE', 'auction', '2023-02-26 11:05:56'),
(8, 'UPDATE', 'auction', '2023-02-26 11:05:56'),
(9, 'UPDATE', 'product', '2023-02-26 11:05:56'),
(10, 'INSERT', 'auction', '2023-02-27 10:03:28'),
(11, 'UPDATE', 'auction', '2023-02-27 10:13:00'),
(12, 'UPDATE', 'auction', '2023-02-27 10:13:01'),
(13, 'UPDATE', 'auction', '2023-02-27 10:13:41'),
(14, 'UPDATE', 'auction', '2023-02-27 10:13:41'),
(15, 'UPDATE', 'product', '2023-02-27 10:13:41'),
(16, 'UPDATE', 'product', '2023-02-27 18:40:13'),
(17, 'INSERT', 'auction', '2023-02-28 18:22:10'),
(18, 'UPDATE', 'product', '2023-03-01 05:39:22'),
(19, 'UPDATE', 'product', '2023-03-01 05:41:54'),
(20, 'UPDATE', 'product', '2023-03-01 05:46:03'),
(21, 'UPDATE', 'product', '2023-03-01 05:46:30'),
(22, 'UPDATE', 'product', '2023-03-01 05:46:49'),
(23, 'INSERT', 'auction', '2023-03-01 11:42:12'),
(24, 'UPDATE', 'auction', '2023-03-01 11:42:12'),
(25, 'UPDATE', 'auction', '2023-03-01 12:05:04'),
(26, 'DELETE', 'auction', '2023-03-01 12:05:09'),
(27, 'UPDATE', 'auction', '2023-03-01 12:10:07'),
(28, 'DELETE', 'auction', '2023-03-01 12:10:11'),
(29, 'INSERT', 'auction', '2023-03-01 12:33:00'),
(30, 'UPDATE', 'auction', '2023-03-01 12:34:16'),
(31, 'INSERT', 'auction', '2023-03-01 12:35:22'),
(32, 'UPDATE', 'auction', '2023-03-01 12:35:32'),
(33, 'UPDATE', 'auction', '2023-03-01 12:35:57'),
(34, 'UPDATE', 'auction', '2023-03-01 12:37:16'),
(35, 'INSERT', 'product', '2023-03-01 13:09:08'),
(36, 'DELETE', 'product', '2023-03-01 13:09:36'),
(37, 'UPDATE', 'product', '2023-03-03 07:05:07'),
(38, 'UPDATE', 'auction', '2023-03-03 07:05:07'),
(39, 'UPDATE', 'auction', '2023-03-03 07:09:33'),
(40, 'UPDATE', 'auction', '2023-03-03 07:09:38'),
(41, 'UPDATE', 'auction', '2023-03-03 07:09:42'),
(42, 'UPDATE', 'auction', '2023-03-03 07:09:46'),
(43, 'UPDATE', 'auction', '2023-03-03 07:09:50'),
(44, 'UPDATE', 'auction', '2023-03-03 07:09:54'),
(45, 'UPDATE', 'auction', '2023-03-03 07:09:57'),
(46, 'UPDATE', 'auction', '2023-03-03 07:10:00'),
(47, 'UPDATE', 'auction', '2023-03-03 07:10:07'),
(48, 'UPDATE', 'auction', '2023-03-03 07:10:07'),
(49, 'UPDATE', 'auction', '2023-03-03 07:10:09'),
(50, 'DELETE', 'auction', '2023-03-03 07:10:14'),
(51, 'UPDATE', 'auction', '2023-03-03 07:10:14'),
(52, 'DELETE', 'auction', '2023-03-03 07:10:15'),
(53, 'UPDATE', 'auction', '2023-03-03 07:10:15'),
(54, 'DELETE', 'auction', '2023-03-03 07:10:17'),
(55, 'UPDATE', 'auction', '2023-03-03 07:10:17'),
(56, 'DELETE', 'auction', '2023-03-03 07:10:18'),
(57, 'UPDATE', 'product', '2023-03-03 07:12:01'),
(58, 'UPDATE', 'product', '2023-03-03 07:12:17'),
(59, 'UPDATE', 'product', '2023-03-03 07:12:25'),
(60, 'UPDATE', 'product', '2023-03-03 07:12:31'),
(61, 'INSERT', 'auction', '2023-03-03 07:13:08'),
(62, 'UPDATE', 'product', '2023-03-03 07:13:34'),
(63, 'UPDATE', 'auction', '2023-03-03 07:13:34'),
(64, 'UPDATE', 'auction', '2023-03-03 07:13:49'),
(65, 'UPDATE', 'auction', '2023-03-03 07:13:49'),
(66, 'INSERT', 'auction', '2023-03-03 07:14:50'),
(67, 'UPDATE', 'auction', '2023-03-03 07:15:14'),
(68, 'UPDATE', 'auction', '2023-03-03 07:15:14'),
(69, 'UPDATE', 'product', '2023-03-03 07:15:14'),
(70, 'UPDATE', 'product', '2023-03-03 07:16:31'),
(71, 'UPDATE', 'auction', '2023-03-03 07:16:31'),
(72, 'UPDATE', 'auction', '2023-03-03 07:22:06'),
(73, 'DELETE', 'auction', '2023-03-03 07:22:09'),
(74, 'UPDATE', 'product', '2023-03-03 07:24:30'),
(75, 'INSERT', 'auction', '2023-03-03 10:37:10'),
(76, 'INSERT', 'auction', '2023-03-03 10:37:26'),
(77, 'UPDATE', 'auction', '2023-03-03 10:37:26'),
(78, 'UPDATE', 'product', '2023-03-03 10:38:30'),
(79, 'UPDATE', 'product', '2023-03-03 10:39:42'),
(80, 'UPDATE', 'auction', '2023-03-03 10:39:42'),
(81, 'UPDATE', 'auction', '2023-03-03 10:42:08'),
(82, 'DELETE', 'auction', '2023-03-03 10:42:12'),
(83, 'UPDATE', 'auction', '2023-03-03 10:42:54'),
(84, 'UPDATE', 'auction', '2023-03-03 10:43:24'),
(85, 'UPDATE', 'auction', '2023-03-03 10:43:25'),
(86, 'UPDATE', 'auction', '2023-03-03 10:43:28'),
(87, 'UPDATE', 'auction', '2023-03-03 10:43:28'),
(88, 'UPDATE', 'auction', '2023-03-03 10:43:28'),
(89, 'UPDATE', 'auction', '2023-03-03 10:43:39'),
(90, 'UPDATE', 'auction', '2023-03-03 10:43:57'),
(91, 'UPDATE', 'auction', '2023-03-03 10:44:03'),
(92, 'DELETE', 'auction', '2023-03-03 10:44:06'),
(93, 'INSERT', 'auction', '2023-03-03 16:01:18'),
(94, 'UPDATE', 'product', '2023-03-03 16:06:52'),
(95, 'UPDATE', 'auction', '2023-03-03 16:06:52'),
(96, 'UPDATE', 'auction', '2023-03-03 16:07:03'),
(97, 'DELETE', 'auction', '2023-03-03 16:07:06'),
(98, 'INSERT', 'auction', '2023-03-03 16:11:39'),
(99, 'UPDATE', 'product', '2023-03-03 16:12:55'),
(100, 'UPDATE', 'auction', '2023-03-03 16:12:55'),
(101, 'UPDATE', 'auction', '2023-03-03 16:13:03'),
(102, 'DELETE', 'auction', '2023-03-03 16:13:06'),
(103, 'INSERT', 'auction', '2023-03-03 17:56:40'),
(104, 'UPDATE', 'product', '2023-03-03 17:57:15'),
(105, 'UPDATE', 'auction', '2023-03-03 17:57:15'),
(106, 'UPDATE', 'auction', '2023-03-03 17:57:29'),
(107, 'UPDATE', 'auction', '2023-03-03 17:57:57'),
(108, 'UPDATE', 'auction', '2023-03-03 17:58:02'),
(109, 'DELETE', 'auction', '2023-03-03 17:58:06'),
(110, 'UPDATE', 'product', '2023-03-03 18:12:50'),
(111, 'UPDATE', 'product', '2023-03-03 18:13:14'),
(112, 'UPDATE', 'auction', '2023-03-03 18:13:14'),
(113, 'DELETE', 'auction', '2023-03-03 18:13:28'),
(114, 'UPDATE', 'product', '2023-03-03 18:13:50'),
(115, 'INSERT', 'auction', '2023-03-03 18:14:03'),
(116, 'UPDATE', 'product', '2023-03-03 18:14:14'),
(117, 'UPDATE', 'auction', '2023-03-03 18:14:14'),
(118, 'UPDATE', 'auction', '2023-03-03 18:14:28'),
(119, 'UPDATE', 'auction', '2023-03-03 18:14:35'),
(120, 'UPDATE', 'auction', '2023-03-03 18:15:03'),
(121, 'DELETE', 'auction', '2023-03-03 18:15:07'),
(122, 'UPDATE', 'product', '2023-03-03 18:16:55'),
(123, 'INSERT', 'auction', '2023-03-03 18:17:47'),
(124, 'UPDATE', 'product', '2023-03-03 18:17:53'),
(125, 'UPDATE', 'auction', '2023-03-03 18:17:53'),
(126, 'UPDATE', 'auction', '2023-03-03 18:22:22'),
(127, 'UPDATE', 'auction', '2023-03-03 18:23:03'),
(128, 'DELETE', 'auction', '2023-03-03 18:23:06'),
(129, 'UPDATE', 'product', '2023-03-03 18:25:28'),
(130, 'INSERT', 'auction', '2023-03-03 18:25:50'),
(131, 'UPDATE', 'product', '2023-03-03 18:26:02'),
(132, 'UPDATE', 'auction', '2023-03-03 18:26:02'),
(133, 'UPDATE', 'auction', '2023-03-03 18:40:05'),
(134, 'DELETE', 'auction', '2023-03-03 18:40:05'),
(135, 'UPDATE', 'product', '2023-03-03 18:41:12'),
(136, 'INSERT', 'auction', '2023-03-03 18:41:30'),
(137, 'UPDATE', 'product', '2023-03-03 18:41:34'),
(138, 'UPDATE', 'auction', '2023-03-03 18:41:34'),
(139, 'UPDATE', 'auction', '2023-03-03 18:42:03'),
(140, 'DELETE', 'auction', '2023-03-03 18:42:03'),
(141, 'UPDATE', 'product', '2023-03-03 18:42:57'),
(142, 'INSERT', 'auction', '2023-03-03 18:43:13'),
(143, 'UPDATE', 'product', '2023-03-03 18:43:17'),
(144, 'UPDATE', 'auction', '2023-03-03 18:43:17'),
(145, 'UPDATE', 'auction', '2023-03-03 18:44:03'),
(146, 'UPDATE', 'auction', '2023-03-03 18:45:10'),
(147, 'UPDATE', 'auction', '2023-03-03 18:46:03'),
(148, 'UPDATE', 'auction', '2023-03-03 18:46:43'),
(149, 'UPDATE', 'auction', '2023-03-03 18:48:00'),
(150, 'UPDATE', 'auction', '2023-03-03 18:48:04'),
(151, 'UPDATE', 'auction', '2023-03-03 18:48:24'),
(152, 'UPDATE', 'auction', '2023-03-03 18:48:58'),
(153, 'UPDATE', 'auction', '2023-03-03 18:49:07'),
(154, 'UPDATE', 'auction', '2023-03-03 18:49:51'),
(155, 'UPDATE', 'auction', '2023-03-03 18:50:10'),
(156, 'UPDATE', 'auction', '2023-03-03 18:50:27'),
(157, 'UPDATE', 'auction', '2023-03-03 18:50:47'),
(158, 'UPDATE', 'auction', '2023-03-03 18:50:52'),
(159, 'UPDATE', 'auction', '2023-03-03 18:55:05'),
(160, 'DELETE', 'auction', '2023-03-03 19:00:07'),
(161, 'UPDATE', 'product', '2023-03-03 19:00:51'),
(162, 'INSERT', 'auction', '2023-03-03 19:01:11'),
(163, 'UPDATE', 'product', '2023-03-03 19:01:21'),
(164, 'UPDATE', 'auction', '2023-03-03 19:01:21'),
(165, 'DELETE', 'auction', '2023-03-03 19:02:03'),
(166, 'UPDATE', 'product', '2023-03-03 19:06:24'),
(167, 'INSERT', 'auction', '2023-03-03 19:07:01'),
(168, 'UPDATE', 'product', '2023-03-03 19:07:49'),
(169, 'UPDATE', 'auction', '2023-03-03 19:07:49'),
(170, 'DELETE', 'auction', '2023-03-03 19:08:04'),
(171, 'UPDATE', 'product', '2023-03-03 19:09:46'),
(172, 'INSERT', 'auction', '2023-03-03 19:10:05'),
(173, 'UPDATE', 'product', '2023-03-03 19:10:41'),
(174, 'UPDATE', 'auction', '2023-03-03 19:10:42'),
(175, 'DELETE', 'auction', '2023-03-03 19:16:04'),
(176, 'UPDATE', 'product', '2023-03-03 19:31:49'),
(177, 'INSERT', 'auction', '2023-03-03 19:32:11'),
(178, 'UPDATE', 'product', '2023-03-03 19:32:24'),
(179, 'UPDATE', 'auction', '2023-03-03 19:32:24'),
(180, 'DELETE', 'auction', '2023-03-03 19:38:08'),
(181, 'UPDATE', 'product', '2023-03-11 18:07:15'),
(182, 'INSERT', 'auction', '2023-03-11 18:07:56'),
(183, 'UPDATE', 'product', '2023-03-11 18:08:18'),
(184, 'UPDATE', 'auction', '2023-03-11 18:08:18'),
(185, 'UPDATE', 'auction', '2023-03-11 18:08:42'),
(186, 'UPDATE', 'auction', '2023-03-11 18:08:43'),
(187, 'UPDATE', 'auction', '2023-03-11 18:09:04'),
(188, 'UPDATE', 'auction', '2023-03-11 18:09:04'),
(189, 'UPDATE', 'product', '2023-03-11 18:09:04'),
(190, 'UPDATE', 'product', '2023-03-11 19:19:28'),
(191, 'UPDATE', 'product', '2023-03-11 19:19:31'),
(192, 'UPDATE', 'product', '2023-03-11 19:19:34'),
(193, 'UPDATE', 'product', '2023-03-11 19:19:36'),
(194, 'UPDATE', 'product', '2023-03-11 19:19:39'),
(195, 'INSERT', 'auction', '2023-03-11 19:20:21'),
(196, 'DELETE', 'auction', '2023-03-11 19:21:09'),
(197, 'UPDATE', 'product', '2023-03-11 19:25:09'),
(198, 'UPDATE', 'auction', '2023-03-11 19:25:09'),
(199, 'UPDATE', 'auction', '2023-03-11 19:25:27'),
(200, 'UPDATE', 'auction', '2023-03-11 19:25:27'),
(201, 'UPDATE', 'auction', '2023-03-11 19:26:16'),
(202, 'UPDATE', 'auction', '2023-03-11 19:26:16'),
(203, 'UPDATE', 'product', '2023-03-11 19:26:16'),
(204, 'UPDATE', 'auction', '2023-03-11 19:28:16'),
(205, 'UPDATE', 'auction', '2023-03-11 22:02:05'),
(206, 'UPDATE', 'auction', '2023-03-11 22:02:10'),
(207, 'UPDATE', 'auction', '2023-03-11 22:02:20'),
(208, 'UPDATE', 'auction', '2023-03-11 22:02:21'),
(209, 'UPDATE', 'auction', '2023-03-11 22:02:49'),
(210, 'UPDATE', 'auction', '2023-03-11 22:02:49'),
(211, 'UPDATE', 'product', '2023-03-11 22:02:49'),
(212, 'INSERT', 'auction', '2023-03-12 17:07:08'),
(213, 'UPDATE', 'product', '2023-03-12 17:07:32'),
(214, 'UPDATE', 'auction', '2023-03-12 17:07:32'),
(215, 'UPDATE', 'auction', '2023-03-12 17:08:06'),
(216, 'UPDATE', 'auction', '2023-03-12 17:08:07'),
(217, 'UPDATE', 'auction', '2023-03-12 17:08:35'),
(218, 'UPDATE', 'product', '2023-03-12 17:08:35'),
(219, 'DELETE', 'auction', '2023-03-12 17:13:05'),
(220, 'DELETE', 'auction', '2023-03-12 21:01:55'),
(221, 'INSERT', 'auction', '2023-03-13 09:54:33'),
(222, 'UPDATE', 'product', '2023-03-13 09:54:40'),
(223, 'UPDATE', 'auction', '2023-03-13 09:54:40'),
(224, 'UPDATE', 'auction', '2023-03-13 09:54:48'),
(225, 'UPDATE', 'auction', '2023-03-13 09:54:48'),
(226, 'UPDATE', 'auction', '2023-03-13 09:55:11'),
(227, 'UPDATE', 'auction', '2023-03-13 09:55:11'),
(228, 'UPDATE', 'product', '2023-03-13 09:55:12'),
(229, 'UPDATE', 'auction', '2023-03-13 09:55:48'),
(230, 'UPDATE', 'auction', '2023-03-13 09:57:17'),
(231, 'UPDATE', 'product', '2023-03-13 10:28:58'),
(232, 'INSERT', 'auction', '2023-03-13 10:29:56'),
(233, 'UPDATE', 'auction', '2023-03-13 10:35:18'),
(234, 'UPDATE', 'auction', '2023-03-13 10:35:18'),
(235, 'UPDATE', 'auction', '2023-03-13 10:35:48'),
(236, 'UPDATE', 'auction', '2023-03-13 10:35:48'),
(237, 'UPDATE', 'product', '2023-03-13 10:35:48'),
(238, 'INSERT', 'auction', '2023-03-13 11:02:04'),
(239, 'INSERT', 'auction', '2023-03-13 11:38:47'),
(240, 'UPDATE', 'auction', '2023-03-13 13:27:58'),
(241, 'UPDATE', 'product', '2023-03-13 13:36:42'),
(242, 'UPDATE', 'product', '2023-03-13 13:36:57'),
(243, 'UPDATE', 'product', '2023-03-13 13:37:21'),
(244, 'UPDATE', 'product', '2023-03-13 13:37:52'),
(245, 'INSERT', 'auction', '2023-03-13 13:40:20'),
(246, 'UPDATE', 'auction', '2023-03-13 13:45:08'),
(247, 'UPDATE', 'auction', '2023-03-13 13:45:09'),
(248, 'UPDATE', 'auction', '2023-03-13 13:46:05'),
(249, 'INSERT', 'auction', '2023-03-13 14:54:32'),
(250, 'DELETE', 'auction', '2023-03-13 16:16:53'),
(251, 'INSERT', 'product', '2023-03-13 16:50:45'),
(252, 'INSERT', 'product', '2023-03-13 16:56:39'),
(253, 'INSERT', 'product', '2023-03-13 16:59:09'),
(254, 'INSERT', 'auction', '2023-03-13 18:04:31'),
(255, 'UPDATE', 'product', '2023-03-14 07:47:50'),
(256, 'UPDATE', 'auction', '2023-03-14 07:47:50'),
(257, 'UPDATE', 'auction', '2023-03-14 07:48:08'),
(258, 'UPDATE', 'auction', '2023-03-14 07:48:09'),
(259, 'UPDATE', 'auction', '2023-03-14 07:48:31'),
(260, 'UPDATE', 'auction', '2023-03-14 07:48:31'),
(261, 'UPDATE', 'product', '2023-03-14 07:48:31'),
(262, 'INSERT', 'auction', '2023-03-14 08:30:25'),
(263, 'UPDATE', 'product', '2023-03-14 08:31:05'),
(264, 'UPDATE', 'auction', '2023-03-14 08:31:07'),
(265, 'UPDATE', 'auction', '2023-03-14 08:32:04'),
(266, 'UPDATE', 'auction', '2023-03-14 08:32:05'),
(267, 'UPDATE', 'auction', '2023-03-14 08:32:30'),
(268, 'UPDATE', 'auction', '2023-03-14 08:32:30'),
(269, 'UPDATE', 'product', '2023-03-14 08:32:30'),
(270, 'INSERT', 'auction', '2023-03-14 10:23:13'),
(271, 'INSERT', 'auction', '2023-03-14 11:12:55'),
(272, 'DELETE', 'auction', '2023-03-14 11:12:59'),
(273, 'INSERT', 'auction', '2023-03-14 11:17:50'),
(274, 'DELETE', 'auction', '2023-03-14 11:18:08'),
(275, 'INSERT', 'auction', '2023-03-14 11:22:48'),
(276, 'UPDATE', 'auction', '2023-03-14 11:27:31'),
(277, 'UPDATE', 'product', '2023-03-14 11:50:54'),
(278, 'UPDATE', 'auction', '2023-03-14 11:50:54'),
(279, 'DELETE', 'auction', '2023-03-14 11:56:10'),
(280, 'INSERT', 'auction', '2023-03-14 12:42:52'),
(281, 'UPDATE', 'auction', '2023-03-14 12:43:19'),
(282, 'INSERT', 'auction', '2023-03-14 12:49:25'),
(283, 'UPDATE', 'auction', '2023-03-14 12:49:25'),
(284, 'DELETE', 'auction', '2023-03-14 13:04:47'),
(285, 'DELETE', 'auction', '2023-03-14 13:04:50'),
(286, 'DELETE', 'auction', '2023-03-14 13:04:53'),
(287, 'DELETE', 'auction', '2023-03-14 13:04:56'),
(288, 'DELETE', 'auction', '2023-03-14 13:04:59'),
(289, 'DELETE', 'auction', '2023-03-14 13:05:02'),
(290, 'UPDATE', 'product', '2023-03-14 13:05:12'),
(291, 'UPDATE', 'product', '2023-03-14 13:05:21'),
(292, 'UPDATE', 'product', '2023-03-14 13:05:30'),
(293, 'UPDATE', 'product', '2023-03-14 13:05:44'),
(294, 'INSERT', 'auction', '2023-03-14 13:38:53'),
(295, 'UPDATE', 'auction', '2023-03-14 13:40:19'),
(296, 'UPDATE', 'product', '2023-03-14 13:41:22'),
(297, 'UPDATE', 'auction', '2023-03-14 13:41:22'),
(298, 'DELETE', 'auction', '2023-03-14 13:47:08'),
(299, 'INSERT', 'auction', '2023-03-14 13:50:10'),
(300, 'INSERT', 'auction', '2023-03-14 13:50:30'),
(301, 'UPDATE', 'auction', '2023-03-14 13:50:37'),
(302, 'UPDATE', 'auction', '2023-03-14 13:50:40'),
(303, 'UPDATE', 'auction', '2023-03-14 13:50:43'),
(304, 'UPDATE', 'auction', '2023-03-14 13:50:46'),
(305, 'UPDATE', 'auction', '2023-03-14 13:50:49'),
(306, 'UPDATE', 'auction', '2023-03-14 13:51:10'),
(307, 'UPDATE', 'auction', '2023-03-14 14:01:25'),
(308, 'UPDATE', 'auction', '2023-03-14 14:02:56'),
(309, 'UPDATE', 'product', '2023-03-14 19:23:46'),
(310, 'INSERT', 'auction', '2023-03-14 23:25:52'),
(311, 'UPDATE', 'product', '2023-03-14 23:26:09'),
(312, 'UPDATE', 'auction', '2023-03-14 23:26:09'),
(313, 'UPDATE', 'auction', '2023-03-14 23:26:23'),
(314, 'UPDATE', 'auction', '2023-03-14 23:26:24'),
(315, 'UPDATE', 'auction', '2023-03-14 23:26:51'),
(316, 'UPDATE', 'auction', '2023-03-14 23:26:51'),
(317, 'UPDATE', 'product', '2023-03-14 23:26:51'),
(318, 'UPDATE', 'product', '2023-03-15 11:46:20'),
(319, 'UPDATE', 'product', '2023-03-15 11:46:36'),
(320, 'INSERT', 'auction', '2023-03-15 11:49:06'),
(321, 'INSERT', 'auction', '2023-03-15 11:49:58'),
(322, 'UPDATE', 'auction', '2023-03-15 11:50:08'),
(323, 'INSERT', 'auction', '2023-03-15 21:47:50'),
(324, 'UPDATE', 'product', '2023-03-15 21:49:41'),
(325, 'UPDATE', 'auction', '2023-03-15 21:49:41'),
(326, 'UPDATE', 'auction', '2023-03-15 21:49:52'),
(327, 'UPDATE', 'auction', '2023-03-15 21:49:53'),
(328, 'UPDATE', 'auction', '2023-03-15 21:50:36'),
(329, 'UPDATE', 'auction', '2023-03-15 21:50:36'),
(330, 'UPDATE', 'product', '2023-03-15 21:50:36'),
(331, 'DELETE', 'auction', '2023-03-15 21:51:33'),
(332, 'UPDATE', 'product', '2023-03-15 21:51:49'),
(333, 'INSERT', 'auction', '2023-03-15 21:52:51'),
(334, 'UPDATE', 'product', '2023-03-15 21:53:08'),
(335, 'UPDATE', 'auction', '2023-03-15 21:53:08'),
(336, 'UPDATE', 'auction', '2023-03-15 21:53:17'),
(337, 'UPDATE', 'auction', '2023-03-15 21:53:18'),
(338, 'UPDATE', 'auction', '2023-03-15 21:54:10'),
(339, 'UPDATE', 'auction', '2023-03-15 21:54:10'),
(340, 'UPDATE', 'product', '2023-03-15 21:54:10'),
(341, 'INSERT', 'auction', '2023-03-16 07:45:42'),
(342, 'INSERT', 'auction', '2023-03-16 07:46:34'),
(343, 'UPDATE', 'auction', '2023-03-16 07:46:34'),
(344, 'UPDATE', 'product', '2023-03-16 07:46:58'),
(345, 'UPDATE', 'auction', '2023-03-16 07:46:58'),
(346, 'UPDATE', 'auction', '2023-03-16 07:47:22'),
(347, 'UPDATE', 'auction', '2023-03-16 07:47:22'),
(348, 'UPDATE', 'auction', '2023-03-16 07:48:46'),
(349, 'UPDATE', 'auction', '2023-03-16 07:48:46'),
(350, 'UPDATE', 'product', '2023-03-16 07:48:46'),
(351, 'INSERT', 'product', '2023-03-16 10:09:21'),
(352, 'INSERT', 'auction', '2023-03-16 10:11:04'),
(353, 'INSERT', 'auction', '2023-03-16 10:11:45'),
(354, 'UPDATE', 'auction', '2023-03-16 10:11:45'),
(355, 'UPDATE', 'product', '2023-03-16 10:12:34'),
(356, 'UPDATE', 'auction', '2023-03-16 10:12:34'),
(357, 'UPDATE', 'auction', '2023-03-16 10:14:35'),
(358, 'UPDATE', 'auction', '2023-03-16 10:14:35'),
(359, 'UPDATE', 'auction', '2023-03-16 10:15:43'),
(360, 'UPDATE', 'auction', '2023-03-16 10:15:43'),
(361, 'UPDATE', 'product', '2023-03-16 10:15:43'),
(362, 'UPDATE', 'auction', '2023-03-16 10:17:08'),
(363, 'DELETE', 'product', '2023-03-16 13:04:02'),
(364, 'UPDATE', 'auction', '2023-03-16 13:24:30'),
(365, 'UPDATE', 'auction', '2023-03-16 13:24:35'),
(366, 'UPDATE', 'auction', '2023-03-16 13:24:40'),
(367, 'UPDATE', 'auction', '2023-03-16 13:24:46'),
(368, 'UPDATE', 'auction', '2023-03-16 13:25:11'),
(369, 'UPDATE', 'auction', '2023-03-16 13:25:14'),
(370, 'DELETE', 'auction', '2023-03-16 13:28:07'),
(371, 'UPDATE', 'auction', '2023-03-16 13:28:07'),
(372, 'UPDATE', 'auction', '2023-03-16 13:28:22');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_01_22_025555_create_categories_table', 1),
(6, '2023_01_22_025556_create_products_table', 1),
(7, '2023_01_22_025848_create_auctions_table', 1),
(8, '2023_01_22_025900_create_auction_histories_table', 1),
(9, '2023_01_22_025920_create_help_centers_table', 1),
(10, '2023_01_31_113351_create_banner_table', 1),
(11, '2023_01_31_113433_create_event_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `for` int(11) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 2, 'auth_token', '90f4ed087ac10a52e111537ba6d59a731727251096eaa5a750c93df3b1160342', '[\"*\"]', NULL, NULL, '2023-02-04 08:42:30', '2023-02-04 08:42:30'),
(2, 'App\\Models\\User', 2, 'auth_token', 'd8b281a673041d3a427532c3ac624a698cf18f632e2085768f947c9dbe4560a9', '[\"*\"]', NULL, NULL, '2023-02-04 08:42:33', '2023-02-04 08:42:33'),
(3, 'App\\Models\\User', 2, 'auth_token', 'b4c93598aeff0392d1ebbf3b9c74bf53e584fa4e2986798b3334f7c7bb70758c', '[\"*\"]', NULL, NULL, '2023-02-04 08:42:57', '2023-02-04 08:42:57'),
(4, 'App\\Models\\User', 2, 'auth_token', 'c60b3298fe14d340ca649d8e6652321ebe311eed640241359918dfacf6683b7f', '[\"*\"]', NULL, NULL, '2023-02-04 08:45:09', '2023-02-04 08:45:09'),
(5, 'App\\Models\\User', 2, 'auth_token', '1220df1b16040218ab765731588b3b6608ff9dfca3a6154d2ade018fa104b4d9', '[\"*\"]', '2023-02-04 09:50:10', NULL, '2023-02-04 08:45:54', '2023-02-04 09:50:10'),
(6, 'App\\Models\\User', 2, 'auth_token', 'da7bb7e047af99fe07563b72a2e529eb737c5daffe0b01a73eccfc566d64a55f', '[\"*\"]', '2023-02-04 10:11:35', NULL, '2023-02-04 10:11:32', '2023-02-04 10:11:35'),
(7, 'App\\Models\\User', 2, 'auth_token', '68a456e4d1b4329dc9f9fff501af3bacd73ba062d35690e330ca1e1d98bf7e80', '[\"*\"]', '2023-02-05 07:08:56', NULL, '2023-02-04 10:13:49', '2023-02-05 07:08:56'),
(8, 'App\\Models\\User', 2, 'auth_token', '1e1ecc97880eccd7b9483efa7302798bcd9edbf7e1ef29c33a22c7105844737b', '[\"*\"]', NULL, NULL, '2023-02-04 10:26:44', '2023-02-04 10:26:44'),
(9, 'App\\Models\\User', 2, 'auth_token', 'fc2d6baf4edeef8e2753be7edd111adae161025f3632a091e0ed25ab1c5aca70', '[\"*\"]', '2023-02-05 08:45:56', NULL, '2023-02-05 07:13:49', '2023-02-05 08:45:56'),
(10, 'App\\Models\\User', 2, 'auth_token', '1dc16a9adc7133b0f1714e3e84d8aefd197e0d7a02ad1b8ce488057e63049210', '[\"*\"]', '2023-02-05 09:51:07', NULL, '2023-02-05 09:20:09', '2023-02-05 09:51:07'),
(11, 'App\\Models\\User', 2, 'auth_token', 'fe0e5a06e64bf71bd9d76614e28636cbdc420af4f0e03a73e6411e6b69d6858d', '[\"*\"]', '2023-02-06 01:18:07', NULL, '2023-02-06 01:16:24', '2023-02-06 01:18:07'),
(12, 'App\\Models\\User', 2, 'auth_token', 'becc2600d743654d711aac2c7975ee911b815efcb1d8a3270d02be767d7f5e4d', '[\"*\"]', '2023-02-06 02:05:14', NULL, '2023-02-06 01:29:48', '2023-02-06 02:05:14'),
(13, 'App\\Models\\User', 2, 'auth_token', '30a66a5ab318fbcb54e17a8636a3ad1ac491f68d8a0d74e1ba252d6dc07e6f92', '[\"*\"]', '2023-02-08 00:28:59', NULL, '2023-02-06 02:30:12', '2023-02-08 00:28:59'),
(14, 'App\\Models\\User', 3, 'auth_token', '1001fe98cc220db110795d40b0d32f6926eee4bafa2a3fa6c4cc4c36d9bf3862', '[\"*\"]', '2023-02-07 12:08:55', NULL, '2023-02-07 11:08:49', '2023-02-07 12:08:55'),
(15, 'App\\Models\\User', 2, 'auth_token', 'e4b43135aae314b6685ffea37266a8ccdac947eaeeade55244dd432cb55fe6f3', '[\"*\"]', '2023-02-09 15:30:15', NULL, '2023-02-08 00:34:32', '2023-02-09 15:30:15'),
(16, 'App\\Models\\User', 3, 'auth_token', 'adf6afe21477a4f5ad7fbba29aa35105339678e8445817cb84f038a2604cc23d', '[\"*\"]', '2023-02-14 03:18:29', NULL, '2023-02-08 01:32:38', '2023-02-14 03:18:29'),
(17, 'App\\Models\\User', 3, 'auth_token', 'c9b6bc1066e81449a78f2802d947515e65065d49809fd7b87bdc7e3ebd369da6', '[\"*\"]', '2023-02-10 06:14:15', NULL, '2023-02-10 06:02:19', '2023-02-10 06:14:15'),
(18, 'App\\Models\\User', 2, 'auth_token', '7fa21da8576854cc1ee69cc5f77ed9fbaa96665577af29e1ccbc3cb44c962073', '[\"*\"]', '2023-02-14 09:58:40', NULL, '2023-02-11 09:30:25', '2023-02-14 09:58:40'),
(19, 'App\\Models\\User', 3, 'auth_token', '856b31dca889b66419e605a94b717a56f3ba5fc3e8e398f419d4a8a003d78e6c', '[\"*\"]', '2023-02-14 06:34:55', NULL, '2023-02-14 03:17:49', '2023-02-14 06:34:55'),
(20, 'App\\Models\\User', 2, 'auth_token', '9ff64f94219c762b14f99320d781369d8556a5274ba5cadaecd0a008e9cc5d2f', '[\"*\"]', '2023-02-14 06:36:17', NULL, '2023-02-14 06:35:21', '2023-02-14 06:36:17'),
(21, 'App\\Models\\User', 2, 'auth_token', '9fbe671dd11825aec4d53afdac9594a7d970a8a6b8e05ffd9a9a164e62a7c83f', '[\"*\"]', '2023-02-14 10:53:39', NULL, '2023-02-14 09:34:04', '2023-02-14 10:53:39'),
(22, 'App\\Models\\User', 2, 'auth_token', '5126166bcd35d2f0aa66cc365924b565379a604c1a3a45293d970bc636036ede', '[\"*\"]', NULL, NULL, '2023-02-14 10:00:33', '2023-02-14 10:00:33'),
(23, 'App\\Models\\User', 2, 'auth_token', '85f1e651cc68b29103bb5ac73c71f1b0b34e66ab1782730d98e2dff1de6cdacc', '[\"*\"]', '2023-02-17 23:30:57', NULL, '2023-02-14 10:10:49', '2023-02-17 23:30:57'),
(24, 'App\\Models\\User', 4, 'auth_token', '5e9cd4a5609806a8539367333a2f96f92aa526596143fb60a4e5ec4a62f2e0a0', '[\"*\"]', '2023-02-17 23:58:53', NULL, '2023-02-17 23:44:05', '2023-02-17 23:58:53'),
(25, 'App\\Models\\User', 2, 'auth_token', '363f1bd29df417e0f9c9a7106acb26fd0414e0db4d962f64816ec755e2180870', '[\"*\"]', '2023-02-18 00:24:00', NULL, '2023-02-18 00:00:36', '2023-02-18 00:24:00'),
(26, 'App\\Models\\User', 2, 'auth_token', '3326a9a88e0b6952dbea5a1fc987cef19d8b9863a08283d6af22a7dad3971f6f', '[\"*\"]', '2023-02-18 00:49:30', NULL, '2023-02-18 00:49:29', '2023-02-18 00:49:30'),
(27, 'App\\Models\\User', 2, 'auth_token', 'b8d71abbfa0d2114b4165c195f509d060a28624d0877c606633405941d68573b', '[\"*\"]', '2023-02-18 00:56:58', NULL, '2023-02-18 00:56:49', '2023-02-18 00:56:58'),
(28, 'App\\Models\\User', 2, 'auth_token', 'ef3ba675099c834e46e7af3e829acf5c5f75fd4a8a3559a9ee7f8abd3d130b18', '[\"*\"]', '2023-02-18 00:58:16', NULL, '2023-02-18 00:57:16', '2023-02-18 00:58:16'),
(29, 'App\\Models\\User', 4, 'auth_token', '51a3d8297a50a117393bba2c2b64b9da1736c120c36080bdb567bd054f2f4fac', '[\"*\"]', '2023-02-18 01:07:57', NULL, '2023-02-18 00:58:46', '2023-02-18 01:07:57'),
(30, 'App\\Models\\User', 2, 'auth_token', '5ff653530cfaa48d7dd618660d58e49aa998257c3c1160f0eab52fa8289a3dfe', '[\"*\"]', '2023-02-18 01:09:44', NULL, '2023-02-18 01:09:43', '2023-02-18 01:09:44'),
(31, 'App\\Models\\User', 4, 'auth_token', '203c61332dc70d40096d5e25f53a64589f474a511672e3ff036f41820e66b6a9', '[\"*\"]', '2023-02-18 01:10:29', NULL, '2023-02-18 01:10:18', '2023-02-18 01:10:29'),
(32, 'App\\Models\\User', 2, 'auth_token', '3e12155b7aeb1b4563fd41f11af5bf7d9a6cce01ab889e3f46883c1820fbc5bf', '[\"*\"]', '2023-02-18 02:03:04', NULL, '2023-02-18 02:01:52', '2023-02-18 02:03:04'),
(33, 'App\\Models\\User', 2, 'auth_token', 'b0e51c9a8194887c8b5f73f47efe1636384fdffdbfb30b91145293ed63f3e541', '[\"*\"]', '2023-02-18 02:05:43', NULL, '2023-02-18 02:05:37', '2023-02-18 02:05:43'),
(34, 'App\\Models\\User', 2, 'auth_token', 'cddf5e16f1023dad78d16d889a70c109ab620c644c067fa03b7d73212af63b21', '[\"*\"]', '2023-02-18 03:16:54', NULL, '2023-02-18 02:16:19', '2023-02-18 03:16:54'),
(35, 'App\\Models\\User', 4, 'auth_token', 'f77ab5947242aeb49115a32f4b54546922df1d700dae35b1265a429dd214b574', '[\"*\"]', '2023-02-19 03:39:21', NULL, '2023-02-19 03:38:56', '2023-02-19 03:39:21'),
(36, 'App\\Models\\User', 4, 'auth_token', 'adcaee6682dad9d7764b4df042de853d1be6fb9cec1f308f99cfa4252e49f7b1', '[\"*\"]', '2023-02-19 05:37:20', NULL, '2023-02-19 05:36:54', '2023-02-19 05:37:20'),
(37, 'App\\Models\\User', 4, 'auth_token', 'e53e98fb6dd506be7d430571401758d95ba1bf385bcc0ead35e06ae801055b85', '[\"*\"]', '2023-02-19 05:43:20', NULL, '2023-02-19 05:37:42', '2023-02-19 05:43:20'),
(38, 'App\\Models\\User', 4, 'auth_token', '2f9ffb3397f1f0feaa1997bf25f32f05d1838e783f9f09bc23bcc6237e0b86b3', '[\"*\"]', '2023-02-19 05:44:13', NULL, '2023-02-19 05:44:13', '2023-02-19 05:44:13'),
(39, 'App\\Models\\User', 4, 'auth_token', '18cd3d0cc2aafa8f61aeec35a48611dbb7c4f4e55b43bde58d0bf333b0e5a435', '[\"*\"]', '2023-02-19 05:48:42', NULL, '2023-02-19 05:48:15', '2023-02-19 05:48:42'),
(40, 'App\\Models\\User', 4, 'auth_token', 'fd5e3924d5610a0c6b20adb81c6db5c777d8b3563a45c7afcbff4403a6790031', '[\"*\"]', '2023-02-20 12:37:47', NULL, '2023-02-19 05:52:44', '2023-02-20 12:37:47'),
(41, 'App\\Models\\User', 4, 'auth_token', '32544dd7b5f619f73e4fb903d696e857cb0d542a56c1145f0f57921cd6328050', '[\"*\"]', '2023-02-19 08:46:49', NULL, '2023-02-19 08:46:32', '2023-02-19 08:46:49'),
(42, 'App\\Models\\User', 4, 'auth_token', '1ca32ed0449dd6a6f9547b746fcfcd03118cc2087ddb6aaacc95c25f26399c74', '[\"*\"]', '2023-02-19 11:41:35', NULL, '2023-02-19 11:40:43', '2023-02-19 11:41:35'),
(43, 'App\\Models\\User', 9, 'auth_token', '3eb5558bdca24b97c8a8bab3406ec551b609c1e4c6a3063bb72f6a0f1b9004e0', '[\"*\"]', '2023-02-20 07:49:51', NULL, '2023-02-20 07:49:00', '2023-02-20 07:49:51'),
(44, 'App\\Models\\User', 9, 'auth_token', 'a3c686d180f208087a824f3ab209596c2169b47792893f80b043574348c4343c', '[\"*\"]', NULL, NULL, '2023-02-20 08:01:46', '2023-02-20 08:01:46'),
(45, 'App\\Models\\User', 9, 'auth_token', 'a8b42fea4de75e3fefa0e6df1a42d3e093998d90d5c3b31df1f365900afecdb1', '[\"*\"]', '2023-02-20 14:27:20', NULL, '2023-02-20 08:02:00', '2023-02-20 14:27:20'),
(46, 'App\\Models\\User', 13, 'auth_token', '03c904ea30413f54f899daa04e3572e3b9f2b1b5874ad7e2c4ebee0b9686fd0e', '[\"*\"]', '2023-02-20 12:52:34', NULL, '2023-02-20 12:52:32', '2023-02-20 12:52:34'),
(47, 'App\\Models\\User', 14, 'auth_token', '3bea8d1e4b1666065e250627b7ad6a7d5ca09a000c9d19d6406389eb8cfc66ef', '[\"*\"]', '2023-02-20 13:12:41', NULL, '2023-02-20 13:12:29', '2023-02-20 13:12:41'),
(48, 'App\\Models\\User', 12, 'auth_token', 'd3f7ea091a1ca6d49b08311289f4c0c4b32c2e5871d78b77191c2d5a39eb9d50', '[\"*\"]', '2023-02-21 00:43:14', NULL, '2023-02-20 13:12:38', '2023-02-21 00:43:14'),
(49, 'App\\Models\\User', 15, 'auth_token', '96bccb5c7c91950c234eba4fb3da2381c75d33a190a6010dfe12907f802409c3', '[\"*\"]', '2023-02-20 13:15:22', NULL, '2023-02-20 13:14:57', '2023-02-20 13:15:22'),
(50, 'App\\Models\\User', 15, 'auth_token', '4ed50f72a750b29acaf6e5409de30c1f23fba0314fbbaf068ab98979cc61e195', '[\"*\"]', '2023-02-20 13:16:48', NULL, '2023-02-20 13:15:41', '2023-02-20 13:16:48'),
(51, 'App\\Models\\User', 9, 'auth_token', '9a81b90daacb397d1764af7e09bc5493be830f29c1dd38eadfbb7c5a07d6d45f', '[\"*\"]', '2023-02-20 13:19:43', NULL, '2023-02-20 13:17:41', '2023-02-20 13:19:43'),
(52, 'App\\Models\\User', 9, 'auth_token', 'd07724a3727b2399b098b9227b5d9e1355654ccc89f607d64c8314f82c4df909', '[\"*\"]', '2023-02-20 13:31:33', NULL, '2023-02-20 13:25:11', '2023-02-20 13:31:33'),
(53, 'App\\Models\\User', 9, 'auth_token', '02c57e4efa6c225c4dc0066d86e90d6523692cc4713f3dafecdba664fb84dc88', '[\"*\"]', '2023-02-20 13:46:33', NULL, '2023-02-20 13:45:34', '2023-02-20 13:46:33'),
(54, 'App\\Models\\User', 9, 'auth_token', 'a06970f1af91d21c641f47be5eadd83b051d865477f83f8f840c2f69dc27aa73', '[\"*\"]', '2023-02-21 01:19:51', NULL, '2023-02-21 00:07:26', '2023-02-21 01:19:51'),
(55, 'App\\Models\\User', 9, 'auth_token', 'a71a3187719aa46bbcf9684e02886d65f92966dadb4b08c0477e85f411d8d96d', '[\"*\"]', '2023-02-21 00:16:25', NULL, '2023-02-21 00:14:02', '2023-02-21 00:16:25'),
(56, 'App\\Models\\User', 9, 'auth_token', 'bec9448f07840c35a72fc8d002d31b5aab713baeaaf3ec84d4c361cdad6ce664', '[\"*\"]', '2023-02-21 01:30:09', NULL, '2023-02-21 01:28:30', '2023-02-21 01:30:09'),
(57, 'App\\Models\\User', 9, 'auth_token', 'f1918702ddcf701e19751d6a7e2cc11708c0c350795cc6c0158c3ea522a3535b', '[\"*\"]', '2023-02-21 09:11:51', NULL, '2023-02-21 03:55:47', '2023-02-21 09:11:51'),
(58, 'App\\Models\\User', 9, 'auth_token', '3ef30cdbad222a226a5d204931e10f4cb9be7592fab788aac8ac715051a316d3', '[\"*\"]', '2023-02-21 11:12:27', NULL, '2023-02-21 11:03:42', '2023-02-21 11:12:27'),
(59, 'App\\Models\\User', 9, 'auth_token', 'f1d105bfb73083286d3841526924f191b0ab2d56a0fad06c73ee72d060b840c5', '[\"*\"]', '2023-02-21 11:25:01', NULL, '2023-02-21 11:17:30', '2023-02-21 11:25:01'),
(60, 'App\\Models\\User', 9, 'auth_token', '3fd05ab5e710d2ccf9d2aa092cc8e7bcf747007af4f9515f0b02a368bbf6db21', '[\"*\"]', '2023-02-21 11:38:47', NULL, '2023-02-21 11:37:09', '2023-02-21 11:38:47'),
(61, 'App\\Models\\User', 9, 'auth_token', '710ed24e19a7fc9c699c709af879b22d55f8c310f5fab89b8106425b0709a9d2', '[\"*\"]', '2023-02-21 12:00:32', NULL, '2023-02-21 11:53:37', '2023-02-21 12:00:32'),
(62, 'App\\Models\\User', 9, 'auth_token', '83a6b498deac05edb27d2c6c6c0e82d21f2f899832621b896baaed31be9a2cfa', '[\"*\"]', '2023-02-21 12:17:09', NULL, '2023-02-21 12:09:06', '2023-02-21 12:17:09'),
(63, 'App\\Models\\User', 9, 'auth_token', '29648e2b8f3d52cfbae1f6f75d19408a76714e55104135b655aaacfeedc99349', '[\"*\"]', '2023-02-22 00:18:55', NULL, '2023-02-21 12:31:37', '2023-02-22 00:18:55'),
(64, 'App\\Models\\User', 9, 'auth_token', '6843e4a170026dbc3ef912ee23ee4b87da460dc7bc8e2a1c17051bb5f0215ec5', '[\"*\"]', '2023-02-21 12:48:39', NULL, '2023-02-21 12:47:12', '2023-02-21 12:48:39'),
(65, 'App\\Models\\User', 9, 'auth_token', '4135f41a7e29702c452fbf8da4ccc4f19eec229b567835caae3f33c9e02ea35d', '[\"*\"]', '2023-02-22 00:23:06', NULL, '2023-02-22 00:23:02', '2023-02-22 00:23:06'),
(66, 'App\\Models\\User', 9, 'auth_token', '12c7751340e7e8053d70d809872d6791ba6cc8f0611392be5c3ce3937fca1a7c', '[\"*\"]', '2023-02-22 01:18:03', NULL, '2023-02-22 01:13:07', '2023-02-22 01:18:03'),
(67, 'App\\Models\\User', 9, 'auth_token', 'defb54425df3edebaedc2a4440f3833357cc30ad71eb121b77f6af9cdbfb00e4', '[\"*\"]', '2023-02-22 05:44:50', NULL, '2023-02-22 01:55:12', '2023-02-22 05:44:50'),
(68, 'App\\Models\\User', 17, 'auth_token', 'caa0ab5b7908e43651e75b4da546e4877c159765def3490aa1e2560ac899e1be', '[\"*\"]', '2023-02-22 06:07:54', NULL, '2023-02-22 05:49:30', '2023-02-22 06:07:54'),
(69, 'App\\Models\\User', 9, 'auth_token', '12b68f0b75015c84f4ac8eeac683787458390b551abe790117c21d3ca0df6cde', '[\"*\"]', '2023-02-23 04:26:16', NULL, '2023-02-22 06:08:41', '2023-02-23 04:26:16'),
(70, 'App\\Models\\User', 9, 'auth_token', '4e0eb404872962f1dc611046020a7e2924f598f4c2acf86042f8f46ac86fa50c', '[\"*\"]', '2023-02-23 07:23:37', NULL, '2023-02-23 07:06:08', '2023-02-23 07:23:37'),
(71, 'App\\Models\\User', 9, 'auth_token', '2c3ee11ce27bb33df4027e8a3df004a52501b4ad323334289d8f0937a59634ba', '[\"*\"]', '2023-02-23 13:37:13', NULL, '2023-02-23 07:28:08', '2023-02-23 13:37:13'),
(72, 'App\\Models\\User', 18, 'auth_token', '4588170eb92d4331245d03b026a1405cee937e49aa7a5a3115e3a3f9c26d7440', '[\"*\"]', '2023-02-23 13:33:10', NULL, '2023-02-23 13:23:37', '2023-02-23 13:33:10'),
(73, 'App\\Models\\User', 9, 'auth_token', '23ef7c3c2bbcc632b5cb0372316de1d6eaf3f675c2b1a2862fa6d4c86a5b2f48', '[\"*\"]', '2023-02-23 13:34:29', NULL, '2023-02-23 13:34:18', '2023-02-23 13:34:29'),
(74, 'App\\Models\\User', 18, 'auth_token', 'a37b0055533ffe9032f411f3668701a53e6b1ab0f7d49e5eded516b56fdcd5f3', '[\"*\"]', '2023-02-23 13:38:03', NULL, '2023-02-23 13:35:45', '2023-02-23 13:38:03'),
(75, 'App\\Models\\User', 18, 'auth_token', '9a2d387e4bab957329c471bf7ab37287f9d76abd2fc7c7029d8a7624b77cb293', '[\"*\"]', '2023-02-23 13:37:35', NULL, '2023-02-23 13:37:30', '2023-02-23 13:37:35'),
(76, 'App\\Models\\User', 18, 'auth_token', 'ee9efcc1d9c7c474dece2a249e0ec32541fc9b4207cd9bb42f558c5df2c8d34e', '[\"*\"]', '2023-02-23 13:55:37', NULL, '2023-02-23 13:43:25', '2023-02-23 13:55:37'),
(77, 'App\\Models\\User', 9, 'auth_token', 'e7427ff1f9e5cbb3a1459ea0527f11d8144ce3480e8e7664c120851c672598a3', '[\"*\"]', NULL, NULL, '2023-02-23 13:59:46', '2023-02-23 13:59:46'),
(78, 'App\\Models\\User', 9, 'auth_token', '21310a0b383acb4b5676f9648c7e0c9467a04c1aece3063b89a630507f977b11', '[\"*\"]', '2023-02-23 14:54:50', NULL, '2023-02-23 14:18:32', '2023-02-23 14:54:50'),
(79, 'App\\Models\\User', 9, 'auth_token', '713bcd1a608b44c4cade7e1dc7651b7d66a155aa365af02bcf3eff108d8d3890', '[\"*\"]', '2023-02-23 15:57:36', NULL, '2023-02-23 15:56:29', '2023-02-23 15:57:36'),
(80, 'App\\Models\\User', 9, 'auth_token', 'f2953477a077aa8e514f2e0374f577aa1e2b4a6d29c736ca8745fecb45215416', '[\"*\"]', '2023-02-23 16:23:01', NULL, '2023-02-23 16:22:56', '2023-02-23 16:23:01'),
(81, 'App\\Models\\User', 9, 'auth_token', 'df4bc65788db1a4994e2f6690a7034458e32b0caaac46527741d23a6bcaf702c', '[\"*\"]', '2023-02-24 00:09:37', NULL, '2023-02-23 16:23:26', '2023-02-24 00:09:37'),
(82, 'App\\Models\\User', 9, 'auth_token', '3c6827519fa7db22f95639e22e43a6ad058979542cc7b7224ada08842421927e', '[\"*\"]', '2023-02-24 05:12:29', NULL, '2023-02-24 00:10:24', '2023-02-24 05:12:29'),
(83, 'App\\Models\\User', 9, 'auth_token', 'a814a25df9b906890b88f13ae5de5d4e59a0ea94c1be097255b4be4b68985694', '[\"*\"]', '2023-02-28 01:21:37', NULL, '2023-02-24 14:09:56', '2023-02-28 01:21:37'),
(84, 'App\\Models\\User', 9, 'auth_token', 'bb618abfc8f45f0cfa045734eaf8354285d4324598f0cf19a9d177196410471c', '[\"*\"]', '2023-02-28 08:12:54', NULL, '2023-02-28 07:14:02', '2023-02-28 08:12:54'),
(85, 'App\\Models\\User', 9, 'auth_token', 'eff51a477d415b07468506790af7e69f9690ec48963820ff721dcfcc590e4f09', '[\"*\"]', '2023-03-13 07:55:35', NULL, '2023-03-01 04:46:03', '2023-03-13 07:55:35'),
(86, 'App\\Models\\User', 26, 'auth_token', 'c9d6b5981973dbdf315b1c19d5ae9f9f36ff8c76c0b2833868fd7e4e339a5eec', '[\"*\"]', '2023-03-13 06:46:07', NULL, '2023-03-13 06:39:44', '2023-03-13 06:46:07'),
(87, 'App\\Models\\User', 27, 'auth_token', '1138c746991112a768d21f73f4b4b35a80ac65fbd0ac7a37c9db9d7635735ad4', '[\"*\"]', '2023-03-13 06:53:39', NULL, '2023-03-13 06:48:29', '2023-03-13 06:53:39'),
(88, 'App\\Models\\User', 28, 'auth_token', 'd65454d970a49eff6a5ddbe22795090cd7f9364b852cc911ca384ec1caceb656', '[\"*\"]', '2023-03-13 07:08:44', NULL, '2023-03-13 07:05:09', '2023-03-13 07:08:44'),
(89, 'App\\Models\\User', 28, 'auth_token', 'f11f430e8aa1ceceb08b422f533d6afeb99e2d5517a1fd64146a7d219283e203', '[\"*\"]', '2023-03-13 07:38:14', NULL, '2023-03-13 07:09:04', '2023-03-13 07:38:14'),
(90, 'App\\Models\\User', 28, 'auth_token', '0d586929a36282bf6e4c2c992ee774ec8440b726c3c599450c1e01be844126d3', '[\"*\"]', '2023-03-13 08:00:00', NULL, '2023-03-13 07:56:54', '2023-03-13 08:00:00'),
(91, 'App\\Models\\User', 9, 'auth_token', '18206b9e115cd13357296a5db8dbac5e35818856a4ca5e991e850037d7293277', '[\"*\"]', '2023-03-13 08:00:36', NULL, '2023-03-13 08:00:34', '2023-03-13 08:00:36'),
(92, 'App\\Models\\User', 9, 'auth_token', '4e24e25275dc796abd8e1c5e82c19db9f6b8c99970fadbe0b59c3ee9adb4d665', '[\"*\"]', '2023-03-13 08:01:09', NULL, '2023-03-13 08:01:08', '2023-03-13 08:01:09'),
(93, 'App\\Models\\User', 9, 'auth_token', '911dc6a92cf634024e375e7b10db16c2469fad9292436d717cad619295c775fe', '[\"*\"]', '2023-03-16 03:39:34', NULL, '2023-03-14 01:24:23', '2023-03-16 03:39:34');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start_from` double(25,2) NOT NULL,
  `end_auction` datetime NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `thumb` text NOT NULL,
  `condition` text NOT NULL,
  `saleroom_notice` text NOT NULL,
  `catalogue_note` text NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0 : Closed, 1 : Opened',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `start_from`, `end_auction`, `created_by`, `category_id`, `thumb`, `condition`, `saleroom_notice`, `catalogue_note`, `status`, `created_at`, `updated_at`) VALUES
(1, 'American Silver Gumbo Pot, Cover, and Lampstand, Anthony Rasch, New Orleans, LA, Circa 1840-50', '<div>\r\n<div class=\"css-siraa5\">\r\n<p><strong>American Silver Gumbo Pot, Cover, and Lampstand, Anthony Rasch, New Orleans, LA, Circa 1840-50</strong></p>\r\n<p>&nbsp;</p>\r\n<p>applied with beaded borders, the handles with acanthus terminals, the lampstand raised on four paw feet headed by acanthus and with detachable burner, <em>lacking its cover and wood handle</em>,<em> marked three times on base of pot with A.RASCH in rectangle</em></p>\r\n<p>&nbsp;</p>\r\n<p>43 oz 5 dwt gross</p>\r\n<p>1350 g</p>\r\n<p>height 12 in.</p>\r\n<p>30.5 cm</p>\r\n</div>\r\n</div>', 5000000.00, '2023-03-31 12:00:00', 2, 1, '1676385103-sothebys-md.brightspotcdn.jpeg', '<p>Please note this piece has been restored since it was photographed: dents were removed from cover below finial, stand was reshaped so that pot sits flush now, wood handle has the missing end replaced, and one support for the lamp has been soldered back in place. The restoration was very nicely done. There are still some minor dings and creases throughout.&nbsp;</p>', '<p>Please note this piece has been restored since it was photographed: dents were removed from cover below finial, stand was reshaped so that pot sits flush now, wood handle has the missing end replaced, and one support for the lamp has been soldered back in place. The restoration was very nicely done. There are still some minor dings and creases throughout.</p>', '<p>Anthony Rasch (c. 1780-1858) was born in Bavaria and learned the trade of silver and goldsmithing there. He immigrated to Philadelphia sometime between 1801 and 1803, where he formed a partnership with Simon Chaudron under the name Chaudron and Rasch. He was also briefly in a partnership with George Willig, Jr. under the name Rasch and Willig. He permanently established himself in New Orleans by 1821, with a year long visit back to Europe to visit relatives from 1836-37. He remained working in New Orleans until his death in 1858.</p>', '0', '2023-02-14 14:31:43', '2023-03-15 04:46:20'),
(2, 'Chicago Worlds Fair of 1893: American Silver-Gilt, Enamel, and Jewel-Mounted Glass Jug, Gorham Mfg. Co., Providence, RI, the Enamels by George de Festetics, 1893', '<div>\r\n<div>\r\n<p><strong>Chicago Worlds Fair of 1893: American Silver-Gilt, Enamel, and Jewel-Mounted Glass Jug, Gorham Mfg. Co., Providence, RI, the Enamels by George de Festetics, 1893</strong></p>\r\n<p>&nbsp;</p>\r\n<p>of baluster form, the domed foot with strapwork, Bacchus heads, and enameled wings, the oval body glass overlaid with strapwork and gem-set, enclosing two large enamel plaques of \"Venus and the Sleeping Adonis\" and \"The Birth of Venus\" and a small enamel plaque with two mermaids, the neck and spout with strapwork and floral motifs against blue, red and white enameled grounds, the gem-set double scroll handle in the form of a bird with enameled body and wings,&nbsp;<em>marked on base, with sample number 4854, arrow mark, and Gorham date mark for 1893</em></p>\r\n<p>&nbsp;</p>\r\n<p>height 16 3/8 in.</p>\r\n<p>41 cm</p>\r\n</div>\r\n</div>', 20000000.00, '2023-03-16 07:46:58', 2, 1, '1676385248-sothebys-md.brightspotcdn.jpeg', '<p>Some enamel loss: to foot flanking mask, to lower neck, particularly turquoise blue, to left side of spout, and to green on high spots of handle and surmounting griffon. A little bit of crizzling to Adonis plaque. No crack visible, but does leak when filled with water. Other plaques and silver good. Impressive scale and luxurious feel.</p>', '<p>Sothebys, New York, January 20, 1998, lot 2191</p>', '<p>According to Samuel J. Hough, this jug was one of the centerpieces of Gorham\'s display at the 1893 Columbian Exposition in Chicago. Made specifically for the Fair, it was finished June 1, 1893. The piece required 125 hours of fabrication and 300 hours of chasing. The piece was then sent to New York for setting the stones and enameling. The enamel, both the decorative grounds and the Venus panels, was executed by the Hungarian artist, G. DeFestetics, who spent over 378 hours at a cost of $350.00. Many of Gorham\'s offerings in 1893 were designed by William C. Codman, such as the Nautilus centerpiece. Although Codman\'s name cannot be tied directly to this jug, its feel is similar to the designer\'s work at this period. This piece, with an engraved depiction, was highlighted in the Providence Sunday Journal, June 18, 1893, which was publishing highlights headed for the fair: ...one of the daintiest articles which has been recently completed and shipped to Chicago. This is an enamelled rose water jar which stands 16 inches high. The body of the jar is of clear white glass, with silver ornamentation about it, pierced so that the glass surface may show through. The paintings on the body of the vase, one on each side and one on the front, represent three allegorical subjects, executed by De Festetics, and surrounded by very fine ornamentation in oxidized silver and parcel-gilt. The coloring in the enamelled surfaces is harmoniously blended and very beautiful, lending much to the general artistic effect of the fine metal working. The neck of the jar or vase is handsomely enamelled and studded with jewels, amethysts, carbuncles and crystals. A griffin, with wings of translucent enamel and delicate ornamental work, forms the handle. Originality and beauty of design are combined with completeness and delicacy of execution to make this vase a gem of artistic work... the value of the rose water jar is $1,000. Gorham\'s enamel work was a success at the 1893 Exposition, and the company received seven awards for this technique alone. A pamphlet published by the firm in 1894 about its display records that \"it is scarcely a year since the Gorham Company commenced the production of translucent enamels, yet this work is of such a high order that one of the German Commissioners at the Fair has purchased a specimen of it...to be placed in the Royal Kunstgewerbe Museum of Berlin.\" Gorham\'s records reveal that the Company was prepared to take only $44.00 profit on this piece which had cost $800.00 to manufacture; for exhibition purposes, immediate financial gain was secondary to art and recognition.</p>', '0', '2023-02-14 14:34:08', '2023-03-16 00:48:46'),
(3, 'American Silver Tankard, Underhill & Vernon, New York, Circa 1790', '<div>\r\n<div class=\"css-siraa5\">\r\n<p><strong>American Silver Tankard, Underhill &amp; Vernon, New York, Circa 1790</strong></p>\r\n<p>&nbsp;</p>\r\n<p>of tapering cylindrical form, the double-scroll handle applied with a baluster, the stepped cover with openwork thumbpiece, the body engraved with later crest, initial <em>W</em>, and motto,<em> marked on base TU in rectangle and I.V in shaped oval</em></p>\r\n<p>&nbsp;</p>\r\n<p>30 oz</p>\r\n<p>933 g</p>\r\n<p>height 7 3/4 in.</p>\r\n<p>19.7 cm</p>\r\n</div>\r\n</div>', 4100000.00, '2023-03-27 13:05:00', 2, 1, '1676386442-sothebys-md.brightspotcdn.jpeg', '<div id=\"collapsable-container-Conditionreporte290ec87-2164-4c88-889c-6c2e025f1290\" class=\"css-8cpbw4\">\r\n<div class=\"css-kxhboe\">\r\n<div>\r\n<div class=\"css-siraa5\">\r\n<p>Some minor bruises and surface nicks throughout, otherwise good condition.</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"css-zxrtth\">&nbsp;</div>', '<div>\r\n<div class=\"css-siraa5\">\r\n<p>Property of a Long Island Private Collection, sold</p>\r\n<p>Doyle New York, April 5, 2017, lot 299</p>\r\n</div>\r\n</div>', '<p>The later monogram and crest is that of Willoughby.&nbsp;</p>', '0', '2023-02-14 14:54:02', '2023-03-14 12:23:46'),
(4, 'A Group of Three Chinese Export \'Mandarin Palette\' Tea Wares, Qing Dynasty, Qianlong Period, Circa 1785 | 清乾隆 約1785年 粉彩人物圖茶具三件', '<div>\r\n<div class=\"css-siraa5\">\r\n<p>A Group of Three Chinese Export \'Mandarin Palette\' Tea Wares</p>\r\n<p>Qing Dynasty, Qianlong Period, Circa 1785</p>\r\n<p>清乾隆 約1785年 粉彩人物圖茶具三件</p>\r\n<p>&nbsp;</p>\r\n<p>decorated in the classic palette and painted with shaped panels depicting Chinese figures in a garden engaged in various pursuits reserved on a pink-enameled cell diaper ground, comprising a teapot and cover, and a teabowl and saucer. <em>4 pieces</em>.</p>\r\n<p>length of teapot 8 3/4 in.; 22.4 cm</p>\r\n</div>\r\n</div>', 7000000.00, '2023-03-31 13:05:00', 2, 2, '1676386533-sothebys-md.brightspotcdn.jpeg', '<div>\r\n<div class=\"css-siraa5\">\r\n<p>The \"teabowl\" with a minute frit to the rim, otherwise in overall good condition. The saucer with two short hairlines to the rim and two minute flakes to the rim. The tip of the spout and handle restored on the teapot. The knop of the teapot cover off and restored back and the rim with minor restored frits and chips with associated overspray.</p>\r\n<br />\r\n<p><em>The lot is sold in the condition it is in at the time of sale. The condition report is provided to assist you with assessing the condition of the lot and is for guidance only. Any reference to condition in the condition report for the lot does not amount to a full description of condition. The images of the lot form part of the condition report for the lot. Certain images of the lot provided online may not accurately reflect the actual condition of the lot. In particular, the online images may represent colors and shades which are different to the lot\'s actual color and shades. The condition report for the lot may make reference to particular imperfections of the lot but you should note that the lot may have other faults not expressly referred to in the condition report for the lot or shown in the online images of the lot. The condition report may not refer to all faults, restoration, alteration or adaptation. The condition report is a statement of opinion only. For that reason, the condition report is not an alternative to taking your own professional advice regarding the condition of the lot. NOTWITHSTANDING THIS ONLINE CONDITION REPORT OR ANY DISCUSSIONS CONCERNING A LOT, ALL LOTS ARE OFFERED AND SOLD \"AS IS\" IN ACCORDANCE WITH THE CONDITIONS OF SALE/BUSINESS APPLICABLE TO THE RESPECTIVE SALE.</em></p>\r\n</div>\r\n</div>', '<p>-</p>', '<p>-</p>', '0', '2023-02-14 14:55:33', '2023-03-14 06:05:30'),
(5, 'Guan Lianchang (Tingqua), 1809-1870, A Rare View of the Interior of a Lacqueware Shop, Qing Dynasty, Daoguang Period, 1820-40 | 關聯昌 （庭呱）1809-1870年 清道光 1820-40年 廣東漆器店内貌 水彩紙本 鏡框', '<div>\r\n<div class=\"css-siraa5\">\r\n<p>Guan Lianchang (Tingqua), 1809-1870</p>\r\n<p>A Rare View of the Interior of a Lacqueware Shop</p>\r\n<p>Qing Dynasty, Daoguang Period, 1820-40</p>\r\n<p>關聯昌 （庭呱）1809-1870年</p>\r\n<p>清道光 1820-40年 廣東漆器店内貌 水彩紙本 鏡框</p>\r\n<p>&nbsp;</p>\r\n<p>gouache on paper, depicting a large circular gilt-decorated lacquer table to the left and further lacquer boxes, chests and trays on display shelves, one figure in the background supporting a circular lacquer box, with three further figures in the foreground, above and below the central scene with shaped panels painted with scholar\'s objects, framed and glazed</p>\r\n<p>overall 13 1/2 in. by 10 in.; 34 cm by 25.4 cm</p>\r\n<p>central interior scene 4 1/4 in. by 6 7/8 in.; 10.8 cm by 17.5 cm</p>\r\n</div>\r\n</div>', 10000000.00, '2023-03-29 13:05:00', 2, 2, '1676386949-sothebys-md.brightspotcdn.jpeg', '<div>\r\n<div class=\"css-siraa5\">\r\n<p>The work is in overall good condition, the applied media remains fresh. Scattered minute spots of foxing to the areas around the central image. Not examined out of frame.</p>\r\n<br />\r\n<p><em>The lot is sold in the condition it is in at the time of sale. The condition report is provided to assist you with assessing the condition of the lot and is for guidance only. Any reference to condition in the condition report for the lot does not amount to a full description of condition. The images of the lot form part of the condition report for the lot. Certain images of the lot provided online may not accurately reflect the actual condition of the lot. In particular, the online images may represent colors and shades which are different to the lot\'s actual color and shades. The condition report for the lot may make reference to particular imperfections of the lot but you should note that the lot may have other faults not expressly referred to in the condition report for the lot or shown in the online images of the lot. The condition report may not refer to all faults, restoration, alteration or adaptation. The condition report is a statement of opinion only. For that reason, the condition report is not an alternative to taking your own professional advice regarding the condition of the lot. NOTWITHSTANDING THIS ONLINE CONDITION REPORT OR ANY DISCUSSIONS CONCERNING A LOT, ALL LOTS ARE OFFERED AND SOLD \"AS IS\" IN ACCORDANCE WITH THE CONDITIONS OF SALE/BUSINESS APPLICABLE TO THE RESPECTIVE SALE.</em></p>\r\n</div>\r\n</div>', '<p>-</p>', '<div>\r\n<div class=\"css-siraa5\">\r\n<p>This interior view of a lacquer shop, probably on New or Old China Street, is a rare record of the lively Chinese export lacquer market in the early 19th century in Canton (Guangdong). According to Carl L. Crossman,&nbsp;<em>The Decorative Arts of The China Trade</em>, Suffolk, 1991, p. 263, Japanese lacquers were usually preferred over Chinese lacquer wares, and Cantonese lacquers were considered inferior to lacquers produced in other Chinese cities, such as Nanjing. However, as described in Crossman,&nbsp;<em>op. cit.,&nbsp;</em>Osmond Tiffany documented in 1849 that Cantonese lacquer decoration as painstaking and skillful. Chinese export lacquers were most often modeled after European designs, as evident in&nbsp;the gilt-lacquered tilt-top tea table shown on the left of the present example. A nearly identical example without the shaped panels above and below the central scene, formerly in the collection of Barbara and Arun Singh, and illustrated in Carl L. Crossman,&nbsp;<em>The China Trade: Export Paintings, Furniture, Silver and Other Objects,&nbsp;</em>Princeton, NJ, 1971, p. 168, pl. 138, sold in these rooms, January 25th, 2020, lot 1197.</p>\r\n<p>&nbsp;</p>\r\n<p>China trade paintings of shopfront scenes were most likely produced in series, such as two examples in the collection of the Victoria and Albert Museum, given by Mrs. Mary A. Goodman, and illustrated in Craig Clunas,&nbsp;<em>Chinese Export Watercolours</em>,<em>&nbsp;</em>London, 1984, p. 21, cat. nos. 3 and 4. One shop remains unidentified, as a large portion of the sheet was trimmed. The author speculates that the shop could either be a restaurant or an oil painting shop. The other painting depicts a tobacco shop, as evident by the large shop sign which reads&nbsp;<em>Yanlin</em>, or \'Tobacco Grove\'. The author points to the unique execution of details in the painting such as the brickwork and paving, use of western perspective, and prominent use of apple green as&nbsp;signs that a not yet identified workshop was responsible for these examples. Other examples of shopfront paintings from the HSBC collection were exhibited and illustrated in&nbsp;<em>Picturing Cathay: Maritime and Cultural Images of the China Trade,&nbsp;</em>University Museum and Art Gallery, The University of Hong Kong, Hong Kong, 2002, cat. nos. 80, 81 and 87,&nbsp;including a poulterer, fishmonger and bamboo basket shop respectively.&nbsp;Two further examples, one depicting the interior of a joss stick shop and the other depicting a costume shop, formerly in the collection of Ann and Gordon Getty, sold at Christie\'s New York, October 22nd, 2022, lots 304 and 305.</p>\r\n</div>\r\n</div>', '0', '2023-02-14 15:02:29', '2023-03-14 06:05:44'),
(6, 'John James Audubon | First octavo edition of Quadrupeds, in the original wrappers', '<div id=\"collapsable-container-Description3e273a3a-350b-423b-9b46-a67c2bde43bd\" class=\"css-8cpbw4\">\r\n<div class=\"css-kxhboe\">\r\n<div>\r\n<div class=\"css-siraa5\">\r\n<p>The Collection of Jay I. Kislak: Sold to Benefit the Kislak Family Foundation</p>\r\n<p>&nbsp;</p>\r\n<p>John James Audubon</p>\r\n<p>The Quadrupeds of North America. <em>New York: V.G. Audubon, 1849-1854</em></p>\r\n<p>&nbsp;</p>\r\n<p>31 original parts, 8vo (268 x 182 mm).&nbsp;155 hand-colored lithographed plates by W.E. Hitchcock and R. Trembly after J.J. and John Wodehouse Audubon; occasional foxmarks or&nbsp;minor stains, plate 9 (no. 2), 26-30 (no.6), 98-100 (no. 20) loose. Vol. 1 title and half-title bound at front of no. 1,&nbsp;vol. 2 title at end of no. 20 and vol. 3 title and half-title at end of no. 31; indexes in parts 10, 20 and 31; occasional&nbsp;pale offsetting from plates on to text, no. 2 with pin puncture in outer margin, nos. 15, 18, and 24 with pale stain in lower right margins throughout. Original printed wrappers;&nbsp;a few chips to fore-edges, a few stains, heaviest on no. 7, spines chipped and with losses, no. 19 with part number changed in ink manuscript; housed in a cloth folding case.</p>\r\n<p>&nbsp;</p>\r\n<p><u>First octavo edition, in the original wrappers, an original subscriber\'s copy</u>&nbsp;containing the 150 plates from the folio edition and five of the six plates from the 1854 supplement to that work.</p>\r\n<p>&nbsp;</p>\r\n<p>REFERENCE:</p>\r\n<p>Bennett 5; Nissen ZBI 163; Sabin 2638</p>\r\n<p>&nbsp;</p>\r\n<p>PROVENANCE:</p>\r\n<p>Valentine (original subscriber, partially printed note laid into no. 1, New York, 8 October 1853, paying V. G. Audubon \"For the \'Quadrupeds of North America\"; penciled name on front wrapper of no. 10, ink on no. 12) &mdash; Christie\'s New York, 3 December 2010, lot 283</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n<div class=\"css-zxrtth\">&nbsp;</div>', 15000000.00, '2023-03-15 21:53:08', 2, 2, '1676387030-sothebys-md.brightspotcdn.jpeg', '<p>For further information on the condition of this lot please contact<a href=\"mailto:americana@sothebys.com\"> americana@sothebys.com </a></p>', '<p>-</p>', '<p>-</p>', '0', '2023-02-14 15:03:50', '2023-03-15 14:54:10'),
(10, 'Tanah 200m2', '<p>Luas Tanah: 1,000 M2<br />DI JUAL TANAH 1.000 m2</p>\r\n<p>Leuwiliang - Bogor Barat</p>\r\n<p>Hanya 390 Jutaan</p>\r\n<p>NEGO DITEMPAT</p>\r\n<p>Kenapa Anda harus memiliki Tanah disini?</p>\r\n<p>- Di kelilingi 2 Perumahan</p>\r\n<p>- Akses angkutan umum</p>\r\n<p>- Dekat SD s/d SMA/K</p>\r\n<p>- Jalan Provinsi 1 km</p>\r\n<p>- RSUD Leuwiliang 2,5 km</p>\r\n<p>- Pasar Leuwiliang 2,6 km</p>\r\n<p>- PHD</p>\r\n<p>Bisa langsung AJB</p>\r\n<p>Yukkk manfaatkan sekarang juga, selagi masih ada.</p>\r\n<p>Kontak Kami<br />Rusdi Bahalwan Consultan<br />Saudagar Property Syariah<br />08562875742</p>', 390000000.00, '2023-03-29 12:00:00', 9, 2, '1678701044-jual-tanah-bogor-kondisi-spesial-AZL2YI.jpg', '<p>-</p>', '<p>-</p>', '<p>-</p>', '1', '2023-03-13 09:50:45', '2023-03-13 09:50:45'),
(11, 'Mobil klasik dan antik klasik dan antik (<1986)', '<p>Barang Simpanan<br />Low Km<br />Pajak 2023<br />Warna Hijau<br />280 matic</p>', 70000000.00, '2023-03-29 12:00:00', 9, 4, '1678701398-image;s=780x0;q=60.webp', '<p>bagus</p>', '<p>-</p>', '<p>-</p>', '1', '2023-03-13 09:56:38', '2023-03-13 09:56:38'),
(12, 'ASUS ROG Strix G G513QY R9X8G6T-O11 Ryzen 9 5900HX 16G 1TB RX6800M W11', '<p><span class=\"css-11oczh8 eytdjj00\"><span class=\"css-168ydy0 eytdjj01\">WAJIB membaca CATATAN TOKO<br />( Penukaran Barang - Salah Kirim barang ) sebelum membeli.<br />WAJIB Video Unboxing Paket saat diterima sampai selesai buka.<br />TIDAK menerima komplain tanpa Video Unboxing Paket.<br />Membeli berarti menyetujui ketentuan Toko.<br />Terima kasih<br />--------------------<br />TAMBAHAN PACKING KAYU<br /><a href=\"https://www.tokopedia.com/blessingcombali/packing-kayu-dengan-berat-barang-5-10-kg\" target=\"_blank\" rel=\"noopener noreferrer\">https://www.tokopedia.com/blessingcombali/packing-kayu-dengan-berat-barang-5-10-kg</a><br />--------------------<br />ASUS ROG Strix - G Advantage Edition G513QY-R9X8G6T-O11 [ Original Black ]<br />--------------------<br />Included in the Box<br />- Marketing Giveaway (2 Customizable Armor Caps)<br />- ROG&nbsp;backpack&nbsp;for&nbsp;15_17<br />- FHD&nbsp;1080P@60FPS&nbsp;external&nbsp;camera<br />- ROG Impact Gaming Mouse<br /><br />Processor : AMD&nbsp;Ryzen&trade;&nbsp;9&nbsp;5900HX&nbsp;Processor&nbsp;3.3&nbsp;GHz&nbsp;(16M&nbsp;Cache,&nbsp;up&nbsp;to&nbsp;4.6&nbsp;GHz)<br />Operating System : Windows 11 Home + Office Home and Student 2021 included<br />Memory : 16GB (8GB DDR4-3200 SO-DIMM *2)<br />Storage : 1TB M.2 NVMe&trade; PCIe&reg; 3.0 SSD<br />Graphic : AMD&reg;&nbsp;Radeon&trade;&nbsp;RX&nbsp;6800M, 12GB GDDR6, AMD RDNA&trade; 2 (2300Mhz Game Clock<br />Display : 15.6-inch - WQHD (2560 x 1440) 16:9 - 165Hz - 3ms - Viewing Angle 170 - IPS-level - 300nits - DCI-P3 100%<br /><br />KSP<br />1. AMD Radeon RX 6800M Graphics <br />2. Pro level precision : 87% screen to body ratio<br />3. Power anywhere : 90Wh battery<br />4. Inteligent cooling : Liquid metal, 4 fans outlets, 6 heats pipes, cooling zone, anti dust<br /><br />Memory Slots : 2x SO-DIMM slots ( Max capacity installed 32GB )<br />Storage : Extra one slot<br /><br />Keyboard<br />&bull; Backlit Chiclet Keyboard 4-Zone RGB<br /><br />I/O ports<br />1x RJ45 LAN port<br />1x USB 3.2 Gen 2 Type-C support DisplayPort&trade; / power delivery / G-SYNC<br />3x USB 3.2 Gen 1 Type-A<br />1x&nbsp;3.5mm&nbsp;Combo&nbsp;Audio&nbsp;Jack<br /><br />Wireless<br />&bull; Wi-Fi 6(802.11ax)+Bluetooth 5.1 (Dual band) 2*2<br />(*BT version may change with OS upgrades.) -RangeBoost<br /><br />Audio<br />Teknologi Smart Amp<br />AI mic noise-canceling<br />Built-in array microphone<br />2x 4W speaker with Smart Amp Technology<br /><br />AC Adapter<br />&oslash;6.0; 240W AC Adaptor<br />Output: 20V DC, 12A, 240W<br />Input: 100~240C AC 50/60Hz universal<br /><br />Battery : 90WHrs, 4S1P, 4-cell Li-ion<br /></span></span></p>', 15000000.00, '2023-03-22 12:00:00', 9, 5, '1678701546-fO7HtXghpT.jpg', '<p>-</p>', '<p>-</p>', '<p>-</p>', '1', '2023-03-13 09:59:07', '2023-03-13 09:59:07');

--
-- Triggers `products`
--
DELIMITER $$
CREATE TRIGGER `logging_product_create` AFTER INSERT ON `products` FOR EACH ROW INSERT INTO log VALUES('','INSERT','product',NOW())
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `logging_product_delete` AFTER DELETE ON `products` FOR EACH ROW INSERT INTO log VALUES('','DELETE','product',NOW())
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `logging_product_update` AFTER UPDATE ON `products` FOR EACH ROW INSERT INTO log VALUES('','UPDATE','product',NOW())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zipcode` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('1','2','3') DEFAULT NULL COMMENT '1 = users, 2 = pengelola, 3 = admin',
  `thumb` varchar(255) DEFAULT NULL,
  `blacklist` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `state`, `zipcode`, `country`, `email_verified_at`, `password`, `role`, `thumb`, `blacklist`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Riley Ruiz', 'admin@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$TOrL.apuylJKbv4S481g8eXHfMWkBn/PB3H.tLB3i4CQPY6pMwMde', '3', 'https://ui-avatars.com/api/?name=Riley Ruiz&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-02-02 14:13:10', '2023-02-02 14:13:10'),
(2, 'Quincy Rosarios', 'quicy@gmail.com', '0895331493506', 'Kp Pondok Bitung RT 01 RW 02', 'Mars', '127111', 'Indonesia', NULL, '$2y$10$B/8kXm3e7Moe.4xVOvQBKuoSJlNgC4RCQyzPNbFuemgLhZGOjhm82', '3', 'https://ui-avatars.com/api/?name=Chase Carson&color=7F9CF5&background=EBF4FF', 0, 'FI0GVkkYyS50hFXNOia5GMeDtYvCQQHYuLSyfvyQy4COK4DHfpxTo2NfvDqw', '2023-02-03 13:13:03', '2023-02-27 03:47:28'),
(3, 'Chase Carson', 'qytylo@mailinator.com', '5555', NULL, NULL, NULL, NULL, NULL, '$2y$10$eGdARv8kXQM32vpkpOrq1.S8dnIMXy8XU7QcCn9vovpcgbPYhFiMe', '3', 'https://ui-avatars.com/api/?name=Chase Carson&color=7F9CF5&background=EBF4FF', 0, 'CnSZZJfznBCeEyySuZLXPTrUKmLlfvI6hXUoMbxMVvuwOlZpezUJ3e0Y1JMq', '2023-02-05 08:09:26', '2023-02-10 06:10:40'),
(4, 'Alfreda Lloyd', 'alfreda1012@gmail.com', '0895331493506', 'Pondok bitungs', 'pondok', '32', 'Indonesia', NULL, '$2y$10$FJ1KXJSJljCG7.zM97HBa.H7pbY1yCH5BwYJrGaRnv2cZPkq/jIq.', '3', '1676808860-IMG-20230219-WA0008.jpg', 0, 'itWBMWzZRAHBKfdKkXMM1uHPePUXOmBzZcpIzI7jdSKowZwzAfFzw0nhWtnq', '2023-02-06 02:10:09', '2023-02-23 05:56:42'),
(5, 'Sopoline Odonnell', 'nicavik@mailinator.com', '0895331493506', 'asdsdfgfvc', 'STATE', '171', 'Indonesia', NULL, '$2y$10$tAPshPu6M28SO4G/OG/4C.IwaeWy6x5ZCW85iQWjix8.uWMLONg96', '1', 'https://ui-avatars.com/api/?name=Alfreda Lloyd&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-02-13 12:20:11', '2023-02-19 23:39:00'),
(6, 'Raihan Musyaffa', 'muhraihanme@gmail.com', '82124396365', 'Bendungan ppmkp III', 'CIAWI', '17620', NULL, NULL, '$2y$10$J6pT/ZCBXcVAEZmJq4HNfO.ohaedq8/XfIMeY3fFPXSBMvUZ/pA8S', '2', 'https://ui-avatars.com/api/?name=Alfreda Lloyd&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-02-14 01:38:12', '2023-02-14 02:06:43'),
(8, 'Ridwan Surya', 'test@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$.SjzZw7LP81PkDccG89kQ.usbA6211CQrcsQODfUKtuEkIlxHiz6q', '1', 'https://ui-avatars.com/api/?name=Ridwan Surya&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-02-17 05:57:19', '2023-02-17 05:57:19'),
(9, 'Reksa Prayoga Syahputra', 'reksa.prayoga1012@gmail.com', '0895331493506', 'Kp pondok bitung', 'rindu', '17135', 'Indonesia', '2023-03-10 07:18:24', '$2y$10$xDPFB/kj/D/DrHvSwnQ.2eYtZ8lyekrCh9dpgOaRatafpABhBl0a.', '3', '1677033489-IMG-20230220-WA0022.jpg', 0, 'I1Tq0PaqAJukQQVGdfsNvbeKgEI9q0MGRJECJMJw1OkscuJttN0jR5VF1T4d', '2023-02-20 05:59:09', '2023-03-16 06:28:04'),
(10, 'Heavn', 'mazatlum.mv@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$udJXUJfUFWC6ED545VZoWuR03GXMT/sMSAsu4tVkHuoojcLNifR/q', '3', '1676872882-deku.PNG', 0, NULL, '2023-02-20 05:59:23', '2023-03-01 05:10:07'),
(11, 'Salwa alia', 'salwa@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$FeEMRpAvj5DeC.pzN1uF9eL/eWDfnfsAM1ceXJmiEg0DZmvVVTasO', '1', 'https://ui-avatars.com/api/?name=Salwa alia&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-02-20 10:39:27', '2023-02-20 10:39:27'),
(12, 'Salwa Alia Nurrizka', 'nurrizkasalwaalia@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$vylHI8.Mr8NtdNCvI7AlqOetmG0qfOjHls/YISuYal8lOY3Fecja.', '1', 'https://ui-avatars.com/api/?name=Salwa Alia Nurrizka&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-02-20 10:39:55', '2023-02-20 10:39:55'),
(15, 'John dalton', 'johndal@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$mw6OcmGftSeUOYPrfAZ1T.GbS2WI.v8gEHnVoYXgAWwZtlDmN9wGS', '1', 'https://ui-avatars.com/api/?name=John dalton&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-02-20 13:14:57', '2023-02-20 13:14:57'),
(16, 'akbar siddiq', 'rizkyakbar.rpl22020@smkn4bogor.sch.id', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$Isc2mDvAxCq22A88HJ/qMeT0SXeaTQdsBSjY64/ff3vDh2L9MPlxW', '1', 'https://ui-avatars.com/api/?name=akbar siddiq&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-02-21 00:27:57', '2023-02-21 00:27:57'),
(17, 'Adrian Restart', 'wawangantra@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$l3soVnyCsUaX0BAtgezEgOU.Be4RiHEFI0NX7YZvuJe2oy1x3v6Km', '1', 'https://ui-avatars.com/api/?name=Adrian Restart&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-02-22 05:49:30', '2023-03-03 00:10:14'),
(18, 'hamster kaget', 'radjaauliaalramdani@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$cpD2d/.EUmsrWDN6jftDB.Mg6rk2WtY3jFpTSWUjJ9lVDTZMyxj1u', '1', 'https://ui-avatars.com/api/?name=hamster kaget&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-02-23 13:23:37', '2023-02-23 13:23:37'),
(19, 'Sage Mommy', 'sage@valorant.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$Extdan4ZxstI12Yjwyul8O3CUi68.pAjpyrpMrbGOFt.Ly5yQ0do6', '1', 'https://ui-avatars.com/api/?name=Sage Mommy&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-02-24 00:41:55', '2023-03-03 00:10:09'),
(20, 'Ridwan Surya', 'muhammadridwansurya@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$Wi135LJApoWqSoBBkTGlrO81Y5k6q597mi2OQAx2r/skC/.zOIvSq', '1', 'https://ui-avatars.com/api/?name=Ridwan Surya&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-02-27 01:17:38', '2023-03-03 00:10:17'),
(21, 'Petugas A', 'petugas@gmail.com', '0895331493506', 'sdad', '0895331493506', '211', 'Mexico', '2023-03-16 00:31:53', '$2y$10$xDPFB/kj/D/DrHvSwnQ.2eYtZ8lyekrCh9dpgOaRatafpABhBl0a.', '2', 'https://ui-avatars.com/api/?name=Petugas+A&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-02-28 22:58:14', '2023-02-28 22:58:58'),
(22, 'MAMAT ROHMAN', 'mamat@gmail.com', '895331493506', 'Kp Pondok Indah', 'Jakarta', '2116', 'Indonesia', '2023-03-16 00:32:45', '$2y$10$xDPFB/kj/D/DrHvSwnQ.2eYtZ8lyekrCh9dpgOaRatafpABhBl0a.', '1', 'https://ui-avatars.com/api/?name=MAMAT ROHMAN&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-03-01 16:53:13', '2023-03-16 00:33:31'),
(23, 'Asmajati Ananto', 'asmajati.cooler15@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$l2fZGvg2DfK3AP2pin.UceXd7w.dAL/b/9iOKxe57AuLaXoZbHisO', '1', 'https://ui-avatars.com/api/?name=Asmajati Ananto&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-03-02 00:48:31', '2023-03-02 00:48:31'),
(24, 'Yuyus rusli', 'rusliyuyus@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$xDPFB/kj/D/DrHvSwnQ.2eYtZ8lyekrCh9dpgOaRatafpABhBl0a.', '1', 'https://ui-avatars.com/api/?name=Yuyus rusli&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-03-03 03:36:09', '2023-03-03 03:44:03'),
(25, 'reksaaa sahputra', 'reksa@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$aZT9bx1WtbD26zzNkzVBZOXqB4E2wS.XwKoKwR8ZD86QQQI.N6X6y', '1', 'https://ui-avatars.com/api/?name=reksaaa sahputra&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-03-03 09:00:12', '2023-03-03 09:13:03'),
(26, 'Wildan multajjam', 'wildun@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$FdG9ddRK4s9M8qblpxk5qOgmnU6BPxpZdrRzbZNvk7FkQlrCL5U3i', '1', 'https://ui-avatars.com/api/?name=Wildan multajjam&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-03-13 06:39:44', '2023-03-13 06:39:44'),
(27, 'ariel audia', 'arielaudhiaputra1225@gmail.com', '0895331493506', 'kp pondok ibdah', 'jakarta', '1890', 'indonesia', NULL, '$2y$10$vBrNVjDa8HB9gGDdat7nX.CPigZeiMXYzKJhZ28O7ysUrEeeNL9Rm', '1', '1678690186-IMG-20230313-WA0039.jpg', 0, NULL, '2023-03-13 06:48:29', '2023-03-13 06:49:46'),
(28, 'halo halo', 'halo@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$h9rQZabgtfoxZkaEZRzKUeaGhGY.fUNO.aF2y50y1zZCpF354aX4G', '1', 'https://ui-avatars.com/api/?name=halo halo&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-03-13 07:05:09', '2023-03-13 07:05:09'),
(29, 'Muhammad Syahid', 'namakusyahiddd@gmail.com', NULL, NULL, NULL, NULL, NULL, '2023-03-14 05:54:28', '$2y$10$zAhKuxSkfIwr2ujcK6.DCOeAXeHhbbK4QECxiBR07Nj3NSmaNpy76', '1', 'https://ui-avatars.com/api/?name=Muhammad Syahid&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-03-14 05:45:18', '2023-03-14 05:54:28'),
(30, 'BANG SSAHID', 'bangsyaih@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$oaWu8OAaeT.YhXqNzWVg1u1H53VESlAhN5cVHFZbbvpR321X9zyJu', '1', 'https://ui-avatars.com/api/?name=BANG SSAHID&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-03-14 05:52:07', '2023-03-14 05:52:07'),
(31, 'Muhammad Syahid Muharram', 'sahid@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$okenxh53gRky87E2jadVjesSzHpn7JUDH30rTSAOBCX33nxmU2s8C', '1', 'https://ui-avatars.com/api/?name=Muhammad Syahid Muharram&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-03-14 05:57:04', '2023-03-14 05:57:04'),
(32, 'BANG SSAHIDdd', 'sahid2@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$hEPtU9yFTxAVfHqvQ8fh9.jbG6pH1HhXQUQxJvlSVg72P4O7lJopu', '1', 'https://ui-avatars.com/api/?name=BANG SSAHIDdd&color=7F9CF5&background=EBF4FF', 0, NULL, '2023-03-14 06:36:50', '2023-03-14 06:36:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auctions`
--
ALTER TABLE `auctions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auctions_product_id_foreign` (`product_id`),
  ADD KEY `auctions_user_id_foreign` (`user_id`);

--
-- Indexes for table `auction_histories`
--
ALTER TABLE `auction_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `help_centers`
--
ALTER TABLE `help_centers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `help_centers_user_id_foreign` (`user_id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_created_by_foreign` (`created_by`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `auctions`
--
ALTER TABLE `auctions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `auction_histories`
--
ALTER TABLE `auction_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `help_centers`
--
ALTER TABLE `help_centers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=373;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auctions`
--
ALTER TABLE `auctions`
  ADD CONSTRAINT `auctions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auctions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `help_centers`
--
ALTER TABLE `help_centers`
  ADD CONSTRAINT `help_centers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
