-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 20, 2025 at 04:22 PM
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
-- Database: `logistics_db`
--
CREATE DATABASE IF NOT EXISTS `logistics_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `logistics_db`;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_centers`
--

CREATE TABLE `delivery_centers` (
  `center_id` int(11) NOT NULL,
  `center_name` varchar(255) NOT NULL COMMENT 'ชื่อศูนย์ส่ง-รับสินค้า',
  `center_address` text NOT NULL COMMENT 'ที่อยู่ศูนย์กระจายสินค้า',
  `center_phone` varchar(20) NOT NULL COMMENT 'หมายเลขโทรศัพท์'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_centers`
--

INSERT INTO `delivery_centers` (`center_id`, `center_name`, `center_address`, `center_phone`) VALUES
(1, 'กรุงเทพ', '123 ถ.พระราม 9 แขวงห้วยขวาง เขตห้วยขวาง กรุงเทพฯ 10310', '021234567'),
(2, 'ชลบุรี	', '456 ถ.สุขุมวิท ต.บางปลาสร้อย อ.เมือง จ.ชลบุรี 20000', '038234567'),
(3, 'เชียงใหม่', '789 ถ.ซุปเปอร์ไฮเวย์ ต.ช้างเผือก อ.เมือง จ.เชียงใหม่ 50000	', '053345678'),
(4, 'อุบลราชธานี', '321 ถ.แจ้งสนิท ต.ในเมือง อ.เมือง จ.อุบลราชธานี 34000	', '045456789'),
(5, 'ภูเก็ต', '654 ถ.เทพกระษัตรี ต.รัษฎา อ.เมือง จ.ภูเก็ต 83000	', '076567890');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `tracking_number` varchar(50) NOT NULL,
  `shipping_type` varchar(100) NOT NULL COMMENT 'ประเภทการจัดส่ง ส่งด่วน/ปกติ',
  `customer_id_ref` int(11) NOT NULL COMMENT 'ชื่อผู้ส่ง',
  `receiver_name` varchar(100) NOT NULL COMMENT 'ชื่อผู้รับพัสดุ',
  `receiver_phone` varchar(20) NOT NULL COMMENT 'เบอร์ผู้รับ',
  `ref_center_id` int(11) NOT NULL COMMENT 'ชื่อศูนย์ส่งสินค้า อ้างอิง\r\ncenter_id',
  `order_address` text NOT NULL COMMENT 'ที่อยู่จัดส่งปลายทาง',
  `order_province` varchar(60) NOT NULL COMMENT 'จังหวัดปลายทาง',
  `current_status` varchar(50) DEFAULT 'รับพัสดุเข้าศูนย์',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `tracking_number`, `shipping_type`, `customer_id_ref`, `receiver_name`, `receiver_phone`, `ref_center_id`, `order_address`, `order_province`, `current_status`, `created_at`) VALUES
(1, '3535140673783', 'ส่งด่วน', 1, 'tavol', '0646266600', 1, '	789 ถ.ซุปเปอร์ไฮเวย์ ต.ช้างเผือก อ.เมือง จ.เชียงใหม่ 50000', 'เชียงใหม่', 'พัสดุถูกตีกลับ', '2025-03-20 09:14:25'),
(2, '1639555591565', 'ปกติ', 2, 'สมศรี สายทอง', '0812345679', 1, '654 ถ.เทพกระษัตรี ต.รัษฎา อ.เมือง จ.ภูเก็ต 83000', 'ภูเก็ต ', 'พัสดุจัดส่งสำเร็จ', '2025-03-20 11:03:30'),
(3, '5082535477678', 'ส่งด่วน', 4, 'พรทิพย์ ทองคำ', '0812345681', 5, '123 ถ.พระราม 9 แขวงห้วยขวาง เขตห้วยขวาง กรุงเทพฯ 10310', 'กรุงเทพ', 'พัสดุกำลังเดินทาง', '2025-03-20 11:07:21'),
(4, '4370205152428', 'ส่งด่วน', 7, 'วราภรณ์ ศรีสวัสดิ์	', '0812345685', 4, '456 ถ.สุขุมวิท ต.บางปลาสร้อย อ.เมือง จ.ชลบุรี 20000', 'ชลบุรี', 'รับพัสดุเข้าศูนย์', '2025-03-20 11:08:47');

-- --------------------------------------------------------

--
-- Table structure for table `order_logs`
--

CREATE TABLE `order_logs` (
  `log_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_logs`
--

INSERT INTO `order_logs` (`log_id`, `order_id`, `status`, `updated_at`) VALUES
(1, 1, 'รับพัสดุเข้าศูนย์', '2025-03-20 09:14:25'),
(2, 1, 'พัสดุกำลังเดินทาง', '2025-03-20 09:47:22'),
(3, 2, 'รับพัสดุเข้าศูนย์', '2025-03-20 11:03:30'),
(4, 2, 'พัสดุกำลังเดินทาง', '2025-03-20 11:04:04'),
(5, 2, 'พัสดุถึงปลายทาง', '2025-03-20 11:04:09'),
(6, 2, 'พัสดุอยู่ระหว่างการนำส่ง', '2025-03-20 11:04:14'),
(7, 2, 'พัสดุจัดส่งสำเร็จ', '2025-03-20 11:04:19'),
(8, 1, 'พัสดุถึงปลายทาง', '2025-03-20 11:04:36'),
(9, 1, 'พัสดุอยู่ระหว่างการนำส่ง', '2025-03-20 11:04:41'),
(10, 1, 'พัสดุจัดส่งไม่สำเร็จ', '2025-03-20 11:04:48'),
(11, 1, 'พัสดุถูกตีกลับ', '2025-03-20 11:04:57'),
(12, 3, 'รับพัสดุเข้าศูนย์', '2025-03-20 11:07:21'),
(13, 4, 'รับพัสดุเข้าศูนย์', '2025-03-20 11:08:47'),
(14, 3, 'พัสดุกำลังเดินทาง', '2025-03-20 11:14:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL COMMENT 'ID ถูกสร้างอัตโนมัติ',
  `admin_profile` varchar(200) NOT NULL COMMENT 'รูปโปรไฟล์',
  `admin_name` varchar(100) NOT NULL COMMENT 'ชื่อ-นามสกุลของแอดมิน',
  `admin_email` varchar(100) NOT NULL COMMENT 'อีเมล์ของแอดมิน',
  `admin_password` varchar(200) NOT NULL COMMENT 'รหัสผ่านสำหรับใช้งานเข้าสู่ระบบ',
  `admin_phone` varchar(20) NOT NULL COMMENT 'เบอร์โทรศัพท์',
  `admin_level` varchar(20) NOT NULL COMMENT 'สิทธิ์ของผู้ใช้',
  `admin_created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'เวลาที่บันทึกข้อมูล(อัตโนมัติ)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_profile`, `admin_name`, `admin_email`, `admin_password`, `admin_phone`, `admin_level`, `admin_created_at`) VALUES
(1, '186434464520250320_160753.JPG', 'วิวัฒน์ ชัยชนะ', 'admin11@g.com', 'c230e0811f617ea267bab08f8a62ca0585218cfa33676f6ed7d67b7d5af36192df3879350d5accc26a22486c8774bce92c3cfe3a3e5c9aa270cce55709db6821', '0646266600', 'admin', '2025-03-20 09:07:53'),
(2, '93322523920250320_175923.jpg', 'เกรียงไกร ทิวทอง', 'admin22@g.com', '17521ce56ddee9351ca4c760173661e3cd2693161baacf7e5bfbdd09847105ba5670379431e5235bcb879a8f4640661d89fe94062b7d46bcec66f623af5fb026', '0811778788', 'admin', '2025-03-20 10:59:23'),
(3, '214343713620250320_175959.jpeg', 'กิตติ สุภาวะหา', 'admin33@g.com', 'd85d8f20e2d334a9586a1f39ab0ca6b3ee53ea6a5da45ced894e650c151ac99e53019be4e4c5757538bafb9f36328085a94bec17d5358cacbabd7cec076e75bf', '0658526450', 'admin', '2025-03-20 10:59:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customers`
--

CREATE TABLE `tbl_customers` (
  `customer_id` int(11) NOT NULL,
  `cus_id_card` varchar(13) NOT NULL COMMENT 'เลขบัตรประชาชนลูกค้า',
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cus_phone` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customers`
--

INSERT INTO `tbl_customers` (`customer_id`, `cus_id_card`, `name`, `email`, `cus_phone`, `created_at`) VALUES
(1, '1111111111111', 'Wiwat Chaichana', 'frong_5057@hotmail.co.th', '0646266600', '2025-03-20 09:13:37'),
(2, '1103700123456', 'สมชาย ใจดี', 'somchai01@example.com', '0812345678', '2025-03-20 09:22:39'),
(3, '1103700123457', 'สมศรี สายทอง', 'somsri02@example.com', '0812345679', '2025-03-20 09:22:39'),
(4, '1103700123458', 'วิชัย รุ่งเรือง', 'wichai03@example.com', '0812345680', '2025-03-20 09:22:39'),
(5, '1103700123459', 'พรทิพย์ ทองคำ', 'pornthip04@example.com', '0812345681', '2025-03-20 09:22:39'),
(6, '1103700123460', 'จักรพงษ์ พรหมมา', 'jakraphong05@example.com', '0812345682', '2025-03-20 09:22:39'),
(7, '1103700123461', 'ธนากร อภิชาติ', 'thanakorn06@example.com', '0812345683', '2025-03-20 09:22:39'),
(8, '1103700123462', 'กิตติพงษ์ วรชัย', 'kittipong07@example.com', '0812345684', '2025-03-20 09:22:39'),
(9, '1103700123463', 'วราภรณ์ ศรีสวัสดิ์', 'waraporn08@example.com', '0812345685', '2025-03-20 09:22:39'),
(10, '1103700123464', 'เอกชัย มั่นคง', 'ekachai09@example.com', '0812345686', '2025-03-20 09:22:39'),
(11, '1103700123465', 'มัลลิกา สุขสันต์', 'mallika10@example.com', '0812345687', '2025-03-20 09:22:39'),
(12, '1103700123466', 'อานนท์ สมบัติ', 'anon11@example.com', '0812345688', '2025-03-20 09:22:39'),
(13, '1103700123467', 'นฤมล ใจดี', 'narumon12@example.com', '0812345689', '2025-03-20 09:22:39'),
(14, '1103700123468', 'สมพงษ์ รัตนา', 'sompong13@example.com', '0812345690', '2025-03-20 09:22:39'),
(15, '1103700123469', 'พิมพ์ใจ บัวทอง', 'pimjai14@example.com', '0812345691', '2025-03-20 09:22:39'),
(16, '1103700123470', 'สิทธิชัย ศรีสุข', 'sittichai15@example.com', '0812345692', '2025-03-20 09:22:39'),
(17, '1103700123471', 'อรทัย พูลสวัสดิ์', 'ornthai16@example.com', '0812345693', '2025-03-20 09:22:39'),
(18, '1103700123472', 'จักรกฤษณ์ วงศ์ไทย', 'jakrit17@example.com', '0812345694', '2025-03-20 09:22:39'),
(19, '1103700123473', 'ธันวา แก้วมณี', 'thanwa18@example.com', '0812345695', '2025-03-20 09:22:39'),
(20, '1103700123474', 'มนัสนันท์ อภิรักษ์', 'manatsanun19@example.com', '0812345696', '2025-03-20 09:22:39'),
(21, '1103700123475', 'วิชิต รุ่งเรือง', 'wichit20@example.com', '0812345697', '2025-03-20 09:22:39'),
(22, '1103700123547', 'ณรงค์เดช แก้วใส', 'narongdej98@example.com', '0812345786', '2025-03-20 09:22:39'),
(23, '1103700123548', 'นิตยา รัตนาวดี', 'nitiya99@example.com', '0812345787', '2025-03-20 09:22:39'),
(24, '1103700123549', 'ชลธิชา บัวทอง', 'chonthicha100@example.com', '0812345788', '2025-03-20 09:22:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `delivery_centers`
--
ALTER TABLE `delivery_centers`
  ADD PRIMARY KEY (`center_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `tracking_number` (`tracking_number`),
  ADD KEY `customer_id` (`customer_id_ref`);

--
-- Indexes for table `order_logs`
--
ALTER TABLE `order_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`admin_email`);

--
-- Indexes for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `cus_id_card` (`cus_id_card`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `delivery_centers`
--
ALTER TABLE `delivery_centers`
  MODIFY `center_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_logs`
--
ALTER TABLE `order_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID ถูกสร้างอัตโนมัติ', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id_ref`) REFERENCES `tbl_customers` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_logs`
--
ALTER TABLE `order_logs`
  ADD CONSTRAINT `order_logs_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
