-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2026 at 08:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moviemarker`
--

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `genre` varchar(40) NOT NULL,
  `release_year` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `poster` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `genre`, `release_year`, `description`, `poster`) VALUES
(1, 'Jujutsu Kaisen 0', 'Animation', 2021, 'Yuta Okkotsu, a teenager haunted by a powerful curse, joins a school for sorcerers to learn to control it.', 'jujutsu-kaisen-0.jpg'),
(2, 'Chainsaw Man: The Movie - Reze Arc', 'Animation', 2025, 'Denji meets a mysterious girl named Reze, and a budding romance gets tangled up with a deadly secret.', 'reze-arc.jpg'),
(3, 'Spider-Man: Across the Spider-Verse', 'Animation', 2023, 'Miles Morales meets a team of Spider-People from across the multiverse.', 'across-the-spider-verse.jpg'),
(4, 'Avengers: Endgame', 'Action', 2019, 'The surviving Avengers team up for one last fight to undo the damage Thanos caused.', 'endgame.jpg'),
(5, 'The Batman', 'Action', 2022, 'Batman hunts a killer targeting powerful figures in Gotham and uncovers deep corruption.', 'the-batman.jpg'),
(6, 'Violet Evergarden: The Movie', 'Animation', 2020, 'Violet, a former soldier turned letter writer, keeps searching for the meaning of love and the last words of the man she cared about.', 'violet-evergarden.jpg'),
(7, 'The Odyssey', 'Adventure', 2026, 'Odysseus fights to get home after the Trojan War in a Christopher Nolan film based on the ancient Greek epic.', 'the-odyssey.jpg'),
(8, 'Spider-Man: Brand New Day', 'Action', 2026, 'Years after the world forgot him, Peter Parker tries to leave Spider-Man behind, but a new danger forces him back into the suit.', 'brand-new-day.jpg'),
(9, 'Obsession', 'Horror', 2026, 'A young man makes a wish to win someone over, and it turns into a nightmare about control.', 'obsession.jpg'),
(10, 'Resident Evil', 'Horror', 2026, 'A new survival horror story with original characters, set during the events of Resident Evil 2.', 'resident-evil.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `created_at`) VALUES
(1, 'Larryu', 'zendergamer13@gmail.com', '$2y$10$cbogv.oIXaZG9l18S1qqvOxmMqn3.cPRkBB0gqxVSjZDGBtT9RXpy', '2026-10-26 05:28:10');

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE `watchlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `status` enum('want','watched') NOT NULL DEFAULT 'want',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `watchlist`
--

INSERT INTO `watchlist` (`id`, `user_id`, `movie_id`, `status`, `created_at`) VALUES
(4, 1, 10, 'want', '2026-10-28 03:02:48'),
(5, 1, 9, 'want', '2026-10-28 03:02:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`movie_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `watchlist`
--
ALTER TABLE `watchlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD CONSTRAINT `watchlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `watchlist_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
