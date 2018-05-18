<?php
require_once __DIR__."/basic.php";

$appConfig->set('HTTP_SERVER',  $appConfig->get('CURRENT_HTTP_DOMAIN').'/admin_it/');
$appConfig->set('HTTPS_SERVER',  $appConfig->get('CURRENT_HTTPS_DOMAIN').'/admin_it/');
$appConfig->set('DIR_APPLICATION', $appConfig->get('DIR_OPENCART').'admin/');
$appConfig->set('LOCAL_DIR_APPLICATION', $appConfig->get('DIR_MODIFICATION').'admin/');

$appConfig->set('DIR_LANGUAGE', $appConfig->get('LOCAL_DIR_OPENCART').'language/admin/');
$appConfig->set('DIR_TEMPLATE', $appConfig->get('DIR_OPENCART').'/admin/view/template/');

$appConfig->set('LOCAL_DIR_TEMPLATE', $appConfig->get('DIR_MODIFICATION').'/admin/view/template/');

$appConfig->set('DIR_CATALOG', $appConfig->get('DIR_OPENCART').'/catalog/');
