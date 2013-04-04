-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2013 at 03:10 PM
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
-- Table structure for table `admin_logs`
--

CREATE TABLE IF NOT EXISTS `admin_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17335 ;

-- --------------------------------------------------------

--
-- Table structure for table `beta`
--

CREATE TABLE IF NOT EXISTS `beta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `b_key` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `channels`
--

CREATE TABLE IF NOT EXISTS `channels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel_id` varchar(255) NOT NULL,
  `server_rtmp` varchar(255) NOT NULL,
  `game` varchar(255) NOT NULL,
  `stream_key` varchar(255) NOT NULL,
  `views` varchar(255) NOT NULL DEFAULT '0',
  `online` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `info1` varchar(2555) NOT NULL,
  `info2` varchar(2555) NOT NULL,
  `info3` varchar(2555) NOT NULL,
  `featured` varchar(255) NOT NULL DEFAULT '0',
  `banned` varchar(255) NOT NULL DEFAULT '0',
  `viewers` varchar(255) NOT NULL DEFAULT '0',
  `subscribers` varchar(255) NOT NULL DEFAULT '0',
  `feature_level` varchar(255) NOT NULL DEFAULT '0',
  `ads` varchar(255) NOT NULL DEFAULT '1',
  `donate` varchar(255) NOT NULL DEFAULT '0',
  `tip_perc` varchar(255) NOT NULL DEFAULT '80',
  `tip_comment` varchar(255) NOT NULL,
  `ad_level` varchar(255) NOT NULL DEFAULT 'high',
  `adsense_video_channel` varchar(255) NOT NULL DEFAULT '7640281454',
  `payment_email` varchar(255) NOT NULL,
  `payment_gateway` varchar(255) NOT NULL,
  `admin` varchar(255) NOT NULL DEFAULT '0',
  `feature_img` varchar(255) NOT NULL,
  `chat_key` varchar(255) NOT NULL,
  `ads_disable` varchar(255) NOT NULL DEFAULT '15',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Table structure for table `channel_options`
--

CREATE TABLE IF NOT EXISTS `channel_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option1` varchar(255) NOT NULL,
  `option2` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `ad1` varchar(2000) NOT NULL,
  `chatad1` varchar(2000) NOT NULL,
  `chatad2` varchar(2000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `chat_bans`
--

CREATE TABLE IF NOT EXISTS `chat_bans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `banned_by` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `banned_until` varchar(255) NOT NULL,
  `banned` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `chat_mods`
--

CREATE TABLE IF NOT EXISTS `chat_mods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `admin` varchar(255) NOT NULL,
  `moderator` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `chat_msg`
--

CREATE TABLE IF NOT EXISTS `chat_msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel_id` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `msg` varchar(2555) NOT NULL,
  `auther` varchar(255) NOT NULL,
  `submitDate` varchar(255) NOT NULL,
  `endDate` varchar(255) NOT NULL,
  `views` varchar(255) NOT NULL,
  `channel` varchar(255) NOT NULL,
  `featured` varchar(255) NOT NULL,
  `startDate` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `game` varchar(255) NOT NULL,
  `featuredShow` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_comments`
--

CREATE TABLE IF NOT EXISTS `event_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auther` varchar(255) NOT NULL,
  `msg` varchar(2555) NOT NULL,
  `dateSend` varchar(255) NOT NULL,
  `event_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_wanna`
--

CREATE TABLE IF NOT EXISTS `event_wanna` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` varchar(255) NOT NULL,
  `viewer` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `startDate` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `frontpage`
--

CREATE TABLE IF NOT EXISTS `frontpage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lol` varchar(255) NOT NULL,
  `dota2` varchar(255) NOT NULL,
  `hon` varchar(255) NOT NULL,
  `sc2` varchar(255) NOT NULL,
  `wow` varchar(255) NOT NULL,
  `cod` varchar(255) NOT NULL,
  `mine` varchar(255) NOT NULL,
  `other` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `kbase`
--

CREATE TABLE IF NOT EXISTS `kbase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `auther` varchar(255) NOT NULL,
  `msg` varchar(2555) NOT NULL,
  `dateSend` varchar(255) NOT NULL,
  `cat` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `login_log`
--

CREATE TABLE IF NOT EXISTS `login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=115 ;

-- --------------------------------------------------------

--
-- Table structure for table `partner_payments`
--

CREATE TABLE IF NOT EXISTS `partner_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `partner_channel_id` varchar(255) NOT NULL,
  `ads_amount` varchar(255) NOT NULL,
  `tips_amount` varchar(255) NOT NULL,
  `for_month` varchar(255) NOT NULL,
  `skrill_trans_id` varchar(255) NOT NULL,
  `to_email` varchar(255) NOT NULL,
  `send_date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `partner_payments_to_do`
--

CREATE TABLE IF NOT EXISTS `partner_payments_to_do` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `partner_id` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `done` varchar(255) NOT NULL,
  `info` varchar(255) NOT NULL,
  `item_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscribtions`
--

CREATE TABLE IF NOT EXISTS `subscribtions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fan_channel_id` varchar(255) NOT NULL,
  `owner_channel_id` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `msg` varchar(25555) NOT NULL,
  `isTicket` varchar(255) NOT NULL,
  `isReply` varchar(255) NOT NULL,
  `replySender` varchar(255) NOT NULL,
  `originTicketID` varchar(255) NOT NULL,
  `isStaff` varchar(255) NOT NULL,
  `dateSend` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `partner` varchar(255) NOT NULL,
  `banned` varchar(255) NOT NULL,
  `userName` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

-- --------------------------------------------------------

--
-- Table structure for table `tips`
--

CREATE TABLE IF NOT EXISTS `tips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` varchar(255) NOT NULL,
  `rec_id` varchar(255) NOT NULL,
  `usd` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `2co_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tips_payza`
--

CREATE TABLE IF NOT EXISTS `tips_payza` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `streamer` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `testing` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `paid` varchar(255) NOT NULL,
  `item_code` varchar(255) NOT NULL,
  `gateway` varchar(255) NOT NULL,
  `trans_id` varchar(255) NOT NULL,
  `payer_email` varchar(255) NOT NULL,
  `paypal_fee` varchar(255) NOT NULL,
  `p_day` varchar(255) NOT NULL,
  `p_month` varchar(255) NOT NULL,
  `p_year` varchar(255) NOT NULL,
  `pending` varchar(255) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `display_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `short_bio` varchar(2555) NOT NULL,
  `long_bio` varchar(2555) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `channel_id` varchar(255) NOT NULL,
  `banned` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `admin` varchar(255) NOT NULL DEFAULT '0',
  `partner` varchar(255) NOT NULL DEFAULT '0',
  `reg_date` varchar(255) NOT NULL,
  `activate_id` varchar(255) NOT NULL,
  `pw_reset` varchar(255) NOT NULL DEFAULT '1',
  `first_time_login` varchar(255) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
