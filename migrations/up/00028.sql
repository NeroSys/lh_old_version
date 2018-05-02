ALTER TABLE oc_ocfilter_option_value_description ADD CONSTRAINT FK_oc_filter_option_marker
FOREIGN KEY (value_id) REFERENCES oc_ocfilter_option_value(value_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE oc_ocfilter_option_value ADD CONSTRAINT FK_oc_ocfilter_option_marker_to_oc_filter_option
FOREIGN KEY (option_id) REFERENCES oc_ocfilter_option(option_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


ALTER TABLE oc_ocfilter_option_value_to_product ADD CONSTRAINT FK_oc_ocfilter_option_value_to_product_marker
FOREIGN KEY (product_id) REFERENCES oc_product(product_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;


ALTER TABLE oc_ocfilter_option_value_to_product ADD CONSTRAINT FK_oc_ocfilter_option_value_to_option_value_marker
FOREIGN KEY (value_id) REFERENCES oc_ocfilter_option_value(value_id)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
