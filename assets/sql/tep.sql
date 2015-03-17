-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2015 at 01:07 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tep`
--

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trip_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `option` int(11) NOT NULL DEFAULT '1',
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tripId` (`trip_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `trip_id`, `name`, `amount`, `option`, `date`) VALUES
(1, 1, 'Bus Ticket', 157, 1, '2015-03-02'),
(2, 1, 'Auto Fare', 63.5, 1, '2015-03-02'),
(7, 1, 'YoYo', 303, 1, '2015-03-03'),
(8, 1, 'test', 234, 1, '2015-03-03');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `trip_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tripId` (`trip_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `trip_id`) VALUES
(1, 'Prerit Rodney', 1),
(2, 'Bhushan', 1),
(3, 'Abhishek', 1),
(4, 'Dev', 1),
(5, 'Abhinav', 1),
(6, 'Piyush', 1),
(7, 'Vaibhav', 1),
(8, 'Manish', 1),
(9, 'Shank', 1),
(10, 'Nazim Khan', 1),
(11, 'Anurag', 1),
(12, 'Gajju', 1),
(13, 'Vani', 1),
(14, 'Thumati', 1),
(15, 'Vishal', 1),
(17, 'Ajju', 1);

-- --------------------------------------------------------

--
-- Table structure for table `member_expense`
--

CREATE TABLE IF NOT EXISTS `member_expense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberId` int(11) NOT NULL,
  `expenseId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `memberId` (`memberId`),
  KEY `expenseId` (`expenseId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `member_expense`
--

INSERT INTO `member_expense` (`id`, `memberId`, `expenseId`) VALUES
(2, 2, 1),
(16, 3, 8),
(17, 4, 8),
(18, 5, 8),
(21, 1, 7),
(22, 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE IF NOT EXISTS `trips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `name`, `date`, `user_id`) VALUES
(1, 'Final Year Goa ', '2015-03-01', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `member_expense`
--
ALTER TABLE `member_expense`
  ADD CONSTRAINT `member_expense_ibfk_1` FOREIGN KEY (`memberId`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_expense_ibfk_2` FOREIGN KEY (`expenseId`) REFERENCES `expenses` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
