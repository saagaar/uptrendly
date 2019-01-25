-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 25, 2019 at 03:08 PM
-- Server version: 5.7.24-0ubuntu0.18.04.1
-- PHP Version: 7.2.14-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uptrendly`
--

-- --------------------------------------------------------

--
-- Table structure for table `emts_admin_permissions`
--

CREATE TABLE `emts_admin_permissions` (
  `permission_id` int(10) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_id` int(10) NOT NULL DEFAULT '0' COMMENT 'parent id',
  `display_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emts_admin_permissions`
--

INSERT INTO `emts_admin_permissions` (`permission_id`, `code`, `name`, `group_id`, `display_order`) VALUES
(1, 'site-setting', 'Site Setting', 0, 0),
(2, 'blockip-setting', 'Block IP Setting', 0, 0),
(3, 'module-cms', 'CMS Module', 0, 0),
(4, 'add-cms', 'Add Cms', 3, 0),
(5, 'edit-cms', 'Edit CMS', 3, 0),
(6, 'delete-cms', 'Delete CMS', 3, 0),
(22, 'email-settings', 'Email Setting', 0, 0),
(23, 'module-product-category', 'Product Category Module', 0, 0),
(24, 'edit-product-category', 'Edit Product Category', 23, 0),
(25, 'delete-product-categories', 'Delete Product Category', 23, 0),
(26, 'view-product-sub-category', 'View Product Sub Category', 23, 0),
(27, 'add-product-sub-category', 'Add Product Sub Category', 23, 0),
(28, 'edit-product-sub-category', 'Edit Product Sub Category', 23, 0),
(29, 'module-administrator', ' Administrator Module', 0, 0),
(30, 'view-administrator', 'View Admins Details', 29, 0),
(31, 'add-administrator', 'Add Administrator', 29, 0),
(32, 'edit-administrator', 'Edit Administrator', 29, 0),
(33, 'delete-administrator', 'Delete Administrator', 29, 0),
(34, 'role-permission', 'Role Permission', 29, 0),
(39, 'add-product-category', 'Add Product Category', 23, 0),
(40, 'module-member', 'Member Module', 0, 0),
(41, 'add-member', 'Add Member', 40, 0),
(42, 'edit-member', 'Edit Member', 40, 0),
(43, 'delete-member', 'Delete Member', 40, 0),
(44, 'member-transaction', 'View Member transaction', 40, 0),
(45, 'add-balance', 'Add Balance', 40, 0),
(46, 'module-product', 'Product Module', 0, 0),
(47, 'add-product', 'Add Product', 46, 0),
(48, 'edit_product', 'Edit Product', 46, 0),
(49, 'delete-product', 'Delete Product', 46, 0),
(52, 'auction-winner-module', 'Product Winner Module', 0, 0),
(53, 'log-setting', 'Admin Log Settings', 0, 0),
(55, 'module-report', 'Report Module', 0, 0),
(56, 'award-bid', 'Award Bid', 0, 0),
(57, 'admin-communication', 'Admin Communication', 0, 0),
(58, 'module-time-zone-settings', 'Time Zone Settings Module', 0, 0),
(59, 'paypal-payment', 'Payment By Paypal', 0, 0),
(60, 'module-seo', 'SEO Management', 0, 0),
(61, 'module-bidpackage', 'Bidpackage Module', 0, 0),
(62, 'add-bidpackage', 'Add Bidpackage', 61, 0),
(63, 'delete-bidpackage', 'Delete Bidpackage', 61, 0),
(64, 'edit-bidpackage', 'Edit Bid Package', 61, 0),
(65, 'module-help', 'Help Module', 0, 0),
(66, 'add-help', 'Add Help', 65, 0),
(67, 'edit-help', 'Edit Help', 65, 0),
(68, 'delete-help', 'Delete Help', 65, 0),
(69, 'view-help', 'View Help', 65, 0),
(70, 'module-currency', 'Currency Module', 0, 0),
(71, 'view-currency', 'View Currency', 70, 0),
(72, 'add-currency', 'Add Currency', 70, 0),
(73, 'edit-currency', 'Edit Currency', 70, 0),
(74, 'delete-currency', 'Delete Currency', 70, 0),
(75, 'view-bidpackage', 'View Bidpackage', 61, 0),
(76, 'module-newsletter', 'Newsletter Module', 0, 0),
(77, 'view-newsletter', 'View Newsletter', 76, 0),
(78, 'add-newsletter', 'Add NewsLetter', 76, 0),
(79, 'edit-newsletter', 'Edit Newsletter', 76, 0),
(80, 'delete-newsletter', 'Delete Newsletter', 76, 0),
(81, 'module-custom-field', 'Custom Field', 0, 0),
(82, 'add-custom-field', 'Add Custom Field', 81, 0),
(83, 'edit-custom-field', 'Edit Custom Field', 81, 0),
(84, 'delete-custom-field', 'Delete Custom Field', 81, 0),
(85, 'module-how-and-why', 'How It Works/ Why Reverse Auction', 0, 0),
(86, 'add-how-and-why', 'Add Content', 85, 0),
(87, 'edit-how-and-why', 'Edit Content', 85, 0),
(88, 'delete-how-and-why', 'Delete Content', 85, 0),
(89, 'view-how-and-why', 'View Content', 85, 0),
(90, 'send-newsletter', 'Send Newsletters', 76, 0),
(91, 'module-dispute', 'Dispute Management', 0, 0),
(92, 'winner-payment', 'Winner Payment', 0, 0),
(93, 'module-reward', 'Rewards', 0, 0),
(94, 'add-reward', 'Add Rewards', 93, 0),
(95, 'edit-reward', 'Edit Rewards', 93, 0),
(96, 'delete-reward', 'Delete Rewards', 93, 0);

-- --------------------------------------------------------

--
-- Table structure for table `emts_admin_roles_permission`
--

CREATE TABLE `emts_admin_roles_permission` (
  `user_type` int(5) NOT NULL,
  `permission_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emts_admin_roles_permission`
--

INSERT INTO `emts_admin_roles_permission` (`user_type`, `permission_id`) VALUES
(1, 1),
(2, 1),
(1, 2),
(1, 3),
(2, 3),
(1, 4),
(2, 4),
(1, 5),
(2, 5),
(1, 6),
(2, 6),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 39),
(1, 40),
(2, 40),
(1, 41),
(2, 41),
(1, 42),
(2, 42),
(1, 43),
(2, 43),
(1, 44),
(2, 44),
(1, 45),
(2, 45),
(1, 46),
(2, 46),
(1, 47),
(2, 47),
(1, 48),
(2, 48),
(1, 49),
(2, 49),
(1, 52),
(1, 53),
(1, 55),
(1, 56),
(1, 57),
(1, 58),
(2, 58),
(1, 59),
(1, 60),
(1, 61),
(1, 62),
(1, 63),
(1, 64),
(1, 65),
(1, 66),
(1, 67),
(1, 68),
(1, 69),
(1, 70),
(1, 71),
(1, 72),
(1, 73),
(1, 74),
(1, 75),
(1, 76),
(1, 77),
(1, 78),
(1, 79),
(1, 80),
(1, 81),
(1, 82),
(1, 83),
(1, 84),
(1, 85),
(1, 86),
(1, 87),
(1, 88),
(1, 89),
(1, 90),
(1, 91),
(1, 92),
(1, 93),
(1, 94),
(1, 95),
(1, 96);

-- --------------------------------------------------------

--
-- Table structure for table `emts_audience_demographic`
--

CREATE TABLE `emts_audience_demographic` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `age_range` varchar(10) DEFAULT NULL,
  `number_male` int(11) DEFAULT NULL,
  `number_female` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_audience_demographic`
--

INSERT INTO `emts_audience_demographic` (`id`, `user_id`, `age_range`, `number_male`, `number_female`) VALUES
(1, 74, '0-12', 10, 20),
(2, 74, '12-24', 12, 11),
(3, 74, '24-26', 20, 26),
(4, 74, '26-29', 25, 40),
(5, 39, '12-24', 40, 35),
(6, 97, 'age18-24', 35, 0),
(7, 97, 'age25-34', 65, 0);

-- --------------------------------------------------------

--
-- Table structure for table `emts_audience_geography`
--

CREATE TABLE `emts_audience_geography` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `country_code` varchar(10) DEFAULT NULL,
  `number_user` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_audience_geography`
--

INSERT INTO `emts_audience_geography` (`id`, `user_id`, `country_code`, `number_user`) VALUES
(24, 74, 'DE', 1),
(23, 74, 'ZZ', 1),
(22, 74, 'NP', 13),
(25, 97, 'AU', 3),
(26, 97, 'NP', 48),
(27, 97, 'ZZ', 0),
(28, 103, 'NP', 0);

-- --------------------------------------------------------

--
-- Table structure for table `emts_block_ips`
--

CREATE TABLE `emts_block_ips` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `added_date` datetime NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emts_block_ips`
--

INSERT INTO `emts_block_ips` (`id`, `ip_address`, `message`, `added_date`, `last_update`) VALUES
(1, '192.12.12.12', 'yo are blocked', '2016-07-07 11:58:01', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `emts_category`
--

CREATE TABLE `emts_category` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'defined whether it is category or subcategory',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `short_desc` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `added_date` datetime NOT NULL,
  `is_display` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=No, 1= Yes',
  `display_menu` enum('No','Yes') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emts_category`
--

INSERT INTO `emts_category` (`id`, `parent_id`, `name`, `short_desc`, `added_date`, `is_display`, `display_menu`, `last_update`) VALUES
(102, 0, 'Smartphone', 'Smart Phone', '2017-02-24 11:29:53', '1', 'Yes', '2017-02-24 05:44:53'),
(103, 0, 'Apparels & Categories', 'Apparels and Categories', '2017-02-24 11:27:54', '1', 'Yes', '2017-02-24 05:42:54'),
(104, 0, 'Automotive', 'Automotive', '2017-02-24 11:28:12', '1', 'Yes', '2017-02-24 05:43:12'),
(105, 0, 'Technology', 'Technology', '2017-02-24 11:28:29', '1', 'Yes', '2017-02-24 05:43:29'),
(106, 0, 'Sports & toys', 'Sports & toys', '2017-02-24 11:28:49', '1', 'Yes', '2017-02-24 05:43:49'),
(107, 0, 'Health & Beauty', 'Health & Beauty', '2017-02-24 11:29:16', '1', 'Yes', '2017-02-24 05:44:16'),
(108, 0, 'Textiles', 'Textiles', '2017-02-24 11:30:06', '1', 'Yes', '2017-02-24 05:45:06'),
(109, 0, 'Video Games', 'Video Games', '2017-02-24 11:30:25', '1', 'Yes', '2017-02-24 05:45:25');

-- --------------------------------------------------------

--
-- Table structure for table `emts_category_1`
--

CREATE TABLE `emts_category_1` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `isactive` enum('1','0') DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emts_ci_sessions`
--

CREATE TABLE `emts_ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emts_cms`
--

CREATE TABLE `emts_cms` (
  `id` int(11) NOT NULL,
  `heading` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cms_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_key` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `is_display` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_date` datetime NOT NULL,
  `last_update` datetime NOT NULL,
  `deletable` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emts_cms`
--

