-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2017 at 08:29 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hackathon`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendees`
--

CREATE TABLE `attendees` (
  `mid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendees`
--

INSERT INTO `attendees` (`mid`, `uid`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 3),
(6, 1),
(6, 19);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cid` int(11) NOT NULL,
  `cname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cid`, `cname`) VALUES
(1, 'PHP and MySQL'),
(2, 'Machine Learning'),
(3, 'Artificial Intellegence'),
(4, 'Algorithms'),
(5, 'Data Science'),
(6, 'Dev Ops');

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

CREATE TABLE `interests` (
  `iid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `interests`
--

INSERT INTO `interests` (`iid`, `uid`, `cid`) VALUES
(1, 1, 1),
(2, 1, 4),
(3, 1, 6),
(4, 19, 1),
(5, 19, 4),
(6, 19, 6);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `lid` int(11) NOT NULL,
  `lname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`lid`, `lname`) VALUES
(1, 'hyderabad'),
(2, 'bangalore'),
(3, 'mumbai'),
(4, 'delhi');

-- --------------------------------------------------------

--
-- Table structure for table `meetups`
--

CREATE TABLE `meetups` (
  `mid` int(11) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `mdescription` varchar(1000) NOT NULL,
  `date` date NOT NULL,
  `from_time` time NOT NULL,
  `from_period` varchar(10) NOT NULL,
  `to_time` time NOT NULL,
  `to_period` varchar(10) NOT NULL,
  `cid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `landmark` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meetups`
--

INSERT INTO `meetups` (`mid`, `mname`, `mdescription`, `date`, `from_time`, `from_period`, `to_time`, `to_period`, `cid`, `lid`, `landmark`, `uid`) VALUES
(1, 'PHP Boot Camp', 'Kick Start your web development with PHP and MySQL', '2017-06-23', '10:00:00', 'AM', '12:00:00', 'PM', 1, 1, 'Nanakramguda', 1),
(2, 'Machine Learning', 'The Next Big Thing.!!', '2017-06-30', '07:00:00', 'PM', '10:00:00', 'PM', 2, 1, 'JNTU', 2),
(3, 'Artificial Intellegence', '"PythonForArtificialIntelligence".The best Package in Python For AI', '2017-07-01', '02:00:00', 'PM', '05:00:00', 'PM', 3, 2, 'Banneraghatta', 3),
(6, 'Data Analytics', 'Data Science is a rapidly expanding Field.<br />\r\nLacks professionals.<br />\r\nGain Experience in developing advanced Data Science Charts.<br />\r\nExplore Machine Learning Also.', '2017-07-29', '08:00:00', 'AM', '12:00:00', 'PM', 2, 1, 'Ameerpet', 1),
(7, 'Algorithmic Thinking', 'Have you ever wondered how Uber finds people travelling in the same route? Or google knows your favorite food?<br />\r\nBehind the scene, Algorithms are running the show.<br />\r\nLearn the basics of algorithms starting from Big-O Notation.', '2017-08-08', '02:00:00', 'PM', '08:30:00', 'PM', 4, 2, 'Cubbon Road', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `location` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `uname`, `password`, `email`, `location`) VALUES
(1, 'narendra', 'e43667c6b93e08fbeee8d71e1c0837236f1791e1', 'naren@honeywell.com', 1),
(2, 'shubham', 'c250f88274cb8a75961a08502efcb7c262033c87', 'shubham@honeywell.com', 1),
(3, 'sivani', 'c61981bb1059f7c8ed45eb7f73b02abb622e265f', 'sivani@gmail.com', 2),
(19, 'karthik', 'cb4abed6c07c79e2deeb7d5895ddc855894ab403', 'ktik@hwell.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendees`
--
ALTER TABLE `attendees`
  ADD PRIMARY KEY (`mid`,`uid`),
  ADD KEY `fk_attendees_uid` (`uid`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `interests`
--
ALTER TABLE `interests`
  ADD PRIMARY KEY (`iid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`lid`);

--
-- Indexes for table `meetups`
--
ALTER TABLE `meetups`
  ADD PRIMARY KEY (`mid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `lid` (`lid`),
  ADD KEY `cid` (`cid`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `uname` (`uname`),
  ADD KEY `location` (`location`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `interests`
--
ALTER TABLE `interests`
  MODIFY `iid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `meetups`
--
ALTER TABLE `meetups`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendees`
--
ALTER TABLE `attendees`
  ADD CONSTRAINT `fk_attendees_mid` FOREIGN KEY (`mid`) REFERENCES `meetups` (`mid`),
  ADD CONSTRAINT `fk_attendees_uid` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `interests`
--
ALTER TABLE `interests`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Constraints for table `meetups`
--
ALTER TABLE `meetups`
  ADD CONSTRAINT `fk_cid_meet_up` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lid` FOREIGN KEY (`lid`) REFERENCES `locations` (`lid`),
  ADD CONSTRAINT `fk_user_id_meet` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_location` FOREIGN KEY (`location`) REFERENCES `locations` (`lid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
