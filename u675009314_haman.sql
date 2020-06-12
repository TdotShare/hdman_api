-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 12, 2020 at 01:12 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u675009314_haman`
--

-- --------------------------------------------------------

--
-- Table structure for table `hd_account`
--

CREATE TABLE `hd_account` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL COMMENT 'email',
  `nickname` varchar(50) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1 = ยืนยันแล้ว , 0 = ยังไม่ยืนยัน',
  `verify_code` varchar(10) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hd_account`
--

INSERT INTO `hd_account` (`id`, `username`, `password`, `email`, `nickname`, `status`, `verify_code`, `create_at`, `update_at`) VALUES
(6, 'admint', '12345', 'neo.tdot@gmail.com', 'admint02', 1, 'X0zs9Xp', '2020-04-23 15:55:38', '2020-04-28 21:02:33'),
(7, 'test01', '12345', 'padtipant@gmail.com', 'test01', 1, 'tHpndY7', '2020-04-29 12:16:32', '2020-04-29 12:17:46'),
(17, 'kamonchanok', '1234', 'kamonchanok0110@gmail.com', 'kamonchanok', 1, '0rBca6p', '2020-04-29 13:55:06', '2020-04-29 13:55:55'),
(18, 'auy', 'auy09012542', 'rawipa.thai1999@gmail.com', 'auy', 1, 'j2lbhNv', '2020-04-29 14:02:49', '2020-04-29 14:03:22'),
(19, 'auyaa', 'auy09012542', 'rawipa.ba@rmuti.ac.th', 'auyaa', 1, 'xHBpn4O', '2020-04-29 14:20:47', '2020-04-29 14:21:17');

-- --------------------------------------------------------

--
-- Table structure for table `hd_market`
--

CREATE TABLE `hd_market` (
  `id` int(11) NOT NULL,
  `id_account` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1 = เปิดใช้งาน, 0 = ไม่เปิดใช้',
  `address` text NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hd_market`
--

INSERT INTO `hd_market` (`id`, `id_account`, `name`, `category`, `status`, `address`, `create_at`, `update_at`) VALUES
(19, 6, 'admintStore02', 'ช่างคอมพิวเตอร์', 0, '238/1', '2020-04-28 20:21:00', '2020-05-01 09:48:31'),
(20, 18, 'tests001', 'ช่างคอมพิวเตอร์', 0, '23811', '2020-05-01 09:34:05', '2020-05-08 09:29:17');

-- --------------------------------------------------------

--
-- Table structure for table `hd_product`
--

CREATE TABLE `hd_product` (
  `id` int(11) NOT NULL,
  `id_market` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `price` varchar(80) NOT NULL,
  `service` varchar(80) NOT NULL,
  `detail` text NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hd_product`
--

INSERT INTO `hd_product` (`id`, `id_market`, `name`, `price`, `service`, `detail`, `create_at`, `update_at`) VALUES
(4, 19, 'fix cpu', '300', '/ชั่วโมง', '', '2020-04-29 11:37:47', '2020-04-29 11:37:47'),
(5, 19, 'fix computer', '500', '/ชั่วโมง', '', '2020-04-29 11:38:02', '2020-04-29 11:38:02'),
(6, 20, 'fix com', '200', '/งาน', '', '2020-05-01 09:34:34', '2020-05-01 09:34:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hd_account`
--
ALTER TABLE `hd_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hd_market`
--
ALTER TABLE `hd_market`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hd_product`
--
ALTER TABLE `hd_product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hd_account`
--
ALTER TABLE `hd_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `hd_market`
--
ALTER TABLE `hd_market`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `hd_product`
--
ALTER TABLE `hd_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
