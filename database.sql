-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Dim 19 Juin 2011 à 14:29
-- Version du serveur: 5.5.8
-- Version de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `webdev`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `barcode` varchar(14) NOT NULL,
  `family` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `state` enum('OK','NOK','TR') NOT NULL,
  `place` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `place` (`place`),
  KEY `family` (`family`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100000 ;

-- --------------------------------------------------------

--
-- Structure de la table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lname` varchar(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `structure` int(10) unsigned NOT NULL,
  `function` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `structure` (`structure`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=400000 ;

-- --------------------------------------------------------

--
-- Structure de la table `dynamic_fields`
--

CREATE TABLE IF NOT EXISTS `dynamic_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_family` int(10) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_family` (`id_family`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `dynamic_values`
--

CREATE TABLE IF NOT EXISTS `dynamic_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_field` int(10) unsigned NOT NULL,
  `id_article` int(10) unsigned NOT NULL,
  `value` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_field` (`id_field`,`id_article`),
  KEY `id_article` (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `families`
--

CREATE TABLE IF NOT EXISTS `families` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `parentfamily` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parentfamily` (`parentfamily`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `loans`
--

CREATE TABLE IF NOT EXISTS `loans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer` int(10) unsigned NOT NULL,
  `begindate` date NOT NULL,
  `enddate` date NOT NULL,
  `reason` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer` (`customer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=500000 ;

-- --------------------------------------------------------

--
-- Structure de la table `loans_articles`
--

CREATE TABLE IF NOT EXISTS `loans_articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `loan` int(10) unsigned NOT NULL,
  `article` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `begindate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `loan` (`loan`),
  KEY `article` (`article`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `structures`
--

CREATE TABLE IF NOT EXISTS `structures` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(40) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `phone` varchar(13) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`place`) REFERENCES `places` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`family`) REFERENCES `families` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`structure`) REFERENCES `structures` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `dynamic_fields`
--
ALTER TABLE `dynamic_fields`
  ADD CONSTRAINT `dynamic_fields_ibfk_1` FOREIGN KEY (`id_family`) REFERENCES `families` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dynamic_values`
--
ALTER TABLE `dynamic_values`
  ADD CONSTRAINT `dynamic_values_ibfk_2` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dynamic_values_ibfk_1` FOREIGN KEY (`id_field`) REFERENCES `dynamic_fields` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `families`
--
ALTER TABLE `families`
  ADD CONSTRAINT `families_ibfk_1` FOREIGN KEY (`parentfamily`) REFERENCES `families` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `loans_articles`
--
ALTER TABLE `loans_articles`
  ADD CONSTRAINT `loans_articles_ibfk_1` FOREIGN KEY (`loan`) REFERENCES `loans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `loans_articles_ibfk_2` FOREIGN KEY (`article`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
