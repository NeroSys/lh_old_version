<?php

require_once(__DIR__ . '/../../vendor/autoload.php');


// Version
define('VERSION', '2.2.0.0');

// Configuration
define('WEBSITE_TYPE', "BACKEND");
require_once(dirname(__DIR__,2) . '/config/config.php');

$application_config = 'admin';
// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Application
require_once(DIR_SYSTEM . 'framework.php');