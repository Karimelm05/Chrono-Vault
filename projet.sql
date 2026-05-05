-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 01 mai 2026 à 01:19
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS chrono_vault;
USE chrono_vault;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `chrono_vault`
--

-- --------------------------------------------------------

--
-- Structure de la table `capsule`
--

CREATE TABLE `capsule` (
  `Id_Capsule` int(11) NOT NULL,
  `titre` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_ouverture` datetime DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `Id_Utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `invitation`
--

CREATE TABLE `invitation` (
  `Id_Invitation` int(11) NOT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `date_envoi` datetime DEFAULT NULL,
  `Id_Capsule` int(11) NOT NULL,
  `Id_Utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `souvenir`
--

CREATE TABLE `souvenir` (
  `Id_Souvenir` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `donnee` varchar(255) DEFAULT NULL,
  `date_poste` datetime DEFAULT NULL,
  `Id_Utilisateur` int(11) NOT NULL,
  `Id_Capsule` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `Id_Utilisateur` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `statut` varchar(20) NOT NULL DEFAULT 'actif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Structure de la table `remember_tokens`
--

CREATE TABLE `remember_tokens` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Id_Utilisateur` INT NOT NULL,
  `token` CHAR(64) NOT NULL,
  `expires_at` DATETIME NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_token` (`token`),
  CONSTRAINT `fk_remember_user`
    FOREIGN KEY (`Id_Utilisateur`)
    REFERENCES `utilisateur` (`Id_Utilisateur`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`Id_Utilisateur`, `nom`, `email`, `mot_de_passe`, `role`, `statut`) VALUES
(1, 'ENSIASD', 'ENSIASD@edu.uiz.ac.ma', 'ENSIASD2026', 'admin', 'actif');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `capsule`
--
ALTER TABLE `capsule`
  ADD PRIMARY KEY (`Id_Capsule`),
  ADD KEY `fk_capsule_utilisateur` (`Id_Utilisateur`);

--
-- Index pour la table `invitation`
--
ALTER TABLE `invitation`
  ADD PRIMARY KEY (`Id_Invitation`),
  ADD KEY `fk_invitation_capsule` (`Id_Capsule`),
  ADD KEY `fk_invitation_utilisateur` (`Id_Utilisateur`);

--
-- Index pour la table `souvenir`
--
ALTER TABLE `souvenir`
  ADD PRIMARY KEY (`Id_Souvenir`),
  ADD KEY `fk_souvenir_utilisateur` (`Id_Utilisateur`),
  ADD KEY `fk_souvenir_capsule` (`Id_Capsule`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`Id_Utilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `capsule`
--
ALTER TABLE `capsule`
  MODIFY `Id_Capsule` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `invitation`
--
ALTER TABLE `invitation`
  MODIFY `Id_Invitation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `souvenir`
--
ALTER TABLE `souvenir`
  MODIFY `Id_Souvenir` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `Id_Utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `capsule`
--
ALTER TABLE `capsule`
  ADD CONSTRAINT `fk_capsule_utilisateur` FOREIGN KEY (`Id_Utilisateur`) REFERENCES `utilisateur` (`Id_Utilisateur`);

--
-- Contraintes pour la table `invitation`
--
ALTER TABLE `invitation`
  ADD CONSTRAINT `fk_invitation_capsule` FOREIGN KEY (`Id_Capsule`) REFERENCES `capsule` (`Id_Capsule`),
  ADD CONSTRAINT `fk_invitation_utilisateur` FOREIGN KEY (`Id_Utilisateur`) REFERENCES `utilisateur` (`Id_Utilisateur`);

--
-- Contraintes pour la table `souvenir`
--
ALTER TABLE `souvenir`
  ADD CONSTRAINT `fk_souvenir_capsule` FOREIGN KEY (`Id_Capsule`) REFERENCES `capsule` (`Id_Capsule`),
  ADD CONSTRAINT `fk_souvenir_utilisateur` FOREIGN KEY (`Id_Utilisateur`) REFERENCES `utilisateur` (`Id_Utilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;