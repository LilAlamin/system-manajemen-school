-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2023 at 03:08 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_password` varchar(200) NOT NULL,
  `admin_phone` int(15) NOT NULL,
  `admin_address` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_email`, `admin_password`, `admin_phone`, `admin_address`, `created_at`) VALUES
(1, 'Admin', 'admin@email.com', 'admin', 12345, 'address admin', '2023-09-03 21:37:09');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `a_teacher_id` int(11) NOT NULL,
  `a_class_id` int(11) NOT NULL,
  `a_student_id` int(11) NOT NULL,
  `attendance_status` enum('Present','Absent','Leave') NOT NULL,
  `attendance_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `a_teacher_id`, `a_class_id`, `a_student_id`, `attendance_status`, `attendance_date`) VALUES
(46, 2, 10, 1, 'Present', '2023-09-29 09:00:00'),
(47, 2, 10, 2, 'Absent', '2023-10-10 00:00:00'),
(48, 2, 10, 7, 'Present', '2023-10-10 00:00:00'),
(49, 2, 9, 5, 'Absent', '2023-10-10 00:00:00'),
(50, 2, 9, 12, 'Present', '2023-10-10 00:00:00'),
(51, 2, 10, 1, 'Present', '2023-09-30 00:00:00'),
(52, 2, 10, 2, 'Present', '2023-10-10 00:00:00'),
(53, 2, 10, 7, 'Present', '2023-10-10 00:00:00'),
(54, 2, 2, 4, 'Present', '2023-10-10 00:00:00'),
(55, 2, 5, 14, 'Absent', '2023-10-10 00:00:00'),
(56, 2, 5, 15, 'Present', '2023-10-10 00:00:00'),
(57, 2, 5, 16, 'Present', '2023-10-10 00:00:00'),
(61, 7, 10, 1, 'Present', '2023-10-04 00:00:00'),
(62, 3, 10, 1, 'Present', '2023-10-06 00:00:00'),
(63, 2, 10, 1, 'Present', '2023-10-07 00:00:00'),
(64, 2, 10, 1, 'Present', '2023-10-08 00:00:00'),
(65, 2, 10, 1, 'Present', '2023-10-10 00:00:00'),
(66, 2, 10, 1, 'Present', '2023-11-16 00:00:00'),
(67, 2, 10, 2, 'Absent', '2023-11-16 00:00:00'),
(68, 2, 10, 7, 'Leave', '2023-11-16 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `subject_name` varchar(300) NOT NULL,
  `section_name` varchar(50) NOT NULL,
  `c_teacher_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_name`, `subject_name`, `section_name`, `c_teacher_id`, `created_at`) VALUES
(1, '1', '1,5,6', '41,42,50', 2, '2023-09-17 23:16:41'),
(2, '2', '1,5,6', '41,42', 2, '2023-09-17 23:12:23'),
(3, '3', '1,5,6', '', 6, '2023-09-17 23:17:04'),
(5, '5', '1,5,6,14', '41', 7, '2023-09-17 23:19:25'),
(6, '6', '1,5,6,7,8,14', '', 2, '2023-09-17 23:19:45'),
(7, '7', '1,5,6,7,8,14', '', 6, '2023-09-17 23:19:53'),
(9, '9', '1,5,6,7,10,11,12,14', '', 4, '2023-09-17 23:21:03'),
(10, '10', '1,5,6,8,10,11,12,14', '', 3, '2023-09-17 23:20:43'),
(11, 'KG', '6,13,14', '', 4, '2023-09-17 23:16:23');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contact_id` int(11) NOT NULL,
  `contact_name` varchar(50) NOT NULL,
  `contact_email` varchar(50) NOT NULL,
  `contact_subject` varchar(100) NOT NULL,
  `contact_message` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `exam_id` int(11) NOT NULL,
  `exam_name` varchar(50) NOT NULL,
  `exam_type` enum('Mid','Final','Assignment','Test') NOT NULL,
  `total_marks` int(11) NOT NULL,
  `obtained_marks` int(11) NOT NULL,
  `e_class_id` int(11) NOT NULL,
  `e_student_id` int(11) NOT NULL,
  `e_teacher_id` int(11) NOT NULL,
  `e_subject_id` int(11) NOT NULL,
  `exam_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`exam_id`, `exam_name`, `exam_type`, `total_marks`, `obtained_marks`, `e_class_id`, `e_student_id`, `e_teacher_id`, `e_subject_id`, `exam_date`) VALUES
(13, 'Test', 'Test', 20, 16, 11, 1, 2, 10, '2023-09-04'),
(14, 'Test 1', 'Test', 10, 8, 11, 1, 2, 5, '2023-09-02'),
(15, 'Mid Term', 'Test', 15, 15, 11, 1, 2, 5, '2023-09-04'),
(17, 'Final', 'Final', 50, 39, 11, 1, 2, 5, '2023-09-04'),
(18, 'Mid Term', 'Mid', 50, 23, 11, 1, 2, 1, '2023-09-04'),
(19, 'Test 1', 'Test', 40, 33, 11, 1, 2, 6, '2023-09-04'),
(20, 'Mid Term', 'Mid', 50, 40, 11, 1, 2, 7, '2023-09-04'),
(21, 'Mid Term', 'Mid', 50, 43, 11, 1, 2, 1, '2023-09-04'),
(22, 'Mid Term', 'Mid', 50, 33, 11, 1, 2, 8, '2023-09-04'),
(24, 'Mid Term', 'Mid', 50, 30, 11, 1, 2, 5, '2023-09-04'),
(25, 'Test 1', 'Test', 15, 10, 11, 1, 2, 5, '2023-09-04'),
(26, 'Mid Term', 'Final', 30, 30, 11, 1, 2, 1, '2023-09-04'),
(29, 'Mid Term', 'Mid', 20, 10, 11, 1, 2, 6, '2023-09-04'),
(31, 'Final Term', 'Final', 50, 40, 10, 1, 2, 6, '2023-10-11'),
(32, 'Assignment 1', 'Assignment', 15, 12, 10, 1, 2, 6, '2023-10-11'),
(33, 'Test', 'Test', 15, 12, 10, 1, 2, 14, '2023-11-17'),
(34, 'Mid', 'Mid', 20, 18, 10, 1, 2, 14, '2023-11-17'),
(35, 'Assignment', 'Assignment', 15, 15, 10, 1, 2, 14, '2023-11-17'),
(36, 'Final', 'Final', 50, 49, 10, 1, 2, 14, '2023-11-17'),
(37, 'Mid', 'Mid', 20, 16, 10, 1, 2, 10, '2023-11-17'),
(38, 'Final', 'Final', 50, 38, 10, 1, 2, 10, '2023-11-17'),
(39, 'Test', 'Test', 15, 12, 10, 1, 2, 8, '2023-11-17'),
(40, 'Assignment', 'Assignment', 15, 15, 10, 1, 2, 8, '2023-11-17'),
(41, 'Assignment', 'Assignment', 15, 13, 10, 1, 2, 1, '2023-11-17'),
(42, 'Final Term', 'Final', 50, 40, 10, 2, 2, 8, '2023-11-17');

-- --------------------------------------------------------

--
-- Table structure for table `fee`
--

CREATE TABLE `fee` (
  `tution_fee` int(11) NOT NULL,
  `library_fee` int(11) NOT NULL,
  `sports_fee` int(11) NOT NULL,
  `fee_id` int(11) NOT NULL,
  `fee_amount` int(12) NOT NULL,
  `fee_month` int(2) NOT NULL,
  `fee_due_date` date NOT NULL,
  `fee_end_date` date NOT NULL,
  `f_student_id` int(11) NOT NULL,
  `f_class_id` int(11) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `payment_method` varchar(50) NOT NULL DEFAULT '0',
  `fee_submit_date` datetime NOT NULL DEFAULT current_timestamp(),
  `fee_status` enum('Paid','Unpaid','Processing') NOT NULL DEFAULT 'Unpaid',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fee`
