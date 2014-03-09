
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `nfa`
--

-- --------------------------------------------------------

--
-- Structure de la table `affaire`
--

CREATE TABLE IF NOT EXISTS `affaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_receptionniste` int(11) NOT NULL,
  `id_appareil` int(11) NOT NULL,
  `remarque` text NOT NULL,
  `annuler` tinyint(1) NOT NULL,
  `terminer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_client` (`id_client`),
  KEY `id_client_2` (`id_client`),
  KEY `id_client_3` (`id_client`),
  KEY `id_receptionniste` (`id_receptionniste`),
  KEY `id_appareil` (`id_appareil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `appareil`
--

CREATE TABLE IF NOT EXISTS `appareil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(100) NOT NULL,
  `numero_serie` varchar(255) NOT NULL,
  `localisation` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `auth_membre`
--

CREATE TABLE IF NOT EXISTS `auth_membre` (
  `id_membre` int(11) NOT NULL,
  `hexa_auth` varchar(8) NOT NULL,
  KEY `id_membre` (`id_membre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

CREATE TABLE IF NOT EXISTS `devis` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `id_affaire` int(11) NOT NULL,
  `id_tech` int(11) NOT NULL,
  `accepter` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_affaire` (`id_affaire`),
  KEY `id_tech` (`id_tech`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE IF NOT EXISTS `facture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `id_affaire` int(11) NOT NULL,
  `correction_total_ht` float NOT NULL,
  `remarque` text NOT NULL,
  `payer` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_affaire` (`id_affaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `info_hexa`
--

CREATE TABLE IF NOT EXISTS `info_hexa` (
  `valeur_hexa` varchar(2) NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text NOT NULL,
  UNIQUE KEY `valeur_hexa` (`valeur_hexa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

CREATE TABLE IF NOT EXISTS `intervention` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_inter` datetime NOT NULL,
  `id_affaire` int(11) NOT NULL,
  `id_tech` int(11) NOT NULL,
  `tache` text NOT NULL,
  `diagnostique` text NOT NULL,
  `duree` int(11) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_affaire` (`id_affaire`),
  KEY `id_tech` (`id_tech`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE IF NOT EXISTS `membre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `mdp` varchar(64) NOT NULL,
  `civilite` tinytext NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `adresse` text NOT NULL,
  `suspendu` tinyint(1) NOT NULL,
  `type_user` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mdp` (`mdp`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `telephone` (`telephone`),
  KEY `nom` (`nom`),
  KEY `prenom` (`prenom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `piece_affaire`
--

CREATE TABLE IF NOT EXISTS `piece_affaire` (
  `id_affaire` int(11) NOT NULL,
  `id_piece` int(11) NOT NULL,
  `qte_utiliser` int(11) NOT NULL,
  KEY `id_affaire` (`id_affaire`),
  KEY `id_piece` (`id_piece`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_piece` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `quantite` smallint(6) NOT NULL,
  `fournisseur` varchar(255) NOT NULL,
  `prixHT` float NOT NULL,
  `localisation` varchar(255) NOT NULL,
  `caracteristique` text NOT NULL,
  `dimension` varchar(255) NOT NULL,
  `id_chargeur` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nom_piece` (`nom_piece`),
  KEY `id_chargeur` (`id_chargeur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `affaire`
--
ALTER TABLE `affaire`
  ADD CONSTRAINT `affaire_ibfk_3` FOREIGN KEY (`id_appareil`) REFERENCES `appareil` (`id`),
  ADD CONSTRAINT `affaire_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `membre` (`id`),
  ADD CONSTRAINT `affaire_ibfk_2` FOREIGN KEY (`id_receptionniste`) REFERENCES `membre` (`id`);

--
-- Contraintes pour la table `auth_membre`
--
ALTER TABLE `auth_membre`
  ADD CONSTRAINT `auth_membre_ibfk_1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id`);

--
-- Contraintes pour la table `devis`
--
ALTER TABLE `devis`
  ADD CONSTRAINT `devis_ibfk_2` FOREIGN KEY (`id_tech`) REFERENCES `membre` (`id`),
  ADD CONSTRAINT `devis_ibfk_1` FOREIGN KEY (`id_affaire`) REFERENCES `affaire` (`id`);

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`id_affaire`) REFERENCES `affaire` (`id`);

--
-- Contraintes pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD CONSTRAINT `intervention_ibfk_2` FOREIGN KEY (`id_tech`) REFERENCES `membre` (`id`),
  ADD CONSTRAINT `intervention_ibfk_1` FOREIGN KEY (`id_affaire`) REFERENCES `affaire` (`id`);

--
-- Contraintes pour la table `piece_affaire`
--
ALTER TABLE `piece_affaire`
  ADD CONSTRAINT `piece_affaire_ibfk_2` FOREIGN KEY (`id_piece`) REFERENCES `stock` (`id`),
  ADD CONSTRAINT `piece_affaire_ibfk_1` FOREIGN KEY (`id_affaire`) REFERENCES `affaire` (`id`);

--
-- Contraintes pour la table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`id_chargeur`) REFERENCES `membre` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
