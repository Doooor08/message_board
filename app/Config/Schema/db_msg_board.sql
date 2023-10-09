-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2023 at 03:13 AM
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
-- Database: `db_msg_board`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_messages`
--

CREATE TABLE `tbl_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `message_id` varchar(12) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `message_body` text NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_messages`
--

INSERT INTO `tbl_messages` (`id`, `message_id`, `user_id`, `recipient`, `message_body`, `is_deleted`, `created_at`, `deleted_at`) VALUES
(1, '917112958483', '6371710336', '1882946202', 'Hello', 0, '2023-10-06 15:11:44', NULL),
(2, '917112958483', '1882946202', '6371710336', 'Hi', 0, '2023-10-06 15:12:13', NULL),
(3, '917112958483', '6371710336', '1882946202', 'Hi again', 0, '2023-10-06 15:16:54', NULL),
(4, '917112958483', '1882946202', '6371710336', 'Hello again', 0, '2023-10-06 15:17:09', NULL),
(5, '917112958483', '1882946202', '6371710336', 'ok', 0, '2023-10-06 15:21:04', NULL),
(6, '917112958483', '6371710336', '1882946202', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aut mollitia quas eveniet exercitationem voluptatum quos ut quis. Repudiandae tenetur dicta et ipsam, corporis voluptatibus incidunt voluptas, ut ea fugiat architecto!', 0, '2023-10-06 15:28:14', NULL),
(7, '703918639313', '2580897836', '1882946202', 'Hey', 0, '2023-10-06 17:47:45', NULL),
(8, '703918639313', '1882946202', '2580897836', 'Yo', 0, '2023-10-06 17:48:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `name` varchar(20) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `user_id`, `name`, `email`, `password`, `last_login`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1882946202', 'Kerlwin Arsolon', 'kerlwin21@gmail.com', '$2a$10$M.uVOco6y0UVt2iYfTprZuGAKPlDdPIX1AJsDVHbPzHQygmbk6TAu', '2023-10-06 17:48:19', '2023-10-06 09:19:38', '2023-10-06 11:50:39', NULL),
(5, '6371710336', 'UserADMIN', 'user000@gmail.com', '$2a$10$NfFvCWiv84QclRy6BJd8Gu0.KV8Fpm3vLUJmCWPJnmC.j7.wRVQJm', '2023-10-06 16:23:25', '2023-10-06 11:10:06', '2023-10-06 11:49:05', NULL),
(6, '2580897836', 'Steve Wojak', 'user002@gmail.com', '$2a$10$Wolzdin0CaFYIzMWPFnyB.BXfWwMW01kzJKJwc.aGZrWyhmbOiXm2', '2023-10-06 17:47:32', '2023-10-06 16:25:15', '2023-10-06 17:06:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users_data`
--

CREATE TABLE `tbl_users_data` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users_data`
--

INSERT INTO `tbl_users_data` (`id`, `user_id`, `photo`, `gender`, `birthdate`, `description`) VALUES
(1, '1882946202', 'IMG_20231006_95889F54.png', 'M', '2000-04-08', 'This is my profile'),
(3, '6371710336', 'IMG_20231006_E10D9304.png', 'M', '2023-10-01', 'This is not an admin'),
(4, '2580897836', 'IMG_20231006_72F9E02B.jpg', 'M', '2023-10-01', 'I\'m Steve');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_message` (`user_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_users_data`
--
ALTER TABLE `tbl_users_data`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `FK_user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_users_data`
--
ALTER TABLE `tbl_users_data`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  ADD CONSTRAINT `FK_user_message` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_users_data`
--
ALTER TABLE `tbl_users_data`
  ADD CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