--

INSERT INTO `fee` (`tution_fee`, `library_fee`, `sports_fee`, `fee_id`, `fee_amount`, `fee_month`, `fee_due_date`, `fee_end_date`, `f_student_id`, `f_class_id`, `transaction_id`, `payment_method`, `fee_submit_date`, `fee_status`, `created_at`) VALUES
(3000, 1000, 1000, 12, 5000, 10, '2023-10-11', '2023-10-18', 4, 2, 'SPTAUHHV697AU4L3CDX6', '0', '2023-10-11 00:12:09', 'Unpaid', '2023-10-11 00:12:09'),
(2000, 500, 500, 13, 3000, 10, '2023-10-11', '2023-10-11', 1, 10, '9XV8JB4R344D0603GCWN', '1', '2023-11-16 11:51:26', 'Processing', '2023-10-11 00:13:21'),
(3000, 1000, 1000, 14, 5000, 9, '2023-10-11', '2023-09-27', 1, 10, '0GRIN4NLBZYQYL8AUWTC', '5', '2023-11-17 00:48:34', 'Processing', '2023-10-11 00:13:50'),
(4000, 500, 500, 15, 5000, 8, '2023-10-11', '2023-08-18', 1, 10, '6J1YOGFTSY3HA9ITK63J', '3', '2023-10-11 00:33:43', 'Paid', '2023-10-11 00:14:19'),
(5000, 1000, 500, 19, 6500, 5, '2023-05-09', '2023-05-12', 1, 10, 'FROYAHQ4ZREMZRH3HZ0W', '2', '2023-10-11 00:32:38', 'Paid', '2023-10-11 00:28:58');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `f_teacher_id` int(11) NOT NULL,
  `f_class_id` int(11) NOT NULL,
  `f_student_id` int(11) NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `status` enum('Positive','Negative') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `f_teacher_id`, `f_class_id`, `f_student_id`, `remarks`, `status`, `created_at`) VALUES
