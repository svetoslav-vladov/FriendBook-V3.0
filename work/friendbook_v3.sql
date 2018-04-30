-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 30 апр 2018 в 18:28
-- Версия на сървъра: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `friendbook_v3`
--

-- --------------------------------------------------------

--
-- Структура на таблица `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `post_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `comments`
--

INSERT INTO `comments` (`id`, `description`, `comment_date`, `post_id`, `owner_id`) VALUES
(79, 'dsfsd', '2018-04-26 14:46:59', 36, 24),
(82, 'Браво', '2018-04-27 11:43:20', 36, 20),
(94, 'ww', '2018-04-30 15:05:05', 61, 21),
(95, 'aa', '2018-04-30 15:20:17', 61, 21);

-- --------------------------------------------------------

--
-- Структура на таблица `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `country_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура на таблица `following_user`
--

CREATE TABLE `following_user` (
  `follower_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура на таблица `friends`
--

CREATE TABLE `friends` (
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура на таблица `friend_requests`
--

CREATE TABLE `friend_requests` (
  `requested_by` int(11) NOT NULL,
  `requester_id` int(11) NOT NULL,
  `approved` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура на таблица `like_comment`
--

CREATE TABLE `like_comment` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `like_comment`
--

INSERT INTO `like_comment` (`comment_id`, `user_id`) VALUES
(95, 21);

-- --------------------------------------------------------

--
-- Структура на таблица `like_post`
--

CREATE TABLE `like_post` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `like_post`
--

INSERT INTO `like_post` (`post_id`, `user_id`, `status`) VALUES
(36, 24, 1),
(36, 20, 1),
(36, 21, 1),
(38, 21, 1);

-- --------------------------------------------------------

--
-- Структура на таблица `photo_albums`
--

CREATE TABLE `photo_albums` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура на таблица `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `posts`
--

INSERT INTO `posts` (`id`, `description`, `create_date`, `user_id`) VALUES
(36, 'Zdrasti, moyat pyrvi post', '2018-04-26 14:46:41', 24),
(38, 'Здравейте!!!', '2018-04-29 08:38:23', 25),
(61, 'asdasd', '2018-04-30 15:03:35', 26),
(62, 'aa', '2018-04-30 15:13:49', 21);

-- --------------------------------------------------------

--
-- Структура на таблица `post_images`
--

CREATE TABLE `post_images` (
  `post_id` int(11) NOT NULL,
  `image_url` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gender` varchar(45) NOT NULL,
  `birthday` date NOT NULL,
  `relation_status` varchar(30) DEFAULT NULL,
  `profile_pic` varchar(200) NOT NULL,
  `profile_cover` varchar(200) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `display_name` varchar(45) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `mobile_number` int(11) DEFAULT NULL,
  `www` varchar(100) DEFAULT NULL,
  `skype` varchar(50) DEFAULT NULL,
  `thumbs_profile` varchar(200) DEFAULT NULL,
  `thumbs_cover` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `reg_date`, `gender`, `birthday`, `relation_status`, `profile_pic`, `profile_cover`, `description`, `display_name`, `country_id`, `mobile_number`, `www`, `skype`, `thumbs_profile`, `thumbs_cover`) VALUES
(20, 'Svetoslav', 'Vladov', 'komara_@abv.bg', 'f10e2821bbbea527ea02200352313bc059445190', '2018-04-29 09:12:58', 'male', '1988-10-22', NULL, './uploads/users/photos/fullsized/Svetoslav-1524993178-5ae58c9a810c2-profile.gif', '/uploads/default_cover.jpg', NULL, NULL, NULL, NULL, NULL, NULL, './uploads/users/photos/thumbs/Svetoslav-1524993178-5ae58c9a810c2-profile.gif', NULL),
(21, 'eray', 'myumyun', 'eray@abv.bg', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2018-04-30 10:12:22', 'male', '2018-04-12', NULL, './uploads/users/photos/fullsized/eray-1525083142-5ae6ec0626f8c-profile.gif', '/uploads/default_cover.jpg', NULL, NULL, NULL, NULL, NULL, NULL, './uploads/users/photos/thumbs/eray-1525083142-5ae6ec0626f8c-profile.gif', NULL),
(22, 'Krasimir', 'Stoev', 'krasi@kra.si', 'a6dba7cb58095dedee2641744602ae218511f4a1', '2018-04-23 10:39:31', 'male', '2018-03-16', NULL, '/uploads/male_default_picture.png', '/uploads/default_cover.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'test', 'test', 'test@abv.bg', 'f10e2821bbbea527ea02200352313bc059445190', '2018-04-30 12:18:06', 'female', '2018-04-17', NULL, '/uploads/female_default_picture.png', '/uploads/default_cover.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'Kiril', 'Dragomirov', 'kiril@dragomirov.email', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2018-04-26 14:44:39', 'male', '1997-05-11', NULL, '/uploads/male_default_picture.png', '/uploads/default_cover.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'Eli', 'Stoqnova', 'eli@abv.bg', 'f10e2821bbbea527ea02200352313bc059445190', '2018-04-30 12:17:10', 'female', '2002-12-09', NULL, './uploads/users/photos/fullsized/Eli-1524995131-5ae5943b00cb5-profile.jpg', '/uploads/default_cover.jpg', NULL, NULL, NULL, NULL, NULL, NULL, './uploads/users/photos/thumbs/Eli-1524995131-5ae5943b00cb5-profile.jpg', NULL),
(26, 'girl', 'girl', 'girl@abv.bg', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2018-04-30 12:17:56', 'female', '2018-04-11', NULL, '/uploads/female_default_picture.png', '/uploads/default_cover.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура на таблица `user_photos`
--

CREATE TABLE `user_photos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `img_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `album_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Схема на данните от таблица `user_photos`
--

INSERT INTO `user_photos` (`id`, `user_id`, `img_url`, `album_id`) VALUES
(52, 20, './uploads/users/photos/fullsized/Svetoslav-1524953156-5ae4f04402c9c-profile.gif', NULL),
(53, 20, './uploads/users/photos/fullsized/Svetoslav-1524953156-5ae4f04408a5e-profile.gif', NULL),
(54, 20, './uploads/users/photos/fullsized/Svetoslav-1524953156-5ae4f0440b16e-profile.gif', NULL),
(55, 20, './uploads/users/photos/fullsized/Svetoslav-1524953156-5ae4f04416909-profile.gif', NULL),
(56, 25, './uploads/users/photos/fullsized/Eli-1524991682-5ae586c2dac20-photos.gif', NULL),
(57, 25, './uploads/users/photos/fullsized/Eli-1524995176-5ae594688f854-photos.jpg', NULL),
(58, 21, './uploads/users/photos/fullsized/eray-1525083187-5ae6ec3322175-photos.png', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commented_post_fk_idx` (`post_id`),
  ADD KEY `commented_owner_fk_idx` (`owner_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `country_name_UNIQUE` (`country_name`);

--
-- Indexes for table `following_user`
--
ALTER TABLE `following_user`
  ADD KEY `user_id_fk_idx` (`follower_id`),
  ADD KEY `followed_id_fik_idx` (`followed_id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`user_id`,`friend_id`),
  ADD KEY `user_friends_fk_idx` (`friend_id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD KEY `user_id_fk_idx` (`requested_by`),
  ADD KEY `request_id_idx` (`requester_id`);

--
-- Indexes for table `like_comment`
--
ALTER TABLE `like_comment`
  ADD KEY `like_comment_fk_idx` (`comment_id`),
  ADD KEY `like_user_fk_idx` (`user_id`);

--
-- Indexes for table `like_post`
--
ALTER TABLE `like_post`
  ADD KEY `liked_post_fk_idx` (`post_id`),
  ADD KEY `user_like_fk_idx` (`user_id`);

--
-- Indexes for table `photo_albums`
--
ALTER TABLE `photo_albums`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`),
  ADD KEY `user_id_fk_idx` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_post_fk_idx` (`user_id`);

--
-- Indexes for table `post_images`
--
ALTER TABLE `post_images`
  ADD KEY `image_to_post_idx` (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `country_id_fk_idx` (`country_id`);

--
-- Indexes for table `user_photos`
--
ALTER TABLE `user_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_fk_idx` (`user_id`),
  ADD KEY `album_id_fk_idx` (`album_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `user_photos`
--
ALTER TABLE `user_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- Ограничения за дъмпнати таблици
--

--
-- Ограничения за таблица `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `commented_owner_fk` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commented_post_fk` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения за таблица `following_user`
--
ALTER TABLE `following_user`
  ADD CONSTRAINT `followed_id_fik` FOREIGN KEY (`followed_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `follower_id_fk` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения за таблица `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `user_be_friend_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_friends_fk` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения за таблица `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `request_id` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения за таблица `like_comment`
--
ALTER TABLE `like_comment`
  ADD CONSTRAINT `like_comment_fk` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения за таблица `like_post`
--
ALTER TABLE `like_post`
  ADD CONSTRAINT `liked_post_fk` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_like_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения за таблица `photo_albums`
--
ALTER TABLE `photo_albums`
  ADD CONSTRAINT `user_album_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения за таблица `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `user_post_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения за таблица `post_images`
--
ALTER TABLE `post_images`
  ADD CONSTRAINT `image_to_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения за таблица `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `country_id_fk` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения за таблица `user_photos`
--
ALTER TABLE `user_photos`
  ADD CONSTRAINT `album_id_fk` FOREIGN KEY (`album_id`) REFERENCES `photo_albums` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_image_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
