-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 11, 2019 at 04:43 AM
-- Server version: 5.7.25
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `slim`
--

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `profile` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `user_id`, `name`, `profile`, `created_at`) VALUES
(1, 1, '1-5c85e3ff39c1b5.66353278.jpeg', 0, '2019-03-11 04:28:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gender` varchar(20) DEFAULT NULL,
  `looking` varchar(20) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `biography` text,
  `tags` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `postal_code` varchar(50) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `vkey` varchar(255) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(255) DEFAULT NULL,
  `tokenExpiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `created_at`, `gender`, `looking`, `birthdate`, `biography`, `tags`, `address`, `city`, `country`, `postal_code`, `phone`, `status`, `rating`, `vkey`, `verified`, `token`, `tokenExpiration`) VALUES
(1, 'ouss', 'nahiz', 'onahiz', 'onahiz@student.1337.ma', '$2y$10$Yvj4gBe79SdW2/BhmeGXWudQ5aAodUsTk9syDQ4Nx/4pROYB5ZXMy', '2019-03-06 23:32:53', 'male', 'female', '1993-01-17', 'dignissimos rerum sed ipsam quasi quod\n', '1337,42', '96, rue des jardins', 'khouribga', 'maroc', '2500099', '06530986257', NULL, NULL, 'e55b72f4d42a6e9c12f8', 1, '4afa16429fbc3747', '2019-03-11 06:40:08'),
(2, 'john', 'snow', 'jsnow', 'magavoka@weave.email', '$2y$10$2Q5/NBBLCYsk4ILeDF2NZ.jb8wPWHGzUR2HKFKIh3PluBwBpe1Koi', '2019-03-07 20:55:47', NULL, NULL, NULL, 'pecial char Password must contain at least one letter, one number and one special charLorempecial char Password must contain at least one letter, one number and one special charLorem trrr', 'stark,winter is coming,ghost,nights watch', '96, wintertown', 'winterfell', 'westeros', '99906', '0653095683', NULL, NULL, '382c669ff4288a229b68', 1, '59b0f4d3d2f62382', '2019-03-09 04:13:13'),
(3, 'denis', 'ritchie', 'dritch', 'refib@yourweb.email', '$2y$10$HKJaBkO9xiFU3V81tp65xeJrGuk3DawNUwo7gCEkOF66s0DqBQCmS', '2019-03-11 01:57:21', NULL, NULL, '1993-01-17', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3b4aa48bdb277562f180', 1, '06c6b51b17d402e3', '2019-03-11 03:59:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
