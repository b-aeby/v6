ALTER TABLE `CubeCart_options_top` ADD `option_type` TINYINT NOT NULL DEFAULT '0'; #EOQ

ALTER TABLE `CubeCart_order_sum` ADD `extra_notes` TEXT NOT NULL; #EOQ

CREATE TABLE IF NOT EXISTS `CubeCart_filemanager` (
	`file_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`type` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
	`disabled` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`filepath` varchar(255) default NULL,
	`filename` VARCHAR(255) NOT NULL,
	`filesize` INT UNSIGNED NOT NULL,
	`mimetype` VARCHAR(50) NOT NULL,
	`md5hash` VARCHAR(32) NOT NULL,
	`description` TEXT NOT NULL,
	PRIMARY KEY (`file_id`),
	KEY (`type`),
	KEY (`filepath`),
	KEY (`filename`),
	UNIQUE KEY (`md5hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; #EOQ