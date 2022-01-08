-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 08 jan. 2022 à 21:35
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `store`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'chemise'),
(2, 'pantalon'),
(3, 'jeans'),
(4, 'Jeans enfants (5-7)'),
(5, 'Jeans enfants (7-10)'),
(7, 'Jeans enfants (10-15)');

-- --------------------------------------------------------

--
-- Structure de la table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` double NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `value`, `status`) VALUES
(1, 'ok', 20, 1);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20211218111625', '2021-12-18 12:16:50', 361),
('DoctrineMigrations\\Version20211218112037', '2021-12-18 12:20:50', 83),
('DoctrineMigrations\\Version20211218113135', '2021-12-18 12:31:49', 127),
('DoctrineMigrations\\Version20211218113637', '2021-12-18 12:36:44', 117),
('DoctrineMigrations\\Version20211218114832', '2021-12-18 12:48:41', 346),
('DoctrineMigrations\\Version20211218115312', '2021-12-18 12:53:19', 181),
('DoctrineMigrations\\Version20211218120117', '2021-12-18 13:01:24', 74),
('DoctrineMigrations\\Version20211222085702', '2021-12-22 09:57:28', 1459),
('DoctrineMigrations\\Version20211222085904', '2021-12-22 09:59:19', 306),
('DoctrineMigrations\\Version20211223121605', '2021-12-23 13:16:19', 1986),
('DoctrineMigrations\\Version20211223124442', '2021-12-23 13:44:55', 120),
('DoctrineMigrations\\Version20211223125059', '2021-12-23 13:51:58', 274),
('DoctrineMigrations\\Version20211224072510', '2021-12-24 08:25:22', 1340),
('DoctrineMigrations\\Version20211224073926', '2021-12-24 08:39:33', 483),
('DoctrineMigrations\\Version20211224074402', '2021-12-24 08:44:12', 223),
('DoctrineMigrations\\Version20220101084830', '2022-01-01 09:48:59', 450),
('DoctrineMigrations\\Version20220101090439', '2022-01-01 10:04:46', 282),
('DoctrineMigrations\\Version20220101090607', '2022-01-01 10:06:16', 194),
('DoctrineMigrations\\Version20220101090711', '2022-01-01 10:07:15', 69),
('DoctrineMigrations\\Version20220104073634', '2022-01-04 08:37:35', 132),
('DoctrineMigrations\\Version20220104073754', '2022-01-04 08:38:00', 63),
('DoctrineMigrations\\Version20220104074027', '2022-01-04 08:49:46', 132),
('DoctrineMigrations\\Version20220104080158', '2022-01-04 09:02:07', 427),
('DoctrineMigrations\\Version20220104080408', '2022-01-04 09:04:16', 661);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id`, `product_id`, `link`) VALUES
(5, 8, 'a5d0988f4b7847fa1a27af542fdb3e5c.jpeg'),
(6, 9, 'adc386d48fe06a03cec5ba104ab1eaec.jpeg'),
(7, 10, '9fabd9eaed9e79489b93c89b87e27455.jpeg'),
(8, 11, '8204b20e1495973e41a62d73b3d1b04b.jpeg'),
(9, 12, 'fbe8ff9d1e5e273a1620ce868a04bd1d.jpeg'),
(10, 13, '6059d9c29d5c8e4e0f5bfc74744128e5.jpeg'),
(11, 14, '41f1704a928d1778166f2edfb5fc85c6.jpeg'),
(12, 15, '11e154badd9510022cf4bdb326955799.jpeg'),
(13, 16, 'd6516aaa34e5b2b280814e8c27abd62f.jpeg'),
(14, 17, 'c1ffae630c023bc762b08a3a090a287e.jpeg'),
(15, 18, 'ed7b7a42a6e955d8fcdca175513cdf65.jpeg'),
(16, 19, 'e0773360cefdb3f046678514fb073fc1.jpeg'),
(17, 20, 'd11b890ae96bfbc1e9b9a60f775c20db.jpeg'),
(18, 21, '0427c33067a941b6fb317661830891af.jpeg'),
(19, 22, 'fbeb77cdd31dfa827bdfffcec93a7631.jpeg'),
(20, 23, '5d5f158c3c6611e84951be8ad43bf801.jpeg'),
(21, 24, 'e25a98e11e55fefdc7bbf3ce1f12b3cc.jpeg'),
(22, 25, '4536253f43ee13aced93575222578ee6.jpeg'),
(23, 26, 'a6815448c04eb67fbba5cda3ca0ff0ba.jpeg'),
(24, 27, 'e12530cb1185a5e4a1d5bb91278b484d.jpeg'),
(25, 28, 'cf536e81d608e9341a15ccdf82029ba2.jpeg'),
(26, 29, '1eeacaebbb8ca3a8c5889b43aad0a0c1.jpeg'),
(27, 30, 'b4e7575c3f605a4b76162b35ba9c2763.jpeg'),
(28, 31, '0e8cabedb7fbae238f161b0c6920a53b.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `created_at`) VALUES
(13, 2, '2021-12-23 14:58:18'),
(14, 1, '2021-12-24 08:18:47'),
(15, 1, '2022-01-01 10:30:41'),
(16, 1, '2022-01-01 10:34:36'),
(17, 1, '2022-01-01 10:40:38'),
(18, 1, '2022-01-01 10:46:21'),
(19, 1, '2022-01-01 10:54:16'),
(20, 1, '2022-01-01 10:57:28'),
(21, 1, '2022-01-01 11:01:46'),
(22, 1, '2022-01-01 11:41:57'),
(23, 1, '2022-01-04 18:05:35'),
(24, 1, '2022-01-04 19:13:07'),
(25, 3, '2022-01-04 23:17:12'),
(26, 3, '2022-01-05 23:12:45'),
(27, 3, '2022-01-07 01:23:01'),
(28, 3, '2022-01-07 01:23:13');

-- --------------------------------------------------------

--
-- Structure de la table `orders_products`
--

CREATE TABLE `orders_products` (
  `orders_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `orders_products`
--

INSERT INTO `orders_products` (`orders_id`, `products_id`) VALUES
(23, 8),
(24, 8),
(26, 8),
(27, 8);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `price` double NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `categorie_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `price`, `name`, `quantity`, `created_at`, `categorie_id`) VALUES
(8, 15, 'JEANS SKINNY DÉLAVÉ - BLEU / GARÇON', 20, '2022-01-04 17:25:32', 7),
(9, 10, 'Jean slim MorphologiK tour de hanches LARGE garçon - stone', 15, '2022-01-08 10:54:02', 4),
(10, 17, 'Jean slim MorphologiK tour de hanches LARGE garçon - stone', 12, '2022-01-08 11:09:47', 4),
(11, 23, 'Jean élastiqué enfant garçon', 13, '2022-01-08 11:11:28', 4),
(12, 19, 'Jean slim MorphologiK \"waterless\" garçon tour de hanches FIN - stone', 22, '2022-01-08 11:18:43', 4),
(13, 24, 'Pantalon droit confort en molleton effet denim garçon - denim black', 16, '2022-01-08 11:22:08', 4),
(14, 13, 'Jean slim garçon - denim brut', 11, '2022-01-08 11:25:25', 5),
(15, 20, 'Pantalon droit confort en molleton effet denim garçon - denim blue black', 30, '2022-01-08 11:27:51', 5),
(16, 42, 'Mayoral - Jeans troué 8 ans bleu délavé garçon', 9, '2022-01-08 11:35:23', 5),
(17, 27, 'JEAN SKINNY DESTROY - BLEU / GARÇON', 12, '2022-01-08 11:46:04', 7),
(18, 23, 'Jean regular doublé polaire enfant garçon', 15, '2022-01-08 11:48:08', 5),
(19, 35, 'Jean garçon STONE 8 ANS', 8, '2022-01-08 11:56:06', 5),
(20, 32, 'Losan - Jeans 8 ans denim garçon', 12, '2022-01-08 11:58:03', 5),
(21, 22, 'Kaporal Voz Jeans Garçon', 14, '2022-01-08 12:05:37', 5),
(22, 15, 'Jean slim MorphologiK \"waterless\" garçon tour de hanches LARGE - denim gris fonce', 24, '2022-01-08 12:09:27', 7),
(23, 11, 'Jean slim MorphologiK tour de hanches LARGE garçon - denim gris fonce', 32, '2022-01-08 12:11:41', 7),
(24, 25, 'Jean droit légèrement loose effet usé garçon - stone', 16, '2022-01-08 12:13:53', 7),
(25, 20, 'Jean thermo', 32, '2022-01-08 12:24:11', 7),
(26, 23, 'JEAN LACET - NOIR / 14 ANS', 26, '2022-01-08 12:35:35', 7),
(27, 8, 'Johny', 25, '2022-01-08 21:25:38', 3),
(28, 25, 'pantalon vintage', 52, '2022-01-08 21:26:33', 3),
(29, 12, 'classic', 24, '2022-01-08 21:27:33', 2),
(30, 12, 'chic et cool', 25, '2022-01-08 21:28:37', 2),
(31, 12, 'chemise', 6, '2022-01-08 21:30:31', 1);

-- --------------------------------------------------------

--
-- Structure de la table `product_qty`
--

CREATE TABLE `product_qty` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `ord_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product_qty`
--

INSERT INTO `product_qty` (`id`, `product_id`, `ord_id`, `quantity`) VALUES
(11, 8, 23, 1),
(12, 8, 24, 1),
(13, 8, 26, 2),
(14, 8, 27, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rgpd` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `roles`, `password`, `first_name`, `last_name`, `billing`, `shipping`, `rgpd`) VALUES
(1, 'al@sp.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$Ti90c3NXZ1dYV0NXUmNyWA$SnfcK6KQLMPxHMmt95/sFolyZngfA00bZMIgPqjbLHk', 'Kamul', 'Nassoma', 'lome', 'togo', 1),
(2, 'client@sp.com', '[]', '$argon2id$v=19$m=65536,t=4,p=1$V051WTVucmpSV0hVV1E4Uw$YKc61bGZVzgppPRqwX3+7/66vDdiDFj3PMX63+b27E8', 'Ali', 'Nassoma', 'lome', 'togo', 1),
(3, 'sulaimansajidf@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$Z0hBQWs3T2tTT2dkUG9hdQ$pB0whh+WBznbdZi6sAedxNyP3x0vlnRZrklHv/yCx/U', 'Sulaiman', 'FAYYAZ', 'oui', 'iuoi', 1),
(4, 'symf@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$NEFDYWo3SC5WaXVNVUpxUw$wr/kp/Drf81+y5zUwkUzeUitlNPcZC11Ehtr2fvKmi4', 'admin', 'admin', 'store', 'store', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C53D045F4584665A` (`product_id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E52FFDEEA76ED395` (`user_id`);

--
-- Index pour la table `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`orders_id`,`products_id`),
  ADD KEY `IDX_749C879CCFFE9AD6` (`orders_id`),
  ADD KEY `IDX_749C879C6C8A81A9` (`products_id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B3BA5A5ABCF5E72D` (`categorie_id`);
ALTER TABLE `products` ADD FULLTEXT KEY `IDX_B3BA5A5A5E237E06` (`name`);

--
-- Index pour la table `product_qty`
--
ALTER TABLE `product_qty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_28D7FA004584665A` (`product_id`),
  ADD KEY `IDX_28D7FA00E636D3F5` (`ord_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `product_qty`
--
ALTER TABLE `product_qty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_C53D045F4584665A` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_E52FFDEEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `orders_products`
--
ALTER TABLE `orders_products`
  ADD CONSTRAINT `FK_749C879C6C8A81A9` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_749C879CCFFE9AD6` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_B3BA5A5ABCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `product_qty`
--
ALTER TABLE `product_qty`
  ADD CONSTRAINT `FK_28D7FA004584665A` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `FK_28D7FA00E636D3F5` FOREIGN KEY (`ord_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
