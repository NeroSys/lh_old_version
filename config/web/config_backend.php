<?php
require_once __DIR__."/basic.php";

$appConfig->set('HTTP_SERVER', 'http://lh-test.loc/admin_it/');
$appConfig->set('HTTP_CATALOG', 'http://lh-test.loc/');

$appConfig->set('DIR_APPLICATION', $appConfig->get('DIR_OPENCART').'admin/');
$appConfig->set('LOCAL_DIR_APPLICATION', $appConfig->get('DIR_MODIFICATION').'admin/');

$appConfig->set('DIR_LANGUAGE', $appConfig->get('LOCAL_DIR_OPENCART').'language/admin/');
$appConfig->set('DIR_TEMPLATE', $appConfig->get('DIR_OPENCART').'/admin/view/template/');

$appConfig->set('LOCAL_DIR_TEMPLATE', $appConfig->get('DIR_MODIFICATION').'/admin/view/template/');

$appConfig->set('DIR_CATALOG', $appConfig->get('DIR_OPENCART').'/catalog/');