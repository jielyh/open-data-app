-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 27, 2012 at 01:59 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hills`
--

-- --------------------------------------------------------

--
-- Table structure for table `hills`
--

CREATE TABLE IF NOT EXISTS `hills` (
  `id` int(100) NOT NULL,
  `name` varchar(250) NOT NULL,
  `longitude` varchar(250) NOT NULL,
  `latitude` varchar(250) NOT NULL,
  `address` varchar(250) NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hills`
--

INSERT INTO `hills` (`id`, `name`, `longitude`, `latitude`, `address`) VALUES
(1, 'Beggar''s Canyon', '415100N', '0873900W', '1022 Tatooine Rd'),
(2, 'Kessel Run', '653400N', '098400W', '12 Parsecs Ave'),
(3, 'Alderaan Peak', '435600N', '123500W', 'Nonexistant Blvd'),
(4, 'Death Star Moutain', '563800N', '356400W', 'Nomoon Rd'),
(5, 'Endor Trail', '534200N', '238700W', 'Forestpine Cres');
