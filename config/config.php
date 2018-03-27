<?php

use M1\Vars\Vars;

$appConfig = new Vars(
    [
        __DIR__ . '/web/basic.yml',
        __DIR__ . '/database/database.yml',
        __DIR__ . '/local.yml'
    ],
    [
        'cache' => false,
    ]
);

switch (WEBSITE_TYPE) {
    case 'FRONTEND':
        require_once __DIR__ . '/web/config_frontend.php';
        break;
    default:
        require_once __DIR__ . '/web/config_backend.php';
}


opencartConfigInit($appConfig);

function opencartConfigInit(Vars $config)
{
    foreach ($config->getContent() as $variable => $varValue) {
        define($variable, $varValue);
    }

}