(1, 2, 10, 1, 'Always comes late in Class', 'Negative', '2023-09-12 21:35:49'),
(3, 2, 10, 2, ' Good Student', 'Positive', '2023-09-12 21:36:52'),
(4, 2, 10, 1, '  a good feedback for student is always refreshing and we always want that we should take a very good remarks from our teachers', 'Positive', '2023-09-12 21:51:53'),
(5, 2, 10, 1, '      always late and make noice in class', 'Negative', '2023-09-12 22:30:34'),
(6, 2, 10, 2, '  late nhi hota', 'Positive', '2023-09-12 22:47:51'),
(7, 2, 10, 1, 'GoodDiscipline in Class', 'Positive', '2023-11-17 00:47:20'),
(8, 2, 10, 1, 'Comes late in class', 'Positive', '2023-11-17 00:47:36');

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `notice_id` int(11) NOT NULL,
  `notice_title` varchar(50) NOT NULL,
  `notice_desc` varchar(300) NOT NULL,
  `n_class_id` int(11) DEFAULT NULL,
  `n_post_id` int(11) NOT NULL,
  `posted_by` varchar(50) NOT NULL,
  `notice_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notice`
--

INSERT INTO `notice` (`notice_id`, `notice_title`, `notice_desc`, `n_class_id`, `n_post_id`, `posted_by`, `notice_date`) VALUES
(22, 'New', 'class', 11, 1888, 'Admin', '2023-09-08 12:45:58'),
(23, 'without', 'wo', NULL, 1888, 'Admin', '2023-09-08 12:46:37'),
(24, 'without', 'wo', NULL, 1888, 'Admin', '2023-09-08 12:47:39'),
(29, 'New entry', 'all', NULL, 2555, 'Sir Hameed', '2023-09-08 12:54:55'),
(30, 'ok', 'ok', NULL, 2555, 'Sir Hameed', '2023-09-08 14:07:24'),
(31, 'New entry', 'ok', NULL, 2555, 'Sir Hameed', '2023-09-08 14:22:05'),
(32, 'New entry', 'ok', NULL, 2555, 'Sir Hameed', '2023-09-08 14:22:14'),
(36, 'New entry', 'dummy', NULL, 2555, 'Sir Hameed', '2023-09-08 14:39:40'),
(44, 'ok class', '  new', 10, 1888, 'Admin', '2023-09-08 14:48:57'),
(45, 'New entry', '  class', 10, 2555, 'Sir Hameed', '2023-09-08 14:49:40'),
(46, 'new', '      all i know', 9, 2555, 'Sir Hameed', '2023-09-08 14:49:52'),
(47, 'holidsay', ' htddsfg', 7, 1888, 'Admin', '2023-09-08 20:04:29'),
(48, 'new', ' rfv', 9, 2555, 'Sir Hameed', '2023-09-08 20:07:35'),
(49, 'Holiday', 'Tomorrow School is Off because of Independence  Day. Pakistan Zindabad!!!!', 10, 1888, 'Admin', '2023-09-09 10:16:31'),
(50, 'Holiday', 'Tomorrow is Holiday', NULL, 2555, 'Sir Atif Iqbal', '2023-11-17 00:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE `parent` (
  `parent_id` int(11) NOT NULL,
  `parent_name` varchar(50) NOT NULL,
  `parent_email` varchar(50) NOT NULL,
  `parent_password` varchar(100) NOT NULL,
  `kids` varchar(50) NOT NULL,
  `cnic` varchar(20) NOT NULL,
  `parent_pic` varchar(300) NOT NULL,
  `parent_verify` enum('Active','Disable') NOT NULL DEFAULT 'Active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parent`
--

INSERT INTO `parent` (`parent_id`, `parent_name`, `parent_email`, `parent_password`, `kids`, `cnic`, `parent_pic`, `parent_verify`, `created_at`) VALUES
(1, 'Rafaqat Ali Shahid', 'rafaqat@gmail.com', 'rafaqat', '1,2', '01234-1231231-1', '1694882950_rafaqat.jpg', 'Active', '2023-09-15 23:05:37'),
(2, 'Fayyaz Hussain', 'fayyaz@gmail.com', 'fayyaz', '6,13', '54321-7654321-8', '1694927114_fayyaz.jpg', 'Active', '2023-09-17 10:05:14');

-- --------------------------------------------------------

--
-- Table structure for table `period`
--

CREATE TABLE `period` (
  `period_id` int(11) NOT NULL,
  `period_name` varchar(50) NOT NULL,
  `period_start_time` time NOT NULL,
  `period_end_time` time NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `period`
--

INSERT INTO `period` (`period_id`, `period_name`, `period_start_time`, `period_end_time`, `created_at`) VALUES
(2, 'First Period', '08:00:00', '08:45:00', '2023-09-13 21:17:17'),
(3, 'Second Period', '08:45:00', '09:30:00', '2023-09-13 21:17:53'),
(4, 'Third Period', '09:30:00', '10:15:00', '2023-09-13 21:23:28'),
(5, 'Lunch Break', '10:15:00', '10:45:00', '2023-09-13 21:27:56'),
(6, 'Fourth Period', '10:45:00', '11:30:00', '2023-09-13 21:28:32'),
(7, 'FifthPeriod', '11:30:00', '12:15:00', '2023-09-13 21:29:00'),
(8, 'Sixth Period', '12:15:00', '13:00:00', '2023-09-13 21:29:33');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(50) NOT NULL,
  `room_capacity` int(5) NOT NULL,
  `r_class_id` int(11) NOT NULL,
  `r_section_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_name`, `room_capacity`, `r_class_id`, `r_section_id`, `created_at`) VALUES
(16, 'Room 1', 12, 11, 41, '2023-08-31 12:11:10');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `section_title` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `section_title`, `created_at`) VALUES
(0, NULL, '2023-08-30 17:48:28'),
(41, 'Section A', '2023-08-22 15:59:40'),
(42, 'Section B', '2023-08-22 15:59:49'),
(50, 'Section C', '2023-08-26 15:17:14'),
(53, 'Section D', '2023-11-17 00:43:59');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_rollno` varchar(20) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `student_email` varchar(30) NOT NULL,
  `student_password` varchar(200) NOT NULL,
  `student_class` int(11) NOT NULL,
  `student_section` int(11) NOT NULL,
  `student_dob` date NOT NULL,
  `student_pic` varchar(300) NOT NULL,
  `student_phone` varchar(30) NOT NULL,
  `student_address` varchar(200) NOT NULL,
  `student_age` int(2) NOT NULL,
  `student_gender` enum('Male','Female') NOT NULL,
  `student_verify` enum('Active','Disable') NOT NULL DEFAULT 'Active',
  `student_admission_date` datetime NOT NULL DEFAULT current_timestamp(),
  `father_cnic` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_rollno`, `student_name`, `student_email`, `student_password`, `student_class`, `student_section`, `student_dob`, `student_pic`, `student_phone`, `student_address`, `student_age`, `student_gender`, `student_verify`, `student_admission_date`, `father_cnic`) VALUES
