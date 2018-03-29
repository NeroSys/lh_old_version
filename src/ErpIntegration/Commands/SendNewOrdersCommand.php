<?php

namespace App\ErpIntegration\Commands;

use LHGroup\From1cToWeb\ConnectionConfig;
use LHGroup\From1cToWeb\Item\OrderItem;
use LHGroup\From1cToWeb\Notify\NotifyInterface;
use LHGroup\From1cToWeb\Publisher;

class SendNewOrdersCommand
{
    const NEW_ORDER_STATUS_NAME = 'Новый';
    const ERP_SENDED_STATUS_NAME = 'В обработке';

    protected $ampqConfig;

    public function __construct($name = null, ConnectionConfig $ampqConfig)
    {
        parent::__construct($name);
        $this->ampqConfig = $ampqConfig;
    }

    protected function configure()
    {
        $this->setName('integration:publish:new-orders')
            ->setDescription('Sends new orders to queue: '.Publisher\OrderPublisher::ORDERS_FROM_LH_TO_1C);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $notifier = new IntegrationEventNotify($output);
        $orderPublisher = new Publisher\OrderPublisher($this->ampqConfig, $notifier);

        $newOrders = [];

        foreach ($newOrders as $newOrder){
            $orderPublisher->sendOrder($newOrder);
        }
    }

}