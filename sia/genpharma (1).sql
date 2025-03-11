-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2024 at 03:59 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `genpharma`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_items`
--

CREATE TABLE `add_items` (
  `product_Id` int(11) NOT NULL,
  `category` varchar(75) NOT NULL,
  `product_name` varchar(75) NOT NULL,
  `description` varchar(75) NOT NULL,
  `quantity` int(75) NOT NULL,
  `price` int(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `app_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `des_pos` varchar(60) NOT NULL,
  `status` varchar(50) NOT NULL,
  `resume` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `att_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `department` varchar(70) NOT NULL,
  `time_in` varchar(50) NOT NULL,
  `time_out` varchar(50) NOT NULL,
  `in_status` varchar(50) NOT NULL,
  `out_status` varchar(50) NOT NULL,
  `shift_hours` int(11) NOT NULL,
  `total_hours` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `note` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `email`, `address`, `code`, `note`) VALUES
(1, 'ben', 989898, 'ben@gmail.com', 'tarlac', 45554, 'hotdog'),
(2, 'sett', 65884, 'dela cruz', 'bacolor pampanga', 0, 'hotdog'),
(4, 'PJ', 85789, 'pj@gmail.com', 'Concepcion, Tarlac', 6585, 'fishfillet'),
(6, 'breth', 23232, 'breth@gmail.com', 'san fernando', 69894, 'weqwewqe'),
(7, 'qwerty', 987545745, 'qwerty@gmail.com', 'san fernando', 8888, 'i like milk'),
(8, 'qwerty12', 85789, 'qwerty12@gmail.com', 'san fernando', 123456, 'woewqoeiwq');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `deptproj_id` int(11) NOT NULL,
  `department` varchar(50) NOT NULL,
  `project` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(50) NOT NULL,
  `budget` varchar(50) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `start` varchar(50) NOT NULL,
  `end` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `emp_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `suffix` varchar(10) NOT NULL,
  `fullname` varchar(70) NOT NULL,
  `email` varchar(70) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `marital_status` varchar(50) NOT NULL,
  `department` varchar(70) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `address` varchar(150) NOT NULL,
  `hire_date` date NOT NULL,
  `emp_status` varchar(50) NOT NULL,
  `shift_per_day` varchar(10) NOT NULL,
  `shift_start` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `monthly_salary` int(50) NOT NULL,
  `photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emp_leave`
--

CREATE TABLE `emp_leave` (
  `leave_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `start` varchar(50) NOT NULL,
  `end` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `product_Id` int(50) NOT NULL,
  `category` varchar(75) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `description` varchar(75) NOT NULL,
  `quantity` int(75) NOT NULL,
  `price` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`product_Id`, `category`, `product_name`, `description`, `quantity`, `price`) VALUES
(1, 'Antacids', 'asd', 'asd', 49, '100'),
(2, 'Analgesics', 'Ad', '25', 100, '1000');

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) UNSIGNED NOT NULL,
  `material` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `expiry_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `material`, `quantity`, `date`, `expiry_date`) VALUES
(1, 'Ibuprofen', '20', '2024-05-11 01:12:20', '2029-05-12');

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `id` int(11) NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `quantity` int(14) NOT NULL,
  `type` varchar(255) NOT NULL,
  `dosage` int(13) NOT NULL,
  `prescription` varchar(20) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  `expiry_date` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `sent` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`id`, `medicine_name`, `quantity`, `type`, `dosage`, `prescription`, `date_created`, `expiry_date`, `status`, `sent`) VALUES