(1, '0001-SMS-10', 'Danish Ali', 'danish@gmail.com', 'danish', 10, 0, '2000-10-20', '1694343750_danish.jpg', '0300-1234567', 'Lahore ', 23, 'Male', 'Active', '2023-08-31 11:53:49', '01234-1231231-1'),
(2, '0002-SMS-10', 'Haider Ali', 'haider@gmail.com', 'haider', 10, 0, '2023-08-03', '1694343717_haider.jpg', '12345', 'addr', 4, 'Male', 'Active', '2023-08-31 11:54:52', '01234-1231231-1'),
(4, '0004-SMHS-02', 'Ahmad Baba', 'ahmad@gmail.com', 'ahmad', 2, 42, '2023-09-08', '1694343600_ahmed.jpg', '2313', 'address', 15, 'Male', 'Active', '2023-09-10 16:00:00', '12121-1212121-1'),
(5, '0005-SMHS-09', 'Adil Iqbal', 'adil@gmail.com', 'adil', 9, 0, '2023-09-13', '1694343688_adil.jpg', '12241', 'adil addr', 19, 'Male', 'Active', '2023-09-10 16:01:28', '54321-7654321-8'),
(6, '0006-SMHS-07', 'Salman Iqbal', 'salman@gmail.com', 'salman', 7, 50, '2023-09-20', '1694343845_salman.jpg', '1313', 'mani address', 17, 'Male', 'Active', '2023-09-10 16:04:05', '54321-7654321-8'),
(7, '0007-SMHS-10', 'Aqib Ali', 'aqib@gmail.com', 'aqib', 10, 0, '2023-09-12', '1694343955_aqib.jpg', '123213', 'addr Aqib', 18, 'Male', 'Active', '2023-09-10 16:05:55', '54321-7654321-8'),
(12, '0008-SMHS-09', 'Saqib Iqbal', 'saqib@gmail.com', 'saqib', 9, 0, '2023-09-05', '1694972656_saqib.jpg', '1234', 'address', 4, 'Male', 'Active', '2023-09-17 22:44:16', '12121-1212121-1'),
(13, '0009-SMHS -07', 'Amir Majeed', 'amir@gmail.com', 'amir', 7, 0, '2023-09-17', '1694975559_amir.jpg', '12345', 'amir address', 19, 'Male', 'Active', '2023-09-17 23:32:39', '54321-7654321-8'),
(14, '0010-SMHS -05', 'Javaid Ali', 'javaid@gmail.com', 'javaid', 5, 41, '2023-09-17', '1694975772_javaid.jpg', '12345', 'jadi address', 20, 'Male', 'Active', '2023-09-17 23:36:12', '54321-7654321-8'),
(15, '0011-SMHS -05', 'Hafiz Hamza', 'hamza@gmail.com', 'hamza', 5, 0, '2023-09-17', '1694976281_hamza.jpg', '12345', 'hamza addr', 15, 'Male', 'Active', '2023-09-17 23:44:41', '12121-1212121-1'),
(16, '0012-SMHS -05', 'Asim Ali', 'asim@gmail.com', 'asim', 5, 0, '2023-09-17', '1694976368_asim.jpg', '0', 'asim address', 12, 'Male', 'Active', '2023-09-17 23:46:08', '12121-1212121-1');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `subject_code` varchar(20) NOT NULL,
  `subject_name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_code`, `subject_name`, `created_at`) VALUES
