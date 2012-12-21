-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 15, 2012 at 02:50 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hrcloud`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE IF NOT EXISTS `applicants` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `jobapplyed` varchar(255) NOT NULL,
  `jobid` varchar(255) DEFAULT NULL,
  `notes` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `name`, `address`, `address2`, `city`, `state`, `zip`, `phone`, `email`, `jobapplyed`, `jobid`, `notes`) VALUES
(1, 'bobby bob', '7272 oak run drive', '#43', 'medina', 'ohio', '44256', '330-4343-34334', 'who@what.com', '2', NULL, 'great invertviewie'),
(2, 'name test', 'test address', 'test address', 'test city', 'test state', 'test zip', 'test phone', 'test email', '5', NULL, 'test notes should be jobid5'),
(3, 'name test2', 'test address2', 'test address22', 't2', 'tes', 'test', 'test', 'tests', '2', NULL, 'fgasg'),
(4, 'name test', 'test address', 'test address', 't', 't', 't', 't', 't', '9', '2', 'awrgqw'),
(5, 't', 't', 't', 't', 't', 't', 't', 't', '5', NULL, 'arwgrgafgs');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `jobtitle` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `opendate` date NOT NULL,
  `closedate` date DEFAULT NULL,
  `closedoropen` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `jobtitle`, `company`, `location`, `opendate`, `closedate`, `closedoropen`) VALUES
(1, 'job title one test', '', 'medina, ohio', '2012-12-03', '2012-12-13', 'closed'),
(2, 'job title two test', '', 'medina, ohio', '2012-12-04', '2012-12-30', 'open'),
(3, 'testjob 8:43', '', 'cleveland, ohio', '2012-12-10', '2012-12-31', 'open'),
(4, 'aaa', '', 'location1', '2012-12-11', NULL, 'closed'),
(5, 'zzz', '', 'location1', '2012-12-11', NULL, 'closed'),
(6, 'aaa', '', 'adfad', '2012-12-10', NULL, 'open'),
(7, 'aaaaa', '', 'favaga', '2012-12-11', NULL, ''),
(8, 'test', '', 'test location', '2012-12-26', NULL, 'open'),
(9, 'testjopb 121212', '', 'ohio', '2012-12-12', NULL, 'open'),
(10, 'zzz2', '', 'zzzohio', '2012-12-12', NULL, 'open'),
(11, 'test', '', 'test', '0000-00-00', NULL, 'open'),
(12, 'test', 'testte', 'test', '2012-12-13', NULL, 'open'),
(13, 'ghigdkh', 'hkjdhnj', '1ghkjdgh', '2012-12-13', NULL, 'open'),
(14, 'hkldhkmg', 'bhkmdgkl', 'nhkmldggkh', '2012-12-13', NULL, 'open'),
(15, 'ryhkldshk', 'dgthkhk', 'hkdfhkdf', '2012-12-03', NULL, 'open');

-- --------------------------------------------------------

--
-- Table structure for table `staffmembers`
--

CREATE TABLE IF NOT EXISTS `staffmembers` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `staffmembers`
--

INSERT INTO `staffmembers` (`id`, `username`, `password`, `email`, `name`) VALUES
(1, 'admin', 'admin', 'staff', 'staff');
