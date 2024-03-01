-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : jeu. 04 jan. 2024 à 21:55
-- Version du serveur : 8.0.33
-- Version de PHP : 8.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `anime-tracker`
--

-- --------------------------------------------------------

--
-- Structure de la table `Anime`
--

CREATE TABLE `Anime` (
  `id` int NOT NULL,
  `nom` varchar(200) NOT NULL,
  `episode_nb` int DEFAULT NULL,
  `note` decimal(4,2) DEFAULT NULL,
  `img` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `type_id` int DEFAULT NULL,
  `duration_id` int DEFAULT NULL,
  `statut_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Anime_a_Genre`
--

CREATE TABLE `Anime_a_Genre` (
  `anime_id` int NOT NULL,
  `genre_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Duree`
--

CREATE TABLE `Duree` (
  `id` int NOT NULL,
  `label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Genre`
--

CREATE TABLE `Genre` (
  `id` int NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Statut`
--

CREATE TABLE `Statut` (
  `id` int NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Type`
--

CREATE TABLE `Type` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Anime`
--
ALTER TABLE `Anime`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_type_id` (`type_id`),
  ADD KEY `fk_statut_id` (`statut_id`),
  ADD KEY `fk_duration_id` (`duration_id`);

--
-- Index pour la table `Anime_a_Genre`
--
ALTER TABLE `Anime_a_Genre`
  ADD PRIMARY KEY (`anime_id`,`genre_id`),
  ADD KEY `fk_genre_id` (`genre_id`);

--
-- Index pour la table `Duree`
--
ALTER TABLE `Duree`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Genre`
--
ALTER TABLE `Genre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Statut`
--
ALTER TABLE `Statut`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Type`
--
ALTER TABLE `Type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Anime`
--
ALTER TABLE `Anime`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Duree`
--
ALTER TABLE `Duree`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Genre`
--
ALTER TABLE `Genre`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Statut`
--
ALTER TABLE `Statut`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Type`
--
ALTER TABLE `Type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Anime`
--
ALTER TABLE `Anime`
  ADD CONSTRAINT `fk_duration_id` FOREIGN KEY (`duration_id`) REFERENCES `Duree` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_statut_id` FOREIGN KEY (`statut_id`) REFERENCES `Statut` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_type_id` FOREIGN KEY (`type_id`) REFERENCES `Type` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `Anime_a_Genre`
--
ALTER TABLE `Anime_a_Genre`
  ADD CONSTRAINT `fk_anime_id` FOREIGN KEY (`anime_id`) REFERENCES `Anime` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_genre_id` FOREIGN KEY (`genre_id`) REFERENCES `Genre` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;