-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2016 at 02:30 AM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `znewman`
--

-- --------------------------------------------------------

--
-- Table structure for table `mm_appointments`
--

CREATE TABLE `mm_appointments` (
  `id` int(11) NOT NULL,
  `mentor_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `price` float NOT NULL,
  `instrument_id` int(11) NOT NULL,
  `location` text NOT NULL,
  `open` tinyint(4) NOT NULL,
  `timezone` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mm_appointments`
--

INSERT INTO `mm_appointments` (`id`, `mentor_id`, `student_id`, `date`, `start_time`, `end_time`, `price`, `instrument_id`, `location`, `open`, `timezone`) VALUES
(7, 1, NULL, '2016-05-28', '12:00:00', '13:00:00', 40, 1, 'New Philadelphia, OH, United States', 1, '(GMT-05:00) Eastern Time (US & Canada)'),
(8, 1, NULL, '2016-05-20', '07:00:00', '08:00:00', 35, 1, 'New Philadelphia, OH, United States', 1, '(GMT-12:00) International Date Line West');

-- --------------------------------------------------------

--
-- Table structure for table `mm_auth`
--

CREATE TABLE `mm_auth` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selector` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mm_genres`
--

CREATE TABLE `mm_genres` (
  `id` int(11) NOT NULL,
  `genre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mm_genres`
--

INSERT INTO `mm_genres` (`id`, `genre`) VALUES
(1, 'Classical'),
(2, 'Jazz'),
(3, 'Rock'),
(4, 'Folk'),
(5, 'Metal'),
(6, 'Funk');

-- --------------------------------------------------------

--
-- Table structure for table `mm_instruments`
--

CREATE TABLE `mm_instruments` (
  `id` int(11) NOT NULL,
  `instrument` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mm_instruments`
--

INSERT INTO `mm_instruments` (`id`, `instrument`) VALUES
(1, 'Guitar'),
(2, 'Bass'),
(3, 'Piano'),
(4, 'Percussion'),
(5, 'Vocals'),
(6, 'Drums');

-- --------------------------------------------------------

--
-- Table structure for table `mm_locations`
--

CREATE TABLE `mm_locations` (
  `id` int(11) NOT NULL,
  `appt_id` int(11) NOT NULL,
  `address` varchar(80) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `marker` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mm_orders`
--

CREATE TABLE `mm_orders` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mm_orders`
--

INSERT INTO `mm_orders` (`id`, `student_id`, `date_time`, `total`) VALUES
(1, 3, '2016-04-28 00:11:37', 110);

-- --------------------------------------------------------

--
-- Table structure for table `mm_reviews`
--

CREATE TABLE `mm_reviews` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `mentor_id` int(11) NOT NULL,
  `review_date` date NOT NULL,
  `review_text` text NOT NULL,
  `rating` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mm_reviews`
--

INSERT INTO `mm_reviews` (`id`, `student_id`, `mentor_id`, `review_date`, `review_text`, `rating`) VALUES
(1, 3, 1, '2016-04-03', 'testmentor did a great job of explaining things and really knew his stuff!', 5),
(2, 3, 1, '2016-04-04', 'Once again, this guy is great!', 5),
(3, 3, 1, '2016-04-04', 'Test review', 3);

-- --------------------------------------------------------

--
-- Table structure for table `mm_users`
--

CREATE TABLE `mm_users` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `bio` text,
  `profile_image_name` varchar(255) DEFAULT NULL,
  `salt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mm_users`
--

INSERT INTO `mm_users` (`id`, `username`, `password`, `email`, `type`, `bio`, `profile_image_name`, `salt`) VALUES
(1, 'testmentor', '15b628194f386cd05d4f515773da949cf0a9b50b846d1f393ac589ff0748a755', 'testmentor@musicmentors.com', 1, 'I like to play classical and rock guitar and drums.\r\nRock on!', 'community_image_1418393964.png', 'qDWM5NadUpHhCvDu'),
(2, 'drumguy20', '5958eeb76148a7fbbd62c0b23ee97d42e31b71e87d8e27da01aeb27843d97204', 'drumguy20@musicmentor.com', 1, NULL, NULL, 'QGa9Pj6/h4GJg6mJ'),
(3, 'znewman', 'a280e47bad398944d71b55f056465f6483e12de80fe823974e4c304a302ca32d', 'znewman@mm.com', 0, 'I like to play metal and classical!', 'maxresdefault.jpg', 'hI+NfBe0dJgb+a41');

-- --------------------------------------------------------

--
-- Table structure for table `mm_user_genres`
--

CREATE TABLE `mm_user_genres` (
  `user_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mm_user_genres`
--

INSERT INTO `mm_user_genres` (`user_id`, `genre_id`) VALUES
(1, 1),
(1, 3),
(2, 2),
(2, 6),
(3, 1),
(3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `mm_user_instruments`
--

CREATE TABLE `mm_user_instruments` (
  `user_id` int(11) NOT NULL,
  `instrument_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mm_user_instruments`
--

INSERT INTO `mm_user_instruments` (`user_id`, `instrument_id`) VALUES
(1, 1),
(1, 6),
(2, 4),
(2, 6),
(3, 1),
(3, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mm_appointments`
--
ALTER TABLE `mm_appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mm_auth`
--
ALTER TABLE `mm_auth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mm_genres`
--
ALTER TABLE `mm_genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mm_instruments`
--
ALTER TABLE `mm_instruments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mm_locations`
--
ALTER TABLE `mm_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mm_orders`
--
ALTER TABLE `mm_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mm_reviews`
--
ALTER TABLE `mm_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mm_users`
--
ALTER TABLE `mm_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `mm_user_genres`
--
ALTER TABLE `mm_user_genres`
  ADD PRIMARY KEY (`user_id`,`genre_id`);

--
-- Indexes for table `mm_user_instruments`
--
ALTER TABLE `mm_user_instruments`
  ADD PRIMARY KEY (`user_id`,`instrument_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mm_appointments`
--
ALTER TABLE `mm_appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `mm_auth`
--
ALTER TABLE `mm_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mm_genres`
--
ALTER TABLE `mm_genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `mm_instruments`
--
ALTER TABLE `mm_instruments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `mm_locations`
--
ALTER TABLE `mm_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mm_orders`
--
ALTER TABLE `mm_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `mm_reviews`
--
ALTER TABLE `mm_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mm_users`
--
ALTER TABLE `mm_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
