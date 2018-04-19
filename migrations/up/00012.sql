ALTER TABLE `oc_product` ADD `id_erp` VARCHAR (100) NOT NULL;
ALTER TABLE `oc_product` ADD INDEX `product_id_erp_index` (`id_erp`);

ALTER TABLE `oc_option` ADD INDEX `option_id_erp_index` (`id_erp`);
ALTER TABLE `oc_option_value` ADD INDEX `option_value_id_erp_index` (`id_erp`);