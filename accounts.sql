-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2012 at 04:37 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sample`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `photo` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `name`, `email`, `photo`) VALUES
(11, 'dino999', '13bec5d7c029e50da4be823233aecc7c71e7cefef8a029a3a45125f7d328d148', 'dino', 'sandino_dolosa@yahoo.com', 'C:\\xampp\\tmp\\phpF4C9'),
(12, 'filial999', '16a385dcd949516fdbfc8befdf30f432943d4a8f226686dd320a75bfdc896e33', 'filial', 'sandino_dolosa99@yahoo.com', 'C:\\xampp\\tmp\\phpF4C9'),
(13, 'a', '961b6dd3ede3cb8ecbaacbd68de040cd78eb2ed5889130cceb4c49268ea4d506', 'a', 'sandino.dolosa@beenest-tech.co', ''),
(14, 'dino999s', 'e5072460bea865c1424b74545077718236c9063157bdcb2ff09fb03a4b481545', 'Sandino Dolosa', 'sandino_dolosas@yahoo.com', ''),
(15, 'dino999ss', 'cc01b31a6753ab7fdbcd21bb15f38b0e885adcbc2224b2ff84d0b0c75b67f25d', 'Sandino Dolosa', 'sandino_dolosa999@yahoo.com', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
