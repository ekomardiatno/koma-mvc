-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2021 at 05:25 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koma_mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `core_user`
--

CREATE TABLE `core_user` (
  `user_id` varchar(10) NOT NULL,
  `user_username` varchar(25) NOT NULL,
  `user_first_name` varchar(50) NOT NULL,
  `user_last_name` varchar(50) NOT NULL,
  `user_gender` tinyint(4) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_phone` varchar(15) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `user_province` varchar(20) NOT NULL,
  `user_city` varchar(20) NOT NULL,
  `user_postal_code` varchar(10) NOT NULL,
  `user_instagram` varchar(20) NOT NULL,
  `user_facebook` varchar(20) NOT NULL,
  `user_twitter` varchar(20) NOT NULL,
  `user_linkedin` varchar(20) NOT NULL,
  `user_id_number` varchar(30) NOT NULL,
  `user_id_picture` text NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_picture` text NOT NULL,
  `user_groups` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `core_user`
--

INSERT INTO `core_user` (`user_id`, `user_username`, `user_first_name`, `user_last_name`, `user_gender`, `user_email`, `user_phone`, `user_address`, `user_province`, `user_city`, `user_postal_code`, `user_instagram`, `user_facebook`, `user_twitter`, `user_linkedin`, `user_id_number`, `user_id_picture`, `user_password`, `user_picture`, `user_groups`, `status`, `date_added`, `date_modified`) VALUES
('u000000001', 'root', 'Ekoma', 'Mardiatno', 1, 'ekomardiatno@gmail.com', '082219299071', '', '', '', '', '', '', '', '', '1402021601950001', 'uploads/images/user/u000000001/upld-img-20210109-003556-2.jpg', '$2y$10$kXJkRoF7is4aAZRftOPT4eWD7HZdzvGT9E6suMnwHFSLiBKWqdvRq', 'uploads/images/user/u000000001/upld-img-20210109-003548-1.png', 'a:1:{i:0;s:10:\"g000000001\";}', 1, '2021-01-08 09:06:37', '2021-08-11 15:15:38');

-- --------------------------------------------------------

--
-- Table structure for table `core_user_group`
--

CREATE TABLE `core_user_group` (
  `user_group_id` varchar(10) NOT NULL,
  `user_group_name` varchar(50) NOT NULL,
  `user_group_description` varchar(150) NOT NULL,
  `user_group_access` text NOT NULL,
  `user_group_modify` text NOT NULL,
  `user_group_publish` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `core_user_group`
--

INSERT INTO `core_user_group` (`user_group_id`, `user_group_name`, `user_group_description`, `user_group_access`, `user_group_modify`, `user_group_publish`, `status`, `date_added`, `date_modified`) VALUES
('g000000001', 'Root', '', 'a:2:{i:0;s:11:\"admin/Group\";i:1;s:10:\"admin/User\";}', 'a:2:{i:0;s:11:\"admin/Group\";i:1;s:10:\"admin/User\";}', 'a:2:{i:0;s:11:\"admin/Group\";i:1;s:10:\"admin/User\";}', 1, '2021-01-06 02:11:07', '2021-08-11 15:05:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `core_user`
--
ALTER TABLE `core_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_username` (`user_username`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD UNIQUE KEY `user_phone` (`user_phone`);

--
-- Indexes for table `core_user_group`
--
ALTER TABLE `core_user_group`
  ADD PRIMARY KEY (`user_group_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
