<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/redirects.php')) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/redirects.php';
}

require_once(__DIR__ . '/../vendor/autoload.php');

// Version
define('VERSION', '2.2.0.0');

// Configuration
define('WEBSITE_TYPE', "FRONTEND");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(dirname(__DIR__,1) . '/config/config.php');


// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Application
require_once(DIR_SYSTEM . 'framework.php');
