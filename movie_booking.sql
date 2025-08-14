-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2025 at 02:48 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movie_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_history`
--

CREATE TABLE `booking_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `booked_at` datetime DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cinemas`
--

CREATE TABLE `cinemas` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `province` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cinemas`
--

INSERT INTO `cinemas` (`id`, `name`, `type`, `province`, `location`, `phone`, `image`, `created_at`, `updated_at`) VALUES
(3, 'Rạp 11', 'Beta Cinema', 'Hà Nội', 'ABC,XYZ,JQK', '0999888999', 'storage/uploads/cinemas/Ky56lyO5DA2K40CAWDvnkUJ3IxaPMJVO7sKGzSfN.jpg', '2025-08-04 02:52:42', '2025-08-06 05:19:10'),
(4, 'Beta Quang Trung', 'Cinestar', 'Hà Nội', 'ABC,XYZ,JQK', '0999888999', 'storage/uploads/cinemas/lYDktpsVphkYaegwR4twOX9tmphENJmQ07iavuFR.jpg', '2025-08-06 04:16:45', '2025-08-06 05:33:40'),
(5, 'Beta Quang Khải', 'Beta Cinema', 'Hà Nội', 'ABC,XYZ,JQK', '0999888999', 'storage/uploads/cinemas/3hY5u6dHdJnzwQ4HN0VGHnHmOlMWdaG9F62WbiAA.jpg', '2025-08-06 05:06:46', '2025-08-06 05:06:46'),
(6, 'Beta Hoàng Tôn', 'Beta Cinema', 'Tp. Hồ Chí Minh', 'ABC,XYZ,JQK', '0999888999', 'storage/uploads/cinemas/2fpWphZDhjBxW0fjZqLe2DRnVhCYz9IcnzVGIMQ1.jpg', '2025-08-06 06:06:00', '2025-08-06 06:06:00');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `trailer_url` text DEFAULT NULL,
  `actors` text DEFAULT NULL,
  `director` varchar(100) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `description` text DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'Thời lượng (phút)',
  `release_date` date DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `trailer_url`, `actors`, `director`, `genre`, `rating`, `description`, `duration`, `release_date`, `language`, `image`, `created_at`, `updated_at`) VALUES
