UPDATE oc_setting SET `value` = 1 WHERE `key` = 'config_api_id';

INSERT INTO `oc_api` (`api_id`, `name`, `key`, `status`, `date_added`, `date_modified`)
VALUES
	(1,'site','TB6itJLuiRhBU60U2zUajaexdGZSDszk8TOVnaDP65JbvQeYmCA3Tw33TQCFbrwolJ1zd0JeuQTO4PWONLAPqYXtNehj2Jt2HbIitZZ1NDN66uVuYYSTCx5UzdGAJdytvKYFYI5b88jsQnFajPsAlgwY4M6FO2sU2XpyQoOjcugbtL7d8NriJyf5RpmG2nSzlYRxbjpbdQwv0D4ojsNWgvreIu7z2hZFNXIg8hjkcZAJeCjWBkoIXgdlOPqxrDnU',1,'2018-04-17 07:33:49','2018-04-17 07:33:49');
