-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2018 at 11:11 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `market`
--

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `date` datetime NOT NULL,
  `content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `poultry`
--

CREATE TABLE `poultry` (
  `id` int(11) NOT NULL,
  `breed` varchar(45) NOT NULL,
  `birth` date DEFAULT NULL,
  `house` int(11) NOT NULL,
  `cost` decimal(5,2) NOT NULL,
  `eggs` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `poultry`
--

INSERT INTO `poultry` (`id`, `breed`, `birth`, `house`, `cost`, `eggs`) VALUES
(1, 'Ameracauna', '2017-09-19', 1, '15.47', '13.00'),
(2, 'Barred Rock', '2017-09-19', 1, '15.47', '13.00'),
(3, 'Australorp', '2018-01-27', 4, '7.98', '0.00'),
(4, 'Barred Rock', '2018-01-27', 4, '7.98', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `poultry_houses`
--

CREATE TABLE `poultry_houses` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `poultry_houses`
--

INSERT INTO `poultry_houses` (`id`, `name`) VALUES
(1, 'Main House'),
(4, 'Brooder');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `type` enum('Fertilizer','Feed','Seeds','Soil/Potting Mix','Herbacide','Insecticide','Medication','Bedding') NOT NULL,
  `date` datetime NOT NULL,
  `amount` decimal(4,2) NOT NULL,
  `metric` enum('Cubic Feet','Cubic Yards','Pounds','Gallons','Ounces','Packets','Pieces','Liters','Milliliters') NOT NULL,
  `cost` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `type`, `date`, `amount`, `metric`, `cost`) VALUES
(1, 'Garden-tone', 'Fertilizer', '2018-03-01 00:00:00', '8.00', 'Pounds', '10.00'),
(2, 'Citrus-tone', 'Fertilizer', '2018-03-01 00:00:00', '8.00', 'Pounds', '10.00'),
(3, 'Pine Shavings', 'Bedding', '2018-03-01 00:00:00', '8.00', 'Cubic Feet', '5.00'),
(6, 'Laying Pellets', 'Feed', '2018-03-01 00:00:00', '50.00', 'Pounds', '10.00'),
(7, 'Starter Feed', 'Feed', '2018-03-01 00:00:00', '50.00', 'Pounds', '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `rain`
--

CREATE TABLE `rain` (
  `date` date NOT NULL,
  `amount` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rain`
--

INSERT INTO `rain` (`date`, `amount`) VALUES
('2018-01-02', '2.00'),
('2018-03-01', '1.00'),
('2018-03-11', '1.40'),
('2018-03-16', '0.90');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user` varchar(45) NOT NULL,
  `pass` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user`, `pass`) VALUES
('jeff', '$2y$10$lEw9w95pTlMfxIYOxuM3Bu5HHg2fVHP2PYg.mK1KVDTc7qn7Ngibu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poultry`
--
ALTER TABLE `poultry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `house_idx` (`house`);

--
-- Indexes for table `poultry_houses`
--
ALTER TABLE `poultry_houses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rain`
--
ALTER TABLE `rain`
  ADD PRIMARY KEY (`date`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `poultry`
--
ALTER TABLE `poultry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `poultry_houses`
--
ALTER TABLE `poultry_houses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `poultry`
--
ALTER TABLE `poultry`
  ADD CONSTRAINT `house` FOREIGN KEY (`house`) REFERENCES `poultry_houses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
