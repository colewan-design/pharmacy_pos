-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2021 at 12:03 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `point_of_sale`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountexpenses`
--

CREATE TABLE `accountexpenses` (
  `accountExpenseId` bigint(20) UNSIGNED NOT NULL,
  `accountCode` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `accountDescription` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accountexpenses`
--

INSERT INTO `accountexpenses` (`accountExpenseId`, `accountCode`, `accountDescription`, `created_at`, `updated_at`) VALUES
(1, '5000', 'Food Supplies - Expenses', '2021-03-11 09:44:20', '2021-03-11 09:47:34'),
(2, '5540', 'Kitchen Utensils', '2021-03-11 09:47:57', '2021-03-11 09:47:57'),
(3, '5550', 'Heat, Light & Water', '2021-03-11 09:48:33', '2021-03-11 09:48:33'),
(4, '5560', 'Office Supplies', '2021-03-11 09:48:50', '2021-03-11 09:48:50'),
(5, '5570', 'Transaportation Expense', '2021-03-11 09:49:05', '2021-03-11 09:49:05'),
(6, '5585', 'Coomunication Expense', '2021-03-11 09:49:22', '2021-03-11 09:49:22'),
(7, '5590', 'Representation Expense', '2021-03-11 09:49:38', '2021-03-11 09:49:38'),
(8, '5615', 'Housekeeping Expense', '2021-03-11 09:49:52', '2021-03-11 09:49:52'),
(9, '5555', 'Repairs & Maintenance', '2021-03-11 09:50:08', '2021-03-11 09:50:08'),
(10, '5625', 'Newspaper/Magazine', '2021-03-11 09:50:28', '2021-03-11 09:50:28'),
(11, '5500', 'Salaries & Wages', '2021-03-11 09:50:42', '2021-03-11 09:50:42'),
(12, '5625', 'Miscellaneous Expense', '2021-03-11 09:51:19', '2021-03-11 09:51:19'),
(13, '', 'Meal Allowance', '2021-03-11 09:51:50', '2021-03-11 09:55:36'),
(14, '', 'Others', '2021-03-11 09:51:59', '2021-03-11 09:55:32');

-- --------------------------------------------------------

--
-- Table structure for table `beginingfunds`
--

