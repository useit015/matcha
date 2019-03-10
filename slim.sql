CREATE TABLE `slim`.`users` ( `id` INT NOT NULL AUTO_INCREMENT , `first_name` VARCHAR(255) NOT NULL , `last_name` VARCHAR(255) NOT NULL , `username` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL , `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `gender` TINYINT NULL , `sex_preference` TINYINT NULL , `biography` TEXT NULL , `tags` VARCHAR(255) NULL , `address` VARCHAR(255) NULL , `phone` VARCHAR(255) NULL , `status` VARCHAR(255) NULL , `rating` INT NULL , `vkey` VARCHAR(255) NOT NULL , `verified` BOOLEAN NOT NULL DEFAULT FALSE , PRIMARY KEY (`id`), UNIQUE (`email`)) ENGINE = InnoDB;
ALTER TABLE `slim`.`users` ADD `token` VARCHAR(255) NULL AFTER `verified`, ADD `tokenExpiration` DATETIME NULL AFTER `token`;
ALTER TABLE `users` ADD `city` VARCHAR(50) NULL AFTER `address`, ADD `country` VARCHAR(50) NULL AFTER `city`, ADD `postal_code` VARCHAR(50) NULL AFTER `country`;
ALTER TABLE `users` CHANGE `gender` `gender` VARCHAR(20) NULL DEFAULT NULL, CHANGE `sex_preference` `looking` VARCHAR(20) NULL DEFAULT NULL;