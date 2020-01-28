-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 28 jan. 2020 à 10:55
-- Version du serveur :  5.7.26
-- Version de PHP :  7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `contact`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id_cat` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_cat`),
  KEY `fk_user_id` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_cat`, `nom`, `id_user`) VALUES
(1, 'Famille', NULL),
(2, 'Ami', NULL),
(3, 'Pro', NULL),
(7, 'test', 1);

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id_contact` int(11) NOT NULL AUTO_INCREMENT,
  `id_categorie` int(11) DEFAULT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `num_mobile` varchar(20) DEFAULT NULL,
  `num_domicile` varchar(20) DEFAULT NULL,
  `num_bureau` varchar(20) DEFAULT NULL,
  `mail` varchar(50) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modif` datetime DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_contact`),
  KEY `fk_id_user` (`id_user`),
  KEY `fk_id_categorie` (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `contacts`
--

INSERT INTO `contacts` (`id_contact`, `id_categorie`, `nom`, `prenom`, `num_mobile`, `num_domicile`, `num_bureau`, `mail`, `date_creation`, `date_modif`, `id_user`) VALUES
(1, 1, 'Rodrigo', 'José', '0607080910', '0490523262', '0402040203', 'rodrigo.s@lol.fr', '2020-01-20 00:00:00', '2020-01-20 00:00:00', 1),
(6, 1, 'test', 'admin', '000000000', '', '', 'test@lel.fr', '2020-01-27 10:09:57', NULL, 2),
(7, 1, 'Bobo', 'Kuku', '0502147856', '', '', 'koku@kiki.fr', '2020-01-27 14:01:11', NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `password` varchar(70) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'standart',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `pseudo`, `password`, `type`) VALUES
(1, 'test', '$2y$10$yPKtDrsldrgq6pgnxh7hpuDVZB9PqJPE6WLTDunSIfASsmlAMOi7i', 'standart'),
(2, 'admin', '$2y$10$Olk8cSjVCAPg.e0ZxCQrd.mEBmYiczE20AS3w0vwh1sEnVBFwGWDS', 'admin');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `fk_id_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_cat`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
