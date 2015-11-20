-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2015 at 12:28 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `irwinstockfeeds`
--

-- --------------------------------------------------------

--
-- Table structure for table `weighbridge_ticket`
--

CREATE TABLE IF NOT EXISTS `weighbridge_ticket` (
`id` int(10) NOT NULL,
  `ticket_number` varchar(50) NOT NULL,
  `delivery_id` int(10) NOT NULL,
  `truck_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `driver` varchar(200) NOT NULL,
  `gross` float NOT NULL,
  `tare` float NOT NULL,
  `net` float NOT NULL,
  `Notes` varchar(500) NOT NULL,
  `Moisture` float DEFAULT NULL,
  `Protein` float DEFAULT NULL,
  `testWeight` float DEFAULT NULL,
  `screenings` float DEFAULT NULL,
  `smo_number` int(20) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `weighbridge_ticket`
--

INSERT INTO `weighbridge_ticket` (`id`, `ticket_number`, `delivery_id`, `truck_id`, `date`, `driver`, `gross`, `tare`, `net`, `Notes`, `Moisture`, `Protein`, `testWeight`, `screenings`, `smo_number`) VALUES
(18, 'WB00018', 29, 92, '2015-11-12', '', 2222, 3333, 55555, 'bhadfadsf', NULL, NULL, NULL, NULL, NULL),
(26, 'WB00019', 31, 92, '2015-11-12', 'SHamus', 1, 2, 3, 'blah vcvv sdfsd sd sd sdfa sdfadsfsdfasd sdf asdf asdf asd asdf asdfasdf sa blah vcvv sdfsd sd sd sdfa sdfadsfsdfasd sdf asdf asdf asd asdf asdfasdf sa\r\nblah vcvv sdfsd sd sd sdfa sdfadsfsdfasd sdf asdf asdf asd asdf asdfasdf sa blah vcvv sdfsd sd sd sdfa sdfadsfsdfasd sdf asdf asdf asd asdf asdfasdf sa', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `weighbridge_ticket`
--
ALTER TABLE `weighbridge_ticket`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `weighbridge_ticket`
--
ALTER TABLE `weighbridge_ticket`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
