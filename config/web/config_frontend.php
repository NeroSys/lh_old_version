<?php

require_once __DIR__."/basic.php";

$appConfig->set('ASSETS_WEB_PATH', 'assets/');
// DIR
$appConfig->set('DIR_APPLICATION', $appConfig->get('DIR_OPENCART').'catalog/');
$appConfig->set('LOCAL_DIR_APPLICATION', $appConfig->get('DIR_MODIFICATION').'catalog/');

$appConfig->set('DIR_LANGUAGE', $appConfig->get('LOCAL_DIR_OPENCART').'language/');

$appConfig->set('DIR_TEMPLATE', $appConfig->get('DIR_OPENCART').'catalog/view/theme/');
$appConfig->set('LOCAL_DIR_TEMPLATE', $appConfig->get('LOCAL_DIR_OPENCART').'catalog/view/theme/');
