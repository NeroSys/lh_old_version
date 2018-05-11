ALTER TABLE `oc_order_product` DROP key specification_ean_1c;
ALTER TABLE `oc_order_product` ADD INDEX `specification_ean_1c_index` (`ean`);

ALTER TABLE oc_order_product ADD CONSTRAINT FK_oc_order_id_to_product
FOREIGN KEY (order_id) REFERENCES oc_order(order_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;