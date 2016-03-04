-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 04 Mars 2016 à 16:14
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `pji`
--

-- --------------------------------------------------------

--
-- Structure de la table `tree`
--

CREATE TABLE IF NOT EXISTS `tree` (
  `PK_tree` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `image` varchar(30) NOT NULL,
  `oxygen_factor` int(11) NOT NULL,
  PRIMARY KEY (`PK_tree`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `tree`
--

INSERT INTO `tree` (`PK_tree`, `name`, `image`, `oxygen_factor`) VALUES
(1, 'Chêne', 'oak.png', 20),
(2, 'Pin', 'pine.png', 18);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `PK_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `actual_score` int(11) NOT NULL DEFAULT '0',
  `best_score` int(11) NOT NULL DEFAULT '0',
  `date_register` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_last_login` datetime DEFAULT NULL,
  `auth_level` varchar(5) NOT NULL DEFAULT 'ok',
  PRIMARY KEY (`PK_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`PK_user`, `username`, `password`, `actual_score`, `best_score`, `date_register`, `date_last_login`, `auth_level`) VALUES
(1, 'aaa', '$6lg.gqkOafmo', 0, 0, '2016-02-28 14:47:16', '2016-03-04 14:32:27', 'ok'),
(2, 'bbb', '$64VpQZON8slY', 0, 0, '2016-03-04 14:31:51', NULL, 'ok'),
(3, 'ccc', '$6hcCB2DaTbkI', 0, 0, '2016-03-04 14:31:58', NULL, 'ok'),
(4, 'ddd', '$6hQ57VN/Y0lk', 0, 0, '2016-03-04 14:32:02', NULL, 'ok');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
