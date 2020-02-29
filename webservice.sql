-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2019 at 10:22 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- SET AUTOCOMMIT = 0;
-- START TRANSACTION;
-- SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webservice`
--
-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(11, '2019_04_10_040553_create_places_table', 2),
(12, '2019_04_10_153955_create_schedule_table', 2),
(15, '2019_04_12_083857_create_route_history_table', 3),
(16, '2019_04_30_041243_create_new_field_on_table_route_histories', 4);

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `x` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `y` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `name`, `latitude`, `longitude`, `x`, `y`, `img_path`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Bengkulu', '1', '1', '550', '580', '/img/bengkulu.jpg', 'Bengkulu adalah kota memiliki bunga langkah yaitu Rafflesia Alnordi', '2019-04-26 17:35:23', '2019-04-28 21:22:32'),
(2, 'Aceh', '1', '1', '150', '70', '/img/aceh.jpg', 'Aceh adalah kota yang terkenal dengan kekentalan agama islamnya', '2019-04-26 17:38:22', '2019-04-28 21:22:41'),
(3, 'Padang', '1', '1', '440', '410', '/img/padang.jpg', 'Padang adalah kota dengan kuliner yang beragam, salah satunya yaitu nasi padang', '2019-04-27 01:55:04', '2019-04-28 21:22:50'),
(4, 'Lampung', '1', '1', '660', '670', '/img/lampung.jpg', 'Lampung adalah kota', '2019-04-29 00:21:05', '2019-04-29 00:39:55'),
(5, 'Medan', '1', '1', '350', '230', '-', 'Medan adalah kota yang terkenal dengan danau tobanya', '2019-04-29 22:33:07', '2019-04-29 22:37:48'),
(6, 'Riau', '1', '1', '530', '340', '-', 'Riau adalah kota yang paling dekat dengan singapura dan malaysia', '2019-04-29 22:38:55', '2019-04-29 22:39:43'),
(7, 'Jambi', '1', '1', '550', '450', '-', 'Jambi adalah kota yang banyak sekali wisata alamnya', '2019-04-29 22:41:27', '2019-04-29 22:42:28'),
(8, 'Palembang', '1', '1', '600', '550', '-', 'Palembang adalah kota yang terkenal dengan jembatan Ampera', '2019-04-29 22:44:13', '2019-04-29 22:45:14');

-- --------------------------------------------------------

--
-- Table structure for table `route_histories`
--

CREATE TABLE `route_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_place_id` bigint(20) UNSIGNED NOT NULL,
  `to_place_id` bigint(20) UNSIGNED NOT NULL,
  `schedule_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `frekuensi` bigint(20) NOT NULL,
  `user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `route_histories`
--

INSERT INTO `route_histories` (`id`, `from_place_id`, `to_place_id`, `schedule_id`, `frekuensi`, `user`) VALUES
(1, 1, 2, '1,4', 2, 'reza'),
(2, 2, 3, '10', 1, 'umum'),
(3, 3, 4, '11', 1, 'umum');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('bus','train') COLLATE utf8mb4_unicode_ci NOT NULL,
  `line` int(11) NOT NULL,
  `from_place_id` bigint(20) UNSIGNED NOT NULL,
  `to_place_id` bigint(20) UNSIGNED NOT NULL,
  `departure_time` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `arrival_time` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `distance` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `speed` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` enum('client','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `api_token`, `level`, `created_at`, `updated_at`) VALUES
(12, 'reza', '$2y$10$hIobXhCQ9D72UHoHavKXleaFr8bhZ7aoFhEMThAtjTXHjPKbYYewa', 'cab2384fe07bded068d9b0804423387c', 'admin', '2019-04-10 17:48:42', '2019-05-01 00:50:50'),
(14, 'dian', '$2y$10$5QIhmc5biZzaPzC4OO2qa.k/KTfLHsN2QzSmQMvEH7hHPGB1j07YC', '', 'client', '2019-04-10 18:19:04', '2019-04-30 10:04:45'),
(15, 'umum', 'umum', 'umum', 'client', '2019-04-21 21:00:00', '2019-04-21 23:05:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `route_histories`
--
ALTER TABLE `route_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `route_histories_from_place_id_foreign` (`from_place_id`),
  ADD KEY `route_histories_to_place_id_foreign` (`to_place_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_from_place_id_foreign` (`from_place_id`),
  ADD KEY `schedules_to_place_id_foreign` (`to_place_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `route_histories`
--
ALTER TABLE `route_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `route_histories`
--
ALTER TABLE `route_histories`
  ADD CONSTRAINT `route_histories_from_place_id_foreign` FOREIGN KEY (`from_place_id`) REFERENCES `places` (`id`),
  ADD CONSTRAINT `route_histories_to_place_id_foreign` FOREIGN KEY (`to_place_id`) REFERENCES `places` (`id`);

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_from_place_id_foreign` FOREIGN KEY (`from_place_id`) REFERENCES `places` (`id`),
  ADD CONSTRAINT `schedules_to_place_id_foreign` FOREIGN KEY (`to_place_id`) REFERENCES `places` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
