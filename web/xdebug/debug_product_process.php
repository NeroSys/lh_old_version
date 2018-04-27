<?php

$loader = require_once dirname(__DIR__, 2).'/vendor/autoload.php';

require_once(dirname(__DIR__,2) . '/config/config.php');

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$hostname = DB_HOSTNAME;
$username = DB_USERNAME;
$password = DB_PASSWORD;
$database = DB_DATABASE;
$port = DB_PORT;

use App\Helper\ActiveRecord as ARInitializer;
ARInitializer::initializeActiveRecord($hostname, $username, $password, $database, $port);

$xmlMessage = '<?xml version="1.0" encoding="UTF-8"?>
<root>
    <item>
        <id_erp>ccd7b56b-e46d-11e6-80d1-005056922691</id_erp>
        <name>Топ, Валенсія</name>
        <sku>072211</sku>
        <brand>
            <id_erp>598d098d-3c8d-11e8-810d-005056922691</id_erp>
            <name>Hanro</name>
        </brand>
        <type>wardrobe</type>
        <categories>
            <category>
                <id_erp>fd726f93-42d9-11e8-810e-005056922691</id_erp>
                <name>Hanro</name>
                <parent>0</parent>
            </category>
            <category>
                <id_erp>589fd3ee-43ce-11e8-810e-005056922691</id_erp>
                <name>Women</name>
                <parent>fd726f93-42d9-11e8-810e-005056922691</parent>
            </category>
            <category>
                <id_erp>05e5d653-3c8d-11e8-810d-005056922691</id_erp>
                <name>Спідня білизна</name>
                <parent>589fd3ee-43ce-11e8-810e-005056922691</parent>
            </category>
            <category>
                <id_erp>05e5d69d-3c8d-11e8-810d-005056922691</id_erp>
                <name>Топ</name>
                <parent>05e5d653-3c8d-11e8-810d-005056922691</parent>
            </category>
        </categories>
        <manufacturer>
            <id_erp>7d67ffa2-3c8d-11e8-810d-005056922691</id_erp>
            <name>HANRO Inernational GmbH</name>
        </manufacturer>
        <specifications>
            <specification>
                <id_erp>ccd7b56e-e46d-11e6-80d1-005056922691</id_erp>
                <name>Код: 1513; Розмір: L; Колір: світло-блакитний; Стать: жіноча</name>
                <ean>888721151917</ean>
                <images/>
                <characteristics>
                    <characteristic>
                        <id_erp>5c545a78-ba1d-4a05-b868-20f30bb99942</id_erp>
                        <name>Размер</name>
                        <value>
                            <id_erp>83603b72-3c8d-11e8-810d-005056922691</id_erp>
                            <name>L</name>
                        </value>
                    </characteristic>
                    <characteristic>
                        <id_erp>2f96b00a-d60f-4d11-ba7e-83f5d736f2c0</id_erp>
                        <name>Цвет</name>
                        <value>
                            <id_erp>4d9a2e80-3c8d-11e8-810d-005056922691</id_erp>
                            <name>світло-блакитний</name>
                        </value>
                    </characteristic>
                </characteristics>
                <price_base>4150</price_base>
                <price_discount/>
                <price_discount_type/>
                <price_erp>4150</price_erp>
                <prices/>
            </specification>
        </specifications>
        <properties>
            <property>
                <id_erp>bdf3387f-1297-11e6-80d7-00155d66a124</id_erp>
                <name>Пол</name>
                <value>
                    <id_erp>977ec2f0-2174-11e6-80d9-00155d66a124</id_erp>
                    <name>жіноча</name>
                </value>
            </property>
            <property>
                <id_erp>7782d44d-d974-462a-946e-1f7185f0180b</id_erp>
                <name>Колекция</name>
                <value>
                    <id_erp>1dcc146b-3c8d-11e8-810d-005056922691</id_erp>
                    <name>Trend SS17</name>
                </value>
            </property>
            <property>
                <id_erp>cde9d5a5-304c-4f0b-a3e5-0506ac7b130f</id_erp>
                <name>Материал</name>
                <value>
                    <id_erp>2fb9d7cb-3c8d-11e8-810d-005056922691</id_erp>
                    <name>100% бавовна</name>
                </value>
            </property>
            <property>
                <id_erp>873a2229-3399-11e6-80d9-00155d66a124</id_erp>
                <name>Серия</name>
                <value>
                    <id_erp>17d17664-3c8d-11e8-810d-005056922691</id_erp>
                    <name>Valencia</name>
                </value>
            </property>
            <property>
                <id_erp>0bbc5306-3f19-11e8-810d-005056922691</id_erp>
                <name>Сезон</name>
                <value>
                    <id_erp>75b487dc-3f20-11e8-810d-005056922691</id_erp>
                    <name>SS</name>
                </value>
            </property>
            <property>
                <id_erp>f57f8df2-71d1-42d1-a44c-dc126a575625</id_erp>
                <name>Страна происхождения</name>
                <value>
                    <id_erp>5f87a95b-3c8d-11e8-810d-005056922691</id_erp>
                    <name>Португалія</name>
                </value>
            </property>
        </properties>
        <images>
            <image>
                <path>Hanro/UTP003959_20010101100000.jpg</path>
            </image>
        </images>
        <width/>
        <height/>
        <depth/>
        <weight/>
    </item>
</root>';

$itemEntity = \LHGroup\From1cToWeb\Item\ProductItem::class;
$output = new Symfony\Component\Console\Output\NullOutput();

$itemFactory = new \LHGroup\From1cToWeb\Item\Unserializer\XmlItemFactory(
    $itemEntity,
    new \App\ErpIntegration\IntegrationEventNotify($output),
    new \LHGroup\From1cToWeb\Item\Validator\ProductValidator(),
    new \App\ErpIntegration\Processors\ProductProcessor()
);

$reader = new \Tymosh\ErpExchangeReader\Reader\Xml($itemFactory);


$reader->processString($xmlMessage);



//$product = \App\Entity\Product::find(50);//
//var_dump($product->categories);