(2, 'Phim mới 22', NULL, 'Nguyễn Văn An, Nguyễn Văn Bình', 'Nguyễn Văn Chung', 'Hành động', NULL, 'ABCDE', 120, '2025-08-05', 'Tiếng Việt', 'storage/uploads/movies/SqZYdZN8sMT5uczEDr5KJeW7V7yF97nyHm0dz8LZ.jpg', '2025-08-04 02:25:58', '2025-08-04 02:25:58'),
(3, 'Phim mới của toio', NULL, 'Nguyễn Văn An, Nguyễn Văn Bình', 'Nguyễn Văn Cường', 'Hài hước', NULL, 'ABCDE', 120, '2025-08-19', 'Tiếng Việt', 'storage/uploads/movies/OtXHAxmZ5z6kEna6wSgBpg2otGTeEGGH7PvmQgwG.jpg', '2025-08-08 04:56:20', '2025-08-08 04:56:20'),
(4, 'Phim mới lồng tiếng', NULL, 'Nguyễn A, Nguyễn B, Nguyễn C', 'Nguyễn Văn Dũng', 'Phiêu lưu', NULL, 'abcde', 100, '2025-08-10', 'Lồng tiếng', 'storage/uploads/movies/1dDVcOXPt3TlFECglW1EFes50k4Ujgv5LFv4rWKh.jpg', '2025-08-08 05:00:32', '2025-08-08 05:00:32');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `value` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `title`, `value`, `description`, `start_date`, `end_date`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Khuyến Mãi ABCDE 1', 10, '11111', '2025-08-05', '2025-08-15', 'storage/uploads/promotions/Ee5qTmvdVkpvDfYxl3yuLD1yq0CSQQzt7mIL0kIQ.jpg', '2025-08-04 23:33:12', '2025-08-04 23:39:20'),
(2, 'Mới', 15, 'ab', '2025-08-06', '2025-08-14', 'storage/uploads/promotions/yUyoK9lqJUuKiDuoROob2FWjfvLQY105E1XvHXDn.jpg', '2025-08-05 05:19:36', '2025-08-05 05:19:36');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `cinema_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `cinema_id`, `name`, `capacity`, `type`, `created_at`, `updated_at`) VALUES
(2, 3, 'Phòng mới', 50, '2D', '2025-08-04 03:24:26', '2025-08-04 22:09:24'),
(3, 5, 'Phòng Beta QK1', 120, '2D', '2025-08-07 23:35:19', '2025-08-07 23:35:19');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `seat_code` varchar(10) DEFAULT NULL,
  `seat_type` varchar(255) DEFAULT 'Thường',
  `price` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `room_id`, `seat_code`, `seat_type`, `price`, `created_at`, `updated_at`) VALUES
(2, 2, 'A2', 'VIP', 0, '2025-08-04 04:04:20', '2025-08-04 20:54:49'),
(3, 2, 'A1', 'VIP', 0, '2025-08-04 20:54:21', '2025-08-04 20:54:21'),
(4, 2, 'A1', 'VIP', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(5, 2, 'A2', 'VIP', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(6, 2, 'A3', 'VIP', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(7, 2, 'A4', 'VIP', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(8, 2, 'A5', 'VIP', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(9, 2, 'B1', 'Thường', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(10, 2, 'B2', 'Thường', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(11, 2, 'B3', 'Thường', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(12, 2, 'B4', 'Thường', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(13, 2, 'B5', 'Thường', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(14, 2, 'C1', 'Thường', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(15, 2, 'C2', 'Thường', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(16, 2, 'C3', 'Thường', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(17, 2, 'C4', 'Thường', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(18, 2, 'C5', 'Thường', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(19, 2, 'D1', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(20, 2, 'D2', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(21, 2, 'D3', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(22, 2, 'D4', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(23, 2, 'D5', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(24, 2, 'E1', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(25, 2, 'E2', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(26, 2, 'E3', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(27, 2, 'E4', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21'),
(28, 2, 'E5', 'Đôi', 0, '2025-08-11 19:33:21', '2025-08-11 19:33:21');

-- --------------------------------------------------------

--
-- Table structure for table `showtimes`
--

CREATE TABLE `showtimes` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `show_date` date DEFAULT NULL,
  `show_time` time DEFAULT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `showtimes`
--

INSERT INTO `showtimes` (`id`, `movie_id`, `room_id`, `show_date`, `show_time`, `price`, `created_at`, `updated_at`) VALUES
(2, 2, 2, '2025-08-15', '19:40:00', 100000, '2025-08-04 03:38:57', '2025-08-07 22:48:22'),
(3, 2, 3, '2025-08-16', '11:46:00', 15000, '2025-08-04 20:45:49', '2025-08-07 23:35:38'),
(4, 2, 2, '2025-08-17', '00:47:00', 60000, '2025-08-07 22:47:31', '2025-08-07 22:47:31'),
(5, 2, 3, '2025-08-19', '02:36:00', 50000, '2025-08-07 23:36:33', '2025-08-07 23:36:33');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `showtime_id` int(11) DEFAULT NULL,
  `seat_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `showtime_id`, `seat_id`, `customer_name`, `customer_email`, `customer_phone`, `created_at`, `updated_at`) VALUES
