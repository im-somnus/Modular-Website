-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 19, 2021 at 12:15 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phplogin`
--
CREATE DATABASE IF NOT EXISTS `phplogin` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `phplogin`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(45) NOT NULL,
  `rank` int(11) NOT NULL DEFAULT '2',
  `points` int(11) NOT NULL DEFAULT '0',
  `pfpicture` varchar(100) NOT NULL DEFAULT 'default_pfpic.png',
  `userStatus` int(11) NOT NULL DEFAULT '0',
  `lastActivity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `postCooldown` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `skin` int(11) NOT NULL DEFAULT '9999',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `rank`, `points`, `pfpicture`, `userStatus`, `lastActivity`, `postCooldown`, `skin`) VALUES
(3, 'admin', '21232f297a57a5a743894a0e4a801fc3', 2, 0, 'default_pfpic.png', 0, '2021-04-18 23:27:42', '2021-04-18 23:26:22', 8),
(4, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 2, 261, 'default_pfpic.png', 0, '2020-05-01 21:05:18', '2020-05-01 20:19:18', 8),
(5, 'moderator', '0408f3c997f309c03b08bf3a4bc7b730', 1, 234, 'default_pfpic.png', 0, '2020-05-01 17:04:18', '2020-05-01 17:04:18', 9999);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryTitle` varchar(45) NOT NULL,
  `categoryType` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `categoryTitle_UNIQUE` (`categoryTitle`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `categoryTitle`, `categoryType`) VALUES
(1, 'General Discussion', 'General'),
(2, 'Offtopic', 'General'),
(3, 'Technical Support & Help', 'General'),
(4, 'Updates', 'News'),
(5, 'Patch Notes', 'News'),
(6, 'Development', 'News'),
(7, 'Gitlab Repository', 'News'),
(8, 'General Gameplay Guides', 'Guides'),
(9, 'Character Guides', 'Guides'),
(10, 'Farming Strategies', 'Guides'),
(11, 'Crafting guides', 'Guides');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postDate` datetime NOT NULL,
  `post` varchar(2000) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `accounts_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_thread1_idx` (`thread_id`),
  KEY `fk_post_accounts1_idx` (`accounts_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `postDate`, `post`, `thread_id`, `accounts_id`) VALUES
(11, '2021-04-19 01:26:22', 'Hello :)', 8, 3);

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

DROP TABLE IF EXISTS `shop`;
CREATE TABLE IF NOT EXISTS `shop` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `itemName` varchar(40) NOT NULL,
  `itemDescription` varchar(2000) NOT NULL,
  `itemImage` varchar(500) NOT NULL,
  `itemPrice` int(12) NOT NULL DEFAULT '1500',
  `itemDiscountPercentage` int(2) NOT NULL DEFAULT '0',
  `itemAddedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `itemDiscountStarts` timestamp NULL DEFAULT NULL,
  `itemDiscountEnds` timestamp NULL DEFAULT NULL,
  `itemRemovedDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`itemID`)
) ENGINE=MyISAM AUTO_INCREMENT=10000 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`itemID`, `itemName`, `itemDescription`, `itemImage`, `itemPrice`, `itemDiscountPercentage`, `itemAddedDate`, `itemDiscountStarts`, `itemDiscountEnds`, `itemRemovedDate`) VALUES
(8, 'Invader', 'Alien invaders have come to our forum! Defend our honor from the aliens!', 'assets/images/shop/invader.png', 1500, 0, '2020-05-01 17:26:12', NULL, NULL, NULL),
(9999, 'default', 'default skin', '', 0, 0, '2020-05-02 06:32:31', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

DROP TABLE IF EXISTS `thread`;
CREATE TABLE IF NOT EXISTS `thread` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postTitle` varchar(45) NOT NULL,
  `postDate` datetime NOT NULL,
  `accounts_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_thread_accounts1_idx` (`accounts_id`),
  KEY `fk_thread_category1_idx` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thread`
--

INSERT INTO `thread` (`id`, `postTitle`, `postDate`, `accounts_id`, `category_id`) VALUES
(8, 'Random post!', '2021-04-19 01:26:21', 3, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_accounts1` FOREIGN KEY (`accounts_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_post_thread1` FOREIGN KEY (`thread_id`) REFERENCES `thread` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `thread`
--
ALTER TABLE `thread`
  ADD CONSTRAINT `fk_thread_accounts1` FOREIGN KEY (`accounts_id`) REFERENCES `accounts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_thread_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

DELIMITER $$
--
-- Events
--
DROP EVENT `checkUserStatus`$$
CREATE DEFINER=`root`@`localhost` EVENT `checkUserStatus` ON SCHEDULE EVERY 1 MINUTE STARTS '2020-02-26 01:41:45' ON COMPLETION PRESERVE ENABLE DO UPDATE accounts SET userStatus='0' WHERE lastActivity < CURRENT_TIMESTAMP() - 300$$

DELIMITER ;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
