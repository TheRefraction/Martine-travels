-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 10 oct. 2024 à 17:56
-- Version du serveur : 10.11.8-MariaDB-0ubuntu0.24.04.1
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `martine_travels`
--

-- --------------------------------------------------------

--
-- Structure de la table `Accomodation`
--

CREATE TABLE `Accomodation` (
  `ID` int(11) NOT NULL,
  `Type_ID` int(11) NOT NULL,
  `Room_type_ID` int(11) NOT NULL,
  `Indate` date NOT NULL,
  `Outdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `AccomodationJoin`
--

CREATE TABLE `AccomodationJoin` (
  `Package_ID` int(11) NOT NULL,
  `Accomodation_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `AccomodationType`
--

CREATE TABLE `AccomodationType` (
  `ID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Amenities`
--

CREATE TABLE `Amenities` (
  `ID` int(11) NOT NULL,
  `Name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `AmenitiesJoin`
--

CREATE TABLE `AmenitiesJoin` (
  `Accomodation_ID` int(11) NOT NULL,
  `Amenity_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Country`
--

CREATE TABLE `Country` (
  `ID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Destination`
--

CREATE TABLE `Destination` (
  `ID` int(11) NOT NULL,
  `Name` varchar(128) NOT NULL,
  `Country_ID` int(11) NOT NULL COMMENT '?',
  `Address` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Feedback`
--

CREATE TABLE `Feedback` (
  `ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Title` varchar(128) NOT NULL,
  `Content` text NOT NULL,
  `Review` tinyint(4) NOT NULL COMMENT 'from 0 to 5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Login`
--

CREATE TABLE `Login` (
  `User_ID` int(11) NOT NULL,
  `Username` varchar(64) NOT NULL,
  `Password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Login`
--

INSERT INTO `Login` (`User_ID`, `Username`, `Password`) VALUES
(1, 'martine.voyage@bd.fr', 'martine'),
(2, 'Lorna.jourdan@utm.fr', '1234'),
(3, 'm@g.com', '1234'),
(4, 'p@p.com', '1');

-- --------------------------------------------------------

--
-- Structure de la table `Package`
--

CREATE TABLE `Package` (
  `ID` int(11) NOT NULL,
  `Type_ID` int(11) NOT NULL,
  `Destination_ID` int(11) NOT NULL,
  `Duration` int(11) NOT NULL COMMENT 'In seconds',
  `Price` decimal(10,0) NOT NULL COMMENT 'All included (accomodation+transport+fees)',
  `Payment_status` tinyint(4) NOT NULL COMMENT '0: unpaid(available) 1: on hold 2:paid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `PackageType`
--

CREATE TABLE `PackageType` (
  `ID` int(11) NOT NULL,
  `Name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Preferences`
--

CREATE TABLE `Preferences` (
  `User_ID` int(11) NOT NULL,
  `Transport_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `PreviousPackage`
--

CREATE TABLE `PreviousPackage` (
  `User_ID` int(11) NOT NULL,
  `Package_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `RoomType`
--

CREATE TABLE `RoomType` (
  `ID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Transport`
--

CREATE TABLE `Transport` (
  `ID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Transportation`
--

CREATE TABLE `Transportation` (
  `ID` int(11) NOT NULL,
  `Type_ID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Departure` time NOT NULL,
  `Arrival` time NOT NULL,
  `Provider_ID` int(11) NOT NULL,
  `Ticket_Number` int(11) NOT NULL,
  `Seat_Number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `TransportationJoin`
--

CREATE TABLE `TransportationJoin` (
  `Package_ID` int(11) NOT NULL,
  `Transportation_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `TransportProvider`
--

CREATE TABLE `TransportProvider` (
  `ID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE `User` (
  `ID` int(11) NOT NULL,
  `First_name` varchar(128) NOT NULL,
  `Last_name` varchar(128) NOT NULL,
  `Email` varchar(128) NOT NULL,
  `Phone` varchar(20) NOT NULL COMMENT 'Allows International Phone Numbers to be entered and saved',
  `Birth_date` date NOT NULL,
  `Creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Last_login_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `User`
--

INSERT INTO `User` (`ID`, `First_name`, `Last_name`, `Email`, `Phone`, `Birth_date`, `Creation_date`, `Last_login_date`, `Is_admin`) VALUES
(1, 'Martine', 'Voyage', 'martine.voyage@bd.fr', '000000000000000', '0001-02-01', '2024-10-10 17:15:24', '2024-10-10 17:15:24', 0),
(2, 'lorna', 'jourdan', 'Lorna.jourdan@utm.fr', '56841654', '0001-05-06', '2024-10-10 17:17:07', '2024-10-10 17:17:07', 0),
(3, 'Marcel', 'G', 'm@g.com', '0303030303', '1980-01-01', '2024-10-10 17:48:48', '2024-10-10 17:48:48', 0),
(4, 'Pom', 'Pot', 'p@p.com', '0101010101', '1979-01-02', '2024-10-10 17:51:16', '2024-10-10 17:51:16', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Accomodation`
--
ALTER TABLE `Accomodation`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Type_ID` (`Type_ID`,`Room_type_ID`),
  ADD KEY `Room_type_ID` (`Room_type_ID`);

--
-- Index pour la table `AccomodationJoin`
--
ALTER TABLE `AccomodationJoin`
  ADD PRIMARY KEY (`Package_ID`,`Accomodation_ID`),
  ADD KEY `Accomodation_ID` (`Accomodation_ID`);

--
-- Index pour la table `AccomodationType`
--
ALTER TABLE `AccomodationType`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Amenities`
--
ALTER TABLE `Amenities`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `AmenitiesJoin`
--
ALTER TABLE `AmenitiesJoin`
  ADD PRIMARY KEY (`Accomodation_ID`,`Amenity_ID`),
  ADD KEY `Amenity_ID` (`Amenity_ID`);

--
-- Index pour la table `Country`
--
ALTER TABLE `Country`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Destination`
--
ALTER TABLE `Destination`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Country_ID` (`Country_ID`);

--
-- Index pour la table `Feedback`
--
ALTER TABLE `Feedback`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Index pour la table `Login`
--
ALTER TABLE `Login`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Index pour la table `Package`
--
ALTER TABLE `Package`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Type_ID` (`Type_ID`,`Destination_ID`),
  ADD KEY `Destination_ID` (`Destination_ID`);

--
-- Index pour la table `PackageType`
--
ALTER TABLE `PackageType`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Preferences`
--
ALTER TABLE `Preferences`
  ADD PRIMARY KEY (`User_ID`,`Transport_ID`),
  ADD KEY `Transport_ID` (`Transport_ID`);

--
-- Index pour la table `PreviousPackage`
--
ALTER TABLE `PreviousPackage`
  ADD PRIMARY KEY (`User_ID`,`Package_ID`),
  ADD KEY `Package_ID` (`Package_ID`);

--
-- Index pour la table `RoomType`
--
ALTER TABLE `RoomType`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Transport`
--
ALTER TABLE `Transport`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Transportation`
--
ALTER TABLE `Transportation`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Type_ID` (`Type_ID`,`Provider_ID`),
  ADD KEY `Provider_ID` (`Provider_ID`);

--
-- Index pour la table `TransportationJoin`
--
ALTER TABLE `TransportationJoin`
  ADD PRIMARY KEY (`Package_ID`,`Transportation_ID`),
  ADD KEY `Transportation_ID` (`Transportation_ID`);

--
-- Index pour la table `TransportProvider`
--
ALTER TABLE `TransportProvider`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Accomodation`
--
ALTER TABLE `Accomodation`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `AccomodationType`
--
ALTER TABLE `AccomodationType`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Amenities`
--
ALTER TABLE `Amenities`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Country`
--
ALTER TABLE `Country`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Destination`
--
ALTER TABLE `Destination`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Feedback`
--
ALTER TABLE `Feedback`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Login`
--
ALTER TABLE `Login`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Package`
--
ALTER TABLE `Package`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `PackageType`
--
ALTER TABLE `PackageType`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `RoomType`
--
ALTER TABLE `RoomType`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Transport`
--
ALTER TABLE `Transport`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Transportation`
--
ALTER TABLE `Transportation`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `TransportProvider`
--
ALTER TABLE `TransportProvider`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Accomodation`
--
ALTER TABLE `Accomodation`
  ADD CONSTRAINT `Accomodation_ibfk_1` FOREIGN KEY (`Type_ID`) REFERENCES `AccomodationType` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Accomodation_ibfk_2` FOREIGN KEY (`Room_type_ID`) REFERENCES `RoomType` (`ID`) ON DELETE CASCADE;

--
-- Contraintes pour la table `AccomodationJoin`
--
ALTER TABLE `AccomodationJoin`
  ADD CONSTRAINT `AccomodationJoin_ibfk_1` FOREIGN KEY (`Package_ID`) REFERENCES `Package` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `AccomodationJoin_ibfk_2` FOREIGN KEY (`Accomodation_ID`) REFERENCES `Accomodation` (`ID`) ON DELETE CASCADE;

--
-- Contraintes pour la table `AmenitiesJoin`
--
ALTER TABLE `AmenitiesJoin`
  ADD CONSTRAINT `AmenitiesJoin_ibfk_1` FOREIGN KEY (`Amenity_ID`) REFERENCES `Amenities` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `AmenitiesJoin_ibfk_2` FOREIGN KEY (`Accomodation_ID`) REFERENCES `Accomodation` (`ID`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Destination`
--
ALTER TABLE `Destination`
  ADD CONSTRAINT `Destination_ibfk_1` FOREIGN KEY (`Country_ID`) REFERENCES `Country` (`ID`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Feedback`
--
ALTER TABLE `Feedback`
  ADD CONSTRAINT `Feedback_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `User` (`ID`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Login`
--
ALTER TABLE `Login`
  ADD CONSTRAINT `Login_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `User` (`ID`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Package`
--
ALTER TABLE `Package`
  ADD CONSTRAINT `Package_ibfk_1` FOREIGN KEY (`Destination_ID`) REFERENCES `Destination` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Package_ibfk_2` FOREIGN KEY (`Type_ID`) REFERENCES `PackageType` (`ID`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Preferences`
--
ALTER TABLE `Preferences`
  ADD CONSTRAINT `Preferences_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `User` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Preferences_ibfk_2` FOREIGN KEY (`Transport_ID`) REFERENCES `Transport` (`ID`) ON DELETE CASCADE;

--
-- Contraintes pour la table `PreviousPackage`
--
ALTER TABLE `PreviousPackage`
  ADD CONSTRAINT `PreviousPackage_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `User` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `PreviousPackage_ibfk_2` FOREIGN KEY (`Package_ID`) REFERENCES `Package` (`ID`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Transportation`
--
ALTER TABLE `Transportation`
  ADD CONSTRAINT `Transportation_ibfk_1` FOREIGN KEY (`Type_ID`) REFERENCES `Transport` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Transportation_ibfk_2` FOREIGN KEY (`Provider_ID`) REFERENCES `TransportProvider` (`ID`) ON DELETE CASCADE;

--
-- Contraintes pour la table `TransportationJoin`
--
ALTER TABLE `TransportationJoin`
  ADD CONSTRAINT `TransportationJoin_ibfk_1` FOREIGN KEY (`Package_ID`) REFERENCES `Package` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `TransportationJoin_ibfk_2` FOREIGN KEY (`Transportation_ID`) REFERENCES `Transportation` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
