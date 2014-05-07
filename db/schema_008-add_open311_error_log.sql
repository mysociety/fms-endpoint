CREATE TABLE `open311_error_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `error_code` mediumint(8) unsigned,
  `error_msg` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `api_key` varchar(255),
  PRIMARY KEY (`log_id`),
  KEY `created_at` (`created_at`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;