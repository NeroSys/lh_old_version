<?php

require_once __DIR__ . '/vendor/autoload.php';

require_once(dirname(__DIR__,1) . '/config/config.php');

$jobby = new \Jobby\Jobby();

/**
 * если есть больше 1 потребителя то скрипт выдаст сообщения об этом и все.
 */
$jobby->add('LoadProductFromErp', array(
    'command' => 'php bin/console integration:consume-products:start',
    'schedule' => '0 * * * *', //Каждый час
    'output' => DIR_LOGS.'command.log',
    'enabled' => true,
));

$jobby->add('sendNewOrdersToErp', array(
    'command' => 'ls',
    'schedule' => '*/2 * * * *', //Каждые 2 минуты
    'output' => DIR_LOGS.'command.log',
    'enabled' => true,
));

$jobby->run();
