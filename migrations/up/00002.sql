ALTER TABLE `oc_address` ENGINE=INNODB;
ALTER TABLE `oc_affiliate` ENGINE=INNODB;
ALTER TABLE `oc_affiliate_activity` ENGINE=INNODB;
ALTER TABLE `oc_affiliate_login` ENGINE=INNODB;
ALTER TABLE `oc_affiliate_transaction` ENGINE=INNODB;
ALTER TABLE `oc_api` ENGINE=INNODB;
ALTER TABLE `oc_api_ip` ENGINE=INNODB;
ALTER TABLE `oc_api_session` ENGINE=INNODB;
ALTER TABLE `oc_attribute` ENGINE=INNODB;
ALTER TABLE `oc_attribute_description` ENGINE=INNODB;
ALTER TABLE `oc_attribute_group` ENGINE=INNODB;
ALTER TABLE `oc_attribute_group_description` ENGINE=INNODB;
ALTER TABLE `oc_banner` ENGINE=INNODB;
ALTER TABLE `oc_banner_image` ENGINE=INNODB;
ALTER TABLE `oc_banner_image_description` ENGINE=INNODB;
ALTER TABLE `oc_category` ENGINE=INNODB;
ALTER TABLE `oc_category_description` ENGINE=INNODB;
ALTER TABLE `oc_category_filter` ENGINE=INNODB;
ALTER TABLE `oc_category_path` ENGINE=INNODB;
ALTER TABLE `oc_category_to_layout` ENGINE=INNODB;
ALTER TABLE `oc_category_to_store` ENGINE=INNODB;
ALTER TABLE `oc_country` ENGINE=INNODB;
ALTER TABLE `oc_coupon`
  CHANGE COLUMN `date_start` `date_start` date NOT NULL DEFAULT '1970-01-01',
  CHANGE COLUMN `date_end` `date_end` date NOT NULL DEFAULT '2100-01-01',
  ENGINE=INNODB;
ALTER TABLE `oc_coupon_category` ENGINE=INNODB;
ALTER TABLE `oc_coupon_history` ENGINE=INNODB;
ALTER TABLE `oc_coupon_product` ENGINE=INNODB;
ALTER TABLE `oc_currency` ENGINE=INNODB;
ALTER TABLE `oc_custom_field` ENGINE=INNODB;
ALTER TABLE `oc_custom_field_customer_group` ENGINE=INNODB;
ALTER TABLE `oc_custom_field_description` ENGINE=INNODB;
ALTER TABLE `oc_custom_field_value` ENGINE=INNODB;
ALTER TABLE `oc_custom_field_value_description` ENGINE=INNODB;
ALTER TABLE `oc_customer` ENGINE=INNODB;
ALTER TABLE `oc_customer_activity` ENGINE=INNODB;
ALTER TABLE `oc_customer_group` ENGINE=INNODB;
ALTER TABLE `oc_customer_group_description` ENGINE=INNODB;
ALTER TABLE `oc_customer_history` ENGINE=INNODB;
ALTER TABLE `oc_customer_ip` ENGINE=INNODB;
ALTER TABLE `oc_customer_login` ENGINE=INNODB;
ALTER TABLE `oc_customer_online` ENGINE=INNODB;
ALTER TABLE `oc_customer_reward` ENGINE=INNODB;
ALTER TABLE `oc_customer_transaction` ENGINE=INNODB;
ALTER TABLE `oc_customer_wishlist` ENGINE=INNODB;
ALTER TABLE `oc_download` ENGINE=INNODB;
ALTER TABLE `oc_download_description` ENGINE=INNODB;
ALTER TABLE `oc_event` ENGINE=INNODB;
ALTER TABLE `oc_extension` ENGINE=INNODB;
ALTER TABLE `oc_filter` ENGINE=INNODB;
ALTER TABLE `oc_filter_description` ENGINE=INNODB;
ALTER TABLE `oc_filter_group` ENGINE=INNODB;
ALTER TABLE `oc_filter_group_description` ENGINE=INNODB;
ALTER TABLE `oc_geo_zone` ENGINE=INNODB;
ALTER TABLE `oc_information` ENGINE=INNODB;
ALTER TABLE `oc_information_description` ENGINE=INNODB;
ALTER TABLE `oc_information_to_layout` ENGINE=INNODB;
ALTER TABLE `oc_information_to_store` ENGINE=INNODB;
ALTER TABLE `oc_language` ENGINE=INNODB;
ALTER TABLE `oc_layout` ENGINE=INNODB;
ALTER TABLE `oc_layout_module` ENGINE=INNODB;
ALTER TABLE `oc_layout_route` ENGINE=INNODB;
ALTER TABLE `oc_length_class` ENGINE=INNODB;
ALTER TABLE `oc_length_class_description` ENGINE=INNODB;
ALTER TABLE `oc_location` ENGINE=INNODB;
ALTER TABLE `oc_manufacturer` ENGINE=INNODB;
ALTER TABLE `oc_manufacturer_to_store` ENGINE=INNODB;
ALTER TABLE `oc_marketing` ENGINE=INNODB;
ALTER TABLE `oc_modification` ENGINE=INNODB;
ALTER TABLE `oc_module` ENGINE=INNODB;
ALTER TABLE `oc_newsblog_article`
  CHANGE COLUMN `date_available` `date_available` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  ENGINE=INNODB;
