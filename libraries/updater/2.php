<?php
mysqli_query($link, "ALTER TABLE `users` CHANGE user_level user_level ENUM('0','1','2','3');") or die(mysqli_error($link));
mysqli_query($link, "ALTER TABLE `users` ADD `user_profile` SMALLINT NOT NULL;") or die(mysqli_error($link));
mysqli_query($link, "UPDATE `users` SET `user_profile`='1'") or die(mysqli_error($link));