CREATE TABLE IF NOT EXISTS `oc_ocfilter_option` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(16) NOT NULL DEFAULT 'checkbox',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `selectbox` tinyint(1) NOT NULL DEFAULT '0',
  `grouping` tinyint(2) NOT NULL DEFAULT '0',
  `color` tinyint(1) NOT NULL DEFAULT '0',
  `image` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`option_id`),
  KEY `keyword` (`keyword`),
  KEY `status` (`status`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `oc_ocfilter_option_description` (
  `option_id` int(11) NOT NULL,
  `language_id` tinyint(2) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `postfix` varchar(32) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`option_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `oc_ocfilter_option_to_category` (
  `option_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`option_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `oc_ocfilter_option_to_store` (
  `option_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`store_id`,`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `oc_ocfilter_option_value` (
  `value_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) NOT NULL DEFAULT '0',
  `keyword` varchar(255) NOT NULL DEFAULT '',
  `color` varchar(6) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`value_id`,`option_id`),
  KEY `keyword` (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `oc_ocfilter_option_value_description` (
  `value_id` bigint(20) NOT NULL,
  `option_id` int(11) NOT NULL,
  `language_id` tinyint(2) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`value_id`,`language_id`),
  KEY `option_id` (`option_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `oc_ocfilter_option_value_to_product` (
	`ocfilter_option_value_to_product_id` INT(11) NOT NULL AUTO_INCREMENT,
	`product_id` INT(11) NOT NULL,
	`option_id` INT(11) NOT NULL,
	`value_id` BIGINT(20) NOT NULL,
	`slide_value_min` DECIMAL(15,4) NOT NULL DEFAULT '0.0000',
	`slide_value_max` DECIMAL(15,4) NOT NULL DEFAULT '0.0000',
	PRIMARY KEY (`ocfilter_option_value_to_product_id`),
	INDEX `slide_value_min_slide_value_max` (`slide_value_min`, `slide_value_max`),
	INDEX `option_id_value_id` (`option_id`, `value_id`),
	INDEX `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `oc_ocfilter_option_value_to_product_description` (
  `product_id` int(11) NOT NULL,
  `value_id` bigint(20) NOT NULL,
  `option_id` int(11) NOT NULL,
  `language_id` tinyint(2) NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`product_id`,`value_id`,`option_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `oc_ocfilter_page` (
  `ocfilter_page_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `ocfilter_params` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ocfilter_page_id`),
  KEY `category_id_ocfilter_params` (`category_id`,`ocfilter_params`),
  KEY `keyword` (`keyword`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;