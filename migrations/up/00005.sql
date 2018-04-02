ALTER TABLE `oc_product_option_group` ADD `product_id` int(11) NOT NULL;
ALTER TABLE `oc_product_option_group` ADD INDEX `product_id_index` (`product_id`);

ALTER TABLE oc_product_option_group ADD CONSTRAINT FK_product
FOREIGN KEY (product_id) REFERENCES oc_product(product_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;