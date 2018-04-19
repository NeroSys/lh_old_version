UPDATE `oc_order_status` SET erp_id = `name`;
INSERT INTO `oc_order_status` SET `language_id` = 2, `name` = 'В обработке', `erp_id` = 'В обработке';