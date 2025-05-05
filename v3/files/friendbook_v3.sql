-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 05, 2025 at 12:50 PM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `post_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `commented_post_fk_idx` (`post_id`),
  KEY `commented_owner_fk_idx` (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `country_name_UNIQUE` (`country_name`)
) ENGINE=InnoDB AUTO_INCREMENT=246 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_name`) VALUES
(1, 'Afghanistan'),
(2, 'Albania'),
(3, 'Algeria'),
(4, 'American Samoa'),
(5, 'Andorra'),
(6, 'Angola'),
(7, 'Anguilla'),
(8, 'Antarctica'),
(9, 'Antigua and Barbuda'),
(10, 'Argentina'),
(11, 'Armenia'),
(12, 'Aruba'),
(13, 'Australia'),
(14, 'Austria'),
(15, 'Azerbaijan'),
(16, 'Bahamas'),
(17, 'Bahrain'),
(18, 'Bangladesh'),
(19, 'Barbados'),
(20, 'Belarus'),
(21, 'Belgium'),
(22, 'Belize'),
(23, 'Benin'),
(24, 'Bermuda'),
(25, 'Bhutan'),
(26, 'Bolivia'),
(27, 'Bosnia and Herzegovina'),
(28, 'Botswana'),
(29, 'Bouvet Island'),
(30, 'Brazil'),
(31, 'British Indian Ocean Territory'),
(32, 'Brunei Darussalam'),
(33, 'Bulgaria'),
(34, 'Burkina Faso'),
(35, 'Burundi'),
(36, 'Cambodia'),
(37, 'Cameroon'),
(38, 'Canada'),
(39, 'Cape Verde'),
(40, 'Cayman Islands'),
(41, 'Central African Republic'),
(42, 'Chad'),
(43, 'Chile'),
(44, 'China'),
(45, 'Christmas Island'),
(46, 'Cocos (Keeling) Islands'),
(47, 'Colombia'),
(48, 'Comoros'),
(49, 'Congo'),
(50, 'Cook Islands'),
(51, 'Costa Rica'),
(52, 'Croatia (Hrvatska)'),
(53, 'Cuba'),
(54, 'Cyprus'),
(55, 'Czech Republic'),
(56, 'Denmark'),
(57, 'Djibouti'),
(58, 'Dominica'),
(59, 'Dominican Republic'),
(60, 'East Timor'),
(61, 'Ecuador'),
(62, 'Egypt'),
(63, 'El Salvador'),
(64, 'Equatorial Guinea'),
(65, 'Eritrea'),
(66, 'Estonia'),
(67, 'Ethiopia'),
(68, 'Falkland Islands (Malvinas)'),
(69, 'Faroe Islands'),
(70, 'Fiji'),
(71, 'Finland'),
(72, 'France'),
(73, 'France, Metropolitan'),
(74, 'French Guiana'),
(75, 'French Polynesia'),
(76, 'French Southern Territories'),
(77, 'Gabon'),
(78, 'Gambia'),
(79, 'Georgia'),
(80, 'Germany'),
(81, 'Ghana'),
(82, 'Gibraltar'),
(84, 'Greece'),
(85, 'Greenland'),
(86, 'Grenada'),
(87, 'Guadeloupe'),
(88, 'Guam'),
(89, 'Guatemala'),
(83, 'Guernsey'),
(90, 'Guinea'),
(91, 'Guinea-Bissau'),
(92, 'Guyana'),
(93, 'Haiti'),
(94, 'Heard and Mc Donald Islands'),
(95, 'Honduras'),
(96, 'Hong Kong'),
(97, 'Hungary'),
(98, 'Iceland'),
(99, 'India'),
(101, 'Indonesia'),
(102, 'Iran (Islamic Republic of)'),
(103, 'Iraq'),
(104, 'Ireland'),
(100, 'Isle of Man'),
(105, 'Israel'),
(106, 'Italy'),
(107, 'Ivory Coast'),
(109, 'Jamaica'),
(110, 'Japan'),
(108, 'Jersey'),
(111, 'Jordan'),
(112, 'Kazakhstan'),
(113, 'Kenya'),
(114, 'Kiribati'),
(115, 'Korea, Democratic People\'s Republic of'),
(116, 'Korea, Republic of'),
(117, 'Kosovo'),
(118, 'Kuwait'),
(119, 'Kyrgyzstan'),
(120, 'Lao People\'s Democratic Republic'),
(121, 'Latvia'),
(122, 'Lebanon'),
(123, 'Lesotho'),
(124, 'Liberia'),
(125, 'Libyan Arab Jamahiriya'),
(126, 'Liechtenstein'),
(127, 'Lithuania'),
(128, 'Luxembourg'),
(129, 'Macau'),
(130, 'Macedonia'),
(131, 'Madagascar'),
(132, 'Malawi'),
(133, 'Malaysia'),
(134, 'Maldives'),
(135, 'Mali'),
(136, 'Malta'),
(137, 'Marshall Islands'),
(138, 'Martinique'),
(139, 'Mauritania'),
(140, 'Mauritius'),
(141, 'Mayotte'),
(142, 'Mexico'),
(143, 'Micronesia, Federated States of'),
(144, 'Moldova, Republic of'),
(145, 'Monaco'),
(146, 'Mongolia'),
(147, 'Montenegro'),
(148, 'Montserrat'),
(149, 'Morocco'),
(150, 'Mozambique'),
(151, 'Myanmar'),
(152, 'Namibia'),
(153, 'Nauru'),
(154, 'Nepal'),
(155, 'Netherlands'),
(156, 'Netherlands Antilles'),
(157, 'New Caledonia'),
(158, 'New Zealand'),
(159, 'Nicaragua'),
(160, 'Niger'),
(161, 'Nigeria'),
(162, 'Niue'),
(163, 'Norfolk Island'),
(164, 'Northern Mariana Islands'),
(165, 'Norway'),
(166, 'Oman'),
(167, 'Pakistan'),
(168, 'Palau'),
(169, 'Palestine'),
(170, 'Panama'),
(171, 'Papua New Guinea'),
(172, 'Paraguay'),
(173, 'Peru'),
(174, 'Philippines'),
(175, 'Pitcairn'),
(176, 'Poland'),
(177, 'Portugal'),
(178, 'Puerto Rico'),
(179, 'Qatar'),
(180, 'Reunion'),
(181, 'Romania'),
(182, 'Russian Federation'),
(183, 'Rwanda'),
(184, 'Saint Kitts and Nevis'),
(185, 'Saint Lucia'),
(186, 'Saint Vincent and the Grenadines'),
(187, 'Samoa'),
(188, 'San Marino'),
(189, 'Sao Tome and Principe'),
(190, 'Saudi Arabia'),
(191, 'Senegal'),
(192, 'Serbia'),
(193, 'Seychelles'),
(194, 'Sierra Leone'),
(195, 'Singapore'),
(196, 'Slovakia'),
(197, 'Slovenia'),
(198, 'Solomon Islands'),
(199, 'Somalia'),
(200, 'South Africa'),
(201, 'South Georgia South Sandwich Islands'),
(202, 'Spain'),
(203, 'Sri Lanka'),
(204, 'St. Helena'),
(205, 'St. Pierre and Miquelon'),
(206, 'Sudan'),
(207, 'Suriname'),
(208, 'Svalbard and Jan Mayen Islands'),
(209, 'Swaziland'),
(210, 'Sweden'),
(211, 'Switzerland'),
(212, 'Syrian Arab Republic'),
(213, 'Taiwan'),
(214, 'Tajikistan'),
(215, 'Tanzania, United Republic of'),
(216, 'Thailand'),
(217, 'Togo'),
(218, 'Tokelau'),
(219, 'Tonga'),
(220, 'Trinidad and Tobago'),
(221, 'Tunisia'),
(222, 'Turkey'),
(223, 'Turkmenistan'),
(224, 'Turks and Caicos Islands'),
(225, 'Tuvalu'),
(226, 'Uganda'),
(227, 'Ukraine'),
(228, 'United Arab Emirates'),
(229, 'United Kingdom'),
(230, 'United States'),
(231, 'United States minor outlying islands'),
(232, 'Uruguay'),
(233, 'Uzbekistan'),
(234, 'Vanuatu'),
(235, 'Vatican City State'),
(236, 'Venezuela'),
(237, 'Vietnam'),
(238, 'Virgin Islands (British)'),
(239, 'Virgin Islands (U.S.)'),
(240, 'Wallis and Futuna Islands'),
(241, 'Western Sahara'),
(242, 'Yemen'),
(243, 'Zaire'),
(244, 'Zambia'),
(245, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `following_user`
--

DROP TABLE IF EXISTS `following_user`;
CREATE TABLE IF NOT EXISTS `following_user` (
  `follower_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL,
  KEY `user_id_fk_idx` (`follower_id`),
  KEY `followed_id_fik_idx` (`followed_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
CREATE TABLE IF NOT EXISTS `friends` (
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`friend_id`),
  KEY `user_friends_fk_idx` (`friend_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

DROP TABLE IF EXISTS `friend_requests`;
CREATE TABLE IF NOT EXISTS `friend_requests` (
  `requested_by` int(11) NOT NULL,
  `requester_id` int(11) NOT NULL,
  `approved` tinyint(4) DEFAULT NULL,
  KEY `user_id_fk_idx` (`requested_by`),
  KEY `request_id_idx` (`requester_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`requested_by`, `requester_id`, `approved`) VALUES
(33, 32, 0);

-- --------------------------------------------------------

--
-- Table structure for table `like_comment`
--

DROP TABLE IF EXISTS `like_comment`;
CREATE TABLE IF NOT EXISTS `like_comment` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  KEY `like_comment_fk_idx` (`comment_id`),
  KEY `like_user_fk_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `like_post`
--

DROP TABLE IF EXISTS `like_post`;
CREATE TABLE IF NOT EXISTS `like_post` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  KEY `liked_post_fk_idx` (`post_id`),
  KEY `user_like_fk_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `reciever_id` int(11) NOT NULL,
  `message_text` text NOT NULL,
  `msg_status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_id_fk_idx` (`sender_id`),
  KEY `receiver_Id_fk_idx` (`reciever_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `reciever_id`, `message_text`, `msg_status`) VALUES
(12, 32, 33, 'Simple message!', 0),
(13, 33, 32, 'Simple message back to you!', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(150) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seen` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_post_id_fk_idx` (`post_id`),
  KEY `notifications_user_id_fk` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `photo_albums`
--

DROP TABLE IF EXISTS `photo_albums`;
CREATE TABLE IF NOT EXISTS `photo_albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `album_thumb` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_fk_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_post_fk_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post_images`
--

DROP TABLE IF EXISTS `post_images`;
CREATE TABLE IF NOT EXISTS `post_images` (
  `post_id` int(11) NOT NULL,
  `image_url` varchar(155) NOT NULL,
  KEY `image_to_post_idx` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `relationship`
--

DROP TABLE IF EXISTS `relationship`;
CREATE TABLE IF NOT EXISTS `relationship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `status_name_UNIQUE` (`status_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `relationship`
--

INSERT INTO `relationship` (`id`, `status_name`) VALUES
(3, 'Engaged'),
(2, 'In a relationship.'),
(7, 'In an open relationship'),
(5, 'It\'s complicated.'),
(4, 'Married'),
(1, 'Single'),
(6, 'Widowed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gender` varchar(45) NOT NULL,
  `birthday` date NOT NULL,
  `relationship_id` int(11) DEFAULT NULL,
  `profile_pic` varchar(200) NOT NULL,
  `profile_cover` varchar(200) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `display_name` varchar(45) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `mobile_number` int(11) DEFAULT NULL,
  `www` varchar(100) DEFAULT NULL,
  `skype` varchar(50) DEFAULT NULL,
  `thumbs_profile` varchar(200) DEFAULT NULL,
  `thumbs_cover` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `country_id_fk_idx` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `reg_date`, `gender`, `birthday`, `relationship_id`, `profile_pic`, `profile_cover`, `description`, `display_name`, `country_id`, `mobile_number`, `www`, `skype`, `thumbs_profile`, `thumbs_cover`) VALUES
(32, 'test1', 'testing1', 'test1@gmail.com', '4c0d2b951ffabd6f9a10489dc40fc356ec1d26d5', '2025-05-05 11:48:53', 'male', '2025-05-01', NULL, '/uploads/male_default_picture.png', '/uploads/default_cover.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'test2', 'testing2', 'test2@gmail.com', '4c0d2b951ffabd6f9a10489dc40fc356ec1d26d5', '2025-05-05 11:49:29', 'male', '2025-05-01', NULL, '/uploads/male_default_picture.png', '/uploads/default_cover.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_photos`
--

DROP TABLE IF EXISTS `user_photos`;
CREATE TABLE IF NOT EXISTS `user_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `img_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `album_id` int(11) DEFAULT NULL,
  `thumb_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_fk_idx` (`user_id`),
  KEY `album_id_fk_idx` (`album_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `commented_owner_fk` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commented_post_fk` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `following_user`
--
ALTER TABLE `following_user`
  ADD CONSTRAINT `followed_id_fik` FOREIGN KEY (`followed_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `follower_id_fk` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `user_be_friend_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_friends_fk` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD CONSTRAINT `request_id` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `like_comment`
--
ALTER TABLE `like_comment`
  ADD CONSTRAINT `like_comment_fk` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `like_post`
--
ALTER TABLE `like_post`
  ADD CONSTRAINT `liked_post_fk` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_like_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `receiver_Id_fk` FOREIGN KEY (`reciever_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `sender_id_fk` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_post_id_fk` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `photo_albums`
--
ALTER TABLE `photo_albums`
  ADD CONSTRAINT `user_album_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `user_post_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_images`
--
ALTER TABLE `post_images`
  ADD CONSTRAINT `image_to_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `country_id_fk` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_photos`
--
ALTER TABLE `user_photos`
  ADD CONSTRAINT `album_id_fk` FOREIGN KEY (`album_id`) REFERENCES `photo_albums` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_image_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
