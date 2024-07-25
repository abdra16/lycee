-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 17 juil. 2024 à 03:43
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `essai`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateurs`
--

DROP TABLE IF EXISTS `administrateurs`;
CREATE TABLE IF NOT EXISTS `administrateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `administrateurs`
--

INSERT INTO `administrateurs` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'Abdra_Tr', 'abdrahamane992@gmail.com', '$2y$10$.wKfp4eN4JicgnAuTytTf.e3SzeEuugdq1Jdi/4z0KD20B5OluopK', '2024-07-16 17:08:28'),
(2, 'Traore', 'abdra@gmail.com', '$2y$10$40.LfQfS.kalie4Nlq8BAuvEKIzXaDXhjsPYKmLjq8AQ2pbqq6/dO', '2024-07-16 18:53:54');

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Médicaments', 'Catégorie pour les médicaments et produits pharmaceutiques.', '2024-07-16 23:30:20'),
(2, 'Produits de Beauté', 'Catégorie pour les produits de beauté et cosmétiques.', '2024-07-16 23:30:20'),
(3, 'Produits d\'Hygiène', 'Catégorie pour les produits d\'hygiène personnelle.', '2024-07-16 23:30:20'),
(4, 'Matériel Médical', 'Catégorie pour le matériel médical et les équipements de santé.', '2024-07-16 23:30:20'),
(5, 'Produits de Soins', 'Catégorie pour les produits de soins et de bien-être.', '2024-07-16 23:30:20'),
(6, 'Produits Alimentaires', 'Catégorie pour les produits alimentaires et les compléments alimentaires.', '2024-07-16 23:30:20'),
(7, 'Produits pour Animaux', 'Catégorie pour les produits pour animaux domestiques.', '2024-07-16 23:30:20'),
(8, 'Articles de Puériculture', 'Catégorie pour les articles de puériculture et pour bébés.', '2024-07-16 23:30:20'),
(9, 'Produits d\'Entretien', 'Catégorie pour les produits d\'entretien et de nettoyage.', '2024-07-16 23:30:20'),
(10, 'Produits Électroniques', 'Catégorie pour les produits électroniques et appareils technologiques.', '2024-07-16 23:30:20'),
(11, 'Articles de Maison', 'Catégorie pour les articles pour la maison et le quotidien.', '2024-07-16 23:30:20'),
(12, 'Vêtements et Accessoires', 'Catégorie pour les vêtements, chaussures et accessoires.', '2024-07-16 23:30:20'),
(13, 'Outils et Matériaux', 'Catégorie pour les outils, matériaux de construction et bricolage.', '2024-07-16 23:30:20'),
(14, 'Articles de Sport', 'Catégorie pour les articles de sport et équipements sportifs.', '2024-07-16 23:30:20'),
(15, 'Livres et Médias', 'Catégorie pour les livres, magazines et produits médiatiques.', '2024-07-16 23:30:20');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_inscription` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`(50),`email`(150))
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `username`, `email`, `password`, `date_inscription`) VALUES
(1, 'jojo10', 'jojo@gmail.com', '$2y$10$2OcmACCtl4fGTlOO47nW6uVx4EdQsnwtT56UAkkgIvk0GFRyNScA6', '2024-07-16 19:36:17'),
(2, 'Aicha12', 'aicha@gmail.com', '$2y$10$cWHDYwM14Cc3dlVujUOai.ioAgFTsYph02Gd2a5PmuVT7pLz1.Ct6', '2024-07-16 19:37:32');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fournisseur_id` int DEFAULT NULL,
  `produit` varchar(255) NOT NULL,
  `quantite` int NOT NULL,
  `prix_fcfa` decimal(10,2) NOT NULL,
  `date_commande` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `statut` varchar(50) DEFAULT 'En attente',
  PRIMARY KEY (`id`),
  KEY `fournisseur_id` (`fournisseur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `fournisseur_id`, `produit`, `quantite`, `prix_fcfa`, `date_commande`, `statut`) VALUES
