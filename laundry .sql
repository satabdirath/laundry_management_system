-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2025 at 01:06 PM
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
(1, 6, '2025-01-05', '10:00:00', '2025-01-06', '18:00:00', 3, 2, 1, 150.00, 'Pending', '2025-01-09 10:36:10', '2025-01-09 10:36:10'),
(2, 6, '2025-01-10', '09:30:00', '2025-01-11', '17:30:00', 5, 3, 2, 200.00, 'Completed', '2025-01-09 10:36:10', '2025-01-09 10:36:10'),
(3, 7, '2025-01-15', '11:00:00', '2025-01-16', '19:00:00', 2, 4, 1, 180.00, 'In Progress', '2025-01-09 10:36:10', '2025-01-09 10:36:10'),
(4, 6, '2024-12-12', '14:00:00', '2024-12-13', '20:00:00', 4, 1, 0, 100.00, 'Cancelled', '2025-01-09 10:36:10', '2025-01-09 10:36:10'),
(5, 7, '2024-12-20', '15:00:00', '2024-12-21', '18:30:00', 3, 2, 1, 170.00, 'Pending', '2025-01-09 10:36:10', '2025-01-09 10:36:10'),
(6, 6, '2025-03-10', '13:00:00', '2025-03-11', '16:00:00', 2, 3, 0, 120.00, 'Completed', '2025-01-09 10:36:10', '2025-01-09 10:36:10'),
(7, 7, '2025-05-22', '09:00:00', '2025-05-23', '15:30:00', 4, 5, 2, 250.00, 'Pending', '2025-01-09 10:36:10', '2025-01-09 10:36:10'),
(8, 6, '2024-06-18', '10:30:00', '2024-06-19', '17:00:00', 3, 2, 1, 160.00, 'Completed', '2025-01-09 10:36:10', '2025-01-09 10:36:10'),
(9, 6, '2024-09-15', '14:00:00', '2024-09-16', '19:30:00', 1, 1, 0, 80.00, 'Cancelled', '2025-01-09 10:36:10', '2025-01-09 10:36:10'),
(10, 6, '2024-11-25', '11:00:00', '2024-11-26', '16:30:00', 5, 4, 3, 300.00, 'In Progress', '2025-01-09 10:36:10', '2025-01-09 10:36:10');

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
  `reset_token` varchar(255) DEFAULT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `user_Type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `reset_token`, `phone`, `address`, `user_Type`) VALUES
(5, 'satabdi rath', 'satabdirath2000@gmail.com', 'sss', '242c92819af915e549616d998f3a8027', NULL, NULL, 1),
(6, 'john doe', 'john@gmail.com', 'mmm', NULL, 9147483647, '554 Middle Street, Cheyenne, Colorado - 43727, Singapore', 0),
(7, 'jon smith', 'john smith@example.com', 'rrrr', NULL, 9876543210, '77950 Warren Close, Huntington Park, New York - 93067, Bangladesh', 0),
(8, 'Alice Brown', 'aliceb@example.com', 'password123', NULL, 1234567890, '123 Elm Street, Springfield, IL - 62701', 1),
(9, 'Bob White', 'bobw@example.com', 'password456', NULL, 9876543210, '456 Oak Avenue, Los Angeles, CA - 90001', 0),
(10, 'Charlie Green', 'charlieg@example.com', 'password789', NULL, 5551234567, '789 Pine Road, Boston, MA - 02110', 1),
(11, 'Diana Gray', 'dianag@example.com', 'password987', NULL, 8887776666, '101 Maple Drive, Dallas, TX - 75201', 0),
(12, 'Eve Black', 'eveb@example.com', 'password654', NULL, 4443332222, '202 Birch Lane, Miami, FL - 33101', 1),
(13, 'Frank Blue', 'frankb@example.com', 'password321', NULL, 7775554444, '303 Cedar Boulevard, Seattle, WA - 98101', 0),
(14, 'Grace Yellow', 'gracey@example.com', 'password000', NULL, 6665554444, '404 Pinecrest Avenue, Chicago, IL - 60601', 1),
(15, 'Hank Red', 'hankr@example.com', 'password111', NULL, 9998887777, '505 Birch Crescent, New York, NY - 10001', 0),
(16, 'Ivy Violet', 'ivyv@example.com', 'password222', NULL, 5554443333, '606 Oak Ridge, San Francisco, CA - 94102', 1),
(17, 'Jack Orange', 'jacko@example.com', 'password333', NULL, 4443332222, '707 Cherry Lane, Phoenix, AZ - 85001', 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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