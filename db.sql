-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 01, 2015 at 04:57 PM
-- Server version: 5.6.13
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db539137818`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `is_dir` tinyint(4) DEFAULT NULL,
  `id_parent_file` int(11) unsigned DEFAULT NULL,
  `id_user` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_files_id_parent_file` (`id_parent_file`),
  KEY `fk_files_id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `friends_requests`
--

CREATE TABLE IF NOT EXISTS `friends_requests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_emitter` int(11) unsigned DEFAULT NULL,
  `id_receiver` int(11) unsigned DEFAULT NULL,
  `date_sending` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_friends_requests_id_emitter` (`id_emitter`),
  KEY `fk_friends_requests_id_receiver` (`id_receiver`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `locales`
--

CREATE TABLE IF NOT EXISTS `locales` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `locales`
--

INSERT INTO `locales` (`id`, `name`) VALUES
(1, 'fr_FR'),
(2, 'en_US');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(254) DEFAULT NULL,
  `is_email_verified` tinyint(1) DEFAULT NULL,
  `password` char(40) DEFAULT NULL,
  `date_subscription` datetime DEFAULT NULL,
  `id_user_group` int(11) unsigned DEFAULT NULL,
  `id_locale_website` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_id_user_group` (`id_user_group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `users2friends`
--

CREATE TABLE IF NOT EXISTS `users2friends` (
  `id_users` int(11) unsigned NOT NULL,
  `id_friends` int(11) unsigned NOT NULL,
  KEY `fk_users2friends_users$users2users` (`id_users`),
  KEY `fk_users2friends_friends$users2users` (`id_friends`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users2locales_comics`
--

CREATE TABLE IF NOT EXISTS `users2locales_comics` (
  `id_users` int(11) unsigned NOT NULL,
  `id_locales_comics` int(11) unsigned NOT NULL,
  KEY `fk_users2locales_comics_users$users2locales` (`id_users`),
  KEY `fk_users2locales_comics_locales_comics$users2locales` (`id_locales_comics`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `can_remove_other_files` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `name`, `can_remove_other_files`) VALUES
(0, 'Anonyme', 0),
(1, 'Membre simple', 0),
(2, 'Admin', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `fk_files_id_parent_file` FOREIGN KEY (`id_parent_file`) REFERENCES `files` (`id`),
  ADD CONSTRAINT `fk_files_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `friends_requests`
--
ALTER TABLE `friends_requests`
  ADD CONSTRAINT `fk_friends_requests_id_emitter` FOREIGN KEY (`id_emitter`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_friends_requests_id_receiver` FOREIGN KEY (`id_receiver`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_id_user_group` FOREIGN KEY (`id_user_group`) REFERENCES `users_groups` (`id`);

--
-- Constraints for table `users2friends`
--
ALTER TABLE `users2friends`
  ADD CONSTRAINT `users2friends_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users2friends_ibfk_2` FOREIGN KEY (`id_friends`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users2locales_comics`
--
ALTER TABLE `users2locales_comics`
  ADD CONSTRAINT `users2locales_comics_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users2locales_comics_ibfk_2` FOREIGN KEY (`id_locales_comics`) REFERENCES `locales` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
