CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(11) NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `playerid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_level` enum('1','2','3') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `user_profile` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';
 
INSERT INTO `users` (`user_id`, `user_name`, `user_password_hash`, `user_email`, `playerid`, `user_level`, `user_profile`) VALUES
(4, 'Admin', '$2y$10$QIzAXgqRRn9xaN62Unu8Nec3iSU9jmRIast3MsXD1b3YHpcFgBMKy', 'admin@demo.com', '76561198088654521', '3', 'assets/img/ui-dave.jpg');
 
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `user_name` (`user_name`), ADD UNIQUE KEY `user_email` (`user_email`);
 
ALTER TABLE `users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',AUTO_INCREMENT=8;
