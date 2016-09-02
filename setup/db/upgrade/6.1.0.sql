ALTER TABLE `CubeCart_order_history` ADD `initiator` VARCHAR(1) NOT NULL DEFAULT 'G'; #EOQ
UPDATE `CubeCart_order_history` SET `initiator` = 'U'; #EOQ
CREATE TABLE `CubeCart_email_log` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content_html` text COLLATE utf8_unicode_ci NOT NULL,
  `content_text` text COLLATE utf8_unicode_ci NOT NULL,
  `to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email_content_id` int(11) NOT NULL,
  `result` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; #EOQ
ALTER TABLE `CubeCart_email_log` ADD PRIMARY KEY (`id`); #EOQ
ALTER TABLE `CubeCart_email_log` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1; #EOQ 
ALTER TABLE `CubeCart_coupons` ADD `free_shipping` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `shipping`; #EOQ