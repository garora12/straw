-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2019 at 01:14 PM
-- Server version: 10.3.13-MariaDB-1:10.3.13+maria~bionic
-- PHP Version: 7.3.3-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `straw`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('OPEN','CLOSE','DELETED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Arts & Humanities', 'OPEN', '2019-03-24 00:22:00', '2019-03-24 00:22:00'),
(2, 'Social Sciences & Management', 'OPEN', '2019-03-24 00:22:00', '2019-03-24 00:22:00'),
(3, 'Engineering & Technology', 'OPEN', '2019-03-24 00:22:00', '2019-03-24 00:22:00'),
(4, 'Natural Sciences', 'OPEN', '2019-03-24 00:22:00', '2019-03-24 00:22:00'),
(5, 'Life Sciences & Medicine', 'OPEN', '2019-03-24 00:22:00', '2019-03-24 00:22:00');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `sortname` varchar(3) NOT NULL,
  `name` varchar(150) NOT NULL,
  `phonecode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `sortname`, `name`, `phonecode`) VALUES
(1, 'AF', 'Afghanistan', 93),
(2, 'AL', 'Albania', 355),
(3, 'DZ', 'Algeria', 213),
(4, 'AS', 'American Samoa', 1684),
(5, 'AD', 'Andorra', 376),
(6, 'AO', 'Angola', 244),
(7, 'AI', 'Anguilla', 1264),
(8, 'AQ', 'Antarctica', 0),
(9, 'AG', 'Antigua And Barbuda', 1268),
(10, 'AR', 'Argentina', 54),
(11, 'AM', 'Armenia', 374),
(12, 'AW', 'Aruba', 297),
(13, 'AU', 'Australia', 61),
(14, 'AT', 'Austria', 43),
(15, 'AZ', 'Azerbaijan', 994),
(16, 'BS', 'Bahamas The', 1242),
(17, 'BH', 'Bahrain', 973),
(18, 'BD', 'Bangladesh', 880),
(19, 'BB', 'Barbados', 1246),
(20, 'BY', 'Belarus', 375),
(21, 'BE', 'Belgium', 32),
(22, 'BZ', 'Belize', 501),
(23, 'BJ', 'Benin', 229),
(24, 'BM', 'Bermuda', 1441),
(25, 'BT', 'Bhutan', 975),
(26, 'BO', 'Bolivia', 591),
(27, 'BA', 'Bosnia and Herzegovina', 387),
(28, 'BW', 'Botswana', 267),
(29, 'BV', 'Bouvet Island', 0),
(30, 'BR', 'Brazil', 55),
(31, 'IO', 'British Indian Ocean Territory', 246),
(32, 'BN', 'Brunei', 673),
(33, 'BG', 'Bulgaria', 359),
(34, 'BF', 'Burkina Faso', 226),
(35, 'BI', 'Burundi', 257),
(36, 'KH', 'Cambodia', 855),
(37, 'CM', 'Cameroon', 237),
(38, 'CA', 'Canada', 1),
(39, 'CV', 'Cape Verde', 238),
(40, 'KY', 'Cayman Islands', 1345),
(41, 'CF', 'Central African Republic', 236),
(42, 'TD', 'Chad', 235),
(43, 'CL', 'Chile', 56),
(44, 'CN', 'China', 86),
(45, 'CX', 'Christmas Island', 61),
(46, 'CC', 'Cocos (Keeling) Islands', 672),
(47, 'CO', 'Colombia', 57),
(48, 'KM', 'Comoros', 269),
(49, 'CG', 'Republic Of The Congo', 242),
(50, 'CD', 'Democratic Republic Of The Congo', 242),
(51, 'CK', 'Cook Islands', 682),
(52, 'CR', 'Costa Rica', 506),
(53, 'CI', 'Cote D\'Ivoire (Ivory Coast)', 225),
(54, 'HR', 'Croatia (Hrvatska)', 385),
(55, 'CU', 'Cuba', 53),
(56, 'CY', 'Cyprus', 357),
(57, 'CZ', 'Czech Republic', 420),
(58, 'DK', 'Denmark', 45),
(59, 'DJ', 'Djibouti', 253),
(60, 'DM', 'Dominica', 1767),
(61, 'DO', 'Dominican Republic', 1809),
(62, 'TP', 'East Timor', 670),
(63, 'EC', 'Ecuador', 593),
(64, 'EG', 'Egypt', 20),
(65, 'SV', 'El Salvador', 503),
(66, 'GQ', 'Equatorial Guinea', 240),
(67, 'ER', 'Eritrea', 291),
(68, 'EE', 'Estonia', 372),
(69, 'ET', 'Ethiopia', 251),
(70, 'XA', 'External Territories of Australia', 61),
(71, 'FK', 'Falkland Islands', 500),
(72, 'FO', 'Faroe Islands', 298),
(73, 'FJ', 'Fiji Islands', 679),
(74, 'FI', 'Finland', 358),
(75, 'FR', 'France', 33),
(76, 'GF', 'French Guiana', 594),
(77, 'PF', 'French Polynesia', 689),
(78, 'TF', 'French Southern Territories', 0),
(79, 'GA', 'Gabon', 241),
(80, 'GM', 'Gambia The', 220),
(81, 'GE', 'Georgia', 995),
(82, 'DE', 'Germany', 49),
(83, 'GH', 'Ghana', 233),
(84, 'GI', 'Gibraltar', 350),
(85, 'GR', 'Greece', 30),
(86, 'GL', 'Greenland', 299),
(87, 'GD', 'Grenada', 1473),
(88, 'GP', 'Guadeloupe', 590),
(89, 'GU', 'Guam', 1671),
(90, 'GT', 'Guatemala', 502),
(91, 'XU', 'Guernsey and Alderney', 44),
(92, 'GN', 'Guinea', 224),
(93, 'GW', 'Guinea-Bissau', 245),
(94, 'GY', 'Guyana', 592),
(95, 'HT', 'Haiti', 509),
(96, 'HM', 'Heard and McDonald Islands', 0),
(97, 'HN', 'Honduras', 504),
(98, 'HK', 'Hong Kong S.A.R.', 852),
(99, 'HU', 'Hungary', 36),
(100, 'IS', 'Iceland', 354),
(101, 'IN', 'India', 91),
(102, 'ID', 'Indonesia', 62),
(103, 'IR', 'Iran', 98),
(104, 'IQ', 'Iraq', 964),
(105, 'IE', 'Ireland', 353),
(106, 'IL', 'Israel', 972),
(107, 'IT', 'Italy', 39),
(108, 'JM', 'Jamaica', 1876),
(109, 'JP', 'Japan', 81),
(110, 'XJ', 'Jersey', 44),
(111, 'JO', 'Jordan', 962),
(112, 'KZ', 'Kazakhstan', 7),
(113, 'KE', 'Kenya', 254),
(114, 'KI', 'Kiribati', 686),
(115, 'KP', 'Korea North', 850),
(116, 'KR', 'Korea South', 82),
(117, 'KW', 'Kuwait', 965),
(118, 'KG', 'Kyrgyzstan', 996),
(119, 'LA', 'Laos', 856),
(120, 'LV', 'Latvia', 371),
(121, 'LB', 'Lebanon', 961),
(122, 'LS', 'Lesotho', 266),
(123, 'LR', 'Liberia', 231),
(124, 'LY', 'Libya', 218),
(125, 'LI', 'Liechtenstein', 423),
(126, 'LT', 'Lithuania', 370),
(127, 'LU', 'Luxembourg', 352),
(128, 'MO', 'Macau S.A.R.', 853),
(129, 'MK', 'Macedonia', 389),
(130, 'MG', 'Madagascar', 261),
(131, 'MW', 'Malawi', 265),
(132, 'MY', 'Malaysia', 60),
(133, 'MV', 'Maldives', 960),
(134, 'ML', 'Mali', 223),
(135, 'MT', 'Malta', 356),
(136, 'XM', 'Man (Isle of)', 44),
(137, 'MH', 'Marshall Islands', 692),
(138, 'MQ', 'Martinique', 596),
(139, 'MR', 'Mauritania', 222),
(140, 'MU', 'Mauritius', 230),
(141, 'YT', 'Mayotte', 269),
(142, 'MX', 'Mexico', 52),
(143, 'FM', 'Micronesia', 691),
(144, 'MD', 'Moldova', 373),
(145, 'MC', 'Monaco', 377),
(146, 'MN', 'Mongolia', 976),
(147, 'MS', 'Montserrat', 1664),
(148, 'MA', 'Morocco', 212),
(149, 'MZ', 'Mozambique', 258),
(150, 'MM', 'Myanmar', 95),
(151, 'NA', 'Namibia', 264),
(152, 'NR', 'Nauru', 674),
(153, 'NP', 'Nepal', 977),
(154, 'AN', 'Netherlands Antilles', 599),
(155, 'NL', 'Netherlands The', 31),
(156, 'NC', 'New Caledonia', 687),
(157, 'NZ', 'New Zealand', 64),
(158, 'NI', 'Nicaragua', 505),
(159, 'NE', 'Niger', 227),
(160, 'NG', 'Nigeria', 234),
(161, 'NU', 'Niue', 683),
(162, 'NF', 'Norfolk Island', 672),
(163, 'MP', 'Northern Mariana Islands', 1670),
(164, 'NO', 'Norway', 47),
(165, 'OM', 'Oman', 968),
(166, 'PK', 'Pakistan', 92),
(167, 'PW', 'Palau', 680),
(168, 'PS', 'Palestinian Territory Occupied', 970),
(169, 'PA', 'Panama', 507),
(170, 'PG', 'Papua new Guinea', 675),
(171, 'PY', 'Paraguay', 595),
(172, 'PE', 'Peru', 51),
(173, 'PH', 'Philippines', 63),
(174, 'PN', 'Pitcairn Island', 0),
(175, 'PL', 'Poland', 48),
(176, 'PT', 'Portugal', 351),
(177, 'PR', 'Puerto Rico', 1787),
(178, 'QA', 'Qatar', 974),
(179, 'RE', 'Reunion', 262),
(180, 'RO', 'Romania', 40),
(181, 'RU', 'Russia', 70),
(182, 'RW', 'Rwanda', 250),
(183, 'SH', 'Saint Helena', 290),
(184, 'KN', 'Saint Kitts And Nevis', 1869),
(185, 'LC', 'Saint Lucia', 1758),
(186, 'PM', 'Saint Pierre and Miquelon', 508),
(187, 'VC', 'Saint Vincent And The Grenadines', 1784),
(188, 'WS', 'Samoa', 684),
(189, 'SM', 'San Marino', 378),
(190, 'ST', 'Sao Tome and Principe', 239),
(191, 'SA', 'Saudi Arabia', 966),
(192, 'SN', 'Senegal', 221),
(193, 'RS', 'Serbia', 381),
(194, 'SC', 'Seychelles', 248),
(195, 'SL', 'Sierra Leone', 232),
(196, 'SG', 'Singapore', 65),
(197, 'SK', 'Slovakia', 421),
(198, 'SI', 'Slovenia', 386),
(200, 'SB', 'Solomon Islands', 677),
(201, 'SO', 'Somalia', 252),
(202, 'ZA', 'South Africa', 27),
(203, 'GS', 'South Georgia', 0),
(204, 'SS', 'South Sudan', 211),
(205, 'ES', 'Spain', 34),
(206, 'LK', 'Sri Lanka', 94),
(207, 'SD', 'Sudan', 249),
(208, 'SR', 'Suriname', 597),
(209, 'SJ', 'Svalbard And Jan Mayen Islands', 47),
(210, 'SZ', 'Swaziland', 268),
(211, 'SE', 'Sweden', 46),
(212, 'CH', 'Switzerland', 41),
(213, 'SY', 'Syria', 963),
(214, 'TW', 'Taiwan', 886),
(215, 'TJ', 'Tajikistan', 992),
(216, 'TZ', 'Tanzania', 255),
(217, 'TH', 'Thailand', 66),
(218, 'TG', 'Togo', 228),
(219, 'TK', 'Tokelau', 690),
(220, 'TO', 'Tonga', 676),
(221, 'TT', 'Trinidad And Tobago', 1868),
(222, 'TN', 'Tunisia', 216),
(223, 'TR', 'Turkey', 90),
(224, 'TM', 'Turkmenistan', 7370),
(225, 'TC', 'Turks And Caicos Islands', 1649),
(226, 'TV', 'Tuvalu', 688),
(227, 'UG', 'Uganda', 256),
(228, 'UA', 'Ukraine', 380),
(229, 'AE', 'United Arab Emirates', 971),
(230, 'UK', 'United Kingdom', 44),
(231, 'US', 'United States', 1),
(232, 'UM', 'United States Minor Outlying Islands', 1),
(233, 'UY', 'Uruguay', 598),
(234, 'UZ', 'Uzbekistan', 998),
(235, 'VU', 'Vanuatu', 678),
(236, 'VA', 'Vatican City State (Holy See)', 39),
(237, 'VE', 'Venezuela', 58),
(238, 'VN', 'Vietnam', 84),
(239, 'VG', 'Virgin Islands (British)', 1284),
(240, 'VI', 'Virgin Islands (US)', 1340),
(241, 'WF', 'Wallis And Futuna Islands', 681),
(242, 'EH', 'Western Sahara', 212),
(243, 'YE', 'Yemen', 967),
(244, 'YU', 'Yugoslavia', 38),
(245, 'ZM', 'Zambia', 260),
(246, 'ZW', 'Zimbabwe', 263);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('OPEN','CLOSE','DELETED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `parent_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, 'View Sports tribes', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(2, 0, 'View Arts tribes', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(3, 0, 'View Science tribes', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(4, 0, 'View Lifestyle tribes', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(5, 1, 'Yoga Lover', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(6, 1, 'Tennis Titan', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(7, 1, 'Weightlifter', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(8, 1, 'Gym Classer', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(9, 1, 'Netball Ninja', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(10, 1, 'Pilates Pirate', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(11, 1, 'Rugby Rogue', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(12, 1, 'Hockey Hero', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(13, 1, 'Rampant Runner', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(14, 1, 'Soccer Superfan', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(15, 2, 'Gamer', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(16, 2, 'Book Worm', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(17, 2, 'Blogger', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(18, 2, 'Artist', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(19, 2, 'Film Buff', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(20, 2, 'Photographer', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(21, 2, 'Writer', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(22, 2, 'Actor', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(23, 2, 'Music Maker', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(24, 3, 'Astrologer', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(25, 3, 'Biologist', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(26, 3, 'Chemist', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(27, 3, 'Physicist', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(28, 3, 'Ecologist', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(29, 4, 'Fashionista', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(30, 4, 'Foodie', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(31, 4, 'Pubber', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(32, 4, 'Clubber', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00'),
(33, 4, 'Cocktail Queen', 'OPEN', '2019-03-27 18:30:00', '2019-03-27 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_03_11_054217_create_users_table', 1),
(2, '2019_03_20_062718_create_branches_table', 1),
(3, '2019_03_24_052941_create_rel_user_groups_table', 1),
(4, '2019_03_28_120012_create_rel_user_countries_table', 1),
(5, '2019_04_02_084801_create_polls_table', 1),
(6, '2019_04_02_104447_create_rel_poll_groups_table', 1),
(7, '2019_04_02_125433_create_rel_poll_genders_table', 1),
(8, '2019_04_02_125544_create_rel_poll_years_table', 1),
(9, '2019_04_02_125710_create_rel_poll_countries_table', 1),
(10, '2019_04_02_125817_create_rel_poll_branches_table', 1),
(11, '2019_04_04_044152_create_rel_poll_votes_table', 1),
(12, '2019_04_04_044459_create_rel_poll_comments_table', 1),
(13, '2019_04_04_044633_create_rel_poll_comments_likes_table', 1),
(14, '2019_04_12_050722_create_rel_user_notification_tokens_table', 1),
(15, '2019_04_12_120926_create_user_notification_settings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE `polls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `imageLink` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allowComments` enum('YES','NO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'YES',
  `status` enum('OPEN','CLOSE','DELETED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `published_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `polls`
--

INSERT INTO `polls` (`id`, `userId`, `question`, `imageLink`, `allowComments`, `status`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'is worth visiting india? #india #trip', '1560751739.jpg', 'YES', 'OPEN', '2019-06-17 06:08:57', '2019-06-17 06:08:57', '2019-06-17 06:08:57'),
(2, 2, 'Is visiting dubai worth?? #dubai #trip', '1560760572.jpg', 'YES', 'OPEN', '2019-06-17 00:00:00', '2019-06-17 06:11:59', '2019-06-17 06:11:59'),
(3, 2, 'After lot of research I found the asynchronous programming overtaken synchronous programming as PHP over Nodejs #php #asyncronous', '1560760537.jpg', 'YES', 'OPEN', '2019-06-17 06:57:43', '2019-06-17 06:57:43', '2019-06-17 06:57:43'),
(4, 4, 'PWA means ionic with angular is in it?? #ionic #pwa #angular #nodejs', '1560755351.jpg', 'YES', 'OPEN', '2019-06-17 07:09:09', '2019-06-17 07:09:09', '2019-06-17 07:09:09'),
(5, 4, 'ReactPHP is another low-level library for event-driven programming in PHP. Managing Concurrency: From Promises to Coroutines is now so easy. #php #asynchronous', '1560760789.jpg', 'YES', 'OPEN', '2019-06-17 07:22:10', '2019-06-17 07:22:10', '2019-06-17 07:22:10'),
(6, 4, 'mariaDB now supports JSON from version 10.2. its very exiting, anyone tried it?? #mariadb #mysql #database #sql', '1560760750.jpg', 'YES', 'OPEN', '2019-06-17 07:32:04', '2019-06-17 07:32:04', '2019-06-17 07:32:04'),
(7, 2, 'For my new hybrid app am going to use SQLite as my local database. #sqlite #database', '1560760496.jpg', 'YES', 'OPEN', '2019-06-17 07:37:15', '2019-06-17 07:37:15', '2019-06-17 07:37:15'),
(8, 5, 'Create Poll check', '1560757590.jpg', 'YES', 'OPEN', '2019-06-17 07:46:26', '2019-06-17 07:46:26', '2019-06-17 07:46:26'),
(9, 5, 'This is a test of a long poll to see how the text is treated. Test test test test\ntest test test test test test test this is a long text test\n#test test test test test test', '1560757927.jpg', 'YES', 'OPEN', '2019-06-17 07:52:02', '2019-06-17 07:52:02', '2019-06-17 07:52:02'),
(10, 2, 'Build cross platform desktop apps with ElectronJS #nodejs #apps #desktop', '1560760462.jpg', 'YES', 'OPEN', '2019-06-17 08:33:00', '2019-06-17 08:33:00', '2019-06-17 08:33:00'),
(11, 2, 'Node WebKit project lets you call nodejs modules directly from DOM. Is it okay?? #nodejs #desktop #apps', '1560763912.jpg', 'YES', 'OPEN', '2019-06-17 09:31:47', '2019-06-17 09:31:47', '2019-06-17 09:31:47'),
(12, 4, 'is visiting singapore worth??', '1560764161.jpg', 'YES', 'OPEN', '2019-06-17 09:35:57', '2019-06-17 09:35:57', '2019-06-17 09:35:57'),
(13, 2, 'Functional programming is the future now. Who are agreed ? #programming', '1560764403.jpg', 'YES', 'OPEN', '2019-06-17 09:40:00', '2019-06-17 09:40:00', '2019-06-17 09:40:00'),
(14, 6, 'for api develoopment in PHP, which is most recommended Laravel Full framework or Laravel Lumen', '1560766652.jpg', 'YES', 'OPEN', '2019-06-17 10:17:29', '2019-06-17 10:17:29', '2019-06-17 10:17:29'),
(15, 6, 'are all students enjoying the football matches last week?\n#FOOTBALL', '1560767852.jpg', 'YES', 'OPEN', '2019-06-17 10:37:27', '2019-06-17 10:37:27', '2019-06-17 10:37:27'),
(51, 6, 'new yoga classes are going to start, who are exited ?? #yoga #india', '1560774277.jpg', 'YES', 'OPEN', '2019-06-17 12:24:34', '2019-06-17 12:24:34', '2019-06-17 12:24:34'),
(54, 2, 'Am going to London how is the weather there? #weather #london', '1560775388.jpg', 'YES', 'OPEN', '2019-06-17 12:43:06', '2019-06-17 12:43:06', '2019-06-17 12:43:06'),
(55, 2, 'Let’s party tonight. How are interested?? #party #DJ', '1560775659.jpg', 'YES', 'OPEN', '2019-06-17 12:47:29', '2019-06-17 12:47:29', '2019-06-17 12:47:29'),
(56, 3, 'How was the INDIA vs PAKISTAN match ??', '1560776467.jpg', 'YES', 'OPEN', '2019-06-17 13:01:05', '2019-06-17 13:01:05', '2019-06-17 13:01:05'),
(63, 2, 'Networking is mess of wires\n#IT #Networking', '1560777620.jpg', 'YES', 'OPEN', '2019-06-17 13:20:14', '2019-06-17 13:20:14', '2019-06-17 13:20:14'),
(70, 2, 'ReactPHP is another low-level library for event-driven programming in PHP. Managing Concurrency: From Promises to Coroutines is now so easy.', '1560855384.png', 'YES', 'OPEN', '2019-06-18 10:56:24', '2019-06-18 10:56:24', '2019-06-18 10:56:24'),
(72, 2, 'My new dog. How’s the color?', '1560855851.jpg', 'YES', 'OPEN', '2019-06-18 11:04:10', '2019-06-18 11:04:10', '2019-06-18 11:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `rel_poll_branches`
--

CREATE TABLE `rel_poll_branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pollId` bigint(20) NOT NULL,
  `branchId` bigint(20) NOT NULL,
  `status` enum('OPEN','CLOSE','DELETED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rel_poll_branches`
--

INSERT INTO `rel_poll_branches` (`id`, `pollId`, `branchId`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'OPEN', '2019-06-17 06:08:57', '2019-06-17 06:08:57'),
(8, 8, 0, 'OPEN', '2019-06-17 07:46:26', '2019-06-17 07:46:26'),
(9, 9, 0, 'OPEN', '2019-06-17 07:52:02', '2019-06-17 07:52:02'),
(11, 11, 0, 'OPEN', '2019-06-17 09:31:48', '2019-06-17 09:31:48'),
(12, 12, 0, 'OPEN', '2019-06-17 09:35:57', '2019-06-17 09:35:57'),
(13, 13, 0, 'OPEN', '2019-06-17 09:40:00', '2019-06-17 09:40:00'),
(14, 14, 0, 'OPEN', '2019-06-17 10:17:29', '2019-06-17 10:17:29'),
(15, 15, 0, 'OPEN', '2019-06-17 10:37:27', '2019-06-17 10:37:27'),
(51, 51, 0, 'OPEN', '2019-06-17 12:24:35', '2019-06-17 12:24:35'),
(54, 54, 0, 'OPEN', '2019-06-17 12:43:06', '2019-06-17 12:43:06'),
(55, 55, 0, 'OPEN', '2019-06-17 12:47:29', '2019-06-17 12:47:29'),
(56, 56, 0, 'OPEN', '2019-06-17 13:01:05', '2019-06-17 13:01:05'),
(63, 63, 0, 'OPEN', '2019-06-17 13:20:14', '2019-06-17 13:20:14'),
(70, 70, 0, 'OPEN', '2019-06-18 10:56:24', '2019-06-18 10:56:24'),
(72, 72, 0, 'OPEN', '2019-06-18 11:04:10', '2019-06-18 11:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `rel_poll_comments`
--

CREATE TABLE `rel_poll_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pollId` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `parentId` bigint(20) NOT NULL DEFAULT 0,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('OPEN','CLOSE','DELETED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rel_poll_comments`
--

INSERT INTO `rel_poll_comments` (`id`, `pollId`, `userId`, `parentId`, `comment`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 0, 'test comment from manoj', 'OPEN', '2019-06-17 06:50:25', '2019-06-17 06:50:25'),
(2, 3, 4, 0, 'hmm but for complex projects with lots of calculations only synchronous programming languages are best.', 'OPEN', '2019-06-17 07:02:40', '2019-06-17 07:02:40'),
(3, 3, 4, 0, 'test', 'OPEN', '2019-06-17 07:06:44', '2019-06-17 07:06:44'),
(4, 4, 2, 0, 'Write once run everywhere from web, desktop to any mobile device', 'OPEN', '2019-06-17 07:11:03', '2019-06-17 07:11:03'),
(5, 13, 6, 0, 'python is best for this case', 'OPEN', '2019-06-17 09:47:31', '2019-06-17 09:47:31'),
(6, 13, 6, 0, 'one can use GO language', 'OPEN', '2019-06-17 10:12:37', '2019-06-17 10:12:37'),
(7, 11, 6, 0, 'oh i liked it', 'OPEN', '2019-06-17 12:21:58', '2019-06-17 12:21:58'),
(8, 56, 2, 0, 'Test', 'OPEN', '2019-06-18 10:31:32', '2019-06-18 10:31:32'),
(9, 70, 3, 0, 'Working all things ??', 'OPEN', '2019-06-18 10:57:18', '2019-06-18 10:57:18');

-- --------------------------------------------------------

--
-- Table structure for table `rel_poll_comments_likes`
--

CREATE TABLE `rel_poll_comments_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pollId` bigint(20) NOT NULL,
  `relPollCommentsId` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `value` enum('YES','NO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'YES',
  `status` enum('OPEN','CLOSE','DELETED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rel_poll_comments_likes`
--

INSERT INTO `rel_poll_comments_likes` (`id`, `pollId`, `relPollCommentsId`, `userId`, `value`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 3, 'NO', 'OPEN', '2019-06-17 06:50:29', '2019-06-17 06:50:29'),
(2, 2, 1, 3, 'YES', 'OPEN', '2019-06-17 06:50:31', '2019-06-17 06:50:31'),
(3, 2, 1, 2, 'YES', 'OPEN', '2019-06-17 06:52:30', '2019-06-17 06:52:30'),
(4, 3, 2, 2, 'YES', 'OPEN', '2019-06-17 07:06:34', '2019-06-17 07:06:34'),
(5, 3, 3, 2, 'YES', 'OPEN', '2019-06-17 07:07:03', '2019-06-17 07:07:03'),
(6, 4, 4, 4, 'YES', 'OPEN', '2019-06-17 07:11:19', '2019-06-17 07:11:19'),
(7, 13, 5, 6, 'YES', 'OPEN', '2019-06-17 09:47:40', '2019-06-17 09:47:40'),
(8, 13, 5, 6, 'NO', 'OPEN', '2019-06-17 09:47:48', '2019-06-17 09:47:48'),
(9, 13, 5, 6, 'YES', 'OPEN', '2019-06-17 09:47:53', '2019-06-17 09:47:53'),
(10, 11, 7, 6, 'YES', 'OPEN', '2019-06-17 12:22:11', '2019-06-17 12:22:11'),
(11, 56, 8, 2, 'YES', 'OPEN', '2019-06-18 10:32:30', '2019-06-18 10:32:30'),
(12, 56, 8, 2, 'NO', 'OPEN', '2019-06-18 10:32:32', '2019-06-18 10:32:32'),
(13, 70, 9, 3, 'YES', 'OPEN', '2019-06-18 10:57:25', '2019-06-18 10:57:25');

-- --------------------------------------------------------

--
-- Table structure for table `rel_poll_countries`
--

CREATE TABLE `rel_poll_countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pollId` bigint(20) NOT NULL,
  `countryId` bigint(20) NOT NULL,
  `status` enum('OPEN','CLOSE','DELETED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rel_poll_countries`
--

INSERT INTO `rel_poll_countries` (`id`, `pollId`, `countryId`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'OPEN', '2019-06-17 06:08:57', '2019-06-17 06:08:57'),
(8, 8, 0, 'OPEN', '2019-06-17 07:46:26', '2019-06-17 07:46:26'),
(9, 9, 0, 'OPEN', '2019-06-17 07:52:02', '2019-06-17 07:52:02'),
(11, 11, 0, 'OPEN', '2019-06-17 09:31:48', '2019-06-17 09:31:48'),
(12, 12, 0, 'OPEN', '2019-06-17 09:35:57', '2019-06-17 09:35:57'),
(13, 13, 0, 'OPEN', '2019-06-17 09:40:00', '2019-06-17 09:40:00'),
(14, 14, 0, 'OPEN', '2019-06-17 10:17:29', '2019-06-17 10:17:29'),
(15, 15, 0, 'OPEN', '2019-06-17 10:37:27', '2019-06-17 10:37:27'),
(51, 51, 0, 'OPEN', '2019-06-17 12:24:35', '2019-06-17 12:24:35'),
(54, 54, 0, 'OPEN', '2019-06-17 12:43:06', '2019-06-17 12:43:06'),
(55, 55, 0, 'OPEN', '2019-06-17 12:47:29', '2019-06-17 12:47:29'),
(56, 56, 0, 'OPEN', '2019-06-17 13:01:05', '2019-06-17 13:01:05'),
(63, 63, 0, 'OPEN', '2019-06-17 13:20:14', '2019-06-17 13:20:14'),
(70, 70, 0, 'OPEN', '2019-06-18 10:56:24', '2019-06-18 10:56:24'),
(72, 72, 0, 'OPEN', '2019-06-18 11:04:10', '2019-06-18 11:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `rel_poll_genders`
--

CREATE TABLE `rel_poll_genders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pollId` bigint(20) NOT NULL,
  `gender` enum('MALE','FEMALE','NEUTRAL','OTHER','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'MALE',
  `status` enum('OPEN','CLOSE','DELETED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rel_poll_genders`
--

INSERT INTO `rel_poll_genders` (`id`, `pollId`, `gender`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '0', 'OPEN', '2019-06-17 06:08:57', '2019-06-17 06:08:57'),
(8, 8, '0', 'OPEN', '2019-06-17 07:46:26', '2019-06-17 07:46:26'),
(9, 9, '0', 'OPEN', '2019-06-17 07:52:02', '2019-06-17 07:52:02'),
(11, 10, '0', 'OPEN', '2019-06-17 08:34:21', '2019-06-17 08:34:21'),
(12, 7, '0', 'OPEN', '2019-06-17 08:34:56', '2019-06-17 08:34:56'),
(13, 3, '0', 'OPEN', '2019-06-17 08:35:37', '2019-06-17 08:35:37'),
(14, 2, '0', 'OPEN', '2019-06-17 08:36:12', '2019-06-17 08:36:12'),
(15, 6, '0', 'OPEN', '2019-06-17 08:38:58', '2019-06-17 08:38:58'),
(16, 5, '0', 'OPEN', '2019-06-17 08:39:46', '2019-06-17 08:39:46'),
(17, 4, '0', 'OPEN', '2019-06-17 08:40:21', '2019-06-17 08:40:21'),
(18, 11, '0', 'OPEN', '2019-06-17 09:31:48', '2019-06-17 09:31:48'),
(19, 12, '0', 'OPEN', '2019-06-17 09:35:57', '2019-06-17 09:35:57'),
(20, 13, '0', 'OPEN', '2019-06-17 09:40:00', '2019-06-17 09:40:00'),
(21, 14, '0', 'OPEN', '2019-06-17 10:17:29', '2019-06-17 10:17:29'),
(22, 15, '0', 'OPEN', '2019-06-17 10:37:27', '2019-06-17 10:37:27'),
(58, 51, '0', 'OPEN', '2019-06-17 12:24:35', '2019-06-17 12:24:35'),
(61, 54, '0', 'OPEN', '2019-06-17 12:43:06', '2019-06-17 12:43:06'),
(62, 55, '0', 'OPEN', '2019-06-17 12:47:29', '2019-06-17 12:47:29'),
(63, 56, '0', 'OPEN', '2019-06-17 13:01:05', '2019-06-17 13:01:05'),
(70, 63, '0', 'OPEN', '2019-06-17 13:20:14', '2019-06-17 13:20:14'),
(77, 70, '0', 'OPEN', '2019-06-18 10:56:24', '2019-06-18 10:56:24'),
(79, 72, '0', 'OPEN', '2019-06-18 11:04:10', '2019-06-18 11:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `rel_poll_groups`
--

CREATE TABLE `rel_poll_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pollId` bigint(20) NOT NULL,
  `groupId` bigint(20) NOT NULL,
  `status` enum('OPEN','CLOSE','DELETED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rel_poll_groups`
--

INSERT INTO `rel_poll_groups` (`id`, `pollId`, `groupId`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'OPEN', '2019-06-17 06:08:57', '2019-06-17 06:08:57'),
(8, 8, 0, 'OPEN', '2019-06-17 07:46:26', '2019-06-17 07:46:26'),
(9, 9, 0, 'OPEN', '2019-06-17 07:52:02', '2019-06-17 07:52:02'),
(11, 11, 0, 'OPEN', '2019-06-17 09:31:47', '2019-06-17 09:31:47'),
(12, 12, 0, 'OPEN', '2019-06-17 09:35:57', '2019-06-17 09:35:57'),
(13, 13, 0, 'OPEN', '2019-06-17 09:40:00', '2019-06-17 09:40:00'),
(14, 14, 0, 'OPEN', '2019-06-17 10:17:29', '2019-06-17 10:17:29'),
(15, 15, 0, 'OPEN', '2019-06-17 10:37:27', '2019-06-17 10:37:27'),
(51, 51, 0, 'OPEN', '2019-06-17 12:24:34', '2019-06-17 12:24:34'),
(54, 54, 0, 'OPEN', '2019-06-17 12:43:06', '2019-06-17 12:43:06'),
(55, 55, 0, 'OPEN', '2019-06-17 12:47:29', '2019-06-17 12:47:29'),
(56, 56, 0, 'OPEN', '2019-06-17 13:01:05', '2019-06-17 13:01:05'),
(63, 63, 0, 'OPEN', '2019-06-17 13:20:14', '2019-06-17 13:20:14'),
(70, 70, 0, 'OPEN', '2019-06-18 10:56:24', '2019-06-18 10:56:24'),
(72, 72, 0, 'OPEN', '2019-06-18 11:04:10', '2019-06-18 11:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `rel_poll_votes`
--

CREATE TABLE `rel_poll_votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pollId` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `vote` enum('YES','NO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'YES',
  `status` enum('OPEN','CLOSE','DELETED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rel_poll_votes`
--

INSERT INTO `rel_poll_votes` (`id`, `pollId`, `userId`, `vote`, `status`, `created_at`, `updated_at`) VALUES
(4, 1, 4, 'YES', 'OPEN', '2019-06-17 09:24:06', '2019-06-17 09:24:06'),
(5, 13, 6, 'YES', 'OPEN', '2019-06-17 09:46:50', '2019-06-17 09:46:50'),
(6, 14, 2, 'YES', 'OPEN', '2019-06-17 10:20:32', '2019-06-17 10:20:32'),
(7, 15, 3, 'YES', 'OPEN', '2019-06-17 11:04:42', '2019-06-17 11:04:42'),
(8, 11, 6, 'YES', 'OPEN', '2019-06-17 12:19:37', '2019-06-17 12:19:37'),
(9, 10, 6, 'YES', 'OPEN', '2019-06-17 12:20:33', '2019-06-17 12:20:33'),
(10, 55, 3, 'YES', 'OPEN', '2019-06-17 12:58:49', '2019-06-17 12:58:49'),
(11, 56, 2, 'YES', 'OPEN', '2019-06-18 10:31:02', '2019-06-18 10:31:02'),
(12, 70, 3, 'YES', 'OPEN', '2019-06-18 10:56:58', '2019-06-18 10:56:58');

-- --------------------------------------------------------

--
-- Table structure for table `rel_poll_years`
--

CREATE TABLE `rel_poll_years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pollId` bigint(20) NOT NULL,
  `year` bigint(20) NOT NULL,
  `status` enum('OPEN','CLOSE','DELETED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rel_poll_years`
--

INSERT INTO `rel_poll_years` (`id`, `pollId`, `year`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'OPEN', '2019-06-17 06:08:57', '2019-06-17 06:08:57'),
(8, 8, 0, 'OPEN', '2019-06-17 07:46:26', '2019-06-17 07:46:26'),
(9, 9, 0, 'OPEN', '2019-06-17 07:52:02', '2019-06-17 07:52:02'),
(11, 11, 0, 'OPEN', '2019-06-17 09:31:48', '2019-06-17 09:31:48'),
(12, 12, 0, 'OPEN', '2019-06-17 09:35:57', '2019-06-17 09:35:57'),
(13, 13, 0, 'OPEN', '2019-06-17 09:40:00', '2019-06-17 09:40:00'),
(14, 14, 0, 'OPEN', '2019-06-17 10:17:29', '2019-06-17 10:17:29'),
(15, 15, 0, 'OPEN', '2019-06-17 10:37:27', '2019-06-17 10:37:27'),
(20, 20, 0, 'OPEN', '2019-06-17 11:00:45', '2019-06-17 11:00:45'),
(21, 21, 0, 'OPEN', '2019-06-17 11:01:18', '2019-06-17 11:01:18'),
(22, 22, 0, 'OPEN', '2019-06-17 11:01:35', '2019-06-17 11:01:35'),
(23, 23, 0, 'OPEN', '2019-06-17 11:02:13', '2019-06-17 11:02:13'),
(24, 24, 0, 'OPEN', '2019-06-17 11:02:47', '2019-06-17 11:02:47'),
(25, 25, 0, 'OPEN', '2019-06-17 11:03:20', '2019-06-17 11:03:20'),
(26, 26, 0, 'OPEN', '2019-06-17 11:04:02', '2019-06-17 11:04:02'),
(27, 27, 0, 'OPEN', '2019-06-17 11:05:00', '2019-06-17 11:05:00'),
(28, 28, 0, 'OPEN', '2019-06-17 11:05:41', '2019-06-17 11:05:41'),
(29, 29, 0, 'OPEN', '2019-06-17 11:06:10', '2019-06-17 11:06:10'),
(30, 30, 0, 'OPEN', '2019-06-17 11:08:19', '2019-06-17 11:08:19'),
(31, 31, 0, 'OPEN', '2019-06-17 11:08:27', '2019-06-17 11:08:27'),
(32, 32, 0, 'OPEN', '2019-06-17 11:08:52', '2019-06-17 11:08:52'),
(33, 33, 0, 'OPEN', '2019-06-17 11:09:20', '2019-06-17 11:09:20'),
(34, 34, 0, 'OPEN', '2019-06-17 11:10:04', '2019-06-17 11:10:04'),
(35, 35, 0, 'OPEN', '2019-06-17 11:10:38', '2019-06-17 11:10:38'),
(36, 36, 0, 'OPEN', '2019-06-17 11:11:08', '2019-06-17 11:11:08'),
(37, 37, 0, 'OPEN', '2019-06-17 11:11:55', '2019-06-17 11:11:55'),
(38, 38, 0, 'OPEN', '2019-06-17 11:12:23', '2019-06-17 11:12:23'),
(39, 39, 0, 'OPEN', '2019-06-17 11:12:48', '2019-06-17 11:12:48'),
(40, 40, 0, 'OPEN', '2019-06-17 11:13:52', '2019-06-17 11:13:52'),
(41, 41, 0, 'OPEN', '2019-06-17 11:14:03', '2019-06-17 11:14:03'),
(42, 42, 0, 'OPEN', '2019-06-17 11:14:24', '2019-06-17 11:14:24'),
(43, 43, 0, 'OPEN', '2019-06-17 11:14:44', '2019-06-17 11:14:44'),
(44, 44, 0, 'OPEN', '2019-06-17 11:15:02', '2019-06-17 11:15:02'),
(45, 45, 0, 'OPEN', '2019-06-17 11:15:16', '2019-06-17 11:15:16'),
(46, 46, 0, 'OPEN', '2019-06-17 11:15:39', '2019-06-17 11:15:39'),
(47, 47, 0, 'OPEN', '2019-06-17 11:16:03', '2019-06-17 11:16:03'),
(48, 48, 0, 'OPEN', '2019-06-17 11:16:42', '2019-06-17 11:16:42'),
(49, 49, 0, 'OPEN', '2019-06-17 11:17:00', '2019-06-17 11:17:00'),
(50, 50, 0, 'OPEN', '2019-06-17 11:17:34', '2019-06-17 11:17:34'),
(51, 51, 0, 'OPEN', '2019-06-17 12:24:35', '2019-06-17 12:24:35'),
(54, 54, 0, 'OPEN', '2019-06-17 12:43:06', '2019-06-17 12:43:06'),
(55, 55, 0, 'OPEN', '2019-06-17 12:47:29', '2019-06-17 12:47:29'),
(56, 56, 0, 'OPEN', '2019-06-17 13:01:05', '2019-06-17 13:01:05'),
(63, 63, 0, 'OPEN', '2019-06-17 13:20:14', '2019-06-17 13:20:14'),
(70, 70, 0, 'OPEN', '2019-06-18 10:56:24', '2019-06-18 10:56:24'),
(72, 72, 0, 'OPEN', '2019-06-18 11:04:10', '2019-06-18 11:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `rel_user_countries`
--

CREATE TABLE `rel_user_countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) NOT NULL,
  `countryId` bigint(20) NOT NULL,
  `status` enum('OPEN','CLOSE','DELETED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rel_user_countries`
--

INSERT INTO `rel_user_countries` (`id`, `userId`, `countryId`, `status`, `created_at`, `updated_at`) VALUES
(74, 4, 1, 'OPEN', '2019-06-17 09:44:31', '2019-06-17 09:44:31'),
(109, 6, 1, 'OPEN', '2019-06-17 13:09:58', '2019-06-17 13:09:58'),
(120, 5, 230, 'OPEN', '2019-06-17 13:36:46', '2019-06-17 13:36:46'),
(122, 3, 1, 'OPEN', '2019-06-18 08:50:40', '2019-06-18 08:50:40'),
(126, 2, 1, 'OPEN', '2019-06-18 11:41:39', '2019-06-18 11:41:39');

-- --------------------------------------------------------

--
-- Table structure for table `rel_user_groups`
--

CREATE TABLE `rel_user_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) NOT NULL,
  `groupId` bigint(20) NOT NULL,
  `status` enum('OPEN','CLOSE','DELETED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rel_user_groups`
--

INSERT INTO `rel_user_groups` (`id`, `userId`, `groupId`, `status`, `created_at`, `updated_at`) VALUES
(514, 4, 7, 'OPEN', '2019-06-17 09:44:31', '2019-06-17 09:44:31'),
(515, 4, 5, 'OPEN', '2019-06-17 09:44:31', '2019-06-17 09:44:31'),
(516, 4, 8, 'OPEN', '2019-06-17 09:44:31', '2019-06-17 09:44:31'),
(517, 4, 11, 'OPEN', '2019-06-17 09:44:31', '2019-06-17 09:44:31'),
(518, 4, 9, 'OPEN', '2019-06-17 09:44:31', '2019-06-17 09:44:31'),
(519, 4, 12, 'OPEN', '2019-06-17 09:44:31', '2019-06-17 09:44:31'),
(520, 4, 14, 'OPEN', '2019-06-17 09:44:31', '2019-06-17 09:44:31'),
(521, 4, 13, 'OPEN', '2019-06-17 09:44:31', '2019-06-17 09:44:31'),
(522, 4, 1, 'OPEN', '2019-06-17 09:44:31', '2019-06-17 09:44:31'),
(523, 4, 10, 'OPEN', '2019-06-17 09:44:31', '2019-06-17 09:44:31'),
(524, 4, 6, 'OPEN', '2019-06-17 09:44:31', '2019-06-17 09:44:31'),
(693, 6, 33, 'OPEN', '2019-06-17 13:09:57', '2019-06-17 13:09:57'),
(694, 6, 32, 'OPEN', '2019-06-17 13:09:57', '2019-06-17 13:09:57'),
(695, 6, 4, 'OPEN', '2019-06-17 13:09:57', '2019-06-17 13:09:57'),
(744, 5, 1, 'OPEN', '2019-06-17 13:36:46', '2019-06-17 13:36:46'),
(745, 5, 11, 'OPEN', '2019-06-17 13:36:46', '2019-06-17 13:36:46'),
(752, 3, 29, 'OPEN', '2019-06-18 08:50:40', '2019-06-18 08:50:40'),
(753, 3, 4, 'OPEN', '2019-06-18 08:50:40', '2019-06-18 08:50:40'),
(754, 3, 31, 'OPEN', '2019-06-18 08:50:40', '2019-06-18 08:50:40'),
(755, 3, 33, 'OPEN', '2019-06-18 08:50:40', '2019-06-18 08:50:40'),
(756, 3, 30, 'OPEN', '2019-06-18 08:50:40', '2019-06-18 08:50:40'),
(757, 3, 32, 'OPEN', '2019-06-18 08:50:40', '2019-06-18 08:50:40'),
(776, 2, 3, 'OPEN', '2019-06-18 11:41:39', '2019-06-18 11:41:39'),
(777, 2, 27, 'OPEN', '2019-06-18 11:41:39', '2019-06-18 11:41:39'),
(778, 2, 26, 'OPEN', '2019-06-18 11:41:39', '2019-06-18 11:41:39'),
(779, 2, 24, 'OPEN', '2019-06-18 11:41:39', '2019-06-18 11:41:39'),
(780, 2, 28, 'OPEN', '2019-06-18 11:41:39', '2019-06-18 11:41:39'),
(781, 2, 25, 'OPEN', '2019-06-18 11:41:39', '2019-06-18 11:41:39');

-- --------------------------------------------------------

--
-- Table structure for table `rel_user_notification_tokens`
--

CREATE TABLE `rel_user_notification_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) NOT NULL,
  `type` enum('WEB','IPHONE','ANDROID') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'IPHONE',
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('OPEN','CLOSE','DELETED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rel_user_notification_tokens`
--

INSERT INTO `rel_user_notification_tokens` (`id`, `userId`, `type`, `token`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'WEB', 'cCXXTJhNdGA:APA91bE-49SnmIFldiKY4rkzaVIijhFr45d5r6N59S5B9TfFR2cstcN6V986nidilFKuG8iCBoH2Cr90zcxjqS6OljPuqqc9oWsdbnBuK3wLKEFoyMx46KZQS5G9xx2evOhYPtKrkXuW', 'OPEN', '2019-06-17 05:27:51', '2019-06-17 05:27:51'),
(19, 3, 'IPHONE', 'ftdBr4ATZJ8:APA91bHfOI8UFDTV4o2mx9N_stAPGuHatLL9dsznpAsSVPBQxQ0l4OaTFLKGju8gikEgZsVNTLk_iMB5wM2g7zzUhRTCWOb7PA2iN3pN2k7DGgd7IL7bAn56Ws70MSt3Yu0Y_5nzG47Z', 'OPEN', '2019-06-18 08:50:52', '2019-06-18 08:50:52'),
(21, 2, 'IPHONE', 'e3vAyQlieaI:APA91bH5ICUWnLLUz1UdKNjUp2hvwmu2MKIg8CznHblMYS7uwaewkOD9WPWPfoVChFomMDAy_f2XoZpnfGkfeCtCq8h5Jcj7uebUbPkdSW_XAbb7oT1VuEYgMPpxwCCeGkN26wXztyKN', 'OPEN', '2019-06-18 10:34:01', '2019-06-18 10:34:01');

-- --------------------------------------------------------

--
-- Table structure for table `rel_user_points`
--

CREATE TABLE `rel_user_points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) NOT NULL,
  `pollId` bigint(20) NOT NULL,
  `transactionFor` enum('SIGNUP','POLLCREATED','POLLVOTED') COLLATE utf8mb4_unicode_ci NOT NULL,
  `transactionType` enum('DEBIT','CREDIT') COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` int(11) NOT NULL,
  `status` enum('OPEN','CLOSE','DELETED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rel_user_points`
--

INSERT INTO `rel_user_points` (`id`, `userId`, `pollId`, `transactionFor`, `transactionType`, `points`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 0, 'SIGNUP', 'CREDIT', 500, 'OPEN', '2019-06-17 05:56:01', '2019-06-17 05:56:01'),
(2, 2, 1, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 06:08:58', '2019-06-17 06:08:58'),
(3, 2, 2, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 06:11:59', '2019-06-17 06:11:59'),
(4, 3, 0, 'SIGNUP', 'CREDIT', 500, 'OPEN', '2019-06-17 06:14:14', '2019-06-17 06:14:14'),
(5, 4, 0, 'SIGNUP', 'CREDIT', 500, 'OPEN', '2019-06-17 06:36:58', '2019-06-17 06:36:58'),
(6, 3, 2, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-06-17 06:49:34', '2019-06-17 06:49:34'),
(7, 2, 3, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 06:57:43', '2019-06-17 06:57:43'),
(8, 4, 3, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-06-17 07:01:16', '2019-06-17 07:01:16'),
(9, 4, 4, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 07:09:09', '2019-06-17 07:09:09'),
(10, 2, 4, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-06-17 07:10:04', '2019-06-17 07:10:04'),
(11, 4, 5, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 07:22:10', '2019-06-17 07:22:10'),
(12, 4, 6, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 07:32:04', '2019-06-17 07:32:04'),
(13, 2, 7, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 07:37:15', '2019-06-17 07:37:15'),
(14, 5, 0, 'SIGNUP', 'CREDIT', 500, 'OPEN', '2019-06-17 07:44:06', '2019-06-17 07:44:06'),
(15, 5, 8, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 07:46:26', '2019-06-17 07:46:26'),
(16, 5, 9, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 07:52:02', '2019-06-17 07:52:02'),
(17, 2, 10, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 08:33:00', '2019-06-17 08:33:00'),
(18, 4, 1, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-06-17 09:24:06', '2019-06-17 09:24:06'),
(19, 2, 11, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 09:31:48', '2019-06-17 09:31:48'),
(20, 4, 12, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 09:35:57', '2019-06-17 09:35:57'),
(21, 2, 13, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 09:40:00', '2019-06-17 09:40:00'),
(22, 6, 0, 'SIGNUP', 'CREDIT', 500, 'OPEN', '2019-06-17 09:45:37', '2019-06-17 09:45:37'),
(23, 6, 13, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-06-17 09:46:50', '2019-06-17 09:46:50'),
(24, 6, 14, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 10:17:29', '2019-06-17 10:17:29'),
(25, 2, 14, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-06-17 10:20:32', '2019-06-17 10:20:32'),
(26, 6, 15, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 10:37:27', '2019-06-17 10:37:27'),
(27, 3, 16, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 10:54:21', '2019-06-17 10:54:21'),
(28, 3, 17, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 10:56:28', '2019-06-17 10:56:28'),
(29, 3, 18, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 10:58:06', '2019-06-17 10:58:06'),
(30, 3, 19, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 10:59:29', '2019-06-17 10:59:29'),
(31, 3, 20, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:00:45', '2019-06-17 11:00:45'),
(32, 3, 21, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:01:18', '2019-06-17 11:01:18'),
(33, 3, 22, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:01:35', '2019-06-17 11:01:35'),
(34, 3, 23, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:02:13', '2019-06-17 11:02:13'),
(35, 3, 24, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:02:47', '2019-06-17 11:02:47'),
(36, 3, 25, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:03:20', '2019-06-17 11:03:20'),
(37, 3, 26, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:04:02', '2019-06-17 11:04:02'),
(38, 3, 15, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-06-17 11:04:43', '2019-06-17 11:04:43'),
(39, 3, 27, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:05:00', '2019-06-17 11:05:00'),
(40, 3, 28, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:05:41', '2019-06-17 11:05:41'),
(41, 3, 29, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:06:10', '2019-06-17 11:06:10'),
(42, 3, 30, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:08:19', '2019-06-17 11:08:19'),
(43, 3, 31, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:08:27', '2019-06-17 11:08:27'),
(44, 3, 32, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:08:52', '2019-06-17 11:08:52'),
(45, 3, 33, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:09:20', '2019-06-17 11:09:20'),
(46, 3, 34, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:10:04', '2019-06-17 11:10:04'),
(47, 3, 35, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:10:38', '2019-06-17 11:10:38'),
(48, 3, 36, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:11:08', '2019-06-17 11:11:08'),
(49, 3, 37, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:11:55', '2019-06-17 11:11:55'),
(50, 3, 38, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:12:23', '2019-06-17 11:12:23'),
(51, 3, 39, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:12:49', '2019-06-17 11:12:49'),
(52, 3, 40, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:13:52', '2019-06-17 11:13:52'),
(53, 3, 41, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:14:03', '2019-06-17 11:14:03'),
(54, 3, 42, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:14:24', '2019-06-17 11:14:24'),
(55, 3, 43, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:14:44', '2019-06-17 11:14:44'),
(56, 3, 44, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:15:02', '2019-06-17 11:15:02'),
(57, 3, 45, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:15:16', '2019-06-17 11:15:16'),
(58, 3, 46, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:15:39', '2019-06-17 11:15:39'),
(59, 3, 47, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:16:03', '2019-06-17 11:16:03'),
(60, 3, 48, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:16:42', '2019-06-17 11:16:42'),
(61, 3, 49, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:17:00', '2019-06-17 11:17:00'),
(62, 3, 50, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 11:17:34', '2019-06-17 11:17:34'),
(63, 6, 11, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-06-17 12:19:37', '2019-06-17 12:19:37'),
(64, 6, 10, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-06-17 12:20:33', '2019-06-17 12:20:33'),
(65, 6, 51, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 12:24:35', '2019-06-17 12:24:35'),
(66, 3, 52, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 12:30:22', '2019-06-17 12:30:22'),
(67, 6, 53, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 12:31:41', '2019-06-17 12:31:41'),
(68, 2, 54, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 12:43:06', '2019-06-17 12:43:06'),
(69, 2, 55, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 12:47:29', '2019-06-17 12:47:29'),
(70, 3, 55, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-06-17 12:58:49', '2019-06-17 12:58:49'),
(71, 3, 56, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 13:01:05', '2019-06-17 13:01:05'),
(72, 6, 57, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 13:11:21', '2019-06-17 13:11:21'),
(73, 2, 58, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 13:11:59', '2019-06-17 13:11:59'),
(74, 2, 59, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 13:13:14', '2019-06-17 13:13:14'),
(75, 2, 60, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 13:15:18', '2019-06-17 13:15:18'),
(76, 2, 61, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 13:15:49', '2019-06-17 13:15:49'),
(77, 2, 62, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 13:16:13', '2019-06-17 13:16:13'),
(78, 2, 63, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 13:20:14', '2019-06-17 13:20:14'),
(79, 2, 64, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 13:21:23', '2019-06-17 13:21:23'),
(80, 2, 65, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-17 13:23:27', '2019-06-17 13:23:27'),
(81, 2, 56, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-06-18 10:31:02', '2019-06-18 10:31:02'),
(82, 2, 66, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-18 10:33:34', '2019-06-18 10:33:34'),
(83, 2, 67, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-18 10:36:20', '2019-06-18 10:36:20'),
(84, 2, 68, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-18 10:38:26', '2019-06-18 10:38:26'),
(85, 2, 69, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-18 10:40:16', '2019-06-18 10:40:16'),
(86, 2, 70, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-18 10:56:24', '2019-06-18 10:56:24'),
(87, 3, 70, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-06-18 10:56:58', '2019-06-18 10:56:58'),
(88, 2, 71, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-18 10:57:58', '2019-06-18 10:57:58'),
(89, 2, 72, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-18 11:04:10', '2019-06-18 11:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `universityEmail` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imageLink` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('MALE','FEMALE','NEUTRAL','OTHER') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'MALE',
  `studyingYear` int(11) NOT NULL,
  `branchId` int(11) NOT NULL,
  `status` enum('OPEN','CLOSE','DELETED','BLOCKED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userName`, `universityEmail`, `password`, `imageLink`, `gender`, `studyingYear`, `branchId`, `status`, `created_at`, `updated_at`) VALUES
(1, 'bawa_d', 'bawa_d@ymail.com', '$2y$10$LSXYRyh9Wt/jhvqxXgq/vO38EJCl/VeLBaclmRGzG3HWf39qo5txC', NULL, 'MALE', 4, 1, 'OPEN', '2019-04-16 08:45:46', '2019-04-16 08:45:46'),
(2, 'deepak', 'deepak@yopmail.com', '$2y$10$IlBXSJ1eiW0riPNEziZGn.1rbtXftRgx4IefYD2l6C8us2e.u56Fm', '1560858095.jpg', 'MALE', 1, 3, 'OPEN', '2019-06-17 05:56:01', '2019-06-17 05:56:01'),
(3, 'manoj', 'manoj@yopmail.com', '$2y$10$wEoBCbYWqRQaASSRKTobq.gDeRK0H7JC03gvB/3z8L5upefxiSUtG', '1560766502.jpg', 'MALE', 1, 1, 'OPEN', '2019-06-17 06:14:13', '2019-06-17 06:14:13'),
(4, 'shanti', 'shanti@yopmail.com', '$2y$10$ZlufJNOh/hn.YPiIQ0XgYe0cvFZKCZQVTjFviGJrEMsuvRiN/ASPG', NULL, 'FEMALE', 1, 5, 'OPEN', '2019-06-17 06:36:58', '2019-06-17 06:36:58'),
(5, 'founder1', 'nicholaspowell@hotmail.com', '$2y$10$sLXMkebtizaLG8GViF8.T.tTVgHrf11Dh0QI6/.5Hnn53uQZg66M.', '1560758677.jpg', 'MALE', 1, 4, 'OPEN', '2019-06-17 07:44:05', '2019-06-17 07:44:05'),
(6, 'founder3', 'founder3@yopmail.com', '$2y$10$MK.aXF4dX1/QnFhb5il8f.5u0YJJ4AmHmwkJxQStC297gpkfDw1mC', '1560767694.jpg', 'MALE', 1, 4, 'OPEN', '2019-06-17 09:45:36', '2019-06-17 09:45:36');

-- --------------------------------------------------------

--
-- Table structure for table `user_notification_settings`
--

CREATE TABLE `user_notification_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) NOT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('OPEN','CLOSE','DELETED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OPEN',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_notification_settings`
--

INSERT INTO `user_notification_settings` (`id`, `userId`, `settings`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, '{\"newPollReceived\":\"1\",\"pollVoteReceived\":\"1\",\"pollCommentReceived\":\"1\",\"pollEnded\":\"1\"}', 'OPEN', '2019-06-17 05:56:01', '2019-06-17 05:56:01'),
(2, 3, '{\"pollEnded\":1,\"pollVoteReceived\":1,\"newPollReceived\":1,\"pollCommentReceived\":1}', 'OPEN', '2019-06-17 06:14:14', '2019-06-17 06:14:14'),
(3, 4, '{\"newPollReceived\":\"1\",\"pollVoteReceived\":\"1\",\"pollCommentReceived\":\"1\",\"pollEnded\":\"1\"}', 'OPEN', '2019-06-17 06:36:58', '2019-06-17 06:36:58'),
(4, 5, '{\"newPollReceived\":\"1\",\"pollVoteReceived\":\"1\",\"pollCommentReceived\":\"1\",\"pollEnded\":\"1\"}', 'OPEN', '2019-06-17 07:44:06', '2019-06-17 07:44:06'),
(5, 6, '{\"pollVoteReceived\":1,\"pollCommentReceived\":1,\"newPollReceived\":1,\"pollEnded\":1}', 'OPEN', '2019-06-17 09:45:37', '2019-06-17 09:45:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`) USING BTREE;

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`) USING BTREE;

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`) USING BTREE;

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`) USING BTREE;

--
-- Indexes for table `rel_poll_branches`
--
ALTER TABLE `rel_poll_branches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pollId` (`pollId`) USING BTREE,
  ADD KEY `branchId` (`branchId`) USING BTREE;

--
-- Indexes for table `rel_poll_comments`
--
ALTER TABLE `rel_poll_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pollId` (`pollId`) USING BTREE,
  ADD KEY `userId` (`userId`) USING BTREE;

--
-- Indexes for table `rel_poll_comments_likes`
--
ALTER TABLE `rel_poll_comments_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pollId` (`pollId`) USING BTREE,
  ADD KEY `userId` (`userId`) USING BTREE;

--
-- Indexes for table `rel_poll_countries`
--
ALTER TABLE `rel_poll_countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pollId` (`pollId`) USING BTREE,
  ADD KEY `countryId` (`countryId`) USING BTREE;

--
-- Indexes for table `rel_poll_genders`
--
ALTER TABLE `rel_poll_genders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pollId` (`pollId`) USING BTREE,
  ADD KEY `gender` (`gender`) USING BTREE;

--
-- Indexes for table `rel_poll_groups`
--
ALTER TABLE `rel_poll_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pollId` (`pollId`) USING BTREE,
  ADD KEY `groupId` (`groupId`) USING BTREE;

--
-- Indexes for table `rel_poll_votes`
--
ALTER TABLE `rel_poll_votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pollId` (`pollId`) USING BTREE,
  ADD KEY `userId` (`userId`) USING BTREE;

--
-- Indexes for table `rel_poll_years`
--
ALTER TABLE `rel_poll_years`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pollId` (`pollId`) USING BTREE,
  ADD KEY `year` (`year`) USING BTREE;

--
-- Indexes for table `rel_user_countries`
--
ALTER TABLE `rel_user_countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`) USING BTREE,
  ADD KEY `countryId` (`countryId`) USING BTREE;

--
-- Indexes for table `rel_user_groups`
--
ALTER TABLE `rel_user_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`) USING BTREE,
  ADD KEY `groupId` (`groupId`) USING BTREE;

--
-- Indexes for table `rel_user_notification_tokens`
--
ALTER TABLE `rel_user_notification_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rel_user_notification_tokens_token_unique` (`token`),
  ADD KEY `userId` (`userId`) USING BTREE;

--
-- Indexes for table `rel_user_points`
--
ALTER TABLE `rel_user_points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branchId` (`branchId`) USING BTREE,
  ADD KEY `studyingYear` (`studyingYear`) USING BTREE,
  ADD KEY `username` (`userName`),
  ADD KEY `email` (`universityEmail`);

--
-- Indexes for table `user_notification_settings`
--
ALTER TABLE `user_notification_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `rel_poll_branches`
--
ALTER TABLE `rel_poll_branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `rel_poll_comments`
--
ALTER TABLE `rel_poll_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `rel_poll_comments_likes`
--
ALTER TABLE `rel_poll_comments_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `rel_poll_countries`
--
ALTER TABLE `rel_poll_countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `rel_poll_genders`
--
ALTER TABLE `rel_poll_genders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT for table `rel_poll_groups`
--
ALTER TABLE `rel_poll_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `rel_poll_votes`
--
ALTER TABLE `rel_poll_votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `rel_poll_years`
--
ALTER TABLE `rel_poll_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `rel_user_countries`
--
ALTER TABLE `rel_user_countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;
--
-- AUTO_INCREMENT for table `rel_user_groups`
--
ALTER TABLE `rel_user_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=782;
--
-- AUTO_INCREMENT for table `rel_user_notification_tokens`
--
ALTER TABLE `rel_user_notification_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `rel_user_points`
--
ALTER TABLE `rel_user_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_notification_settings`
--
ALTER TABLE `user_notification_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