ALTER TABLE `oc_newsblog_article_attribute` ENGINE=INNODB;
ALTER TABLE `oc_newsblog_article_description` ENGINE=INNODB;
ALTER TABLE `oc_newsblog_article_image` ENGINE=INNODB;
ALTER TABLE `oc_newsblog_article_related` ENGINE=INNODB;
ALTER TABLE `oc_newsblog_article_to_category` ENGINE=INNODB;
ALTER TABLE `oc_newsblog_article_to_layout` ENGINE=INNODB;
ALTER TABLE `oc_newsblog_article_to_store` ENGINE=INNODB;
ALTER TABLE `oc_newsblog_category` ENGINE=INNODB;
ALTER TABLE `oc_newsblog_category_description` ENGINE=INNODB;
ALTER TABLE `oc_newsblog_category_path` ENGINE=INNODB;
ALTER TABLE `oc_newsblog_category_to_layout` ENGINE=INNODB;
ALTER TABLE `oc_newsblog_category_to_store` ENGINE=INNODB;
ALTER TABLE `oc_option` ENGINE=INNODB;
ALTER TABLE `oc_option_description` ENGINE=INNODB;
ALTER TABLE `oc_option_value` ENGINE=INNODB;
ALTER TABLE `oc_option_value_description` ENGINE=INNODB;
ALTER TABLE `oc_order` ENGINE=INNODB;
ALTER TABLE `oc_order_custom_field` ENGINE=INNODB;
ALTER TABLE `oc_order_history` ENGINE=INNODB;
ALTER TABLE `oc_order_option` ENGINE=INNODB;
ALTER TABLE `oc_order_product` ENGINE=INNODB;
ALTER TABLE `oc_order_recurring` ENGINE=INNODB;
ALTER TABLE `oc_order_recurring_transaction` ENGINE=INNODB;
ALTER TABLE `oc_order_status` ENGINE=INNODB;
ALTER TABLE `oc_order_total` ENGINE=INNODB;
ALTER TABLE `oc_order_voucher` ENGINE=INNODB;
ALTER TABLE `oc_product`
  CHANGE COLUMN `date_available` `date_available` date NOT NULL DEFAULT '1970-01-01',
  ENGINE=INNODB;
ALTER TABLE `oc_product_attribute` ENGINE=INNODB;
ALTER TABLE `oc_product_description` ENGINE=INNODB;
ALTER TABLE `oc_product_discount`
  CHANGE COLUMN `date_start` `date_start` date NOT NULL DEFAULT '1970-01-01',
  CHANGE COLUMN `date_end` `date_end` date NOT NULL DEFAULT '2100-01-01',
  ENGINE=INNODB;
ALTER TABLE `oc_product_filter` ENGINE=INNODB;
ALTER TABLE `oc_product_image` ENGINE=INNODB;
ALTER TABLE `oc_product_option` ENGINE=INNODB;
ALTER TABLE `oc_product_option_value` ENGINE=INNODB;
ALTER TABLE `oc_product_recurring` ENGINE=INNODB;
ALTER TABLE `oc_product_related` ENGINE=INNODB;
ALTER TABLE `oc_product_reward` ENGINE=INNODB;
ALTER TABLE `oc_product_special`
  CHANGE COLUMN `date_start` `date_start` date NOT NULL DEFAULT '1970-01-01',
  CHANGE COLUMN `date_end` `date_end` date NOT NULL DEFAULT '2100-01-01',
  ENGINE=INNODB;
ALTER TABLE `oc_product_to_category` ENGINE=INNODB;
ALTER TABLE `oc_product_to_download` ENGINE=INNODB;
ALTER TABLE `oc_product_to_layout` ENGINE=INNODB;
ALTER TABLE `oc_product_to_store` ENGINE=INNODB;
ALTER TABLE `oc_recurring` ENGINE=INNODB;
ALTER TABLE `oc_recurring_description` ENGINE=INNODB;
ALTER TABLE `oc_return`
  CHANGE COLUMN `date_ordered` `date_ordered` date NOT NULL DEFAULT '2100-01-01',
  ENGINE=INNODB;
ALTER TABLE `oc_return_action` ENGINE=INNODB;
ALTER TABLE `oc_return_history` ENGINE=INNODB;
ALTER TABLE `oc_return_reason` ENGINE=INNODB;
ALTER TABLE `oc_return_status` ENGINE=INNODB;
ALTER TABLE `oc_review` ENGINE=INNODB;
ALTER TABLE `oc_setting` ENGINE=INNODB;
ALTER TABLE `oc_stock_status` ENGINE=INNODB;
ALTER TABLE `oc_store` ENGINE=INNODB;
ALTER TABLE `oc_tax_class` ENGINE=INNODB;
ALTER TABLE `oc_tax_rate` ENGINE=INNODB;
ALTER TABLE `oc_tax_rate_to_customer_group` ENGINE=INNODB;
ALTER TABLE `oc_tax_rule` ENGINE=INNODB;
ALTER TABLE `oc_upload` ENGINE=INNODB;
ALTER TABLE `oc_url_alias` ENGINE=INNODB;
ALTER TABLE `oc_user` ENGINE=INNODB;
ALTER TABLE `oc_user_group` ENGINE=INNODB;
ALTER TABLE `oc_voucher` ENGINE=INNODB;
ALTER TABLE `oc_voucher_history` ENGINE=INNODB;
ALTER TABLE `oc_voucher_theme` ENGINE=INNODB;
ALTER TABLE `oc_voucher_theme_description` ENGINE=INNODB;
ALTER TABLE `oc_weight_class` ENGINE=INNODB;
ALTER TABLE `oc_weight_class_description` ENGINE=INNODB;
ALTER TABLE `oc_zone` ENGINE=INNODB;
UPDATE `oc_zone_to_geo_zone` SET `date_added` = CURRENT_TIMESTAMP, `date_modified` = CURRENT_TIMESTAMP;
ALTER TABLE `oc_zone_to_geo_zone`
  CHANGE COLUMN `date_added` `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CHANGE COLUMN `date_modified` `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  ENGINE=INNODB;