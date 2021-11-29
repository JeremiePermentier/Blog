-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 26 nov. 2021 à 12:14
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `idComment` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(45) NOT NULL,
  `idPost` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idComment`,`idPost`,`idUser`),
  KEY `fk_Comments_Users1` (`idUser`),
  KEY `fk_Comments_Posts1` (`idPost`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dislikes`
--

DROP TABLE IF EXISTS `dislikes`;
CREATE TABLE IF NOT EXISTS `dislikes` (
  `idUsers` int(11) NOT NULL,
  `idPosts` int(11) NOT NULL,
  PRIMARY KEY (`idUsers`,`idPosts`),
  KEY `fk_Dislikes_Posts1` (`idPosts`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dislike_comments`
--

DROP TABLE IF EXISTS `dislike_comments`;
CREATE TABLE IF NOT EXISTS `dislike_comments` (
  `idComments` int(11) NOT NULL,
  `idPosts` int(11) NOT NULL,
  `idUsers` int(11) NOT NULL,
  PRIMARY KEY (`idComments`,`idPosts`,`idUsers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `idUsers` int(11) NOT NULL,
  `idPosts` int(11) NOT NULL,
  PRIMARY KEY (`idUsers`,`idPosts`),
  KEY `fk_Likes_Posts1` (`idPosts`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `like_comments`
--

DROP TABLE IF EXISTS `like_comments`;
CREATE TABLE IF NOT EXISTS `like_comments` (
  `idComments` int(11) NOT NULL,
  `idPosts` int(11) NOT NULL,
  `idUsers` int(11) NOT NULL,
  PRIMARY KEY (`idComments`,`idPosts`,`idUsers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `idPosts` int(11) NOT NULL AUTO_INCREMENT,
  `idUsers` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `post` varchar(200) NOT NULL,
  `url_image` varchar(200) NOT NULL,
  PRIMARY KEY (`idPosts`,`idUsers`),
  KEY `fk_Posts_Users1` (`idUsers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(45) NOT NULL DEFAULT 'subscribe',
  `pseudo` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(200) NOT NULL,
  `url_avatar` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_Comments_Posts1` FOREIGN KEY (`idPost`) REFERENCES `posts` (`idPosts`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Comments_Users1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `dislikes`
--
ALTER TABLE `dislikes`
  ADD CONSTRAINT `fk_Dislikes_Posts1` FOREIGN KEY (`idPosts`) REFERENCES `posts` (`idPosts`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Dislikes_Users1` FOREIGN KEY (`idUsers`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `dislike_comments`
--
ALTER TABLE `dislike_comments`
  ADD CONSTRAINT `fk_Dislike_comments_Comments1` FOREIGN KEY (`idComments`,`idPosts`,`idUsers`) REFERENCES `comments` (`idComment`, `idPost`, `idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_Likes_Posts1` FOREIGN KEY (`idPosts`) REFERENCES `posts` (`idPosts`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Likes_Users` FOREIGN KEY (`idUsers`) REFERENCES `users` (`idUser`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `like_comments`
--
ALTER TABLE `like_comments`
  ADD CONSTRAINT `fk_Like_comments_Comments1` FOREIGN KEY (`idComments`,`idPosts`,`idUsers`) REFERENCES `comments` (`idComment`, `idPost`, `idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_Posts_Users1` FOREIGN KEY (`idUsers`) REFERENCES `users` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

INSERT INTO `users`(`role`, `pseudo`, `email`, `password`) VALUES ("admin", "Admin","admin@admin.com","$2y$10$S/UrDQgiKHA1JeIpRo73EeuBNux861e72QY01nDEhkMNBQMSslRUG");

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
