-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2023 at 03:03 PM
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
-- Database: `pixelsalonsoftware`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL DEFAULT 0,
  `appointment_date` varchar(20) NOT NULL COMMENT 'date of appointment',
  `appointment_time` varchar(20) NOT NULL COMMENT 'appointment time',
  `appointment_source` varchar(15) DEFAULT NULL,
  `service_for` varchar(15) DEFAULT NULL,
  `sub_total` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `discount_type` text DEFAULT NULL,
  `tax` varchar(15) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `pending_due` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `branch_id`, `client_id`, `membership_id`, `appointment_date`, `appointment_time`, `appointment_source`, `service_for`, `sub_total`, `discount`, `discount_type`, `tax`, `total`, `pending_due`, `notes`, `status`, `is_approved`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(70, 4, 56, 0, '20/05/2023', '06:16 PM', 'on call', '', 100, 0, 'percentage', '', 100, '100', '', 'Pending', 1, '2023-05-20 18:17:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appointment_advance_payment`
--

CREATE TABLE `appointment_advance_payment` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `advance` int(11) NOT NULL,
  `method` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `appointment_advance_payment`
--

INSERT INTO `appointment_advance_payment` (`id`, `appointment_id`, `transaction_id`, `advance`, `method`) VALUES
(31, 70, '', 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_assign_service_provider`
--

CREATE TABLE `appointment_assign_service_provider` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `appointment_service_id` int(11) NOT NULL,
  `service_provider_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `appointment_assign_service_provider`
--

INSERT INTO `appointment_assign_service_provider` (`id`, `appointment_id`, `appointment_service_id`, `service_provider_id`) VALUES
(98, 70, 99, 27);

-- --------------------------------------------------------

--
-- Table structure for table `appointment_checkin`
--

CREATE TABLE `appointment_checkin` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `checkin_time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_service`
--

CREATE TABLE `appointment_service` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `service_cat_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `service_discount` varchar(50) DEFAULT NULL,
  `service_discount_type` varchar(50) DEFAULT NULL,
  `start_time` varchar(20) NOT NULL,
  `end_time` varchar(20) NOT NULL,
  `start_timestamp` datetime DEFAULT NULL,
  `end_timestamp` datetime DEFAULT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `appointment_service`
--

INSERT INTO `appointment_service` (`id`, `appointment_id`, `service_cat_id`, `service_id`, `service_discount`, `service_discount_type`, `start_time`, `end_time`, `start_timestamp`, `end_timestamp`, `price`) VALUES
(99, 70, 44, 135, '0', 'percentage', '06:16 PM', '06:31 PM', '2023-05-20 18:16:00', '2023-05-20 18:31:00', 100);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `employee_type` varchar(50) NOT NULL,
  `check_in_time` varchar(20) NOT NULL,
  `check_out_time` varchar(20) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = present\r\n2 = absent',
  `date` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `branch_name` tinytext NOT NULL,
  `salon_name` tinytext NOT NULL,
  `address` tinytext NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `gst` varchar(50) DEFAULT NULL,
  `working_hours_start` varchar(30) NOT NULL,
  `working_hours_end` varchar(30) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `uid`, `branch_name`, `salon_name`, `address`, `phone`, `email`, `website`, `gst`, `working_hours_start`, `working_hours_end`, `logo`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(4, 3, 'Branch 1', 'Lakme', 'Alambagh Lko', '9999999999', 'itsabirerasul@gmail.com', 'abc.com', 'dfdfdfdfdfdfd', '08:00 AM', '11:55 PM', '24433039final-logo.png', '2023-01-02 00:45:06', NULL, '2023-04-15 18:32:39', NULL),
(5, 4, 'Branch 2', 'Ponds', 'Hazratganj, Lko', '9696969696', 'branch2@test.com', 'ponds.in', 'dfdfddf', '09:00 AM', '10:00 PM', '3851download.jpg', '2023-01-02 00:48:31', NULL, '2023-01-28 13:06:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `branch_api_setting`
--

CREATE TABLE `branch_api_setting` (
  `id` int(11) NOT NULL,
  `url` tinytext DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `sender_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `branch_api_setting`
--

INSERT INTO `branch_api_setting` (`id`, `url`, `username`, `password`, `sender_id`) VALUES
(1, 'http://bulksms.anksms.com/api/mt/SendSMS', 'zeeshan', '123456', 'PIXSAL');

-- --------------------------------------------------------

--
-- Table structure for table `branch_automatic_reminder`
--

CREATE TABLE `branch_automatic_reminder` (
  `id` int(11) NOT NULL,
  `birthday` tinyint(4) DEFAULT 0,
  `anniversary` tinyint(4) DEFAULT 0,
  `appointment` tinyint(4) DEFAULT 0,
  `package_expiry` tinyint(4) DEFAULT 0,
  `membership_expiry` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `branch_automatic_reminder`
--

INSERT INTO `branch_automatic_reminder` (`id`, `birthday`, `anniversary`, `appointment`, `package_expiry`, `membership_expiry`) VALUES
(1, 1, 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `branch_holiday`
--

CREATE TABLE `branch_holiday` (
  `id` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `title` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `branch_holiday`
--

INSERT INTO `branch_holiday` (`id`, `date`, `title`) VALUES
(1, '08/03/2023', 'Holi'),
(3, '26/01/2023', 'Republic Day'),
(5, '14/01/2023', 'Khichdi');

-- --------------------------------------------------------

--
-- Table structure for table `branch_redeem_points_setting`
--

CREATE TABLE `branch_redeem_points_setting` (
  `id` int(11) NOT NULL,
  `redeem_point` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `max_redeem_point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `branch_redeem_points_setting`
--

INSERT INTO `branch_redeem_points_setting` (`id`, `redeem_point`, `price`, `max_redeem_point`) VALUES
(1, 1, 1.00, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `branch_sms_history`
--

CREATE TABLE `branch_sms_history` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `schedule` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch_sms_message`
--

CREATE TABLE `branch_sms_message` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `sms_title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `branch_sms_message`
--

INSERT INTO `branch_sms_message` (`id`, `branch_id`, `template_id`, `date`, `sms_title`, `message`, `created_at`, `updated_at`) VALUES
(3, 4, 17, '2023-03-16', 'Wallet', 'Dear bulk test , Your wallet is credited with INR –  100. Available Wallet Balance INR  1000 From  salon. Thanks\r\n\r\nBOOKPX', '2023-03-14 15:59:14', '2023-03-16 17:02:13'),
(4, 4, 5, '2023-03-16', 'Billing', 'Thank you for your Services of {$xxxx} ON {$xxxx} Invoice link {$xxxx} For Feedback {$xxxx} From {$xxxx}. Thanks BOOKPX', '2023-03-14 15:59:23', '2023-03-16 17:04:34'),
(5, 4, 2, '2023-03-14', 'Appointment Message', 'Thank You  Sabire Rasul. Your Appointment is booked for 14-03-2023 06:30 PM. From Pixel Salon.BOOKPX', '2023-03-14 15:59:38', '2023-03-14 17:29:09'),
(6, 4, 5, '2023-03-16', 'billing new', 'Thank you for your Services of 100 ON 22-03-2023 Invoice link xyx For Feedback xyz From xyz. Thanks BOOKPX', '2023-03-16 18:43:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `branch_sms_template`
--

CREATE TABLE `branch_sms_template` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `template_title` text NOT NULL,
  `template` text NOT NULL,
  `priority` varchar(50) NOT NULL,
  `s_type` varchar(50) NOT NULL,
  `channel` varchar(50) NOT NULL,
  `dcs` int(11) NOT NULL,
  `flash_sms` int(11) NOT NULL,
  `route` int(11) NOT NULL,
  `peid` text NOT NULL,
  `dlt_template_id` text NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `branch_sms_template`
--

INSERT INTO `branch_sms_template` (`id`, `branch_id`, `template_title`, `template`, `priority`, `s_type`, `channel`, `dcs`, `flash_sms`, `route`, `peid`, `dlt_template_id`, `created_at`) VALUES
(1, 4, 'Enquiry bulk sms', '', 'ndnda', 'normal', 'Trans', 0, 0, 1, '', '', '2023-03-13 15:51:34'),
(2, 4, 'Appointment Booking', 'Thank You  {$name}. Your Appointment is booked for {$date} {$time}. From {$salon_name}.BOOKPX', 'ndnda', 'normal', 'Trans', 0, 0, 1, '1201162462661800644', '1207167168997235967', '2023-03-13 15:51:34'),
(3, 4, 'Service slip - client', '', 'ndnda', 'normal', 'Trans', 0, 0, 1, '', '', '2023-03-13 15:51:34'),
(4, 4, 'Service slip - service provider', '', 'ndnda', 'normal', 'Trans', 0, 0, 1, '', '', '2023-03-13 15:51:34'),
(5, 4, 'Billing', 'Thank you for your Services of {$inr} ON {$date} Invoice link {$invlink} For Feedback {$feedlink} From {$salon_name}. Thanks BOOKPX', 'ndnda', 'normal', 'Trans', 0, 0, 1, '1201162462661800644', '1207167168989297763', '2023-03-14 16:12:51'),
(6, 4, 'New client', '', 'ndnda', 'normal', 'Trans', 0, 0, 1, '', '', '2023-03-13 15:51:34'),
(7, 4, 'Feedback after billing', '', 'ndnda', 'normal', 'Trans', 0, 0, 1, '', '', '2023-03-13 15:51:34'),
(8, 4, 'Cancle appointment', 'Dear {$name}, your appointment is Cancelled  with {$salon_name}.Any query call {$salon_contact}', 'ndnda', 'normal', 'Trans', 0, 0, 1, '1201162462661800644', '1207167168976382605', '2023-03-13 15:51:34'),
(9, 4, 'Update Appointment', 'Dear {$name} , your appointment has been reschedule at {$salon_name} on {$date} at {$salon_address} . Any query call {$salon_contact} ', 'ndnda', 'normal', 'Trans', 0, 0, 1, '1201162462661800644', '1207167168976382605', '2023-03-13 15:51:34'),
(10, 4, 'Birthday', 'Dear {$name}, Many Many Happy returns of the day. May god bless you. {$salon_name}.', 'ndnda', 'normal', 'Trans', 0, 0, 1, '1201162462661800644', '1207167168976382605', '2023-03-13 15:51:34'),
(11, 4, 'Anniversary', '', 'ndnda', 'normal', 'Trans', 0, 0, 1, '', '', '2023-03-13 15:51:34'),
(12, 4, 'Pending payment', '', 'ndnda', 'normal', 'Trans', 0, 0, 1, '', '', '2023-03-13 15:51:34'),
(13, 4, 'Package expiry', '', 'ndnda', 'normal', 'Trans', 0, 0, 1, '', '', '2023-03-13 15:51:34'),
(14, 4, 'Enquiry followup', '', 'ndnda', 'normal', 'Trans', 0, 0, 1, '', '', '2023-03-13 15:51:34'),
(15, 4, 'Irregular client', '', 'ndnda', 'normal', 'Trans', 0, 0, 1, '', '', '2023-03-13 15:51:34'),
(16, 4, 'Client bulk sms', '', 'ndnda', 'normal', 'Trans', 0, 0, 1, '', '', '2023-03-13 15:51:34'),
(17, 4, 'Wallet', 'Dear {$name} , Your wallet is credited with INR –  {$inr}. Available Wallet Balance INR  {$available} From  {$salon_name}. Thanks\r\n\r\nBOOKPX', 'ndnda', 'normal', 'Trans', 0, 0, 1, '1201162462661800644', '1207167168976382605', '2023-03-13 18:07:45'),
(19, 5, 'Booking Reminder', 'Dear {$name},{$date},{$service_time} we have schedule your booking!  with {$salon_name} ', 'ndnda', 'normal', 'Trans', 0, 0, 1, '1201162462661800644', '1207167168989297763', '2023-03-24 17:12:14');

-- --------------------------------------------------------

--
-- Table structure for table `branch_working_day_hour`
--

CREATE TABLE `branch_working_day_hour` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `monday` tinyint(4) DEFAULT 0,
  `monday_hour_open` varchar(20) DEFAULT NULL,
  `monday_hour_close` varchar(20) DEFAULT NULL,
  `tuesday` tinyint(4) DEFAULT 0,
  `tuesday_hour_open` varchar(20) DEFAULT NULL,
  `tuesday_hour_close` varchar(20) DEFAULT NULL,
  `wednesday` tinyint(4) DEFAULT 0,
  `wednesday_hour_open` varchar(20) DEFAULT NULL,
  `wednesday_hour_close` varchar(20) DEFAULT NULL,
  `thursday` tinyint(4) DEFAULT 0,
  `thursday_hour_open` varchar(20) DEFAULT NULL,
  `thursday_hour_close` varchar(20) DEFAULT NULL,
  `friday` tinyint(4) DEFAULT 0,
  `friday_hour_open` varchar(20) DEFAULT NULL,
  `friday_hour_close` varchar(20) DEFAULT NULL,
  `saturday` tinyint(4) DEFAULT 0,
  `saturday_hour_open` varchar(20) DEFAULT NULL,
  `saturday_hour_close` varchar(20) DEFAULT NULL,
  `sunday` tinyint(4) DEFAULT 0,
  `sunday_hour_open` varchar(20) DEFAULT NULL,
  `sunday_hour_close` varchar(20) DEFAULT NULL,
  `extra_hour` tinyint(4) DEFAULT 0,
  `day_end_report_time` varchar(20) DEFAULT NULL,
  `day_end_report_send_mail` tinyint(4) DEFAULT 0,
  `day_end_report_send_sms` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `branch_working_day_hour`
--

INSERT INTO `branch_working_day_hour` (`id`, `branch_id`, `monday`, `monday_hour_open`, `monday_hour_close`, `tuesday`, `tuesday_hour_open`, `tuesday_hour_close`, `wednesday`, `wednesday_hour_open`, `wednesday_hour_close`, `thursday`, `thursday_hour_open`, `thursday_hour_close`, `friday`, `friday_hour_open`, `friday_hour_close`, `saturday`, `saturday_hour_open`, `saturday_hour_close`, `sunday`, `sunday_hour_open`, `sunday_hour_close`, `extra_hour`, `day_end_report_time`, `day_end_report_send_mail`, `day_end_report_send_sms`) VALUES
(8, 4, 1, '08:00 AM', '11:55 PM', 1, '08:00 AM', '11:55 PM', 1, '08:00 AM', '11:55 PM', 1, '08:00 AM', '11:55 PM', 1, '08:00 AM', '11:55 PM', 1, '08:00 AM', '11:55 PM', 1, '08:00 AM', '11:55 PM', 1, '05:00 PM', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `dob` varchar(20) DEFAULT NULL,
  `anniversary` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `source_of_client` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `referral` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `branch_id`, `client_name`, `contact`, `dob`, `anniversary`, `gender`, `email`, `source_of_client`, `address`, `referral`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 4, 'Charu Dar', '9783714748', '20/01/1952', NULL, 'female', 'ricky.talwar@bansal.com', NULL, '77, Labeen Apartments, Yeshwanthpura, Faridabad, Kerala - 550984', NULL, '2023-01-27 15:51:34', NULL, NULL, NULL),
(2, 4, 'Rohini Dey', '4046856171', '20/07/2012', NULL, 'female', 'varma.vijay@tak.com', NULL, '39, Dadar,, Kolkata, Sikkim - 359581', NULL, '2023-01-27 15:51:34', NULL, NULL, NULL),
(3, 4, 'Ananya Brar', '6642404226', '12/08/1965', NULL, 'female', 'wable.habib@lachman.org', NULL, '79, Sara Chowk,, Udaipur, Kerala - 432752', NULL, '2023-01-27 15:51:34', NULL, NULL, NULL),
(4, 4, 'Upasana Balay', '2684938746', '26/10/1935', NULL, 'female', 'sur.runjhun@hotmail.com', NULL, '67, Gayatri Apartments, Yerwada, Rajkot, Jammu and Kashmir - 329810', NULL, '2023-01-27 15:51:34', NULL, NULL, NULL),
(5, 4, 'Kim Sood', '7078517866', '20/05/1968', NULL, 'female', 'ravi.mukti@mannan.org', NULL, '79, Bandra,, Nashik, Jammu and Kashmir - 311759', NULL, '2023-01-27 15:51:34', NULL, NULL, NULL),
(6, 4, 'Padama Anand', '4252412090', '07/05/2010', NULL, 'female', 'ibrahim17@yahoo.com', NULL, '20, Nupoor Chowk,, Pondicherry, West Bengal - 591032', NULL, '2023-01-27 15:51:34', NULL, NULL, NULL),
(7, 4, 'Anjana Lodi', '2339277368', '11/06/1954', NULL, 'female', 'thakur.arun@yahoo.com', NULL, '18, Namita Villas, Hinjewadi, Lucknow, Gujarat - 519215', NULL, '2023-01-27 15:51:34', NULL, NULL, NULL),
(8, 4, 'Ambika Mehta', '1303757813', '26/03/2000', NULL, 'female', 'ibhatnagar@gmail.com', NULL, '17, Andheri,, Pilani, Madhya Pradesh - 590687', NULL, '2023-01-27 15:51:34', NULL, NULL, NULL),
(9, 4, 'Rohini Arya', '3886907067', '17/11/1925', NULL, 'female', 'lamin@choudhary.in', NULL, '69, CharlieGarh,, Mysore, Andaman and Nicobar Islands - 165643', NULL, '2023-01-27 15:51:34', NULL, NULL, NULL),
(10, 4, 'Drishti Cheema', '7037385150', '09/08/1990', NULL, 'female', 'ttrivedi@comar.com', NULL, '11, Nikita Nagar,, Jammu, Uttarakhand - 226444', NULL, '2023-01-27 15:51:34', NULL, NULL, NULL),
(11, 4, 'Drishti Sankar', '7328358046', '14/06/2016', NULL, 'female', 'labeen95@yahoo.co.in', NULL, '17, Nupoor Society, PrernaGarh, Gurgaon, Bihar - 288785', NULL, '2023-01-27 15:51:34', NULL, NULL, NULL),
(12, 4, 'Kajol Dash', '7851088856', '12/03/1983', NULL, 'female', 'hemendra67@hotmail.com', NULL, '44, Prabhat Society, RehmanGunj, Kochi, Meghalaya - 396259', NULL, '2023-01-27 15:51:34', NULL, NULL, NULL),
(13, 4, 'Richa Shah', '8844798468', '31/08/1935', NULL, 'female', 'hema08@subramanian.com', NULL, '96, Churchgate,, Meerut, Himachal Pradesh - 450142', NULL, '2023-01-27 15:51:34', NULL, NULL, NULL),
(14, 4, 'Swati Saini', '6367053772', '05/09/1933', NULL, 'female', 'ramachandran.richa@pillai.co.in', NULL, '83, ParvezGarh,, Udaipur, Andaman and Nicobar Islands - 298783', NULL, '2023-01-27 15:51:34', NULL, NULL, NULL),
(15, 4, 'Charu Lodi', '8939807986', '26/10/1955', NULL, 'female', 'krishna.modi@choudhury.com', NULL, '46, Aundh,, Trichy, Puducherry - 466370', NULL, '2023-01-27 15:51:34', NULL, NULL, NULL),
(16, 4, 'Sona Menon', '4806380370', '11/02/2018', NULL, 'female', 'nakul.kara@gmail.com', NULL, '26, Hira Heights, Borivali, Udaipur, Nagaland - 163930', NULL, '2023-01-27 15:51:34', NULL, NULL, NULL),
(17, 4, 'Upasana Sood', '9351159058', '18/09/2012', NULL, 'female', 'tejaswani36@rediffmail.com', NULL, '51, HariGunj,, Chandigarh, Karnataka - 488423', NULL, '2023-01-27 15:51:35', NULL, NULL, NULL),
(18, 4, 'Amolika Chowdhury', '7652885396', '07/10/1962', NULL, 'female', 'ubakshi@yahoo.com', NULL, '99, Nitin Heights, KirtiGarh, Kanpur, Tripura - 243914', NULL, '2023-01-27 15:51:35', NULL, NULL, NULL),
(19, 4, 'Kirti Hegde', '2207742137', '02/12/2014', NULL, 'female', 'vkabra@raman.com', NULL, '48, Sharad Society, Deccan Gymkhana, Vadodara, Tripura - 163452', NULL, '2023-01-27 15:51:35', NULL, NULL, NULL),
(20, 4, 'Madhu Nagar', '7955547640', '23/01/2009', NULL, 'female', 'qboase@kala.net', NULL, '19, Aundh,, Raipur, Madhya Pradesh - 312070', NULL, '2023-01-27 15:51:35', NULL, NULL, NULL),
(21, 4, 'Alaknanda Dodiya', '8705287940', '01/05/1960', NULL, 'female', 'egulati@lata.in', NULL, '11, Rehman Society, MustafaGunj, Mysore, Bihar - 143288', NULL, '2023-01-27 15:51:35', NULL, NULL, NULL),
(22, 4, 'Bimla Mistry', '5415191958', '18/10/1954', NULL, 'female', 'laveena.sengupta@rediffmail.com', NULL, '71, Madhu Apartments, Dadar, Agra, Jammu and Kashmir - 262791', NULL, '2023-01-27 15:51:35', NULL, NULL, NULL),
(23, 4, 'Bhaagyasree Mehra', '5839659012', '21/11/1995', NULL, 'female', 'zmathew@yahoo.com', NULL, '87, Yash Heights, IqbalGarh, Bikaner, Bihar - 154491', NULL, '2023-01-27 15:51:35', NULL, NULL, NULL),
(24, 4, 'Ambika Dhillon', '2716972746', '21/11/1926', NULL, 'female', 'grover.ananya@rediffmail.com', NULL, '93, Sharad Villas, Model Town, Pune, Jharkhand - 277036', NULL, '2023-01-27 15:51:35', NULL, NULL, NULL),
(25, 4, 'Komal Garg', '3094988724', '16/03/1963', NULL, 'female', 'zeeshan.anne@yahoo.co.in', NULL, '65, Baldev Villas, DrishtiPur, Bhubhaneshwar, Odisha - 142134', NULL, '2023-01-27 15:51:35', NULL, NULL, NULL),
(26, 4, 'Balaji Chatterjee', '1792470141', '18/05/2013', NULL, 'male', 'fhari@chand.com', NULL, '25, Jagruti Society, Mohit Nagar, Rajkot, Puducherry - 201282', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(27, 4, 'Srinivasan Handa', '1062048951', '05/12/1934', NULL, 'male', 'hegde.anusha@yahoo.com', NULL, '86, Navami Villas, Yeshwanthpura, Jaipur, Maharashtra - 471295', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(28, 4, 'Zaad Joshi', '5959786572', '27/04/2007', NULL, 'male', 'sharad.sule@yahoo.com', NULL, '22, Ajeet Chowk,, Kanpur, Madhya Pradesh - 311065', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(29, 4, 'Faisal Khatri', '8513024844', '18/04/1947', NULL, 'male', 'namita99@yahoo.co.in', NULL, '97, Sabina Heights, Vikhroli, Lucknow, Madhya Pradesh - 533319', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(30, 4, 'Jack Tella', '9599763455', '07/04/1958', NULL, 'male', 'shroff.ratan@yahoo.co.in', NULL, '64, Shanti Nagar,, Chennai, Rajasthan - 293256', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(31, 4, 'Marlo Doctor', '5185112203', '24/07/1948', NULL, 'male', 'sirish07@gmail.com', NULL, '29, Radheshyam Heights, RachelPur, Hisar, Andhra Pradesh - 279105', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(32, 4, 'Fardeen Karan', '2162652732', '19/08/1945', NULL, 'male', 'lgandhi@hotmail.com', NULL, '64, Aundh,, Bikaner, Madhya Pradesh - 319661', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(33, 4, 'Bahadur Bera', '6228664175', '22/04/1945', NULL, 'male', 'dial.sweta@mittal.in', NULL, '24, Churchgate,, Chennai, Arunachal Pradesh - 523320', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(34, 4, 'Yadunandan Sundaram', '7899416888', '08/03/1999', NULL, 'male', 'parvez.gobin@sarma.org', NULL, '15, Himani Apartments, Dadar, Warangal, Bihar - 596820', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(35, 4, 'Harpreet Baral', '2709184166', '18/01/2014', NULL, 'male', 'parvez60@deshpande.in', NULL, '45, Cyber City,, Delhi, Daman and Diu - 282150', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(36, 4, 'Jobin Konda', '1985183629', '15/03/1962', NULL, 'male', 'mitra.madhavi@viswanathan.in', NULL, '21, Aastha Apartments, Trishana Chowk, Guwahati, Bihar - 342452', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(37, 4, 'Sai Pal', '8094984550', '07/07/1923', NULL, 'male', 'kiran40@sathe.com', NULL, '90, Yasmin Villas, HimanshuGarh, Bengaluru, Delhi - 150434', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(38, 4, 'Aatif Saini', '8587053560', '02/09/1966', NULL, 'male', 'jaswant.chatterjee@hotmail.com', NULL, '71, MohanGarh,, Vadodara, Punjab - 304724', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(39, 4, 'Baldev Khan', '5775258350', '07/04/1950', NULL, 'male', 'manish.nigam@ramachandran.com', NULL, '30, MarloGarh,, Jaipur, Meghalaya - 382178', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(40, 4, 'Naseer Ghosh', '2456413473', '17/03/1953', NULL, 'male', 'bgulati@mukherjee.in', NULL, '96, Nirmal Heights, MonaGunj, Jabalpur, Haryana - 268292', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(41, 4, 'Jagdish Vaidya', '6212889794', '07/10/1939', NULL, 'male', 'rsuri@sha.com', NULL, '58, Kushal Society, Riya Chowk, Raipur, Odisha - 526711', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(42, 4, 'Yadunandan Varughese', '1977511550', '11/04/2010', NULL, 'male', 'kulkarni.gauransh@rediffmail.com', NULL, '74, AmbikaGunj,, Chennai, Delhi - 146172', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(43, 4, 'Habib Palan', '7408944411', '01/02/1985', NULL, 'male', 'nutan70@balay.com', NULL, '16, Upasana Society, Borivali, Ludhiana, West Bengal - 301572', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(44, 4, 'Abhinav Usman', '1288113140', '06/03/1984', NULL, 'male', 'mvig@nadkarni.co.in', NULL, '65, Venkat Apartments, Vikhroli, Mumbai, Uttar Pradesh - 500224', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(45, 4, 'Jamshed Comar', '2727493953', '19/05/1968', NULL, 'male', 'kartik77@mand.com', NULL, '92, Balaji Heights, Harmada, Kota, Rajasthan - 178124', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(46, 4, 'Devendra Shetty', '8930227550', '16/06/1930', NULL, 'male', 'khanna.sweta@balan.in', NULL, '88, Gauransh Villas, ManishPur, Patna, Jammu and Kashmir - 466405', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(47, 4, 'Aayushman Chatterjee', '3002915097', '21/08/1941', NULL, 'male', 'swati29@shenoy.com', NULL, '13, NaliniGarh,, Chandigarh, Nagaland - 160770', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(48, 4, 'Rashid Varkey', '2517632380', '08/08/2004', NULL, 'male', 'zaad.goel@shere.com', NULL, '42, Churchgate,, Faridabad, Dadra and Nagar Haveli - 599916', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(49, 4, 'Zahir Tara', '7280082452', '15/03/2012', NULL, 'male', 'nayan.chaudry@dalia.in', NULL, '37, Pradeep Heights, Churchgate, Simla, Nagaland - 105911', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(50, 4, 'Deep Bhatti', '5702366901', '21/02/1997', NULL, 'male', 'binoya59@gmail.com', NULL, '64, RadheshyamGunj,, Ajmer, Andhra Pradesh - 469950', NULL, '2023-01-27 15:51:59', NULL, NULL, NULL),
(56, 4, 'Sabire Rasul', '9125149648', '26/03/2023', '', 'male', 'itsabirerasul@gmail.com', 'Client refrence', 'alambagh', NULL, '2023-01-28 01:58:11', NULL, '2023-03-25 17:01:10', NULL),
(59, 4, 'Rajesh Chauhan', '7905001303', '', '', 'male', '', '', '', NULL, '2023-02-01 12:40:39', NULL, '2023-03-28 17:21:46', NULL),
(64, 4, 'sabire new', '9453179080', NULL, NULL, 'male', NULL, NULL, NULL, NULL, '2023-04-15 12:06:20', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client_billing`
--

CREATE TABLE `client_billing` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL DEFAULT 0,
  `membership_id` int(11) NOT NULL DEFAULT 0,
  `invoice_number` varchar(50) NOT NULL,
  `billing_date` varchar(20) NOT NULL COMMENT 'date of appointment',
  `billing_time` varchar(20) NOT NULL COMMENT 'appointment time',
  `service_for` varchar(15) DEFAULT NULL,
  `sub_total` decimal(10,2) DEFAULT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `discount_type` text DEFAULT NULL,
  `tax` varchar(15) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `referral_code` varchar(255) DEFAULT NULL,
  `give_reward_point` int(11) DEFAULT NULL,
  `advance_receive` decimal(10,2) DEFAULT NULL,
  `pending_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT '1',
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_billing_assign_service_provider`
--

CREATE TABLE `client_billing_assign_service_provider` (
  `id` int(11) NOT NULL,
  `billing_id` int(11) NOT NULL,
  `billing_service_id` int(11) NOT NULL,
  `service_provider_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_billing_payment`
--

CREATE TABLE `client_billing_payment` (
  `id` int(11) NOT NULL,
  `billing_id` int(11) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `advance` decimal(10,2) NOT NULL,
  `method` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_billing_product`
--

CREATE TABLE `client_billing_product` (
  `id` int(11) NOT NULL,
  `billing_id` int(11) NOT NULL,
  `service_cat_id` int(11) NOT NULL DEFAULT 0,
  `service_id` int(11) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `service_discount` varchar(50) DEFAULT NULL,
  `service_discount_type` varchar(50) DEFAULT NULL,
  `start_time` varchar(20) NOT NULL,
  `end_time` varchar(20) NOT NULL,
  `start_timestamp` datetime DEFAULT NULL,
  `end_timestamp` datetime DEFAULT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_coupon_code_use_history`
--

CREATE TABLE `client_coupon_code_use_history` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `billing_id` int(11) NOT NULL,
  `coupon_code_id` int(11) NOT NULL,
  `coupon_code` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_followup`
--

CREATE TABLE `client_followup` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `followup_date` varchar(30) NOT NULL,
  `followup_time` varchar(30) NOT NULL,
  `response` text NOT NULL,
  `representative` varchar(50) NOT NULL,
  `response_type` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_membership`
--

CREATE TABLE `client_membership` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL,
  `billing_id` int(11) NOT NULL,
  `valid_upto` varchar(30) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_package`
--

CREATE TABLE `client_package` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `billing_id` int(11) NOT NULL,
  `valid_upto` varchar(30) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_package_details`
--

CREATE TABLE `client_package_details` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `client_package_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_package_details_usage`
--

CREATE TABLE `client_package_details_usage` (
  `id` int(11) NOT NULL,
  `package_details_id` int(11) NOT NULL,
  `client_package_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `billing_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `use_on` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_referral_code`
--

CREATE TABLE `client_referral_code` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `referral_code` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_referral_code_use_history`
--

CREATE TABLE `client_referral_code_use_history` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `billing_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `referral_client_id` int(11) NOT NULL,
  `referral_code_id` int(11) NOT NULL,
  `referral_code` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `billing_rc_redeem` tinyint(1) NOT NULL DEFAULT 0,
  `client_rc_redeem` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_wallet`
--

CREATE TABLE `client_wallet` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `bill_id` varchar(11) DEFAULT NULL,
  `date` varchar(20) NOT NULL,
  `transaction_type` varchar(50) DEFAULT NULL,
  `paid_amount` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(11) DEFAULT NULL,
  `amount_receive_from` varchar(150) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `id` int(11) NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `discount` int(11) NOT NULL,
  `discount_type` varchar(100) NOT NULL,
  `min_bill_amount` decimal(10,2) NOT NULL,
  `max_discount_amount` decimal(10,2) NOT NULL,
  `coupon_per_user` int(11) NOT NULL,
  `valid_till` varchar(50) NOT NULL,
  `reward_point` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`id`, `coupon_code`, `discount`, `discount_type`, `min_bill_amount`, `max_discount_amount`, `coupon_per_user`, `valid_till`, `reward_point`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'save20', 100, 'inr', 500.00, 100.00, 2, '30/04/2023', 50, '2023-04-26 17:41:50', NULL, NULL, NULL),
(2, 'save50', 50, 'percentage', 1000.00, 400.00, 2, '30/04/2023', 100, '2023-04-26 17:41:56', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dob` varchar(15) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `working_hours_start` varchar(15) NOT NULL,
  `working_hours_end` varchar(15) NOT NULL,
  `salary` varchar(8) NOT NULL,
  `emer_contact_number` varchar(15) NOT NULL,
  `emer_contact_person` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text DEFAULT NULL,
  `gender` varchar(8) NOT NULL,
  `date_of_joining` varchar(15) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `frontproof` varchar(255) DEFAULT NULL,
  `backproof` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `name`, `dob`, `contact_number`, `email`, `working_hours_start`, `working_hours_end`, `salary`, `emer_contact_number`, `emer_contact_person`, `address`, `username`, `password`, `gender`, `date_of_joining`, `user_type`, `department`, `photo`, `frontproof`, `backproof`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Anees Inani', '03/03/1935', '8503379285', 'khosla.natwar@yahoo.com', '09:00 AM', '07:00 PM', '15000', '', '', '46, Owais Chowk,, Patna, Nagaland - 276448', 'E188', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:56', NULL, NULL, NULL),
(2, 'Abbas Raman', '30/10/1939', '8401254343', 'payal51@rediffmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '94, Pradeep Heights, MowgliGunj, Raipur, Puducherry - 164950', 'E281', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:56', NULL, NULL, NULL),
(3, 'Kartik Oommen', '08/09/1932', '3081784536', 'tdey@gmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '37, Ritika Heights, NeerendraGarh, Rajkot, Meghalaya - 407370', 'E392', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:56', NULL, NULL, NULL),
(4, 'Amrit Subramaniam', '14/02/1933', '5499194344', 'mandal.vicky@yahoo.co.in', '09:00 AM', '07:00 PM', '15000', '', '', '74, Sodala,, Kolkata, Andaman and Nicobar Islands - 316725', 'E414', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:56', NULL, NULL, NULL),
(5, 'Kabeer Chanda', '24/07/1933', '8092605021', 'karim.khanna@hotmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '28, Astha Chowk,, Srinagar, Kerala - 455013', 'E518', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:56', NULL, NULL, NULL),
(6, 'David Mistry', '06/04/2001', '1669634078', 'philip.vaishali@tak.co.in', '09:00 AM', '07:00 PM', '15000', '', '', '12, Dadar,, Patna, Manipur - 388955', 'E697', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:56', NULL, NULL, NULL),
(7, 'Nirmal Chaudhry', '12/10/1956', '3902079760', 'zedwin@yahoo.com', '09:00 AM', '07:00 PM', '15000', '', '', '60, SukritiGunj,, Chennai, Kerala - 262598', 'E722', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:56', NULL, NULL, NULL),
(8, 'Yogesh Prashad', '04/12/1989', '9260752223', 'rbaral@yahoo.co.in', '09:00 AM', '07:00 PM', '15000', '', '', '70, Shashank Villas, Marathahalli, Jabalpur, Karnataka - 312994', 'E881', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:56', NULL, NULL, NULL),
(9, 'Yogesh Grewal', '19/01/1936', '8781315310', 'msarin@raja.com', '09:00 AM', '07:00 PM', '15000', '', '', '83, Labeen Society, Iqbal Chowk, Kanpur, Manipur - 293395', 'E967', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:56', NULL, NULL, NULL),
(10, 'Kailash Thakur', '03/10/1935', '6261983151', 'munaf.sood@sampath.in', '09:00 AM', '07:00 PM', '15000', '', '', '62, Model Town,, Raipur, West Bengal - 449058', 'E1071', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:57', NULL, NULL, NULL),
(11, 'Hrishikesh Persad', '03/05/1960', '9288409208', 'parvez99@gmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '66, Kalyani Villas, Borivali, Jammu, Kerala - 111356', 'E1123', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:57', NULL, NULL, NULL),
(12, 'Wafa Chander', '25/01/1931', '9827708580', 'kara.pamela@kapur.in', '09:00 AM', '07:00 PM', '15000', '', '', '15, Fakaruddin Society, Radhika Chowk, Ranchi, Odisha - 321385', 'E1250', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:57', NULL, NULL, NULL),
(13, 'Hetan Gade', '06/07/1942', '8702217449', 'mowgli51@yahoo.com', '09:00 AM', '07:00 PM', '15000', '', '', '53, Kharadi,, Darjeeling, Chandigarh - 304376', 'E1362', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:57', NULL, NULL, NULL),
(14, 'Baalkrishan Bhakta', '04/02/1930', '7626788409', 'gera.owais@yahoo.com', '09:00 AM', '07:00 PM', '15000', '', '', '18, Ajay Villas, Deccan Gymkhana, Rajkot, Telangana - 550760', 'E1448', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:57', NULL, NULL, NULL),
(15, 'Dinesh Dhingra', '23/09/1944', '6767981402', 'okarnik@gmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '57, Payal Society, Harmada, Thiruvananthapuram, Jharkhand - 384851', 'E153', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:57', NULL, NULL, NULL),
(16, 'Animesh Bhargava', '10/12/1928', '6750286605', 'aissac@rediffmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '74, Hadapsar,, Ahmedabad, Himachal Pradesh - 267208', 'E1621', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:57', NULL, NULL, NULL),
(17, 'Deep Grewal', '22/10/1977', '3831860361', 'prerna.mohanty@batra.com', '09:00 AM', '07:00 PM', '15000', '', '', '42, Mansarovar,, Noida, Dadra and Nagar Haveli - 554836', 'E1716', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:57', NULL, NULL, NULL),
(18, 'Rupesh Dial', '03/04/1983', '8987058105', 'fatima70@gokhale.in', '09:00 AM', '07:00 PM', '15000', '', '', '78, IqbalGunj,, Jodhpur, Goa - 345464', 'E1841', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:57', NULL, NULL, NULL),
(19, 'Monin Konda', '04/10/1994', '1131139644', 'jsampath@hotmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '60, Radheshyam Society, AnilPur, Gangtok, Chhattisgarh - 268109', 'E1919', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:57', NULL, NULL, NULL),
(20, 'Sharad Jha', '18/01/1944', '1251185539', 'aishwarya79@mannan.com', '09:00 AM', '07:00 PM', '15000', '', '', '99, PrabhatGarh,, Bengaluru, West Bengal - 186856', 'E2050', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:57', NULL, NULL, NULL),
(21, 'Suresh Taneja', '26/03/1985', '1705051453', 'umar.hans@hotmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '96, HrishikeshGunj,, Jammu, Daman and Diu - 255690', 'E2130', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:57', NULL, NULL, NULL),
(22, 'Aayushman Mathew', '14/02/1949', '3431017928', 'kunda.farah@misra.com', '09:00 AM', '07:00 PM', '15000', '', '', '10, Mansarovar,, Alwar, Chandigarh - 263483', 'E2218', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:57', NULL, NULL, NULL),
(23, 'Bijoy Meka', '30/05/2020', '1580056260', 'pillai.mridula@rediffmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '28, Mansarovar,, Pilani, Jharkhand - 371885', 'E2349', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:57', NULL, NULL, NULL),
(24, 'Taahid Mehan', '04/09/1923', '8755116192', 'utella@rediffmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '92, Julie Villas, Dadar, Vadodara, Andhra Pradesh - 518235', 'E2453', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:57', NULL, NULL, NULL),
(25, 'Mitesh Nagar', '26/01/1975', '7308774361', 'gshukla@samuel.com', '09:00 AM', '07:00 PM', '15000', '', '', '11, Vikhroli,, Jamnagar, Mizoram - 205858', 'E2587', NULL, 'male', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:02:57', NULL, NULL, NULL),
(26, 'Tanuja Kashyap', '07/06/1987', '2389530663', 'baria.tarun@yahoo.com', '09:00 AM', '07:00 PM', '15000', '', '', '43, Chinchwad,, Jaipur, Rajasthan - 231122', 'E2628', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:16', NULL, NULL, NULL),
(27, 'Drishti Issac', '07/04/2000', '9201508509', 'heena01@gandhi.com', '09:00 AM', '07:00 PM', '15000', '', '', '60, Charandeep Apartments, Marathahalli, Patna, Tamil Nadu - 325969', 'E279', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:16', NULL, NULL, NULL),
(28, 'Basanti Bansal', '26/05/1983', '6600811813', 'ibrahim.badami@yahoo.co.in', '09:00 AM', '07:00 PM', '15000', '', '', '81, Model Town,, Simla, Haryana - 557967', 'E2898', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:16', NULL, NULL, NULL),
(29, 'Lalita Doctor', '30/11/1928', '3688069196', 'ibehl@hari.com', '09:00 AM', '07:00 PM', '15000', '', '', '97, Churchgate,, Hisar, Sikkim - 432252', 'E2937', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:16', NULL, NULL, NULL),
(30, 'Alaknanda Baria', '14/08/1982', '5299833238', 'chameli93@goda.org', '09:00 AM', '07:00 PM', '15000', '', '', '86, Chhaya Apartments, RupeshPur, Thiruvananthapuram, Gujarat - 498244', 'E3087', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:16', NULL, NULL, NULL),
(31, 'Runjhun Joshi', '19/08/1923', '5698123055', 'mona.sahni@gmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '72, Jayshree Apartments, Chandpole, Pune, Bihar - 390055', 'E315', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:16', NULL, NULL, NULL),
(32, 'Dipti Pant', '12/06/1990', '9363596723', 'upasana.chakrabarti@gmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '76, Indrani Society, Model Town, Ludhiana, Lakshadweep - 585054', 'E3289', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:16', NULL, NULL, NULL),
(33, 'Smriti Pant', '29/08/1953', '6737090830', 'shetty.kabeer@hotmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '10, Andheri,, Alwar, Dadra and Nagar Haveli - 538109', 'E3321', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:16', NULL, NULL, NULL),
(34, 'Urmi Setty', '07/06/1959', '3689258510', 'qmishra@naruka.com', '09:00 AM', '07:00 PM', '15000', '', '', '30, Nazir Heights, Borivali, Nagpur, Chhattisgarh - 455072', 'E3489', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:16', NULL, NULL, NULL),
(35, 'Rita Chanda', '10/07/1953', '8937591414', 'kbal@gmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '44, Usha Chowk,, Kanpur, Nagaland - 525043', 'E3543', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:16', NULL, NULL, NULL),
(36, 'Akanksha Mammen', '03/11/1944', '3752171941', 'ichokshi@hotmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '91, Bishnu Villas, Chinchwad, Jodhpur, Mizoram - 305368', 'E3663', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:16', NULL, NULL, NULL),
(37, 'Neha Chauhan', '22/05/1940', '3744096295', 'heena.prakash@chanda.com', '09:00 AM', '07:00 PM', '15000', '', '', '46, RamGunj,, Alwar, Daman and Diu - 434590', 'E3752', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:16', NULL, NULL, NULL),
(38, 'Kalpana Kothari', '02/12/1933', '6693046678', 'anthony.baber@gmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '84, Malik Apartments, ManojPur, Ahmedabad, Assam - 321523', 'E3843', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:16', NULL, NULL, NULL),
(39, 'Urvashi Sane', '13/10/1931', '7191151714', 'ddas@issac.co.in', '09:00 AM', '07:00 PM', '15000', '', '', '76, Tulsi Society, Model Town, Nashik, Jharkhand - 133852', 'E3995', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:16', NULL, NULL, NULL),
(40, 'Divya Meda', '13/12/1939', '2603832918', 'aadish84@banik.com', '09:00 AM', '07:00 PM', '15000', '', '', '86, Ajay Heights, AvantikaGunj, Bengaluru, Gujarat - 122283', 'E4078', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:16', NULL, NULL, NULL),
(41, 'Anshu Malhotra', '02/04/1954', '3313933104', 'tejaswani43@yahoo.com', '09:00 AM', '07:00 PM', '15000', '', '', '34, Runjhun Villas, Deccan Gymkhana, Mumbai, Uttar Pradesh - 251997', 'E4199', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:16', NULL, NULL, NULL),
(42, 'Sneha Borra', '27/07/1927', '5388731180', 'uramson@yahoo.com', '09:00 AM', '07:00 PM', '15000', '', '', '29, AabhaPur,, Patna, Meghalaya - 208490', 'E4290', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:16', NULL, NULL, NULL),
(43, 'Zeenat Sharma', '24/06/1940', '3876627524', 'geetanjali.tella@de.in', '09:00 AM', '07:00 PM', '15000', '', '', '76, FalguniGunj,, Indore, Bihar - 373589', 'E4334', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:17', NULL, NULL, NULL),
(44, 'Binita Karpe', '01/12/1993', '5465063559', 'pdevi@gmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '68, Suraj Society, Bandra, Ludhiana, Rajasthan - 179380', 'E4499', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:17', NULL, NULL, NULL),
(45, 'Anusha Mutti', '09/01/1938', '6759707625', 'vivek68@yahoo.com', '09:00 AM', '07:00 PM', '15000', '', '', '88, Umesh Heights, Kormangala, Gangtok, Assam - 498875', 'E4579', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:17', NULL, NULL, NULL),
(46, 'Pushpa Bahl', '14/05/1936', '2099461031', 'xmohanty@dugal.net', '09:00 AM', '07:00 PM', '15000', '', '', '49, AkankshaGunj,, Jammu, Chhattisgarh - 394581', 'E4668', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:17', NULL, NULL, NULL),
(47, 'Runjhun Narayanan', '03/11/1925', '7871371665', 'koushtubh.ghosh@krishna.in', '09:00 AM', '07:00 PM', '15000', '', '', '21, Jatin Villas, MonicaGarh, New Delhi, Meghalaya - 504155', 'E4726', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:17', NULL, NULL, NULL),
(48, 'Nishi Maheshwari', '11/04/2008', '9033334799', 'obaid.hans@yahoo.co.in', '09:00 AM', '07:00 PM', '15000', '', '', '72, Amrita Society, BaldevPur, Ajmer, Jammu and Kashmir - 546606', 'E4861', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:17', NULL, NULL, NULL),
(49, 'Kirti Kamdar', '13/08/1991', '5824526500', 'bhalla.mridula@sidhu.in', '09:00 AM', '07:00 PM', '15000', '', '', '84, Churchgate,, Nashik, Odisha - 365263', 'E4956', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:17', NULL, NULL, NULL),
(50, 'Tejaswani Jaggi', '02/08/1974', '7940171546', 'vikrant69@gmail.com', '09:00 AM', '07:00 PM', '15000', '', '', '86, Harmada,, Hisar, Dadra and Nagar Haveli - 219422', 'E5044', NULL, 'female', '27/10/2022', 'user', 'management', NULL, NULL, NULL, 1, '2023-01-27 16:03:17', NULL, NULL, NULL),
(51, 'nn', '27/03/2023', '9999999999', '', '10:00 AM', '06:00 PM', '15000', '', '', '', 'E5141', NULL, 'male', '27/03/2023', 'user', 'sales', '', '', '', 1, '2023-03-27 17:07:09', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_salary`
--

CREATE TABLE `employee_salary` (
  `id` int(11) NOT NULL,
  `date` varchar(50) NOT NULL,
  `employee_type` varchar(100) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `salary_type` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `comments` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `employee_salary`
--

INSERT INTO `employee_salary` (`id`, `date`, `employee_type`, `employee_id`, `salary_type`, `amount`, `comments`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, '18/03/2023', '2', 26, '1', 100000.00, 'eeer', '2023-03-18 16:35:56', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `enquiry`
--

CREATE TABLE `enquiry` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `enquiry_for` int(11) NOT NULL,
  `enquiry_table_type` varchar(100) NOT NULL,
  `enquiry_type` varchar(50) NOT NULL,
  `response` text DEFAULT NULL,
  `followdate` varchar(20) NOT NULL,
  `source_of_enquiry` varchar(200) NOT NULL,
  `leaduser` varchar(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `enquiry`
--

INSERT INTO `enquiry` (`id`, `branch_id`, `client_id`, `contact`, `client_name`, `email`, `address`, `enquiry_for`, `enquiry_table_type`, `enquiry_type`, `response`, `followdate`, `source_of_enquiry`, `leaduser`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 4, 56, '9125149648', 'Sabire Rasul', '', '', 26, 'service', 'Hot', '', '09/02/2023', 'Instagram', '1', 'Pending', '2023-02-08 18:06:44', NULL, NULL, NULL),
(2, 4, 56, '9125149648', 'Sabire Rasul', '', '', 64, 'service', 'Cold', '', '09/02/2023', 'Flex', '1', 'Pending', '2023-02-08 18:07:33', NULL, NULL, NULL),
(4, 4, 56, '9125149648', 'sabir second', 'sabirerasuljic@gmail.com', '', 123, 'service', 'Hot', '', '09/02/2023', 'Flyer', '', 'Pending', '2023-04-18 17:45:27', NULL, NULL, NULL),
(5, 4, 56, '9125149648', 'sabir second', 'billing@saraagrofoods.com', '', 10, 'service', 'Hot', '', '09/02/2023', 'Cold Calling', '', 'Pending', '2023-04-18 17:46:43', NULL, NULL, NULL),
(6, 4, 56, '9125149648', 'sabiraas ', 'sabirerasuljic@gmail.com', '', 20, 'service', 'Hot', '', '09/02/2023', 'Flex', '', 'Pending', '2023-04-18 17:47:29', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_history`
--

CREATE TABLE `enquiry_history` (
  `id` int(11) NOT NULL,
  `enquiry_id` int(11) NOT NULL,
  `date` varchar(20) DEFAULT NULL,
  `response` tinytext DEFAULT NULL,
  `update_time` varchar(20) DEFAULT NULL,
  `enquiry_type` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `leaduser` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `enquiry_history`
--

INSERT INTO `enquiry_history` (`id`, `enquiry_id`, `date`, `response`, `update_time`, `enquiry_type`, `status`, `leaduser`, `created_at`) VALUES
(1, 1, '08/02/2023', '', '06:06 PM', 'Hot', 'Pending', 1, '2023-02-08 18:06:44'),
(2, 2, '08/02/2023', '', '06:07 PM', 'Cold', 'Pending', 1, '2023-02-08 18:07:33'),
(4, 4, '18/04/2023', '', '05:45 PM', 'Hot', 'Pending', 0, '2023-04-18 17:45:27'),
(5, 5, '18/04/2023', '', '05:46 PM', 'Hot', 'Pending', 0, '2023-04-18 17:46:43'),
(6, 6, '18/04/2023', '', '05:47 PM', 'Hot', 'Pending', 0, '2023-04-18 17:47:29');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `date` varchar(30) NOT NULL,
  `expense_type_id` int(11) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_mode` int(11) NOT NULL,
  `recipient_name_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_recipient`
--

CREATE TABLE `expense_recipient` (
  `id` int(11) NOT NULL,
  `recipient_name` tinytext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `expense_recipient`
--

INSERT INTO `expense_recipient` (`id`, `recipient_name`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(7, 'sujeet', '2023-03-27 16:22:06', NULL, NULL, NULL),
(8, 'ramesh', '2023-03-27 16:22:20', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expense_type`
--

CREATE TABLE `expense_type` (
  `id` int(11) NOT NULL,
  `title` tinytext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `expense_type`
--

INSERT INTO `expense_type` (`id`, `title`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(8, 'tea', '2023-03-27 16:22:06', NULL, NULL, NULL),
(9, 'coffee', '2023-03-27 16:22:20', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_number` varchar(150) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `review` text NOT NULL,
  `overall_experience` varchar(30) NOT NULL,
  `timely_response` varchar(30) NOT NULL,
  `our_support` varchar(30) NOT NULL,
  `overall_satisfaction` varchar(30) NOT NULL,
  `rating` int(5) NOT NULL,
  `suggestion` text DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `branch_id`, `client_id`, `invoice_number`, `name`, `email`, `review`, `overall_experience`, `timely_response`, `our_support`, `overall_satisfaction`, `rating`, `suggestion`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(2, 4, 56, 'LA2303165606', 'Sabire Rasul', 'itsabirerasul@gmail.com', 'Awesome', 'Very Good', 'Very Good', 'Very Good', 'Very Good', 5, 'Awesome', 1, '2023-04-19 17:26:50', NULL, NULL, NULL),
(3, 4, 56, 'LA2304113026', 'Sabire Rasul', 'itsabirerasul@gmail.com', 'Beawesome', 'Very Good', 'Very Good', 'Very Good', 'Very Good', 5, 'bakwas', 1, '2023-04-19 17:28:51', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gst_slab`
--

CREATE TABLE `gst_slab` (
  `id` int(11) NOT NULL,
  `product_service_type` varchar(20) NOT NULL,
  `tax_type` varchar(20) NOT NULL,
  `gst` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `gst_slab`
--

INSERT INTO `gst_slab` (`id`, `product_service_type`, `tax_type`, `gst`) VALUES
(3, 'product', 'inclusive', 0),
(4, 'product', 'exclusive', 0),
(5, 'service', 'inclusive', 0),
(6, 'service', 'exclusive', 0),
(7, 'product', 'inclusive', 5),
(8, 'product', 'exclusive', 5),
(9, 'service', 'inclusive', 5),
(10, 'service', 'exclusive', 5),
(11, 'product', 'inclusive', 12),
(12, 'product', 'exclusive', 12),
(13, 'service', 'inclusive', 12),
(14, 'service', 'exclusive', 12),
(15, 'product', 'inclusive', 18),
(16, 'product', 'exclusive', 18),
(17, 'service', 'inclusive', 18),
(18, 'service', 'exclusive', 18),
(19, 'product', 'inclusive', 28),
(20, 'product', 'exclusive', 28),
(21, 'service', 'inclusive', 28),
(22, 'service', 'exclusive', 28);

-- --------------------------------------------------------

--
-- Table structure for table `link_shortener`
--

CREATE TABLE `link_shortener` (
  `id` int(11) NOT NULL,
  `billing_id` int(11) NOT NULL,
  `invoice_number` varchar(100) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `link_type` varchar(100) NOT NULL,
  `shortener_key` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `link_shortener`
--

INSERT INTO `link_shortener` (`id`, `billing_id`, `invoice_number`, `domain`, `link_type`, `shortener_key`, `created_at`) VALUES
(154, 150, 'LA2304113026', 'http://localhost/sabir/pixelsalonsoftwarefresh/', 'invoice', '7yeJqfT2', '2023-04-15 11:30:27'),
(155, 150, 'LA2304113026', 'http://localhost/sabir/pixelsalonsoftwarefresh/', 'feedback', 'Ct4jCnKB', '2023-04-15 11:30:27'),
(156, 151, 'LA2304120959', 'http://localhost/sabir/pixelsalonsoftwarefresh/', 'invoice', 'lJKHE4ML', '2023-04-15 12:09:59'),
(157, 151, 'LA2304120959', 'http://localhost/sabir/pixelsalonsoftwarefresh/', 'feedback', 'PsCF2Lxa', '2023-04-15 12:09:59'),
(158, 152, 'LA2304121050', 'http://localhost/sabir/pixelsalonsoftwarefresh/', 'invoice', 'mC7Ofuhy', '2023-04-15 12:10:51'),
(159, 152, 'LA2304121050', 'http://localhost/sabir/pixelsalonsoftwarefresh/', 'feedback', '5Bipwqp1', '2023-04-15 12:10:51'),
(160, 153, 'LA2305155304', 'http://localhost/salon-software/pixelsalonsoftwarefresh/', 'invoice', 'B8pA1XFP', '2023-05-12 15:53:05'),
(161, 153, 'LA2305155304', 'http://localhost/salon-software/pixelsalonsoftwarefresh/', 'feedback', 'LX0KuNKV', '2023-05-12 15:53:05'),
(162, 154, 'LA2305155333', 'http://localhost/salon-software/pixelsalonsoftwarefresh/', 'invoice', 't598yrlb', '2023-05-12 15:53:33'),
(163, 154, 'LA2305155333', 'http://localhost/salon-software/pixelsalonsoftwarefresh/', 'feedback', 'bDeut2IP', '2023-05-12 15:53:33'),
(164, 155, 'LA2305155345', 'http://localhost/salon-software/pixelsalonsoftwarefresh/', 'invoice', '4Ic0Pr40', '2023-05-12 15:53:45'),
(165, 155, 'LA2305155345', 'http://localhost/salon-software/pixelsalonsoftwarefresh/', 'feedback', 'ofmSGOrr', '2023-05-12 15:53:45');

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `id` int(11) NOT NULL,
  `membership_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `validity` int(4) NOT NULL COMMENT 'Duration (in days start from day of purchase)',
  `reward_point` int(11) NOT NULL COMMENT 'Reward points on purchase',
  `discount_on_service` int(11) NOT NULL,
  `discount_on_service_type` varchar(20) NOT NULL,
  `discount_on_product` int(11) NOT NULL,
  `discount_on_product_type` varchar(20) NOT NULL,
  `discount_on_package` int(11) NOT NULL,
  `discount_on_package_type` varchar(20) NOT NULL,
  `reward_point_boost` varchar(10) NOT NULL,
  `min_reward_point_earned` decimal(10,2) NOT NULL,
  `membership_condition` varchar(50) NOT NULL,
  `min_bill_amount` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`id`, `membership_name`, `price`, `validity`, `reward_point`, `discount_on_service`, `discount_on_service_type`, `discount_on_product`, `discount_on_product_type`, `discount_on_package`, `discount_on_package_type`, `reward_point_boost`, `min_reward_point_earned`, `membership_condition`, `min_bill_amount`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Silver', 10000.00, 60, 100, 5, 'percentage', 3, 'percentage', 3, 'percentage', '2', 100.00, '1', 10000.00, '2023-02-27 16:13:00', NULL, NULL, NULL),
(2, 'Gold', 20000.00, 60, 200, 10, 'percentage', 6, 'percentage', 6, 'percentage', '4', 200.00, '1', 20000.00, '2023-02-27 16:12:51', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `id` int(11) NOT NULL,
  `package_name` tinytext NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'Duration (in days start from day of purchase)',
  `package_validity` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`id`, `package_name`, `duration`, `package_validity`, `price`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'All in One', 30, '27/02/2023', 500.00, '2023-02-27 16:15:59', NULL, '2023-03-27 17:04:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `package_service`
--

CREATE TABLE `package_service` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `package_service`
--

INSERT INTO `package_service` (`id`, `package_id`, `service_id`, `quantity`, `price`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(4, 1, 26, 1, 1200.00, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `invoice` varchar(100) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_mode` varchar(100) NOT NULL,
  `notes` text NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pending_payment_history`
--

CREATE TABLE `pending_payment_history` (
  `id` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `app_bill_id` int(11) NOT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `paid_branch_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `advance` decimal(10,2) NOT NULL,
  `paid` decimal(10,2) NOT NULL,
  `pending` decimal(10,2) NOT NULL,
  `payment_mode` int(11) DEFAULT NULL,
  `bill_type` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `pending_payment_history`
--

INSERT INTO `pending_payment_history` (`id`, `date`, `branch_id`, `client_id`, `app_bill_id`, `appointment_id`, `paid_branch_id`, `total`, `advance`, `paid`, `pending`, `payment_mode`, `bill_type`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(221, '20/05/2023', 4, 56, 70, NULL, 4, 100.00, 0.00, 0.00, 100.00, NULL, 'appointment', '2023-05-20 18:17:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product` text NOT NULL,
  `volume` varchar(20) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `mrp` decimal(10,2) NOT NULL,
  `barcode` tinytext DEFAULT NULL,
  `reward_point_on_purchase` varchar(100) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product`, `volume`, `unit`, `mrp`, `barcode`, `reward_point_on_purchase`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(590, 'Kera', '200', 'ml', 800.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(591, 'Loreal shamppo', '250', 'l', 500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(592, 'Lotus gold facial', '5', 'pkt', 1210.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(593, 'Xyz', '1', 'l', 1000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(594, 'Fruit facial Kit', '1', 'pcs', 2500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(595, 'Saloon Chair', '1', 'pcs', 30000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(596, 'Brasil Cacau BTR', '1000', 'ml', 30000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(597, 'Bridal chair', '1', 'pcs', 35000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(598, 'Raj Facial', '1', 'pcs', 300.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(599, 'Abc', '12', 'gram', 23.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(600, 'Salon product', '1', 'l', 1200.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(601, 'Bindiiiii', '2', 'pcs', 455.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(602, 'Product 12', '2', 'pcs', 366.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(603, 'Product', '1', 'pcs', 200.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(604, 'Bindi', '10', 'pcs', 500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(605, 'Hair ext', '1', 'l', 250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(606, 'Xtenso keratin repair shampoo', '1', 'pcs', 875.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(607, 'Xtenso keratin repair mask', '1', 'pcs', 980.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(608, 'Wooden Sputula', '1', 'pcs', 200.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(609, 'Whitening & Brightening Nourishing Mositureiser', '1', 'pcs', 545.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(610, 'Wax Strip', '1', 'pcs', 160.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(611, 'Wax Pre post Oil', '1', 'pcs', 1100.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(612, 'Wax Powder', '1', 'pcs', 60.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(613, 'Wax italian', '1', 'pcs', 950.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(614, 'Wax flavoured', '1', 'pcs', 300.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(615, 'Wax estilo', '1', 'pcs', 900.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(616, 'WATER BOTTEL', '1', 'pcs', 6.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(617, 'Volume Boost Shampoo', '1', 'pcs', 600.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(618, 'Volume Boost Conditioner', '1', 'pcs', 560.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(619, 'Vlcc di-pigmentation fesial kit', '1', 'pcs', 950.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(620, 'Vlcc anti ten kit', '1', 'pcs', 450.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(621, 'Veg pill pawoder', '1', 'pcs', 140.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(622, 'Vedicline Green Apple Toner', '1', 'pcs', 175.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(623, 'Vedic Line Wine Kit', '1', 'pcs', 40.56, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(624, 'Vedic Line Silver Kit', '1', 'pcs', 320.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(625, 'Vedic Line Polishing Kit', '1', 'pcs', 272.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(626, 'Vedic Line Pearl Kit', '1', 'pcs', 48.89, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(627, 'Vedic Line Morrocon Argan Kit', '1', 'pcs', 160.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(628, 'Vedic Line Gold Kit', '1', 'pcs', 4400.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(629, 'Vedic Line Fruit Kit', '1', 'pcs', 28.89, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(630, 'Vedic Line Diamond Kit', '1', 'pcs', 53.33, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(631, 'Vedic Line Collagen Mask', '1', 'pcs', 350.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(632, 'Vedic Line Chocolate Kit', '1', 'pcs', 105.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(633, 'Vedic Line Bio Whitening Kit', '1', 'pcs', 292.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(634, 'Vedic Line Apple Toner', '1', 'pcs', 175.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(635, 'Vedic Line Acne Kit', '1', 'pcs', 105.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(636, 'Ultra sonic machine', '1', 'pcs', 3500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(637, 'Ultra Make-Up Base Or Under Base', '1', 'pcs', 1200.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(638, 'Treatment-oil', '1', 'pcs', 250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(639, 'Tissue Paper', '1', 'pcs', 0.55, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(640, 'Tibolli Shampoo', '1', 'pcs', 1250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(641, 'Tibolli conditioner', '1', 'pcs', 1250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(642, 'Thread', '1', 'pcs', 375.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(643, 'Thermo Herb Pack', '1', 'pcs', 500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(644, 'Streax Pro-Serum', '1', 'pcs', 260.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(645, 'Ston choti', '1', 'pcs', 250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(646, 'Steam machine skin', '1', 'pcs', 3500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(647, 'Spunj', '1', 'pcs', 125.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(648, 'Special plastic', '1', 'pcs', 570.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(649, 'Spa vitalizer creame', '1', 'pcs', 600.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(650, 'Spa Ampules', '1', 'pcs', 83.33, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(651, 'Smooth Shine Shampoo', '1', 'pcs', 660.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(652, 'Sleek Wax', '1', 'pcs', 210.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(653, 'Skeyndor Sun Expeetise Spf 30', '1', 'pcs', 2830.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(654, 'Skeyndor Skin Care Makeup CC Cream', '1', 'pcs', 3460.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(655, 'Skeyndor Skin Care Makeup BB Cream', '1', 'pcs', 2350.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(656, 'Skeyndor Power Mask', '1', 'pcs', 580.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(657, 'Skeyndor Power Hyaluronic', '1', 'pcs', 4140.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(658, 'Skeyndor Power C+ Serum Iluminador Antioxidante', '1', 'pcs', 3870.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(659, 'Skeyndor Power c+ kit.', '1', 'pcs', 7010.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(660, 'Skeyndor Power C Brightening Cream', '1', 'pcs', 3590.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(661, 'Skeyndor Essential Tonic', '1', 'pcs', 2730.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(662, 'Skeyndor Essential Soft peeling Scrub', '1', 'pcs', 2360.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(663, 'Skeyndor Essential Mask', '1', 'pcs', 4020.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(664, 'Skeyndor Essential Hyd Cream Amino Acids', '1', 'pcs', 2540.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(665, 'Skeyndor Essential Cleansing', '1', 'pcs', 3090.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(666, 'Skeyndor EGlyco 30& enzyme peeling Ampuls', '1', 'pcs', 250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(667, 'Skeyndor Dermapeel Pro fecial kit', '1', 'pcs', 961.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(668, 'Skeyndor Derma Peel Cleansing', '1', 'pcs', 4550.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(669, 'Skeyndor Corrective', '1', 'pcs', 1485.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(670, 'Skeyndor CC Cream', '1', 'pcs', 3460.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(671, 'Skeyndor BB Cream', '1', 'pcs', 2350.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(672, 'Skeyndor Aquatherm Recovery O2 Fecial Kit', '1', 'pcs', 985.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(673, 'Skeyndor Aquatherm Massage Cream', '1', 'pcs', 4160.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(674, 'Skeyndor Aquatherm Concentrate Water', '1', 'pcs', 1170.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(675, 'Skeyndor Aquatherm Cleansing', '1', 'pcs', 1750.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(676, 'Skeyndor Aquatherm Anti -Redness Concentrate', '1', 'pcs', 586.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(677, 'Skeyndoor Power C+', '1', 'pcs', 890.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(678, 'Sindur', '1', 'pcs', 117.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(679, 'Shirodhara Oil', '1', 'pcs', 750.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(680, 'Shimmering Foundation', '1', 'pcs', 1000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(681, 'Shimer Eye-liner silver', '1', 'pcs', 450.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(682, 'Shimer Eye-liner gold', '1', 'pcs', 425.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(683, 'Serie Expert Pro Longer Conditionar', '1', 'pcs', 820.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(684, 'Sensi Balance Shampoo', '1', 'pcs', 575.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(685, 'Section Pin', '1', 'pcs', 12.50, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(686, 'Satin Eye Shade', '1', 'pcs', 500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(687, 'Sara Mould Mask', '1', 'pcs', 1100.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(688, 'Safety Pin', '1', 'pcs', 165.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(689, 'Rose Water', '1', 'pcs', 90.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(690, 'Roller', '1', 'pcs', 180.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(691, 'Rimmel Lipstick Sealer', '1', 'pcs', 300.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(692, 'Reviver Hair Repair Shampoo', '1', 'pcs', 1100.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(693, 'Reviver Hair Repair Conditioner', '1', 'pcs', 1100.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(694, 'Repair Resource Shampoo', '1', 'pcs', 700.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(695, 'Repair Resource Conditioner', '1', 'pcs', 800.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(696, 'Remy Laure Sensitive Skin Powder Mask', '1', 'pcs', 3269.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(697, 'Remy Laure Peeling Cream', '1', 'pcs', 4837.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(698, 'Remy Laure Oil Skin Set', '1', 'pcs', 2220.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(699, 'Remy Laure Natural Brack Mud', '1', 'pcs', 11880.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(700, 'Remy Laure Gommge Exfoliant Scrub', '1', 'pcs', 2365.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(701, 'Remy Laure Eclaircissante Brightening Cream', '1', 'pcs', 9499.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(702, 'Remy Laure D.N.A Tonic lotion', '1', 'pcs', 8535.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(703, 'Remy Laure Creme Demaquillante Adn Cleansing', '1', 'pcs', 8535.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(704, 'Remy Laure Brightening set', '1', 'pcs', 2838.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(705, 'Remy Laure Brightening Peel Of Powder Mask V C', '1', 'pcs', 3600.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(706, 'Remy Laure Brightening Cleansing Foam', '1', 'pcs', 4848.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(707, 'Remy Laure Beauty Lotion', '1', 'pcs', 6447.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(708, 'Remy Laure Baume De Modelage Massage Balm', '1', 'pcs', 10246.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(709, 'Remy Laore Brightening Mask', '1', 'pcs', 5554.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(710, 'Regular Scrub', '1', 'pcs', 300.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(711, 'Regular Massage Cream &gel', '1', 'pcs', 300.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(712, 'Rebonding cream', '1', 'pcs', 1000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(713, 'Razor', '1', 'pcs', 55.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(714, 'Pin Comb', '1', 'pcs', 75.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(715, 'Pedicure Shampoo', '1', 'pcs', 300.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(716, 'Parlour pack Shampoo', '1', 'pcs', 0.75, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(717, 'Parlour pack serum - consum', '1', 'pcs', 185.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(718, 'Parlour pack Conditioner', '1', 'pcs', 0.75, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(719, 'Pack Brush', '1', 'pcs', 70.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(720, 'O3+vitamin -a night repair creame', '1', 'pcs', 830.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(721, 'O3+Night Repair Cream', '1', 'pcs', 955.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(722, 'O3+H.S Face Wash', '1', 'pcs', 195.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(723, 'O3+Dermal Zone Soothing Gel Cream Spf 30', '1', 'pcs', 650.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(724, 'O3+Dermal Zone Meladerm Whitenig Night Cream', '1', 'pcs', 650.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(725, 'O3+Dermal Zone Meladerm Cream Spf 40', '1', 'pcs', 650.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(726, 'O3+Dermal Zone Anti Aging Cream Spf 60', '1', 'pcs', 650.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(727, 'O3+deep concerns 3 hydrating moisture serum', '1', 'pcs', 830.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(728, 'O3+deep concerns 2 pore clean up tonic', '1', 'pcs', 740.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(729, 'O3+Deep Concerns 1 Hydrating Moisture Cleanser', '1', 'pcs', 740.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(730, 'O3+ WHITENING Tonic', '1', 'pcs', 1260.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(731, 'O3+ Whitening Serum', '1', 'pcs', 1475.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(732, 'O3+ Whitening Massage Cream', '1', 'pcs', 2715.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(733, 'O3+ Whitening Mask', '1', 'pcs', 2000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(734, 'O3+ whitening Emulsion', '1', 'pcs', 385.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(735, 'O3+ whitening creame spf 30', '1', 'pcs', 490.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(736, 'O3+ whitening Cleanser', '1', 'pcs', 1450.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(737, 'O3+ Volcano Scrub', '1', 'pcs', 285.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(738, 'O3+ ULTRA SOOTHING FACIAL KIT', '1', 'pcs', 1080.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(739, 'O3+ TIME EXPERT FACIAL KIT', '1', 'pcs', 500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(740, 'O3+ SPF 30', '1', 'pcs', 425.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(741, 'O3+ Soothing Massage Care', '1', 'pcs', 1820.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(742, 'O3+ seaweed serum', '1', 'pcs', 1280.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(743, 'O3+ seaweed purifying tonic', '1', 'pcs', 1450.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(744, 'O3+ seaweed purifying cleansing gel', '1', 'pcs', 1450.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(745, 'O3+ seaweed massage cream', '1', 'pcs', 2000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(746, 'O3+ Seaweed Emulsion', '1', 'pcs', 385.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(747, 'O3+ seawed mask', '1', 'pcs', 2360.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(748, 'O3+ Radiant Whitening SPF 30', '1', 'pcs', 1050.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(749, 'O3+ Power Mask Gel', '1', 'pcs', 294.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(750, 'O3+ POWER BRIGHTENING FACIAL KIT', '1', 'pcs', 450.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(751, 'O3+ Milk Scrub', '1', 'pcs', 280.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(752, 'O3+ Micro Derma Peel', '1', 'pcs', 2100.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(753, 'O3+ meladerm spf 30', '1', 'pcs', 830.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(754, 'O3+ Lightening & Calming face wash', '1', 'pcs', 285.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(755, 'O3+ H.S. Face Wash', '1', 'pcs', 225.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(756, 'O3+ Eye Circle Cream', '1', 'pcs', 445.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(757, 'O3+ Descaling Lotion', '1', 'pcs', 1100.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(758, 'O3+ dermalzone derma clam int cream', '1', 'pcs', 650.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(759, 'O3+ dermal zone zitderm cream', '1', 'pcs', 650.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(760, 'O3+ dermal zone white day cream spf 15', '1', 'pcs', 955.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(761, 'O3+ dermal zone soothing gel cream spf 30', '1', 'pcs', 650.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(762, 'O3+ Derma SPF 40', '1', 'pcs', 750.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(763, 'O3+ Derma Fresh Mask', '1', 'pcs', 285.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(764, 'O3+ Derma Fresh Cream', '1', 'pcs', 385.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(765, 'O3+ deep concerns 3 pore clean up serum', '1', 'pcs', 8676.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(766, 'O3+ Deep Concerns 3 Brighten Up Serum', '1', 'pcs', 830.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(767, 'O3+ Deep Concerns 2 Hydrating Moisture Tonic', '1', 'pcs', 740.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(768, 'O3+ Deep Concerns 2 Brighten Up Tonic', '1', 'pcs', 1058.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(769, 'O3+ deep concerns 1pore clean up', '1', 'pcs', 740.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(770, 'O3+ Deep Concerns 1Brighten Cleanser', '1', 'pcs', 920.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(771, 'O3+ Deep Concerns 1 Pore Clean Cleanser', '1', 'pcs', 920.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(772, 'O3+ B.W. Face Wash', '1', 'pcs', 650.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(773, 'O3+ Ampule', '1', 'pcs', 100.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(774, 'O3+ agelock youth drops', '1', 'pcs', 1840.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(775, 'O3+ AGELOCK SPF 50', '1', 'pcs', 830.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(776, 'O3+ AGELOCK SPF 40', '1', 'pcs', 830.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(777, 'O3+ AGELOCK Meladerm Night Care Cream', '1', 'pcs', 830.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(778, 'O3+ AGELOCK CLARIFYING TREATMENST MASK', '1', 'pcs', 675.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(779, 'O3+ AGELOCK CLARIFYING TREATMENST GEL', '1', 'pcs', 675.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(780, 'O3+ age lock vita moist lotion', '1', 'pcs', 830.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(781, 'O3+ age lock fair moist moisturizing cream', '1', 'pcs', 830.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(782, 'O3+ age lock bossster serum vit c', '1', 'pcs', 1840.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(783, 'O3 + 2 pore clean up tonic', '1', 'pcs', 920.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(784, 'Nose putti', '1', 'pcs', 190.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(785, 'Neck Roll', '1', 'pcs', 125.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(786, 'Nail paint sell', '1', 'pcs', 199.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(787, 'Moisturiser', '1', 'pcs', 310.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(788, 'Mini Spa', '1', 'pcs', 250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(789, 'Micro Silk Powder', '1', 'pcs', 2000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(790, 'Micro Foundation', '1', 'pcs', 2000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(791, 'Matrixnourishing Oil', '1', 'pcs', 125.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(792, 'Matrix Ultra Hydrating Shampoo', '1', 'pcs', 195.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(793, 'Matrix Straightening Conditioner', '1', 'pcs', 850.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(794, 'Matrix scalppure Treatment shampoo', '1', 'pcs', 1075.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(795, 'Matrix scalppure Treatment serum', '1', 'pcs', 460.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(796, 'Matrix scalppure treatment scrub', '1', 'pcs', 108.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(797, 'Matrix scalppure Treatment conditioner', '1', 'pcs', 1275.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(798, 'Matrix repairing shampoo', '1', 'pcs', 300.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(799, 'Matrix repairing conditioner', '1', 'pcs', 250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(800, 'Matrix Opti Serum', '1', 'pcs', 410.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(801, 'Matrix Opti Careconditioner', '1', 'pcs', 240.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(802, 'Matrix Opti Care Shampoo', '1', 'pcs', 325.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(803, 'Matrix Nourishing Oil Shampoo', '1', 'pcs', 190.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(804, 'Matrix Hydra Conditioner', '1', 'pcs', 160.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(805, 'Matrix Hydra Care Shampoo', '1', 'pcs', 195.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(806, 'Matrix fiberstrong Straightening Shampoo', '1', 'pcs', 300.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(807, 'Matrix fiber strong shampoo', '1', 'pcs', 345.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(808, 'Matrix fiber strong conditionar', '1', 'pcs', 280.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(809, 'Matrix deep smoothing shampoo', '1', 'pcs', 220.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(810, 'Matrix Deep Smooth Conditioner', '1', 'pcs', 170.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(811, 'Matrix color shampoo', '1', 'pcs', 755.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(812, 'Matrix Color Care Conditioner', '1', 'pcs', 170.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(813, 'Matrix black dazzling shine shampoo', '1', 'pcs', 290.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(814, 'Matrix black dazzling shine serum', '1', 'pcs', 410.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(815, 'Matrix black dazzling shine conditioner', '1', 'pcs', 1020.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(816, 'Matrix Biolage strengthening cream', '1', 'pcs', 380.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(817, 'MATRIX BIOLAGE SMOOTHNING SERUM', '1', 'pcs', 295.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(818, 'Matrix Biolage Scalppure Shampo', '1', 'pcs', 345.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(819, 'Matrix biolage scalppure serum', '1', 'pcs', 460.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(820, 'Matrix Biolage Scalppure Conditioner', '1', 'pcs', 290.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(821, 'Maskara', '1', 'pcs', 200.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(822, 'Make-Up Sponge', '1', 'pcs', 70.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(823, 'Make-Up Fixer', '1', 'pcs', 450.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(824, 'Makeup base gold Primer', '1', 'pcs', 650.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(825, 'Machune infra red', '1', 'pcs', 3500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(826, 'Machine wax heater', '1', 'pcs', 1500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(827, 'Machine tong rod', '1', 'pcs', 2500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(828, 'Machine stylizer', '1', 'pcs', 2500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(829, 'Machine skin analyze', '1', 'pcs', 3500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(830, 'Machine pree meter', '1', 'pcs', 1000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(831, 'Machine pen drive', '1', 'pcs', 500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(832, 'Machine pedicure', '1', 'pcs', 2000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(833, 'Machine ironing', '1', 'pcs', 2500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(834, 'Machine hot roller', '1', 'pcs', 2500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(835, 'Machine hood drier', '1', 'pcs', 3500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(836, 'Machine high frequency', '1', 'pcs', 2500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(837, 'Machine hamza', '1', 'pcs', 2000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(838, 'Machine hair steam', '1', 'pcs', 3500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(839, 'Machine galvanic', '1', 'pcs', 2500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(840, 'Machine drier', '1', 'pcs', 1800.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(841, 'Machine child cilipar', '1', 'pcs', 1000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(842, 'Machine body massager', '1', 'pcs', 3600.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(843, 'Machin hair climpar', '1', 'pcs', 1500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(844, 'Lotus Whitening Brightening Polisher', '1', 'pcs', 355.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(845, 'Lotus whitening brightening night cream', '1', 'pcs', 485.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(846, 'Lotus Whitening Brightening Kit', '1', 'pcs', 1185.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(847, 'Lotus Whitening Brightening Face Wash', '1', 'pcs', 495.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(848, 'Lotus Whitening Brightening Cream 25', '1', 'pcs', 665.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(849, 'Lotus Ultimo platinum Kit', '1', 'pcs', 1058.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(850, 'Lotus Ultimo Pearl Kit', '1', 'pcs', 898.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(851, 'Lotus Ultimo Gold Kit', '1', 'pcs', 998.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(852, 'Lotus Toner', '1', 'pcs', 495.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(853, 'Lotus SPF60', '1', 'pcs', 645.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(854, 'Lotus SPF 80', '1', 'pcs', 845.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(855, 'Lotus SPF 70', '1', 'pcs', 945.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(856, 'Lotus SPF 50', '1', 'pcs', 795.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(857, 'Lotus SPF 30', '1', 'pcs', 495.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(858, 'Lotus SPF 100', '1', 'pcs', 895.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(859, 'Lotus Skin Brightening Exfloliator', '1', 'pcs', 295.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(860, 'Lotus Skin Brightening Essence', '1', 'pcs', 495.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(861, 'Lotus Retemin Serum', '1', 'pcs', 895.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(862, 'Lotus Retemin Plant Retinol Vitamin -C Face oil', '1', 'pcs', 825.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(863, 'Lotus Retemin Plant Retinol + Night Cream', '1', 'pcs', 695.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(864, 'Lotus Retemin Plant Retinol + Boost Cream', '1', 'pcs', 695.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(865, 'Lotus Retemin Face Wash Plant Retinol +', '1', 'pcs', 475.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(866, 'Lotus Rejuvina Lotion', '1', 'pcs', 545.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(867, 'Lotus Rejuvina Kit', '1', 'pcs', 249.16, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(868, 'Lotus Rejuvina Herbcomplex Protective Lotion', '1', 'pcs', 545.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(869, 'Lotus puravitals toner', '1', 'pcs', 445.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(870, 'Lotus Puravitals Massage Gel', '1', 'pcs', 495.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(871, 'Lotus puravitals invigoraating cleanser', '1', 'pcs', 495.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(872, 'Lotus puravitals exfoliating gel', '1', 'pcs', 495.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(873, 'Lotus Preservita All kit', '1', 'pcs', 399.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(874, 'Lotus platinum moisturiser spf 25', '1', 'pcs', 995.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(875, 'Lotus Pigmentone Facial Kit', '1', 'pcs', 249.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(876, 'Lotus Pedicure & Manicure Foot Scrub', '1', 'pcs', 495.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(877, 'Lotus pedicure & Manicure Foot Moisturiser', '1', 'pcs', 445.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(878, 'Lotus Pedicure & Manicure Foot Massage Cream', '1', 'pcs', 495.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(879, 'Lotus Pedicure & Manicure Foot Cream Mask', '1', 'pcs', 445.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(880, 'Lotus Pedicure & Manicure Foot Bath Cleanser', '1', 'pcs', 345.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(881, 'Lotus pearl whitening moisturiser spf 25', '1', 'pcs', 795.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(882, 'Lotus Nourishing Creme Face Wash', '1', 'pcs', 395.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(883, 'Lotus Mask', '1', 'pcs', 695.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(884, 'Lotus japaness Whitening Creme', '1', 'pcs', 845.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(885, 'Lotus intense repair hand and food creme spf 25', '1', 'pcs', 395.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(886, 'Lotus Insta Fair Facial Kit', '1', 'pcs', 299.17, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(887, 'Lotus Hydravitals Toner', '1', 'pcs', 445.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(888, 'Lotus Hydravitals Scrub', '1', 'pcs', 545.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(889, 'Lotus Hydravitals Massage Cream', '1', 'pcs', 695.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(890, 'Lotus Hydravitals Cleanser', '1', 'pcs', 495.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(891, 'Lotus Hydra Nourishing Facial Kit', '1', 'pcs', 1095.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(892, 'Lotus Green Tea Mask', '1', 'pcs', 245.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(893, 'Lotus Gold Sheen Facial Kit', '1', 'pcs', 332.50, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(894, 'Lotus gold radiance moisturiser spf 25', '1', 'pcs', 895.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(895, 'Lotus Glowdermic Facial Kit', '1', 'pcs', 249.17, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(896, 'Lotus Gel Creme SPF 20', '1', 'pcs', 595.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(897, 'Lotus Eye Cream1', '1', 'pcs', 395.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(898, 'Lotus dermo spa Japanese Sakura Face wash', '1', 'pcs', 445.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(899, 'Lotus Dermo Japanese Sakura Skin Whitning Illuminating Cream', '1', 'pcs', 865.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(900, 'Lotus Dermo Bulgrian Rose Glow Brighterning face wash', '1', 'pcs', 445.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(901, 'Lotus Derma Spa Brazilian Night Cream', '1', 'pcs', 985.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(902, 'Lotus Derma Spa Brazilian FACE WASH', '1', 'pcs', 445.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(903, 'Lotus Derma Spa Brazilian Cream SPF-20', '1', 'pcs', 945.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(904, 'Lotus Deep Pore Face Wash', '1', 'pcs', 375.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(905, 'Lotus Deep Moisturising Cream', '1', 'pcs', 665.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(906, 'Lotus Daily Deep Cleansing Face Wash', '1', 'pcs', 440.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(907, 'Lotus Crystal Spa - Pedicure & Manicure', '1', 'pcs', 246.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(908, 'Lotus Clarifying Pimples & Acne Creme', '1', 'pcs', 395.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(909, 'Lotus brighting whitening serum', '1', 'pcs', 675.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(910, 'Lotus bodysheen body polishing', '1', 'pcs', 582.50, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(911, 'Lotus Anti- Blemish Cream', '1', 'pcs', 695.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(912, 'Lotus anti aging serum', '1', 'pcs', 945.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(913, 'Lotus anti aging scrub', '1', 'pcs', 375.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(914, 'Lotus anti aging night cream', '1', 'pcs', 945.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(915, 'Lotus anti aging face wash', '1', 'pcs', 495.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(916, 'Lotus Anti Aging Day Cream - Spf 25', '1', 'pcs', 845.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(917, 'Lotus Anti- Aging', '1', 'pcs', 895.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(918, 'Lotus Acnex Facial Kit', '1', 'pcs', 249.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(919, 'Lotus 4 Layer Anti Ageing Kit', '1', 'pcs', 382.50, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(920, 'Lotus 4 Layer Adv whitening kit', '1', 'pcs', 332.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(921, 'Lotus 360 Eye Treatment Kit', '1', 'pcs', 249.16, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(922, 'Loreal X-Tenso care Shampoo', '1', 'pcs', 610.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(923, 'Loreal X-Tenso care serum', '1', 'pcs', 630.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(924, 'Loreal X-Tenso Care Pre Treatment', '1', 'pcs', 1800.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(925, 'Loreal X Tenso Treatment mask -consum', '1', 'pcs', 1000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(926, 'Loreal X Tenso care mask', '1', 'pcs', 720.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(927, 'Loreal x - Tensho Care Treatment Shampoo', '1', 'pcs', 610.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(928, 'Loreal Volumentary Shampoo', '1', 'pcs', 575.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(929, 'Loreal Volumentary Conditioner', '1', 'pcs', 675.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(930, 'Loreal Volume Expand', '1', 'pcs', 500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(931, 'Loreal Vitamino shampoo', '1', 'pcs', 695.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(932, 'Loreal vitamino mask', '1', 'pcs', 860.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(933, 'Loreal vitamino color treatment shampoo', '1', 'pcs', 1600.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(934, 'Loreal Vitamino Color Teatment Mask', '1', 'pcs', 860.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(935, 'Loreal Vitamino Color Combo', '1', 'pcs', 575.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(936, 'Loreal Treatment Nutrifier Shampoo', '1', 'pcs', 1565.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(937, 'Loreal Treatment Nutrifier -Mask', '1', 'pcs', 780.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(938, 'Loreal Treatment Mythic Shampoo', '1', 'pcs', 900.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(939, 'Loreal treatment mythic oil', '1', 'pcs', 950.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(940, 'Loreal Treatment Mythic Mask', '1', 'pcs', 980.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(941, 'Loreal Tecni Art Serum', '1', 'pcs', 550.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(942, 'Loreal smooth revival shampoo', '1', 'pcs', 400.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(943, 'Loreal smooth revival conditiner', '1', 'pcs', 380.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(944, 'Loreal smooth revival combo pack', '1', 'pcs', 700.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(945, 'Loreal Smartbond Treatment Step 2 - Pre Shampoo', '1', 'pcs', 3000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(946, 'Loreal Smartbond Treatment Step 1 - Additive', '1', 'pcs', 3000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(947, 'Loreal Serioxyl Treatment Denser - Consum', '1', 'pcs', 3600.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(948, 'Loreal Serioxyl Shampoo sep 1', '1', 'pcs', 950.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(949, 'Loreal Serioxyl Glycolic treatment Acid', '1', 'pcs', 133.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(950, 'Loreal Serioxyl Glucoboost incell Treatment conditioner 2-consumable', '1', 'pcs', 1600.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(951, 'Loreal Serioxyl Denser', '1', 'pcs', 3600.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(952, 'Loreal Serioxyl conditioner step 2', '1', 'pcs', 950.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(953, 'Loreal Serioxly gluco boost Treatment shampoo 1 -consumable', '1', 'pcs', 1600.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(954, 'Loreal Serie expert Pro Longer Shampoo', '1', 'pcs', 695.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(955, 'Loreal Serie expert Pro Longer Masc', '1', 'pcs', 860.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(956, 'Loreal Serie expert Pro longer creme', '1', 'pcs', 550.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(957, 'Loreal sensi balance shampoo', '1', 'pcs', 575.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(958, 'Loreal pure resource shampoo', '1', 'pcs', 575.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(959, 'Loreal Primer Repair Lipidium', '1', 'pcs', 133.30, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(960, 'Loreal Powermix Repair Lipidium Additive', '1', 'pcs', 900.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(961, 'Loreal Powermix nutrifier treatment', '1', 'pcs', 870.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(962, 'Loreal Powermix Base', '1', 'pcs', 1100.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(963, 'Loreal power repair lipidium', '1', 'pcs', 106.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(964, 'Loreal Power Mix Liss Prokeratin Treatment', '1', 'pcs', 100.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(965, 'Loreal Power MiX Force Treatment', '1', 'pcs', 900.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(966, 'Loreal Power Mix Color Treatment', '1', 'pcs', 835.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(967, 'Loreal Power Kera-Recharge', '1', 'pcs', 106.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(968, 'Loreal Perm Treatment Neutriliser', '1', 'pcs', 200.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(969, 'Loreal Perm Treatment Lotion', '1', 'pcs', 200.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(970, 'Loreal oxydant', '1', 'pcs', 650.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(971, 'Loreal Nutrifier -Shampoo', '1', 'pcs', 665.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(972, 'Loreal Nutrifier -Mask', '1', 'pcs', 780.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(973, 'Loreal mythic rich oil', '1', 'pcs', 1050.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(974, 'Loreal Mythic Oil Treatment Emulsion', '1', 'pcs', 1200.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(975, 'Loreal mythic oil shampoo', '1', 'pcs', 900.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(976, 'Loreal Mythic oil Mask', '1', 'pcs', 950.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(977, 'Loreal mythic color glow oil', '1', 'pcs', 1100.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(978, 'Loreal Metal Dx Shampoo', '1', 'pcs', 1200.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(979, 'Loreal Metal Dx Mask', '1', 'pcs', 1400.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(980, 'Loreal Liss Unlimited Treatment Shampoo', '1', 'pcs', 1600.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(981, 'Loreal Liss Unlimited Treatment Mask', '1', 'pcs', 1000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(982, 'Loreal Liss Ultima Shampoo', '1', 'pcs', 650.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(983, 'Loreal Liss Ultima Serum', '1', 'pcs', 710.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(984, 'Loreal Liss Ultima Mask', '1', 'pcs', 675.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(985, 'Loreal Instant Clear Treatment Shampoo', '1', 'pcs', 1600.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(986, 'Loreal Instant Clear Shampoo', '1', 'pcs', 695.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(987, 'Loreal Instant clear', '1', 'pcs', 695.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(988, 'Loreal Inner Spa Treatment Ampuls', '1', 'pcs', 186.67, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(989, 'Loreal Inforcer Tretment Shampoo', '1', 'pcs', 1600.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(990, 'Loreal Inforcer Tretment Mask', '1', 'pcs', 1015.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(991, 'Loreal Inforcer Shampoo', '1', 'pcs', 695.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(992, 'Loreal Inforcer Masque', '1', 'pcs', 860.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(993, 'Loreal Hair Spa Oil', '1', 'pcs', 250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(994, 'Loreal Hair Spa Detox Shampo', '1', 'pcs', 399.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(995, 'Loreal Hair Spa Detox Conitioner', '1', 'pcs', 400.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(996, 'Loreal hair spa Deep Nourishing Shampoo', '1', 'pcs', 399.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(997, 'Loreal hair spa Deep Nourishing Conditionar', '1', 'pcs', 399.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(998, 'Loreal Force Vector Shampoo', '1', 'pcs', 635.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(999, 'Loreal Force Vector Mask', '1', 'pcs', 675.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1000, 'Loreal Detoxifying Treatment Shampoo', '1', 'pcs', 1500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1001, 'Loreal Detoxifying Scalp Clay Ampuls', '1', 'pcs', 162.50, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1002, 'Loreal Density Advance Shampoo', '1', 'pcs', 635.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1003, 'Loreal deep nourishing dua', '1', 'pcs', 700.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1004, 'Loreal Aminexil Advance Treatment Ampule', '1', 'pcs', 145.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1005, 'Loreal aminexil advance ampuls', '1', 'pcs', 1950.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1006, 'Loreal Absolute Repair Shampoo', '1', 'pcs', 695.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1007, 'Loreal Absolute Repair Serum', '1', 'pcs', 1200.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1008, 'Loreal Absolute Repair Mask', '1', 'pcs', 860.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1009, 'Loreal Absolute Repair lipidiumTreatment Mask', '1', 'pcs', 860.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1010, 'Loreal Absolut Repair Lipidium Treatment Shampoo', '1', 'pcs', 1600.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1011, 'Loral Nutrifiler Levinbalm', '1', 'pcs', 575.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1012, 'Lip pencil sell', '1', 'pcs', 60.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1013, 'Lip Color', '1', 'pcs', 750.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1014, 'Lip Balm', '1', 'pcs', 250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1015, 'Kryolan Ultra Make Up Base', '1', 'pcs', 1300.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1016, 'Kryolan Tl Powerd', '1', 'pcs', 550.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1017, 'Kryolan Satin Powder', '1', 'pcs', 300.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1018, 'Kryolan Live-in Color Pigment', '1', 'pcs', 300.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1019, 'Kryolan Lip Pallet', '1', 'pcs', 2000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1020, 'Kryolan glamour sparks', '1', 'pcs', 450.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1021, 'KRYOLAN Eye Liner', '1', 'pcs', 700.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1022, 'Krylon Primer', '1', 'pcs', 1650.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1023, 'Keratin treatment shampoo', '1', 'pcs', 2800.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1024, 'Keratin treatment', '1', 'pcs', 3200.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1025, 'Keratin pure deep cleansing shampoo', '1', 'pcs', 1400.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1026, 'Keratin Kerafusion treatment', '1', 'pcs', 18000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1027, 'Keratin Acai Oil', '1', 'pcs', 2500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1028, 'Kenpeki Kouyou Solal Protect 40', '1', 'pcs', 680.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1029, 'Jooda pin', '1', 'pcs', 250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1030, 'Jennot Hydratung Cleansing Milk', '1', 'pcs', 1250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1031, 'Jeannot Ultra Soothing Mask', '1', 'pcs', 1090.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1032, 'Jeannot Skin Purifying Foam', '1', 'pcs', 1190.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1033, 'Jeannot Skin Brightening Cream SPF20', '1', 'pcs', 1310.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1034, 'Jeannot Revitalizing whitening serum', '1', 'pcs', 1950.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1035, 'Jeannot Renewal radiance mask', '1', 'pcs', 1090.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1036, 'Jeannot Radiance Whitning Cream SPF30', '1', 'pcs', 1350.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL);
INSERT INTO `product` (`id`, `product`, `volume`, `unit`, `mrp`, `barcode`, `reward_point_on_purchase`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1037, 'Jeannot Radiance Glow Tonic', '1', 'pcs', 1190.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1038, 'Jeannot Pro-collagen firming cream SPF20', '1', 'pcs', 1310.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1039, 'Jeannot Pro-collagen Concentrate Serum', '1', 'pcs', 1690.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1040, 'Jeannot Micellar Water 5 in 1', '1', 'pcs', 1150.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1041, 'Jeannot Intence Renewal Brightening Serum', '1', 'pcs', 1890.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1042, 'Jeannot Instant Hydrating Cream', '1', 'pcs', 1290.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1043, 'Jeannot Deep Whitening Detox Mask', '1', 'pcs', 1150.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1044, 'Jeannot Cellular Repair Night Cream', '1', 'pcs', 1340.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1045, 'Jeannot Anti-pollution Calming Mist', '1', 'pcs', 1050.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1046, 'Invisible Pin', '1', 'pcs', 140.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1047, 'Inrich Shampoo', '1', 'pcs', 1130.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1048, 'Inrich mask', '1', 'pcs', 1120.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1049, 'Inrich Ampuls', '1', 'pcs', 720.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1050, 'Indola Repair Conditioner', '1', 'pcs', 149.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1051, 'Indola Hyadrate Shampoo', '1', 'pcs', 149.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1052, 'Indola Color Shampoo', '1', 'pcs', 149.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1053, 'Indola Color Conditioner', '1', 'pcs', 149.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1054, 'Hydrofuse under eye cream', '1', 'pcs', 795.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1055, 'Hydro Pack Shade', '1', 'pcs', 18.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1056, 'Henna', '1', 'pcs', 60.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1057, 'Head Patti', '1', 'pcs', 175.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1058, 'HD Sparkle Eye liner', '1', 'pcs', 500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1059, 'Hand Gloves', '1', 'pcs', 3.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1060, 'Hair Spa Sampoo(Consumable)', '1', 'pcs', 1465.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1061, 'Hair Spa', '1', 'pcs', 650.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1062, 'Hair setting brush', '1', 'pcs', 140.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1063, 'Hair Puff', '1', 'pcs', 100.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1064, 'Hair Mousse Or Hair Spray', '1', 'pcs', 188.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1065, 'Hair Gel', '1', 'pcs', 120.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1066, 'Hair Extension - Streaks', '1', 'pcs', 399.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1067, 'Hair Extension', '1', 'pcs', 850.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1068, 'Hair Dummy', '1', 'pcs', 450.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1069, 'Hair Color', '1', 'pcs', 310.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1070, 'Hair Clutcher', '1', 'pcs', 60.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1071, 'Hair Blonder', '1', 'pcs', 1250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1072, 'GP SHINE SPRAY', '1', 'pcs', 425.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1073, 'GP REPAIR SHAMPOO', '1', 'pcs', 990.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1074, 'GP REPAIR MASK', '1', 'pcs', 1050.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1075, 'GP RECHARGE SHAMPOO', '1', 'pcs', 990.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1076, 'GP RECHARGE CONDITIONER', '1', 'pcs', 990.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1077, 'GP QUINOA SMOOTH MASK', '1', 'pcs', 250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1078, 'GP QUINOA SHAMPOO', '1', 'pcs', 350.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1079, 'GP PROTECT SHINE SERUM', '1', 'pcs', 325.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1080, 'GP NOURISH SHINE OIL', '1', 'pcs', 990.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1081, 'GP KERATINRICH SHAMPOO', '1', 'pcs', 350.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1082, 'GP KERATINRICH MASK', '1', 'pcs', 250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1083, 'GP HONEY MOISTURE SHAMPOO', '1', 'pcs', 350.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1084, 'GP HONEY MASK', '1', 'pcs', 250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1085, 'GP AVOCADO SHAMPOO', '1', 'pcs', 350.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1086, 'GP AVOCADO MASK', '1', 'pcs', 250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1087, 'GP ACAI OIL', '1', 'pcs', 1050.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1088, 'GK.Conditioner', '1', 'pcs', 1500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1089, 'GK. Serum', '1', 'pcs', 1900.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1090, 'Gk Serum 50Mi', '1', 'pcs', 1900.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1091, 'GK Sampoo', '1', 'pcs', 1500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1092, 'Gk Moisturizing Shampoo 300 Ml', '1', 'pcs', 1800.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1093, 'General Pack', '1', 'pcs', 250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1094, 'G.K. hair taming serum', '1', 'pcs', 1650.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1095, 'G.K Taming system shampoo (sell)', '1', 'pcs', 1800.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1096, 'G.K Taming system conditioner sell', '1', 'pcs', 1200.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1097, 'G.K Hair Taming System1Ph+Shampoo -consumable', '1', 'pcs', 2200.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1098, 'G.K Hair Taming System 2 Resistant -consumable', '1', 'pcs', 24279.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1099, 'G.K Deep Conditioner Masque Hydratant (Consumable)', '1', 'pcs', 2450.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1100, 'G.K Color Protection 4 Conditioner -consumable', '1', 'pcs', 2900.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1101, 'G.K Color Protection 3 Shampoo -consumable', '1', 'pcs', 2900.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1102, 'Fushion shampoo', '1', 'pcs', 1500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1103, 'Fushion Refiller', '1', 'pcs', 1387.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1104, 'Fushion mask', '1', 'pcs', 1500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1105, 'Foundation', '1', 'pcs', 74.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1106, 'Forever - Relaxation Shower Gel', '1', 'pcs', 1596.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1107, 'Forever - Relaxation Massage Lotion', '1', 'pcs', 1808.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1108, 'Foil Paper', '1', 'pcs', 450.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1109, 'Flat Brush', '1', 'pcs', 380.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1110, 'Figaro Oil', '1', 'pcs', 495.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1111, 'Fairness kit', '1', 'pcs', 299.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1112, 'Facial Wipes- Wet', '1', 'pcs', 1.46, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1113, 'Facial - tray', '1', 'pcs', 90.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1114, 'Face Mask', '1', 'pcs', 15.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1115, 'Eye Shadow Pallet', '1', 'pcs', 2000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1116, 'Eye Shadow Base', '1', 'pcs', 1500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1117, 'Eye liner', '1', 'pcs', 75.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1118, 'Eye lashes', '1', 'pcs', 150.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1119, 'Eye lash Gum', '1', 'pcs', 60.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1120, 'Elements', '1', 'pcs', 1261.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1121, 'Element Shampoo', '1', 'pcs', 1800.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1122, 'Element mask', '1', 'pcs', 1850.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1123, 'Ear buds', '1', 'pcs', 180.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1124, 'Disposable Bed Sheet', '1', 'pcs', 9.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1125, 'Dip & Twist', '1', 'pcs', 100.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1126, 'Dermo Spa Japanese Whitening FW', '1', 'pcs', 475.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1127, 'Dermo Spa Japanese Whitening Facial Kit', '1', 'pcs', 758.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1128, 'Dermo Spa Japanese Night Cream', '1', 'pcs', 845.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1129, 'Dermo Spa Japanese Day Cream', '1', 'pcs', 845.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1130, 'Dermo Spa Bulgarian Rose FW', '1', 'pcs', 445.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1131, 'Dermo Spa Bulgarian Rose Facial kit', '1', 'pcs', 700.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1132, 'Dermo Spa Bulgarian Rose Day Cream', '1', 'pcs', 895.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1133, 'Dermo Spa Bulgarian Night Cream', '1', 'pcs', 775.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1134, 'Dermo Spa Brazillian Night Cream', '1', 'pcs', 895.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1135, 'Dermo Spa Brazillian FW', '1', 'pcs', 445.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1136, 'Dermo Spa Brazillian Facial Kit', '1', 'pcs', 700.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1137, 'Dermo Spa Brazillian Day Cream', '1', 'pcs', 845.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1138, 'Density Advance@', '1', 'pcs', 635.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1139, 'Cutting Sheet', '1', 'pcs', 250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1140, 'Cutting Scissor', '1', 'pcs', 500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1141, 'Cutting Comb', '1', 'pcs', 60.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1142, 'Cutting Bag', '1', 'pcs', 600.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1143, 'Cuticle Cream', '1', 'pcs', 200.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1144, 'Cotton Gown', '1', 'pcs', 200.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1145, 'Cotton', '1', 'pcs', 115.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1146, 'Concealer', '1', 'pcs', 450.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1147, 'Colour Protection Cap', '1', 'pcs', 165.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1148, 'Colorbar Primer', '1', 'pcs', 825.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1149, 'Color Brush', '1', 'pcs', 50.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1150, 'Color Bar Lip Pencil', '1', 'pcs', 100.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1151, 'Cleansing Milk', '1', 'pcs', 112.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1152, 'Choti', '1', 'pcs', 45.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1153, 'Cheryls Heel Peel', '1', 'pcs', 350.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1154, 'Brillare style care shampoo', '1', 'pcs', 545.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1155, 'Brillare soft smooth shine serum', '1', 'pcs', 290.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1156, 'Brillare intenso style care conditioning', '1', 'pcs', 425.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1157, 'Brillare intenso heavy moisturising conditioning', '1', 'pcs', 225.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1158, 'Brillare Intenso Hair Fall Conditioner', '1', 'pcs', 225.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1159, 'Brillare intenso dandruff control conditioning', '1', 'pcs', 225.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1160, 'Brillare heavy moisturising shampoo', '1', 'pcs', 190.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1161, 'Brillare hair fall control shampoo', '1', 'pcs', 350.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1162, 'Brillare dandruff control shampoo', '1', 'pcs', 350.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1163, 'Brillance Shampoo', '1', 'pcs', 1050.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1164, 'Brillance mask', '1', 'pcs', 1000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1165, 'Bridal Bindi', '1', 'pcs', 50.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1166, 'Bowl', '1', 'pcs', 70.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1167, 'Body shampoo', '1', 'pcs', 500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1168, 'Bob Pin', '1', 'pcs', 250.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1169, 'Bleach-Dtan', '1', 'pcs', 300.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1170, 'Black Head Pin', '1', 'pcs', 7.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1171, 'Base pallete', '1', 'pcs', 1500.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1172, 'Base', '1', 'pcs', 450.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1173, 'Banana Bun', '1', 'pcs', 7.50, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1174, 'Ballsar Pallet', '1', 'pcs', 1000.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1175, 'Astrigent & rose water', '1', 'pcs', 90.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1176, 'Aroma oil', '1', 'pcs', 345.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1177, 'Aroma Almond Moisturising Lotion', '1', 'pcs', 290.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1178, 'Actone & nail remover', '1', 'pcs', 120.00, NULL, '10', 1, '2022-11-16 18:20:34', NULL, NULL, NULL),
(1179, 'Aroma Manicure', '100', 'pkt', 200.00, '', '10', 1, '2022-12-21 18:14:16', NULL, NULL, NULL),
(1180, 'VLCC Manicure', '10', 'pkt', 1000.00, '10', '10', 1, '2023-01-30 13:12:40', NULL, '2023-02-10 15:41:32', NULL),
(1181, 'Loreal Spa', '10', 'l', 450.00, '', '10', 1, '2023-01-30 13:13:42', NULL, '2023-02-10 15:40:18', NULL),
(1182, 'Vampire Facial', '1', 'pkt', 5000.00, '', '50', 1, '2023-03-18 17:18:09', NULL, NULL, NULL),
(1183, 'VP Facial', '1', 'l', 1000.00, '', '', 1, '2023-03-18 17:25:24', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_use_in_salon`
--

CREATE TABLE `product_use_in_salon` (
  `id` int(11) NOT NULL,
  `salon_product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `service_provider_id` int(11) NOT NULL,
  `remark` tinytext DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_use_in_salon_stock_record`
--

CREATE TABLE `product_use_in_salon_stock_record` (
  `id` int(11) NOT NULL,
  `product_use_in_salon_id` int(11) NOT NULL,
  `stock_record_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_history`
--

CREATE TABLE `purchase_history` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `invoice` varchar(100) DEFAULT NULL,
  `amount_payable` decimal(10,2) DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `payment_mode` varchar(100) DEFAULT NULL,
  `amount_pending` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reward_point`
--

CREATE TABLE `reward_point` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `date` varchar(50) NOT NULL,
  `app_bill_id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `points` varchar(50) NOT NULL,
  `transaction_type` varchar(15) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `self_assessment_data`
--

CREATE TABLE `self_assessment_data` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `affected_countries_last` varchar(5) NOT NULL COMMENT 'Have you been to one of the COVID-19 affected countries in the last 14 days?',
  `confirmed_case_coronavirus` varchar(5) NOT NULL COMMENT 'Have you been in close contact with a confirmed case of coronavirus?',
  `experiencing_symptoms` varchar(5) NOT NULL COMMENT 'Are you currently experiencing symptoms (cough, shortness of breath, fever)',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `self_assessment_data`
--

INSERT INTO `self_assessment_data` (`id`, `name`, `email`, `mobile`, `address`, `affected_countries_last`, `confirmed_case_coronavirus`, `experiencing_symptoms`, `created_at`, `created_by`) VALUES
(1, 'ss', 'ss@ss.com', '9999999999', 'ssss', 'No', 'No', 'No', '2023-03-27 17:08:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `service_name` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `membership_price` decimal(10,2) NOT NULL,
  `duration` varchar(10) NOT NULL,
  `reward_point` int(11) NOT NULL,
  `service_for` tinyint(4) NOT NULL,
  `hide_on_website` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `category_id`, `service_name`, `price`, `membership_price`, `duration`, `reward_point`, `service_for`, `hide_on_website`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(9, 3, 'Adance hair cut', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, '2023-01-16 00:32:40', NULL),
(10, 3, 'Anti-agening', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(11, 3, 'Aroma oil massage', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(12, 3, 'Back massage', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(13, 3, 'Back tan removal', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(14, 3, 'Beard colouring', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(15, 3, 'Beard styling', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(16, 3, 'Berry mask', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(17, 3, 'Body polishing', 4500.00, 4500.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(18, 3, 'Body spa', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(19, 3, 'Charcol mask (black)', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(20, 3, 'Clean & clear facial', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, '2023-01-30 00:24:44', NULL),
(21, 3, 'Cleanup facial', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(22, 3, 'Clear dose', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(23, 3, 'Crack peel pedicure', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(24, 3, 'Crazy shades', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(25, 3, 'Creative cut', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(26, 3, 'Creative hair cut', 1200.00, 1200.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(27, 3, 'Customer product', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(28, 3, 'Derma lite facial', 3700.00, 3700.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(29, 3, 'Dip shades', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(30, 3, 'Enzyme facial', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(31, 3, 'Express colouring', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(32, 3, 'Express facial', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(33, 3, 'Extra foils', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(34, 3, 'Face massage', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(35, 3, 'Face tan removal', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(36, 3, 'Foot logix pedicure', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(37, 3, 'Foot massage', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(38, 3, 'Frinches cut', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(39, 3, 'Full hands tan removal', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(40, 3, 'Full legs tan removal', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(41, 3, 'Gelly manicure', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(42, 3, 'Gelly pedicure', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(43, 3, 'Glow vite facial', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(44, 3, 'Gogi mask (young &amp; tighter)', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(45, 3, 'Gold mask (glow &amp; moisture)', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(46, 3, 'Green mask (revitalize)', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(47, 3, 'Green tea mask (instant glow)', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(48, 3, 'Hair colour loreal', 900.00, 900.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(49, 3, 'Hair cut', 350.00, 350.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(50, 3, 'Hair highlights (4 foils)', 1200.00, 1200.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(51, 3, 'Haircut normal', 530.00, 530.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(52, 3, 'Half hands tan removal', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(53, 3, 'Half legs tan removal', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(54, 3, 'Hand massage', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(55, 3, 'Hand polishing', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(56, 3, 'Honey aromatic facial', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(57, 3, 'Inner spa ( dandruff)', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(58, 3, 'Kids advance cut', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(59, 3, 'Kids cut (below 5 yrs)', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(60, 3, 'Leg massage', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(61, 3, 'Leg polishing', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(62, 3, 'Lipidium hair spa', 850.00, 850.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(63, 3, 'Loreal ammonia free', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(64, 3, 'Loreal ammonia free customer product', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(65, 3, 'Loreal ammonia free global colour', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(66, 3, 'Loreal ammonia free part colour', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(67, 3, 'Loreal ammonia free root touch up', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(68, 3, 'Loreal fashion shade', 3000.00, 3000.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(69, 3, 'Loreal global colour', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(70, 3, 'Loreal hair spa', 850.00, 850.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(71, 3, 'Loreal hair streak', 800.00, 800.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(72, 3, 'Loreal part colour', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(73, 3, 'Loreal root touch up', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(74, 3, 'Luxury manicure', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(75, 3, 'Luxury pedicure', 2500.00, 2500.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(76, 3, 'Mustache colouring', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(77, 3, 'Neck tan removal', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(78, 3, 'Normal colouring global colour', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(79, 3, 'Normal colouring part colour', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(80, 3, 'Normal colouring root touch up', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(81, 3, 'Oil massage', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(82, 3, 'Organic manicure', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(83, 3, 'Organic pedicure', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(84, 3, 'Oxy blast facial', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(85, 3, 'Paraffin manicure', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(86, 3, 'Paraffin pedicure', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(87, 3, 'Part colouring', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(88, 3, 'Photo facial', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(89, 3, 'Pimple treatment', 1500.00, 1500.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(90, 3, 'Promelanim facial', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(91, 3, 'Scalp scrub (itchy scalp)', 700.00, 700.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(92, 3, 'Sensi glow facial', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(93, 3, 'Signature bridal facial', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(94, 3, 'Signature hydradew facial', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(95, 3, 'Signature mixed facial', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(96, 3, 'Signature organic facial', 4150.00, 4150.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(97, 3, 'Signature platinum facial', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(98, 3, 'Signature sea secret facial', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(99, 3, 'Skin peeling', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(100, 3, 'Spa manicure', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(101, 3, 'Spa oil massage', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(102, 3, 'Spa pedicure', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(103, 3, 'Tan clear facial', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(104, 3, 'Trimming', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(105, 3, 'Tux blouse', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(106, 3, 'Under eye', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(107, 3, 'Vegetable mask (lightening)', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(108, 3, 'Wash &amp; blow dry', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, NULL, NULL),
(109, 3, 'Wats removal', 300.00, 300.00, '15', 10, 1, 0, 1, '2022-09-02 11:39:01', NULL, '2022-12-09 15:38:57', NULL),
(114, 35, 'Aroma Manicure', 300.00, 300.00, '30', 10, 3, 0, 1, '2022-12-21 18:14:53', NULL, NULL, NULL),
(115, 3, 'Hair Straightening', 1000.00, 1000.00, '30', 10, 3, 0, 1, '2023-01-05 15:49:26', NULL, NULL, NULL),
(116, 3, 'Hair Straightening', 1000.00, 1000.00, '30', 10, 3, 0, 1, '2023-01-05 15:49:29', NULL, NULL, NULL),
(117, 3, 'Hair Straightening', 1000.00, 1000.00, '30', 10, 3, 0, 1, '2023-01-05 15:49:33', NULL, NULL, NULL),
(118, 3, 'Hair Straightening', 1000.00, 1000.00, '30', 10, 3, 0, 1, '2023-01-05 15:49:42', NULL, NULL, NULL),
(119, 3, 'Hair Straightening', 1000.00, 1000.00, '30', 10, 3, 0, 1, '2023-01-05 15:49:43', NULL, NULL, NULL),
(120, 3, 'Hair Straightening', 1000.00, 1000.00, '30', 10, 3, 0, 1, '2023-01-05 15:49:43', NULL, NULL, NULL),
(121, 3, 'Hair Straightening', 1000.00, 1000.00, '30', 10, 3, 0, 1, '2023-01-05 15:51:05', NULL, NULL, NULL),
(123, 38, 'color hair', 600.00, 600.00, '45', 6, 1, 0, 1, '2023-01-30 13:37:16', NULL, '2023-01-30 13:38:00', NULL),
(124, 38, 'hair facial color', 100.00, 100.00, '25', 10, 1, 0, 1, '2023-01-30 13:41:16', NULL, NULL, NULL),
(125, 38, 'hair facial deep color', 100.00, 100.00, '35', 10, 1, 0, 1, '2023-01-30 13:45:28', NULL, '2023-01-30 13:53:31', NULL),
(126, 35, 'VLCC manicure', 300.00, 300.00, '30', 3, 1, 0, 1, '2023-01-30 13:55:59', NULL, NULL, NULL),
(134, 43, 'excel service', 100.00, 100.00, '15', 10, 1, 0, 1, '2023-05-20 17:59:47', NULL, NULL, NULL),
(135, 44, 'xyz', 100.00, 100.00, '15', 1, 1, 0, 1, '2023-05-20 18:15:06', NULL, NULL, NULL),
(136, 44, 'xyz 1', 100.00, 100.00, '15', 1, 1, 0, 1, '2023-05-20 18:21:16', NULL, NULL, NULL),
(137, 44, 'xyz 2', 100.00, 100.00, '15', 1, 1, 0, 1, '2023-05-20 18:21:16', NULL, NULL, NULL),
(138, 44, 'xyz 3', 100.00, 100.00, '15', 1, 1, 0, 1, '2023-05-20 18:21:16', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_category`
--

CREATE TABLE `service_category` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `service_category`
--

INSERT INTO `service_category` (`id`, `name`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(3, 'Hair Dreser3', 1, '2022-08-31 12:07:57', NULL, '2022-08-31 12:54:51', NULL),
(35, 'Manicure', 1, '2022-12-21 18:14:53', NULL, NULL, NULL),
(38, 'hair coloring', 1, '2023-01-30 13:27:37', NULL, NULL, NULL),
(43, 'excel', 1, '2023-05-20 17:59:47', NULL, NULL, NULL),
(44, 'abc', 1, '2023-05-20 18:15:06', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_product`
--

CREATE TABLE `service_product` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `volume` int(11) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `quantity_used` decimal(10,2) NOT NULL COMMENT 'in unit',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_product_commission`
--

CREATE TABLE `service_product_commission` (
  `id` int(11) NOT NULL,
  `sp_id` int(11) NOT NULL,
  `sale_from` decimal(10,0) NOT NULL,
  `sale_to` decimal(10,0) NOT NULL,
  `commission` decimal(10,0) NOT NULL,
  `type` varchar(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_provider`
--

CREATE TABLE `service_provider` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dob` varchar(15) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `service_provider_type` varchar(255) DEFAULT NULL,
  `working_hours_start` varchar(15) NOT NULL,
  `working_hours_end` varchar(15) NOT NULL,
  `salary` varchar(8) NOT NULL,
  `emer_contact_number` varchar(15) NOT NULL,
  `emer_contact_person` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text DEFAULT NULL,
  `gender` varchar(8) NOT NULL,
  `service_commission` varchar(20) DEFAULT NULL,
  `product_commission` varchar(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `frontproof` varchar(255) DEFAULT NULL,
  `backproof` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `service_provider`
--

INSERT INTO `service_provider` (`id`, `branch_id`, `name`, `dob`, `contact_number`, `email`, `service_provider_type`, `working_hours_start`, `working_hours_end`, `salary`, `emer_contact_number`, `emer_contact_person`, `address`, `username`, `password`, `gender`, `service_commission`, `product_commission`, `photo`, `frontproof`, `backproof`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 4, 'Binita Amin', '19/12/2019', '1278789687', 'ctoor@kunda.com', 'Hair Cut', '08:00 AM', '11:55 PM', '15000', '', '', '97, Kalpit Society, TarunGunj, Hyderabad, Himachal Pradesh - 326375', 'E5167', NULL, 'female', '10', '10', '', '', '', 1, '2023-02-04 11:44:33', NULL, NULL, NULL),
(2, 4, 'Isha Persaud', '02/02/2009', '4627960036', 'mohan.halder@gmail.com', 'Hair Cut', '08:00 AM', '11:55 PM', '15000', '', '', '83, Akshay Apartments, Hinjewadi, Srinagar, Rajasthan - 144209', 'E5153', NULL, 'female', '10', '10', '', '', '', 1, '2023-02-04 11:44:04', NULL, NULL, NULL),
(3, 4, 'Jyoti Raval', '31/01/1966', '3726770898', 'narmada08@dalal.org', 'Hair Cut', '08:00 AM', '11:55 PM', '15000', '', '', '55, Harbhajan Villas, Malad, Udaipur, Tripura - 129908', 'E5154', NULL, 'female', '10', '10', '', '', '', 1, '2023-02-04 11:44:26', NULL, NULL, NULL),
(4, 4, 'Tarun Kara', '06/10/1974', '9773880693', 'kamlesh53@saini.in', 'Hair Cut', '08:00 AM', '11:55 PM', '15000', '', '', '94, ChameliGarh,, Nashik, Telangana - 447011', 'E5110', NULL, 'male', '10', '10', '', '', '', 1, '2023-02-04 11:44:19', NULL, NULL, NULL),
(5, 4, 'Ajinkya Deshpande', '25/06/1936', '9898969477', 'aniruddh42@pingle.com', 'Hair Cut', '08:00 AM', '11:55 PM', '15000', '', '', '32, Chandpole,, Kochi, Andhra Pradesh - 420985', 'E5150', NULL, 'male', '10', '10', '', '', '', 1, '2023-02-04 11:44:46', NULL, NULL, NULL),
(6, 4, 'Krishna Vaidya', '05/10/1947', '9881903690', 'hemendra17@hayer.in', 'Hair Cut', '08:00 AM', '11:55 PM', '15000', '', '', '24, Emran Villas, YasminPur, Bhubhaneshwar, Tripura - 466272', 'E5147', NULL, 'male', '10', '10', '', '', '', 1, '2023-02-04 11:44:57', NULL, NULL, NULL),
(7, 4, 'Mahmood Goswami', '10/05/1945', '8091774278', 'parekh.jasmin@hotmail.com', 'Unisex Hair Dresser', '08:00 AM', '11:55 PM', '15000', '', '', '31, Ganesh Society, Naval Chowk, Jammu, Daman and Diu - 284197', 'E5173', NULL, 'male', '10', '10', '', '', '', 1, '2023-02-04 11:45:09', NULL, NULL, NULL),
(8, 4, 'Srinivasan Karnik', '09/05/1946', '7932667139', 'david.ahuja@gmail.com', 'Unisex Hair Dresser', '08:00 AM', '11:55 PM', '15000', '', '', '61, Charlie Villas, Krishna Nagar, Chandigarh, Chandigarh - 270100', 'E5189', NULL, 'male', '10', '10', '', '', '', 1, '2023-02-04 11:45:27', NULL, NULL, NULL),
(9, 4, 'Parvez Om', '20/05/1932', '4110332299', 'rama.varun@mahabir.com', 'Unisex Hair Dresser', '08:00 AM', '11:55 PM', '15000', '', '', '94, Hadapsar,, Lucknow, Kerala - 416656', 'E5182', NULL, 'male', '10', '10', '', '', '', 1, '2023-02-04 11:45:37', NULL, NULL, NULL),
(10, 4, 'Trishana Rege', '20/07/1975', '3174102409', 'rsur@hotmail.com', 'Unisex Hair Dresser', '08:00 AM', '11:55 PM', '15000', '', '', '46, DivyaGarh,, Thiruvananthapuram, Andhra Pradesh - 473224', 'E5113', NULL, 'female', '10', '10', '', '', '', 1, '2023-02-03 15:46:34', NULL, NULL, NULL),
(11, 4, 'Mini Shroff', '07/11/1940', '6249298870', 'ragini.sing@thaker.com', 'Unisex Hair Dresser', '08:00 AM', '11:55 PM', '15000', '', '', '15, Drishti Apartments, VarunGunj, Ludhiana, Kerala - 413431', 'E5129', NULL, 'female', '10', '10', '', '', '', 1, '2023-02-03 15:46:44', NULL, NULL, NULL),
(12, 4, 'Maya Narain', '08/02/2005', '1000381047', 'magar.lalita@sachar.com', 'Unisex Hair Dresser', '08:00 AM', '11:55 PM', '15000', '', '', '83, Fardeen Villas, Chandpole, Pilani, Meghalaya - 331644', 'E5160', NULL, 'female', '10', '10', '', '', '', 1, '2023-02-03 15:46:54', NULL, NULL, NULL),
(13, 4, 'Prerna Khalsa', '08/09/1954', '6492074228', 'sangha.elias@gmail.com', 'Makeup Artist', '08:00 AM', '11:55 PM', '15000', '', '', '75, Vikhroli,, Agra, Karnataka - 458680', 'E5128', NULL, 'female', '10', '10', '', '', '', 1, '2023-02-03 15:47:04', NULL, NULL, NULL),
(14, 4, 'Himani Mann', '12/03/1987', '4435310504', 'esha.ramnarine@natarajan.in', 'Makeup Artist', '08:00 AM', '11:55 PM', '15000', '', '', '71, Alka Villas, RameshGarh, Raipur, Dadra and Nagar Haveli - 208787', 'E5196', NULL, 'female', '10', '10', '', '', '', 1, '2023-02-03 15:47:18', NULL, NULL, NULL),
(15, 4, 'Amrita Atwal', '19/10/1949', '1030814977', 'seshadri.nutan@nath.org', 'Makeup Artist', '08:00 AM', '11:55 PM', '15000', '', '', '54, GovindGarh,, Ahmedabad, West Bengal - 396923', 'E5123', NULL, 'female', '10', '10', '', '', '', 1, '2023-02-04 11:46:06', NULL, NULL, NULL),
(16, 4, 'Nirmal Kaul', '18/04/1923', '3936416456', 'binoya94@rediffmail.com', 'Makeup Artist', '08:00 AM', '11:55 PM', '15000', '', '', '78, Ankita Society, EshaGarh, Ahmedabad, Chhattisgarh - 421857', 'E5185', NULL, 'male', '10', '10', '', '', '', 1, '2023-02-04 11:46:18', NULL, NULL, NULL),
(17, 4, 'Charandeep Sastry', '05/03/1942', '2666430442', 'vivek.murty@hotmail.com', 'Makeup Artist', '08:00 AM', '11:55 PM', '15000', '', '', '72, Prasoon Villas, BahadurPur, Lucknow, Nagaland - 220081', 'E5160', NULL, 'male', '10', '10', '', '', '', 1, '2023-02-04 11:46:31', NULL, NULL, NULL),
(18, 4, 'Surya Mohabir', '11/06/1981', '8300866093', 'oramachandran@mangal.org', 'Makeup Artist', '08:00 AM', '11:55 PM', '15000', '', '', '97, NeelaGarh,, Nashik, Delhi - 173756', 'E5199', NULL, 'male', '10', '10', '', '', '', 1, '2023-02-04 11:47:45', NULL, NULL, NULL),
(19, 4, 'Rehman Mital', '21/10/2017', '2278645888', 'tulsi06@rediffmail.com', 'Skin Care', '08:00 AM', '11:55 PM', '15000', '', '', '79, Meghana Society, Churchgate, Meerut, Goa - 300095', 'E514', NULL, 'male', '10', '10', '', '', '', 1, '2023-02-04 11:47:56', NULL, NULL, NULL),
(20, 4, 'Kalyan Hayre', '14/09/1954', '4650581703', 'nawab.nagi@yahoo.com', 'Skin Care', '08:00 AM', '11:55 PM', '15000', '', '', '65, Siddharth Apartments, Chandpole, Guwahati, Manipur - 118506', 'E5186', NULL, 'male', '10', '10', '', '', '', 1, '2023-02-04 11:48:07', NULL, NULL, NULL),
(21, 4, 'Chinmay Datta', '01/08/1929', '3519756946', 'surana.hanuman@chohan.in', 'Skin Care', '08:00 AM', '11:55 PM', '15000', '', '', '67, Namita Society, Hadapsar, Ludhiana, Bihar - 246172', 'E5152', NULL, 'male', '10', '10', '', '', '', 1, '2023-02-04 11:48:18', NULL, NULL, NULL),
(22, 4, 'Uma Nadig', '31/03/1997', '4327351706', 'osundaram@yahoo.com', 'Skin Care', '08:00 AM', '11:55 PM', '15000', '', '', '65, Virar,, Ajmer, Daman and Diu - 456203', 'E5125', NULL, 'female', '10', '10', '', '', '', 1, '2023-02-04 11:48:29', NULL, NULL, NULL),
(23, 4, 'Kalyani Soman', '26/03/1962', '7506816407', 'tanuja10@rediffmail.com', 'Skin Care', '08:00 AM', '11:55 PM', '15000', '', '', '65, Kormangala,, Chennai, Andaman and Nicobar Islands - 140004', 'E5127', NULL, 'female', '10', '10', '', '', '', 1, '2023-02-04 11:48:39', NULL, NULL, NULL),
(24, 4, 'Pooja Mangat', '10/10/1938', '2011148986', 'padmini.kannan@hotmail.com', 'Skin Care', '08:00 AM', '11:55 PM', '15000', '', '', '39, Ehsaan Apartments, Cyber City, Agra, Manipur - 294082', 'E5136', NULL, 'female', '10', '10', '', '', '', 1, '2023-02-04 11:48:50', NULL, NULL, NULL),
(25, 4, 'sabir new', '', '9125149648', '', 'hair facial', '08:35 AM', '08:35 PM', '15000', '', '', '', 'E2594', NULL, 'male', '10', '10', '', '', '', 1, '2023-01-30 13:39:21', NULL, NULL, NULL),
(26, 5, 'sabir new', '', '9125149648', '', 'hair facial', '08:35 AM', '08:35 PM', '15000', '', '', '', 'E2594', '', 'male', '10', '10', '', '', '', 1, '2023-01-30 13:39:21', NULL, NULL, NULL),
(27, 4, 'vijay', '', '9999999999', '', 'Facial Expert', '08:00 AM', '11:55 PM', '10000', '', '', '', 'E2722', NULL, 'male', '10', '5', '', '', '', 1, '2023-02-04 11:49:02', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_provider_assign_services`
--

CREATE TABLE `service_provider_assign_services` (
  `id` int(11) NOT NULL,
  `sp_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `service_provider_assign_services`
--

INSERT INTO `service_provider_assign_services` (`id`, `sp_id`, `s_id`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(4473, 1, 9, '2023-03-28 13:06:09', NULL, NULL, NULL),
(4586, 1, 10, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4587, 1, 11, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4588, 1, 12, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4589, 1, 13, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4590, 1, 14, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4591, 1, 15, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4592, 1, 16, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4593, 1, 17, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4594, 1, 18, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4595, 1, 19, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4596, 1, 20, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4597, 1, 21, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4598, 1, 22, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4599, 1, 23, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4600, 1, 24, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4601, 1, 25, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4602, 1, 26, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4603, 1, 27, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4604, 1, 28, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4605, 1, 29, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4606, 1, 30, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4607, 1, 31, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4608, 1, 32, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4609, 1, 33, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4610, 1, 34, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4611, 1, 35, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4612, 1, 36, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4613, 1, 37, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4614, 1, 38, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4615, 1, 39, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4616, 1, 40, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4617, 1, 41, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4618, 1, 42, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4619, 1, 43, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4620, 1, 44, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4621, 1, 45, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4622, 1, 46, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4623, 1, 47, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4624, 1, 48, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4625, 1, 49, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4626, 1, 50, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4627, 1, 51, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4628, 1, 52, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4629, 1, 53, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4630, 1, 54, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4631, 1, 55, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4632, 1, 56, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4633, 1, 57, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4634, 1, 58, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4635, 1, 59, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4636, 1, 60, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4637, 1, 61, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4638, 1, 62, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4639, 1, 63, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4640, 1, 64, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4641, 1, 65, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4642, 1, 66, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4643, 1, 67, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4644, 1, 68, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4645, 1, 69, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4646, 1, 70, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4647, 1, 71, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4648, 1, 72, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4649, 1, 73, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4650, 1, 74, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4651, 1, 75, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4652, 1, 76, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4653, 1, 77, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4654, 1, 78, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4655, 1, 79, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4656, 1, 80, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4657, 1, 81, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4658, 1, 82, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4659, 1, 83, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4660, 1, 84, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4661, 1, 85, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4662, 1, 86, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4663, 1, 87, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4664, 1, 88, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4665, 1, 89, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4666, 1, 90, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4667, 1, 91, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4668, 1, 92, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4669, 1, 93, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4670, 1, 94, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4671, 1, 95, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4672, 1, 96, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4673, 1, 97, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4674, 1, 98, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4675, 1, 99, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4676, 1, 100, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4677, 1, 101, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4678, 1, 102, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4679, 1, 103, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4680, 1, 104, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4681, 1, 105, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4682, 1, 106, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4683, 1, 107, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4684, 1, 108, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4685, 1, 109, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4686, 1, 114, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4687, 1, 115, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4688, 1, 116, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4689, 1, 117, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4690, 1, 118, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4691, 1, 119, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4692, 1, 120, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4693, 1, 121, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4694, 1, 123, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4695, 1, 124, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4696, 1, 125, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4697, 1, 126, '2023-03-28 13:07:35', NULL, NULL, NULL),
(4698, 27, 9, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4699, 27, 10, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4700, 27, 11, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4701, 27, 12, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4702, 27, 13, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4703, 27, 14, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4704, 27, 15, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4705, 27, 16, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4706, 27, 17, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4707, 27, 18, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4708, 27, 19, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4709, 27, 20, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4710, 27, 21, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4711, 27, 22, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4712, 27, 23, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4713, 27, 24, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4714, 27, 25, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4715, 27, 26, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4716, 27, 27, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4717, 27, 28, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4718, 27, 29, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4719, 27, 30, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4720, 27, 31, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4721, 27, 32, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4722, 27, 33, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4723, 27, 34, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4724, 27, 35, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4725, 27, 36, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4726, 27, 37, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4727, 27, 38, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4728, 27, 39, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4729, 27, 40, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4730, 27, 41, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4731, 27, 42, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4732, 27, 43, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4733, 27, 44, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4734, 27, 45, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4735, 27, 46, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4736, 27, 47, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4737, 27, 48, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4738, 27, 49, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4739, 27, 50, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4740, 27, 51, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4741, 27, 52, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4742, 27, 53, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4743, 27, 54, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4744, 27, 55, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4745, 27, 56, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4746, 27, 57, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4747, 27, 58, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4748, 27, 59, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4749, 27, 60, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4750, 27, 61, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4751, 27, 62, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4752, 27, 63, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4753, 27, 64, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4754, 27, 65, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4755, 27, 66, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4756, 27, 67, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4757, 27, 68, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4758, 27, 69, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4759, 27, 70, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4760, 27, 71, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4761, 27, 72, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4762, 27, 73, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4763, 27, 74, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4764, 27, 75, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4765, 27, 76, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4766, 27, 77, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4767, 27, 78, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4768, 27, 79, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4769, 27, 80, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4770, 27, 81, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4771, 27, 82, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4772, 27, 83, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4773, 27, 84, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4774, 27, 85, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4775, 27, 86, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4776, 27, 87, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4777, 27, 88, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4778, 27, 89, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4779, 27, 90, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4780, 27, 91, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4781, 27, 92, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4782, 27, 93, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4783, 27, 94, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4784, 27, 95, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4785, 27, 96, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4786, 27, 97, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4787, 27, 98, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4788, 27, 99, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4789, 27, 100, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4790, 27, 101, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4791, 27, 102, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4792, 27, 103, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4793, 27, 104, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4794, 27, 105, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4795, 27, 106, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4796, 27, 107, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4797, 27, 108, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4798, 27, 109, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4799, 27, 114, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4800, 27, 115, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4801, 27, 116, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4802, 27, 117, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4803, 27, 118, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4804, 27, 119, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4805, 27, 120, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4806, 27, 121, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4807, 27, 123, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4808, 27, 124, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4809, 27, 125, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4810, 27, 126, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4811, 27, 134, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4812, 27, 135, '2023-05-20 18:16:44', NULL, NULL, NULL),
(4813, 1, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4814, 2, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4815, 3, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4816, 4, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4817, 5, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4818, 6, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4819, 7, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4820, 8, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4821, 9, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4822, 10, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4823, 11, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4824, 12, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4825, 13, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4826, 14, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4827, 15, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4828, 16, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4829, 17, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4830, 18, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4831, 19, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4832, 20, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4833, 21, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4834, 22, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4835, 23, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4836, 24, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4837, 25, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4838, 26, 136, '2023-05-20 18:21:16', NULL, NULL, NULL),
(4839, 27, 136, '2023-05-20 18:21:16', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_provider_commission_history`
--

CREATE TABLE `service_provider_commission_history` (
  `id` int(11) NOT NULL,
  `service_provider_id` int(11) NOT NULL,
  `billing_id` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `service_id` int(11) NOT NULL,
  `service_type` varchar(20) NOT NULL,
  `commission` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_provider_holiday`
--

CREATE TABLE `service_provider_holiday` (
  `id` int(11) NOT NULL,
  `sp_id` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_provider_off_week_day`
--

CREATE TABLE `service_provider_off_week_day` (
  `id` int(11) NOT NULL,
  `day` varchar(15) NOT NULL,
  `sp_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `service_provider_off_week_day`
--

INSERT INTO `service_provider_off_week_day` (`id`, `day`, `sp_id`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(8, 'Sunday', 27, '2023-02-04 11:49:52', NULL, NULL, NULL),
(9, 'Sunday', 24, '2023-02-04 11:50:00', NULL, NULL, NULL),
(10, 'Sunday', 23, '2023-02-04 11:50:06', NULL, NULL, NULL),
(11, 'Sunday', 22, '2023-02-04 11:50:17', NULL, NULL, NULL),
(12, 'Sunday', 21, '2023-02-04 11:50:20', NULL, NULL, NULL),
(13, 'Sunday', 20, '2023-02-04 11:50:22', NULL, NULL, NULL),
(14, 'Sunday', 19, '2023-02-04 11:50:26', NULL, NULL, NULL),
(15, 'Sunday', 18, '2023-02-04 11:50:28', NULL, NULL, NULL),
(16, 'Sunday', 17, '2023-02-04 11:50:31', NULL, NULL, NULL),
(17, 'Sunday', 16, '2023-02-04 11:50:33', NULL, NULL, NULL),
(18, 'Sunday', 15, '2023-02-04 11:50:36', NULL, NULL, NULL),
(19, 'Sunday', 14, '2023-02-04 11:50:39', NULL, NULL, NULL),
(20, 'Sunday', 13, '2023-02-04 11:50:42', NULL, NULL, NULL),
(21, 'Sunday', 12, '2023-02-04 11:50:45', NULL, NULL, NULL),
(22, 'Sunday', 11, '2023-02-04 11:50:48', NULL, NULL, NULL),
(23, 'Sunday', 10, '2023-02-04 11:50:50', NULL, NULL, NULL),
(24, 'Sunday', 9, '2023-02-04 11:50:52', NULL, NULL, NULL),
(25, 'Sunday', 8, '2023-02-04 11:50:55', NULL, NULL, NULL),
(26, 'Sunday', 7, '2023-02-04 11:50:57', NULL, NULL, NULL),
(27, 'Sunday', 6, '2023-02-04 11:51:00', NULL, NULL, NULL),
(28, 'Sunday', 5, '2023-02-04 11:51:03', NULL, NULL, NULL),
(29, 'Sunday', 4, '2023-02-04 11:51:05', NULL, NULL, NULL),
(30, 'Sunday', 3, '2023-02-04 11:51:07', NULL, NULL, NULL),
(31, 'Sunday', 2, '2023-02-04 11:51:10', NULL, NULL, NULL),
(32, 'Sunday', 1, '2023-02-04 11:51:12', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_reminder`
--

CREATE TABLE `service_reminder` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `interval_days` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `stock_purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `volume` varchar(20) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `mrp_price` decimal(10,2) NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `exp_date` varchar(20) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_purchase`
--

CREATE TABLE `stock_purchase` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `gst_number` varchar(100) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `purchase_date` varchar(20) DEFAULT NULL,
  `sub_total` decimal(10,2) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `discount_type` varchar(100) DEFAULT NULL,
  `tax` varchar(50) DEFAULT NULL,
  `shipping_charge` int(11) DEFAULT NULL,
  `total_charge` decimal(10,2) DEFAULT NULL,
  `amount_paid` int(11) DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `pending_due` decimal(10,2) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_purchase_product`
--

CREATE TABLE `stock_purchase_product` (
  `id` int(11) NOT NULL,
  `stock_record_id` int(11) NOT NULL,
  `stock_purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `volume` varchar(20) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `mrp_price` decimal(10,2) NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `exp_date` varchar(20) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_record`
--

CREATE TABLE `stock_record` (
  `id` int(11) NOT NULL,
  `stock_main_id` int(11) NOT NULL,
  `vendor_client_service_provider_id` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `invoice` varchar(100) NOT NULL,
  `debit` decimal(10,2) DEFAULT NULL,
  `credit` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_service_provider`
--

CREATE TABLE `transfer_service_provider` (
  `id` int(11) NOT NULL,
  `transfer_type` varchar(20) NOT NULL,
  `transfer_date` varchar(20) NOT NULL,
  `service_provider_id` int(11) NOT NULL,
  `transfer_branch_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `plain_password` text NOT NULL,
  `user_role` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `email`, `password`, `plain_password`, `user_role`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'pIxeladmin', 'pIxeladmin', 'pIxeladmin@test.com', '$2y$10$yuwWKCFJNadYYZ2VrW51heyqVyA6TyhVrlgw.NVy6261U09AVMuKW', 'pixeldemo', 'superadmin', '2023-01-01 16:24:50', NULL, '2023-01-23 23:49:03', NULL),
(3, 'pixelbranch', 'pixelbranch', 'pixelbranch@test.com', '$2y$10$XI0movmEwWadbG2DZYhXv..I4X8lSgDEjzohpAsMSn9nyNYFmbsm.', 'pixeldemo', 'admin', '2023-01-01 16:36:24', NULL, '2023-01-23 23:53:44', NULL),
(4, 'pixelbranch 2', 'pixelbranch2', 'pixelbranch2@test.com', '$2y$10$23NVSDAhckkC0mpb2EZDQOYA6ZFdlcAoJzUDZTCm6Ei.p8YOn6ai6', 'pixeldemo', 'admin', '2023-01-02 00:54:10', NULL, '2023-02-09 23:49:19', NULL),
(5, 'Sabire Rasul', 'sabirerasul', 'sabirerasul@outlook.com', '$2y$10$LS45522bbfkOpBSWwkKBk.nHSNVgJR8MCJD581.fy370.zwH0Aa1y', '12345678', 'admin', '2023-02-15 18:27:35', NULL, '2023-02-15 18:28:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int(11) NOT NULL,
  `vendor_name` tinytext NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `gst_number` text DEFAULT NULL,
  `company_details` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `vendor_name`, `contact`, `email`, `address`, `gst_number`, `company_details`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(4, 'sabir', '9125149648', NULL, NULL, '', NULL, '2023-03-21 15:38:10', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `appointment_advance_payment`
--
ALTER TABLE `appointment_advance_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `appointment_assign_service_provider`
--
ALTER TABLE `appointment_assign_service_provider`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `appointment_service_id` (`appointment_service_id`),
  ADD KEY `service_provider_id` (`service_provider_id`);

--
-- Indexes for table `appointment_checkin`
--
ALTER TABLE `appointment_checkin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `appointment_service`
--
ALTER TABLE `appointment_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `branch_api_setting`
--
ALTER TABLE `branch_api_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_automatic_reminder`
--
ALTER TABLE `branch_automatic_reminder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_holiday`
--
ALTER TABLE `branch_holiday`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_redeem_points_setting`
--
ALTER TABLE `branch_redeem_points_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch_sms_history`
--
ALTER TABLE `branch_sms_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `branch_sms_message`
--
ALTER TABLE `branch_sms_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `template_id` (`template_id`);

--
-- Indexes for table `branch_sms_template`
--
ALTER TABLE `branch_sms_template`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `branch_working_day_hour`
--
ALTER TABLE `branch_working_day_hour`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `client_billing`
--
ALTER TABLE `client_billing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `client_billing_assign_service_provider`
--
ALTER TABLE `client_billing_assign_service_provider`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_provider_id` (`service_provider_id`),
  ADD KEY `billing_id` (`billing_id`);

--
-- Indexes for table `client_billing_payment`
--
ALTER TABLE `client_billing_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billing_id` (`billing_id`);

--
-- Indexes for table `client_billing_product`
--
ALTER TABLE `client_billing_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billing_id` (`billing_id`);

--
-- Indexes for table `client_coupon_code_use_history`
--
ALTER TABLE `client_coupon_code_use_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billing_id` (`billing_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `coupon_code_id` (`coupon_code_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `client_followup`
--
ALTER TABLE `client_followup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `client_membership`
--
ALTER TABLE `client_membership`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `membership_id` (`membership_id`),
  ADD KEY `billing_id` (`billing_id`);

--
-- Indexes for table `client_package`
--
ALTER TABLE `client_package`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `package_id` (`package_id`),
  ADD KEY `billing_id` (`billing_id`);

--
-- Indexes for table `client_package_details`
--
ALTER TABLE `client_package_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `client_package_id` (`client_package_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `client_package_details_usage`
--
ALTER TABLE `client_package_details_usage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_referral_code`
--
ALTER TABLE `client_referral_code`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `client_referral_code_use_history`
--
ALTER TABLE `client_referral_code_use_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `referral_code_id` (`referral_code_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `billing_id` (`billing_id`),
  ADD KEY `referral_client_id` (`referral_client_id`);

--
-- Indexes for table `client_wallet`
--
ALTER TABLE `client_wallet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_salary`
--
ALTER TABLE `employee_salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enquiry`
--
ALTER TABLE `enquiry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `enquiry_history`
--
ALTER TABLE `enquiry_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enquiry_id` (`enquiry_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expense_type_id` (`expense_type_id`),
  ADD KEY `recipient_name_id` (`recipient_name_id`);

--
-- Indexes for table `expense_recipient`
--
ALTER TABLE `expense_recipient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_type`
--
ALTER TABLE `expense_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `gst_slab`
--
ALTER TABLE `gst_slab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `link_shortener`
--
ALTER TABLE `link_shortener`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_service`
--
ALTER TABLE `package_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package_id` (`package_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_payment_history`
--
ALTER TABLE `pending_payment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_use_in_salon`
--
ALTER TABLE `product_use_in_salon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_provider_id` (`service_provider_id`);

--
-- Indexes for table `product_use_in_salon_stock_record`
--
ALTER TABLE `product_use_in_salon_stock_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_use_in_salon_id` (`product_use_in_salon_id`),
  ADD KEY `stock_record_id` (`stock_record_id`);

--
-- Indexes for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reward_point`
--
ALTER TABLE `reward_point`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `self_assessment_data`
--
ALTER TABLE `self_assessment_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`category_id`);

--
-- Indexes for table `service_category`
--
ALTER TABLE `service_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_product`
--
ALTER TABLE `service_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `service_product_commission`
--
ALTER TABLE `service_product_commission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sp_id` (`sp_id`);

--
-- Indexes for table `service_provider`
--
ALTER TABLE `service_provider`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `service_provider_assign_services`
--
ALTER TABLE `service_provider_assign_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sp_id` (`sp_id`),
  ADD KEY `s_id` (`s_id`);

--
-- Indexes for table `service_provider_commission_history`
--
ALTER TABLE `service_provider_commission_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_provider_id` (`service_provider_id`),
  ADD KEY `billing_id` (`billing_id`);

--
-- Indexes for table `service_provider_holiday`
--
ALTER TABLE `service_provider_holiday`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sp_id` (`sp_id`);

--
-- Indexes for table `service_provider_off_week_day`
--
ALTER TABLE `service_provider_off_week_day`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sp_id` (`sp_id`);

--
-- Indexes for table `service_reminder`
--
ALTER TABLE `service_reminder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `stock_purchase_id` (`stock_purchase_id`);

--
-- Indexes for table `stock_purchase`
--
ALTER TABLE `stock_purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `stock_purchase_product`
--
ALTER TABLE `stock_purchase_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_purchase_id` (`stock_purchase_id`),
  ADD KEY `stock_record_id` (`stock_record_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `stock_record`
--
ALTER TABLE `stock_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_product_id` (`stock_main_id`);

--
-- Indexes for table `transfer_service_provider`
--
ALTER TABLE `transfer_service_provider`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_provider_id` (`service_provider_id`),
  ADD KEY `transfer_branch_id` (`transfer_branch_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `appointment_advance_payment`
--
ALTER TABLE `appointment_advance_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `appointment_assign_service_provider`
--
ALTER TABLE `appointment_assign_service_provider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `appointment_checkin`
--
ALTER TABLE `appointment_checkin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `appointment_service`
--
ALTER TABLE `appointment_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `branch_api_setting`
--
ALTER TABLE `branch_api_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branch_automatic_reminder`
--
ALTER TABLE `branch_automatic_reminder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branch_holiday`
--
ALTER TABLE `branch_holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `branch_redeem_points_setting`
--
ALTER TABLE `branch_redeem_points_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branch_sms_history`
--
ALTER TABLE `branch_sms_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `branch_sms_message`
--
ALTER TABLE `branch_sms_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `branch_sms_template`
--
ALTER TABLE `branch_sms_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `branch_working_day_hour`
--
ALTER TABLE `branch_working_day_hour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `client_billing`
--
ALTER TABLE `client_billing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `client_billing_assign_service_provider`
--
ALTER TABLE `client_billing_assign_service_provider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- AUTO_INCREMENT for table `client_billing_payment`
--
ALTER TABLE `client_billing_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `client_billing_product`
--
ALTER TABLE `client_billing_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT for table `client_coupon_code_use_history`
--
ALTER TABLE `client_coupon_code_use_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `client_followup`
--
ALTER TABLE `client_followup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_membership`
--
ALTER TABLE `client_membership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `client_package`
--
ALTER TABLE `client_package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `client_package_details`
--
ALTER TABLE `client_package_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `client_package_details_usage`
--
ALTER TABLE `client_package_details_usage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_referral_code`
--
ALTER TABLE `client_referral_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `client_referral_code_use_history`
--
ALTER TABLE `client_referral_code_use_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `client_wallet`
--
ALTER TABLE `client_wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `employee_salary`
--
ALTER TABLE `employee_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enquiry`
--
ALTER TABLE `enquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `enquiry_history`
--
ALTER TABLE `enquiry_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `expense_recipient`
--
ALTER TABLE `expense_recipient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `expense_type`
--
ALTER TABLE `expense_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gst_slab`
--
ALTER TABLE `gst_slab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `link_shortener`
--
ALTER TABLE `link_shortener`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `package_service`
--
ALTER TABLE `package_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pending_payment_history`
--
ALTER TABLE `pending_payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1199;

--
-- AUTO_INCREMENT for table `product_use_in_salon`
--
ALTER TABLE `product_use_in_salon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_use_in_salon_stock_record`
--
ALTER TABLE `product_use_in_salon_stock_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reward_point`
--
ALTER TABLE `reward_point`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `self_assessment_data`
--
ALTER TABLE `self_assessment_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `service_category`
--
ALTER TABLE `service_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `service_product`
--
ALTER TABLE `service_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `service_product_commission`
--
ALTER TABLE `service_product_commission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_provider`
--
ALTER TABLE `service_provider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `service_provider_assign_services`
--
ALTER TABLE `service_provider_assign_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4840;

--
-- AUTO_INCREMENT for table `service_provider_commission_history`
--
ALTER TABLE `service_provider_commission_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `service_provider_holiday`
--
ALTER TABLE `service_provider_holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_provider_off_week_day`
--
ALTER TABLE `service_provider_off_week_day`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `service_reminder`
--
ALTER TABLE `service_reminder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stock_purchase`
--
ALTER TABLE `stock_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stock_purchase_product`
--
ALTER TABLE `stock_purchase_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `stock_record`
--
ALTER TABLE `stock_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `transfer_service_provider`
--
ALTER TABLE `transfer_service_provider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `appointment_advance_payment`
--
ALTER TABLE `appointment_advance_payment`
  ADD CONSTRAINT `appointment_advance_payment_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `appointment_assign_service_provider`
--
ALTER TABLE `appointment_assign_service_provider`
  ADD CONSTRAINT `appointment_assign_service_provider_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointment_assign_service_provider_ibfk_2` FOREIGN KEY (`appointment_service_id`) REFERENCES `appointment_service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointment_assign_service_provider_ibfk_3` FOREIGN KEY (`service_provider_id`) REFERENCES `service_provider` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `appointment_checkin`
--
ALTER TABLE `appointment_checkin`
  ADD CONSTRAINT `appointment_checkin_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `appointment_service`
--
ALTER TABLE `appointment_service`
  ADD CONSTRAINT `appointment_service_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointment_service_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `branch`
--
ALTER TABLE `branch`
  ADD CONSTRAINT `branch_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `branch_sms_history`
--
ALTER TABLE `branch_sms_history`
  ADD CONSTRAINT `branch_sms_history_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `branch_sms_history_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `branch_sms_message` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `branch_sms_message`
--
ALTER TABLE `branch_sms_message`
  ADD CONSTRAINT `branch_sms_message_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `branch_sms_template` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `branch_sms_template`
--
ALTER TABLE `branch_sms_template`
  ADD CONSTRAINT `branch_sms_template_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `branch_working_day_hour`
--
ALTER TABLE `branch_working_day_hour`
  ADD CONSTRAINT `branch_working_day_hour_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_billing`
--
ALTER TABLE `client_billing`
  ADD CONSTRAINT `client_billing_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_billing_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_billing_assign_service_provider`
--
ALTER TABLE `client_billing_assign_service_provider`
  ADD CONSTRAINT `client_billing_assign_service_provider_ibfk_1` FOREIGN KEY (`billing_id`) REFERENCES `client_billing` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_billing_payment`
--
ALTER TABLE `client_billing_payment`
  ADD CONSTRAINT `client_billing_payment_ibfk_1` FOREIGN KEY (`billing_id`) REFERENCES `client_billing` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_billing_product`
--
ALTER TABLE `client_billing_product`
  ADD CONSTRAINT `client_billing_product_ibfk_1` FOREIGN KEY (`billing_id`) REFERENCES `client_billing` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_coupon_code_use_history`
--
ALTER TABLE `client_coupon_code_use_history`
  ADD CONSTRAINT `client_coupon_code_use_history_ibfk_1` FOREIGN KEY (`billing_id`) REFERENCES `client_billing` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_coupon_code_use_history_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_coupon_code_use_history_ibfk_3` FOREIGN KEY (`coupon_code_id`) REFERENCES `coupon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_coupon_code_use_history_ibfk_4` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_followup`
--
ALTER TABLE `client_followup`
  ADD CONSTRAINT `client_followup_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_followup_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_membership`
--
ALTER TABLE `client_membership`
  ADD CONSTRAINT `client_membership_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_membership_ibfk_2` FOREIGN KEY (`membership_id`) REFERENCES `membership` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_membership_ibfk_3` FOREIGN KEY (`billing_id`) REFERENCES `client_billing` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_package`
--
ALTER TABLE `client_package`
  ADD CONSTRAINT `client_package_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_package_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `package` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_package_ibfk_3` FOREIGN KEY (`billing_id`) REFERENCES `client_billing` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_package_details`
--
ALTER TABLE `client_package_details`
  ADD CONSTRAINT `client_package_details_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_package_details_ibfk_2` FOREIGN KEY (`client_package_id`) REFERENCES `client_package` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_package_details_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_referral_code`
--
ALTER TABLE `client_referral_code`
  ADD CONSTRAINT `client_referral_code_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_referral_code_use_history`
--
ALTER TABLE `client_referral_code_use_history`
  ADD CONSTRAINT `client_referral_code_use_history_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_referral_code_use_history_ibfk_2` FOREIGN KEY (`referral_code_id`) REFERENCES `client_referral_code` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_referral_code_use_history_ibfk_3` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_referral_code_use_history_ibfk_4` FOREIGN KEY (`billing_id`) REFERENCES `client_billing` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_referral_code_use_history_ibfk_5` FOREIGN KEY (`referral_client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_wallet`
--
ALTER TABLE `client_wallet`
  ADD CONSTRAINT `client_wallet_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_wallet_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `enquiry`
--
ALTER TABLE `enquiry`
  ADD CONSTRAINT `enquiry_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `enquiry_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `enquiry_history`
--
ALTER TABLE `enquiry_history`
  ADD CONSTRAINT `enquiry_history_ibfk_1` FOREIGN KEY (`enquiry_id`) REFERENCES `enquiry` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expense`
--
ALTER TABLE `expense`
  ADD CONSTRAINT `expense_ibfk_1` FOREIGN KEY (`expense_type_id`) REFERENCES `expense_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expense_ibfk_2` FOREIGN KEY (`recipient_name_id`) REFERENCES `expense_recipient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `package_service`
--
ALTER TABLE `package_service`
  ADD CONSTRAINT `package_service_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `package` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `package_service_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pending_payment_history`
--
ALTER TABLE `pending_payment_history`
  ADD CONSTRAINT `pending_payment_history_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pending_payment_history_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_use_in_salon`
--
ALTER TABLE `product_use_in_salon`
  ADD CONSTRAINT `product_use_in_salon_ibfk_1` FOREIGN KEY (`service_provider_id`) REFERENCES `service_provider` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_use_in_salon_stock_record`
--
ALTER TABLE `product_use_in_salon_stock_record`
  ADD CONSTRAINT `product_use_in_salon_stock_record_ibfk_1` FOREIGN KEY (`product_use_in_salon_id`) REFERENCES `product_use_in_salon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_use_in_salon_stock_record_ibfk_2` FOREIGN KEY (`stock_record_id`) REFERENCES `stock_record` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reward_point`
--
ALTER TABLE `reward_point`
  ADD CONSTRAINT `reward_point_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reward_point_ibfk_3` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `service_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `service_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_product`
--
ALTER TABLE `service_product`
  ADD CONSTRAINT `service_product_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `service_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_product_commission`
--
ALTER TABLE `service_product_commission`
  ADD CONSTRAINT `service_product_commission_ibfk_1` FOREIGN KEY (`sp_id`) REFERENCES `service_provider` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_provider`
--
ALTER TABLE `service_provider`
  ADD CONSTRAINT `service_provider_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_provider_assign_services`
--
ALTER TABLE `service_provider_assign_services`
  ADD CONSTRAINT `service_provider_assign_services_ibfk_1` FOREIGN KEY (`sp_id`) REFERENCES `service_provider` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `service_provider_assign_services_ibfk_2` FOREIGN KEY (`s_id`) REFERENCES `service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_provider_commission_history`
--
ALTER TABLE `service_provider_commission_history`
  ADD CONSTRAINT `service_provider_commission_history_ibfk_1` FOREIGN KEY (`service_provider_id`) REFERENCES `service_provider` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `service_provider_commission_history_ibfk_2` FOREIGN KEY (`billing_id`) REFERENCES `client_billing` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_provider_holiday`
--
ALTER TABLE `service_provider_holiday`
  ADD CONSTRAINT `service_provider_holiday_ibfk_1` FOREIGN KEY (`sp_id`) REFERENCES `service_provider` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_provider_off_week_day`
--
ALTER TABLE `service_provider_off_week_day`
  ADD CONSTRAINT `service_provider_off_week_day_ibfk_1` FOREIGN KEY (`sp_id`) REFERENCES `service_provider` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_reminder`
--
ALTER TABLE `service_reminder`
  ADD CONSTRAINT `service_reminder_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`stock_purchase_id`) REFERENCES `stock_purchase` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_purchase`
--
ALTER TABLE `stock_purchase`
  ADD CONSTRAINT `stock_purchase_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_purchase_product`
--
ALTER TABLE `stock_purchase_product`
  ADD CONSTRAINT `stock_purchase_product_ibfk_1` FOREIGN KEY (`stock_purchase_id`) REFERENCES `stock_purchase` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_purchase_product_ibfk_2` FOREIGN KEY (`stock_record_id`) REFERENCES `stock_record` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_purchase_product_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_record`
--
ALTER TABLE `stock_record`
  ADD CONSTRAINT `stock_record_ibfk_1` FOREIGN KEY (`stock_main_id`) REFERENCES `stock` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transfer_service_provider`
--
ALTER TABLE `transfer_service_provider`
  ADD CONSTRAINT `transfer_service_provider_ibfk_1` FOREIGN KEY (`service_provider_id`) REFERENCES `service_provider` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_service_provider_ibfk_2` FOREIGN KEY (`transfer_branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