(1, 18, 'x', 1, '12.00', '2024-07-17 02:32:29', 'Acceptée'),
(2, 18, 'D', 2, '2.00', '2024-07-17 02:32:29', 'En attente'),
(3, 28, 'c', 1, '1.00', '2024-07-17 03:03:35', 'En attente'),
(4, 28, 'Z', 3, '3.00', '2024-07-17 03:03:35', 'En attente'),
(5, 28, 'd', 2, '2.00', '2024-07-17 03:05:31', 'En attente'),
(6, 28, 'e', 1, '2.00', '2024-07-17 03:05:31', 'En attente'),
(7, 28, 'f', 4, '7.00', '2024-07-17 03:05:31', 'En attente'),
(8, 28, 'b', 2, '1.00', '2024-07-17 03:07:41', 'En attente'),
(9, 28, 'x', 1, '9.00', '2024-07-17 03:07:41', 'En attente'),
(10, 28, 'A', 2, '10.00', '2024-07-17 03:09:51', 'En attente'),
(11, 28, 'E', 2, '2.00', '2024-07-17 03:09:51', 'En attente');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

DROP TABLE IF EXISTS `fournisseurs`;
CREATE TABLE IF NOT EXISTS `fournisseurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` text,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `name`, `address`, `phone`, `email`, `created_at`) VALUES
(16, 'Bolloré Logistics', '5 rue de Chantecoq, 92800 Puteaux, France', '+33 1 46 96 44 44', 'contact@bollore-logistics.com', '2024-07-16 23:27:06'),
(17, 'Kuehne + Nagel', '63 Avenue de l\'Europe, 78140 Vélizy-Villacoublay, France', '+33 1 34 63 56 00', 'info@kuehne-nagel.com', '2024-07-16 23:27:06'),
(18, 'DHL Supply Chain', '1 Avenue des Sables, 59140 Dunkerque, France', '+33 3 28 66 21 00', 'customer.service@dhl.com', '2024-07-16 23:27:06'),
(19, 'Geodis', '26 Quai Charles Pasqua, 92300 Levallois-Perret, France', '+33 1 56 76 26 00', 'contact@geodis.com', '2024-07-16 23:27:06'),
(20, 'DB Schenker', '4 Rue du Colonel Moll, 75017 Paris, France', '+33 1 58 00 80 00', 'info.france@dbschenker.com', '2024-07-16 23:27:06'),
(21, 'Ceva Logistics', '10 Rue de l\'Industrie, 74100 Annemasse, France', '+33 4 50 87 99 00', 'contact@cevalogistics.com', '2024-07-16 23:27:06'),
(22, 'XPO Logistics', '192 Avenue Thiers, 69006 Lyon, France', '+33 4 78 89 45 00', 'contact@xpo.com', '2024-07-16 23:27:06'),
(23, 'UPS Supply Chain Solutions', '22 Rue des Chardonnerets, 95700 Roissy-en-France, France', '+33 1 73 00 66 61', 'france@ups.com', '2024-07-16 23:27:06'),
(24, 'Norbert Dentressangle', '192 Route de Paris, 69260 Charbonnières-les-Bains, France', '+33 4 72 23 23 23', 'contact@dentressangle.com', '2024-07-16 23:27:06'),
(25, 'GEFCO', '77/81 Rue Saint-Lazare, 75009 Paris, France', '+33 1 49 53 30 00', 'contact@gefco.net', '2024-07-16 23:27:06'),
(26, 'ID Logistics', '55 Avenue Jules Quentin, 92000 Nanterre, France', '+33 1 30 10 25 00', 'contact@id-logistics.com', '2024-07-16 23:27:06'),
(27, 'Tred Union', '4 Rue de la Croix Verte, 75016 Paris, France', '+33 1 45 27 24 24', 'info@tred-union.com', '2024-07-16 23:27:06'),
(28, 'FM Logistic', '1 Rue de l\'Egalité, 77230 Dammartin-en-Goële, France', '+33 1 60 03 55 00', 'contact@fmlogistic.com', '2024-07-16 23:27:06'),
(29, 'Panopa Logistique', '15 Rue Jean Jaurès, 92800 Puteaux, France', '+33 1 47 75 44 44', 'contact@panopa.fr', '2024-07-16 23:27:06'),
(30, 'STEF', '93 Boulevard Malesherbes, 75008 Paris, France', '+33 1 40 74 29 00', 'contact@stef.com', '2024-07-16 23:27:06');

-- --------------------------------------------------------

--
-- Structure de la table `livreurs`
--

DROP TABLE IF EXISTS `livreurs`;
CREATE TABLE IF NOT EXISTS `livreurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `adresse` text NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
