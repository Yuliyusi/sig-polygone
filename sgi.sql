-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 08, 2022 at 09:51 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sgi`
--

-- --------------------------------------------------------

--
-- Table structure for table `ged_dossier`
--

CREATE TABLE `ged_dossier` (
  `ID` int(11) NOT NULL,
  `nom_dossier` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `nbre_visite` int(11) DEFAULT 0,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ged_dossier`
--

INSERT INTO `ged_dossier` (`ID`, `nom_dossier`, `description`, `nbre_visite`, `is_archived`) VALUES
(13, 'Dossier1', 'ced dossier stock tous les fichiers', 13, 1),
(14, 'Dossier2', 'dossier ya 2', 6, 0),
(15, 'folder1', 'folder', 1, 0),
(19, 'newfolder', 'gg', 4, 0),
(20, 'securite', 'cours de securite', 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ged_file_dossier`
--

CREATE TABLE `ged_file_dossier` (
  `ID` int(11) NOT NULL,
  `PATH_FICHIER` varchar(200) NOT NULL,
  `ID_DOSSIER` int(11) NOT NULL,
  `NOM_FICHIER` varchar(100) NOT NULL,
  `NBRE_TELECHARGEMA` int(11) DEFAULT 0,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ged_file_dossier`
--

INSERT INTO `ged_file_dossier` (`ID`, `PATH_FICHIER`, `ID_DOSSIER`, `NOM_FICHIER`, `NBRE_TELECHARGEMA`, `is_archived`) VALUES
(2, 'VOTE.xml', 13, 'planning', 1, 0),
(3, 'EQUIPE_COLLECTE.docx', 13, 'planning', 0, 0),
(4, 'Screenshot from 2022-01-14 12-05-40.png', 13, 'picture', 1, 0),
(6, 'Screenshot_20211004-085534.png', 19, 'tttt', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mes_polygone`
--

CREATE TABLE `mes_polygone` (
  `ID` bigint(20) NOT NULL,
  `POLYGONE` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`POLYGONE`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mes_polygone`
--

INSERT INTO `mes_polygone` (`ID`, `POLYGONE`) VALUES
(1, '[[\"29.33217931563297\",\"-3.3505053752077174\"],[\"29.351319555952927\",\"-3.326892541462314\"],[\"29.382753121358235\",\"-3.349728646295574\"],[\"29.33217931563297\",\"-3.3505053752077174\"]]'),
(2, '[[\"29.387565192590017\",\"-3.385888323255827\"],[\"29.390376147636346\",\"-3.384624529705249\"],[\"29.391170081505408\",\"-3.386252466854387\"],[\"29.390032824883463\",\"-3.386423828499872\"],[\"29.387565192590017\",\"-3.385888323255827\"]]');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `NOM` text NOT NULL,
  `PRENOM` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `NOM`, `PRENOM`) VALUES
(1, 'TkRJSE9LVUJXQVlP', 'SnVsZXM='),
(2, 'TkRJSE9LVUJXQVlP', 'SnVsZXM='),
(3, 'bmRheWkgdGVzdA==', 'anVsZXMgdGVzdA=='),
(4, 'TmRpaG9rdWJ3YXlv', 'SnVsZXM='),
(5, 'ZGlkaWVy', 'ZGllcg=='),
(6, 'ZGlkZXI=', 'anVsZXM=');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ged_dossier`
--
ALTER TABLE `ged_dossier`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `nom_dossier` (`nom_dossier`),
  ADD UNIQUE KEY `description` (`description`);

--
-- Indexes for table `ged_file_dossier`
--
ALTER TABLE `ged_file_dossier`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_DOSSIER` (`ID_DOSSIER`);

--
-- Indexes for table `mes_polygone`
--
ALTER TABLE `mes_polygone`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ged_dossier`
--
ALTER TABLE `ged_dossier`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ged_file_dossier`
--
ALTER TABLE `ged_file_dossier`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mes_polygone`
--
ALTER TABLE `mes_polygone`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ged_file_dossier`
--
ALTER TABLE `ged_file_dossier`
  ADD CONSTRAINT `ged_file_dossier_ibfk_1` FOREIGN KEY (`ID_DOSSIER`) REFERENCES `ged_dossier` (`ID`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
