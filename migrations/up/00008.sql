ALTER TABLE `oc_coupon`
  CHANGE COLUMN `date_start` `date_start` date NOT NULL DEFAULT '1970-01-01',
  CHANGE COLUMN `date_end` `date_end` date NOT NULL DEFAULT '2100-01-01';
ALTER TABLE `oc_newsblog_article`
  CHANGE COLUMN `date_available` `date_available` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `oc_product`
  CHANGE COLUMN `date_available` `date_available` date NOT NULL DEFAULT '1970-01-01';
ALTER TABLE `oc_product_discount`
  CHANGE COLUMN `date_start` `date_start` date NOT NULL DEFAULT '1970-01-01',
  CHANGE COLUMN `date_end` `date_end` date NOT NULL DEFAULT '2100-01-01',
  ENGINE=INNODB;
ALTER TABLE `oc_product_special`
  CHANGE COLUMN `date_start` `date_start` date NOT NULL DEFAULT '1970-01-01',
  CHANGE COLUMN `date_end` `date_end` date NOT NULL DEFAULT '2100-01-01';
ALTER TABLE `oc_return`
  CHANGE COLUMN `date_ordered` `date_ordered` date NOT NULL DEFAULT '2100-01-01';
UPDATE `oc_zone_to_geo_zone` SET `date_added` = CURRENT_TIMESTAMP, `date_modified` = CURRENT_TIMESTAMP;
ALTER TABLE `oc_zone_to_geo_zone`
  CHANGE COLUMN `date_added` `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CHANGE COLUMN `date_modified` `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;