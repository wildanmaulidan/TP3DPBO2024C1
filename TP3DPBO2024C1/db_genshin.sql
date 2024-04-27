-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2023 at 03:31 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_genshin`
--

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE `characters` (
  `characters_id` int(11) NOT NULL,
  `characters_name` varchar(244) NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `gnosis_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `characters_photo` varchar(244) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`characters_id`, `characters_name`, `birthday`, `gender`, `gnosis_id`, `region_id`, `characters_photo`) VALUES
(1, 'Venti', '2020-06-16', 'Male', 1, 1, 'venti.png'),
(2, 'Hu Tao', '2020-07-15', 'Female', 2, 2, 'hutao.png\r\n'),
(4, 'Raiden Shogun', '2019-06-26', 'Female', 3, 3, 'raiden.png\r\n'),
(5, 'Nahida', '2023-05-04', 'Female', 4, 4, 'nahida.png'),
(11, 'Kamisato Ayaka', '2020-09-28', 'Female', 6, 3, 'ayaka.png'),
(13, 'Ganyu', '2020-12-31', 'Female', 6, 2, 'ganyu.png'),
(15, 'Diluc', '2023-05-12', 'Male', 2, 1, 'diluc.png'),
(17, 'Yelan', '2019-05-23', 'Female', 13, 2, 'yelan.jpg'),
(18, 'Zhongli', '2019-06-07', 'Male', 12, 2, 'zhongli.png');

-- --------------------------------------------------------

--
-- Table structure for table `gnosis`
--

CREATE TABLE `gnosis` (
  `gnosis_id` int(11) NOT NULL,
  `gnosis_name` varchar(244) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gnosis`
--

INSERT INTO `gnosis` (`gnosis_id`, `gnosis_name`) VALUES
(1, 'Anemo'),
(2, 'Pyro'),
(3, 'Electro'),
(4, 'Dendro'),
(6, 'Cryo'),
(12, 'Geo'),
(13, 'Hydro');

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `region_id` int(11) NOT NULL,
  `region_name` varchar(244) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`region_id`, `region_name`) VALUES
(1, 'Monstadt'),
(2, 'Liyue'),
(3, 'Inazuma'),
(4, 'Sumeru');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`characters_id`),
  ADD KEY `gnosis_id` (`gnosis_id`),
  ADD KEY `region_id` (`region_id`);

--
-- Indexes for table `gnosis`
--
ALTER TABLE `gnosis`
  ADD PRIMARY KEY (`gnosis_id`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`region_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `characters`
--
ALTER TABLE `characters`
  MODIFY `characters_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `gnosis`
--
ALTER TABLE `gnosis`
  MODIFY `gnosis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `region_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `characters`
--
ALTER TABLE `characters`
  ADD CONSTRAINT `characters_ibfk_1` FOREIGN KEY (`gnosis_id`) REFERENCES `gnosis` (`gnosis_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `characters_ibfk_2` FOREIGN KEY (`region_id`) REFERENCES `region` (`region_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
