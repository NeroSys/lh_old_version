ALTER TABLE `oc_filter_group` ADD `id_erp` VARCHAR (100) NOT NULL;
ALTER TABLE `oc_filter_group` ADD `source` VARCHAR (20) NOT NULL;
ALTER TABLE `oc_filter_group` ADD UNIQUE `filter_group_id_erp_index` (`id_erp` , `source`);

ALTER TABLE `oc_filter` ADD `id_erp` VARCHAR (100) NOT NULL;
ALTER TABLE `oc_filter` ADD `source` VARCHAR (20) NOT NULL;
ALTER TABLE `oc_filter` ADD UNIQUE `filter_value_id_erp_index` (`id_erp` , `source`);

ALTER TABLE oc_filter_description ADD CONSTRAINT FK_filter
FOREIGN KEY (filter_id) REFERENCES oc_filter(filter_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE oc_filter_group_description ADD CONSTRAINT FK_filter_group
FOREIGN KEY (filter_group_id) REFERENCES oc_filter_group(filter_group_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE oc_filter ADD CONSTRAINT FK_filter_group_to_filter
FOREIGN KEY (filter_group_id) REFERENCES oc_filter_group(filter_group_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;