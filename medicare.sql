-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 02 juin 2024 à 20:43
-- Version du serveur : 5.7.24
-- Version de PHP : 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `medicare`
--

-- --------------------------------------------------------

--
-- Structure de la table `disponibilites`
--

CREATE TABLE `disponibilites` (
  `id` int(11) NOT NULL,
  `medecin_id` int(11) NOT NULL,
  `jour` enum('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche') NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `disponibilites`
--

INSERT INTO `disponibilites` (`id`, `medecin_id`, `jour`, `heure_debut`, `heure_fin`) VALUES
(1, 11, 'Lundi', '08:00:00', '12:00:00'),
(2, 11, 'Lundi', '13:00:00', '17:00:00'),
(3, 11, 'Mardi', '08:00:00', '12:00:00'),
(4, 11, 'Mardi', '13:00:00', '17:00:00'),
(5, 11, 'Mercredi', '08:00:00', '12:00:00'),
(6, 11, 'Mercredi', '13:00:00', '17:00:00'),
(7, 11, 'Jeudi', '08:00:00', '12:00:00'),
(8, 11, 'Jeudi', '13:00:00', '17:00:00'),
(9, 11, 'Vendredi', '08:00:00', '12:00:00'),
(10, 11, 'Vendredi', '13:00:00', '17:00:00'),
(11, 12, 'Lundi', '08:00:00', '12:00:00'),
(12, 12, 'Lundi', '13:00:00', '15:00:00'),
(13, 12, 'Mardi', '08:00:00', '12:00:00'),
(14, 12, 'Mardi', '13:00:00', '15:00:00'),
(15, 12, 'Jeudi', '08:00:00', '12:00:00'),
(16, 12, 'Jeudi', '13:00:00', '15:00:00'),
(17, 12, 'Vendredi', '08:00:00', '12:00:00'),
(18, 12, 'Vendredi', '13:00:00', '15:00:00'),
(19, 13, 'Samedi', '09:00:00', '12:00:00'),
(20, 13, 'Samedi', '13:00:00', '18:00:00'),
(21, 13, 'Dimanche', '09:00:00', '12:00:00'),
(22, 13, 'Dimanche', '13:00:00', '18:00:00'),
(23, 14, 'Mercredi', '08:00:00', '12:00:00'),
(24, 14, 'Mercredi', '13:00:00', '16:00:00'),
(25, 14, 'Jeudi', '08:00:00', '12:00:00'),
(26, 14, 'Jeudi', '13:00:00', '16:00:00'),
(27, 14, 'Vendredi', '08:00:00', '12:00:00'),
(28, 14, 'Vendredi', '13:00:00', '16:00:00'),
(29, 15, 'Lundi', '08:00:00', '12:00:00'),
(30, 15, 'Lundi', '13:00:00', '15:00:00'),
(31, 15, 'Mardi', '08:00:00', '12:00:00'),
(32, 15, 'Mardi', '13:00:00', '15:00:00'),
(33, 15, 'Mercredi', '08:00:00', '12:00:00'),
(34, 15, 'Mercredi', '13:00:00', '15:00:00'),
(35, 15, 'Vendredi', '08:00:00', '12:00:00'),
(36, 15, 'Vendredi', '13:00:00', '15:00:00'),
(37, 21, 'Mardi', '08:00:00', '12:00:00'),
(38, 21, 'Mardi', '15:00:00', '18:00:00'),
(39, 21, 'Mercredi', '08:00:00', '12:00:00'),
(40, 21, 'Mercredi', '15:00:00', '18:00:00'),
(41, 21, 'Jeudi', '08:00:00', '12:00:00'),
(42, 21, 'Jeudi', '15:00:00', '18:00:00'),
(43, 21, 'Vendredi', '08:00:00', '12:00:00'),
(44, 21, 'Vendredi', '15:00:00', '18:00:00'),
(45, 31, 'Lundi', '09:00:00', '12:00:00'),
(46, 31, 'Lundi', '13:00:00', '17:00:00'),
(47, 31, 'Mardi', '09:00:00', '12:00:00'),
(48, 31, 'Mardi', '13:00:00', '17:00:00'),
(49, 31, 'Mercredi', '09:00:00', '12:00:00'),
(50, 31, 'Mercredi', '13:00:00', '17:00:00'),
(51, 41, 'Lundi', '08:00:00', '12:00:00'),
(52, 41, 'Mardi', '08:00:00', '12:00:00'),
(53, 41, 'Mardi', '13:00:00', '14:00:00'),
(54, 41, 'Mercredi', '08:00:00', '12:00:00'),
(55, 41, 'Jeudi', '08:00:00', '12:00:00'),
(56, 41, 'Jeudi', '13:00:00', '14:00:00'),
(57, 41, 'Vendredi', '08:00:00', '12:00:00'),
(58, 41, 'Vendredi', '13:00:00', '14:00:00'),
(59, 51, 'Samedi', '08:00:00', '12:00:00'),
(60, 51, 'Samedi', '13:00:00', '20:00:00'),
(61, 51, 'Dimanche', '08:00:00', '12:00:00'),
(62, 51, 'Dimanche', '13:00:00', '20:00:00'),
(63, 61, 'Lundi', '13:00:00', '17:00:00'),
(64, 61, 'Lundi', '18:00:00', '21:00:00'),
(65, 61, 'Mardi', '13:00:00', '17:00:00'),
(66, 61, 'Mardi', '18:00:00', '21:00:00'),
(67, 61, 'Jeudi', '13:00:00', '17:00:00'),
(68, 61, 'Jeudi', '18:00:00', '21:00:00'),
(69, 61, 'Vendredi', '13:00:00', '17:00:00'),
(70, 61, 'Vendredi', '18:00:00', '21:00:00'),
(71, 71, 'Mardi', '10:00:00', '13:00:00'),
(72, 71, 'Mardi', '14:00:00', '18:00:00'),
(73, 71, 'Mercredi', '10:00:00', '13:00:00'),
(74, 71, 'Mercredi', '14:00:00', '18:00:00'),
(75, 71, 'Jeudi', '10:00:00', '13:00:00'),
(76, 71, 'Jeudi', '14:00:00', '18:00:00'),
(77, 71, 'Vendredi', '10:00:00', '13:00:00'),
(78, 71, 'Vendredi', '14:00:00', '18:00:00'),
(79, 81, 'Lundi', '09:00:00', '15:00:00'),
(80, 81, 'Mardi', '09:00:00', '15:00:00'),
(81, 81, 'Mercredi', '09:00:00', '15:00:00'),
(82, 91, 'Mercredi', '08:00:00', '12:00:00'),
(83, 91, 'Mercredi', '13:00:00', '17:00:00'),
(84, 91, 'Jeudi', '08:00:00', '12:00:00'),
(85, 91, 'Jeudi', '13:00:00', '17:00:00'),
(86, 91, 'Vendredi', '08:00:00', '12:00:00'),
(87, 91, 'Vendredi', '13:00:00', '17:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `historique_consult`
--

CREATE TABLE `historique_consult` (
  `id` int(11) NOT NULL,
  `medecin_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `heure` time NOT NULL,
  `details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `laboratoire`
--

CREATE TABLE `laboratoire` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) CHARACTER SET latin1 NOT NULL,
  `salle` varchar(255) CHARACTER SET latin1 NOT NULL,
  `telephone` varchar(255) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `laboratoire`
--

INSERT INTO `laboratoire` (`id`, `nom`, `salle`, `telephone`, `email`) VALUES
(100, 'Depistage', 'Sc-100', '09 09 09 09 09 ', 'depistage.labo@gmail.com'),
(101, 'Biologie preventive', 'Sc-101', '06 06 06 06 94 ', 'preventive.labo@gmail.com'),
(102, 'Biologie de la femme enceinte ', 'Sc-102', '07 98 98 02 03', 'enceinte.labo@gmail.com'),
(103, 'Biologie de routine', 'Sc-103', '06 73 82 28 12', 'routine.labo@gmail.com'),
(104, 'Cancerologie', 'Sc-104', '06 87 87 78 78', 'cancerologie.labo@gmail.com'),
(105, 'Gynecologie', 'Sc-105', '06 78 23 23 23', 'gynecologie.labo@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

CREATE TABLE `medecin` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `photo` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `cv` text CHARACTER SET latin1,
  `specialite_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `medecin`
--

INSERT INTO `medecin` (`id`, `user_id`, `photo`, `cv`, `specialite_id`) VALUES
(11, 3, 'https://mymathews.com/media/institute_banner/Shree_Sapthagiri_College_of_Nursing_Banner.JPG', 'cv_stephanie.xml', 1),
(12, 4, 'https://th.bing.com/th/id/R.3ee4c6ee5a3ec8aa81f534a8f037898a?rik=5Y5myJgs6ccI6Q&pid=ImgRaw&r=0', 'cv_catherine.xml', 1),
(13, 5, 'https://th.bing.com/th/id/R.9e7579acac08c5b5add69b6572d34886?rik=tEwrKVtJkJHTAg&pid=ImgRaw&r=0', 'cv_paul.xml', 1),
(14, 6, 'https://media.licdn.com/dms/image/C4D03AQEFwA5jy2Ho3w/profile-displayphoto-shrink_800_800/0/1624981969763?e=2147483647&v=beta&t=Gnzc1OgJBw9XRtJfrXXgDTh3nW8ItMpK1f2NT_ZRZO8', 'cv_jean.xml', 1),
(15, 7, 'https://www.mrcbndu.ox.ac.uk/sites/default/files/styles/standard_image_crop/public/featured_images/Dr%20Kai%20Loewenbr%C3%BCck.png?itok=jTIKNZ3P', 'cv_christophe.xml', 1),
(21, 8, 'https://th.bing.com/th/id/OIP.SO4k4SH5kP92kW51qjt9PAHaJ0?rs=1&pid=ImgDetMain', 'cv_aurelie.xml', 2),
(31, 9, 'https://media.doctolib.com/image/upload/q_auto:eco,f_auto,w_1024,h_700,c_limit/iz6vo3pkcjkptjlt5lrv.jpg', 'cv_celine.xml', 3),
(41, 10, 'https://cdn-s-www.leprogres.fr/images/E4B6E7AB-51A5-47E4-94EA-6A1950987E33/NW_raw/olivier-schwinn-elu-president-de-la-jce-oyonnax-plastics-vallee-photo-benoit-adrien-1452722704.jpg', 'cv_philippe.xml', 4),
(51, 11, 'https://th.bing.com/th/id/OIP.7I7kCupl3N3AsRePJgLUCgHaHa?w=1024&h=1024&rs=1&pid=ImgDetMain', 'cv_fabrice.xml', 5),
(61, 12, 'https://th.bing.com/th/id/OIP.SJ1vazvUdlckaawb7RGjbAHaIR?w=510&h=570&rs=1&pid=ImgDetMain', 'cv_corinne.xml', 6),
(71, 13, 'https://thumbs.dreamstime.com/b/friendly-female-doctor-standing-clinic-portrait-cheerful-smiling-physician-perfect-medical-service-hospital-medicine-216455960.jpg', 'cv_marianne.xml', 7),
(81, 14, 'https://th.bing.com/th/id/R.40ccebddd619a39e61310e482ac73fc9?rik=UstJHY8bLbRDvQ&pid=ImgRaw&r=0', 'cv_laurent.xml', 8),
(91, 15, 'https://emails-entreprises.com/wp-content/uploads/2021/03/medecins-generalistes.jpg', 'cv_laure.xml', 9),
(92, 20, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE `paiement` (
  `id` int(11) NOT NULL,
  `type_carte` varchar(255) CHARACTER SET latin1 NOT NULL,
  `numero_carte` varchar(255) CHARACTER SET latin1 NOT NULL,
  `nom_carte` varchar(255) CHARACTER SET latin1 NOT NULL,
  `date_expi` date NOT NULL,
  `code_carte` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

CREATE TABLE `rdv` (
  `id` int(11) NOT NULL,
  `medecin_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `laboratoire_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `heure` time NOT NULL,
  `adresse` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `rendezvous`
--

CREATE TABLE `rendezvous` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `medecin_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `heure` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `rendezvous`
--

INSERT INTO `rendezvous` (`id`, `client_id`, `medecin_id`, `date`, `heure`) VALUES
(1, NULL, 11, '2024-06-03', '08:08:00'),
(2, NULL, 11, '2024-06-03', '12:10:00'),
(3, NULL, 11, '2024-06-03', '13:10:00'),
(4, NULL, 11, '2024-06-03', '14:10:00'),
(5, NULL, 11, '2024-06-03', '08:11:00'),
(6, NULL, 21, '2024-06-04', '08:15:00'),
(7, NULL, 21, '2024-06-04', '08:15:00'),
(8, NULL, 21, '2024-06-04', '08:15:00'),
(9, NULL, 21, '2024-06-04', '08:15:00'),
(10, NULL, 11, '2024-06-03', '08:17:00'),
(11, NULL, 11, '2024-06-03', '08:17:00'),
(12, NULL, 11, '2024-06-03', '08:17:00'),
(13, NULL, 11, '2024-06-03', '08:17:00'),
(14, NULL, 11, '2024-06-03', '09:20:00'),
(15, NULL, 11, '2024-06-03', '09:20:00'),
(16, NULL, 11, '2024-06-03', '09:20:00'),
(17, NULL, 11, '2024-06-03', '09:20:00'),
(18, NULL, 12, '2024-06-03', '08:25:00'),
(19, NULL, 12, '2024-06-03', '08:25:00'),
(20, NULL, 12, '2024-06-03', '08:25:00'),
(21, NULL, 12, '2024-06-03', '08:25:00'),
(22, NULL, 12, '2024-06-03', '08:25:00'),
(23, NULL, 12, '2024-06-03', '08:25:00'),
(24, NULL, 12, '2024-06-03', '08:28:00'),
(25, NULL, 12, '2024-06-03', '08:28:00'),
(26, NULL, 21, '2024-06-01', '23:44:00'),
(27, NULL, 21, '2024-06-01', '23:44:00'),
(28, NULL, 21, '2024-06-05', '00:44:00'),
(29, NULL, 21, '2024-06-05', '00:44:00'),
(30, NULL, 11, '2024-06-03', '03:16:00'),
(31, NULL, 11, '2024-06-03', '03:16:00');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `laboratoire_id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `services_creneaux`
--

CREATE TABLE `services_creneaux` (
  `id` int(11) NOT NULL,
  `services_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `disponible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `specialites`
--

CREATE TABLE `specialites` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `specialites`
--

INSERT INTO `specialites` (`id`, `nom`) VALUES
(1, 'généraliste'),
(2, 'Addictologue\r\n'),
(3, 'Andrologue\r\n'),
(4, 'Cardiologue\r\n'),
(5, 'Dermatologue\r\n'),
(6, 'Gastro- Hépato-Entérologue\r\n'),
(7, 'Gynécologue\r\n'),
(8, 'spécialiste des I.S.T.\r\n'),
(9, 'Ostéopathe\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) CHARACTER SET latin1 NOT NULL,
  `prenom` varchar(255) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `mdp` varchar(255) CHARACTER SET latin1 NOT NULL,
  `type` enum('admin','medecin','client') CHARACTER SET latin1 NOT NULL,
  `telephone` varchar(255) CHARACTER SET latin1 NOT NULL,
  `adresse_ligne1` varchar(255) CHARACTER SET latin1 NOT NULL,
  `adresse_ligne2` varchar(255) CHARACTER SET latin1 NOT NULL,
  `ville` varchar(255) CHARACTER SET latin1 NOT NULL,
  `codePost` varchar(255) CHARACTER SET latin1 NOT NULL,
  `pays` varchar(255) CHARACTER SET latin1 NOT NULL,
  `carte_vitale` varchar(255) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `mdp`, `type`, `telephone`, `adresse_ligne1`, `adresse_ligne2`, `ville`, `codePost`, `pays`, `carte_vitale`) VALUES
(1, 'Gerin', 'Paul', 'paul.gerin@edu.ece.fr', '$2y$10$l56WTMqY6N2Wp1mO3lAetes4D5UVaKwAJJtcZ7HQ6602n..GUUzwO', 'client', '0638752665', '13 avenue maurice hauriou', '', 'Toulouse', '31000', 'France', '1021020192012'),
(2, 'Hogommat', 'Julien', 'julien.hogommat@edu.ece.fr', '$2y$10$P/C716Th38ma4jUY449ruekm2yEIIcZFYbQf84stV8tns72ziMO8e', 'client', '06 83 72 44 47', '8 rue de la croix macaire', '', 'Herblay', '95220', 'france', '0104040408249'),
(3, 'Dupont', 'stephanie', 'stephanie.dupont@medicare.fr', '$2y$10$mIbO.usc6Bc6sFDthZAtYOI.tErKMR2kF7EQi0qVGaDzo9ymKmYd.', 'medecin', '0235959480', '9', '', 'Auzebosc', '76190', 'France', NULL),
(4, 'Gerin', 'catherine', 'catherine.gerin@medicare.fr', 'gerin', 'medecin', '06 73 82 82 92', '10 rue du chateaufort', '', 'Perpignan', '31499', 'France', NULL),
(5, 'Valet', 'paul', 'paul.valet@medicare.fr', 'valet', 'medecin', '06 81 91 43 34', ' 17 rue de l\'epine', '', 'Beziers', '34032', 'France', NULL),
(6, 'Remy', 'jean', 'jean.remy@medicare.fr', 'remy', 'medecin', '06 73 19 23 33', '4 impasse de generale de gaulle', '', 'Toulon', '76188', 'France', NULL),
(7, 'Sellito', 'christophe', 'cristophe.sellito@medicare.fr', 'sellito', 'medecin', '06 13 32 32 33', '10 rue de la fourche', '', 'Marseille', '13333', 'France', NULL),
(8, 'Rembry', 'aurelie', 'aurelie.rembry@medicare.fr', 'rembry', 'medecin', '06 11 88 31 31', '4 rue du marteau de thor', '', 'Paris', '75008', 'France', NULL),
(9, 'Leroy', 'celine', 'celine.leroy@medicare.fr', 'leroy', 'medecin', '06 35 15 67 87', 'Rue des champs elysees', '', 'Paris', '75007', 'France', NULL),
(10, 'Cohen', 'philippe', 'philippe.cohen@medicare.fr', 'cohen', 'medecin', '06 73 23 12 12', '8 venue du repas', '', 'Brest', '74900', 'France', NULL),
(11, 'Benamou', 'fabrice', 'fabrice.benamou', 'benamou', 'medecin', '06 28 89 98 09', 'Rue de la bouffe', '', 'Paris', '75006', 'France', NULL),
(12, 'Fleury', 'corinne', 'corinne.fleury@medicare.fr', 'fleury', 'medecin', '06 82 12 33 33', '20 rue de l\'épee', '', 'Lille', '12333', 'France', NULL),
(13, 'Bouchet ', 'marianne ', 'marinne.bouchet', 'bouchet', 'medecin', '06 78 88 91 91', '7 rue des apagnagnan', '', 'Amiens', '70039', 'France', NULL),
(14, 'Tillon', 'laurent', 'laurent.tillon@medicare.fr', 'tillon', 'medecin', '06 13 13 89 09', '9 rue de l\'apagnan', '', 'Amiens', '48000', 'France', NULL),
(15, 'Allory', 'laure', 'laure.allory@medicare.fr', 'allory', 'medecin', '06 73 83 91 11', '10 champs du boeuf', '', 'Lyon', '69000', 'France', NULL),
(16, 'dfgfdgf', 'frdrgfd', 'paulgerin@icloud.com', '$2y$10$zz144KSLWKlaUL4W6HKLvuN09g1u3P2tJ258rQsf5pRt//gxGER/.', 'client', '0638752665', '9 Boulevard Du Chateau', '', 'Neuilly-Sur-Seine', '92200', 'france', '01238182'),
(17, 'pogba', 'paul', 'paulpogba@omnesadmin.fr', '$2y$10$xV8YPSWHh3tZu6qHH6HXOu8HexVyd9rSt0PyLlq978Rtmimc0iRbS', 'admin', '0638752665', '9 Boulevard Du Chateau', '', 'Neuilly-Sur-Seine', '92200', 'france', '01238182');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `disponibilites`
--
ALTER TABLE `disponibilites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `historique_consult`
--
ALTER TABLE `historique_consult`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_historique_consult_medecin` (`medecin_id`),
  ADD KEY `fk_historique_consult_patient` (`patient_id`);

--
-- Index pour la table `laboratoire`
--
ALTER TABLE `laboratoire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `medecin`
--
ALTER TABLE `medecin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_medecin_user` (`user_id`),
  ADD KEY `fk_medecin_specialite` (`specialite_id`);

--
-- Index pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_patient_user` (`user_id`);

--
-- Index pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rdv_medecin` (`medecin_id`),
  ADD KEY `fk_rdv_patient` (`patient_id`),
  ADD KEY `fk_rdv_laboratoire` (`laboratoire_id`),
  ADD KEY `fk_rdv_service` (`service_id`);

--
-- Index pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_client` (`client_id`),
  ADD KEY `fk_medecin` (`medecin_id`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_services` (`laboratoire_id`);

--
-- Index pour la table `services_creneaux`
--
ALTER TABLE `services_creneaux`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_services_creneaux` (`services_id`);

--
-- Index pour la table `specialites`
--
ALTER TABLE `specialites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `disponibilites`
--
ALTER TABLE `disponibilites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT pour la table `historique_consult`
--
ALTER TABLE `historique_consult`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `laboratoire`
--
ALTER TABLE `laboratoire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT pour la table `medecin`
--
ALTER TABLE `medecin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD CONSTRAINT `fk_client` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_medecin` FOREIGN KEY (`medecin_id`) REFERENCES `medecin` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
