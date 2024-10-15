-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 08, 2023 at 04:59 AM
-- Server version: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ourgram`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--
CREATE DATABASE ourgram;
USE ourgram;
CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment`, `create_at`, `post_id`, `user_id`) VALUES
(1, 'Have a nice day!', '2023-03-02 14:02:15', 5, 8);

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `follow_id` int(11) NOT NULL,
  `following_user_id` int(11) NOT NULL COMMENT 'กำลังติดตามใคร',
  `followed_user_id` int(11) NOT NULL COMMENT 'ถูกติดตามโดยใคร'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`follow_id`, `following_user_id`, `followed_user_id`) VALUES
(1, 2, 1),
(2, 3, 1),
(3, 7, 1),
(4, 9, 1),
(5, 3, 2),
(6, 10, 2),
(7, 8, 2),
(8, 6, 2),
(9, 6, 3),
(11, 7, 10),
(12, 9, 10),
(13, 4, 10),
(14, 6, 10),
(15, 8, 10),
(16, 10, 8),
(17, 4, 12),
(18, 7, 12);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `user_id`, `post_id`) VALUES
(2, 2, 3),
(3, 2, 2),
(4, 3, 4),
(5, 10, 5),
(6, 8, 5),
(7, 7, 6),
(8, 12, 7);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `read_notification` enum('yes','no') NOT NULL,
  `message_notification` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `read_notification`, `message_notification`, `user_id`) VALUES
(1, 'no', 'pawitaircraft following you', 2),
(2, 'no', 'pawitaircraft following you', 3),
(3, 'no', 'pawitaircraft following you', 7),
(4, 'no', 'pawitaircraft following you', 9),
(5, 'no', 'pawitsole following you', 3),
(6, 'no', 'pawitsole following you', 10),
(7, 'no', 'pawitsole following you', 8),
(8, 'no', 'pawitsole following you', 6),
(9, 'no', 'canpawit following you', 6),
(11, 'no', 'pawitworshipper following you', 7),
(12, 'no', 'pawitworshipper following you', 9),
(13, 'no', 'pawitworshipper following you', 4),
(14, 'no', 'pawitworshipper following you', 6),
(15, 'no', 'pawitworshipper following you', 8),
(16, 'no', 'pawittrainer following you', 10),
(17, 'no', 'masz following you', 4),
(18, 'no', 'masz following you', 7);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `caption` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `caption`, `create_at`, `user_id`) VALUES
(2, 'TEST', '2023-03-02 13:54:18', 2),
(3, 'Hope!', '2023-03-02 13:54:49', 2),
(4, 'Bad luck.', '2023-03-02 13:59:31', 3),
(5, 'Some day.', '2023-03-02 14:00:13', 10),
(6, 'Can you see?', '2023-03-02 14:19:46', 7),
(7, 'Hey yo', '2023-03-07 13:44:12', 12),
(8, 'I\'m tried!', '2023-03-07 13:45:01', 12),
(10, 'test', '2023-03-08 02:09:40', 12);

-- --------------------------------------------------------

--
-- Table structure for table `posts_media`
--

CREATE TABLE `posts_media` (
  `post_media_id` int(11) NOT NULL,
  `media_files` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `post_id` int(11) NOT NULL
) ;

--
-- Dumping data for table `posts_media`
--

