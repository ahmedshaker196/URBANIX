-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2025 at 04:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `urbanix`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `session_id`, `created_at`) VALUES
(1, 'gcndg8rnlll3h0ln9gqg4vbne5', '2025-12-08 15:23:48');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `price_at_added` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `qty`, `price_at_added`, `created_at`) VALUES
(2, 1, 7, 14, 500.00, '2025-12-10 17:50:44'),
(4, 1, 2, 1, 750.00, '2025-12-10 17:54:51'),
(5, 1, 8, 1, 600.00, '2025-12-10 17:55:33'),
(6, 1, 1, 2, 500.00, '2025-12-10 23:46:41'),
(7, 1, 10, 1, 650.00, '2025-12-10 23:56:03');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `message_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `interest` varchar(100) DEFAULT NULL,
  `timeline` varchar(50) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('new','read','replied') DEFAULT 'new',
  `agree_marketing` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`message_id`, `first_name`, `last_name`, `email`, `city`, `interest`, `timeline`, `message`, `status`, `agree_marketing`, `created_at`) VALUES
(1, 'message_id', 'message_id', 'ibrahim@78gmial.com', 'cairo', 'Clothing', 'Within 1 week', 'asfgasdg', 'new', 0, '2025-12-11 03:44:05');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_number` varchar(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `discount` decimal(10,0) NOT NULL,
  `shipping_address` text DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `is_new` tinyint(1) NOT NULL,
  `image` varchar(500) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stock`, `is_new`, `image`, `description`, `created_at`) VALUES
(1, 'Loose Sweater', 500.00, 0, 0, 'images/black-sweater.jpg', '', '2025-12-05 13:44:48'),
(2, 'Cut Out Hoodie', 750.00, 0, 0, 'images/Cut Out Drawstring Asymmetrical Hoodie.jpg', '', '2025-12-05 13:44:48'),
(3, 'cartier stainless steel bracelet', 210.00, 0, 0, 'images/cartier.jpg', '', '2025-12-05 13:44:48'),
(4, 'adidas Original Samba', 1600.00, 0, 0, 'images/samba.jpg', '', '2025-12-05 13:44:48'),
(5, 'Casio Vintage', 990.00, 0, 0, 'images/casio.jpg', '', '2025-12-05 13:44:48'),
(6, 'Loose Sweater', 490.00, 0, 0, 'images/e5c121a6ee210a221930f410e5fa4111.jpg', '', '2025-12-05 13:44:48'),
(7, 'Loose Sweater', 500.00, 0, 0, 'images/black-sweater.jpg', '', '2025-12-05 13:44:48'),
(8, 'Workaction Hoodie', 600.00, 0, 0, 'images/Workaction Hoodie.jpg', '', '2025-12-05 13:44:48'),
(9, 'Ski Jump Hoodie', 800.00, 0, 0, 'images/SkiJumpHoodie.jpg', 'new', '2025-12-05 13:44:48'),
(10, 'cropped zip hoodies', 650.00, 0, 0, 'images/cropped zip hoodies.jpg', '', '2025-12-05 13:44:48'),
(11, 'Cozy Striped Sweater With Zipper', 420.00, 0, 0, 'images/CozyStripedSweaterWithZipper.jpg', '', '2025-12-05 13:44:48'),
(12, 'Baggy Hoodie Set', 830.00, 0, 0, 'images/BasicBaggyHoodieSet.jpg', 'new', '2025-12-05 13:44:48'),
(13, 'ZipUp Jacket', 500.00, 0, 0, 'images/b34f7f8298d5cc06179f8c1289098e15.jpg', '', '2025-12-05 13:44:48'),
(14, 'Basic Sweater', 335.00, 0, 0, 'images/BasicSweater.jpg', '', '2025-12-05 13:44:48'),
(15, 'Short Jacket', 610.00, 0, 0, 'images/ShortJacket.webp', 'new', '2025-12-05 13:44:48'),
(16, 'Blanket Stitch Wrap Jacket', 770.00, 0, 0, 'images/Blanket Stitch Wrap Jacket.jpg', 'new', '2025-12-05 13:44:48'),
(17, 'Cut Out Hoodie', 750.00, 0, 0, 'images/Cut Out Drawstring Asymmetrical Hoodie.jpg', '', '2025-12-05 13:44:48'),
(18, 'Long Sleeve Hoody Pullovers', 590.00, 0, 0, 'images/Long Sleeve Hoody Pullovers.webp', '', '2025-12-05 13:44:48'),
(19, 'Blur Oversized Fit T-Shirt', 400.00, 0, 0, 'images/Blur Oversized Fit T-Shirt.jpg', '', '2025-12-05 13:44:48'),
(20, 'Heavyweight Short Sleeve Shirt', 430.00, 0, 0, 'images/Heavyweight Short Sleeve Shirt.jpg', '', '2025-12-05 13:44:48'),
(21, 'Summer Oversized T-Shirt', 390.00, 0, 0, 'images/Another Sweet Summer Oversized T-Shirt.jpg', '', '2025-12-05 13:44:48'),
(22, 'Blur Oversized T-Shirt', 450.00, 0, 0, 'images/Blur Oversized T-Shirt.jpg', '', '2025-12-05 13:44:48'),
(23, 'Polo T-shirt', 480.00, 0, 0, 'images/poloT-shirt.jpg', '', '2025-12-05 13:44:48'),
(24, 'Hoop Earrings', 220.00, 0, 0, 'images/Gold Hoop Earrings.jpg', '', '2025-12-05 13:44:48'),
(25, 'Juste Un Clou bracelet', 135.00, 0, 0, 'images/Juste un Clou bracelet.jpg', '', '2025-12-05 13:44:48'),
(26, 'Dainty Bracelet', 200.00, 0, 0, 'images/Dainty Bracelet.jpg', 'new', '2025-12-05 13:44:48'),
(27, 'North Star Necklace', 350.00, 0, 0, 'images/NorthStarNecklace.jpg', 'new', '2025-12-05 13:44:48'),
(28, 'Open Circle Necklace', 115.00, 0, 0, 'images/Open Circle Necklace.webp', '', '2025-12-05 13:44:48'),
(29, 'CHIC CHUNKY RINGS SET', 90.00, 0, 0, 'images/CHIC CHUNKY RINGS SET.jpg', '(for piece)', '2025-12-05 13:44:48'),
(30, 'Bella Leather Watch', 1200.00, 0, 0, 'images/Bella Leather Watch.webp', '', '2025-12-05 13:44:48'),
(31, 'Mini Classic Gold White 31mm', 1335.00, 0, 0, 'images/Mini Classic Gold White 31mm.jpg', '', '2025-12-05 13:44:48'),
(32, 'SLisbon Leather Watch', 1100.00, 0, 0, 'images/Lisbon Leather Watch.webp', '', '2025-12-05 13:44:48'),
(33, 'Casio Vintage', 990.00, 0, 0, 'images/casio.jpg', '', '2025-12-05 13:44:48'),
(34, 'Casio Duo Watch', 1400.00, 0, 0, 'images/Casio Duo Watch.jpg', '', '2025-12-05 13:44:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', 'admin@admin.com', '$2y$10$wS0SfAmZTeVOcpxfolpPH.AJpL.q3j44nyCggJsC7Xmx7Ij9n7kPW', 'admin', '2025-12-05 15:23:46', '2025-12-11 03:16:39'),
(2, 'mohamed', 'mohamed', 'mo@gmail.com', '$2y$10$5SL.tSok30AXfCMRuGZlde98Q9vbSX9pRI3NbT6LdIp/duGsGas8K', 'user', '2025-12-11 03:42:57', '2025-12-11 03:42:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_id` (`session_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
