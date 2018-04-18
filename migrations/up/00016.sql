ALTER TABLE `oc_order_product` ADD `ean` VARCHAR (100) NOT NULL;
ALTER TABLE `oc_order_product` ADD UNIQUE `specification_ean_1c` (`ean`);

ALTER TABLE `oc_order_status` ADD `erp_id` VARCHAR (100) NOT NULL;