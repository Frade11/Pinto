-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Фев 14 2026 г., 03:38
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pinto_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(16, 'Anime'),
(2, 'Art'),
(1, 'Design'),
(8, 'Education'),
(11, 'Fashion'),
(10, 'Food'),
(3, 'Games'),
(14, 'Lifestyle'),
(17, 'Meme'),
(12, 'Movies'),
(6, 'Music'),
(15, 'Nature'),
(5, 'Photography'),
(13, 'Sports'),
(7, 'Technology'),
(9, 'Travel'),
(4, 'UI/UX');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `likes_count` int(10) UNSIGNED DEFAULT 0,
  `saves_count` int(10) UNSIGNED DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `category_id`, `name`, `description`, `likes_count`, `saves_count`, `created_at`) VALUES
(36, 2, NULL, 'Wallpaper', 'Minecraft 4k wallpaper', 0, 0, '2026-01-31 19:42:04'),
(37, 2, NULL, 'Chainsaw man', '<3', 0, 0, '2026-01-31 19:44:23'),
(38, 2, NULL, 'K-ONNNNN', '', 0, 0, '2026-01-31 19:45:21'),
(39, 2, NULL, 'Вам звонят', 'жизаа', 0, 0, '2026-01-31 19:46:43'),
(40, 2, NULL, 'I like it', '', 0, 0, '2026-01-31 19:48:17'),
(41, 2, NULL, 'Pochita >>>', 'pochita supremacy', 0, 1, '2026-01-31 19:49:17'),
(42, 2, NULL, 'мое будущее', 'реал', 0, 0, '2026-01-31 19:50:43'),
(43, 2, NULL, 'кислинка', 'кислинка кислинка кислинка', 0, 0, '2026-01-31 19:51:34'),
(44, 2, NULL, '(°o°)', '', 0, 0, '2026-01-31 19:52:39'),
(45, 2, NULL, '(⊙_⊙)', '', 0, 0, '2026-01-31 19:53:09'),
(46, 2, NULL, 'shhh', '', 0, 0, '2026-01-31 19:53:36'),
(47, 2, NULL, 'wallpaper 4k', 'minecraft wallpaper', 0, 0, '2026-01-31 19:54:37'),
(48, 2, NULL, ')', '', 0, 1, '2026-01-31 19:54:58'),
(49, 2, NULL, 'minecraft cat', 'i like this cat', 0, 0, '2026-01-31 19:55:39'),
(50, 2, NULL, 'Yui', 'k-on Yui', 0, 0, '2026-01-31 19:56:59'),
(51, 2, NULL, 'добро ', '', 0, 0, '2026-01-31 19:57:27'),
(52, 2, NULL, 'real', '', 0, 0, '2026-01-31 19:59:20'),
(53, 2, NULL, '._.', '', 0, 0, '2026-01-31 19:59:56'),
(54, 2, NULL, '(　〇□〇）', '', 0, 0, '2026-01-31 20:00:59'),
(55, 2, NULL, 'beauty', '', 1, 1, '2026-01-31 20:01:27'),
(56, 2, NULL, 'myiabi', '', 1, 1, '2026-01-31 20:02:08'),
(57, 2, NULL, 'wallpaper', '', 1, 1, '2026-01-31 20:02:38'),
(58, 3, 2, '°ʚ(´꒳`)ɞ° ', '', 1, 1, '2026-02-08 12:59:01'),
(63, 3, 16, '...', '', 1, 0, '2026-02-14 01:43:49'),
(64, 3, 16, 'yuiyuiyui', '', 0, 0, '2026-02-14 01:44:41'),
(65, 3, 3, 'Minecraft beauty', '', 0, 0, '2026-02-14 01:45:26'),
(66, 3, 2, 'The one...', '', 0, 0, '2026-02-14 01:46:40'),
(67, 3, 2, 'Dark Fantasy', 'wallpapers for mobile ', 0, 0, '2026-02-14 01:47:34'),
(68, 3, 14, 'Routine', '', 1, 0, '2026-02-14 01:48:45'),
(69, 3, 3, 'Its already the 2 week phase', 'lets go', 2, 1, '2026-02-14 01:49:29'),
(70, 3, 16, 'k-off', '', 0, 0, '2026-02-14 01:50:31'),
(71, 3, 14, 'Nature', '', 2, 0, '2026-02-14 01:51:19'),
(72, 3, 16, 'heh', '', 0, 0, '2026-02-14 01:52:10'),
(73, 3, 3, 'beautiful', 'minecraft', 2, 1, '2026-02-14 01:53:10'),
(74, 3, 14, 'chill', '', 0, 0, '2026-02-14 01:54:15'),
(75, 3, 16, 'php bochi', 'Hitori', 0, 0, '2026-02-14 01:56:02'),
(76, 3, 16, ')', '', 0, 0, '2026-02-14 01:56:38'),
(77, 3, 15, 'So pretty', '', 0, 0, '2026-02-14 01:57:52'),
(78, 3, 16, 'Mayuri Shiina Holding Bash Scripting Book', '', 2, 0, '2026-02-14 01:58:37'),
(79, 3, 16, 'k-on!', '', 1, 0, '2026-02-14 01:59:36'),
(80, 3, 6, 'guitar and cat', '', 1, 0, '2026-02-14 02:00:55'),
(81, 3, 6, 'cool guitar', '', 1, 0, '2026-02-14 02:02:03'),
(82, 3, 6, 'i love it!', 'guitar', 2, 1, '2026-02-14 02:02:36'),
(83, 3, 6, 'Music Aestethic', 'piano', 2, 1, '2026-02-14 02:03:31'),
(84, 3, 6, 'life music', 'cant live without music', 2, 1, '2026-02-14 02:04:07'),
(85, 3, 14, 'Aestethic', '', 2, 0, '2026-02-14 02:04:49'),
(86, 3, 14, 'kitty', '', 2, 1, '2026-02-14 02:05:36'),
(87, 3, 14, 'cattts', '', 2, 1, '2026-02-14 02:06:20');

