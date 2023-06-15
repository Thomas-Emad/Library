-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 14, 2023 at 01:24 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ag-book`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int NOT NULL,
  `num` int NOT NULL,
  `author` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `num`, `author`) VALUES
(1, 0, 'البابا شنودة الثالث ');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `code` varchar(512) DEFAULT NULL,
  `name` varchar(512) DEFAULT NULL,
  `img` varchar(255) NOT NULL,
  `part_number` varchar(255) DEFAULT 'N/A',
  `section` varchar(255) DEFAULT NULL,
  `series` varchar(512) DEFAULT NULL,
  `author` varchar(512) DEFAULT NULL,
  `publisher` varchar(512) DEFAULT NULL,
  `num_page` int DEFAULT NULL,
  `num_copy` int DEFAULT NULL,
  `unit_number` int DEFAULT NULL,
  `shelf_number` varchar(255) DEFAULT NULL,
  `position_book_sh` int DEFAULT NULL,
  `subjects` varchar(512) DEFAULT NULL,
  `visits` int NOT NULL,
  `add_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `famous` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `publications`
--

CREATE TABLE `publications` (
  `id` int NOT NULL,
  `post_random` int NOT NULL,
  `username` int NOT NULL,
  `img` varchar(255) NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `time_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `market` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publishers`
--

CREATE TABLE `publishers` (
  `id` int NOT NULL,
  `num` int NOT NULL,
  `publisher` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`id`, `num`, `publisher`) VALUES
(1, 0, 'الكلية الاكليريكية'),
(2, 0, 'مطبعة الانبا رويس');

-- --------------------------------------------------------

--
-- Table structure for table `shelf`
--

CREATE TABLE `shelf` (
  `id` int NOT NULL,
  `unit_number` int NOT NULL,
  `shelf_name` varchar(255) NOT NULL,
  `shelf_number` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `shelf`
--

INSERT INTO `shelf` (`id`, `unit_number`, `shelf_name`, `shelf_number`) VALUES
(1, 1, 'البابا شنوده', 1),
(2, 1, 'البابا شنوده', 2),
(3, 1, 'البابا شنوده', 3),
(4, 3, 'فلسفه', 1),
(5, 3, 'فلسفه', 2),
(6, 3, 'فلسفه', 3),
(7, 3, 'فلسفه', 4),
(8, 2, 'أدب', 1),
(9, 2, 'أدب', 2),
(10, 2, 'أدب', 3),
(11, 2, 'أدب', 4),
(16, 4, 'علوم', 1),
(17, 4, 'علوم', 2),
(18, 4, 'علوم', 3),
(19, 4, 'علوم', 4),
(20, 5, 'أسقفية الشباب', 1),
(21, 5, 'أسقفية الشباب', 2),
(22, 5, 'أسقفية الشباب', 3),
(23, 5, 'أسقفية الشباب', 4),
(24, 5, 'أسقفية الشباب', 5),
(25, 5, 'أسقفية الشباب', 6),
(26, 6, 'تاريخ', 1),
(27, 6, 'تاريخ', 2),
(28, 6, 'تاريخ', 3),
(29, 6, 'تاريخ', 4),
(30, 7, 'روحيات', 1),
(31, 7, 'روحيات', 2),
(32, 7, 'روحيات', 3),
(33, 7, 'روحيات', 4),
(34, 8, 'سير قديسين', 1),
(35, 8, 'سير قديسين', 2),
(36, 8, 'سير قديسين', 3),
(37, 8, 'سير قديسين', 4),
(38, 9, 'خدمات', 1),
(39, 9, 'خدمات', 2),
(40, 9, 'خدمات', 3),
(41, 9, 'خدمات', 4),
(42, 9, 'خدمات', 5),
(43, 9, 'خدمات', 6),
(44, 10, 'اباء اولين', 1),
(45, 10, 'اباء اولين', 2),
(46, 10, 'اباء اولين', 3),
(47, 10, 'اباء اولين', 4),
(48, 10, 'اباء اولين', 5),
(49, 10, 'اباء اولين', 6),
(50, 11, 'كتاب مقدس', 1),
(51, 11, 'كتاب مقدس', 2),
(52, 11, 'كتاب مقدس', 3),
(53, 11, 'كتاب مقدس', 4),
(54, 12, 'أبائيات', 1),
(55, 12, 'أبائيات', 2),
(56, 12, 'أبائيات', 3),
(57, 12, 'أبائيات', 4),
(58, 13, '******', 1),
(59, 13, '******', 2),
(60, 13, '******', 3),
(61, 13, '******', 4),
(62, 14, '******', 1),
(63, 14, '******', 2),
(64, 14, '******', 3),
(65, 14, '******', 4),
(66, 14, '******', 5),
(67, 14, '******', 6),
(68, 15, 'ألانبا غريغوريوس', 1),
(69, 15, 'ألانبا غريغوريوس', 2),
(70, 15, 'ألانبا غريغوريوس', 3),
(71, 16, 'مدرسه الاسكندرية', 1),
(72, 16, 'مدرسه الاسكندرية', 2),
(73, 16, 'مدرسه الاسكندرية', 3),
(74, 16, 'مدرسه الاسكندرية', 4),
(75, 16, 'مدرسه الاسكندرية', 5);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int NOT NULL,
  `num` int NOT NULL,
  `unit_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `num`, `unit_name`) VALUES
(1, 1, 'البابا شنودة الثالث '),
(2, 3, 'فلسفه'),
(3, 5, 'أسقفية الشباب'),
(4, 6, 'تاريخ'),
(5, 8, 'سير قديسين'),
(6, 9, 'خدمات'),
(7, 11, 'كتاب مقدس'),
(8, 12, 'أبائيات'),
(9, 15, 'ألانبا غريغوريوس'),
(10, 16, 'مدرسه الاسكندرية'),
(11, 2, 'أدب'),
(12, 7, 'روحيات'),
(13, 4, 'علوم'),
(14, 10, 'اباء اولين'),
(15, 13, '******'),
(16, 14, '******');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `permissions` varchar(255) NOT NULL,
  `birthday` timestamp NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `word_day`
--

CREATE TABLE `word_day` (
  `id` int NOT NULL,
  `random_num` int NOT NULL,
  `content` varchar(500) NOT NULL,
  `source` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `code_2` (`code`);

--
-- Indexes for table `publications`
--
ALTER TABLE `publications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_random` (`post_random`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shelf`
--
ALTER TABLE `shelf`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_number` (`unit_number`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unit_number` (`num`),
  ADD UNIQUE KEY `num` (`num`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `word_day`
--
ALTER TABLE `word_day`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `random_num` (`random_num`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `publications`
--
ALTER TABLE `publications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `shelf`
--
ALTER TABLE `shelf`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `word_day`
--
ALTER TABLE `word_day`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `publications`
--
ALTER TABLE `publications`
  ADD CONSTRAINT `publications_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `shelf`
--
ALTER TABLE `shelf`
  ADD CONSTRAINT `shelf_ibfk_1` FOREIGN KEY (`unit_number`) REFERENCES `unit` (`num`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
