-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 24, 2022 at 07:38 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `msn_fast`
--

-- --------------------------------------------------------

--
-- Table structure for table `dashboardmanagement_boards`
--

DROP TABLE IF EXISTS `dashboardmanagement_boards`;
CREATE TABLE IF NOT EXISTS `dashboardmanagement_boards` (
  `id` varchar(200) NOT NULL,
  `title` varchar(256) DEFAULT '',
  `description` varchar(256) DEFAULT '',
  `timeAdded` varchar(256) DEFAULT NULL,
  `userId` varchar(256) DEFAULT '',
  `prompt_time` varchar(256) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dashboardmanagement_boards`
--

INSERT INTO `dashboardmanagement_boards` (`id`, `title`, `description`, `timeAdded`, `userId`, `prompt_time`) VALUES
('8UYJHQGVT8', 'sadasd', 'asd', '1648126643', 'H01V89SHHX', '00:09');

-- --------------------------------------------------------

--
-- Table structure for table `dashboardmanagement_board_cards`
--

DROP TABLE IF EXISTS `dashboardmanagement_board_cards`;
CREATE TABLE IF NOT EXISTS `dashboardmanagement_board_cards` (
  `id` varchar(256) NOT NULL,
  `title` varchar(256) DEFAULT '',
  `description` varchar(256) DEFAULT '',
  `boxId` varchar(256) DEFAULT '',
  `boardId` varchar(256) DEFAULT '',
  `userId` varchar(256) DEFAULT '',
  `timeAdded` varchar(256) DEFAULT '',
  `assigned_to` varchar(256) DEFAULT '',
  `label` varchar(256) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dashboardmanagement_board_cards`
--

INSERT INTO `dashboardmanagement_board_cards` (`id`, `title`, `description`, `boxId`, `boardId`, `userId`, `timeAdded`, `assigned_to`, `label`) VALUES
('ZFPA0VF3TP', 'in ehre', 'asd', 'PROGRESS', '8UYJHQGVT8', 'H01V89SHHX', '1648145996', '', 'Low'),
('ZNFGSYLY1C', 'awdij', 'asd', 'DONE', '8UYJHQGVT8', 'H01V89SHHX', '1648145127', '', 'Low'),
('RV9G0WFMRX', 'ffsda', 'asd', 'CODE REVIEW', '8UYJHQGVT8', 'H01V89SHHX', '1648145121', '', 'Low'),
('ET008A60UH', 'ads', 'asd', 'TODO', '9D0SOWGLLJ', 'H01V89SHHX', '1648150378', '', 'Low'),
('SCLIFYTWYN', 'asd', 'asd', 'PROGRESS', '8UYJHQGVT8', 'H01V89SHHX', '1648145114', '', 'Low'),
('JAFFZWKJSX', 'asd', 'asd', 'DONE', '8UYJHQGVT8', 'H01V89SHHX', '1648145100', 'LVBDOC3QNH', 'High');

-- --------------------------------------------------------

--
-- Table structure for table `dashboardmanagement_board_users`
--

DROP TABLE IF EXISTS `dashboardmanagement_board_users`;
CREATE TABLE IF NOT EXISTS `dashboardmanagement_board_users` (
  `id` varchar(256) NOT NULL,
  `userId` varchar(256) DEFAULT '',
  `boardId` varchar(256) DEFAULT '',
  `timeAdded` varchar(256) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dashboardmanagement_board_users`
--

INSERT INTO `dashboardmanagement_board_users` (`id`, `userId`, `boardId`, `timeAdded`) VALUES
('9D0SOWGLLJ', 'LVBDOC3QNH', '8UYJHQGVT8', '1648133897');

-- --------------------------------------------------------

--
-- Table structure for table `dashboardmanagement_users`
--

DROP TABLE IF EXISTS `dashboardmanagement_users`;
CREATE TABLE IF NOT EXISTS `dashboardmanagement_users` (
  `id` varchar(256) NOT NULL,
  `name` varchar(256) DEFAULT '',
  `email` varchar(256) DEFAULT '',
  `password` varchar(256) DEFAULT '',
  `first_name` varchar(256) DEFAULT '',
  `last_name` varchar(256) DEFAULT '',
  `timeAdded` varchar(256) DEFAULT '',
  `prompt_user` varchar(256) DEFAULT '',
  `boardId` varchar(256) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dashboardmanagement_users`
--

INSERT INTO `dashboardmanagement_users` (`id`, `name`, `email`, `password`, `first_name`, `last_name`, `timeAdded`, `prompt_user`, `boardId`) VALUES
('H01V89SHHX', 'fnamelname', 'admin@portal.com', '3cce45bf21f047a954e1861c653a14ba', 'fname', 'lname', 'time()', 'No', '8UYJHQGVT8'),
('LVBDOC3QNH', 'checkcheeck', 'assd@gmas.cim', '3cce45bf21f047a954e1861c653a14ba', 'check', 'cheeck', '1648126126', 'Yes', '8UYJHQGVT8');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
