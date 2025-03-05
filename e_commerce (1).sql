-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2025 at 12:06 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_commerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL CHECK (`quantity` > 0),
  `size` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `size_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `quantity`, `size`, `created_at`, `size_id`) VALUES
(2, 9, 7, 1, '', '2025-02-11 17:56:51', 1),
(5, 12, 7, 1, '', '2025-02-11 18:05:59', 2),
(8, 13, 8, 1, '', '2025-02-11 18:08:11', 1),
(10, 6, 7, 1, '', '2025-03-01 11:00:13', 1),
(11, 6, 8, 1, '', '2025-03-01 11:00:18', 1),
(12, 6, 8, 1, '', '2025-03-01 11:00:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `size` enum('Small','Medium','Large') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `size`) VALUES
(7, 'abcd', 'Ahsan', '12.07', 'product3.jpg', 'Small'),
(8, 'copy', 'Shaheer', '0.24', 'product4.jpg', 'Medium'),
(13, 'aslam', 'Momin', '16.00', 'product5.jpg', 'Medium');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` int(11) NOT NULL,
  `size_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `size_name`) VALUES
(1, 'Small'),
(2, 'Medium'),
(3, 'Large');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'Ahsan', 'Ahsan@gmail.com', '$2y$10$fJwWeg38vErU8mAik3/LXuE7TawLYGr6vtsHvfmq1fBWXSSHZGypO', 'user'),
(4, 'Shaheer', 'fff@gmail.com', '$2y$10$29A6yKUBRKJO87A5244cEeaSqfuSIdGfZYpCNiQU5EOQVKwF.GUre', 'user'),
(5, 'Momin', 'hussainsajjad10999888910@gmail.com', '$2y$10$tgAwQaXcr8u2UVL3JExRC.Jg.UIvVc1HALExn/C5fm8i6YUOqZdKe', 'user'),
(6, 'hussain', 'mazz@gmail.com', '$2y$10$tFo3c4tpmogDQ.U/JBEEUund/.nI9L53Vxp7RnkBOU67NvsF6G2I6', 'user'),
(7, 'sajjadeeee', 'sajjad@gmail.com', '$2y$10$p4cPw9aZwQfoRl8VNaBY6O1F5lo5p39Csmc9nRBmL0m2QMF3IRSfC', 'user'),
(8, 'sajjadali', 'sajjadali@gmail.com', '$2y$10$3B4HnmVlS964Z5GgfMHspOPPdWEOCT/fpBkM6xOu1Ey0QOJuC1raO', 'user'),
(9, 'asim javed', 'assim@gmail.com', '$2y$10$btlwhnwlrj2jqHjV5BTiiequksUGxwwxaafIZnCdcXEfiEiKkg7ry', 'user'),
(10, 'sajjadee ali', 'alisajjad@gmail.com', '$2y$10$qhwLNHkgtz6ja6yUlHhIVubo4VyvUuToa1ba5iTWN7J.0QQCKvqRe', 'user'),
(11, 'ahmad ali', 'ahmad@gmail.com', '$2y$10$Ch.6wEvntvbpEUkWto8Gf.2zYoI/4Ht.UJi1qUhPsSZQT/aeaSwRG', 'user'),
(12, 'ghulam abbas', 'ghulam@gamil.com', '$2y$10$trjkb4xPdtam4q.fdszVk.W4v7vx1mGJALFdox4jMPWU1J7peFrMq', 'user'),
(13, 'abcd', 'abcd@gamil.com', '$2y$10$ucT6FlbwOX80EuBhD0g8C.iUZKjbalyX.dMfgZIVV8QhxBWRB1gg6', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_user` (`user_id`),
  ADD KEY `fk_cart_product` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `fk_cart_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
