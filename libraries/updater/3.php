<?php
mysqli_query($link, "CREATE TABLE IF NOT EXISTS `notes` (
	  `note_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing note_id of each user, unique index',
	  `uid` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	  `staff_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	  `note_text` varchar(255) NOT NULL,
	  `note_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  PRIMARY KEY (`note_id`),
	  UNIQUE KEY `note_id` (`note_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;")or die(mysqli_error($link));