-- --------------------------------------------------------

--
-- Структура таблицы `post_likes`
--

CREATE TABLE `post_likes` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `post_likes`
--

INSERT INTO `post_likes` (`user_id`, `post_id`, `created_at`) VALUES
(2, 55, '2026-02-07 17:03:22'),
(2, 56, '2026-02-14 00:19:11'),
(2, 63, '2026-02-14 02:08:30'),
(2, 68, '2026-02-14 02:09:02'),
(2, 69, '2026-02-14 02:07:39'),
(2, 71, '2026-02-14 02:11:40'),
(2, 73, '2026-02-14 02:08:06'),
(2, 78, '2026-02-14 02:07:54'),
(2, 81, '2026-02-14 02:09:16'),
(2, 82, '2026-02-14 02:07:46'),
(2, 83, '2026-02-14 02:08:33'),
(2, 84, '2026-02-14 02:07:36'),
(2, 85, '2026-02-14 02:08:20'),
(2, 86, '2026-02-14 02:07:25'),
(2, 87, '2026-02-14 02:09:18'),
(3, 69, '2026-02-14 02:06:55'),
(3, 71, '2026-02-14 02:11:11'),
(3, 73, '2026-02-14 02:07:00'),
(3, 78, '2026-02-14 02:10:54'),
(3, 79, '2026-02-14 02:10:51'),
(3, 80, '2026-02-14 02:10:45'),
(3, 82, '2026-02-14 02:06:44'),
(3, 83, '2026-02-14 02:10:38'),
(3, 84, '2026-02-14 02:06:39'),
(3, 85, '2026-02-14 02:10:31'),
(3, 86, '2026-02-14 02:07:11'),
(3, 87, '2026-02-14 02:10:22'),
(5, 57, '2026-02-08 15:27:38'),
(5, 58, '2026-02-08 14:46:52');

-- --------------------------------------------------------

--
-- Структура таблицы `post_media`
--

