<?php
$loader = require_once dirname(__DIR__).'/vendor/autoload.php';

$rabbitmq_config = include_once LOCAL_DIR_OPENCART.'/config/rabbitMQ.php';

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader([$loader, 'loadClass']);

use \Symfony\Component\Console\Application;

$application = new Application();
//данные для подключение в rabbitMQ
$ampqConfig =  new \LHGroup\From1cToWeb\ConnectionConfig(
    $rabbitmq_config["host"],
    $rabbitmq_config["port"],
    $rabbitmq_config["user"],
    $rabbitmq_config["pass"],
    $rabbitmq_config["vhost"]
);

$application->add(
    new \LHGroup\From1cToWeb\Command\QueueConsumeCommand(
        null,
        $ampqConfig
    )
);

$application->run();
