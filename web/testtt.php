<?php

$loader = require_once dirname(__DIR__, 1).'/vendor/autoload.php';

require_once(dirname(__DIR__,1) . '/config/config.php');

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$hostname = DB_HOSTNAME;
$username = DB_USERNAME;
$password = DB_PASSWORD;
$database = DB_DATABASE;
$port = DB_PORT;
\ActiveRecord\Config::initialize(function($cfg) use ($hostname, $username, $password, $database, $port)
{
    $cfg->set_model_directory(LOCAL_DIR_OPENCART.'/src/Entity');
    $cfg->set_connections(
        array(
            'development' => 'mysql://'.$username.':'.$password.'@'.$hostname.'/'.$database
        )
    );
});

$ampqConfig = new \LHGroup\From1cToWeb\ConnectionConfig(
    RABBIT_MQ_HOST,
    RABBIT_MQ_PORT,
    RABBIT_MQ_USER,
    RABBIT_MQ_PASSWORD,
    RABBIT_MQ_VHOST
);

$itemEntity = \LHGroup\From1cToWeb\Item\ProductItem::class;

$itemFactory = new \LHGroup\From1cToWeb\Item\Unserializer\XmlItemFactory(
    $itemEntity,
    new \App\ErpIntegration\IntegrationEventNotify($output),
    new \LHGroup\From1cToWeb\Item\Validator\ProductValidator(),
    new \App\ErpIntegration\Processors\ProductProcessor()
);

$reader = new \Tymosh\ErpExchangeReader\Reader\Xml($itemFactory);


$reader->processString($xmlMessage);

$product = \App\Entity\Product::find(50);
var_dump($product->categories);