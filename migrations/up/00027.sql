ALTER TABLE `oc_ocfilter_option` ADD `id_erp` VARCHAR (100) NOT NULL;
ALTER TABLE `oc_ocfilter_option` ADD `source` VARCHAR (20) NOT NULL;
ALTER TABLE `oc_ocfilter_option` ADD UNIQUE `filter_group_id_erp_index` (`id_erp` , `source`);

ALTER TABLE `oc_ocfilter_option_value` ADD `id_erp` VARCHAR (100) NOT NULL;
ALTER TABLE `oc_ocfilter_option_value` ADD `source` VARCHAR (20) NOT NULL;
ALTER TABLE `oc_ocfilter_option_value` ADD UNIQUE `filter_value_id_erp_index` (`id_erp` , `source`);

ALTER TABLE oc_ocfilter_option_description ADD CONSTRAINT FK_oc_filter_marker
FOREIGN KEY (option_id) REFERENCES oc_ocfilter_option(option_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;