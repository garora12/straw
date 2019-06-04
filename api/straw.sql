-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 04, 2019 at 08:57 AM
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
(230, 'GB', 'United Kingdom', 44),
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
(1, 2, 'Is worth visiting India?? #india #country #tiranga', '1558456006.jpg', 'YES', 'DELETED', '2019-05-21 16:26:44', '2019-05-21 16:26:44', '2019-05-21 16:26:44'),
(2, 3, 'Is worth visiting Canada? #canada #beautiful #trip', '1558456160.jpg', 'YES', 'OPEN', '2019-05-21 16:29:19', '2019-05-21 16:29:19', '2019-05-21 16:29:19'),
(3, 3, 'Which one is better macOS or windowsOS? #macos #windows #microsoft #apple', '1558456447.jpg', 'YES', 'OPEN', '2019-05-21 16:34:06', '2019-05-21 16:34:06', '2019-05-21 16:34:06'),
(4, 3, 'Is yoga good for weight loss? #fat #yoga #namaste', '1558456705.jpg', 'YES', 'OPEN', '2019-05-21 16:38:24', '2019-05-21 16:38:24', '2019-05-21 16:38:24'),
(5, 3, 'Is quora trustable? #quora #polls #trust', NULL, 'YES', 'OPEN', '2019-05-21 16:43:31', '2019-05-21 16:43:31', '2019-05-21 16:43:31'),
(6, 2, 'Cats are like lions ?? #wildlife #cats', '1558457351.jpg', 'YES', 'OPEN', '2019-05-21 16:49:09', '2019-05-21 16:49:09', '2019-05-21 16:49:09'),
(7, 3, 'Is angular is good for hybrid apps? #google #angular #hybrid #apps', '1558457668.jpg', 'YES', 'OPEN', '2019-05-21 16:54:27', '2019-05-21 16:54:27', '2019-05-21 16:54:27'),
(8, 3, 'Is stackoverflow trustable? #quora #polls #trust', NULL, 'YES', 'OPEN', '2019-05-21 16:55:58', '2019-05-21 16:55:58', '2019-05-21 16:55:58'),
(9, 3, 'Is ionic easy? #angular #ionic #hybrid', NULL, 'YES', 'OPEN', '2019-05-21 17:14:04', '2019-05-21 17:14:04', '2019-05-21 17:14:04'),
(10, 3, 'Is visiting Taj Mahal exciting?? #india #agra #tazmahal', '', 'NO', 'OPEN', '2019-05-21 17:17:09', '2019-05-21 17:17:09', '2019-05-21 17:17:09'),
(11, 5, 'Who is the greatest singer in the world?', '1558508221.jpg', 'YES', 'OPEN', '2019-05-22 06:56:55', '2019-05-22 06:56:55', '2019-05-22 06:56:55'),
(12, 2, 'Water falls are so satisfying.\n#waterFall #River #Water', '1558508734.jpg', 'YES', 'OPEN', '2019-05-22 07:05:32', '2019-05-22 07:05:32', '2019-05-22 07:05:32'),
(13, 2, 'Is “Little girl”  song written by Harley ??\n#Little #Girl', '1558509228.jpg', 'YES', 'OPEN', '2019-05-22 07:13:46', '2019-05-22 07:13:46', '2019-05-22 07:13:46'),
(14, 6, 'Is Manoj the best UI Dev that has ever lived in India?', '1558517678.jpg', 'NO', 'OPEN', '2019-05-22 00:00:00', '2019-05-22 08:39:26', '2019-05-22 08:39:26'),
(15, 6, 'Are India going to win the cricket World Cup? #ICC #comeonengland #hopeful', '1558514701.jpg', 'YES', 'OPEN', '2019-05-22 08:44:57', '2019-05-22 08:44:57', '2019-05-22 08:44:57'),
(17, 10, 'Is ionic used for progressive web apps?? #ioinic #angular #web #apps #progressive #webapps', '1558955242.png', 'YES', 'OPEN', '2019-05-23 06:29:44', '2019-05-23 06:29:44', '2019-05-23 06:29:44'),
(18, 10, 'Who is the winner of 2019 election??\n#india #elections #2019', '1558689383.jpg', 'YES', 'OPEN', '2019-05-24 09:16:20', '2019-05-24 09:16:20', '2019-05-24 09:16:20'),
(19, 6, 'This is a check of the points back end. Will this Poll reduce/cost my total by 10 points?', '', 'NO', 'OPEN', '2019-05-24 20:16:25', '2019-05-24 20:16:25', '2019-05-24 20:16:25'),
(20, 11, 'Is The King’s Arms as good pub?', '1558783416.jpg', 'YES', 'OPEN', '2019-05-25 11:22:10', '2019-05-25 11:22:10', '2019-05-25 11:22:10'),
(21, 11, 'Where should I get my nails done near UCL arts faculty?', '1558783588.jpg', 'YES', 'OPEN', '2019-05-25 11:26:24', '2019-05-25 11:26:24', '2019-05-25 11:26:24'),
(22, 6, 'Polling test', '', 'NO', 'OPEN', '2019-05-27 08:19:45', '2019-05-27 08:19:45', '2019-05-27 08:19:45'),
(23, 6, 'Polling test 2', '', 'NO', 'OPEN', '2019-05-27 08:20:28', '2019-05-27 08:20:28', '2019-05-27 08:20:28'),
(24, 6, 'Polling test 2', '', 'NO', 'OPEN', '2019-05-27 08:21:08', '2019-05-27 08:21:08', '2019-05-27 08:21:08'),
(25, 6, 'Poll test 3', '1559037632.jpg', 'NO', 'OPEN', '2019-05-27 08:24:45', '2019-05-27 08:24:45', '2019-05-27 08:24:45'),
(26, 2, 'Poll share testing 1', '1559539127.jpg', 'YES', 'OPEN', '2019-06-03 05:18:44', '2019-06-03 05:18:44', '2019-06-03 05:18:44');

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
(1, 1, 0, 'OPEN', '2019-05-21 16:26:44', '2019-05-21 16:26:44'),
(3, 3, 0, 'OPEN', '2019-05-21 16:34:06', '2019-05-21 16:34:06'),
(4, 4, 0, 'OPEN', '2019-05-21 16:38:24', '2019-05-21 16:38:24'),
(5, 5, 0, 'OPEN', '2019-05-21 16:43:32', '2019-05-21 16:43:32'),
(6, 6, 0, 'OPEN', '2019-05-21 16:49:09', '2019-05-21 16:49:09'),
(7, 7, 0, 'OPEN', '2019-05-21 16:54:27', '2019-05-21 16:54:27'),
(8, 8, 0, 'OPEN', '2019-05-21 16:55:58', '2019-05-21 16:55:58'),
(9, 9, 0, 'OPEN', '2019-05-21 17:14:04', '2019-05-21 17:14:04'),
(10, 10, 0, 'OPEN', '2019-05-21 17:17:09', '2019-05-21 17:17:09'),
(11, 11, 0, 'OPEN', '2019-05-22 06:56:55', '2019-05-22 06:56:55'),
(12, 12, 0, 'OPEN', '2019-05-22 07:05:32', '2019-05-22 07:05:32'),
(13, 13, 0, 'OPEN', '2019-05-22 07:13:46', '2019-05-22 07:13:46'),
(15, 15, 0, 'OPEN', '2019-05-22 08:44:57', '2019-05-22 08:44:57'),
(19, 18, 0, 'OPEN', '2019-05-24 09:16:21', '2019-05-24 09:16:21'),
(20, 19, 0, 'OPEN', '2019-05-24 20:16:25', '2019-05-24 20:16:25'),
(22, 21, 0, 'OPEN', '2019-05-25 11:26:24', '2019-05-25 11:26:24'),
(23, 22, 0, 'OPEN', '2019-05-27 08:19:45', '2019-05-27 08:19:45'),
(24, 23, 0, 'OPEN', '2019-05-27 08:20:28', '2019-05-27 08:20:28'),
(25, 24, 0, 'OPEN', '2019-05-27 08:21:08', '2019-05-27 08:21:08'),
(33, 17, 0, 'OPEN', '2019-05-27 11:07:25', '2019-05-27 11:07:25'),
(34, 2, 0, 'OPEN', '2019-05-30 12:45:15', '2019-05-30 12:45:15'),
(35, 25, 0, 'OPEN', '2019-05-30 12:45:25', '2019-05-30 12:45:25'),
(36, 26, 0, 'OPEN', '2019-06-03 05:18:44', '2019-06-03 05:18:44');

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
(1, 1, 3, 0, 'Yes India is an incredible country', 'OPEN', '2019-05-21 16:30:20', '2019-05-21 16:30:20'),
(2, 6, 5, 0, 'Yes they are', 'OPEN', '2019-05-22 06:09:47', '2019-05-22 06:09:47'),
(3, 6, 5, 0, 'They eats same', 'OPEN', '2019-05-22 06:10:48', '2019-05-22 06:10:48'),
(4, 6, 5, 0, 'Lions Lives in jungle', 'OPEN', '2019-05-22 06:11:05', '2019-05-22 06:11:05'),
(5, 11, 3, 0, 'Alan Walker', 'OPEN', '2019-05-22 07:02:03', '2019-05-22 07:02:03'),
(6, 11, 3, 0, 'Bohemia', 'OPEN', '2019-05-22 07:02:19', '2019-05-22 07:02:19'),
(7, 13, 3, 0, 'I don’t know who is Harley!!! 🧐', 'OPEN', '2019-05-22 07:26:29', '2019-05-22 07:26:29'),
(8, 14, 3, 0, 'Hey nick, you can tell the best answer..!!', 'OPEN', '2019-05-22 08:48:18', '2019-05-22 08:48:18'),
(9, 3, 6, 0, 'MAC OS is overrated. Too much design and not enough Functionally. And sometimes the design gets in the way too.', 'OPEN', '2019-05-22 09:25:29', '2019-05-22 09:25:29'),
(10, 3, 6, 0, 'What happens if I write another comment. Will it slot in below my other comment - let’s try it and see', 'OPEN', '2019-05-22 09:26:50', '2019-05-22 09:26:50'),
(11, 3, 6, 0, 'That’s works really well.', 'OPEN', '2019-05-22 09:27:28', '2019-05-22 09:27:28'),
(12, 17, 3, 0, 'yes with ionic 4 you can do it more easily.', 'OPEN', '2019-05-23 08:41:27', '2019-05-23 08:41:27'),
(13, 17, 3, 0, 'Ionic 4 is for everyone.', 'OPEN', '2019-05-23 08:49:54', '2019-05-23 08:49:54'),
(14, 17, 2, 0, 'I dont have much knowledge to tell', 'OPEN', '2019-05-23 09:05:38', '2019-05-23 09:05:38'),
(15, 17, 3, 0, 'Ionic can be used with angular, vue etc', 'OPEN', '2019-05-23 09:39:05', '2019-05-23 09:39:05'),
(16, 17, 3, 0, 'Ionic can access native hardware of devices.', 'OPEN', '2019-05-23 09:39:55', '2019-05-23 09:39:55'),
(17, 17, 3, 0, 'Ionic dependencies are difficult to install on linux OS.', 'OPEN', '2019-05-23 09:42:22', '2019-05-23 09:42:22'),
(19, 17, 3, 0, 'Built on standard web technology, Ionic helps teams build and ship beautiful cross-platform hybrid and Progressive Web Apps with ease.', 'OPEN', '2019-05-23 09:52:30', '2019-05-23 09:52:30'),
(20, 17, 3, 0, 'From open source to premium services, Ionic makes app creation lightning fast.', 'OPEN', '2019-05-23 09:54:45', '2019-05-23 09:54:45'),
(27, 18, 2, 0, 'Modi is the winner 🥳', 'OPEN', '2019-05-24 09:17:13', '2019-05-24 09:17:13'),
(28, 18, 2, 0, 'Yeah...we are waiting for that day ......BJP now become the largest party in the world', 'OPEN', '2019-05-24 10:34:24', '2019-05-24 10:34:24'),
(29, 18, 6, 0, 'Is Modi a good politician though. I’m not sure. What if I write a long comment like this- will it ruin Manoj’s carefully built UI? Let’s see...', 'OPEN', '2019-05-24 21:10:50', '2019-05-24 21:10:50'),
(30, 21, 2, 0, 'I don’t have much knowledge about your area!!', 'OPEN', '2019-05-27 04:51:16', '2019-05-27 04:51:16'),
(31, 21, 2, 0, 'O2 is best saloon in our area', 'OPEN', '2019-05-27 04:52:19', '2019-05-27 04:52:19');

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
(1, 1, 1, 3, 'YES', 'OPEN', '2019-05-22 05:10:57', '2019-05-22 05:10:57'),
(2, 11, 6, 6, 'NO', 'OPEN', '2019-05-22 08:00:48', '2019-05-22 08:00:48'),
(4, 1, 1, 6, 'YES', 'OPEN', '2019-05-22 08:03:24', '2019-05-22 08:03:24'),
(6, 14, 8, 6, 'NO', 'OPEN', '2019-05-22 08:49:46', '2019-05-22 08:49:46'),
(21, 18, 27, 2, 'NO', 'OPEN', '2019-05-24 10:46:04', '2019-05-24 10:46:04'),
(48, 21, 31, 2, 'NO', 'OPEN', '2019-05-27 04:52:48', '2019-05-27 04:52:48'),
(53, 21, 30, 2, 'YES', 'OPEN', '2019-05-27 07:09:18', '2019-05-27 07:09:18'),
(80, 2, 1, 10, 'YES', 'OPEN', '2019-05-31 11:26:42', '2019-05-31 11:26:42');

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
(1, 1, 0, 'OPEN', '2019-05-21 16:26:44', '2019-05-21 16:26:44'),
(3, 3, 0, 'OPEN', '2019-05-21 16:34:06', '2019-05-21 16:34:06'),
(4, 4, 0, 'OPEN', '2019-05-21 16:38:24', '2019-05-21 16:38:24'),
(5, 5, 0, 'OPEN', '2019-05-21 16:43:32', '2019-05-21 16:43:32'),
(6, 6, 0, 'OPEN', '2019-05-21 16:49:09', '2019-05-21 16:49:09'),
(7, 7, 0, 'OPEN', '2019-05-21 16:54:27', '2019-05-21 16:54:27'),
(8, 8, 0, 'OPEN', '2019-05-21 16:55:58', '2019-05-21 16:55:58'),
(9, 9, 0, 'OPEN', '2019-05-21 17:14:04', '2019-05-21 17:14:04'),
(10, 10, 0, 'OPEN', '2019-05-21 17:17:09', '2019-05-21 17:17:09'),
(11, 11, 0, 'OPEN', '2019-05-22 06:56:55', '2019-05-22 06:56:55'),
(12, 12, 0, 'OPEN', '2019-05-22 07:05:32', '2019-05-22 07:05:32'),
(13, 13, 0, 'OPEN', '2019-05-22 07:13:46', '2019-05-22 07:13:46'),
(18, 15, 0, 'OPEN', '2019-05-22 08:44:57', '2019-05-22 08:44:57'),
(23, 14, 2, 'OPEN', '2019-05-22 09:34:37', '2019-05-22 09:34:37'),
(24, 14, 4, 'OPEN', '2019-05-22 09:34:37', '2019-05-22 09:34:37'),
(25, 14, 3, 'OPEN', '2019-05-22 09:34:37', '2019-05-22 09:34:37'),
(26, 14, 1, 'OPEN', '2019-05-22 09:34:37', '2019-05-22 09:34:37'),
(30, 18, 0, 'OPEN', '2019-05-24 09:16:20', '2019-05-24 09:16:20'),
(31, 19, 0, 'OPEN', '2019-05-24 20:16:25', '2019-05-24 20:16:25'),
(33, 21, 0, 'OPEN', '2019-05-25 11:26:24', '2019-05-25 11:26:24'),
(34, 22, 1, 'OPEN', '2019-05-27 08:19:45', '2019-05-27 08:19:45'),
(35, 22, 2, 'OPEN', '2019-05-27 08:19:45', '2019-05-27 08:19:45'),
(36, 22, 4, 'OPEN', '2019-05-27 08:19:45', '2019-05-27 08:19:45'),
(37, 22, 3, 'OPEN', '2019-05-27 08:19:45', '2019-05-27 08:19:45'),
(38, 23, 1, 'OPEN', '2019-05-27 08:20:28', '2019-05-27 08:20:28'),
(39, 23, 2, 'OPEN', '2019-05-27 08:20:28', '2019-05-27 08:20:28'),
(40, 23, 4, 'OPEN', '2019-05-27 08:20:28', '2019-05-27 08:20:28'),
(41, 23, 3, 'OPEN', '2019-05-27 08:20:28', '2019-05-27 08:20:28'),
(42, 24, 1, 'OPEN', '2019-05-27 08:21:08', '2019-05-27 08:21:08'),
(43, 24, 2, 'OPEN', '2019-05-27 08:21:08', '2019-05-27 08:21:08'),
(44, 24, 4, 'OPEN', '2019-05-27 08:21:08', '2019-05-27 08:21:08'),
(45, 24, 3, 'OPEN', '2019-05-27 08:21:08', '2019-05-27 08:21:08'),
(56, 17, 0, 'OPEN', '2019-05-27 11:07:25', '2019-05-27 11:07:25'),
(57, 2, 0, 'OPEN', '2019-05-30 12:45:15', '2019-05-30 12:45:15'),
(58, 25, 1, 'OPEN', '2019-05-30 12:45:25', '2019-05-30 12:45:25'),
(59, 25, 2, 'OPEN', '2019-05-30 12:45:25', '2019-05-30 12:45:25'),
(60, 25, 4, 'OPEN', '2019-05-30 12:45:25', '2019-05-30 12:45:25'),
(61, 25, 3, 'OPEN', '2019-05-30 12:45:25', '2019-05-30 12:45:25'),
(62, 26, 0, 'OPEN', '2019-06-03 05:18:44', '2019-06-03 05:18:44');

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
(1, 1, '0', 'OPEN', '2019-05-21 16:26:44', '2019-05-21 16:26:44'),
(3, 3, '0', 'OPEN', '2019-05-21 16:34:06', '2019-05-21 16:34:06'),
(4, 4, '0', 'OPEN', '2019-05-21 16:38:24', '2019-05-21 16:38:24'),
(5, 5, '0', 'OPEN', '2019-05-21 16:43:31', '2019-05-21 16:43:31'),
(6, 6, '0', 'OPEN', '2019-05-21 16:49:09', '2019-05-21 16:49:09'),
(7, 7, '0', 'OPEN', '2019-05-21 16:54:27', '2019-05-21 16:54:27'),
(8, 8, '0', 'OPEN', '2019-05-21 16:55:58', '2019-05-21 16:55:58'),
(9, 9, '0', 'OPEN', '2019-05-21 17:14:04', '2019-05-21 17:14:04'),
(10, 10, '0', 'OPEN', '2019-05-21 17:17:09', '2019-05-21 17:17:09'),
(11, 11, '0', 'OPEN', '2019-05-22 06:56:55', '2019-05-22 06:56:55'),
(12, 12, '0', 'OPEN', '2019-05-22 07:05:32', '2019-05-22 07:05:32'),
(13, 13, '0', 'OPEN', '2019-05-22 07:13:46', '2019-05-22 07:13:46'),
(15, 15, '0', 'OPEN', '2019-05-22 08:44:57', '2019-05-22 08:44:57'),
(17, 14, '0', 'OPEN', '2019-05-22 09:34:37', '2019-05-22 09:34:37'),
(21, 18, '0', 'OPEN', '2019-05-24 09:16:20', '2019-05-24 09:16:20'),
(22, 19, '0', 'OPEN', '2019-05-24 20:16:25', '2019-05-24 20:16:25'),
(24, 20, '0', 'OPEN', '2019-05-25 11:23:35', '2019-05-25 11:23:35'),
(25, 21, 'FEMALE', 'OPEN', '2019-05-25 11:26:24', '2019-05-25 11:26:24'),
(26, 22, '0', 'OPEN', '2019-05-27 08:19:45', '2019-05-27 08:19:45'),
(27, 23, '0', 'OPEN', '2019-05-27 08:20:28', '2019-05-27 08:20:28'),
(28, 24, '0', 'OPEN', '2019-05-27 08:21:08', '2019-05-27 08:21:08'),
(36, 17, '0', 'OPEN', '2019-05-27 11:07:25', '2019-05-27 11:07:25'),
(37, 2, '0', 'OPEN', '2019-05-30 12:45:15', '2019-05-30 12:45:15'),
(38, 25, '0', 'OPEN', '2019-05-30 12:45:25', '2019-05-30 12:45:25'),
(39, 26, '0', 'OPEN', '2019-06-03 05:18:44', '2019-06-03 05:18:44');

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
(1, 1, 0, 'OPEN', '2019-05-21 16:26:44', '2019-05-21 16:26:44'),
(3, 3, 0, 'OPEN', '2019-05-21 16:34:06', '2019-05-21 16:34:06'),
(4, 4, 0, 'OPEN', '2019-05-21 16:38:24', '2019-05-21 16:38:24'),
(5, 5, 0, 'OPEN', '2019-05-21 16:43:31', '2019-05-21 16:43:31'),
(6, 6, 0, 'OPEN', '2019-05-21 16:49:09', '2019-05-21 16:49:09'),
(7, 7, 0, 'OPEN', '2019-05-21 16:54:27', '2019-05-21 16:54:27'),
(8, 8, 0, 'OPEN', '2019-05-21 16:55:58', '2019-05-21 16:55:58'),
(9, 9, 0, 'OPEN', '2019-05-21 17:14:04', '2019-05-21 17:14:04'),
(10, 10, 0, 'OPEN', '2019-05-21 17:17:09', '2019-05-21 17:17:09'),
(11, 11, 0, 'OPEN', '2019-05-22 06:56:55', '2019-05-22 06:56:55'),
(12, 12, 0, 'OPEN', '2019-05-22 07:05:32', '2019-05-22 07:05:32'),
(13, 13, 0, 'OPEN', '2019-05-22 07:13:46', '2019-05-22 07:13:46'),
(15, 15, 0, 'OPEN', '2019-05-22 08:44:57', '2019-05-22 08:44:57'),
(19, 18, 0, 'OPEN', '2019-05-24 09:16:20', '2019-05-24 09:16:20'),
(20, 19, 0, 'OPEN', '2019-05-24 20:16:25', '2019-05-24 20:16:25'),
(22, 21, 0, 'OPEN', '2019-05-25 11:26:24', '2019-05-25 11:26:24'),
(23, 22, 0, 'OPEN', '2019-05-27 08:19:45', '2019-05-27 08:19:45'),
(24, 23, 0, 'OPEN', '2019-05-27 08:20:28', '2019-05-27 08:20:28'),
(25, 24, 0, 'OPEN', '2019-05-27 08:21:08', '2019-05-27 08:21:08'),
(33, 17, 0, 'OPEN', '2019-05-27 11:07:25', '2019-05-27 11:07:25'),
(34, 2, 0, 'OPEN', '2019-05-30 12:45:15', '2019-05-30 12:45:15'),
(35, 25, 0, 'OPEN', '2019-05-30 12:45:25', '2019-05-30 12:45:25'),
(36, 26, 0, 'OPEN', '2019-06-03 05:18:44', '2019-06-03 05:18:44');

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
(1, 17, 3, 'YES', 'OPEN', '2019-05-23 10:16:30', '2019-05-23 10:16:30'),
(2, 18, 6, 'NO', 'OPEN', '2019-05-24 20:18:25', '2019-05-24 20:18:25'),
(3, 19, 11, 'YES', 'OPEN', '2019-05-25 11:23:14', '2019-05-25 11:23:14'),
(4, 21, 2, 'YES', 'OPEN', '2019-05-26 15:38:01', '2019-05-26 15:38:01'),
(5, 24, 2, 'YES', 'OPEN', '2019-05-27 09:42:44', '2019-05-27 09:42:44');

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
(1, 1, 0, 'OPEN', '2019-05-21 16:26:44', '2019-05-21 16:26:44'),
(3, 3, 0, 'OPEN', '2019-05-21 16:34:06', '2019-05-21 16:34:06'),
(4, 4, 0, 'OPEN', '2019-05-21 16:38:24', '2019-05-21 16:38:24'),
(5, 5, 0, 'OPEN', '2019-05-21 16:43:32', '2019-05-21 16:43:32'),
(6, 6, 0, 'OPEN', '2019-05-21 16:49:09', '2019-05-21 16:49:09'),
(7, 7, 0, 'OPEN', '2019-05-21 16:54:27', '2019-05-21 16:54:27'),
(8, 8, 0, 'OPEN', '2019-05-21 16:55:58', '2019-05-21 16:55:58'),
(9, 9, 0, 'OPEN', '2019-05-21 17:14:04', '2019-05-21 17:14:04'),
(10, 10, 0, 'OPEN', '2019-05-21 17:17:09', '2019-05-21 17:17:09'),
(11, 11, 0, 'OPEN', '2019-05-22 06:56:55', '2019-05-22 06:56:55'),
(12, 12, 0, 'OPEN', '2019-05-22 07:05:32', '2019-05-22 07:05:32'),
(13, 13, 0, 'OPEN', '2019-05-22 07:13:46', '2019-05-22 07:13:46'),
(15, 15, 0, 'OPEN', '2019-05-22 08:44:57', '2019-05-22 08:44:57'),
(19, 18, 0, 'OPEN', '2019-05-24 09:16:20', '2019-05-24 09:16:20'),
(20, 19, 0, 'OPEN', '2019-05-24 20:16:25', '2019-05-24 20:16:25'),
(22, 21, 0, 'OPEN', '2019-05-25 11:26:24', '2019-05-25 11:26:24'),
(23, 22, 0, 'OPEN', '2019-05-27 08:19:45', '2019-05-27 08:19:45'),
(24, 23, 0, 'OPEN', '2019-05-27 08:20:28', '2019-05-27 08:20:28'),
(25, 24, 0, 'OPEN', '2019-05-27 08:21:08', '2019-05-27 08:21:08'),
(33, 17, 0, 'OPEN', '2019-05-27 11:07:25', '2019-05-27 11:07:25'),
(34, 2, 0, 'OPEN', '2019-05-30 12:45:15', '2019-05-30 12:45:15'),
(35, 25, 0, 'OPEN', '2019-05-30 12:45:25', '2019-05-30 12:45:25'),
(36, 26, 0, 'OPEN', '2019-06-03 05:18:44', '2019-06-03 05:18:44');

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
(49, 4, 2, 'OPEN', '2019-05-21 17:07:19', '2019-05-21 17:07:19'),
(50, 4, 3, 'OPEN', '2019-05-21 17:07:19', '2019-05-21 17:07:19'),
(51, 4, 1, 'OPEN', '2019-05-21 17:07:19', '2019-05-21 17:07:19'),
(68, 5, 1, 'OPEN', '2019-05-22 06:11:59', '2019-05-22 06:11:59'),
(69, 5, 2, 'OPEN', '2019-05-22 06:11:59', '2019-05-22 06:11:59'),
(70, 5, 3, 'OPEN', '2019-05-22 06:11:59', '2019-05-22 06:11:59'),
(79, 3, 2, 'OPEN', '2019-05-22 08:46:50', '2019-05-22 08:46:50'),
(80, 3, 1, 'OPEN', '2019-05-22 08:46:50', '2019-05-22 08:46:50'),
(91, 8, 1, 'OPEN', '2019-05-23 06:39:36', '2019-05-23 06:39:36'),
(94, 9, 5, 'OPEN', '2019-05-23 06:49:07', '2019-05-23 06:49:07'),
(133, 10, 2, 'OPEN', '2019-05-25 01:11:04', '2019-05-25 01:11:04'),
(142, 11, 230, 'OPEN', '2019-05-25 11:30:03', '2019-05-25 11:30:03'),
(163, 6, 230, 'OPEN', '2019-05-29 10:26:02', '2019-05-29 10:26:02'),
(164, 12, 1, 'OPEN', '2019-05-30 05:54:39', '2019-05-30 05:54:39'),
(167, 2, 2, 'OPEN', '2019-06-03 09:07:40', '2019-06-03 09:07:40'),
(168, 2, 1, 'OPEN', '2019-06-03 09:07:40', '2019-06-03 09:07:40');

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
(109, 4, 4, 'OPEN', '2019-05-21 17:07:19', '2019-05-21 17:07:19'),
(110, 4, 29, 'OPEN', '2019-05-21 17:07:19', '2019-05-21 17:07:19'),
(111, 4, 32, 'OPEN', '2019-05-21 17:07:19', '2019-05-21 17:07:19'),
(134, 5, 24, 'OPEN', '2019-05-22 06:11:59', '2019-05-22 06:11:59'),
(135, 5, 3, 'OPEN', '2019-05-22 06:11:59', '2019-05-22 06:11:59'),
(136, 5, 27, 'OPEN', '2019-05-22 06:11:59', '2019-05-22 06:11:59'),
(179, 3, 16, 'OPEN', '2019-05-22 08:46:50', '2019-05-22 08:46:50'),
(180, 3, 2, 'OPEN', '2019-05-22 08:46:50', '2019-05-22 08:46:50'),
(181, 3, 20, 'OPEN', '2019-05-22 08:46:50', '2019-05-22 08:46:50'),
(182, 3, 19, 'OPEN', '2019-05-22 08:46:50', '2019-05-22 08:46:50'),
(183, 3, 15, 'OPEN', '2019-05-22 08:46:50', '2019-05-22 08:46:50'),
(227, 8, 7, 'OPEN', '2019-05-23 06:39:36', '2019-05-23 06:39:36'),
(228, 8, 1, 'OPEN', '2019-05-23 06:39:36', '2019-05-23 06:39:36'),
(233, 9, 6, 'OPEN', '2019-05-23 06:49:07', '2019-05-23 06:49:07'),
(234, 9, 1, 'OPEN', '2019-05-23 06:49:07', '2019-05-23 06:49:07'),
(341, 10, 6, 'OPEN', '2019-05-25 01:11:04', '2019-05-25 01:11:04'),
(342, 10, 1, 'OPEN', '2019-05-25 01:11:04', '2019-05-25 01:11:04'),
(414, 11, 16, 'OPEN', '2019-05-25 11:30:03', '2019-05-25 11:30:03'),
(415, 11, 8, 'OPEN', '2019-05-25 11:30:03', '2019-05-25 11:30:03'),
(416, 11, 10, 'OPEN', '2019-05-25 11:30:03', '2019-05-25 11:30:03'),
(417, 11, 2, 'OPEN', '2019-05-25 11:30:03', '2019-05-25 11:30:03'),
(418, 11, 4, 'OPEN', '2019-05-25 11:30:03', '2019-05-25 11:30:03'),
(419, 11, 25, 'OPEN', '2019-05-25 11:30:03', '2019-05-25 11:30:03'),
(420, 11, 1, 'OPEN', '2019-05-25 11:30:03', '2019-05-25 11:30:03'),
(421, 11, 32, 'OPEN', '2019-05-25 11:30:03', '2019-05-25 11:30:03'),
(422, 11, 3, 'OPEN', '2019-05-25 11:30:03', '2019-05-25 11:30:03'),
(471, 6, 14, 'OPEN', '2019-05-29 10:26:02', '2019-05-29 10:26:02'),
(472, 6, 18, 'OPEN', '2019-05-29 10:26:02', '2019-05-29 10:26:02'),
(473, 6, 3, 'OPEN', '2019-05-29 10:26:02', '2019-05-29 10:26:02'),
(474, 6, 1, 'OPEN', '2019-05-29 10:26:02', '2019-05-29 10:26:02'),
(475, 6, 9, 'OPEN', '2019-05-29 10:26:02', '2019-05-29 10:26:02'),
(476, 6, 8, 'OPEN', '2019-05-29 10:26:02', '2019-05-29 10:26:02'),
(477, 6, 25, 'OPEN', '2019-05-29 10:26:02', '2019-05-29 10:26:02'),
(478, 6, 2, 'OPEN', '2019-05-29 10:26:02', '2019-05-29 10:26:02'),
(479, 12, 1, 'OPEN', '2019-05-30 05:54:38', '2019-05-30 05:54:38'),
(482, 2, 27, 'OPEN', '2019-06-03 09:07:40', '2019-06-03 09:07:40'),
(483, 2, 3, 'OPEN', '2019-06-03 09:07:40', '2019-06-03 09:07:40');

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
(1, 2, 'IPHONE', 'euBoIumUt5s:APA91bGgOQA-jSra-qG-9WJ0zbX65X275kYIdufmp2qAKs-qc27QfpjatK9krz9UL8M4_S4jRkrTrERKVt0kmd-5ItfO6DHSweD1UVkRj3upScD-EP1mVdy344nb5ItzILq-HoGfOQIm', 'OPEN', '2019-05-21 16:20:26', '2019-05-21 16:20:26'),
(2, 3, 'IPHONE', 'fRVTS-sT5wM:APA91bE-kK1bsLQAIa1WfE7mlU70e3nXVghorhY664s-FkruM9I2HYJoAKTfCHNVgO8ubzLORQeNqouTYzFtqw7veNp-nVFZkb8vuIl1JYqUoDAiNanAGvgxUVcP4k5yi309zBT5Oter', 'OPEN', '2019-05-21 16:27:07', '2019-05-21 16:27:07'),
(3, 1, 'WEB', 'c_5kFbmN83w:APA91bE7HjPUKtGTPsfW9YnErlvMwlqDwDFkrW9t4GqZVglv2-t9_pW_oXjUx3-Su19rcgR4F-_ohqZTPz3vjvwww64UgAGvsMzxlKW1ilWv9jOyvzT2tCcavm1V98CjEuMxgfi4wL-W', 'OPEN', '2019-05-21 16:58:42', '2019-05-21 16:58:42'),
(4, 4, 'IPHONE', 'deoENJ0fyKc:APA91bH9tXg4yKmzcZNuc7aPRgxWrGUnTuESHA2k-7SvVhXEnnlg4C_sZWayeAufT4yHrG87JFN0MxVnyrgvnnIK7CdhE35jTYNSK3LylEzKPjQjgRI7bLHqPABidvmfalhNS9lrwT8S', 'OPEN', '2019-05-21 17:07:20', '2019-05-21 17:07:20'),
(5, 5, 'IPHONE', 'cdWgQKdHeSw:APA91bG6pCYnefcp1rKJmIB-0pPLvBj1mWXe_CiWSLh0Kw9Yk6lLkBCOoZ_pzMfudM8rPwzg5va_U-fXBM40jrhgcK-6CYkRhZ4bx7Ymy2nql3C4jZnbct_TvVPGZc-raZSMFA3cxYl2', 'OPEN', '2019-05-22 06:08:33', '2019-05-22 06:08:33'),
(6, 6, 'IPHONE', 'ccTtMlLsla8:APA91bEYWPesP2C69mMtDX1gFgxndCK1dai1Nl3hZ300nFIdMXnWgjBcYvMiRzkCUVEE39ZBMGwIWIBdzAKE5z6rwqwZU634VoJCJ0upCrOL4Yz3GvRFUFetpMEpcNHC0dH6WdPIH1Hr', 'OPEN', '2019-05-22 07:54:53', '2019-05-22 07:54:53'),
(7, 9, 'IPHONE', 'eA8OnfwqO_k:APA91bHcfmt5k4C-kfvezXIdJYK2QDsEkzNJtH1XkGp-sDkSb1U_EZHcXR1rJ7qF0bFs-jIR3MzVan9Io_2oqjq8jNWElmeUKJiLGLkuMdcRjps4KslVxqnHe6UI0UcsY7USED3ZvRFz', 'OPEN', '2019-05-23 06:41:48', '2019-05-23 06:41:48'),
(8, 10, 'IPHONE', 'cmEdQiv0eQw:APA91bH4bauS9YN78Xg00xmsad_86GBG18LUeDQypKMzCo6vl2rVU2yAfYYFsIrQicgaMmpFIsD25tUm-ZYkZxr32glwC0ty06zCXivOLRgyErvqOUUq3qQGs7Vi8XDXyOXdYxCPn0Vm', 'OPEN', '2019-05-23 06:55:51', '2019-05-23 06:55:51');

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
(1, 2, 0, 'SIGNUP', 'CREDIT', 500, 'OPEN', '2019-05-21 16:20:26', '2019-05-21 16:20:26'),
(2, 2, 1, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-21 16:26:44', '2019-05-21 16:26:44'),
(3, 3, 0, 'SIGNUP', 'CREDIT', 500, 'OPEN', '2019-05-21 16:27:07', '2019-05-21 16:27:07'),
(4, 3, 2, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-21 16:29:19', '2019-05-21 16:29:19'),
(5, 3, 1, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-21 16:29:44', '2019-05-21 16:29:44'),
(6, 3, 3, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-21 16:34:06', '2019-05-21 16:34:06'),
(7, 3, 4, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-21 16:38:24', '2019-05-21 16:38:24'),
(8, 3, 5, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-21 16:43:32', '2019-05-21 16:43:32'),
(9, 2, 6, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-21 16:49:09', '2019-05-21 16:49:09'),
(10, 3, 7, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-21 16:54:27', '2019-05-21 16:54:27'),
(11, 3, 6, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-21 16:54:53', '2019-05-21 16:54:53'),
(12, 3, 8, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-21 16:55:58', '2019-05-21 16:55:58'),
(13, 4, 0, 'SIGNUP', 'CREDIT', 500, 'OPEN', '2019-05-21 17:07:20', '2019-05-21 17:07:20'),
(14, 3, 9, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-21 17:14:04', '2019-05-21 17:14:04'),
(15, 3, 10, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-21 17:17:09', '2019-05-21 17:17:09'),
(16, 5, 0, 'SIGNUP', 'CREDIT', 500, 'OPEN', '2019-05-22 06:08:33', '2019-05-22 06:08:33'),
(17, 5, 5, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-22 06:09:30', '2019-05-22 06:09:30'),
(18, 5, 6, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-22 06:11:15', '2019-05-22 06:11:15'),
(19, 5, 11, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-22 06:56:55', '2019-05-22 06:56:55'),
(20, 2, 12, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-22 07:05:32', '2019-05-22 07:05:32'),
(21, 2, 13, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-22 07:13:46', '2019-05-22 07:13:46'),
(22, 6, 0, 'SIGNUP', 'CREDIT', 500, 'OPEN', '2019-05-22 07:54:53', '2019-05-22 07:54:53'),
(23, 6, 13, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-22 07:59:11', '2019-05-22 07:59:11'),
(24, 6, 12, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-22 07:59:19', '2019-05-22 07:59:19'),
(25, 6, 4, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-22 08:01:55', '2019-05-22 08:01:55'),
(26, 6, 3, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-22 08:01:59', '2019-05-22 08:01:59'),
(27, 6, 2, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-22 08:02:06', '2019-05-22 08:02:06'),
(28, 6, 1, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-22 08:02:11', '2019-05-22 08:02:11'),
(29, 6, 14, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-22 08:39:26', '2019-05-22 08:39:26'),
(30, 6, 15, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-22 08:44:57', '2019-05-22 08:44:57'),
(31, 6, 11, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-22 08:58:36', '2019-05-22 08:58:36'),
(32, 6, 10, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-22 08:58:42', '2019-05-22 08:58:42'),
(33, 6, 5, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-22 08:58:48', '2019-05-22 08:58:48'),
(34, 6, 6, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-22 08:58:56', '2019-05-22 08:58:56'),
(35, 6, 7, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-22 08:58:59', '2019-05-22 08:58:59'),
(36, 6, 8, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-22 08:59:04', '2019-05-22 08:59:04'),
(38, 3, 16, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-23 05:59:01', '2019-05-23 05:59:01'),
(39, 3, 15, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 06:05:23', '2019-05-23 06:05:23'),
(40, 3, 13, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 06:05:53', '2019-05-23 06:05:53'),
(41, 3, 12, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 06:06:00', '2019-05-23 06:06:00'),
(42, 3, 11, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 06:06:06', '2019-05-23 06:06:06'),
(43, 3, 15, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 06:14:37', '2019-05-23 06:14:37'),
(44, 8, 0, 'SIGNUP', 'CREDIT', 500, 'OPEN', '2019-05-23 06:27:08', '2019-05-23 06:27:08'),
(45, 8, 17, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-23 06:29:44', '2019-05-23 06:29:44'),
(46, 3, 17, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 06:31:09', '2019-05-23 06:31:09'),
(47, 9, 0, 'SIGNUP', 'CREDIT', 500, 'OPEN', '2019-05-23 06:41:10', '2019-05-23 06:41:10'),
(48, 10, 0, 'SIGNUP', 'CREDIT', 500, 'OPEN', '2019-05-23 06:54:22', '2019-05-23 06:54:22'),
(49, 3, 17, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 07:08:40', '2019-05-23 07:08:40'),
(50, 3, 17, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 07:15:34', '2019-05-23 07:15:34'),
(51, 3, 17, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 07:21:28', '2019-05-23 07:21:28'),
(52, 3, 17, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 07:22:16', '2019-05-23 07:22:16'),
(53, 3, 17, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 07:22:55', '2019-05-23 07:22:55'),
(54, 3, 17, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 07:27:30', '2019-05-23 07:27:30'),
(55, 3, 17, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 08:32:37', '2019-05-23 08:32:37'),
(56, 3, 17, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 08:34:32', '2019-05-23 08:34:32'),
(57, 3, 17, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 08:39:38', '2019-05-23 08:39:38'),
(58, 2, 17, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 09:05:49', '2019-05-23 09:05:49'),
(59, 2, 17, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 09:19:37', '2019-05-23 09:19:37'),
(60, 3, 17, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-23 10:16:30', '2019-05-23 10:16:30'),
(61, 10, 18, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-24 09:16:21', '2019-05-24 09:16:21'),
(62, 6, 19, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-24 20:16:25', '2019-05-24 20:16:25'),
(63, 6, 18, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-24 20:18:25', '2019-05-24 20:18:25'),
(64, 11, 0, 'SIGNUP', 'CREDIT', 500, 'OPEN', '2019-05-25 11:21:01', '2019-05-25 11:21:01'),
(65, 11, 20, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-25 11:22:10', '2019-05-25 11:22:10'),
(66, 11, 19, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-25 11:23:14', '2019-05-25 11:23:14'),
(67, 11, 21, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-25 11:26:24', '2019-05-25 11:26:24'),
(68, 2, 21, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-26 15:38:01', '2019-05-26 15:38:01'),
(69, 6, 22, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-27 08:19:45', '2019-05-27 08:19:45'),
(70, 6, 23, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-27 08:20:28', '2019-05-27 08:20:28'),
(71, 6, 24, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-27 08:21:08', '2019-05-27 08:21:08'),
(72, 6, 25, 'POLLCREATED', 'DEBIT', 1, 'OPEN', '2019-05-27 08:24:45', '2019-05-27 08:24:45'),
(73, 2, 24, 'POLLVOTED', 'CREDIT', 1, 'OPEN', '2019-05-27 09:42:44', '2019-05-27 09:42:44'),
(74, 12, 0, 'SIGNUP', 'CREDIT', 500, 'OPEN', '2019-05-30 05:54:39', '2019-05-30 05:54:39'),
(75, 2, 26, 'POLLCREATED', 'DEBIT', 10, 'OPEN', '2019-06-03 05:18:44', '2019-06-03 05:18:44');

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
(1, 'bawa_d', 'bawa_d@ymail.com', '$2y$10$aGfU9AjwlEyfhgAHOTaG4.RKbJIMwDAhdLP95qQ6XZopCzmuZ3ukG', NULL, 'MALE', 4, 1, 'OPEN', '2019-04-16 08:45:46', '2019-04-16 08:45:46'),
(2, 'Manoj', 'manoj@co.uk', '$2y$10$aGfU9AjwlEyfhgAHOTaG4.RKbJIMwDAhdLP95qQ6XZopCzmuZ3ukG', '1558456037.jpg', 'MALE', 1, 1, 'OPEN', '2019-05-21 16:20:26', '2019-05-21 16:20:26'),
(3, 'deepak', 'deepak@co.uk', '$2y$10$pWjWUK7H1X.zbDiJAjugnebZTsTAlvpZRBRFB0Ct7Ito4hdsqpeYu', '1558954583.jpg', 'MALE', 1, 3, 'OPEN', '2019-05-21 16:27:06', '2019-05-21 16:27:06'),
(4, 'shanti', 'shanti@co.uk', '$2y$10$eQVfuB4kIRSSDaMgFEN8NOgQIaXbw1BhAdrDRmJ4IX/9ukmi6vPaW', '1558592304.jpg', 'MALE', 1, 5, 'OPEN', '2019-05-21 17:07:19', '2019-05-21 17:07:19'),
(5, 'manoj_1', 'manoj_1@co.uk', '$2y$10$Yv3IsTH/QWVbYt4iWfbBSuJKu11GsRodZtK0Hnd2Epwrqh1d9erGu', '1558505419.jpg', 'MALE', 4, 2, 'OPEN', '2019-05-22 06:08:32', '2019-05-22 06:08:32'),
(6, 'Founder1', 'nicholaspowell@co.uk', '$2y$10$Cy6EQyPudF7j3H78R00tgeX46UO/UDUds8FN.y/HHIHzzGigpUeGC', '1558516894.jpg', 'MALE', 1, 3, 'OPEN', '2019-05-22 07:54:52', '2019-05-22 07:54:52'),
(8, 'Rakesh', 'rakesh@co.uk', '$2y$10$beMkPe6WYeRZzysmvZMlW.Jvv37vYmzyesAVMYvE5XCLzYCMdVR2K', NULL, 'MALE', 1, 3, 'OPEN', '2019-05-23 06:27:08', '2019-05-23 06:27:08'),
(9, 'Gaurav', 'gaurav@co.uk', '$2y$10$aENInBCYBKY6eHImxHAqmu469RN/HDiuyFd9akqLYwYOyLm.vCFiq', NULL, 'NEUTRAL', 3, 1, 'OPEN', '2019-05-23 06:41:10', '2019-05-23 06:41:10'),
(10, 'Sonia', 'sonia@co.uk', '$2y$10$af/8JrJ7jF0NxinXbwwXYO1Xq6qdGPwIv92o8.AdT3WItrkS8LTaW', '1558603448.jpg', 'OTHER', 3, 1, 'OPEN', '2019-05-23 06:54:21', '2019-05-23 06:54:21'),
(11, 'rlmaud', 'rlmaud@co.uk', '$2y$10$AuIL8ebM81fUGTsXDid2lurrmxGmZ2eTBvrcWsODxPM/YsPAPSyCi', NULL, 'FEMALE', 2, 1, 'OPEN', '2019-05-25 11:21:01', '2019-05-25 11:21:01'),
(12, 'deepakBawas', 'deepakbawas@ucl.ac.uk', '$2y$10$3J/vQDOC5PsZ3bbsz8qsQOWX8.og3bYU74zlwwvidjyTSOGnEOgQe', NULL, 'MALE', 1, 1, 'OPEN', '2019-05-30 05:54:38', '2019-05-30 05:54:38');

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
(1, 2, '{\"pollVoteReceived\":1,\"pollCommentReceived\":1,\"pollEnded\":1,\"newPollReceived\":1}', 'OPEN', '2019-05-21 16:20:26', '2019-05-21 16:20:26'),
(2, 3, '{\"pollVoteReceived\":1,\"pollEnded\":1,\"newPollReceived\":1,\"pollCommentReceived\":1}', 'OPEN', '2019-05-21 16:27:07', '2019-05-21 16:27:07'),
(3, 4, '{\"newPollReceived\":\"1\",\"pollVoteReceived\":\"1\",\"pollCommentReceived\":\"1\",\"pollEnded\":\"1\"}', 'OPEN', '2019-05-21 17:07:20', '2019-05-21 17:07:20'),
(4, 5, '{\"newPollReceived\":\"1\",\"pollVoteReceived\":\"1\",\"pollCommentReceived\":\"1\",\"pollEnded\":\"1\"}', 'OPEN', '2019-05-22 06:08:33', '2019-05-22 06:08:33'),
(5, 6, '{\"pollEnded\":1,\"newPollReceived\":1,\"pollVoteReceived\":1,\"pollCommentReceived\":1}', 'OPEN', '2019-05-22 07:54:52', '2019-05-22 07:54:52'),
(7, 8, '{\"pollEnded\":1,\"pollVoteReceived\":1,\"pollCommentReceived\":1,\"newPollReceived\":1}', 'OPEN', '2019-05-23 06:27:08', '2019-05-23 06:27:08'),
(8, 9, '{\"newPollReceived\":\"1\",\"pollVoteReceived\":\"1\",\"pollCommentReceived\":\"1\",\"pollEnded\":\"1\"}', 'OPEN', '2019-05-23 06:41:10', '2019-05-23 06:41:10'),
(9, 10, '{\"newPollReceived\":\"1\",\"pollVoteReceived\":\"1\",\"pollCommentReceived\":\"1\",\"pollEnded\":\"1\"}', 'OPEN', '2019-05-23 06:54:22', '2019-05-23 06:54:22'),
(10, 11, '{\"newPollReceived\":\"1\",\"pollVoteReceived\":\"1\",\"pollCommentReceived\":\"1\",\"pollEnded\":\"1\"}', 'OPEN', '2019-05-25 11:21:01', '2019-05-25 11:21:01'),
(11, 12, '{\"newPollReceived\":\"1\",\"pollVoteReceived\":\"1\",\"pollCommentReceived\":\"1\",\"pollEnded\":\"1\"}', 'OPEN', '2019-05-30 05:54:39', '2019-05-30 05:54:39');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `rel_poll_branches`
--
ALTER TABLE `rel_poll_branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `rel_poll_comments`
--
ALTER TABLE `rel_poll_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `rel_poll_comments_likes`
--
ALTER TABLE `rel_poll_comments_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `rel_poll_countries`
--
ALTER TABLE `rel_poll_countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `rel_poll_genders`
--
ALTER TABLE `rel_poll_genders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `rel_poll_groups`
--
ALTER TABLE `rel_poll_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `rel_poll_votes`
--
ALTER TABLE `rel_poll_votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `rel_poll_years`
--
ALTER TABLE `rel_poll_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `rel_user_countries`
--
ALTER TABLE `rel_user_countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;
--
-- AUTO_INCREMENT for table `rel_user_groups`
--
ALTER TABLE `rel_user_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=484;
--
-- AUTO_INCREMENT for table `rel_user_notification_tokens`
--
ALTER TABLE `rel_user_notification_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `rel_user_points`
--
ALTER TABLE `rel_user_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `user_notification_settings`
--
ALTER TABLE `user_notification_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
