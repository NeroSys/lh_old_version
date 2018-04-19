CREATE TABLE `oc_product_option_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `price_base` float DEFAULT NULL,
  `price_discount` float DEFAULT NULL,
  `price_discount_type` varchar(11) DEFAULT NULL,
  `quantity` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `oc_product_option_value` ADD product_option_group int(11) unsigned NOT NULL;
ALTER TABLE `oc_product_option_value` ADD INDEX `product_option_group_index` (`product_option_group`);