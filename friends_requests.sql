-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 25 Janvier 2015 à 17:41
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `shyco`
--

-- --------------------------------------------------------

--
-- Structure de la table `friends_requests`
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

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `friends_requests`
--
ALTER TABLE `friends_requests`
  ADD CONSTRAINT `fk_friends_requests_id_emitter` FOREIGN KEY (`id_emitter`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_friends_requests_id_receiver` FOREIGN KEY (`id_receiver`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
