-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2021 at 05:33 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_code` int(11) DEFAULT NULL,
  `category_desc` varchar(50) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_code`, `category_desc`) VALUES
(1, 1, 'ITEM'),
(2, 0, 'SERVICES'),
(10, NULL, 'OKES');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_code` char(10) DEFAULT NULL,
  `customer_name` varchar(50) DEFAULT NULL,
  `customer_address` varchar(150) DEFAULT NULL,
  `customer_phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_code`, `customer_name`, `customer_address`, `customer_phone`) VALUES
(1, 'C001', 'Name', 'Address', '12345'),
(3, 'C002', 'Naruto', 'Konoha', '1111');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `invoice_number` char(15) DEFAULT NULL,
  `invoice_date` datetime DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `invoice_total` int(11) DEFAULT NULL,
  `invoice_status` int(11) DEFAULT NULL,
  `invoice_notes` varchar(200) DEFAULT NULL,
  `invoice_created_by` int(11) DEFAULT NULL,
  `invoice_created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_detail`
--

CREATE TABLE `invoice_detail` (
  `detail_id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `detail_item_id` int(11) DEFAULT NULL,
  `detail_item_code` char(10) DEFAULT NULL,
  `detail_item_desc` varchar(150) DEFAULT NULL,
  `detail_item_qty` int(11) DEFAULT NULL,
  `detail_item_unit` char(5) DEFAULT NULL,
  `detail_item_price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `item_code` char(10) DEFAULT NULL,
  `item_desc` varchar(150) DEFAULT NULL,
  `item_unit` char(5) DEFAULT NULL,
  `item_buy` int(11) DEFAULT NULL,
  `item_price` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `category_id`, `item_code`, `item_desc`, `item_unit`, `item_buy`, `item_price`, `supplier_id`) VALUES
(1, 1, 'B001', 'Barang', 'kg', 1000, NULL, NULL),
(2, 1, 'B002', 'Barang 2', 'g', 500, NULL, 1),
(3, 2, 'B003', 'Service', '-', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `level_id` int(11) NOT NULL,
  `level_desc` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`level_id`, `level_desc`) VALUES
(1, 'Administrator'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchase_id` int(11) NOT NULL,
  `purchase_number` char(15) DEFAULT NULL,
  `purchase_date` datetime DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `purchase_total` int(11) DEFAULT NULL,
  `purchase_notes` varchar(200) DEFAULT NULL,
  `purchase_created_by` int(11) DEFAULT NULL,
  `purchase_created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_detail`
--

CREATE TABLE `purchase_detail` (
  `detail_id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `detail_item_id` int(11) DEFAULT NULL,
  `detail_item_code` char(10) DEFAULT NULL,
  `detail_item_desc` varchar(150) DEFAULT NULL,
  `detail_item_qty` int(11) DEFAULT NULL,
  `detail_item_unit` char(5) DEFAULT NULL,
  `detail_item_price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quotation`
--

CREATE TABLE `quotation` (
  `quotation_id` int(11) NOT NULL,
  `quotation_number` char(15) DEFAULT NULL,
  `quotation_date` datetime DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `quotation_total` int(11) DEFAULT NULL,
  `quotation_status` int(11) DEFAULT NULL,
  `quotation_created_by` int(11) DEFAULT NULL,
  `quotation_created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quotation_detail`
--

CREATE TABLE `quotation_detail` (
  `detail_id` int(11) NOT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `detail_item_id` int(11) DEFAULT NULL,
  `detail_item_code` char(10) DEFAULT NULL,
  `detail_item_desc` varchar(150) DEFAULT NULL,
  `detail_item_qty` int(11) DEFAULT NULL,
  `detail_item_unit` char(5) DEFAULT NULL,
  `detail_item_price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `setting_id` int(11) NOT NULL,
  `setting_category` char(10) DEFAULT NULL,
  `setting_name` varchar(50) DEFAULT NULL,
  `setting_value` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL,
  `status_desc` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_desc`) VALUES
(1, 'NEW'),
(2, 'CANCEL'),
(3, 'FINISH');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `stock_min` int(11) DEFAULT NULL,
  `stock_max` int(11) DEFAULT NULL,
  `stock_exist` int(11) DEFAULT NULL,
  `stock_updated_id` int(11) DEFAULT NULL,
  `stock_updated_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_history`
--

CREATE TABLE `stock_history` (
  `stock_history_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `stock_history_item_code` char(10) DEFAULT NULL,
  `stock_history_item_desc` varchar(150) DEFAULT NULL,
  `stock_history_item_qty` int(11) DEFAULT NULL,
  `stock_history_number` char(15) DEFAULT NULL,
  `stock_history_type` int(11) DEFAULT NULL,
  `stock_history_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_history_category`
--

CREATE TABLE `stock_history_category` (
  `stock_history_category_id` int(11) NOT NULL,
  `stock_history_category_desc` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_history_category`
--

INSERT INTO `stock_history_category` (`stock_history_category_id`, `stock_history_category_desc`) VALUES
(1, 'QUOTATION'),
(2, 'INVOICE'),
(3, 'PURCHASE');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `supplier_code` char(10) DEFAULT NULL,
  `supplier_name` varchar(50) DEFAULT NULL,
  `supplier_address` varchar(150) DEFAULT NULL,
  `supplier_phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier_code`, `supplier_name`, `supplier_address`, `supplier_phone`) VALUES
(1, 'S001', 'Supplier', 'Alamat', '12345'),
(3, 'S002', 'PT. SUPPLIER', 'Surabaya', '0852');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_code` char(10) DEFAULT NULL,
  `user_fullname` varchar(50) DEFAULT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `user_password` varchar(50) DEFAULT NULL,
  `user_address` varchar(150) DEFAULT NULL,
  `user_phone` varchar(15) DEFAULT NULL,
  `user_level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_code`, `user_fullname`, `user_name`, `user_password`, `user_address`, `user_phone`, `user_level`) VALUES
(1, 'U-001', 'Administrator', 'admin', '21232f297a57a5a743894a0e4a801fc3', '-', '-', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD PRIMARY KEY (`detail_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `purchase_detail`
--
ALTER TABLE `purchase_detail`
  ADD PRIMARY KEY (`detail_id`);

--
-- Indexes for table `quotation`
--
ALTER TABLE `quotation`
  ADD PRIMARY KEY (`quotation_id`);

--
-- Indexes for table `quotation_detail`
--
ALTER TABLE `quotation_detail`
  ADD PRIMARY KEY (`detail_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `stock_history`
--
ALTER TABLE `stock_history`
  ADD PRIMARY KEY (`stock_history_id`);

--
-- Indexes for table `stock_history_category`
--
ALTER TABLE `stock_history_category`
  ADD PRIMARY KEY (`stock_history_category_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_detail`
--
ALTER TABLE `purchase_detail`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotation`
--
ALTER TABLE `quotation`
  MODIFY `quotation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotation_detail`
--
ALTER TABLE `quotation_detail`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_history`
--
ALTER TABLE `stock_history`
  MODIFY `stock_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_history_category`
--
ALTER TABLE `stock_history_category`
  MODIFY `stock_history_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
