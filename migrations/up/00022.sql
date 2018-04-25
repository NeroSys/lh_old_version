ALTER TABLE `oc_location` ADD `id_erp` VARCHAR (100) NOT NULL;
UPDATE `oc_location` SET `id_erp` = `location_id`;
ALTER TABLE `oc_location` ADD UNIQUE `oc_location_unique_key` (`id_erp`);