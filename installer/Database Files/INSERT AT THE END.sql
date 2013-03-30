-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2013 at 09:58 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `live`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game` varchar(255) NOT NULL,
  `viewers` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `short` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `game`, `viewers`, `img`, `short`) VALUES
(1, 'League Of Legends', '0', './images/frontpage/lol_normal.png', 'lol'),
(3, 'Dota 2', '0', './images/frontpage/dota2_normal.png', 'dota2'),
(4, 'Heroes of Newerth', '0', './images/frontpage/hon_normal.png', 'hon'),
(5, 'Star Craft 2', '0', './images/frontpage/sc2_normal.png', 'sc2'),
(6, 'Minecraft', '0', './images/frontpage/minecraft_normal.png', 'minecraft'),
(7, 'World Of Warcraft', '0', './images/frontpage/wow_normal.png', 'wow'),
(10, 'Call Of Duty', '0', './images/frontpage/cod_normal.png', 'callofduty');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


INSERT INTO `users` (`id`, `display_name`, `email`, `password`, `avatar`, `short_bio`, `long_bio`, `timezone`, `channel_id`, `banned`, `active`, `admin`, `partner`, `reg_date`, `activate_id`, `pw_reset`, `first_time_login`) VALUES
(1, 'admin', 'admin@admin.com', 'admin123', '', '', '', '', 'admin', '0', '1', '1', '1', '????-??-??', '0', '1', '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

