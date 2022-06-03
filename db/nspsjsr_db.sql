-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2022 at 06:55 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nspsjsr_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(100) NOT NULL,
  `admin_name` varchar(200) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_email` varchar(255) DEFAULT NULL,
  `admin_mobile` varchar(255) DEFAULT NULL,
  `admin_permission` varchar(255) NOT NULL,
  `admin_type` varchar(255) NOT NULL,
  `admin_branch` varchar(100) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_name`, `admin_username`, `admin_password`, `admin_email`, `admin_mobile`, `admin_permission`, `admin_type`, `admin_branch`, `employee_id`, `status`) VALUES
(1, 'qwerty', 'admin22', 'f6a1921633481c17562904903c058f14', 'dg@fgh.vb', '1234567890', '{\"3\":\"\",\"4\":\"\",\"5\":\"\",\"6\":\"\",\"7\":\"\",\"8\":\"\",\"9\":\"\",\"11\":\"11_1||11_2||11_8\",\"12\":\"\",\"13\":\"\",\"14\":\"\"}', 'subadmin', '', 0, '46cf0e59759c9b7f1112ca4b174343ef'),
(2, 'NSU', 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '9334833164', 'all', 'superadmin', '', 0, '46cf0e59759c9b7f1112ca4b174343ef'),
(3, 'Ankush Kumar', 'Faizahmad', 'e10adc3949ba59abbe56e057f20f883e', 'k.ankush14345@gmail.com', '9334168140', '{\"3\":\"\",\"4\":\"\",\"5\":\"\",\"6\":\"\",\"7\":\"\",\"8\":\"\",\"9\":\"\",\"11\":\"11_1\",\"12\":\"\",\"13\":\"\",\"14\":\"\"}', 'subadmin', '', 0, '46cf0e59759c9b7f1112ca4b174343ef'),
(4, 'dfghj', 'addd', '6cd5f3e6d5f285f82ec3c351faa42294', 'aaa@aa.com', '1234567890', '{\"3\":\"\",\"4\":\"\",\"5\":\"\",\"6\":\"\",\"7\":\"\",\"8\":\"\",\"9\":\"\",\"11\":\"11_1||11_8||11_4||11_6\",\"12\":\"\",\"13\":\"\",\"14\":\"\"}', 'subadmin', '', 0, '30639096bfe4ec4b9f17696ef1d02b9f'),
(5, 'mamta', 'mamta', '565fdb43462efef831c018f2e91cecbb', 'mamta@gmail.com', '1234567890', '{\"3\":\"\",\"4\":\"\",\"5\":\"\",\"6\":\"\",\"7\":\"\",\"8\":\"\",\"9\":\"\",\"11\":\"11_1||11_8||11_3||11_4||11_5||11_6\",\"12\":\"\",\"13\":\"\",\"14\":\"\"}', 'subadmin', '', 0, '46cf0e59759c9b7f1112ca4b174343ef'),
(6, 'admin_new', 'admin_new', '8cc0824481c32a8ebe30b7edc2e12a19', 'admin_new@gmail.com', '934567890', '{\"3\":\"\",\"4\":\"\",\"5\":\"\",\"6\":\"\",\"7\":\"\",\"8\":\"8_1||8_5||8_6||8_2||8_3||8_8||8_4\",\"9\":\"\",\"11\":\"11_1||11_2||11_8||11_4||11_5||11_6\",\"12\":\"\",\"13\":\"\",\"14\":\"\"}', 'subadmin', 'subadmin', 0, '46cf0e59759c9b7f1112ca4b174343ef'),
(7, 'test123', 'test21', 'b48cca5aebb82a328227b78d899506f5', 'test@gmail.com', '9876543210', '{\"3\":\"\",\"4\":\"\",\"5\":\"\",\"6\":\"6_4\",\"7\":\"\",\"8\":\"\",\"9\":\"\",\"11\":\"11_1||11_2||11_8||11_4||11_5||11_6\",\"12\":\"12_1\",\"13\":\"\",\"14\":\"\"}', 'subadmin', 'subadmin', 0, '46cf0e59759c9b7f1112ca4b174343ef'),
(8, 'Manoj', 'manoj', 'fe01ce2a7fbac8fafaed7c982a04e229', 'demo@gmail.com', '9876543201', '{\"3\":\"\",\"4\":\"\",\"5\":\"\",\"6\":\"6_4\",\"7\":\"\",\"8\":\"\",\"9\":\"\",\"11\":\"11_1||11_2||11_8||11_4||11_5||11_6\",\"12\":\"12_1||12_2\",\"13\":\"\",\"14\":\"\"}', 'subadmin', 'sample', 0, '46cf0e59759c9b7f1112ca4b174343ef'),
(9, 'manoj', 'manoj123', '977c0156d7403e2bebba75cdf5652678', '', '', '{\"3\":\"\",\"4\":\"\",\"5\":\"\",\"6\":\"\",\"7\":\"\",\"8\":\"\",\"9\":\"\",\"11\":\"11_1||11_2||11_8||11_3||11_4||11_5||11_6||11_7\",\"12\":\"\",\"13\":\"\",\"14\":\"\"}', 'subadmin', 'sample', 1, '46cf0e59759c9b7f1112ca4b174343ef'),
(11, 'ramesh', 'ramesh123', 'b1471adc34c852d9ca3f03f5f47ff496', NULL, NULL, '{\"3\":\"\",\"4\":\"\",\"5\":\"\",\"6\":\"\",\"7\":\"\",\"8\":\"\",\"9\":\"\",\"11\":\"11_1||11_2||11_8||11_3||11_4||11_5||11_6||11_7\",\"12\":\"\",\"13\":\"\",\"14\":\"\"}', 'subadmin', '8', 2, '46cf0e59759c9b7f1112ca4b174343ef');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barcode`
--

CREATE TABLE `tbl_barcode` (
  `barcode_id` int(11) NOT NULL,
  `student_id` varchar(200) NOT NULL,
  `total_marks` varchar(200) NOT NULL,
  `barcode_image` varchar(200) NOT NULL,
  `result` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_barcode`
