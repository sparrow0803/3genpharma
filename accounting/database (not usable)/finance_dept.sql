-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2024 at 09:19 AM
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
-- Database: `finance_dept`
--

-- --------------------------------------------------------

--
-- Table structure for table `balance_sheet`
--

CREATE TABLE `balance_sheet` (
  `accounts` text NOT NULL,
  `description` text NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `balance_sheet`
--

INSERT INTO `balance_sheet` (`accounts`, `description`, `amount`) VALUES
('Current Assets', 'Cash', 0),
('Current Assets', 'Accounts Receivable', 0),
('Current Assets', 'Inventory', 0),
('Current Assets', 'Investments', 0),
('Long-Term Assets', 'Land', 0),
('Long-Term Assets', 'Buildings', 0),
('Long-Term Assets', 'Equipments', 0),
('Current Liabilities', 'Accounts Payable', 0),
('Current Liabilities', 'Tax', 0),
('Current Liabilities', 'Notes Payable', 0),
('Current Liabilities', 'Accrued Expenses', 0),
('Long-Term Liabilities', 'Bonds Payable', 0),
('Long-Term Liabilities', 'Loans Payable', 0),
('Long-Term Liabilities', 'Pensions', 0),
('Equity', 'Equity Capital', 0),
('Equity', 'Retained Earnings', 0);

-- --------------------------------------------------------

--
-- Table structure for table `general_ledger`
--

CREATE TABLE `general_ledger` (
  `date` date NOT NULL,
  `account` text NOT NULL,
  `description` text NOT NULL,
  `debit` int(11) NOT NULL,
  `credit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
