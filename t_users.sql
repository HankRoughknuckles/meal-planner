-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 04, 2013 at 06:59 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `meal_planner`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_users`
--

CREATE TABLE IF NOT EXISTS `t_users` (
  `email` varchar(255) NOT NULL COMMENT 'The username',
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique id for the user in the db',
  `password` text NOT NULL COMMENT 'the hashed password for the user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Stores the users and their account information' AUTO_INCREMENT=8 ;

--
-- Dumping data for table `t_users`
--

INSERT INTO `t_users` (`email`, `id`, `password`) VALUES
('andra@amica.com', 3, '$2a$08$7PWujTMwXsRRfgukg.mdKeNnOfRFCZ0RIvmciozg/d0Uwy59xwO0O'),
('thomas.imorris@gmail.com', 6, '$2a$08$EACAQMuhLt26kyG1r6LIkO8XEkrKaZwiXO74dLfp3AiTpOI4U1p2K'),
('andra.popan@gmail.com', 7, '$2a$08$xdBX5iw9bWieVojH3n.XEevhCcblshHKw7C9i7KHFnUS5mk73vQ2K');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
