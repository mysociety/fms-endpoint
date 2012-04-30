-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 26, 2012 at 01:39 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `fms-endpoint`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` varchar(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `group` varchar(255) NOT NULL,
  `keywords` text NOT NULL,
  `metadata` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` VALUES('001', 'Pothole', 'Hole or crack in road surface.', 'Street defects', '', 'false', 'realtime');
INSERT INTO `categories` VALUES('002', 'Streetlight', 'Broken streetlight.', 'Street Defects', '', 'false', 'realtime');

-- --------------------------------------------------------

--
-- Table structure for table `category_attributes`
--

CREATE TABLE `category_attributes` (
  `category_id` varchar(255) NOT NULL,
  `attribute_id` varchar(255) NOT NULL,
  `variable` varchar(255) NOT NULL,
  `datatype` varchar(255) NOT NULL,
  `required` varchar(255) NOT NULL,
  `datatype_description` text NOT NULL,
  `order` int(10) NOT NULL,
  `description` text NOT NULL,
  `values` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_attributes`
--

INSERT INTO `category_attributes` VALUES('001', 'XX', 'true', 'text', 'true', '', 1, 'How deep is the hole?', '');

-- --------------------------------------------------------

--
-- Table structure for table `config_settings`
--

CREATE TABLE `config_settings` (
  `name` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `desc` text,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `config_settings`
--

INSERT INTO `config_settings` VALUES('organisation_name', 'Example Department', '<p>The name of the department/council/authority running this endpoint.</p>');
INSERT INTO `config_settings` VALUES('can_edit_categories', 'no', '<p>Can normal users change the Open311 Categories? Suggested values:</p>\n<ul>\n<li>no [default]</li>\n<li>yes</li>\n</ul>\n<p>The admin user can always change them.</p>');
INSERT INTO `config_settings` VALUES('redirect_root_page', '', '<p>Once your endpoint is up and running, you may prefer to automatically redirect it to the admin URL. Suggested values:</p> <ul><li style="padding-left:3em"> <i>(blank)</i> [default &mdash; no redirection: display the root page]</li><li>/admin </li><li> any URL</li></ul><p>Be sure to <a href="/">visit the root page</a> after changing this setting to check that it is working as you expected.</p>');
INSERT INTO `config_settings` VALUES('enable_open311_server', 'yes', '<p>Is the Open311 server running? Suggested values:</p>\n<ul>\n<li>no</li>\n<li>yes [default]</li>\n</ul>');
-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` VALUES(1, 'admin', 'Administrator');
INSERT INTO `groups` VALUES(2, 'members', 'General User');
INSERT INTO `groups` VALUES(3, 'open311', 'Open311 write access');

-- --------------------------------------------------------

--
-- Table structure for table `priorities`
--

CREATE TABLE `priorities` (
  `prio_value` varchar(255) NOT NULL,
  `prio_name` varchar(255) NOT NULL,
  PRIMARY KEY (`prio_value`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `priorities`
--

INSERT INTO `priorities` VALUES('-2', 'Very Low');
INSERT INTO `priorities` VALUES('-1', 'Low');
INSERT INTO `priorities` VALUES('0', 'Normal');
INSERT INTO `priorities` VALUES('1', 'High');
INSERT INTO `priorities` VALUES('2', 'Urgent');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(255) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `status_notes` text,
  `priority` int(255) DEFAULT '0',
  `category_name` varchar(255) DEFAULT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `description` text,
  `agency_responsible` varchar(255) DEFAULT NULL,
  `service_notice` text,
  `requested_datetime` datetime DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  `expected_datetime` datetime DEFAULT NULL,
  `address` text,
  `address_id` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `long` double DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `device_id` varchar(255) DEFAULT NULL,
  `account_id` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `media_url` text,
  PRIMARY KEY (`report_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=702641 ;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` VALUES(698792, 'open', NULL, 0, 'Pothole', '042', NULL, NULL, NULL, '2010-07-22 23:05:00', NULL, '2012-04-26 08:30:00', '<p>INTERSECTION of 22ND ST and SAN BRUNO AVE</p>', NULL, NULL, 37.756954, -122.40473, 'a_user@example.com', NULL, NULL, 'Anne', 'Example', NULL, 'http://farm3.static.flickr.com/2002/2212426634_5ed477a060.jpg');


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` int(10) unsigned NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(1, 2130706433, 'administrator', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'admin@example.com', '', NULL, NULL, 1268889823, 1335371450, 1, 'Admin', 'istrator', 'ADMIN', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` VALUES(1, 1, 1);
INSERT INTO `users_groups` VALUES(2, 1, 2);
