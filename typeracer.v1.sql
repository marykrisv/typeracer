-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2018 at 06:12 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `typeracer`
--

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `mId` int(11) NOT NULL,
  `mCreatedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mmParId` int(11) NOT NULL,
  `mStatus` enum('waiting','playing','done','forfeit') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`mId`, `mCreatedOn`, `mmParId`, `mStatus`) VALUES
(7, '2018-03-19 05:08:03', 2, 'done'),
(8, '2018-03-19 05:08:16', 2, 'waiting');

-- --------------------------------------------------------

--
-- Table structure for table `paragraph`
--

CREATE TABLE `paragraph` (
  `id` int(11) NOT NULL,
  `paragraph` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paragraph`
--

INSERT INTO `paragraph` (`id`, `paragraph`) VALUES
(1, 'The quick brown fox jumps over the lazy dog'),
(2, 'test paragraph'),
(8, 'this is a test paragraph\n'),
(9, 'What a beautiful day it is on the beach, here in beautiful and sunny Hawaii.'),
(10, 'Do you know why all those chemicals are so hazardous to the environment?'),
(11, 'Max Joykner sneakily drove his car around every corner looking for his dog.'),
(12, 'The two boys collected twigs outside, for over an hour, in the freezing cold!'),
(13, 'test'),
(14, 'test test'),
(15, 'test with space '),
(16, 'taaaa ');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `playId` int(11) NOT NULL,
  `playMatchId` int(11) NOT NULL,
  `player` enum('1','2','','') NOT NULL,
  `playUserId` int(11) NOT NULL,
  `playResult` enum('win','lose','calibrating') NOT NULL,
  `playMargin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`playId`, `playMatchId`, `player`, `playUserId`, `playResult`, `playMargin`) VALUES
(12, 7, '1', 1, 'win', 130),
(13, 7, '2', 3, 'lose', 0),
(14, 8, '1', 1, 'calibrating', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pvp_highscore`
--

CREATE TABLE `pvp_highscore` (
  `id` int(11) NOT NULL,
  `self_score` int(11) NOT NULL,
  `opp_score` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `opp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `solo_highscore`
--

CREATE TABLE `solo_highscore` (
  `id` int(11) NOT NULL,
  `wpm` int(11) NOT NULL,
  `paragraph_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `solo_highscore`
--

INSERT INTO `solo_highscore` (`id`, `wpm`, `paragraph_id`, `user_id`) VALUES
(6, 39, 10, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(525) NOT NULL,
  `role` enum('admin','player','','') NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('online','ready','ingame','') NOT NULL,
  `readytime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `createdBy`, `createdOn`, `status`, `readytime`) VALUES
(1, 'admin', 'admin', 'admin', 1, '2018-03-14 13:38:56', 'online', '2018-03-18 03:23:51'),
(2, 'test', 'test', 'player', 1, '2018-03-14 13:33:43', 'online', '2018-03-16 07:31:57'),
(3, 'player', 'pass', 'player', 0, '2018-03-18 05:01:50', 'online', '2018-03-18 05:01:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`mId`);

--
-- Indexes for table `paragraph`
--
ALTER TABLE `paragraph`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`playId`);

--
-- Indexes for table `pvp_highscore`
--
ALTER TABLE `pvp_highscore`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pvp_highscore_ibfk_1` (`user_id`),
  ADD KEY `opp_id` (`opp_id`);

--
-- Indexes for table `solo_highscore`
--
ALTER TABLE `solo_highscore`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paragraph_id` (`paragraph_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `mId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `paragraph`
--
ALTER TABLE `paragraph`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `playId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `pvp_highscore`
--
ALTER TABLE `pvp_highscore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `solo_highscore`
--
ALTER TABLE `solo_highscore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `pvp_highscore`
--
ALTER TABLE `pvp_highscore`
  ADD CONSTRAINT `pvp_highscore_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `pvp_highscore_ibfk_2` FOREIGN KEY (`opp_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `solo_highscore`
--
ALTER TABLE `solo_highscore`
  ADD CONSTRAINT `solo_highscore_ibfk_1` FOREIGN KEY (`paragraph_id`) REFERENCES `paragraph` (`id`),
  ADD CONSTRAINT `solo_highscore_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