INSERT INTO `emts_cms` (`id`, `heading`, `content`, `cms_slug`, `page_title`, `meta_key`, `meta_description`, `is_display`, `created_date`, `last_update`, `deletable`) VALUES
(2, 'About', '<p>\r\n Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>\r\n<h4>\r\n 1914 translation by H. Rackham</h4>\r\n<p>\r\n The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\r\n<h4 class=\"pnk\">\r\n 1914 translation by H. Rackham</h4>\r\n<p>\r\n Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>\r\n<h4 class=\"blu\">\r\n 1914 translation by H. Rackham</h4>\r\n<p>\r\n Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>\r\n<ul>\r\n <li>\r\n  Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>\r\n <li>\r\n  Sed consectetur lectus et felis dapibus tempus.</li>\r\n <li>\r\n  Cras ut massa et massa pellentesque luctus.</li>\r\n <li>\r\n  Quisque accumsan lectus et scelerisque congue.</li>\r\n <li>\r\n  Nam sodales elit et lacus tristique, et tempor neque aliquam.</li>\r\n <li>\r\n  Sed sodales sem a ante semper posuere.</li>\r\n <li>\r\n  In porta turpis a neque varius porta.</li>\r\n</ul>\r\n<p>\r\n The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\r\n', 'about', 'About Us', 'About Us', 'About Us', 'Yes', '2016-05-10 12:23:58', '2016-06-06 11:16:25', 'No'),
(8, 'Buyers', '<p>\r\n Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam euismod lacus sit amet urna accumsan mattis. Nunc in justo sed libero iaculis consectetur vel ut turpis. Etiam tincidunt venenatis elit, in pretium risus condimentum et. Nullam mauris diam, cursus quis eros in, semper vehicula magna. Morbi aliquam eu felis bibendum aliquam. Duis in dignissim magna, in auctor neque. Aenean et libero quam. Aliquam erat volutpat. Phasellus nec feugiat enim. Praesent sit amet massa efficitur, venenatis orci at, lobortis ligula. Nunc a elementum orci. Suspendisse potenti.</p>\r\n', 'buyers', 'Buyers', 'Buyers', 'Buyers', 'Yes', '2016-06-06 11:05:01', '0000-00-00 00:00:00', 'No'),
(5, 'Privacy Policy', '<p>\r\n Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>\r\n<p>\r\n Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>\r\n<p>\r\n Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>\r\n', 'privacy-policy', 'Privacy Ploicy', 'Privacy Policy, Hightree Group', 'Privacy Policy, Hightree Group', 'Yes', '2016-06-02 13:04:33', '2016-06-22 15:21:31', 'No'),
(6, 'Terms And Conditions', '<p>\r\n <strong>1.</strong> Clip LLC, Company code 12456395 (hereinafter Organiser), organises auctions for new products and services on the internet. If you place a bid at an auction, or register as a user (hereinafter Client), you accept the following terms of use, and enter a contract on the following terms.</p>\r\n<p>\r\n <strong>2.</strong> The Client has to be a real person. The auction user account is personal. The client is not allowed to create various different user names/accounts. When a person has several auction accounts (user accounts), the bids placed by such a user may be annulled and/or the Organiser may close the account (possible purchased or received bids on a closed account will not be remunerated).</p>\r\n<p>\r\n <strong>3.</strong> The password cannot be detrimental towards other Clients (visitors and users of the Yepbid.com site). The Client is expected to present correct details when registering. The Client is liable for their actions regarding their user account. All registered users undertake to keep their username and password confidential. If a registered user has revealed their username and password to a third party, the Organiser cannot be held liable for the consequences of such actions.</p>\r\n<p>\r\n <strong>4. </strong>The Organiser is entitled to annul the winner of an auction, if the rules of the auction have been violated. Funds paid for annulled bids will not be returned. The organiser cannot be held liable for the unlawful actions of the Client.</p>\r\n<p>\r\n <strong>5.</strong>The Client or a visitor at www.Yepbid.com (hereinafter Site) agree not to distribute spam, chain letters, so-called pyramid schemes, viruses or other technology which cause or may cause harm to the Organiser or the Site.</p>\r\n<p>\r\n <strong>6.</strong> If the Organiser detects unlawful actions in the use of the services, the Organiser may suspend the Client’s use of the services and/or forbid such a Client to participate at auctions if deemed necessary.</p>\r\n<p>\r\n <strong>7. </strong>The Organiser is entitled to suspend, close or annul the auction, if Organiser’s server system is being violated, disturbed or such a system error is detected which may harm or affect course of the auction. If it is not possible to restore the auction, funds paid for placing bids at this auction will be returned to the Clients as virtual funds on their Yepbid.com accounts.</p>\r\n<p>\r\n <strong>8.</strong> The Organiser is not liable for errors in the computer system resulting from factors beyond the Organiser’s control (Force Majeure).</p>\r\n<p>\r\n <strong>9.</strong> The Organiser is not liable for errors which originate from the Client’s internet connection, power failure, and computer related errors or for other circumstances beyond the control of the Organiser.</p>\r\n<p>\r\n <strong>10.</strong> The Organiser does not affect the course of auctions in any way.</p>\r\n<p>\r\n <strong>11.</strong> Persons defined as organisers or employees of Yepbid.com are not allowed to participate in auctions.</p>\r\n<p>\r\n <strong>12.</strong> The user of Yepbid.com undertakes to use the services available on the site according to these terms and conditions and applicable legislation.</p>\r\n<p>\r\n <strong>13.</strong> Persons under the age of 18 are not allowed to participate in auctions with the exception of persons participating with their parent’s or guardian’s consent.</p>\r\n<p>\r\n <strong>14.</strong> The Organiser reserves right to close all auctions if a system error is detected.</p>\r\n<p>\r\n <strong>15</strong>. It is forbidden to use scripts at placing bids. If such a conduct is detected, the Organiser is entitled to refrain from selling the item to the Client.</p>\r\n<p>\r\n <strong>16</strong>. The Organiser is not liable for server problems or other problems. The Organiser does their utmost to restore the auction or return bids to the users when this is due to a server problem.</p>\r\n<p>\r\n <strong>17</strong>. The Client is entitled to participate simultaneously in all on-going auctions.</p>\r\n<p>\r\n <strong>18</strong>. The number of bids at auctions is not limited unless otherwise stated.</p>\r\n<p>\r\n <strong>19</strong>. Auctions go on 24h per day unless otherwise stated.</p>\r\n<p>\r\n <strong>20</strong>. Yepbid.com bids may be used on this site only (www.Yepbid.com), and the virtual funds, which the user does not spend, will not be compensated with real funds.</p>\r\n<p>\r\n <strong>21</strong>. Virtual funds may be purchased via available payment options.</p>\r\n<p>\r\n <strong>22</strong>. The Organiser is entitled to change the terms and conditions. The new terms and conditions come into force immediately after they have been published on the site. The Client confirms their acceptance of the modified and/or supplemented terms and conditions after the modifications/supplementations have entered into force.</p>\r\n<p>\r\n <strong>23</strong>. When the Client is entitled to purchase an auctioned item, she or he pays the winning price for the auctioned item (the lowest unique bid or the remaining value of the product or service i.e. the price the user has verified to purchase the item.) according to the Organiser’s invoice. The price includes delivery costs and VAT. Also Client can convert won item into bids before payment.</p>\r\n<p>\r\n <strong>24</strong>. If the Client does not pay for the item won at an auction within 14 days, the Organiser is entitled to annul the sales contract.</p>\r\n<p>\r\n <strong>25</strong>. The item photos are illustrative only. The product displayed in the photograph may differ from the offered product, or include components not included in the product package.</p>\r\n<p>\r\n <strong>26</strong>. The Organiser forwards the purchased items to the Client within 15 (fifteen) business days from the date when the Client paid the invoice to the address the Client has provided. The Organiser pays for the domestic delivery costs of the items.</p>\r\n<p>\r\n <strong>27</strong>. Delivery terms for more sizeable and expensive items are agreed upon separately with the winner.</p>\r\n<p>\r\n <strong>28</strong>. The item is posted to the Client or forwarded on some other agreed means of transport provided that the invoice has been paid in full, and the funds have been transferred to the Organiser&#39;s bank account.</p>\r\n<p>\r\n <strong>29</strong>. If defects are found in an item purchased at auction, the Client undertakes to inform the Organiser of such defects without delay. The Client is entitled to return the purchased item to the Organiser within 14 (fourteen) calendar days. The returned item has to be in prime condition, in its original package and unused. The Organiser returns the funds paid for the item to the Client after the returned item has been checked, but no later than within 15 (fifteen) business days. Costs for placing a bid at the auction or costs for returning the item will not be reimbursed.</p>\r\n', 'terms-and-conditions', 'Terms and Conditions', 'Terms and Conditions', 'Terms and Conditions', 'Yes', '2016-06-02 13:05:49', '2016-06-22 15:22:15', 'No'),
(7, 'Reverse Auction', '<h1>\r\n Reverse Auction</h1>\r\n<h2>\r\n Are you a supplier</h2>\r\n<p>\r\n If yes! Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>\r\n', 'reverse-auction', 'Reverse Auction', 'Reverse Auction', 'Reverse Auction', 'Yes', '2016-06-02 13:06:44', '2016-06-02 15:43:35', 'No'),
(9, 'Suppliers', '<p>\r\n Vestibulum at dolor semper, posuere libero viverra, blandit nunc. Donec varius dolor nunc, eget rhoncus felis rutrum sed. Duis tristique dolor lectus, et bibendum tellus blandit non. Cras eget purus tortor. Fusce ultricies arcu in orci scelerisque dignissim. Quisque vitae cursus dui. Nulla maximus lectus ut sodales facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mauris orci, porttitor et interdum et, lobortis sit amet orci. Curabitur nunc massa, semper eu convallis eu, scelerisque sed velit. Curabitur finibus elit enim, id suscipit odio congue non. Donec risus erat, auctor ac risus id, tempus dignissim justo. Donec sagittis, felis ac vulputate rhoncus, lacus nisi placerat mauris, a rhoncus urna sem eget elit.</p>\r\n', 'suppliers', 'Suppliers', 'Suppliers', 'Suppliers', 'Yes', '2016-06-06 11:05:35', '0000-00-00 00:00:00', 'No'),
(10, 'Why Reverse Auction', '<p>\r\n Vestibulum at dolor semper, posuere libero viverra, blandit nunc. Donec varius dolor nunc, eget rhoncus felis rutrum sed. Duis tristique dolor lectus, et bibendum tellus blandit non. Cras eget purus tortor. Fusce ultricies arcu in orci scelerisque dignissim. Quisque vitae cursus dui. Nulla maximus lectus ut sodales facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mauris orci, porttitor et interdum et, lobortis sit amet orci. Curabitur nunc massa, semper eu convallis eu, scelerisque sed velit. Curabitur finibus elit enim, id suscipit odio congue non. Donec risus erat, auctor ac risus id, tempus dignissim justo. Donec sagittis, felis ac vulputate rhoncus, lacus nisi placerat mauris, a rhoncus urna sem eget elit.</p>\r\n<p>\r\n Quisque eu justo vel libero pulvinar finibus quis eget justo. Aenean quis enim tincidunt, efficitur mauris dictum, interdum erat. Vivamus nisl diam, pretium vel sapien sit amet, viverra luctus nibh. Curabitur erat nisi, ullamcorper at eleifend sit amet, sollicitudin nec nisl. Aliquam et justo ut ipsum bibendum aliquet id posuere felis. Etiam facilisis ex sed ex ornare, at ultrices lacus varius. Sed luctus pulvinar dolor, quis feugiat nisl rutrum vitae. Integer finibus est a ullamcorper egestas. Mauris efficitur turpis id suscipit malesuada.</p>\r\n', 'why-reverse-auction', 'Why Reverse Auction', 'Why Reverse Auction', 'Why Reverse Auction', 'Yes', '2016-06-06 11:26:24', '2016-06-06 12:14:06', 'No'),
(11, 'Member Activation Successful', '<p>\n Congratulations! You have successfully registered!<br>\n <br>\n To log in use email address and password you used when you registered.<br>\n <br>\n Your log in details have also emailed to you.</p>\n', 'member-activation-successful', '', '', '', 'Yes', '2016-06-14 09:25:44', '0000-00-00 00:00:00', 'No'),
(12, 'Member Activation Failed', '<p>\r\n Yor activation to our site failed</p>\r\n', 'member-activation-failed', '', '', '', 'Yes', '2016-06-14 09:26:32', '2016-06-23 15:50:28', 'No'),
(13, 'test', '<p>\r\n test</p>\r\n', 'test', '', '', '', 'Yes', '2016-07-07 12:00:52', '0000-00-00 00:00:00', 'Yes'),
(14, 'suplier success registration message', '<p>\r\n  Please check your email for your account verification</p>\r\n', 'suplier-success-registration-message', 'success registration', 'success registration', 'success registration', 'Yes', '2016-08-05 11:56:09', '0000-00-00 00:00:00', 'Yes'),
(15, 'buyer success registration message', '<p>\r\n  Please check your email for your account verification</p>\r\n', 'buyer-success-registration-message', 'success message', 'success message', 'success message', 'Yes', '2016-08-05 11:56:53', '0000-00-00 00:00:00', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `emts_cms_others`
--

CREATE TABLE `emts_cms_others` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(100) NOT NULL,
  `is_display` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=No, 1= Yes',
  `cms_type` varchar(100) NOT NULL COMMENT 'how_it_works, why_reverse_auction',
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_cms_others`
--

INSERT INTO `emts_cms_others` (`id`, `title`, `description`, `image`, `is_display`, `cms_type`, `post_date`) VALUES
(6, 'Sign Up', '<p>\r\n Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, dummy text ever.</p>\r\n', 'sign-up-icon.png', '1', 'how_it_works', '2016-06-06 04:48:27'),
(8, 'Cost Reduction', '<p>\r\n Lorem Ipsum is an simply dummy text of the printing and type enc setting industry. Lorem Ipsum eim has been the an dummy text 1500s, dummy text ever.</p>\r\n', 'cost-reduce-icon.png', '1', 'why_reverse_auction', '2016-06-06 04:48:36'),
(9, 'Set-up auction', '<p>\r\n Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, dummy text ever.</p>\r\n', 'set-up-auction-icon.png', '1', 'how_it_works', '2016-06-06 04:48:43'),
(10, 'Evaluate Real Time Results', '<p>\r\n Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, dummy text ever.</p>\r\n', 'real-time-icon.png', '1', 'how_it_works', '2016-06-06 04:48:53'),
(11, 'Choose Most Appropriate Supplier', '<p>\r\n Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, dummy text ever.</p>\r\n', 'choose-supplier-icon.png', '1', 'how_it_works', '2016-06-06 05:05:17'),
(12, 'Competition Leveraging', '<p>\r\n Lorem Ipsum is an simply dummy text of the printing and type enc setting industry. Lorem Ipsum eim has been the an dummy text 1500s, dummy text ever.</p>\r\n', 'compition-icon.png', '1', 'why_reverse_auction', '2016-06-06 04:49:08'),
(13, 'Transparency in Bids', '<p>\r\n Lorem Ipsum is an simply dummy text of the printing and type enc setting industry. Lorem Ipsum eim has been the an dummy text 1500s, dummy text ever.</p>\r\n', 'bids1-icon.png', '1', 'why_reverse_auction', '2016-06-06 04:49:15'),
(14, 'Negotiation Time Reduction', '<p>\r\n Lorem Ipsum is an simply dummy text of the printing and type enc setting industry. Lorem Ipsum eim has been the an dummy text 1500s, dummy text ever.</p>\r\n', 'navigate-icon.png', '1', 'why_reverse_auction', '2016-06-06 04:49:23'),
(15, 'test', '<p>\r\n this is a test post </p>\r\n', 'logomain_bk.png', '1', 'how_it_works', '2016-07-07 06:21:22');

-- --------------------------------------------------------

--
-- Table structure for table `emts_communication`
--

CREATE TABLE `emts_communication` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `message` varchar(500) DEFAULT NULL,
  `messagedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ismsgseen` enum('0','1') DEFAULT '0' COMMENT '0=No, 1=Yes',
  `receiver_id` int(11) DEFAULT NULL,
  `bid_status` int(11) NOT NULL,
  `bid_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_communication`
--

INSERT INTO `emts_communication` (`id`, `product_id`, `sender_id`, `message`, `messagedate`, `ismsgseen`, `receiver_id`, `bid_status`, `bid_id`) VALUES
(1, 114, 43, 'test', '2017-03-01 03:36:41', '0', 39, 0, 4),
(2, 114, 43, 'test', '2017-03-01 03:36:41', '0', 39, 0, 4),
(90, 132, 83, 'r u there', '2017-05-17 10:11:29', '1', 82, 1, 18),
(91, 132, 82, 'hi there', '2017-05-17 10:11:43', '1', 83, 1, 18),
(92, 132, 83, 'asd', '2017-05-22 07:25:08', '1', 82, 1, 18),
(93, 132, 83, 'zzxc', '2017-05-22 07:25:45', '1', 82, 1, 18),
(94, 132, 83, 'asdasd', '2017-05-22 09:10:25', '1', 82, 1, 18),
(88, 132, 82, 'hey!!', '2017-05-17 10:10:16', '1', 83, 1, 18),
(89, 132, 83, 'hello', '2017-05-17 10:11:29', '1', 82, 1, 18),
(7, 118, 69, 'hey if you want to work with me submit yoouur detail', '2017-03-01 04:20:13', '1', 48, 0, 1),
(8, 118, 48, 'What should i send??', '2017-03-01 04:20:13', '1', 69, 0, 1),
(9, 118, 69, 'You can always send from link given to u in email.', '2017-03-01 04:20:13', '1', 48, 0, 1),
(10, 118, 69, 'Your job is good.', '2017-03-01 04:20:13', '1', 48, 2, 1),
(11, 118, 69, 'you are perfectly set on', '2017-03-01 04:20:13', '1', 48, 2, 1),
(12, 118, 69, 'Well do work well more..You will get better work next time :)', '2017-03-01 04:20:13', '1', 48, 2, 1),
(13, 118, 48, 'I would try my best sir.Thank you', '2017-03-01 04:20:13', '1', 69, 2, 1),
(14, 118, 48, 'What about the proposal .Please look into this.', '2017-03-01 04:20:13', '1', 69, 2, 1),
(15, 118, 69, 'Hey that looks good!! :)', '2017-03-01 04:20:13', '1', 48, 2, 1),
(16, 118, 69, 'Hey i tried to test if you are working in it a better way. Please feel free to  express any thing you feel.Is there any problem on what you are working on with?', '2017-03-01 04:20:13', '1', 48, 2, 1),
(17, 118, 69, 'asd', '2017-03-01 04:20:13', '1', 48, 2, 1),
(18, 118, 69, 'check this again', '2017-03-01 04:20:13', '1', 48, 2, 1),
(19, 118, 69, 'hey am i correct', '2017-03-01 04:20:13', '1', 48, 2, 1),
(20, 118, 69, 'hello there', '2017-03-01 04:20:13', '1', 48, 2, 1),
(21, 118, 69, 'asdad', '2017-03-01 04:20:13', '1', 48, 2, 1),
(22, 118, 69, 'get', '2017-03-01 04:20:13', '1', 48, 2, 1),
(23, 118, 69, 'hey', '2017-03-01 04:20:13', '1', 48, 2, 1),
(24, 118, 69, 'check', '2017-03-01 04:20:13', '1', 48, 2, 1),
(25, 118, 69, 'check 2', '2017-03-01 04:20:13', '1', 48, 2, 1),
(26, 118, 69, 'check1', '2017-03-01 04:20:13', '1', 48, 2, 1),
(27, 118, 69, 'check3', '2017-03-01 04:20:13', '1', 48, 2, 1),
(28, 118, 69, 'asdad', '2017-03-01 04:20:13', '1', 48, 2, 1),
(29, 118, 69, 'test', '2017-03-01 04:20:13', '1', 48, 2, 1),
(30, 118, 69, 'tested', '2017-03-01 04:20:13', '1', 48, 2, 1),
(31, 118, 69, 'tested2', '2017-03-01 04:20:13', '1', 48, 2, 1),
(32, 118, 69, 'test', '2017-03-01 04:20:13', '1', 48, 2, 1),
(33, 118, 69, 'check test2', '2017-03-01 04:20:13', '1', 48, 2, 1),
(34, 118, 69, 'check test21', '2017-03-01 04:20:13', '1', 48, 2, 1),
(35, 118, 69, 'checked1', '2017-03-01 04:20:13', '1', 48, 2, 1),
(36, 118, 48, 'hey there', '2017-03-01 04:20:13', '1', 69, 2, 1),
(65, 118, 48, 'hi', '2017-03-01 04:20:13', '1', 69, 7, 1),
(66, 118, 69, 'hello', '2017-03-01 04:20:13', '1', 48, 7, 1),
(67, 118, 69, 'hey there', '2017-03-01 04:20:13', '1', 48, 7, 1),
(68, 118, 48, 'hello', '2017-03-01 04:20:13', '1', 69, 7, 1),
(69, 118, 69, 'hi', '2017-03-01 04:20:13', '1', 48, 7, 1),
(70, 118, 48, 'Thank you', '2017-03-01 04:20:13', '1', 69, 7, 1),
(71, 118, 69, 'hello', '2017-03-01 04:20:13', '1', 48, 7, 1),
(72, 118, 69, 'hi', '2017-03-01 04:20:13', '1', 48, 7, 1),
(73, 118, 69, 'hey', '2017-03-01 04:20:13', '1', 48, 7, 1),
(74, 118, 69, 'hello', '2017-03-01 04:20:13', '1', 48, 7, 1),
(75, 118, 48, 'hello', '2017-03-01 04:20:13', '1', 69, 7, 1),
(76, 118, 69, 'hello', '2017-03-01 04:20:13', '1', 48, 7, 1),
(77, 118, 48, 'hello sir r u there??', '2017-03-01 04:20:13', '1', 69, 7, 1),
(78, 118, 69, 'tested hello', '2017-03-01 04:20:13', '1', 48, 7, 1),
(79, 118, 69, 'hi', '2017-03-01 04:20:13', '1', 48, 2, 1),
(80, 122, 69, 'test', '2017-03-01 03:36:41', '0', 74, 5, 4),
(81, 118, 48, 'hey', '2017-03-01 04:20:13', '1', 69, 2, 1),
(95, 132, 83, 'check', '2017-05-22 09:15:10', '1', 82, 1, 18),
(96, 132, 83, 'IS there anyone??!!', '2017-05-22 09:20:06', '1', 82, 1, 18),
(97, 132, 83, 'Hey will u be there', '2017-05-22 09:21:05', '1', 82, 1, 18),
(98, 132, 83, 'asdasd', '2017-05-22 09:21:05', '1', 82, 1, 18),
(99, 132, 83, 'asdasd', '2017-05-22 09:21:05', '1', 82, 1, 18),
(100, 132, 83, 'check my test', '2017-05-22 09:22:46', '1', 82, 1, 18),
(101, 132, 83, 'hey sagar!!', '2017-05-22 09:27:21', '1', 82, 1, 18),
(102, 132, 83, 'Hello sir!!!', '2017-05-22 09:30:51', '1', 82, 1, 18),
(103, 132, 83, 'checkout', '2017-05-22 09:32:31', '1', 82, 1, 18),
(104, 132, 83, 'check here', '2017-05-22 09:32:31', '1', 82, 1, 18),
(105, 132, 83, 'hi', '2017-05-22 09:33:32', '1', 82, 1, 18),
(106, 132, 83, 'asdasd', '2017-05-22 09:38:47', '1', 82, 1, 18),
(107, 132, 83, 'asda sadad ad sad', '2017-05-22 09:40:22', '1', 82, 1, 18),
(108, 132, 83, 'check', '2017-05-22 09:43:56', '1', 82, 1, 18),
(109, 132, 83, 'asfddsf', '2017-05-22 09:43:56', '1', 82, 1, 18),
(110, 132, 83, 'asfddsf', '2017-05-22 09:43:56', '1', 82, 1, 18),
(111, 132, 83, 'checkasd', '2017-05-22 09:43:56', '1', 82, 1, 18),
(112, 132, 83, 'checkasd', '2017-05-22 09:43:56', '1', 82, 1, 18),
(113, 132, 83, 'checkasd', '2017-05-22 09:43:56', '1', 82, 1, 18),
(114, 132, 83, 'shiva pathaak', '2017-05-22 09:46:34', '1', 82, 1, 18),
(115, 132, 83, 'sudip stha', '2017-05-22 09:49:43', '1', 82, 1, 18),
(116, 132, 83, 'door', '2017-05-22 10:08:00', '1', 82, 1, 18),
(117, 132, 83, 'shiva pathaak', '2017-05-22 10:08:00', '1', 82, 1, 18),
(118, 132, 83, 'hey\n', '2017-05-22 10:14:35', '1', 82, 1, 18),
(119, 132, 83, 'asdasd', '2017-05-23 05:58:14', '1', 82, 1, 18),
(120, 132, 83, 'hello test', '2017-05-23 05:59:33', '1', 82, 1, 18),
(121, 132, 83, '', '2017-05-23 06:02:09', '1', 82, 1, 18),
(122, 132, 83, '', '2017-05-23 06:02:09', '1', 82, 1, 18),
(123, 132, 82, 'sir i want to work with you!!', '2017-05-23 06:10:16', '1', 83, 1, 18),
(124, 132, 83, 'hey', '2017-05-23 08:27:51', '1', 85, 1, 22),
(125, 132, 83, 'hello ', '2017-05-23 08:27:18', '1', 82, 1, 18),
(126, 132, 83, 'hello ', '2017-05-23 08:27:18', '1', 82, 1, 18),
(127, 132, 83, 'hello ', '2017-05-23 08:27:18', '1', 82, 1, 18),
(128, 132, 83, 'hello ', '2017-05-23 08:27:18', '1', 82, 1, 18),
(129, 132, 83, 'hello 1\n', '2017-05-23 08:27:18', '1', 82, 1, 18),
(130, 132, 83, 'hello 1\n', '2017-05-23 08:27:18', '1', 82, 1, 18),
(131, 132, 83, 'hello 1\n', '2017-05-23 08:27:18', '1', 82, 1, 18),
(132, 132, 83, 'hello 1\n', '2017-05-23 08:27:18', '1', 82, 1, 18),
(133, 132, 83, 'pc rishi', '2017-05-23 09:11:51', '1', 82, 1, 18),
(134, 132, 83, 'pc rishi', '2017-05-23 09:11:51', '1', 82, 1, 18),
(135, 132, 83, 'pc rishi-2', '2017-05-23 09:11:51', '1', 82, 1, 18),
(136, 132, 83, 'pc rishi-3', '2017-05-23 09:11:51', '1', 82, 1, 18),
(137, 132, 85, 'hello!!', '2017-05-23 08:48:07', '1', 83, 1, 22),
(138, 132, 85, 'hello hello!!', '2017-05-24 09:21:02', '1', 83, 1, 22),
(139, 132, 83, 'hey!!\n', '2017-05-23 09:13:09', '1', 82, 1, 18),
(140, 132, 82, 'bro u ok!!', '2017-05-23 09:20:25', '1', 83, 1, 18),
(141, 132, 82, 'this is time to make responsive.Mr. Rishi bayanjakar ,what do you think you need to do....r u rishi or a pc?? do u understand?? what is what ii mean  to say yp??this is time to make responsive.Mr. Rishi bayanjakar ,what do you think you need to do....r u rishi or a pc?? do u understand?? what is what ii mean  to say yp??', '2017-05-23 09:47:41', '1', 83, 1, 18),
(142, 132, 83, 'test sagar', '2017-05-23 10:16:32', '1', 82, 1, 18),
(143, 132, 82, 'test rishi', '2017-05-23 10:17:17', '1', 83, 1, 18),
(144, 132, 83, '\nHey u...are u there', '2017-05-23 10:17:17', '1', 82, 1, 18),
(145, 132, 82, '\nyes i am here!!!', '2017-05-23 10:17:17', '1', 83, 1, 18),
(146, 132, 82, '\nhey three message test', '2017-05-23 10:17:42', '1', 83, 1, 18),
(147, 132, 82, 'I received message\n', '2017-05-23 10:18:05', '1', 83, 1, 18),
(148, 132, 82, '\nhey is that mistake detected!!!', '2017-05-23 10:22:34', '1', 83, 1, 18),
(149, 132, 82, 'is that a mistake!! can u ask??\n', '2017-05-23 10:26:54', '1', 83, 1, 18),
(150, 132, 82, '', '2017-05-23 10:26:54', '1', 83, 1, 18),
(151, 132, 83, 'hello!!', '2017-05-23 10:26:54', '1', 82, 1, 18),
(152, 132, 83, '', '2017-05-23 10:26:54', '1', 82, 1, 18),
(153, 132, 82, 'hi there', '2017-05-23 10:30:28', '1', 83, 1, 18),
(154, 132, 83, 'asd', '2017-05-23 10:32:26', '1', 82, 1, 18),
(155, 132, 82, '\nasdasd', '2017-05-23 10:32:26', '1', 83, 1, 18),
(156, 132, 83, '\n', '2017-05-23 10:32:26', '1', 82, 1, 18),
(157, 132, 82, '\n', '2017-05-23 10:34:22', '1', 83, 1, 18),
(158, 132, 83, 'hi sagar', '2017-05-23 11:10:39', '1', 82, 1, 18),
(159, 132, 82, '\naasd', '2017-05-23 11:10:39', '1', 83, 1, 18),
(160, 132, 83, 'check\n', '2017-05-23 11:10:39', '1', 82, 1, 18),
(161, 132, 82, 'hello check\n', '2017-05-23 11:10:39', '1', 83, 1, 18),
(162, 132, 83, 'is there anythjing wrong??\n', '2017-05-23 11:10:39', '1', 82, 1, 18),
(163, 132, 82, '\nyes ther eis', '2017-05-23 11:11:09', '1', 83, 1, 18),
(164, 132, 83, 'hello all are u fgine?? i am a single user\n', '2017-05-23 11:11:09', '1', 82, 1, 18),
(165, 132, 83, 'asdasd', '2017-05-23 11:12:15', '1', 82, 1, 18),
(166, 132, 83, 'asdasd', '2017-05-23 11:21:20', '1', 82, 1, 18),
(167, 132, 83, '', '2017-05-23 11:21:20', '1', 82, 1, 18),
(168, 132, 82, 'hello tjer', '2017-05-23 11:23:07', '1', 83, 1, 18),
(169, 132, 83, 'sir', '2017-05-24 05:06:51', '1', 82, 1, 18),
(170, 132, 82, 'hello student!! are u ther??!!', '2017-05-24 05:17:36', '1', 83, 1, 18),
(171, 132, 83, 'hey@!', '2017-05-24 05:34:52', '1', 82, 1, 18),
(172, 132, 83, 'hey u!!', '2017-05-24 05:37:41', '1', 82, 1, 18),
(173, 132, 83, 'hey', '2017-05-24 05:38:31', '1', 82, 1, 18),
(174, 132, 83, 'are u there', '2017-05-24 05:43:58', '1', 82, 1, 18),
(175, 132, 83, '', '2017-05-24 05:43:58', '1', 82, 1, 18),
(176, 132, 83, '', '2017-05-24 05:44:09', '1', 82, 1, 18),
(177, 132, 83, '', '2017-05-24 05:44:09', '1', 82, 1, 18),
(178, 132, 83, '', '2017-05-24 05:44:09', '1', 82, 1, 18),
(179, 132, 82, '\nhello everyuone', '2017-05-24 05:54:11', '1', 83, 1, 18),
(180, 132, 82, '', '2017-05-24 05:54:11', '1', 83, 1, 18),
(181, 132, 82, '\ncheckit', '2017-05-24 05:54:11', '1', 83, 1, 18),
(182, 132, 82, '', '2017-05-24 05:54:11', '1', 83, 1, 18),
(183, 132, 83, 'hey', '2017-05-24 05:54:11', '1', 82, 1, 18),
(184, 132, 82, '\nhey', '2017-05-24 05:54:36', '1', 83, 1, 18),
(185, 132, 82, '', '2017-05-24 05:54:36', '1', 83, 1, 18),
(186, 132, 82, 'asd', '2017-05-24 05:55:01', '1', 83, 1, 18),
(187, 132, 82, '\nhei', '2017-05-24 06:03:18', '1', 83, 1, 18),
(188, 132, 83, 'hello', '2017-05-24 06:03:18', '1', 82, 1, 18),
(189, 132, 83, '', '2017-05-24 06:03:18', '1', 82, 1, 18),
(190, 132, 83, 'hei', '2017-05-24 06:10:44', '1', 82, 1, 18),
(191, 132, 82, 'hello', '2017-05-24 07:26:19', '1', 83, 1, 18),
(192, 132, 83, 'hellp\n', '2017-05-24 07:26:19', '1', 82, 1, 18),
(193, 132, 83, '', '2017-05-24 07:26:19', '1', 82, 1, 18),
(194, 132, 82, '\nhi', '2017-05-24 07:26:19', '1', 83, 1, 18),
(195, 132, 82, '', '2017-05-24 07:26:19', '1', 83, 1, 18),
(196, 132, 82, '\n.', '2017-05-24 07:26:19', '1', 83, 1, 18),
(197, 132, 82, '', '2017-05-24 07:26:19', '1', 83, 1, 18),
(198, 132, 82, '', '2017-05-24 07:26:19', '1', 83, 1, 18),
(199, 132, 82, '', '2017-05-24 07:26:19', '1', 83, 1, 18),
(200, 132, 83, '\n.', '2017-05-24 07:26:19', '1', 82, 1, 18),
(201, 132, 83, '', '2017-05-24 07:26:19', '1', 82, 1, 18),
(202, 132, 83, '', '2017-05-24 07:26:19', '1', 82, 1, 18),
(203, 132, 83, '', '2017-05-24 07:26:19', '1', 82, 1, 18),
(204, 132, 83, 'hi', '2017-05-24 07:26:34', '1', 82, 1, 18),
(205, 132, 82, '\nhello!!', '2017-05-24 07:26:34', '1', 83, 1, 18),
(206, 132, 82, '', '2017-05-24 07:26:34', '1', 83, 1, 18),
(207, 132, 82, '', '2017-05-24 07:26:34', '1', 83, 1, 18),
(208, 132, 82, '', '2017-05-24 07:26:34', '1', 83, 1, 18),
(209, 132, 82, '', '2017-05-24 07:26:34', '1', 83, 1, 18),
(210, 132, 82, 'hello', '2017-05-24 07:27:49', '1', 83, 1, 18),
(211, 132, 83, '\nhi there', '2017-05-24 07:27:49', '1', 82, 1, 18),
(212, 132, 82, '\nhi sir', '2017-05-24 07:27:49', '1', 83, 1, 18),
(213, 132, 82, '\nhello', '2017-05-24 07:28:00', '1', 83, 1, 18),
(214, 132, 83, 'hi', '2017-05-24 07:28:53', '1', 82, 1, 18),
(215, 132, 82, '\nWe are alright', '2017-05-24 07:28:53', '1', 83, 1, 18),
(216, 132, 82, '\nok fine', '2017-05-24 07:28:53', '1', 83, 1, 18),
(217, 132, 83, '\nthank u a lot', '2017-05-24 07:28:53', '1', 82, 1, 18),
(218, 132, 83, 'hi there', '2017-05-24 07:29:41', '1', 82, 1, 18),
(219, 132, 82, '\nhi', '2017-05-24 07:29:41', '1', 83, 1, 18),
(220, 132, 82, '\nhi', '2017-05-24 07:30:57', '1', 83, 1, 18),
(221, 132, 82, '\nhello', '2017-05-24 07:30:57', '1', 83, 1, 18),
(222, 132, 83, 'sir', '2017-05-24 07:31:03', '1', 82, 1, 18),
(223, 132, 82, 'what is that sir', '2017-05-24 07:31:32', '1', 83, 1, 18),
(224, 132, 82, 'hello sir', '2017-05-24 07:39:50', '1', 83, 1, 18),
(225, 132, 82, 'hi', '2017-05-24 07:44:33', '1', 83, 1, 18),
(226, 132, 82, 'hi', '2017-05-24 07:48:15', '1', 83, 1, 18),
(227, 132, 82, 'hello', '2017-05-24 07:53:16', '1', 83, 1, 18),
(228, 132, 82, 'hi there', '2017-05-24 07:54:48', '1', 83, 1, 18),
(229, 132, 82, 'hello i am fine', '2017-05-24 07:54:48', '1', 83, 1, 18),
(230, 132, 82, 'hi ok', '2017-05-24 07:54:48', '1', 83, 1, 18),
(231, 132, 82, '\nhello!! hello!!', '2017-05-24 07:54:48', '1', 83, 1, 18),
(232, 132, 82, 'Mr.sagar', '2017-05-24 08:20:13', '1', 83, 1, 18),
(233, 132, 83, 'hi all', '2017-05-24 09:22:57', '1', 82, 1, 18),
(234, 132, 82, 'hello are u available', '2017-05-24 09:21:20', '1', 83, 1, 18),
(235, 132, 82, '\nhello', '2017-05-24 09:21:48', '0', 0, 1, 22),
(236, 132, 83, 'hekk', '2017-05-25 07:19:30', '1', 85, 1, 22),
(237, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(238, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(239, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(240, 132, 82, 'hi', '2017-05-24 09:23:48', '0', 0, 1, 22),
(241, 132, 83, 'hi', '2017-05-24 09:24:59', '1', 82, 1, 18),
(242, 132, 82, 'hello', '2017-05-24 09:24:48', '1', 83, 1, 18),
(243, 132, 82, '', '2017-05-24 09:24:48', '1', 83, 1, 18),
(244, 132, 83, 'hihi', '2017-05-24 09:24:59', '1', 82, 1, 18),
(245, 132, 82, 'hello', '2017-05-24 09:29:06', '1', 83, 1, 18),
(246, 132, 83, 'hi', '2017-05-25 07:19:30', '1', 85, 1, 22),
(247, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(248, 132, 83, 'hi', '2017-05-24 09:29:15', '1', 82, 1, 18),
(249, 132, 83, 'hi', '2017-05-25 07:19:30', '1', 85, 1, 22),
(250, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(251, 132, 83, 'hi', '2017-05-24 10:36:48', '1', 82, 1, 18),
(252, 132, 83, 'ok', '2017-05-25 07:19:30', '1', 85, 1, 22),
(253, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(254, 132, 83, 'asd\n', '2017-05-25 07:19:30', '1', 85, 1, 22),
(255, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(256, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(257, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(258, 132, 83, 'yes', '2017-05-24 10:36:48', '1', 82, 1, 18),
(259, 132, 83, 'a', '2017-05-25 07:19:30', '1', 85, 1, 22),
(260, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(261, 132, 83, 'asd', '2017-05-24 10:36:48', '1', 82, 1, 18),
(262, 132, 83, 'yes', '2017-05-25 07:19:30', '1', 85, 1, 22),
(263, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(264, 132, 83, 'asd', '2017-05-24 10:36:48', '1', 82, 1, 18),
(265, 132, 83, 'asd', '2017-05-25 07:19:30', '1', 85, 1, 22),
(266, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(267, 132, 83, '2', '2017-05-24 10:36:48', '1', 82, 1, 18),
(268, 132, 83, 'a', '2017-05-25 07:19:30', '1', 85, 1, 22),
(269, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(270, 132, 83, 'i', '2017-05-24 10:36:48', '1', 82, 1, 18),
(271, 132, 83, 'l', '2017-05-25 07:19:30', '1', 85, 1, 22),
(272, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(273, 132, 83, 'hi', '2017-05-24 10:36:48', '1', 82, 1, 18),
(274, 132, 83, 'hi', '2017-05-25 07:19:30', '1', 85, 1, 22),
(275, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(276, 132, 83, '1', '2017-05-24 10:36:48', '1', 82, 1, 18),
(277, 132, 83, '2', '2017-05-25 07:19:30', '1', 85, 1, 22),
(278, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(279, 132, 83, 'asd\n', '2017-05-25 07:19:30', '1', 85, 1, 22),
(280, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(281, 132, 83, '2', '2017-05-24 10:36:48', '1', 82, 1, 18),
(282, 132, 83, '3', '2017-05-25 07:19:30', '1', 85, 1, 22),
(283, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(284, 132, 83, '\n3', '2017-05-25 07:19:30', '1', 85, 1, 22),
(285, 132, 83, '1', '2017-05-24 10:36:48', '1', 82, 1, 18),
(286, 132, 83, '2.', '2017-05-24 10:36:48', '1', 82, 1, 18),
(287, 132, 83, '3.', '2017-05-24 10:36:48', '1', 82, 1, 18),
(288, 132, 83, '4.', '2017-05-24 10:36:48', '1', 82, 1, 18),
(289, 132, 83, '4.', '2017-05-25 07:19:30', '1', 85, 1, 22),
(290, 132, 83, 'asd', '2017-05-24 10:36:48', '1', 82, 1, 18),
(291, 132, 83, 'as', '2017-05-25 07:19:30', '1', 85, 1, 22),
(292, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(293, 132, 83, 'sd\n', '2017-05-25 07:19:30', '1', 85, 1, 22),
(294, 132, 83, 'a', '2017-05-24 10:36:48', '1', 82, 1, 18),
(295, 132, 83, 'a', '2017-05-25 07:19:30', '1', 85, 1, 22),
(296, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(297, 132, 83, 'a', '2017-05-24 10:36:48', '1', 82, 1, 18),
(298, 132, 83, '', '2017-05-24 10:36:48', '1', 82, 1, 18),
(299, 132, 83, '', '2017-05-24 10:36:48', '1', 82, 1, 18),
(300, 132, 83, 'as', '2017-05-24 10:36:48', '1', 82, 1, 18),
(301, 132, 83, 'asd', '2017-05-25 07:19:30', '1', 85, 1, 22),
(302, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(303, 132, 83, 'asd\n', '2017-05-25 07:19:30', '1', 85, 1, 22),
(304, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(305, 132, 83, 'asd', '2017-05-24 10:36:48', '1', 82, 1, 18),
(306, 132, 83, 'asd', '2017-05-25 07:19:30', '1', 85, 1, 22),
(307, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(308, 132, 83, 'ads', '2017-05-24 10:36:48', '1', 82, 1, 18),
(309, 132, 83, 'asd', '2017-05-24 10:36:48', '1', 82, 1, 18),
(310, 132, 83, 'asd', '2017-05-25 07:19:30', '1', 85, 1, 22),
(311, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(312, 132, 83, 'asd', '2017-05-24 10:36:48', '1', 82, 1, 18),
(313, 132, 83, '', '2017-05-24 10:36:48', '1', 82, 1, 18),
(314, 132, 83, '', '2017-05-24 10:36:48', '1', 82, 1, 18),
(315, 132, 83, 'as', '2017-05-24 10:36:48', '1', 82, 1, 18),
(316, 132, 83, 'asd', '2017-05-24 10:36:48', '1', 82, 1, 18),
(317, 132, 83, 'asd', '2017-05-24 10:36:48', '1', 82, 1, 18),
(318, 132, 83, '12', '2017-05-24 10:36:48', '1', 82, 1, 18),
(319, 132, 83, '12', '2017-05-24 10:36:48', '1', 82, 1, 18),
(320, 132, 83, '12', '2017-05-24 10:36:48', '1', 82, 1, 18),
(321, 132, 83, '34', '2017-05-25 07:19:30', '1', 85, 1, 22),
(322, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(323, 132, 83, 'asd', '2017-05-24 10:36:48', '1', 82, 1, 18),
(324, 132, 83, '1', '2017-05-25 04:17:37', '1', 82, 1, 18),
(325, 132, 83, '2', '2017-05-25 07:19:30', '1', 85, 1, 22),
(326, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(327, 132, 83, 'sd\n', '2017-05-25 07:19:30', '1', 85, 1, 22),
(328, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(329, 132, 83, 'a\n', '2017-05-25 07:19:30', '1', 85, 1, 22),
(330, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(331, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(332, 132, 83, '**************************************', '2017-05-25 07:19:30', '1', 85, 1, 22),
(333, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(334, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(335, 132, 83, '.....\n', '2017-05-25 07:19:30', '1', 85, 1, 22),
(336, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(337, 132, 83, '...\n', '2017-05-25 07:19:30', '1', 85, 1, 22),
(338, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(339, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(340, 132, 83, '1\n', '2017-05-25 04:17:37', '1', 82, 1, 18),
(341, 132, 83, 'hi\n', '2017-05-25 07:19:30', '1', 85, 1, 22),
(342, 132, 83, '', '2017-05-25 07:19:30', '1', 85, 1, 22),
(343, 132, 83, 'hello', '2017-05-25 04:17:37', '1', 82, 1, 18),
(344, 132, 83, 'hello', '2017-05-25 04:17:37', '1', 82, 1, 18),
(345, 132, 83, '', '2017-05-25 04:17:37', '1', 82, 1, 18),
(346, 132, 83, 'hi', '2017-05-25 04:17:37', '1', 82, 1, 18),
(347, 132, 83, '', '2017-05-25 04:17:37', '1', 82, 1, 18),
(348, 132, 83, '', '2017-05-25 04:17:37', '1', 82, 1, 18),
(349, 132, 83, 'hi', '2017-05-25 04:17:37', '1', 82, 1, 18),
(350, 132, 83, '', '2017-05-25 04:17:37', '1', 82, 1, 18),
(351, 132, 83, '1', '2017-05-25 04:17:37', '1', 82, 1, 18),
(352, 132, 83, '', '2017-05-25 04:17:37', '1', 82, 1, 18),
(353, 132, 83, '', '2017-05-25 04:17:37', '1', 82, 1, 18),
(354, 132, 83, '', '2017-05-25 04:17:37', '1', 82, 1, 18),
(355, 132, 83, '', '2017-05-25 04:17:37', '1', 82, 1, 18),
(356, 132, 83, '1', '2017-05-25 04:17:37', '1', 82, 1, 18),
(357, 132, 83, '', '2017-05-25 04:17:37', '1', 82, 1, 18),
(358, 132, 83, 'asdad', '2017-05-25 04:17:37', '1', 82, 1, 18),
(359, 132, 83, '', '2017-05-25 04:17:37', '1', 82, 1, 18),
(360, 132, 83, '', '2017-05-25 04:17:37', '1', 82, 1, 18),
(361, 132, 83, '', '2017-05-25 05:59:46', '1', 82, 1, 18),
(362, 132, 83, '', '2017-05-25 05:59:46', '1', 82, 1, 18),
(363, 132, 83, '', '2017-05-25 05:59:46', '1', 82, 1, 18),
(364, 132, 83, 'hi\n', '2017-05-25 05:59:46', '1', 82, 1, 18),
(365, 132, 83, 'hello\n', '2017-05-25 05:59:46', '1', 82, 1, 18),
(366, 132, 83, 'hi', '2017-05-25 05:59:46', '1', 82, 1, 18),
(367, 132, 83, 'there\n', '2017-05-25 05:59:46', '1', 82, 1, 18),
(368, 132, 83, '1\n', '2017-05-25 05:59:46', '1', 82, 1, 18),
(369, 132, 83, '2\n', '2017-05-25 05:59:46', '1', 82, 1, 18),
(370, 132, 83, '3', '2017-05-25 05:59:46', '1', 82, 1, 18),
(371, 132, 83, '4', '2017-05-25 05:59:46', '1', 82, 1, 18),
(372, 132, 83, '1\n', '2017-05-25 05:59:46', '1', 82, 1, 18),
(373, 132, 83, '2', '2017-05-25 05:59:46', '1', 82, 1, 18),
(374, 132, 83, '', '2017-05-25 05:59:46', '1', 82, 1, 18),
(375, 132, 83, '123', '2017-05-25 05:59:46', '1', 82, 1, 18),
(376, 132, 83, 'hi', '2017-05-25 05:59:46', '1', 82, 1, 18),
(377, 132, 83, 'hello', '2017-05-25 05:59:46', '1', 82, 1, 18),
(378, 132, 83, 'all\n', '2017-05-25 07:19:30', '1', 85, 1, 22),
(379, 132, 83, 'a', '2017-05-25 05:59:46', '1', 82, 1, 18),
(380, 132, 83, 'b', '2017-05-25 05:59:46', '1', 82, 1, 18),
(381, 132, 83, '', '2017-05-25 05:59:46', '1', 82, 1, 18),
(382, 132, 83, 'hi', '2017-05-25 05:59:46', '1', 82, 1, 18),
(383, 132, 83, 'hello', '2017-05-25 05:59:46', '1', 82, 1, 18),
(384, 132, 83, '', '2017-05-25 05:59:46', '1', 82, 1, 18),
(385, 132, 83, 'asd', '2017-05-25 05:59:46', '1', 82, 1, 18),
(386, 132, 83, 'hi', '2017-05-25 05:59:46', '1', 82, 1, 18),
(387, 132, 83, 'hello', '2017-05-25 05:59:46', '1', 82, 1, 18),
(388, 132, 83, 'hey', '2017-05-25 07:19:30', '1', 85, 1, 22),
(389, 132, 83, 'kite', '2017-05-25 05:59:46', '1', 82, 1, 18),
(390, 132, 83, 'this is fine', '2017-05-25 05:59:46', '1', 82, 1, 18),
(391, 132, 83, '\nasd', '2017-05-25 05:59:46', '1', 82, 1, 18),
(392, 132, 83, 'wmv', '2017-05-25 05:59:46', '1', 82, 1, 18),
(393, 132, 83, 'a', '2017-05-25 05:59:46', '1', 82, 1, 18),
(394, 132, 83, 'asd\n\n', '2017-05-25 05:59:46', '1', 82, 1, 18),
(395, 132, 83, '12', '2017-05-25 05:59:46', '1', 82, 1, 18),
(396, 132, 83, 'check', '2017-05-25 05:59:46', '1', 82, 1, 18),
(397, 132, 83, 'hey', '2017-05-25 06:17:23', '1', 82, 1, 18),
(398, 132, 82, 'hel', '2017-05-25 06:19:58', '1', 83, 1, 18),
(399, 132, 83, 'help', '2017-05-25 06:17:23', '1', 82, 1, 18),
(400, 132, 82, '\nhi', '2017-05-25 06:19:58', '1', 83, 1, 18),
(401, 132, 83, 'hello\n', '2017-05-25 06:17:23', '1', 82, 1, 18),
(402, 132, 83, 'hi\n', '2017-05-25 06:17:23', '1', 82, 1, 18),
(403, 132, 82, '\nhello', '2017-05-25 06:19:58', '1', 83, 1, 18),
(404, 132, 83, 'hi sir\n', '2017-05-25 06:17:23', '1', 82, 1, 18),
(405, 132, 82, '\nhello student', '2017-05-25 06:19:58', '1', 83, 1, 18),
(406, 132, 82, '\nr u fine??', '2017-05-25 06:19:58', '1', 83, 1, 18),
(407, 132, 82, '\nyes u can', '2017-05-25 06:19:58', '1', 83, 1, 18),
(408, 132, 82, '\nhi', '2017-05-25 06:19:58', '1', 83, 1, 18),
(409, 132, 83, 'hello\n', '2017-05-25 06:17:23', '1', 82, 1, 18),
(410, 132, 82, '\nhi', '2017-05-25 06:19:58', '1', 83, 1, 18),
(411, 132, 83, '\nhi', '2017-05-25 06:17:23', '1', 82, 1, 18),
(412, 132, 83, '\nhi sir', '2017-05-25 06:17:23', '1', 82, 1, 18),
(413, 132, 82, '\nhello', '2017-05-25 06:19:58', '1', 83, 1, 18),
(414, 132, 83, '\nr u fine', '2017-05-25 06:17:23', '1', 82, 1, 18),
(415, 132, 82, '\nyes i am', '2017-05-25 06:19:58', '1', 83, 1, 18),
(416, 132, 83, 'hello\n', '2017-05-25 06:17:23', '1', 82, 1, 18),
(417, 132, 83, 'k xa kanxa??\n', '2017-05-25 06:18:28', '1', 82, 1, 18),
(418, 132, 83, 'hello\n', '2017-05-25 06:18:28', '1', 82, 1, 18),
(419, 132, 83, 'hi', '2017-05-25 06:20:24', '1', 82, 1, 18),
(420, 132, 83, 'hello', '2017-05-25 06:23:52', '1', 82, 1, 18),
(421, 132, 83, 'k xa kanax\n', '2017-05-25 07:18:32', '1', 82, 1, 18),
(422, 132, 82, 'thik cha dai ', '2017-05-25 07:20:21', '1', 83, 1, 18),
(423, 132, 83, 'aah sanchai xau??\n', '2017-05-25 07:18:32', '1', 82, 1, 18),
(424, 132, 82, '\nxu k xu ', '2017-05-25 07:20:21', '1', 83, 1, 18),
(425, 132, 83, '\nok khana khana jau', '2017-05-25 07:18:32', '1', 82, 1, 18),
(426, 132, 83, 'solri\n', '2017-05-25 07:18:32', '1', 82, 1, 18),
(427, 132, 85, 'hello', '2017-05-25 07:20:04', '1', 83, 1, 22),
(428, 132, 83, 'hi', '2017-05-25 07:20:14', '1', 85, 1, 22),
(429, 132, 83, 'sanchai xau', '2017-05-25 07:21:27', '1', 82, 1, 18),
(430, 132, 82, 'yes !! ma sanchai xu', '2017-05-25 07:22:53', '1', 83, 1, 18),
(431, 132, 83, 'ani timro', '2017-05-25 07:21:27', '1', 82, 1, 18),
(432, 132, 82, 'hi', '2017-05-25 07:22:53', '1', 83, 1, 18),
(433, 132, 83, '\nhello', '2017-05-25 09:34:23', '1', 82, 1, 18),
(434, 132, 82, '\nhi', '2017-05-25 09:34:31', '1', 83, 1, 18),
(435, 132, 83, 'hi', '2017-07-20 05:02:42', '1', 82, 2, 30),
(436, 132, 83, 'hello', '2017-07-20 05:02:42', '1', 82, 2, 30),
(437, 132, 83, 'hi', '2017-06-27 09:02:41', '1', 81, 1, 33),
(438, 148, 83, 'hhhhhhhhi', '2017-06-29 07:32:01', '1', 81, 1, 36);

-- --------------------------------------------------------

--
-- Table structure for table `emts_communication_attachment`
--

CREATE TABLE `emts_communication_attachment` (
  `id` bigint(20) NOT NULL,
  `msg_id` bigint(20) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_saved` varchar(50) NOT NULL,
  `file_size` float NOT NULL,
  `file_mimetype` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `emts_communication_earlier`
--

CREATE TABLE `emts_communication_earlier` (
  `id` bigint(20) NOT NULL,
  `msg_root_id` bigint(20) NOT NULL,
  `sender` int(11) NOT NULL COMMENT 'ser_id of member who send the message',
  `receiver` int(11) NOT NULL COMMENT 'user id of member who received the message',
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `inbox_status` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '1=Unread, 2=Read, 3=Delete',
  `outbox_status` enum('1','2','3') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '1=Read, 2=Unread, 3=Deleted',
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emts_communication_earlier`
--

INSERT INTO `emts_communication_earlier` (`id`, `msg_root_id`, `sender`, `receiver`, `subject`, `message`, `date`, `inbox_status`, `outbox_status`, `product_id`) VALUES
(3, 0, 1, 3, 'test', 'test message', '2016-06-13 04:52:06', '3', '1', NULL),
(4, 0, 1, 3, 'test sub', 'test message again, faskfhask hfksh fsahfhassas kfas hfhsahfas kjf safh ashf askjfh sahfs fakfh kfkas hfh fk a fsakf sf saf a', '2016-06-13 05:11:01', '3', '1', NULL),
(5, 0, 1, 3, 'tests', 'twtradgsd dsgsdg sd gds gs', '2016-06-13 10:03:40', '3', '1', NULL),
(6, 5, 3, 1, 'RE:tests', 'test message to admin', '2016-06-13 10:22:03', '2', '1', NULL),
(7, 5, 3, 1, 'RE:tests', 'test message deliver', '2016-06-13 10:23:12', '2', '1', NULL),
(8, 5, 3, 1, 'RE:tests', 'test msg admin', '2016-06-13 10:24:28', '2', '1', NULL),
(9, 0, 1, 26, 'test subject', 'test message', '2016-06-21 09:16:07', '3', '1', NULL),
(10, 0, 1, 26, 'test subject again', 'test message again', '2016-06-21 09:17:15', '3', '1', NULL),
(11, 10, 26, 1, 'RE:test subject again', 'reply message again', '2016-06-21 09:17:38', '3', '1', NULL),
(12, 10, 26, 1, 'RE:test subject again', 'test message again and again', '2016-06-21 09:18:22', '1', '1', NULL),
(13, 10, 26, 1, 'RE:test subject again', 'test again and again and again', '2016-06-21 09:52:16', '1', '1', NULL),
(14, 10, 26, 1, 'RE:test subject again', 'test test', '2016-06-21 09:52:31', '1', '1', NULL),
(15, 10, 26, 1, 'RE:test subject again', 'test reply', '2016-06-21 09:56:04', '1', '1', NULL),
(16, 10, 26, 1, 'RE:test subject again', 'test test reply\r\n', '2016-06-21 09:56:49', '1', '1', NULL),
(17, 10, 26, 1, 'RE:test subject again', 'test test reply reply', '2016-06-21 10:02:03', '1', '1', NULL),
(18, 10, 26, 1, 'RE:test subject again', 'jsldhfgl dhglkjds dshg;dskj', '2016-06-21 10:04:36', '1', '1', NULL),
(19, 10, 26, 1, 'RE:test subject again', 'sfgsdfg sdgdsgdsgds', '2016-06-21 10:05:07', '1', '1', NULL),
(20, 0, 1, 3, 'test', 'jkdhskjhsklgjds ds gkldsgds', '2016-06-21 10:15:59', '3', '1', NULL),
(21, 0, 1, 29, 'test', 'test file', '2016-07-07 06:27:34', '1', '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `emts_contact`
--

CREATE TABLE `emts_contact` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emts_contact`
--

INSERT INTO `emts_contact` (`id`, `email`, `subject`, `message`, `name`, `address`, `contact_no`) VALUES
(1, 'shresthasujan129@yahoo.com', 'asdfgh', 'asdfghjk', 'Tek Raj Shrestha', 'Freak street', ''),
(2, 'shresthasujan129@yahoo.com', 'sdfghjkl', 'sdfghjk', 'Tek Raj Shrestha', 'Freak street', ''),
(3, 'shresthasujan129@yahoo.com', 'sdfghuji', 'sdfghjkl;', 'Tek Raj Shrestha', 'Freak street', '2159788544');

-- --------------------------------------------------------

--
-- Table structure for table `emts_country`
--

CREATE TABLE `emts_country` (
  `id` bigint(20) NOT NULL,
  `country` varchar(255) NOT NULL DEFAULT '',
  `iso_code` varchar(2) NOT NULL,
  `isd_code` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emts_country`
--

INSERT INTO `emts_country` (`id`, `country`, `iso_code`, `isd_code`) VALUES
(1, 'United Kingdom', '', NULL),
(2, 'Australia', '', NULL),
(3, 'Canada', '', NULL),
(4, 'Ireland', '', NULL),
(5, 'New Zealand', '', NULL),
(6, 'Angola', '', NULL),
(7, 'Antigua', '', NULL),
(8, 'Argentina', '', NULL),
(9, 'Armenia', '', NULL),
(10, 'Australia', '', NULL),
(11, 'Austria', '', NULL),
(12, 'Azerbaijan', '', NULL),
(13, 'Bahamas', '', NULL),
(14, 'Bahrain', '', NULL),
(15, 'Bangladesh', '', NULL),
(16, 'Barbados', '', NULL),
(17, 'Belarus', '', NULL),
(18, 'Belgium', '', NULL),
(19, 'Belize', '', NULL),
(20, 'Benin', '', NULL),
(21, 'Bhutan', '', NULL),
(22, 'Bolivia', '', NULL),
(23, 'Bosnia', '', NULL),
(24, 'Herzegovina', '', NULL),
(25, 'Botswana', '', NULL),
(26, 'Brazil', '', NULL),
(27, 'Brunei', '', NULL),
(28, 'Bulgaria', '', NULL),
(29, 'Barbuda', '', NULL),
(30, 'Burkina Faso', '', NULL),
(31, 'Burma', '', NULL),
(32, 'Burundi', '', NULL),
(33, 'Cambodia', '', NULL),
(34, 'Cameroon', '', NULL),
(35, 'Afghanistan', '', NULL),
(36, 'Cape Verde', '', NULL),
(37, 'Central African Republic', '', NULL),
(38, 'Chad', '', NULL),
(39, 'Chile', '', NULL),
(40, 'China', '', NULL),
(41, 'Colombia', '', NULL),
(42, 'Comoros', '', NULL),
(43, 'Congo (Brazzaville)', '', NULL),
(44, 'Congo (Kinshasa)', '', NULL),
(45, 'Costa Rica', '', NULL),
(46, 'Cote d\'Ivoire', '', NULL),
(47, 'Croatia', '', NULL),
(48, 'Cuba', '', NULL),
(49, 'Cyprus', '', NULL),
(50, 'Czech Republic', '', NULL),
(51, 'Denmark', '', NULL),
(52, 'Djibouti', '', NULL),
(53, 'Dominica', '', NULL),
(54, 'Dominican Republic', '', NULL),
(55, 'Ecuador', '', NULL),
(56, 'Egypt', '', NULL),
(57, 'El Salvador', '', NULL),
(58, 'Equatorial Guinea', '', NULL),
(59, 'Eritrea', '', NULL),
(60, 'Estonia', '', NULL),
(61, 'Ethiopia', '', NULL),
(62, 'Fiji', '', NULL),
(63, 'Finland', '', NULL),
(64, 'France', '', NULL),
(65, 'Gabon', '', NULL),
(66, 'Gambia', '', NULL),
(67, 'Georgia', '', NULL),
(68, 'Germany', '', NULL),
(69, 'Ghana', '', NULL),
(70, 'Greece', '', NULL),
(71, 'Grenada', '', NULL),
(72, 'Guatemala', '', NULL),
(73, 'Guinea', '', NULL),
(74, 'Guinea-Bissau', '', NULL),
(75, 'Guyana', '', NULL),
(76, 'Haiti', '', NULL),
(77, 'Holy See', '', NULL),
(78, 'Honduras', '', NULL),
(79, 'Hungary', '', NULL),
(80, 'Iceland', '', NULL),
(81, 'India', '', NULL),
(82, 'Indonesia', '', NULL),
(83, 'Iran', '', NULL),
(84, 'Iraq', '', NULL),
(86, 'Israel', '', NULL),
(87, 'Italy', '', NULL),
(88, 'Jamaica', '', NULL),
(89, 'Japan', '', NULL),
(90, 'Jordan', '', NULL),
(91, 'Kazakhstan', '', NULL),
(92, 'Kenya', '', NULL),
(93, 'Kiribati', '', NULL),
(94, 'North Korea', '', NULL),
(95, 'South Korea', '', NULL),
(96, 'Kuwait', '', NULL),
(97, 'Kyrgyzstan', '', NULL),
(98, 'Laos', '', NULL),
(99, 'Latvia', '', NULL),
(100, 'Lebanon', '', NULL),
(101, 'Lesotho', '', NULL),
(102, 'Liberia', '', NULL),
(103, 'Libya', '', NULL),
(104, 'Liechtenstein', '', NULL),
(105, 'Lithuania', '', NULL),
(106, 'Luxembourg', '', NULL),
(107, 'Macedonia', '', NULL),
(108, 'Madagascar', '', NULL),
(109, 'Malaqi', '', NULL),
(110, 'Malaysia', '', NULL),
(111, 'Maldives', '', NULL),
(112, 'Mali', '', NULL),
(113, 'Malta', '', NULL),
(114, 'Marshall Islands', '', NULL),
(115, 'Mauritania', '', NULL),
(116, 'Mauritius', '', NULL),
(117, 'Mexico', '', NULL),
(118, 'Micronesia', '', NULL),
(119, 'Moldova', '', NULL),
(120, 'Monaco', '', NULL),
(121, 'Mongolia', '', NULL),
(122, 'Morocco', '', NULL),
(123, 'Mozambique', '', NULL),
(124, 'Namibia', '', NULL),
(125, 'Nauru', '', NULL),
(126, 'Nepal', '', NULL),
(127, 'Netherlands', '', NULL),
(128, 'Andorra', '', NULL),
(129, 'Nicaragua', '', NULL),
(130, 'Niger', '', NULL),
(131, 'Nigeria', '', NULL),
(132, 'Norway', '', NULL),
(133, 'Oman', '', NULL),
(134, 'Pakistan', '', NULL),
(135, 'Palau', '', NULL),
(136, 'Panama', '', NULL),
(137, 'Papua New Guinea', '', NULL),
(138, 'Paraguay', '', NULL),
(139, 'Peru', '', NULL),
(140, 'Philippines', '', NULL),
(141, 'Polska', '', NULL),
(142, 'Portugal', '', NULL),
(143, 'Qatar', '', NULL),
(144, 'Romania', '', NULL),
(145, 'Russia', '', NULL),
(146, 'Rwanda', '', NULL),
(147, 'Saint Kitts & Nevis', '', NULL),
(148, 'Saint Lucia', '', NULL),
(149, 'Saint Vincent & the Grenadines', '', NULL),
(150, 'Samoa', '', NULL),
(151, 'San Marino', '', NULL),
(152, 'Sao Tome & Principe', '', NULL),
(153, 'Saudi Arabia', '', NULL),
(154, 'Senegal', '', NULL),
(155, 'Seychelles', '', NULL),
(156, 'Sierra Leone', '', NULL),
(157, 'Singapore', '', NULL),
(158, 'Slovakia', '', NULL),
(159, 'Slovenia', '', NULL),
(160, 'Solomon Islands', '', NULL),
(161, 'Somalia', '', NULL),
(162, 'South Africa', '', NULL),
(163, 'Spain', '', NULL),
(164, 'Sri Lanka', '', NULL),
(165, 'Sudan', '', NULL),
(166, 'Suriname', '', NULL),
(167, 'Swaziland', '', NULL),
(168, 'Sweden', '', NULL),
(169, 'Switzerland', '', NULL),
(170, 'Syria', '', NULL),
(171, 'Tajikistan', '', NULL),
(172, 'Tanzania', '', NULL),
(173, 'Thailand', '', NULL),
(174, 'Togo', '', NULL),
(175, 'Tonga', '', NULL),
(176, 'Trinidad & Tobago', '', NULL),
(177, 'Tunisia', '', NULL),
(178, 'Turkey', '', NULL),
(179, 'Turkmenistan', '', NULL),
(180, 'Tuvalu', '', NULL),
(181, 'Uganda', '', NULL),
(182, 'Ukraine', '', NULL),
(183, 'United Arab Emirates', '', NULL),
(184, 'United States', '', NULL),
(185, 'Uruguay', '', NULL),
(186, 'Uzbekistan', '', NULL),
(187, 'Vanuatu', '', NULL),
(188, 'Venezuela', '', NULL),
(189, 'Vietnam', '', NULL),
(190, 'Yemen', '', NULL),
(191, 'Yugoslavia', '', NULL),
(192, 'Zambia', '', NULL),
(193, 'Zimbabwe', '', NULL),
(194, 'Taiwan', '', NULL),
(195, 'N. Ireland', '', NULL),
(196, 'Republic of Ireland', '', NULL),
(197, 'Albania', '', NULL),
(198, 'Algeria', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `emts_draft_promotion`
--

CREATE TABLE `emts_draft_promotion` (
  `id` int(11) NOT NULL,
  `bid_id` int(11) DEFAULT NULL,
  `description` text,
  `link` varchar(200) DEFAULT NULL,
  `draft_accept` enum('0','1','2') NOT NULL COMMENT '0->No Action,1->Draft accepted,2->Draft rejected',
  `DATE` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_draft_promotion`
--

INSERT INTO `emts_draft_promotion` (`id`, `bid_id`, `description`, `link`, `draft_accept`, `DATE`) VALUES
(1, 98, 'asdfgh', 'sxdcfghjkl;', '0', '2017-08-21 17:41:20');

-- --------------------------------------------------------

--
-- Table structure for table `emts_email_settings`
--

CREATE TABLE `emts_email_settings` (
  `id` int(11) NOT NULL,
  `email_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `sms_text` text COLLATE utf8_unicode_ci NOT NULL,
  `last_update` datetime NOT NULL,
  `email_type` enum('1','2','3') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Admin, 2=Buyer, 3=Seller',
  `is_display_notification` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=disable, 1=enable ; in the user account',
  `is_email_notification_send` enum('0','1') COLLATE utf8_unicode_ci DEFAULT '1' COMMENT '0=No, 1=Yes ',
  `is_sms_notification_send` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0=No,1=Yes',
  `listing_order` int(11) NOT NULL COMMENT 'Display Order in the backend  and front end',
  `enable_rating` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=disable, 1=enable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emts_email_settings`
--

INSERT INTO `emts_email_settings` (`id`, `email_code`, `subject`, `email_body`, `sms_text`, `last_update`, `email_type`, `is_display_notification`, `is_email_notification_send`, `is_sms_notification_send`, `listing_order`, `enable_rating`) VALUES
(1, 'register_notification', 'Registration Notification', '<p>\r\n Hello <strong>[USERNAME]</strong>,</p>\r\n<p>\r\n Your account was successfully created.</p>\r\n<p>\r\n Your login information is as follows:</p>\r\n<p>\r\n Email: <strong>[EMAIL]</strong><br>\r\n  </p>\r\n<p>\r\n <br>\r\n <strong>[SITENAME]</strong></p>\r\n', 'Hello [EMAIL],\r\n\r\nYour account was successfully created. You will be noified shortly after verification\r\n\r\nYour login information is as follows:\r\n\r\nEmail: [EMAIL]\r\nPassword: [PASSWORD]\r\n\r\nThe reverseauction.com Support Team\r\n[SITENAME]', '2016-08-22 15:50:58', '1', '0', '1', '0', 0, '1'),
(3, 'email_confirmation', 'Email Confirmation', '<p>\r\n Hey <strong>[USERNAME]</strong></p>\r\n<p>\r\n click and follow the link below  to confirm your new email address</p>\r\n<p>\r\n <span>[CONFIRM]</span></p>\r\n<p>\r\n <strong>The Vid.energy Support Team<br>\r\n [SITENAME]</strong></p>\r\n', 'Hey [USERNAME]\r\n\r\nclick and follow the link below  to confirm your new email address\r\n\r\n[CONFIRM]\r\n\r\nThe hightreegroup.com Support Team\r\n[SITENAME]', '2017-01-25 11:48:24', '1', '1', '1', '0', 0, '1'),
(5, 'payment_status_email', 'Payment Completed', '<p>\r\n Hello <strong>[USERNAME]</strong>,</p>\r\n<p>\r\n Your Payment information is as follows:</p>\r\n<p>\r\n Invoice ID: <strong> [INVOICE_ID]</strong><br>\r\n Payment Method:<strong> [PAYMENT_METHOD]</strong><br>\r\n Paid Amount:<strong> [PAID_AMOUNT]</strong></p>\r\n<p>\r\n Current Balance : <strong>[CURRENT_BALANCE]</strong></p>\r\n<p>\r\n Payment Date: <strong> [PAYMENT_DATE]</strong><br>\r\n  </p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2017-03-29 17:34:48', '1', '1', '1', '0', 0, '1'),
(7, 'payment_status_admin', 'Payment Completed -Admin', '<p>\r\n Hello Admin,</p>\r\n<p>\r\n Payment is made for the Campaign.Payment details are mentioned below.</p>\r\n<p>\r\n <strong>Payment Information</strong><br>\r\n Invoice ID: <strong> [INVOICE_ID]</strong></p>\r\n<p>\r\n Paid Amount:<strong> [PAID_AMOUNT]</strong><br>\r\n Payment Method:<strong> [PAYMENT_METHOD]</strong><br>\r\n New Balance : <strong>[CURRENT_BALANCE]</strong><br>\r\n Payment Date: <strong> [PAYMENT_DATE]</strong></p>\r\n<p>\r\n <strong>Member Information</strong><br>\r\n Member ID: <strong>[USER_ID]</strong><br>\r\n Member Name: <strong>[USERNAME]</strong></p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2017-05-15 15:54:57', '1', '1', '1', '0', 0, '1'),
(9, 'promotion_completed_admin', 'Promotion Completed', '<p>\r\n Hello <strong>[SELLER]</strong>,</p>\r\n<p>\r\n Payment is made for the product. Product and buyer details are mentioned below.</p>\r\n<p>\r\n <strong>Product Information</strong><br>\r\n Product ID: <strong>[PRODUCT_ID]</strong><br>\r\n Product Name: <strong>[PRODUCT_NAME]</strong><br>\r\n Payment Method:<strong> [PAYMENT_METHOD]</strong><br>\r\n Paid Amount: <strong> [PAID_AMOUNT]</strong><br>\r\n Payment Date: <strong> [DATE]</strong></p>\r\n<p>\r\n <strong>Member Information</strong><br>\r\n Member ID: <strong>[BUYER_ID]</strong><br>\r\n Member Name: <strong>[BUYER_NAME]</strong></p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2016-08-09 15:48:18', '1', '1', '1', '0', 0, '1'),
(11, 'forgot_password_notification', 'Login details', '<p>\r\n Hello <strong>[EMAIL]</strong>,<br>\r\n <br>\r\n Your login information is as follows:<br>\r\n <br>\r\n Email: <strong>[EMAIL]</strong><br>\r\n Password: <strong> [PASSWORD]</strong></p>\r\n<p>\r\n <span>Sincerely,</span></p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2016-08-09 15:48:28', '1', '1', '1', '0', 0, '1'),
(13, 'change_password_user', 'Password Changed', '<p>\r\n Hello <strong>[USERNAME]</strong>,<br>\r\n <br>\r\n तपाईंको लगइन पासवर्ड परिवर्तन गरिएको छ। निम्नानुसार तपाईंको नयाँ लगइन विवरण छ:<br>\r\n <br>\r\n Username: <strong>[USERNAME]</strong><br>\r\n Password: <strong> [PASSWORD]</strong></p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2016-08-09 15:48:36', '1', '1', '1', '0', 0, '1'),
(15, 'draft_promotion_received', 'Draft Promotion Received', '<p>\r\n Hi [<strong>EMAIL</strong>],</p>\r\n<p>\r\n Your Post has received a Draft of promotion.The following draft is received.</p>\r\n<p>\r\n Post Name : <strong>[POST_NAME]</strong></p>\r\n<p>\r\n Sent by : <strong>[SENDER_EMAIL]</strong></p>\r\n<p>\r\n Description : <strong>[DESCRIPTION]</strong></p>\r\n<p>\r\n Link: <strong>[LINK]</strong></p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong>[SITENAME]</strong></p>\r\n', '', '2017-02-15 16:54:51', '1', '1', '1', '0', 0, '1'),
(17, 'product_delivered_email_winnner', 'Product Delivered', '<p>\r\n Hi [USERNAME],</p>\r\n<p>\r\n The below product has been Delivered to your shipping address.</p>\r\n<p>\r\n Invoice No: [INVOICE_ID]</p>\r\n<p>\r\n Product Name: [PRODUCT_NAME]</p>\r\n<p>\r\n Shipped Date: [DATE]</p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n  </p>\r\n<p>\r\n <strong>[SITENAME]</strong></p>\r\n', '', '2016-08-09 15:49:27', '1', '1', '1', '0', 0, '1'),
(19, 'final_payment_won_bid', 'Final payment for won bid', '<p>\r\n Hi [USERNAME],</p>\r\n<p>\r\n Shipping of below product has been cancelled</p>\r\n<p>\r\n Invoice No: [INVOICE_ID]</p>\r\n<p>\r\n Product Name: [PRODUCT_NAME]</p>\r\n<p>\r\n  </p>\r\n<p>\r\n <strong>[SITENAME] </strong></p>\r\n', '', '2016-08-09 15:49:37', '1', '1', '1', '0', 0, '1'),
(21, 'product_won_notification_user', 'Product Won Notification', '<p>\r\n Hello <strong>[EMAIL]</strong>,</p>\r\n<p>\r\n You have been awarded the below product with invoie id <strong>[INVOICE]</strong></p>\r\n<p>\r\n Product Name: <strong>[PRODUCTNAME]</strong><br>\r\n Won Amount:<strong> [AMOUNT]</strong><br>\r\n Closed Date: <strong> [DATE]</strong></p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2016-08-09 15:50:09', '1', '1', '1', '0', 0, '1'),
(23, 'auction_closed_notification_seller', 'Product Sold Notification', '<p>\r\n Hello <strong>[SELLER_NAME]</strong>,</p>\r\n<p>\r\n One of your product in Auction has been Closed. Product and buyer details are mentioned below.</p>\r\n<p>\r\n <strong>Product Information</strong><br>\r\n Product Category:<strong> [PRODUCT_CATEGORY]  >> [PRODUCT_SUBCATEGORY]</strong><br>\r\n Product Name: <strong>[PRODUCT_NAME]</strong><br>\r\n Product Code: <strong>[AUCTION_ID]</strong></p>\r\n<p>\r\n Won Amount: <strong>[AMOUNT]</strong><br>\r\n Closed Date: <strong> [DATE]</strong></p>\r\n<p>\r\n <strong>Winner Information</strong><br>\r\n Member ID: <strong>[USER_ID]</strong><br>\r\n Member Name: <strong>[USERNAME]</strong></p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2016-08-09 15:50:17', '1', '1', '1', '0', 0, '1'),
(25, 'auction_closed_notification_admin', 'Auction Closed Notification', '<p>\r\n Hello <strong>Admin</strong>,</p>\r\n<p>\r\n One of the product in Auction has been Closed. Product, Seller and buyer details are mentioned below.</p>\r\n<p>\r\n <strong>Product Information</strong><br>\r\n Product Category:<strong> [PRODUCT_CATEGORY]  >> [PRODUCT_SUBCATEGORY]</strong><br>\r\n Product Name: <strong>[PRODUCT_NAME]</strong><br>\r\n Product Code: <strong>[AUCTION_ID]</strong></p>\r\n<p>\r\n Won Amount: <strong>[AMOUNT]</strong></p>\r\n<p>\r\n Closed Date: <strong> [DATE]</strong></p>\r\n<p>\r\n <strong>Seller Information</strong><br>\r\n Seller ID: <strong>[SELLER_ID]</strong><br>\r\n Seller Name: <strong>[SELLER_NAME]</strong></p>\r\n<p>\r\n <strong>Winner Information</strong><br>\r\n Member ID: <strong>[USER_ID]</strong><br>\r\n Member Name: <strong>[USERNAME]</strong></p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2016-08-09 15:50:25', '1', '1', '1', '0', 0, '1'),
(27, 'communication-from-seller', 'Email from seller', '<p>\r\n Hello <strong>Admin</strong>,</p>\r\n<p>\r\n Email from the seller  <strong>[SELLER_NAME]-[SELLER_ID]</strong></p>\r\n<p>\r\n Subject :<strong> [SUBJECT]</strong></p>\r\n<p>\r\n Message: <strong>[MESSAGE]</strong></p>\r\n<p>\r\n  </p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2016-08-09 15:50:32', '1', '1', '1', '0', 0, '1'),
(29, 'communication-from-admin', 'Email from admin', '<p>\r\n Hello<strong> [SELLER_NAME]-[SELLER_ID],</strong></p>\r\n<p>\r\n Email from the admin </p>\r\n<p>\r\n Subject :<strong> [SUBJECT]</strong></p>\r\n<p>\r\n Message: <strong>[MESSAGE]</strong></p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2016-08-09 15:50:39', '1', '1', '1', '0', 0, '1'),
(31, 'listing_fee_payment_notification_admin', 'Payment made for Product Listing', '<p>\r\n Hello Admin,</p>\r\n<p>\r\n Payment is made for the Listing product. Product and Seller details are mentioned below.</p>\r\n<p>\r\n <strong>Product Information</strong><br>\r\n Invoice ID: <strong> [INVOICE_ID]</strong><br>\r\n Paid Amount:<strong> [PAID_AMOUNT]</strong><br>\r\n Payment Method:<strong> [PAYMENT_METHOD]</strong><br>\r\n Product Id: <strong> [PRODUCT_ID]</strong><br>\r\n Product Name: <strong> [PRODUCT_NAME]</strong><br>\r\n Payment Date: <strong> [DATE]</strong></p>\r\n<p>\r\n <strong>Seller Information</strong><br>\r\n Seller (Member) ID: <strong>[USER_ID]</strong><br>\r\n Seller (Member) Name: <strong>[USERNAME]</strong></p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2016-08-09 15:50:46', '1', '1', '1', '0', 0, '1'),
(33, 'product_rejected', 'Campaign Rejected', '<p>\r\n Hello <strong>[USER]</strong>,</p>\r\n<p>\r\n Your campaign [CAMPAIGN_NAME] is Rejected by Admin. Please Loot at the description of product:</p>\r\n<p>\r\n  </p>\r\n<p>\r\n Campaign Name : <strong>[CAMPAIGN_NAME]</strong></p>\r\n<p>\r\n Description : [DESCRIPTION]</p>\r\n<p>\r\n Product Name : [PRODUCT_NAME]</p>\r\n<p>\r\n Product Url : [PRODUCT_URL]</p>\r\n<p>\r\n <br>\r\n <strong>[SITENAME]</strong></p>\r\n', '', '2017-08-10 14:33:52', '1', '1', '1', '0', 0, '1'),
(35, 'bid_proposal_accepted', 'Proposal Accepted', '<p>\n Hello <strong>[USERNAME]</strong>,</p>\n<p>\n You have successfully paid for the auction you have won. Payment information is as follows:</p>\n<p>\n Invoice ID: <strong> [INVOICE_ID]</strong><br>\n Product Id: <strong> [PRODUCT_ID]</strong><br>\n Product Name: <strong> [PRODUCT_NAME]</strong><br>\n Paid Amount:<strong> [PAID_AMOUNT]</strong><br>\n Payment Method:<strong> [PAYMENT_METHOD]</strong><br>\n Payment Date: <strong> [PAYMENT_DATE]</strong></p>\n<p>\n Sincerely,</p>\n<p>\n <strong><br>\n [SITENAME]</strong></p>\n', '', '2016-08-09 15:51:00', '1', '1', '1', '0', 0, '1'),
(37, 'bid_proposal_rejected', 'Proposal Rejected', '<p>\r\n Hello Admin,</p>\r\n<p>\r\n Payment is made for won auction. Product and winner details are mentioned below.</p>\r\n<p>\r\n <strong>Product Information</strong><br>\r\n Invoice ID: <strong> [INVOICE_ID]</strong><br>\r\n Product ID: <strong> [PRODUCT_ID]</strong><br>\r\n Product Name: <strong> [PRODUCT_NAME]</strong><br>\r\n Paid Amount:<strong> [PAID_AMOUNT]</strong><br>\r\n Payment Method:<strong> [PAYMENT_METHOD]</strong><br>\r\n Payment Date: <strong> [DATE]</strong></p>\r\n<p>\r\n <strong>Winner Information</strong><br>\r\n Member ID: <strong>[USER_ID]</strong><br>\r\n Member Name: <strong>[USERNAME]</strong></p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2016-08-09 15:51:15', '1', '1', '1', '0', 0, '1'),
(38, 'paid_for_auction_notification_admin', 'Pay for Won Auction Notification - Admin', '<p>\r\n Hello Admin,</p>\r\n<p>\r\n Payment is made for won auction. Product and winner details are mentioned below.</p>\r\n<p>\r\n <strong>Product Information</strong><br>\r\n Invoice ID: <strong> [INVOICE_ID]</strong><br>\r\n Product ID: <strong> [PRODUCT_ID]</strong><br>\r\n Product Name: <strong> [PRODUCT_NAME]</strong><br>\r\n Paid Amount:<strong> [PAID_AMOUNT]</strong><br>\r\n Payment Method:<strong> [PAYMENT_METHOD]</strong><br>\r\n Payment Date: <strong> [DATE]</strong></p>\r\n<p>\r\n <strong>Winner Information</strong><br>\r\n Member ID: <strong>[USER_ID]</strong><br>\r\n Member Name: <strong>[USERNAME]</strong></p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2016-08-09 15:51:15', '1', '1', '1', '0', 0, '1'),
(39, 'paid_for_auction_notification_seller', 'Pay for Won Auction Notification - Seller', '<p>\r\n Hello <strong>[SELLER]</strong>,</p>\r\n<p>\r\n Payment is made by winner for one of your product in auction. Product and winner details are mentioned below.</p>\r\n<p>\r\n <strong>Product Information</strong><br>\r\n Product ID: <strong>[PRODUCT_ID]</strong><br>\r\n Product Name: <strong>[PRODUCT_NAME]</strong><br>\r\n Payment Method:<strong> [PAYMENT_METHOD]</strong><br>\r\n Paid Amount: <strong> [PAID_AMOUNT]</strong><br>\r\n Payment Date: <strong> [DATE]</strong></p>\r\n<p>\r\n <strong>Winner Information</strong><br>\r\n Member ID: <strong>[BUYER_ID]</strong><br>\r\n Member Name: <strong>[<strong>BUYER</strong>_NAME]</strong></p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2016-08-09 15:52:02', '1', '1', '1', '0', 0, '1'),
(40, 'paid_for_auction_notification_seller', 'Pay for Won Auction Notification - Seller', '<p>\r\n Hello <strong>[SELLER]</strong>,</p>\r\n<p>\r\n Payment is made by winner for one of your product in auction. Product and winner details are mentioned below.</p>\r\n<p>\r\n <strong>Product Information</strong><br>\r\n Product ID: <strong>[PRODUCT_ID]</strong><br>\r\n Product Name: <strong>[PRODUCT_NAME]</strong><br>\r\n Payment Method:<strong> [PAYMENT_METHOD]</strong><br>\r\n Paid Amount: <strong> [PAID_AMOUNT]</strong><br>\r\n Payment Date: <strong> [DATE]</strong></p>\r\n<p>\r\n <strong>Winner Information</strong><br>\r\n Member ID: <strong>[BUYER_ID]</strong><br>\r\n Member Name: <strong>[<strong>BUYER</strong>_NAME]</strong></p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2016-08-09 15:52:02', '1', '1', '1', '0', 0, '1'),
(41, 'auction_cancel_notification_seller', 'Auction Cancel Notification- User', '<p>\r\n Hello <strong>[email]</strong>,</p>\r\n<p>\r\n One of your auction has been cancelled.</p>\r\n<p>\r\n Product Details: <strong>[product_details]</strong></p>\r\n<p>\r\n Product Name: <strong> [product_name]</strong><br>\r\nPrice Range:<strong> [price_range]</strong><br>\r\n Submission Deadline: <strong> [submission_deadline]</strong></p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2016-08-09 15:52:08', '1', '1', '1', '0', 0, '1'),
(42, 'auction_update_notification_user', 'Auction Status Changed Notification- User', '<p>\r\n Hello <strong>[email]</strong>,</p>\r\n<p>\r\n Your Auction has been  <strong>[</strong><strong>status</strong><strong>] </strong>.</p>\r\n<p>\r\n Campaign Name: <strong><strong>[product_name]</strong></strong><br>\r\nCampaign Details: <strong><strong>[product_details]</strong></strong><br>\r\n Price Range:<strong> [price_range]</strong><br>\r\n <strong>[</strong><strong>status</strong><strong>]</strong> Date: <strong> [DATE]</strong></p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n<p>\r\n  </p>\r\n<p>\r\n  </p>\r\n<p>\r\n [status]</p>\r\n', '', '2016-08-09 15:52:16', '1', '1', '1', '0', 0, '1'),
(43, 'auction_cancel_notification_admin', 'Auction Cancel Notification-Admin', '<p>\n Hello <strong>Admin,</strong></p>\n<p>\n One of the auction has been cancelled</p>\n<p>\n Details:</p>\n<p>\n Product Name: <strong> [PRODUCT_NAME]</strong></p>\n<p>\n Won Amount:<strong> [AMOUNT]</strong><br />\n Closed Date: <strong> [DATE]</strong></p>\n<p>\n Sincerely,</p>\n<p>\n <strong>The bidcy.com Support Team<br />\n [SITENAME]</strong></p>\n', '', '2014-08-12 14:50:42', '1', '1', '1', '0', 0, '1'),
(47, 'auction_cancel_notification_user', 'Campaign Cancel Notification', '<p>\r\n Hello <strong>[EMAIL]</strong>,</p>\r\n<p>\r\n One of your campaign has been cancelled for following reason: </p>\r\n<p>\r\n <strong>[reject_reason]</strong></p>\r\n<p>\r\n Campaign Name: <strong>[product_name]</strong></p>\r\n<p>\r\n Product Details : <strong>[product_details]</strong></p>\r\n<p>\r\n Price Range:<strong> [price_range]</strong><br>\r\n Submission Deadline : <strong> [submission_deadline]</strong></p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2017-02-17 12:00:34', '1', '1', '1', '0', 0, '1'),
(49, 'verification-notification', 'Verification Notification', '<p>\r\n Hello <strong>[EMAIL]</strong>,</p>\r\n<p>\r\n You are now verified to bid on products</p>\r\n<p>\r\n The reverseauction.com Support Team<br>\r\n <strong>[SITENAME]</strong></p>\r\n', 'Hello Admin\n\nUser [EMAIL] just registered in your app. Check his/her verification documents\n\nThe reverse.com Support Team\n[SITENAME]', '2016-06-23 10:37:18', '1', '0', '1', '0', 0, '1'),
(50, 'product_published', 'Product Published', '<p>\n Hello <strong>[USER]</strong>,</p>\n<p>\n Your campaign [CAMPAIGN_NAME] is Approved by Admin. Please Loot at the description of product:</p>\n<p>\n  </p>\n<p>\n Campaign Name : <strong>[CAMPAIGN_NAME]</strong></p>\n<p>\n Description : [DESCRIPTION]</p>\n<p>\n Product Name : [PRODUCT_NAME]</p>\n<p>\n Product Url : [PRODUCT_URL]</p>\n<p>\n <br>\n <strong>[SITENAME]</strong></p>\n', '', '2017-08-10 14:27:48', '1', '1', '1', '0', 0, '1'),
(51, 'verification-notification-admin', 'Verification Notification', '<p>\r\n Hello <strong>Admin</strong></p>\r\n<p>\r\n User <strong>[EMAIL] </strong> just registered in your app. Check his/her verification documents</p>\r\n<p>\r\n The reverse.com Support Team<br>\r\n <strong>[SITENAME]</strong></p>\r\n', 'Hello Admin\r\n\r\nUser [EMAIL] just registered in your app. Check his/her verification documents\r\n\r\nThe reverse.com Support Team\r\n[SITENAME]', '2016-06-23 10:40:49', '1', '0', '1', '0', 0, '1'),
(52, 'email_header', 'Email Header', '', '', '0000-00-00 00:00:00', '1', '1', '1', '0', 0, '1'),
(53, 'email_footer', 'Email Footer', '', '', '2016-06-23 12:00:00', '1', '1', '1', '0', 0, '1'),
(54, 'contact', 'Contact us', '<p>\r\n <strong>[message]</strong></p>\r\n<p>\r\n  </p>\r\n<p>\r\n Regards,</p>\r\n<p>\r\n <strong>[name]</strong>,</p>\r\n<p>\r\n <strong>[contact]</strong>,</p>\r\n<p>\r\n <strong>[email]</strong></p>\r\n', '', '2016-07-29 14:16:12', '1', '1', '1', '0', 0, '1'),
(55, 'send_password_reset_link', 'Password Reset link', '<p>\r\n Hello,<br>\r\n <br>\r\n <span xss=\"removed\">You can use the following </span><span class=\"il\" xss=\"removed\">link</span><span xss=\"removed\"> within the next day to </span><span class=\"il\" xss=\"removed\">reset</span><span xss=\"removed\"> your </span><span class=\"il\" xss=\"removed\">password</span><span xss=\"removed\">: [reset_link]</span><br>\r\n <br>\r\n  </p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', '', '2016-08-09 15:52:52', '1', '1', '1', '0', 0, '1'),
(56, 'campaign_created_admin', 'New Campaign Created', '<div id=\"cke_pastebin\">\r\n <p>\r\n   </p>\r\n</div>\r\n<div id=\"cke_pastebin\">\r\n  Hello Admin<b>,</b></div>\r\n<div>\r\n  </div>\r\n<div>\r\n This Campaign has been added please view the detail:</div>\r\n<div>\r\n  </div>\r\n<div>\r\n Campaign Type: <strong>[campaign_type]</strong></div>\r\n<div>\r\n  </div>\r\n<div id=\"cke_pastebin\">\r\n Campaign Name: <strong><strong>[campaign_name]</strong></strong></div>\r\n<p>\r\n Campaign Added By: <strong><strong>[username]</strong></strong></p>\r\n<div>\r\n <strong>url: [product_url]</strong></div>\r\n<div>\r\n  </div>\r\n<div>\r\n Description:<strong>[description]</strong></div>\r\n<p>\r\n  </p>\r\n<div id=\"cke_pastebin\">\r\n <p>\r\n   Sincerely,</p>\r\n</div>\r\n<div id=\"cke_pastebin\">\r\n <p>\r\n   </p>\r\n</div>\r\n<div id=\"cke_pastebin\">\r\n <strong> [SITENAME]</strong>\r\n <p>\r\n   </p>\r\n</div>\r\n<div id=\"cke_pastebin\">\r\n <div id=\"cke_pastebin\">\r\n   </div>\r\n <div>\r\n  <strong><br>\r\n  </strong></div>\r\n</div>\r\n', '1234', '2017-07-20 10:59:58', '1', '1', '1', '0', 0, '1'),
(57, 'remaining_membership', 'Your remaining Membership Package Information', '<p>\r\n Dear <strong>[user],</strong></p>\r\n<p>\r\n Your membership information is given below:</p>\r\n<p>\r\n Free post : <strong>[FreePost]</strong></p>\r\n<p>\r\n Memebership Type: <strong>[MembershipType]</strong></p>\r\n<p>\r\n Validity : <strong>[vaildity]</strong></p>\r\n<p>\r\n  </p>\r\n<p>\r\n <strong>[</strong>SITENAME<strong>]</strong></p>\r\n', 'asdadad', '2016-08-23 16:11:06', '1', '1', '1', '0', 0, '1'),
(58, 'campaign_completed_brand', 'Campaign Closed Notification-Brand', '<p>\r\n Hello <strong>[username]</strong>,</p>\r\n<p>\r\n The product you added has been closed. The details is given below:</p>\r\n<p>\r\n Campaign name : <strong>[product_name]</strong>,</p>\r\n<p>\r\n Price Range: <strong>[price_range]  [budget]</strong>,</p>\r\n<p>\r\n Submission_deadline : <strong>[submission_deadline],</strong></p>\r\n<p>\r\n CampaignClosed Date: <strong>[auc_end_time],</strong></p>\r\n<p>\r\n Number of bidders: <strong>[no_bidder]</strong></p>\r\n<p>\r\n <strong>[SITENAME]</strong></p>\r\n', 'asdasd', '2017-02-17 11:49:21', '1', '1', '1', '0', 0, '1'),
(59, 'campaign_completed_influencer', 'Campaign Closed Notification-Creator', '<p>\r\n Dear <strong>[USERNAME]</strong>,</p>\r\n<p>\r\n The following Auction has been closed. Winner announcement is still in process. You will be Notified if you are selected as winner.</p>\r\n<p>\r\n Find the detail below.</p>\r\n<p>\r\n  </p>\r\n<p>\r\n Campaign  Name: <strong>[product_name],</strong></p>\r\n<p>\r\n Submission Deadline : <strong>[auc_end_date]</strong>,</p>\r\n<p>\r\n Price Range : <strong>[CURRENCY]  [price_range]</strong>,</p>\r\n<p>\r\n  </p>\r\n<p>\r\n Thank you,</p>\r\n<p>\r\n <strong>[SITENAME]</strong></p>\r\n', 'asd', '2017-02-17 11:53:26', '1', '1', '1', '0', 0, '1'),
(60, 'membership_expire_notification', 'Alert: Membership Expiring soon', '<p>\r\n Dear <strong>[USER],</strong></p>\r\n<p>\r\n Your membership is about to expire. You have 30 days to expire for the your membership.</p>\r\n<p>\r\n Membership Type : Unlimited</p>\r\n<p>\r\n Thankyou</p>\r\n<p>\r\n <strong>[SITENAME]</strong></p>\r\n', 'asd', '2016-08-24 12:36:03', '1', '1', '1', '0', 0, '1'),
(61, 'invitation_creator', 'Campaign Invitation ', '<p>\r\n  </p>\r\n<div id=\"cke_pastebin\">\r\n <div id=\"cke_pastebin\">\r\n   Hello <strong>[EMAIL]</strong><b>,</b></div>\r\n <div>\r\n   </div>\r\n <div>\r\n  You have been invited for the following Campaign with following message:</div>\r\n <div id=\"cke_pastebin\">\r\n  <p>\r\n   <strong>[message]</strong></p>\r\n </div>\r\n <div id=\"cke_pastebin\">\r\n   Campaign Name: <strong>[campaign_name]</strong></div>\r\n <div>\r\n   </div>\r\n <div>\r\n  <p>\r\n    </p>\r\n </div>\r\n <div id=\"cke_pastebin\">\r\n  <p>\r\n    Sincerely,</p>\r\n </div>\r\n <div id=\"cke_pastebin\">\r\n  <p>\r\n    </p>\r\n </div>\r\n <div id=\"cke_pastebin\">\r\n  <strong xss=\"removed\"> [SITENAME]</strong></div>\r\n <div>\r\n  <strong xss=\"removed\"><br>\r\n  </strong></div>\r\n</div>\r\n', 'sdf\r\n', '2016-12-09 11:55:26', '1', '1', '1', '0', 0, '1'),
(62, 'draft_accepted', 'Draft Submission Accepted', '<p>\r\n Dear <strong>[EMAIL]</strong></p>\r\n<p>\r\n The following Draft submitted by you has been Accepted. Please follow the instruction to claim your prize.</p>\r\n<p>\r\n Product Name : <strong>[PRODUCT_NAME]</strong></p>\r\n<p>\r\n Draft Description : <strong>[DESCRIPTION]</strong></p>\r\n<p>\r\n Draft Link : <strong>[LINK]</strong></p>\r\n<p>\r\n Sincerely,</p>\r\n<p>\r\n <strong><br>\r\n [SITENAME]</strong></p>\r\n', 'sdasd', '2017-02-21 12:02:04', '1', '1', '1', '0', 0, '1'),
(63, 'draft_rejected', 'Draft Submission Rejected', 'sdkasdkladjs', 'sd	', '0000-00-00 00:00:00', '1', '1', '1', '0', 0, '1'),
(64, 'proposal_received', 'Proposal Received', '<p>\r\n Dear <strong>[EMAIL],</strong></p>\r\n<p>\r\n You have received a proposal from one of the creator .Please have a look at it.</p>\r\n<p>\r\n Campaign Name : <strong>[PRODUCT_NAME]</strong></p>\r\n<p>\r\n Campaign Expire : <strong>[SUBMISSION_DEADLINE]</strong></p>\r\n<p>\r\n Media : <strong>[SOCIAL_MEDIA]</strong></p>\r\n<p>\r\n  </p>\r\n<p>\r\n Sincerly Yours,</p>\r\n<p>\r\n <strong>[WEBSITE_NAME]</strong></p>\r\n', 'sdasd', '2017-02-24 15:45:42', '1', '1', '1', '0', 0, '1'),
(65, 'creator_selected_for_campaign', 'You have been selected for campaign promotion', '<p>\n Dear Influencer,</p>\n<p>\n You have been selected for promotion of the following campaign:</p>\n<p>\n <strong>Campaign Name</strong> : [CAMPAIGN_NAME]</p>\n<p>\n <strong>Description</strong>: [DESCRIPTION]</p>\n<p>\n <strong>Product</strong> :  [PRODUCT_NAME]</p>\n<p>\n <strong>Submission Deadline </strong>: [SUBMISSION_DEADLINE]</p>\n<p>\n  </p>\n<p>\n Thank you,</p>\n<p>\n [<strong>WEBSITE_NAME</strong>]</p>\n<p>\n  </p>', 'asdasd', '2017-08-03 09:27:51', '1', '1', '1', '0', 0, '1'),
(66, 'promotion_complete', 'You have been selected for campaign promotion', '<p>\r\n Dear [USER],</p>\r\n<p>\r\n You have been selected for promotion of the following campaign:</p>\r\n<p>\r\n <strong>Campaign Name</strong> : [CAMPAIGN_NAME]</p>\r\n<p>\r\n <strong>Brand Name</strong>: [BRAND_NAME]</p>\r\n<p>\r\n <strong>Product</strong> :  [PRODUCT_NAME]</p>\r\n<p>\r\n <strong>Submission Deadline </strong>: [SUBMISSION_DEADLINE]</p>\r\n<p>\r\n  </p>\r\n<p>\r\n Thank you,</p>\r\n<p>\r\n [<strong>WEBSITE_NAME</strong>]</p>\r\n<p>\r\n  </p>', 'sd', '2017-08-03 09:27:51', '1', '1', '1', '0', 0, '1'),
(67, 'invoice_sent', 'Invoice sent', 'Dear [USER]\r\n\r\nWe have attached invoice with the email.\r\n\r\nThank you\r\n[WEBSITE_NAME]', 'sd	', '0000-00-00 00:00:00', '1', '1', '1', '0', 0, '1'),
(68, 'invitation_brand', 'Invitation from Creator', '<p>\r\n  </p>\r\n<div id=\"cke_pastebin\">\r\n <div id=\"cke_pastebin\">\r\n   Hello <strong>[EMAIL]</strong><b>,</b></div>\r\n <div>\r\n   </div>\r\n <div>\r\n  You have been invited for the following Campaign with following message:</div>\r\n <div id=\"cke_pastebin\">\r\n  <p>\r\n   <strong>[message]</strong></p>\r\n </div>\r\n <div id=\"cke_pastebin\">\r\n   Campaign Name: <strong>[campaign_name]</strong></div>\r\n <div>\r\n   </div>\r\n <div>\r\n  <p>\r\n    </p>\r\n </div>\r\n <div id=\"cke_pastebin\">\r\n  <p>\r\n    Sincerely,</p>\r\n </div>\r\n <div id=\"cke_pastebin\">\r\n  <p>\r\n    </p>\r\n </div>\r\n <div id=\"cke_pastebin\">\r\n  <strong xss=\"removed\"> [SITENAME]</strong></div>\r\n <div>\r\n  <strong xss=\"removed\"><br>\r\n  </strong></div>\r\n</div>\r\n', '<p>\r\n  </p>\r\n<div id=\"cke_pastebin\">\r\n <div id=\"cke_pastebin\">\r\n   Hello <strong>[EMAIL]</strong><b>,</b></div>\r\n <div>\r\n   </div>\r\n <div>\r\n  You have been invited for the following Campaign with following message:</div>\r\n <div id=\"cke_pastebin\">\r\n  <p>\r\n   <strong>[message]</strong></p>\r\n </div>\r\n <div id=\"cke_pastebin\">\r\n   Campaign Name: <strong>[campaign_name]</strong></div>\r\n <div>\r\n   </div>\r\n <div>\r\n  <p>\r\n    </p>\r\n </div>\r\n <div id=\"cke_pastebin\">\r\n  <p>\r\n    Sincerely,</p>\r\n </div>\r\n <div id=\"cke_pastebin\">\r\n  <p>\r\n    </p>\r\n </div>\r\n <div id=\"cke_pastebin\">\r\n  <strong xss=\"removed\"> [SITENAME]</strong></div>\r\n <div>\r\n  <strong xss=\"removed\"><br>\r\n  </strong></div>\r\n</div>\r\n', '0000-00-00 00:00:00', '1', '1', '1', '0', 0, '1'),
(69, 'user_activated', 'User Approved Successfully', '<p>\r\n Dear [USER],</p>\r\n<p>\r\n  </p>\r\n<p>\r\n Your Account  with email <strong>[EMAIL] </strong>has been Approved by Admin. You can now login and register into the system.</p>\r\n<p>\r\n Username : [USER]</p>\r\n<p>\r\n  </p>\r\n<p>\r\n [SITENAME]</p>\r\n', 'asd', '2017-08-16 14:13:12', '1', '1', '1', '0', 0, '1'),
(70, 'user_activated', 'User Approved Successfully', '<p>\r\n Dear [USER],</p>\r\n<p>\r\n  </p>\r\n<p>\r\n Your Account  with email <strong>[EMAIL] </strong>has been Approved by Admin. You can now login and register into the system.</p>\r\n<p>\r\n Username : [USER]</p>\r\n<p>\r\n  </p>\r\n<p>\r\n [SITENAME]</p>\r\n', 'asd', '2017-08-16 14:13:12', '1', '1', '1', '0', 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `emts_help`
--

CREATE TABLE `emts_help` (
  `id` int(11) NOT NULL,
  `title` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `last_update` datetime NOT NULL,
  `is_display` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emts_help`
--

INSERT INTO `emts_help` (`id`, `title`, `description`, `last_update`, `is_display`) VALUES
(1, 'What is High Tree Group?', '<p>\r\n	Mauris pharetra placerat est, ut interdum nibh. Pellentesque sapien dui, ullamcorper non ultricies nec, convallis in ex. Duis rhoncus maximus iaculis. Sed laoreet nisl sodales risus suscipit, quis maximus neque ultrices. Etiam cursus elit id ultrices vestibulum. Suspendisse molestie eros nisi, et vestibulum lectus convallis non. Cras</p>\r\n', '2016-05-09 16:40:15', 'Yes'),
(2, 'How do Reverse Auction Work', '<div class=\"panel-collapse collapse in\" id=\"collapse-1\" style=\"\">\r\n	<div class=\"panel-body\">\r\n		<p>\r\n			Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n		<p>\r\n			Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n	</div>\r\n</div>\r\n', '2016-06-06 11:46:36', 'Yes'),
(3, 'What is Hightree Group', '<div class=\"panel-collapse collapse in\" id=\"collapse-1\" style=\"\">\r\n	<div class=\"panel-body\">\r\n		<p>\r\n			Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n		<p>\r\n			Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n	</div>\r\n</div>\r\n', '2016-06-06 11:47:06', 'Yes'),
(4, 'This is test help', '<p>\r\n	Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo</p>\r\n', '2016-07-16 13:40:20', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `emts_log_admin_activity`
--

CREATE TABLE `emts_log_admin_activity` (
  `log_id` bigint(20) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_user_id` int(11) NOT NULL,
  `log_user_type` varchar(10) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `module_desc` text NOT NULL,
  `log_action` varchar(255) NOT NULL,
  `log_ip` varchar(255) NOT NULL,
  `log_browser` text,
  `log_platform` text,
  `log_agent` text,
  `log_referrer` text,
  `log_extra_info` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `emts_log_invalid_logins`
--

CREATE TABLE `emts_log_invalid_logins` (
  `log_id` bigint(20) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_module` varchar(50) NOT NULL,
  `log_username` varchar(255) DEFAULT NULL,
  `log_password` varchar(255) DEFAULT NULL,
  `log_ip` varchar(255) DEFAULT NULL,
  `log_platform` text,
  `log_browser` text,
  `log_agent` text,
  `log_referrer` text,
  `log_desc` text,
  `log_extra_info` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emts_log_invalid_logins`
--

INSERT INTO `emts_log_invalid_logins` (`log_id`, `log_time`, `log_module`, `log_username`, `log_password`, `log_ip`, `log_platform`, `log_browser`, `log_agent`, `log_referrer`, `log_desc`, `log_extra_info`) VALUES
(20, '2016-02-09 05:33:37', 'Admin Login', 'testing1', '4s0C04x/tBvjO5+och3zNzgcOVmZ2L/6dxfbjUOnYEb38kUNfUNxKKVvr/FP8sYn1CIbwsxjn1LQaV9M/NKWKg==', '122.162.222.122', 'Unknown Windows OS', 'Chrome | 48.0.2564.103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.103 Safari/537.36', 'http://nepaimpressions.com/prabin/reverse/admin', 'Admin user not registered', ''),
(21, '2016-02-11 21:04:40', 'Admin Login', 'admin', 'aY/oxPwqN7F+YzTHRR7iF3bSiWr3+wY6f9jq8UJLqtxWIkTL3vd5IPVSzTWNFCSf4pfOdWCzU7BfKNdnvYVeyw==', '202.79.37.78', 'Unknown Windows OS', 'Firefox | 44.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:44.0) Gecko/20100101 Firefox/44.0', 'http://nepaimpressions.com/prabin/reverse/admin', 'invalid password', ''),
(22, '2016-02-11 21:07:23', 'Admin Login', 'admin', 'eHhFBXj6zrnqgydJi3Lnl7AAmDL/5Q6M7mZpZ/iqnamJU7bNGGAgJVzfHAMqV01NxnrBjj++OY2r68RjjPYfrw==', '202.79.37.78', 'Unknown Windows OS', 'Firefox | 44.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:44.0) Gecko/20100101 Firefox/44.0', 'http://nepaimpressions.com/prabin/reverse/admin', 'invalid password', ''),
(23, '2016-02-16 15:50:48', 'Admin Login', 'admin', 'mF5NPEW3lKe1BOZ/S1P4qV6Uigqebrj57iXjFKqgDpN8xEtKiuiA4mCuJQbYUGa2WE9pl2FcyZgtjlpXY7Dy9A==', '202.79.37.78', 'Unknown Windows OS', 'Firefox | 44.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:44.0) Gecko/20100101 Firefox/44.0', 'http://nepaimpressions.com/prabin/reverse/admin', 'invalid password', ''),
(24, '2016-05-27 07:04:42', 'Admin Login', 'admin', 'CMuYGPb+2aPfwtEWnxCbbcCEDaVShuSd+U8OMD8ThA5x+QWyavwjsrfzEkDTjFQfNKE17sBP5+4TLQfADRCi9g==', '127.0.0.1', 'Windows 7', 'Firefox | 46.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 'http://localhost/hightreegroup/admin', 'invalid password', ''),
(25, '2016-06-02 11:29:58', 'Admin Login', 'admin', 'lgdBqf6iHaF7D7t0SimV+1Rs4BUHHLqDa1hy/WcvXxSKOGMcQahCppoMAidJKkLdAv2Na/mpkE0C0lKXSU6+oA==', '127.0.0.1', 'Windows 7', 'Firefox | 46.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 'http://127.0.0.1/hightreegroup/admin', 'invalid password', ''),
(26, '2016-06-02 11:30:05', 'Admin Login', 'admin', '+T22+bX8xnVGTliL6AvlF4axpfWOhrPnBadepdUhAMDXi5L5Cg5aR5AWhhLnPyzmbDWK1XlzNV3vVpDiHzzGqg==', '127.0.0.1', 'Windows 7', 'Firefox | 46.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', 'http://127.0.0.1/hightreegroup/admin', 'invalid password', ''),
(27, '2016-07-07 06:03:51', 'Admin Login', 'cmanish049@gmail.com', '8H46Qwio7i1s8ikQ91gG5jRzXK0vq+ZFkzyTh+JXWyPdH91GjQSOsdr6yo53d0GhzJlz8sFj22L+//mepeaK+Q==', '::1', 'Windows 7', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://localhost/hightreegroup/admin', 'Admin user not registered', ''),
(28, '2016-07-07 06:03:54', 'Admin Login', 'cmanish049@gmail.com', 'jmUjMrAUlgpAT2G1+G2CjkVrrPASEH0e6fnDUi+1VpnqWdM5CK9ly1eqoN37MQb03Z7iP/rj0HaocFcQC2jnJA==', '::1', 'Windows 7', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://localhost/hightreegroup/admin', 'Admin user not registered', ''),
(29, '2016-07-07 06:04:02', 'Admin Login', 'admin', 'z/cJ4eRARiV9wYK69PRXG1X1HMQtrQ4WpdWda8EdPfJYkv9Tpo4ezs3c/wYv3uu5HMKYlCEnWGwR05JDiOSXcg==', '::1', 'Windows 7', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://localhost/hightreegroup/admin', 'invalid password', ''),
(30, '2016-07-07 06:13:36', 'Admin Login', 'cmanish049@gmail.com', 'Bac5nEk1Gxhm6OOjWF7K2MnNx1LoQbeVfZWpGCuXtCvzXXniYoSHdFrCkAEKkBc936JK2pmjTMWUjXOoeVcemA==', '::1', 'Windows 7', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://localhost/hightreegroup/admin', 'Admin user not registered', ''),
(31, '2016-07-07 07:18:56', 'Admin Login', 'cmanish049@gmail.com', 'GRaRFZIohnaiICGlSZmdPS7N7tyBxfICCVy3KWxjVqHPRNP0LEK3DrYPh1kBLBUt/B4UHcL5NaM2Pj7BsoRXkg==', '::1', 'Windows 7', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://localhost/hightreegroup/admin', 'Admin user not registered', ''),
(32, '2016-07-11 11:18:46', 'Admin Login', 'admin', 'uSMAUfn29MHOHCmMdG4bjNZo/p5iUPGEHUVA9vFVRYUwSP8qmP/J2aDdwAmawZ4Q6GpADBDp9IjmpoR/G77HkQ==', '::1', 'Windows 7', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://localhost/hightreegroup/admin', 'invalid password', ''),
(33, '2016-07-11 11:18:54', 'Admin Login', 'admin', 'smARB2Jk9SanuRuhvTz8UI9lzxOLfrKpt6Pxy/rh5wkGUWoIEhsBi3VRnIVpePtVG0zzJuIhJojN2bfIGJ/oVQ==', '::1', 'Windows 7', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://localhost/hightreegroup/admin', 'invalid password', ''),
(34, '2016-07-11 11:19:04', 'Admin Login', 'admin', 'yZepcGYacujI4SwrK8RTFHo/G4AimaMuK+432XxPMRHsSfQ5uWNxmWcXHGS8xPk4Szsg79RpC9o5WheEDURNFw==', '::1', 'Windows 7', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://localhost/hightreegroup/admin', 'invalid password', ''),
(35, '2016-07-11 11:19:14', 'Admin Login', 'admin', 'cGbhcBa9fAir6KQtzKIvmsJGuQtd+rshAL3jd/Z87Htt3JxwlgyDHiM9qxC6xkPooVmcvASup7thyZ13gNrExA==', '::1', 'Windows 7', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://localhost/hightreegroup/admin', 'invalid password', ''),
(36, '2016-07-11 11:20:11', 'Admin Login', 'admin', 'Q0R2d7Vt8vOrlyH7Yp58aMX8OBdC+nTK3rR8OoM5qvVbg8d7zv1TLcoMEq+/j4l88Bc9OjYZVKTbVVVASenP9A==', '::1', 'Windows 7', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://localhost/hightreegroup/admin', 'invalid password', ''),
(37, '2016-07-16 06:02:49', 'Admin Login', 'admin', 'cOl6dSYXNpHH0YxMQcKZ4qHK2s2OHN27li5bfsaGlDL9NZi85Av10YYVeVlbkElMISVN/ySbqesRSWXFqoJfFA==', '202.166.198.151', 'Windows 10', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', ''),
(38, '2016-07-16 06:02:57', 'Admin Login', 'admin', '4uVu0GUcZf8dR88DVDfCWcKVDQEJCofXgxd8SyCeH0noAzNog9fA7qipzwM79CO97anI2aPZy4taub47lAEQKA==', '202.166.198.151', 'Windows 10', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', ''),
(39, '2016-07-16 06:03:05', 'Admin Login', 'admin', 'jwlyNfXTV/M9+Rdme7J0s8MrAbuA50jFrymnUUd1cZBl0eLobJ0CwURO6h9b5UuT1xPe8anF6+tUwpwz7SQE8g==', '202.166.198.151', 'Windows 10', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', ''),
(40, '2016-07-16 06:03:22', 'Admin Login', 'admin', 'RGBnH2DVVe4+7WMta2IgS295nQIv7InVnyYzNS9E01zHIRIMRftu++/4SFU1n2R4e9iPUOfUu0SqBd+s9wFG3g==', '202.166.198.151', 'Windows 10', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', ''),
(41, '2016-07-16 06:07:52', 'Admin Login', 'admin', '3bVZlqqUjKbirX0dVV+DYOANWVTn1p/Bs83f9VNo1H5eIeWDO1WSiJqRQRDfHXUKneG6MLXxX7l440n3CGpOTw==', '202.166.198.151', 'Windows 10', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', ''),
(42, '2016-07-16 06:07:59', 'Admin Login', 'admin', 'sUwSEK2jbGuSE9GOjSFeiigac5EdEXZwhN+GmT/qPNjtF3GISdhIyF3q2+8m9hliajPNywCe/Kq/jLRbZNBHeg==', '202.166.198.151', 'Windows 10', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', ''),
(43, '2016-07-16 06:08:06', 'Admin Login', 'admin', 'yc/1vSsUP+go5lmNI9k9qwWoEVoauqWzXZUIqZKdTUOdNHQ69YTtQg5H54KmYfhXHdtidyJdTua0JnvXEdjjqg==', '202.166.198.151', 'Windows 10', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', ''),
(44, '2016-07-27 07:02:32', 'Admin Login', 'admin', 'tmrIfgRyL3pOItGqJMLvbqefw5U0T4Tr8ARe0u9LanAmbqJlLj975cbd1dd9+MN0VEktlb9bPPq1N0aZNRMCJg==', '202.166.198.151', 'Windows 10', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', ''),
(45, '2016-07-28 05:29:23', 'Admin Login', 'admin', 'DQRK4/7K9qqsUraVLJdPGxlqgqw0vFdWCH2/dzznBWGjpr31rap9DQuQ4+exoQS8W/rXwUs8QvbUUXjEr2jrCg==', '202.166.198.151', 'Windows 10', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', ''),
(46, '2016-08-03 06:55:28', 'Admin Login', 'admin', 'pNv341mD2yFcjeVDIquX/qI3yGHzwZEOPr4mUnCFdvgZDeNAgprpLRRWTFbgw5x8ZVhzhH3tO49tmBxWcGOdCQ==', '202.166.198.151', 'Windows 10', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', ''),
(47, '2016-08-03 07:45:51', 'Admin Login', 'admin', 'v7EIgJuKqbwuWjkEl+/vFd3x1/xeiIu0Wmt/8H/bp3Y/aFkcp4o6djHu3+jDUwkmz/Zm7mPulkFD/gUHfTA22Q==', '202.166.198.151', 'Windows 10', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', ''),
(48, '2016-08-05 10:25:45', 'Admin Login', 'admin', '1WZwEzAPuVquzxfQ4L2s52bas12r5J+/gjtrQkYSX/mrzPE5V8fsmzrL++U9pM/8JoqlkOabYm6gPedqMuyAUA==', '202.166.198.151', 'Linux', 'Firefox | 47.0', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:47.0) Gecko/20100101 Firefox/47.0', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', ''),
(49, '2016-08-09 06:09:25', 'Admin Login', 'sujititc', 'Ecvi4tToGVd9VotR+UgNFyHdUrGwVQy12kp8vzKv4meF55h677p49oKGMveFauRvx4XCqaXnqzvpYNZvB9Mp2A==', '202.166.198.151', 'Windows 7', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'Admin user not registered', ''),
(50, '2016-08-09 06:09:35', 'Admin Login', 'sujititc', '0cf90xFs7vOzLC45ALG04tZ0g4sIW4/XC5Unbfp0kzTC7XMfLQlS5ny4zRRLP2pt2IWNvTs5mYpqvFm9LHYNew==', '202.166.198.151', 'Windows 7', 'Chrome | 51.0.2704.103', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'Admin user not registered', ''),
(51, '2016-08-10 06:56:55', 'Admin Login', 'admin', 'Ecw+92++gI1LbYEMPPQqupiumW4TETGOR+yfP+XDu1IaYCgHXBuRX2VCcqWwCZBD7TANehlGjks5+QSi+8W00w==', '202.166.198.151', 'Windows 10', 'Chrome | 52.0.2743.116', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', ''),
(52, '2016-08-10 08:47:27', 'Admin Login', 'admin', 'lcwSHsazi6RY+n/eM4k/MkUZlooSlI09gEtKRc19ma2LZ1LFSCc1M9F6ameai9Pl80FLtylV6SvmcGSDM1Hwew==', '202.166.198.151', 'Windows 10', 'Chrome | 52.0.2743.116', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', ''),
(53, '2016-08-15 03:50:32', 'Admin Login', 'admin', 'mn+yEjkspl4hAeX++Kbne0oNFuHAULtrjgnK9dY/U78baPMT3slxLrEkzb4BvDV5FGYU+rqnWazVD0qk976MvA==', '202.166.198.151', 'Windows 10', 'Chrome | 52.0.2743.116', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', ''),
(54, '2016-08-15 04:44:25', 'Admin Login', 'sujititc', 'C4jJny3O60Npqdnd1pLGlu8DRTEyFh/eDl72i5MFEaO7yoHvtIdKmkt6LA2dhv4LczhCq9QuyQ8V6uTK8AYyRg==', '202.166.198.151', 'Windows 7', 'Chrome | 52.0.2743.116', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'Admin user not registered', ''),
(55, '2016-08-15 05:53:40', 'Admin Login', 'admin', 'jNg6sp/MuoI8g66PeKDTLvhQFq/VwE7qtAoWkYpupRGe3sXs3BBOCngxQIZpcXPWDzt/A1sLbplJyktEDp1jtg==', '202.166.198.151', 'Windows 7', 'Chrome | 52.0.2743.116', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', ''),
(56, '2016-08-17 05:17:54', 'Admin Login', 'renato.abreu@gmail.com', 'M7N9YYPGtdHD86iUABKF+AX3QahXRTBaSQz/tWnIFwjjFNzdf6AvgQC0HC6LwudOg4IeH2oWK6ebRvN0A3NdAQ==', '79.140.194.224', 'Windows 7', 'Chrome | 52.0.2743.116', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'Admin user not registered', ''),
(57, '2016-08-22 04:39:34', 'Admin Login', 'admin', '5RAVD0qkXJuA2ZZQRKHmgkkh7JjoNkHGSSPWNhLe8AycgpVNtydhscOmlh6oFbdYwHW4oXerk8QQQ398LqGeWQ==', '202.166.198.151', 'Windows 10', 'Chrome | 52.0.2743.116', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', ''),
(58, '2016-08-22 11:20:47', 'Admin Login', 'admin', '4G4zVI6wMk37vQGpZig40LlMXQ+KBsTHt142AUwakcPShFpk6+6y/bPbpC+d6o9V+CwVhBkq/TaVgSKesWoDCg==', '202.166.198.151', 'Windows 7', 'Chrome | 52.0.2743.116', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', 'http://nepaimpressions.com/dev/hightree/admin', 'invalid password', '');

-- --------------------------------------------------------

--
-- Table structure for table `emts_members`
--

CREATE TABLE `emts_members` (
  `id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `new_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` enum('1','2','3','4') COLLATE utf8_unicode_ci NOT NULL DEFAULT '3' COMMENT '1=Super Admin, 2=Admin, 3=Brand, 4=Creator',
  `balance` double(20,2) NOT NULL,
  `reg_date` timestamp NULL DEFAULT NULL,
  `last_login_date` timestamp NULL DEFAULT NULL,
  `last_modify_date` timestamp NULL DEFAULT NULL,
  `reg_ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_login_ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `is_login` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0=No, 1=Yes',
  `status` enum('1','2','3','4') COLLATE utf8_unicode_ci NOT NULL COMMENT '1=Active or Verified, 2=Inactive or unverified, 3=Suspended, 4=Closed',
  `mem_last_activated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `balance_free` int(11) NOT NULL DEFAULT '0',
  `balance_paid` int(11) NOT NULL DEFAULT '0' COMMENT '0, 1',
  `membership_type` varchar(25) COLLATE utf8_unicode_ci NOT NULL COMMENT 'one_post,one_bid,unlimited',
  `member_validity` datetime NOT NULL,
  `activation_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `forgot_password_code` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `forgot_password_code_expire` datetime NOT NULL,
  `primary_media` int(11) DEFAULT NULL,
  `brand_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `brand_url` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referred_by` int(11) DEFAULT NULL,
  `referral_points` int(11) DEFAULT '0',
  `price` int(11) DEFAULT '0',
  `available_status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL COMMENT '1->available,0->unavailable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emts_members`
--

INSERT INTO `emts_members` (`id`, `email`, `new_email`, `username`, `password`, `salt`, `user_type`, `balance`, `reg_date`, `last_login_date`, `last_modify_date`, `reg_ip`, `last_login_ip`, `is_login`, `status`, `mem_last_activated`, `balance_free`, `balance_paid`, `membership_type`, `member_validity`, `activation_code`, `forgot_password_code`, `forgot_password_code_expire`, `primary_media`, `brand_name`, `brand_url`, `referred_by`, `referral_points`, `price`, `available_status`) VALUES
(81, 'sagar@emultitechsolution.com', '', 'sagar', 'c8a6f0c9d8e368969a7e4b20f00c955ce353461d', '0280644c70', '4', 5299.50, '2017-04-18 11:26:11', '2017-08-03 07:24:00', '2017-06-29 04:55:31', '::1', '202.166.198.151', '0', '1', '2017-08-03 07:38:19', 0, 0, '', '0000-00-00 00:00:00', '26167637', '', '0000-00-00 00:00:00', 1, NULL, NULL, NULL, 0, 10, '1'),
(82, 'insta@gmail.com', '', 'insta', '178c75d312e830b20793d6fe2dd5d68aea77b6a8', 'ae43d4ab58', '4', 510.80, '2017-04-18 11:43:36', '2017-08-22 04:04:12', '2017-08-21 08:27:22', '::1', '202.166.198.151', '0', '1', '2017-08-24 09:38:31', 0, 0, '', '0000-00-00 00:00:00', '80182461', '', '0000-00-00 00:00:00', 3, NULL, NULL, NULL, 0, 10, '1'),
(83, 'check@gmail.com', '', 'check', '0dd0a87c250702c161b70abd506cfb6f3cc46a04', 'edef488466', '3', 867.96, '2017-04-18 11:46:01', '2017-08-24 09:38:31', '2017-08-07 08:43:13', '::1', '202.166.198.151', '1', '1', '2017-08-24 09:38:31', 0, 0, '', '0000-00-00 00:00:00', '89970976', '', '0000-00-00 00:00:00', NULL, '123 tea company', 'http://poplr.com.ai', NULL, 0, 0, '1'),
(84, 'emts.testers@gmail.com1', '', 'youtuleesagar12', 'e4a20acd4000bec1ec0329072c819c45bcefc417', 'bc73e3cca5', '4', 0.00, '2017-04-19 04:30:26', '2017-08-08 07:45:33', NULL, '::1', '202.166.198.151', '0', '1', '2017-08-16 08:46:50', 0, 0, '', '0000-00-00 00:00:00', '90292130', '', '0000-00-00 00:00:00', 5, NULL, NULL, NULL, 9, 10, '1'),
(85, 'saagarchapagain@gmail.coms', '', 'youtuleesagar', 'c21d24fbaf1708d3dd10edec21b28effdd2ed9d7', 'b81e18c2a2', '4', -300.00, '2017-04-24 06:22:53', '2017-06-27 10:50:32', '2017-05-04 03:15:40', '127.0.0.1', '202.79.37.78', '0', '1', '2017-08-16 06:04:52', 0, 0, '', '0000-00-00 00:00:00', '45841250', '', '0000-00-00 00:00:00', 5, NULL, NULL, NULL, 0, 10, '1'),
(92, 'brand@gmail.com', '', '', '47ef31a2661f2503382e54720e8a95ae53048f10', 'a5b747ebfd', '3', 0.00, '2017-05-10 10:12:19', '2017-08-08 08:46:39', NULL, '::1', '202.166.198.151', '0', '1', '2017-08-08 08:54:50', 0, 0, '', '0000-00-00 00:00:00', '99721295', '', '0000-00-00 00:00:00', NULL, 'general store item where everything is found', 'http://thegeneralitemstorewhereeverythingisfound.com', NULL, 0, 0, '1'),
(96, 'emts.testers@gmail.coms', '', 'emts.testers', 'c338336a876ec154bed17d6e52810af6d0bcddb6', 'acb8dede46', '4', 0.00, '2017-05-11 06:06:44', '2017-08-08 07:55:45', NULL, '192.168.0.129', '202.166.198.151', '0', '1', '2017-08-08 08:02:59', 0, 0, '', '0000-00-00 00:00:00', '26731544', '', '0000-00-00 00:00:00', 2, NULL, NULL, NULL, 0, 10, '1'),
(97, 'saagarchapagain@gmail.coma', '', 'sagar.chapagain', '362965c3d0dd93b6ca364938fca9538ad060d224', 'a211595f52', '4', 0.00, '2017-05-11 08:58:23', NULL, NULL, '::1', '', '0', '2', '2017-07-18 08:31:49', 0, 0, '', '0000-00-00 00:00:00', '14754247', '', '0000-00-00 00:00:00', 4, NULL, NULL, NULL, 0, 10, '1'),
(98, 'sagar@brand.com', '', '', '42794790f0947dc0e41ceb41cc62f5da646a993e', 'a5af25e099', '3', 0.00, '2017-05-15 09:54:19', '2017-08-08 08:03:37', NULL, '::1', '202.166.198.151', '0', '1', '2017-08-08 08:03:48', 0, 0, '', '0000-00-00 00:00:00', '31760553', '', '0000-00-00 00:00:00', NULL, 'taxxu', 'http://samsungstore.com', NULL, 0, 0, '1'),
(99, 'poplr@gmail.com', '', 'poplr', '5f9dabd1914d4b39f1f83cd3f5984bb2f7d7ef64', '2a658c7683', '3', 0.00, '2017-05-26 09:25:02', NULL, NULL, '::1', '', '0', '2', '2017-07-18 08:30:30', 0, 0, '', '0000-00-00 00:00:00', '94255021', '', '0000-00-00 00:00:00', NULL, 'poplar', 'http://poplr.com', NULL, 0, 0, '1'),
(100, 'youtulee12@gmail.com', '', 'checktest', '8aff0728fcb070852c34d9d13c4944198ef38d5e', '3a0b7a14f5', '3', 0.00, '2017-05-26 10:24:17', NULL, NULL, '::1', '', '0', '2', '2017-07-18 08:30:30', 0, 0, '', '0000-00-00 00:00:00', '42354326', '', '0000-00-00 00:00:00', NULL, 'sagar test', 'http://poplr.com', 83, 0, 0, '1'),
(101, 'test@gmail.com', '', 'tumblr', '4805d4e3880198b2055a9f695f1db1a13d5914de', '89064925c1', '4', 0.00, '2017-05-26 10:36:16', NULL, NULL, '127.0.0.1', '', '0', '2', '2017-07-18 08:31:49', 0, 0, '', '0000-00-00 00:00:00', '83927330', '', '0000-00-00 00:00:00', 6, NULL, NULL, 82, 0, 10, '1'),
(102, 'emts.solutions@gmail.com', '', 'emtsbrand', '593a21b984be7c571bc7dcd1966394ded65c9fd9', '5f783d67ed', '3', 0.00, '2017-05-26 10:37:40', NULL, NULL, '127.0.0.1', '', '0', '2', '2017-07-18 08:30:30', 0, 0, '', '0000-00-00 00:00:00', '30697697', '', '0000-00-00 00:00:00', NULL, 'sagar test', 'http://brand.com', 82, 0, 0, '1'),
(103, 'emts@gml.com', '', 'tester', 'b7836b0662fe4436fa48aaec27262af930c3b855', 'f7aa2cef87', '4', 0.00, '2017-05-26 10:38:38', '2017-08-08 08:55:29', NULL, '127.0.0.1', '202.166.198.151', '0', '1', '2017-08-08 10:13:09', 0, 0, '', '0000-00-00 00:00:00', '50532252', '', '0000-00-00 00:00:00', 4, NULL, NULL, 82, 0, 10, '0'),
(107, 'asasd@asd.asd', '', '5asd4', 'f8a49ce369a01d41ead9f2dde2a8ecf6d64be287', 'd9628ae77a', '4', 0.00, '2017-05-26 10:49:22', '2017-08-08 08:14:14', NULL, '127.0.0.1', '202.166.198.151', '0', '1', '2017-08-08 08:32:43', 0, 0, '', '0000-00-00 00:00:00', '11345272', '', '0000-00-00 00:00:00', 3, NULL, NULL, NULL, 5, 10, '1'),
(108, 'asdasd@12sd.asd', '', '12345', 'd2f48a9ef146c74f34635ddefa5dc47921b00fd7', '30c00072b8', '4', 0.00, '2017-05-26 10:50:26', '2017-05-29 03:39:15', NULL, '127.0.0.1', '::1', '0', '1', '2017-07-18 08:31:49', 0, 0, '', '0000-00-00 00:00:00', '59098392', '', '0000-00-00 00:00:00', 5, NULL, NULL, NULL, 5, 10, '1'),
(110, 'admin', '', 'admin', '07fbf35aadeb32e16ebb0d16d9db76de6b81d4b2', '34323b3e7d', '1', 0.00, NULL, '2017-08-22 04:03:57', NULL, '::1', '202.166.198.151', '0', '1', '2017-08-24 09:38:31', 0, 0, '', '0000-00-00 00:00:00', '54545', '', '0000-00-00 00:00:00', NULL, '', NULL, NULL, 0, 0, '1'),
(111, 'brandsagar@gmail.com', '', 'brandsagar', '0fbb082d6bff836edbf05b0692f74494f48c8c7c', 'ecd4c578cf', '3', 0.00, '2017-05-29 03:55:21', '2017-06-21 11:09:18', NULL, '127.0.0.1', '::1', '0', '1', '2017-07-18 08:30:30', 0, 0, '', '0000-00-00 00:00:00', '99190893', '', '0000-00-00 00:00:00', NULL, 'checkbrand', 'http://brand.com', 82, 1, 0, '1'),
(112, 'emts@gmail.com', '', 'emts123', '8186dba5a2ff13ae9ff9e56b539866f5f3883d0f', '8634b2bb18', '3', 0.00, '2017-06-27 05:36:02', NULL, NULL, '202.79.37.78', '', '0', '2', '2017-07-18 08:30:30', 0, 0, '', '0000-00-00 00:00:00', '44638437', '', '0000-00-00 00:00:00', NULL, 'Emts', 'https://www.nytimes.com/section/magazine', NULL, 0, 0, '1'),
(114, 'ss@vv.com', '', '', '230c650753ed04bd8398768532724cb046e8f228', 'f4914a1933', '3', 0.00, '2017-06-27 05:46:42', NULL, NULL, '202.79.37.78', '', '0', '2', '2017-07-18 08:30:30', 0, 0, '', '0000-00-00 00:00:00', '68256166', '', '0000-00-00 00:00:00', NULL, 'emts', 'https://www.nytimes.com/2017/06/26/world/australia/indigenous-australia-through-american-eyes.html', NULL, 0, 0, '1'),
(118, 'emultitechsolution@gmail.com', '', '', '9f539231e5ead74e0f1d5fc0ad81e71f78e8e1b7', '6b358ca4de', '3', 0.00, '2017-07-04 09:06:13', NULL, NULL, '202.166.198.151', '', '0', '2', '2017-07-18 08:30:30', 0, 0, '', '0000-00-00 00:00:00', '68948573', '', '0000-00-00 00:00:00', NULL, 'Colgate', 'www.colgate.com', NULL, 0, 0, '1'),
(119, 'mks_q1990@yahoo.com', '', '', 'a72632576a56bfa9e223e1483c3d242cce27554e', '49cc3ed902', '3', 0.00, '2017-07-04 09:09:52', NULL, NULL, '202.166.198.151', '', '0', '2', '2017-07-18 08:30:30', 0, 0, '', '0000-00-00 00:00:00', '31451188', '', '0000-00-00 00:00:00', NULL, 'kamala', 'www.kamala.com.np', NULL, 0, 0, '1'),
(124, 'saagarchapagain@gmail.com1', '', '', 'd49f45c7e852b4066a5376df66d5e373c9f6c213', '528161dee7', '3', 0.00, '2017-07-04 11:02:59', NULL, NULL, '202.166.198.151', '', '0', '2', '2017-08-16 06:03:36', 0, 0, '', '0000-00-00 00:00:00', '12711766', '', '0000-00-00 00:00:00', NULL, 'Kimberley Barrera', 'Est quisquam id cum vitae in voluptate sint eligendi qui dignissimos dolor sed ab', NULL, 0, 0, '1'),
(125, 'test@test.com', '', '', '75c14461bda8c7c4bbac65f42d825950a00ab268', 'dc0f33aa42', '3', 0.00, '2017-07-04 11:09:51', NULL, NULL, '202.79.37.78', '', '0', '2', '2017-07-18 08:30:30', 0, 0, '', '0000-00-00 00:00:00', '18962672', '', '0000-00-00 00:00:00', NULL, 'Sagaar', 'www.sagaar.com', NULL, 0, 0, '1'),
(126, 'lawaahaana@gmail.com', '', 'Srijana', '7b60ea4cded065617fce6868429f1c672132a693', '7e554da9a3', '4', 0.00, '2017-07-04 11:26:50', NULL, NULL, '202.79.37.78', '', '0', '2', '2017-07-18 08:31:49', 0, 0, '', '0000-00-00 00:00:00', '34671394', '', '0000-00-00 00:00:00', 2, NULL, NULL, NULL, 0, 10, '1'),
(127, 'sagar@emultitechsolution.coms', '', 'asdasdad', 'faadaddd2e35ff4959e1e77f040bd09176da887e', '67038e9c87', '4', 0.00, '2017-07-04 11:36:19', NULL, '2017-08-21 08:21:42', '202.166.198.151', '', '0', '1', '2017-08-21 08:21:42', 0, 0, '', '0000-00-00 00:00:00', '45573891', '', '0000-00-00 00:00:00', 2, NULL, NULL, NULL, 0, 100, '1'),
(128, 'uptrendly@gmail.com', '', '', 'cc9d2329cdc9f55a4c837439305f924288852d77', 'b101fa24ae', '', 0.00, '2017-07-20 03:25:37', NULL, '2017-08-16 08:40:29', '202.166.198.151', '', '0', '1', '2017-08-16 08:40:29', 0, 0, '', '0000-00-00 00:00:00', '43671929', '', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, 0, 0, '1'),
(134, 'emts.testers@gmail.com', '', 'emts.testerss', '885d1c09a24a7520df2a9b94fa8f6b494116ac23', 'ac440f33d3', '4', 0.00, '2017-08-16 08:47:02', '2017-08-16 08:52:04', '2017-08-21 08:25:18', '202.166.198.151', '202.166.198.151', '0', '1', '2017-08-21 08:25:18', 0, 0, '', '0000-00-00 00:00:00', '56869687', '', '0000-00-00 00:00:00', 3, NULL, NULL, NULL, 0, 15, '1'),
(135, 'saagarchapagain@gmail.com', '', '', 'cca8a4a6eb010043db46ca2a94e8ff33250bb529', '4e91f7e03e', '3', 0.00, '2017-08-16 09:00:37', '2017-08-16 09:01:46', '2017-08-21 08:22:58', '202.166.198.151', '202.166.198.151', '0', '1', '2017-08-21 08:22:58', 0, 0, '', '0000-00-00 00:00:00', '11224286', '', '0000-00-00 00:00:00', NULL, 'uptrendly', 'http://poplr.com', NULL, 0, NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `emts_membership_package`
--

CREATE TABLE `emts_membership_package` (
  `id` int(11) NOT NULL,
  `member_type` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1=Buyer, 2=Seller',
  `package_name` varchar(255) NOT NULL,
  `bids` int(11) NOT NULL,
  `cost` double DEFAULT NULL,
  `valid_time` varchar(50) NOT NULL COMMENT 'DD',
  `is_display` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=No, 1=Yes',
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `package_type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_membership_package`
--

INSERT INTO `emts_membership_package` (`id`, `member_type`, `package_name`, `bids`, `cost`, `valid_time`, `is_display`, `post_date`, `update_date`, `package_type`) VALUES
(2, '1', 'One Month unlimited', 0, 500, '30', '1', '2016-08-17 09:11:52', '2016-08-17 20:56:52', 'unlimited'),
(3, '1', 'One Year Unlimited', 0, 1000, '365', '1', '2016-07-26 08:54:24', '2016-07-26 20:39:24', 'unlimited'),
(4, '2', 'One Year Unlimited', 0, 500, '365', '1', '2016-07-26 08:55:09', '2016-07-26 20:40:09', 'unlimited'),
(5, '1', 'ten Post', 10, 10, '', '1', '2016-07-26 08:55:52', '2016-07-26 20:40:52', 'one_post'),
(6, '2', 'Unlim-test', 0, 0, '1000', '1', '2016-09-05 13:52:45', '2016-09-06 01:37:45', 'unlimited'),
(7, '1', 'One Post', 0, 0, '', '1', '2016-08-24 14:35:25', '2016-08-25 02:20:25', 'one_post');

-- --------------------------------------------------------

--
-- Table structure for table `emts_members_details`
--

CREATE TABLE `emts_members_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cover_image` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about_user` tinytext COLLATE utf8_unicode_ci,
  `mobile` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_info` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `company_address1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_address2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `company_state` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `company_zipcode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `company_country` int(5) NOT NULL,
  `company_phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `company_fax` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `company_website` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `profession` int(255) DEFAULT NULL,
  `identification_no` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pan_no` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ceiling_likes` int(11) NOT NULL DEFAULT '0',
  `age` int(11) NOT NULL,
  `gender` enum('m','f','o') COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `account_no` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `designation` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emts_members_details`
--

INSERT INTO `emts_members_details` (`id`, `user_id`, `name`, `image`, `address`, `address2`, `state`, `city`, `country`, `post_code`, `phone`, `cover_image`, `about_user`, `mobile`, `company_name`, `company_info`, `company_address1`, `company_address2`, `company_city`, `company_state`, `company_zipcode`, `company_country`, `company_phone`, `company_fax`, `company_website`, `profession`, `identification_no`, `pan_no`, `ceiling_likes`, `age`, `gender`, `category_id`, `account_no`, `bank_name`, `designation`) VALUES
(79, 81, 'facebook saagar', '', '', NULL, NULL, NULL, 'Barbados', NULL, '98449985656', '17c79c0954aa0f1ee1ec4209bb377b2e.png', 'asd asd asdasd', NULL, 'Emts', '', 'ktm', 'ktm', 'katm', 'bagmati', '123409', 0, '12345678', '', '', 2, '123456', '', 0, 21, 'm', NULL, NULL, NULL, NULL),
(80, 82, 'instagram sagar', '', '123 street,Kathmandu Nepal', NULL, NULL, NULL, 'New Zealand', NULL, '9841121522', '17c6337069f5c4c1164cb9603afc40f7.jpg', 'You asked, Font Awesome delivers with 41 shiny new icons in version 4.7. Want to request new icons? Here\'s how. Need vectors or want to use on the desktop? Check the cheatsheet.', NULL, '', '', '', '', '', '', '', 0, '', '', '', 1, '012525', '', 500, 10, 'm', 102, '2342424324324', 'GIme Bank Ltd. Pvt LDt.', NULL),
(81, 83, 'samer Wills', '', '123 street,Kathmandu Nepal', NULL, NULL, NULL, 'Malaysia', NULL, '9841121522', 'dfbd970f5415f64628e6518ee6a09eba.jpg', NULL, '2143254354235', 'taxxi', '', '123 street', 'street1 middle lane', 'kathmandu', 'bagmati', '00977s', 0, '9841121522', '', 'http://poplr.com.ai', 1, '123456', '54545454554', 50000, 0, '', 0, NULL, NULL, 'chairman'),
(82, 84, 'sagar test', '', 'nakkhu ,lalitpur 1', NULL, NULL, NULL, NULL, NULL, '9812151512', '6645399275056b68aac93f929dee2ac8.jpg', 'test', NULL, '', '', '', '', '', '', '', 0, '', '', '', 2, NULL, '', 6000, 51, 'f', 103, '989894554', 'Nabil Bank Ltd. Pvt LDt.', NULL),
(83, 85, 'youtulee ram', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', 0, 1, 'm', NULL, NULL, NULL, NULL),
(90, 92, 'The general', '', 'ktm', NULL, NULL, NULL, 'Spain', NULL, '01454545', '2449496f123d2c5f0770524b0e5c849d.jpg', NULL, '9845121252', '', '', '', '', '', '', '', 0, '', '', 'http://thegeneralitemstorewhereeverythingisfound.com', 0, NULL, '55454545', 0, 0, '', NULL, NULL, NULL, 'Manager'),
(94, 96, 'sagar chapagain', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(95, 97, 'Youtube sagar', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '105388039004193259795_profilepic.jpg', NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(96, 98, 'sagar chapagain testers', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'taxxu', '', '', '', '', '', '', 0, '9841121522', '', 'http://samsungstore.com', 0, NULL, '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(97, 99, 'poplr vid', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(98, 100, 'tumblr sagar', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(99, 101, 'tumblr test', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(100, 102, 'emts tester', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(101, 103, 'test chapagain', '', '123 street,Kathmandu Nepal', NULL, NULL, NULL, NULL, NULL, '9841121522', '8946ade0c50a8933f598d71f14f026cf.jpg', 'I am  me', NULL, '', '', '', '', '', '', '', 0, '', '', '', 2, NULL, '', 0, 10, 'm', NULL, '009779856563', 'GIme Bank Ltd. Pvt LDt.', NULL),
(105, 107, 'asdsad', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '5351115191_profilepic.jpg', NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(106, 108, 'sagar', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(107, 111, 'sagar chapagain', '', '', NULL, NULL, NULL, 'New Zealand', NULL, NULL, NULL, NULL, NULL, 'checkbrand', '', 'ktm test', 'ktm', 'kathmandu', 'bagmati', '00977', 0, '9841121522', '', 'http://brand.com', 0, '2398239823', '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(108, 112, 'Emts', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(110, 114, 'emts', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(114, 118, 'Nicolas', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(115, 119, 'kamala ghimire', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(120, 124, 'Fleur Randall', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(121, 125, 'sagaar', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(122, 126, 'Srijana', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(123, 127, 'sagfar ', '', '', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', 100, 0, 'm', NULL, NULL, NULL, NULL),
(124, 128, 'uptrendly new', '', '', NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', NULL, NULL, '', 0, 0, 'm', NULL, NULL, NULL, NULL),
(130, 134, 'emts testers', '', '', NULL, NULL, NULL, NULL, NULL, '', '5715935742_profilepic.jpg', NULL, NULL, '', '', '', '', '', '', '', 0, '', '', '', NULL, NULL, '', 50, 0, 'm', NULL, NULL, NULL, NULL),
(131, 135, 'uptrendly sagar', '', 'Banswor,Kathmandu', NULL, NULL, NULL, NULL, NULL, '0154545454', '81d843b9b4f0caa8233270fb88bb1855.jpg', NULL, '9841121522', '', '', '', '', '', '', '', 0, '', '', 'http://poplr.com', NULL, NULL, '21254545412', 0, 0, '', NULL, NULL, NULL, 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `emts_members_temp`
--

CREATE TABLE `emts_members_temp` (
  `id` int(11) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `fb_link` varchar(200) DEFAULT NULL,
  `insta_link` varchar(200) DEFAULT NULL,
  `STATUS` enum('0','1','2') DEFAULT NULL COMMENT '0->no action,1->reject,2->active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emts_member_expertise`
--

CREATE TABLE `emts_member_expertise` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_member_expertise`
--

INSERT INTO `emts_member_expertise` (`id`, `user_id`, `category_id`, `date`) VALUES
(55, 81, 102, '2017-08-03'),
(56, 81, 103, '2017-08-03'),
(57, 81, 107, '2017-08-03'),
(89, 83, 102, '2017-08-04'),
(90, 83, 103, '2017-08-04'),
(142, 84, 102, '2017-08-08'),
(143, 84, 103, '2017-08-08'),
(144, 84, 108, '2017-08-08'),
(149, 103, 102, '2017-08-08'),
(150, 103, 109, '2017-08-08'),
(151, 82, 102, '2017-08-08'),
(152, 82, 103, '2017-08-08'),
(153, 82, 104, '2017-08-08');

-- --------------------------------------------------------

--
-- Table structure for table `emts_member_notification_settings`
--

CREATE TABLE `emts_member_notification_settings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email_template_id` int(11) NOT NULL,
  `is_email_notification_send` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=disable, 1=enable to send notification',
  `is_sms_notification_send` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=No,1=Yes'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_member_notification_settings`
--

INSERT INTO `emts_member_notification_settings` (`id`, `user_id`, `email_template_id`, `is_email_notification_send`, `is_sms_notification_send`) VALUES
(680, 3, 1, '1', '0'),
(681, 3, 3, '0', '0'),
(682, 3, 5, '0', '0'),
(683, 3, 7, '0', '0'),
(684, 3, 9, '1', '0'),
(685, 3, 11, '1', '0'),
(686, 3, 13, '1', '0'),
(687, 3, 15, '1', '0'),
(688, 3, 17, '1', '0'),
(689, 3, 19, '1', '0'),
(690, 3, 21, '1', '0'),
(691, 3, 23, '1', '0'),
(692, 3, 25, '1', '0'),
(693, 3, 27, '0', '0'),
(694, 3, 29, '1', '0'),
(695, 3, 31, '0', '0'),
(696, 3, 33, '1', '0'),
(697, 3, 35, '1', '0'),
(698, 3, 37, '1', '0'),
(699, 3, 38, '1', '0'),
(700, 3, 39, '1', '0'),
(701, 3, 40, '1', '0'),
(702, 3, 41, '1', '0'),
(703, 3, 42, '1', '0'),
(704, 3, 43, '1', '0'),
(705, 3, 47, '0', '0'),
(706, 3, 50, '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `emts_member_rating`
--

CREATE TABLE `emts_member_rating` (
  `rating_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `overall_rating` double(5,1) NOT NULL DEFAULT '0.0',
  `rating_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment` varchar(200) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_member_rating`
--

INSERT INTO `emts_member_rating` (`rating_id`, `from_user_id`, `to_user_id`, `overall_rating`, `rating_date`, `comment`, `product_id`) VALUES
(1, 9, 32, 4.0, '2016-07-21 11:29:09', 'test ss hello', 17),
(11, 29, 32, 4.0, '2016-07-20 05:56:51', 'hello', 40),
(12, 9, 29, 4.0, '2016-07-21 11:17:52', 'this is awesome', 17),
(13, 29, 9, 3.3, '2016-07-21 11:17:52', 'Thank you for wonderful time', 18),
(14, 29, 9, 1.0, '2016-07-24 01:10:35', 'this is too late...You ruined my business.', 20),
(15, 9, 29, 1.0, '2016-07-24 01:14:51', 'You did not support me.Although I made to win you..I am guilty for my deeds.', 20),
(16, 32, 9, 3.0, '2016-08-22 17:22:31', 'asdf', 17),
(17, 97, 98, 5.0, '2016-08-24 17:16:49', '', 85);

-- --------------------------------------------------------

--
-- Table structure for table `emts_member_socialmedia`
--

CREATE TABLE `emts_member_socialmedia` (
  `id` int(11) NOT NULL,
  `media_type_id` int(11) DEFAULT NULL,
  `isActive` enum('1','0') NOT NULL DEFAULT '1' COMMENT '1->Active ;0->Inactive',
  `user_id` int(11) DEFAULT NULL,
  `socialmedia_id` varchar(50) DEFAULT NULL COMMENT 'social media integration id',
  `email` varchar(50) DEFAULT NULL,
  `access_token` varchar(150) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `page_id` varchar(100) DEFAULT NULL,
  `total_reach` int(11) DEFAULT NULL,
  `avg_reach` int(11) DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  `rating` varchar(10) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `date_modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emts_member_socialmedia`
--

INSERT INTO `emts_member_socialmedia` (`id`, `media_type_id`, `isActive`, `user_id`, `socialmedia_id`, `email`, `access_token`, `username`, `page_id`, `total_reach`, `avg_reach`, `country`, `rating`, `category_id`, `date_modified`) VALUES
(25, 1, '1', 81, '1282878575075700', NULL, 'EAAEGb24WyAkBAA42uBlrZAxgu7Ay6RrCCVh53Kbg0ZAaOhha7tvWa3HAw7Tp4sw6BjYz8cnXHjfAZC6tj1OCTzBbICLrXdoGUtGQoMZBmGos2i3wql0pcULValxzprZAJf3fBQaXkWdDuJhVVWYce', NULL, '1558120121124011', 696, 0, '', '5', 0, '2017-04-25 13:01:07'),
(26, 3, '1', 82, '2024372666', 'insta@gmail.com', '2024372666.883511e.04d1125978654a7f9fbac58106b45687', 'saagarchapagain', NULL, 142, 0, '', NULL, 0, '2017-05-04 10:11:52'),
(27, 1, '1', 82, '1780670512218555', NULL, 'EAAEGb24WyAkBAI38ExBLTmbWfMhtBC6iyQkMYCZA9rTTPUfGOnwrB6cz4U2ig62Ml9hPqJ78KUNHHUuvyWP1KMTkF8FO2mFapewlNx8H67AoifSRqih34mXiy8eSNohfzN3CVco4JpBdUVOUZAd9d', NULL, '1718106361761342', 1, 0, '', NULL, 0, '2017-04-24 14:04:54'),
(28, 5, '1', 84, 'sagaryoutulee', 'sagar@youtulee.com', '', 'youtuleesagar', NULL, 500, 200, 'Nepal', '5', 0, '2017-04-19 10:15:26'),
(29, 5, '1', 85, 'youtule', 'youtulee@gmail.com', '', 'youtuleesagar', NULL, 1000, 500, 'Nepal', '5', 0, '2017-04-24 12:07:53'),
(38, 6, '1', 82, 'luisxg.com', NULL, 'M2vQG5yNdRrfS1AYbq3yu6uVAxCEZR9eX7T8jTft6BousZCBiH', 'themylifemychoices', NULL, 12, 12, '12', '12', 0, '2017-05-02 15:47:06'),
(43, 6, '1', 85, 'techking-sagar.tumblr.com', NULL, 'yX0J41tYaLuw5z0sOQWSNyGyjws74cLKAA3OjVO8Rf61OSEO1X', NULL, NULL, 2, 0, '', '0', 0, '2017-05-04 09:59:12'),
(50, 2, '1', 96, '854595028072620032', 'emts.testers@gmail.com', '854595028072620032-uvXyvfYZYgkUVWpylBj8lnF77g7AKGf', 'Rockmultitech', NULL, 3, 0, NULL, NULL, 0, '2017-05-11 11:51:44'),
(51, 4, '1', 97, '105388039004193259795', 'saagarchapagain@gmail.com', 'ya29.Gl1HBDhElBvl2iOdRu-1Egla9lITkYSTRvy4BRrZu4jJCYYeBWI_6GNdRTHJhT2T9S4NIL13S8q-hHtOrWsZYKxrjxZlCrrRdMWJOaKN7CAbGBE44To77SL0iyx7pps', NULL, 'UCNlkRMK0uptntjt6m1gFU3A', 3, 0, '', '0', 0, '2017-05-11 14:43:23'),
(52, 6, '1', 101, 'themylifemychoice.tumblr.com', 'test@gmail.com', 'xSBEnpddcKKsaNxGnMQc0IQeKlPnIEGUwzebXlA5DCELwUgPsV', 'themylifemychoice', NULL, 2, 0, '', NULL, 0, '2017-05-26 16:21:16'),
(53, 4, '1', 103, '101479471505561676238', 'emts.testers@gmail.com', 'ya29.GltWBKqBM2CvWmYCy6qKPmxwexcOG08qfZ4ln_9bu765HrVGNjjre-aZ6I1K6nWE03ORY3XiugUkXoLnn7ZJsjSi5lzqsk2pEP_yIQHyCe_3u9mBCqqE5kYtzuXF', NULL, 'UCd3f6aWdDhwEH8MJiZ52VTQ', 1, 0, '', '0', 0, '2017-05-26 16:23:38'),
(62, 2, '1', 126, '3237048300', 'lawaahaana@gmail.com', '3237048300-wtYtAntENzXDfmsM8mZwFsdDn9CCVCGaYdY8BHu', 'Srijanalawa', NULL, 3, 0, NULL, NULL, 0, '2017-07-04 17:11:50'),
(63, 2, '1', 127, '2678891990', 'sagar@emultitechsolution.coms', '2678891990-PTX69WlFrLmO2PONnK2Iis4nKJlfIRU4lLeDlHv', 'saagarchapagain', NULL, 8, 0, 'Nepal', NULL, 0, '2017-07-04 17:21:19'),
(69, 3, '1', 134, '5715935742', 'emts.testers@gmail.com', '5715935742.669c2af.37d4a597ce37432bae79bd80e4d5f5ab', 'up.trendly', NULL, 1, 0, '', NULL, 0, '2017-08-16 14:32:02');

-- --------------------------------------------------------

--
-- Table structure for table `emts_message`
--

CREATE TABLE `emts_message` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `reciepient_id` int(11) NOT NULL,
  `subject` varchar(1024) NOT NULL,
  `body` longtext NOT NULL,
  `attachment` varchar(100) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=unread,1=read',
  `seller_del_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=No, 1=Yes',
  `buyer_del_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=No, 1=Yes'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emts_meta_categories`
--

CREATE TABLE `emts_meta_categories` (
  `category_id` int(11) NOT NULL,
  `field_id` int(11) UNSIGNED NOT NULL,
  `field_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='custom fields categories';

--
-- Dumping data for table `emts_meta_categories`
--

INSERT INTO `emts_meta_categories` (`category_id`, `field_id`, `field_order`) VALUES
(36, 12, 0),
(95, 12, 0),
(32, 11, 0),
(103, 11, 0),
(34, 11, 0),
(3, 14, 0),
(8, 14, 0),
(11, 14, 0),
(13, 14, 0);

-- --------------------------------------------------------

--
-- Table structure for table `emts_meta_fields`
--

CREATE TABLE `emts_meta_fields` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'primary key',
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` enum('CHECKBOX','DATE','DATETIME','DROPDOWN','EMAIL','FILE','NUMBER','RADIO','TEXT','TEXTAREA','URL') NOT NULL DEFAULT 'TEXT',
  `options` varchar(2048) DEFAULT NULL COMMENT 'if field is select or radio',
  `extensions` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'files extensions if type is file',
  `validation_rules` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'validation rules in json format',
  `added_date` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `form_field_type` enum('custom','basic') NOT NULL DEFAULT 'custom' COMMENT 'defines whether this field is basic field or custom field',
  `basic_field_order` int(11) NOT NULL COMMENT 'defines the order of field if it is basic fields'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='custom fields';

--
-- Dumping data for table `emts_meta_fields`
--

INSERT INTO `emts_meta_fields` (`id`, `name`, `slug`, `type`, `options`, `extensions`, `validation_rules`, `added_date`, `last_update`, `form_field_type`, `basic_field_order`) VALUES
(1, 'Document Attachment', 'Document Attachment', 'FILE', '', 'doc,xls,pdf', '', '2016-05-18 16:58:09', '2016-08-09 06:37:47', 'basic', 2),
(4, 'Document Information', 'Document Information', 'TEXT', '', '', '', '2016-06-08 18:06:40', '2016-08-09 06:37:47', 'basic', 1),
(5, 'Author', 'Author', 'TEXT', '', '', '', '2016-06-09 10:09:03', '2016-06-09 04:24:03', 'custom', 0),
(6, 'Publication', 'Publication', 'TEXT', '', '', '{\"required\":\"true\"}', '2016-06-09 10:15:48', '2016-06-09 04:30:48', 'custom', 0),
(7, 'genre', 'genre', 'TEXT', '', '', '{\"required\":\"true\"}', '2016-06-09 10:17:38', '2016-06-09 04:32:38', 'custom', 0),
(8, 'Genre', 'Genre', 'TEXT', '', '', '', '2016-06-09 10:18:17', '2016-06-09 04:33:17', 'custom', 0),
(9, 'Platform', 'Platform', 'TEXT', '', '', '{\"required\":\"true\"}', '2016-06-09 11:56:03', '2016-06-09 06:11:03', 'custom', 0),
(10, 'Website', 'Website', 'URL', '', '', '{\"url\":\"true\",\"required\":\"true\"}', '2016-06-09 11:56:35', '2016-06-09 06:11:35', 'custom', 0),
(11, 'Brand', 'Brand', 'TEXT', '', '', '', '2016-06-22 16:16:53', '2016-08-03 20:15:32', 'custom', 0),
(14, 'test', 'test', 'TEXT', '', '', '{\"required\":\"true\"}', '2016-08-09 12:26:06', '2016-08-09 18:26:06', 'custom', 0);

-- --------------------------------------------------------

--
-- Table structure for table `emts_meta_products`
--

CREATE TABLE `emts_meta_products` (
  `product_id` int(11) NOT NULL COMMENT 'id(pk) of product table',
  `meta_fields_id` int(11) NOT NULL COMMENT 'id(pk) of met_fields table',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emts_meta_products`
--

INSERT INTO `emts_meta_products` (`product_id`, `meta_fields_id`, `value`) VALUES
(11, 1, 'f7c00bc2cd347196d100b0132c30e423.docx'),
(14, 4, ''),
(15, 4, ''),
(15, 11, ''),
(16, 1, '76d37761e7e9d16e2c5a3f29358f37bb.docx'),
(16, 4, 'toy user guide'),
(17, 4, ''),
(11, 4, 'test document'),
(11, 11, 'Apple'),
(19, 4, ''),
(20, 4, ''),
(21, 4, ''),
(22, 4, ''),
(23, 4, ''),
(24, 4, ''),
(25, 4, ''),
(27, 4, ''),
(28, 4, ''),
(29, 4, 'sasd'),
(30, 4, 'sasd'),
(31, 4, ''),
(33, 4, ''),
(34, 4, ''),
(35, 4, ''),
(36, 4, ''),
(41, 4, ''),
(35, 4, ''),
(35, 4, ''),
(35, 4, ''),
(42, 4, ''),
(39, 4, ''),
(37, 4, ''),
(44, 4, ''),
(43, 4, ''),
(45, 4, ''),
(38, 4, ''),
(46, 4, ''),
(47, 4, ''),
(48, 4, ''),
(49, 4, ''),
(50, 4, ''),
(51, 4, ''),
(52, 4, ''),
(53, 4, ''),
(53, 11, 'ABC'),
(54, 4, ''),
(55, 4, ''),
(55, 13, '4'),
(55, 11, 'iphone'),
(56, 4, ''),
(56, 14, 'sdf'),
(57, 4, ''),
(57, 14, '1'),
(58, 4, ''),
(58, 11, 'toyota'),
(59, 4, 'Mollitia corporis officia reprehenderit qui tempore ullam necessitatibus excepturi officia qui tempor praesentium quas impedit anim deserunt velit'),
(59, 14, 'Illo autem sed ipsam tempore dolorem perferendis do et perferendis quia quae quisquam voluptatem'),
(60, 4, 'Quibusdam culpa est sed proident'),
(60, 14, 'ffdggggg'),
(61, 4, ''),
(62, 4, ''),
(62, 14, 'test'),
(63, 4, 'Aliquip excepteur est maiores laborum exercitationem ut assumenda ullamco iure labore voluptate ut voluptatem Voluptatem Repellendus Est fugiat voluptatem Totam'),
(64, 4, 'Minus expedita sed ullamco molestiae nisi Nam asperiores ut consequatur deserunt qui in'),
(64, 14, 'Odio accusamus odio molestiae ut in incididunt et sed ducimus molestiae mollit cupiditate ad cupiditate'),
(65, 4, ''),
(65, 14, 'test'),
(66, 4, ''),
(66, 14, 'what is this?'),
(67, 4, ''),
(68, 4, ''),
(68, 11, ''),
(69, 4, ''),
(69, 14, 'er'),
(70, 4, ''),
(70, 11, 'nokia'),
(71, 4, ''),
(72, 4, ''),
(72, 14, 'nbvc'),
(73, 4, ''),
(73, 11, 'asdf'),
(74, 4, ''),
(75, 4, ''),
(76, 4, ''),
(76, 14, 'asdf'),
(77, 4, 'asdf'),
(77, 14, 'asdf'),
(78, 4, ''),
(78, 14, 'asdf'),
(79, 4, ''),
(79, 14, 'asdf'),
(80, 4, ''),
(80, 14, 'asdf'),
(81, 4, ''),
(81, 14, 'asdf'),
(82, 4, ''),
(82, 14, 'asdf'),
(83, 4, ''),
(83, 14, 'asdf'),
(84, 4, ''),
(84, 14, 'fsdfg'),
(85, 4, ''),
(86, 4, ''),
(86, 14, 'why'),
(87, 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `emts_news_letter`
--

CREATE TABLE `emts_news_letter` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `send_test_email` enum('Yes','No') NOT NULL,
  `is_display` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=No, 1=Yes',
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_news_letter`
--

INSERT INTO `emts_news_letter` (`id`, `subject`, `message`, `send_test_email`, `is_display`, `post_date`, `update_date`) VALUES
(2, 'Test News Letter', '<p>\r\n	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br />\r\n	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br />\r\n	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo<br />\r\n	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse<br />\r\n	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non<br />\r\n	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n', 'Yes', '1', '2016-05-18 09:38:03', '2016-05-18 09:38:03'),
(3, 'Test Newsletter 2', '<p>\r\n	Dear [USERNAME],</p>\r\n<p>\r\n	<br />\r\n	We are offering new membership packages at 50% discount.</p>\r\n<p>\r\n	Please Check Membership Package Section in our site for more details</p>\r\n<p>\r\n	Thank you</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	[SITENAME]</p>\r\n', 'Yes', '1', '2016-06-01 12:20:46', '2016-06-01 12:20:46'),
(4, 'test', '<p>\r\n	hellop sir,</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	This is a test mail</p>\r\n', 'Yes', '1', '2016-07-07 06:34:47', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `emts_notification`
--

CREATE TABLE `emts_notification` (
  `id` int(11) NOT NULL,
  `notification_message` varchar(250) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `isnotifyseen` enum('0','1') NOT NULL COMMENT '0->No ,1->Yes',
  `is_display` enum('0','1') NOT NULL COMMENT '0->No,1->Yes',
  `datetime` datetime DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_notification`
--

INSERT INTO `emts_notification` (`id`, `notification_message`, `user_id`, `isnotifyseen`, `is_display`, `datetime`, `product_id`) VALUES
(3, 'You have been Selected for the campaign', 81, '0', '1', '2017-08-10 00:00:00', 198),
(4, 'You have been Selected for the campaign', 82, '1', '1', '2017-08-10 00:00:00', 198),
(5, 'Influencer   has accepted your request to promote campaigntest test double', NULL, '0', '0', '2017-08-10 01:46:54', 198),
(8, 'You have received a draft of promotion for the campaign <a href=\"http://202.166.198.151:8888/uptrendly/brand/getproposalbyproduct/150184678783\">test test double </a>.Please review the draft', 83, '1', '1', '2017-08-10 01:56:12', 198),
(7, 'Influencer   has accepted your request to promote campaigntest test double', 83, '1', '1', '2017-08-10 01:50:33', 198),
(9, 'Your Product is live and running', 83, '1', '1', '2017-08-10 02:37:16', 198),
(10, 'You have been Selected for the campaign', 81, '0', '1', '2017-08-10 00:00:00', 198),
(11, 'You have been Selected for the campaign', 82, '1', '1', '2017-08-10 00:00:00', 198),
(12, 'Your Product is live and running', 83, '1', '1', '2017-08-10 02:38:10', 197),
(13, 'You have been Selected for the campaign', 81, '0', '1', '2017-08-10 00:00:00', 197),
(14, 'You have been Selected for the campaign', 82, '1', '1', '2017-08-10 00:00:00', 197),
(15, 'You have been Selected for the campaign', 84, '0', '1', '2017-08-10 00:00:00', 197),
(16, 'You have been Selected for the campaign', 85, '0', '1', '2017-08-10 00:00:00', 197),
(17, 'Your Product is live and running', 83, '1', '1', '2017-08-10 02:39:18', 197),
(18, 'You have been Selected for the campaign', 81, '0', '1', '2017-08-10 00:00:00', 197),
(19, 'You have been Selected for the campaign', 82, '1', '1', '2017-08-10 00:00:00', 197),
(20, 'You have been Selected for the campaign', 84, '0', '1', '2017-08-10 00:00:00', 197),
(21, 'You have been Selected for the campaign', 85, '0', '1', '2017-08-10 00:00:00', 197),
(22, 'Your Product is live and running', 83, '1', '1', '2017-08-10 02:39:26', 197),
(23, 'You have been Selected for the campaign', 81, '0', '1', '2017-08-10 00:00:00', 197),
(24, 'You have been Selected for the campaign', 82, '1', '1', '2017-08-10 00:00:00', 197),
(25, 'You have been Selected for the campaign', 84, '0', '1', '2017-08-10 00:00:00', 197),
(26, 'You have been Selected for the campaign', 85, '0', '1', '2017-08-10 00:00:00', 197),
(27, 'Your Product is Rejected by Admin', 83, '1', '1', '2017-08-10 02:39:49', 197),
(28, 'Your Product is Rejected by Admin', 83, '1', '1', '2017-08-10 02:39:57', 197),
(29, 'Your Product is live and running', 83, '1', '1', '2017-08-17 09:50:12', 198),
(30, 'You have been Selected for the campaign', 84, '0', '1', '2017-08-17 00:00:00', 198),
(31, 'You have been Selected for the campaign', 85, '0', '1', '2017-08-17 00:00:00', 198),
(32, 'You have been Selected for the campaign', 96, '0', '1', '2017-08-17 00:00:00', 198),
(33, 'You have received a draft of promotion for the campaign <a href=\"http://202.166.198.151:8888/uptrendly/brand/getproposalbyproduct/150155909783\">check </a>.Please review the draft', 83, '1', '1', '2017-08-21 05:32:14', 191);

-- --------------------------------------------------------

--
-- Table structure for table `emts_objective`
--

CREATE TABLE `emts_objective` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `STATUS` enum('1','0') NOT NULL COMMENT '1->active,0->inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_objective`
--

INSERT INTO `emts_objective` (`id`, `name`, `STATUS`) VALUES
(1, 'Push Sales', '1'),
(2, 'Brand Recognition', '1'),
(5, 'CSR', '1'),
(6, 'Others', '1');

-- --------------------------------------------------------

--
-- Table structure for table `emts_payment_gateway`
--

CREATE TABLE `emts_payment_gateway` (
  `id` int(11) NOT NULL,
  `payment_gateway` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `payment_logo` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('1','2') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Test Mode, 2 = Live Mode',
  `is_display` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emts_payment_gateway`
--

INSERT INTO `emts_payment_gateway` (`id`, `payment_gateway`, `payment_logo`, `email`, `status`, `is_display`, `last_update`) VALUES
(1, 'Paypal', 'pym1.jpg', 'emts.me@gmail.com', '1', 'Yes', '2016-09-05 19:38:15');

-- --------------------------------------------------------

--
-- Table structure for table `emts_pricerange`
--

CREATE TABLE `emts_pricerange` (
  `id` int(11) NOT NULL,
  `price_range` varchar(150) NOT NULL,
  `priority` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_pricerange`
--

INSERT INTO `emts_pricerange` (`id`, `price_range`, `priority`) VALUES
(1, '100-250', 1),
(2, '250-500', 2),
(3, '500-1000', 3),
(4, '1000-2000', 4),
(5, '2000+', 5),
(6, '0-100', 0);

-- --------------------------------------------------------

--
-- Table structure for table `emts_products`
--

CREATE TABLE `emts_products` (
  `id` int(11) NOT NULL,
  `product_code` bigint(20) NOT NULL COMMENT 'unique integer product id to display to user',
  `cat_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sub_cat_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `auction_type` enum('1','2') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=public, 2=private',
  `bid_decrement` int(11) NOT NULL,
  `auction_time_zone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `budget` double(20,2) NOT NULL,
  `currency` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `post_date` timestamp NULL DEFAULT NULL,
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `auc_start_time` datetime NOT NULL,
  `submission_deadline` datetime NOT NULL,
  `auc_end_time` datetime NOT NULL,
  `status` enum('1','2','3','4') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Pending, 2=Active, 3=Closed, 4=Cancelled',
  `payment_type` enum('free','paid','unlimited') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'paid' COMMENT 'free, paid or unlimited',
  `winner_notified` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT 'product won notification emailed to winner or not',
  `product_url` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price_range` int(11) NOT NULL,
  `least_fan_count` int(11) DEFAULT NULL,
  `campaign_type` enum('normal','budget','smart') COLLATE utf8_unicode_ci NOT NULL,
  `create_type` enum('campaign','collab') COLLATE utf8_unicode_ci DEFAULT NULL,
  `reject_reason` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `save_method` enum('1','2') COLLATE utf8_unicode_ci NOT NULL COMMENT '1=>Open for Bid,2=>Save to Draft',
  `product_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pan_no` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `owner_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `contact_no` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `critical_deadline` datetime DEFAULT NULL,
  `time_sensitive` enum('1','0') COLLATE utf8_unicode_ci NOT NULL COMMENT '1->is sensitive ,0->no senstive',
  `tentative_budget` int(11) DEFAULT NULL,
  `tentative_date` date DEFAULT NULL,
  `no_influencer` int(11) DEFAULT NULL,
  `preferred_gender` enum('m','f') COLLATE utf8_unicode_ci NOT NULL,
  `preferred_age` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `smart_status` enum('0','1','2') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emts_products`
--

INSERT INTO `emts_products` (`id`, `product_code`, `cat_id`, `sub_cat_id`, `brand_id`, `name`, `description`, `auction_type`, `bid_decrement`, `auction_time_zone`, `budget`, `currency`, `post_date`, `update_date`, `auc_start_time`, `submission_deadline`, `auc_end_time`, `status`, `payment_type`, `winner_notified`, `product_url`, `price_range`, `least_fan_count`, `campaign_type`, `create_type`, `reject_reason`, `save_method`, `product_name`, `pan_no`, `owner_name`, `contact_no`, `critical_deadline`, `time_sensitive`, `tentative_budget`, `tentative_date`, `no_influencer`, `preferred_gender`, `preferred_age`, `smart_status`) VALUES
(128, 149251518281, '0', '', 81, 'Get Facebook like of 1000', 'I would like to get facebook like of 1000 is there any one who can help', '1', 0, '', 0.00, '', '2017-04-18 11:33:02', '2017-06-29 04:48:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', NULL, 0, 50, 'normal', 'collab', '', '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(129, 149251604883, '102', '', 83, 'My campaign', 'This is test campaign please apply bt best players in town of nepal', '1', 0, '', 0.00, '', '2017-04-18 11:47:28', '2017-06-29 04:03:10', '0000-00-00 00:00:00', '2017-04-20 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 1, 999, 'normal', 'campaign', '', '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(130, 149257653984, '0', '', 84, 'Youtulee groe', 'We would like to work together', '1', 0, '', 0.00, '', '2017-04-19 04:35:39', '2017-04-19 04:39:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', NULL, 0, 100, 'normal', 'collab', '', '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(131, 149258227281, '0', '', 81, 'My facebook get 1000 likes', 'Hi i would love to get 1000likes with your help', '1', 0, '', 0.00, '', '2017-04-19 06:11:12', '2017-04-19 06:11:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', NULL, 0, 1, 'normal', 'collab', '', '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(132, 149301441983, '103', '', 83, 'check for all media', 'This is to test all media.Please check it all', '1', 0, '', 0.00, '', '2017-04-24 06:13:39', '2017-05-30 08:34:08', '0000-00-00 00:00:00', '2017-04-28 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://triad.org.np', 1, 1, 'normal', 'campaign', '', '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(133, 149319929083, '102', '', 83, 'media campaign', 'this is my media cmapaign check it', '1', 0, '', 0.00, '', '2017-04-26 09:34:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-04-28 00:00:00', '0000-00-00 00:00:00', '1', 'paid', '0', 'http://mediacampaign.com.bp', 1, 1, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(134, 149369490186, '0', '', 86, 'This is tumblr test', 'This is to notify this social media is newly created', '1', 0, '', 0.00, '', '2017-05-02 03:15:01', '2017-05-02 03:23:44', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', NULL, 0, 1, 'normal', 'collab', '', '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(135, 149372231683, '102', '', 83, 'test', 'sdfsdf', '1', 0, '', 0.00, '', '2017-05-02 10:51:56', '2017-05-02 10:52:14', '0000-00-00 00:00:00', '2017-05-18 00:00:00', '0000-00-00 00:00:00', '1', 'paid', '0', 'http://url.com', 1, 1000, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(136, 149396493281, '0', '', 81, 'check collab', 'asda lsakd jsalkjdaslkd', '1', 0, '', 0.00, '', '2017-05-05 06:15:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', 'paid', '0', NULL, 0, 100, 'normal', 'collab', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(137, 1496030236111, '103', '', 111, 'tomatoes', 'this is good flavoured tomatores', '1', 0, '', 0.00, '', '2017-05-29 03:57:16', '2017-05-29 03:57:41', '0000-00-00 00:00:00', '2017-06-08 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://goodtomattoes.com', 1, 0, 'normal', 'campaign', '', '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(138, 149605708283, '102', '', 83, 'testing', 'check my testing hell', '1', 0, '', 0.00, '', '2017-05-29 11:24:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-06-26 00:00:00', '0000-00-00 00:00:00', '1', 'paid', '0', 'http://checkmytest.com', 1, 1, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(139, 149611755383, '102', '', 83, 'This is test', 'test work we acan fdo for this', '1', 0, '', 0.00, '', '2017-05-30 04:12:33', '2017-06-27 05:33:48', '0000-00-00 00:00:00', '2017-06-27 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://url.com', 2, 1000, 'normal', 'campaign', '', '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(143, 149613876583, '102', '', 83, 'Suman Sanga', 'Egal wo auf der Welt Sie sind, Hundeliebhaber sind überall! Egal, ob Sie Deutsche Doggen, Schäferhunde,', '1', 0, '', 0.00, '', '2017-05-30 10:06:05', '2017-06-27 05:33:39', '0000-00-00 00:00:00', '2017-06-20 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 2, 1000, 'normal', 'campaign', '', '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(144, 149854028383, '106', '', 83, 'Pulsar Dare Venture', 'Pulsar Dare Venture is a first ever biking reality show in Nepal.\r\nPulsar Dare Venture is a first ever biking reality show in Nepal.\r\nPulsar Dare Venture is a first ever biking reality show in Nepal.', '1', 0, '', 0.00, '', '2017-06-27 05:11:23', '2017-06-27 05:33:33', '0000-00-00 00:00:00', '2017-07-20 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://ktv.ekantipur.com/show/pulsar-dare-venture.html', 5, 300, 'normal', 'campaign', '', '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(145, 149854126983, '103', '', 83, 'Elegance at its best', 'Rasna Shrestha (MuCe) brought a scintillating start to the third day of Ruslan The Himalayan Times TGIF Nepal Fashion Week 2017 on April 7 at Hyatt Regency Kathmandu.', '1', 0, '', 0.00, '', '2017-06-27 05:27:49', '2017-06-27 05:33:27', '0000-00-00 00:00:00', '2017-07-27 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'https://thehimalayantimes.com/category/fashion/', 5, 200, 'normal', 'campaign', '', '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(146, 149854152383, '103', '', 83, 'Nation’s biggest fashion gala ends on high note', 'Another exhilarating chapter of Nepal’s fashion came to a captivating conclusion, but not without leaving a trail of mind-blowing designs.', '1', 0, '', 0.00, '', '2017-06-27 05:32:03', '2017-06-27 05:33:21', '0000-00-00 00:00:00', '2017-08-25 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'https://thehimalayantimes.com/fashion/ruslan-the-himalayan-times-tgif-nepal-fashion-week-2017-ends-high-note/', 5, 250, 'normal', 'campaign', '', '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(147, 149855038183, '103', '', 83, 'COUNSELh', 'eck', '1', 0, '', 0.00, '', '2017-06-27 07:59:41', '2017-06-27 08:09:59', '0000-00-00 00:00:00', '2017-06-30 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'https://www.nytimes.com/section/magazine', 6, 40, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(148, 149855579783, '106', '', 83, 'check', 'Checking Campain', '1', 0, '', 0.00, '', '2017-06-27 09:29:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-06-28 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://202.166.198.151:8888/uptrendly/creator/sponsorship/public', 6, 10, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(149, 149855892381, '0', '', 81, 'test', 'adafff', '1', 0, '', 0.00, '', '2017-06-27 10:22:03', '2017-06-27 10:51:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', NULL, 0, 1, 'normal', 'collab', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(150, 149871379883, '108', '', 83, 'campaign check', 'shjjwkjv thhe namme the to ce', '1', 0, '', 0.00, '', '2017-06-29 05:23:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-06-30 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://202.166.198.151:8888/uptrendly/my-account/Detailmessages/18', 6, 1, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(151, 1498716818116, '103', '', 116, 'first campaign', 'the thhd hdsabbuewbfqwerty us is the name of thw paeop', '1', 0, '', 0.00, '', '2017-06-29 06:13:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-06-30 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://202.166.198.151:8888/uptrendly/my-account/brand', 6, 2, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(152, 149872637481, '0', '', 81, 'join us', 'ssssssss', '1', 0, '', 0.00, '', '2017-06-29 08:52:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', NULL, 0, 1, 'normal', 'collab', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(153, 149915630083, '107', '', 83, 'Campaign Check', 'uifufuwi thhuewii fhurvcaahfhthwe uuwiqwertry n thw inthhe is', '1', 0, '', 0.00, '', '2017-07-04 08:18:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-28 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://www.newyorker.com/news/john-cassidy/donald-trump-will-go-down-in-history-as-the-troll-in-chief', 6, 1, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(154, 149915664481, '0', '', 81, 'Join With me', 'join with me to add', '1', 0, '', 0.00, '', '2017-07-04 08:24:04', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', NULL, 0, 1, 'normal', 'collab', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(155, 150037808383, '102', '', 83, 'test1234', 'test1234', '1', 0, '', 0.00, '', '2017-07-18 11:41:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-27 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 1, NULL, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(156, 150044520083, '102', '', 83, 'asdaadaasd', 'asd', '1', 0, '', 0.00, '', '2017-07-19 06:20:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-26 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 6, NULL, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(157, 150045163883, '103', '', 83, 'asdasd', 'asdasd', '1', 0, '', 0.00, '', '2017-07-19 08:07:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-28 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 6, NULL, 'budget', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(158, 150045285683, '102', '', 83, 'test', 'sfd', '1', 0, '', 0.00, '', '2017-07-19 08:27:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-27 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 6, NULL, 'budget', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(160, 150045304883, '103', '', 83, 'test2', 'asdasd', '1', 0, '', 0.00, '', '2017-07-19 08:30:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-27 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 6, NULL, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(162, 150045336283, '104', '', 83, 'Tashya Dean', 'Qui suscipit eu deserunt sint aperiam saepe ut', '1', 0, '', 0.00, '', '2017-07-19 08:36:02', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-27 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 6, NULL, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(163, 150045360383, '103', '', 83, 'asd', 'sdfsdf', '1', 0, '', 0.00, '', '2017-07-19 08:40:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-28 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 1, NULL, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(168, 150045433483, '105', '', 83, 'Alice Albert', 'Nobis est ad iusto nobis animi aut aperiam nemo nostrud totam distinctio Numquam aliquid in aut', '1', 0, '', 0.00, '', '2017-07-19 08:52:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-27 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 4, NULL, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(169, 150045443683, '109', '', 83, 'Indira Rowland', 'Quas quia soluta eum hic hic', '1', 0, '', 0.00, '', '2017-07-19 08:53:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-25 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 4, NULL, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(170, 150045489683, '102', '', 83, 'das', 'ads', '1', 0, '', 0.00, '', '2017-07-19 09:01:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-08-02 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 1, NULL, 'budget', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(171, 150046276783, '104', '', 83, '234', 'dfsgdfg', '1', 0, '', 0.00, '', '2017-07-19 11:12:47', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-27 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 3, NULL, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(172, 150046345683, '102', '', 83, 'asdaadasdasd', 'ad', '1', 0, '', 0.00, '', '2017-07-19 11:24:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-08-04 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 1, NULL, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(173, 150046459083, '108', '', 83, 'Gloria Schroeder', 'Laboris ad reprehenderit tempor doloribus labore sed', '1', 0, '', 0.00, '', '2017-07-19 11:43:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-28 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 5, NULL, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(174, 150046466583, '103', '', 83, 'asdaad', 'aasd', '1', 0, '', 0.00, '', '2017-07-19 11:44:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-22 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 2, NULL, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(175, 150046497283, '108', '', 83, 'ws', 'df', '1', 0, '', 0.00, '', '2017-07-19 11:49:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-27 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 3, NULL, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(176, 150052392283, '102', '', 83, 'Oppo Mobile', 'kladf lkajfd lkajdf lkjadf lkjadflk', '1', 0, '', 0.00, '', '2017-07-20 04:12:02', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-21 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 1, NULL, 'normal', 'campaign', NULL, '1', '', '', '', '', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(177, 150052640983, '102', '', 83, 'test', 'sagar test', '1', 0, '', 0.00, '', '2017-07-20 04:53:29', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-28 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 6, NULL, 'normal', 'campaign', NULL, '1', 'taxxi', '54545454554', 'Khaja pasal', '9841121522', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(178, 150052993683, '102', '', 83, 'TEST', 'test', '1', 0, '', 0.00, '', '2017-07-20 05:52:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-27 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 6, NULL, 'normal', 'campaign', NULL, '1', 'taxxi', '54545454554', 'Khaja pasal', '9841121522', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(179, 150053089383, '105', '', 83, 'sdfdasf', 'zxcvxzcvcxz', '1', 0, '', 0.00, '', '2017-07-20 06:08:13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-29 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 1, NULL, 'normal', 'campaign', NULL, '1', 'taxxi', '54545454554', 'Khaja pasal', '9841121522', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(180, 150053435283, '107', '', 83, 'test', 'adakj', '1', 0, '', 0.00, '', '2017-07-20 07:05:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-28 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 6, NULL, 'budget', 'campaign', NULL, '1', 'taxxi', '54545454554', 'Khaja pasal', '9841121522', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(182, 150089404083, '102', '', 83, 'launcasd', 'asads', '1', 0, '', 0.00, '', '2017-07-24 11:00:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-26 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 1, NULL, 'normal', 'campaign', NULL, '1', 'taxxi', '54545454554', 'Khaja pasal', '9841121522', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(183, 150095523683, '104', '', 83, 'khjf', 'ulgkjhl', '1', 0, '', 0.00, '', '2017-07-25 04:00:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-07-27 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 1, NULL, 'normal', 'campaign', NULL, '1', 'taxxi', '54545454554', 'Khaja pasal', '9841121522', NULL, '1', NULL, NULL, NULL, 'm', NULL, '0'),
(184, 150112928083, '107', '', 83, 'rys xu sx6uj', 'rftutrrftutrrftutrrftutrrftutrrftutr', '1', 0, '', 0.00, '', '2017-07-27 04:21:20', '2017-08-02 03:25:06', '0000-00-00 00:00:00', '2017-07-29 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 5, NULL, 'normal', 'campaign', NULL, '1', 'taxxi', '54545454554', 'Khaja pasal', '9841121522', '2017-09-02 00:00:00', '1', 0, '0000-00-00', 0, '', '', '0'),
(187, 150147238583, '102', '', 83, 'test', 'test', '1', 0, '', 0.00, '', '2017-07-31 03:39:45', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-08-15 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 6, NULL, 'normal', 'campaign', NULL, '1', 'test', '54545454554', 'samer swar', '9841121522', '2017-09-06 00:00:00', '0', NULL, NULL, NULL, 'm', NULL, '0'),
(188, 150147345083, '105', '', 83, 'asd', 'asd', '1', 0, '', 0.00, '', '2017-07-31 03:57:30', '2017-08-24 10:31:15', '0000-00-00 00:00:00', '2017-07-31 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 6, NULL, 'smart', 'campaign', NULL, '1', 'asd', '5454as5454554', 'samer swar', '9841121522', '2017-07-31 00:00:00', '0', 1, '2017-08-30', 1, 'm', '25-35', '0'),
(190, 150149104483, '103', '', 83, 'celebrity campaign', 'this is celebrity campaign', '1', 0, '', 0.00, '', '2017-07-31 08:50:44', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2017-08-05 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 6, NULL, 'budget', 'campaign', NULL, '1', 'the axe', '54545454554', 'samer swar', '9841121522', '2017-08-05 00:00:00', '0', NULL, NULL, NULL, 'm', NULL, '0'),
(191, 150155909783, '107', '', 83, 'check', 'check detail', '1', 0, '', 0.00, '', '2017-08-01 03:44:57', '2017-08-01 04:26:22', '0000-00-00 00:00:00', '2017-08-01 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 6, NULL, 'budget', 'campaign', NULL, '1', 'check product', '54545454554', 'samer swar', '9841121522', '2017-08-01 00:00:00', '0', NULL, NULL, NULL, 'm', NULL, '0'),
(192, 150156163383, '102', '', 83, 'test test', 'test campagign', '1', 0, '', 0.00, '', '2017-08-01 04:27:13', '2017-08-01 06:15:29', '0000-00-00 00:00:00', '2017-09-01 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 6, NULL, 'normal', 'campaign', NULL, '2', 'test campaign', '54545454554', 'samer swar', '9841121522', '2017-09-08 00:00:00', '0', NULL, NULL, NULL, 'm', NULL, '0'),
(193, 150156848783, '102', '', 83, 'check test', 'ce', '1', 0, '', 0.00, '', '2017-08-01 06:21:27', '2017-08-01 10:31:32', '0000-00-00 00:00:00', '2017-08-31 00:00:00', '0000-00-00 00:00:00', '2', 'paid', '0', 'http://taxxi.com', 6, NULL, 'smart', 'campaign', NULL, '2', 'check test', '54545454554', 'samer swar', '9841121522', '2017-08-31 00:00:00', '0', 10, '0000-00-00', 0, '', '', '0'),
(196, 150158429483, '102', '', 83, 'test', 'test', '1', 0, '', 0.00, '', '2017-08-01 10:44:54', '2017-08-21 07:56:10', '0000-00-00 00:00:00', '2017-08-23 00:00:00', '0000-00-00 00:00:00', '1', 'paid', '0', 'http://taxxi.com', 6, NULL, 'smart', 'campaign', NULL, '1', 'test', '54545454554', 'samer swar', '343434', '2017-08-29 00:00:00', '1', 10, '2017-08-25', 5, 'm', '15-25', '1'),
(197, 150164438083, '102', '', 83, 'check last', 'check', '1', 0, '', 0.00, '', '2017-08-02 03:26:20', '2017-08-09 09:23:38', '0000-00-00 00:00:00', '2017-08-25 00:00:00', '0000-00-00 00:00:00', '4', 'paid', '0', 'http://taxxi.com', 6, NULL, 'normal', 'campaign', NULL, '1', 'check', '54545454554', 'samer swar', '9841121522', '2017-08-29 00:00:00', '1', 0, '0000-00-00', 0, '', '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `emts_product_bids`
--

CREATE TABLE `emts_product_bids` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_bid_amt` double(20,2) NOT NULL,
  `bid_details` text NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `bid_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `delivery_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mediaid` int(11) DEFAULT NULL,
  `status` enum('0','1','2','3','4','5','6','7') NOT NULL COMMENT '0=proposal sent,1=Actions Required,2=Changes Required,3=Funding Required,4=Declined,5=Canceled and refunded,6=Expired Proposals,7=Completed',
  `membermediaid` int(11) DEFAULT NULL,
  `productmediaid` int(11) DEFAULT NULL,
  `bidamount_paid` enum('0','1') NOT NULL,
  `socialtrackid` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emts_product_bids`
--

INSERT INTO `emts_product_bids` (`id`, `user_id`, `product_id`, `user_bid_amt`, `bid_details`, `attachment`, `bid_date`, `delivery_date`, `mediaid`, `status`, `membermediaid`, `productmediaid`, `bidamount_paid`, `socialtrackid`) VALUES
(17, 82, 131, 0.00, 'test atesasasd ad asd asda das d', '', '2017-04-25 08:41:15', '2017-04-28 18:15:00', 1, '7', 27, 65, '0', '1293032437412598'),
(23, 85, 130, 0.00, 'asd ad adad ad asdas', '', '2017-05-04 09:53:02', '2017-05-24 18:15:00', 5, '0', 29, 64, '0', NULL),
(29, 82, 137, 234234.00, 'asd asdsa dsa kasdka jkdja jkal d', '', '2017-05-29 03:58:11', '2017-05-28 18:15:00', 1, '0', 27, 109, '0', NULL),
(30, 82, 132, 1500.00, 'asda sa asdad ads adsada', '', '2017-06-29 03:49:53', '2017-06-05 18:15:00', 1, '5', 27, 161, '1', NULL),
(31, 81, 137, 10.00, '578ws4568  6si6tij reuthezauza reyar5hyryha43', '', '2017-06-27 08:48:06', '2017-06-28 18:15:00', 1, '0', 25, 109, '0', NULL),
(32, 81, 144, 10.00, 'sdt5z eryzd atwzryhyse st yenzwsy ', '', '2017-06-27 08:55:54', '2017-06-28 18:15:00', 1, '1', 25, 285, '1', '846691102090040_1419386198153858'),
(33, 81, 132, 50.00, 'this is check for sending proposal', '', '2017-06-27 08:40:36', '2017-06-28 18:15:00', 1, '7', 25, 161, '1', '846691102090040_1419386198153858'),
(34, 81, 145, 10.04, 'afffffffffffffffffffffffffffffffffgggggggg', '', '2017-06-27 09:10:13', '2017-06-27 18:15:00', 1, '4', 25, 299, '1', NULL),
(35, 81, 146, 10.00, 'aaaaaaaaaaaaaaaaaa jjjjjjjjjjjjjj', '', '2017-06-27 09:12:17', '2017-06-28 18:15:00', 1, '4', 25, 305, '1', NULL),
(36, 81, 148, 10.04, 'sssssssss ggggggggggg', '', '2017-06-27 09:32:12', '2017-06-29 18:15:00', 1, '1', 25, 311, '1', NULL),
(37, 81, 150, 15.00, 'this i smy proposal aaaafffffff', '', '2017-06-29 05:32:13', '2017-06-29 18:15:00', 1, '4', 25, 366, '1', NULL),
(38, 82, 150, 12.00, 'whhdhs hfffjdskk htthtut', '', '2017-06-29 05:44:25', '2017-06-28 18:15:00', 1, '7', 27, 366, '1', '1498714997_1419386198153858'),
(39, 82, 149, 0.00, 'sfhl sjjdjfdjfj sjsjsjjsjsjjss', '', '2017-06-29 05:45:46', '2017-06-29 18:15:00', 1, '0', 27, 314, '0', NULL),
(41, 82, 154, 0.00, 'rttttttttttttttttt gggggggggggggg', '', '2017-07-04 10:19:22', '2017-07-18 18:15:00', 1, '1', 27, 380, '0', NULL),
(42, 82, 153, 10.00, 'this is for sponsorship', '', '2017-07-25 04:22:32', '2017-07-24 18:15:00', 1, '2', 27, 378, '1', NULL),
(50, 82, 168, 0.00, '', '', '2017-07-18 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(51, 84, 168, 0.00, '', '', '2017-07-18 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(52, 81, 169, 0.00, '', '', '2017-07-18 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(53, 82, 169, 0.00, '', '', '2017-07-18 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(54, 81, 170, 0.00, '', '', '2017-07-18 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(55, 82, 170, 0.00, '', '', '2017-07-18 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(56, 81, 172, 0.00, '', '', '2017-07-18 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(57, 82, 172, 0.00, '', '', '2017-07-18 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(58, 81, 176, 0.00, '', '', '2017-07-19 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(59, 85, 176, 0.00, '', '', '2017-07-19 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(60, 81, 177, 0.00, '', '', '2017-07-19 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(61, 82, 177, 0.00, '', '', '2017-07-19 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(62, 81, 178, 0.00, '', '', '2017-07-19 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(63, 84, 178, 0.00, '', '', '2017-07-19 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(64, 81, 179, 0.00, '', '', '2017-07-19 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(65, 84, 179, 0.00, '', '', '2017-07-19 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(66, 81, 180, 0.00, '', '', '2017-07-19 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(70, 81, 183, 0.00, '', '', '2017-07-24 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(71, 82, 183, 0.00, '', '', '2017-08-10 07:49:27', '0000-00-00 00:00:00', NULL, '1', NULL, NULL, '0', NULL),
(72, 84, 183, 0.00, '', '', '2017-07-24 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(73, 85, 183, 0.00, '', '', '2017-07-24 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(78, 85, 128, 0.00, '', '', '2017-07-27 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(79, 84, 187, 0.00, '', '', '2017-07-30 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(80, 85, 187, 0.00, '', '', '2017-07-30 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(81, 85, 190, 0.00, '', '', '2017-07-30 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(97, 81, 191, 0.00, '', '', '2017-07-31 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(98, 82, 191, 0.00, '', '', '2017-08-04 04:43:49', '0000-00-00 00:00:00', NULL, '1', NULL, NULL, '0', NULL),
(102, 82, 192, 0.00, '', '', '2017-08-03 10:19:13', '0000-00-00 00:00:00', NULL, '4', NULL, NULL, '0', NULL),
(103, 85, 188, 0.00, '', '', '2017-07-31 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(109, 84, 193, 0.00, '', '', '2017-07-31 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(122, 81, 184, 0.00, '', '', '2017-08-01 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(123, 82, 184, 0.00, '', '', '2017-08-01 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(124, 84, 184, 0.00, '', '', '2017-08-01 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(125, 85, 184, 0.00, '', '', '2017-08-01 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(180, 81, 197, 0.00, '', '', '2017-08-08 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(181, 82, 197, 0.00, '', '', '2017-08-08 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(182, 84, 197, 0.00, '', '', '2017-08-08 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(183, 85, 197, 0.00, '', '', '2017-08-08 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(241, 84, 196, 0.00, '', '', '2017-08-20 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(242, 85, 196, 0.00, '', '', '2017-08-20 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(243, 96, 196, 0.00, '', '', '2017-08-20 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL),
(244, 134, 196, 0.00, '', '', '2017-08-20 18:15:00', '0000-00-00 00:00:00', NULL, '0', NULL, NULL, '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `emts_product_currency`
--

CREATE TABLE `emts_product_currency` (
  `id` int(11) NOT NULL,
  `currency_sign` varchar(10) NOT NULL,
  `currency_code` varchar(50) NOT NULL,
  `is_display` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=No, 1=Yes',
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_product_currency`
--

INSERT INTO `emts_product_currency` (`id`, `currency_sign`, `currency_code`, `is_display`, `post_date`, `update_date`) VALUES
(1, 'NRS', 'NRS', '1', '2016-07-07 06:24:59', '0000-00-00 00:00:00'),
(2, 'US$', 'USD', '1', '2016-08-19 10:00:40', '0000-00-00 00:00:00'),
(3, '£', 'GBP', '1', '2016-08-17 05:49:33', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `emts_product_images`
--

CREATE TABLE `emts_product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emts_product_images`
--

INSERT INTO `emts_product_images` (`id`, `product_id`, `image`) VALUES
(1, 131, 'f0b265a6bac75c1efc9630592dca4934.jpg'),
(2, 131, '69c49da72527aa52d6bb46f834be09d6.jpg'),
(3, 95, '75d881e13f391a05febb5d95c6cdcb21.jpg'),
(5, 97, '36a0e98be87f6f6e7dcab04e363ff041.jpg'),
(6, 109, '0a64a8207ef38afd143945e1df097df7.jpg'),
(7, 113, '1ca939d42a832b5250aa8e2d40d25765.jpg'),
(8, 114, '479cc3f73a7bf0a740537bfdad5394d3.jpg'),
(9, 118, '882c80d2bae3cbd717d99e7b9803a2b7.png'),
(10, 121, '5cff4056c545cf061a3ca05e229f3e09.png'),
(11, 122, '3d147bba7d573c2118ef8458ca42bf49.jpg'),
(12, 124, '60b5e6e5682ea692da17a3fbab91c8a0.jpg'),
(13, 129, 'c6d26dd2461d94590a85b12d1ad19041.jpg'),
(14, 132, '68e6ae30b5d61aea0ffac706fc61699a.jpg'),
(15, 133, '68aab54d7d54f6930ad597b791298a4a.jpg'),
(16, 135, '93ad738976ade72812f8b73ecd511ba0.jpg'),
(17, 137, '572dfcb5ac3d6bdb3c7defb35c1908fd.png'),
(18, 138, '5c47e3832d1e98440893ecbaada73c96.jpg'),
(19, 139, '2eb2d240d9b97bdceaac85874cc33027.jpg'),
(20, 143, '9359602d48e0a34dac0fc59f63bda758.jpeg'),
(21, 144, 'ed6c192901e3190d525ac04da46e2930.jpeg'),
(22, 145, 'e925f05cf9005a49af1f3cec34d6469c.jpg'),
(23, 146, 'aa3583d53361be6c517c60b9eef8956e.jpg'),
(24, 147, '12d1e2bdae107fe8bc5b034493ec7f98.png'),
(25, 148, 'b97740682c9c82ed51d2e521216802c2.png'),
(26, 150, '3e4c067a51c8a836ba2925003d0c7e77.jpg'),
(27, 151, '46c415448f219e1a176bf62864a5d05e.jpg'),
(28, 153, '7ef2f71191f956a494416ff4eabd341a.jpg'),
(29, 155, 'c71e38fda228e54c859d7d86e4c40a4e.jpg'),
(30, 156, '5ae73e794f0deec3309808c4e57b2323.jpg'),
(31, 157, '16f2772c9346078c7d9d179d5190c15a.jpg'),
(32, 158, 'c9fa67d0fad2a8dba472f6793d686d5e.jpg'),
(34, 160, '76f31046d6edf94d675c10342935804f.jpg'),
(36, 162, '5567807ba231311a359558664122b62a.jpg'),
(37, 163, 'd7879b9980bc293368b059abb42ce343.jpg'),
(42, 168, 'fd3c6a6576dc184624650a2a5a3275a5.jpg'),
(43, 169, 'c3716a07c1c855a10b70b5acf43892d0.jpg'),
(44, 170, '312446f314bbbd778dda63aba12051af.jpg'),
(45, 171, 'e89c98338d8369a3dd93df47b22dfa3d.jpg'),
(46, 172, '29f2c6e513734ab1684b9a5f70faca2f.jpg'),
(47, 173, '66933d1439d57aa3f4ea768f3c18cb22.jpg'),
(48, 174, '680330e0ef03b15c2b846b9862c02eb9.jpg'),
(49, 175, '9c73b27ecdc222ed6632602b0fbbd3b1.jpg'),
(50, 176, 'ae801f15a78492cac7df45da6f0be1f8.png'),
(51, 177, '35e508f53745e0af614f9984639e638f.jpg'),
(52, 178, 'f88cc003a33717ada3ec4a0fec9dc93b.jpg'),
(53, 179, '2b1a2782b12b9de498ab88d592b076ed.jpeg'),
(54, 180, 'fbcc682a1bc67632eb60af68f4d0fa4c.jpg'),
(56, 182, '87287437aae40b749d6ac72a18e976ac.jpg'),
(57, 183, '133c9821158b78785ac793de1df7c87f.jpg'),
(59, 128, '5b2937583f003d89ea1137f318659f22.jpg'),
(60, 128, '0a642fc5b70479ecc63040f1c7ba47ae.jpg'),
(61, 187, '1fd99559c2c341084042799543d349bf.jpg'),
(62, 187, '651b796b66053adad31415d1f416e4d1.jpg'),
(63, 190, 'c59db4465c7ed92064541a89b03eb18b.jpg'),
(68, 191, 'f8227cd7d699ede47861e2dbdc5626d6.jpg'),
(70, 192, '0a045815dc72a2ed60b2fc0b2e416198.jpg'),
(71, 188, 'de1ce45b3471d1cb0a902784f336e65c.jpg'),
(72, 184, '4e0157ec1be0ad693d55609d72af0cfe.jpg'),
(73, 193, '6250c02824601b49057fa8f498fc37b6.jpg'),
(74, 193, '3533cce37b081dad5236906bf969eb29.jpg'),
(77, 196, '38a3ab9411ec61a02f434b225e4228e6.jpg'),
(78, 197, '022c8f4ddfb6df6dc9578c1337d65f3e.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `emts_product_images_temp`
--

CREATE TABLE `emts_product_images_temp` (
  `id` bigint(20) NOT NULL,
  `product_code` bigint(20) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emts_product_invitation`
--

CREATE TABLE `emts_product_invitation` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `invite_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_product_invitation`
--

INSERT INTO `emts_product_invitation` (`id`, `product_id`, `user_email`, `message`, `invite_date`, `user_id`) VALUES
(1, 94, 'saagarchapagain@gmail.coms', 'asdasdad', '2016-12-09 18:57:26', NULL),
(2, 95, 'saagarchapagain@gmail.coms', 'test', '2016-12-09 20:45:41', NULL),
(3, 94, 'saagarchapagain@gmail.coms', 'sdasd', '2016-12-09 20:45:53', NULL),
(4, 94, 'saagarchapagain@gmail.coms', 'asdad', '2016-12-09 20:49:32', NULL),
(5, 94, 'saagarchapagain@gmail.com', '', '2016-12-09 21:41:37', NULL),
(6, 129, 'sagar@emultitechsolution.com', 'adasd sad asd', '2017-05-18 09:55:37', 81),
(7, 129, 'insta@gmail.com', 'Hey there ..can u send me proposal.', '2017-05-18 10:27:07', 82),
(8, 132, 'sagar@emultitechsolution.com', '', '2017-05-18 10:34:03', 81),
(9, 132, 'sagar@emultitechsolution.com', '', '2017-05-18 10:38:33', 81),
(10, 132, 'insta@gmail.com', 'asdasd asd', '2017-05-18 10:40:18', 82),
(11, 145, 'sagar@emultitechsolution.com', 'sdfff dddddd', '2017-06-27 10:36:23', 81),
(12, 139, 'sagar@emultitechsolution.com', 'u can joimus', '2017-06-29 03:56:35', 81),
(13, 128, 'sagar@emultitechsolution.com', 'test', '2017-07-04 04:42:29', 81),
(14, 153, 'sagar@emultitechsolution.com', 'mn', '2017-07-04 08:20:25', 81),
(15, 0, 'check@gmail.com', 'sdfdf', '2017-08-10 03:30:13', 83),
(16, 0, 'brand@gmail.com', 'Hello there', '2017-08-10 03:32:32', 92);

-- --------------------------------------------------------

--
-- Table structure for table `emts_product_objective`
--

CREATE TABLE `emts_product_objective` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `objective_id` int(11) DEFAULT NULL,
  `reason` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_product_objective`
--

INSERT INTO `emts_product_objective` (`id`, `product_id`, `objective_id`, `reason`) VALUES
(3, 187, 1, NULL),
(4, 187, 2, NULL),
(7, 190, 1, NULL),
(8, 190, 2, NULL),
(68, 191, 1, NULL),
(69, 191, 2, NULL),
(73, 192, 2, NULL),
(95, 193, 1, NULL),
(96, 193, 2, NULL),
(109, 184, 1, NULL),
(145, 197, 1, ''),
(146, 197, 2, ''),
(147, 197, 6, NULL),
(212, 196, 1, ''),
(213, 196, 2, ''),
(214, 188, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `emts_product_post_categories`
--

CREATE TABLE `emts_product_post_categories` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_product_post_categories`
--

INSERT INTO `emts_product_post_categories` (`id`, `user_id`, `category_id`, `product_id`) VALUES
(1, 9, 103, 24),
(2, 9, 34, 24),
(3, 9, 36, 24),
(4, 9, 93, 24),
(5, 9, 3, 25),
(6, 9, 8, 25),
(7, 9, 11, 25),
(8, 9, 19, 26),
(9, 9, 103, 26),
(10, 9, 34, 26),
(11, 9, 36, 26),
(12, 9, 19, 27),
(13, 9, 103, 27),
(14, 9, 34, 27),
(15, 9, 36, 27),
(16, 9, 103, 28),
(17, 9, 34, 28),
(18, 9, 36, 28),
(19, 9, 93, 28),
(20, 9, 11, 29),
(21, 9, 13, 29),
(22, 9, 19, 29),
(23, 9, 103, 29),
(24, 9, 11, 30),
(25, 9, 13, 30),
(26, 9, 19, 30),
(27, 9, 103, 30),
(28, 9, 34, 30),
(29, 9, 19, 31),
(30, 9, 103, 31),
(31, 9, 34, 31),
(32, 9, 36, 31),
(33, 9, 93, 31),
(34, 9, 13, 32),
(35, 9, 19, 32),
(36, 9, 103, 32),
(37, 9, 34, 32),
(38, 9, 13, 33),
(39, 9, 19, 33),
(40, 9, 103, 33),
(41, 9, 34, 33),
(42, 9, 13, 31),
(43, 9, 19, 31),
(44, 9, 103, 31),
(45, 9, 34, 31),
(46, 9, 19, 31),
(47, 9, 103, 31),
(48, 9, 19, 31),
(49, 9, 19, 31),
(50, 9, 103, 31),
(51, 9, 34, 31),
(52, 9, 36, 31),
(53, 9, 19, 31),
(54, 9, 103, 31),
(55, 9, 34, 31),
(56, 9, 36, 31),
(57, 9, 19, 31),
(58, 9, 13, 31),
(59, 9, 19, 31),
(60, 9, 103, 31),
(61, 9, 34, 31),
(62, 9, 19, 31),
(63, 9, 34, 31),
(64, 9, 19, 31),
(65, 9, 19, 31),
(66, 9, 103, 31),
(67, 9, 103, 31),
(68, 9, 34, 31),
(69, 9, 36, 31),
(70, 9, 19, 31),
(71, 9, 34, 31),
(72, 9, 36, 31),
(73, 9, 34, 31),
(74, 9, 19, 31),
(75, 9, 103, 31),
(76, 9, 34, 31),
(77, 9, 103, 31),
(78, 9, 34, 31),
(79, 9, 34, 31),
(80, 9, 19, 31),
(81, 9, 34, 31),
(82, 9, 13, 31),
(83, 9, 19, 31),
(84, 9, 103, 31),
(85, 9, 34, 31),
(86, 9, 8, 31),
(87, 9, 11, 31),
(88, 9, 13, 31),
(89, 9, 19, 31),
(90, 9, 34, 31),
(91, 9, 8, 31),
(92, 9, 11, 31),
(93, 9, 13, 31),
(94, 9, 19, 31),
(95, 9, 103, 31),
(96, 9, 34, 31),
(97, 9, 8, 31),
(98, 9, 11, 31),
(99, 9, 13, 31),
(100, 9, 19, 31),
(101, 9, 103, 31),
(102, 9, 34, 31),
(103, 9, 19, 31),
(104, 9, 103, 31),
(105, 9, 34, 31),
(106, 9, 36, 31),
(107, 9, 93, 31),
(108, 9, 19, 31),
(109, 9, 103, 31),
(110, 9, 34, 31),
(111, 9, 36, 31),
(112, 9, 93, 31),
(113, 9, 19, 31),
(114, 9, 103, 31),
(115, 9, 34, 31),
(116, 9, 36, 31),
(117, 9, 93, 31),
(118, 9, 19, 31),
(119, 9, 103, 31),
(120, 9, 34, 31),
(121, 9, 36, 31),
(122, 9, 93, 31),
(123, 9, 19, 34),
(124, 9, 103, 34),
(125, 9, 34, 34),
(126, 9, 36, 34),
(127, 9, 93, 34),
(128, 9, 19, 35),
(129, 9, 103, 35),
(130, 9, 34, 35),
(131, 9, 36, 35),
(132, 9, 93, 35),
(133, 9, 13, 36),
(134, 9, 19, 36),
(135, 9, 103, 36),
(136, 9, 34, 36),
(137, 9, 36, 36),
(138, 9, 13, 37),
(139, 9, 19, 37),
(140, 9, 103, 37),
(141, 9, 34, 37),
(142, 9, 36, 37);

-- --------------------------------------------------------

--
-- Table structure for table `emts_product_socialmedia`
--

CREATE TABLE `emts_product_socialmedia` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `socialmedia_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emts_product_socialmedia`
--

INSERT INTO `emts_product_socialmedia` (`id`, `user_id`, `product_id`, `socialmedia_id`) VALUES
(64, 84, 130, 5),
(65, 81, 131, 1),
(72, 83, 133, 4),
(73, 83, 133, 2),
(74, 83, 133, 3),
(75, 83, 133, 6),
(79, 83, 135, 4),
(80, 83, 135, 2),
(87, 81, 136, 1),
(104, 111, 137, 4),
(105, 111, 137, 2),
(106, 111, 137, 3),
(107, 111, 137, 5),
(108, 111, 137, 6),
(109, 111, 137, 1),
(110, 83, 138, 4),
(111, 83, 138, 2),
(156, 83, 132, 4),
(157, 83, 132, 2),
(158, 83, 132, 3),
(159, 83, 132, 5),
(160, 83, 132, 6),
(161, 83, 132, 1),
(280, 83, 144, 4),
(281, 83, 144, 2),
(282, 83, 144, 3),
(283, 83, 144, 5),
(284, 83, 144, 6),
(285, 83, 144, 1),
(288, 83, 143, 3),
(289, 83, 143, 5),
(292, 83, 139, 4),
(293, 83, 139, 2),
(294, 83, 145, 4),
(295, 83, 145, 2),
(296, 83, 145, 3),
(297, 83, 145, 5),
(298, 83, 145, 6),
(299, 83, 145, 1),
(300, 83, 146, 4),
(301, 83, 146, 2),
(302, 83, 146, 3),
(303, 83, 146, 5),
(304, 83, 146, 6),
(305, 83, 146, 1),
(310, 83, 147, 2),
(311, 83, 148, 1),
(314, 81, 149, 1),
(351, 83, 129, 4),
(352, 83, 129, 2),
(353, 83, 129, 3),
(354, 83, 129, 1),
(360, 81, 128, 1),
(361, 83, 150, 4),
(362, 83, 150, 2),
(363, 83, 150, 3),
(364, 83, 150, 5),
(365, 83, 150, 6),
(366, 83, 150, 1),
(372, 81, 152, 1),
(373, 83, 153, 4),
(374, 83, 153, 2),
(375, 83, 153, 3),
(376, 83, 153, 5),
(377, 83, 153, 6),
(378, 83, 153, 1),
(379, 81, 154, 2),
(380, 81, 154, 1),
(381, 83, 155, 4),
(382, 83, 155, 2),
(383, 83, 155, 3),
(384, 83, 156, 2),
(385, 83, 156, 3),
(386, 83, 157, 2),
(387, 83, 157, 3),
(388, 83, 158, 4),
(389, 83, 158, 2),
(392, 83, 160, 4),
(393, 83, 160, 2),
(396, 83, 162, 2),
(397, 83, 162, 3),
(398, 83, 163, 2),
(399, 83, 163, 3),
(408, 83, 168, 2),
(409, 83, 168, 3),
(410, 83, 169, 2),
(411, 83, 169, 3),
(412, 83, 170, 4),
(413, 83, 170, 2),
(414, 83, 171, 2),
(415, 83, 172, 2),
(416, 83, 173, 4),
(417, 83, 173, 2),
(418, 83, 174, 2),
(419, 83, 175, 4),
(420, 83, 176, 1),
(421, 83, 177, 4),
(422, 83, 177, 2),
(423, 83, 178, 2),
(424, 83, 178, 3),
(425, 83, 179, 2),
(426, 83, 180, 1);

-- --------------------------------------------------------

--
-- Table structure for table `emts_product_static_fields`
--

CREATE TABLE `emts_product_static_fields` (
  `id` int(11) NOT NULL,
  `field_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `options` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'options for radio and drodown menus',
  `display` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emts_product_static_fields`
--

INSERT INTO `emts_product_static_fields` (`id`, `field_name`, `field_label`, `options`, `display`) VALUES
(1, 'name', 'Product Name', '0', '1'),
(2, 'description', 'Product Description', '', '1'),
(3, 'auction_type', 'Auction Type', 'Public,Private', '1'),
(18, 'bid_decrement', 'Bid Decrement', '', '1'),
(19, 'auction_time_zone', 'Auction Time Zone', '', '1'),
(20, 'currency', 'Currency', '', '1'),
(21, 'auction_start_time', 'Auction Start Time', '', '1'),
(22, 'auction_end_time', 'Auction End Time', '', '1'),
(24, 'upload_photos', 'Upload Product Images', '', '0'),
(25, 'budget', 'Previous or Prospective Spend', '', '1'),
(26, 'auction_end_days', 'Auction End Days', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `emts_product_winner`
--

CREATE TABLE `emts_product_winner` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `bid_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `won_amount` double(20,2) NOT NULL DEFAULT '0.00',
  `product_close_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `payment_status` enum('Incomplete','Completed') CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT 'Incomplete',
  `email_sent` enum('yes','no') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emts_product_winner`
--

INSERT INTO `emts_product_winner` (`id`, `product_id`, `bid_id`, `user_id`, `won_amount`, `product_close_date`, `payment_status`, `email_sent`) VALUES
(1, 132, 15, 81, 1500.00, '2017-05-16 00:00:00', 'Incomplete', 'no'),
(2, 132, 16, 85, 300.00, '2017-05-10 00:00:00', 'Completed', ''),
(3, 132, 20, 82, 200.00, '2017-05-09 00:00:00', 'Incomplete', ''),
(4, 132, 33, 81, 45.00, '2017-06-27 14:25:36', 'Incomplete', 'no'),
(5, 150, 38, 82, 10.80, '2017-06-29 11:29:25', 'Incomplete', 'no'),
(6, 151, 40, 81, 4.50, '2017-06-29 12:16:54', 'Incomplete', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `emts_profession`
--

CREATE TABLE `emts_profession` (
  `id` int(11) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `status` enum('1','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_profession`
--

INSERT INTO `emts_profession` (`id`, `profession`, `status`) VALUES
(1, 'Model', '1'),
(2, 'Actor', '1');

-- --------------------------------------------------------

--
-- Table structure for table `emts_referral_prize`
--

CREATE TABLE `emts_referral_prize` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `is_display` enum('1','0') NOT NULL COMMENT '0->No,1->Yes',
  `points` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_referral_prize`
--

INSERT INTO `emts_referral_prize` (`id`, `title`, `description`, `image`, `is_display`, `points`) VALUES
(1, 'Reward team', 'asd', 'team.jpg', '0', 324),
(2, 'check', 'asasd', '7041524-high-resolution-naaaaaaaature-wallpapers-hd1.jpg', '1', 2),
(3, 'check', 'asd', '7041524-high-resolution-naaaaaaaature-wallpapers-hd2.jpg', '1', 2),
(4, 'check plus plus', 'ok we are done', 'p1.jpg', '1', 2),
(5, 'check', 'asd', '7041524-high-resolution-naaaaaaaature-wallpapers-hd4.jpg', '1', 2),
(6, 'asdsad', 'asdsad', '7041524-high-resolution-naaaaaaaature-wallpapers-hd8.jpg', '1', 142);

-- --------------------------------------------------------

--
-- Table structure for table `emts_report`
--

CREATE TABLE `emts_report` (
  `id` int(11) NOT NULL,
  `upload_link` varchar(200) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `comments` int(11) DEFAULT NULL,
  `SHARE` int(11) DEFAULT NULL,
  `subscribe` int(11) DEFAULT NULL,
  `follow` int(11) DEFAULT NULL,
  `tweet` int(11) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `bid_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_report`
--

INSERT INTO `emts_report` (`id`, `upload_link`, `likes`, `comments`, `SHARE`, `subscribe`, `follow`, `tweet`, `description`, `product_id`, `bid_id`) VALUES
(1, 'https://www.facebook.com/?stype=lo&jlou=Afd99Zcy7YpNVKqCNLZs819T8eWaNPzj3PgOHHbVtorjLcMiuT5W46hIQgpl2aMLLIjomB_saX896WziGyOUam-0jakh3LGPeCjeyR1cuvN7qw&smuh=13773&lh=Ac-ybcX0R0peYodS', 20, 10, 5, NULL, NULL, NULL, NULL, 131, 17);

-- --------------------------------------------------------

--
-- Table structure for table `emts_reportuser`
--

CREATE TABLE `emts_reportuser` (
  `id` int(11) NOT NULL,
  `reporterid` int(11) DEFAULT NULL,
  `offenderid` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(400) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `bid_id` int(11) DEFAULT NULL,
  `report_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_reportuser`
--

INSERT INTO `emts_reportuser` (`id`, `reporterid`, `offenderid`, `title`, `description`, `remarks`, `bid_id`, `report_date`) VALUES
(1, 81, 83, 'Harrassment', '', NULL, 36, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `emts_seo`
--

CREATE TABLE `emts_seo` (
  `id` int(11) NOT NULL,
  `seo_page_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_key` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emts_seo`
--

INSERT INTO `emts_seo` (`id`, `seo_page_name`, `page_title`, `meta_key`, `meta_description`, `created_date`, `last_update`) VALUES
(1, 'home', 'Uptrendly', 'Home Page', 'Home Page', '2016-05-09 00:00:00', '2017-06-23 15:22:22'),
(2, 'contact-us', 'Uptrendly', 'Contact-Us', 'Contact Us', '2016-05-09 07:26:28', '2017-06-23 15:22:27'),
(3, 'help', ':: Uptrendly Help ::', 'Help', 'Help', '2016-05-09 09:37:30', '2017-06-23 15:22:36');

-- --------------------------------------------------------

--
-- Table structure for table `emts_site_settings`
--

CREATE TABLE `emts_site_settings` (
  `id` int(11) NOT NULL,
  `site_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `log_admin_activity` enum('N','Y') COLLATE utf8_unicode_ci NOT NULL COMMENT 'keep log of admins activity',
  `log_admin_invalid_login` enum('N','Y') COLLATE utf8_unicode_ci NOT NULL COMMENT 'keep log of admins invalid login ',
  `contact_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contact_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `system_email_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `system_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address1` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `country_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `site_status` enum('1','2','3') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=online, 2=offline, 3=maintainance',
  `user_activation` enum('0','1') COLLATE utf8_unicode_ci NOT NULL COMMENT 'need user activation after registration? 0=No, 1=Yes',
  `supplier_category_limit` int(2) NOT NULL COMMENT 'Limit No. of category choose by supplier to display as experience area',
  `facebook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_app_id` bigint(20) NOT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rss_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `linkedin` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `google_plus` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `currency_sign` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `currency_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `google_analytics_code` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `auction_post_activation` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0=No Activation Require, 1= Activation Require by admin',
  `no_auction_post_free` int(11) NOT NULL DEFAULT '99999' COMMENT '0=No Free Post, 99999=Unlimited',
  `is_auction_post_cost` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0=No Buy package Enable, 1=Buy Package Enable',
  `no_bid_place_free` int(11) NOT NULL DEFAULT '999999999' COMMENT '0=No Free Bid, 999999999=Unlimited',
  `is_bid_place_cost` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0=No Buy package Enable, 1=Buy Package Enable',
  `enable_rating` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `timezone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sms_notification` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0=No, 1=Yes',
  `sms_gateway_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sms_api_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sms_api_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `commission_percent` float DEFAULT NULL,
  `v_content_static` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `proposal_static` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dashboard_note` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `brand_refer_point` int(11) DEFAULT NULL,
  `creator_refer_point` int(11) DEFAULT NULL,
  `fixed_commission` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emts_site_settings`
--

INSERT INTO `emts_site_settings` (`id`, `site_name`, `log_admin_activity`, `log_admin_invalid_login`, `contact_email`, `contact_name`, `system_email_name`, `system_email`, `address1`, `address2`, `city`, `state`, `zip_code`, `country_name`, `site_status`, `user_activation`, `supplier_category_limit`, `facebook`, `facebook_app_id`, `twitter`, `rss_url`, `linkedin`, `google_plus`, `currency_sign`, `currency_code`, `google_analytics_code`, `auction_post_activation`, `no_auction_post_free`, `is_auction_post_cost`, `no_bid_place_free`, `is_bid_place_cost`, `enable_rating`, `timezone`, `sms_notification`, `sms_gateway_url`, `sms_api_username`, `sms_api_password`, `commission_percent`, `v_content_static`, `proposal_static`, `dashboard_note`, `brand_refer_point`, `creator_refer_point`, `fixed_commission`) VALUES
(1, 'Uptrendly', '', '', 'saagarchapagain@gmail.com', 'Uptrendly', 'Uptrendly', 'saagarchapagain@gmail.com', '', '', '', '', '', '', '1', '1', 0, 'http://www.facebook.com/vid.energy', 405264519614040, '', 'http://www.rss.com/bidcy', 'http://www.linkedin.com/vid.energy', '', 'NRS', 'NRS', 'this is test', '1', 0, '1', 0, '1', 'Yes', 'Asia/Kathmandu', '0', 'http://testapi.comm', 'apiuser', 'apipassword', 10, 'No Contents Found', 'No proposals Fopund', 'Please Don\'t contact Brand outside of Uptrendly', 7, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `emts_socialmedia_profile`
--

CREATE TABLE `emts_socialmedia_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `url` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emts_socialmedia_profile`
--

INSERT INTO `emts_socialmedia_profile` (`id`, `user_id`, `media_id`, `url`) VALUES
(2, 85, 6, 'https://breakup.tumblr.com/post/160221963841'),
(3, 85, 6, 'http://luisxg.com/post/160223913239'),
(15, 81, 1, 'https://www.facebook.com/298585800329851/photos/pb.298585800329851.-2207520000.1499142293./698744226980671/?type=3&theater'),
(74, 103, 4, 'http://youtube.com/34734'),
(75, 82, 3, 'https://www.instagram.com/p/BHDgLxFgDAn/?taken-at=1028961340'),
(76, 82, 3, 'https://www.instagram.com/p/BHDgLxFgDAn/?taken-at=1028961340'),
(77, 82, 1, 'https://www.faceok.com/p/BHDgLxFgDAn/?taken-at=1028961340'),
(78, 82, 1, 'https://www.facebook.com/p/BHDgLxFgDAn/?taken-at=1028961340');

-- --------------------------------------------------------

--
-- Table structure for table `emts_socialmedia_settings`
--

CREATE TABLE `emts_socialmedia_settings` (
  `id` int(11) NOT NULL,
  `media_type` varchar(150) NOT NULL,
  `display_name` varchar(150) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `app_key` varchar(200) DEFAULT NULL,
  `app_secret` varchar(200) DEFAULT NULL,
  `server_key` varchar(200) DEFAULT NULL,
  `browser_key` varchar(200) DEFAULT NULL,
  `ios_key` varchar(200) DEFAULT NULL,
  `redirect_uri` varchar(200) DEFAULT NULL,
  `least_fan_count` int(11) NOT NULL DEFAULT '500',
  `isActive` enum('1','0') NOT NULL DEFAULT '1',
  `api_key` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emts_socialmedia_settings`
--

INSERT INTO `emts_socialmedia_settings` (`id`, `media_type`, `display_name`, `description`, `app_key`, `app_secret`, `server_key`, `browser_key`, `ios_key`, `redirect_uri`, `least_fan_count`, `isActive`, `api_key`) VALUES
(1, 'facebook', NULL, NULL, '288550634833929', 'eef5dc81b0103332b4bccf7578e88b71', NULL, NULL, NULL, 'http://202.166.198.151:8888/uptrendly/user/register/signup_facebook', 500, '1', NULL),
(2, 'twitter', NULL, NULL, '7wLrPiymWI7yeR0IitwLj4Jbx', 'umyOTj3EgcpPqti62ejCyX2o9AVV6t8m3dwIxjm7hCojzGezYL', NULL, NULL, NULL, 'http://202.166.198.151:8888/uptrendly/user/register/signup_twitter', 1, '0', NULL),
(3, 'instagram', NULL, NULL, '669c2afef5c84df5913451565a718722', '2c86d6c3e71c41819514aeb3ff2f6dd2', NULL, NULL, NULL, 'http://202.166.198.151:8888/uptrendly/user/register/signup_instagram', 1, '1', NULL),
(4, 'youtube', NULL, NULL, '785158072228-ltorjcnpkbhtp2oo7ff4cku5hfpnh67e.apps.googleusercontent.com', 'XblXyCO3ovJY7_KRBbrdVNWb', NULL, NULL, NULL, 'http://202.166.198.151:8888/uptrendly/user/register/signup_youtube', 1, '0', 'AIzaSyCyVNboZ93IgX4Ap622BTzaIwXzACULkBI'),
(5, 'youtulee', NULL, NULL, '', '', NULL, NULL, NULL, '', 100, '0', NULL),
(6, 'tumblr', NULL, NULL, 'OUDEKdcuW7Nxo4xsKQuJya3OUSwG4rm2QZPWg196oWWvSD9b8M', 'uRJD1gqgFTATcYGRnl6KxzFOsJOU4KnFbDvb2YXsGuVaiaGUxo', NULL, NULL, NULL, 'http://202.166.198.151:8888/uptrendly/user/register/signup_tumblr', 1, '0', NULL),
(7, 'snapchat', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `emts_time_zone_setting`
--

CREATE TABLE `emts_time_zone_setting` (
  `id` int(11) NOT NULL,
  `utc_time_zone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gmt_time` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('on','off') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emts_time_zone_setting`
--

INSERT INTO `emts_time_zone_setting` (`id`, `utc_time_zone`, `gmt_time`, `status`) VALUES
(1, '(GMT-10:00) Hawaii', '-10:00', 'off'),
(2, '(GMT-09:00) Alaska', '-09:00', 'off'),
(3, '(GMT-08:00) Pacific Time (US &amp; Canada)', '-08:00', 'off'),
(4, '(GMT-07:00) Arizona', '-07:00', 'off'),
(5, '(GMT-07:00) Mountain Time (US &amp; Canada)', '-07:00', 'off'),
(6, '(GMT-06:00) Central Time (US &amp; Canada)', '-06:00', 'off'),
(7, '(GMT-05:00) America/Indianapolis', '-05:00', 'off'),
(8, '(GMT-05:00) Eastern Time (US &amp; Canada)', '-05:00', 'off'),
(9, '(GMT-05:00) Indiana (East)', '-05:00', 'off'),
(10, '(GMT-11:00) American Samoa', '-11:00', 'off'),
(11, '(GMT-11:00) International Date Line West', '-11:00', 'off'),
(12, '(GMT-11:00) Midway Island', '-11:00', 'off'),
(13, '(GMT-08:00) Tijuana', '-08:00', 'off'),
(14, '(GMT-07:00) Chihuahua', '-07:00', 'off'),
(15, '(GMT-07:00) Mazatlan', '-07:00', 'off'),
(16, '(GMT-06:00) Central America', '-06:00', 'off'),
(17, '(GMT-06:00) Guadalajara', '-06:00', 'off'),
(18, '(GMT-06:00) Mexico City', '-06:00', 'off'),
(19, '(GMT-06:00) Monterrey', '-06:00', 'off'),
(20, '(GMT-06:00) Saskatchewan', '-06:00', 'off'),
(21, '(GMT-05:00) Bogota', '-05:00', 'off'),
(22, '(GMT-05:00) Lima', '-05:00', 'off'),
(23, '(GMT-05:00) Quito', '-05:00', 'off'),
(24, '(GMT-04:30) Caracas', '-04:30', 'off'),
(25, '(GMT-04:00) Atlantic Time (Canada)', '-04:00', 'off'),
(26, '(GMT-04:00) Georgetown', '-04:00', 'off'),
(27, '(GMT-04:00) La Paz', '-04:00', 'off'),
(28, '(GMT-03:30) Newfoundland', '-03:30', 'off'),
(29, '(GMT-03:00) Brasilia', '-03:00', 'off'),
(30, '(GMT-03:00) Buenos Aires', '-03:00', 'off'),
(31, '(GMT-03:00) Greenland', '-03:00', 'off'),
(32, '(GMT-03:00) Montevideo', '-03:00', 'off'),
(33, '(GMT-03:00) Santiago', '-03:00', 'off'),
(34, '(GMT-02:00) Mid-Atlantic', '-02:00', 'off'),
(35, '(GMT-01:00) Azores', '-01:00', 'off'),
(36, '(GMT-01:00) Cape Verde Is.', '-01:00', 'off'),
(37, '(GMT+00:00) Casablanca', '+00:00', 'off'),
(38, '(GMT+00:00) Dublin', '+00:00', 'off'),
(39, '(GMT+00:00) Edinburgh', '+00:00', 'off'),
(40, '(GMT+00:00) Lisbon', '+00:00', 'off'),
(41, '(GMT+00:00) London', '+00:00', 'off'),
(42, '(GMT+00:00) Monrovia', '+00:00', 'off'),
(43, '(GMT+00:00) UTC', '+00:00', 'off'),
(44, '(GMT+01:00) Amsterdam', '+01:00', 'off'),
(45, '(GMT+01:00) Belgrade', '+01:00', 'off'),
(46, '(GMT+01:00) Berlin', '+01:00', 'off'),
(47, '(GMT+01:00) Bern', '+01:00', 'off'),
(48, '(GMT+01:00) Bratislava', '+01:00', 'off'),
(49, '(GMT+01:00) Brussels', '+01:00', 'off'),
(50, '(GMT+01:00) Budapest', '+01:00', 'off'),
(51, '(GMT+01:00) Copenhagen', '+01:00', 'off'),
(52, '(GMT+01:00) Ljubljana', '+01:00', 'off'),
(53, '(GMT+01:00) Madrid', '+01:00', 'off'),
(54, '(GMT+01:00) Paris', '+01:00', 'off'),
(55, '(GMT+01:00) Prague', '+01:00', 'off'),
(56, '(GMT+01:00) Rome', '+01:00', 'off'),
(57, '(GMT+01:00) Sarajevo', '+01:00', 'off'),
(58, '(GMT+01:00) Skopje', '+01:00', 'off'),
(59, '(GMT+01:00) Stockholm', '+01:00', 'off'),
(60, '(GMT+01:00) Vienna', '+01:00', 'off'),
(61, '(GMT+01:00) Warsaw', '+01:00', 'off'),
(62, '(GMT+01:00) West Central Africa', '+01:00', 'off'),
(63, '(GMT+01:00) Zagreb', '+01:00', 'off'),
(64, '(GMT+02:00) Athens', '+02:00', 'off'),
(65, '(GMT+02:00) Bucharest', '+02:00', 'off'),
(66, '(GMT+02:00) Cairo', '+02:00', 'off'),
(67, '(GMT+02:00) Harare', '+02:00', 'off'),
(68, '(GMT+02:00) Helsinki', '+02:00', 'off'),
(69, '(GMT+02:00) Istanbul', '+02:00', 'off'),
(70, '(GMT+02:00) Jerusalem', '+02:00', 'off'),
(71, '(GMT+02:00) Kaliningrad', '+02:00', 'off'),
(72, '(GMT+02:00) Kyiv', '+02:00', 'off'),
(73, '(GMT+02:00) Pretoria', '+02:00', 'off'),
(74, '(GMT+02:00) Riga', '+02:00', 'off'),
(75, '(GMT+02:00) Sofia', '+02:00', 'off'),
(76, '(GMT+02:00) Tallinn', '+02:00', 'off'),
(77, '(GMT+02:00) Vilnius', '+02:00', 'off'),
(78, '(GMT+03:00) Baghdad', '+03:00', 'off'),
(79, '(GMT+03:00) Kuwait', '+03:00', 'off'),
(80, '(GMT+03:00) Minsk', '+03:00', 'off'),
(81, '(GMT+03:00) Moscow', '+03:00', 'off'),
(82, '(GMT+03:00) Nairobi', '+03:00', 'off'),
(83, '(GMT+03:00) Riyadh', '+03:00', 'off'),
(84, '(GMT+03:00) St. Petersburg', '+03:00', 'off'),
(85, '(GMT+03:00) Volgograd', '+03:00', 'off'),
(86, '(GMT+03:30) Tehran', '+03:30', 'off'),
(87, '(GMT+04:00) Abu Dhabi', '+04:00', 'off'),
(88, '(GMT+04:00) Baku', '+04:00', 'off'),
(89, '(GMT+04:00) Muscat', '+04:00', 'off'),
(90, '(GMT+04:00) Samara', '+04:00', 'off'),
(91, '(GMT+04:00) Tbilisi', '+04:00', 'off'),
(92, '(GMT+04:00) Yerevan', '+04:00', 'off'),
(93, '(GMT+04:30) Kabul', '+04:30', 'off'),
(94, '(GMT+05:00) Ekaterinburg', '+05:00', 'off'),
(95, '(GMT+05:00) Islamabad', '+05:00', 'off'),
(96, '(GMT+05:00) Karachi', '+05:00', 'off'),
(97, '(GMT+05:00) Tashkent', '+05:00', 'off'),
(98, '(GMT+05:30) Chennai', '+05:30', 'off'),
(99, '(GMT+05:30) Kolkata', '+05:30', 'off'),
(100, '(GMT+05:30) Mumbai', '+05:30', 'off'),
(101, '(GMT+05:30) New Delhi', '+05:30', 'off'),
(102, '(GMT+05:30) Sri Jayawardenepura', '+05:30', 'off'),
(103, '(GMT+05:45) Asia/Katmandu', '+05:45', 'on'),
(104, '(GMT+05:45) Kathmandu', '+05:45', 'off'),
(105, '(GMT+06:00) Almaty', '+06:00', 'off'),
(106, '(GMT+06:00) Astana', '+06:00', 'off'),
(107, '(GMT+06:00) Dhaka', '+06:00', 'off'),
(108, '(GMT+06:00) Novosibirsk', '+06:00', 'off'),
(109, '(GMT+06:00) Urumqi', '+06:00', 'off'),
(110, '(GMT+06:30) Rangoon', '+06:30', 'off'),
(111, '(GMT+07:00) Bangkok', '+07:00', 'off'),
(112, '(GMT+07:00) Hanoi', '+07:00', 'off'),
(113, '(GMT+07:00) Jakarta', '+07:00', 'off'),
(114, '(GMT+07:00) Krasnoyarsk', '+07:00', 'off'),
(115, '(GMT+08:00) Beijing', '+08:00', 'off'),
(116, '(GMT+08:00) Chongqing', '+08:00', 'off'),
(117, '(GMT+08:00) Hong Kong', '+08:00', 'off'),
(118, '(GMT+08:00) Irkutsk', '+08:00', 'off'),
(119, '(GMT+08:00) Kuala Lumpur', '+08:00', 'off'),
(120, '(GMT+08:00) Perth', '+08:00', 'off'),
(121, '(GMT+08:00) Singapore', '+08:00', 'off'),
(122, '(GMT+08:00) Taipei', '+08:00', 'off'),
(123, '(GMT+08:00) Ulaanbaatar', '+08:00', 'off'),
(124, '(GMT+09:00) Osaka', '+09:00', 'off'),
(125, '(GMT+09:00) Sapporo', '+09:00', 'off'),
(126, '(GMT+09:00) Seoul', '+09:00', 'off'),
(127, '(GMT+09:00) Tokyo', '+09:00', 'off'),
(128, '(GMT+09:00) Yakutsk', '+09:00', 'off'),
(129, '(GMT+09:30) Adelaide', '+09:30', 'off'),
(130, '(GMT+09:30) Darwin', '+09:30', 'off'),
(131, '(GMT+10:00) Brisbane', '+10:00', 'off'),
(132, '(GMT+10:00) Canberra', '+10:00', 'off'),
(133, '(GMT+10:00) Guam', '+10:00', 'off'),
(134, '(GMT+10:00) Hobart', '+10:00', 'off'),
(135, '(GMT+10:00) Magadan', '+10:00', 'off'),
(136, '(GMT+10:00) Melbourne', '+10:00', 'off'),
(137, '(GMT+10:00) Port Moresby', '+10:00', 'off'),
(138, '(GMT+10:00) Sydney', '+10:00', 'off'),
(139, '(GMT+10:00) Vladivostok', '+10:00', 'off'),
(140, '(GMT+11:00) New Caledonia', '+11:00', 'off'),
(141, '(GMT+11:00) Solomon Is.', '+11:00', 'off'),
(142, '(GMT+11:00) Srednekolymsk', '+11:00', 'off'),
(143, '(GMT+12:00) Auckland', '+12:00', 'off'),
(144, '(GMT+12:00) Fiji', '+12:00', 'off'),
(145, '(GMT+12:00) Kamchatka', '+12:00', 'off'),
(146, '(GMT+12:00) Marshall Is.', '+12:00', 'off'),
(147, '(GMT+12:00) Wellington', '+12:00', 'off'),
(148, '(GMT+12:45) Chatham Is.', '+12:45', 'off'),
(149, '(GMT+13:00) Samoa', '+13:00', 'off'),
(150, '(GMT+13:00) Tokelau Is.', '+13:00', 'off');

-- --------------------------------------------------------

--
-- Table structure for table `emts_transaction`
--

CREATE TABLE `emts_transaction` (
  `id` int(11) NOT NULL,
  `invoice_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(11) NOT NULL,
  `bidpackage_id` int(11) NOT NULL,
  `amount` double(20,2) NOT NULL,
  `credit_get` int(10) NOT NULL,
  `credit_debit` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_date` datetime NOT NULL,
  `transaction_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `current_balance` int(11) NOT NULL,
  `payment_method` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'direct',
  `txn_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gross_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pending_reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mc_fee` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mc_gross` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax` double NOT NULL,
  `mc_currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `txn_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payer_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payer_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notify_version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `verify_sign` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_creation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `received_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `receiver_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(20) COLLATE utf8_unicode_ci DEFAULT 'INR',
  `pay_type` enum('free','paid','unlimited') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'paid' COMMENT 'free,paid or unlimited',
  `commission` double DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emts_transaction`
--

INSERT INTO `emts_transaction` (`id`, `invoice_id`, `user_id`, `order_id`, `product_id`, `bidpackage_id`, `amount`, `credit_get`, `credit_debit`, `transaction_name`, `transaction_date`, `transaction_type`, `transaction_status`, `current_balance`, `payment_method`, `txn_id`, `gross_amount`, `pending_reason`, `payment_date`, `mc_fee`, `mc_gross`, `tax`, `mc_currency`, `txn_type`, `payer_email`, `payer_status`, `payment_type`, `notify_version`, `verify_sign`, `date_creation`, `received_amount`, `receiver_email`, `quantity`, `currency`, `pay_type`, `commission`, `admin_id`) VALUES
(1, 0, 69, '', 0, 0, 50.00, 0, 'CREDIT', 'Top up Balance: 50', '2017-03-29 15:25:48', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(2, 0, 69, '', 0, 0, 50.00, 0, 'CREDIT', 'Top up Balance: 50', '2017-03-29 17:06:55', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(3, 0, 69, '', 0, 0, 123.00, 0, 'CREDIT', 'Top up Balance: 123', '2017-03-30 09:12:38', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(4, 0, 69, '', 0, 0, 123.00, 0, 'CREDIT', 'Top up Balance: 123', '2017-03-30 09:33:26', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(7, 0, 69, '', 118, 0, 123.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of US$ 123.00', '2017-03-30 10:26:30', 'bidaccept_amount', 'Completed', 77, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, NULL),
(8, 0, 69, '', 118, 0, 123.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of US$ 123.00', '2017-03-30 10:39:09', 'bidaccept_amount', 'Completed', -46, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, NULL),
(9, 0, 83, '', 0, 0, 1520.00, 0, 'CREDIT', 'Top up Balance: 1520', '2017-04-21 09:10:24', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(10, 0, 83, '', 0, 0, 1520.00, 0, 'CREDIT', 'Top up Balance: 1520', '2017-04-21 09:10:43', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(11, 0, 83, '', 129, 0, 500.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of US$ 500.00', '2017-04-21 10:05:59', 'bidaccept_amount', 'Completed', 1100, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, NULL),
(12, 0, 83, '', 129, 0, 1200.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of US$ 1200.00', '2017-04-21 10:51:36', 'bidaccept_amount', 'Completed', 200, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, NULL),
(13, 0, 83, '', 129, 0, 1200.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of US$ 1200.00', '2017-04-21 10:53:12', 'bidaccept_amount', 'Completed', 0, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, NULL),
(14, 0, 83, '', 0, 0, 300.00, 0, 'CREDIT', 'Top up Balance: 300', '2017-04-24 14:10:12', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(15, 0, 83, '', 0, 0, 300.00, 0, 'CREDIT', 'Top up Balance: 300', '2017-04-24 14:11:40', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(16, 0, 83, '', 0, 0, 300.00, 0, 'CREDIT', 'Top up Balance: 300', '2017-04-24 14:15:10', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(17, 0, 83, '', 0, 0, 300.00, 0, 'CREDIT', 'Top up Balance: 300', '2017-04-24 14:15:18', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(18, 0, 83, '', 132, 0, 300.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of US$ 300.00', '2017-04-24 14:28:46', 'bidaccept_amount', 'Completed', 0, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, NULL),
(19, 0, 83, '', 0, 0, 1500.00, 0, 'CREDIT', 'Top up Balance: 1500', '2017-04-24 15:03:04', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(21, 0, 83, '', 132, 0, 1500.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of US$ 1500.00', '2017-04-24 15:30:55', 'bidaccept_amount', 'Completed', 0, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, NULL),
(22, 0, 83, '', 0, 0, 1000.00, 0, 'CREDIT', 'Top up Balance: 1000', '2017-04-25 15:56:25', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(23, 0, 83, '', 132, 0, 100.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of US$ 100.00', '2017-04-25 15:57:46', 'bidaccept_amount', 'Completed', 900, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, NULL),
(24, 0, 83, '', 132, 0, 200.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of US$ 200.00', '2017-05-02 15:50:25', 'bidaccept_amount', 'Completed', 700, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, NULL),
(25, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-05 14:39:58', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(26, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-05 14:41:18', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(27, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-05 15:00:43', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(28, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-05 15:13:52', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(29, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-05 15:43:05', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(30, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-05 15:46:20', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(31, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-05 16:03:54', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(32, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-05 16:04:07', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(33, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-05 16:21:33', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(34, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-05 16:26:16', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(35, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-05 16:33:30', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(36, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-05 16:34:41', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(37, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-05 16:36:31', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(38, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-05 16:38:42', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(39, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-05 16:40:58', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(40, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-05 16:43:10', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(41, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-08 10:45:34', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(42, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-08 10:46:07', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(43, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-08 10:47:00', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(44, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-08 10:50:48', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(45, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-08 10:57:44', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 108, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(46, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-08 10:58:16', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 108, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(47, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-08 14:04:56', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(48, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-08 15:27:27', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(49, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-10 16:32:17', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 108, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(50, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-10 16:35:24', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(51, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-10 16:38:05', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 51, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(52, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-10 16:43:04', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 51.2, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(53, 0, 81, '', 132, 0, 1350.00, 0, 'CREDIT', 'Pay for won Campaign Bid US$ 1500.00', '2017-05-11 10:34:00', 'payment_for_task_completion', 'Completed', 1350, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', 150, NULL),
(54, 0, 81, '', 132, 0, 1350.00, 0, 'CREDIT', 'Pay for won Campaign Bid US$ 1500.00', '2017-05-11 10:34:26', 'payment_for_task_completion', 'Completed', 2700, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', 150, NULL),
(55, 0, 81, '', 132, 0, 1350.00, 0, 'CREDIT', 'Pay for won Campaign Bid US$ 1500.00', '2017-05-11 10:36:49', 'payment_for_task_completion', 'Completed', 1350, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', 150, NULL),
(56, 0, 81, '', 132, 0, 1350.00, 0, 'CREDIT', 'Pay for won Campaign Bid US$ 1500.00', '2017-05-11 10:45:40', 'payment_for_task_completion', 'Completed', 2700, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', 150, NULL),
(57, 0, 81, '', 132, 0, 1350.00, 0, 'CREDIT', 'Pay for won Campaign Bid US$ 1500.00', '2017-05-11 10:46:06', 'payment_for_task_completion', 'Completed', 4050, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', 150, NULL),
(58, 0, 81, '', 132, 0, 1350.00, 0, 'CREDIT', 'Pay for won Campaign Bid US$ 1500.00', '2017-05-11 10:50:15', 'payment_for_task_completion', 'Completed', 5400, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', 150, NULL),
(59, 0, 81, '', 132, 0, 1350.00, 0, 'CREDIT', 'Pay for won Campaign Bid US$ 1500.00', '2017-05-11 10:58:51', 'payment_for_task_completion', 'Completed', 6750, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', 150, NULL),
(61, 0, 81, '', 132, 0, 1500.00, 0, 'DEBIT', 'Win amount transferred to respective account US$ 1500.00', '2017-05-16 14:33:07', 'pay_won_amount_admin', 'Completed', 5250, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, 8),
(62, 0, 85, '', 132, 0, 300.00, 0, 'DEBIT', 'Win amount transferred to respective account US$ 300.00', '2017-05-16 14:38:34', 'pay_won_amount_admin', 'Completed', -300, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, 8),
(63, 0, 82, '', 132, 0, 200.00, 0, 'DEBIT', 'Win amount transferred to respective account US$ 200.00', '2017-05-16 15:55:21', 'pay_won_amount_admin', 'Completed', -200, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, 8),
(64, 0, 83, '', 0, 0, 512.00, 0, 'CREDIT', 'Top up Balance: 512', '2017-05-23 13:57:35', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(65, 0, 83, '', 132, 0, 1212.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of US$ 1212.00', '2017-05-23 14:00:43', 'bidaccept_amount', 'Completed', 488, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, NULL),
(66, 0, 111, '', 0, 0, 234234.00, 0, 'CREDIT', 'Top up Balance: 234234', '2017-05-29 09:45:38', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(67, 0, 111, '', 0, 0, 234234.00, 0, 'CREDIT', 'Top up Balance: 234234', '2017-05-29 09:45:57', 'topup_balance', 'Processing', 0, 'paypal', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(68, 0, 84, '', 0, 0, 5.00, 0, 'Debit', 'Free Referral points', '2017-06-20 14:05:44', 'added_by_admin', 'Completed', 0, 'free', '', '', '', '', '', '', 0, 'US$', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(69, 0, 84, '', 0, 0, 2.00, 0, 'Debit', 'Free referral points for outstanding work', '2017-06-20 14:16:03', 'added_by_admin', 'Completed', 0, 'free', '', '', '', '', '', '', 0, 'US$', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(70, 0, 108, '', 0, 0, 2.00, 0, 'Debit', 'free referral points for good work', '2017-06-20 14:17:49', 'added_by_admin', 'Completed', 0, 'free', '', '', '', '', '', '', 0, 'US$', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(71, 0, 108, '', 0, 0, 2.00, 0, 'Debit', 'free referral points for good work', '2017-06-20 14:18:06', 'added_by_admin', 'Completed', 0, 'free', '', '', '', '', '', '', 0, 'US$', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(72, 0, 111, '', 0, 0, 1.00, 0, 'Debit', 'Referral points', '2017-06-20 14:18:26', 'added_by_admin', 'Completed', 0, 'free', '', '', '', '', '', '', 0, 'US$', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(73, 0, 107, '', 0, 0, 5.00, 0, 'Debit', 'referral points for help', '2017-06-20 14:18:50', 'added_by_admin', 'Completed', 0, 'free', '', '', '', '', '', '', 0, 'US$', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(74, 0, 108, '', 0, 0, 1.00, 0, 'Debit', 'test', '2017-06-20 14:20:57', 'added_by_admin', 'Completed', 0, 'free', '', '', '', '', '', '', 0, 'US$', '', '', '', '', '', '', '', '', '', '', 'INR', 'paid', NULL, NULL),
(75, 0, 83, '', 132, 0, 1500.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of US$ 1500.00', '2017-06-22 09:22:54', 'bidaccept_amount', 'Completed', -1012, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, NULL),
(76, 0, 83, '', 132, 0, 1500.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of US$ 1500.00', '2017-06-22 09:28:08', 'bidaccept_amount', 'Completed', -2512, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, NULL),
(77, 0, 83, '', 132, 0, 1500.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of US$ 1500.00', '2017-06-22 09:29:01', 'bidaccept_amount', 'Completed', -4012, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, NULL),
(78, 0, 83, '', 132, 0, 1500.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of US$ 1500.00', '2017-06-22 09:51:24', 'bidaccept_amount', 'Completed', -5512, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, NULL),
(79, 0, 83, '', 132, 0, 1500.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of US$ 1500.00', '2017-06-22 09:52:19', 'bidaccept_amount', 'Completed', -7012, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'USD', 'paid', NULL, NULL),
(80, 0, 83, '', 132, 0, 50.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of NRS 50.00', '2017-06-27 14:13:55', 'bidaccept_amount', 'Completed', 950, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'NRS', 'paid', NULL, NULL),
(83, 0, 81, '', 132, 0, 45.00, 0, 'CREDIT', 'Pay for won Campaign Bid NRS 50.00', '2017-06-27 14:25:36', 'payment_for_task_completion', 'Completed', 5295, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'NRS', 'paid', 5, NULL),
(84, 0, 83, '', 144, 0, 10.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of NRS 10.00', '2017-06-27 14:36:35', 'bidaccept_amount', 'Completed', 940, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'NRS', 'paid', NULL, NULL),
(85, 0, 83, '', 145, 0, 10.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of NRS 10.00', '2017-06-27 14:51:40', 'bidaccept_amount', 'Completed', 930, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'NRS', 'paid', NULL, NULL),
(86, 0, 83, '', 146, 0, 10.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of NRS 10.00', '2017-06-27 14:57:17', 'bidaccept_amount', 'Completed', 920, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'NRS', 'paid', NULL, NULL),
(87, 0, 83, '', 148, 0, 10.04, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of NRS 10.04', '2017-06-27 15:17:12', 'bidaccept_amount', 'Completed', 910, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'NRS', 'paid', NULL, NULL),
(88, 0, 83, '', 150, 0, 10.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of NRS 10.00', '2017-06-29 11:12:47', 'bidaccept_amount', 'Completed', 900, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'NRS', 'paid', NULL, NULL),
(89, 0, 83, '', 150, 0, 12.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of NRS 12.00', '2017-06-29 11:25:42', 'bidaccept_amount', 'Completed', 888, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'NRS', 'paid', NULL, NULL),
(90, 0, 82, '', 150, 0, 10.80, 0, 'CREDIT', 'Pay for won Campaign Bid NRS 12.00', '2017-06-29 11:29:25', 'payment_for_task_completion', 'Completed', 511, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'NRS', 'paid', 1.2, NULL),
(91, 0, 116, '', 151, 0, 5.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of NRS 5.00', '2017-06-29 12:09:32', 'bidaccept_amount', 'Completed', 495, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'NRS', 'paid', NULL, NULL),
(92, 0, 81, '', 151, 0, 4.50, 0, 'CREDIT', 'Pay for won Campaign Bid NRS 5.00', '2017-06-29 12:16:54', 'payment_for_task_completion', 'Completed', 5300, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'NRS', 'paid', 0.5, NULL),
(93, 0, 83, '', 153, 0, 10.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of NRS 10.00', '2017-07-04 16:08:37', 'bidaccept_amount', 'Completed', 878, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'NRS', 'paid', NULL, NULL),
(94, 0, 83, '', 153, 0, 10.00, 0, 'DEBIT', 'Deduct Balance for Accepting Proposal of NRS 10.00', '2017-07-04 16:10:21', 'bidaccept_amount', 'Completed', 868, 'Direct', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 'NRS', 'paid', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emts_admin_permissions`
--
ALTER TABLE `emts_admin_permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `emts_admin_roles_permission`
--
ALTER TABLE `emts_admin_roles_permission`
  ADD PRIMARY KEY (`user_type`,`permission_id`),
  ADD KEY `FK_ROLES_PERMS_PERMS_ID` (`permission_id`);

--
-- Indexes for table `emts_audience_demographic`
--
ALTER TABLE `emts_audience_demographic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `emts_audience_geography`
--
ALTER TABLE `emts_audience_geography`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `emts_block_ips`
--
ALTER TABLE `emts_block_ips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_category`
--
ALTER TABLE `emts_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prent_id` (`parent_id`);

--
-- Indexes for table `emts_category_1`
--
ALTER TABLE `emts_category_1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_ci_sessions`
--
ALTER TABLE `emts_ci_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `emts_cms`
--
ALTER TABLE `emts_cms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_cms_others`
--
ALTER TABLE `emts_cms_others`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_communication`
--
ALTER TABLE `emts_communication`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `bid_id` (`bid_id`);

--
-- Indexes for table `emts_communication_attachment`
--
ALTER TABLE `emts_communication_attachment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `msg_id` (`msg_id`);

--
-- Indexes for table `emts_communication_earlier`
--
ALTER TABLE `emts_communication_earlier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender` (`sender`),
  ADD KEY `receiver` (`receiver`);

--
-- Indexes for table `emts_contact`
--
ALTER TABLE `emts_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_country`
--
ALTER TABLE `emts_country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_draft_promotion`
--
ALTER TABLE `emts_draft_promotion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emts_draft_promotion_ibfk_1` (`bid_id`);

--
-- Indexes for table `emts_email_settings`
--
ALTER TABLE `emts_email_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_help`
--
ALTER TABLE `emts_help`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_log_admin_activity`
--
ALTER TABLE `emts_log_admin_activity`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `emts_log_invalid_logins`
--
ALTER TABLE `emts_log_invalid_logins`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `emts_members`
--
ALTER TABLE `emts_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `primary_media` (`primary_media`);

--
-- Indexes for table `emts_membership_package`
--
ALTER TABLE `emts_membership_package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_members_details`
--
ALTER TABLE `emts_members_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `emts_members_temp`
--
ALTER TABLE `emts_members_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_member_expertise`
--
ALTER TABLE `emts_member_expertise`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `emts_member_notification_settings`
--
ALTER TABLE `emts_member_notification_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_template_id` (`email_template_id`);

--
-- Indexes for table `emts_member_rating`
--
ALTER TABLE `emts_member_rating`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indexes for table `emts_member_socialmedia`
--
ALTER TABLE `emts_member_socialmedia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `media_type_id` (`media_type_id`);

--
-- Indexes for table `emts_message`
--
ALTER TABLE `emts_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_meta_categories`
--
ALTER TABLE `emts_meta_categories`
  ADD KEY `field_id` (`field_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `emts_meta_fields`
--
ALTER TABLE `emts_meta_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_meta_products`
--
ALTER TABLE `emts_meta_products`
  ADD KEY `product_id` (`product_id`),
  ADD KEY `meta_fields_id` (`meta_fields_id`);

--
-- Indexes for table `emts_news_letter`
--
ALTER TABLE `emts_news_letter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_notification`
--
ALTER TABLE `emts_notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `emts_objective`
--
ALTER TABLE `emts_objective`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_payment_gateway`
--
ALTER TABLE `emts_payment_gateway`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_pricerange`
--
ALTER TABLE `emts_pricerange`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_products`
--
ALTER TABLE `emts_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`brand_id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `sub_cat_id` (`sub_cat_id`);

--
-- Indexes for table `emts_product_bids`
--
ALTER TABLE `emts_product_bids`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emts_product_bids_ibfk_2` (`product_id`),
  ADD KEY `emts_product_bids_ibfk_3` (`user_id`),
  ADD KEY `emts_product_bids_ibfk_4` (`mediaid`),
  ADD KEY `emts_product_bids_ibfk_7` (`membermediaid`),
  ADD KEY `emts_product_bids_ibfk_8` (`productmediaid`);

--
-- Indexes for table `emts_product_currency`
--
ALTER TABLE `emts_product_currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_product_images`
--
ALTER TABLE `emts_product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `emts_product_images_temp`
--
ALTER TABLE `emts_product_images_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_product_invitation`
--
ALTER TABLE `emts_product_invitation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `emts_product_objective`
--
ALTER TABLE `emts_product_objective`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `objective_id` (`objective_id`);

--
-- Indexes for table `emts_product_post_categories`
--
ALTER TABLE `emts_product_post_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `emts_product_socialmedia`
--
ALTER TABLE `emts_product_socialmedia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emts_product_socialmedia_ibfk_1` (`user_id`),
  ADD KEY `emts_product_socialmedia_ibfk_2` (`product_id`),
  ADD KEY `emts_product_socialmedia_ibfk_3` (`socialmedia_id`);

--
-- Indexes for table `emts_product_static_fields`
--
ALTER TABLE `emts_product_static_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_product_winner`
--
ALTER TABLE `emts_product_winner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `member_id` (`user_id`);

--
-- Indexes for table `emts_profession`
--
ALTER TABLE `emts_profession`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_referral_prize`
--
ALTER TABLE `emts_referral_prize`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_report`
--
ALTER TABLE `emts_report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `bid_id` (`bid_id`);

--
-- Indexes for table `emts_reportuser`
--
ALTER TABLE `emts_reportuser`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bid_id` (`bid_id`);

--
-- Indexes for table `emts_seo`
--
ALTER TABLE `emts_seo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_site_settings`
--
ALTER TABLE `emts_site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_socialmedia_profile`
--
ALTER TABLE `emts_socialmedia_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indexes for table `emts_socialmedia_settings`
--
ALTER TABLE `emts_socialmedia_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_time_zone_setting`
--
ALTER TABLE `emts_time_zone_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emts_transaction`
--
ALTER TABLE `emts_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emts_admin_permissions`
--
ALTER TABLE `emts_admin_permissions`
  MODIFY `permission_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT for table `emts_audience_demographic`
--
ALTER TABLE `emts_audience_demographic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `emts_audience_geography`
--
ALTER TABLE `emts_audience_geography`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `emts_block_ips`
--
ALTER TABLE `emts_block_ips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `emts_category`
--
ALTER TABLE `emts_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;
--
-- AUTO_INCREMENT for table `emts_category_1`
--
ALTER TABLE `emts_category_1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emts_cms`
--
ALTER TABLE `emts_cms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `emts_cms_others`
--
ALTER TABLE `emts_cms_others`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `emts_communication`
--
ALTER TABLE `emts_communication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=439;
--
-- AUTO_INCREMENT for table `emts_communication_attachment`
--
ALTER TABLE `emts_communication_attachment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emts_communication_earlier`
--
ALTER TABLE `emts_communication_earlier`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `emts_contact`
--
ALTER TABLE `emts_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `emts_country`
--
ALTER TABLE `emts_country`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;
--
-- AUTO_INCREMENT for table `emts_draft_promotion`
--
ALTER TABLE `emts_draft_promotion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `emts_email_settings`
--
ALTER TABLE `emts_email_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT for table `emts_help`
--
ALTER TABLE `emts_help`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `emts_log_admin_activity`
--
ALTER TABLE `emts_log_admin_activity`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1038;
--
-- AUTO_INCREMENT for table `emts_log_invalid_logins`
--
ALTER TABLE `emts_log_invalid_logins`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `emts_members`
--
ALTER TABLE `emts_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;
--
-- AUTO_INCREMENT for table `emts_membership_package`
--
ALTER TABLE `emts_membership_package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `emts_members_details`
--
ALTER TABLE `emts_members_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;
--
-- AUTO_INCREMENT for table `emts_members_temp`
--
ALTER TABLE `emts_members_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emts_member_expertise`
--
ALTER TABLE `emts_member_expertise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;
--
-- AUTO_INCREMENT for table `emts_member_notification_settings`
--
ALTER TABLE `emts_member_notification_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=707;
--
-- AUTO_INCREMENT for table `emts_member_rating`
--
ALTER TABLE `emts_member_rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `emts_member_socialmedia`
--
ALTER TABLE `emts_member_socialmedia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `emts_message`
--
ALTER TABLE `emts_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emts_meta_fields`
--
ALTER TABLE `emts_meta_fields`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'primary key', AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `emts_news_letter`
--
ALTER TABLE `emts_news_letter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `emts_notification`
--
ALTER TABLE `emts_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `emts_objective`
--
ALTER TABLE `emts_objective`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `emts_payment_gateway`
--
ALTER TABLE `emts_payment_gateway`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `emts_pricerange`
--
ALTER TABLE `emts_pricerange`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `emts_products`
--
ALTER TABLE `emts_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;
--
-- AUTO_INCREMENT for table `emts_product_bids`
--
ALTER TABLE `emts_product_bids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;
--
-- AUTO_INCREMENT for table `emts_product_currency`
--
ALTER TABLE `emts_product_currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `emts_product_images`
--
ALTER TABLE `emts_product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `emts_product_images_temp`
--
ALTER TABLE `emts_product_images_temp`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `emts_product_invitation`
--
ALTER TABLE `emts_product_invitation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `emts_product_objective`
--
ALTER TABLE `emts_product_objective`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;
--
-- AUTO_INCREMENT for table `emts_product_post_categories`
--
ALTER TABLE `emts_product_post_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;
--
-- AUTO_INCREMENT for table `emts_product_socialmedia`
--
ALTER TABLE `emts_product_socialmedia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=427;
--
-- AUTO_INCREMENT for table `emts_product_static_fields`
--
ALTER TABLE `emts_product_static_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `emts_product_winner`
--
ALTER TABLE `emts_product_winner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `emts_profession`
--
ALTER TABLE `emts_profession`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `emts_referral_prize`
--
ALTER TABLE `emts_referral_prize`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `emts_report`
--
ALTER TABLE `emts_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `emts_reportuser`
--
ALTER TABLE `emts_reportuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `emts_seo`
--
ALTER TABLE `emts_seo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `emts_site_settings`
--
ALTER TABLE `emts_site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `emts_socialmedia_profile`
--
ALTER TABLE `emts_socialmedia_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `emts_socialmedia_settings`
--
ALTER TABLE `emts_socialmedia_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `emts_time_zone_setting`
--
ALTER TABLE `emts_time_zone_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;
--
-- AUTO_INCREMENT for table `emts_transaction`
--
ALTER TABLE `emts_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `emts_draft_promotion`
--
ALTER TABLE `emts_draft_promotion`
  ADD CONSTRAINT `emts_draft_promotion_ibfk_1` FOREIGN KEY (`bid_id`) REFERENCES `emts_product_bids` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `emts_members`
--
ALTER TABLE `emts_members`
  ADD CONSTRAINT `emts_members_ibfk_1` FOREIGN KEY (`primary_media`) REFERENCES `emts_socialmedia_settings` (`id`);

--
-- Constraints for table `emts_members_details`
--
ALTER TABLE `emts_members_details`
  ADD CONSTRAINT `emts_members_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `emts_members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `emts_member_expertise`
--
ALTER TABLE `emts_member_expertise`
  ADD CONSTRAINT `emts_member_expertise_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `emts_members` (`id`),
  ADD CONSTRAINT `emts_member_expertise_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `emts_members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `emts_member_socialmedia`
--
ALTER TABLE `emts_member_socialmedia`
  ADD CONSTRAINT `emts_member_socialmedia_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `emts_members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emts_member_socialmedia_ibfk_3` FOREIGN KEY (`media_type_id`) REFERENCES `emts_socialmedia_settings` (`id`);

--
-- Constraints for table `emts_product_bids`
--
ALTER TABLE `emts_product_bids`
  ADD CONSTRAINT `emts_product_bids_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `emts_products` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `emts_product_bids_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `emts_members` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `emts_product_bids_ibfk_4` FOREIGN KEY (`mediaid`) REFERENCES `emts_socialmedia_settings` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `emts_product_bids_ibfk_7` FOREIGN KEY (`membermediaid`) REFERENCES `emts_member_socialmedia` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `emts_product_bids_ibfk_8` FOREIGN KEY (`productmediaid`) REFERENCES `emts_product_socialmedia` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `emts_product_invitation`
--
ALTER TABLE `emts_product_invitation`
  ADD CONSTRAINT `emts_product_invitation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `emts_members` (`id`);

--
-- Constraints for table `emts_product_objective`
--
ALTER TABLE `emts_product_objective`
  ADD CONSTRAINT `emts_product_objective_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `emts_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emts_product_objective_ibfk_2` FOREIGN KEY (`objective_id`) REFERENCES `emts_objective` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `emts_product_socialmedia`
--
ALTER TABLE `emts_product_socialmedia`
  ADD CONSTRAINT `emts_product_socialmedia_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `emts_members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emts_product_socialmedia_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `emts_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emts_product_socialmedia_ibfk_3` FOREIGN KEY (`socialmedia_id`) REFERENCES `emts_socialmedia_settings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `emts_report`
--
ALTER TABLE `emts_report`
  ADD CONSTRAINT `emts_report_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `emts_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emts_report_ibfk_2` FOREIGN KEY (`bid_id`) REFERENCES `emts_product_bids` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `emts_reportuser`
--
ALTER TABLE `emts_reportuser`
  ADD CONSTRAINT `emts_reportuser_ibfk_1` FOREIGN KEY (`bid_id`) REFERENCES `emts_product_bids` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `emts_socialmedia_profile`
--
ALTER TABLE `emts_socialmedia_profile`
  ADD CONSTRAINT `emts_socialmedia_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `emts_members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emts_socialmedia_profile_ibfk_2` FOREIGN KEY (`media_id`) REFERENCES `emts_socialmedia_settings` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
