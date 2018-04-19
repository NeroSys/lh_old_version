ALTER TABLE oc_attribute_description ADD CONSTRAINT FK_attribute
FOREIGN KEY (attribute_id) REFERENCES oc_attribute(attribute_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `oc_attribute` ADD `id_erp` VARCHAR (100) NOT NULL;