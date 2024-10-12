-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 12 oct. 2024 à 21:50
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

--
-- Déchargement des données de la table `Country`
--

INSERT INTO `Country` (`ID`, `Name`) VALUES
(1, 'Afghanistan'),
(2, 'Albania'),
(3, 'Algeria'),
(4, 'Andorra'),
(5, 'Angola'),
(6, 'Antigua and Barbuda'),
(7, 'Argentina'),
(8, 'Armenia'),
(9, 'Australia'),
(10, 'Austria'),
(11, 'Azerbaijan'),
(12, 'Bahamas'),
(13, 'Bahrain'),
(14, 'Bangladesh'),
(15, 'Barbados'),
(16, 'Belarus'),
(17, 'Belgium'),
(18, 'Belize'),
(19, 'Benin'),
(20, 'Bhutan'),
(21, 'Bolivia'),
(22, 'Bosnia and Herzegovina'),
(23, 'Botswana'),
(24, 'Brazil'),
(25, 'Brunei'),
(26, 'Bulgaria'),
(27, 'Burkina Faso'),
(28, 'Burundi'),
(29, 'Cambodia'),
(30, 'Cameroon'),
(31, 'Canada'),
(32, 'Cape Verde'),
(33, 'Central African Republic'),
(34, 'Chad'),
(35, 'Chile'),
(36, 'China'),
(37, 'Colombia'),
(38, 'Comoros'),
(39, 'Congo (Brazzaville)'),
(40, 'Congo (Kinshasa)'),
(41, 'Costa Rica'),
(42, 'Croatia'),
(43, 'Cuba'),
(44, 'Cyprus'),
(45, 'Czech Republic'),
(46, 'Denmark'),
(47, 'Djibouti'),
(48, 'Dominica'),
(49, 'Dominican Republic'),
(50, 'Ecuador'),
(51, 'Egypt'),
(52, 'El Salvador'),
(53, 'Equatorial Guinea'),
(54, 'Eritrea'),
(55, 'Estonia'),
(56, 'Eswatini'),
(57, 'Ethiopia'),
(58, 'Fiji'),
(59, 'Finland'),
(60, 'France'),
(61, 'Gabon'),
(62, 'Gambia'),
(63, 'Georgia'),
(64, 'Germany'),
(65, 'Ghana'),
(66, 'Greece'),
(67, 'Grenada'),
(68, 'Guatemala'),
(69, 'Guinea'),
(70, 'Guinea-Bissau'),
(71, 'Guyana'),
(72, 'Haiti'),
(73, 'Honduras'),
(74, 'Hungary'),
(75, 'Iceland'),
(76, 'India'),
(77, 'Indonesia'),
(78, 'Iran'),
(79, 'Iraq'),
(80, 'Ireland'),
(81, 'Israel'),
(82, 'Italy'),
(83, 'Jamaica'),
(84, 'Japan'),
(85, 'Jordan'),
(86, 'Kazakhstan'),
(87, 'Kenya'),
(88, 'Kiribati'),
(89, 'Korea (North)'),
(90, 'Korea (South)'),
(91, 'Kuwait'),
(92, 'Kyrgyzstan'),
(93, 'Laos'),
(94, 'Latvia'),
(95, 'Lebanon'),
(96, 'Lesotho'),
(97, 'Liberia'),
(98, 'Libya'),
(99, 'Liechtenstein'),
(100, 'Lithuania'),
(101, 'Luxembourg'),
(102, 'Madagascar'),
(103, 'Malawi'),
(104, 'Malaysia'),
(105, 'Maldives'),
(106, 'Mali'),
(107, 'Malta'),
(108, 'Marshall Islands'),
(109, 'Mauritania'),
(110, 'Mauritius'),
(111, 'Mexico'),
(112, 'Micronesia'),
(113, 'Moldova'),
(114, 'Monaco'),
(115, 'Mongolia'),
(116, 'Montenegro'),
(117, 'Morocco'),
(118, 'Mozambique'),
(119, 'Myanmar (Burma)'),
(120, 'Namibia'),
(121, 'Nauru'),
(122, 'Nepal'),
(123, 'Netherlands'),
(124, 'New Zealand'),
(125, 'Nicaragua'),
(126, 'Niger'),
(127, 'Nigeria'),
(128, 'North Macedonia'),
(129, 'Norway'),
(130, 'Oman'),
(131, 'Pakistan'),
(132, 'Palau'),
(133, 'Panama'),
(134, 'Papua New Guinea'),
(135, 'Paraguay'),
(136, 'Peru'),
(137, 'Philippines'),
(138, 'Poland'),
(139, 'Portugal'),
(140, 'Qatar'),
(141, 'Romania'),
(142, 'Russia'),
(143, 'Rwanda'),
(144, 'Saint Kitts and Nevis'),
(145, 'Saint Lucia'),
(146, 'Saint Vincent and the Grenadines'),
(147, 'Samoa'),
(148, 'San Marino'),
(149, 'Sao Tome and Principe'),
(150, 'Saudi Arabia'),
(151, 'Senegal'),
(152, 'Serbia'),
(153, 'Seychelles'),
(154, 'Sierra Leone'),
(155, 'Singapore'),
(156, 'Slovakia'),
(157, 'Slovenia'),
(158, 'Solomon Islands'),
(159, 'Somalia'),
(160, 'South Africa'),
(161, 'South Sudan'),
(162, 'Spain'),
(163, 'Sri Lanka'),
(164, 'Sudan'),
(165, 'Suriname'),
(166, 'Sweden'),
(167, 'Switzerland'),
(168, 'Syria'),
(169, 'Taiwan'),
(170, 'Tajikistan'),
(171, 'Tanzania'),
(172, 'Thailand'),
(173, 'Timor-Leste'),
(174, 'Togo'),
(175, 'Tonga'),
(176, 'Trinidad and Tobago'),
(177, 'Tunisia'),
(178, 'Turkey'),
(179, 'Turkmenistan'),
(180, 'Tuvalu'),
(181, 'Uganda'),
(182, 'Ukraine'),
(183, 'United Arab Emirates'),
(184, 'United Kingdom'),
(185, 'United States'),
(186, 'Uruguay'),
(187, 'Uzbekistan'),
(188, 'Vanuatu'),
(189, 'Vatican City'),
(190, 'Venezuela'),
(191, 'Vietnam'),
(192, 'Yemen'),
(193, 'Zambia'),
(194, 'Zimbabwe');

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

--
-- Déchargement des données de la table `Transport`
--

INSERT INTO `Transport` (`ID`, `Name`) VALUES
(1, 'Train'),
(2, 'Bus'),
(3, 'Renting car'),
(4, 'Plane'),
(5, 'Taxi'),
(6, 'PoppyNonNonLeServeurCaSeMangePas'),
(7, 'Boat');

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
  `Password` varchar(60) NOT NULL,
  `Phone` varchar(20) NOT NULL COMMENT 'Allows International Phone Numbers to be entered and saved',
  `Birth_date` date NOT NULL,
  `Creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Last_login` timestamp NOT NULL DEFAULT current_timestamp(),
  `Is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Phone` (`Phone`);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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

DELIMITER $$
--
-- Évènements
--
CREATE DEFINER=`corentin`@`%` EVENT `Delete_old_users` ON SCHEDULE EVERY 5 MINUTE STARTS '2024-01-01 00:00:00' ENDS '2030-01-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM User WHERE Last_login < NOW() - INTERVAL 2 YEAR$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
