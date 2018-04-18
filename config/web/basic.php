<?php
$appConfig->set('LOCAL_DIR_OPENCART', dirname(__DIR__,2)."/");
$appConfig->set('LOCAL_DIR_OPENCART_REWRITES', $appConfig->get('LOCAL_DIR_OPENCART').'rewrites/');

$appConfig->set('DIR_OPENCART', $appConfig->get('LOCAL_DIR_OPENCART').'vendor/opencart/opencart/upload/');
$appConfig->set('DIR_SYSTEM', $appConfig->get('DIR_OPENCART').'system/');
$appConfig->set('LOCAL_DIR_SYSTEM', $appConfig->get('LOCAL_DIR_OPENCART_REWRITES').'system/');

$appConfig->set('DIR_CONFIG', $appConfig->get('DIR_OPENCART').'system/config/');

$appConfig->set('PUBLIC_WEB', $appConfig->get('LOCAL_DIR_OPENCART').'web/');
$appConfig->set('DIR_MODIFICATION', $appConfig->get('LOCAL_DIR_OPENCART').'rewrites/');

$appConfig->set('DIR_IMAGE', $appConfig->get('PUBLIC_WEB').'image/');
$appConfig->set('DIR_CACHE', $appConfig->get('LOCAL_DIR_OPENCART').'/cache/');
$appConfig->set('DIR_DOWNLOAD', $appConfig->get('PUBLIC_WEB').'/storage/download/');
$appConfig->set('DIR_LOGS', $appConfig->get('LOCAL_DIR_OPENCART').'logs/');

$appConfig->set('DIR_UPLOAD', $appConfig->get('PUBLIC_WEB').'/storage/upload/');

$appConfig->set('HTTP_CATALOG', $appConfig->get('CURRENT_HTTP_DOMAIN'));
$appConfig->set('HTTP_SERVER',  $appConfig->get('CURRENT_HTTP_DOMAIN'));
$appConfig->set('HTTPS_SERVER',  $appConfig->get('CURRENT_HTTPS_DOMAIN'));