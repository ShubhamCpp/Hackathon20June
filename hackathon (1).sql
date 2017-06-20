-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2017 at 06:21 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

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
(6, 2),
(6, 21),
(7, 1);

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
-- Table structure for table `deals`
--

CREATE TABLE `deals` (
  `did` int(11) NOT NULL,
  `dname` varchar(40) NOT NULL,
  `ddescription` varchar(200) NOT NULL,
  `shared_by` int(11) NOT NULL,
  `shared_with` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deals`
--

INSERT INTO `deals` (`did`, `dname`, `ddescription`, `shared_by`, `shared_with`) VALUES
(3, 'Discount', '5% off', 1, 1),
(5, 'crash course', 'discounted crash course', 1, 7),
(6, 'analysis', 'using data', 1, 6),
(7, 'crash course', 'discounted course', 1, 2),
(8, 'Discount', 'discounted course', 1, 6),
(9, 'Discount', 'learn data analysis', 1, 6),
(10, 'Lecture By Shubham', 'Please Do attend!', 2, 6),
(11, 'Lecture By Karthik', 'Discounted Price Rs 5000.', 21, 6),
(12, 'Lecture By Karthik', 'Discounted Price Rs 5000.', 21, 6);

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
(7, 21, 1),
(8, 21, 4);

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
  `uid` int(11) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meetups`
--

INSERT INTO `meetups` (`mid`, `mname`, `mdescription`, `date`, `from_time`, `from_period`, `to_time`, `to_period`, `cid`, `lid`, `landmark`, `uid`, `latitude`, `longitude`) VALUES
(1, 'PHP Boot Camp', 'Kick Start your web development with PHP and MySQL', '2017-06-23', '10:00:00', 'AM', '12:00:00', 'PM', 1, 1, 'Kukatpally, Ashok Nagar, Jawaharlal Nehru Technological University, Kukatpally Housing Board Colony,', 1, 17.4946, 78.3922),
(2, 'Machine Learning', 'The Next Big Thing.!!', '2017-06-30', '07:00:00', 'PM', '10:00:00', 'PM', 2, 1, '8-2-409, Road Number 6, Banjara Hills, Green Valley, Banjara Hills,', 2, 17.4222, 78.4416),
(3, 'Artificial Intellegence', '\"PythonForArtificialIntelligence\".The best Package in Python For AI', '2017-07-01', '02:00:00', 'PM', '05:00:00', 'PM', 3, 2, 'Honeywell, Kalyani Campus, Krishnaraju Layout, Bengaluru, Karnataka, India', 3, 12.8993, 77.5999),
(6, 'Data Analytics', 'Data Science is a rapidly expanding Field.<br />\r\nLacks professionals.<br />\r\nGain Experience in developing advanced Data Science Charts.<br />\r\nExplore Machine Learning Also.', '2017-07-29', '08:00:00', 'AM', '12:00:00', 'PM', 2, 1, 'Road No.1, Banjara Hills, Mithila Nagar, Banjara Hills, Hyderabad, Telangana 500034, India', 1, 17.4097, 78.4488),
(7, 'Algorithmic Thinking', 'Have you ever wondered how Uber finds people travelling in the same route? Or google knows your favorite food?<br />\r\nBehind the scene, Algorithms are running the show.<br />\r\nLearn the basics of algorithms starting from Big-O Notation.', '2017-08-08', '02:00:00', 'PM', '08:30:00', 'PM', 4, 2, 'Ambedkar Veedhi, Sampangi Rama Nagar, Bengaluru, Karnataka 560001, India', 3, 12.9811, 77.5969),
(10, 'Cloud Computing', 'Meetup for discussing the recent advancements in Cloud Technology.', '2017-06-14', '01:00:00', 'AM', '01:30:00', 'AM', 4, 1, 'Abids, Hyderabad, Telangana, India', 2, 17.393, 78.473);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `did` int(11) NOT NULL,
  `dname` varchar(40) NOT NULL,
  `ddescription` varchar(200) NOT NULL,
  `shared_by` int(11) NOT NULL,
  `shared_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `uid`, `did`, `dname`, `ddescription`, `shared_by`, `shared_name`) VALUES
(1, 2, 9, 'Discount', 'learn data analysis', 1, 'narendra'),
(2, 21, 9, 'Discount', 'learn data analysis', 1, 'narendra'),
(3, 1, 10, 'Lecture By Shubham', 'Please Do attend!', 2, 'shubham'),
(4, 21, 10, 'Lecture By Shubham', 'Please Do attend!', 2, 'shubham'),
(5, 1, 12, 'Lecture By Karthik', 'Discounted Price Rs 5000.', 21, 'karthik'),
(6, 2, 12, 'Lecture By Karthik', 'Discounted Price Rs 5000.', 21, 'karthik');

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
(21, 'karthik', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', 'karthik@gmail.com', 1);

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
-- Indexes for table `deals`
--
ALTER TABLE `deals`
  ADD PRIMARY KEY (`did`),
  ADD KEY `shared_with` (`shared_with`),
  ADD KEY `shared_by` (`shared_by`);

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `did` (`did`),
  ADD KEY `shared_by` (`shared_by`);

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
-- AUTO_INCREMENT for table `deals`
--
ALTER TABLE `deals`
  MODIFY `did` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `interests`
--
ALTER TABLE `interests`
  MODIFY `iid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `meetups`
--
ALTER TABLE `meetups`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendees`
--
ALTER TABLE `attendees`
  ADD CONSTRAINT `fk_attendees_mid` FOREIGN KEY (`mid`) REFERENCES `meetups` (`mid`),
  ADD CONSTRAINT `fk_attendees_uid` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

--
-- Constraints for table `deals`
--
ALTER TABLE `deals`
  ADD CONSTRAINT `fk_deals_mid` FOREIGN KEY (`shared_with`) REFERENCES `meetups` (`mid`),
  ADD CONSTRAINT `fk_deals_uid` FOREIGN KEY (`shared_by`) REFERENCES `users` (`uid`) ON DELETE CASCADE;

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
