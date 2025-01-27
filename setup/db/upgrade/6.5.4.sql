ALTER TABLE `CubeCart_filemanager` ADD INDEX(`type`); #EOQ
ALTER TABLE `CubeCart_filemanager` ADD UNIQUE(`md5hash`); #EOQ
ALTER TABLE `CubeCart_currency` ADD `adjustment` DECIMAL(5,3) NOT NULL DEFAULT '0.000'; #EOQ
ALTER TABLE `CubeCart_addressbook` CHANGE `title` `title` VARCHAR(16); #EOQ
ALTER TABLE `CubeCart_addressbook` CHANGE `first_name` `first_name` VARCHAR(32); #EOQ
ALTER TABLE `CubeCart_addressbook` CHANGE `last_name` `last_name` VARCHAR(32); #EOQ
ALTER TABLE `CubeCart_customer` CHANGE `email` `email` VARCHAR(96); #EOQ
ALTER TABLE `CubeCart_customer` CHANGE `title` `title` VARCHAR(16); #EOQ
ALTER TABLE `CubeCart_customer` CHANGE `first_name` `first_name` VARCHAR(32); #EOQ
ALTER TABLE `CubeCart_customer` CHANGE `last_name` `last_name` VARCHAR(32); #EOQ
ALTER TABLE `CubeCart_order_summary` CHANGE `email` `email` VARCHAR(96); #EOQ
ALTER TABLE `CubeCart_order_summary` CHANGE `title` `title` VARCHAR(16); #EOQ
ALTER TABLE `CubeCart_order_summary` CHANGE `first_name` `first_name` VARCHAR(32); #EOQ
ALTER TABLE `CubeCart_order_summary` CHANGE `last_name` `last_name` VARCHAR(32); #EOQ
ALTER TABLE `CubeCart_newsletter_subscriber` CHANGE `email` `email` VARCHAR(96); #EOQ
ALTER TABLE `CubeCart_newsletter_subscriber_log` CHANGE `email` `email` VARCHAR(96); #EOQ
ALTER TABLE `CubeCart_reviews` CHANGE `email` `email` VARCHAR(96); #EOQ
ALTER TABLE `CubeCart_customer_coupon` CHANGE `email` `email` VARCHAR(96); #EOQ
ALTER TABLE `CubeCart_admin_users` CHANGE `email` `email` VARCHAR(96); #EOQ
ALTER TABLE `CubeCart_category_language` CHANGE `cat_desc` `cat_desc` TEXT NULL DEFAULT NULL; #EOQ
ALTER TABLE `CubeCart_inventory` CHANGE `maximum_quantity` `maximum_quantity` INT NULL DEFAULT '0'; #EOQ
ALTER TABLE `CubeCart_order_summary` ADD `updated` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP; #EOQ
ALTER TABLE `CubeCart_admin_log` CHANGE `item_id` `item_id` VARCHAR(255) NULL DEFAULT NULL; #EOQ
ALTER TABLE `CubeCart_inventory` ADD `product_parse` INT UNSIGNED NOT NULL DEFAULT '0'; #EOQ
ALTER TABLE `CubeCart_category` ADD `cat_parse` INT UNSIGNED NOT NULL DEFAULT '0'; #EOQ
ALTER TABLE `CubeCart_filemanager` ADD `date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP; #EOQ