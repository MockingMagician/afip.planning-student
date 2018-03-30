-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le :  jeu. 29 mars 2018 à 09:21
-- Version du serveur :  5.7.20
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `afip_tp_planning_2`
--

-- --------------------------------------------------------

--
-- Structure de la table `nationality`
--

CREATE TABLE `nationality` (
  `id` int(11) NOT NULL,
  `label` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `nationality`
--

INSERT INTO `nationality` (`id`, `label`) VALUES
(8, 'Suédois'),
(10, 'Italien'),
(11, 'Chinois'),
(12, 'Japonais');

-- --------------------------------------------------------

--
-- Structure de la table `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `label` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `room`
--

INSERT INTO `room` (`id`, `label`) VALUES
(3, '444'),
(5, '606'),
(6, '77'),
(7, 'zubida'),
(8, 'Suédois');

-- --------------------------------------------------------

--
-- Structure de la table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `nationalityId` int(11) DEFAULT NULL,
  `traineeshipId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `student`
--

INSERT INTO `student` (`id`, `lastName`, `firstName`, `nationalityId`, `traineeshipId`) VALUES
(27, 'Moreau', 'Jeanot', 10, 1),
(28, 'Valjean', 'Jean', NULL, 3);

-- --------------------------------------------------------

--
-- Structure de la table `studentTeacher`
--

CREATE TABLE `studentTeacher` (
  `id` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `teacherId` int(11) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `studentTeacher`
--

INSERT INTO `studentTeacher` (`id`, `studentId`, `teacherId`, `startDate`, `endDate`) VALUES
(6, 28, 2, '2018-12-06', '2019-02-03');

-- --------------------------------------------------------

--
-- Structure de la table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `roomId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `teacher`
--

INSERT INTO `teacher` (`id`, `firstName`, `lastName`, `roomId`) VALUES
(1, 'Jean', 'Vador', 3),
(2, 'Germond', 'Fabier', 7),
(3, 'Jean', 'Moulin', NULL);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `teacherTraineeshipLabel`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `teacherTraineeshipLabel` (
`traineeshipLabel` varchar(25)
,`teacherId` int(11)
,`traineeshipId` int(11)
);

-- --------------------------------------------------------

--
-- Structure de la table `traineeship`
--

CREATE TABLE `traineeship` (
  `id` int(11) NOT NULL,
  `label` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `traineeship`
--

INSERT INTO `traineeship` (`id`, `label`) VALUES
(1, 'PHP'),
(2, 'MySQL'),
(3, 'JAVA'),
(4, 'Javascript'),
(5, 'XML');

-- --------------------------------------------------------

--
-- Structure de la table `traineeshipTeacher`
--

CREATE TABLE `traineeshipTeacher` (
  `id` int(11) NOT NULL,
  `traineeshipId` int(11) NOT NULL,
  `teacherId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `traineeshipTeacher`
--

INSERT INTO `traineeshipTeacher` (`id`, `traineeshipId`, `teacherId`) VALUES
(5, 2, 3),
(6, 3, 3),
(7, 4, 3),
(13, 1, 1),
(14, 2, 1),
(15, 3, 1),
(16, 4, 1),
(17, 5, 1),
(18, 3, 2);

-- --------------------------------------------------------

--
-- Structure de la vue `teacherTraineeshipLabel`
--
DROP TABLE IF EXISTS `teacherTraineeshipLabel`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `teacherTraineeshipLabel`  AS  select `traineeship`.`label` AS `traineeshipLabel`,`traineeshipTeacher`.`teacherId` AS `teacherId`,`traineeshipTeacher`.`traineeshipId` AS `traineeshipId` from (`traineeshipTeacher` join `traineeship` on((`traineeshipTeacher`.`traineeshipId` = `traineeship`.`id`))) ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `nationality`
--
ALTER TABLE `nationality`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Id_nationalite` (`nationalityId`),
  ADD KEY `Id_type_formation` (`traineeshipId`);

--
-- Index pour la table `studentTeacher`
--
ALTER TABLE `studentTeacher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Id_stagiaire` (`studentId`),
  ADD KEY `Id_formateur` (`teacherId`);

--
-- Index pour la table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Id_salle` (`roomId`);

--
-- Index pour la table `traineeship`
--
ALTER TABLE `traineeship`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `traineeshipTeacher`
--
ALTER TABLE `traineeshipTeacher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Id_formateur` (`teacherId`),
  ADD KEY `Id_type_formation` (`traineeshipId`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `nationality`
--
ALTER TABLE `nationality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `studentTeacher`
--
ALTER TABLE `studentTeacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `traineeship`
--
ALTER TABLE `traineeship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `traineeshipTeacher`
--
ALTER TABLE `traineeshipTeacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`nationalityId`) REFERENCES `nationality` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`traineeshipId`) REFERENCES `traineeship` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `studentTeacher`
--
ALTER TABLE `studentTeacher`
  ADD CONSTRAINT `studentTeacher_ibfk_1` FOREIGN KEY (`teacherId`) REFERENCES `teacher` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `studentTeacher_ibfk_2` FOREIGN KEY (`studentId`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`roomId`) REFERENCES `room` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `traineeshipTeacher`
--
ALTER TABLE `traineeshipTeacher`
  ADD CONSTRAINT `traineeshipTeacher_ibfk_1` FOREIGN KEY (`teacherId`) REFERENCES `teacher` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `traineeshipTeacher_ibfk_2` FOREIGN KEY (`traineeshipId`) REFERENCES `traineeship` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
