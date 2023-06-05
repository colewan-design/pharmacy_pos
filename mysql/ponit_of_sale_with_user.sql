-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2021 at 02:59 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ponit_of_sale`
--

-- --------------------------------------------------------

--
-- Table structure for table `cashins`
--

CREATE TABLE `cashins` (
  `cashInId` bigint(20) UNSIGNED NOT NULL,
  `giveBy` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cashouts`
--

CREATE TABLE `cashouts` (
  `cashOutId` bigint(20) UNSIGNED NOT NULL,
  `giveBy` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` text COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `categoryStyle` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Button Color Hex',
  `categoryUse` char(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y' COMMENT 'Y/N',
  `categoryIsDeleted` char(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Y/N',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryId`, `departmentId`, `categoryName`, `categoryDescription`, `categoryStyle`, `categoryUse`, `categoryIsDeleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'All-Day Breakfast Specials', 'All-Day Breakfast Specials', '#00FF00', 'Y', 'N', '2021-02-01 22:28:11', '2021-02-03 02:16:29'),
(2, 1, 'Soup Sublime', 'Soup Sublime', '#00FF00', 'Y', 'N', '2021-02-01 22:28:25', '2021-02-03 03:13:54'),
(3, 1, 'Wholesome\'wiches', 'Wholesome\'wiches', '#F4A460', 'Y', 'N', '2021-02-01 22:28:51', '2021-02-03 03:13:59'),
(4, 1, 'Salad Bliss', 'Salad Bliss', '#808080', 'Y', 'N', '2021-02-01 22:29:05', '2021-02-03 03:14:05'),
(5, 1, 'Pasta Delights', 'Pasta Delights', '#00FF00', 'Y', 'N', '2021-02-01 22:29:27', '2021-02-01 22:29:27'),
(6, 1, 'Chicken Favorites', 'Chicken Favorites', '#006400', 'Y', 'N', '2021-02-01 22:29:48', '2021-02-03 03:14:11'),
(7, 1, 'Fish Specials', 'Fish Specials', '#00FF00', 'Y', 'N', '2021-02-01 22:30:06', '2021-02-01 22:30:06'),
(8, 1, 'Meaty Diversion', 'Meaty Diversion', '#00FF00', 'Y', 'N', '2021-02-01 22:30:33', '2021-02-01 22:55:28'),
(9, 1, 'Vegetarian Pleasure', 'Vegetarian Pleasure', '#00FF00', 'Y', 'N', '2021-02-01 22:30:53', '2021-02-01 22:30:53'),
(10, 1, 'Side dish', 'Side dish', '#00FF00', 'Y', 'N', '2021-02-01 22:31:03', '2021-02-01 22:31:03'),
(11, 2, 'Cold Beverages', 'Cold Beverages', '#00FF00', 'Y', 'N', '2021-02-01 22:31:23', '2021-02-01 22:31:23'),
(12, 2, 'House Iced tea', 'House Iced tea', '#00FF00', 'Y', 'N', '2021-02-01 22:31:39', '2021-02-01 22:31:39'),
(13, 2, 'Freshly Squeezed Juices', 'Freshly Squeezed Juices', '#00FF00', 'Y', 'N', '2021-02-01 22:31:54', '2021-02-01 22:31:54'),
(14, 2, 'Hot beverages', 'Hot beverages', '#00FF00', 'Y', 'N', '2021-02-01 22:32:08', '2021-02-01 22:32:08'),
(15, 2, 'Hot Tea', 'Hot Tea', '#00FF00', 'Y', 'N', '2021-02-01 22:32:37', '2021-02-01 22:32:37'),
(16, 4, 'Outsourced', 'Outsourced', '#F0E68C', 'Y', 'N', '2021-02-01 22:33:22', '2021-02-09 17:29:48'),
(18, 2, 'Breads', 'Breads', '#DA70D6', 'Y', 'N', '2021-03-01 18:37:02', '2021-03-01 19:07:34'),
(19, 2, 'Cakes Whole Cake', 'Cakes Whole Cake', '#808080', 'Y', 'N', '2021-03-01 18:37:34', '2021-03-01 19:07:25'),
(20, 2, 'Cakes Slices', 'Cakes Slices', '#00BFFF', 'Y', 'N', '2021-03-01 18:37:54', '2021-03-01 19:07:21'),
(21, 2, 'Bars', 'Bars', '#F4A460', 'Y', 'N', '2021-03-01 18:38:10', '2021-03-01 19:07:17'),
(22, 2, 'Cookies', 'Cookies', '#00FF00', 'Y', 'N', '2021-03-01 18:38:21', '2021-03-01 19:07:11'),
(23, 2, 'Pastries', 'Pastries', '#FFA500', 'Y', 'N', '2021-03-01 18:38:34', '2021-03-01 19:07:05');

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
(5, 'Kitchen', 'Kitchen', 'Y', 'N', '2021-03-04 18:43:13', NULL),
(6, 'Bar', 'Bar', 'Y', 'N', '2021-03-04 18:43:13', NULL),
(7, 'Cashier', 'Cashier', 'Y', 'N', '2021-03-04 18:43:13', NULL),
(8, 'Outsourced', 'Outsourced', 'Y', 'N', '2021-03-04 18:43:13', NULL);

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
(1, '1', 'smb://DESKTOP-Q1M4MR6/EPSON TM-T82X', 'smb://DESKTOP-Q1M4MR6/EPSON TM-T82X', 'Y', 'N', '2021-03-01 19:08:56', '2021-03-01 19:08:56'),
(2, '2', 'smb://DESKTOP-EN0ACJM/EPSON TM-T82X', 'smb://DESKTOP-EN0ACJM/EPSON TM-T82X', 'Y', 'N', '2021-03-01 19:18:44', '2021-03-01 23:18:07');

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
(1, 1, 'Bekkag\'s Corned Beef Hash', 'Bekkag\'s Corned Beef Hash', 10, 175, 'Y', 'N', '2021-02-01 22:35:08', '2021-02-02 00:14:29'),
(2, 1, 'Gatao\'s Egg Surprices', 'Gatao\'s Egg Surprices', 10, 195, 'Y', 'N', '2021-02-01 22:35:52', '2021-02-01 22:35:52'),
(3, 1, 'Ommay\'s Chicken & Waffle', 'Ommay\'s Chicken & Waffle', 10, 175, 'Y', 'N', '2021-02-01 22:36:31', '2021-02-01 22:36:31'),
(4, 1, 'Chef\'s Huevos Rancheros', 'Chef\'s Huevos Rancheros', 10, 185, 'Y', 'N', '2021-02-01 22:36:56', '2021-02-01 22:36:56'),
(5, 2, 'Bloody Mary', 'Bloody Mary', 10, 95, 'Y', 'N', '2021-02-01 22:37:20', '2021-02-01 22:37:20'),
(6, 2, 'House Chicken Soup', 'House Chicken Soup', 10, 95, 'Y', 'N', '2021-02-01 22:37:36', '2021-02-01 22:37:36'),
(7, 3, 'Fish in a Bun', 'Fish in a Bun', 10, 195, 'Y', 'N', '2021-02-01 22:37:55', '2021-02-01 22:37:55'),
(8, 3, 'Chicken & Apple Burrito', 'Chicken & Apple Burrito', 10, 185, 'Y', 'N', '2021-02-01 22:38:13', '2021-02-01 22:38:13'),
(9, 3, 'Eco French Toasts', 'Eco French Toasts', 10, 175, 'Y', 'N', '2021-02-01 22:38:35', '2021-02-01 22:38:35'),
(10, 3, 'Chili Dog Sandwich', 'Chili Dog Sandwich', 10, 195, 'Y', 'N', '2021-02-01 22:39:15', '2021-02-01 22:39:15'),
(11, 3, 'Steak in a Bun', 'Steak in a Bun', 10, 205, 'Y', 'N', '2021-02-01 22:39:28', '2021-02-01 22:39:28'),
(12, 4, 'House Salad', 'House Salad', 10, 100, 'Y', 'N', '2021-02-01 22:39:58', '2021-02-01 22:39:58'),
(13, 4, 'Chef\'s Bounty Salad(SOLO)', 'Chef\'s Bounty Salad(SOLO)', 10, 100, 'Y', 'N', '2021-02-01 22:41:00', '2021-02-01 22:41:00'),
(14, 4, 'Herb Salad(SOLO)', 'Herb Salad(SOLO)', 10, 100, 'Y', 'N', '2021-02-01 22:41:17', '2021-02-01 22:41:17'),
(15, 4, 'Green Goddess Pasta Salad(SOLO)', 'Green Goddess Pasta Salad(SOLO)', 10, 100, 'Y', 'N', '2021-02-01 22:41:37', '2021-02-01 22:41:37'),
(16, 4, 'Chicken Apple Salad(SHARING)', 'Chicken Apple Salad(SHARING)', 10, 195, 'Y', 'N', '2021-02-01 22:42:18', '2021-02-01 22:42:18'),
(17, 4, 'House Salad(SHARING)', 'House Salad(SHARING)', 10, 195, 'Y', 'N', '2021-02-01 22:42:29', '2021-02-01 22:42:29'),
(18, 4, 'Chef\'s Bountry(SHARING)', 'Chef\'s Bountry(SHARING)', 10, 195, 'Y', 'N', '2021-02-01 22:42:48', '2021-02-01 22:42:48'),
(19, 4, 'Herb Salad(SHARING)', 'Herb Salad(SHARING)', 10, 195, 'Y', 'N', '2021-02-01 22:42:57', '2021-02-01 22:42:57'),
(20, 4, 'Green Goddess Pasta Salad(SHARING)', 'Green Goddess Pasta Salad(SHARING)', 10, 195, 'Y', 'N', '2021-02-01 22:43:15', '2021-02-01 22:43:15'),
(21, 5, 'Chicken Lasagna Roll-ups', 'Chicken Lasagna Roll-ups', 10, 195, 'Y', 'N', '2021-02-01 22:43:46', '2021-02-01 22:43:46'),
(22, 5, 'Vegetarian Pasta Roll-ups', 'Vegetarian Pasta Roll-ups', 10, 175, 'Y', 'N', '2021-02-01 22:44:08', '2021-02-01 22:44:08'),
(23, 5, 'Pasta Ratatouille', 'Pasta Ratatouille', 10, 195, 'Y', 'N', '2021-02-01 22:48:53', '2021-02-01 22:48:53'),
(24, 5, 'Kung Pao Chicken Pasta', 'Kung Pao Chicken Pasta', 10, 185, 'Y', 'N', '2021-02-01 22:49:21', '2021-02-01 22:49:21'),
(25, 5, 'Panne al Telefono', 'Panne al Telefono', 10, 175, 'Y', 'N', '2021-02-01 22:49:41', '2021-02-01 22:49:41'),
(26, 6, 'Chicken Tenders', 'Chicken Tenders', 10, 185, 'Y', 'N', '2021-02-01 22:50:14', '2021-02-01 22:50:14'),
(27, 6, 'Chef\'s Pockets', 'Chef\'s Pockets', 10, 195, 'Y', 'N', '2021-02-01 22:50:32', '2021-02-01 22:50:32'),
(28, 6, 'Grilled Chicken With Pesto', 'Grilled Chicken With Pesto', 10, 185, 'Y', 'N', '2021-02-01 22:50:51', '2021-02-01 22:50:51'),
(29, 6, 'Honey-Glazed Chicken', 'Honey-Glazed Chicken', 10, 195, 'Y', 'N', '2021-02-01 22:51:05', '2021-02-01 22:51:05'),
(30, 7, 'Fish Fingers', 'Fish Fingers', 10, 185, 'Y', 'N', '2021-02-01 22:51:25', '2021-02-01 22:51:25'),
(31, 7, 'Fishermans Bounty', 'Fishermans Bounty', 10, 195, 'Y', 'N', '2021-02-01 22:51:43', '2021-02-01 22:51:44'),
(32, 7, 'Farmer\'s Fish', 'Farmer\'s Fish', 10, 200, 'Y', 'N', '2021-02-01 22:52:00', '2021-02-01 22:52:00'),
(33, 7, 'Chef\'s Glazed Salmon', 'Chef\'s Glazed Salmon', 10, 295, 'Y', 'N', '2021-02-01 22:52:20', '2021-02-01 22:52:20'),
(34, 8, 'Lodge Beef Tenders', 'Lodge Beef Tenders', 10, 205, 'Y', 'N', '2021-02-01 22:56:03', '2021-02-01 22:56:03'),
(35, 8, 'Cowboy\'s Chilli-Bean Stew', 'Cowboy\'s Chilli-Bean Stew', 10, 200, 'Y', 'N', '2021-02-01 22:56:41', '2021-02-01 22:56:41'),
(36, 8, 'Shepherd\'s Pie', 'Shepherd\'s Pie', 10, 195, 'Y', 'N', '2021-02-01 22:56:56', '2021-02-01 22:56:56'),
(37, 8, 'Chef\'s Steak', 'Chef\'s Steak', 10, 350, 'Y', 'N', '2021-02-01 22:57:12', '2021-02-01 22:57:12'),
(38, 9, 'Eggplant Parmigiana', 'Eggplant Parmigiana', 10, 175, 'Y', 'N', '2021-02-01 22:57:31', '2021-02-01 22:57:31'),
(39, 9, 'Elmer\'s Mystic Two', 'Elmer\'s Mystic Two', 10, 175, 'Y', 'N', '2021-02-01 22:57:47', '2021-02-01 22:57:47'),
(40, 10, 'Camote Fries(SOLO)', 'Camote Fries(SOLO)', 10, 35, 'Y', 'N', '2021-02-01 22:58:22', '2021-02-01 22:58:22'),
(41, 10, 'Camote Fries(SHARING)', 'Camote Fries(SHARING)', 10, 65, 'Y', 'N', '2021-02-01 22:58:33', '2021-02-01 22:58:33'),
(42, 11, 'Fresh Fruit Shake Depends on its Season/Availability(SOLO)', 'Fresh Fruit Shake Depends on its Season/Availability(SOLO)', 10, 85, 'Y', 'N', '2021-02-01 23:00:43', '2021-02-24 17:48:48'),
(43, 11, '2-Fruit Combination', '2-Fruit Combination', 10, 95, 'Y', 'N', '2021-02-01 23:01:24', '2021-02-01 23:01:24'),
(44, 11, '3 to 4 Fruit Combination', '3 to 4 Fruit Combination', 10, 100, 'Y', 'N', '2021-02-01 23:01:48', '2021-02-01 23:01:48'),
(45, 11, 'Iced Coffee', 'Iced Coffee', 10, 0, 'Y', 'N', '2021-02-01 23:02:07', '2021-02-01 23:02:07'),
(46, 12, 'Lemon Grass Iced Tea', 'Lemon Grass Iced Tea', 10, 75, 'Y', 'N', '2021-02-01 23:02:30', '2021-02-01 23:02:31'),
(47, 12, 'Berries Iced Tea', 'Berries Iced Tea', 10, 75, 'Y', 'N', '2021-02-01 23:02:45', '2021-02-01 23:02:45'),
(48, 12, 'Mixed Fruit Iced Tea', 'Mixed Fruit Iced Tea', 10, 75, 'Y', 'N', '2021-02-01 23:02:59', '2021-02-01 23:02:59'),
(49, 13, 'Carrot Pure(CP)', 'Carrot Pure(CP)', 10, 75, 'Y', 'N', '2021-02-01 23:03:24', '2021-02-24 17:55:21'),
(50, 13, 'Apple Pure(AP)', 'Apple Pure(AP)', 10, 95, 'Y', 'N', '2021-02-01 23:03:43', '2021-02-24 17:55:26'),
(51, 13, 'Cucumber Pure(CucP)', 'Cucumber Pure(CucP)', 10, 75, 'Y', 'N', '2021-02-01 23:04:19', '2021-02-24 17:55:31'),
(52, 13, 'CAC(Carrot, Apple & Cucumber)', 'CAC(Carrot, Apple & Cucumber)', 10, 95, 'Y', 'N', '2021-02-01 23:05:03', '2021-02-24 17:55:36'),
(53, 13, 'CEL(Carrot, Apple, Cucumbe & Celery)', 'CEL(Carrot, Apple, Cucumbe & Celery)', 10, 95, 'Y', 'N', '2021-02-01 23:05:52', '2021-02-24 17:55:40'),
(54, 13, 'GIN(Carrot, Apple, Beets & Ginger)', 'GIN(Carrot, Apple, Beets & Ginger)', 10, 95, 'Y', 'N', '2021-02-01 23:06:34', '2021-02-24 17:55:45'),
(55, 13, 'CAB(Carrot, Apple & Beets )', 'CAB(Carrot, Apple & Beets )', 10, 95, 'Y', 'N', '2021-02-01 23:07:08', '2021-02-24 17:55:49'),
(56, 14, 'Brewed Coffee', 'Brewed Coffee', 10, 50, 'Y', 'N', '2021-02-01 23:07:27', '2021-02-01 23:07:27'),
(57, 14, 'Soya Bean Coffee', 'Soya Bean Coffee', 10, 50, 'Y', 'N', '2021-02-01 23:07:43', '2021-02-01 23:07:43'),
(58, 14, 'Hot Choco', 'Hot Choco', 10, 65, 'Y', 'N', '2021-02-01 23:07:59', '2021-02-01 23:07:59'),
(59, 14, 'Latte', 'Latte', 10, 0, 'Y', 'N', '2021-02-01 23:08:10', '2021-02-01 23:08:10'),
(60, 14, 'Cappuccino', 'Cappuccino', 10, 0, 'Y', 'N', '2021-02-01 23:08:19', '2021-02-01 23:08:19'),
(61, 14, 'Americano', 'Americano', 10, 0, 'Y', 'N', '2021-02-01 23:08:30', '2021-02-01 23:08:30'),
(62, 14, 'Caramel Macchiato', 'Caramel Macchiato', 10, 0, 'Y', 'N', '2021-02-01 23:08:44', '2021-02-01 23:08:44'),
(63, 15, 'Single (Banaba)', 'Single (Banaba)', 10, 55, 'Y', 'N', '2021-02-01 23:09:43', '2021-02-24 17:55:55'),
(64, 15, 'Single (Gipah)', 'Single (Gipah)', 10, 55, 'Y', 'N', '2021-02-01 23:09:54', '2021-02-24 17:56:00'),
(65, 15, 'Single (ashitaba)', 'Single (ashitaba)', 10, 55, 'Y', 'N', '2021-02-01 23:10:06', '2021-02-24 17:56:05'),
(66, 15, 'Single (lemon grass)', 'Single (lemon grass)', 10, 55, 'Y', 'N', '2021-02-01 23:10:16', '2021-02-24 17:56:09'),
(67, 15, 'Single (dandelion)', 'Single (dandelion)', 10, 55, 'Y', 'N', '2021-02-01 23:10:27', '2021-02-24 17:56:13'),
(68, 15, 'Single(gayubana & ginger turmeric)', 'Single(gayubana & ginger turmeric)', 10, 55, 'Y', 'N', '2021-02-01 23:10:46', '2021-02-24 17:56:18'),
(69, 15, 'Tea Pot (Banaba)', 'Tea Pot (Banaba)', 10, 75, 'Y', 'N', '2021-02-01 23:11:14', '2021-02-24 17:56:23'),
(70, 15, 'Tea Pot (Gipah)', 'Tea Pot (Gipah)', 10, 75, 'Y', 'N', '2021-02-01 23:11:42', '2021-02-24 17:56:28'),
(71, 15, 'Tea Pot (ashitaba)', 'Tea Pot (ashitaba)', 10, 75, 'Y', 'N', '2021-02-01 23:11:59', '2021-02-24 17:56:33'),
(72, 15, 'Tea Pot (lemon grass)', 'Tea Pot (lemon grass)', 10, 75, 'Y', 'N', '2021-02-01 23:12:09', '2021-02-24 17:56:37'),
(73, 15, 'Tea Pot (dandelion)', 'Tea Pot (dandelion)', 10, 75, 'Y', 'N', '2021-02-01 23:12:22', '2021-02-24 17:56:42'),
(74, 15, 'Tea Pot(gayubana & ginger turmeric)', 'Tea Pot(gayubana & ginger turmeric)', 10, 75, 'Y', 'N', '2021-02-01 23:12:37', '2021-02-24 17:56:47'),
(75, 15, 'Single CRS  (Cranberry-Raspberry-Strawberry)', 'Single CRS  (Cranberry-Raspberry-Strawberry)', 10, 55, 'Y', 'N', '2021-02-01 23:15:22', '2021-02-24 17:56:52'),
(76, 15, 'Single (Peach)', 'Single Peach', 10, 55, 'Y', 'N', '2021-02-01 23:15:40', '2021-02-01 23:15:40'),
(77, 15, 'Single (Cinnamon)', 'Single (Cinnamon)', 10, 55, 'Y', 'N', '2021-02-01 23:17:09', '2021-02-01 23:17:09'),
(78, 15, 'Single (Earl grey)', 'Single (Earl grey)', 10, 55, 'Y', 'N', '2021-02-01 23:17:28', '2021-02-01 23:17:28'),
(79, 15, 'Single (Cammomile)', 'Single (Cammomile)', 10, 55, 'Y', 'N', '2021-02-01 23:17:40', '2021-02-01 23:17:40'),
(80, 15, 'Single (Mixed Fruit Tea and Jasmne Green and Black Tea)', 'Single (Mixed Fruit Tea and Jasmne Green and Black Tea)', 10, 55, 'Y', 'N', '2021-02-01 23:18:14', '2021-02-01 23:18:14'),
(81, 15, 'Tea pot CRS (Cranberry-Raspberry-Strawberry)', 'Tea pot CRS (Cranberry-Raspberry-Strawberry)', 10, 75, 'Y', 'N', '2021-02-01 23:18:55', '2021-02-24 17:57:00'),
(82, 15, 'Tea pot (Peach)', 'Tea pot (Peach)', 10, 75, 'Y', 'N', '2021-02-01 23:19:23', '2021-02-24 17:57:04'),
(83, 15, 'Tea pot (Cinnamon)', 'Tea pot (Cinnamon)', 10, 75, 'Y', 'N', '2021-02-01 23:19:43', '2021-02-24 17:57:09'),
(84, 15, 'Tea pot (Earl grey)', 'Tea pot (Earl grey)', 10, 75, 'Y', 'N', '2021-02-01 23:20:56', '2021-02-24 17:57:13'),
(85, 15, 'Tea pot (Cammomile)', 'Tea pot (Cammomile)', 10, 75, 'Y', 'N', '2021-02-01 23:21:16', '2021-02-24 17:57:18'),
(86, 15, 'TP(Mixed Fruit Tea & Jasmne Green and Black Tea)', 'Tea pot (Mixed Fruit Tea & Jasmne Green and Black Tea)', 10, 75, 'Y', 'N', '2021-02-01 23:21:37', '2021-02-22 00:38:29'),
(87, 16, 'Tauli Brown Rice(25kg)', 'Tauli Brown Rice(25kg)', 10, 1400, 'Y', 'N', '2021-02-01 23:22:29', '2021-02-01 23:22:29'),
(88, 16, 'Tauli White Rice(25kg)', 'Tauli White Rice(25kg)', 10, 1350, 'Y', 'N', '2021-02-01 23:23:30', '2021-02-01 23:23:30'),
(89, 16, 'Brown Rice(1kg)', 'Brown Rice(1kg)', 10, 75, 'Y', 'N', '2021-02-01 23:24:01', '2021-02-01 23:24:01'),
(90, 16, 'Brown Rice(2kg)', 'Brown Rice(2kg)', 10, 140, 'Y', 'N', '2021-02-01 23:24:17', '2021-02-01 23:24:17'),
(91, 16, 'Maleng Ag Eco Coffee', 'Maleng Ag Eco Coffee', 10, 295, 'Y', 'N', '2021-02-01 23:25:01', '2021-02-01 23:25:01'),
(92, 16, 'Turmeric Powder 100g', 'Turmeric Powder 100g', 10, 110, 'Y', 'N', '2021-02-01 23:25:21', '2021-02-01 23:25:21'),
(93, 16, 'Turmeric Powder 200g', 'Turmeric Powder 200g', 10, 220, 'Y', 'N', '2021-02-01 23:25:35', '2021-02-01 23:25:35'),
(94, 16, 'Turmeric Powder 350g Bottle', 'Turmeric Powder 350g Bottle', 10, 350, 'Y', 'N', '2021-02-01 23:26:04', '2021-02-01 23:26:04'),
(95, 16, 'Turmeric Powder 400g', 'Turmeric Powder 400g', 10, 380, 'Y', 'N', '2021-02-01 23:26:21', '2021-02-01 23:26:21'),
(96, 16, 'Honey 4x4', 'Honey 4x4', 10, 500, 'Y', 'N', '2021-02-01 23:26:38', '2021-02-01 23:26:38'),
(97, 16, 'Honey 2x2', 'Honey 2x2', 10, 250, 'Y', 'N', '2021-02-01 23:26:49', '2021-02-01 23:26:49'),
(98, 16, 'Muscovado', 'Muscovado', 10, 160, 'Y', 'N', '2021-02-01 23:27:04', '2021-02-01 23:27:04'),
(99, 16, 'KB Lemon Grass', 'KB Lemon Grass', 10, 165, 'Y', 'N', '2021-02-01 23:27:19', '2021-02-01 23:27:19'),
(100, 16, 'KB Banaba', 'KB Banaba', 10, 165, 'Y', 'N', '2021-02-01 23:27:38', '2021-02-01 23:27:38'),
(101, 16, 'KB Dandelion', 'KB Dandelion', 10, 165, 'Y', 'N', '2021-02-01 23:27:51', '2021-02-01 23:27:51'),
(102, 16, 'KB Goto kola', 'KB Goto kola', 10, 165, 'Y', 'N', '2021-02-01 23:28:03', '2021-02-01 23:28:03'),
(103, 16, 'KB Ashitaba', 'KB Ashitaba', 10, 165, 'Y', 'N', '2021-02-01 23:28:12', '2021-02-01 23:28:12'),
(104, 16, 'KB Gipas', 'KB Gipas', 10, 165, 'Y', 'N', '2021-02-01 23:28:20', '2021-02-01 23:28:20'),
(105, 16, 'KB Ginger Turmeric', 'KB Ginger Turmeric', 10, 165, 'Y', 'N', '2021-02-01 23:28:41', '2021-02-01 23:28:41'),
(106, 16, 'KB Ginger Guyabano', 'KB Ginger Guyabano', 10, 165, 'Y', 'N', '2021-02-01 23:28:50', '2021-02-01 23:28:50'),
(107, 16, 'KB Honeymansi', 'KB Honeymansi', 10, 210, 'Y', 'N', '2021-02-01 23:29:04', '2021-02-01 23:29:04'),
(108, 16, 'GE Apple Tea', 'GE Apple Tea', 10, 230, 'Y', 'N', '2021-02-01 23:29:19', '2021-02-01 23:29:19'),
(109, 16, 'GE Cinnamon Tea', 'GE Cinnamon Tea', 10, 230, 'Y', 'N', '2021-02-01 23:29:32', '2021-02-01 23:29:32'),
(110, 16, 'GE Cammomile', 'GE Cammomile', 10, 230, 'Y', 'N', '2021-02-01 23:29:45', '2021-02-01 23:29:45'),
(111, 16, 'GE Peach', 'GE Peach', 10, 230, 'Y', 'N', '2021-02-01 23:29:59', '2021-02-01 23:29:59'),
(112, 16, 'GE Earl Gray', 'GE Earl Gray', 10, 230, 'Y', 'N', '2021-02-01 23:30:07', '2021-02-01 23:30:08'),
(113, 16, 'GE CRS(Berries)', 'GE CRS(Berries)', 10, 250, 'Y', 'N', '2021-02-01 23:30:28', '2021-02-01 23:30:28'),
(114, 16, 'GE Mixed Fruit Tea', 'GE Mixed Fruit Tea', 10, 250, 'Y', 'N', '2021-02-01 23:30:54', '2021-02-01 23:30:54'),
(115, 16, 'GE Strawberry', 'GE Strawberry', 10, 230, 'Y', 'N', '2021-02-01 23:31:13', '2021-02-01 23:31:13'),
(116, 16, 'GE Jasmin Green Tea', 'GE Jasmin Green Tea', 10, 230, 'Y', 'N', '2021-02-01 23:31:36', '2021-02-01 23:31:36'),
(117, 16, 'GE Jasmin Black Tea', 'GE Jasmin Black Tea', 10, 230, 'Y', 'N', '2021-02-01 23:31:47', '2021-02-01 23:31:47'),
(118, 16, 'Bird Club Lang-ay Wine', 'Bird Club Lang-ay Wine', 10, 350, 'Y', 'N', '2021-02-01 23:32:06', '2021-02-01 23:32:06'),
(119, 16, 'Bird Club Peanut Butter', 'Bird Club Peanut Butter', 10, 220, 'Y', 'N', '2021-02-01 23:32:22', '2021-02-01 23:32:22'),
(120, 16, 'Lifeline Soya Coffee 250g', 'Lifeline Soya Coffee 250g', 10, 135, 'Y', 'N', '2021-02-01 23:32:42', '2021-02-01 23:32:42'),
(121, 16, 'Lifeline Corn Coffee 250g', 'Lifeline Corn Coffee 250g', 10, 125, 'Y', 'N', '2021-02-01 23:34:11', '2021-02-01 23:34:11'),
(122, 16, 'Lifeline Mushroom Powder 200g', 'Lifeline Mushroom Powder 200g', 10, 190, 'Y', 'N', '2021-02-01 23:34:30', '2021-02-01 23:34:30'),
(123, 16, 'Lifeline Charcoal Capsule', 'Lifeline Charcoal Capsule', 10, 375, 'Y', 'N', '2021-02-01 23:34:58', '2021-02-01 23:34:58'),
(124, 16, 'Lifeline Charcoal Powder', 'Lifeline Charcoal Powder', 10, 190, 'Y', 'N', '2021-02-01 23:35:08', '2021-02-01 23:35:08'),
(125, 16, 'Lifeline Turmeric Powder Bottle', 'Lifeline Turmeric Powder Bottle', 10, 150, 'Y', 'N', '2021-02-01 23:35:31', '2021-02-01 23:35:31'),
(126, 16, 'Lifeline Ginger Powder/Tea', 'Lifeline Ginger Powder/Tea', 10, 140, 'Y', 'N', '2021-02-01 23:35:52', '2021-02-01 23:35:52'),
(127, 16, 'Lifeline Onion Sauce', 'Lifeline Onion Sauce', 10, 120, 'Y', 'N', '2021-02-01 23:36:09', '2021-02-01 23:36:09'),
(128, 16, 'Lifeline Chili Sauce', 'Lifeline Chili Sauce', 10, 120, 'Y', 'N', '2021-02-01 23:36:25', '2021-02-01 23:36:25'),
(129, 16, 'Lifeline Crysanthemum Tea', 'Lifeline Crysanthemum Tea', 10, 150, 'Y', 'N', '2021-02-01 23:36:46', '2021-02-01 23:36:46'),
(130, 16, 'Lifeline Molasses', 'Lifeline Molasses', 10, 120, 'Y', 'N', '2021-02-01 23:37:03', '2021-02-01 23:37:03'),
(131, 16, 'Bojos Atchara', 'Bojos Atchara', 10, 120, 'Y', 'N', '2021-02-01 23:37:21', '2021-02-01 23:37:21'),
(132, 16, 'Marmalade', 'Marmalade', 10, 190, 'Y', 'N', '2021-02-01 23:37:34', '2021-02-01 23:37:34'),
(133, 16, 'Malunngay Capsule', 'Malunngay Capsule', 10, 365, 'Y', 'N', '2021-02-01 23:38:04', '2021-02-01 23:38:04'),
(134, 16, 'Serpentina Capsule', 'Serpentina Capsule', 10, 350, 'Y', 'N', '2021-02-01 23:38:22', '2021-02-01 23:38:22'),
(135, 16, 'Ginger Turmeric Big Bottled', 'Ginger Turmeric Big Bottled', 10, 280, 'Y', 'N', '2021-02-01 23:38:41', '2021-02-01 23:38:41'),
(136, 16, 'Ginger Turmeric Small Bottled', 'Ginger Turmeric Small Bottled', 10, 230, 'Y', 'N', '2021-02-01 23:39:00', '2021-02-01 23:39:00'),
(137, 16, 'Lemon Curd Small', 'Lemon Curd Small', 10, 90, 'Y', 'N', '2021-02-01 23:39:16', '2021-02-01 23:39:16'),
(138, 16, 'Lemon Curd Big', 'Lemon Curd Big', 10, 180, 'Y', 'N', '2021-02-01 23:39:39', '2021-02-01 23:39:39'),
(139, 16, 'PUC Gluten Steak', 'PUC Gluten Steak', 10, 130, 'Y', 'N', '2021-02-01 23:39:55', '2021-02-01 23:39:55'),
(140, 16, 'PUC Gluten Tocino', 'PUC Gluten Tocino', 10, 130, 'Y', 'N', '2021-02-01 23:40:32', '2021-02-01 23:40:32'),
(141, 16, 'PUC Tapa', 'PUC Tapa', 10, 130, 'Y', 'N', '2021-02-01 23:41:14', '2021-02-01 23:41:14'),
(142, 16, 'PUC Lona', 'PUC Lona', 10, 110, 'Y', 'N', '2021-02-01 23:41:40', '2021-02-01 23:41:40'),
(143, 16, 'PUC Vg Meat', 'PUC Vg Meat', 10, 110, 'Y', 'N', '2021-02-01 23:41:55', '2021-02-01 23:41:55'),
(144, 18, 'Plain Pandesal', 'Plain Pandesal', 10, 15, 'Y', 'N', '2021-03-01 18:39:37', '2021-03-01 18:39:37'),
(145, 18, 'Yacun Pandesal', 'Yacun Pandesal', 10, 20, 'Y', 'N', '2021-03-01 18:40:21', '2021-03-01 18:40:21'),
(146, 18, 'Raisin Pandesal', 'Raisin Pandesal', 10, 20, 'Y', 'N', '2021-03-01 18:41:05', '2021-03-01 18:41:05'),
(147, 18, 'Fiber Loaf', 'Fiber Loaf', 10, 90, 'Y', 'N', '2021-03-01 18:41:38', '2021-03-01 18:41:38'),
(148, 18, 'Wheat Oats', 'Wheat Oats', 10, 75, 'Y', 'N', '2021-03-01 18:42:36', '2021-03-01 18:42:36'),
(149, 18, 'Monggo Bread', 'Monggo Bread', 10, 100, 'Y', 'N', '2021-03-01 18:42:51', '2021-03-01 18:42:51'),
(150, 18, 'Cheese Loaf', 'Cheese Loaf', 10, 100, 'Y', 'N', '2021-03-01 18:43:16', '2021-03-01 18:43:16'),
(151, 18, 'Cinnamon', 'Cinnamon', 10, 100, 'Y', 'N', '2021-03-01 18:43:32', '2021-03-01 18:43:32'),
(152, 18, 'Banana Bread', 'Banana Bread', 10, 125, 'Y', 'N', '2021-03-01 18:43:54', '2021-03-01 18:43:54'),
(153, 18, 'Banana Wheat Bread', 'Banana Wheat Bread', 10, 130, 'Y', 'N', '2021-03-01 18:44:06', '2021-03-01 18:44:06'),
(154, 18, 'Cheese Pandesal', 'Cheese Pandesal', 10, 65, 'Y', 'N', '2021-03-01 18:44:21', '2021-03-01 18:44:21'),
(155, 18, 'Ube Pandesal', 'Ube Pandesal', 10, 65, 'Y', 'N', '2021-03-01 18:44:38', '2021-03-01 18:44:38'),
(156, 19, 'Blue Berry Cheese Cake', 'Blue Berry Cheese Cake', 10, 1300, 'Y', 'N', '2021-03-01 18:45:19', '2021-03-01 18:45:19'),
(157, 19, 'Blue Berry Choco', 'Blue Berry Choco', 10, 1000, 'Y', 'N', '2021-03-01 18:45:34', '2021-03-01 18:45:34'),
(158, 19, 'Carrot Cake', 'Carrot Cake', 10, 900, 'Y', 'N', '2021-03-01 18:45:58', '2021-03-01 18:45:58'),
(159, 19, 'Chocolite', 'Chocolite', 10, 900, 'Y', 'N', '2021-03-01 18:46:11', '2021-03-01 18:46:11'),
(160, 19, 'Oreo Cheese Cake', 'Oreo Cheese Cake', 10, 1200, 'Y', 'N', '2021-03-01 18:46:38', '2021-03-01 18:46:38'),
(161, 19, 'Pandan Cake', 'Pandan Cake', 10, 825, 'Y', 'N', '2021-03-01 18:46:52', '2021-03-01 18:46:52'),
(162, 19, 'Red Velvet', 'Red Velvet', 10, 900, 'Y', 'N', '2021-03-01 18:47:05', '2021-03-01 18:47:05'),
(163, 19, 'Sinful Cake', 'Sinful Cake', 10, 1200, 'Y', 'N', '2021-03-01 18:47:19', '2021-03-01 18:47:34'),
(164, 19, 'Tiramisu Cake', 'Tiramisu Cake', 10, 900, 'Y', 'N', '2021-03-01 18:48:03', '2021-03-01 18:48:03'),
(165, 19, 'Yema Caramel', 'Yema Caramel', 10, 825, 'Y', 'N', '2021-03-01 18:48:24', '2021-03-01 18:48:24'),
(166, 19, 'Yema Cheese Cake', 'Yema Cheese Cake', 10, 825, 'Y', 'N', '2021-03-01 18:48:38', '2021-03-01 18:48:38'),
(167, 19, 'Lemon Cake', 'Lemon Cake', 10, 825, 'Y', 'N', '2021-03-01 18:48:48', '2021-03-01 18:48:48'),
(168, 20, 'Blueberry Cheese Cake', 'Blueberry Cheese Cake', 10, 100, 'Y', 'N', '2021-03-01 18:49:23', '2021-03-01 18:49:23'),
(169, 20, 'Blue Berry Choco', 'Blue Berry Choco', 10, 85, 'Y', 'N', '2021-03-01 18:49:42', '2021-03-01 18:49:42'),
(170, 20, 'Carrot Cake', 'Carrot Cake', 10, 75, 'Y', 'N', '2021-03-01 18:50:02', '2021-03-01 18:50:02'),
(171, 20, 'Chocolite', 'Chocolite', 10, 75, 'Y', 'N', '2021-03-01 18:50:22', '2021-03-01 18:50:22'),
(172, 20, 'Oreo Cheese Cake', 'Oreo Cheese Cake', 10, 100, 'Y', 'N', '2021-03-01 18:50:53', '2021-03-01 18:50:53'),
(173, 20, 'Pandan Cake', 'Pandan Cake', 10, 75, 'Y', 'N', '2021-03-01 18:51:07', '2021-03-01 18:51:07'),
(174, 20, 'Red Velvet', 'Red Velvet', 10, 75, 'Y', 'N', '2021-03-01 18:51:19', '2021-03-01 18:51:19'),
(175, 20, 'Sinful Cake', 'Sinful Cake', 10, 100, 'Y', 'N', '2021-03-01 18:51:32', '2021-03-01 18:51:32'),
(176, 20, 'Tiramisu Cake', 'Tiramisu Cake', 10, 75, 'Y', 'N', '2021-03-01 18:51:47', '2021-03-01 18:51:47'),
(177, 20, 'Yema Caramel', 'Yema Caramel', 10, 75, 'Y', 'N', '2021-03-01 18:52:01', '2021-03-01 18:52:01'),
(178, 20, 'Yema Cheese Cake', 'Yema Cheese Cake', 10, 75, 'Y', 'N', '2021-03-01 18:52:14', '2021-03-01 18:52:14'),
(179, 20, 'Lemon Cake', 'Lemon Cake', 10, 75, 'Y', 'N', '2021-03-01 18:52:26', '2021-03-01 18:52:26'),
(180, 21, 'Brownies', 'Brownies', 10, 20, 'Y', 'N', '2021-03-01 18:52:51', '2021-03-01 18:52:51'),
(181, 21, 'Blueberry Crumble', 'Blueberry Crumble', 10, 25, 'Y', 'N', '2021-03-01 18:53:06', '2021-03-01 18:53:06'),
(182, 21, 'Oatmeal Bar', 'Oatmeal Bar', 10, 20, 'Y', 'N', '2021-03-01 18:53:20', '2021-03-01 18:53:20'),
(183, 21, 'Cheese Bar', 'Cheese Bar', 10, 20, 'Y', 'N', '2021-03-01 18:53:28', '2021-03-01 18:53:28'),
(184, 21, 'Yema Caramel Bar', 'Yema Caramel Bar', 10, 20, 'Y', 'N', '2021-03-01 18:53:45', '2021-03-01 18:53:45'),
(185, 22, 'Oatmeal Cookies', 'Oatmeal Cookies', 10, 70, 'Y', 'N', '2021-03-01 18:54:04', '2021-03-01 18:54:04'),
(186, 22, 'Oatmeal Nuts Cookies', 'Oatmeal Nuts Cookies', 10, 60, 'Y', 'N', '2021-03-01 18:54:23', '2021-03-01 18:54:23'),
(187, 22, 'Crunchy Peanut Cookies', 'Crunchy Peanut Cookies', 10, 70, 'Y', 'N', '2021-03-01 18:54:38', '2021-03-01 18:54:38'),
(188, 22, 'Butter Cookies', 'Butter Cookies', 10, 70, 'Y', 'N', '2021-03-01 18:54:49', '2021-03-01 18:54:49'),
(189, 22, 'Chocolate Chip', 'Chocolate Chip', 10, 70, 'Y', 'N', '2021-03-01 18:55:00', '2021-03-01 18:55:00'),
(190, 23, 'Cheesy Pie', 'Cheesy Pie', 10, 55, 'Y', 'N', '2021-03-01 18:55:14', '2021-03-01 18:55:14'),
(191, 23, 'Blueberry Muffin', 'Blueberry Muffin', 10, 50, 'Y', 'N', '2021-03-01 18:55:34', '2021-03-01 18:55:34'),
(192, 23, 'Malungay Muffin', 'Malungay Muffin', 10, 50, 'Y', 'N', '2021-03-01 18:55:47', '2021-03-01 18:56:04'),
(193, 23, 'Strawberry Muffin', 'Strawberry Muffin', 10, 50, 'Y', 'N', '2021-03-01 18:56:37', '2021-03-01 18:56:37'),
(194, 23, 'Banana Muffin', 'Banana Muffin', 10, 50, 'Y', 'N', '2021-03-01 18:57:01', '2021-03-01 18:57:01'),
(195, 23, 'Carrot Muffin', 'Carrot Muffin', 10, 50, 'Y', 'N', '2021-03-01 18:57:13', '2021-03-01 18:57:13'),
(196, 23, 'Bibingka', 'Bibingka', 10, 55, 'Y', 'N', '2021-03-01 18:57:25', '2021-03-01 18:57:25'),
(197, 23, 'Ensaymada', 'Ensaymada', 10, 50, 'Y', 'N', '2021-03-01 18:57:39', '2021-03-01 18:57:39'),
(198, 23, 'Double Choco', 'Double Choco', 10, 60, 'Y', 'N', '2021-03-01 18:57:52', '2021-03-01 18:57:52'),
(199, 23, 'Brownies Cake', 'Brownies Cake', 10, 60, 'Y', 'N', '2021-03-01 18:58:04', '2021-03-01 18:58:04'),
(200, 23, 'Cinnamon Twist', 'Cinnamon Twist', 10, 50, 'Y', 'N', '2021-03-01 18:58:19', '2021-03-01 18:58:19'),
(201, 23, 'Hopia', 'Hopia', 10, 15, 'Y', 'N', '2021-03-01 18:58:35', '2021-03-01 18:58:35'),
(202, 23, 'Blueberry Cheezy Pie', 'Blueberry Cheezy Pie', 10, 65, 'Y', 'N', '2021-03-01 18:58:51', '2021-03-01 18:58:51'),
(203, 23, 'Siopao', 'Siopao', 10, 55, 'Y', 'N', '2021-03-01 18:59:04', '2021-03-01 18:59:04'),
(204, 23, 'Cassava', 'Cassava', 10, 60, 'Y', 'N', '2021-03-01 18:59:16', '2021-03-01 18:59:16'),
(205, 23, 'Brazo De Mercedes', 'Brazo De Mercedes', 10, 50, 'Y', 'N', '2021-03-01 18:59:38', '2021-03-01 18:59:38'),
(206, 23, 'Apple Pie', 'Apple Pie', 10, 750, 'Y', 'N', '2021-03-01 19:00:05', '2021-03-01 19:00:05'),
(207, 23, 'Chicken Siopao', 'Chicken Siopao', 10, 55, 'Y', 'N', '2021-03-01 19:00:19', '2021-03-01 19:00:19'),
(208, 23, 'Crincles', 'Crincles', 10, 10, 'Y', 'N', '2021-03-01 19:00:42', '2021-03-01 19:00:42'),
(209, 23, 'Clover', 'Clover', 10, 10, 'Y', 'N', '2021-03-01 19:00:54', '2021-03-01 19:00:54'),
(210, 23, 'Squash Bread', 'Squash Bread', 10, 12, 'Y', 'N', '2021-03-01 19:01:14', '2021-03-01 19:01:14'),
(211, 23, 'French Bread', 'French Bread', 10, 50, 'Y', 'N', '2021-03-01 19:01:29', '2021-03-01 19:01:29'),
(212, 23, 'Cheese Bun', 'Cheese Bun', 10, 15, 'Y', 'N', '2021-03-01 19:01:46', '2021-03-01 19:01:46'),
(213, 23, 'Spanish Bread', 'Spanish Bread', 10, 20, 'Y', 'N', '2021-03-01 19:02:07', '2021-03-01 19:02:07'),
(214, 23, 'Red Velvet Cupcake', 'Red Velvet Cupcake', 10, 30, 'Y', 'N', '2021-03-01 19:02:23', '2021-03-01 19:02:23');

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
(1, '2021_01_28_071106_categories', 1),
(2, '2021_01_28_071129_items', 1),
(3, '2021_01_28_071143_departments', 1),
(4, '2021_01_29_033415_transactions', 1),
(5, '2021_02_04_021211_orders', 1),
(6, '2021_02_09_065818_tables', 1),
(16, '2021_01_28_071106_categories', 1),
(17, '2021_01_28_071129_items', 1),
(18, '2021_01_28_071143_departments', 1),
(19, '2021_01_29_033415_transactions', 1),
(20, '2021_02_04_021211_orders', 1),
(21, '2021_02_09_055303_tables', 2),
(22, '2021_02_09_065818_tables', 3),
(23, '2021_03_01_075422_devices', 4),
(24, '2021_03_03_024458_create_inventories_table', 5),
(25, '2021_03_03_044744_create_users_table', 5),
(26, '2021_03_03_050819_create_roles_table', 5),
(27, '2021_03_05_051444_payments', 6),
(28, '2014_10_12_100000_create_password_resets_table', 7),
(29, '2021_03_08_010234_cashins', 8),
(30, '2021_03_08_010244_cashouts', 8);

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
  `orderStatus` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `transactionId`, `itemId`, `categoryId`, `orderQty`, `orderPrice`, `orderTotal`, `orderStatus`, `created_at`, `updated_at`) VALUES
(230, '43', '1', '1', 1, 175, 175, 1, '2021-02-23 21:48:39', '2021-03-01 23:44:00'),
(231, '43', '42', '11', 1, 85, 85, 1, '2021-02-23 21:48:39', '2021-03-01 23:43:55'),
(232, '43', '4', '1', 1, 185, 185, 1, '2021-02-23 22:10:49', '2021-03-01 23:44:00'),
(233, '43', '47', '12', 1, 75, 75, 1, '2021-02-23 22:10:49', '2021-03-01 23:43:55'),
(234, '43', '6', '2', 1, 95, 95, 1, '2021-02-23 22:13:06', '2021-03-01 23:44:00'),
(235, '43', '47', '12', 1, 75, 75, 1, '2021-02-23 22:13:07', '2021-03-01 23:43:55'),
(236, '43', '13', '4', 1, 100, 100, 1, '2021-02-23 22:40:24', '2021-03-01 23:44:00'),
(237, '43', '43', '11', 1, 95, 95, 1, '2021-02-23 22:40:24', '2021-03-01 23:43:55'),
(238, '43', '48', '12', 1, 75, 75, 1, '2021-02-23 22:40:24', '2021-03-01 23:43:55'),
(239, '43', '67', '15', 1, 55, 55, 1, '2021-02-23 23:23:24', '2021-03-01 23:43:55'),
(240, '43', '4', '1', 1, 185, 185, 1, '2021-02-23 23:23:36', '2021-03-01 23:44:00'),
(241, '43', '22', '5', 1, 175, 175, 1, '2021-02-23 23:34:16', '2021-03-01 23:44:00'),
(242, '43', '58', '14', 1, 65, 65, 1, '2021-02-23 23:34:16', '2021-03-01 23:43:55'),
(244, '44', '7', '3', 1, 195, 195, 1, '2021-03-01 22:05:32', '2021-03-01 23:44:00'),
(245, '44', '22', '5', 1, 175, 175, 1, '2021-03-01 22:05:32', '2021-03-01 23:44:00'),
(246, '44', '191', '23', 1, 50, 50, 1, '2021-03-01 22:05:32', '2021-03-01 23:43:55'),
(247, '44', '192', '23', 1, 50, 50, 1, '2021-03-01 22:05:32', '2021-03-01 23:43:55'),
(248, '45', '2', '1', 1, 195, 195, 1, '2021-03-01 22:16:33', '2021-03-01 23:44:00'),
(249, '45', '3', '1', 1, 175, 175, 1, '2021-03-01 22:16:33', '2021-03-01 23:44:00'),
(250, '45', '14', '4', 1, 100, 100, 1, '2021-03-01 22:16:33', '2021-03-01 23:44:00'),
(251, '45', '63', '15', 1, 55, 55, 1, '2021-03-01 22:16:33', '2021-03-01 23:43:55'),
(252, '45', '67', '15', 1, 55, 55, 1, '2021-03-01 22:16:34', '2021-03-01 23:43:55'),
(253, '45', '187', '22', 1, 70, 70, 1, '2021-03-01 22:16:34', '2021-03-01 23:43:55'),
(254, '46', '1', '1', 1, 175, 175, 1, '2021-03-01 23:43:49', '2021-03-01 23:44:00'),
(255, '46', '5', '2', 1, 95, 95, 1, '2021-03-01 23:43:49', '2021-03-01 23:44:00'),
(256, '46', '6', '2', 1, 95, 95, 1, '2021-03-01 23:43:49', '2021-03-01 23:44:00'),
(257, '46', '11', '3', 1, 205, 205, 1, '2021-03-01 23:43:49', '2021-03-01 23:44:00'),
(258, '46', '22', '5', 1, 175, 175, 1, '2021-03-01 23:43:49', '2021-03-01 23:44:00'),
(259, '46', '41', '10', 1, 65, 65, 1, '2021-03-01 23:43:49', '2021-03-01 23:44:00'),
(260, '46', '44', '11', 1, 100, 100, 1, '2021-03-01 23:43:49', '2021-03-01 23:43:55');

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
  `tenderedAmount` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `change` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'Admin', '[{\"resourceName\":\"Dashboard\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"dashboard\"},{\"resourceName\":\"Category\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"category\"},{\"resourceName\":\"Department\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"department\"},{\"resourceName\":\"Item\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"item\"},{\"resourceName\":\"Table\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"table\"},{\"resourceName\":\"Device\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"device\"},{\"resourceName\":\"User\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"user\"},{\"resourceName\":\"Role\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"role\"},{\"resourceName\":\"Assign Role\",\"read\":true,\"write\":true,\"update\":true,\"delete\":true,\"name\":\"assignRole\"}]', 1, NULL, '2021-03-04 18:44:38', '2021-03-05 18:59:18');

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
(1, '#1', 'one', 'one', '2', 'Y', 'N', '2021-02-08 23:34:25', '2021-02-08 23:36:21'),
(2, '#2', 'two', 'two', '2', 'Y', 'N', '2021-02-08 23:36:40', '2021-02-08 23:36:40'),
(3, '#3', 'three', 'three', '4', 'Y', 'N', '2021-02-08 23:36:57', '2021-02-08 23:36:57'),
(4, 'Additional Table 1', 'Additional Table 1', 'Additional Table 1', '2', 'Y', 'N', '2021-02-15 01:16:25', '2021-02-15 01:16:25'),
(5, '#4', 'four', 'four', '4', 'Y', 'N', '2021-02-22 19:07:25', '2021-02-22 19:07:25'),
(6, '#5', 'five', 'five', '5', 'Y', 'N', '2021-02-22 19:07:45', '2021-02-22 19:07:45'),
(7, '#6', 'six', 'six', '6', 'Y', 'N', '2021-02-22 19:07:54', '2021-02-22 19:07:54'),
(8, '#7', 'seven', 'seven', '7', 'Y', 'N', '2021-02-22 19:08:03', '2021-02-22 19:08:03');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transactionId` bigint(20) UNSIGNED NOT NULL,
  `transactionSlipNo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionTableId` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionServedBy` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionStatus` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionKitchenStatus` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionBarStatus` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transactionId`, `transactionSlipNo`, `transactionTableId`, `transactionServedBy`, `transactionStatus`, `transactionKitchenStatus`, `transactionBarStatus`, `created_at`, `updated_at`) VALUES
(43, '001', '1', 'Waiter 1', 'Processing', 'Processing', 'Processing', '2021-02-23 21:48:39', '2021-02-28 17:48:35'),
(44, '5520', '5', 'Waiter 1', 'Processing', 'Processing', 'Processing', '2021-03-01 22:05:32', '2021-03-01 22:05:44'),
(45, '542345345', '6', 'Waiter 1', 'Processing', 'Processing', 'Processing', '2021-03-01 22:16:33', '2021-03-01 23:03:58'),
(46, '3524234', '3', 'Waiter 1', 'Processing', 'Processing', 'Processing', '2021-03-01 23:43:49', '2021-03-01 23:44:00');

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `role_id`, `position`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', '$2y$10$G8qIWD6IIuQH.AbaQtZcjOl9g.4AfSqOOkR1kgNB2gXYupGSyCUEq', 1, 'Admin', '2021-03-04 18:45:14', '2021-03-04 18:45:14');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `cashins`
--
ALTER TABLE `cashins`
  MODIFY `cashInId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashouts`
--
ALTER TABLE `cashouts`
  MODIFY `cashOutId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `departmentId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `deviceId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `inventoryId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `paymentId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `tableId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transactionId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
