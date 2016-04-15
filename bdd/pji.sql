-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 15 Avril 2016 à 14:14
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
-- Structure de la table `asso_user_tree`
--

CREATE TABLE IF NOT EXISTS `asso_user_tree` (
  `PK_asso_user_tree` int(11) NOT NULL AUTO_INCREMENT,
  `FK_user` int(11) NOT NULL,
  `nb_row` int(11) NOT NULL,
  `nb_column` int(11) NOT NULL,
  `FK_tree` int(11) NOT NULL,
  PRIMARY KEY (`PK_asso_user_tree`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `asso_user_tree`
--

INSERT INTO `asso_user_tree` (`PK_asso_user_tree`, `FK_user`, `nb_row`, `nb_column`, `FK_tree`) VALUES
(1, 1, 2, 10, 2),
(2, 1, 3, 9, 3),
(3, 1, 4, 1, 1),
(4, 1, 6, 10, 1),
(5, 1, 7, 10, 1),
(6, 1, 1, 8, 3),
(7, 1, 4, 5, 4),
(8, 1, 3, 3, 4),
(9, 1, 1, 3, 1),
(10, 1, 5, 6, 1),
(11, 1, 3, 5, 1),
(12, 1, 0, 2, 1),
(13, 1, 0, 6, 1),
(14, 1, 4, 14, 1);

-- --------------------------------------------------------

--
-- Structure de la table `board_element`
--

CREATE TABLE IF NOT EXISTS `board_element` (
  `PK_board_element` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `nb_row` int(11) NOT NULL,
  `nb_column` int(11) NOT NULL,
  `oxygen` int(11) NOT NULL DEFAULT '0',
  `water` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`PK_board_element`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=145 ;

--
-- Contenu de la table `board_element`
--

INSERT INTO `board_element` (`PK_board_element`, `type`, `nb_row`, `nb_column`, `oxygen`, `water`) VALUES
(1, 'town', 0, 0, 70000, 0),
(2, 'empty', 0, 1, 1000, 100),
(3, 'empty', 0, 2, 1000, 100),
(4, 'empty', 0, 3, 1000, 100),
(5, 'empty', 0, 4, 1000, 100),
(6, 'empty', 0, 5, 1000, 100),
(7, 'empty', 0, 6, 1000, 100),
(8, 'empty', 0, 7, 1000, 100),
(9, 'town', 0, 8, 70000, 0),
(10, 'empty', 0, 9, 1000, 100),
(11, 'empty', 0, 10, 1000, 100),
(12, 'empty', 0, 11, 1000, 100),
(13, 'empty', 0, 12, 1000, 100),
(14, 'empty', 0, 13, 1000, 100),
(15, 'river', 0, 14, 0, 200),
(16, 'empty', 0, 15, 1000, 100),
(17, 'empty', 1, 0, 1000, 100),
(18, 'empty', 1, 1, 1000, 100),
(19, 'empty', 1, 2, 1000, 100),
(20, 'empty', 1, 3, 1000, 100),
(21, 'town', 1, 4, 70000, 0),
(22, 'town', 1, 5, 70000, 0),
(23, 'empty', 1, 6, 1000, 100),
(24, 'empty', 1, 7, 1000, 100),
(25, 'empty', 1, 8, 1000, 100),
(26, 'empty', 1, 9, 1000, 100),
(27, 'empty', 1, 10, 1000, 100),
(28, 'town', 1, 11, 70000, 0),
(29, 'town', 1, 12, 70000, 0),
(30, 'river', 1, 13, 0, 200),
(31, 'river', 1, 14, 0, 200),
(32, 'empty', 1, 15, 1000, 100),
(33, 'empty', 2, 0, 1000, 100),
(34, 'empty', 2, 1, 1000, 100),
(35, 'river', 2, 2, 0, 200),
(36, 'river', 2, 3, 0, 200),
(37, 'river', 2, 4, 0, 200),
(38, 'river', 2, 5, 0, 200),
(39, 'river', 2, 6, 0, 200),
(40, 'river', 2, 7, 0, 200),
(41, 'empty', 2, 8, 1000, 100),
(42, 'empty', 2, 9, 1000, 100),
(43, 'empty', 2, 10, 1000, 100),
(44, 'town', 2, 11, 70000, 0),
(45, 'town', 2, 12, 70000, 0),
(46, 'river', 2, 13, 0, 200),
(47, 'empty', 2, 14, 1000, 100),
(48, 'empty', 2, 15, 1000, 100),
(49, 'empty', 3, 0, 1000, 100),
(50, 'empty', 3, 1, 1000, 100),
(51, 'river', 3, 2, 0, 200),
(52, 'empty', 3, 3, 1000, 100),
(53, 'empty', 3, 4, 1000, 100),
(54, 'empty', 3, 5, 1000, 100),
(55, 'empty', 3, 6, 1000, 100),
(56, 'river', 3, 7, 0, 200),
(57, 'empty', 3, 8, 1000, 100),
(58, 'empty', 3, 9, 1000, 100),
(59, 'empty', 3, 10, 1000, 100),
(60, 'empty', 3, 11, 1000, 100),
(61, 'empty', 3, 12, 1000, 100),
(62, 'river', 3, 13, 0, 200),
(63, 'empty', 3, 14, 1000, 100),
(64, 'empty', 3, 15, 1000, 100),
(65, 'empty', 4, 0, 1000, 100),
(66, 'empty', 4, 1, 1000, 100),
(67, 'river', 4, 2, 0, 200),
(68, 'empty', 4, 3, 1000, 100),
(69, 'empty', 4, 4, 1000, 100),
(70, 'empty', 4, 5, 1000, 100),
(71, 'empty', 4, 6, 1000, 100),
(72, 'river', 4, 7, 0, 200),
(73, 'river', 4, 8, 0, 200),
(74, 'river', 4, 9, 0, 200),
(75, 'river', 4, 10, 0, 200),
(76, 'river', 4, 11, 0, 200),
(77, 'river', 4, 12, 0, 200),
(78, 'river', 4, 13, 0, 200),
(79, 'empty', 4, 14, 1000, 100),
(80, 'empty', 4, 15, 1000, 100),
(81, 'empty', 5, 0, 1000, 100),
(82, 'empty', 5, 1, 1000, 100),
(83, 'river', 5, 2, 0, 200),
(84, 'town', 5, 3, 70000, 0),
(85, 'town', 5, 4, 70000, 0),
(86, 'empty', 5, 5, 1000, 100),
(87, 'empty', 5, 6, 1000, 100),
(88, 'empty', 5, 7, 1000, 100),
(89, 'town', 5, 8, 70000, 0),
(90, 'empty', 5, 9, 1000, 100),
(91, 'empty', 5, 10, 1000, 100),
(92, 'empty', 5, 11, 1000, 100),
(93, 'town', 5, 12, 70000, 0),
(94, 'town', 5, 13, 70000, 0),
(95, 'empty', 5, 14, 1000, 100),
(96, 'empty', 5, 15, 1000, 100),
(97, 'empty', 6, 0, 1000, 100),
(98, 'empty', 6, 1, 1000, 100),
(99, 'river', 6, 2, 0, 200),
(100, 'town', 6, 3, 70000, 0),
(101, 'town', 6, 4, 70000, 0),
(102, 'empty', 6, 5, 1000, 100),
(103, 'empty', 6, 6, 1000, 100),
(104, 'empty', 6, 7, 1000, 100),
(105, 'empty', 6, 8, 1000, 100),
(106, 'empty', 6, 9, 1000, 100),
(107, 'empty', 6, 10, 1000, 100),
(108, 'empty', 6, 11, 1000, 100),
(109, 'empty', 6, 12, 1000, 100),
(110, 'empty', 6, 13, 1000, 100),
(111, 'empty', 6, 14, 1000, 100),
(112, 'empty', 6, 15, 1000, 100),
(113, 'empty', 7, 0, 1000, 100),
(114, 'empty', 7, 1, 1000, 100),
(115, 'river', 7, 2, 0, 200),
(116, 'river', 7, 3, 0, 200),
(117, 'river', 7, 4, 0, 200),
(118, 'river', 7, 5, 0, 200),
(119, 'river', 7, 6, 0, 200),
(120, 'town', 7, 7, 70000, 0),
(121, 'empty', 7, 8, 1000, 100),
(122, 'empty', 7, 9, 1000, 100),
(123, 'empty', 7, 10, 1000, 100),
(124, 'empty', 7, 11, 1000, 100),
(125, 'empty', 7, 12, 1000, 100),
(126, 'town', 7, 13, 70000, 0),
(127, 'empty', 7, 14, 1000, 100),
(128, 'empty', 7, 15, 1000, 100),
(129, 'empty', 8, 0, 1000, 100),
(130, 'empty', 8, 1, 1000, 100),
(131, 'town', 8, 2, 70000, 0),
(132, 'empty', 8, 3, 1000, 100),
(133, 'empty', 8, 4, 1000, 100),
(134, 'empty', 8, 5, 1000, 100),
(135, 'river', 8, 6, 0, 200),
(136, 'town', 8, 7, 70000, 0),
(137, 'empty', 8, 8, 1000, 100),
(138, 'empty', 8, 9, 1000, 100),
(139, 'empty', 8, 10, 1000, 100),
(140, 'empty', 8, 11, 1000, 100),
(141, 'empty', 8, 12, 1000, 100),
(142, 'town', 8, 13, 70000, 0),
(143, 'empty', 8, 14, 1000, 100),
(144, 'empty', 8, 15, 1000, 100);

-- --------------------------------------------------------

--
-- Structure de la table `tree`
--

CREATE TABLE IF NOT EXISTS `tree` (
  `PK_tree` int(11) NOT NULL AUTO_INCREMENT,
  `tree_type` varchar(30) NOT NULL,
  `cost` int(11) NOT NULL DEFAULT '5000',
  `image` varchar(30) NOT NULL,
  `default_oxygen_give` int(11) NOT NULL,
  `water_need` int(11) NOT NULL DEFAULT '200',
  PRIMARY KEY (`PK_tree`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `tree`
--

INSERT INTO `tree` (`PK_tree`, `tree_type`, `cost`, `image`, `default_oxygen_give`, `water_need`) VALUES
(1, 'Chêne', 9000, 'oak.png', 20, 200),
(2, 'Pin', 8000, 'pine.png', 18, 180),
(3, 'Hêtre', 7000, 'beech.png', 16, 160),
(4, 'Epicéa', 10000, 'spruce.png', 22, 220);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `PK_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `money` int(11) NOT NULL DEFAULT '1000000',
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

INSERT INTO `user` (`PK_user`, `username`, `password`, `money`, `actual_score`, `best_score`, `date_register`, `date_last_login`, `auth_level`) VALUES
(1, 'aaa', '$6lg.gqkOafmo', 877000, 0, 0, '2016-02-28 14:47:16', '2016-04-15 13:43:59', 'ok'),
(2, 'bbb', '$64VpQZON8slY', 1000000, 0, 0, '2016-03-04 14:31:51', NULL, 'ok'),
(3, 'ccc', '$6hcCB2DaTbkI', 1000000, 0, 0, '2016-03-04 14:31:58', NULL, 'ok'),
(4, 'ddd', '$6hQ57VN/Y0lk', 1000000, 0, 0, '2016-03-04 14:32:02', NULL, 'ok');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
