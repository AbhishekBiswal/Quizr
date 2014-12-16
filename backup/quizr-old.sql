-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 19, 2012 at 05:59 PM
-- Server version: 5.5.24
-- PHP Version: 5.3.10-1ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `quizr`
--

-- --------------------------------------------------------

--
-- Table structure for table `cats`
--

CREATE TABLE IF NOT EXISTS `cats` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `played`
--

CREATE TABLE IF NOT EXISTS `played` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qid` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `playedtill` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `played`
--

INSERT INTO `played` (`id`, `qid`, `user`, `playedtill`) VALUES
(2, 12, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(100) NOT NULL,
  `answer` varchar(100) NOT NULL,
  `qid` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `qdesc` text,
  `seq` int(11) NOT NULL DEFAULT '0',
  `dt` datetime NOT NULL,
  `hashint` int(11) NOT NULL,
  `hint` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `answer`, `qid`, `user`, `qdesc`, `seq`, `dt`, `hashint`, `hint`) VALUES
(1, 'dfdfddddddddd', 'ssssssssss', 5, 1, 'aaaaaaaaaaaaaaaa', 19, '0000-00-00 00:00:00', 0, ''),
(2, 'dfdfddddddddd', 'ssssssssss', 5, 1, 'aaaaaaaaaaaaaaaa', 20, '0000-00-00 00:00:00', 0, ''),
(3, 'Hello,', 'd;wef', 6, 1, 'jJJJdnwelfwe;fmwejwe', 1, '0000-00-00 00:00:00', 0, ''),
(4, 'zzzzz', 'zzzzzzzzzzzzzz', 10, 1, 'zzzzzzzzzz', 3, '0000-00-00 00:00:00', 0, ''),
(5, 'yes or no?', 'yes', 11, 1, 'yes or no?', 1, '0000-00-00 00:00:00', 1, ''),
(6, 'Who is the CEO of Google Inc ?', 'larrypage', 12, 1, '', 1, '0000-00-00 00:00:00', 0, ''),
(7, 'Who is the Founder of Virgin Atlantic?', 'larryellision', 12, 1, '', 2, '0000-00-00 00:00:00', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `quizmeta`
--

CREATE TABLE IF NOT EXISTS `quizmeta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `user` int(11) NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `qdesc` text NOT NULL,
  `questions` int(11) NOT NULL,
  `plays` int(11) NOT NULL,
  `cat` int(11) NOT NULL,
  `pub` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `quizmeta`
--

INSERT INTO `quizmeta` (`id`, `title`, `user`, `dt`, `qdesc`, `questions`, `plays`, `cat`, `pub`) VALUES
(1, 'First Quiz', 1, '2012-07-21 16:39:47', 'First Quiz :P', 0, 0, 0, 0),
(2, 'First Quiz (2)', 1, '2012-07-24 09:04:57', 'First Quiz', 0, 0, 0, 0),
(3, 'Butter Ketchup', 5, '2012-07-28 08:42:05', 'liked Exun Clan', 0, 0, 0, 0),
(4, '3{Jeet}', 5, '2012-07-28 09:55:11', 'hello!', 0, 0, 0, 0),
(5, 'Tuk Tuk', 1, '2012-07-28 10:44:59', 'Taanish :P', 20, 0, 0, 0),
(6, 'Tanish', 1, '2012-07-28 11:11:37', 'Hellooo', 1, 0, 0, 0),
(7, 'About Butter', 1, '2012-07-28 11:58:07', 'About Bharat Kashyap', 0, 0, 0, 0),
(8, 'Test Quiz', 1, '2012-07-28 12:16:06', 'Testing', 0, 0, 0, 0),
(9, '/lisa', 1, '2012-07-28 12:28:22', 'Hackathon', 3, 0, 0, 0),
(10, 'Hey Hello', 1, '2012-08-06 12:32:33', 'Hey Hello\r\n', 3, 0, 0, 0),
(11, 'Finalize the Design', 1, '2012-08-08 14:05:17', 'Do it!', 1, 0, 0, 0),
(12, 'Quiz 1', 1, '2012-09-28 07:28:18', 'Test Quiz', 2, 0, 0, 0),
(13, 'A New Quiz :D', 1, '2012-10-17 12:14:38', 'New Quiz == Awesome Quiz', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `oauthp` varchar(10) NOT NULL,
  `oauthid` text NOT NULL,
  `bio` text,
  `points` int(11) NOT NULL,
  `lastlogged` int(11) NOT NULL,
  `fbusername` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `oauthp`, `oauthid`, `bio`, `points`, `lastlogged`, `fbusername`) VALUES
(1, 'Abhishek Biswal', NULL, 'facebook', '100002469580942', '', 0, 0, 'AbhishekBiswal2');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
