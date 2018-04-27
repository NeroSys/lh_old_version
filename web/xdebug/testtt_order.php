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
        <id>110000010??????</id>
        <shop_id>LH</shop_id>
        <warehouse>Guliver</warehouse>
        <date>20180326130101</date>
        <currency>грн</currency>
        <total_price>140.00</total_price>
        <delivery>Новая почта г. Киев отделение 135 Иванов Иван 0504652132</delivery>
        <payment>Наложенный платеж</payment>
        <comment>Нужен срочно</comment>
        <status>
            <id_erp>e343434w332</id_erp>
            <name>Новый</name>
        </status>
        <user>
            <Ид>100001 - если етсь</Ид>
            <name>Иванов Иван</name>
            <role>Покупатель</role>
        </user>
        <items>
            <item>
                <ean>482020202020201</ean>
                <name>Мишка</name>
                <price>1225.00</price>
                <quantity>1</quantity>
                <total_price>1225</total_price>
            </item>
        </items>
    </item>
</root>';

$newOrderStatus = \App\Entity\OrderStatus::first(array('conditions' => array('erp_id' => 'Новый')));

$newOrders = \App\Entity\Order::find('all', array('conditions' => array('order_status_id' => $newOrderStatus->order_status_id)));
//var_dump($newOrders);
foreach ($newOrders as $newOrder) {
    dump($newOrder->order_product);
}
exit();
$item = new \LHGroup\From1cToWeb\Item\OrderItem();
$item->setId("1");
$item->setShopId("LH");
$item->setWarehouse("Guliver");
$item->setDate("20180326130101");
$item->setCurrency("грн");
$item->setTotalPrice(140.00);
$item->setDelivery("Новая почта г. Киев отделение 135 Иванов Иван 0504652132");
$item->setPayment("Наложенный платеж");
$item->setComment("");
$status = new \LHGroup\From1cToWeb\Item\Order\Status();
$status->setName("Новый");
$status->setIdErp("213dfsdsf");
$item->setStatus($status);
$orderItem = new \LHGroup\From1cToWeb\Item\Order\Item();
$orderItem->setName("Мишка");
$orderItem->setEan("482020202020201");
$orderItem->setPrice(1225.00);
$orderItem->setQuantity(1);
$orderItem->setTotalPrice(1225);

$item->addItem($orderItem);



echo $item->toXML();




//$product = \App\Entity\Product::find(50);//
//var_dump($product->categories);