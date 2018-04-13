ALTER TABLE `oc_product_option` ADD product_option_group int(11) unsigned NOT NULL;
ALTER TABLE `oc_product_option` ADD INDEX `product_option_group_index` (`product_option_group`);

ALTER TABLE oc_product_option ADD CONSTRAINT FK_option_value_group
FOREIGN KEY (product_option_group) REFERENCES oc_product_option_group(id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

UPDATE oc_option SET `id_erp` = `option_id`;
ALTER TABLE  oc_option ADD UNIQUE ( id_erp );
UPDATE oc_option_value SET `id_erp` = `option_value_id`;
ALTER TABLE  oc_option_value ADD UNIQUE ( id_erp );

UPDATE oc_attribute SET `id_erp` = `attribute_id`;
ALTER TABLE  oc_attribute ADD UNIQUE ( id_erp );

UPDATE oc_manufacturer SET `id_erp` = `manufacturer_id`;
ALTER TABLE  oc_manufacturer ADD UNIQUE ( id_erp );
UPDATE oc_category SET `id_erp` = `category_id`;
ALTER TABLE  oc_category ADD UNIQUE ( id_erp );

UPDATE oc_product_option_group SET `id_erp` = `id`;
ALTER TABLE  oc_product_option_group ADD UNIQUE ( id_erp );