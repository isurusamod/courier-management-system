-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2024 at 12:27 PM
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
-- Database: `courier_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `tracking_number` varchar(100) NOT NULL,
  `sender_name` varchar(100) DEFAULT NULL,
  `recipient_name` varchar(100) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `status` enum('pending','in-transit','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `tracking_number`, `sender_name`, `recipient_name`, `destination`, `status`, `created_at`, `updated_at`) VALUES
(7, '66f115f417734', 'samod', 'isuru', 'unawtuna rambukkana', 'pending', '2024-09-23 07:17:08', '2024-09-23 07:17:08'),
(8, '66f1166bd341b', 'samod', 'isuru', 'unawtuna rambukkana', 'pending', '2024-09-23 07:19:07', '2024-09-23 07:19:07'),
(9, '66f1169a7ef26', 'samod', 'isuru', 'unawtuna rambukkana', 'pending', '2024-09-23 07:19:54', '2024-09-23 07:19:54'),
(10, '66f116b015bfc', 'samod', 'isuru', 'unawtuna rambukkana', 'pending', '2024-09-23 07:20:16', '2024-09-23 07:20:16'),
(11, '66f116b78e395', 'samod', 'isuru', 'unawtuna rambukkana', 'pending', '2024-09-23 07:20:23', '2024-09-23 07:20:23'),
(12, '66f11951714dc', 'samod', 'isuru', 'unawtuna rambukkana', 'pending', '2024-09-23 07:31:29', '2024-09-23 07:31:29'),
(13, '66f11956e3991', 'samod', 'isuru', 'unawtuna rambukkana', 'pending', '2024-09-23 07:31:34', '2024-09-23 07:31:34'),
(14, '66f1198ae12cd', 'samod', 'isuru', 'unawtuna rambukkana', 'pending', '2024-09-23 07:32:26', '2024-09-23 07:32:26'),
(15, '66f1199eb90ca', 'samod', 'isuru', 'unawtuna rambukkana', 'pending', '2024-09-23 07:32:46', '2024-09-23 07:32:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee','customer') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(9, 'isuru', 'isuru@gmail.com', '$2y$10$Yb8hdBqNAnzxVUG9FiKix.DOeZ9djDDNTdq4SI0hWkz6jBg7Y6Qc2', 'customer', '2024-09-23 07:16:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tracking_number` (`tracking_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
