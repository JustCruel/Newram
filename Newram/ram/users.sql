-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2024 at 07:57 PM
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
-- Database: `tourist`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `birthday` varchar(10) NOT NULL,
  `age` int(3) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `middlename`, `birthday`, `age`, `gender`, `email`, `username`, `password`) VALUES
(1, 'dsadadsad', 'dasdsa', '', '', 0, '', 'dasddsada@gmail.com', '', '12345'),
(2, 'dsadadsad', 'dasdsa', '', '', 0, '', 'dasddsada@gmail.com', '', '12345'),
(3, 'dsadadsad', 'dasdsa', '', '', 0, '', 'dasddsada@gmail.com', '', '12345'),
(4, '', 'dasdsa', '', '', 0, '', 'dasddsada@gmail.com', '', '123456'),
(5, 'dsadadsad', 'dasdsa', '', '', 0, '', 'dasddsada@gmail.com', '', '12345'),
(6, 'dsadadsad', 'dasdsa', '', '', 0, '', 'dasddsada@gmail.com', '', '12345'),
(7, 'dsadadsad', 'dasdsa', '', '', 0, '', 'dasddsada@gmail.com', '', '12345'),
(8, 'dsadadsad', 'dasdsa', '', '', 0, '', 'asdsa@gmail.com', '', '12345'),
(9, 'dsadadsad', 'dasdsa', '', '', 0, '', 'dasddsada@gmail.com', '', '12345'),
(10, 'dsadadsad', 'dasdsadasd', '', '', 0, '', 'gamer.gamer3384@gmail.com', '', '123'),
(11, 'dsadadsad', 'dasdsa', '', '', 0, '', 'dsadsa@gmail.com', '', '123'),
(12, 'dsadadsad', 'dasdsadasd', '', '', 0, '', 'dasddsada@gmail.com', '', '12'),
(13, 'dsadadsad', 'dasdsa', '', '', 0, '', 'dsadsa@gmail.com', '', '12'),
(14, 'dsadadsad', 'dasdsadasd', '', '', 0, '', 'gamer.gamer3384@gmail.com', '', '1'),
(15, 'dsad', 'dsad', 'asd', '2024-04-09', 2, '2', 'dasddsada@gmail.com', 'root', '123'),
(16, 'dsad', 'das', 'dsa', '2024-04-23', 2, '2', 'dasddsada@gmail.com', 'gamer08', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
