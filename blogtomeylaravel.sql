-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 17, 2024 at 12:34 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blogtomeylaravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `bgArticle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `watched` int NOT NULL DEFAULT '0',
  `hidden` timestamp NULL DEFAULT NULL,
  `comment` enum('allow','disable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'allow',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `id_post` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `refer` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` bigint UNSIGNED NOT NULL,
  `id_author` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `markup_articles`
--

CREATE TABLE `markup_articles` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_article` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_11_04_083339_create_types_table', 1),
(7, '2023_11_05_102833_create_articles_table', 1),
(8, '2023_11_09_090352_create_comments_table', 1),
(9, '2023_11_10_163546_create_types__articles_table', 1),
(10, '2023_11_14_090925_create_markup_articles_table', 1),
(11, '2023_11_14_122045_create_watched_articles_table', 1),
(12, '2023_11_15_150601_create_reactions_table', 1),
(13, '2023_11_18_172751_create_report_articles_table', 1),
(14, '2023_12_18_145349_create_search_users_table', 1),
(15, '2023_12_20_132654_create_followers_table', 1),
(16, '2024_01_02_130557_create_permission_tables', 1),
(17, '2024_01_05_153336_create_notifications_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'rolesPermissions', 'web', '2024-01-17 10:34:28', '2024-01-17 10:34:28'),
(2, 'users', 'web', '2024-01-17 10:34:28', '2024-01-17 10:34:28'),
(3, 'types', 'web', '2024-01-17 10:34:28', '2024-01-17 10:34:28'),
(4, 'admin-statistics', 'web', '2024-01-17 10:34:28', '2024-01-17 10:34:28'),
(5, 'articles-show', 'web', '2024-01-17 10:34:28', '2024-01-17 10:34:28'),
(6, 'articles-controll', 'web', '2024-01-17 10:34:28', '2024-01-17 10:34:28');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_article` bigint UNSIGNED NOT NULL,
  `action` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_articles`
--

CREATE TABLE `report_articles` (
  `id` bigint UNSIGNED NOT NULL,
  `id_article` bigint UNSIGNED NOT NULL,
  `id_user_report` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Owner', 'web', '2024-01-17 10:34:29', '2024-01-17 10:34:29');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `search_users`
--

CREATE TABLE `search_users` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `type` text COLLATE utf8mb4_unicode_ci,
  `hidden` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Programming', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(2, 'Data Engineering', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(3, 'Data Science', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(4, 'Technology', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(5, 'Self Improvement', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(6, 'Writing', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(7, 'Machine Learning', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(8, 'Productivity', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(9, 'Politics', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(10, 'Cryptocurrency', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(11, 'Psychology', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(12, 'History', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(13, 'Money', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(14, 'Business', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(15, 'Coding', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(16, 'Software Development', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(17, 'Artificial Intelligence (AI)', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(18, 'Web Development', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(19, 'Android', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(20, 'Apple', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(21, 'UI', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(22, 'UX', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(23, 'API', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(24, 'Laravel', '2024-01-17 10:34:26', '2024-01-17 10:34:26'),
(25, 'React', '2024-01-17 10:34:27', '2024-01-17 10:34:27'),
(26, 'Angular', '2024-01-17 10:34:27', '2024-01-17 10:34:27'),
(27, 'Vue', '2024-01-17 10:34:27', '2024-01-17 10:34:27'),
(28, 'Node.js', '2024-01-17 10:34:27', '2024-01-17 10:34:27'),
(29, 'C', '2024-01-17 10:34:27', '2024-01-17 10:34:27'),
(30, 'C++', '2024-01-17 10:34:27', '2024-01-17 10:34:27'),
(31, 'C#', '2024-01-17 10:34:27', '2024-01-17 10:34:27'),
(32, 'Python', '2024-01-17 10:34:27', '2024-01-17 10:34:27'),
(33, 'Ruby', '2024-01-17 10:34:27', '2024-01-17 10:34:27'),
(34, 'Swift', '2024-01-17 10:34:27', '2024-01-17 10:34:27'),
(35, 'Kotlin', '2024-01-17 10:34:27', '2024-01-17 10:34:27'),
(36, 'Java', '2024-01-17 10:34:27', '2024-01-17 10:34:27'),
(37, 'R', '2024-01-17 10:34:27', '2024-01-17 10:34:27'),
(38, 'SQL', '2024-01-17 10:34:27', '2024-01-17 10:34:27'),
(39, 'NoSQL', '2024-01-17 10:34:27', '2024-01-17 10:34:27'),
(40, 'TypeScript', '2024-01-17 10:34:27', '2024-01-17 10:34:27');

-- --------------------------------------------------------

--
-- Table structure for table `types__articles`
--

CREATE TABLE `types__articles` (
  `id` bigint UNSIGNED NOT NULL,
  `id_article` bigint UNSIGNED NOT NULL,
  `id_type` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Hi, I''m a new editor here and I''m looking forward to sharing my knowledge and joining this amazing community.',
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'male',
  `status` enum('open','block') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `reports` int NOT NULL DEFAULT '0',
  `email_verified_at` date DEFAULT NULL,
  `last_login` date DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `info`, `img`, `type`, `status`, `reports`, `email_verified_at`, `last_login`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$12$HxEZH38lv2roWjqyVDkWUuOOhAzm2z7Oj0m2xf1uTJjbbzv0K9sim', 'Hi, I\'m a new editor here and I\'m looking forward to sharing my knowledge and joining this amazing community.', NULL, 'male', 'open', 0, '2024-01-17', NULL, NULL, '2024-01-17 10:34:29', '2024-01-17 10:34:29');

-- --------------------------------------------------------

--
-- Table structure for table `watched_articles`
--

CREATE TABLE `watched_articles` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_article` bigint UNSIGNED NOT NULL,
  `hidden` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `articles_id_user_foreign` (`id_user`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_id_post_foreign` (`id_post`),
  ADD KEY `comments_id_user_foreign` (`id_user`),
  ADD KEY `comments_refer_foreign` (`refer`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `followers_id_author_foreign` (`id_author`),
  ADD KEY `followers_id_user_foreign` (`id_user`);

--
-- Indexes for table `markup_articles`
--
ALTER TABLE `markup_articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `markup_articles_id_user_foreign` (`id_user`),
  ADD KEY `markup_articles_id_article_foreign` (`id_article`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reactions_id_user_foreign` (`id_user`),
  ADD KEY `reactions_id_article_foreign` (`id_article`);

--
-- Indexes for table `report_articles`
--
ALTER TABLE `report_articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_articles_id_article_foreign` (`id_article`),
  ADD KEY `report_articles_id_user_report_foreign` (`id_user_report`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `search_users`
--
ALTER TABLE `search_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `search_users_id_user_foreign` (`id_user`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types__articles`
--
ALTER TABLE `types__articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `types__articles_id_article_foreign` (`id_article`),
  ADD KEY `types__articles_id_type_foreign` (`id_type`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `watched_articles`
--
ALTER TABLE `watched_articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `watched_articles_id_user_foreign` (`id_user`),
  ADD KEY `watched_articles_id_article_foreign` (`id_article`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `markup_articles`
--
ALTER TABLE `markup_articles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_articles`
--
ALTER TABLE `report_articles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `search_users`
--
ALTER TABLE `search_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `types__articles`
--
ALTER TABLE `types__articles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `watched_articles`
--
ALTER TABLE `watched_articles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_id_post_foreign` FOREIGN KEY (`id_post`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_refer_foreign` FOREIGN KEY (`refer`) REFERENCES `comments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_id_author_foreign` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `followers_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `markup_articles`
--
ALTER TABLE `markup_articles`
  ADD CONSTRAINT `markup_articles_id_article_foreign` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `markup_articles_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reactions`
--
ALTER TABLE `reactions`
  ADD CONSTRAINT `reactions_id_article_foreign` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reactions_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_articles`
--
ALTER TABLE `report_articles`
  ADD CONSTRAINT `report_articles_id_article_foreign` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `report_articles_id_user_report_foreign` FOREIGN KEY (`id_user_report`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `search_users`
--
ALTER TABLE `search_users`
  ADD CONSTRAINT `search_users_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `types__articles`
--
ALTER TABLE `types__articles`
  ADD CONSTRAINT `types__articles_id_article_foreign` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `types__articles_id_type_foreign` FOREIGN KEY (`id_type`) REFERENCES `types` (`id`);

--
-- Constraints for table `watched_articles`
--
ALTER TABLE `watched_articles`
  ADD CONSTRAINT `watched_articles_id_article_foreign` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `watched_articles_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
