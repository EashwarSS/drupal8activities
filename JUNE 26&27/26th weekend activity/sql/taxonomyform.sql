-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2020 at 08:31 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6
 
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
 
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
 
--
-- Database: `drupal8.9`
--
 
-- --------------------------------------------------------
 
--
-- Table structure for table `taxonomyform`
--
 
CREATE TABLE `taxonomyform` (
  `pid` int(11) NOT NULL COMMENT 'Primary Key: Unique person ID.',
  `firstname` varchar(255) NOT NULL DEFAULT '' COMMENT 'Name of the person.',
  `lastname` varchar(255) NOT NULL DEFAULT '' COMMENT 'Creator user''s lastname',
  `bio` varchar(255) NOT NULL DEFAULT '' COMMENT 'bio for the person.',
  `gender` varchar(255) NOT NULL DEFAULT '' COMMENT 'gender for the person.',
  `interest` varchar(255) NOT NULL COMMENT 'taxonomy'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Stores example person entries for demonstration purposes.';
 
--
-- Indexes for dumped tables
--
 
--
-- Indexes for table `taxonomyform`
--
ALTER TABLE `taxonomyform`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `firstname` (`firstname`(191)),
  ADD KEY `lastname` (`lastname`(191)),
  ADD KEY `bio` (`bio`(191)),
  ADD KEY `gender` (`gender`(191)),
  ADD KEY `interset` (`interest`(191));
 
--
-- AUTO_INCREMENT for dumped tables
--
 
--
-- AUTO_INCREMENT for table `taxonomyform`
--
ALTER TABLE `taxonomyform`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key: Unique person ID.';
COMMIT;
 
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;