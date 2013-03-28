CREATE TABLE IF NOT EXISTS `#__fbimporter_formats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `ordering` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(10) unsigned NOT NULL,
  `language` char(7) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_createdby` (`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_checkout` (`checked_out`),
  KEY `cat_index` (`published`,`access`,`catid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `#__fbimporter_formats` (`id`, `catid`, `title`, `introtext`, `fulltext`, `ordering`, `published`, `checked_out`, `checked_out_time`, `access`, `language`, `params`) VALUES
(1, 1, '基本格式一', '<p>{IMAGE}</p>\r\n<p>{CREATED_TIME} - {LIKES} Likes</p>\r\n<p>{INTRO_MESSAGE}</p>\r\n', '\r\n<p> </p>\r\n<h3>{LINK_NAME}</h3>\r\n<p>{VIDEO}</p>\r\n<p>{FULL_MESSAGE} </p>\r\n<p> </p>\r\n<p>Source: {LINK_URL}</p>\r\n<p> </p>\r\n<p class="ja-typo-box box-hilite-1"><strong>Readmore:</strong> <a href="{READMORE_LINK}" target="_blank">{READMORE_LINK}</a></p>\r\n<p> </p>', 1, 1, 0, '0000-00-00 00:00:00', 1, '*', '');