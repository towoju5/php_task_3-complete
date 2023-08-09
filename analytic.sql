-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 09, 2023 at 04:56 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `analytic`
--

-- --------------------------------------------------------

--
-- Table structure for table `analytic`
--

CREATE TABLE `analytic` (
  `id` int(11) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `widget_name` varchar(255) NOT NULL,
  `browser_type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `analytic`
--

INSERT INTO `analytic` (`id`, `create_at`, `widget_name`, `browser_type`) VALUES
(1, '2023-08-08 21:30:58', 'test', 'sample record'),
(2, '2023-08-09 14:04:22', 'weather-info', 'Mozilla Firefox'),
(3, '2023-08-09 14:04:30', 'nigeria-time', 'Mozilla Firefox'),
(4, '2023-08-09 14:51:58', 'xml-export', 'Mozilla Firefox'),
(5, '2023-08-09 14:52:01', 'undefined', 'Mozilla Firefox'),
(6, '2023-08-09 14:52:01', 'undefined', 'Mozilla Firefox'),
(7, '2023-08-09 14:52:26', 'undefined', 'Mozilla Firefox'),
(8, '2023-08-09 14:52:31', 'undefined', 'Mozilla Firefox'),
(9, '2023-08-09 14:52:32', 'undefined', 'Mozilla Firefox'),
(10, '2023-08-09 14:52:43', 'undefined', 'Mozilla Firefox'),
(11, '2023-08-09 14:52:47', 'airport-search-form', 'Mozilla Firefox'),
(12, '2023-08-09 14:52:54', 'airport-search-form', 'Mozilla Firefox'),
(13, '2023-08-09 14:52:58', 'artic-distance', 'Mozilla Firefox'),
(14, '2023-08-09 14:52:59', 'artic-distance', 'Mozilla Firefox');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `chat_messages` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `created_at`, `chat_messages`) VALUES
(1, '2023-08-09 11:34:22', 'sdf'),
(2, '2023-08-09 11:34:27', 'sf'),
(3, '2023-08-09 11:34:57', 's'),
(4, '2023-08-09 11:38:22', 'SFDAS'),
(5, '2023-08-09 11:38:27', 'i tried my best'),
(6, '2023-08-09 11:38:50', 'is that long pull working now'),
(7, '2023-08-09 11:38:57', 'yeah dude'),
(8, '2023-08-09 11:40:01', 'okay bro'),
(9, '2023-08-09 11:40:15', 'I\'m. finally. happy with. this'),
(10, '2023-08-09 14:03:15', 'kp');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `filename` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `filename`, `updated_at`) VALUES
(1, 'uploads/download.png', '2023-08-09 14:52:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `analytic`
--
ALTER TABLE `analytic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `analytic`
--
ALTER TABLE `analytic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