CREATE TABLE `post_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('image','video') NOT NULL,
  `source` enum('upload','url') NOT NULL,
  `mime_type` varchar(100) DEFAULT NULL,
  `file_path` varchar(500) DEFAULT NULL,
  `url` varchar(1000) DEFAULT NULL,
  `original_name` varchar(255) DEFAULT NULL,
  `file_size` int(10) UNSIGNED DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Дамп данных таблицы `post_media`
--

INSERT INTO `post_media` (`id`, `post_id`, `type`, `source`, `mime_type`, `file_path`, `url`, `original_name`, `file_size`, `created_at`) VALUES
(17, 36, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/13/4f/a5/134fa50efc8a4fe801d5fcaa0f08782a.jpg', NULL, 0, '2026-01-31 19:42:04'),
(18, 37, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/1200x/d2/25/4e/d2254e3eac878368fae632f394fabef9.jpg', NULL, 0, '2026-01-31 19:44:23'),
(19, 38, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/98/60/12/986012e9cb1abe44e2d735097a9a2c31.jpg', NULL, 0, '2026-01-31 19:45:21'),
(20, 39, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/9b/6f/84/9b6f840db5b12750b07ee293cf238953.jpg', NULL, 0, '2026-01-31 19:46:43'),
(21, 40, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/originals/66/3d/6a/663d6a01430b226c2e438e7272db654c.gif', NULL, 0, '2026-01-31 19:48:17'),
(22, 41, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/26/0f/45/260f45c8e3b747fc4c8b1a4970419cf3.jpg', NULL, 0, '2026-01-31 19:49:17'),
(23, 42, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/1200x/6a/d4/2a/6ad42ab8d6da213f232dc7ff835a9268.jpg', NULL, 0, '2026-01-31 19:50:43'),
(24, 43, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/fe/86/6b/fe866b1f84259243159a8c1a10ade878.jpg', NULL, 0, '2026-01-31 19:51:34'),
(25, 44, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/2b/30/fc/2b30fc7f0ad1113763f139134ae856ec.jpg', NULL, 0, '2026-01-31 19:52:39'),
(26, 45, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/86/25/6a/86256ac3183aa9e7fbea6564fb1bd447.jpg', NULL, 0, '2026-01-31 19:53:09'),
(27, 46, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/9e/0f/30/9e0f30ac0df48fa942be29af3776423d.jpg', NULL, 0, '2026-01-31 19:53:36'),
(28, 47, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/1200x/c5/18/aa/c518aaa17f08413eb9dd5a903dc61a78.jpg', NULL, 0, '2026-01-31 19:54:37'),
(29, 48, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/ba/8a/bc/ba8abc3a6c410f871fd448bc38024af0.jpg', NULL, 0, '2026-01-31 19:54:58'),
(30, 49, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/22/70/11/2270111cd0327b7234494370bb5ee570.jpg', NULL, 0, '2026-01-31 19:55:39'),
(31, 50, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/originals/f2/3c/9a/f23c9a5c4e89959e4308c37c07f8029d.gif', NULL, 0, '2026-01-31 19:56:59'),
(32, 51, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/1200x/cc/fe/02/ccfe02d4a6a14cc37020a67736a2eda6.jpg', NULL, 0, '2026-01-31 19:57:27'),
(33, 52, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/5a/ce/97/5ace97abd51ff0e11ca1f2ddde495e08.jpg', NULL, 0, '2026-01-31 19:59:20'),
(34, 53, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/a4/76/ef/a476ef92d844801493f700393f3613c6.jpg', NULL, 0, '2026-01-31 19:59:56'),
(35, 54, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/de/15/d8/de15d839e5299b61f4d7f90a8782756c.jpg', NULL, 0, '2026-01-31 20:00:59'),
(36, 55, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/1200x/23/2a/3e/232a3e7f48025a96a25a2b5c55b97500.jpg', NULL, 0, '2026-01-31 20:01:27'),
(37, 56, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/originals/23/f5/bf/23f5bf1d66889c28887d1c2fb3cc298c.gif', NULL, 0, '2026-01-31 20:02:08'),
(38, 57, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/41/ce/30/41ce3005db0fbf9d9e69e3e8324436bd.jpg', NULL, 0, '2026-01-31 20:02:38'),
(39, 58, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/12/2e/e0/122ee0080213aa778890706c4079dd00.jpg', NULL, 0, '2026-02-08 12:59:01'),
(44, 63, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/1200x/76/0e/72/760e72ecd7c91344f7f641db3429fc93.jpg', NULL, 0, '2026-02-14 01:43:49'),
(45, 64, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/25/eb/29/25eb29a3c2e71896662eac64fe2c442a.jpg', NULL, 0, '2026-02-14 01:44:41'),
(46, 65, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/b5/a4/9d/b5a49d0b43589703916ce01e3204dee9.jpg', NULL, 0, '2026-02-14 01:45:26'),
(47, 66, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/1b/fd/03/1bfd03f976004036549fbca576dc61e5.jpg', NULL, 0, '2026-02-14 01:46:40'),
(48, 67, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/1200x/8d/0d/9f/8d0d9f01c8bd5cc2197f7c53fe8a8151.jpg', NULL, 0, '2026-02-14 01:47:34'),
(49, 68, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/9d/a1/35/9da135ae49cb55fc80871d0f6bace35e.jpg', NULL, 0, '2026-02-14 01:48:45'),
(50, 69, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/cc/bf/52/ccbf522634585d3f0241af6e5e796f0c.jpg', NULL, 0, '2026-02-14 01:49:29'),
(51, 70, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/01/49/5a/01495a71e97750dc5220a4b236be6452.jpg', NULL, 0, '2026-02-14 01:50:31'),
(52, 71, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/1200x/bf/09/b9/bf09b9373bd22a7cb21d36482ab8b34b.jpg', NULL, 0, '2026-02-14 01:51:19'),
(53, 72, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/f4/19/f9/f419f9c69e945a702b0b300af7b86fc5.jpg', NULL, 0, '2026-02-14 01:52:10'),
(54, 73, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/8d/9a/e7/8d9ae7670ac27a5532620245cf19f931.jpg', NULL, 0, '2026-02-14 01:53:10'),
(55, 74, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/42/e8/ed/42e8ede0195c1a14cc964b5ccb835726.jpg', NULL, 0, '2026-02-14 01:54:15'),
(56, 75, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/e6/0d/a3/e60da318b135e5130c1d45e7789767af.jpg', NULL, 0, '2026-02-14 01:56:02'),
(57, 76, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/1a/10/a7/1a10a719e51daa5d21394fa142e397a1.jpg', NULL, 0, '2026-02-14 01:56:38'),
(58, 77, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/85/b3/97/85b397590dae721f02509b114b686a59.jpg', NULL, 0, '2026-02-14 01:57:52'),
(59, 78, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/1200x/2a/a8/fb/2aa8fb6cbd93fb6351024dcdd50254b0.jpg', NULL, 0, '2026-02-14 01:58:37'),
(60, 79, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/1200x/6d/2b/5a/6d2b5a4511809ac1af1b7c7a13d465e8.jpg', NULL, 0, '2026-02-14 01:59:36'),
(61, 80, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/e4/e5/3f/e4e53f6afa314dbff46ff8f9b04cf85e.jpg', NULL, 0, '2026-02-14 02:00:55'),
(62, 81, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/a3/7f/a9/a37fa95866a8ffb418d9323aa23eb7da.jpg', NULL, 0, '2026-02-14 02:02:03'),
(63, 82, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/64/f1/53/64f15383828a0f54ca9042b68d862b86.jpg', NULL, 0, '2026-02-14 02:02:36'),
(64, 83, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/a4/ca/9e/a4ca9ed6166def1450ba44755368c9b4.jpg', NULL, 0, '2026-02-14 02:03:31'),
(65, 84, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/31/db/f6/31dbf67224453d2ff54bd6f0c76bfb75.jpg', NULL, 0, '2026-02-14 02:04:07'),
(66, 85, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/df/3c/1e/df3c1ef452dde61601ac81caea8b0254.jpg', NULL, 0, '2026-02-14 02:04:49'),
(67, 86, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/03/4d/f9/034df9a5916f9d48c91946b64a4cbd93.jpg', NULL, 0, '2026-02-14 02:05:36'),
(68, 87, 'image', 'url', NULL, NULL, 'https://i.pinimg.com/736x/5d/42/5e/5d425e841c9c1e7cd69bc2fcb9c0c3d9.jpg', NULL, 0, '2026-02-14 02:06:20');

-- --------------------------------------------------------

--
-- Структура таблицы `post_tags`
--

CREATE TABLE `post_tags` (
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `post_tags`
--

INSERT INTO `post_tags` (`post_id`, `tag_id`) VALUES
(36, 14),
(36, 15),
(37, 16),
(37, 17),
(38, 16),
(38, 18),
(38, 19),
(39, 17),
(40, 16),
(40, 17),
(40, 18),
(40, 19),
(41, 16),
(41, 17),
(42, 17),
(43, 17),
(44, 17),
(45, 17),
(46, 17),
(47, 14),
(47, 15),
(48, 17),
(49, 14),
(50, 18),
(50, 19),
(50, 39),
(51, 16),
(51, 17),
(51, 42),
(52, 17),
(53, 16),
(53, 44),
(54, 17),
(56, 17),
(56, 47),
(56, 49),
(57, 15),
(57, 51),
(58, 16),
(58, 18),
(58, 19),
(58, 39),
(58, 64),
(63, 16),
(63, 79),
(64, 16),
(64, 18),
(64, 19),
(65, 14),
(66, 64),
(67, 15),
(68, 86),
(69, 14),
(69, 47),
(69, 88),
(70, 16),
(70, 90),
(71, 92),
(72, 16),
(73, 14),
(74, 95),
(75, 16),
(75, 42),
(75, 98),
(76, 16),
(77, 100),
(78, 16),
(78, 102),
(79, 16),
(79, 18),
(79, 19),
(80, 95),
(80, 106),
(81, 106),
(82, 106),
(83, 110),
(83, 111),
(84, 92),
(84, 111),
(85, 114),
(86, 95),
(87, 95);

-- --------------------------------------------------------

--
-- Структура таблицы `saved_posts`
--

CREATE TABLE `saved_posts` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `saved_posts`
--

INSERT INTO `saved_posts` (`user_id`, `post_id`, `created_at`) VALUES
(2, 41, '2026-02-07 17:08:00'),
(2, 48, '2026-02-07 17:03:34'),
(2, 55, '2026-02-07 16:53:13'),
(2, 56, '2026-02-14 00:19:08'),
(3, 69, '2026-02-14 02:06:55'),
(3, 73, '2026-02-14 02:07:00'),
(3, 82, '2026-02-14 02:06:45'),
(3, 83, '2026-02-14 02:10:38'),
(3, 84, '2026-02-14 02:06:40'),
(3, 86, '2026-02-14 02:07:11'),
(3, 87, '2026-02-14 02:10:21'),
(5, 57, '2026-02-08 15:27:39'),
(5, 58, '2026-02-08 14:46:53');

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE `tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(6, '#genshin'),
(9, '#kon'),
(114, 'Aestethic'),
(16, 'anime'),
(64, 'art'),
(79, 'beauty'),
(42, 'bochi'),
(95, 'cat'),
(100, 'flowers'),
(47, 'games'),
(106, 'guitar'),
(98, 'hitori'),
(54, 'jon'),
(19, 'k-on'),
(18, 'kon'),
(90, 'kon-k-on'),
(86, 'lifestyl'),
(92, 'lifestyle'),
(88, 'lyfestyle'),
(17, 'meme'),
(14, 'minecraft'),
(10, 'minecraft wallpaper'),
(49, 'miyabi'),
(111, 'music'),
(51, 'nature'),
(110, 'piano'),
(102, 'programing'),
(44, 'rem'),
(7, 's'),
(15, 'wallpaper'),
(39, 'yui'),
(1, 'ы');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `avatar_url` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `role`, `avatar_url`, `created_at`) VALUES
(1, 'testuser', 'test@example.com', '123456', 'user', NULL, '2026-01-21 21:28:20'),
(2, 'Frade1', 'frade@gmail.com', '$2y$10$8pMEDJX0RqwEKJ9KgHEpzOgwzcMlPk8jnGVdsblcoNV07ChxUgbOC', 'user', 'https://i.pinimg.com/474x/c6/f8/e4/c6f8e4ad87b6fd2c39c6b3b31c603f11.jpg', '2026-01-30 21:22:10'),
(3, 'Hikaru', 'hikaru@gmail.com', '$2y$10$Ihhj.PDZPz.w/dpafu.vwe7JNLOkkVHQGrGsFdqLlGk6jMiTFcuAu', 'user', 'https://i.pinimg.com/736x/d9/c4/7f/d9c47f95f469bc7974e9176cb9137e19.jpg', '2026-02-07 16:39:46'),
(5, 'H1karu', 'fradefrade@gmail.com', '$2y$10$938NyVt0pU/SZ6mkef0zc.E6NvwIQNg/dE2ICQr37IEIuAbXCTvjq', 'user', 'https://i.pinimg.com/736x/d9/64/22/d964220d316781dfa8d8314c4309bb88.jpg', '2026-02-08 14:45:55');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`user_id`,`post_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Индексы таблицы `post_media`
--
ALTER TABLE `post_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Индексы таблицы `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`post_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Индексы таблицы `saved_posts`
--
ALTER TABLE `saved_posts`
  ADD PRIMARY KEY (`user_id`,`post_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Индексы таблицы `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT для таблицы `post_media`
--
ALTER TABLE `post_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `post_media`
--
ALTER TABLE `post_media`
  ADD CONSTRAINT `post_media_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `post_tags`
--
ALTER TABLE `post_tags`
  ADD CONSTRAINT `post_tags_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `saved_posts`
--
ALTER TABLE `saved_posts`
  ADD CONSTRAINT `saved_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `saved_posts_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
