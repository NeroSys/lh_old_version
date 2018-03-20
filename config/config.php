<?php
define('DEBUG', 0);
define('LOCAL_DIR_OPENCART', dirname(__DIR__)."/");
define('LOCAL_DIR_OPENCART_REWRITES', LOCAL_DIR_OPENCART.'rewrites/');

define('DIR_OPENCART', LOCAL_DIR_OPENCART.'vendor/opencart/opencart/upload/');
define('DIR_SYSTEM', DIR_OPENCART.'system/');
define('LOCAL_DIR_SYSTEM', LOCAL_DIR_OPENCART_REWRITES.'system/');

define('DIR_CONFIG', DIR_OPENCART.'system/config/');

define('PUBLIC_WEB', LOCAL_DIR_OPENCART.'/web/');
define('DIR_MODIFICATION', LOCAL_DIR_OPENCART.'rewrites/');

define('DIR_IMAGE', PUBLIC_WEB.'/image/');
define('DIR_CACHE', LOCAL_DIR_OPENCART.'/cache/');
define('DIR_DOWNLOAD', PUBLIC_WEB.'/storage/download/');
define('DIR_LOGS', LOCAL_DIR_OPENCART.'/logs/');

define('DIR_UPLOAD', PUBLIC_WEB.'/storage/upload/');

require_once(__DIR__."/database.php");