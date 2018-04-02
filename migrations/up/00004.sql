ALTER TABLE oc_product_option_value ADD CONSTRAINT FK_option_value_group
FOREIGN KEY (product_option_group) REFERENCES oc_product_option_group(id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;