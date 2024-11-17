-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 17 nov. 2024 à 14:27
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
-- Structure de la table `Accommodation`
--

CREATE TABLE `Accommodation` (
  `ID` int(11) NOT NULL,
  `Provider_ID` int(11) NOT NULL,
  `Room_Type_ID` int(11) NOT NULL,
  `Check_In_Date` date NOT NULL,
  `Check_Out_Date` date NOT NULL,
  `Price_Per_Night` decimal(10,0) NOT NULL,
  `Booking_Status` tinyint(4) NOT NULL COMMENT '0: free, 1: booked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Accommodation`
--

INSERT INTO `Accommodation` (`ID`, `Provider_ID`, `Room_Type_ID`, `Check_In_Date`, `Check_Out_Date`, `Price_Per_Night`, `Booking_Status`) VALUES
(1, 1, 2, '2005-07-11', '2005-08-11', 50, 1),
(2, 2, 1, '2024-11-11', '2024-11-23', 56, 0),
(3, 1, 1, '2000-11-11', '2005-11-11', 1236, 0),
(4, 1, 4, '2024-11-20', '2024-11-22', 53, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Accommodation_Join`
--

CREATE TABLE `Accommodation_Join` (
  `ID` int(11) NOT NULL,
  `Package_ID` int(11) NOT NULL,
  `Accommodation_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Accommodation_Join`
--

INSERT INTO `Accommodation_Join` (`ID`, `Package_ID`, `Accommodation_ID`) VALUES
(1, 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `Accommodation_Provider`
--

CREATE TABLE `Accommodation_Provider` (
  `ID` int(11) NOT NULL,
  `Type_ID` int(11) NOT NULL,
  `Name` varchar(128) NOT NULL,
  `Address_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Accommodation_Provider`
--

INSERT INTO `Accommodation_Provider` (`ID`, `Type_ID`, `Name`, `Address_ID`) VALUES
(1, 1, 'Ibis budget', 2),
(2, 2, 'Motel One Berlin-Upper West', 3);

-- --------------------------------------------------------

--
-- Structure de la table `Accommodation_Type`
--

CREATE TABLE `Accommodation_Type` (
  `ID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Accommodation_Type`
--

INSERT INTO `Accommodation_Type` (`ID`, `Name`) VALUES
(1, 'Budget hotel'),
(2, '3 Stars Hotel'),
(3, 'camping');

-- --------------------------------------------------------

--
-- Structure de la table `Address`
--

CREATE TABLE `Address` (
  `ID` int(11) NOT NULL,
  `Country_ID` int(11) NOT NULL COMMENT '?',
  `County_ID` int(11) NOT NULL,
  `Town_ID` int(11) NOT NULL,
  `Street_ID` int(11) NOT NULL,
  `Street_Num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Address`
--

INSERT INTO `Address` (`ID`, `Country_ID`, `County_ID`, `Town_ID`, `Street_ID`, `Street_Num`) VALUES
(2, 60, 1, 1, 1, 45),
(4, 60, 3, 4, 3, 16),
(3, 64, 2, 2, 2, 163);

-- --------------------------------------------------------

--
-- Structure de la table `Address_Country`
--

CREATE TABLE `Address_Country` (
  `ID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Address_Country`
--

INSERT INTO `Address_Country` (`ID`, `Name`) VALUES
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
-- Structure de la table `Address_County`
--

CREATE TABLE `Address_County` (
  `ID` int(11) NOT NULL,
  `Name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Address_County`
--

INSERT INTO `Address_County` (`ID`, `Name`) VALUES
(1, 'Ile de France'),
(2, 'Berlin (State)'),
(3, 'Vosges (88)');

-- --------------------------------------------------------

--
-- Structure de la table `Address_Street`
--

CREATE TABLE `Address_Street` (
  `ID` int(11) NOT NULL,
  `Name` varchar(256) NOT NULL COMMENT 'In French : le libellé de la voie'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Address_Street`
--

INSERT INTO `Address_Street` (`ID`, `Name`) VALUES
(1, 'rue du Docteur Babinski'),
(2, 'Kantstrasse'),
(3, 'rue du champ renard');

-- --------------------------------------------------------

--
-- Structure de la table `Address_Town`
--

CREATE TABLE `Address_Town` (
  `ID` int(11) NOT NULL,
  `Name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Address_Town`
--

INSERT INTO `Address_Town` (`ID`, `Name`) VALUES
(1, 'Paris'),
(2, 'Berlin'),
(3, 'London'),
(4, 'Remiremont');

-- --------------------------------------------------------

--
-- Structure de la table `Amenity`
--

CREATE TABLE `Amenity` (
  `ID` int(11) NOT NULL,
  `Name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Amenity`
--

INSERT INTO `Amenity` (`ID`, `Name`) VALUES
(2, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `Amenity_Join`
--

CREATE TABLE `Amenity_Join` (
  `ID` int(11) NOT NULL,
  `Accommodation_ID` int(11) NOT NULL,
  `Amenity_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Amenity_Join`
--

INSERT INTO `Amenity_Join` (`ID`, `Accommodation_ID`, `Amenity_ID`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `Package`
--

CREATE TABLE `Package` (
  `ID` int(11) NOT NULL,
  `Type_ID` int(11) NOT NULL,
  `Address_ID` int(11) NOT NULL COMMENT 'Destination',
  `Duration` int(11) NOT NULL COMMENT 'In days',
  `Price` decimal(10,0) NOT NULL COMMENT 'All included (accomodation+transport+fees)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Package`
--

INSERT INTO `Package` (`ID`, `Type_ID`, `Address_ID`, `Duration`, `Price`) VALUES
(2, 1, 3, 20, 500),
(3, 1, 4, 5, 100);

-- --------------------------------------------------------

--
-- Structure de la table `Package_Type`
--

CREATE TABLE `Package_Type` (
  `ID` int(11) NOT NULL,
  `Name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Package_Type`
--

INSERT INTO `Package_Type` (`ID`, `Name`) VALUES
(1, 'Historical Trip'),
(2, 'Family'),
(3, 'Business');

-- --------------------------------------------------------

--
-- Structure de la table `Payment`
--

CREATE TABLE `Payment` (
  `ID` int(11) NOT NULL,
  `Reservation_ID` int(11) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Amount` int(11) NOT NULL,
  `Method` int(11) NOT NULL,
  `Status` int(11) NOT NULL COMMENT '0: completed, 1:pending, 2:refunded'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Payment`
--

INSERT INTO `Payment` (`ID`, `Reservation_ID`, `Date`, `Amount`, `Method`, `Status`) VALUES
(1, 1, '2024-11-11 01:50:00', 1205, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Payment_Method`
--

CREATE TABLE `Payment_Method` (
  `ID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Payment_Method`
--

INSERT INTO `Payment_Method` (`ID`, `Name`) VALUES
(1, 'Money'),
(3, 'Credit Card'),
(5, 'Bank Transfer');

-- --------------------------------------------------------

--
-- Structure de la table `Reservation`
--

CREATE TABLE `Reservation` (
  `ID` int(11) NOT NULL,
  `Client_ID` int(11) NOT NULL,
  `Package_ID` int(11) DEFAULT NULL,
  `Transportation_ID` int(11) DEFAULT NULL,
  `Accommodation_ID` int(11) DEFAULT NULL,
  `Status` tinyint(4) NOT NULL COMMENT '0: Confirmed, 1: Pending, 2: Cancelled , 3 : Old Reservation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Reservation`
--

INSERT INTO `Reservation` (`ID`, `Client_ID`, `Package_ID`, `Transportation_ID`, `Accommodation_ID`, `Status`) VALUES
(1, 10, 2, 1, 1, 1),
(3, 16, 3, 1, 3, 3),
(4, 15, 2, 1, 1, 0),
(5, 15, 3, 1, 2, 0),
(26, 9, NULL, NULL, 3, 0),
(27, 9, NULL, 2, 3, 1),
(28, 9, NULL, 1, 3, 0),
(29, 9, 2, 1, NULL, 3),
(30, 9, 2, 1, NULL, 0),
(31, 9, NULL, 1, 3, 0),
(33, 16, NULL, NULL, 3, 3),
(34, 16, NULL, NULL, 3, 3),
(35, 16, 2, NULL, NULL, 0),
(36, 16, NULL, NULL, 2, 0),
(37, 16, NULL, NULL, 3, 0),
(38, 13, NULL, NULL, 3, 0),
(39, 13, 2, NULL, NULL, 0),
(40, 13, NULL, NULL, 3, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Review`
--

CREATE TABLE `Review` (
  `ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Package_ID` int(11) NOT NULL,
  `Transportation_ID` int(11) NOT NULL,
  `Accommodation_ID` int(11) NOT NULL,
  `Title` varchar(128) NOT NULL,
  `Content` text NOT NULL,
  `Rating` tinyint(4) NOT NULL COMMENT 'from 1 to 5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Review`
--

INSERT INTO `Review` (`ID`, `User_ID`, `Package_ID`, `Transportation_ID`, `Accommodation_ID`, `Title`, `Content`, `Rating`) VALUES
(1, 16, 2, 1, 1, 'DESASTRE', 'très mécontente de ce séjour ', 1),
(5, 16, 2, 1, 4, 'pas aimé', 'très mauvais acceuil ', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Room_Type`
--

CREATE TABLE `Room_Type` (
  `ID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL,
  `Description` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Room_Type`
--

INSERT INTO `Room_Type` (`ID`, `Name`, `Description`) VALUES
(1, 'Single room', 'A single room is designed for one occupant and has one bed – generally a double or queen bed.'),
(2, 'Double room', 'A room for two people, sometimes with two full-size beds and sometimes with a king or queen bed. The size of this room is usually larger than a single room.'),
(3, 'Triple room', 'As the name suggests, the triple is a room that can accommodate three people, and will generally include three twin beds, one double bed and one twin bed or two double beds.'),
(4, 'Quad hotel room', 'A larger room that’s meant for four guests, and will have at least two double beds.\r\n\r\nSome quad rooms may be set up with bunks or twins.');

-- --------------------------------------------------------

--
-- Structure de la table `Transportation`
--

CREATE TABLE `Transportation` (
  `ID` int(11) NOT NULL,
  `Type_ID` int(11) NOT NULL,
  `Provider_ID` int(11) NOT NULL,
  `Date_Departure` timestamp NOT NULL,
  `Date_Arrival` timestamp NOT NULL,
  `Ticket_Num` int(11) NOT NULL,
  `Ticket_Price` decimal(10,0) NOT NULL,
  `Seat_Num` int(11) NOT NULL,
  `Address_Depature_ID` int(11) NOT NULL,
  `Address_Arrival_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Transportation`
--

INSERT INTO `Transportation` (`ID`, `Type_ID`, `Provider_ID`, `Date_Departure`, `Date_Arrival`, `Ticket_Num`, `Ticket_Price`, `Seat_Num`, `Address_Depature_ID`, `Address_Arrival_ID`) VALUES
(1, 4, 2, '2024-11-08 20:39:35', '2024-11-08 20:39:35', 32, 160, 15, 2, 3),
(2, 4, 2, '2024-11-10 19:57:10', '2024-11-10 19:57:10', 44, 162, 3, 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `Transportation_Join`
--

CREATE TABLE `Transportation_Join` (
  `ID` int(11) NOT NULL,
  `Package_ID` int(11) NOT NULL,
  `Transportation_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Transportation_Join`
--

INSERT INTO `Transportation_Join` (`ID`, `Package_ID`, `Transportation_ID`) VALUES
(1, 2, 1),
(3, 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Transportation_Preferences`
--

CREATE TABLE `Transportation_Preferences` (
  `ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Transport_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Transportation_Preferences`
--

INSERT INTO `Transportation_Preferences` (`ID`, `User_ID`, `Transport_ID`) VALUES
(2, 10, 1),
(3, 13, 4),
(12, 16, 2),
(31, 16, 5),
(33, 9, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Transportation_Provider`
--

CREATE TABLE `Transportation_Provider` (
  `ID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Transportation_Provider`
--

INSERT INTO `Transportation_Provider` (`ID`, `Name`) VALUES
(1, 'SNCF'),
(2, 'AirFrance'),
(3, 'KAYAK'),
(4, 'Optymo');

-- --------------------------------------------------------

--
-- Structure de la table `Transportation_Type`
--

CREATE TABLE `Transportation_Type` (
  `ID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Transportation_Type`
--

INSERT INTO `Transportation_Type` (`ID`, `Name`) VALUES
(1, 'Train'),
(2, 'Bus'),
(3, 'Renting car'),
(4, 'Plane'),
(5, 'Taxi'),
(7, 'Boat');

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE `User` (
  `ID` int(11) NOT NULL,
  `First_Name` varchar(128) NOT NULL,
  `Last_Name` varchar(128) NOT NULL,
  `Email` varchar(128) NOT NULL,
  `Password` varchar(60) NOT NULL,
  `Phone` varchar(20) NOT NULL COMMENT 'Allows International Phone Numbers to be entered and saved',
  `Loyalty_Points` int(11) NOT NULL DEFAULT 0,
  `Birth_Date` date NOT NULL,
  `Creation_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Last_Login` timestamp NOT NULL DEFAULT current_timestamp(),
  `Is_Admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `User`
--

INSERT INTO `User` (`ID`, `First_Name`, `Last_Name`, `Email`, `Password`, `Phone`, `Loyalty_Points`, `Birth_Date`, `Creation_Date`, `Last_Login`, `Is_Admin`) VALUES
(9, 'Maxime', 'Giraux', 'maxime.giraux@utbm.fr', '$2y$10$Hbd5JQNxjL39jaijYvUNg.YckHYSKjJUL1qIKJIy0gyw1vS4RZ1zm', '0315469280', 0, '1900-02-13', '2024-10-13 12:17:09', '2024-11-17 00:40:32', 0),
(10, 'lorna', 'lo', 'lorna.jourdan@utbm.fr', '$2y$10$xc2YU2X8BxxVoLw/L2krueTXDASzhQRz1ViVvbk95ImnLOoGLhuUe', '564815', 0, '2005-10-23', '2024-10-27 17:22:31', '2024-11-01 16:34:58', 0),
(13, 'Michel', 'Marcel', 'michel@marcel.com', '$2y$10$idL2db3ORR3er89oCVARc.9Hk8ZHffDxvxrdASs3FPu3cvSZyDzQy', '0303030303', 0, '1990-01-01', '2024-11-01 19:20:27', '2024-11-17 11:33:41', 0),
(15, 'admin', 'admin', 'admin@gmail.com', '$2y$10$auNpgmLKgwu224Q1b.xCju30nZ7/qNC2JBA6vvk9acbdKGsqdHB2y', '6846426985', 1, '2011-11-11', '2024-11-01 20:25:58', '2024-11-17 02:57:02', 1),
(16, 'Lorna', 'JOURDAN', 'lornajourdan@gmail.com', '$2y$10$UXuDrx2IgK1AJFGkou6voeygBmnUFKUzM.yIRnzPRYnaznvnFWbdC', '0752589641', 16, '2005-07-11', '2024-11-01 20:31:00', '2024-11-17 10:31:46', 0),
(21, 'ujythrgef', 'uytreza', 'dangfrezds@eu.c', '$2y$10$Hoo0K/dBlQb2a8X.SHS2U.aRUrjo6ZKSu39gBlg5GKmJs.yI9rU2q', '0215648648', 100, '2000-11-11', '2009-11-11 08:54:00', '2024-11-12 05:58:00', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Accommodation`
--
ALTER TABLE `Accommodation`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Provider_ID` (`Provider_ID`),
  ADD KEY `Room_type_ID` (`Room_Type_ID`);

--
-- Index pour la table `Accommodation_Join`
--
ALTER TABLE `Accommodation_Join`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Accomodation_ID` (`Accommodation_ID`);

--
-- Index pour la table `Accommodation_Provider`
--
ALTER TABLE `Accommodation_Provider`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Type_ID` (`Type_ID`),
  ADD KEY `Address_ID` (`Address_ID`);

--
-- Index pour la table `Accommodation_Type`
--
ALTER TABLE `Accommodation_Type`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Address`
--
ALTER TABLE `Address`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Country_ID_2` (`Country_ID`,`County_ID`,`Town_ID`,`Street_ID`,`Street_Num`),
  ADD KEY `Country_ID` (`Country_ID`),
  ADD KEY `County_ID` (`County_ID`),
  ADD KEY `Town_ID` (`Town_ID`),
  ADD KEY `Street_ID` (`Street_ID`);

--
-- Index pour la table `Address_Country`
--
ALTER TABLE `Address_Country`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Address_County`
--
ALTER TABLE `Address_County`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Address_Street`
--
ALTER TABLE `Address_Street`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Address_Town`
--
ALTER TABLE `Address_Town`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Amenity`
--
ALTER TABLE `Amenity`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Amenity_Join`
--
ALTER TABLE `Amenity_Join`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Amenity_ID` (`Amenity_ID`);

--
-- Index pour la table `Package`
--
ALTER TABLE `Package`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Type_ID` (`Type_ID`,`Address_ID`),
  ADD KEY `Address_ID` (`Address_ID`);

--
-- Index pour la table `Package_Type`
--
ALTER TABLE `Package_Type`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Payment`
--
ALTER TABLE `Payment`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Method` (`Method`),
  ADD KEY `Reservation_ID` (`Reservation_ID`);

--
-- Index pour la table `Payment_Method`
--
ALTER TABLE `Payment_Method`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Reservation`
--
ALTER TABLE `Reservation`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Client_ID` (`Client_ID`),
  ADD KEY `Package_ID` (`Package_ID`),
  ADD KEY `Transportation_ID` (`Transportation_ID`),
  ADD KEY `Accommodation_ID` (`Accommodation_ID`);

--
-- Index pour la table `Review`
--
ALTER TABLE `Review`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Package_ID` (`Package_ID`),
  ADD KEY `Transportation_ID` (`Transportation_ID`),
  ADD KEY `Accommodation_ID` (`Accommodation_ID`);

--
-- Index pour la table `Room_Type`
--
ALTER TABLE `Room_Type`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Transportation`
--
ALTER TABLE `Transportation`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Type_ID` (`Type_ID`,`Provider_ID`),
  ADD KEY `Provider_ID` (`Provider_ID`),
  ADD KEY `Address_Depature_ID` (`Address_Depature_ID`),
  ADD KEY `Address_Arrival_ID` (`Address_Arrival_ID`);

--
-- Index pour la table `Transportation_Join`
--
ALTER TABLE `Transportation_Join`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Transportation_ID` (`Transportation_ID`);

--
-- Index pour la table `Transportation_Preferences`
--
ALTER TABLE `Transportation_Preferences`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Transport_ID` (`Transport_ID`);

--
-- Index pour la table `Transportation_Provider`
--
ALTER TABLE `Transportation_Provider`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Transportation_Type`
--
ALTER TABLE `Transportation_Type`
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
-- AUTO_INCREMENT pour la table `Accommodation`
--
ALTER TABLE `Accommodation`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Accommodation_Join`
--
ALTER TABLE `Accommodation_Join`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `Accommodation_Provider`
--
ALTER TABLE `Accommodation_Provider`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `Accommodation_Type`
--
ALTER TABLE `Accommodation_Type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `Address`
--
ALTER TABLE `Address`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Address_Country`
--
ALTER TABLE `Address_Country`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT pour la table `Address_County`
--
ALTER TABLE `Address_County`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `Address_Street`
--
ALTER TABLE `Address_Street`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `Address_Town`
--
ALTER TABLE `Address_Town`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Amenity`
--
ALTER TABLE `Amenity`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `Amenity_Join`
--
ALTER TABLE `Amenity_Join`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `Package`
--
ALTER TABLE `Package`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `Package_Type`
--
ALTER TABLE `Package_Type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Payment`
--
ALTER TABLE `Payment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Payment_Method`
--
ALTER TABLE `Payment_Method`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Reservation`
--
ALTER TABLE `Reservation`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `Review`
--
ALTER TABLE `Review`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Room_Type`
--
ALTER TABLE `Room_Type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `Transportation`
--
ALTER TABLE `Transportation`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `Transportation_Join`
--
ALTER TABLE `Transportation_Join`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Transportation_Preferences`
--
ALTER TABLE `Transportation_Preferences`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `Transportation_Provider`
--
ALTER TABLE `Transportation_Provider`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Transportation_Type`
--
ALTER TABLE `Transportation_Type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Accommodation`
--
ALTER TABLE `Accommodation`
  ADD CONSTRAINT `Accommodation_ibfk_1` FOREIGN KEY (`Room_Type_ID`) REFERENCES `Room_Type` (`ID`),
  ADD CONSTRAINT `Accommodation_ibfk_2` FOREIGN KEY (`Provider_ID`) REFERENCES `Accommodation_Provider` (`ID`);

--
-- Contraintes pour la table `Accommodation_Join`
--
ALTER TABLE `Accommodation_Join`
  ADD CONSTRAINT `Accommodation_Join_ibfk_1` FOREIGN KEY (`Package_ID`) REFERENCES `Package` (`ID`),
  ADD CONSTRAINT `Accommodation_Join_ibfk_2` FOREIGN KEY (`Accommodation_ID`) REFERENCES `Accommodation` (`ID`);

--
-- Contraintes pour la table `Accommodation_Provider`
--
ALTER TABLE `Accommodation_Provider`
  ADD CONSTRAINT `Accommodation_Provider_ibfk_2` FOREIGN KEY (`Type_ID`) REFERENCES `Accommodation_Type` (`ID`),
  ADD CONSTRAINT `Accommodation_Provider_ibfk_3` FOREIGN KEY (`Address_ID`) REFERENCES `Address` (`ID`);

--
-- Contraintes pour la table `Address`
--
ALTER TABLE `Address`
  ADD CONSTRAINT `Address_ibfk_1` FOREIGN KEY (`Country_ID`) REFERENCES `Address_Country` (`ID`),
  ADD CONSTRAINT `Address_ibfk_2` FOREIGN KEY (`County_ID`) REFERENCES `Address_County` (`ID`),
  ADD CONSTRAINT `Address_ibfk_3` FOREIGN KEY (`Town_ID`) REFERENCES `Address_Town` (`ID`),
  ADD CONSTRAINT `Address_ibfk_4` FOREIGN KEY (`Street_ID`) REFERENCES `Address_Street` (`ID`);

--
-- Contraintes pour la table `Amenity_Join`
--
ALTER TABLE `Amenity_Join`
  ADD CONSTRAINT `Amenity_Join_ibfk_1` FOREIGN KEY (`Amenity_ID`) REFERENCES `Amenity` (`ID`),
  ADD CONSTRAINT `Amenity_Join_ibfk_2` FOREIGN KEY (`Accommodation_ID`) REFERENCES `Accommodation` (`ID`);

--
-- Contraintes pour la table `Package`
--
ALTER TABLE `Package`
  ADD CONSTRAINT `Package_ibfk_1` FOREIGN KEY (`Type_ID`) REFERENCES `Package_Type` (`ID`),
  ADD CONSTRAINT `Package_ibfk_2` FOREIGN KEY (`Address_ID`) REFERENCES `Address` (`ID`);

--
-- Contraintes pour la table `Payment`
--
ALTER TABLE `Payment`
  ADD CONSTRAINT `Payment_ibfk_1` FOREIGN KEY (`Method`) REFERENCES `Payment_Method` (`ID`),
  ADD CONSTRAINT `Payment_ibfk_2` FOREIGN KEY (`Reservation_ID`) REFERENCES `Reservation` (`ID`);

--
-- Contraintes pour la table `Reservation`
--
ALTER TABLE `Reservation`
  ADD CONSTRAINT `Reservation_ibfk_1` FOREIGN KEY (`Client_ID`) REFERENCES `User` (`ID`),
  ADD CONSTRAINT `Reservation_ibfk_2` FOREIGN KEY (`Package_ID`) REFERENCES `Package` (`ID`),
  ADD CONSTRAINT `Reservation_ibfk_3` FOREIGN KEY (`Accommodation_ID`) REFERENCES `Accommodation` (`ID`),
  ADD CONSTRAINT `Reservation_ibfk_4` FOREIGN KEY (`Transportation_ID`) REFERENCES `Transportation` (`ID`);

--
-- Contraintes pour la table `Review`
--
ALTER TABLE `Review`
  ADD CONSTRAINT `Review_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `User` (`ID`),
  ADD CONSTRAINT `Review_ibfk_2` FOREIGN KEY (`Package_ID`) REFERENCES `Package` (`ID`),
  ADD CONSTRAINT `Review_ibfk_3` FOREIGN KEY (`Accommodation_ID`) REFERENCES `Accommodation` (`ID`),
  ADD CONSTRAINT `Review_ibfk_4` FOREIGN KEY (`Transportation_ID`) REFERENCES `Transportation` (`ID`);

--
-- Contraintes pour la table `Transportation`
--
ALTER TABLE `Transportation`
  ADD CONSTRAINT `Transportation_ibfk_1` FOREIGN KEY (`Type_ID`) REFERENCES `Transportation_Type` (`ID`),
  ADD CONSTRAINT `Transportation_ibfk_2` FOREIGN KEY (`Provider_ID`) REFERENCES `Transportation_Provider` (`ID`),
  ADD CONSTRAINT `Transportation_ibfk_3` FOREIGN KEY (`Address_Depature_ID`) REFERENCES `Address` (`ID`),
  ADD CONSTRAINT `Transportation_ibfk_4` FOREIGN KEY (`Address_Arrival_ID`) REFERENCES `Address` (`ID`);

--
-- Contraintes pour la table `Transportation_Join`
--
ALTER TABLE `Transportation_Join`
  ADD CONSTRAINT `Transportation_Join_ibfk_1` FOREIGN KEY (`Transportation_ID`) REFERENCES `Transportation` (`ID`),
  ADD CONSTRAINT `Transportation_Join_ibfk_2` FOREIGN KEY (`Package_ID`) REFERENCES `Package` (`ID`);

--
-- Contraintes pour la table `Transportation_Preferences`
--
ALTER TABLE `Transportation_Preferences`
  ADD CONSTRAINT `Transportation_Preferences_ibfk_1` FOREIGN KEY (`Transport_ID`) REFERENCES `Transportation_Type` (`ID`),
  ADD CONSTRAINT `Transportation_Preferences_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `User` (`ID`);

DELIMITER $$
--
-- Évènements
--
CREATE DEFINER=`corentin`@`%` EVENT `Delete_old_users` ON SCHEDULE EVERY 5 MINUTE STARTS '2024-01-01 00:00:00' ENDS '2030-01-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM User WHERE Last_Login < NOW() - INTERVAL 2 YEAR$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
