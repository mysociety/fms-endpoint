-- SQL for initialising FMS-endpoint database
-- suitable for mySQL 

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Table structure for table `categories`
-- category_id is varchar just in case that's helpful for departments with
-- existing (legacy) classifcations for categories. Be wary of case-dependency
-- if they're not numbers!

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
-- empty table; example only:

-- INSERT INTO `category_attributes` VALUES('001', 'XX', 'true', 'text', 'true', '', 1, 'How deep is the hole?', '');

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
INSERT INTO `config_settings` VALUES('open311_use_external_id', 'always', '<p>Does the Open311 server demand that an external ID (such as FixMyStreet problem ID) is always provided? Suggested values:</p>\n<ul>\n<li>no</li>\n<li>optional</li>\n<li>always [default]</li>\n</ul>');
INSERT INTO `config_settings` VALUES('open311_use_external_name', 'external_id', '<p>The name of the external ID that must be sent if <strong>open311_use_external_id</strong> is set to <em>yes</em>. Defaults to <em>external_id</em> if left blank. For example, use as <em>attrib[external_id]</em> in incoming reports.</li>\n</ul>');



-- --------------------------------------------------------

--
-- Table structure for table `groups`
-- from Ion Auth 2 (CodeIgniter user authentication)

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
-- Table structure for table `users`
-- from Ion Auth 2 (CodeIgniter user authentication)
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
-- from Ion Auth 2 (CodeIgniter user authentication)
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
-- --------------------------------------------------------

--
-- Table structure for table `priorities`
--

CREATE TABLE `priorities` (
  `prio_value` int(11) NOT NULL,
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
  `status` int(11) DEFAULT '1',
  `status_notes` text,
  `priority` int(11) DEFAULT '0',
  `category_id` varchar(255) DEFAULT NULL,
  `description` text,
  `agency_responsible` varchar(255) DEFAULT NULL,
  `service_notice` text,
  `token` varchar(255) DEFAULT NULL,
  `external_id` varchar(255) DEFAULT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` VALUES(1000, 1, NULL, 0, '001', 'Hole in the road', NULL, NULL, NULL, NULL, '2012-05-01 12:00:00', NULL, '2012-05-02 13:00:00', 'Intersection of 22nd St and San Bruna Ave', NULL, NULL, 37.756954, -122.40473, 'a_user@example.com', NULL, NULL, 'Anne', 'Example', NULL, 'http://farm3.static.flickr.com/2002/2212426634_5ed477a060.jpg');


-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_closed` tinyint(1) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `statuses`
-- Note these statuses correspond to FixMyStreet statuses
-- except "unknown" which is an error state

INSERT INTO `statuses` VALUES(0, 'unknown',  'unrecognised status', 0);

INSERT INTO `statuses` VALUES(1, 'new',    'report newly created', 0);
INSERT INTO `statuses` VALUES(2, 'open',   'awaiting action', 0);
INSERT INTO `statuses` VALUES(3, 'closed', 'no further action required', 1);

INSERT INTO `statuses` VALUES(4, 'investigating', 'investigating', 0);
INSERT INTO `statuses` VALUES(5, 'planned', 'work is scheduled', 0);
INSERT INTO `statuses` VALUES(6, 'in progress', 'work is in progress', 0);

INSERT INTO `statuses` VALUES(7, 'fixed', 'problem is fixed', 1);
INSERT INTO `statuses` VALUES(8, 'fixed - user', 'problem marked as fixed by public', 1);
INSERT INTO `statuses` VALUES(9, 'fixed - council', 'problem marked as fixed by dept/council', 1);

