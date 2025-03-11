-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2024 at 07:19 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `code` int(11) NOT NULL,
  `note` varchar(255) NOT NULL,
  `points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `email`, `address`, `code`, `note`, `points`) VALUES
(1, 'ben', 989898, 'ben@gmail.com', 'tarlac', 45554, 'hotdog', 0),
(2, 'sett', 65884, 'dela cruz', 'bacolor pampanga', 2856, 'hotdog', 10),
(4, 'PJ', 85789, 'pj@gmail.com', 'Concepcion, Tarlac', 6585, 'fishfillet', 0),
(6, 'breth', 23232, 'breth@gmail.com', 'san fernando', 69894, 'weqwewqe', 0),
(7, 'qwerty', 987545745, 'qwerty@gmail.com', 'san fernando', 8888, 'i like milk', 0),
(8, 'juan', 2322858, 'juandelacruz22222@gmail.com', 'bacolor', 1, '2323222', 0),
(10, 'juan2', 85789, 'pj22112@gmail.com', 'Concepcion, Tarlac', 23232, '22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `p_name` varchar(50) NOT NULL,
  `p_brand` varchar(50) NOT NULL,
  `p_stocks` int(11) NOT NULL,
  `p_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `p_name`, `p_brand`, `p_stocks`, `p_price`) VALUES
(1, 'amlodiphine', 'generic', 100, 10),
(2, 'biogesic', 'branded', 100, 8),
(3, 'bioflu', 'generic', 250, 12);

-- --------------------------------------------------------

--
-- Table structure for table `product_add`
--

CREATE TABLE `product_add` (
  `id` int(11) NOT NULL,
  `t_product` varchar(50) NOT NULL,
  `t_brand` varchar(50) NOT NULL,
  `t_price` int(11) NOT NULL,
  `t_quantity` int(11) NOT NULL,
  `t_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_history`
--

CREATE TABLE `product_history` (
  `id` int(11) NOT NULL,
  `name_product` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_history`
--

INSERT INTO `product_history` (`id`, `name_product`, `quantity`, `total_price`, `code`) VALUES
(1, 'biogesic', 10, 80, 45554),
(2, 'biogesic', 15, 120, 45554),
(3, 'amlodiphine', 10, 100, 0),
(4, 'amlodiphine', 10, 100, 0),
(5, 'bioflu', 20, 240, 0),
(6, 'amlodiphine', 2, 20, 0),
(7, 'biogesic', 3, 24, 0),
(8, 'bioflu', 4, 48, 0),
(9, 'biogesic', 10, 80, 0),
(10, 'bioflu', 10, 120, 0),
(11, 'amlodiphine', 10, 100, 0),
(12, 'biogesic', 10, 80, 0),
(13, 'bioflu', 10, 120, 0),
(14, 'amlodiphine', 10, 100, 0),
(15, 'biogesic', 10, 80, 0),
(16, 'biogesic', 10, 80, 0),
(17, 'biogesic', 100, 800, 45554);

-- --------------------------------------------------------

--
-- Table structure for table `product_order`
--

CREATE TABLE `product_order` (
  `id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_history`
--

CREATE TABLE `purchase_history` (
  `id` int(30) NOT NULL,
  `customer` text NOT NULL,
  `code` int(11) NOT NULL,
  `totalcost` float NOT NULL DEFAULT 0,
  `amountpaid` int(11) NOT NULL,
  `change_amount` int(11) NOT NULL,
  `purchase_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_history`
--

INSERT INTO `purchase_history` (`id`, `customer`, `code`, `totalcost`, `amountpaid`, `change_amount`, `purchase_date`) VALUES
(1, 'ben', 45554, 150, 0, 0, '2021-11-02 10:01:55'),
(2, 'ben', 45554, 200, 0, 0, '2021-11-02 10:02:12'),
(3, 'ben', 45554, 185, 0, 0, '2021-11-02 10:02:27'),
(4, 'qwerty', 8888, 205, 0, 0, '2021-11-02 10:02:47'),
(6, 'asdf', 8888, 300, 0, 0, '2024-03-22 11:22:36'),
(10, 'sett', 45554, 200, 1000, 800, '2024-05-16 00:30:50'),
(11, 'sett', 45554, 200, 1000, 800, '2024-05-16 00:32:59'),
(12, 'sett', 45554, 200, 1000, 800, '2024-05-16 00:34:16'),
(21, 'ben', 45554, 800, 900, 100, '2024-05-16 01:14:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_add`
--
ALTER TABLE `product_add`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_history`
--
ALTER TABLE `product_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_order`
--
ALTER TABLE `product_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_add`
--
ALTER TABLE `product_add`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `product_history`
--
ALTER TABLE `product_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product_order`
--
ALTER TABLE `product_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
