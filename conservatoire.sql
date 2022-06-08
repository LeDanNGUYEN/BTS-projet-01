-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 08 juin 2022 à 22:09
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
-- Base de données : `conservatoire_v0`
--

-- --------------------------------------------------------

--
-- Structure de la table `adherent`
--

DROP TABLE IF EXISTS `adherent`;
CREATE TABLE IF NOT EXISTS `adherent` (
  `adherent_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `tel` varchar(100) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  PRIMARY KEY (`adherent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `adherent`
--

INSERT INTO `adherent` (`adherent_id`, `nom`, `prenom`, `tel`, `adresse`, `mail`, `mdp`) VALUES
(1, 'test', 'test', '0102030405', '101 rue des Conservatoires', 'test@fake.com', 'test'),
(2, 'admin', 'admin', '0908070605', '09 rue des Admins', 'admin@fakemail.com', 'admin'),
(3, 'marie', 'marie', '0102030405', '5 avenue des Maries', 'marie@fakemail.com', 'marie'),
(4, 'paul', 'paul', '0102030405', '10 rue de la Paul Dance', 'paul@fakemail.com', 'paul'),
(5, 'bob', 'bob', '0102030405', '01 rue de BOB', 'bob@fakemail.com', 'bob'),
(6, 'MALKOVITCH', 'John Bob', '0102030405', '10 rue de Malkovitch', 'malkovitch@fakemail.com', 'malko'),
(7, 'BOBBY BROWN', 'Millie Miller', '0102030405', '221b Baker Street', 'mmbb@fakemail.com', 'mmbb'),
(8, 'CONSTANTINE', 'John Doe', '0102030405', '01 rue de l\'Eglise', 'jdc@fakemail.com', 'jdc'),
(9, 'John', 'John', '0102030405', '10 rue des Johns', 'john@fakemail.com', 'john'),
(10, 'CONSTANTINE2', 'John2', '0102030405', '012 rue de l\'Eglise', 'jdc2@fakemail.com', 'jdc2'),
(39, 'test2', 'test2', '0102030405', '02 rue des tests', 'test2@fakemail.com', 'az'),
(40, 'test2', 'test2', '0102030405', '072 rue des tests', 'test2@fakemail.com', 'azer'),
(41, 'test3', 'test3', '0102030405', '03 rue des tests', 'test3@fakemail.com', 'test3'),
(42, 'test3', 'test3', '0102030405', '03 rue des tests', 'test3@fakemail.com', 'test3'),
(43, 'CONSTANTINE2', 'John2', '0102030405', '012 rue de l\'Eglise', 'jdc@fakemail.com', 'jjj'),
(44, 'toto', 'toto', '0102030405', '01 avenue toto', 'toto@fakemail.com', 'toto'),
(45, 'toto', 'toto', '0102030405', '01 avenue toto', 'toto@fakemail.com', 'toto'),
(46, 'test2', 'test2', '0102030405', '02 rue des tests', 'test2@fakemail.com', '01'),
(47, 'toto2', 'toto2', '0203040506', '01 avenue des totos', 'toto@fakemail.com', 'toto2'),
(48, 'PAUL', 'Jean PÃ©Ã tÃ¢chÃ©rÃ¨ve', '0102030405', '01 rue utf8', 'paul@fakemail.com', 'paul'),
(49, 'titi', 'titi', '0708091010', '01 rue des cartoons', 'titi@fakemail.com', 'titi'),
(50, 'joe', 'joe', '0102030405', '01 avenue JOE', 'joe@fakemail.com', 'joe'),
(53, 'admin2', 'admin2', '0102030405', '02 rue Admin', 'admin2@fakemail.com', 'admin2'),
(54, 'SAWYER', 'Tom', '1876010101', '05 rue Sawyer', 'toms@fakemail.com', 'tom'),
(56, 'VADOR', 'Darth', '0909090909', '02 rue du Senat', 'darthvador@fakemail.com', 'darthvador'),
(58, 'POKIN', 'Charles', '4646464646', '5 rue charles', 'cpokin@fakemail.com', 'pokin'),
(59, 'po', 'po', '0102030405', '01 rue po', 'po@fakemail.com', 'po'),
(60, 'kon', 'kon', '0102030405', '01 rue Kon', 'kon@fakemail.com', 'kon');

--
-- Déclencheurs `adherent`
--
DROP TRIGGER IF EXISTS `verifAdherent`;
DELIMITER $$
CREATE TRIGGER `verifAdherent` BEFORE INSERT ON `adherent` FOR EACH ROW Begin

DECLARE nb INTEGER ;
SELECT COUNT(*) INTO nb
FROM adherent
WHERE nom = NEW.nom 
and prenom = NEW.prenom;
  
   IF (nb>0) THEN
      SIGNAL SQLSTATE "45000" 
      SET MESSAGE_TEXT = "adherent déja existant" ; 
   END IF ;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `cours_id` int(11) NOT NULL AUTO_INCREMENT,
  `horaire` varchar(100) NOT NULL,
  `nbPlace` int(100) NOT NULL,
  `cours_prix` int(255) NOT NULL DEFAULT '0',
  `idProfesseur` int(100) NOT NULL,
  `idInstrument` int(100) NOT NULL,
  PRIMARY KEY (`cours_id`),
  KEY `lien cours/professeur` (`idProfesseur`),
  KEY `lien cours/instrument` (`idInstrument`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`cours_id`, `horaire`, `nbPlace`, `cours_prix`, `idProfesseur`, `idInstrument`) VALUES
(1, 'lundi 17h', 46, 50, 1, 3),
(2, 'mardi 17h', 48, 60, 2, 2),
(3, 'mercredi 14h', 47, 70, 1, 4),
(4, 'jeudi 9h', 27, 100, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

DROP TABLE IF EXISTS `inscription`;
CREATE TABLE IF NOT EXISTS `inscription` (
  `idAdherent` int(11) NOT NULL,
  `idCours` int(11) NOT NULL,
  `paye` int(1) NOT NULL,
  `inscription_prixPaye` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idAdherent`,`idCours`),
  KEY `lien inscription/cours` (`idCours`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`idAdherent`, `idCours`, `paye`, `inscription_prixPaye`) VALUES
(1, 1, 1, 50),
(1, 2, 1, 0),
(1, 3, 0, 30),
(1, 4, 1, 100),
(2, 1, 0, 0),
(3, 1, 0, 20),
(4, 1, 1, 50),
(5, 1, 0, 0),
(5, 2, 0, 0),
(5, 3, 0, 0),
(5, 4, 0, 0),
(6, 1, 0, 0),
(6, 3, 0, 0),
(39, 1, 0, 0),
(40, 2, 0, 0),
(41, 2, 0, 0),
(42, 4, 0, 0),
(43, 3, 0, 0),
(44, 4, 0, 0),
(46, 3, 0, 0),
(48, 4, 0, 0),
(49, 4, 0, 0),
(53, 4, 0, 0),
(54, 4, 0, 0),
(56, 1, 0, 0),
(58, 4, 0, 0),
(59, 4, 0, 0),
(60, 1, 0, 0),
(60, 2, 0, 0),
(60, 3, 0, 0),
(60, 4, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `instrument`
--

DROP TABLE IF EXISTS `instrument`;
CREATE TABLE IF NOT EXISTS `instrument` (
  `instrument_id` int(11) NOT NULL AUTO_INCREMENT,
  `instrument_nom` varchar(100) NOT NULL,
  PRIMARY KEY (`instrument_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `instrument`
--

INSERT INTO `instrument` (`instrument_id`, `instrument_nom`) VALUES
(1, 'violon'),
(2, 'piano'),
(3, 'guitare'),
(4, 'hautbois');

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

DROP TABLE IF EXISTS `professeur`;
CREATE TABLE IF NOT EXISTS `professeur` (
  `professeur_id` int(11) NOT NULL AUTO_INCREMENT,
  `prof_nom` varchar(100) NOT NULL,
  `prof_prenom` varchar(100) NOT NULL,
  PRIMARY KEY (`professeur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `professeur`
--

INSERT INTO `professeur` (`professeur_id`, `prof_nom`, `prof_prenom`) VALUES
(1, 'DUBOIS', 'Jean'),
(2, 'GEORGES', 'Alex');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cours`
--
ALTER TABLE `cours`
  ADD CONSTRAINT `lien cours/instrument` FOREIGN KEY (`idInstrument`) REFERENCES `instrument` (`instrument_id`),
  ADD CONSTRAINT `lien cours/professeur` FOREIGN KEY (`idProfesseur`) REFERENCES `professeur` (`professeur_id`);

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `lien inscription/adherent` FOREIGN KEY (`idAdherent`) REFERENCES `adherent` (`adherent_id`),
  ADD CONSTRAINT `lien inscription/cours` FOREIGN KEY (`idCours`) REFERENCES `cours` (`cours_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