(170, 'Vestar', 40, 'Cardio', 30, 'Need', '2024-05-15', '2026-05-06', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ordered_items`
--

CREATE TABLE `ordered_items` (
  `product_Id` int(11) NOT NULL,
  `category` varchar(75) NOT NULL,
  `product_name` varchar(75) NOT NULL,
  `description` varchar(75) NOT NULL,
  `quantity` varchar(75) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ordered_items`
--

INSERT INTO `ordered_items` (`product_Id`, `category`, `product_name`, `description`, `quantity`, `date`, `status`) VALUES
(1, 'Analgesics', 'Haha', '213', '123', '2024-05-15 17:56:36', 2),
(2, 'Analgesics', 'asd', '12', '123', '2024-05-15 17:07:15', 2),
(3, 'Analgesics', 'asd', 'asd', '123', '2024-05-15 17:07:15', 2),
(4, 'Analgesics', 'asd', '1235', '300', '2024-05-15 17:07:16', 2),
(5, 'Analgesics', 'Ad', '100', '500', '2024-05-15 17:07:16', 2),
(6, 'Antianxiety Drugs', 'Ad', '450', '350', '2024-05-15 17:07:16', 2),
(9, 'tiutan gel', 'biogesic', 'ewan', '50', '2024-05-15 17:07:17', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ordertb`
--

CREATE TABLE `ordertb` (
  `product_Id` int(50) NOT NULL,
  `category` varchar(75) NOT NULL,
  `product_name` varchar(70) NOT NULL,
  `description` varchar(250) NOT NULL,
  `quantity` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `payroll_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `whole_salary` int(11) NOT NULL,
  `bonus` int(11) NOT NULL,
  `deduction` int(11) NOT NULL,
  `total_salary` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `performance`
--

CREATE TABLE `performance` (
  `perf_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `department` varchar(70) NOT NULL,
  `date` date NOT NULL,
  `qua_work` int(11) NOT NULL,
  `char_rate` int(11) NOT NULL,
  `inter_rel` int(11) NOT NULL,
  `creativity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_history`
--

CREATE TABLE `purchase_history` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `code` int(11) NOT NULL,
  `totalcost` float NOT NULL DEFAULT 0,
  `purchase_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_history`
--

INSERT INTO `purchase_history` (`id`, `name`, `code`, `totalcost`, `purchase_date`) VALUES
(1, 'ben', 0, 150, '2021-11-02 10:01:55'),
(2, 'ben', 0, 200, '2021-11-02 10:02:12'),
(3, 'ben', 0, 185, '2021-11-02 10:02:27'),
(4, 'qwerty', 0, 205, '2021-11-02 10:02:47'),
(6, 'asdf', 0, 300, '2024-03-22 11:22:36');

-- --------------------------------------------------------

--
-- Table structure for table `sia_order`
--

CREATE TABLE `sia_order` (
  `id` int(11) NOT NULL,
  `Ingredient` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sia_order`
--

INSERT INTO `sia_order` (`id`, `Ingredient`, `quantity`, `date`) VALUES
(1, 'Ibuprofen', '25', '2024-05-11 01:25:22'),
(2, '', '', '2024-05-11 02:41:03'),
(3, 'HEHE', '40', '2024-05-15 22:30:43');

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `id` int(11) NOT NULL,
  `medicine_name` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(5) NOT NULL DEFAULT 0,
  `expiry_date` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `sent` int(10) NOT NULL,
  `dosage` int(45) NOT NULL,
  `prescription` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`id`, `medicine_name`, `quantity`, `date_created`, `status`, `expiry_date`, `type`, `sent`, `dosage`, `prescription`) VALUES
(170, 'Vestar', '40', '2024-05-15', 4, '2026-05-06', 'Cardio', 0, 30, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_items`
--
ALTER TABLE `add_items`
  ADD PRIMARY KEY (`product_Id`);

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`att_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`deptproj_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `emp_leave`
--
ALTER TABLE `emp_leave`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`product_Id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ordered_items`
--
ALTER TABLE `ordered_items`
  ADD PRIMARY KEY (`product_Id`);

--
-- Indexes for table `ordertb`
--
ALTER TABLE `ordertb`
  ADD PRIMARY KEY (`product_Id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`payroll_id`);

--
-- Indexes for table `performance`
--
ALTER TABLE `performance`
  ADD PRIMARY KEY (`perf_id`);

--
-- Indexes for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sia_order`
--
ALTER TABLE `sia_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_items`
--
ALTER TABLE `add_items`
  MODIFY `product_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `att_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `deptproj_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `emp_leave`
--
ALTER TABLE `emp_leave`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `product_Id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `ordered_items`
--
ALTER TABLE `ordered_items`
  MODIFY `product_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ordertb`
--
ALTER TABLE `ordertb`
  MODIFY `product_Id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `payroll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `performance`
--
ALTER TABLE `performance`
  MODIFY `perf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sia_order`
--
ALTER TABLE `sia_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `warehouse`
--
ALTER TABLE `warehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
