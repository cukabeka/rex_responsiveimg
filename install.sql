DROP TABLE IF EXISTS `%TABLE_PREFIX%responsiveimg`;
CREATE TABLE IF NOT EXISTS `%TABLE_PREFIX%responsiveimg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile_first` varchar(255) NOT NULL,
  `minwidth` int(11) NOT NULL,
  `responsive` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;