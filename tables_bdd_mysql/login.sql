-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 25 jan. 2021 à 14:59
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
-- Base de données : `login`
--

-- --------------------------------------------------------

--
-- Structure de la table `acteurs`
--

DROP TABLE IF EXISTS `acteurs`;
CREATE TABLE IF NOT EXISTS `acteurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8_bin NOT NULL,
  `contenu` text COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `acteurs`
--

INSERT INTO `acteurs` (`id`, `titre`, `contenu`, `image`) VALUES
(1, 'Formation & Co', 'Formation&co est une association française présente sur tout le territoire.\r\nNous proposons à des personnes issues de tout milieu de devenir entrepreneur grâce à un crédit et un accompagnement professionnel et personnalisé.\r\n<div class =\'hiden\'>\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <br> Ut enim ad minim veniam, quis\r\nadipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis\r\nadipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis\r\n</div> \r\n<div class=\'cacher\'>\r\n<h3>Notre proposition :</h3>\r\n<ul> \r\n<li>un financement jusqu’à 30 000€ ;</li>\r\n<li>un suivi personnalisé et gratuit ;</li>\r\n<li>une lutte acharnée contre les freins sociétaux et les stéréotypes.</li>\r\n</ul>\r\n<p>Le financement est possible, peu importe le métier : coiffeur, banquier, éleveur de chèvres… . Nous collaborons avec des personnes talentueuses et motivées.\r\nVous n’avez pas de diplômes ?\r\n<br> \r\n     Ce n’est pas un problème pour nous ! Nos financements s’adressent à tous.</p>\r\n</div>\r\n', '../img/formation_co.png'),
(2, 'Protect People', '<div class=text_people>Protectpeople finance la solidarité nationale.<br>\r\nNous appliquons le principe édifié par la Sécurité sociale française en 1945 :Permettre à chacun de bénéficier d’une protection sociale.<br>\r\n\r\nChez Protectpeople, chacun cotise selon ses moyens et reçoit selon ses besoins.<div class=\"cacher\">\r\nProtectpeople est ouvert à tous, sans considération d’âge ou d’état de santé.\r\nNous garantissons un accès aux soins et une retraite.\r\nChaque année, nous collectons et répartissons 300 milliards d’euros.\r\nNotre mission est double :\r\n<ul>\r\n<li><strong>Sociale :</strong> nous garantissons la fiabilité des données sociales ;</li>\r\n<li><strong>Economique :</strong>nous apportons une contribution aux activités économiques.</li>\r\n</ul>\r\n</div>\r\n</div>', '../img/protectpeople.png'),
(3, 'DSA France', 'Dsa France accélère la croissance du territoire et s’engage avec les collectivités territoriales.\r\nNous accompagnons les entreprises dans les étapes clés de leur évolution.\r\nNotre philosophie : s’adapter à chaque entreprise.\r\nNous les accompagnons pour voir plus grand et plus loin et proposons des solutions de financement adaptées à chaque étape de la vie des entreprises\r\n', '../img/Dsa_france.png'),
(4, 'CDE', 'La CDE (Chambre Des Entrepreneurs) accompagne les entreprises dans leurs démarches de formation. \r\nSon président est élu pour 3 ans par ses pairs, chefs d’entreprises et présidents des CDE.\r\n', '../img/CDE.png');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_acteurs` int(11) NOT NULL,
  `content` text NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `id_user`, `id_acteurs`, `content`, `date_creation`) VALUES
(79, 17, 1, 'J\'ai commenté ici!!', '2021-01-25 15:48:46');

-- --------------------------------------------------------

--
-- Structure de la table `dislikes`
--

DROP TABLE IF EXISTS `dislikes`;
CREATE TABLE IF NOT EXISTS `dislikes` (
  `id` int(11) NOT NULL DEFAULT '1',
  `id_acteurs` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `dislikes`
--

INSERT INTO `dislikes` (`id`, `id_acteurs`, `id_user`) VALUES
(1, 1, 17);

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_acteurs` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=134 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`id`, `id_acteurs`, `id_user`) VALUES
(133, 1, 16);

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `motdepasse` text NOT NULL,
  `question` text NOT NULL,
  `reponse` text NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id_user`, `nom`, `prenom`, `username`, `mail`, `motdepasse`, `question`, `reponse`) VALUES
(16, 'White', 'Black', 'User2', 'White5670@gmail.com', '$2y$10$WsBnyDtqMn2IgHkg.HhQNeomm0MpJSINFGfr5v2MbHSRK4Jba1qNK', 'Le nom de votre superhero prÃ©fÃ©res ?', 'je sais pas'),
(17, 'Roger', 'Ford', 'User1', 'Roger@gmail.com', '$2y$10$u7YEtwkYg2G9C7XCbM9ZAuzO3dQtWXxbC2DrNJFmNR6DDsQ08Yfji', 'Le nom de votre Pays ?', 'France'),
(18, 'Paul', 'Mathias', 'User3', 'Paul01@gmail.com', '$2y$10$493nV9qVIJY0.DLIvu31teWEg9MS4MebZMPDO2jkwbtyuY4Bg7oT.', 'Le nom de votre professeur prÃ©fÃ©rÃ© ? ?', 'GTO'),
(19, 'Rennes', 'Amandine', 'User4', 'Amandine04@gmail.com', '$2y$10$67QLgi8IAJqwyeU/8HY5AOXdLt3nwuc7lvYEshoA.6ygF5zlRFcKC', 'Le nom de votre superhero prÃ©fÃ©res ?', 'sangoku');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
