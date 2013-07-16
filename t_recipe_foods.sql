-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2013 at 08:30 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `calorie_calculator`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_recipe_foods`
--

CREATE TABLE IF NOT EXISTS `t_recipe_foods` (
  `food_id` int(11) DEFAULT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `amount` decimal(10,0) DEFAULT NULL,
  `liquid_measurement` tinyint(4) DEFAULT NULL,
  KEY `food_id` (`food_id`),
  KEY `recipe_id` (`recipe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_recipe_foods`
--
ALTER TABLE `t_recipe_foods`
  ADD CONSTRAINT `t_recipe_foods_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `t_foods` (`id`),
  ADD CONSTRAINT `t_recipe_foods_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `t_recipes` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
