ALTER TABLE oc_option_value_description ADD CONSTRAINT FK_option_value
FOREIGN KEY (option_value_id) REFERENCES oc_option_value(option_value_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;