INSERT INTO `posts_media` (`post_media_id`, `media_files`, `post_id`) VALUES
(2, '[\"2023-03-02_1677765249468.png\"]', 2),
(3, '[\"2023-03-02_1677765279103.jpg\"]', 3),
(4, '[\"2023-03-02_1677765568804.png\"]', 4),
(5, '[\"2023-03-02_1677765605404.png\"]', 5),
(6, '[\"2023-03-02_1677766776226.png\"]', 6),
(7, '[\"2023-03-07_1678196648887.png\"]', 7),
(8, '[\"2023-03-07_1678196696528.png\"]', 8),
(10, '[\"2023-03-08_1678241378411.png\"]', 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profile_name` varchar(100) NOT NULL,
  `profile_pic` varchar(100) DEFAULT NULL,
  `bio` varchar(200) DEFAULT NULL,
  `role` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `profile_name`, `profile_pic`, `bio`, `role`, `create_at`) VALUES
(1, 'pawitaircraft', 'pawitaircraft@example.com', '$2y$10$H6rgaVM.l0f/SDqbYSAXwOpFb.GlbbvaZ1CoktbnnYZ8teOZPxoEu', 'pawitaircraft', '1.jpg', 'xxhello worldxx', 'user', '2023-02-01 20:20:48'),
(2, 'pawitsole', 'pawitsole@example.com', '$2y$10$lgSC.hXC61mtzhnwLCoMSOHHIZ66QvyFVVUoAGaw2SwDvh1UIx/Oa', 'pawitsole', '2.jpg', NULL, 'user', '2023-02-01 20:21:14'),
(3, 'canpawit', 'canpawit@example.com', '$2y$10$Hfx8sXBr0MOlwbAEG3q.0ukMEq1DAlwV4hgI9WrxlpI.7v/FIoxCG', 'canpawit', '3.jpg', NULL, 'user', '2023-02-01 20:21:42'),
(4, 'pawitflee', 'pawitflee@example.com', '$2y$10$PRkKQujKT/MetiIUfAF7RusipjPzePoJFT9HcwY/.vNfJAR0Ij8R.', 'pawitflee', '4.jpg', NULL, 'user', '2023-02-01 20:22:07'),
(5, 'pawitpacified', 'pawitpacified@example.com', '$2y$10$nw68LuMpxGY1gN1K.U3g3e71KY2iA8O4SVJeY.qn02kRbzMYNfTLy', 'pawitpacified', '5.jpg', NULL, '5user', '2023-02-01 20:22:34'),
(6, 'kidneyspawit', 'kidneyspawit@example.com', '$2y$10$aEbCx.lLA5LMOBea0OXRx.MSxx.axqp.2PHQtHMD5B9tSeylCzQrC', 'kidneyspawit', '6.jpg', NULL, 'user', '2023-02-01 20:23:10'),
(7, 'pawitplease', 'pawitplease@example.com', '$2y$10$merev8DNb4UL21Nh/F4CxeVSzB9UBOcwk.j3XoM57dZiR.bkNQJti', 'pawitplease', '7.jpg', NULL, 'user', '2023-02-01 20:23:43'),
(8, 'pawittrainer', 'pawittrainer@example.com', '$2y$10$qYaZI5eOTcq5lUaR.h19pecrKAm9r7aWm/DWbCuFZ8qnKkRLQ4Up.', 'pawittrainer', '8.jpg', NULL, 'user', '2023-02-01 20:24:00'),
(9, 'pawitcavities', 'pawitcavities@example.com', '$2y$10$E0AVc7DJQG64BlWNB2dQOeAznlrCLIBYpnH.AUuTPr0paK4xpLhVS', 'pawitcavities', '9.jpg', NULL, 'user', '2023-02-01 20:24:20'),
(10, 'pawitworshipper', 'pawitworshipper@example.com', '$2y$10$NdVVgKzQf5HOaC4qYrYUF.gp7c9xyxBHJPsp8oiDaOsWegXimyg8G', 'pawitworshipper', '10.jpg', NULL, 'user', '2023-02-01 20:24:42'),
(11, 'admin', 'admin@example.com', '$2y$10$2EzHQWNAB7SuiaeyYTgDZ.u/KYeciEoj.zyB9mBtze5.OpciiEijO', 'admin', NULL, NULL, 'admin', '2023-02-22 08:25:14'),
(12, 'masz', 'masz@example.com', '$2y$10$KwbVfxYMfNLFmu7fDqAcUe05ZQC/42ZUQK7tHFnGFPie21XAyjd6u', 'masz', NULL, NULL, 'user', '2023-03-07 13:43:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`follow_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `posts_media`
--
ALTER TABLE `posts_media`
  ADD PRIMARY KEY (`post_media_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `follow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posts_media`
--
ALTER TABLE `posts_media`
  MODIFY `post_media_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `posts_media`
--
ALTER TABLE `posts_media`
  ADD CONSTRAINT `posts_media_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
