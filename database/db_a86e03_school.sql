-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql8003.site4now.net
-- Generation Time: Jun 10, 2023 at 01:47 AM
-- Server version: 8.0.32
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_a86e03_school`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE `academic_year` (
  `year_id` int NOT NULL,
  `academic_year` varchar(150) DEFAULT NULL,
  `key_status` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `academic_year`
--

INSERT INTO `academic_year` (`year_id`, `academic_year`, `key_status`, `status`) VALUES
(1, '2020-2021', 0, 0),
(2, '2021-2022', 0, 0),
(3, '2022-2023', 0, 0),
(4, '2023-2024', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `accountsgroup`
--

CREATE TABLE `accountsgroup` (
  `Id` int NOT NULL,
  `AccountsName` longtext,
  `ParentId` int DEFAULT '0',
  `status` int DEFAULT '0',
  `order_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `accountsgroup`
--

INSERT INTO `accountsgroup` (`Id`, `AccountsName`, `ParentId`, `status`, `order_id`) VALUES
(1, 'Capital Account', 0, 0, 1),
(2, 'Current Liabilities', 0, 0, 2),
(3, 'Current Assets', 0, 0, 4),
(4, 'Purchase Accounts', 0, 0, 5),
(5, 'Direct Income', 0, 0, 6),
(6, 'Direct Expenses', 0, 0, 7),
(7, 'Indirect Income', 0, 0, 8),
(8, 'Indirect Expenses', 0, 0, 9),
(9, 'Profit & Loss A/c', 0, 0, 10),
(10, 'Diff. in Opening Balances', 0, 0, 11),
(11, 'Reserve & Surplus', 1, 0, 12),
(12, 'Sundry Creditors', 2, 0, 13),
(13, 'Loans(Liability)', 2, 0, 14),
(14, 'Bank OD', 2, 0, 15),
(15, 'Opening Stock', 3, 0, 16),
(16, 'Cash-in-hand', 3, 0, 17),
(17, 'Bank Accounts', 3, 0, 18),
(18, 'Investments', 3, 0, 19),
(19, 'Loans and Advances', 3, 0, 20),
(40, 'Sundry Debtors', 3, 0, 35),
(42, 'Fixed Assets', 0, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `area_creation`
--

CREATE TABLE `area_creation` (
  `area_id` int NOT NULL,
  `area_name` varchar(255) DEFAULT NULL,
  `item_details` varchar(255) DEFAULT NULL,
  `due_amount` varchar(255) DEFAULT NULL,
  `due_date` text,
  `no_of_terms` text,
  `transport_amount` text,
  `status` int NOT NULL DEFAULT '0',
  `school_id` int DEFAULT NULL,
  `year_id` int DEFAULT NULL,
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `area_creation`
--

INSERT INTO `area_creation` (`area_id`, `area_name`, `item_details`, `due_amount`, `due_date`, `no_of_terms`, `transport_amount`, `status`, `school_id`, `year_id`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'Ariyanguppam', 'I Term ,II Term', '1000,1000', '2023-05-06,2023-05-05', '2', '2000', 0, NULL, NULL, 1, NULL, NULL, '2023-05-05 13:01:55', '2023-05-05 13:01:55'),
(2, 'Tambaram', ',,,,,,,,,,,', ',,,,,,,,,,,', ',,,,,,,,,,,', '12', '24000', 0, NULL, NULL, 1, NULL, NULL, '2023-06-03 09:47:38', '2023-06-03 09:47:38'),
(3, 'White Town', '1st term,2nd term,3rd term', '550,550,550', '2023-06-03,2023-07-03,2023-08-03', '3', '1650', 0, 2, 3, 1, NULL, NULL, '2023-06-03 14:32:57', '2023-06-03 14:32:57'),
(4, 'PondiCherry', 'Test1,Test2,Test1', '8333,8333,8333', '2023-06-10,2023-07-10,2023-08-03', '3', '25000', 0, 7, 3, 18, NULL, NULL, '2023-06-03 14:40:54', '2023-06-03 14:40:54'),
(5, 'SCHOOL3', 'Test', '12344', '2023-06-17', '1', '12344', 0, 8, 2, 19, NULL, NULL, '2023-06-09 16:54:56', '2023-06-09 16:54:56');

-- --------------------------------------------------------

--
-- Table structure for table `bankmaster`
--

CREATE TABLE `bankmaster` (
  `bankid` int NOT NULL,
  `bankcode` varchar(255) DEFAULT NULL,
  `bankname` varchar(255) DEFAULT NULL,
  `accountno` varchar(255) DEFAULT NULL,
  `branchname` varchar(255) DEFAULT NULL,
  `shortform` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `mailid` varchar(255) DEFAULT NULL,
  `ifsccode` varchar(255) DEFAULT NULL,
  `contactperson` varchar(255) DEFAULT NULL,
  `contactno` varchar(255) DEFAULT NULL,
  `micrcode` varchar(255) DEFAULT NULL,
  `typeofaccount` varchar(255) DEFAULT NULL,
  `undersubgroup` varchar(255) DEFAULT NULL,
  `fgroup` varchar(255) DEFAULT NULL,
  `bankgrouprefid` varchar(20) DEFAULT NULL,
  `ledgername` varchar(255) DEFAULT NULL,
  `costcenter` varchar(255) DEFAULT NULL,
  `fromperiod` varchar(50) DEFAULT NULL,
  `toperiod` varchar(50) DEFAULT NULL,
  `duedate` varchar(50) DEFAULT NULL,
  `loanamount` int DEFAULT NULL,
  `emi` int DEFAULT NULL,
  `restofinterest` int DEFAULT NULL,
  `status` int DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `createddate` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bankmaster`
--

INSERT INTO `bankmaster` (`bankid`, `bankcode`, `bankname`, `accountno`, `branchname`, `shortform`, `purpose`, `mailid`, `ifsccode`, `contactperson`, `contactno`, `micrcode`, `typeofaccount`, `undersubgroup`, `fgroup`, `bankgrouprefid`, `ledgername`, `costcenter`, `fromperiod`, `toperiod`, `duedate`, `loanamount`, `emi`, `restofinterest`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `createddate`) VALUES
(1, 'BANK1001', 'SBI', '23423434234', 'Tiruvannamalai', 'TVM', '1', 'test@gmail.com', 'rfase343434', 'test', '7887788878', '234234234', 'bankod', '13', '2', '2', 'SBI', '0', '2022-12-15', '2022-12-30', '2022-12-05', 100000, 100, 10, 0, 1, 1, 1, '2022-11-17 09:33:55');

-- --------------------------------------------------------

--
-- Table structure for table `billsettings`
--

CREATE TABLE `billsettings` (
  `id` int NOT NULL,
  `billmodel` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `billsettings`
--

INSERT INTO `billsettings` (`id`, `billmodel`) VALUES
(1, 'model1');

-- --------------------------------------------------------

--
-- Table structure for table `conduct_certificate`
--

CREATE TABLE `conduct_certificate` (
  `conduct_id` int NOT NULL,
  `admission_number` varchar(250) DEFAULT NULL,
  `student_name` varchar(250) DEFAULT NULL,
  `school_name` varchar(250) DEFAULT NULL,
  `school_address` varchar(250) DEFAULT NULL,
  `studied_from` varchar(250) DEFAULT NULL,
  `studied_to` varchar(250) DEFAULT NULL,
  `academic_year_from` varchar(250) DEFAULT NULL,
  `academic_year_to` varchar(250) DEFAULT NULL,
  `place` varchar(250) DEFAULT NULL,
  `student_character` varchar(250) DEFAULT NULL,
  `phone_number` varchar(250) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `conduct_certificate`
--

INSERT INTO `conduct_certificate` (`conduct_id`, `admission_number`, `student_name`, `school_name`, `school_address`, `studied_from`, `studied_to`, `academic_year_from`, `academic_year_to`, `place`, `student_character`, `phone_number`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '3', 'Sivas', 'VIDHYA PARTHI NATIONAL ACADEMY', 'dfgdfgaddress', 'gdfggdfgfrom', 'dfgdfgto', 'dfgdfgto', 'dfgsdfg', 'dfgdfg', 'dfgsdfg', '7845124578', 0, 1, 1, 1, '2023-04-24 16:29:10', '2023-04-24 16:29:10');

-- --------------------------------------------------------

--
-- Table structure for table `costcentre`
--

CREATE TABLE `costcentre` (
  `costcentreid` int NOT NULL,
  `costcentrename` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `costcentre`
--

INSERT INTO `costcentre` (`costcentreid`, `costcentrename`, `status`) VALUES
(1, 'Celebration Charges', '0'),
(2, 'Faculty Bus', '0'),
(3, 'Sale', '0'),
(4, 'Purchase', '0'),
(5, 'Salary', '0'),
(6, 'Admin', '0'),
(7, 'test', '0');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_student_creation`
--

CREATE TABLE `deleted_student_creation` (
  `deleted_student_id` int NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `deleted_student_creation`
--

INSERT INTO `deleted_student_creation` (`deleted_student_id`, `student_id`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '3', 0, NULL, NULL, NULL, '2023-05-18 09:59:16', '2023-05-18 09:59:16'),
(2, '3', 0, NULL, NULL, NULL, '2023-05-18 09:59:24', '2023-05-18 09:59:24'),
(3, '3', 0, NULL, NULL, NULL, '2023-05-18 10:00:26', '2023-05-18 10:00:26'),
(4, '3', 0, NULL, NULL, NULL, '2023-05-18 10:00:51', '2023-05-18 10:00:51'),
(5, '3', 0, NULL, NULL, NULL, '2023-05-18 10:07:02', '2023-05-18 10:07:02'),
(6, '3', 0, NULL, NULL, NULL, '2023-05-18 10:07:24', '2023-05-18 10:07:24'),
(7, '3', 0, NULL, NULL, NULL, '2023-05-18 10:11:53', '2023-05-18 10:11:53'),
(8, '3', 0, NULL, NULL, NULL, '2023-05-18 10:17:47', '2023-05-18 10:17:47'),
(9, '3', 0, NULL, NULL, NULL, '2023-05-18 10:26:02', '2023-05-18 10:26:02'),
(10, '3', 0, NULL, NULL, NULL, '2023-05-18 10:31:07', '2023-05-18 10:31:07'),
(11, '3', 0, NULL, NULL, NULL, '2023-05-18 10:32:43', '2023-05-18 10:32:43'),
(12, '3', 0, NULL, NULL, NULL, '2023-05-18 10:33:10', '2023-05-18 10:33:10'),
(13, '3', 0, NULL, NULL, NULL, '2023-05-18 10:37:41', '2023-05-18 10:37:41');

-- --------------------------------------------------------

--
-- Table structure for table `fees_master`
--

CREATE TABLE `fees_master` (
  `fees_id` int NOT NULL,
  `academic_year` varchar(250) DEFAULT NULL,
  `medium` varchar(250) DEFAULT NULL,
  `student_type` varchar(250) DEFAULT NULL,
  `standard` varchar(255) DEFAULT NULL,
  `grp_particulars` varchar(250) DEFAULT NULL,
  `grp_amount` varchar(250) DEFAULT NULL,
  `grp_date` varchar(250) DEFAULT NULL,
  `extra_particulars` varchar(250) DEFAULT NULL,
  `extra_amount` varchar(255) DEFAULT NULL,
  `extra_date` varchar(250) DEFAULT NULL,
  `amenity_particulars` varchar(250) DEFAULT NULL,
  `amenity_amount` varchar(250) DEFAULT NULL,
  `amenity_date` varchar(250) DEFAULT NULL,
  `grp_ledger_name` varchar(250) DEFAULT NULL,
  `extra_ledger_name` varchar(250) DEFAULT NULL,
  `amenity_ledger_name` varchar(250) DEFAULT NULL,
  `temp_flat_no` varchar(250) DEFAULT NULL,
  `temp_street` varchar(250) DEFAULT NULL,
  `temp_district` varchar(250) DEFAULT NULL,
  `temp_area` varchar(250) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `grp_status` int NOT NULL DEFAULT '0',
  `extra_status` int NOT NULL DEFAULT '0',
  `amenity_status` int NOT NULL DEFAULT '0',
  `school_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fees_master`
--

INSERT INTO `fees_master` (`fees_id`, `academic_year`, `medium`, `student_type`, `standard`, `grp_particulars`, `grp_amount`, `grp_date`, `extra_particulars`, `extra_amount`, `extra_date`, `amenity_particulars`, `amenity_amount`, `amenity_date`, `grp_ledger_name`, `extra_ledger_name`, `amenity_ledger_name`, `temp_flat_no`, `temp_street`, `temp_district`, `temp_area`, `status`, `grp_status`, `extra_status`, `amenity_status`, `school_id`, `user_id`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '2023-2024', 'Tamil', 'New Student', 'PRE.K.G', 'Book Fees', '5000', '2023-04-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, 1, NULL, NULL, '2023-04-19 15:33:31', '2023-04-19 15:33:31'),
(3, '2023-2024', 'Tamil', 'New Student', 'PRE.K.G', NULL, NULL, NULL, 'School Fees', '3000', '2023-04-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, NULL, NULL, 1, NULL, NULL, '2023-04-19 15:34:35', '2023-04-19 15:34:35'),
(4, '2023-2024', 'Tamil', 'New Student', 'PRE.K.G', NULL, NULL, NULL, NULL, NULL, NULL, 'Playground Fees', '1000', '2023-04-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, 1, NULL, NULL, '2023-04-19 15:34:57', '2023-04-19 15:34:57'),
(5, '2023-2024', 'Tamil', 'New Student', 'PRE.K.G', 'Book Fees2', '5000', '2023-04-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, 1, NULL, NULL, '2023-04-19 16:55:20', '2023-04-19 16:55:20'),
(6, '2023-2024', 'Tamil', 'New Student', 'PRE.K.G', NULL, NULL, NULL, 'Extra School Fees', '1000', '2023-04-27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, NULL, NULL, 1, NULL, NULL, '2023-04-27 12:04:17', '2023-04-27 12:04:17'),
(7, '2023-2024', 'Tamil', 'New Student', 'PRE.K.G', NULL, NULL, NULL, NULL, NULL, NULL, 'Extra Playground Fees', '2000', '2023-04-27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, 1, NULL, NULL, '2023-04-27 12:04:41', '2023-04-27 12:04:41'),
(8, '2023-2024', 'Tamil', 'New Student', 'L.K.G', 'School Fees', '10000', '2023-05-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, 1, NULL, NULL, '2023-05-06 16:57:59', '2023-05-06 16:57:59'),
(9, '2023-2024', 'Tamil', 'New Student', 'L.K.G', NULL, NULL, NULL, 'Book Fees', '2000', '2023-05-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, NULL, NULL, 1, NULL, NULL, '2023-05-06 16:58:12', '2023-05-06 16:58:12'),
(10, '2023-2024', 'Tamil', 'New Student', 'L.K.G', NULL, NULL, NULL, NULL, NULL, NULL, 'Uniform Fees', '3000', '2023-05-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, 1, NULL, NULL, '2023-05-06 16:59:09', '2023-05-06 16:59:09'),
(11, '2023-2024', 'Tamil', 'New Student', 'PRE.K.G', 'Book Fees3', '3000', '2023-05-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, '2023-05-09 15:37:30', '2023-05-09 15:37:30'),
(12, '2023-2024', 'Tamil', 'New Student', 'PRE.K.G', 'testing', '10000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Uniform', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, '2023-05-18 16:11:55', '2023-05-18 16:11:55'),
(13, '2023-2024', 'Tamil', NULL, 'PRE.K.G', NULL, NULL, NULL, 'tes', '4000', '2023-05-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, NULL, NULL, 1, NULL, NULL, '2023-05-18 16:18:25', '2023-05-18 16:18:25'),
(14, '2023-2024', 'Tamil', NULL, 'PRE.K.G', 'testing', '1000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, 1, NULL, NULL, '2023-05-18 16:29:55', '2023-05-18 16:29:55'),
(15, '3', 'English', 'New Student', 'PRE.K.G', 'Lkg', '10500', '2023-06-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, 1, NULL, NULL, '2023-06-02 06:25:31', '2023-06-02 06:25:31'),
(16, '3', 'English', 'New Student', 'PRE.K.G', NULL, NULL, NULL, 'Pre', '15000', '2023-06-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, 0, 1, NULL, NULL, '2023-06-02 06:25:48', '2023-06-02 06:25:48'),
(17, '3', 'English', 'New Student', 'PRE.K.G', NULL, NULL, NULL, NULL, NULL, NULL, 'Table', '4500', '2023-06-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 0, 0, 1, NULL, NULL, '2023-06-02 06:26:12', '2023-06-02 06:26:12'),
(18, '3', 'Tamil', 'New Student', 'PRE.K.G', 'Tution fee', '15000', '2023-06-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 1, NULL, NULL, '2023-06-09 02:38:50', '2023-06-09 02:38:50'),
(19, '3', 'Tamil', 'New Student', 'PRE.K.G', NULL, NULL, NULL, 'Swimming', '2500', '2023-06-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, 0, 1, NULL, NULL, '2023-06-09 02:39:16', '2023-06-09 02:39:16'),
(20, '3', 'Tamil', 'New Student', 'PRE.K.G', NULL, NULL, NULL, 'Yoga', '2500', '2023-06-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, 0, 1, NULL, NULL, '2023-06-09 02:39:29', '2023-06-09 02:39:29'),
(21, '3', 'Tamil', 'New Student', 'PRE.K.G', NULL, NULL, NULL, 'Karate', '2500', '2023-06-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, 0, 1, NULL, NULL, '2023-06-09 02:40:02', '2023-06-09 02:40:02'),
(22, '3', 'Tamil', 'New Student', 'PRE.K.G', NULL, NULL, NULL, 'Art', '2500', '2023-06-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 0, 0, 1, NULL, NULL, '2023-06-09 02:40:21', '2023-06-09 02:40:21'),
(23, '3', 'Tamil', 'New Student', 'PRE.K.G', NULL, NULL, NULL, 'vcv', '33333', '2023-06-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 2, 0, 1, NULL, NULL, '2023-06-09 03:34:45', '2023-06-09 03:34:45'),
(24, '3', 'English', 'New Student', 'PRE.K.G', NULL, NULL, NULL, 'tre', '1500', '2023-06-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 2, 0, 1, NULL, NULL, '2023-06-09 03:35:24', '2023-06-09 03:35:24'),
(25, '3', 'Tamil', 'New Student', 'I', '1', '1000', '2023-06-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 1, NULL, NULL, '2023-06-09 03:47:52', '2023-06-09 03:47:52'),
(26, '3', 'Tamil', 'New Student', 'I', NULL, NULL, NULL, '2', '500', '2023-06-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 2, 0, 1, NULL, NULL, '2023-06-09 03:48:24', '2023-06-09 03:48:24'),
(27, '3', 'Tamil', 'New Student', 'I', NULL, NULL, NULL, NULL, NULL, NULL, '3', '100', '2023-06-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 1, NULL, NULL, '2023-06-09 03:48:45', '2023-06-09 03:48:45'),
(28, '1', 'Tamil', 'New Student', 'I', '1', '1000', '2023-06-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 1, NULL, NULL, '2023-06-09 05:27:51', '2023-06-09 05:27:51'),
(29, '1', 'Tamil', 'New Student', 'I', NULL, NULL, NULL, '2', '500', '2023-06-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 2, 0, 1, NULL, NULL, '2023-06-09 05:28:13', '2023-06-09 05:28:13'),
(30, '1', 'Tamil', 'New Student', 'I', NULL, NULL, NULL, NULL, NULL, NULL, '3', '100', '2023-06-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 1, NULL, NULL, '2023-06-09 05:28:28', '2023-06-09 05:28:28'),
(31, '3', 'English', 'New Student', 'PRE.K.G', 'First term', '1000', '2023-07-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 1, NULL, NULL, '2023-06-09 22:06:13', '2023-06-09 22:06:13'),
(32, '3', 'English', 'New Student', 'PRE.K.G', 'Second  term', '1000', '2023-08-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 1, NULL, NULL, '2023-06-09 22:06:39', '2023-06-09 22:06:39'),
(33, '3', 'English', 'New Student', 'PRE.K.G', 'Third term', '1000', '2023-09-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 1, NULL, NULL, '2023-06-09 22:06:54', '2023-06-09 22:06:54'),
(34, '3', 'English', 'New Student', 'PRE.K.G', 'Four term', '1000', '2023-10-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 1, NULL, NULL, '2023-06-09 22:07:08', '2023-06-09 22:07:08'),
(35, '2', 'English', 'New Student', 'I', '1', '1000', '2023-06-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0, 0, 1, NULL, NULL, '2023-06-09 22:10:42', '2023-06-09 22:10:42'),
(36, '3', 'English', 'New Student', 'PRE.K.G', NULL, NULL, NULL, 'Music ', '1000', '0020-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 2, 0, 1, NULL, NULL, '2023-06-09 22:10:43', '2023-06-09 22:10:43'),
(37, '3', 'English', 'New Student', 'PRE.K.G', NULL, NULL, NULL, 'Yoga', '1000', '0020-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 2, 0, 1, NULL, NULL, '2023-06-09 22:10:54', '2023-06-09 22:10:54'),
(38, '2', 'English', 'New Student', 'I', NULL, NULL, NULL, '2', '300', '2023-06-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 2, 0, 1, NULL, NULL, '2023-06-09 22:11:01', '2023-06-09 22:11:01'),
(39, '3', 'English', 'New Student', 'PRE.K.G', NULL, NULL, NULL, NULL, NULL, NULL, 'Book', '1000', '2023-06-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 1, NULL, NULL, '2023-06-09 22:11:21', '2023-06-09 22:11:21'),
(40, '2', 'English', 'New Student', 'I', NULL, NULL, NULL, NULL, NULL, NULL, '3', '500', '2023-06-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 1, NULL, NULL, '2023-06-09 22:11:23', '2023-06-09 22:11:23');

-- --------------------------------------------------------

--
-- Table structure for table `fees_master_model2`
--

CREATE TABLE `fees_master_model2` (
  `fees_id` int NOT NULL,
  `academic_year` varchar(250) DEFAULT NULL,
  `medium` varchar(250) DEFAULT NULL,
  `student_type` varchar(250) DEFAULT NULL,
  `standard` varchar(255) DEFAULT NULL,
  `grp_particulars` varchar(250) DEFAULT NULL,
  `grp_amount` varchar(250) DEFAULT NULL,
  `grp_ledger_name` varchar(250) DEFAULT NULL,
  `extra_particulars` varchar(250) DEFAULT NULL,
  `extra_amount` varchar(255) DEFAULT NULL,
  `extra_ledger_name` varchar(250) DEFAULT NULL,
  `amenity_particulars` varchar(250) DEFAULT NULL,
  `amenity_amount` varchar(250) DEFAULT NULL,
  `amenity_ledger_name` varchar(250) DEFAULT NULL,
  `temp_flat_no` varchar(250) DEFAULT NULL,
  `temp_street` varchar(250) DEFAULT NULL,
  `temp_district` varchar(250) DEFAULT NULL,
  `temp_area` varchar(250) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `grp_status` int NOT NULL DEFAULT '0',
  `extra_status` int NOT NULL DEFAULT '0',
  `amenity_status` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fees_master_model2`
--

INSERT INTO `fees_master_model2` (`fees_id`, `academic_year`, `medium`, `student_type`, `standard`, `grp_particulars`, `grp_amount`, `grp_ledger_name`, `extra_particulars`, `extra_amount`, `extra_ledger_name`, `amenity_particulars`, `amenity_amount`, `amenity_ledger_name`, `temp_flat_no`, `temp_street`, `temp_district`, `temp_area`, `status`, `grp_status`, `extra_status`, `amenity_status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '2019 - 2020', 'Tamil', 'New Student', '1', 'Testing', '1000', 'Uniform', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 1, NULL, NULL, '2023-04-13 14:31:21', '2023-04-13 14:31:21'),
(2, '2019 - 2020', 'Tamil', 'New Student', '1', 'Testing', '1000', 'Bag', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 1, NULL, NULL, '2023-04-13 14:36:17', '2023-04-13 14:36:17'),
(3, '2019 - 2020', 'Tamil', 'New Student', '1', NULL, NULL, NULL, 'Testing', '2000', 'uniform', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 1, NULL, NULL, '2023-04-13 14:54:26', '2023-04-13 14:54:26'),
(4, '2019 - 2020', 'Tamil', 'New Student', '1', NULL, NULL, NULL, 'Testing', '2000', 'Sports Kits', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 1, NULL, NULL, '2023-04-13 15:05:44', '2023-04-13 15:05:44'),
(5, '2019 - 2020', 'Tamil', 'New Student', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fgdfgd', '3434', '', NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, NULL, NULL, '2023-04-13 15:23:43', '2023-04-13 15:23:43'),
(6, '2019 - 2020', 'Tamil', 'New Student', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'Testing', '1000', '', NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, NULL, NULL, '2023-04-13 15:29:28', '2023-04-13 15:29:28'),
(7, '2019 - 2020', 'Tamil', 'New Student', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'Test Process', '1500', '', NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, NULL, NULL, '2023-04-13 15:34:40', '2023-04-13 15:34:40'),
(8, '2019 - 2020', 'Tamil', 'New Student', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'ttttt', '333', 'Bag', NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, NULL, NULL, '2023-04-13 15:37:46', '2023-04-13 15:37:46');

-- --------------------------------------------------------

--
-- Table structure for table `fees_master_model3`
--

CREATE TABLE `fees_master_model3` (
  `fees_id` int NOT NULL,
  `academic_year` varchar(250) DEFAULT NULL,
  `medium` varchar(250) DEFAULT NULL,
  `student_type` varchar(250) DEFAULT NULL,
  `standard` varchar(255) DEFAULT NULL,
  `grp_particulars` varchar(250) DEFAULT NULL,
  `grp_amount` varchar(250) DEFAULT NULL,
  `grp_date` varchar(250) DEFAULT NULL,
  `extra_particulars` varchar(250) DEFAULT NULL,
  `extra_amount` varchar(255) DEFAULT NULL,
  `extra_date` varchar(250) DEFAULT NULL,
  `amenity_particulars` varchar(250) DEFAULT NULL,
  `amenity_amount` varchar(250) DEFAULT NULL,
  `amenity_date` varchar(250) DEFAULT NULL,
  `temp_flat_no` varchar(250) DEFAULT NULL,
  `temp_street` varchar(250) DEFAULT NULL,
  `temp_district` varchar(250) DEFAULT NULL,
  `temp_area` varchar(250) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `grp_status` int NOT NULL DEFAULT '0',
  `extra_status` int NOT NULL DEFAULT '0',
  `amenity_status` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fees_master_model3`
--

INSERT INTO `fees_master_model3` (`fees_id`, `academic_year`, `medium`, `student_type`, `standard`, `grp_particulars`, `grp_amount`, `grp_date`, `extra_particulars`, `extra_amount`, `extra_date`, `amenity_particulars`, `amenity_amount`, `amenity_date`, `temp_flat_no`, `temp_street`, `temp_district`, `temp_area`, `status`, `grp_status`, `extra_status`, `amenity_status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '2019 - 2020', 'Tamil', NULL, '1', 'testing', '1000', '2023-04-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 1, NULL, NULL, '2023-04-13 16:27:53', '2023-04-13 16:27:53'),
(2, '2019 - 2020', 'Tamil', NULL, '1', 'testing2', '1000', '2023-04-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 1, NULL, NULL, '2023-04-13 16:29:38', '2023-04-13 16:29:38'),
(3, '2019 - 2020', 'Tamil', NULL, '1', NULL, NULL, NULL, 'test', '4545', '2023-04-21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 0, 1, NULL, NULL, '2023-04-13 16:35:00', '2023-04-13 16:35:00'),
(4, '2019 - 2020', 'Tamil', NULL, '1', NULL, NULL, NULL, 'trtrtrt', '56666', '2023-04-14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 1, NULL, NULL, '2023-04-13 16:35:30', '2023-04-13 16:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `fees_master_model4`
--

CREATE TABLE `fees_master_model4` (
  `fees_id` int NOT NULL,
  `academic_year` varchar(250) DEFAULT NULL,
  `medium` varchar(250) DEFAULT NULL,
  `student_type` varchar(250) DEFAULT NULL,
  `standard` varchar(255) DEFAULT NULL,
  `grp_particulars` varchar(250) DEFAULT NULL,
  `grp_amount` varchar(250) DEFAULT NULL,
  `grp_date` varchar(250) DEFAULT NULL,
  `extra_particulars` varchar(250) DEFAULT NULL,
  `extra_amount` varchar(255) DEFAULT NULL,
  `extra_date` varchar(250) DEFAULT NULL,
  `amenity_particulars` varchar(250) DEFAULT NULL,
  `amenity_amount` varchar(250) DEFAULT NULL,
  `amenity_date` varchar(250) DEFAULT NULL,
  `temp_flat_no` varchar(250) DEFAULT NULL,
  `temp_street` varchar(250) DEFAULT NULL,
  `temp_district` varchar(250) DEFAULT NULL,
  `temp_area` varchar(250) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `grp_status` int NOT NULL DEFAULT '0',
  `extra_status` int NOT NULL DEFAULT '0',
  `amenity_status` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fees_master_model4`
--

INSERT INTO `fees_master_model4` (`fees_id`, `academic_year`, `medium`, `student_type`, `standard`, `grp_particulars`, `grp_amount`, `grp_date`, `extra_particulars`, `extra_amount`, `extra_date`, `amenity_particulars`, `amenity_amount`, `amenity_date`, `temp_flat_no`, `temp_street`, `temp_district`, `temp_area`, `status`, `grp_status`, `extra_status`, `amenity_status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '2019 - 2020', 'Tamil', NULL, '1', 'tets', '1000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 1, NULL, NULL, '2023-04-13 17:06:16', '2023-04-13 17:06:16'),
(2, '2019 - 2020', 'Tamil', NULL, '1', NULL, NULL, NULL, 'test', '323423', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 1, 0, 1, NULL, NULL, '2023-04-13 17:12:43', '2023-04-13 17:12:43'),
(3, '2019 - 2020', 'Tamil', NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, 'fsdfsdf', '5555', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 1, NULL, NULL, '2023-04-13 17:23:24', '2023-04-13 17:23:24'),
(4, '2023-2024', 'Tamil', NULL, 'PRE.K.G', 'tets', '10000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 1, NULL, NULL, '2023-05-18 16:10:26', '2023-05-18 16:10:26');

-- --------------------------------------------------------

--
-- Table structure for table `grp_classification`
--

CREATE TABLE `grp_classification` (
  `grp_classification_id` int NOT NULL,
  `grp_classification_name` varchar(255) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `grp_classification`
--

INSERT INTO `grp_classification` (`grp_classification_id`, `grp_classification_name`, `status`, `created_date`, `updated_date`) VALUES
(1, 'Note Books', 0, '2023-05-19 14:57:33', '2023-05-19 14:57:33'),
(2, 'Ruled Note', 0, '2023-05-19 14:58:07', '2023-05-19 14:58:07');

-- --------------------------------------------------------

--
-- Table structure for table `holiday_creation`
--

CREATE TABLE `holiday_creation` (
  `holiday_id` int NOT NULL,
  `holiday_name` varchar(255) DEFAULT NULL,
  `holiday_date` varchar(250) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `holiday_creation`
--

INSERT INTO `holiday_creation` (`holiday_id`, `holiday_name`, `holiday_date`, `comments`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'Week Off', '2023-03-23', 'Testtt', 0, 1, NULL, NULL, '2023-03-23 17:23:03', '2023-03-23 17:23:03'),
(2, 'Test', '2023-03-23', 'tesdfasdf', 0, 1, NULL, NULL, '2023-03-29 13:13:21', '2023-03-29 13:13:21'),
(3, 'Week end', '2023-06-04', 'regular', 0, 1, 1, 1, '2023-06-02 15:22:40', '2023-06-02 15:22:40'),
(4, 'Hyderabad Formation hoilday ', '2023-06-02', 'School leave', 0, 1, NULL, NULL, '2023-06-02 15:23:00', '2023-06-02 15:23:00'),
(5, 'local holiday', '2023-06-24', 'car festival', 0, 1, NULL, NULL, '2023-06-10 10:42:14', '2023-06-10 10:42:14');

-- --------------------------------------------------------

--
-- Table structure for table `item_creation`
--

CREATE TABLE `item_creation` (
  `item_id` int NOT NULL,
  `grp_classification` varchar(255) DEFAULT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `uom` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `invoice_ref` varchar(255) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `item_creation`
--

INSERT INTO `item_creation` (`item_id`, `grp_classification`, `item_code`, `description`, `uom`, `quantity`, `rate`, `result`, `invoice_ref`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '2', 'ITEM1001', '192 Pages Four Ruled', 'Kg', '500', '50', '25000', '10101', 0, 1, NULL, NULL, '2023-05-19 15:54:00', '2023-05-19 15:54:00'),
(2, '1', 'ITEM1002', 'Tamil Book (X)', 'Kg', '200', '150', '30000', '10102', 0, 1, NULL, NULL, '2023-05-19 16:58:16', '2023-05-19 16:58:16');

-- --------------------------------------------------------

--
-- Table structure for table `last_year_fees_master`
--

CREATE TABLE `last_year_fees_master` (
  `last_year_fees_master_id` int NOT NULL,
  `academic_year` varchar(250) DEFAULT NULL,
  `medium` varchar(250) DEFAULT NULL,
  `student_type` varchar(250) DEFAULT NULL,
  `standard` varchar(255) DEFAULT NULL,
  `grp_particulars` varchar(250) DEFAULT NULL,
  `grp_amount` varchar(250) DEFAULT NULL,
  `grp_date` varchar(250) DEFAULT NULL,
  `extra_particulars` varchar(250) DEFAULT NULL,
  `extra_amount` varchar(255) DEFAULT NULL,
  `extra_date` varchar(250) DEFAULT NULL,
  `amenity_particulars` varchar(250) DEFAULT NULL,
  `amenity_amount` varchar(250) DEFAULT NULL,
  `amenity_date` varchar(250) DEFAULT NULL,
  `temp_flat_no` varchar(250) DEFAULT NULL,
  `temp_street` varchar(250) DEFAULT NULL,
  `temp_district` varchar(250) DEFAULT NULL,
  `temp_area` varchar(250) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `grp_status` int NOT NULL DEFAULT '0',
  `extra_status` int NOT NULL DEFAULT '0',
  `amenity_status` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `last_year_fees_master`
--

INSERT INTO `last_year_fees_master` (`last_year_fees_master_id`, `academic_year`, `medium`, `student_type`, `standard`, `grp_particulars`, `grp_amount`, `grp_date`, `extra_particulars`, `extra_amount`, `extra_date`, `amenity_particulars`, `amenity_amount`, `amenity_date`, `temp_flat_no`, `temp_street`, `temp_district`, `temp_area`, `status`, `grp_status`, `extra_status`, `amenity_status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '2022 - 2023', 'Tamil', 'New Student', 'L.K.G', 'I Term', '3', '2023-05-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 1, NULL, NULL, '2023-05-03 11:35:48', '2023-05-03 11:35:48'),
(2, '2022 - 2023', 'Tamil', 'New Student', 'PRE.K.G', 'II Term', '5000', '2023-05-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 1, NULL, NULL, '2023-05-03 11:36:02', '2023-05-03 11:36:02'),
(3, '2022 - 2023', 'Tamil', 'New Student', 'PRE.K.G', 'III Term', '4000', '2023-05-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 1, NULL, NULL, '2023-05-03 11:42:21', '2023-05-03 11:42:21'),
(4, '2022 - 2023', 'Tamil', 'New Student', 'PRE.K.G', 'IV Term', '3000', '2023-05-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 1, NULL, NULL, '2023-05-03 11:44:37', '2023-05-03 11:44:37');

-- --------------------------------------------------------

--
-- Table structure for table `ledger`
--

CREATE TABLE `ledger` (
  `ledgerid` int NOT NULL,
  `ledgername` varchar(255) DEFAULT NULL,
  `groupname` varchar(255) DEFAULT NULL,
  `subgroupname` varchar(255) DEFAULT NULL,
  `inventory` varchar(255) DEFAULT NULL,
  `costcentre` varchar(255) DEFAULT NULL,
  `openingbalancedr` varchar(200) DEFAULT NULL,
  `opening_credit` varchar(255) DEFAULT NULL,
  `opening_debit` varchar(255) DEFAULT NULL,
  `openingbalance` int DEFAULT '0',
  `status` varchar(255) DEFAULT '0',
  `exciseduty` varchar(255) DEFAULT NULL,
  `pan` varchar(255) DEFAULT NULL,
  `tin` varchar(255) DEFAULT NULL,
  `servicetax` varchar(255) DEFAULT NULL,
  `contactperson` varchar(255) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `address3` varchar(255) DEFAULT NULL,
  `address4` varchar(255) DEFAULT NULL,
  `contactnumber` varchar(255) DEFAULT NULL,
  `AccountRefId` int DEFAULT NULL,
  `ServiceTaxNumber` varchar(255) DEFAULT NULL,
  `ExciseDutyReg` varchar(255) DEFAULT NULL,
  `DebitCredit` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ledger`
--

INSERT INTO `ledger` (`ledgerid`, `ledgername`, `groupname`, `subgroupname`, `inventory`, `costcentre`, `openingbalancedr`, `opening_credit`, `opening_debit`, `openingbalance`, `status`, `exciseduty`, `pan`, `tin`, `servicetax`, `contactperson`, `address1`, `address2`, `address3`, `address4`, `contactnumber`, `AccountRefId`, `ServiceTaxNumber`, `ExciseDutyReg`, `DebitCredit`) VALUES
(3, 'SBI', '3', '17', 'No', 'No', 'CR', '0', '0', 0, '0', '', '', '', '', '', '', '', '', '', '', 17, NULL, NULL, NULL),
(4, 'Mukesh', '3', '3', 'No', 'No', 'CR', '50000', '0', 50000, '0', '', '', '', '', '', '', '', '', '', '', 3, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pay_fees`
--

CREATE TABLE `pay_fees` (
  `pay_fees_id` int NOT NULL,
  `student_id` int DEFAULT NULL,
  `grp_fees_id` varchar(250) DEFAULT NULL,
  `extra_fees_id` varchar(250) DEFAULT NULL,
  `amenity_fees_id` varchar(250) DEFAULT NULL,
  `receipt_number` varchar(250) DEFAULT NULL,
  `receipt_date` varchar(250) DEFAULT NULL,
  `register_number` varchar(250) DEFAULT NULL,
  `academic_year` varchar(250) DEFAULT NULL,
  `standard` varchar(250) DEFAULT NULL,
  `grp_particulars` varchar(250) DEFAULT NULL,
  `grp_concession_amount` varchar(250) DEFAULT NULL,
  `extra_concession_amount` varchar(250) DEFAULT NULL,
  `amenity_concession_amount` varchar(250) DEFAULT NULL,
  `grp_amount` varchar(255) DEFAULT NULL,
  `amount_recieved` varchar(250) DEFAULT NULL,
  `amount_balance` varchar(250) DEFAULT NULL,
  `extra_particulars` varchar(250) DEFAULT NULL,
  `extra_amount` varchar(250) DEFAULT NULL,
  `extra_amount_recieved` varchar(255) DEFAULT NULL,
  `extra_amount_balance` varchar(250) DEFAULT NULL,
  `amenity_particulars` varchar(250) DEFAULT NULL,
  `amenity_amount` varchar(250) DEFAULT NULL,
  `amenity_amount_recieved` varchar(250) DEFAULT NULL,
  `amenity_amount_balance` varchar(250) DEFAULT NULL,
  `other_charges_recieved` varchar(250) DEFAULT NULL,
  `other_charges` varchar(250) DEFAULT NULL,
  `fees_total` varchar(250) DEFAULT NULL,
  `grp_remarks` text,
  `extra_remarks` varchar(250) DEFAULT NULL,
  `amenity_remarks` varchar(250) DEFAULT NULL,
  `fees_scholarship` varchar(250) DEFAULT NULL,
  `final_amount_recieved` varchar(250) DEFAULT NULL,
  `fees_collected` varchar(250) DEFAULT NULL,
  `fees_balance` varchar(250) DEFAULT NULL,
  `collection_info` varchar(250) DEFAULT NULL,
  `qty1` varchar(250) DEFAULT NULL,
  `qty2` varchar(250) DEFAULT NULL,
  `qty3` varchar(250) DEFAULT NULL,
  `qty4` varchar(250) DEFAULT NULL,
  `qty5` varchar(250) DEFAULT NULL,
  `qty6` varchar(250) DEFAULT NULL,
  `qty7` varchar(250) DEFAULT NULL,
  `unit1` varchar(250) DEFAULT NULL,
  `unit2` varchar(250) DEFAULT NULL,
  `unit3` varchar(250) DEFAULT NULL,
  `unit4` varchar(250) DEFAULT NULL,
  `unit5` varchar(250) DEFAULT NULL,
  `unit6` varchar(250) DEFAULT NULL,
  `unit7` varchar(250) DEFAULT NULL,
  `amount1` varchar(250) DEFAULT NULL,
  `amount2` varchar(250) DEFAULT NULL,
  `amount3` varchar(250) DEFAULT NULL,
  `amount4` varchar(250) DEFAULT NULL,
  `amount5` varchar(250) DEFAULT NULL,
  `amount6` varchar(250) DEFAULT NULL,
  `amount7` varchar(250) DEFAULT NULL,
  `result` varchar(250) DEFAULT NULL,
  `cheque_number` varchar(250) DEFAULT NULL,
  `cheque_amount` varchar(250) DEFAULT NULL,
  `cheque_date` varchar(250) DEFAULT NULL,
  `cheque_bank_name` varchar(250) DEFAULT NULL,
  `cheque_ledger_name` varchar(250) DEFAULT NULL,
  `neft_number` varchar(250) DEFAULT NULL,
  `neft_amount` varchar(250) DEFAULT NULL,
  `neft_date` varchar(250) DEFAULT NULL,
  `neft_bank_name` varchar(250) DEFAULT NULL,
  `neft_ledger_name` varchar(250) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `approvedstatus` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pay_fees`
--

INSERT INTO `pay_fees` (`pay_fees_id`, `student_id`, `grp_fees_id`, `extra_fees_id`, `amenity_fees_id`, `receipt_number`, `receipt_date`, `register_number`, `academic_year`, `standard`, `grp_particulars`, `grp_concession_amount`, `extra_concession_amount`, `amenity_concession_amount`, `grp_amount`, `amount_recieved`, `amount_balance`, `extra_particulars`, `extra_amount`, `extra_amount_recieved`, `extra_amount_balance`, `amenity_particulars`, `amenity_amount`, `amenity_amount_recieved`, `amenity_amount_balance`, `other_charges_recieved`, `other_charges`, `fees_total`, `grp_remarks`, `extra_remarks`, `amenity_remarks`, `fees_scholarship`, `final_amount_recieved`, `fees_collected`, `fees_balance`, `collection_info`, `qty1`, `qty2`, `qty3`, `qty4`, `qty5`, `qty6`, `qty7`, `unit1`, `unit2`, `unit3`, `unit4`, `unit5`, `unit6`, `unit7`, `amount1`, `amount2`, `amount3`, `amount4`, `amount5`, `amount6`, `amount7`, `result`, `cheque_number`, `cheque_amount`, `cheque_date`, `cheque_bank_name`, `cheque_ledger_name`, `neft_number`, `neft_amount`, `neft_date`, `neft_bank_name`, `neft_ledger_name`, `status`, `approvedstatus`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 3, '1,5,14', '3,6', '4,7', 'GRP-101', '19-05-2023', '87845123', '2023-2024', 'PRE.K.G', 'Book Fees,Book Fees2,testing', '0,0,0', '0,01000', '0,0', '0,1500,0', '0,0,0500', '0,1500,0', 'School Fees,Extra School Fees', '1000,0', '0,0', '1000,0', 'Playground Fees,Extra Playground Fees', '0,1000', '0,0', '0,1000', '', '', '4000', NULL, NULL, NULL, NULL, '4000', '500', '3500', 'Cash Payment', '2000', '500', '100', '50', '20', '10', '5', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 1, 1, NULL, '2023-05-19 09:46:07', '2023-05-19 09:46:07'),
(2, 1, '8', '', '10', '', '06-06-2023', '87845123', '', 'L.K.G', 'School Fees', '0', '', '0', '5000', '5000', '5000', '', '', '', '', 'Uniform Fees', '2000', '1000', '2000', '', '', '13000', NULL, NULL, NULL, NULL, '13000', '6000', '7000', 'Cash Payment', '2000', '500', '100', '50', '20', '10', '5', '2', '2', '10', '', '', '', '', '4000', '1000', '1000', '', '', '', '', '6000', '', '', '', '', '', '', '', '', '', '', 0, 0, 1, NULL, NULL, '2023-06-06 13:41:06', '2023-06-06 13:41:06');

-- --------------------------------------------------------

--
-- Table structure for table `pay_fees_ref`
--

CREATE TABLE `pay_fees_ref` (
  `pay_fees_reff_id` int NOT NULL,
  `student_id` int DEFAULT NULL,
  `pay_fees_id` int DEFAULT NULL,
  `final_fees_total` varchar(250) DEFAULT NULL,
  `final_concession_fees_total` varchar(250) DEFAULT NULL,
  `final_received_fees_total` varchar(250) DEFAULT NULL,
  `final_fees_collected` varchar(250) DEFAULT NULL,
  `final_fees_balance` varchar(250) DEFAULT NULL,
  `grp_fees_total` varchar(250) DEFAULT NULL,
  `extra_fees_total` varchar(250) DEFAULT NULL,
  `amenity_fees_total` varchar(250) DEFAULT NULL,
  `amenity_fees_total_received` varchar(250) DEFAULT NULL,
  `extra_fees_total_received` varchar(250) DEFAULT NULL,
  `grp_fees_total_received` varchar(250) DEFAULT NULL,
  `grp_fees_balance` int DEFAULT NULL,
  `extra_fees_balance` int DEFAULT NULL,
  `amenity_fees_balance` int DEFAULT NULL,
  `grp_concession_fees` varchar(250) DEFAULT NULL,
  `extra_concession_fees` varchar(250) DEFAULT NULL,
  `amenity_concession_fees` varchar(250) DEFAULT NULL,
  `grp_fees_id` varchar(250) DEFAULT NULL,
  `extra_fees_id` varchar(250) DEFAULT NULL,
  `amenity_fees_id` varchar(250) DEFAULT NULL,
  `grp_particulars` varchar(250) DEFAULT NULL,
  `grp_amount` varchar(250) DEFAULT NULL,
  `amount_recieved` varchar(250) DEFAULT NULL,
  `extra_particulars` varchar(250) DEFAULT NULL,
  `extra_amount` varchar(250) DEFAULT NULL,
  `extra_amount_recieved` varchar(250) DEFAULT NULL,
  `amenity_particulars` varchar(250) DEFAULT NULL,
  `amenity_amount` varchar(250) DEFAULT NULL,
  `amenity_amount_recieved` varchar(250) DEFAULT NULL,
  `grp_concession_amount` varchar(250) DEFAULT NULL,
  `extra_concession_amount` varchar(250) DEFAULT NULL,
  `amenity_concession_amount` varchar(250) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `approvedstatus` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pay_fees_ref`
--

INSERT INTO `pay_fees_ref` (`pay_fees_reff_id`, `student_id`, `pay_fees_id`, `final_fees_total`, `final_concession_fees_total`, `final_received_fees_total`, `final_fees_collected`, `final_fees_balance`, `grp_fees_total`, `extra_fees_total`, `amenity_fees_total`, `amenity_fees_total_received`, `extra_fees_total_received`, `grp_fees_total_received`, `grp_fees_balance`, `extra_fees_balance`, `amenity_fees_balance`, `grp_concession_fees`, `extra_concession_fees`, `amenity_concession_fees`, `grp_fees_id`, `extra_fees_id`, `amenity_fees_id`, `grp_particulars`, `grp_amount`, `amount_recieved`, `extra_particulars`, `extra_amount`, `extra_amount_recieved`, `amenity_particulars`, `amenity_amount`, `amenity_amount_recieved`, `grp_concession_amount`, `extra_concession_amount`, `amenity_concession_amount`, `status`, `approvedstatus`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 3, 1, '18000', NULL, '18000', '12500', '4500', '11000', '4000', '3000', '2000', '2000', '8500', 2500, 1000, 1000, '0', '1000', '0', '1,5,14', '3,6', '4,7', 'Book Fees,Book Fees2,testing', '5000,5000,1000', '05000,03000,0500', 'School Fees,Extra School Fees', '3000,1000', '02000,0', 'Playground Fees,Extra Playground Fees', '1000,2000', '01000,01000', '0,0,0', '0,01000', '0,0', 0, 0, 1, NULL, NULL, '2023-05-19 09:46:07', '2023-05-19 09:46:07'),
(2, 3, 1, '4500', NULL, '4500', '500', '4000', '2500', '1000', '1000', '0', '0', '500', 2000, 1000, 1000, '0', '0', '0', '1,5,14', '3,6', '4,7', 'Book Fees,Book Fees2,testing', '0,2000,500', '0,0500,0', 'School Fees,Extra School Fees', '1000,0', '0,0', 'Playground Fees,Extra Playground Fees', '0,1000', '0,0', '0,0,0', '0,0', '0,0', 0, 0, 1, NULL, NULL, '2023-05-19 09:47:17', '2023-05-19 09:47:17'),
(3, 3, 1, '4000', NULL, '4000', '500', '3500', '2000', '1000', '1000', '0', '0', '500', 1500, 1000, 1000, '0', '0', '0', '1,5,14', '3,6', '4,7', 'Book Fees,Book Fees2,testing', '0,1500,500', '0,0,0500', 'School Fees,Extra School Fees', '1000,0', '0,0', 'Playground Fees,Extra Playground Fees', '0,1000', '0,0', '0,0,0', '0,0', '0,0', 0, 0, 1, NULL, NULL, '2023-05-19 10:36:33', '2023-05-19 10:36:33'),
(4, 1, 2, '13000', NULL, '13000', '6000', '7000', '10000', '0', '3000', '1000', '0', '5000', 5000, 0, 2000, '0', '0', '0', '8', '', '10', 'School Fees', '10000', '5000', '', '', '', 'Uniform Fees', '3000', '1000', '0', '', '0', 0, 0, 1, NULL, NULL, '2023-06-06 13:41:06', '2023-06-06 13:41:06');

-- --------------------------------------------------------

--
-- Table structure for table `pay_last_year_fees`
--

CREATE TABLE `pay_last_year_fees` (
  `pay_last_year_fees_id` int NOT NULL,
  `student_id` int DEFAULT NULL,
  `grp_fees_id` varchar(250) DEFAULT NULL,
  `extra_fees_id` varchar(250) DEFAULT NULL,
  `amenity_fees_id` varchar(250) DEFAULT NULL,
  `receipt_number` varchar(250) DEFAULT NULL,
  `receipt_date` varchar(250) DEFAULT NULL,
  `register_number` varchar(250) DEFAULT NULL,
  `academic_year` varchar(250) DEFAULT NULL,
  `standard` varchar(250) DEFAULT NULL,
  `grp_particulars` varchar(250) DEFAULT NULL,
  `grp_concession_amount` varchar(250) DEFAULT NULL,
  `extra_concession_amount` varchar(250) DEFAULT NULL,
  `amenity_concession_amount` varchar(250) DEFAULT NULL,
  `grp_amount` varchar(255) DEFAULT NULL,
  `amount_recieved` varchar(250) DEFAULT NULL,
  `amount_balance` varchar(250) DEFAULT NULL,
  `extra_particulars` varchar(250) DEFAULT NULL,
  `extra_amount` varchar(250) DEFAULT NULL,
  `extra_amount_recieved` varchar(255) DEFAULT NULL,
  `extra_amount_balance` varchar(250) DEFAULT NULL,
  `amenity_particulars` varchar(250) DEFAULT NULL,
  `amenity_amount` varchar(250) DEFAULT NULL,
  `amenity_amount_recieved` varchar(250) DEFAULT NULL,
  `amenity_amount_balance` varchar(250) DEFAULT NULL,
  `other_charges_recieved` varchar(250) DEFAULT NULL,
  `other_charges` varchar(250) DEFAULT NULL,
  `fees_total` varchar(250) DEFAULT NULL,
  `grp_remarks` text,
  `extra_remarks` varchar(250) DEFAULT NULL,
  `amenity_remarks` varchar(250) DEFAULT NULL,
  `fees_scholarship` varchar(250) DEFAULT NULL,
  `final_amount_recieved` varchar(250) DEFAULT NULL,
  `fees_collected` varchar(250) DEFAULT NULL,
  `fees_balance` varchar(250) DEFAULT NULL,
  `collection_info` varchar(250) DEFAULT NULL,
  `qty1` varchar(250) DEFAULT NULL,
  `qty2` varchar(250) DEFAULT NULL,
  `qty3` varchar(250) DEFAULT NULL,
  `qty4` varchar(250) DEFAULT NULL,
  `qty5` varchar(250) DEFAULT NULL,
  `qty6` varchar(250) DEFAULT NULL,
  `qty7` varchar(250) DEFAULT NULL,
  `unit1` varchar(250) DEFAULT NULL,
  `unit2` varchar(250) DEFAULT NULL,
  `unit3` varchar(250) DEFAULT NULL,
  `unit4` varchar(250) DEFAULT NULL,
  `unit5` varchar(250) DEFAULT NULL,
  `unit6` varchar(250) DEFAULT NULL,
  `unit7` varchar(250) DEFAULT NULL,
  `amount1` varchar(250) DEFAULT NULL,
  `amount2` varchar(250) DEFAULT NULL,
  `amount3` varchar(250) DEFAULT NULL,
  `amount4` varchar(250) DEFAULT NULL,
  `amount5` varchar(250) DEFAULT NULL,
  `amount6` varchar(250) DEFAULT NULL,
  `amount7` varchar(250) DEFAULT NULL,
  `result` varchar(250) DEFAULT NULL,
  `cheque_number` varchar(250) DEFAULT NULL,
  `cheque_amount` varchar(250) DEFAULT NULL,
  `cheque_date` varchar(250) DEFAULT NULL,
  `cheque_bank_name` varchar(250) DEFAULT NULL,
  `cheque_ledger_name` varchar(250) DEFAULT NULL,
  `neft_number` varchar(250) DEFAULT NULL,
  `neft_amount` varchar(250) DEFAULT NULL,
  `neft_date` varchar(250) DEFAULT NULL,
  `neft_bank_name` varchar(250) DEFAULT NULL,
  `neft_ledger_name` varchar(250) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `approvedstatus` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_last_year_fees_ref`
--

CREATE TABLE `pay_last_year_fees_ref` (
  `pay_last_year_fees_reff_id` int NOT NULL,
  `student_id` int DEFAULT NULL,
  `pay_last_year_fees_id` int DEFAULT NULL,
  `final_fees_total` varchar(250) DEFAULT NULL,
  `final_concession_fees_total` varchar(250) DEFAULT NULL,
  `final_received_fees_total` varchar(250) DEFAULT NULL,
  `final_fees_collected` varchar(250) DEFAULT NULL,
  `final_fees_balance` varchar(250) DEFAULT NULL,
  `grp_fees_total` varchar(250) DEFAULT NULL,
  `extra_fees_total` varchar(250) DEFAULT NULL,
  `amenity_fees_total` varchar(250) DEFAULT NULL,
  `amenity_fees_total_received` varchar(250) DEFAULT NULL,
  `extra_fees_total_received` varchar(250) DEFAULT NULL,
  `grp_fees_total_received` varchar(250) DEFAULT NULL,
  `grp_fees_balance` int DEFAULT NULL,
  `extra_fees_balance` int DEFAULT NULL,
  `amenity_fees_balance` int DEFAULT NULL,
  `grp_concession_fees` varchar(250) DEFAULT NULL,
  `extra_concession_fees` varchar(250) DEFAULT NULL,
  `amenity_concession_fees` varchar(250) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `approvedstatus` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_transport_fees`
--

CREATE TABLE `pay_transport_fees` (
  `pay_transport_fees_id` int NOT NULL,
  `student_id` int DEFAULT NULL,
  `transport_fees_master_id` varchar(250) DEFAULT NULL,
  `receipt_number` varchar(250) DEFAULT NULL,
  `receipt_date` varchar(250) DEFAULT NULL,
  `register_number` varchar(250) DEFAULT NULL,
  `academic_year` varchar(250) DEFAULT NULL,
  `standard` varchar(250) DEFAULT NULL,
  `grp_particulars` varchar(250) DEFAULT NULL,
  `transport_concession_amount` varchar(250) DEFAULT NULL,
  `grp_amount` varchar(255) DEFAULT NULL,
  `amount_recieved` varchar(250) DEFAULT NULL,
  `amount_balance` varchar(250) DEFAULT NULL,
  `fees_total` varchar(250) DEFAULT NULL,
  `final_amount_recieved` varchar(250) DEFAULT NULL,
  `fees_collected` varchar(250) DEFAULT NULL,
  `fees_balance` varchar(250) DEFAULT NULL,
  `collection_info` varchar(250) DEFAULT NULL,
  `qty1` varchar(250) DEFAULT NULL,
  `qty2` varchar(250) DEFAULT NULL,
  `qty3` varchar(250) DEFAULT NULL,
  `qty4` varchar(250) DEFAULT NULL,
  `qty5` varchar(250) DEFAULT NULL,
  `qty6` varchar(250) DEFAULT NULL,
  `qty7` varchar(250) DEFAULT NULL,
  `unit1` varchar(250) DEFAULT NULL,
  `unit2` varchar(250) DEFAULT NULL,
  `unit3` varchar(250) DEFAULT NULL,
  `unit4` varchar(250) DEFAULT NULL,
  `unit5` varchar(250) DEFAULT NULL,
  `unit6` varchar(250) DEFAULT NULL,
  `unit7` varchar(250) DEFAULT NULL,
  `amount1` varchar(250) DEFAULT NULL,
  `amount2` varchar(250) DEFAULT NULL,
  `amount3` varchar(250) DEFAULT NULL,
  `amount4` varchar(250) DEFAULT NULL,
  `amount5` varchar(250) DEFAULT NULL,
  `amount6` varchar(250) DEFAULT NULL,
  `amount7` varchar(250) DEFAULT NULL,
  `result` varchar(250) DEFAULT NULL,
  `cheque_number` varchar(250) DEFAULT NULL,
  `cheque_amount` varchar(250) DEFAULT NULL,
  `cheque_date` varchar(250) DEFAULT NULL,
  `cheque_bank_name` varchar(250) DEFAULT NULL,
  `cheque_ledger_name` varchar(250) DEFAULT NULL,
  `neft_number` varchar(250) DEFAULT NULL,
  `neft_amount` varchar(250) DEFAULT NULL,
  `neft_date` varchar(250) DEFAULT NULL,
  `neft_bank_name` varchar(250) DEFAULT NULL,
  `neft_ledger_name` varchar(250) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `approvedstatus` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pay_transport_fees`
--

INSERT INTO `pay_transport_fees` (`pay_transport_fees_id`, `student_id`, `transport_fees_master_id`, `receipt_number`, `receipt_date`, `register_number`, `academic_year`, `standard`, `grp_particulars`, `transport_concession_amount`, `grp_amount`, `amount_recieved`, `amount_balance`, `fees_total`, `final_amount_recieved`, `fees_collected`, `fees_balance`, `collection_info`, `qty1`, `qty2`, `qty3`, `qty4`, `qty5`, `qty6`, `qty7`, `unit1`, `unit2`, `unit3`, `unit4`, `unit5`, `unit6`, `unit7`, `amount1`, `amount2`, `amount3`, `amount4`, `amount5`, `amount6`, `amount7`, `result`, `cheque_number`, `cheque_amount`, `cheque_date`, `cheque_bank_name`, `cheque_ledger_name`, `neft_number`, `neft_amount`, `neft_date`, `neft_bank_name`, `neft_ledger_name`, `status`, `approvedstatus`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 3, '', 'TARC-101', '11-05-2023', '87845123', '2023-2024', 'PRE.K.G', 'I Term ,II Term', '0100,0200', '700,700', '0200,0100', '700,700', '2000', '1700', '300', '1400', 'Cash Payment', '2000', '500', '100', '50', '20', '10', '5', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 1, NULL, NULL, '2023-05-11 11:50:34', '2023-05-11 11:50:34'),
(2, 2, '', 'TARC-101', '18-05-2023', '87845123', '2023-2024', 'PRE.K.G', 'I Term ,II Term', '0,0', '0,500', '1000,500', '0,500', '2000', '2000', '1500', '500', 'Cash Payment', '2000', '500', '100', '50', '20', '10', '5', '', '1', '', '', '', '', '', '0', '500', '', '', '', '', '', '500', '', '', '', '', '', '', '', '', '', '', 0, 0, 1, NULL, NULL, '2023-05-18 14:28:54', '2023-05-18 14:28:54'),
(3, 4, '', 'TARC-101', '10-06-2023', '123456', '3', 'I', '1st term,2nd term,3rd term', '0,0,0', '0,550,550', '550,0,0', '0,550,550', '1650', '1650', '550', '1100', 'Cash Payment', '2000', '500', '100', '50', '20', '10', '5', '', '1', '', '1', '', '', '', '', '500', '', '50', '', '', '', '550', '', '', '', '', '', '', '', '', '', '', 0, 0, 1, 1, NULL, '2023-06-10 10:11:55', '2023-06-10 10:11:55');

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder`
--

CREATE TABLE `purchaseorder` (
  `purchase_id` int NOT NULL,
  `vendor_name` varchar(255) DEFAULT NULL,
  `bill_number` varchar(255) DEFAULT NULL,
  `bill_date` varchar(255) DEFAULT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `total_value` varchar(255) DEFAULT NULL,
  `sub_quantity` varchar(255) DEFAULT NULL,
  `unit_amount` varchar(255) DEFAULT NULL,
  `total_amount` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0',
  `createddate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `purchaseorder`
--

INSERT INTO `purchaseorder` (`purchase_id`, `vendor_name`, `bill_number`, `bill_date`, `item_code`, `rate`, `total_value`, `sub_quantity`, `unit_amount`, `total_amount`, `description`, `quantity`, `status`, `createddate`) VALUES
(1, 'Samsel Publications', 'Fn101', '29-05-2023', NULL, NULL, NULL, '15', '200', '1750', NULL, NULL, '0', '2023-05-29 11:26:31');

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorderref`
--

CREATE TABLE `purchaseorderref` (
  `pur_ref_id` int NOT NULL,
  `item_id` int DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT '0',
  `rate` varchar(255) DEFAULT '0',
  `total` varchar(255) DEFAULT '0',
  `purchase_id` int NOT NULL,
  `createddate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `purchaseorderref`
--

INSERT INTO `purchaseorderref` (`pur_ref_id`, `item_id`, `description`, `quantity`, `rate`, `total`, `purchase_id`, `createddate`) VALUES
(3, 2, 'Tamil Book (X)', '10', '150', '1500', 1, '2023-05-29 11:26:31'),
(4, 1, '192 Pages Four Ruled', '5', '50', '250', 1, '2023-05-29 11:26:31');

-- --------------------------------------------------------

--
-- Table structure for table `purpose`
--

CREATE TABLE `purpose` (
  `purposeid` int NOT NULL,
  `purposename` varchar(255) DEFAULT NULL,
  `status` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `purpose`
--

INSERT INTO `purpose` (`purposeid`, `purposename`, `status`) VALUES
(1, 'test', 0);

-- --------------------------------------------------------

--
-- Table structure for table `school_creation`
--

CREATE TABLE `school_creation` (
  `school_id` int NOT NULL,
  `school_name` varchar(255) DEFAULT NULL,
  `school_login_name` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `address1` text,
  `address2` text,
  `address3` text,
  `state` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `web_url` varchar(200) DEFAULT NULL,
  `school_logo` varchar(255) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `year_id` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `school_creation`
--

INSERT INTO `school_creation` (`school_id`, `school_name`, `school_login_name`, `district`, `address1`, `address2`, `address3`, `state`, `contact_number`, `email_id`, `web_url`, `school_logo`, `status`, `year_id`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(2, 'Annai Sivagami Hr Sec School', 'Annai Sivagamai', 'dsasdfsdf', 'Address', 'Address2', NULL, '2', '7865998565', 'sivashankari2903@gmail.com', NULL, '', 0, 3, 1, 1, NULL, '2023-03-23 17:04:22', '2023-03-23 17:04:22'),
(7, 'ST.James higher Secondary School', 'Jamesst', 'trichy', 'pudukottai road', 'Palakurichy', NULL, '1', '9876543210', 'st.james@gmail.com', 'www.Jamesroins.com', '', 0, 3, 1, 1, NULL, '2023-06-02 14:50:46', '2023-06-02 14:50:46'),
(8, 'ST.James Metriculation higher Secondary School', 'Jamesst', 'Trichy', 'pudukottai road', 'Trichy', NULL, '1', '9876543210', 'st.james@gmail.com', 'www.feathertechnology', '', 0, 2, 1, 1, NULL, '2023-06-02 15:07:06', '2023-06-02 15:07:06');

-- --------------------------------------------------------

--
-- Table structure for table `staff_creation`
--

CREATE TABLE `staff_creation` (
  `id` int NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `employee_no` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `blood_group` varchar(50) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `pan` varchar(255) DEFAULT NULL,
  `aadhar_no` varchar(255) DEFAULT NULL,
  `pf_no` varchar(255) DEFAULT NULL,
  `contact_no` varchar(150) DEFAULT NULL,
  `doj` varchar(150) DEFAULT NULL,
  `appointment_lt` varchar(150) DEFAULT NULL,
  `emg_contact_person` varchar(255) DEFAULT NULL,
  `emg_contact_no` varchar(150) DEFAULT NULL,
  `transport_details` varchar(50) DEFAULT NULL,
  `area_id` int DEFAULT NULL,
  `flat_no` varchar(100) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_acc_no` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `staff_pic` varchar(255) NOT NULL,
  `title` text,
  `certificate` varchar(255) DEFAULT NULL,
  `title1` text,
  `certificate1` varchar(255) DEFAULT NULL,
  `title2` text,
  `certificate2` varchar(255) DEFAULT NULL,
  `title3` text,
  `certificate3` varchar(255) DEFAULT NULL,
  `title4` text,
  `certificate4` varchar(255) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `school_id` int DEFAULT NULL,
  `year_id` int DEFAULT NULL,
  `deleted_staff` int DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `staff_creation`
--

INSERT INTO `staff_creation` (`id`, `first_name`, `last_name`, `employee_no`, `designation`, `gender`, `blood_group`, `qualification`, `pan`, `aadhar_no`, `pf_no`, `contact_no`, `doj`, `appointment_lt`, `emg_contact_person`, `emg_contact_no`, `transport_details`, `area_id`, `flat_no`, `street`, `area`, `district`, `bank_name`, `bank_acc_no`, `branch`, `ifsc_code`, `staff_pic`, `title`, `certificate`, `title1`, `certificate1`, `title2`, `certificate2`, `title3`, `certificate3`, `title4`, `certificate4`, `status`, `school_id`, `year_id`, `deleted_staff`, `reason`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'ABC', 'XYZ', 'ST-101', 'IT', 'Male', 'A1+', 'MCA', 'AKASA8383G', '8874-5154-4584', '54564546564', '7418529332', '2023-01-01', '2023-04-01', '', '', 'YES', 3, '555', 'Trust Road', 'Mylapore', 'Chennai', 'SBI', '1854846415656', 'Chennai', 'DGGD415515', 'photo-1541963463532-d68292c34b19.jpg', '10', 'hoc2022-banner.png', '12', 'pexels-pixabay-268533.jpg', 'UG', 'pondicherry-has-beautiful-coast-india-famous-unexplored-beaches-beautiful-coastline-india-123124828.jpg', '', '', '', '', 0, 2, 3, NULL, NULL, 1, 1, NULL, '2023-04-14 18:16:12', '2023-04-14 18:16:12'),
(2, 'Azil', 'keerthu', 'ST-102', 'IT', 'Male', 'B+', 'M.Com', 'AKASA8383G', '8874-5154-4584', '34662456254', '7418529630', '2023-02-01', '2023-04-01', 'Shrlin', '8529637410', 'YES', NULL, '555', 'Trust Road', 'Mylapore', 'Chennai', 'ICICI', '1854846415656', 'Chennai', 'DGGD415515', 'tree-736885__480.jpg', '10', 'hoc2022-banner.png', '12', 'pexels-pixabay-268533.jpg', 'UG', 'photo-1541963463532-d68292c34b19.jpg', '', '', '', '', 0, 7, 3, 1, NULL, 1, 1, 1, '2023-04-14 18:29:27', '2023-04-14 18:29:27'),
(3, 'Lourds ', 'Richard', 'ST-103', 'Computer Teacher', 'Male', 'O+', 'BE EEE', 'ABCDE1234Z', '4444-4444-4444', '101307038356', '9876543210', '2023-06-02', '2023-06-15', 'Arul Selvaraj', '9876543210', 'YES', 3, '563 7', 'voc street', 'voc street Area', 'Trichy', 'Indian Overseas Bank', '008701000074033', 'Tambaram', 'IOBA0000047', '', '', '', '', '', '', '', '', '', '', '', 0, 2, 3, NULL, NULL, 1, 1, NULL, '2023-06-05 15:02:17', '2023-06-05 15:02:17'),
(5, 'RAJESH', 'KUMAR', 'ST-104', 'STAFF', 'Male', 'B-', 'BA', 'ISBNE1234J', '8921-8342-0398', '', '8906491234', '2023-06-09', '', '', '', 'YES', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 2, 3, NULL, NULL, 1, NULL, NULL, '2023-06-09 16:21:34', '2023-06-09 16:21:34');

-- --------------------------------------------------------

--
-- Table structure for table `state_creation`
--

CREATE TABLE `state_creation` (
  `id` int NOT NULL,
  `state` varchar(200) NOT NULL,
  `state_code` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `state_creation`
--

INSERT INTO `state_creation` (`id`, `state`, `state_code`, `status`) VALUES
(1, 'Tamil Nadu', 0, 0),
(2, 'Pondicherry', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stock_issuance`
--

CREATE TABLE `stock_issuance` (
  `stock_issuance_id` int NOT NULL,
  `stock_issuance_to` varchar(255) DEFAULT NULL,
  `si_number` varchar(255) DEFAULT NULL,
  `si_date` varchar(255) DEFAULT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `total_value` varchar(255) DEFAULT NULL,
  `sub_quantity` varchar(255) DEFAULT NULL,
  `unit_amount` varchar(255) DEFAULT NULL,
  `total_amount` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0',
  `createddate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stock_issuance`
--

INSERT INTO `stock_issuance` (`stock_issuance_id`, `stock_issuance_to`, `si_number`, `si_date`, `item_code`, `rate`, `total_value`, `sub_quantity`, `unit_amount`, `total_amount`, `description`, `quantity`, `status`, `createddate`) VALUES
(1, 'Vidhya Parthia School', 'SI101', '22-05-2023', NULL, NULL, NULL, NULL, '600.00', NULL, NULL, NULL, '0', '2023-05-22 15:26:17');

-- --------------------------------------------------------

--
-- Table structure for table `stock_issuance_ref`
--

CREATE TABLE `stock_issuance_ref` (
  `stock_issuance_ref_id` int NOT NULL,
  `item_id` int DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT '0',
  `rate` varchar(255) DEFAULT '0',
  `total` varchar(255) DEFAULT '0',
  `stock_issuance_id` int NOT NULL,
  `createddate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stock_issuance_ref`
--

INSERT INTO `stock_issuance_ref` (`stock_issuance_ref_id`, `item_id`, `description`, `quantity`, `rate`, `total`, `stock_issuance_id`, `createddate`) VALUES
(1, 1, '192 Pages Four Ruled', '0', '500', '0', 1, '2023-05-22 15:26:17'),
(2, 2, 'Tamil Book (X)', '0', '100', '0', 1, '2023-05-22 15:26:17');

-- --------------------------------------------------------

--
-- Table structure for table `student_creation`
--

CREATE TABLE `student_creation` (
  `student_id` int NOT NULL,
  `temp_admission_id` int DEFAULT NULL,
  `temp_no` varchar(250) DEFAULT NULL,
  `admission_number` varchar(250) DEFAULT NULL,
  `student_name` varchar(250) DEFAULT NULL,
  `sur_name` varchar(250) DEFAULT NULL,
  `date_of_birth` varchar(250) DEFAULT NULL,
  `gender` varchar(250) NOT NULL,
  `mother_tongue` varchar(250) DEFAULT NULL,
  `aadhar_number` varchar(250) DEFAULT NULL,
  `blood_group` varchar(250) DEFAULT NULL,
  `category` varchar(250) DEFAULT NULL,
  `castename` varchar(250) DEFAULT NULL,
  `sub_caste` varchar(250) DEFAULT NULL,
  `nationality` varchar(250) DEFAULT NULL,
  `religion` varchar(250) DEFAULT NULL,
  `student_image` varchar(250) DEFAULT NULL,
  `father_image` varchar(50) DEFAULT NULL,
  `mother_image` varchar(50) DEFAULT NULL,
  `filltoo` varchar(50) DEFAULT NULL,
  `flat_no` varchar(250) DEFAULT NULL,
  `flat_no1` varchar(250) DEFAULT NULL,
  `street` varchar(250) DEFAULT NULL,
  `street1` varchar(250) DEFAULT NULL,
  `area_locatlity` varchar(255) DEFAULT NULL,
  `area_locatlity1` varchar(250) DEFAULT NULL,
  `district` varchar(250) DEFAULT NULL,
  `district1` varchar(250) DEFAULT NULL,
  `pincode` varchar(250) DEFAULT NULL,
  `pincode1` varchar(250) DEFAULT NULL,
  `standard` varchar(250) DEFAULT NULL,
  `previouschoolname` varchar(250) DEFAULT NULL,
  `previousplace` varchar(250) DEFAULT NULL,
  `strpreviousdoj` varchar(250) DEFAULT NULL,
  `strpreviousdol` varchar(250) DEFAULT NULL,
  `timeoftchandedover` varchar(250) DEFAULT NULL,
  `previousclassattended` varchar(250) DEFAULT NULL,
  `section` varchar(250) DEFAULT NULL,
  `medium` varchar(250) DEFAULT NULL,
  `studentrollno` varchar(250) DEFAULT NULL,
  `emisno` varchar(250) DEFAULT NULL,
  `studentstype` varchar(250) DEFAULT NULL,
  `referencecat` varchar(250) DEFAULT NULL,
  `refstaffid` varchar(250) DEFAULT NULL,
  `refstudentid` varchar(255) DEFAULT NULL,
  `refoldstudentid` varchar(250) DEFAULT NULL,
  `referencecatname` varchar(250) DEFAULT NULL,
  `concession_type` varchar(250) DEFAULT NULL,
  `concessiontypedetails` varchar(250) DEFAULT NULL,
  `facility` varchar(250) DEFAULT NULL,
  `roomcatogoryfeeid` varchar(250) DEFAULT NULL,
  `advancefee` varchar(250) DEFAULT NULL,
  `roomrent` varchar(250) DEFAULT NULL,
  `transportarearefid` varchar(250) DEFAULT NULL,
  `transportstopping` varchar(250) DEFAULT NULL,
  `busno` varchar(250) DEFAULT NULL,
  `father_name` varchar(250) DEFAULT NULL,
  `mother_name` varchar(250) DEFAULT NULL,
  `father_aadhar_number` varchar(250) DEFAULT NULL,
  `mother_aadhar_number` varchar(250) DEFAULT NULL,
  `occupation` varchar(250) DEFAULT NULL,
  `monthly_income` varchar(250) DEFAULT NULL,
  `nature_business` varchar(250) DEFAULT NULL,
  `position_held` varchar(250) DEFAULT NULL,
  `telephone_number` int DEFAULT NULL,
  `lives_gaurdian` text,
  `gaurdian_name` text,
  `gaurdian_mobile` text,
  `gaurdian_aadhar_number` text,
  `gaurdian_email_id` text,
  `father_mobile_no` text,
  `mother_mobile_no` text,
  `father_email_id` text,
  `sms_sent_no` text,
  `extra_curricular` text,
  `sibling_name` text,
  `sibling_school_name` text,
  `sibling_standard` text,
  `sibling_name2` text,
  `sibling_school_name2` text,
  `sibling_standard2` text,
  `sibling_name3` text,
  `sibling_school_name3` text,
  `sibling_standard3` text,
  `anyextracurricular` text,
  `title` text,
  `certificate` varchar(250) DEFAULT NULL,
  `title1` text,
  `certificate1` varchar(250) DEFAULT NULL,
  `title2` text,
  `certificate2` varchar(250) DEFAULT NULL,
  `title3` text,
  `certificate3` varchar(250) DEFAULT NULL,
  `title4` text,
  `certificate4` varchar(250) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `deleted_student` int NOT NULL DEFAULT '0',
  `reason` text,
  `school_id` int DEFAULT NULL,
  `year_id` int DEFAULT NULL,
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student_creation`
--

INSERT INTO `student_creation` (`student_id`, `temp_admission_id`, `temp_no`, `admission_number`, `student_name`, `sur_name`, `date_of_birth`, `gender`, `mother_tongue`, `aadhar_number`, `blood_group`, `category`, `castename`, `sub_caste`, `nationality`, `religion`, `student_image`, `father_image`, `mother_image`, `filltoo`, `flat_no`, `flat_no1`, `street`, `street1`, `area_locatlity`, `area_locatlity1`, `district`, `district1`, `pincode`, `pincode1`, `standard`, `previouschoolname`, `previousplace`, `strpreviousdoj`, `strpreviousdol`, `timeoftchandedover`, `previousclassattended`, `section`, `medium`, `studentrollno`, `emisno`, `studentstype`, `referencecat`, `refstaffid`, `refstudentid`, `refoldstudentid`, `referencecatname`, `concession_type`, `concessiontypedetails`, `facility`, `roomcatogoryfeeid`, `advancefee`, `roomrent`, `transportarearefid`, `transportstopping`, `busno`, `father_name`, `mother_name`, `father_aadhar_number`, `mother_aadhar_number`, `occupation`, `monthly_income`, `nature_business`, `position_held`, `telephone_number`, `lives_gaurdian`, `gaurdian_name`, `gaurdian_mobile`, `gaurdian_aadhar_number`, `gaurdian_email_id`, `father_mobile_no`, `mother_mobile_no`, `father_email_id`, `sms_sent_no`, `extra_curricular`, `sibling_name`, `sibling_school_name`, `sibling_standard`, `sibling_name2`, `sibling_school_name2`, `sibling_standard2`, `sibling_name3`, `sibling_school_name3`, `sibling_standard3`, `anyextracurricular`, `title`, `certificate`, `title1`, `certificate1`, `title2`, `certificate2`, `title3`, `certificate3`, `title4`, `certificate4`, `status`, `deleted_student`, `reason`, `school_id`, `year_id`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 2, 'PRE.K.G-2023-2', '101', 'Sivabala', 's', '2023-04-15', 'Male', 'Tamil', '8785-1548-7484-5454', 'A1+', 'BC', '', '', '', '', '', NULL, NULL, 'Address_Permanant', '8', '8', 'Street ', 'Street ', 'Area', 'Area', 'District', 'District', '605004', '605004', 'L.K.G', '', '', '', '', '', '', 'B', 'Tamil', '87845123', 'fsdfasdf', 'NewStudent', 'Other', '', '', '', 'dfsdfsdfasdf', 'General', 'Govt Quota', 'Transport', '', '', '', '1', 'erert', 'dfgdfg', 'Moorthy', 'Saraswathy', '', '', '', '', '', '', 2147483647, '', '', '', '', '', '', '', '', '', '3,6', '', '', '', '', '', '', '', '', '', '                                                                                ', '', '', '', '', '', '', '', '', '', '', 0, 0, NULL, 2, 3, 1, NULL, NULL, '2023-04-17 12:02:09', '2023-04-17 12:02:09'),
(2, 1, 'PRE.K.G-2023-1', '102', 'Sivas', '', '1993-09-21', 'Female', 'Sanskrit', '8785-1548-7484-5454', 'A1-', 'OBC', '2', 'dfsdfasdf', 'Indian', 'Hindu', '', NULL, NULL, 'Address_Permanant', '8', '8', 'Street ', 'Street ', 'Area', 'Area', 'District', 'District', '605004', '605004', 'PRE.K.G', '', '', '', '', '', '', 'B', 'Tamil', '87845123', 'fsdfasdf', 'NewStudent', 'Other', '', '', '', 'efwewerwe', 'Scholar', '', 'Transport', '', '', '', '1', 'erert', 'dfgdfg', 'Moorthy', 'Saraswathy', '6484-5114-5485-4122', '5474-7851-2484-1254', '', '', '', '', 2147483647, '', '', '', '', '', '', '', '', '', '3', '', '', '', '', '', '', '', '', '', '                                                                                ', '', '', '', '', '', '', '', '', '', '', 0, 0, NULL, 7, 3, 1, NULL, NULL, '2023-04-17 12:29:30', '2023-04-17 12:29:30'),
(3, 0, 'PRE.K.G-2023-1', '103', 'Siva', 'b', '1993-09-21', 'Female', 'Hindi', '7875-4545-7878-4545', 'A1-', 'OBC', '1', 'Testing', 'Others', 'Muslim-All', '', 'photo-1541963463532-d68292c34b19.jpg', 'hoc2022-banner.png', 'Address_Permanant', '8', '8', 'Street ', 'Street ', 'Area', 'Area', 'District', 'District', '605004', '605004', 'PRE.K.G', '', '', '', '', '', '', 'A', 'Tamil', '87845123', 'fsdfasdf', 'NewStudent', 'Agent', '', '', '', 'efwewerwe', 'RTE', '', 'Transport', '', '', '', '3', 'erert', 'dfgdfg', 'Moorthy', 'Saraswathy', '6484-5114-5485-4122', '5474-7851-2484-1254', 'Business', '10000', 'dfsdfsd', 'fsdfsdf', 2147483647, 'lives_gaurdian', 'dfasdfs', '5898565323', '7898-9965-6598-5965', '', '9895232659', '8995632323', 'sdfasdf@gmail.com', '5898565323', '23,24', 'dfsdfsd', 'fsdfasdf', 'f', 'fsdf', 'dfadfsdf', 'asdfasdfsdf', 'sdfasdfasdfas', 'sdfsadfs', 'dfasdfasdf', '                                                                                fgdfgsdfg                                                                                                      ', '', '', '', '', '', '', '', '', '', '', 0, 0, 'xdfdfdfdf', 2, 3, 0, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 9, 'I-2023-2', '123456', 'MURUGA', '', '2018-01-01', 'Male', 'Tamil', '9756-7389-9917', 'A2+', 'OBC', '1', 'DWEF', 'Indian', 'Hindu', '', '', '', 'Address_Permanant', '2', '2', 'EFW', 'EFW', 'WD', 'WD', 'PONDY', 'PONDY', '', '', 'I', '', '', '', '', '', '', 'A', '', '123456', 'CEVEFE', 'NewStudent', 'Staff', '5', '', '', '', '', 'Student Quota', 'Transport', '', '', '', '3', '2', '4', 'ASWIN', 'AKILA', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '23,24,26', '', '', '', '', '', '', '', '', '', '                                                                                ', '', '', '', '', '', '', '', '', '', '', 0, 0, NULL, 2, 3, 1, NULL, NULL, '2023-06-09 18:08:08', '2023-06-09 18:08:08'),
(5, 10, 'I-2023-3', '1234567', 'christ', '', '2018-08-02', 'Male', 'Malayalam', '2132-4432-3543', ' ', 'OBC', '1', '', 'Indian', 'Hindu', 'sri akila.PNG', '', '', 'Address_Permanant', '2', '2', 'adc', 'adc', 'adcdd', 'adcdd', 'fsdgtt', 'fsdgtt', '', '', 'I', '', '', '', '', '', '', 'A', '', '1234567', '', 'NewStudent', 'Staff', '3', '', '', '', 'General', '', '', '', '', '', '', '', '', 'john', 'mary', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '23', '', '', '', '', '', '', '', '', '', '                                                                                ', '', '', '', '', '', '', '', '', '', '', 0, 0, NULL, 2, 3, 1, NULL, NULL, '2023-06-10 10:47:39', '2023-06-10 10:47:39'),
(6, 0, '', '1046341', 'Shanmugam ', '', '2020-01-06', 'Male', 'Tamil', '1111-1111-1111', 'A1+', 'BC', '1', '', 'Indian', 'Hindu', '', '', '', 'Address_Permanant', 'No 31', 'No 31', 'Brindavan street', 'Brindavan street', 'Thirumullaivoyal ', 'Thirumullaivoyal ', 'Thiruvallur ', 'Thiruvallur ', '600062', '600062', 'PRE.K.G', '', '', '', '', '', '', 'A', '', '101001', '', 'NewStudent', '', '', '', '', '', '', '', 'Transport', '', '', '', '3', '', '', 'Jayavel ', 'Saroja ', '1111-1111-1111', '1111-1111-1111', 'Job', '25000', '', '', 0, '', '', '', '', '', '9042312671', '9042312716', 'sp@gmail.co', '', '36', '', '', '', '', '', '', '', '', '', '                                                                                ', '', '', '', '', '', '', '', '', '', '', 0, 0, NULL, 2, 3, 1, NULL, NULL, '2023-06-10 11:59:09', '2023-06-10 11:59:09');

-- --------------------------------------------------------

--
-- Table structure for table `subject_details`
--

CREATE TABLE `subject_details` (
  `subject_id` int NOT NULL,
  `class_id` varchar(255) DEFAULT NULL,
  `paper_name` varchar(255) DEFAULT NULL,
  `max_mark` varchar(255) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subject_details`
--

INSERT INTO `subject_details` (`subject_id`, `class_id`, `paper_name`, `max_mark`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '2', 'Tamil', '50', 1, 1, NULL, NULL, '2023-04-04 13:34:32', '2023-04-04 13:34:32'),
(2, '2', 'English', '50', 0, 1, NULL, NULL, '2023-04-04 13:34:52', '2023-04-04 13:34:52'),
(3, '3', 'Tamil', '50', 0, 1, NULL, NULL, '2023-04-04 13:35:03', '2023-04-04 13:35:03'),
(4, '2', 'Englishrt', '50', 0, 1, NULL, NULL, '2023-04-04 13:36:07', '2023-04-04 13:36:07'),
(5, '2', 'Science', '50', 0, 1, NULL, NULL, '2023-04-04 13:36:12', '2023-04-04 13:36:12'),
(6, '2', 'Tamilggg', '50', 1, 1, NULL, NULL, '2023-04-04 13:36:20', '2023-04-04 13:36:20'),
(7, '2', 'Maths', '50', 0, 1, NULL, NULL, '2023-04-04 13:39:42', '2023-04-04 13:39:42'),
(8, '2', 'social', '50', 0, 1, NULL, NULL, '2023-04-11 10:12:56', '2023-04-11 10:12:56'),
(9, '4', 'Maths1', '50', 0, 1, NULL, NULL, '2023-04-11 12:59:30', '2023-04-11 12:59:30');

-- --------------------------------------------------------

--
-- Table structure for table `temp_admission_student`
--

CREATE TABLE `temp_admission_student` (
  `temp_admission_id` int NOT NULL,
  `temp_no` varchar(250) DEFAULT NULL,
  `temp_student_name` varchar(250) DEFAULT NULL,
  `temp_dob` varchar(250) DEFAULT NULL,
  `temp_gender` varchar(250) DEFAULT NULL,
  `temp_category` varchar(255) DEFAULT NULL,
  `temp_standard` varchar(250) DEFAULT NULL,
  `temp_student_type` varchar(250) DEFAULT NULL,
  `temp_medium` varchar(250) DEFAULT NULL,
  `temp_entrance_exam_date` varchar(250) DEFAULT NULL,
  `temp_entrance_exam_mark` varchar(255) DEFAULT NULL,
  `temp_src` varchar(250) DEFAULT NULL,
  `temp_father_name` varchar(250) DEFAULT NULL,
  `temp_mother_name` varchar(250) DEFAULT NULL,
  `temp_contact_number` varchar(250) DEFAULT NULL,
  `temp_flat_no` varchar(250) DEFAULT NULL,
  `temp_street` varchar(250) DEFAULT NULL,
  `temp_district` varchar(250) DEFAULT NULL,
  `temp_area` varchar(250) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `school_id` int DEFAULT NULL,
  `year_id` int DEFAULT NULL,
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `temp_admission_student`
--

INSERT INTO `temp_admission_student` (`temp_admission_id`, `temp_no`, `temp_student_name`, `temp_dob`, `temp_gender`, `temp_category`, `temp_standard`, `temp_student_type`, `temp_medium`, `temp_entrance_exam_date`, `temp_entrance_exam_mark`, `temp_src`, `temp_father_name`, `temp_mother_name`, `temp_contact_number`, `temp_flat_no`, `temp_street`, `temp_district`, `temp_area`, `status`, `school_id`, `year_id`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'PRE.K.G-2023-1', 'Sivas', '1993-09-21', 'Female', 'OBC', 'PRE.K.G', 'Old Student', 'Tamil', '2023-03-25', '50', 'Scholarship', 'Moorthy', 'Saraswathy', '7845457845', '8', 'Street ', 'District', 'Area', 0, 2, 3, 1, 1, NULL, '2023-03-24 14:23:01', '2023-03-24 14:23:01'),
(2, 'PRE.K.G-2023-2', 'Sivabala', '2023-04-15', 'Male', 'OBC', 'L.K.G', 'New Student', 'Tamil', '2023-04-15', '50', 'Scholarship', 'Moorthy', 'Saraswathy', '8745152121', '8', 'Street ', 'District', 'Area', 0, 7, 3, 1, 1, 1, '2023-04-15 13:26:31', '2023-04-15 13:26:31'),
(3, 'L.K.G-2023-1', 'Shanmugam ', '2020-01-06', 'Male', 'BC', 'L.K.G', '', '', '2023-06-06', '50', 'Concession', 'Jayavel ', 'Saroja ', '9042312716', 'No 31', 'Brindavan Street', 'Thiruvallur ', 'Thirumullaivoyal ', 0, 2, 3, 1, NULL, NULL, '2023-06-06 13:17:15', '2023-06-06 13:17:15'),
(4, 'I-2023-1', 'KRISHNA', '2018-01-01', 'Male', 'OBC', 'I', '', '', '2023-06-02', '70', 'Scholarship', 'RAJ', 'SELVI', '9862384092', '2', 'CDEF', 'PONDY', 'PONDY', 0, NULL, NULL, 1, NULL, NULL, '2023-06-09 16:24:37', '2023-06-09 16:24:37'),
(5, 'I-2023-1', 'GANESH', '2018-01-01', 'Male', 'OBC', 'I', '', '', '2023-06-02', '60', 'Concession', 'RAVI', 'ANITHA', '9600780506', '13', 'SDAVSDASDV', 'SDFV', 'SDVS', 0, NULL, NULL, 1, NULL, NULL, '2023-06-09 16:27:55', '2023-06-09 16:27:55'),
(6, 'PRE.K.G-2023-1', 'lourds Richard Jeevith', '1996-09-29', 'Male', 'BC', 'PRE.K.G', '', '', '2023-05-18', '4545', 'Scholarship', 'Arul selvaraj', 'rani', '9876543210', '263 7', 'Kanesh nagar', 'Trichy', 'palakurichy', 0, NULL, NULL, 19, NULL, NULL, '2023-06-09 16:32:34', '2023-06-09 16:32:34'),
(7, 'IV-2023-1', 'lourds Richard Jeevith 11', '1998-03-23', 'Male', 'BC', 'IV', '', '', '2023-06-15', '54', 'Scholarship', 'Arul selvaraj', 'rani', '9876543210', '263 7', 'Kanesh nagar', 'Trichy', 'palakurichy', 0, 2, 3, 1, NULL, NULL, '2023-06-09 17:53:02', '2023-06-09 17:53:02'),
(8, 'XI_Maths_ComputerScience-2023-1', 'lourds Richard Jeevith 11', '1997-01-17', 'Male', 'BC', 'XI_Maths_ComputerScience', '', '', '2023-05-05', '565', 'Scholarship', 'Arul selvaraj', 'rani', '9876543210', '263 7', 'Kanesh nagar', 'Trichy', 'palakurichy', 0, 2, 3, 1, NULL, NULL, '2023-06-09 17:59:27', '2023-06-09 17:59:27'),
(9, 'I-2023-2', 'MURUGA', '2023-06-09', 'Male', 'OBC', 'I', '', '', '2023-06-02', '60', 'Scholarship', 'ASWIN', 'AKILA', '9600780506', '2', 'EFW', 'PONDY', 'WD', 0, 2, 3, 1, NULL, NULL, '2023-06-09 18:01:48', '2023-06-09 18:01:48'),
(10, 'I-2023-3', 'christ', '2018-08-02', 'Male', 'OBC', 'I', '', '', '2023-06-09', '100', 'Concession', 'john', 'mary', '9178453919', '2', 'adc', 'fsdgtt', 'adcdd', 0, 2, 3, 1, NULL, NULL, '2023-06-10 10:44:23', '2023-06-10 10:44:23');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_certificate`
--

CREATE TABLE `transfer_certificate` (
  `transfer_id` int NOT NULL,
  `serial_number` varchar(250) DEFAULT NULL,
  `tmr_code` varchar(250) DEFAULT NULL,
  `admission_number` varchar(250) DEFAULT NULL,
  `certificate_number` varchar(255) DEFAULT NULL,
  `transfer_date` varchar(250) DEFAULT NULL,
  `school_name` varchar(250) DEFAULT NULL,
  `district_educational` varchar(250) DEFAULT NULL,
  `revenue_district` varchar(250) DEFAULT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `parents_name` varchar(250) DEFAULT NULL,
  `nationality` varchar(250) DEFAULT NULL,
  `caste` varchar(250) DEFAULT NULL,
  `gender` varchar(250) DEFAULT NULL,
  `admission_date` varchar(250) DEFAULT NULL,
  `register_words` varchar(250) DEFAULT NULL,
  `personal_identification` varchar(250) DEFAULT NULL,
  `date_first_admission` varchar(250) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `standard` varchar(250) DEFAULT NULL,
  `promotion` varchar(250) DEFAULT NULL,
  `scholarship` varchar(250) DEFAULT NULL,
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `medical_inspection` varchar(250) DEFAULT NULL,
  `date_school` varchar(250) DEFAULT NULL,
  `conduct` varchar(250) DEFAULT NULL,
  `date_parents` varchar(250) DEFAULT NULL,
  `date_of_transfer_certificate` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transfer_certificate`
--

INSERT INTO `transfer_certificate` (`transfer_id`, `serial_number`, `tmr_code`, `admission_number`, `certificate_number`, `transfer_date`, `school_name`, `district_educational`, `revenue_district`, `student_name`, `parents_name`, `nationality`, `caste`, `gender`, `admission_date`, `register_words`, `personal_identification`, `date_first_admission`, `status`, `standard`, `promotion`, `scholarship`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`, `medical_inspection`, `date_school`, `conduct`, `date_parents`, `date_of_transfer_certificate`) VALUES
(1, '1', '101TMR', '103', '10101', '2023-05-18', 'school name', 'educational district', 'revenue district', 'SIVA', 'Moorthi', 'indian  hindu', 'mbc', 'female', '2023-05-16', 'dsdds', 'dsd', 'sdsd', 0, 'dfasdfad', 'asdfadfs', 'dfasdfasdf', 1, 1, 1, '2023-05-18 12:25:07', '2023-05-18 12:25:07', 'sdsd', 'sdsd', 'Good', '2023-05-18', '2023-05-19'),
(2, '2', '101TMR', '102', '10101', '2023-05-18', 'school name', 'educational district', 'revenue district', 'Siva', 'Moorthi', 'indian  hindu', 'mbc', 'female', '2023-05-18', 'dsdds', 'dsd', 'sdsd', 0, 'dssd', 'sdsd', 'sdsd', 1, NULL, NULL, '2023-05-18 17:25:18', '2023-05-18 17:25:18', 'sdsd', 'sdsd', 'Good', '2023-05-18', '2023-05-18');

-- --------------------------------------------------------

--
-- Table structure for table `transport_fees_master`
--

CREATE TABLE `transport_fees_master` (
  `transport_fees_master_id` int NOT NULL,
  `academic_year` varchar(250) DEFAULT NULL,
  `medium` varchar(250) DEFAULT NULL,
  `student_type` varchar(250) DEFAULT NULL,
  `standard` varchar(255) DEFAULT NULL,
  `grp_particulars` varchar(250) DEFAULT NULL,
  `grp_amount` varchar(250) DEFAULT NULL,
  `grp_date` varchar(250) DEFAULT NULL,
  `extra_particulars` varchar(250) DEFAULT NULL,
  `extra_amount` varchar(255) DEFAULT NULL,
  `extra_date` varchar(250) DEFAULT NULL,
  `amenity_particulars` varchar(250) DEFAULT NULL,
  `amenity_amount` varchar(250) DEFAULT NULL,
  `amenity_date` varchar(250) DEFAULT NULL,
  `temp_flat_no` varchar(250) DEFAULT NULL,
  `temp_street` varchar(250) DEFAULT NULL,
  `temp_district` varchar(250) DEFAULT NULL,
  `temp_area` varchar(250) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `grp_status` int NOT NULL DEFAULT '0',
  `extra_status` int NOT NULL DEFAULT '0',
  `amenity_status` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transport_fees_master`
--

INSERT INTO `transport_fees_master` (`transport_fees_master_id`, `academic_year`, `medium`, `student_type`, `standard`, `grp_particulars`, `grp_amount`, `grp_date`, `extra_particulars`, `extra_amount`, `extra_date`, `amenity_particulars`, `amenity_amount`, `amenity_date`, `temp_flat_no`, `temp_street`, `temp_district`, `temp_area`, `status`, `grp_status`, `extra_status`, `amenity_status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, '2022 - 2023', 'Tamil', 'New Student', 'PRE.K.G', 'III Term', '1000', '2023-05-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 1, NULL, NULL, '2023-05-03 10:51:03', '2023-05-03 10:51:03'),
(2, '2022 - 2023', 'Tamil', 'New Student', 'L.K.G', 'I Term', '2000', '2023-06-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 1, NULL, NULL, '2023-05-03 11:20:02', '2023-05-03 11:20:02'),
(3, '2022 - 2023', 'Tamil', 'New Student', 'PRE.K.G', 'II Term', '3000', '2023-06-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 1, NULL, NULL, '2023-05-03 11:20:14', '2023-05-03 11:20:14'),
(4, '2022 - 2023', 'Tamil', 'New Student', 'PRE.K.G', 'IV Term', '3000', '2023-06-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 1, NULL, NULL, '2023-05-03 11:22:32', '2023-05-03 11:22:32');

-- --------------------------------------------------------

--
-- Table structure for table `transport_fees_ref`
--

CREATE TABLE `transport_fees_ref` (
  `transport_fees_reff_id` int NOT NULL,
  `student_id` int DEFAULT NULL,
  `transport_fees_id` int DEFAULT NULL,
  `transport_fees_total` varchar(250) DEFAULT NULL,
  `transport_concession_fees_total` varchar(250) DEFAULT NULL,
  `transport_received_fees_total` varchar(250) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `approvedstatus` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transport_fees_ref`
--

INSERT INTO `transport_fees_ref` (`transport_fees_reff_id`, `student_id`, `transport_fees_id`, `transport_fees_total`, `transport_concession_fees_total`, `transport_received_fees_total`, `status`, `approvedstatus`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 3, 1, '2000', '300', '300', 0, 0, 1, NULL, NULL, '2023-05-11 11:50:34', '2023-05-11 11:50:34'),
(2, 2, 2, '2000', '0', '1500', 0, 0, 1, NULL, NULL, '2023-05-18 14:28:54', '2023-05-18 14:28:54'),
(3, 4, 3, '1650', '0', '550', 0, 0, 1, NULL, NULL, '2023-06-10 10:11:55', '2023-06-10 10:11:55'),
(4, 4, 1, '1650', '0', '550', 0, 0, 1, NULL, NULL, '2023-06-10 10:12:44', '2023-06-10 10:12:44');

-- --------------------------------------------------------

--
-- Table structure for table `trust_creation`
--

CREATE TABLE `trust_creation` (
  `trust_id` int NOT NULL,
  `trust_name` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `address1` text,
  `address2` text,
  `address3` text,
  `place` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `pan_number` varchar(255) DEFAULT NULL,
  `tan_number` varchar(255) DEFAULT NULL,
  `trust_logo` varchar(255) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `insert_login_id` int DEFAULT NULL,
  `update_login_id` int DEFAULT NULL,
  `delete_login_id` int DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `trust_creation`
--

INSERT INTO `trust_creation` (`trust_id`, `trust_name`, `contact_person`, `contact_number`, `address1`, `address2`, `address3`, `place`, `pincode`, `email_id`, `website`, `pan_number`, `tan_number`, `trust_logo`, `status`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'Agaram', 'Surya', '1212121212', 'Bussy Street', 'Chinnakadai', '', 'Pondicherry', '121212', 'test@gmail.com', 'www.feathertechnology.com', 'ABCTY1234D', 'PDES03028F', 'img_avatar1.png', 0, 1, 18, NULL, '2023-04-06 15:51:33', '2023-04-06 15:51:33');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `school_id` int NOT NULL,
  `emailid` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0',
  `Createddate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `fullname`, `title`, `school_id`, `emailid`, `user_name`, `user_password`, `role`, `status`, `Createddate`) VALUES
(1, 'Super', 'Admin', 'Super Admin', 'Super Admin', 2, 'support@feathertechnology.in', 'support@feathertechnology.in', 'admin@123', '1', '0', '2021-04-17 17:08:00'),
(18, 'Admin2', 'admin', 'Super Admin2', 'test', 7, 'test@gmil.com', 'test@gmail.com', 'test@123', '1', '0', '2022-11-09 11:19:58'),
(19, 'Super', 'User', 'SuperUser', 'test', 8, 'E8@gmil.com', 'E8@gmil.com', 'test@123', '1', '0', '2023-06-09 03:53:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`year_id`);

--
-- Indexes for table `accountsgroup`
--
ALTER TABLE `accountsgroup`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `area_creation`
--
ALTER TABLE `area_creation`
  ADD PRIMARY KEY (`area_id`);

--
-- Indexes for table `bankmaster`
--
ALTER TABLE `bankmaster`
  ADD PRIMARY KEY (`bankid`);

--
-- Indexes for table `billsettings`
--
ALTER TABLE `billsettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conduct_certificate`
--
ALTER TABLE `conduct_certificate`
  ADD PRIMARY KEY (`conduct_id`);

--
-- Indexes for table `costcentre`
--
ALTER TABLE `costcentre`
  ADD PRIMARY KEY (`costcentreid`);

--
-- Indexes for table `deleted_student_creation`
--
ALTER TABLE `deleted_student_creation`
  ADD PRIMARY KEY (`deleted_student_id`);

--
-- Indexes for table `fees_master`
--
ALTER TABLE `fees_master`
  ADD PRIMARY KEY (`fees_id`);

--
-- Indexes for table `fees_master_model2`
--
ALTER TABLE `fees_master_model2`
  ADD PRIMARY KEY (`fees_id`);

--
-- Indexes for table `fees_master_model3`
--
ALTER TABLE `fees_master_model3`
  ADD PRIMARY KEY (`fees_id`);

--
-- Indexes for table `fees_master_model4`
--
ALTER TABLE `fees_master_model4`
  ADD PRIMARY KEY (`fees_id`);

--
-- Indexes for table `grp_classification`
--
ALTER TABLE `grp_classification`
  ADD PRIMARY KEY (`grp_classification_id`);

--
-- Indexes for table `holiday_creation`
--
ALTER TABLE `holiday_creation`
  ADD PRIMARY KEY (`holiday_id`);

--
-- Indexes for table `item_creation`
--
ALTER TABLE `item_creation`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `last_year_fees_master`
--
ALTER TABLE `last_year_fees_master`
  ADD PRIMARY KEY (`last_year_fees_master_id`);

--
-- Indexes for table `ledger`
--
ALTER TABLE `ledger`
  ADD PRIMARY KEY (`ledgerid`);

--
-- Indexes for table `pay_fees`
--
ALTER TABLE `pay_fees`
  ADD PRIMARY KEY (`pay_fees_id`);

--
-- Indexes for table `pay_fees_ref`
--
ALTER TABLE `pay_fees_ref`
  ADD PRIMARY KEY (`pay_fees_reff_id`);

--
-- Indexes for table `pay_last_year_fees`
--
ALTER TABLE `pay_last_year_fees`
  ADD PRIMARY KEY (`pay_last_year_fees_id`);

--
-- Indexes for table `pay_last_year_fees_ref`
--
ALTER TABLE `pay_last_year_fees_ref`
  ADD PRIMARY KEY (`pay_last_year_fees_reff_id`);

--
-- Indexes for table `pay_transport_fees`
--
ALTER TABLE `pay_transport_fees`
  ADD PRIMARY KEY (`pay_transport_fees_id`);

--
-- Indexes for table `purchaseorder`
--
ALTER TABLE `purchaseorder`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `purchaseorderref`
--
ALTER TABLE `purchaseorderref`
  ADD PRIMARY KEY (`pur_ref_id`);

--
-- Indexes for table `purpose`
--
ALTER TABLE `purpose`
  ADD PRIMARY KEY (`purposeid`);

--
-- Indexes for table `school_creation`
--
ALTER TABLE `school_creation`
  ADD PRIMARY KEY (`school_id`);

--
-- Indexes for table `staff_creation`
--
ALTER TABLE `staff_creation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state_creation`
--
ALTER TABLE `state_creation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_issuance`
--
ALTER TABLE `stock_issuance`
  ADD PRIMARY KEY (`stock_issuance_id`);

--
-- Indexes for table `stock_issuance_ref`
--
ALTER TABLE `stock_issuance_ref`
  ADD PRIMARY KEY (`stock_issuance_ref_id`);

--
-- Indexes for table `student_creation`
--
ALTER TABLE `student_creation`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `subject_details`
--
ALTER TABLE `subject_details`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `temp_admission_student`
--
ALTER TABLE `temp_admission_student`
  ADD PRIMARY KEY (`temp_admission_id`);

--
-- Indexes for table `transfer_certificate`
--
ALTER TABLE `transfer_certificate`
  ADD PRIMARY KEY (`transfer_id`);

--
-- Indexes for table `transport_fees_master`
--
ALTER TABLE `transport_fees_master`
  ADD PRIMARY KEY (`transport_fees_master_id`);

--
-- Indexes for table `transport_fees_ref`
--
ALTER TABLE `transport_fees_ref`
  ADD PRIMARY KEY (`transport_fees_reff_id`);

--
-- Indexes for table `trust_creation`
--
ALTER TABLE `trust_creation`
  ADD PRIMARY KEY (`trust_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_year`
--
ALTER TABLE `academic_year`
  MODIFY `year_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `accountsgroup`
--
ALTER TABLE `accountsgroup`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `area_creation`
--
ALTER TABLE `area_creation`
  MODIFY `area_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bankmaster`
--
ALTER TABLE `bankmaster`
  MODIFY `bankid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `billsettings`
--
ALTER TABLE `billsettings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `conduct_certificate`
--
ALTER TABLE `conduct_certificate`
  MODIFY `conduct_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `costcentre`
--
ALTER TABLE `costcentre`
  MODIFY `costcentreid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `deleted_student_creation`
--
ALTER TABLE `deleted_student_creation`
  MODIFY `deleted_student_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `fees_master`
--
ALTER TABLE `fees_master`
  MODIFY `fees_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `fees_master_model2`
--
ALTER TABLE `fees_master_model2`
  MODIFY `fees_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fees_master_model3`
--
ALTER TABLE `fees_master_model3`
  MODIFY `fees_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fees_master_model4`
--
ALTER TABLE `fees_master_model4`
  MODIFY `fees_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `grp_classification`
--
ALTER TABLE `grp_classification`
  MODIFY `grp_classification_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `holiday_creation`
--
ALTER TABLE `holiday_creation`
  MODIFY `holiday_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `item_creation`
--
ALTER TABLE `item_creation`
  MODIFY `item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `last_year_fees_master`
--
ALTER TABLE `last_year_fees_master`
  MODIFY `last_year_fees_master_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ledger`
--
ALTER TABLE `ledger`
  MODIFY `ledgerid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pay_fees`
--
ALTER TABLE `pay_fees`
  MODIFY `pay_fees_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pay_fees_ref`
--
ALTER TABLE `pay_fees_ref`
  MODIFY `pay_fees_reff_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pay_last_year_fees`
--
ALTER TABLE `pay_last_year_fees`
  MODIFY `pay_last_year_fees_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_last_year_fees_ref`
--
ALTER TABLE `pay_last_year_fees_ref`
  MODIFY `pay_last_year_fees_reff_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_transport_fees`
--
ALTER TABLE `pay_transport_fees`
  MODIFY `pay_transport_fees_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchaseorder`
--
ALTER TABLE `purchaseorder`
  MODIFY `purchase_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchaseorderref`
--
ALTER TABLE `purchaseorderref`
  MODIFY `pur_ref_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purpose`
--
ALTER TABLE `purpose`
  MODIFY `purposeid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `school_creation`
--
ALTER TABLE `school_creation`
  MODIFY `school_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `staff_creation`
--
ALTER TABLE `staff_creation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `state_creation`
--
ALTER TABLE `state_creation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stock_issuance`
--
ALTER TABLE `stock_issuance`
  MODIFY `stock_issuance_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_issuance_ref`
--
ALTER TABLE `stock_issuance_ref`
  MODIFY `stock_issuance_ref_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_creation`
--
ALTER TABLE `student_creation`
  MODIFY `student_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subject_details`
--
ALTER TABLE `subject_details`
  MODIFY `subject_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `temp_admission_student`
--
ALTER TABLE `temp_admission_student`
  MODIFY `temp_admission_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transfer_certificate`
--
ALTER TABLE `transfer_certificate`
  MODIFY `transfer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transport_fees_master`
--
ALTER TABLE `transport_fees_master`
  MODIFY `transport_fees_master_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transport_fees_ref`
--
ALTER TABLE `transport_fees_ref`
  MODIFY `transport_fees_reff_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `trust_creation`
--
ALTER TABLE `trust_creation`
  MODIFY `trust_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
