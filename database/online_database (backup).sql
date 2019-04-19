-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 19 apr 2019 om 02:58
-- Serverversie: 10.1.31-MariaDB
-- PHP-versie: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `urbex`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `streetname_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `comments`
--

INSERT INTO `comments` (`id`, `message`, `user_id`, `post_id`, `timestamp`) VALUES
(29, 'ghyj', 3, 7, '2019-04-18 23:25:51'),
(30, 'ytjt', 3, 7, '2019-04-18 23:25:53'),
(31, 'tyjty', 3, 7, '2019-04-18 23:25:54'),
(32, 'tyj', 3, 7, '2019-04-18 23:25:55'),
(33, 'j', 3, 7, '2019-04-18 23:25:55'),
(34, 'ty', 3, 7, '2019-04-18 23:25:55'),
(35, 'jytjy', 3, 7, '2019-04-18 23:25:56'),
(36, 'jyt', 3, 7, '2019-04-18 23:25:56'),
(37, 'yjt', 3, 7, '2019-04-18 23:25:56'),
(38, 'j', 3, 7, '2019-04-18 23:25:56'),
(39, 'jyt', 3, 7, '2019-04-18 23:25:56'),
(40, 'ytj', 3, 7, '2019-04-18 23:25:57'),
(41, 'tyj', 3, 7, '2019-04-18 23:25:57'),
(42, '', 3, 7, '2019-04-18 23:25:57'),
(43, 'j', 3, 7, '2019-04-18 23:25:57'),
(44, 'j', 3, 7, '2019-04-18 23:25:58'),
(45, 'ty', 3, 7, '2019-04-18 23:25:58'),
(46, 'tyj', 3, 7, '2019-04-18 23:26:05'),
(47, 'lars', 3, 7, '2019-04-18 23:26:08'),
(48, 'Lars', 3, 7, '2019-04-18 23:26:18'),
(49, 'lars', 3, 8, '2019-04-18 23:27:31'),
(50, 'is', 3, 8, '2019-04-18 23:27:33'),
(51, 'erg', 3, 8, '2019-04-18 23:27:34'),
(52, 'cool', 3, 8, '2019-04-18 23:27:35'),
(53, 'want', 3, 8, '2019-04-18 23:27:37'),
(54, 'hij', 3, 8, '2019-04-18 23:27:38'),
(55, 'kan', 3, 8, '2019-04-18 23:27:39'),
(56, 'php', 3, 8, '2019-04-18 23:27:41'),
(57, 'zeer', 3, 8, '2019-04-18 23:27:43'),
(58, 'goed', 3, 8, '2019-04-18 23:27:45'),
(59, 'maar', 3, 8, '2019-04-18 23:27:48'),
(60, 'die', 3, 8, '2019-04-18 23:27:52'),
(61, 'kan', 3, 8, '2019-04-18 23:27:57');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `follower` int(11) NOT NULL,
  `following` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `likes_comments`
--

CREATE TABLE `likes_comments` (
  `id` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `likes_posts`
--

CREATE TABLE `likes_posts` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `likes_posts`
--

INSERT INTO `likes_posts` (`id`, `post_id`, `user_id`, `timestamp`) VALUES
(47, 7, 3, '2019-04-18 22:27:05');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `latitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `posts`
--

INSERT INTO `posts` (`id`, `image`, `title`, `description`, `timestamp`, `active`, `user_id`, `location_id`) VALUES
(7, '5cb8beb0245661.34579019.png', 'test', 'zef', '2019-04-18 18:15:16', 1, 3, 0),
(8, '5cb8f7e7ae3fc3.00478460.png', 'ioulmy', 'oyipy', '2019-04-18 22:19:24', 1, 3, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `streetnames`
--

CREATE TABLE `streetnames` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `house_number` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tags_following`
--

CREATE TABLE `tags_following` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_pic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `background_pic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `profile_pic`, `description`, `background_pic`, `timestamp`, `active`) VALUES
(3, 'Lars', 'Pauwels', 'admin', 'lars.pauwels@telenet.be', '$2y$12$8uWg9cce89DTGofSXt6.tOGkcuMb5bJv3wECD.qyPGmDxi/5CCnYK', 'standerd.jpg', '', 'standerd.jpg', '2019-04-19 00:52:35', 1);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `likes_comments`
--
ALTER TABLE `likes_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `likes_posts`
--
ALTER TABLE `likes_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `streetnames`
--
ALTER TABLE `streetnames`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `tags_following`
--
ALTER TABLE `tags_following`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT voor een tabel `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `likes_comments`
--
ALTER TABLE `likes_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `likes_posts`
--
ALTER TABLE `likes_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT voor een tabel `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `streetnames`
--
ALTER TABLE `streetnames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `tags_following`
--
ALTER TABLE `tags_following`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
