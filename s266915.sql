-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2019 at 06:22 PM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s266915`
--

-- --------------------------------------------------------

--
-- Table structure for table `LOCATION`
--
DROP TABLE IF EXISTS `LOCATION`;
CREATE TABLE `LOCATION` (
  `pointID` varchar(255) NOT NULL,
  `pointX` int(11) NOT NULL,
  `pointY` int(11) NOT NULL,
  `numBicycle` int(11) NOT NULL,
  `numMotobike` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `LOCATION`
--

INSERT INTO `LOCATION` (`pointID`, `pointX`, `pointY`, `numBicycle`, `numMotobike`) VALUES
('point1', 10, 20, 2, 3),
('point2', 30, 60, 3, 4),
('point3', 40, 134, 1, 0),
('point4', 30, 180, 2, 1),
('point5', 130, 290, 3, 0),
('point6', 255, 360, 4, 2),
('point7', 440, 241, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `RESERVATION`
--
DROP TABLE IF EXISTS `RESERVATION`;
CREATE TABLE `RESERVATION` (
  `username` varchar(255) NOT NULL,
  `pointID` varchar(255) NOT NULL,
  `resBicycles` int(11) NOT NULL,
  `resMotobikes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `RESERVATION`
--

INSERT INTO `RESERVATION` (`username`, `pointID`, `resBicycles`, `resMotobikes`) VALUES
('u1@p.it', 'POINT3', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `USER`
--
DROP TABLE IF EXISTS `USER`;
CREATE TABLE `USER` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `USER`
--

INSERT INTO `USER` (`username`, `password`) VALUES
('u1@p.it', '$2y$10$XDVmLxrC76PnuYSwLqszkOWSf5sFevo4DFLnUw5OB8C4SEodWYsZa'),
('u2@p.it', '$2y$10$n6yuG2WsCwxAef4.FUiXD.L7mr8iVL5Dpin8BBpJugpbVeCIJPAZy'),
('u3@p.it', '$2y$10$LWrlSSUOU5YsetXApBc3muXJIVWAfQS84p4zkzVR/VktDFUK0/Qay');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `LOCATION`
--
ALTER TABLE `LOCATION`
  ADD PRIMARY KEY (`pointID`);

--
-- Indexes for table `USER`
--
ALTER TABLE `USER`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