CREATE TABLE `beginingfunds` (
  `beginingfundId` bigint(20) UNSIGNED NOT NULL,
  `beginingfundUserId` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `beginingAmount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `beginingfunds`
--

INSERT INTO `beginingfunds` (`beginingfundId`, `beginingfundUserId`, `beginingAmount`, `created_at`, `updated_at`) VALUES
(3, '1', 2000, '2021-03-16 18:08:39', '2021-03-16 18:08:39'),
(4, '4', 2000, '2021-03-16 18:17:22', '2021-03-16 18:17:22'),
(5, '4', 2000, '2021-03-17 17:06:25', '2021-03-17 17:06:25'),
(6, '6', 0, '2021-03-17 17:32:56', '2021-03-17 17:32:56'),
(7, '1', 1000, '2021-03-18 05:46:56', '2021-03-18 05:46:56'),
(8, '15', 2000, '2021-03-18 06:39:05', '2021-03-18 06:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `cashins`
--

CREATE TABLE `cashins` (
  `cashInId` bigint(20) UNSIGNED NOT NULL,
  `giveBy` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cashins`
--

INSERT INTO `cashins` (`cashInId`, `giveBy`, `amount`, `note`, `created_at`, `updated_at`) VALUES
(1, 'andrea labiang', 1000, 'adv. payment on catering service on april 3, 2021', '2021-03-16 19:07:56', '2021-03-16 19:07:56'),
(2, 'm. andrea', 1000, 'adv. payment on catering service on april 3,2021', '2021-03-17 00:27:19', '2021-03-17 00:27:19');

-- --------------------------------------------------------

--
-- Table structure for table `cashouts`
--

CREATE TABLE `cashouts` (
  `cashOutId` bigint(20) UNSIGNED NOT NULL,
  `receiveBy` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryId` bigint(20) UNSIGNED NOT NULL,
  `departmentId` int(11) NOT NULL COMMENT 'department id',
  `categoryName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoryDescription` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoryStyle` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'success' COMMENT 'Button Color Hex',
  `categoryUse` char(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y' COMMENT 'Y/N',
  `categoryIsDeleted` char(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Y/N',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryId`, `departmentId`, `categoryName`, `categoryDescription`, `categoryStyle`, `categoryUse`, `categoryIsDeleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'All-Day Breakfast Specials', 'All-Day Breakfast Specials', '#00FF00', 'Y', 'N', '2021-02-01 06:28:11', '2021-03-11 09:55:14'),
(2, 1, 'Soup Sublime', 'Soup Sublime', '#00FF00', 'Y', 'N', '2021-02-01 06:28:25', '2021-02-02 11:13:54'),
(3, 1, 'Wholesome\'wiches', 'Wholesome\'wiches', '#F4A460', 'Y', 'N', '2021-02-01 06:28:51', '2021-02-02 11:13:59'),
(4, 1, 'Salad Bliss', 'Salad Bliss', '#808080', 'Y', 'N', '2021-02-01 06:29:05', '2021-02-02 11:14:05'),
(5, 1, 'Pasta Delights', 'Pasta Delights', '#00FF00', 'Y', 'N', '2021-02-01 06:29:27', '2021-02-01 06:29:27'),
(6, 1, 'Chicken Favorites', 'Chicken Favorites', '#FFA500', 'Y', 'N', '2021-02-01 06:29:48', '2021-03-03 13:38:51'),
(7, 1, 'Fish Specials', 'Fish Specials', '#00FF00', 'Y', 'N', '2021-02-01 06:30:06', '2021-02-01 06:30:06'),
(8, 1, 'Meaty Diversion', 'Meaty Diversion', '#00FF00', 'Y', 'N', '2021-02-01 06:30:33', '2021-02-01 06:55:28'),
(9, 1, 'Vegetarian Pleasure', 'Vegetarian Pleasure', '#00FF00', 'Y', 'N', '2021-02-01 06:30:53', '2021-02-01 06:30:53'),
(10, 1, 'Side dish', 'Side dish', '#00FF00', 'Y', 'N', '2021-02-01 06:31:03', '2021-02-01 06:31:03'),
(11, 2, 'Cold Beverages', 'Cold Beverages', '#00FF00', 'Y', 'N', '2021-02-01 06:31:23', '2021-02-01 06:31:23'),
(12, 2, 'House Iced tea', 'House Iced tea', '#00FF00', 'Y', 'N', '2021-02-01 06:31:39', '2021-02-01 06:31:39'),
(13, 2, 'Freshly Squeezed Juices', 'Freshly Squeezed Juices', '#00FF00', 'Y', 'N', '2021-02-01 06:31:54', '2021-02-01 06:31:54'),
(14, 2, 'Hot beverages', 'Hot beverages', '#00FF00', 'Y', 'N', '2021-02-01 06:32:08', '2021-02-01 06:32:08'),
(15, 2, 'Hot Tea', 'Hot Tea', '#00FF00', 'Y', 'N', '2021-02-01 06:32:37', '2021-02-01 06:32:37'),
(16, 4, 'Outsourced', 'Outsourced', '#F0E68C', 'Y', 'N', '2021-02-01 06:33:22', '2021-02-09 01:29:48'),
(18, 2, 'Breads', 'Breads', '#DA70D6', 'Y', 'N', '2021-03-01 02:37:02', '2021-03-01 03:07:34'),
(19, 2, 'Cakes Whole Cake', 'Cakes Whole Cake', '#808080', 'Y', 'N', '2021-03-01 02:37:34', '2021-03-01 03:07:25'),
(20, 2, 'Cakes Slices', 'Cakes Slices', '#00BFFF', 'Y', 'N', '2021-03-01 02:37:54', '2021-03-01 03:07:21'),
(21, 2, 'Bars', 'Bars', '#F4A460', 'Y', 'N', '2021-03-01 02:38:10', '2021-03-01 03:07:17'),
(22, 2, 'Cookies', 'Cookies', '#00FF00', 'Y', 'N', '2021-03-01 02:38:21', '2021-03-01 03:07:11'),
(23, 2, 'Pastries', 'Pastries', '#FFA500', 'Y', 'N', '2021-03-01 02:38:34', '2021-03-01 03:07:05'),
(24, 1, 'Additional Dressing', 'Additional Dressing', '#00FFFF', 'Y', 'N', '2021-03-16 18:56:59', '2021-03-16 18:56:59'),
(25, 4, 'Vegetable', 'Vegetable', '#00BFFF', 'Y', 'N', '2021-03-16 23:11:45', '2021-03-16 23:11:45'),
(26, 4, 'Others', 'Others', '#00FFFF', 'Y', 'N', '2021-03-16 23:27:15', '2021-03-16 23:27:15');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `departmentId` bigint(20) UNSIGNED NOT NULL,
  `departmentName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departmentDescription` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `departmentUse` char(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y' COMMENT 'Y/N',
  `departmentIsDeleted` char(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Y/N',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`departmentId`, `departmentName`, `departmentDescription`, `departmentUse`, `departmentIsDeleted`, `created_at`, `updated_at`) VALUES
(1, 'Kitchen', 'Kitchen', 'Y', 'N', '2021-03-15 18:22:05', NULL),
(2, 'Bar', 'Bar', 'Y', 'N', '2021-03-15 18:22:05', NULL),
(3, 'Cashier', 'Cashier', 'Y', 'N', '2021-03-15 18:22:05', NULL),
(4, 'Outsourced', 'Outsourced', 'Y', 'N', '2021-03-15 18:22:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `deviceId` bigint(20) UNSIGNED NOT NULL,
  `departmentId` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'department where this device is used!',
  `deviceName` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deviceDescription` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deviceUse` char(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y' COMMENT 'Y/N',
  `deviceIsDeleted` char(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Y/N',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`deviceId`, `departmentId`, `deviceName`, `deviceDescription`, `deviceUse`, `deviceIsDeleted`, `created_at`, `updated_at`) VALUES
(1, '1', 'smb://DOORSCOMPUTERS/EPSON TM-T82 Receipt', 'smb://DOORSCOMPUTERS/EPSON TM-T82 Receipt', 'Y', 'N', '2021-03-01 03:08:56', '2021-03-16 00:40:33'),
(2, '2', 'smb://DOORSCOMPUTERS/EPSON TM-T82 Receipt', 'smb://DOORSCOMPUTERS/EPSON TM-T82 Receipt', 'Y', 'N', '2021-03-01 03:18:44', '2021-03-16 18:07:24'),
(3, '3', 'smb://DESKTOP-Q1M4MR6/EPSON TM-T82X', 'smb://DESKTOP-Q1M4MR6/EPSON TM-T82X', 'Y', 'N', '2021-03-02 13:52:32', '2021-03-02 15:43:11'),
(4, '4', 'smb://DOORSCOMPUTERS/EPSON TM-T82 Receipt', 'smb://DOORSCOMPUTERS/EPSON TM-T82 Receipt', 'Y', 'N', '2021-03-02 13:53:38', '2021-03-16 18:20:58');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expenseId` bigint(20) UNSIGNED NOT NULL,
  `accountExpenseId` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `accountDescription` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `expenseAmount` double NOT NULL,
  `expenseDate` date NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userId` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `inventoryId` bigint(20) UNSIGNED NOT NULL,
  `itemId` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateEncoded` date NOT NULL,
  `batchCode` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `originalQty` int(11) NOT NULL,
  `currentQty` int(11) NOT NULL,
  `expiryDate` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`inventoryId`, `itemId`, `dateEncoded`, `batchCode`, `originalQty`, `currentQty`, `expiryDate`, `created_at`, `updated_at`) VALUES
(3, '1', '2021-03-18', 'BCBH1', 10, 0, '2021-03-31', '2021-03-18 02:49:09', '2021-03-18 02:49:09'),
(4, '272', '2021-03-18', 'M.4', 100, 0, '2021-09-25', '2021-03-18 06:29:42', '2021-03-18 06:29:42'),
(5, '273', '2021-03-18', 'ER5', 100, 0, '2021-03-31', '2021-03-18 07:49:59', '2021-03-18 07:49:59'),
(6, '274', '2021-03-18', 'SE6', 99, 0, '2021-03-31', '2021-03-18 08:05:08', '2021-03-18 08:05:08'),
(7, '275', '2021-03-18', 'SE7', 99, 0, '2021-03-31', '2021-03-18 08:05:22', '2021-03-18 08:05:22'),
(8, '276', '2021-03-18', 'BE8', 99, 0, '2021-03-31', '2021-03-18 08:05:36', '2021-03-18 08:05:36'),
(9, '59', '2021-03-18', 'L9', 99, 0, '2021-03-31', '2021-03-18 10:28:17', '2021-03-18 10:28:17'),
(10, '277', '2021-03-18', 'PP10', 99, 0, '2021-03-31', '2021-03-18 10:34:07', '2021-03-18 10:34:07');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemId` bigint(20) UNSIGNED NOT NULL,
  `categoryId` int(11) NOT NULL COMMENT 'Categorty ID',
  `itemName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `itemDescription` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `itemQty` int(11) NOT NULL,
  `itemPrice` double NOT NULL,
  `itemUse` char(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y' COMMENT 'Y/N',
  `itemIsDeleted` char(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Y/N',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemId`, `categoryId`, `itemName`, `itemDescription`, `itemQty`, `itemPrice`, `itemUse`, `itemIsDeleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bekkag\'s Corned Beef Hash', 'Bekkag\'s Corned Beef Hash', 101, 175, 'Y', 'N', '2021-02-01 06:35:08', '2021-03-18 02:49:09'),
(2, 1, 'Gatao\'s Egg Surprices', 'Gatao\'s Egg Surprices', 98, 195, 'Y', 'N', '2021-02-01 06:35:52', '2021-03-17 00:05:02'),
(3, 1, 'Ommay\'s Chicken & Waffle', 'Ommay\'s Chicken & Waffle', 99, 175, 'Y', 'N', '2021-02-01 06:36:31', '2021-03-16 18:50:06'),
(4, 1, 'Chef\'s Huevos Rancheros', 'Chef\'s Huevos Rancheros', 99, 185, 'Y', 'N', '2021-02-01 06:36:56', '2021-03-16 18:53:51'),
(5, 2, 'Bloody Mary', 'Bloody Mary', 99, 95, 'Y', 'N', '2021-02-01 06:37:20', '2021-03-16 18:53:51'),
(6, 2, 'House Chicken Soup', 'House Chicken Soup', 99, 95, 'Y', 'N', '2021-02-01 06:37:36', '2021-03-16 22:33:26'),
(7, 3, 'Fish in a Bun', 'Fish in a Bun', 98, 195, 'Y', 'N', '2021-02-01 06:37:55', '2021-03-18 08:04:01'),
(8, 3, 'Chicken & Apple Burrito', 'Chicken & Apple Burrito', 97, 185, 'Y', 'N', '2021-02-01 06:38:13', '2021-03-17 00:18:04'),
(9, 3, 'Eco French Toasts', 'Eco French Toasts', 100, 175, 'Y', 'N', '2021-02-01 06:38:35', '2021-02-01 06:38:35'),
(10, 3, 'Chili Dog Sandwich', 'Chili Dog Sandwich', 100, 195, 'Y', 'N', '2021-02-01 06:39:15', '2021-02-01 06:39:15'),
(11, 3, 'Steak in a Bun', 'Steak in a Bun', 97, 205, 'Y', 'N', '2021-02-01 06:39:28', '2021-03-18 08:04:01'),
(12, 4, 'House Salad', 'House Salad', 93, 100, 'Y', 'N', '2021-02-01 06:39:58', '2021-03-17 00:29:11'),
(13, 4, 'Chef\'s Bounty Salad(SOLO)', 'Chef\'s Bounty Salad(SOLO)', 100, 100, 'Y', 'N', '2021-02-01 06:41:00', '2021-02-01 06:41:00'),
(14, 4, 'Herb Salad(SOLO)', 'Herb Salad(SOLO)', 100, 100, 'Y', 'N', '2021-02-01 06:41:17', '2021-02-01 06:41:17'),
(15, 4, 'Green Goddess Pasta Salad(SOLO)', 'Green Goddess Pasta Salad(SOLO)', 96, 100, 'Y', 'N', '2021-02-01 06:41:37', '2021-03-18 10:48:33'),
(16, 4, 'Chicken Apple Salad(SHARING)', 'Chicken Apple Salad(SHARING)', 97, 195, 'Y', 'N', '2021-02-01 06:42:18', '2021-03-18 10:35:14'),
(17, 4, 'House Salad(SHARING)', 'House Salad(SHARING)', 98, 195, 'Y', 'N', '2021-02-01 06:42:29', '2021-03-18 08:04:00'),
(18, 4, 'Chef\'s Bountry(SHARING)', 'Chef\'s Bountry(SHARING)', 100, 195, 'Y', 'N', '2021-02-01 06:42:48', '2021-02-01 06:42:48'),
(19, 4, 'Herb Salad(SHARING)', 'Herb Salad(SHARING)', 100, 195, 'Y', 'N', '2021-02-01 06:42:57', '2021-02-01 06:42:57'),
(20, 4, 'Green Goddess Pasta Salad(SHARING)', 'Green Goddess Pasta Salad(SHARING)', 100, 195, 'Y', 'N', '2021-02-01 06:43:15', '2021-02-01 06:43:15'),
(21, 5, 'Chicken Lasagna Roll-ups', 'Chicken Lasagna Roll-ups', 96, 195, 'Y', 'N', '2021-02-01 06:43:46', '2021-03-18 10:35:14'),
(22, 5, 'Vegetarian Pasta Roll-ups', 'Vegetarian Pasta Roll-ups', 100, 175, 'Y', 'N', '2021-02-01 06:44:08', '2021-02-01 06:44:08'),
(23, 5, 'Pasta Ratatouille', 'Pasta Ratatouille', 100, 195, 'Y', 'N', '2021-02-01 06:48:53', '2021-02-01 06:48:53'),
(24, 5, 'Kung Pao Chicken Pasta', 'Kung Pao Chicken Pasta', 98, 185, 'Y', 'N', '2021-02-01 06:49:21', '2021-03-18 02:46:34'),
(25, 5, 'Panne al Telefono', 'Panne al Telefono', 100, 175, 'Y', 'N', '2021-02-01 06:49:41', '2021-02-01 06:49:41'),
(26, 6, 'Chicken Tenders', 'Chicken Tenders', 97, 185, 'Y', 'N', '2021-02-01 06:50:14', '2021-03-18 10:48:33'),
(27, 6, 'Chef\'s Pockets', 'Chef\'s Pockets', 88, 195, 'Y', 'N', '2021-02-01 06:50:32', '2021-03-18 10:26:15'),
(28, 6, 'Grilled Chicken With Pesto', 'Grilled Chicken With Pesto', 92, 185, 'Y', 'N', '2021-02-01 06:50:51', '2021-03-18 06:24:01'),
(29, 6, 'Honey-Glazed Chicken', 'Honey-Glazed Chicken', 94, 195, 'Y', 'N', '2021-02-01 06:51:05', '2021-03-18 06:24:01'),
(30, 7, 'Fish Fingers', 'Fish Fingers', 100, 185, 'Y', 'N', '2021-02-01 06:51:25', '2021-02-01 06:51:25'),
(31, 7, 'Fishermans Bounty', 'Fishermans Bounty', 87, 195, 'Y', 'N', '2021-02-01 06:51:43', '2021-03-18 08:04:00'),
(32, 7, 'Farmer\'s Fish', 'Farmer\'s Fish', 95, 200, 'Y', 'N', '2021-02-01 06:52:00', '2021-03-18 08:04:00'),
(33, 7, 'Chef\'s Glazed Salmon', 'Chef\'s Glazed Salmon', 95, 295, 'Y', 'N', '2021-02-01 06:52:20', '2021-03-18 08:04:01'),
(34, 8, 'Lodge Beef Tenders', 'Lodge Beef Tenders', 95, 205, 'Y', 'N', '2021-02-01 06:56:03', '2021-03-18 08:04:01'),
(35, 8, 'Cowboy\'s Chilli-Bean Stew', 'Cowboy\'s Chilli-Bean Stew', 100, 200, 'Y', 'N', '2021-02-01 06:56:41', '2021-02-01 06:56:41'),
(36, 8, 'Shepherd\'s Pie', 'Shepherd\'s Pie', 100, 195, 'Y', 'N', '2021-02-01 06:56:56', '2021-02-01 06:56:56'),
(37, 8, 'Chef\'s Steak', 'Chef\'s Steak', 100, 350, 'Y', 'N', '2021-02-01 06:57:12', '2021-02-01 06:57:12'),
(38, 9, 'Eggplant Parmigiana', 'Eggplant Parmigiana', 97, 175, 'Y', 'N', '2021-02-01 06:57:31', '2021-03-16 23:32:06'),
(39, 9, 'Elmer\'s Mystic Two', 'Elmer\'s Mystic Two', 100, 175, 'Y', 'N', '2021-02-01 06:57:47', '2021-02-01 06:57:47'),
(40, 10, 'Camote Fries(SOLO)', 'Camote Fries(SOLO)', 93, 35, 'Y', 'N', '2021-02-01 06:58:22', '2021-03-16 23:59:29'),
(41, 10, 'Camote Fries(SHARING)', 'Camote Fries(SHARING)', 95, 65, 'Y', 'N', '2021-02-01 06:58:33', '2021-03-18 10:44:47'),
(42, 11, 'Fresh Fruit Shake Depends on its Season/Availability(SOLO)', 'Fresh Fruit Shake Depends on its Season/Availability(SOLO)', 99, 85, 'Y', 'N', '2021-02-01 07:00:43', '2021-03-16 22:12:36'),
(43, 11, '2-Fruit Combination', '2-Fruit Combination', 100, 95, 'Y', 'N', '2021-02-01 07:01:24', '2021-02-01 07:01:24'),
(44, 11, '3 to 4 Fruit Combination', '3 to 4 Fruit Combination', 99, 100, 'Y', 'N', '2021-02-01 07:01:48', '2021-03-18 10:43:19'),
(45, 11, 'Iced Coffee', 'Iced Coffee', 100, 0, 'Y', 'N', '2021-02-01 07:02:07', '2021-02-01 07:02:07'),
(46, 12, 'Lemon Grass Iced Tea', 'Lemon Grass Iced Tea', 99, 75, 'Y', 'N', '2021-02-01 07:02:30', '2021-03-18 10:26:15'),
(47, 12, 'Berries Iced Tea', 'Berries Iced Tea', 100, 75, 'Y', 'N', '2021-02-01 07:02:45', '2021-02-01 07:02:45'),
(48, 12, 'Mixed Fruit Iced Tea', 'Mixed Fruit Iced Tea', 100, 75, 'Y', 'N', '2021-02-01 07:02:59', '2021-02-01 07:02:59'),
(49, 13, 'Carrot Pure(CP)', 'Carrot Pure(CP)', 93, 75, 'Y', 'N', '2021-02-01 07:03:24', '2021-03-18 07:29:02'),
(50, 13, 'Apple Pure(AP)', 'Apple Pure(AP)', 100, 95, 'Y', 'N', '2021-02-01 07:03:43', '2021-02-24 01:55:26'),
(51, 13, 'Cucumber Pure(CucP)', 'Cucumber Pure(CucP)', 100, 75, 'Y', 'N', '2021-02-01 07:04:19', '2021-02-24 01:55:31'),
(52, 13, 'CAC(Carrot, Apple & Cucumber)', 'CAC(Carrot, Apple & Cucumber)', 89, 95, 'Y', 'N', '2021-02-01 07:05:03', '2021-03-18 10:51:22'),
(53, 13, 'CEL(Carrot, Apple, Cucumbe & Celery)', 'CEL(Carrot, Apple, Cucumbe & Celery)', 99, 95, 'Y', 'N', '2021-02-01 07:05:52', '2021-03-17 00:05:01'),
(54, 13, 'GIN(Carrot, Apple, Beets & Ginger)', 'GIN(Carrot, Apple, Beets & Ginger)', 95, 95, 'Y', 'N', '2021-02-01 07:06:34', '2021-03-16 23:54:42'),
(55, 13, 'CAB(Carrot, Apple & Beets )', 'CAB(Carrot, Apple & Beets )', 100, 95, 'Y', 'N', '2021-02-01 07:07:08', '2021-02-24 01:55:49'),
(56, 14, 'Brewed Coffee', 'Brewed Coffee', 38, 50, 'Y', 'N', '2021-02-01 07:07:27', '2021-03-18 10:50:08'),
(57, 14, 'Soya Bean Coffee', 'Soya Bean Coffee', 95, 50, 'Y', 'N', '2021-02-01 07:07:43', '2021-03-18 10:24:03'),
(58, 14, 'Hot Choco', 'Hot Choco', 96, 65, 'Y', 'N', '2021-02-01 07:07:59', '2021-03-16 23:46:49'),
(59, 14, 'Latte', 'Latte', 198, 95, 'Y', 'N', '2021-02-01 07:08:10', '2021-03-18 10:35:14'),
(60, 14, 'Cappuccino', 'Cappuccino', 96, 95, 'Y', 'N', '2021-02-01 07:08:19', '2021-03-18 02:14:21'),
(61, 14, 'Americano', 'Americano', 100, 0, 'Y', 'N', '2021-02-01 07:08:30', '2021-02-01 07:08:30'),
(62, 14, 'Caramel Macchiato', 'Caramel Macchiato', 100, 0, 'Y', 'N', '2021-02-01 07:08:44', '2021-02-01 07:08:44'),
(63, 15, 'Single (Banaba)', 'Single (Banaba)', 100, 55, 'Y', 'N', '2021-02-01 07:09:43', '2021-02-24 01:55:55'),
(64, 15, 'Single (Gipah)', 'Single (Gipah)', 100, 55, 'Y', 'N', '2021-02-01 07:09:54', '2021-02-24 01:56:00'),
(65, 15, 'Single (ashitaba)', 'Single (ashitaba)', 100, 55, 'Y', 'N', '2021-02-01 07:10:06', '2021-02-24 01:56:05'),
(66, 15, 'Single (lemon grass)', 'Single (lemon grass)', 97, 55, 'Y', 'N', '2021-02-01 07:10:16', '2021-03-18 10:44:47'),
(67, 15, 'Single (dandelion)', 'Single (dandelion)', 100, 55, 'Y', 'N', '2021-02-01 07:10:27', '2021-02-24 01:56:13'),
(68, 15, 'Single(gayubana & ginger turmeric)', 'Single(gayubana & ginger turmeric)', 100, 55, 'Y', 'N', '2021-02-01 07:10:46', '2021-02-24 01:56:18'),
(69, 15, 'Tea Pot (Banaba)', 'Tea Pot (Banaba)', 100, 75, 'Y', 'N', '2021-02-01 07:11:14', '2021-02-24 01:56:23'),
(70, 15, 'Tea Pot (Gipah)', 'Tea Pot (Gipah)', 100, 75, 'Y', 'N', '2021-02-01 07:11:42', '2021-02-24 01:56:28'),
(71, 15, 'Tea Pot (ashitaba)', 'Tea Pot (ashitaba)', 100, 75, 'Y', 'N', '2021-02-01 07:11:59', '2021-02-24 01:56:33'),
(72, 15, 'Tea Pot (lemon grass)', 'Tea Pot (lemon grass)', 95, 75, 'Y', 'N', '2021-02-01 07:12:09', '2021-03-18 10:51:22'),
(73, 15, 'Tea Pot (dandelion)', 'Tea Pot (dandelion)', 100, 75, 'Y', 'N', '2021-02-01 07:12:22', '2021-02-24 01:56:42'),
(74, 15, 'Tea Pot(gayubana & ginger turmeric)', 'Tea Pot(gayubana & ginger turmeric)', 100, 75, 'Y', 'N', '2021-02-01 07:12:37', '2021-02-24 01:56:47'),
(75, 15, 'Single CRS  (Cranberry-Raspberry-Strawberry)', 'Single CRS  (Cranberry-Raspberry-Strawberry)', 100, 55, 'Y', 'N', '2021-02-01 07:15:22', '2021-02-24 01:56:52'),
(76, 15, 'Single (Peach)', 'Single Peach', 100, 55, 'Y', 'N', '2021-02-01 07:15:40', '2021-02-01 07:15:40'),
(77, 15, 'Single (Cinnamon)', 'Single (Cinnamon)', 100, 55, 'Y', 'N', '2021-02-01 07:17:09', '2021-02-01 07:17:09'),
(78, 15, 'Single (Earl grey)', 'Single (Earl grey)', 100, 55, 'Y', 'N', '2021-02-01 07:17:28', '2021-02-01 07:17:28'),
(79, 15, 'Single (Cammomile)', 'Single (Cammomile)', 100, 55, 'Y', 'N', '2021-02-01 07:17:40', '2021-02-01 07:17:40'),
(80, 15, 'Single (Mixed Fruit Tea and Jasmne Green and Black Tea)', 'Single (Mixed Fruit Tea and Jasmne Green and Black Tea)', 98, 55, 'Y', 'N', '2021-02-01 07:18:14', '2021-03-18 09:23:51'),
(81, 15, 'Tea pot CRS (Cranberry-Raspberry-Strawberry)', 'Tea pot CRS (Cranberry-Raspberry-Strawberry)', 99, 75, 'Y', 'N', '2021-02-01 07:18:55', '2021-03-18 08:04:01'),
(82, 15, 'Tea pot (Peach)', 'Tea pot (Peach)', 100, 75, 'Y', 'N', '2021-02-01 07:19:23', '2021-02-24 01:57:04'),
(83, 15, 'Tea pot (Cinnamon)', 'Tea pot (Cinnamon)', 100, 75, 'Y', 'N', '2021-02-01 07:19:43', '2021-02-24 01:57:09'),
(84, 15, 'Tea pot (Earl grey)', 'Tea pot (Earl grey)', 100, 75, 'Y', 'N', '2021-02-01 07:20:56', '2021-02-24 01:57:13'),
(85, 15, 'Tea pot (Cammomile)', 'Tea pot (Cammomile)', 100, 75, 'Y', 'N', '2021-02-01 07:21:16', '2021-02-24 01:57:18'),
(86, 15, 'TP(Mixed Fruit Tea & Jasmne Green and Black Tea)', 'Tea pot (Mixed Fruit Tea & Jasmne Green and Black Tea)', 100, 75, 'Y', 'N', '2021-02-01 07:21:37', '2021-02-21 08:38:29'),
(87, 16, 'Tauli Brown Rice(25kg)', 'Tauli Brown Rice(25kg)', 99, 1400, 'Y', 'N', '2021-02-01 07:22:29', '2021-03-16 18:50:06'),
(88, 16, 'Tauli White Rice(25kg)', 'Tauli White Rice(25kg)', 99, 1350, 'Y', 'N', '2021-02-01 07:23:30', '2021-03-16 18:50:06'),
(89, 16, 'Brown Rice(1kg)', 'Brown Rice(1kg)', 99, 75, 'Y', 'N', '2021-02-01 07:24:01', '2021-03-16 18:50:06'),
(90, 16, 'Brown Rice(2kg)', 'Brown Rice(2kg)', 100, 140, 'Y', 'N', '2021-02-01 07:24:17', '2021-02-01 07:24:17'),
(91, 16, 'Maleng Ag Eco Coffee', 'Maleng Ag Eco Coffee', 100, 295, 'Y', 'N', '2021-02-01 07:25:01', '2021-02-01 07:25:01'),
(92, 16, 'Turmeric Powder 100g', 'Turmeric Powder 100g', 99, 110, 'Y', 'N', '2021-02-01 07:25:21', '2021-03-16 18:50:06'),
(93, 16, 'Turmeric Powder 200g', 'Turmeric Powder 200g', 100, 220, 'Y', 'N', '2021-02-01 07:25:35', '2021-02-01 07:25:35'),
(94, 16, 'Turmeric Powder 350g Bottle', 'Turmeric Powder 350g Bottle', 99, 350, 'Y', 'N', '2021-02-01 07:26:04', '2021-03-18 10:24:03'),
(95, 16, 'Turmeric Powder 400g', 'Turmeric Powder 400g', 100, 380, 'Y', 'N', '2021-02-01 07:26:21', '2021-02-01 07:26:21'),
(96, 16, 'Honey 4x4', 'Honey 4x4', 99, 500, 'Y', 'N', '2021-02-01 07:26:38', '2021-03-18 10:24:03'),
(97, 16, 'Honey 2x2', 'Honey 2x2', 100, 250, 'Y', 'N', '2021-02-01 07:26:49', '2021-02-01 07:26:49'),
(98, 16, 'Muscovado', 'Muscovado', 99, 160, 'Y', 'N', '2021-02-01 07:27:04', '2021-03-17 00:24:04'),
(99, 16, 'KB Lemon Grass', 'KB Lemon Grass', 100, 165, 'Y', 'N', '2021-02-01 07:27:19', '2021-02-01 07:27:19'),
(100, 16, 'KB Banaba', 'KB Banaba', 100, 165, 'Y', 'N', '2021-02-01 07:27:38', '2021-02-01 07:27:38'),
(101, 16, 'KB Dandelion', 'KB Dandelion', 100, 165, 'Y', 'N', '2021-02-01 07:27:51', '2021-02-01 07:27:51'),
(102, 16, 'KB Goto kola', 'KB Goto kola', 100, 165, 'Y', 'N', '2021-02-01 07:28:03', '2021-02-01 07:28:03'),
(103, 16, 'KB Ashitaba', 'KB Ashitaba', 100, 165, 'Y', 'N', '2021-02-01 07:28:12', '2021-02-01 07:28:12'),
(104, 16, 'KB Gipas', 'KB Gipas', 100, 165, 'Y', 'N', '2021-02-01 07:28:20', '2021-02-01 07:28:20'),
(105, 16, 'KB Ginger Turmeric', 'KB Ginger Turmeric', 100, 165, 'Y', 'N', '2021-02-01 07:28:41', '2021-02-01 07:28:41'),
(106, 16, 'KB Ginger Guyabano', 'KB Ginger Guyabano', 100, 165, 'Y', 'N', '2021-02-01 07:28:50', '2021-02-01 07:28:50'),
(107, 16, 'KB Honeymansi', 'KB Honeymansi', 100, 210, 'Y', 'N', '2021-02-01 07:29:04', '2021-02-01 07:29:04'),
(108, 16, 'GE Apple Tea', 'GE Apple Tea', 100, 230, 'Y', 'N', '2021-02-01 07:29:19', '2021-02-01 07:29:19'),
(109, 16, 'GE Cinnamon Tea', 'GE Cinnamon Tea', 100, 230, 'Y', 'N', '2021-02-01 07:29:32', '2021-02-01 07:29:32'),
(110, 16, 'GE Cammomile', 'GE Cammomile', 97, 230, 'Y', 'N', '2021-02-01 07:29:45', '2021-03-18 10:41:30'),
(111, 16, 'GE Peach', 'GE Peach', 100, 230, 'Y', 'N', '2021-02-01 07:29:59', '2021-02-01 07:29:59'),
(112, 16, 'GE Earl Gray', 'GE Earl Gray', 100, 230, 'Y', 'N', '2021-02-01 07:30:07', '2021-02-01 07:30:08'),
(113, 16, 'GE CRS(Berries)', 'GE CRS(Berries)', 99, 250, 'Y', 'N', '2021-02-01 07:30:28', '2021-03-18 10:24:03'),
(114, 16, 'GE Mixed Fruit Tea', 'GE Mixed Fruit Tea', 99, 250, 'Y', 'N', '2021-02-01 07:30:54', '2021-03-18 10:24:03'),
(115, 16, 'GE Strawberry', 'GE Strawberry', 100, 230, 'Y', 'N', '2021-02-01 07:31:13', '2021-02-01 07:31:13'),
(116, 16, 'GE Jasmin Green Tea', 'GE Jasmin Green Tea', 100, 230, 'Y', 'N', '2021-02-01 07:31:36', '2021-02-01 07:31:36'),
(117, 16, 'GE Jasmin Black Tea', 'GE Jasmin Black Tea', 100, 230, 'Y', 'N', '2021-02-01 07:31:47', '2021-02-01 07:31:47'),
(118, 16, 'Bird Club Lang-ay Wine', 'Bird Club Lang-ay Wine', 100, 350, 'Y', 'N', '2021-02-01 07:32:06', '2021-02-01 07:32:06'),
(119, 16, 'Bird Club Peanut Butter', 'Bird Club Peanut Butter', 100, 220, 'Y', 'N', '2021-02-01 07:32:22', '2021-02-01 07:32:22'),
(120, 16, 'Lifeline Soya Coffee 250g', 'Lifeline Soya Coffee 250g', 100, 135, 'Y', 'N', '2021-02-01 07:32:42', '2021-02-01 07:32:42'),
(121, 16, 'Lifeline Corn Coffee 250g', 'Lifeline Corn Coffee 250g', 100, 125, 'Y', 'N', '2021-02-01 07:34:11', '2021-02-01 07:34:11'),
(122, 16, 'Lifeline Mushroom Powder 200g', 'Lifeline Mushroom Powder 200g', 99, 190, 'Y', 'N', '2021-02-01 07:34:30', '2021-03-18 10:24:03'),
(123, 16, 'Lifeline Charcoal Capsule', 'Lifeline Charcoal Capsule', 99, 375, 'Y', 'N', '2021-02-01 07:34:58', '2021-03-18 10:43:19'),
(124, 16, 'Lifeline Charcoal Powder', 'Lifeline Charcoal Powder', 100, 190, 'Y', 'N', '2021-02-01 07:35:08', '2021-02-01 07:35:08'),
(125, 16, 'Lifeline Turmeric Powder Bottle', 'Lifeline Turmeric Powder Bottle', 100, 150, 'Y', 'N', '2021-02-01 07:35:31', '2021-02-01 07:35:31'),
(126, 16, 'Lifeline Ginger Powder/Tea', 'Lifeline Ginger Powder/Tea', 100, 140, 'Y', 'N', '2021-02-01 07:35:52', '2021-02-01 07:35:52'),
(127, 16, 'Lifeline Onion Sauce', 'Lifeline Onion Sauce', 100, 120, 'Y', 'N', '2021-02-01 07:36:09', '2021-02-01 07:36:09'),
(128, 16, 'Lifeline Chili Sauce', 'Lifeline Chili Sauce', 100, 120, 'Y', 'N', '2021-02-01 07:36:25', '2021-02-01 07:36:25'),
(129, 16, 'Lifeline Crysanthemum Tea', 'Lifeline Crysanthemum Tea', 100, 150, 'Y', 'N', '2021-02-01 07:36:46', '2021-02-01 07:36:46'),
(130, 16, 'Lifeline Molasses', 'Lifeline Molasses', 100, 120, 'Y', 'N', '2021-02-01 07:37:03', '2021-02-01 07:37:03'),
(131, 16, 'Bojos Atchara', 'Bojos Atchara', 100, 120, 'Y', 'N', '2021-02-01 07:37:21', '2021-02-01 07:37:21'),
(132, 16, 'Marmalade', 'Marmalade', 100, 190, 'Y', 'N', '2021-02-01 07:37:34', '2021-02-01 07:37:34'),
(133, 16, 'Malunngay Capsule', 'Malunngay Capsule', 100, 365, 'Y', 'N', '2021-02-01 07:38:04', '2021-02-01 07:38:04'),
(134, 16, 'Serpentina Capsule', 'Serpentina Capsule', 100, 350, 'Y', 'N', '2021-02-01 07:38:22', '2021-02-01 07:38:22'),
(135, 16, 'Ginger Turmeric Big Bottled', 'Ginger Turmeric Big Bottled', 100, 280, 'Y', 'N', '2021-02-01 07:38:41', '2021-02-01 07:38:41'),
(136, 16, 'Ginger Turmeric Small Bottled', 'Ginger Turmeric Small Bottled', 100, 230, 'Y', 'N', '2021-02-01 07:39:00', '2021-02-01 07:39:00'),
(137, 16, 'Lemon Curd Small', 'Lemon Curd Small', 100, 90, 'Y', 'N', '2021-02-01 07:39:16', '2021-02-01 07:39:16'),
(138, 16, 'Lemon Curd Big', 'Lemon Curd Big', 100, 180, 'Y', 'N', '2021-02-01 07:39:39', '2021-02-01 07:39:39'),
(139, 16, 'PUC Gluten Steak', 'PUC Gluten Steak', 100, 130, 'Y', 'N', '2021-02-01 07:39:55', '2021-02-01 07:39:55'),
(140, 16, 'PUC Gluten Tocino', 'PUC Gluten Tocino', 100, 130, 'Y', 'N', '2021-02-01 07:40:32', '2021-02-01 07:40:32'),
(141, 16, 'PUC Tapa', 'PUC Tapa', 100, 130, 'Y', 'N', '2021-02-01 07:41:14', '2021-02-01 07:41:14'),
(142, 16, 'PUC Lona', 'PUC Lona', 100, 110, 'Y', 'N', '2021-02-01 07:41:40', '2021-02-01 07:41:40'),
(143, 16, 'PUC Vg Meat', 'PUC Vg Meat', 100, 110, 'Y', 'N', '2021-02-01 07:41:55', '2021-02-01 07:41:55'),
(144, 18, 'Plain Pandesal', 'Plain Pandesal', 100, 15, 'Y', 'N', '2021-03-01 02:39:37', '2021-03-01 02:39:37'),
(145, 18, 'Yacun Pandesal', 'Yacun Pandesal', 80, 20, 'Y', 'N', '2021-03-01 02:40:21', '2021-03-18 10:39:58'),
(146, 18, 'Raisin Pandesal', 'Raisin Pandesal', 87, 20, 'Y', 'N', '2021-03-01 02:41:05', '2021-03-18 06:22:20'),
(147, 18, 'Fiber Loaf', 'Fiber Loaf', 99, 90, 'Y', 'N', '2021-03-01 02:41:38', '2021-03-18 10:41:30'),
(148, 18, 'Wheat Oats', 'Wheat Oats', 98, 75, 'Y', 'N', '2021-03-01 02:42:36', '2021-03-18 02:31:17'),
(149, 18, 'Monggo Bread', 'Monggo Bread', 100, 100, 'Y', 'N', '2021-03-01 02:42:51', '2021-03-01 02:42:51'),
(150, 18, 'Cheese Loaf', 'Cheese Loaf', 100, 100, 'Y', 'N', '2021-03-01 02:43:16', '2021-03-01 02:43:16'),
(151, 18, 'Cinnamon', 'Cinnamon', 96, 100, 'Y', 'N', '2021-03-01 02:43:32', '2021-03-18 10:43:19'),
(152, 18, 'Banana Bread', 'Banana Bread', 99, 125, 'Y', 'N', '2021-03-01 02:43:54', '2021-03-18 10:43:19'),
(153, 18, 'Banana Wheat Bread', 'Banana Wheat Bread', 100, 130, 'Y', 'N', '2021-03-01 02:44:06', '2021-03-01 02:44:06'),
(154, 18, 'Cheese Pandesal', 'Cheese Pandesal', 99, 65, 'Y', 'N', '2021-03-01 02:44:21', '2021-03-18 03:00:54'),
(155, 18, 'Ube Pandesal', 'Ube Pandesal', 99, 65, 'Y', 'N', '2021-03-01 02:44:38', '2021-03-17 00:14:55'),
(156, 19, 'Blue Berry Cheese Cake', 'Blue Berry Cheese Cake', 100, 1300, 'Y', 'N', '2021-03-01 02:45:19', '2021-03-01 02:45:19'),
(157, 19, 'Blue Berry Choco', 'Blue Berry Choco', 100, 1000, 'Y', 'N', '2021-03-01 02:45:34', '2021-03-01 02:45:34'),
(158, 19, 'Carrot Cake', 'Carrot Cake', 100, 900, 'Y', 'N', '2021-03-01 02:45:58', '2021-03-01 02:45:58'),
(159, 19, 'Chocolite', 'Chocolite', 100, 900, 'Y', 'N', '2021-03-01 02:46:11', '2021-03-01 02:46:11'),
(160, 19, 'Oreo Cheese Cake', 'Oreo Cheese Cake', 100, 1200, 'Y', 'N', '2021-03-01 02:46:38', '2021-03-01 02:46:38'),
(161, 19, 'Pandan Cake', 'Pandan Cake', 100, 825, 'Y', 'N', '2021-03-01 02:46:52', '2021-03-01 02:46:52'),
(162, 19, 'Red Velvet', 'Red Velvet', 100, 900, 'Y', 'N', '2021-03-01 02:47:05', '2021-03-01 02:47:05'),
(163, 19, 'Sinful Cake', 'Sinful Cake', 100, 1200, 'Y', 'N', '2021-03-01 02:47:19', '2021-03-01 02:47:34'),
(164, 19, 'Tiramisu Cake', 'Tiramisu Cake', 100, 900, 'Y', 'N', '2021-03-01 02:48:03', '2021-03-01 02:48:03'),
(165, 19, 'Yema Caramel', 'Yema Caramel', 100, 825, 'Y', 'N', '2021-03-01 02:48:24', '2021-03-01 02:48:24'),
(166, 19, 'Yema Cheese Cake', 'Yema Cheese Cake', 100, 825, 'Y', 'N', '2021-03-01 02:48:38', '2021-03-01 02:48:38'),
(167, 19, 'Lemon Cake', 'Lemon Cake', 100, 825, 'Y', 'N', '2021-03-01 02:48:48', '2021-03-01 02:48:48'),
(168, 20, 'Blueberry Cheese Cake', 'Blueberry Cheese Cake', 95, 100, 'Y', 'N', '2021-03-01 02:49:23', '2021-03-18 07:29:02'),
(169, 20, 'Blue Berry Choco', 'Blue Berry Choco', 96, 85, 'Y', 'N', '2021-03-01 02:49:42', '2021-03-18 07:24:18'),
(170, 20, 'Carrot Cake', 'Carrot Cake', 98, 75, 'Y', 'N', '2021-03-01 02:50:02', '2021-03-16 23:54:42'),
(171, 20, 'Chocolite', 'Chocolite', 100, 75, 'Y', 'N', '2021-03-01 02:50:22', '2021-03-01 02:50:22'),
(172, 20, 'Oreo Cheese Cake', 'Oreo Cheese Cake', 97, 100, 'Y', 'N', '2021-03-01 02:50:53', '2021-03-18 07:35:07'),
(173, 20, 'Pandan Cake', 'Pandan Cake', 95, 75, 'Y', 'N', '2021-03-01 02:51:07', '2021-03-16 23:46:49'),
(174, 20, 'Red Velvet', 'Red Velvet', 100, 75, 'Y', 'N', '2021-03-01 02:51:19', '2021-03-01 02:51:19'),
(175, 20, 'Sinful Cake', 'Sinful Cake', 99, 100, 'Y', 'N', '2021-03-01 02:51:32', '2021-03-18 07:35:07'),
(176, 20, 'Tiramisu Cake', 'Tiramisu Cake', 100, 75, 'Y', 'N', '2021-03-01 02:51:47', '2021-03-01 02:51:47'),
(177, 20, 'Yema Caramel', 'Yema Caramel', 98, 75, 'Y', 'N', '2021-03-01 02:52:01', '2021-03-16 23:46:49'),
(178, 20, 'Yema Cheese Cake', 'Yema Cheese Cake', 100, 75, 'Y', 'N', '2021-03-01 02:52:14', '2021-03-01 02:52:14'),
(179, 20, 'Lemon Cake', 'Lemon Cake', 99, 75, 'Y', 'N', '2021-03-01 02:52:26', '2021-03-18 02:44:35'),
(180, 21, 'Brownies', 'Brownies', 100, 20, 'Y', 'N', '2021-03-01 02:52:51', '2021-03-01 02:52:51'),
(181, 21, 'Blueberry Crumble', 'Blueberry Crumble', 97, 25, 'Y', 'N', '2021-03-01 02:53:06', '2021-03-18 10:50:08'),
(182, 21, 'Oatmeal Bar', 'Oatmeal Bar', 97, 20, 'Y', 'N', '2021-03-01 02:53:20', '2021-03-18 10:50:08'),
(183, 21, 'Cheese Bar', 'Cheese Bar', 100, 20, 'Y', 'N', '2021-03-01 02:53:28', '2021-03-01 02:53:28'),
(184, 21, 'Yema Caramel Bar', 'Yema Caramel Bar', 100, 20, 'Y', 'N', '2021-03-01 02:53:45', '2021-03-01 02:53:45'),
(185, 22, 'Oatmeal Cookies', 'Oatmeal Cookies', 99, 70, 'Y', 'N', '2021-03-01 02:54:04', '2021-03-17 00:49:13'),
(186, 22, 'Oatmeal Nuts Cookies', 'Oatmeal Nuts Cookies', 98, 60, 'Y', 'N', '2021-03-01 02:54:23', '2021-03-16 23:41:09'),
(187, 22, 'Crunchy Peanut Cookies', 'Crunchy Peanut Cookies', 100, 70, 'Y', 'N', '2021-03-01 02:54:38', '2021-03-01 02:54:38'),
(188, 22, 'Butter Cookies', 'Butter Cookies', 96, 70, 'Y', 'N', '2021-03-01 02:54:49', '2021-03-18 02:31:18'),
(189, 22, 'Chocolate Chip', 'Chocolate Chip', 99, 70, 'Y', 'N', '2021-03-01 02:55:00', '2021-03-18 07:35:07'),
(190, 23, 'Cheesy Pie', 'Cheesy Pie', 100, 55, 'Y', 'N', '2021-03-01 02:55:14', '2021-03-01 02:55:14'),
(191, 23, 'Blueberry Muffin', 'Blueberry Muffin', 100, 50, 'Y', 'N', '2021-03-01 02:55:34', '2021-03-01 02:55:34'),
(192, 23, 'Malungay Muffin', 'Malungay Muffin', 100, 50, 'Y', 'N', '2021-03-01 02:55:47', '2021-03-01 02:56:04'),
(193, 23, 'Strawberry Muffin', 'Strawberry Muffin', 100, 50, 'Y', 'N', '2021-03-01 02:56:37', '2021-03-01 02:56:37'),
(194, 23, 'Banana Muffin', 'Banana Muffin', 100, 50, 'Y', 'N', '2021-03-01 02:57:01', '2021-03-01 02:57:01'),
(195, 23, 'Carrot Muffin', 'Carrot Muffin', 100, 50, 'Y', 'N', '2021-03-01 02:57:13', '2021-03-01 02:57:13'),
(196, 23, 'Bibingka', 'Bibingka', 100, 55, 'Y', 'N', '2021-03-01 02:57:25', '2021-03-01 02:57:25'),
(197, 23, 'Ensaymada', 'Ensaymada', 100, 50, 'Y', 'N', '2021-03-01 02:57:39', '2021-03-01 02:57:39'),
(198, 23, 'Double Choco', 'Double Choco', 100, 60, 'Y', 'N', '2021-03-01 02:57:52', '2021-03-01 02:57:52'),
(199, 23, 'Brownies Cake', 'Brownies Cake', 100, 60, 'Y', 'N', '2021-03-01 02:58:04', '2021-03-01 02:58:04'),
(200, 23, 'Cinnamon Twist', 'Cinnamon Twist', 100, 50, 'Y', 'N', '2021-03-01 02:58:19', '2021-03-01 02:58:19'),
(201, 23, 'Hopia', 'Hopia', 54, 15, 'Y', 'N', '2021-03-01 02:58:35', '2021-03-18 10:51:22'),
(202, 23, 'Blueberry Cheezy Pie', 'Blueberry Cheezy Pie', 100, 65, 'Y', 'N', '2021-03-01 02:58:51', '2021-03-01 02:58:51'),
(203, 23, 'Siopao', 'Siopao', 100, 55, 'Y', 'N', '2021-03-01 02:59:04', '2021-03-01 02:59:04'),
(204, 23, 'Cassava', 'Cassava', 94, 60, 'Y', 'N', '2021-03-01 02:59:16', '2021-03-18 10:36:38'),
(205, 23, 'Brazo De Mercedes', 'Brazo De Mercedes', 100, 50, 'Y', 'N', '2021-03-01 02:59:38', '2021-03-01 02:59:38'),
(206, 23, 'Apple Pie', 'Apple Pie', 100, 750, 'Y', 'N', '2021-03-01 03:00:05', '2021-03-01 03:00:05'),
(207, 23, 'Chicken Siopao', 'Chicken Siopao', 100, 55, 'Y', 'N', '2021-03-01 03:00:19', '2021-03-01 03:00:19'),
(208, 23, 'Crincles', 'Crincles', 100, 10, 'Y', 'N', '2021-03-01 03:00:42', '2021-03-01 03:00:42'),
(209, 23, 'Clover', 'Clover', 100, 10, 'Y', 'N', '2021-03-01 03:00:54', '2021-03-01 03:00:54'),
(210, 23, 'Squash Bread', 'Squash Bread', 100, 12, 'Y', 'N', '2021-03-01 03:01:14', '2021-03-01 03:01:14'),
(211, 23, 'French Bread', 'French Bread', 100, 50, 'Y', 'N', '2021-03-01 03:01:29', '2021-03-01 03:01:29'),
(212, 23, 'Cheese Bun', 'Cheese Bun', 100, 15, 'Y', 'N', '2021-03-01 03:01:46', '2021-03-01 03:01:46'),
(213, 23, 'Spanish Bread', 'Spanish Bread', 100, 20, 'Y', 'N', '2021-03-01 03:02:07', '2021-03-01 03:02:07'),
(214, 23, 'Red Velvet Cupcake', 'Red Velvet Cupcake', 100, 30, 'Y', 'N', '2021-03-01 03:02:23', '2021-03-01 03:02:23'),
(215, 24, 'Aoili  Solo', 'Aoili  Solo', 98, 30, 'Y', 'N', '2021-03-16 18:57:57', '2021-03-16 18:59:26'),
(216, 24, 'Aolli Big', 'Aolli Big', 99, 35, 'Y', 'N', '2021-03-16 18:58:42', '2021-03-16 18:58:42'),
(217, 25, 'Petchay Tagalog', 'Petchay Tagalog', 99, 75, 'Y', 'N', '2021-03-16 23:12:10', '2021-03-16 23:12:10'),
(218, 25, 'Petchay Flowering', 'Petchay Flowering', 98, 80, 'Y', 'N', '2021-03-16 23:13:02', '2021-03-17 00:21:18'),
(219, 25, 'Pole Beans', 'Pole Beans', 99, 80, 'Y', 'N', '2021-03-16 23:13:41', '2021-03-16 23:13:41'),
(220, 25, 'Sitaw', 'Sitaw', 98, 60, 'Y', 'N', '2021-03-16 23:14:14', '2021-03-18 06:22:20'),
(221, 25, 'Chingkang', 'Chingkang', 99, 70, 'Y', 'N', '2021-03-16 23:14:37', '2021-03-16 23:14:37'),
(222, 25, 'Mostasa', 'Mostasa', 99, 70, 'Y', 'N', '2021-03-16 23:14:59', '2021-03-16 23:14:59'),
(223, 25, 'Lettuce', 'Lettuce', 99, 80, 'Y', 'N', '2021-03-16 23:15:27', '2021-03-16 23:15:27'),
(224, 25, 'Mint', 'MInt', 99, 50, 'Y', 'N', '2021-03-16 23:15:57', '2021-03-16 23:15:57'),
(225, 25, 'Blue Ternate', 'Blue Ternate', 99, 500, 'Y', 'N', '2021-03-16 23:16:27', '2021-03-16 23:16:27'),
(226, 25, 'Chili', 'Chili', 99, 300, 'Y', 'N', '2021-03-16 23:16:49', '2021-03-16 23:16:49'),
(227, 25, 'Beans', 'Beans', 79, 80, 'Y', 'N', '2021-03-16 23:17:18', '2021-03-18 06:24:01'),
(228, 25, 'Mustard', 'Mustard', 99, 70, 'Y', 'N', '2021-03-16 23:17:44', '2021-03-16 23:17:44'),
(229, 25, 'Kamote', 'Kamote', 98, 50, 'Y', 'N', '2021-03-16 23:18:05', '2021-03-18 06:22:19'),
(230, 25, 'Kalabasa', 'Kalabasa', 99, 45, 'Y', 'N', '2021-03-16 23:18:28', '2021-03-16 23:18:28'),
(231, 25, 'Banana', 'Banana', 99, 50, 'Y', 'N', '2021-03-16 23:18:49', '2021-03-16 23:18:49'),
(232, 25, 'Papaya', 'Papaya', 99, 50, 'Y', 'N', '2021-03-16 23:19:22', '2021-03-16 23:19:22'),
(233, 25, 'Antak', 'Antak', 99, 100, 'Y', 'N', '2021-03-16 23:19:48', '2021-03-16 23:19:48'),
(234, 25, 'Aba', 'Aba', 99, 80, 'Y', 'N', '2021-03-16 23:19:57', '2021-03-16 23:19:57'),
(235, 25, 'Lemon', 'Lemon', 99, 70, 'Y', 'N', '2021-03-16 23:20:09', '2021-03-16 23:20:09'),
(236, 25, 'Mushroom', 'Mushroom', 98, 240, 'Y', 'N', '2021-03-16 23:20:21', '2021-03-18 06:24:01'),
(237, 25, 'Yakun', 'Yakun', 99, 60, 'Y', 'N', '2021-03-16 23:20:46', '2021-03-16 23:20:46'),
(238, 25, 'Patatas', 'Yakun', 99, 70, 'Y', 'N', '2021-03-16 23:21:37', '2021-03-16 23:21:37'),
(239, 25, 'Cardis', 'Cardis', 99, 80, 'Y', 'N', '2021-03-16 23:22:42', '2021-03-16 23:22:42'),
(240, 24, 'BBQ sauce', 'BBQ sauce', 99, 25, 'Y', 'N', '2021-03-16 23:24:47', '2021-03-16 23:24:47'),
(241, 24, 'Fruit Vinaigrette', 'Fruit Vinaigrette', 99, 35, 'Y', 'N', '2021-03-16 23:25:09', '2021-03-16 23:25:09'),
(242, 24, 'Balsanic Vinaigrette', 'Balsanic Vinaigrette', 99, 35, 'Y', 'N', '2021-03-16 23:26:26', '2021-03-16 23:26:26'),
(243, 24, 'Pesto Aoili Sauce', 'Pesto Aoili Sauce', 99, 35, 'Y', 'N', '2021-03-16 23:26:41', '2021-03-16 23:26:41'),
(244, 26, 'Canister', 'Canister', 97, 10, 'Y', 'N', '2021-03-16 23:27:35', '2021-03-18 10:44:47'),
(245, 26, 'Round Cannister', 'Round Cannister', 99, 5, 'Y', 'N', '2021-03-16 23:27:47', '2021-03-16 23:27:47'),
(246, 26, 'Take out Box Small', 'Take out Box Small', 99, 15, 'Y', 'N', '2021-03-16 23:28:04', '2021-03-16 23:28:04'),
(247, 26, 'Take out Box Big', 'Take out Box Big', 98, 25, 'Y', 'N', '2021-03-16 23:28:14', '2021-03-18 10:35:14'),
(248, 26, 'Take out cup', 'Take out cup', 98, 5, 'Y', 'N', '2021-03-16 23:28:30', '2021-03-18 02:42:35'),
(249, 26, 'Add Milk', 'Add Milk', 99, 5, 'Y', 'N', '2021-03-16 23:28:41', '2021-03-16 23:28:41'),
(250, 26, 'Additional Honey', 'Additional Honey', 99, 15, 'Y', 'N', '2021-03-16 23:28:53', '2021-03-16 23:28:53'),
(251, 25, 'Petchay Flowering 1/2', 'Petchay Flowering 1/2', 97, 40, 'Y', 'N', '2021-03-16 23:39:52', '2021-03-17 00:18:04'),
(252, 26, 'bottle water 500ml', 'bottle water 500ml', 99, 20, 'Y', 'N', '2021-03-16 23:42:59', '2021-03-16 23:42:59'),
(253, 26, 'bottle water 350ml', 'bottle water 350ml', 97, 15, 'Y', 'N', '2021-03-16 23:43:21', '2021-03-17 00:06:15'),
(254, 26, 'bottle water 1l', 'bottle water 1l', 99, 25, 'Y', 'N', '2021-03-16 23:43:38', '2021-03-16 23:43:38'),
(255, 11, '2 combi juice', '2 combi juice', 96, 85, 'Y', 'N', '2021-03-16 23:52:01', '2021-03-18 07:29:02'),
(256, 11, '2 combi juice', '2 combi juice', 99, 85, 'Y', 'N', '2021-03-16 23:52:43', '2021-03-16 23:52:43'),
(257, 11, '2 combi shake', '2 combi shake', 99, 95, 'Y', 'N', '2021-03-16 23:53:12', '2021-03-16 23:53:12'),
(258, 11, '3-4 combi shake', '3-4combi shake', 99, 100, 'Y', 'N', '2021-03-16 23:53:32', '2021-03-16 23:53:32'),
(259, 11, 'mango shake', 'mango shake', 93, 85, 'Y', 'N', '2021-03-17 00:09:42', '2021-03-18 08:04:01'),
(260, 11, 'guya shake', 'guya shake', 92, 85, 'Y', 'N', '2021-03-17 00:09:59', '2021-03-18 08:04:01'),
(261, 11, 'straw shake', 'straw shake', 95, 95, 'Y', 'N', '2021-03-17 00:10:17', '2021-03-18 10:50:08'),
(262, 11, 'apple shake', 'apple shake', 99, 85, 'Y', 'N', '2021-03-17 00:10:32', '2021-03-17 00:10:32'),
(263, 11, 'melon shake', 'melon shake', 99, 85, 'Y', 'N', '2021-03-17 00:10:48', '2021-03-17 00:10:48'),
(264, 11, 'papaya shake', 'papaya shake', 99, 85, 'Y', 'N', '2021-03-17 00:11:01', '2021-03-17 00:11:01'),
(265, 11, 'banana shake', 'banana shake', 99, 85, 'Y', 'N', '2021-03-17 00:11:16', '2021-03-17 00:11:16'),
(266, 18, 'pande wd butter', 'pande wd butter', 98, 25, 'Y', 'N', '2021-03-17 00:16:12', '2021-03-17 00:16:57'),
(267, 25, 'beans 1.5kl', 'beans 1.5kl', 98, 120, 'Y', 'N', '2021-03-17 00:20:25', '2021-03-17 00:21:18'),
(268, 16, 'taro chip', 'taro chip', 98, 25, 'Y', 'N', '2021-03-17 00:24:57', '2021-03-17 00:25:23'),
(269, 7, 'grilled salmon', 'grilled salmon', 91, 295, 'Y', 'N', '2021-03-17 17:17:45', '2021-03-18 08:04:01'),
(270, 18, 'siopao', 'siopao', 87, 60, 'Y', 'N', '2021-03-18 02:41:50', '2021-03-18 10:51:22'),
(271, 18, 'Ube Piyaya', 'Ube Piyaya', 92, 15, 'Y', 'N', '2021-03-18 05:53:35', '2021-03-18 10:35:14'),
(272, 25, 'mushroom .75kl', 'mushroom .75kl', 99, 180, 'Y', 'N', '2021-03-18 06:26:25', '2021-03-18 06:30:52'),
(273, 26, 'Extra Rice', 'Extra Rice', 98, 30, 'Y', 'N', '2021-03-18 07:49:32', '2021-03-18 08:07:04'),
(274, 1, 'Sunny Egg', 'Sunny Egg', 96, 25, 'Y', 'N', '2021-03-18 08:03:57', '2021-03-18 08:07:04'),
(275, 1, 'Scramble Egg', 'Scramble Egg', 99, 25, 'Y', 'N', '2021-03-18 08:03:57', '2021-03-18 08:05:22'),
(276, 1, 'Boiled Egg', 'Boiled Egg', 99, 30, 'Y', 'N', '2021-03-18 08:04:56', '2021-03-18 08:05:36'),
(277, 23, 'Pineapple Piyaya', 'Pineapple Piyaya', 99, 15, 'Y', 'N', '2021-03-18 10:33:46', '2021-03-18 10:34:07');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2021_01_28_071106_categories', 1),
(3, '2021_01_28_071129_items', 1),
(4, '2021_01_28_071143_departments', 1),
(5, '2021_01_29_033415_transactions', 1),
(6, '2021_02_04_021211_orders', 1),
(7, '2021_02_09_065818_tables', 1),
(8, '2021_03_01_075422_devices', 1),
(9, '2021_03_03_024458_create_inventories_table', 1),
(10, '2021_03_03_044744_create_users_table', 1),
(11, '2021_03_03_050819_create_roles_table', 1),
(12, '2021_03_05_051444_payments', 1),
(13, '2021_03_08_010234_cashins', 1),
(14, '2021_03_08_010244_cashouts', 1),
(15, '2021_03_11_011952_beginingfunds', 1),
(16, '2021_03_12_005915_accountexpenses', 1),
(17, '2021_03_12_010002_expenses', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` bigint(20) UNSIGNED NOT NULL,
  `transactionId` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `itemId` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoryId` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `orderQty` int(11) NOT NULL,
  `orderPrice` double NOT NULL,
  `orderTotal` double NOT NULL,
  `orderStatus` int(11) NOT NULL DEFAULT 0 COMMENT '1 if printed/ 0 if not printed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `transactionId`, `itemId`, `categoryId`, `orderQty`, `orderPrice`, `orderTotal`, `orderStatus`, `created_at`, `updated_at`) VALUES
(38, '10', '201', '23', 1, 15, 15, 1, '2021-03-16 19:26:14', '2021-03-18 10:51:28'),
(39, '11', '38', '9', 1, 175, 175, 1, '2021-03-16 19:29:59', '2021-03-18 10:51:35'),
(40, '11', '31', '7', 1, 195, 195, 1, '2021-03-16 19:29:59', '2021-03-18 10:51:35'),
(41, '11', '40', '10', 1, 35, 35, 1, '2021-03-16 19:29:59', '2021-03-18 10:51:35'),
(42, '11', '56', '14', 4, 50, 200, 1, '2021-03-16 19:29:59', '2021-03-18 10:51:28'),
(43, '11', '169', '20', 1, 85, 85, 1, '2021-03-16 19:29:59', '2021-03-18 10:51:28'),
(44, '11', '173', '20', 1, 75, 75, 1, '2021-03-16 19:30:00', '2021-03-18 10:51:28'),
(45, '12', '49', '13', 1, 75, 75, 1, '2021-03-16 19:38:09', '2021-03-18 10:51:28'),
(46, '12', '40', '10', 1, 35, 35, 1, '2021-03-16 19:38:09', '2021-03-18 10:51:35'),
(47, '12', '12', '4', 1, 100, 100, 1, '2021-03-16 19:38:09', '2021-03-18 10:51:35'),
(48, '12', '56', '14', 1, 50, 50, 1, '2021-03-16 19:38:09', '2021-03-18 10:51:28'),
(49, '13', '56', '14', 3, 50, 150, 1, '2021-03-16 19:46:10', '2021-03-18 10:51:28'),
(50, '14', '21', '5', 1, 195, 195, 1, '2021-03-16 22:12:36', '2021-03-18 10:51:35'),
(51, '14', '28', '6', 1, 185, 185, 1, '2021-03-16 22:12:36', '2021-03-18 10:51:35'),
(52, '14', '42', '11', 1, 85, 85, 1, '2021-03-16 22:12:36', '2021-03-18 10:51:28'),
(53, '15', '32', '7', 1, 200, 200, 1, '2021-03-16 22:21:37', '2021-03-18 10:51:36'),
(54, '15', '31', '7', 1, 195, 195, 1, '2021-03-16 22:21:38', '2021-03-18 10:51:36'),
(55, '15', '145', '18', 6, 20, 120, 1, '2021-03-16 22:21:38', '2021-03-18 10:51:28'),
(56, '16', '186', '22', 1, 60, 60, 1, '2021-03-16 22:33:26', '2021-03-18 10:51:28'),
(57, '16', '201', '23', 1, 15, 15, 1, '2021-03-16 22:33:26', '2021-03-18 10:51:28'),
(58, '16', '54', '13', 2, 95, 190, 1, '2021-03-16 22:33:26', '2021-03-18 10:51:28'),
(59, '16', '188', '22', 1, 70, 70, 1, '2021-03-16 22:33:26', '2021-03-18 10:51:28'),
(60, '16', '6', '2', 1, 95, 95, 1, '2021-03-16 22:33:26', '2021-03-18 10:51:36'),
(61, '17', '38', '9', 1, 175, 175, 1, '2021-03-16 23:32:06', '2021-03-18 10:51:36'),
(62, '17', '31', '7', 1, 195, 195, 1, '2021-03-16 23:32:06', '2021-03-18 10:51:36'),
(63, '17', '40', '10', 1, 35, 35, 1, '2021-03-16 23:32:06', '2021-03-18 10:51:36'),
(64, '17', '56', '14', 4, 50, 200, 1, '2021-03-16 23:32:06', '2021-03-18 10:51:28'),
(65, '17', '169', '20', 1, 85, 85, 1, '2021-03-16 23:32:06', '2021-03-18 10:51:29'),
(66, '17', '173', '20', 1, 75, 75, 1, '2021-03-16 23:32:06', '2021-03-18 10:51:29'),
(67, '18', '201', '23', 1, 15, 15, 1, '2021-03-16 23:34:32', '2021-03-18 10:51:29'),
(68, '19', '49', '13', 1, 75, 75, 1, '2021-03-16 23:35:46', '2021-03-18 10:51:29'),
(69, '19', '40', '10', 1, 35, 35, 1, '2021-03-16 23:35:46', '2021-03-18 10:51:36'),
(70, '19', '12', '4', 1, 100, 100, 1, '2021-03-16 23:35:46', '2021-03-18 10:51:36'),
(71, '19', '56', '14', 1, 50, 50, 1, '2021-03-16 23:35:46', '2021-03-18 10:51:29'),
(72, '20', '54', '13', 2, 95, 190, 1, '2021-03-16 23:41:09', '2021-03-18 10:51:29'),
(73, '20', '188', '22', 1, 70, 70, 1, '2021-03-16 23:41:09', '2021-03-18 10:51:29'),
(74, '20', '186', '22', 1, 60, 60, 1, '2021-03-16 23:41:09', '2021-03-18 10:51:29'),
(75, '20', '60', '14', 1, 95, 95, 1, '2021-03-16 23:41:09', '2021-03-18 10:51:29'),
(76, '20', '251', '25', 1, 40, 40, 1, '2021-03-16 23:41:09', '2021-03-18 10:51:34'),
(77, '20', '201', '23', 1, 15, 15, 1, '2021-03-16 23:41:09', '2021-03-18 10:51:29'),
(78, '21', '27', '6', 1, 195, 195, 1, '2021-03-16 23:44:51', '2021-03-18 10:51:36'),
(79, '21', '253', '26', 1, 15, 15, 1, '2021-03-16 23:44:51', '2021-03-18 10:51:34'),
(80, '21', '170', '20', 1, 75, 75, 1, '2021-03-16 23:44:51', '2021-03-18 10:51:29'),
(81, '22', '173', '20', 2, 75, 150, 1, '2021-03-16 23:46:49', '2021-03-18 10:51:29'),
(82, '22', '177', '20', 2, 75, 150, 1, '2021-03-16 23:46:49', '2021-03-18 10:51:29'),
(83, '22', '56', '14', 3, 50, 150, 1, '2021-03-16 23:46:49', '2021-03-18 10:51:29'),
(84, '22', '52', '13', 1, 95, 95, 1, '2021-03-16 23:46:49', '2021-03-18 10:51:29'),
(85, '22', '58', '14', 1, 65, 65, 1, '2021-03-16 23:46:49', '2021-03-18 10:51:29'),
(86, '22', '201', '23', 1, 15, 15, 1, '2021-03-16 23:46:49', '2021-03-18 10:51:29'),
(87, '22', '151', '18', 1, 100, 100, 1, '2021-03-16 23:46:49', '2021-03-18 10:51:29'),
(88, '23', '17', '4', 1, 195, 195, 1, '2021-03-16 23:48:52', '2021-03-18 10:51:36'),
(89, '23', '16', '4', 1, 195, 195, 1, '2021-03-16 23:48:53', '2021-03-18 10:51:36'),
(90, '23', '148', '18', 1, 75, 75, 1, '2021-03-16 23:48:53', '2021-03-18 10:51:29'),
(91, '24', '33', '7', 2, 295, 590, 1, '2021-03-16 23:54:42', '2021-03-18 10:51:36'),
(92, '24', '170', '20', 1, 75, 75, 1, '2021-03-16 23:54:42', '2021-03-18 10:51:29'),
(93, '24', '54', '13', 1, 95, 95, 1, '2021-03-16 23:54:42', '2021-03-18 10:51:29'),
(94, '24', '201', '23', 2, 15, 30, 1, '2021-03-16 23:54:42', '2021-03-18 10:51:29'),
(96, '25', '56', '14', 2, 50, 100, 1, '2021-03-16 23:55:50', '2021-03-18 10:51:29'),
(97, '26', '49', '13', 1, 75, 75, 1, '2021-03-16 23:59:29', '2021-03-18 10:51:29'),
(98, '26', '40', '10', 1, 35, 35, 1, '2021-03-16 23:59:29', '2021-03-18 10:51:36'),
(99, '26', '12', '4', 1, 100, 100, 1, '2021-03-16 23:59:29', '2021-03-18 10:51:36'),
(100, '26', '56', '14', 1, 50, 50, 1, '2021-03-16 23:59:29', '2021-03-18 10:51:29'),
(101, '27', '27', '6', 2, 195, 390, 1, '2021-03-17 00:03:41', '2021-03-18 10:51:36'),
(102, '27', '56', '14', 2, 50, 100, 1, '2021-03-17 00:03:41', '2021-03-18 10:51:29'),
(103, '28', '7', '3', 1, 195, 195, 1, '2021-03-17 00:05:01', '2021-03-18 10:51:36'),
(104, '28', '53', '13', 1, 95, 95, 1, '2021-03-17 00:05:01', '2021-03-18 10:51:29'),
(105, '28', '52', '13', 1, 95, 95, 1, '2021-03-17 00:05:02', '2021-03-18 10:51:29'),
(106, '28', '2', '1', 1, 195, 195, 1, '2021-03-17 00:05:02', '2021-03-18 10:51:36'),
(107, '29', '15', '4', 1, 100, 100, 1, '2021-03-17 00:06:15', '2021-03-18 10:51:36'),
(108, '29', '11', '3', 1, 205, 205, 1, '2021-03-17 00:06:15', '2021-03-18 10:51:36'),
(109, '29', '56', '14', 1, 50, 50, 1, '2021-03-17 00:06:15', '2021-03-18 10:51:29'),
(110, '29', '253', '26', 1, 15, 15, 1, '2021-03-17 00:06:15', '2021-03-18 10:51:34'),
(111, '30', '29', '6', 1, 195, 195, 1, '2021-03-17 00:07:26', '2021-03-18 10:51:36'),
(112, '30', '33', '7', 1, 295, 295, 1, '2021-03-17 00:07:26', '2021-03-18 10:51:36'),
(113, '30', '56', '14', 1, 50, 50, 1, '2021-03-17 00:07:26', '2021-03-18 10:51:29'),
(114, '31', '21', '5', 1, 195, 195, 1, '2021-03-17 00:12:08', '2021-03-18 10:51:36'),
(115, '31', '12', '4', 1, 100, 100, 1, '2021-03-17 00:12:08', '2021-03-18 10:51:36'),
(116, '31', '260', '11', 1, 85, 85, 1, '2021-03-17 00:12:08', '2021-03-18 10:51:29'),
(117, '31', '29', '6', 1, 195, 195, 1, '2021-03-17 00:12:08', '2021-03-18 10:51:36'),
(118, '32', '8', '3', 2, 185, 370, 1, '2021-03-17 00:13:48', '2021-03-18 10:51:36'),
(119, '32', '80', '15', 1, 55, 55, 1, '2021-03-17 00:13:49', '2021-03-18 10:51:29'),
(120, '32', '56', '14', 1, 50, 50, 1, '2021-03-17 00:13:49', '2021-03-18 10:51:30'),
(121, '32', '66', '15', 1, 55, 55, 1, '2021-03-17 00:13:49', '2021-03-18 10:51:30'),
(122, '33', '151', '18', 1, 100, 100, 1, '2021-03-17 00:14:55', '2021-03-18 10:51:30'),
(123, '33', '155', '18', 1, 65, 65, 1, '2021-03-17 00:14:55', '2021-03-18 10:51:30'),
(124, '33', '201', '23', 4, 15, 60, 1, '2021-03-17 00:14:55', '2021-03-18 10:51:30'),
(125, '34', '260', '11', 1, 85, 85, 1, '2021-03-17 00:16:56', '2021-03-18 10:51:30'),
(126, '34', '266', '18', 1, 25, 25, 1, '2021-03-17 00:16:57', '2021-03-18 10:51:30'),
(127, '34', '29', '6', 1, 195, 195, 1, '2021-03-17 00:16:57', '2021-03-18 10:51:36'),
(128, '34', '49', '13', 1, 75, 75, 1, '2021-03-17 00:16:57', '2021-03-18 10:51:30'),
(129, '35', '57', '14', 1, 50, 50, 1, '2021-03-17 00:18:04', '2021-03-18 10:51:30'),
(130, '35', '56', '14', 1, 50, 50, 1, '2021-03-17 00:18:04', '2021-03-18 10:51:30'),
(131, '35', '8', '3', 1, 185, 185, 1, '2021-03-17 00:18:04', '2021-03-18 10:51:36'),
(132, '35', '251', '25', 1, 40, 40, 1, '2021-03-17 00:18:04', '2021-03-18 10:51:34'),
(133, '36', '32', '7', 1, 200, 200, 1, '2021-03-17 00:21:18', '2021-03-18 10:51:36'),
(134, '36', '31', '7', 1, 195, 195, 1, '2021-03-17 00:21:18', '2021-03-18 10:51:36'),
(135, '36', '146', '18', 6, 20, 120, 1, '2021-03-17 00:21:18', '2021-03-18 10:51:30'),
(136, '36', '267', '25', 1, 120, 120, 1, '2021-03-17 00:21:18', '2021-03-18 10:51:34'),
(137, '36', '218', '25', 1, 80, 80, 1, '2021-03-17 00:21:18', '2021-03-18 10:51:34'),
(138, '37', '21', '5', 1, 195, 195, 1, '2021-03-17 00:22:21', '2021-03-18 10:51:36'),
(139, '37', '28', '6', 1, 185, 185, 1, '2021-03-17 00:22:21', '2021-03-18 10:51:36'),
(140, '37', '259', '11', 1, 85, 85, 1, '2021-03-17 00:22:21', '2021-03-18 10:51:30'),
(141, '38', '201', '23', 1, 15, 15, 1, '2021-03-17 00:23:24', '2021-03-18 10:51:30'),
(142, '38', '188', '22', 1, 70, 70, 1, '2021-03-17 00:23:24', '2021-03-18 10:51:30'),
(143, '39', '98', '16', 1, 160, 160, 1, '2021-03-17 00:24:04', '2021-03-18 10:51:34'),
(144, '40', '201', '23', 8, 15, 120, 1, '2021-03-17 00:25:23', '2021-03-18 10:51:30'),
(145, '40', '268', '16', 1, 25, 25, 1, '2021-03-17 00:25:23', '2021-03-18 10:51:34'),
(146, '41', '12', '4', 2, 100, 200, 1, '2021-03-17 00:29:11', '2021-03-18 10:51:36'),
(147, '42', '56', '14', 6, 50, 300, 1, '2021-03-17 00:49:13', '2021-03-18 10:51:30'),
(148, '42', '185', '22', 1, 70, 70, 1, '2021-03-17 00:49:13', '2021-03-18 10:51:30'),
(152, '44', '28', '6', 5, 185, 925, 1, '2021-03-18 02:14:21', '2021-03-18 10:51:36'),
(153, '44', '72', '15', 2, 75, 150, 1, '2021-03-18 02:14:21', '2021-03-18 10:51:30'),
(154, '44', '60', '14', 2, 95, 190, 1, '2021-03-18 02:14:21', '2021-03-18 10:51:30'),
(155, '44', '204', '23', 1, 60, 60, 1, '2021-03-18 02:14:21', '2021-03-18 10:51:30'),
(157, '46', '110', '16', 2, 230, 460, 1, '2021-03-18 02:25:14', '2021-03-18 10:51:34'),
(158, '47', '148', '18', 1, 75, 75, 1, '2021-03-18 02:31:17', '2021-03-18 10:51:30'),
(159, '47', '188', '22', 1, 70, 70, 1, '2021-03-18 02:31:17', '2021-03-18 10:51:30'),
(160, '48', '201', '23', 1, 15, 15, 1, '2021-03-18 02:42:34', '2021-03-18 10:51:30'),
(161, '48', '270', '18', 1, 60, 60, 1, '2021-03-18 02:42:35', '2021-03-18 10:51:30'),
(162, '48', '248', '26', 1, 5, 5, 1, '2021-03-18 02:42:35', '2021-03-18 10:51:34'),
(163, '49', '16', '4', 1, 195, 195, 1, '2021-03-18 02:44:35', '2021-03-18 10:51:36'),
(164, '49', '24', '5', 1, 185, 185, 1, '2021-03-18 02:44:35', '2021-03-18 10:51:36'),
(165, '49', '168', '20', 2, 100, 200, 1, '2021-03-18 02:44:35', '2021-03-18 10:51:30'),
(166, '49', '179', '20', 1, 75, 75, 1, '2021-03-18 02:44:35', '2021-03-18 10:51:30'),
(167, '49', '172', '20', 1, 100, 100, 1, '2021-03-18 02:44:35', '2021-03-18 10:51:30'),
(168, '49', '182', '21', 2, 20, 40, 1, '2021-03-18 02:45:21', '2021-03-18 10:51:30'),
(169, '50', '269', '7', 2, 295, 590, 1, '2021-03-18 02:46:33', '2021-03-18 10:51:37'),
(170, '50', '49', '13', 1, 75, 75, 1, '2021-03-18 02:46:33', '2021-03-18 10:51:30'),
(171, '50', '56', '14', 1, 50, 50, 1, '2021-03-18 02:46:33', '2021-03-18 10:51:30'),
(172, '50', '24', '5', 1, 185, 185, 1, '2021-03-18 02:46:34', '2021-03-18 10:51:37'),
(173, '51', '151', '18', 1, 100, 100, 1, '2021-03-18 03:00:54', '2021-03-18 10:51:30'),
(174, '51', '154', '18', 1, 65, 65, 1, '2021-03-18 03:00:54', '2021-03-18 10:51:30'),
(175, '51', '146', '18', 3, 20, 60, 1, '2021-03-18 03:00:55', '2021-03-18 10:51:30'),
(176, '52', '27', '6', 5, 195, 975, 1, '2021-03-18 03:03:15', '2021-03-18 10:51:37'),
(177, '52', '29', '6', 1, 195, 195, 1, '2021-03-18 03:03:15', '2021-03-18 10:51:37'),
(178, '53', '201', '23', 4, 15, 60, 1, '2021-03-18 05:59:29', '2021-03-18 10:51:30'),
(179, '53', '271', '18', 1, 15, 15, 1, '2021-03-18 05:59:29', '2021-03-18 10:51:31'),
(180, '54', '255', '11', 1, 85, 85, 1, '2021-03-18 06:13:27', '2021-03-18 10:51:31'),
(181, '54', '33', '7', 1, 295, 295, 1, '2021-03-18 06:13:27', '2021-03-18 10:51:37'),
(182, '54', '11', '3', 1, 205, 205, 1, '2021-03-18 06:13:28', '2021-03-18 10:51:37'),
(183, '54', '260', '11', 1, 85, 85, 1, '2021-03-18 06:13:28', '2021-03-18 10:51:31'),
(184, '55', '52', '13', 1, 95, 95, 1, '2021-03-18 06:19:18', '2021-03-18 10:51:31'),
(185, '55', '260', '11', 1, 85, 85, 1, '2021-03-18 06:19:19', '2021-03-18 10:51:31'),
(186, '55', '15', '4', 1, 100, 100, 1, '2021-03-18 06:19:19', '2021-03-18 10:51:37'),
(187, '55', '204', '23', 1, 60, 60, 1, '2021-03-18 06:19:19', '2021-03-18 10:51:31'),
(188, '55', '270', '18', 5, 60, 300, 1, '2021-03-18 06:19:19', '2021-03-18 10:51:31'),
(189, '56', '26', '6', 1, 185, 185, 1, '2021-03-18 06:20:25', '2021-03-18 10:51:37'),
(190, '56', '56', '14', 1, 50, 50, 1, '2021-03-18 06:20:26', '2021-03-18 10:51:31'),
(191, '57', '229', '25', 1, 50, 50, 1, '2021-03-18 06:22:19', '2021-03-18 10:51:34'),
(192, '57', '220', '25', 1, 60, 60, 1, '2021-03-18 06:22:20', '2021-03-18 10:51:34'),
(193, '57', '146', '18', 4, 20, 80, 1, '2021-03-18 06:22:20', '2021-03-18 10:51:31'),
(194, '58', '31', '7', 2, 195, 390, 1, '2021-03-18 06:24:00', '2021-03-18 10:51:37'),
(195, '58', '29', '6', 1, 195, 195, 1, '2021-03-18 06:24:01', '2021-03-18 10:51:37'),
(196, '58', '56', '14', 1, 50, 50, 1, '2021-03-18 06:24:01', '2021-03-18 10:51:31'),
(197, '58', '28', '6', 1, 185, 185, 1, '2021-03-18 06:24:01', '2021-03-18 10:51:37'),
(198, '58', '236', '25', 1, 240, 240, 1, '2021-03-18 06:24:01', '2021-03-18 10:51:34'),
(199, '58', '227', '25', 1, 80, 80, 1, '2021-03-18 06:24:01', '2021-03-18 10:51:34'),
(200, '59', '272', '25', 1, 180, 180, 1, '2021-03-18 06:30:52', '2021-03-18 10:51:34'),
(201, '60', '31', '7', 2, 195, 390, 1, '2021-03-18 06:31:55', '2021-03-18 10:51:37'),
(202, '60', '56', '14', 2, 50, 100, 1, '2021-03-18 06:31:55', '2021-03-18 10:51:31'),
(203, '61', '271', '18', 4, 15, 60, 1, '2021-03-18 07:10:11', '2021-03-18 10:51:31'),
(204, '61', '145', '18', 2, 20, 40, 1, '2021-03-18 07:10:11', '2021-03-18 10:51:31'),
(205, '62', '270', '18', 2, 60, 120, 1, '2021-03-18 07:12:08', '2021-03-18 10:51:31'),
(206, '62', '56', '14', 2, 50, 100, 1, '2021-03-18 07:12:08', '2021-03-18 10:51:31'),
(207, '63', '172', '20', 1, 100, 100, 1, '2021-03-18 07:24:18', '2021-03-18 10:51:31'),
(208, '63', '169', '20', 1, 85, 85, 1, '2021-03-18 07:24:18', '2021-03-18 10:51:31'),
(209, '63', '41', '10', 1, 65, 65, 1, '2021-03-18 07:24:18', '2021-03-18 10:51:37'),
(210, '64', '255', '11', 2, 85, 170, 1, '2021-03-18 07:29:02', '2021-03-18 10:51:31'),
(211, '64', '32', '7', 1, 200, 200, 1, '2021-03-18 07:29:02', '2021-03-18 10:51:37'),
(212, '64', '49', '13', 1, 75, 75, 1, '2021-03-18 07:29:02', '2021-03-18 10:51:31'),
(213, '64', '56', '14', 1, 50, 50, 1, '2021-03-18 07:29:02', '2021-03-18 10:51:31'),
(214, '64', '168', '20', 3, 100, 300, 1, '2021-03-18 07:29:02', '2021-03-18 10:51:31'),
(215, '64', '181', '21', 2, 25, 50, 1, '2021-03-18 07:29:02', '2021-03-18 10:51:31'),
(216, '65', '270', '18', 2, 60, 120, 1, '2021-03-18 07:30:36', '2021-03-18 10:51:31'),
(217, '66', '41', '10', 1, 65, 65, 1, '2021-03-18 07:32:21', '2021-03-18 10:51:37'),
(218, '66', '56', '14', 1, 50, 50, 1, '2021-03-18 07:32:21', '2021-03-18 10:51:31'),
(219, '68', '175', '20', 1, 100, 100, 1, '2021-03-18 07:35:07', '2021-03-18 10:51:31'),
(220, '68', '172', '20', 1, 100, 100, 1, '2021-03-18 07:35:07', '2021-03-18 10:51:31'),
(221, '68', '259', '11', 1, 85, 85, 1, '2021-03-18 07:35:07', '2021-03-18 10:51:31'),
(222, '68', '261', '11', 1, 95, 95, 1, '2021-03-18 07:35:07', '2021-03-18 10:51:31'),
(223, '68', '189', '22', 1, 70, 70, 1, '2021-03-18 07:35:07', '2021-03-18 10:51:31'),
(224, '69', '204', '23', 2, 60, 120, 1, '2021-03-18 07:45:45', '2021-03-18 10:51:31'),
(225, '70', '31', '7', 4, 195, 780, 1, '2021-03-18 08:04:00', '2021-03-18 10:51:37'),
(226, '70', '32', '7', 2, 200, 400, 1, '2021-03-18 08:04:00', '2021-03-18 10:51:37'),
(227, '70', '41', '10', 1, 65, 65, 1, '2021-03-18 08:04:00', '2021-03-18 10:51:37'),
(228, '70', '17', '4', 1, 195, 195, 1, '2021-03-18 08:04:00', '2021-03-18 10:51:37'),
(229, '70', '34', '8', 5, 205, 1025, 1, '2021-03-18 08:04:01', '2021-03-18 10:51:37'),
(230, '70', '11', '3', 1, 205, 205, 1, '2021-03-18 08:04:01', '2021-03-18 10:51:37'),
(231, '70', '33', '7', 1, 295, 295, 1, '2021-03-18 08:04:01', '2021-03-18 10:51:37'),
(232, '70', '269', '7', 1, 295, 295, 1, '2021-03-18 08:04:01', '2021-03-18 10:51:37'),
(233, '70', '56', '14', 4, 50, 200, 1, '2021-03-18 08:04:01', '2021-03-18 10:51:31'),
(234, '70', '260', '11', 3, 95, 265, 1, '2021-03-18 08:04:01', '2021-03-18 10:51:31'),
(235, '70', '259', '11', 4, 85, 340, 1, '2021-03-18 08:04:01', '2021-03-18 10:51:32'),
(236, '70', '261', '11', 1, 95, 95, 1, '2021-03-18 08:04:01', '2021-03-18 10:51:32'),
(237, '70', '7', '3', 1, 195, 195, 1, '2021-03-18 08:04:01', '2021-03-18 10:51:37'),
(238, '70', '81', '15', 1, 75, 75, 1, '2021-03-18 08:04:01', '2021-03-18 10:51:32'),
(239, '70', '52', '13', 6, 95, 570, 1, '2021-03-18 08:04:01', '2021-03-18 10:51:32'),
(240, '70', '273', '26', 2, 30, 60, 1, '2021-03-18 08:07:03', '2021-03-18 10:51:34'),
(241, '70', '274', '1', 3, 25, 75, 1, '2021-03-18 08:07:04', '2021-03-18 10:51:37'),
(242, '71', '80', '15', 1, 55, 55, 1, '2021-03-18 09:23:51', '2021-03-18 10:51:32'),
(243, '71', '201', '23', 3, 15, 45, 1, '2021-03-18 09:23:51', '2021-03-18 10:51:32'),
(244, '71', '145', '18', 9, 20, 180, 1, '2021-03-18 09:23:51', '2021-03-18 10:51:32'),
(245, '72', '57', '14', 2, 50, 100, 1, '2021-03-18 10:24:03', '2021-03-18 10:51:32'),
(246, '72', '113', '16', 1, 250, 250, 1, '2021-03-18 10:24:03', '2021-03-18 10:51:34'),
(247, '72', '114', '16', 1, 250, 250, 1, '2021-03-18 10:24:03', '2021-03-18 10:51:34'),
(248, '72', '96', '16', 1, 500, 500, 1, '2021-03-18 10:24:03', '2021-03-18 10:51:34'),
(249, '72', '94', '16', 1, 350, 350, 1, '2021-03-18 10:24:03', '2021-03-18 10:51:34'),
(250, '72', '122', '16', 1, 190, 190, 1, '2021-03-18 10:24:03', '2021-03-18 10:51:34'),
(251, '73', '27', '6', 2, 195, 390, 1, '2021-03-18 10:26:15', '2021-03-18 10:51:37'),
(252, '73', '261', '11', 1, 95, 95, 1, '2021-03-18 10:26:15', '2021-03-18 10:51:32'),
(253, '73', '46', '12', 1, 75, 75, 1, '2021-03-18 10:26:15', '2021-03-18 10:51:32'),
(254, '74', '52', '13', 1, 95, 95, 1, '2021-03-18 10:35:14', '2021-03-18 10:51:32'),
(255, '74', '16', '4', 1, 195, 195, 1, '2021-03-18 10:35:14', '2021-03-18 10:51:37'),
(256, '74', '59', '14', 1, 95, 95, 1, '2021-03-18 10:35:14', '2021-03-18 10:51:32'),
(257, '74', '21', '5', 1, 195, 195, 1, '2021-03-18 10:35:14', '2021-03-18 10:51:37'),
(258, '74', '271', '18', 2, 15, 30, 1, '2021-03-18 10:35:14', '2021-03-18 10:51:32'),
(259, '74', '244', '26', 1, 10, 10, 1, '2021-03-18 10:35:14', '2021-03-18 10:51:34'),
(260, '74', '247', '26', 1, 25, 25, 1, '2021-03-18 10:35:14', '2021-03-18 10:51:34'),
(261, '75', '56', '14', 2, 50, 100, 1, '2021-03-18 10:36:38', '2021-03-18 10:51:32'),
(262, '75', '204', '23', 2, 60, 120, 1, '2021-03-18 10:36:38', '2021-03-18 10:51:32'),
(263, '76', '201', '23', 4, 15, 60, 1, '2021-03-18 10:39:58', '2021-03-18 10:51:32'),
(264, '76', '145', '18', 3, 20, 60, 1, '2021-03-18 10:39:58', '2021-03-18 10:51:32'),
(265, '76', '56', '14', 1, 50, 50, 1, '2021-03-18 10:39:59', '2021-03-18 10:51:32'),
(266, '76', '66', '15', 1, 55, 55, 1, '2021-03-18 10:39:59', '2021-03-18 10:51:32'),
(267, '77', '201', '23', 10, 15, 150, 1, '2021-03-18 10:41:30', '2021-03-18 10:51:33'),
(268, '77', '110', '16', 1, 230, 230, 1, '2021-03-18 10:41:30', '2021-03-18 10:51:34'),
(269, '77', '147', '18', 1, 90, 90, 1, '2021-03-18 10:41:30', '2021-03-18 10:51:33'),
(270, '78', '151', '18', 1, 100, 100, 1, '2021-03-18 10:43:19', '2021-03-18 10:51:33'),
(271, '78', '152', '18', 1, 125, 125, 1, '2021-03-18 10:43:19', '2021-03-18 10:51:33'),
(272, '78', '44', '11', 1, 100, 100, 1, '2021-03-18 10:43:19', '2021-03-18 10:51:33'),
(273, '78', '123', '16', 1, 375, 375, 1, '2021-03-18 10:43:19', '2021-03-18 10:51:34'),
(274, '79', '41', '10', 3, 65, 195, 1, '2021-03-18 10:44:47', '2021-03-18 10:51:37'),
(275, '79', '56', '14', 1, 50, 50, 1, '2021-03-18 10:44:47', '2021-03-18 10:51:33'),
(276, '79', '66', '15', 1, 55, 55, 1, '2021-03-18 10:44:47', '2021-03-18 10:51:33'),
(277, '79', '244', '26', 1, 10, 10, 1, '2021-03-18 10:44:47', '2021-03-18 10:51:34'),
(278, '80', '15', '4', 2, 100, 200, 1, '2021-03-18 10:48:33', '2021-03-18 10:51:38'),
(279, '80', '26', '6', 2, 185, 370, 1, '2021-03-18 10:48:33', '2021-03-18 10:51:38'),
(280, '80', '56', '14', 4, 50, 200, 1, '2021-03-18 10:48:33', '2021-03-18 10:51:33'),
(281, '81', '56', '14', 2, 50, 100, 1, '2021-03-18 10:50:08', '2021-03-18 10:51:33'),
(282, '81', '270', '18', 1, 60, 60, 1, '2021-03-18 10:50:08', '2021-03-18 10:51:33'),
(283, '81', '181', '21', 1, 25, 25, 1, '2021-03-18 10:50:08', '2021-03-18 10:51:33'),
(284, '81', '182', '21', 1, 20, 20, 1, '2021-03-18 10:50:08', '2021-03-18 10:51:33'),
(285, '81', '261', '11', 1, 95, 95, 1, '2021-03-18 10:50:08', '2021-03-18 10:51:33'),
(286, '82', '72', '15', 1, 75, 75, 1, '2021-03-18 10:51:22', '2021-03-18 10:51:33'),
(287, '82', '52', '13', 1, 95, 95, 1, '2021-03-18 10:51:22', '2021-03-18 10:51:33'),
(288, '82', '270', '18', 1, 60, 60, 1, '2021-03-18 10:51:22', '2021-03-18 10:51:33'),
(289, '82', '201', '23', 3, 15, 45, 1, '2021-03-18 10:51:22', '2021-03-18 10:51:33');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `paymentId` bigint(20) UNSIGNED NOT NULL,
  `transactionId` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `totalAmount` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenderedAmount` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `change` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`paymentId`, `transactionId`, `customer`, `totalAmount`, `discount`, `tenderedAmount`, `change`, `created_at`, `updated_at`) VALUES
(10, '14', 'a', '465', '', '465', '0', '2021-03-16 22:19:06', '2021-03-16 22:19:06'),
(11, '15', 'a', '415', '', '515', '100', '2021-03-16 22:22:28', '2021-03-16 22:22:28'),
(12, '16', 'a', '335', '', '430', '95', '2021-03-16 22:34:38', '2021-03-16 22:34:38'),
(13, '15', 'a', '515', '', '515', '0', '2021-03-16 23:02:42', '2021-03-16 23:02:42'),
(14, '17', 'A', '765', '', '765', '0', '2021-03-16 23:32:59', '2021-03-16 23:32:59'),
(15, '18', 'A', '15', '', '15', '0', '2021-03-16 23:34:48', '2021-03-16 23:34:48'),
(16, '19', 'C', '260', '', '260', '0', '2021-03-16 23:36:33', '2021-03-16 23:36:33'),
(17, '20', 'n', '470', '', '470', '0', '2021-03-16 23:41:36', '2021-03-16 23:41:36'),
(18, '21', 'n', '285', '', '285', '0', '2021-03-16 23:45:25', '2021-03-16 23:45:25'),
(19, '22', 'b', '725', '', '725', '0', '2021-03-16 23:47:29', '2021-03-16 23:47:29'),
(20, '23', 'a', '465', '', '465', '0', '2021-03-16 23:49:25', '2021-03-16 23:49:25'),
(21, '24', 'n', '790', '', '800', '10', '2021-03-16 23:55:10', '2021-03-16 23:55:10'),
(22, '26', 'j', '260', '', '260', '0', '2021-03-17 00:03:04', '2021-03-17 00:03:04'),
(23, '27', 'h', '490', '', '490', '0', '2021-03-17 00:04:06', '2021-03-17 00:04:06'),
(24, '28', 'tyi', '580', '', '570', '10', '2021-03-17 00:05:34', '2021-03-17 00:05:34'),
(25, '29', 'h', '370', '', '370', '0', '2021-03-17 00:06:37', '2021-03-17 00:06:37'),
(26, '30', 'gh', '540', '', '540', '98', '2021-03-17 00:08:26', '2021-03-17 00:08:26'),
(27, '31', 'jh', '575', '', '575', '0', '2021-03-17 00:12:32', '2021-03-17 00:12:32'),
(28, '32', 'gh', '530', '', '530', '0', '2021-03-17 00:14:18', '2021-03-17 00:14:18'),
(29, '33', 'hjk', '225', '', '225', '0', '2021-03-17 00:15:14', '2021-03-17 00:15:14'),
(30, '34', 'g', '380', '', '380', '0', '2021-03-17 00:17:18', '2021-03-17 00:17:18'),
(31, '35', 'gh', '325', '', '325', '0', '2021-03-17 00:18:39', '2021-03-17 00:18:39'),
(32, '36', 'h', '715', '', '715', '0', '2021-03-17 00:21:48', '2021-03-17 00:21:48'),
(33, '37', 'f', '465', '', '465', '0', '2021-03-17 00:22:45', '2021-03-17 00:22:45'),
(34, '38', 'j', '85', '', '130', '45', '2021-03-17 00:23:47', '2021-03-17 00:23:47'),
(35, '39', 'h', '160', '', '160', '0', '2021-03-17 00:26:20', '2021-03-17 00:26:20'),
(36, '40', 'y', '145', '', '145', '0', '2021-03-17 00:26:34', '2021-03-17 00:26:34'),
(37, '41', 's', '200', '', '200', '0', '2021-03-17 00:29:27', '2021-03-17 00:29:27'),
(39, '44', 'n', '1325', '178', '1500', '353', '2021-03-18 02:15:48', '2021-03-18 02:15:48'),
(41, '46', 'a', '460', '0', '460', '0', '2021-03-18 02:25:38', '2021-03-18 02:25:38'),
(42, '47', 'l', '145', '0', '145', '0', '2021-03-18 02:31:41', '2021-03-18 02:31:41'),
(43, '48', 'g', '80', '0', '80', '0', '2021-03-18 02:43:06', '2021-03-18 02:43:06'),
(44, '49', 'w', '795', '0', '795', '0', '2021-03-18 02:45:43', '2021-03-18 02:45:43'),
(45, '50', 'u', '900', '0', '900', '0', '2021-03-18 02:47:12', '2021-03-18 02:47:12'),
(46, '51', 'A', '225', '20', '505', '300', '2021-03-18 03:01:22', '2021-03-18 03:01:22'),
(47, '52', 'E', '1170', '0', '2000', '830', '2021-03-18 03:03:47', '2021-03-18 03:03:47'),
(48, '53', 'a', '75', '0', '75', '0', '2021-03-18 05:59:58', '2021-03-18 05:59:58'),
(49, '54', 'f', '670', '0', '700', '30', '2021-03-18 06:15:28', '2021-03-18 06:15:28'),
(50, '55', 'y', '640', '0', '640', '0', '2021-03-18 06:19:50', '2021-03-18 06:19:50'),
(51, '56', 'k', '235', '0', '235', '0', '2021-03-18 06:20:55', '2021-03-18 06:20:55'),
(52, '57', 'j', '190', '0', '190', '0', '2021-03-18 06:22:51', '2021-03-18 06:22:51'),
(53, '58', 'y', '1140', '0', '1140', '0', '2021-03-18 06:24:44', '2021-03-18 06:24:44'),
(54, '59', 'r', '180', '0', '180', '0', '2021-03-18 06:31:11', '2021-03-18 06:31:11'),
(55, '60', 'h', '490', '0', '490', '0', '2021-03-18 06:32:15', '2021-03-18 06:32:15'),
(56, '61', 'ry', '100', '0', '100', '0', '2021-03-18 07:10:54', '2021-03-18 07:10:54'),
(57, '62', 'ry', '220', '0', '220', '0', '2021-03-18 07:12:30', '2021-03-18 07:12:30'),
(58, '63', 'ry', '250', '0', '250', '0', '2021-03-18 07:24:48', '2021-03-18 07:24:48'),
(59, '64', 'y', '845', '0', '845', '0', '2021-03-18 07:29:42', '2021-03-18 07:29:42'),
(60, '65', 'r', '120', '24', '120', '24', '2021-03-18 07:31:35', '2021-03-18 07:31:35'),
(61, '66', 'ry', '115', '0', '115', '0', '2021-03-18 07:33:50', '2021-03-18 07:33:50'),
(62, '68', 'wr', '450', '0', '450', '0', '2021-03-18 07:35:49', '2021-03-18 07:35:49'),
(63, '69', 'gj', '120', '12', '120', '12', '2021-03-18 07:46:11', '2021-03-18 07:46:11'),
(64, '70', 'gj', '5125', '200', '5135', '210', '2021-03-18 08:09:56', '2021-03-18 08:09:56'),
(65, '70', 'gy', '5135', '200', '5135', '200', '2021-03-18 08:31:59', '2021-03-18 08:31:59'),
(66, '71', 'ry', '280', '0', '280', '0', '2021-03-18 09:24:27', '2021-03-18 09:24:27'),
(67, '65', 'gy', '120', '24', '120', '24', '2021-03-18 09:44:31', '2021-03-18 09:44:31'),
(68, '72', 'ry', '1640', '0', '1640', '0', '2021-03-18 10:24:49', '2021-03-18 10:24:49'),
(69, '73', 'lo', '560', '0', '560', '0', '2021-03-18 10:26:49', '2021-03-18 10:26:49'),
(70, '74', 'lo', '645', '64', '645', '64', '2021-03-18 10:35:53', '2021-03-18 10:35:53'),
(71, '75', 'li', '220', '0', '220', '0', '2021-03-18 10:37:04', '2021-03-18 10:37:04'),
(72, '76', 'my', '225', '0', '225', '0', '2021-03-18 10:40:29', '2021-03-18 10:40:29'),
(73, '77', 'by', '470', '0', '470', '0', '2021-03-18 10:42:07', '2021-03-18 10:42:07'),
(74, '78', 'po', '700', '0', '700', '0', '2021-03-18 10:43:46', '2021-03-18 10:43:46'),
(75, '79', 'gy', '245', '0', '310', '65', '2021-03-18 10:45:13', '2021-03-18 10:45:13'),
(76, '79', 'gy', '310', '0', '310', '0', '2021-03-18 10:47:36', '2021-03-18 10:47:36'),
(77, '80', 'fe', '770', '0', '770', '0', '2021-03-18 10:48:56', '2021-03-18 10:48:56'),
(78, '81', 'ry', '300', '0', '300', '0', '2021-03-18 10:50:30', '2021-03-18 10:50:30'),
(79, '82', 'fy', '275', '0', '275', '0', '2021-03-18 10:51:40', '2021-03-18 10:51:40');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `roleName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `roleName`, `permission`, `isAdmin`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '[{\"resourceName\":\"Kitchen Dashboard\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"kitchen_dashboard\",\"icon\":\"ios-restaurant\"},{\"resourceName\":\"Bar Dashboard\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"bar_dashboard\",\"icon\":\"ios-wine\"},{\"resourceName\":\"Cashier Dashboard\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"dashboard\",\"icon\":\"ios-cash\"},{\"resourceName\":\"Outsourced Dashboard\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"outsourced_dashboard\",\"icon\":\"ios-repeat\"},{\"resourceName\":\"Reports\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"reports\",\"icon\":\"ios-filing\"},{\"resourceName\":\"Inventory Record\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"inventory\",\"icon\":\"ios-list-box\"},{\"resourceName\":\"Category\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"category\",\"icon\":\"ios-apps\"},{\"resourceName\":\"Department\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"department\",\"icon\":\"ios-people\"},{\"resourceName\":\"Item\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"item\",\"icon\":\"ios-pricetags\"},{\"resourceName\":\"Table\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"table\",\"icon\":\"ios-radio-button-off\"},{\"resourceName\":\"Device\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"device\",\"icon\":\"ios-desktop\"},{\"resourceName\":\"Expense\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"expense\",\"icon\":\"ios-cash-outline\"},{\"resourceName\":\"Account Expense\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"account_expense\",\"icon\":\"ios-book-outline\"},{\"resourceName\":\"Cash In\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"cashin\",\"icon\":\"ios-cash\"},{\"resourceName\":\"Cash Out\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"cashout\",\"icon\":\"md-cash\"},{\"resourceName\":\"User\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"user\",\"icon\":\"ios-contact\"},{\"resourceName\":\"Role\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"role\",\"icon\":\"ios-body\"},{\"resourceName\":\"Assign Role\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"assignRole\",\"icon\":\"ios-clipboard\"}]', 1, NULL, '2021-03-03 10:39:34', '2021-03-14 16:26:14'),
(2, 'Kitchen', '[{\"resourceName\":\"Kitchen Dashboard\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"kitchen_dashboard\",\"icon\":\"ios-restaurant\"},{\"resourceName\":\"Bar Dashboard\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"bar_dashboard\",\"icon\":\"ios-wine\"},{\"resourceName\":\"Cashier Dashboard\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"dashboard\",\"icon\":\"ios-cash\"},{\"resourceName\":\"Outsourced Dashboard\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"outsourced_dashboard\",\"icon\":\"ios-repeat\"},{\"resourceName\":\"Reports\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"reports\",\"icon\":\"ios-filing\"},{\"resourceName\":\"Inventory Record\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"inventory\",\"icon\":\"ios-list-box\"},{\"resourceName\":\"Category\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"category\",\"icon\":\"ios-apps\"},{\"resourceName\":\"Department\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"department\",\"icon\":\"ios-people\"},{\"resourceName\":\"Item\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"item\",\"icon\":\"ios-pricetags\"},{\"resourceName\":\"Table\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"table\",\"icon\":\"ios-radio-button-off\"},{\"resourceName\":\"Device\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"device\",\"icon\":\"ios-desktop\"},{\"resourceName\":\"Expense\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"expense\",\"icon\":\"ios-cash-outline\"},{\"resourceName\":\"Account Expense\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"account_expense\",\"icon\":\"ios-book-outline\"},{\"resourceName\":\"Cash In\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"cashin\",\"icon\":\"ios-cash\"},{\"resourceName\":\"Cash Out\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"cashout\",\"icon\":\"md-cash\"},{\"resourceName\":\"User\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"user\",\"icon\":\"ios-contact\"},{\"resourceName\":\"Role\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"role\",\"icon\":\"ios-body\"},{\"resourceName\":\"Assign Role\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"assignRole\",\"icon\":\"ios-clipboard\"}]', 0, NULL, '2021-03-04 13:12:50', '2021-03-15 18:44:10'),
(3, 'Bar', '[{\"resourceName\":\"Kitchen Dashboard\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"kitchen_dashboard\",\"icon\":\"ios-restaurant\"},{\"resourceName\":\"Bar Dashboard\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"bar_dashboard\",\"icon\":\"ios-wine\"},{\"resourceName\":\"Cashier Dashboard\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"dashboard\",\"icon\":\"ios-cash\"},{\"resourceName\":\"Outsourced Dashboard\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"outsourced_dashboard\",\"icon\":\"ios-repeat\"},{\"resourceName\":\"Reports\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"reports\",\"icon\":\"ios-filing\"},{\"resourceName\":\"Inventory Record\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"inventory\",\"icon\":\"ios-list-box\"},{\"resourceName\":\"Category\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"category\",\"icon\":\"ios-apps\"},{\"resourceName\":\"Department\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"department\",\"icon\":\"ios-people\"},{\"resourceName\":\"Item\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"item\",\"icon\":\"ios-pricetags\"},{\"resourceName\":\"Table\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"table\",\"icon\":\"ios-radio-button-off\"},{\"resourceName\":\"Device\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"device\",\"icon\":\"ios-desktop\"},{\"resourceName\":\"Expense\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"expense\",\"icon\":\"ios-cash-outline\"},{\"resourceName\":\"Account Expense\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"account_expense\",\"icon\":\"ios-book-outline\"},{\"resourceName\":\"Cash In\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"cashin\",\"icon\":\"ios-cash\"},{\"resourceName\":\"Cash Out\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"cashout\",\"icon\":\"md-cash\"},{\"resourceName\":\"User\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"user\",\"icon\":\"ios-contact\"},{\"resourceName\":\"Role\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"role\",\"icon\":\"ios-body\"},{\"resourceName\":\"Assign Role\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"assignRole\",\"icon\":\"ios-clipboard\"}]', 0, NULL, '2021-03-04 13:12:55', '2021-03-14 17:03:09'),
(4, 'Cashier', '[{\"resourceName\":\"Kitchen Dashboard\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"kitchen_dashboard\",\"icon\":\"ios-restaurant\"},{\"resourceName\":\"Bar Dashboard\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"bar_dashboard\",\"icon\":\"ios-wine\"},{\"resourceName\":\"Cashier Dashboard\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"dashboard\",\"icon\":\"ios-cash\"},{\"resourceName\":\"Outsourced Dashboard\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"outsourced_dashboard\",\"icon\":\"ios-repeat\"},{\"resourceName\":\"Reports\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"reports\",\"icon\":\"ios-filing\"},{\"resourceName\":\"Inventory Record\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"inventory\",\"icon\":\"ios-list-box\"},{\"resourceName\":\"Category\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"category\",\"icon\":\"ios-apps\"},{\"resourceName\":\"Department\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"department\",\"icon\":\"ios-people\"},{\"resourceName\":\"Item\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"item\",\"icon\":\"ios-pricetags\"},{\"resourceName\":\"Table\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"table\",\"icon\":\"ios-radio-button-off\"},{\"resourceName\":\"Device\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"device\",\"icon\":\"ios-desktop\"},{\"resourceName\":\"Expense\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"expense\",\"icon\":\"ios-cash-outline\"},{\"resourceName\":\"Account Expense\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"account_expense\",\"icon\":\"ios-book-outline\"},{\"resourceName\":\"Cash In\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"cashin\",\"icon\":\"ios-cash\"},{\"resourceName\":\"Cash Out\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"cashout\",\"icon\":\"md-cash\"},{\"resourceName\":\"User\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"user\",\"icon\":\"ios-contact\"},{\"resourceName\":\"Role\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"role\",\"icon\":\"ios-body\"},{\"resourceName\":\"Assign Role\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"assignRole\",\"icon\":\"ios-clipboard\"}]', 0, NULL, '2021-03-04 13:13:03', '2021-03-14 13:43:34'),
(5, 'Outsource', '[{\"resourceName\":\"Kitchen Dashboard\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"kitchen_dashboard\",\"icon\":\"ios-restaurant\"},{\"resourceName\":\"Bar Dashboard\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"bar_dashboard\",\"icon\":\"ios-wine\"},{\"resourceName\":\"Cashier Dashboard\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"dashboard\",\"icon\":\"ios-cash\"},{\"resourceName\":\"Outsourced Dashboard\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"outsourced_dashboard\",\"icon\":\"ios-repeat\"},{\"resourceName\":\"Reports\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"reports\",\"icon\":\"ios-filing\"},{\"resourceName\":\"Inventory Record\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"inventory\",\"icon\":\"ios-list-box\"},{\"resourceName\":\"Category\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"category\",\"icon\":\"ios-apps\"},{\"resourceName\":\"Department\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"department\",\"icon\":\"ios-people\"},{\"resourceName\":\"Item\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"item\",\"icon\":\"ios-pricetags\"},{\"resourceName\":\"Table\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"table\",\"icon\":\"ios-radio-button-off\"},{\"resourceName\":\"Device\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"device\",\"icon\":\"ios-desktop\"},{\"resourceName\":\"Expense\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"expense\",\"icon\":\"ios-cash-outline\"},{\"resourceName\":\"Account Expense\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"account_expense\",\"icon\":\"ios-book-outline\"},{\"resourceName\":\"Cash In\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"cashin\",\"icon\":\"ios-cash\"},{\"resourceName\":\"Cash Out\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"cashout\",\"icon\":\"md-cash\"},{\"resourceName\":\"User\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"user\",\"icon\":\"ios-contact\"},{\"resourceName\":\"Role\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"role\",\"icon\":\"ios-body\"},{\"resourceName\":\"Assign Role\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"assignRole\",\"icon\":\"ios-clipboard\"}]', 0, NULL, '2021-03-04 13:13:09', '2021-03-14 13:44:31'),
(6, 'Waiter', '[{\"resourceName\":\"Kitchen Dashboard\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"kitchen_dashboard\",\"icon\":\"ios-restaurant\"},{\"resourceName\":\"Bar Dashboard\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"bar_dashboard\",\"icon\":\"ios-wine\"},{\"resourceName\":\"Cashier Dashboard\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"dashboard\",\"icon\":\"ios-cash\"},{\"resourceName\":\"Outsourced Dashboard\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"outsourced_dashboard\",\"icon\":\"ios-repeat\"},{\"resourceName\":\"Reports\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"reports\",\"icon\":\"ios-filing\"},{\"resourceName\":\"Inventory Record\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"inventory\",\"icon\":\"ios-list-box\"},{\"resourceName\":\"Category\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"category\",\"icon\":\"ios-apps\"},{\"resourceName\":\"Department\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"department\",\"icon\":\"ios-people\"},{\"resourceName\":\"Item\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"item\",\"icon\":\"ios-pricetags\"},{\"resourceName\":\"Table\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"table\",\"icon\":\"ios-radio-button-off\"},{\"resourceName\":\"Device\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"device\",\"icon\":\"ios-desktop\"},{\"resourceName\":\"Expense\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"expense\",\"icon\":\"ios-cash-outline\"},{\"resourceName\":\"Account Expense\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"account_expense\",\"icon\":\"ios-book-outline\"},{\"resourceName\":\"Cash In\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"cashin\",\"icon\":\"ios-cash\"},{\"resourceName\":\"Cash Out\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"cashout\",\"icon\":\"md-cash\"},{\"resourceName\":\"User\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"user\",\"icon\":\"ios-contact\"},{\"resourceName\":\"Role\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"role\",\"icon\":\"ios-body\"},{\"resourceName\":\"Assign Role\",\"read\":false,\"write\":false,\"update\":false,\"delete\":false,\"name\":\"assignRole\",\"icon\":\"ios-clipboard\"}]', 0, NULL, '2021-03-10 10:47:06', '2021-03-14 13:44:54');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `tableId` bigint(20) UNSIGNED NOT NULL,
  `tableNumber` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tableName` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tableDescription` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tableCapacity` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tableUse` char(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y' COMMENT 'Y/N',
  `tableIsDeleted` char(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Y/N',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`tableId`, `tableNumber`, `tableName`, `tableDescription`, `tableCapacity`, `tableUse`, `tableIsDeleted`, `created_at`, `updated_at`) VALUES
(1, '1', 'ALFRESCO TABLE 1', 'ALFRESCO TABLE 1', '5', 'Y', 'N', '2021-03-02 11:53:04', '2021-03-16 16:50:25'),
(2, '2', 'ALFRESCO TABLE 2', 'ALFRESCO TABLE 2', '2', 'Y', 'N', '2021-03-02 12:41:14', '2021-03-16 16:50:46'),
(3, '3', 'ALFRESCO TABLE 3', 'ALFRESCO TABLE 23', '2', 'Y', 'N', '2021-03-02 12:56:50', '2021-03-16 16:50:55'),
(4, '4', 'ALFRESCO TABLE 4', 'ALFRESCO TABLE 4', '4', 'Y', 'N', '2021-03-02 15:54:33', '2021-03-16 16:51:04'),
(5, '5', 'ALFRESCO TABLE 5', 'ALFRESCO TABLE 5', '5', 'Y', 'N', '2021-03-16 16:51:16', '2021-03-16 16:51:16'),
(6, '6', 'ALFRESCO TABLE 6', 'ALFRESCO TABLE 6', '5', 'Y', 'N', '2021-03-16 16:51:25', '2021-03-16 16:51:25'),
(7, '7', 'ALFRESCO TABLE 7', 'ALFRESCO TABLE 7', '5', 'Y', 'N', '2021-03-16 16:51:34', '2021-03-16 16:51:34'),
(8, '8', 'ALFRESCO TABLE 8', 'ALFRESCO TABLE 8', '5', 'Y', 'N', '2021-03-16 16:51:45', '2021-03-16 16:51:45'),
(9, '9', 'ALFRESCO TABLE 9', 'ALFRESCO TABLE 9', '9', 'Y', 'N', '2021-03-16 16:52:04', '2021-03-16 16:52:04'),
(10, '10', 'ALFRESCO TABLE 10', 'ALFRESCO TABLE 10', '9', 'Y', 'N', '2021-03-16 16:52:14', '2021-03-16 16:52:14'),
(11, '11', 'ALFRESCO TABLE 11', 'ALFRESCO TABLE 11', '9', 'Y', 'N', '2021-03-16 16:52:22', '2021-03-16 16:52:22'),
(12, '12', 'ALFRESCO TABLE 12', 'ALFRESCO TABLE 12', '9', 'Y', 'N', '2021-03-16 16:52:31', '2021-03-16 16:52:31'),
(13, '13', 'ALFRESCO TABLE 13', 'ALFRESCO TABLE 13', '9', 'Y', 'N', '2021-03-16 16:52:42', '2021-03-16 16:52:42'),
(14, '14', 'ALFRESCO TABLE 14', 'ALFRESCO TABLE 14', '9', 'Y', 'N', '2021-03-16 16:52:50', '2021-03-16 16:52:50'),
(15, '1', 'BIG HALL 1', 'BIG HALL 1', '1', 'Y', 'N', '2021-03-16 16:53:13', '2021-03-16 16:53:13'),
(16, '2', 'BIG HALL 2', 'BIG HALL 2', '1', 'Y', 'N', '2021-03-16 16:53:21', '2021-03-16 16:53:21'),
(17, '3', 'BIG HALL 3', 'BIG HALL 3', '1', 'Y', 'N', '2021-03-16 16:53:29', '2021-03-16 16:53:29'),
(18, '4', 'BIG HALL 4', 'BIG HALL 4', '1', 'Y', 'N', '2021-03-16 16:53:39', '2021-03-16 16:53:39'),
(19, '5', 'BIG HALL 5', 'BIG HALL 5', '1', 'Y', 'N', '2021-03-16 16:53:46', '2021-03-16 16:53:46'),
(20, '1', 'SMALL HALL 1', 'SMALL HALL 1', '1', 'Y', 'N', '2021-03-16 16:54:03', '2021-03-16 16:54:03'),
(21, '2', 'SMALL HALL 2', 'SMALL HALL 2', '1', 'Y', 'N', '2021-03-16 16:54:12', '2021-03-16 16:54:12'),
(22, '3', 'SMALL HALL 3', 'SMALL HALL 3', '1', 'Y', 'N', '2021-03-16 16:54:19', '2021-03-16 16:54:19'),
(23, '4', 'SMALL HALL 4', 'SMALL HALL 4', '1', 'Y', 'N', '2021-03-16 16:54:27', '2021-03-16 16:54:27'),
(24, '5', 'SMALL HALL 5', 'SMALL HALL 5', '1', 'Y', 'N', '2021-03-16 16:54:35', '2021-03-16 16:54:35'),
(25, '1', 'MINI HALL', 'MINI HALL', '1', 'Y', 'N', '2021-03-16 16:55:13', '2021-03-16 16:55:13'),
(26, '1', 'DINING AREA 1', 'DINING AREA 1', '1', 'Y', 'N', '2021-03-16 16:55:25', '2021-03-16 16:55:25'),
(27, '1', 'DINING AREA 2', 'DINING AREA 2', '1', 'Y', 'N', '2021-03-16 16:55:31', '2021-03-16 16:55:31'),
(28, '3', 'DINING AREA 3', 'DINING AREA 3', '1', 'Y', 'N', '2021-03-16 16:55:48', '2021-03-16 16:55:48'),
(29, '4', 'DINING AREA 4', 'DINING AREA 4', '1', 'Y', 'N', '2021-03-16 16:55:56', '2021-03-16 16:55:56'),
(30, '5', 'DINING AREA 5', 'DINING AREA 5', '1', 'Y', 'N', '2021-03-16 16:56:03', '2021-03-16 16:56:03'),
(31, '6', 'DINING AREA 6', 'DINING AREA 6', '6', 'Y', 'N', '2021-03-18 06:14:41', '2021-03-18 06:14:41');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transactionId` bigint(20) UNSIGNED NOT NULL,
  `transactionUserId` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionSlipNo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionNote` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionTableId` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionServedBy` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionStatus` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionKitchenStatus` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionBarStatus` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionOutsourcedStatus` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transactionId`, `transactionUserId`, `transactionSlipNo`, `transactionNote`, `transactionTableId`, `transactionServedBy`, `transactionStatus`, `transactionKitchenStatus`, `transactionBarStatus`, `transactionOutsourcedStatus`, `created_at`, `updated_at`) VALUES
(10, '4', '638', '', '1', 'JANET', 'Available', 'Processing', 'Served', 'Processing', '2021-03-16 19:26:14', '2021-03-16 19:27:38'),
(11, '4', '525', '', '1', 'JANET', 'Available', 'Served', 'Served', 'Processing', '2021-03-16 19:29:59', '2021-03-16 19:30:34'),
(12, '4', '958', '', '1', 'JANET', 'Available', 'Served', 'Served', 'Pending', '2021-03-16 19:38:09', '2021-03-16 19:39:13'),
(13, '4', '525', '', '1', 'JANET', 'Available', 'Processing', 'Processing', 'Processing', '2021-03-16 19:46:10', '2021-03-16 19:46:31'),
(14, '4', '695', '', '29', 'JANET', 'Available', 'Served', 'Served', 'Processing', '2021-03-16 22:12:36', '2021-03-16 22:19:06'),
(15, '4', '527', '', '30', 'JANET', 'Available', 'Served', 'Served', 'Processing', '2021-03-16 22:21:37', '2021-03-16 23:02:42'),
(16, '4', '573', '', '1', 'DEBBIE', 'Available', 'Processing', 'Served', 'Processing', '2021-03-16 22:33:26', '2021-03-16 22:34:38'),
(17, '4', '525', '', '1', 'JANET', 'Available', 'Served', 'Served', 'Processing', '2021-03-16 23:32:06', '2021-03-16 23:32:59'),
(18, '4', '638', '', '1', 'JANET', 'Available', 'Processing', 'Served', 'Processing', '2021-03-16 23:34:32', '2021-03-16 23:34:48'),
(19, '4', '595', '', '2', 'DEBBIE', 'Available', 'Served', 'Served', 'Processing', '2021-03-16 23:35:46', '2021-03-16 23:36:33'),
(20, '4', '573', '', '1', 'LOMARIE', 'Available', 'Served', 'Served', 'Processing', '2021-03-16 23:41:09', '2021-03-16 23:41:36'),
(21, '4', '565', '', '4', 'KEMUEL', 'Available', 'Served', 'Served', 'Processing', '2021-03-16 23:44:51', '2021-03-16 23:45:25'),
(22, '4', '014', '', '4', 'GANI', 'Available', 'Processing', 'Served', 'Processing', '2021-03-16 23:46:49', '2021-03-16 23:47:29'),
(23, '4', '600', '', '4', 'GANI', 'Available', 'Processing', 'Served', 'Processing', '2021-03-16 23:48:52', '2021-03-16 23:49:25'),
(24, '4', '569', '', '3', 'LOMARIE', 'Available', 'Served', 'Served', 'Processing', '2021-03-16 23:54:42', '2021-03-16 23:55:10'),
(26, '4', '959', '', '6', 'JANET', 'Available', 'Served', 'Served', 'Processing', '2021-03-16 23:59:29', '2021-03-17 00:03:04'),
(27, '4', '543', '', '30', 'KEMUEL', 'Available', 'Served', 'Served', 'Processing', '2021-03-17 00:03:41', '2021-03-17 00:04:06'),
(28, '4', '572', '', '14', 'LOMARIE', 'Available', 'Served', 'Served', 'Processing', '2021-03-17 00:05:01', '2021-03-17 00:05:34'),
(29, '4', '571', '', '6', 'LOMARIE', 'Available', 'Served', 'Served', 'Processing', '2021-03-17 00:06:15', '2021-03-17 00:06:37'),
(30, '4', '545', '', '2', 'DEBBIE', 'Available', 'Processing', 'Served', 'Processing', '2021-03-17 00:07:26', '2021-03-17 00:08:26'),
(31, '4', '568', '', '4', 'LOMARIE', 'Available', 'Processing', 'Served', 'Processing', '2021-03-17 00:12:08', '2021-03-17 00:12:32'),
(32, '4', '567', '', '1', 'DEBBIE', 'Available', 'Served', 'Served', 'Processing', '2021-03-17 00:13:48', '2021-03-17 00:14:18'),
(33, '4', '547', '', '2', 'JANET', 'Available', 'Processing', 'Served', 'Processing', '2021-03-17 00:14:55', '2021-03-17 00:15:14'),
(34, '4', '526', '', '2', 'LOMARIE', 'Available', 'Served', 'Served', 'Processing', '2021-03-17 00:16:56', '2021-03-17 00:17:18'),
(35, '4', '960', '', '3', 'JANET', 'Available', 'Served', 'Served', 'Processing', '2021-03-17 00:18:04', '2021-03-17 00:18:39'),
(36, '4', '527', '', '3', 'DEBBIE', 'Available', 'Served', 'Served', 'Processing', '2021-03-17 00:21:18', '2021-03-17 00:21:48'),
(37, '4', '659', '', '3', 'JANET', 'Available', 'Served', 'Served', 'Processing', '2021-03-17 00:22:21', '2021-03-17 00:22:45'),
(38, '4', '444', '', '2', 'DEBBIE', 'Available', 'Served', 'Served', 'Processing', '2021-03-17 00:23:24', '2021-03-17 00:23:47'),
(39, '4', '6666', '', '1', 'JANET', 'Available', 'Processing', 'Served', 'Processing', '2021-03-17 00:24:04', '2021-03-17 00:26:20'),
(40, '4', '6667', '', '3', 'DEBBIE', 'Available', 'Processing', 'Served', 'Processing', '2021-03-17 00:25:23', '2021-03-17 00:26:34'),
(41, '4', '6666', '', '5', 'DEBBIE', 'Available', 'Served', 'Processing', 'Processing', '2021-03-17 00:29:11', '2021-03-17 00:29:27'),
(42, '4', '668', '', '1', 'JANET', 'Available', 'Processing', 'Served', 'Processing', '2021-03-17 00:49:13', '2021-03-17 00:49:32'),
(44, '4', '534', '', '20', 'JANET', 'Available', 'Served', 'Served', 'Pending', '2021-03-18 02:14:21', '2021-03-18 02:15:49'),
(46, '4', '654654654', '', '1', 'JANET', 'Available', 'Processing', 'Served', 'Pending', '2021-03-18 02:25:14', '2021-03-18 02:25:38'),
(47, '4', '553', '', '5', 'JANET', 'Available', 'Processing', 'Served', 'Processing', '2021-03-18 02:31:17', '2021-03-18 02:31:41'),
(48, '4', '016', '', '19', 'DEBBIE', 'Available', 'Processing', 'Served', 'Processing', '2021-03-18 02:42:34', '2021-03-18 02:43:06'),
(49, '4', '015', '', '12', 'LOMARIE', 'Available', 'Served', 'Processing', 'Processing', '2021-03-18 02:44:35', '2021-03-18 02:45:43'),
(50, '4', '639', '', '26', 'EUGENE', 'Available', 'Served', 'Served', 'Processing', '2021-03-18 02:46:33', '2021-03-18 02:47:12'),
(51, '4', '666', '', '1', 'EUGENE', 'Available', 'Processing', 'Served', 'Processing', '2021-03-18 03:00:54', '2021-03-18 03:01:22'),
(52, '4', '577', '', '1', 'LOMARIE', 'Available', 'Served', 'Processing', 'Processing', '2021-03-18 03:03:15', '2021-03-18 03:03:47'),
(53, '4', '661', NULL, '1', 'JANET', 'Available', 'Processing', 'Processing', 'Processing', '2021-03-18 05:59:29', '2021-03-18 05:59:58'),
(54, '4', '641', NULL, '30', 'DEBBIE', 'Available', 'Served', 'Served', 'Processing', '2021-03-18 06:13:27', '2021-03-18 06:15:28'),
(55, '4', '536', NULL, '27', 'LOMARIE', 'Available', 'Served', 'Processing', 'Processing', '2021-03-18 06:19:18', '2021-03-18 06:19:50'),
(56, '4', '019', NULL, '26', 'JANET', 'Available', 'Served', 'Served', 'Processing', '2021-03-18 06:20:25', '2021-03-18 06:20:55'),
(57, '4', '5555', NULL, '29', 'JANET', 'Available', 'Processing', 'Served', 'Processing', '2021-03-18 06:22:19', '2021-03-18 06:22:51'),
(58, '4', '017', NULL, '29', 'KEMUEL', 'Available', 'Served', 'Served', 'Processing', '2021-03-18 06:24:00', '2021-03-18 06:24:44'),
(59, '4', '444', NULL, '27', 'LOMARIE', 'Available', 'Processing', 'Served', 'Processing', '2021-03-18 06:30:52', '2021-03-18 06:31:11'),
(60, '4', '020', NULL, '26', 'GANI', 'Available', 'Served', 'Processing', 'Processing', '2021-03-18 06:31:55', '2021-03-18 06:32:15'),
(61, '15', '642', NULL, '31', 'GANI', 'Available', 'Processing', 'Served', 'Processing', '2021-03-18 07:10:11', '2021-03-18 07:10:54'),
(62, '15', '641', NULL, '28', 'GANI', 'Available', 'Processing', 'Served', 'Processing', '2021-03-18 07:12:08', '2021-03-18 07:12:30'),
(63, '15', '644', NULL, '26', 'JANET', 'Available', 'Served', 'Served', 'Processing', '2021-03-18 07:24:18', '2021-03-18 07:24:48'),
(64, '15', '642', NULL, '13', 'GANI', 'Available', 'Served', 'Served', 'Processing', '2021-03-18 07:29:01', '2021-03-18 07:29:42'),
(65, '15', '007', NULL, '31', 'JANET', 'Available', 'Processing', 'Served', 'Processing', '2021-03-18 07:30:36', '2021-03-18 09:44:31'),
(66, '15', '643', NULL, '27', 'DEBBIE', 'Available', 'Served', 'Served', 'Processing', '2021-03-18 07:32:21', '2021-03-18 07:33:50'),
(68, '15', '537', NULL, '31', 'GANI', 'Available', 'Processing', 'Served', 'Processing', '2021-03-18 07:35:07', '2021-03-18 07:35:49'),
(69, '15', '538', NULL, '27', 'JUSTIN', 'Available', 'Processing', 'Served', 'Processing', '2021-03-18 07:45:45', '2021-03-18 07:46:11'),
(70, '15', '560', NULL, '8', 'GANI', 'Available', 'Served', 'Served', 'Processing', '2021-03-18 08:04:00', '2021-03-18 08:31:59'),
(71, '15', '683', NULL, '8', 'JANET', 'Available', 'Processing', 'Served', 'Processing', '2021-03-18 09:23:51', '2021-03-18 09:24:27'),
(72, '15', '621', NULL, '26', 'GANI', 'Available', 'Processing', 'Served', 'Processing', '2021-03-18 10:24:03', '2021-03-18 10:24:49'),
(73, '15', '560', NULL, '27', 'LOMARIE', 'Available', 'Served', 'Served', 'Processing', '2021-03-18 10:26:15', '2021-03-18 10:26:49'),
(74, '15', '622', NULL, '26', 'LOMARIE', 'Available', 'Served', 'Served', 'Processing', '2021-03-18 10:35:14', '2021-03-18 10:35:53'),
(75, '15', '684', NULL, '28', 'LOMARIE', 'Available', 'Processing', 'Served', 'Processing', '2021-03-18 10:36:38', '2021-03-18 10:37:04'),
(76, '15', '225', NULL, '27', 'LOMARIE', 'Available', 'Processing', 'Served', 'Processing', '2021-03-18 10:39:58', '2021-03-18 10:40:29'),
(77, '15', '661', NULL, '29', 'DEBBIE', 'Available', 'Processing', 'Served', 'Processing', '2021-03-18 10:41:30', '2021-03-18 10:42:07'),
(78, '15', '662', NULL, '31', 'LOMARIE', 'Available', 'Processing', 'Served', 'Processing', '2021-03-18 10:43:19', '2021-03-18 10:43:47'),
(79, '15', '602', NULL, '30', 'KEMUEL', 'Available', 'Served', 'Served', 'Processing', '2021-03-18 10:44:47', '2021-03-18 10:47:36'),
(80, '15', '664', NULL, '26', 'LOMARIE', 'Available', 'Served', 'Served', 'Processing', '2021-03-18 10:48:33', '2021-03-18 10:48:56'),
(81, '15', '601', NULL, '30', 'GANI', 'Available', 'Pending', 'Served', 'Processing', '2021-03-18 10:50:08', '2021-03-18 10:50:30'),
(82, '15', '682', NULL, '29', 'GANI', 'Available', 'Processing', 'Processing', 'Processing', '2021-03-18 10:51:22', '2021-03-18 10:51:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` tinyint(1) NOT NULL DEFAULT 0,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `role_id`, `position`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@admin.com', '$2y$10$G8qIWD6IIuQH.AbaQtZcjOl9g.4AfSqOOkR1kgNB2gXYupGSyCUEq', 1, 'Admin', '2021-03-03 10:40:33', '2021-03-03 10:40:33', NULL),
(2, 'Kitchen', 'kitchen@kitchen.com', '$2y$10$gpr8cRk5cETFGaYWAxNkuujc3FVh19O79fl3lxnxuYaGHUuJf45TG', 2, 'Kitchen Staff', '2021-03-04 13:14:21', '2021-03-04 13:14:21', NULL),
(3, 'Bar', 'bar@bar.com', '$2y$10$m2BOJxHrzOtoXbqi5RghSer44P019ojAzEJmpwvrrh4G7CrXdSqG2', 3, 'Bar Staff', '2021-03-04 13:14:42', '2021-03-04 13:14:42', NULL),
(4, 'janet dodoy', 'aneth@cashier.com', '$2y$10$WY5WsSCDYQ3J3xFr28vcl.TexiNjw1.0ROhZ/LIduCtZI0uZCJFxy', 4, 'Cashier Staff', '2021-03-04 13:15:09', '2021-03-16 19:19:44', NULL),
(5, 'Outsourced', 'outsourced@outsourced.com', '$2y$10$l2Dx.XTsJzfDfFqRdRrCkOG/nUXntGECmcy7O3WWzTNMvN5sWsMGq', 5, 'Outsource Staff', '2021-03-04 13:15:45', '2021-03-04 13:15:45', NULL),
(6, 'Cashier Two', 'cashier2@cashier.com', '$2y$10$4f2VLdgV5.vE0W.LCdxDh.ByRk/VCUDCBiT/9NxY9ag7naxLEUlfO', 4, 'Cashier Staff', '2021-03-04 13:17:55', '2021-03-04 13:17:55', NULL),
(7, 'JANET', 'JANET@one.com', '$2y$10$MTN8hHztmWqCpreI1pmHzugRnhM7non2bxA0YZzea/quciHdrQO5e', 6, '1', '2021-03-10 10:47:47', '2021-03-16 16:48:16', NULL),
(8, 'DEBBIE', 'DEBBIE@two.com', '$2y$10$oz9kTJu.zQX2eI75zpTke.hNmiWXz7WYI3Q65miTNgbLvKys.vK2S', 6, '2', '2021-03-10 10:48:05', '2021-03-16 16:48:01', NULL),
(9, 'LOMARIE', 'LOMARIE@LOMARIE.com', '$2y$10$9cpwLVKuCdRI.1XFn6YeN.ukNm5oGY7Hl5M51ZHf84b.Wg.cLe7B2', 6, 'waiter', '2021-03-16 16:48:41', '2021-03-16 16:48:41', NULL),
(10, 'KEMUEL', 'KEMUEL@KEMUEL.com', '$2y$10$PHitUzUoJYH0meWPxBIwEehVIh1VHQSXZHjIEjxHK6vnPDcms/aF.', 6, 'waiter', '2021-03-16 16:48:56', '2021-03-16 16:48:56', NULL),
(11, 'GANI', 'GANI@GANI.com', '$2y$10$Bj8jX7BxS2ZMwSyYYXPi/.rBi8rMQZ3zsXHDOAEcINuKYBRit3RZS', 6, 'waiter', '2021-03-16 16:49:05', '2021-03-16 16:49:05', NULL),
(12, 'EUGENE', 'EUGENE@EUGENE.com', '$2y$10$eCEkN6BuWaQm5R7RmnKW7eYqFFuDQ5sSnCb3dPhe1uv4.u9PvhsMy', 6, 'waiter', '2021-03-16 16:49:23', '2021-03-16 16:49:23', NULL),
(13, 'JUSTIN', 'JUSTIN@JUSTIN.com', '$2y$10$2Dgmuaup2mGb7ynRUnhbau4j03XNAdsD9CGoPSNv0w2GDUTslyPNu', 6, 'waiter', '2021-03-16 16:49:37', '2021-03-16 16:49:37', NULL),
(14, 'DARWIN', 'DARWIN@DARWIN.com', '$2y$10$ZTbU2lPr22yrw0t4fzKnvO/aMyP3VIdr57jI14JXt9aPrBwxnvmHm', 6, 'waiter', '2021-03-16 16:49:46', '2021-03-16 16:49:46', NULL),
(15, 'Lomarie', 'lomarievictor143@gmail.com', '$2y$10$R1blGDSOBGjccxUNrJaahu3PfUc1Y0KqYAq42hU79ZwLz27zrOWYG', 4, 'cashier', '2021-03-18 03:29:10', '2021-03-18 03:29:10', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountexpenses`
--
ALTER TABLE `accountexpenses`
  ADD PRIMARY KEY (`accountExpenseId`);

--
-- Indexes for table `beginingfunds`
--
ALTER TABLE `beginingfunds`
  ADD PRIMARY KEY (`beginingfundId`);

--
-- Indexes for table `cashins`
--
ALTER TABLE `cashins`
  ADD PRIMARY KEY (`cashInId`);

--
-- Indexes for table `cashouts`
--
ALTER TABLE `cashouts`
  ADD PRIMARY KEY (`cashOutId`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`departmentId`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`deviceId`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expenseId`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`inventoryId`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`paymentId`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`tableId`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transactionId`);

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
-- AUTO_INCREMENT for table `accountexpenses`
--
ALTER TABLE `accountexpenses`
  MODIFY `accountExpenseId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `beginingfunds`
--
ALTER TABLE `beginingfunds`
  MODIFY `beginingfundId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cashins`
--
ALTER TABLE `cashins`
  MODIFY `cashInId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cashouts`
--
ALTER TABLE `cashouts`
  MODIFY `cashOutId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `departmentId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `deviceId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expenseId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `inventoryId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=278;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=290;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `paymentId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `tableId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transactionId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
