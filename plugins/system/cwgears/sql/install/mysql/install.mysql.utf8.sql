CREATE TABLE IF NOT EXISTS `#__cwgears` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `url` varchar(255) NOT NULL,
  `facebook_js` int(11) NOT NULL,
  `uikit` int(11) NOT NULL,
  `uikit_plus` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;