<?php

$loader = require_once dirname(__DIR__, 1).'/vendor/autoload.php';

require_once(dirname(__DIR__,1) . '/config/config.php');

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$hostname = DB_HOSTNAME;
$username = DB_USERNAME;
$password = DB_PASSWORD;
$database = DB_DATABASE;
$port = DB_PORT;

use App\Helper\ActiveRecord as ARInitializer;
ARInitializer::initializeActiveRecord($hostname, $username, $password, $database, $port);

$xmlMessage = '<?xml version="1.0" encoding="UTF-8" ?>
<root>
     <item>
        <id_erp>1234dsf</id_erp>
        <name>Носки Falke SuperMegaDeluxNoski</name>
        <brand>
            <id_erp>12123faff3</id_erp>
            <name>Falke</name>
        </brand>
        <type>wardrobe</type>
        <categories>
            <category>
                <id_erp>32323</id_erp>
                <name>Носки</name>
            </category>
            <category>
                <id_erp>a-3232323</id_erp>
                <name>Женские</name>
            </category>
        </categories>
        <manufacturer>
            <id_erp>12123</id_erp>
            <name>Falke Manufacturer</name>
        </manufacturer>
        <specifications>
            <!--Набор характеристик-начений, которые влияют на цену. Спецификация имеет артикул. -->
            <specification>
                <id_erp>1230sdf-fds</id_erp>
                <sku>1230sdf-fds</sku>
                <ean>1euudf-fds</ean>
                <characteristics>
                    <characteristic>
                        <id_erp>f1fcdsfdfsf</id_erp>
                        <name>Размер</name>
                        <value>
                            <id_erp>1f1f2cdsfdfsf</id_erp>
                            <name>34</name>
                        </value>
                    </characteristic>
                    <characteristic>
                        <id_erp>34f1f2cdsfdfsf</id_erp>
                        <name>Цвет</name>
                        <value>
                            <id_erp>534f1f2cdsfdfsf</id_erp>
                            <name>Желтый</name>
                        </value>
                    </characteristic>
                </characteristics>
                <price_base>350</price_base>
                <price_discount></price_discount>
                <price_discount_type></price_discount_type>
                <price_erp>350</price_erp>
                <prices>
                    <price>
                        <stock_erp_id>stock1</stock_erp_id>
                        <price_retail>
                            <!--Базовая цена для розницы-->
                            <price></price>
                            <discount></discount>
                            <discount_type></discount_type>
                        </price_retail>
                        <price_wholesale>
                            <!--Базовая цена для опта-->
                            <price></price>
                            <discount></discount>
                            <discount_type></discount_type>
                        </price_wholesale>
                        <quantity>20</quantity>
                    </price>
                    <price>
                        <stock_erp_id>stock2</stock_erp_id>
                        <price_retail>
                            <!--Базовая цена для розницы-->
                            <price></price>
                            <discount></discount>
                            <discount_type></discount_type>
                        </price_retail>
                        <price_wholesale>
                            <!--Базовая цена для опта-->
                            <price></price>
                            <discount></discount>
                            <discount_type></discount_type>
                        </price_wholesale>
                        <quantity>10</quantity>
                    </price>
                </prices>
                <images>
                    <image>
                        <path>ссылка</path>
                    </image>
                </images>
            </specification>
        </specifications>
        <properties>
            <!--Свойства номенклатуры, не влияющие на цену. Используются для фильтров-->
            <property>
                <id_erp>dfsdfs1</id_erp>
                <name>Ткань2</name>
                <value>
                    <id_erp>f1f2cdsfdfsf</id_erp>
                    <name>Шерсть</name>
                </value>
            </property>
            <property>
                <id_erp>32dfsdfs</id_erp>
                <name>Страна происхождения</name>
                <value>
                    <id_erp>f1f2cdsfdfsf</id_erp>
                    <name>Германия</name>
                </value>
            </property>
        </properties>
        <images>
            <image>
                <path>ссылка</path>
            </image>
        </images>
        <width></width>
        <height></height>
        <depth></depth>
        <weight></weight>
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