(1, 'ENG', 'English', '2023-08-30 22:56:09'),
(5, 'UD', 'Urdu', '2023-08-30 22:55:59'),
(6, 'MATHS', 'Mathematics', '2023-08-30 22:56:25'),
(7, 'PS', 'Pak Studies', '2023-08-30 22:56:57'),
(8, 'ISL', 'Islamiat', '2023-08-30 22:56:47'),
(9, 'SCI', 'Science', '2023-08-30 22:56:37'),
(10, 'PHY', 'Physics', '2023-08-30 22:54:05'),
(11, 'CHEM', 'Chemistry', '2023-08-30 22:54:17'),
(12, 'BIO', 'Biology', '2023-08-30 22:54:45'),
(13, 'DRW', 'Drawing', '2023-08-30 22:55:01'),
(14, 'COMP', 'Computer', '2023-08-30 22:55:38');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `teacher_email` varchar(100) NOT NULL,
  `teacher_password` varchar(200) NOT NULL,
  `teacher_dob` date NOT NULL,
  `teacher_pic` varchar(300) NOT NULL,
  `teacher_subject` varchar(50) NOT NULL,
  `teacher_phone` varchar(30) NOT NULL,
  `teacher_address` varchar(100) NOT NULL,
  `teacher_age` int(2) NOT NULL,
  `teacher_gender` enum('Male','Female') NOT NULL,
  `teacher_verify` enum('Active','Disable') NOT NULL DEFAULT 'Active',
  `teacher_joining_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `teacher_name`, `teacher_email`, `teacher_password`, `teacher_dob`, `teacher_pic`, `teacher_subject`, `teacher_phone`, `teacher_address`, `teacher_age`, `teacher_gender`, `teacher_verify`, `teacher_joining_date`) VALUES
(2, 'Atif Iqbal', 'atif@gmail.com', 'atif', '1995-07-18', '1697107461_atif.jpg', '14', '0300-1234567', 'Lahore', 28, 'Male', 'Active', '2023-08-29 16:30:55'),
(3, 'Sadaqat Ali', 'sadaqat@gmail.com', 'sadaqat', '2023-06-08', '1694973251_sadaqat.jpg', '14', '12345', 'adres', 35, 'Male', 'Active', '2023-09-17 22:53:51'),
(4, 'Shahbaz Ali Shad', 'shahbaz@gmail.com', 'shahbaz', '2023-07-05', '1694973661_shahbaz.jpg', '9', '12345', 'address', 36, 'Male', 'Active', '2023-09-17 23:01:01'),
(6, 'Tariq Ali', 'tariq@gmail.com', 'tariq', '2023-09-07', '1694973966_tariq.jpg', '10', '12345', 'addres', 35, 'Male', 'Active', '2023-09-17 23:06:06'),
(7, 'Zahid Ali', 'zahid@gmail.com', 'zahid', '2023-09-15', '1694974157_zahid.jpg', '8', '12345', 'address', 40, 'Male', 'Active', '2023-09-17 23:09:17');

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `timetable_id` int(11) NOT NULL,
  `t_teacher_id` int(5) NOT NULL,
  `t_class_id` int(5) NOT NULL,
  `t_section_id` int(5) DEFAULT NULL,
  `t_period_id` int(5) NOT NULL,
  `t_subject_id` int(5) NOT NULL,
  `t_room_id` int(5) NOT NULL,
  `timetable_day` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`timetable_id`, `t_teacher_id`, `t_class_id`, `t_section_id`, `t_period_id`, `t_subject_id`, `t_room_id`, `timetable_day`, `created_at`) VALUES
(18, 2, 11, 41, 8, 5, 16, 'Thursday', '2023-09-13 22:25:30'),
(19, 2, 11, 41, 4, 11, 16, 'Monday', '2023-09-13 22:25:11'),
(20, 2, 11, 41, 2, 11, 16, 'Friday', '2023-09-05 12:11:54'),
(22, 2, 1, 0, 3, 10, 16, 'Saturday', '2023-09-13 22:37:39'),
(23, 2, 1, 0, 4, 11, 16, 'Wednesday', '2023-09-17 15:55:55'),
(24, 6, 5, 41, 2, 11, 16, 'Tuesday', '2023-11-16 11:48:50'),
(25, 3, 3, 0, 2, 9, 16, 'Thursday', '2023-11-17 00:44:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `relation with class in attendance` (`a_class_id`),
  ADD KEY `relation with student in attendance` (`a_student_id`),
  ADD KEY `relation with teacher in attendance` (`a_teacher_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `relation with section` (`section_name`),
  ADD KEY `relation with teaacher in class` (`c_teacher_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`exam_id`),
  ADD KEY `relation with student in exam` (`e_student_id`),
  ADD KEY `relation with subject in exam` (`e_subject_id`),
  ADD KEY `relation with class in exam` (`e_class_id`);

--
-- Indexes for table `fee`
--
ALTER TABLE `fee`
  ADD PRIMARY KEY (`fee_id`),
  ADD KEY `relation with student in fee` (`f_student_id`),
  ADD KEY `relation with class in fee` (`f_class_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `relation with class in feedback` (`f_class_id`),
  ADD KEY `relation with student in feedback` (`f_student_id`),
  ADD KEY `relation with teacher in feedback` (`f_teacher_id`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`notice_id`),
  ADD KEY `relation with class in notice` (`n_class_id`);

--
-- Indexes for table `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`parent_id`);

--
-- Indexes for table `period`
--
ALTER TABLE `period`
  ADD PRIMARY KEY (`period_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `relation with class in room` (`r_class_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `relation with class in student` (`student_class`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`timetable_id`),
  ADD KEY `relation with section` (`t_section_id`),
  ADD KEY `relation with class` (`t_class_id`),
  ADD KEY `relation with teacher` (`t_teacher_id`),
  ADD KEY `relation with period` (`t_period_id`),
  ADD KEY `relation with room` (`t_room_id`),
  ADD KEY `relation with subject` (`t_subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `fee`
--
ALTER TABLE `fee`
  MODIFY `fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `parent`
--
ALTER TABLE `parent`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `period`
--
ALTER TABLE `period`
  MODIFY `period_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `timetable_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `relation with class in attendance` FOREIGN KEY (`a_class_id`) REFERENCES `class` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with student in attendance` FOREIGN KEY (`a_student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with teacher in attendance` FOREIGN KEY (`a_teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `relation with teaacher in class` FOREIGN KEY (`c_teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `relation with class in exam` FOREIGN KEY (`e_class_id`) REFERENCES `class` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with student in exam` FOREIGN KEY (`e_student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with subject in exam` FOREIGN KEY (`e_subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fee`
--
ALTER TABLE `fee`
  ADD CONSTRAINT `relation with class in fee` FOREIGN KEY (`f_class_id`) REFERENCES `class` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `relation with class in feedback` FOREIGN KEY (`f_class_id`) REFERENCES `class` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with student in feedback` FOREIGN KEY (`f_student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with teacher in feedback` FOREIGN KEY (`f_teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notice`
--
ALTER TABLE `notice`
  ADD CONSTRAINT `relation with class in notice` FOREIGN KEY (`n_class_id`) REFERENCES `class` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `relation with class in room` FOREIGN KEY (`r_class_id`) REFERENCES `class` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `relation with class in student` FOREIGN KEY (`student_class`) REFERENCES `class` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `timetable`
--
ALTER TABLE `timetable`
  ADD CONSTRAINT `relation with class` FOREIGN KEY (`t_class_id`) REFERENCES `class` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with period` FOREIGN KEY (`t_period_id`) REFERENCES `period` (`period_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with room` FOREIGN KEY (`t_room_id`) REFERENCES `room` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with section` FOREIGN KEY (`t_section_id`) REFERENCES `section` (`section_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with subject` FOREIGN KEY (`t_subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with teacher` FOREIGN KEY (`t_teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
