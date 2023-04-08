-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2023 at 03:33 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `laundry_requests`
--

CREATE TABLE `laundry_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `pickup_time` time NOT NULL,
  `delivery_date` date NOT NULL,
  `delivery_time` time NOT NULL,
  `wash_fold` int(11) NOT NULL,
  `wash_iron` int(11) NOT NULL,
  `dry_clean` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laundry_requests`
--

INSERT INTO `laundry_requests` (`id`, `user_id`, `pickup_date`, `pickup_time`, `delivery_date`, `delivery_time`, `wash_fold`, `wash_iron`, `dry_clean`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, '2023-04-08', '10:00:00', '2023-04-10', '10:00:00', 3, 5, 1, '0.00', 'confirm', '2023-04-07 05:54:11', '2023-04-08 06:09:14'),
(2, 5, '2023-04-08', '12:00:00', '2023-04-14', '12:00:00', 3, 9, 2, '29.50', 'confirm', '2023-04-07 11:36:39', '2023-04-08 06:26:07'),
(3, 5, '2023-04-10', '11:01:00', '2023-04-15', '12:02:00', 7, 6, 3, '285.00', 'confirm', '2023-04-08 06:37:19', '2023-04-08 07:38:29');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `read_status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `request_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `read_status`, `created_at`, `request_id`) VALUES
(133, 5, 'Your laundry request with ID 3 has been Confirm', 0, '2023-04-08 07:51:00', 0),
(134, 5, 'Your laundry request with ID 2 has been Confirm', 0, '2023-04-08 07:51:00', 0),
(135, 5, 'Your laundry request with ID 1 has been Confirm', 0, '2023-04-08 07:51:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `reset_token`) VALUES
(1, '', '', '', NULL),
(2, '', '', '', NULL),
(3, '', '', '', NULL),
(4, '', '', '', NULL),
(5, 'satabdi rath', 'satabdirath2000@gmail.com', 'sss', '242c92819af915e549616d998f3a8027'),
(6, 'minati rath', 'minatirath@gmail.com', 'mmm', NULL),
(7, 'satabdi', 'fff@example.com', 'rrrr', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `laundry_requests`
--
ALTER TABLE `laundry_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `laundry_requests`
--
ALTER TABLE `laundry_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `laundry_requests`
--
ALTER TABLE `laundry_requests`
  ADD CONSTRAINT `laundry_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
