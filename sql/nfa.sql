

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `keokod12muy`
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
  KEY `id_client_3` (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- Contenu de la table `affaire`
--

INSERT INTO `affaire` (`id`, `date`, `id_client`, `id_receptionniste`, `id_appareil`, `remarque`, `annuler`, `terminer`) VALUES
(36, '2009-06-13 00:00:00', 208, 190, 19, 'pas de connexion', 0, 1),
(37, '2010-06-13 00:00:00', 209, 190, 20, 'gfdgfdgfdgfd', 0, 1),
(38, '2016-06-13 00:00:00', 208, 190, 21, 'grillÃ©dd', 0, 0),
(39, '2016-06-13 00:00:00', 215, 190, 22, 'plus de son et couleur', 0, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Contenu de la table `appareil`
--

INSERT INTO `appareil` (`id`, `reference`, `numero_serie`, `localisation`) VALUES
(6, 'ajouter ajouter', '45454545554', '454545'),
(7, 'dssfsfdsjj', 'gdfqgq', 'fgdgfd'),
(8, 'sdsfds', 'dfsfdsf', 'dsfds'),
(9, 'fdsfgdsgds', 'gfdgfdsg', 'fdgdf'),
(10, 'rdsfsq', 'fsqfs', 'fdsqfdsq'),
(11, 'tdsfqsd', 'fdsqf', 'fdsfdsfdsq'),
(12, 'sdfdqs', 'dsqfq', 'dsqfdsqf'),
(13, 's allume plus ', '415454545', 'fdsfsdfdsf'),
(14, 'dropbox', '454455', 'rangÃ© d'),
(15, 'fdsfqdsq', '44424', 'gdsfds'),
(16, 'DGS', '454DD', 'randE'),
(17, 'TV LCD2', 'POL00000PL1111', 'ranc C'),
(18, 'K2V1000', '666554444555', 'ranc c'),
(19, 'tv3', '00000DDE', 'sortie'),
(20, 'gfdgfdgfd', 'dfggfdgfd', 'gfdgfdgfdgfd'),
(21, 'fdqfdsqfdq', '454545', 'randD'),
(22, 'KV-200-83', 'ABC099', 'sortie');

-- --------------------------------------------------------

--
-- Structure de la table `auth_membre`
--

CREATE TABLE IF NOT EXISTS `auth_membre` (
  `id_membre` int(11) NOT NULL,
  `hexa_auth` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `auth_membre`
--

INSERT INTO `auth_membre` (`id_membre`, `hexa_auth`) VALUES
(1, 'FF'),
(122, '42'),
(122, '43'),
(122, '42'),
(55, '43'),
(55, '44'),
(51, '10'),
(51, '11'),
(51, '12'),
(51, '13'),
(51, '15'),
(51, '20'),
(51, '21'),
(51, '22'),
(51, '23'),
(51, '24'),
(91, '42'),
(91, '43'),
(96, '40'),
(96, '41'),
(96, '42'),
(96, '43'),
(96, '44'),
(96, '45'),
(96, '4F'),
(97, '40'),
(97, '41'),
(97, '42'),
(97, '43'),
(97, '44'),
(97, '45'),
(97, '4F'),
(116, '40'),
(116, '41'),
(116, '42'),
(116, '43'),
(116, '44'),
(116, '45'),
(116, '4F'),
(119, '40'),
(119, '41'),
(119, '42'),
(119, '43'),
(119, '44'),
(119, '45'),
(119, '4F'),
(121, '10'),
(121, '11'),
(121, '12'),
(121, '13'),
(121, '14'),
(121, '15'),
(125, '30'),
(125, '31'),
(125, '32'),
(125, '33'),
(125, '34'),
(125, '35'),
(125, '37'),
(125, '36'),
(125, '3F'),
(145, '22'),
(145, '23'),
(145, '40'),
(145, '41'),
(145, '42'),
(145, '43'),
(145, '44'),
(145, '45'),
(145, '4F'),
(120, '21'),
(120, '22'),
(120, '23'),
(120, '40'),
(120, '41'),
(120, '42'),
(120, '43'),
(120, '44'),
(120, '45'),
(120, '4F'),
(150, '30'),
(150, '31'),
(150, '32'),
(150, '33'),
(150, '34'),
(150, '35'),
(150, '37'),
(150, '36'),
(150, '3F'),
(151, '40'),
(151, '41'),
(151, '42'),
(151, '43'),
(151, '44'),
(151, '45'),
(151, '4F'),
(148, '10'),
(148, '11'),
(148, '12'),
(148, '13'),
(148, '14'),
(148, '15'),
(157, '11'),
(179, '30'),
(179, '31'),
(179, '32'),
(179, '33'),
(179, '34'),
(179, '35'),
(179, '37'),
(179, '36'),
(179, '3F'),
(0, '41'),
(0, '43'),
(0, '45'),
(181, '11'),
(181, '13'),
(181, '15'),
(191, '30'),
(191, '31'),
(191, '32'),
(191, '33'),
(191, '34'),
(191, '35'),
(191, '37'),
(191, '36'),
(191, '3F'),
(192, '40'),
(192, '41'),
(192, '42'),
(192, '43'),
(192, '44'),
(192, '45'),
(192, '4F'),
(198, '30'),
(198, '31'),
(198, '32'),
(198, '33'),
(190, '10'),
(190, '11'),
(190, '12'),
(190, '13'),
(190, '14'),
(190, '15'),
(210, '40'),
(210, '41'),
(210, '42'),
(210, '43'),
(210, '44'),
(210, '45'),
(210, '4F'),
(211, '40'),
(211, '41'),
(211, '42'),
(211, '43'),
(211, '44'),
(211, '45'),
(211, '4F'),
(212, '40'),
(212, '41'),
(212, '42'),
(212, '43'),
(212, '44'),
(212, '45'),
(212, '4F'),
(213, '40'),
(213, '41'),
(213, '42'),
(213, '43'),
(213, '44'),
(213, '45'),
(213, '4F'),
(214, '40'),
(214, '41'),
(214, '42'),
(214, '43'),
(214, '44'),
(214, '45'),
(214, '4F');

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

CREATE TABLE IF NOT EXISTS `devis` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `id_affaire` int(11) NOT NULL,
  `id_tech` int(11) NOT NULL,
  `accepter` int(11) NOT NULL
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `facture`
--

INSERT INTO `facture` (`id`, `date`, `id_affaire`, `correction_total_ht`, `remarque`, `payer`) VALUES
(1, '0000-00-00 00:00:00', 36, 1100, '                ', 0),
(2, '0000-00-00 00:00:00', 1, 809973, '                ', 0),
(3, '0000-00-00 00:00:00', 37, 2, '                ', 0),
(4, '0000-00-00 00:00:00', 39, 254.26, '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `info_hexa`
--

CREATE TABLE IF NOT EXISTS `info_hexa` (
  `valeur_hexa` varchar(2) NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `info_hexa`
--

INSERT INTO `info_hexa` (`valeur_hexa`, `action`, `description`) VALUES
('0X', 'page_public', 'ce que peut faire le client'),
('1X', 'membre', 'tout les menus et actions qui concerne le membre'),
('2X', 'comptoire', 'les menus et action du comptoire'),
('3X', 'stock', 'tout ce qui concerne la gestion du stock'),
('4X', 'technique', 'page pour les techniciens'),
('5X', 'administration', 'permet de tous faire dans le site'),
('0D', '', ''),
('0E', '', ''),
('0F', '', ''),
('10', 'ajouter client', 'menu action voir profil client'),
('11', 'lister client', 'action editer le profil client'),
('12', 'rechercher', 'menu modifier client'),
('13', 'voir client', 'menu rechercher client'),
('14', 'editer', 'voir détail client'),
('15', 'modifier', 'action editer client'),
('16', '', ''),
('17', '', ''),
('18', '', ''),
('19', '', ''),
('10', '', ''),
('1A', '', ''),
('1B', '', ''),
('1C', '', ''),
('1D', '', ''),
('1E', 'bannir client', ''),
('1F', 'supprimer client', ''),
('20', 'ajouter affaire', 'menu ajouter affaire'),
('21', 'lister affaire', 'menu lister les affaires par dates'),
('22', 'rechercher affaire', 'menu recherche affaire'),
('23', 'voir affaire', 'action voir la fiche affaire'),
('24', 'editer', 'menu en mode edition'),
('25', 'modifier affaire', 'modifer l''affaire'),
('26', '', ''),
('27', '', ''),
('28', '', ''),
('29', '', ''),
('2A', '', ''),
('2B', '', ''),
('2C', '', ''),
('2D', '', ''),
('2E', '', ''),
('2F', 'action supprimer affaire', 'supprimer l''affaire'),
('30', 'ajouter pièce', 'menu ajouter nouvelle  pièce'),
('31', 'liste pièce', 'menu liste pièce'),
('32', 'recherche pièce', 'menu rechercher piece'),
('33', 'voir pièce', 'action voir détail la fiche pièce'),
('34', 'editer pièce', 'action en mode edition piece'),
('35', 'modifier pièce', 'action modifier piece'),
('36', 'quantite moin piece', 'action vider la quantité de pièce'),
('37', 'quantite plus pièce', 'action ajouter la quantité de pice'),
('38', '', ''),
('39', '', ''),
('3A', '', ''),
('3B', '', ''),
('3C', '', ''),
('3D', '', ''),
('3E', '', ''),
('3F', 'supprimer pièce', 'supprimer la pièce déprécié'),
('40', 'ajouter intervention', 'menu commencer une intervention'),
('41', 'voir mes interventions', 'liste les interventions du technicien'),
('42', 'recherche intervention', ''),
('43', 'voir intervention', 'action voir détail intervention'),
('44', 'editer intervention', 'action edition intervention'),
('45', 'modifier intervention', ''),
('46', '', ''),
('47', '', ''),
('48', '', ''),
('49', '', ''),
('4A', '', ''),
('4B', '', ''),
('4C', '', ''),
('4D', '', ''),
('4E', '', ''),
('4F', 'supprimer intervention', ''),
('', '', ''),
('50', 'ajouter employé', 'menu ajouter emloyé'),
('51', 'liste employé', 'liste employé par date'),
('52', 'recherche employé', 'menu recherche employé'),
('53', 'voir employé', 'voir le détail de l''emmloyé'),
('54', 'editer employé', 'action fiche editer employé'),
('55', 'modifier employé', 'action modifié la fiche employé'),
('56', '', ''),
('57', '', ''),
('58', '', ''),
('59', '', ''),
('', '', ''),
('5A', '', ''),
('5B', '', ''),
('5C', '', ''),
('5D', 'statistique repartation', ''),
('5E', 'bannir employé', 'bannire employé'),
('5F', 'supprimer emloyé', 'supprimé employé');

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
  KEY `date` (`date_inter`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `intervention`
--

INSERT INTO `intervention` (`id`, `date_inter`, `id_affaire`, `id_tech`, `tache`, `diagnostique`, `duree`, `etat`) VALUES
(1, '2013-05-19 10:22:00', 24, 151, 'fdfdsf', 'dsfds', 12, 1),
(2, '2013-06-09 12:05:00', 36, 192, 'remplacement circuit de refroidssement et condensateur', 'suppresseur hs', 1, 2),
(3, '2013-06-16 08:11:00', 37, 192, '7878', 'dsqfqs', 1, 2),
(4, '2013-06-16 20:39:00', 39, 214, 'remplacement des condensateur primaire', 'alimentation secteur faible.', 1, 3),
(5, '2013-06-16 20:40:00', 39, 214, 'Ajouter carte son', 'carte son hs', 2, 3);

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
  UNIQUE KEY `mdp` (`mdp`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=216 ;

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`id`, `email`, `mdp`, `civilite`, `nom`, `prenom`, `telephone`, `adresse`, `suspendu`, `type_user`) VALUES
(1, 'su@su.fr', '71cbeabb0cf893d0910c987603e3c9f26081d6ba', '1', 'admin', 'admin', '578451245', 'avenue foch', 0, 'SU'),
(190, 'reception@nfa.fr', '2ce31c61b54d548b9bf54c73c9ca9b6357698315', '2', 'hote', 'raphael', '2147483647', '3 avenue de verdun', 0, 'reception'),
(191, 'piece@nfa.fr', '44a670148408cc29097018edc0ce5dc49d1dabfc', '1', 'Richard', 'Mathieu', '1111111111', '4 avenue de verdun', 0, 'magasin'),
(192, 'tech@nfa.fr', '38412d7a69d654b8f4036c3b30faab0b80df8d75', '1', 'Ternay', 'Thierry', '2147483647', '5Avenu de verdun', 0, 'technique'),
(201, 'alex.nr@hotmail.fr', 'b74eef26df1ff56bfceb8f8cbe684c5253e3c02c', '1', 'NGUYEN', 'Alexandre', '612588816', '4 impasse leo ferre', 0, 'client'),
(214, 'keo.n@free.fr', '1a2e0976ce9d11f64a8d632388738e09fe36330c', '1', 'NGOV', 'kÃ©o', '0478474603', '9 rue du Barriot, 69570 DARDILLY', 0, 'technique'),
(215, 'nfa021@yopmail.com', '1ce42c0cc56c7ba31cd50ef17df1adbc27b0ad12', '2', 'LEGRAND', 'CÃ©line', '0987654543', '13 impasse du prÃ©', 0, 'client');

-- --------------------------------------------------------

--
-- Structure de la table `nfois`
--

CREATE TABLE IF NOT EXISTS `nfois` (
  `repete` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `piece_affaire`
--

CREATE TABLE IF NOT EXISTS `piece_affaire` (
  `id_affaire` int(11) NOT NULL,
  `id_piece` int(11) NOT NULL,
  `qte_utiliser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `piece_affaire`
--

INSERT INTO `piece_affaire` (`id_affaire`, `id_piece`, `qte_utiliser`) VALUES
(39, 2, 5),
(39, 3, 6);

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
  KEY `nom_piece` (`nom_piece`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `stock`
--

INSERT INTO `stock` (`id`, `nom_piece`, `reference`, `quantite`, `fournisseur`, `prixHT`, `localisation`, `caracteristique`, `dimension`, `id_chargeur`) VALUES
(1, 'ipad', '10', 10, 'apple', 29999, 'oam', '<script>var hello=11111111111111111; alert(hello);</script>', '100000', 1),
(2, 'condensateur', '1000MF', 795, 'Farnell', 10.01, 'stock condo', 'condo chimique', '10x56', 191),
(3, 'condensateur', '100MF', 64, 'radiospare', 4.25, 'rand E', 'condensateur tantal', '5 mm', 191),
(4, 'diode ', '1N40', 0, '', 0, '', '', '', 191),
(5, 'clavier azerty', 'azerty', 10, 'selectronic', 100, 'range E', 'clavier industriel azerty', '105 touche', 191),
(6, 'limiteur de courant', 'LM 543', 10, 'farnell', 10.01, 'rand Z', 'circuit limiteur de courant ', 'dil 16', 191),
(7, 'timer', 'NE555', 100, 'farnell', 10, 'RANZ', 'circuit mononstable, astable', 'DIL 08', 191),
(8, 'circuit RGB', 'TDA3502', 50, 'nedis', 100, 'RANGE A', 'circuit pour tube cathodique', 'DIL 05', 191),
(9, 'Transistor NPN', '100', 100, 'digikey', 100, 'RANDE', 'transistor bipolaire', 'TO3', 191),
(10, 'circuit logique et', '74HCT04', 10, 'nedis', 1, 'RAND E', 'circuit ET logique', 'DIL 16', 191),
(11, 'circuit protection relais', 'ULN2004', 7, 'nedis', 10, 'rand A', 'circuit NAND', 'dIL 14', 191),
(12, 'thyristor', 'BTA16', 10, 'nedis', 12, 'rand C', 'thyristor de puissance 16A', 'DIL 16', 191),
(13, 'diode zener', 'DT05', 100, 'farnell', 1, 'rand E', 'diode transyl', '5 mm', 191),
(14, 'transitor effet de champ', 'FMT05', 1000, 'nedis', 105, 'placard A', 'transistor effet de champs', 'tsop', 191);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` int(11) NOT NULL,
  `question` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `email`, `phone`, `question`) VALUES
(1, 'nom', 'prenom', 'courriel@cour.fr', 478454587, '                                                    dsqfdqs'),
(2, 'jean', 'toru', 'toru@fr.fr', 4758454, 'have question ??                                                    '),
(3, 'test', 'testpre', 'cour@free.fr', 145788956, '                                               un questionsdsqfd\r\ndfsfds     '),
(4, 'nom', 'prenom', 'courrie@cou.fr', 14545685, '                                                                                                        '),
(5, 'fsfq', 'fdsfq', 'cour@free.fr', 0, '                                                                                jdfkjsqmfjlqsfjldsqjflsqfjqslfjdlskfjlmqsjflkjsqfljdqlksjflksqjflkjsqdklfjqskljfldskjfljqlkfdskk                        '),
(6, '5555555', '5555555', 'test@free.fr', 2147483647, '                                                                                ffff                        '),
(7, '1234567890', '1234567890', 'id@fe.fr', 1234567890, '                                                                 vvvvv                        '),
(8, '789456', '455', 'yt@fg.jy', 1234567896, '                                                je st question    '),
(9, 'dsfsd', 'dfdsf', 'keo.n@free.fr', 2147483647, '                                                    dsdsqd');

