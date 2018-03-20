<?php

require_once(__DIR__ . '/../vendor/autoload.php');


// Version
define('VERSION', '2.2.0.0');

// Configuration
if (is_file(__DIR__.'/../config/config_frontend.php')) {
    require_once(__DIR__.'/../config/config_frontend.php');
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Application
require_once(DIR_SYSTEM . 'framework.php');
