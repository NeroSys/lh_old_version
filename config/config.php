<?php

use M1\Vars\Vars;
$cache_key = "app_config";
$cache = \App\Engine\Cache\Memcached::getInstance();
$appConfig = $cache->get($cache_key);

if(!$appConfig){
    $appConfig = new Vars(
        [
            __DIR__ . '/web/basic.yml',
            __DIR__ . '/database/database.yml',
            __DIR__ . '/other/rabbit_mq.yml',
            __DIR__ . '/local.yml'
        ],
        [
            'cache' => false,
        ]
    );
    if (defined('WEBSITE_TYPE') && WEBSITE_TYPE !== 'FRONTEND') {
        require_once __DIR__ . '/web/config_backend.php';
    } else {
        require_once __DIR__ . '/web/config_frontend.php';
    }
    $cache->set($cache_key, $appConfig);
}

if(defined('WEBSITE_TYPE') && WEBSITE_TYPE === 'FRONTEND'){
    $application_config = 'catalog';
}

opencartConfigInit($appConfig);

function opencartConfigInit(Vars $config)
{
    foreach ($config->getContent() as $variable => $varValue) {
        define($variable, $varValue);
    }

}