(2, 4, 3, 2, NULL, NULL, NULL, '2025-08-04 05:03:55', '2025-08-04 21:24:40'),
(3, 3, 2, 2, NULL, NULL, NULL, '2025-08-04 21:08:28', '2025-08-04 21:18:31'),
(4, NULL, 2, 5, NULL, NULL, NULL, '2025-08-12 03:34:15', '2025-08-12 03:34:15'),
(5, NULL, 2, 4, NULL, NULL, NULL, '2025-08-12 03:34:15', '2025-08-12 03:34:15'),
(6, NULL, 2, 6, NULL, NULL, NULL, '2025-08-12 03:36:39', '2025-08-12 03:36:39'),
(7, NULL, 2, 7, NULL, NULL, NULL, '2025-08-12 03:36:39', '2025-08-12 03:36:39'),
(8, NULL, 2, 8, NULL, NULL, NULL, '2025-08-12 03:39:55', '2025-08-12 03:39:55'),
(9, NULL, 2, 13, NULL, NULL, NULL, '2025-08-12 03:39:55', '2025-08-12 03:39:55'),
(10, NULL, 2, 27, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888999', '2025-08-12 03:56:40', '2025-08-12 03:56:40'),
(11, NULL, 2, 26, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888999', '2025-08-12 03:56:40', '2025-08-12 03:56:40'),
(12, 1, 2, 28, NULL, NULL, NULL, '2025-08-12 04:15:22', '2025-08-12 04:15:22'),
(13, 1, 2, 23, NULL, NULL, NULL, '2025-08-12 04:15:22', '2025-08-12 04:15:22'),
(14, NULL, 2, 18, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888999', '2025-08-12 04:22:52', '2025-08-12 04:22:52'),
(15, NULL, 2, 17, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888999', '2025-08-12 04:22:52', '2025-08-12 04:22:52'),
(16, NULL, 2, 16, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888999', '2025-08-12 04:22:52', '2025-08-12 04:22:52'),
(17, NULL, 2, 14, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888999', '2025-08-12 07:20:12', '2025-08-12 07:20:12'),
(18, NULL, 2, 15, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888999', '2025-08-12 07:20:12', '2025-08-12 07:20:12'),
(19, 6, 2, 9, NULL, NULL, NULL, '2025-08-13 04:39:23', '2025-08-13 04:39:23'),
(20, 6, 2, 24, NULL, NULL, NULL, '2025-08-13 04:39:23', '2025-08-13 04:39:23'),
(21, 6, 2, 22, NULL, NULL, '0999888992', '2025-08-13 04:42:42', '2025-08-13 04:42:42'),
(22, 6, 2, 21, NULL, NULL, '0999888992', '2025-08-13 04:42:42', '2025-08-13 04:42:42'),
(23, 6, 2, 20, NULL, NULL, '0999888992', '2025-08-13 04:42:42', '2025-08-13 04:42:42'),
(24, 6, 2, 19, NULL, NULL, '0999888992', '2025-08-13 04:42:42', '2025-08-13 04:42:42'),
(25, NULL, 2, 12, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888991', '2025-08-13 04:45:06', '2025-08-13 04:45:06'),
(26, NULL, 2, 11, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888991', '2025-08-13 04:45:06', '2025-08-13 04:45:06'),
(27, NULL, 2, 10, 'Lại Văn Nam', 'laivannam@gmail.com', '0999888991', '2025-08-13 04:45:06', '2025-08-13 04:45:06');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_codes`
--

CREATE TABLE `ticket_codes` (
  `ticket_id` int(11) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ticket_codes`
--

INSERT INTO `ticket_codes` (`ticket_id`, `code`, `created_at`, `updated_at`) VALUES
(2, 'TKT6890A1AB3E70A', '2025-08-04 05:03:55', '2025-08-04 05:03:55'),
(3, 'TKT689183BCA6E52', '2025-08-04 21:08:28', '2025-08-04 21:08:28'),
(14, 'TKT689B240C8BF1F', '2025-08-12 04:22:52', '2025-08-12 04:22:52'),
(15, 'TKT689B240C9B6A7', '2025-08-12 04:22:52', '2025-08-12 04:22:52'),
(16, 'TKT689B240C9D426', '2025-08-12 04:22:52', '2025-08-12 04:22:52'),
(17, 'TKT689B4D9CE00A4', '2025-08-12 07:20:12', '2025-08-12 07:20:12'),
(18, 'TKT689B4D9CE1BB8', '2025-08-12 07:20:12', '2025-08-12 07:20:12'),
(19, 'TKT689C796B41F57', '2025-08-13 04:39:23', '2025-08-13 04:39:23'),
(20, 'TKT689C796B49E63', '2025-08-13 04:39:23', '2025-08-13 04:39:23'),
(21, 'TKT689C7A32BF600', '2025-08-13 04:42:42', '2025-08-13 04:42:42'),
(22, 'TKT689C7A32C0BF2', '2025-08-13 04:42:42', '2025-08-13 04:42:42'),
(23, 'TKT689C7A32C1CD5', '2025-08-13 04:42:42', '2025-08-13 04:42:42'),
(24, 'TKT689C7A32C3D29', '2025-08-13 04:42:42', '2025-08-13 04:42:42'),
(25, 'TKT689C7AC2D703E', '2025-08-13 04:45:06', '2025-08-13 04:45:06'),
(26, 'TKT689C7AC2D8A72', '2025-08-13 04:45:06', '2025-08-13 04:45:06'),
(27, 'TKT689C7AC2DA1AF', '2025-08-13 04:45:06', '2025-08-13 04:45:06');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_promotions`
--

CREATE TABLE `ticket_promotions` (
  `movie_id` int(11) NOT NULL,
  `promo_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ticket_promotions`
--

INSERT INTO `ticket_promotions` (`movie_id`, `promo_id`, `created_at`, `updated_at`) VALUES
(2, 1, '2025-08-05 05:27:08', '2025-08-05 05:27:08'),
(3, 2, '2025-08-05 05:27:42', '2025-08-09 00:11:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('customer','staff','admin') DEFAULT 'customer',
  `avatar` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2a$10$Ps57KjMNIigT79a5HF0TSe/zJ7KaCEA5F4anpX86Er5QOqSAtfeDS', 'admin@example.com', 'admin', 'storage/uploads/avatars/95vIGv5Pu1cLaPz5rvU4GWXhdZ5wZY3BMmIPK60k.jpg', '2025-08-04 11:43:16', '2025-08-05 04:16:31'),
(2, 'staff01', '$2a$10$Ps57KjMNIigT79a5HF0TSe/zJ7KaCEA5F4anpX86Er5QOqSAtfeDS', 'staff01@example.com', 'staff', NULL, '2025-08-04 11:43:16', '2025-08-04 11:43:16'),
(3, 'john_doe', '$2a$10$Ps57KjMNIigT79a5HF0TSe/zJ7KaCEA5F4anpX86Er5QOqSAtfeDS', 'john.doe@gmail.com', 'customer', NULL, '2025-08-04 11:43:16', '2025-08-04 11:43:16'),
(4, 'jane_smith', '$2a$10$Ps57KjMNIigT79a5HF0TSe/zJ7KaCEA5F4anpX86Er5QOqSAtfeDS', 'jane.smith@yahoo.com', 'customer', NULL, '2025-08-04 11:43:16', '2025-08-04 11:43:16'),
(5, 'tester', '$2a$10$Ps57KjMNIigT79a5HF0TSe/zJ7KaCEA5F4anpX86Er5QOqSAtfeDS', 'tester@gmail.com', 'customer', NULL, '2025-08-04 11:43:16', '2025-08-04 11:43:16'),
(6, 'nguyenvana', '$2y$10$Ez.bAEzHKDjeCv93M1IEseisc55nl6i1uI96rxHM/ASRIthYFjpZi', 'laivannam@gmail.com', 'customer', '/storage/avatars/aRsEcOTH98vMmR2BfxjuYiCF0WCsyAtnqNj6A10I.jpg', '2025-08-04 23:51:25', '2025-08-13 03:56:55'),
(7, 'laivannam2', '$2y$10$fJyOs08qDrMkxZ51ao45W.fj3aswrkKi3zk5y3MP2MI59ilxnSqnG', 'laivannam2@gmail.com', 'customer', NULL, '2025-08-13 04:25:29', '2025-08-13 04:25:29'),
(8, 'laivannam3', '$2y$10$3NOxjw0c9v8EW9/ZCulO5upl4U1eGQEFNwvpMKhcgGp0mbTzQ02Oq', 'laivannam3@gmail.com', 'customer', 'storage/avatars/no-avatar.png', '2025-08-13 04:28:20', '2025-08-13 04:28:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_history`
--
ALTER TABLE `booking_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexes for table `cinemas`
--
ALTER TABLE `cinemas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cinema_id` (`cinema_id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `showtimes`
--
ALTER TABLE `showtimes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `showtime_id` (`showtime_id`),
  ADD KEY `seat_id` (`seat_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ticket_codes`
--
ALTER TABLE `ticket_codes`
  ADD PRIMARY KEY (`ticket_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `ticket_promotions`
--
ALTER TABLE `ticket_promotions`
  ADD PRIMARY KEY (`movie_id`,`promo_id`),
  ADD KEY `promo_id` (`promo_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_history`
--
ALTER TABLE `booking_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cinemas`
--
ALTER TABLE `cinemas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `showtimes`
--
ALTER TABLE `showtimes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_history`
--
ALTER TABLE `booking_history`
  ADD CONSTRAINT `booking_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `booking_history_ibfk_2` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`cinema_id`) REFERENCES `cinemas` (`id`);

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `showtimes`
--
ALTER TABLE `showtimes`
  ADD CONSTRAINT `showtimes_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`),
  ADD CONSTRAINT `showtimes_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`showtime_id`) REFERENCES `showtimes` (`id`),
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`id`),
  ADD CONSTRAINT `tickets_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ticket_codes`
--
ALTER TABLE `ticket_codes`
  ADD CONSTRAINT `ticket_codes_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`);

--
-- Constraints for table `ticket_promotions`
--
ALTER TABLE `ticket_promotions`
  ADD CONSTRAINT `ticket_promotions_ibfk_2` FOREIGN KEY (`promo_id`) REFERENCES `promotions` (`id`),
  ADD CONSTRAINT `ticket_promotions_ibfk_3` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
