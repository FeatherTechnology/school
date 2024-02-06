-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2024 at 01:31 PM
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
-- Database: `school_empty`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE `academic_year` (
  `year_id` int(11) NOT NULL,
  `academic_year` varchar(150) DEFAULT NULL,
  `key_status` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accountsgroup`
--

CREATE TABLE `accountsgroup` (
  `Id` int(11) NOT NULL,
  `AccountsName` longtext DEFAULT NULL,
  `ParentId` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 0,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admission_fees`
--

CREATE TABLE `admission_fees` (
  `id` int(11) NOT NULL,
  `admission_id` int(11) NOT NULL,
  `receipt_no` varchar(100) NOT NULL,
  `receipt_date` date NOT NULL,
  `academic_year` varchar(50) NOT NULL,
  `other_charges` varchar(100) NOT NULL,
  `other_charges_received` varchar(100) NOT NULL,
  `scholarship` varchar(100) NOT NULL,
  `total_fees_tobe_collected` varchar(100) NOT NULL,
  `final_amount_tobe_collect` varchar(100) NOT NULL,
  `fees_collected` varchar(100) NOT NULL,
  `balance_tobe_paid` varchar(100) NOT NULL,
  `school_id` int(11) NOT NULL,
  `insert_login_id` int(11) NOT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `created_on` date NOT NULL DEFAULT current_timestamp(),
  `updated_on` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admission_fees_denomination`
--

CREATE TABLE `admission_fees_denomination` (
  `id` int(11) NOT NULL,
  `admission_fees_ref_id` varchar(150) NOT NULL,
  `payment_mode` varchar(50) NOT NULL,
  `ledger_ref_id` varchar(50) DEFAULT NULL,
  `no_five_hundred` varchar(100) DEFAULT NULL,
  `no_two_hundred` varchar(100) DEFAULT NULL,
  `no_hundred` varchar(100) DEFAULT NULL,
  `no_fifty` varchar(100) DEFAULT NULL,
  `no_twenty` varchar(100) DEFAULT NULL,
  `no_ten` varchar(100) DEFAULT NULL,
  `no_five` varchar(100) DEFAULT NULL,
  `total_amount` varchar(250) DEFAULT NULL,
  `cheque_number` varchar(150) DEFAULT NULL,
  `cheque_date` date NOT NULL,
  `cheque_amount` varchar(150) DEFAULT NULL,
  `cheque_bank_name` varchar(150) DEFAULT NULL,
  `neft_ref_number` varchar(150) DEFAULT NULL,
  `neft_tran_date` date NOT NULL,
  `neft_amount` varchar(150) DEFAULT NULL,
  `neft_bank_name` varchar(150) DEFAULT NULL,
  `insert_login_id` int(11) NOT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `created_on` date NOT NULL DEFAULT current_timestamp(),
  `updated_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admission_fees_details`
--

CREATE TABLE `admission_fees_details` (
  `id` int(11) NOT NULL,
  `admission_fees_ref_id` varchar(100) NOT NULL,
  `fees_master_id` varchar(255) NOT NULL,
  `fees_table_name` varchar(100) NOT NULL,
  `fees_id` int(255) NOT NULL,
  `fee_received` varchar(150) NOT NULL,
  `balance_tobe_paid` varchar(150) NOT NULL,
  `scholarship` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `amenity_fee`
--

CREATE TABLE `amenity_fee` (
  `amenity_fee_id` int(11) NOT NULL,
  `fee_master_id` int(50) NOT NULL,
  `amenity_particulars` varchar(150) NOT NULL,
  `amenity_amount` int(50) NOT NULL,
  `amenity_date` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `amenity_id_used` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `area_creation`
--

CREATE TABLE `area_creation` (
  `area_id` int(11) NOT NULL,
  `area_name` varchar(255) DEFAULT NULL,
  `item_details` varchar(255) DEFAULT NULL,
  `due_amount` varchar(255) DEFAULT NULL,
  `due_date` text DEFAULT NULL,
  `no_of_terms` text DEFAULT NULL,
  `transport_amount` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `school_id` int(11) DEFAULT NULL,
  `year_id` varchar(100) DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `area_creation_particulars`
--

CREATE TABLE `area_creation_particulars` (
  `particulars_id` int(11) NOT NULL,
  `area_creation_id` int(11) DEFAULT NULL,
  `particulars` varchar(50) DEFAULT NULL,
  `due_amount` varchar(50) DEFAULT NULL,
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attachment`
--

CREATE TABLE `attachment` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `attach_format` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) NOT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp(),
  `updated_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bankmaster`
--

CREATE TABLE `bankmaster` (
  `bankid` int(11) NOT NULL,
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
  `loanamount` int(11) DEFAULT NULL,
  `emi` int(11) DEFAULT NULL,
  `restofinterest` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `createddate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `billsettings`
--

CREATE TABLE `billsettings` (
  `id` int(11) NOT NULL,
  `billmodel` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cast_details`
--

CREATE TABLE `cast_details` (
  `cast_id` int(11) NOT NULL,
  `cast_name` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conduct_certificate`
--

CREATE TABLE `conduct_certificate` (
  `conduct_id` int(11) NOT NULL,
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
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `costcentre`
--

CREATE TABLE `costcentre` (
  `costcentreid` int(11) NOT NULL,
  `costcentrename` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deleted_student_creation`
--

CREATE TABLE `deleted_student_creation` (
  `deleted_student_id` int(11) NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extra_curricular_activities_fee`
--

CREATE TABLE `extra_curricular_activities_fee` (
  `extra_fee_id` int(11) NOT NULL,
  `fee_master_id` int(50) NOT NULL,
  `extra_particulars` varchar(150) NOT NULL,
  `extra_amount` varchar(50) NOT NULL,
  `extra_date` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `extra_id_used` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees_master`
--

CREATE TABLE `fees_master` (
  `fees_id` int(11) NOT NULL,
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
  `status` int(11) NOT NULL DEFAULT 0,
  `grp_status` int(11) NOT NULL DEFAULT 0,
  `extra_status` int(11) NOT NULL DEFAULT 0,
  `amenity_status` int(11) NOT NULL DEFAULT 0,
  `school_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees_master_model2`
--

CREATE TABLE `fees_master_model2` (
  `fees_id` int(11) NOT NULL,
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
  `status` int(11) NOT NULL DEFAULT 0,
  `grp_status` int(11) NOT NULL DEFAULT 0,
  `extra_status` int(11) NOT NULL DEFAULT 0,
  `amenity_status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees_master_model3`
--

CREATE TABLE `fees_master_model3` (
  `fees_id` int(11) NOT NULL,
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
  `status` int(11) NOT NULL DEFAULT 0,
  `grp_status` int(11) NOT NULL DEFAULT 0,
  `extra_status` int(11) NOT NULL DEFAULT 0,
  `amenity_status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees_master_model4`
--

CREATE TABLE `fees_master_model4` (
  `fees_id` int(11) NOT NULL,
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
  `status` int(11) NOT NULL DEFAULT 0,
  `grp_status` int(11) NOT NULL DEFAULT 0,
  `extra_status` int(11) NOT NULL DEFAULT 0,
  `amenity_status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_course_fee`
--

CREATE TABLE `group_course_fee` (
  `grp_course_id` int(11) NOT NULL,
  `fee_master_id` int(11) NOT NULL,
  `grp_particulars` varchar(150) NOT NULL,
  `grp_amount` varchar(150) NOT NULL,
  `grp_date` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `grp_id_used` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grp_classification`
--

CREATE TABLE `grp_classification` (
  `grp_classification_id` int(11) NOT NULL,
  `grp_classification_name` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holiday_creation`
--

CREATE TABLE `holiday_creation` (
  `holiday_id` int(11) NOT NULL,
  `holiday_name` varchar(255) DEFAULT NULL,
  `holiday_date` varchar(250) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `academic_year` varchar(100) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_creation`
--

CREATE TABLE `item_creation` (
  `item_id` int(11) NOT NULL,
  `grp_classification` varchar(255) DEFAULT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `uom` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `invoice_ref` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `last_year_fees`
--

CREATE TABLE `last_year_fees` (
  `id` int(11) NOT NULL,
  `admission_id` varchar(255) NOT NULL,
  `receipt_no` varchar(100) NOT NULL,
  `receipt_date` date NOT NULL,
  `academic_year` varchar(50) NOT NULL,
  `other_charges` varchar(255) NOT NULL,
  `other_charges_received` varchar(255) NOT NULL,
  `scholarship` varchar(255) NOT NULL,
  `total_fees_tobe_collected` varchar(255) NOT NULL,
  `final_amount_tobe_collect` varchar(255) NOT NULL,
  `fees_collected` varchar(255) NOT NULL,
  `balance_tobe_paid` varchar(255) NOT NULL,
  `school_id` int(11) NOT NULL,
  `insert_login_id` int(11) NOT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `created_on` date NOT NULL DEFAULT current_timestamp(),
  `updated_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `last_year_fees_denomination`
--

CREATE TABLE `last_year_fees_denomination` (
  `id` int(11) NOT NULL,
  `admission_fees_ref_id` varchar(150) NOT NULL,
  `payment_mode` varchar(50) NOT NULL,
  `ledger_ref_id` varchar(50) DEFAULT NULL,
  `no_five_hundred` varchar(100) DEFAULT NULL,
  `no_two_hundred` varchar(100) DEFAULT NULL,
  `no_hundred` varchar(100) DEFAULT NULL,
  `no_fifty` varchar(100) DEFAULT NULL,
  `no_twenty` varchar(100) DEFAULT NULL,
  `no_ten` varchar(100) DEFAULT NULL,
  `no_five` varchar(100) DEFAULT NULL,
  `total_amount` varchar(250) DEFAULT NULL,
  `cheque_number` varchar(150) DEFAULT NULL,
  `cheque_date` date NOT NULL,
  `cheque_amount` varchar(150) DEFAULT NULL,
  `cheque_bank_name` varchar(150) DEFAULT NULL,
  `neft_ref_number` varchar(150) DEFAULT NULL,
  `neft_tran_date` date NOT NULL,
  `neft_amount` varchar(150) DEFAULT NULL,
  `neft_bank_name` varchar(150) DEFAULT NULL,
  `insert_login_id` int(11) NOT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `created_on` date NOT NULL DEFAULT current_timestamp(),
  `updated_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `last_year_fees_details`
--

CREATE TABLE `last_year_fees_details` (
  `id` int(11) NOT NULL,
  `admission_fees_ref_id` varchar(100) NOT NULL,
  `fees_master_id` varchar(255) NOT NULL,
  `fees_table_name` varchar(100) NOT NULL,
  `fees_id` varchar(255) NOT NULL,
  `fee_received` varchar(150) NOT NULL,
  `balance_tobe_paid` varchar(150) NOT NULL,
  `scholarship` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `last_year_fees_master`
--

CREATE TABLE `last_year_fees_master` (
  `last_year_fees_master_id` int(11) NOT NULL,
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
  `status` int(11) NOT NULL DEFAULT 0,
  `grp_status` int(11) NOT NULL DEFAULT 0,
  `extra_status` int(11) NOT NULL DEFAULT 0,
  `amenity_status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ledger`
--

CREATE TABLE `ledger` (
  `ledgerid` int(11) NOT NULL,
  `ledgername` varchar(255) DEFAULT NULL,
  `groupname` varchar(255) DEFAULT NULL,
  `subgroupname` varchar(255) DEFAULT NULL,
  `inventory` varchar(255) DEFAULT NULL,
  `costcentre` varchar(255) DEFAULT NULL,
  `openingbalancedr` varchar(200) DEFAULT NULL,
  `opening_credit` varchar(255) DEFAULT NULL,
  `opening_debit` varchar(255) DEFAULT NULL,
  `openingbalance` int(11) DEFAULT 0,
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
  `AccountRefId` int(11) DEFAULT NULL,
  `ServiceTaxNumber` varchar(255) DEFAULT NULL,
  `ExciseDutyReg` varchar(255) DEFAULT NULL,
  `DebitCredit` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_fees`
--

CREATE TABLE `pay_fees` (
  `pay_fees_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
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
  `grp_remarks` text DEFAULT NULL,
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
  `status` int(11) NOT NULL DEFAULT 0,
  `school_id` int(11) NOT NULL,
  `approvedstatus` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_fees_ref`
--

CREATE TABLE `pay_fees_ref` (
  `pay_fees_reff_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `pay_fees_id` int(11) DEFAULT NULL,
  `receipt_number` varchar(250) DEFAULT NULL,
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
  `grp_fees_balance` int(11) DEFAULT NULL,
  `extra_fees_balance` int(11) DEFAULT NULL,
  `amenity_fees_balance` int(11) DEFAULT NULL,
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
  `status` int(11) NOT NULL DEFAULT 0,
  `approvedstatus` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_last_year_fees`
--

CREATE TABLE `pay_last_year_fees` (
  `pay_last_year_fees_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
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
  `grp_remarks` text DEFAULT NULL,
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
  `status` int(11) NOT NULL DEFAULT 0,
  `approvedstatus` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_last_year_fees_ref`
--

CREATE TABLE `pay_last_year_fees_ref` (
  `pay_last_year_fees_reff_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `pay_last_year_fees_id` int(11) DEFAULT NULL,
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
  `grp_fees_balance` int(11) DEFAULT NULL,
  `extra_fees_balance` int(11) DEFAULT NULL,
  `amenity_fees_balance` int(11) DEFAULT NULL,
  `grp_concession_fees` varchar(250) DEFAULT NULL,
  `extra_concession_fees` varchar(250) DEFAULT NULL,
  `amenity_concession_fees` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `approvedstatus` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_transport_fees`
--

CREATE TABLE `pay_transport_fees` (
  `pay_transport_fees_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
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
  `school_id` int(11) DEFAULT NULL,
  `transport_remark` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `approvedstatus` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder`
--

CREATE TABLE `purchaseorder` (
  `purchase_id` int(11) NOT NULL,
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
  `createddate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorderref`
--

CREATE TABLE `purchaseorderref` (
  `pur_ref_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT '0',
  `rate` varchar(255) DEFAULT '0',
  `total` varchar(255) DEFAULT '0',
  `purchase_id` int(11) NOT NULL,
  `createddate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purpose`
--

CREATE TABLE `purpose` (
  `purposeid` int(11) NOT NULL,
  `purposename` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_creation`
--

CREATE TABLE `school_creation` (
  `school_id` int(11) NOT NULL,
  `school_name` varchar(255) DEFAULT NULL,
  `school_login_name` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `address1` text DEFAULT NULL,
  `address2` text DEFAULT NULL,
  `address3` text DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `web_url` varchar(200) DEFAULT NULL,
  `school_logo` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `year_id` varchar(100) DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_creation`
--

INSERT INTO `school_creation` (`school_id`, `school_name`, `school_login_name`, `district`, `address1`, `address2`, `address3`, `state`, `pincode`, `contact_number`, `email_id`, `web_url`, `school_logo`, `status`, `year_id`, `insert_login_id`, `update_login_id`, `delete_login_id`, `created_date`, `updated_date`) VALUES
(1, 'VIDHYA PARTHI NATIONAL ACADEMY', 'VIDHYA PARTHI NATIONAL ACADEMY', 'Dindigul', 'SEELAPADI', '', NULL, '1', '624005', '9597575922', 'vpnacbse@gmail.com', 'www.vpnacbse.com', 'tree-736885__480.jpg', 0, '2023-2024', 1, 1, NULL, '2023-12-02 14:43:44', '2023-12-02 14:43:44');

-- --------------------------------------------------------

--
-- Table structure for table `staff_creation`
--

CREATE TABLE `staff_creation` (
  `id` int(11) NOT NULL,
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
  `area_id` int(11) DEFAULT NULL,
  `flat_no` varchar(100) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_acc_no` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `staff_pic` varchar(255) NOT NULL,
  `title` text DEFAULT NULL,
  `certificate` varchar(255) DEFAULT NULL,
  `title1` text DEFAULT NULL,
  `certificate1` varchar(255) DEFAULT NULL,
  `title2` text DEFAULT NULL,
  `certificate2` varchar(255) DEFAULT NULL,
  `title3` text DEFAULT NULL,
  `certificate3` varchar(255) DEFAULT NULL,
  `title4` text DEFAULT NULL,
  `certificate4` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `year_id` varchar(100) DEFAULT NULL,
  `deleted_staff` int(11) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `standard_creation`
--

CREATE TABLE `standard_creation` (
  `standard_id` int(11) NOT NULL,
  `standard` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `state_creation`
--

CREATE TABLE `state_creation` (
  `id` int(11) NOT NULL,
  `state` varchar(200) NOT NULL,
  `state_code` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_issuance`
--

CREATE TABLE `stock_issuance` (
  `stock_issuance_id` int(11) NOT NULL,
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
  `createddate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_issuance_ref`
--

CREATE TABLE `stock_issuance_ref` (
  `stock_issuance_ref_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT '0',
  `rate` varchar(255) DEFAULT '0',
  `total` varchar(255) DEFAULT '0',
  `stock_issuance_id` int(11) NOT NULL,
  `createddate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_creation`
--

CREATE TABLE `student_creation` (
  `student_id` int(11) NOT NULL,
  `temp_admission_id` int(11) DEFAULT NULL,
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
  `telephone_number` int(11) DEFAULT NULL,
  `lives_gaurdian` text DEFAULT NULL,
  `gaurdian_name` text DEFAULT NULL,
  `gaurdian_mobile` text DEFAULT NULL,
  `gaurdian_aadhar_number` text DEFAULT NULL,
  `gaurdian_email_id` text DEFAULT NULL,
  `father_mobile_no` text DEFAULT NULL,
  `mother_mobile_no` text DEFAULT NULL,
  `father_email_id` text DEFAULT NULL,
  `sms_sent_no` text DEFAULT NULL,
  `extra_curricular` text DEFAULT NULL,
  `sibling_name` text DEFAULT NULL,
  `sibling_school_name` text DEFAULT NULL,
  `sibling_standard` text DEFAULT NULL,
  `sibling_name2` text DEFAULT NULL,
  `sibling_school_name2` text DEFAULT NULL,
  `sibling_standard2` text DEFAULT NULL,
  `sibling_name3` text DEFAULT NULL,
  `sibling_school_name3` text DEFAULT NULL,
  `sibling_standard3` text DEFAULT NULL,
  `anyextracurricular` text DEFAULT NULL,
  `title` text DEFAULT NULL,
  `certificate` varchar(250) DEFAULT NULL,
  `title1` text DEFAULT NULL,
  `certificate1` varchar(250) DEFAULT NULL,
  `title2` text DEFAULT NULL,
  `certificate2` varchar(250) DEFAULT NULL,
  `title3` text DEFAULT NULL,
  `certificate3` varchar(250) DEFAULT NULL,
  `title4` text DEFAULT NULL,
  `certificate4` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `deleted_student` int(11) NOT NULL DEFAULT 0,
  `reason` text DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `year_id` varchar(100) DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject_details`
--

CREATE TABLE `subject_details` (
  `subject_id` int(11) NOT NULL,
  `class_id` varchar(255) DEFAULT NULL,
  `paper_name` varchar(255) DEFAULT NULL,
  `max_mark` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_admissionfees_details`
--

CREATE TABLE `temp_admissionfees_details` (
  `id` int(11) NOT NULL,
  `TempAdmFeeRefId` int(255) NOT NULL,
  `FeesMasterId` varchar(255) DEFAULT NULL,
  `FeesTableName` varchar(100) DEFAULT NULL,
  `FeesId` int(255) NOT NULL,
  `FeeReceived` varchar(150) NOT NULL,
  `BalancetobePaid` varchar(150) NOT NULL,
  `Scholarship` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_admission_fees`
--

CREATE TABLE `temp_admission_fees` (
  `id` int(11) NOT NULL,
  `TempAdmissionId` int(11) NOT NULL,
  `ReceiptNo` varchar(100) NOT NULL,
  `ReceiptDate` date NOT NULL,
  `AcademicYear` varchar(50) NOT NULL,
  `Othercharges` varchar(100) NOT NULL,
  `OtherChargesReceived` varchar(100) NOT NULL,
  `Scholarship` varchar(100) NOT NULL,
  `TotalFeestobeCollected` varchar(100) NOT NULL,
  `FinalAmounttobeCollect` varchar(100) NOT NULL,
  `FeesCollected` varchar(100) NOT NULL,
  `BalancetobePaid` varchar(100) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `insert_login_id` int(11) NOT NULL,
  `update_login_id` int(11) NOT NULL,
  `created_on` date NOT NULL DEFAULT current_timestamp(),
  `updated_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_admission_fees_denomination`
--

CREATE TABLE `temp_admission_fees_denomination` (
  `id` int(11) NOT NULL,
  `TempAdmFeeRefId` varchar(150) DEFAULT NULL,
  `PaymentMode` varchar(50) DEFAULT NULL,
  `LedgerRefId` varchar(50) DEFAULT NULL,
  `No_Fivehundred` varchar(100) DEFAULT NULL,
  `No_Twohundred` varchar(100) DEFAULT NULL,
  `No_hundred` varchar(100) DEFAULT NULL,
  `No_fifty` varchar(100) DEFAULT NULL,
  `No_twenty` varchar(100) DEFAULT NULL,
  `No_ten` varchar(100) DEFAULT NULL,
  `No_five` varchar(100) DEFAULT NULL,
  `totalamt` varchar(250) DEFAULT NULL,
  `ChequeNumber` varchar(150) DEFAULT NULL,
  `ChequeDate` date NOT NULL,
  `ChequeAmt` varchar(150) DEFAULT NULL,
  `ChequeBankName` varchar(150) DEFAULT NULL,
  `NeftRefNumber` varchar(150) DEFAULT NULL,
  `NeftTranDate` date NOT NULL,
  `NeftAmt` varchar(150) DEFAULT NULL,
  `NeftBankName` varchar(150) DEFAULT NULL,
  `insert_login_id` int(11) NOT NULL,
  `update_login_id` int(11) NOT NULL,
  `created_on` date NOT NULL DEFAULT current_timestamp(),
  `updated_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_admission_student`
--

CREATE TABLE `temp_admission_student` (
  `temp_admission_id` int(11) NOT NULL,
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
  `status` int(11) NOT NULL DEFAULT 0,
  `school_id` int(11) DEFAULT NULL,
  `year_id` varchar(100) DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_certificate`
--

CREATE TABLE `transfer_certificate` (
  `transfer_id` int(11) NOT NULL,
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
  `status` int(11) NOT NULL DEFAULT 0,
  `standard` varchar(250) DEFAULT NULL,
  `promotion` varchar(250) DEFAULT NULL,
  `scholarship` varchar(250) DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `medical_inspection` varchar(250) DEFAULT NULL,
  `date_school` varchar(250) DEFAULT NULL,
  `conduct` varchar(250) DEFAULT NULL,
  `date_parents` varchar(250) DEFAULT NULL,
  `date_of_transfer_certificate` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_admission_fees`
--

CREATE TABLE `transport_admission_fees` (
  `id` int(11) NOT NULL,
  `admission_id` varchar(255) NOT NULL,
  `receipt_no` varchar(255) NOT NULL,
  `receipt_date` date NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `scholarship` varchar(255) NOT NULL,
  `total_fees_tobe_collected` varchar(255) NOT NULL,
  `final_amount_tobe_collect` varchar(255) NOT NULL,
  `fees_collected` varchar(255) NOT NULL,
  `balance_tobe_paid` varchar(255) NOT NULL,
  `school_id` int(11) NOT NULL,
  `insert_login_id` int(11) NOT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `created_on` date NOT NULL DEFAULT current_timestamp(),
  `updated_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_admission_fees_denomination`
--

CREATE TABLE `transport_admission_fees_denomination` (
  `id` int(11) NOT NULL,
  `admission_fees_ref_id` varchar(255) NOT NULL,
  `payment_mode` varchar(50) NOT NULL,
  `ledger_ref_id` varchar(50) NOT NULL,
  `no_five_hundred` varchar(255) DEFAULT NULL,
  `no_two_hundred` varchar(255) DEFAULT NULL,
  `no_hundred` varchar(255) DEFAULT NULL,
  `no_fifty` varchar(255) DEFAULT NULL,
  `no_twenty` varchar(255) DEFAULT NULL,
  `no_ten` varchar(255) DEFAULT NULL,
  `no_five` varchar(255) DEFAULT NULL,
  `total_amount` varchar(255) DEFAULT NULL,
  `cheque_number` varchar(255) DEFAULT NULL,
  `cheque_date` date NOT NULL,
  `cheque_amount` varchar(255) DEFAULT NULL,
  `cheque_bank_name` varchar(255) DEFAULT NULL,
  `neft_ref_number` varchar(255) DEFAULT NULL,
  `neft_tran_date` varchar(255) DEFAULT NULL,
  `neft_amount` varchar(255) DEFAULT NULL,
  `neft_bank_name` varchar(255) DEFAULT NULL,
  `insert_login_id` int(11) NOT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `created_on` date NOT NULL DEFAULT current_timestamp(),
  `updated_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_admission_fees_details`
--

CREATE TABLE `transport_admission_fees_details` (
  `id` int(11) NOT NULL,
  `admission_fees_ref_id` varchar(255) NOT NULL,
  `area_creation_id` varchar(255) NOT NULL,
  `area_creation_particulars_id` varchar(255) NOT NULL,
  `fee_received` varchar(255) NOT NULL,
  `balance_tobe_paid` varchar(255) NOT NULL,
  `scholarship` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_fees_master`
--

CREATE TABLE `transport_fees_master` (
  `transport_fees_master_id` int(11) NOT NULL,
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
  `status` int(11) NOT NULL DEFAULT 0,
  `school_id` int(11) NOT NULL,
  `grp_status` int(11) NOT NULL DEFAULT 0,
  `extra_status` int(11) NOT NULL DEFAULT 0,
  `amenity_status` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_fees_ref`
--

CREATE TABLE `transport_fees_ref` (
  `transport_fees_reff_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `transport_fees_id` int(11) DEFAULT NULL,
  `transport_fees_total` varchar(250) DEFAULT NULL,
  `transport_concession_fees_total` varchar(250) DEFAULT NULL,
  `transport_received_fees_total` varchar(250) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `approvedstatus` int(11) NOT NULL DEFAULT 0,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trust_creation`
--

CREATE TABLE `trust_creation` (
  `trust_id` int(11) NOT NULL,
  `trust_name` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `address1` text DEFAULT NULL,
  `address2` text DEFAULT NULL,
  `address3` text DEFAULT NULL,
  `place` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `pan_number` varchar(255) DEFAULT NULL,
  `tan_number` varchar(255) DEFAULT NULL,
  `trust_logo` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `school_id` varchar(100) DEFAULT NULL,
  `academic_year` varchar(100) DEFAULT NULL,
  `insert_login_id` int(11) DEFAULT NULL,
  `update_login_id` int(11) DEFAULT NULL,
  `delete_login_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `school_id` int(11) NOT NULL,
  `emailid` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0',
  `Createddate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `fullname`, `title`, `school_id`, `emailid`, `user_name`, `user_password`, `role`, `status`, `Createddate`) VALUES
(1, 'Super', 'Admin', 'Super Admin', 'Super Admin', 1, 'support@feathertechnology.in', 'support@feathertechnology.in', 'admin@123', '1', '0', '2021-04-17 17:08:00'),
(18, 'Admin2', 'admin', 'Super Admin2', 'test', 7, 'support1@feathertechnology.in', 'support1@feathertechnology.in', 'admin@123', '1', '0', '2022-11-09 11:19:58'),
(19, 'Super', 'User', 'SuperUser', 'test', 8, 'support2@feathertechnology.in\n', 'support2@feathertechnology.in', 'admin@123', '1', '0', '2023-06-09 03:53:34');

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
-- Indexes for table `admission_fees`
--
ALTER TABLE `admission_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admission_fees_denomination`
--
ALTER TABLE `admission_fees_denomination`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admission_fees_details`
--
ALTER TABLE `admission_fees_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amenity_fee`
--
ALTER TABLE `amenity_fee`
  ADD PRIMARY KEY (`amenity_fee_id`);

--
-- Indexes for table `area_creation`
--
ALTER TABLE `area_creation`
  ADD PRIMARY KEY (`area_id`);

--
-- Indexes for table `area_creation_particulars`
--
ALTER TABLE `area_creation_particulars`
  ADD PRIMARY KEY (`particulars_id`);

--
-- Indexes for table `attachment`
--
ALTER TABLE `attachment`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `cast_details`
--
ALTER TABLE `cast_details`
  ADD PRIMARY KEY (`cast_id`);

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
-- Indexes for table `extra_curricular_activities_fee`
--
ALTER TABLE `extra_curricular_activities_fee`
  ADD PRIMARY KEY (`extra_fee_id`);

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
-- Indexes for table `group_course_fee`
--
ALTER TABLE `group_course_fee`
  ADD PRIMARY KEY (`grp_course_id`);

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
-- Indexes for table `last_year_fees`
--
ALTER TABLE `last_year_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `last_year_fees_denomination`
--
ALTER TABLE `last_year_fees_denomination`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `last_year_fees_details`
--
ALTER TABLE `last_year_fees_details`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `standard_creation`
--
ALTER TABLE `standard_creation`
  ADD PRIMARY KEY (`standard_id`);

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
-- Indexes for table `temp_admissionfees_details`
--
ALTER TABLE `temp_admissionfees_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_admission_fees`
--
ALTER TABLE `temp_admission_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_admission_fees_denomination`
--
ALTER TABLE `temp_admission_fees_denomination`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `transport_admission_fees`
--
ALTER TABLE `transport_admission_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport_admission_fees_denomination`
--
ALTER TABLE `transport_admission_fees_denomination`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport_admission_fees_details`
--
ALTER TABLE `transport_admission_fees_details`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `year_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accountsgroup`
--
ALTER TABLE `accountsgroup`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admission_fees`
--
ALTER TABLE `admission_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admission_fees_denomination`
--
ALTER TABLE `admission_fees_denomination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admission_fees_details`
--
ALTER TABLE `admission_fees_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `amenity_fee`
--
ALTER TABLE `amenity_fee`
  MODIFY `amenity_fee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `area_creation`
--
ALTER TABLE `area_creation`
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `area_creation_particulars`
--
ALTER TABLE `area_creation_particulars`
  MODIFY `particulars_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attachment`
--
ALTER TABLE `attachment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bankmaster`
--
ALTER TABLE `bankmaster`
  MODIFY `bankid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billsettings`
--
ALTER TABLE `billsettings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cast_details`
--
ALTER TABLE `cast_details`
  MODIFY `cast_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conduct_certificate`
--
ALTER TABLE `conduct_certificate`
  MODIFY `conduct_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `costcentre`
--
ALTER TABLE `costcentre`
  MODIFY `costcentreid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deleted_student_creation`
--
ALTER TABLE `deleted_student_creation`
  MODIFY `deleted_student_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extra_curricular_activities_fee`
--
ALTER TABLE `extra_curricular_activities_fee`
  MODIFY `extra_fee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees_master`
--
ALTER TABLE `fees_master`
  MODIFY `fees_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees_master_model2`
--
ALTER TABLE `fees_master_model2`
  MODIFY `fees_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees_master_model3`
--
ALTER TABLE `fees_master_model3`
  MODIFY `fees_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees_master_model4`
--
ALTER TABLE `fees_master_model4`
  MODIFY `fees_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_course_fee`
--
ALTER TABLE `group_course_fee`
  MODIFY `grp_course_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grp_classification`
--
ALTER TABLE `grp_classification`
  MODIFY `grp_classification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holiday_creation`
--
ALTER TABLE `holiday_creation`
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_creation`
--
ALTER TABLE `item_creation`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `last_year_fees`
--
ALTER TABLE `last_year_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `last_year_fees_denomination`
--
ALTER TABLE `last_year_fees_denomination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `last_year_fees_details`
--
ALTER TABLE `last_year_fees_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `last_year_fees_master`
--
ALTER TABLE `last_year_fees_master`
  MODIFY `last_year_fees_master_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ledger`
--
ALTER TABLE `ledger`
  MODIFY `ledgerid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_fees`
--
ALTER TABLE `pay_fees`
  MODIFY `pay_fees_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_fees_ref`
--
ALTER TABLE `pay_fees_ref`
  MODIFY `pay_fees_reff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_last_year_fees`
--
ALTER TABLE `pay_last_year_fees`
  MODIFY `pay_last_year_fees_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_last_year_fees_ref`
--
ALTER TABLE `pay_last_year_fees_ref`
  MODIFY `pay_last_year_fees_reff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_transport_fees`
--
ALTER TABLE `pay_transport_fees`
  MODIFY `pay_transport_fees_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchaseorder`
--
ALTER TABLE `purchaseorder`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchaseorderref`
--
ALTER TABLE `purchaseorderref`
  MODIFY `pur_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purpose`
--
ALTER TABLE `purpose`
  MODIFY `purposeid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_creation`
--
ALTER TABLE `school_creation`
  MODIFY `school_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff_creation`
--
ALTER TABLE `staff_creation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `standard_creation`
--
ALTER TABLE `standard_creation`
  MODIFY `standard_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `state_creation`
--
ALTER TABLE `state_creation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_issuance`
--
ALTER TABLE `stock_issuance`
  MODIFY `stock_issuance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_issuance_ref`
--
ALTER TABLE `stock_issuance_ref`
  MODIFY `stock_issuance_ref_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_creation`
--
ALTER TABLE `student_creation`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject_details`
--
ALTER TABLE `subject_details`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_admissionfees_details`
--
ALTER TABLE `temp_admissionfees_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_admission_fees`
--
ALTER TABLE `temp_admission_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_admission_fees_denomination`
--
ALTER TABLE `temp_admission_fees_denomination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_admission_student`
--
ALTER TABLE `temp_admission_student`
  MODIFY `temp_admission_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfer_certificate`
--
ALTER TABLE `transfer_certificate`
  MODIFY `transfer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_admission_fees`
--
ALTER TABLE `transport_admission_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_admission_fees_denomination`
--
ALTER TABLE `transport_admission_fees_denomination`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_admission_fees_details`
--
ALTER TABLE `transport_admission_fees_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_fees_master`
--
ALTER TABLE `transport_fees_master`
  MODIFY `transport_fees_master_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_fees_ref`
--
ALTER TABLE `transport_fees_ref`
  MODIFY `transport_fees_reff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trust_creation`
--
ALTER TABLE `trust_creation`
  MODIFY `trust_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
