CREATE TABLE category (
`id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
`parent_id` INT(11) DEFAULT NULL,
KEY(`parent_id`)
) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8;


CREATE TABLE item (
`id` INT(11) UNSIGNED not null,
`action_ru` TINYINT UNSIGNED default 1,
`action_en` TINYINT UNSIGNED default 1,
`name_ru` VARCHAR(128) default NULL,
`name_en` VARCHAR(128)  default NULL,
`short_description_ru` TEXT default NULL,
`short_description_en` TEXT default NULL,
`description_ru` LONGTEXT default NULL,
`description_en` LONGTEXT default NULL,
`meta_title_ru`  VARCHAR(128)  default NULL,
`meta_title_en`  VARCHAR(128)  default NULL,
`meta_description_en`  VARCHAR(128)  default NULL,
`meta_description_ru`  VARCHAR(128)  default NULL,
`meta_keywords_ru`  VARCHAR(128)  default NULL,
`meta_keywords_en`  VARCHAR(128)  default NULL,
`file_ru`  VARCHAR(128)  default NULL,
`file_en`  VARCHAR(128)  default NULL,
UNIQUE KEY(`id`)
) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8;


