-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2023 at 04:10 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crud_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(400) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:active,2:inactive',
  `created_by` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `description`, `status`, `created_by`, `created_on`) VALUES
(3, 'abc 1', 'abc 2', 1, 1, '2023-08-05 14:19:57'),
(4, 'abc test test test test test test 2', 'abc test test test test descr test 1 \nabc test test test test descr test 1 abc test test test test descr test 1 \nabc test test test test descr test 1 \nabc test test test test descr test 1 ', 1, 1, '2023-08-05 14:26:45'),
(5, 'abc', 'abc', 1, 1, '2023-08-05 15:12:46'),
(6, 'abc', 'abc', 1, 1, '2023-08-05 15:14:55'),
(24, 'Post 10', 'Description 10', 1, 1, '2023-08-07 08:35:13'),
(21, 'New Post 1', 'New Post 1 Description', 1, 1, '2023-08-07 07:01:13'),
(22, 'New Post 2', 'New Post 1 Description', 1, 1, '2023-08-07 07:01:20'),
(12, 'updated title test', 'new test desc test test', 1, 2, '2023-08-05 18:35:42'),
(13, 'updated title test', 'new test desc test test', 1, 2, '2023-08-05 18:37:44'),
(14, 'updated title test', 'new test desc test test', 1, 2, '2023-08-05 18:38:12'),
(23, 'New Post 2', 'New Post 2 Description', 1, 1, '2023-08-07 07:01:27'),
(25, 'Post 11', 'Description 11', 1, 1, '2023-08-07 08:35:20'),
(26, 'Post 12', 'Description 12', 1, 1, '2023-08-07 08:35:28'),
(27, 'Post 13', 'Description 13', 1, 1, '2023-08-07 08:35:38'),
(28, 'latest ', 'Latest post', 1, 1, '2023-08-07 08:37:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `user_name` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `user_name`) VALUES
(1, 'yogesh', 'kumar', 'yogeshp'),
(2, 'neha', 'paliwal', 'nehap');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`(250));

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
