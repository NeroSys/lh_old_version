ALTER TABLE `oc_product_option_group` ADD `ean` VARCHAR (100) NOT NULL;
UPDATE `oc_product_option_group` SET `ean` = `id`;
ALTER TABLE `oc_product_option_group` ADD UNIQUE `ean_1c` (`ean`);