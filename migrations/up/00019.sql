ALTER TABLE oc_product_option ADD CONSTRAINT FK_product_option_to_group
FOREIGN KEY (product_option_group) REFERENCES oc_product_option_group(id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;