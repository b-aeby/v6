ALTER TABLE `CubeCart_request_log` ADD `response_code` VARCHAR(3) NULL DEFAULT NULL AFTER `result`; #EOQ
ALTER TABLE `CubeCart_request_log` ADD `is_curl` ENUM('1','0') NOT NULL AFTER `response_code`; #EOQ