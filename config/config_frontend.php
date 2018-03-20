<?php

require_once __DIR__."/config.php";

// HTTP
define('HTTP_SERVER', 'http://lh-test.loc/');

// HTTPS
define('HTTPS_SERVER', 'https://lh-test.loc/');
define('ASSETS_WEB_PATH', 'assets/');
// DIR
define('DIR_APPLICATION', DIR_OPENCART.'catalog/');
define('LOCAL_DIR_APPLICATION', DIR_MODIFICATION.'catalog/');

define('DIR_LANGUAGE', LOCAL_DIR_OPENCART.'language/');

define('DIR_TEMPLATE', DIR_OPENCART.'catalog/view/theme/');
define('LOCAL_DIR_TEMPLATE', LOCAL_DIR_OPENCART.'catalog/view/theme/');






$application_config = 'catalog';