--

INSERT INTO `tbl_barcode` (`barcode_id`, `student_id`, `total_marks`, `barcode_image`, `result`) VALUES
(1, 'NSPS0050', '', '', 'PROMOTE'),
(2, 'NSPS001', '111', 'images/613077d51f5d7613077d51f5db.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch`
--

CREATE TABLE `tbl_branch` (
  `id` int(11) NOT NULL,
  `branch_name` varchar(200) NOT NULL,
  `branch_address` varchar(200) NOT NULL,
  `branch_phone` varchar(200) NOT NULL,
  `doc` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_branch`
--

INSERT INTO `tbl_branch` (`id`, `branch_name`, `branch_address`, `branch_phone`, `doc`) VALUES
(1, 'sample', 'sakchi', '9876543210', '2021-12-15 07:33:46'),
(2, 'test', 'jamshedpur', '1234567890', '2021-12-17 09:11:16'),
(4, 'new', 'jamshedpur', '9876543210', '2022-01-12 07:34:56'),
(7, 'test123', 'jsr', '234567890', '2022-01-17 10:04:18'),
(8, 'Pokhari', 'Suraj Path, Baridih Basti, Dist : EAST SINGHBHUM,<br> JAMSHEDPUR - 831017 Jharkhand Ph. +0657 221 0167 <br>Website : https://nspsjsr.in/', '9876543210', '2022-02-12 08:47:01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class`
--

CREATE TABLE `tbl_class` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_time` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_class`
--

INSERT INTO `tbl_class` (`course_id`, `course_name`, `course_time`, `status`) VALUES
(1, 'IV', '13 Aug, 2021. 02:48 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(2, 'V', '13 Aug, 2021. 02:41 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(3, 'VI', '13 Aug, 2021. 02:41 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(4, 'VII', '13 Aug, 2021. 02:42 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(5, 'VIII', '17 Jan, 2022. 03:41 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(6, 'IX', '26 Aug, 2021. 12:51 PM', '46cf0e59759c9b7f1112ca4b174343ef');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

CREATE TABLE `tbl_employee` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `address` varchar(3000) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(225) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `password` varchar(225) NOT NULL,
  `doc` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_employee`
--

INSERT INTO `tbl_employee` (`id`, `name`, `address`, `phone`, `email`, `branch_id`, `user_id`, `password`, `doc`) VALUES
(1, 'Manoj', 'jamshedpur', '9876543210', 'manoj.22@gmail.com', 8, '8', '5e81f9859d223ea420aca993c647b839', '2022-01-19 13:28:59'),
(2, 'sdf', 'dsf', '1234567890', 'edsrfghj@fd.bv', 8, 'ramesh123', 'b1471adc34c852d9ca3f03f5f47ff496', '2022-01-21 10:41:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exam`
--

CREATE TABLE `tbl_exam` (
  `exam_id` int(11) NOT NULL,
  `exam_name` varchar(100) NOT NULL,
  `create_time` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_exam`
--

INSERT INTO `tbl_exam` (`exam_id`, `exam_name`, `create_time`, `status`) VALUES
(1, 'TEST', '26 Aug, 2021. 03:01 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(2, 'HALF YEARLY EXAM', '26 Aug, 2021. 01:58 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(3, 'YEARLY EXAM', '26 Aug, 2021. 02:42 PM', '30639096bfe4ec4b9f17696ef1d02b9f'),
(4, 'YEARLY EXAM', '26 Aug, 2021. 02:44 PM', '46cf0e59759c9b7f1112ca4b174343ef');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fee`
--

CREATE TABLE `tbl_fee` (
  `id` int(11) NOT NULL,
  `class` varchar(100) NOT NULL,
  `section` varchar(100) NOT NULL,
  `particular` varchar(225) NOT NULL,
  `fee` varchar(225) NOT NULL,
  `last_date` varchar(225) NOT NULL,
  `fine_amount` varchar(225) NOT NULL,
  `tennure` varchar(225) NOT NULL,
  `branch` varchar(225) NOT NULL,
  `fee_astatus` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_fee`
--

INSERT INTO `tbl_fee` (`id`, `class`, `section`, `particular`, `fee`, `last_date`, `fine_amount`, `tennure`, `branch`, `fee_astatus`) VALUES
(1, '1', '1', 'Admission', '20000', '2022-03-31', '2000', 'monthly', '1', 'Active'),
(2, '1', '2', 'Admission', '20000', '2022-03-31', '2000', 'monthly', '1', 'Active'),
(3, '1', '1', 'Admission', '20000', '2022-03-31', '2000', 'monthly', '2', 'Active'),
(4, '1', '2', 'Admission', '20000', '2022-03-31', '2000', 'monthly', '2', 'Active'),
(5, '1', '1', 'Admission', '20000', '2022-03-31', '2000', 'monthly', '4', 'Active'),
(6, '1', '2', 'Admission', '20000', '2022-03-31', '2000', 'monthly', '4', 'Active'),
(7, '1', '1', 'Admission', '20000', '2022-03-31', '2000', 'monthly', '7', 'Active'),
(8, '1', '2', 'Admission', '20000', '2022-03-31', '2000', 'monthly', '7', 'Active'),
(9, '1', '1', 'Admission', '20000', '2022-03-31', '2000', 'monthly', '8', 'Active'),
(10, '1', '2', 'Admission', '20000', '2022-03-31', '2000', 'monthly', '8', 'Active'),
(559, '1', '1', 'transport', '5000', '2022-03-31', '150', 'weekly', '8', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fee_paid`
--

CREATE TABLE `tbl_fee_paid` (
  `feepaid_id` int(255) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `section_id` varchar(100) NOT NULL,
  `particular_id` varchar(255) NOT NULL,
  `branch_id` varchar(100) NOT NULL,
  `paid_amount` varchar(255) NOT NULL,
  `rebate_amount` varchar(255) NOT NULL,
  `fine` varchar(255) NOT NULL,
  `extra_fine` varchar(255) NOT NULL,
  `balance` varchar(255) NOT NULL,
  `payment_mode` varchar(255) NOT NULL,
  `cash_deposit_to` varchar(255) NOT NULL,
  `cash_date` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `receipt_date` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `transaction_no` varchar(255) NOT NULL,
  `transaction_date` varchar(255) NOT NULL,
  `receipt_no` varchar(255) NOT NULL,
  `paid_on` varchar(255) NOT NULL,
  `university_details_id` varchar(255) NOT NULL,
  `fee_paid_time` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `print_generated_by` varchar(100) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_fee_paid`
--

INSERT INTO `tbl_fee_paid` (`feepaid_id`, `student_id`, `course_id`, `section_id`, `particular_id`, `branch_id`, `paid_amount`, `rebate_amount`, `fine`, `extra_fine`, `balance`, `payment_mode`, `cash_deposit_to`, `cash_date`, `notes`, `receipt_date`, `bank_name`, `transaction_no`, `transaction_date`, `receipt_no`, `paid_on`, `university_details_id`, `fee_paid_time`, `payment_status`, `print_generated_by`, `status`) VALUES
(1, '1', '1', '1', '1', '7', '6000', '', '', '', '4000', 'Cash', 'school office', '2022-01-05', '', '2022-01-05', 'ICICI BANK', '100000', '2022-01-05', 'NSPS_1111', '2022-01-05', '1', '05 Jan, 2022. 12:02 PM', 'cleared', 'mamta', '46cf0e59759c9b7f1112ca4b174343ef'),
(2, '1', '1', '', '2', '', '3000', '', '', '', '2000', 'cheque', 'school office', '2022-02-07', '', '2022-02-07', 'Punjab National Bank', '000007', '2022-02-07', 'NSPS_2222', '2022-02-06', '1', '06 Feb, 2022. 12:12 PM', 'cleared', 'Ramesh', '30639096bfe4ec4b9f17696ef1d02b9f'),
(3, '1', '1', '1', '2', '7', '3000', '', '', '', '2000', 'cheque', 'school office', '2022-02-07', '', '2022-02-07', 'Punjab National Bank', '000006', '2022-02-07', 'NSPS_2222', '2022-02-06', '1', '06 Feb, 2022. 12:12 PM', 'pending', 'Ramesh', '46cf0e59759c9b7f1112ca4b174343ef');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_income`
--

CREATE TABLE `tbl_income` (
  `id` int(11) NOT NULL,
  `reg_no` varchar(200) NOT NULL,
  `course` varchar(200) NOT NULL,
  `academic_year` varchar(200) NOT NULL,
  `received_date` varchar(255) NOT NULL,
  `particulars` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `payment_mode` varchar(255) NOT NULL,
  `check_no` varchar(200) NOT NULL,
  `bank_name` varchar(200) NOT NULL,
  `income_from` varchar(200) NOT NULL,
  `post_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_marks`
--

CREATE TABLE `tbl_marks` (
  `marks_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `reg_no` varchar(100) NOT NULL,
  `subject_id` varchar(255) NOT NULL,
  `internal_marks` varchar(255) NOT NULL,
  `external_marks` varchar(200) NOT NULL,
  `add_time` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_marks`
--

INSERT INTO `tbl_marks` (`marks_id`, `class_id`, `section_id`, `reg_no`, `subject_id`, `internal_marks`, `external_marks`, `add_time`, `status`) VALUES
(1, 1, 2, 'NSPS001', '1', '19', '70', '26 Aug, 2021. 05:54 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(2, 1, 2, 'NSPS002', '1', '15', '80', '26 Aug, 2021. 05:54 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(3, 1, 2, 'NSPS003', '1', '17', '76', '26 Aug, 2021. 05:54 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(4, 1, 2, 'NSPS004', '1', '20', '56', '26 Aug, 2021. 05:54 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(5, 1, 2, 'NSPS005', '1', '14', '67', '26 Aug, 2021. 05:54 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(6, 1, 2, 'NSPS006', '1', '12', '56', '26 Aug, 2021. 05:54 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(7, 1, 2, 'NSPS007', '1', '10', '70', '26 Aug, 2021. 05:54 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(8, 1, 2, 'NSPS008', '1', '18', '78', '26 Aug, 2021. 05:54 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(9, 1, 2, 'NSPS009', '1', '16', '56', '26 Aug, 2021. 05:54 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(10, 1, 2, 'NSPS010', '1', '16', '12', '26 Aug, 2021. 05:54 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(11, 1, 2, 'NSPS011', '1', '16', '78', '26 Aug, 2021. 05:54 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(12, 1, 2, 'NSPS012', '1', '18', '78', '26 Aug, 2021. 05:54 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(27, 1, 2, 'NSPS001', '2', '2', '20', '27 Aug, 2021. 12:37 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(28, 1, 2, 'NSPS002', '2', '19', '69', '27 Aug, 2021. 12:37 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(29, 1, 2, 'NSPS003', '2', '20', '79', '27 Aug, 2021. 12:37 PM', '46cf0e59759c9b7f1112ca4b174343ef');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section`
--

CREATE TABLE `tbl_section` (
  `section_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `section_time` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_section`
--

INSERT INTO `tbl_section` (`section_id`, `course_id`, `section_name`, `section_time`, `status`) VALUES
(1, 1, '4A', '14 Aug, 2021. 02:32 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(2, 1, '4B', '14 Aug, 2021. 02:32 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(3, 2, '5A', '14 Aug, 2021. 02:36 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(4, 2, '5B', '14 Aug, 2021. 02:36 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(5, 2, '5C', '14 Aug, 2021. 02:36 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(6, 5, '8A', '14 Aug, 2021. 03:24 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(7, 5, '8B', '14 Aug, 2021. 03:24 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(8, 5, '8C', '14 Aug, 2021. 03:24 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(9, 6, '9A', '29 Jan, 2022. 12:38 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(10, 6, '9B', '29 Jan, 2022. 12:38 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(11, 6, '9C', '29 Jan, 2022. 12:38 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(12, 6, '9D', '29 Jan, 2022. 12:38 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(13, 4, '7D', '04 Feb, 2022. 05:01 PM', '46cf0e59759c9b7f1112ca4b174343ef');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `student_id` int(11) NOT NULL,
  `university_details_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `reg_no` varchar(200) DEFAULT NULL,
  `roll_no` varchar(100) DEFAULT NULL,
  `course_id` varchar(200) DEFAULT NULL,
  `section_id` varchar(200) DEFAULT NULL,
  `student_name` varchar(200) DEFAULT NULL,
  `dob` varchar(100) DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `father_name` varchar(200) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `parent_contactno` varchar(100) DEFAULT NULL,
  `create_time` varchar(200) DEFAULT NULL,
  `status` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`student_id`, `university_details_id`, `branch_id`, `reg_no`, `roll_no`, `course_id`, `section_id`, `student_name`, `dob`, `gender`, `father_name`, `mother_name`, `parent_contactno`, `create_time`, `status`) VALUES
(1, 1, 8, 'NSPS001', '5001', '1', '2', 'Rohit Kumar', '', 'Male', 'Ramesh Singh', 'pushpa Devi', '9031329089', '23 Aug, 2021. 11:20 AM', '46cf0e59759c9b7f1112ca4b174343ef'),
(2, 1, 0, 'NSPS002', '5002', '1', '2', 'Rajesh Kumar', '', 'Male', 'Ramesh Singh', 'pushpa Devi', '9031329089', '23 Aug, 2021. 06:15 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(3, 1, 0, 'NSPS003', '5003', '1', '2', 'Manmeet Kaur', '06-02-1999', 'Male', 'Ramesh Singh', 'pushpa Devi', '9031329089', '18 Aug, 2021. 06:38 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(4, 1, 0, 'NSPS004', '5004', '1', '2', 'Rohit Kumar', '07-02-1999', 'Male', 'Ramesh Singh', 'pushpa Devi', '9031329089', '18 Aug, 2021. 06:38 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(5, 1, 0, 'NSPS005', '5005', '1', '2', 'Rohit Kumar', '08-02-1999', 'Male', 'Ramesh Singh', 'pushpa Devi', '9031329089', '18 Aug, 2021. 06:38 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(6, 1, 0, 'NSPS006', '5006', '1', '2', 'Rohit Kumar', '09-02-1999', 'Male', 'Ramesh Singh', 'pushpa Devi', '9031329089', '18 Aug, 2021. 06:38 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(7, 1, 0, 'NSPS007', '5007', '1', '2', 'Rohit Kumar', '10-02-1999', 'Male', 'Ramesh Singh', 'pushpa Devi', '9031329089', '18 Aug, 2021. 06:38 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(8, 1, 0, 'NSPS008', '5008', '1', '2', 'Rohit Kumar', '11-02-1999', 'Male', 'Ramesh Singh', 'pushpa Devi', '9031329089', '18 Aug, 2021. 06:38 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(9, 1, 0, 'NSPS009', '5009', '1', '2', 'Rohit Kumar', '12-02-1999', 'Male', 'Ramesh Singh', 'pushpa Devi', '9031329089', '18 Aug, 2021. 06:38 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(11, 1, 0, 'NSPS010', '5010', '1', '2', 'Rohit Kumar', '14-02-1999', 'Male', 'Ramesh Singh', 'pushpa Devi', '9031329089', '18 Aug, 2021. 06:38 PM', '30639096bfe4ec4b9f17696ef1d02b9f'),
(12, 1, 0, 'NSPS011', '5011', '1', '2', 'Rohit Kumar', '15-02-1999', 'Male', 'Ramesh Singh', 'pushpa Devi', '9031329089', '18 Aug, 2021. 06:38 PM', '30639096bfe4ec4b9f17696ef1d02b9f'),
(13, 1, 0, 'NSPS012', '5012', '1', '2', 'Rohit Kumar', '16-02-1999', 'Male', 'Ramesh Singh', 'pushpa Devi', '9031329089', '18 Aug, 2021. 06:38 PM', '30639096bfe4ec4b9f17696ef1d02b9f'),
(23, 1, 0, 'NSPS0050', '50', '1', '2', 'Priya', '08-07-1990', 'Female', 'Shankar', 'Seema', '9031289070', '27 Aug, 2021. 05:42 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(24, 1, 0, 'NSPS0051', '51', '1', '2', 'Sneha', '09-07-1990', 'Female', 'Shankar', 'Seema', '9031289070', '27 Aug, 2021. 05:42 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(25, 1, 0, 'NSPS0052', '52', '8', '2', 'Sony', '10-07-1990', 'Female', 'Shankar', 'Seema', '9031289070', '27 Aug, 2021. 05:42 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(26, 0, 0, 'Roll No', 'Class ', '', '', 'Date of Birth', 'Gender', 'Fathers Name', 'Mothers name', 'Parent Contact No', '', '18 Jan, 2022. 06:43 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(27, 1, 0, '233', '4', '', '', 'Dec-13', 'male', 'sahdev', 'savita', '9876543210', '', '18 Jan, 2022. 06:43 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(28, 0, 0, 'Reg No', 'Roll No', '', '', 'Student Name', 'Date of Birth', 'Gender', 'Fathers Name', 'Mothers name', 'Parent Contact No', '19 Jan, 2022. 11:14 AM', '46cf0e59759c9b7f1112ca4b174343ef'),
(29, 1, 0, '12334', '233', '', '', 'ramessh', '13-Dec', 'male', 'sahdev', 'savita', '9876543210', '19 Jan, 2022. 11:14 AM', '46cf0e59759c9b7f1112ca4b174343ef'),
(30, 0, 0, 'Reg No', 'Roll No', '', '', 'Student Name', 'Date of Birth', 'Gender', 'Fathers Name', 'Mothers name', 'Parent Contact No', '19 Jan, 2022. 11:16 AM', '46cf0e59759c9b7f1112ca4b174343ef'),
(31, 1, 0, '12334', '233', '', '', 'ramessh', '13-Dec', 'male', 'sahdev', 'savita', '9876543210', '19 Jan, 2022. 11:16 AM', '46cf0e59759c9b7f1112ca4b174343ef'),
(32, 1, 0, '12334', '233', '', '', 'ramessh', '13-Dec', 'male', 'sahdev', 'savita', '9876543210', '19 Jan, 2022. 11:33 AM', '46cf0e59759c9b7f1112ca4b174343ef'),
(33, 1, 8, '12334', '233', '', '', 'ramessh', '13-Dec', 'male', 'sahdev', 'savita', '9876543210', '19 Jan, 2022. 12:55 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(34, 1, 2, '12334', '233', '', '', 'ramessh', '13-Dec', 'male', 'sahdev', 'savita', '9876543210', '19 Jan, 2022. 12:56 PM', '46cf0e59759c9b7f1112ca4b174343ef');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subjects`
--

CREATE TABLE `tbl_subjects` (
  `subject_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `full_marks` varchar(255) NOT NULL,
  `pass_marks` varchar(255) NOT NULL,
  `add_time` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_subjects`
--

INSERT INTO `tbl_subjects` (`subject_id`, `class_id`, `section_id`, `subject_name`, `full_marks`, `pass_marks`, `add_time`, `status`) VALUES
(1, 1, 2, 'ENGLISH', '100', '30', '23 Aug, 2021. 09:24 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(2, 1, 2, 'HINDI', '100', '30', '23 Aug, 2021. 09:24 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(3, 1, 2, 'MATHEMATICS', '100', '30', '23 Aug, 2021. 09:24 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(4, 1, 2, 'SCIENCE', '100', '30', '23 Aug, 2021. 09:24 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(5, 1, 2, 'SOCIAL SCIENCE', '100', '30', '23 Aug, 2021. 09:24 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(6, 1, 2, 'MORAL SCIENCE', '100', '30', '23 Aug, 2021. 09:24 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(7, 1, 2, 'GENERAL KNOWLEDGE', '100', '30', '23 Aug, 2021. 09:24 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(8, 1, 2, 'SANSKRIT', '100', '30', '23 Aug, 2021. 09:24 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(9, 1, 2, 'COMPUTER', '100', '30', '23 Aug, 2021. 09:24 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(10, 1, 2, 'DRAWING', '100', '30', '23 Aug, 2021. 09:57 PM', '30639096bfe4ec4b9f17696ef1d02b9f'),
(17, 0, 0, 'subject', 'full marks', 'pass marks', '12 Jan, 2022. 06:56 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(18, 0, 1, 'Hindi', '100', '33', '12 Jan, 2022. 06:56 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(19, 0, 4, 'English', '90', '23', '12 Jan, 2022. 06:56 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(20, 0, 8, 'Computer', '80', '13', '12 Jan, 2022. 06:56 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(21, 0, 0, 'subject', 'full marks', 'pass marks', '12 Jan, 2022. 10:02 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(22, 0, 1, 'Hindi', '100', '33', '12 Jan, 2022. 10:02 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(23, 0, 4, 'English', '90', '23', '12 Jan, 2022. 10:02 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(24, 0, 8, 'Computer', '80', '13', '12 Jan, 2022. 10:02 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(25, 6, 9, 'Hindi', '100', '33', '29 Jan, 2022. 12:43 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(26, 6, 9, 'English', '100', '33', '29 Jan, 2022. 12:43 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(27, 6, 9, 'Computer', '100', '33', '29 Jan, 2022. 12:43 PM', '46cf0e59759c9b7f1112ca4b174343ef'),
(28, 6, 11, 'test', '100', '20', '10 Feb, 2022. 11:37 AM', '46cf0e59759c9b7f1112ca4b174343ef');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_university_details`
--

CREATE TABLE `tbl_university_details` (
  `university_details_id` int(11) NOT NULL,
  `university_details_financial_start_date` date NOT NULL,
  `university_details_financial_end_date` date NOT NULL,
  `university_details_academic_start_date` date NOT NULL,
  `university_details_academic_end_date` date NOT NULL,
  `university_details_university_name` varchar(255) NOT NULL,
  `university_details_affiliation_details` varchar(255) NOT NULL,
  `university_details_address` varchar(255) NOT NULL,
  `university_details_email` varchar(255) NOT NULL,
  `university_details_contact` varchar(255) NOT NULL,
  `university_details_logo_image` varchar(255) NOT NULL,
  `university_details_website_url` varchar(255) NOT NULL,
  `academic_session` varchar(200) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_university_details`
--

INSERT INTO `tbl_university_details` (`university_details_id`, `university_details_financial_start_date`, `university_details_financial_end_date`, `university_details_academic_start_date`, `university_details_academic_end_date`, `university_details_university_name`, `university_details_affiliation_details`, `university_details_address`, `university_details_email`, `university_details_contact`, `university_details_logo_image`, `university_details_website_url`, `academic_session`, `status`) VALUES
(1, '2021-08-02', '2022-08-11', '2021-08-02', '2022-08-11', 'NETAJI SUBHAS PUBLIC SCHOOL', 'TEST', 's/o : Arvind kumar,', 'k.ankush14345@gmail.com', '9031329089', '575455_logo.png', 'https://nspsjsr.in/', '', '46cf0e59759c9b7f1112ca4b174343ef');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_barcode`
--
ALTER TABLE `tbl_barcode`
  ADD PRIMARY KEY (`barcode_id`);

--
-- Indexes for table `tbl_branch`
--
ALTER TABLE `tbl_branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_class`
--
ALTER TABLE `tbl_class`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_exam`
--
ALTER TABLE `tbl_exam`
  ADD PRIMARY KEY (`exam_id`);

--
-- Indexes for table `tbl_fee`
--
ALTER TABLE `tbl_fee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_fee_paid`
--
ALTER TABLE `tbl_fee_paid`
  ADD PRIMARY KEY (`feepaid_id`);

--
-- Indexes for table `tbl_income`
--
ALTER TABLE `tbl_income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_marks`
--
ALTER TABLE `tbl_marks`
  ADD PRIMARY KEY (`marks_id`);

--
-- Indexes for table `tbl_section`
--
ALTER TABLE `tbl_section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `tbl_university_details`
--
ALTER TABLE `tbl_university_details`
  ADD PRIMARY KEY (`university_details_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_barcode`
--
ALTER TABLE `tbl_barcode`
  MODIFY `barcode_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_branch`
--
ALTER TABLE `tbl_branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_class`
--
ALTER TABLE `tbl_class`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_exam`
--
ALTER TABLE `tbl_exam`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_fee`
--
ALTER TABLE `tbl_fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=560;

--
-- AUTO_INCREMENT for table `tbl_fee_paid`
--
ALTER TABLE `tbl_fee_paid`
  MODIFY `feepaid_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_income`
--
ALTER TABLE `tbl_income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_marks`
--
ALTER TABLE `tbl_marks`
  MODIFY `marks_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_section`
--
ALTER TABLE `tbl_section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_student`
--
ALTER TABLE `tbl_student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_university_details`
--
ALTER TABLE `tbl_university_details`
  MODIFY `university_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
