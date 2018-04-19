<?php

namespace App\ErpIntegration\Commands;

use App\Entity\Order;
use App\Entity\OrderStatus;
use App\ErpIntegration\IntegrationEventNotify;
use LHGroup\From1cToWeb\ConnectionConfig;
use LHGroup\From1cToWeb\Publisher;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendNewOrdersCommand extends Command
{
    const NEW_ORDER_STATUS_ID = 'Новый';
    const ERP_SENDED_STATUS_ID = 'В обработке';

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

        $newOrderStatus = OrderStatus::first(array('conditions' => array('erp_id' => self::NEW_ORDER_STATUS_ID)));
        $sendedOrderStatus = OrderStatus::first(array('conditions' => array('erp_id' => self::ERP_SENDED_STATUS_ID)));

        $newOrders = Order::find('all', array('conditions' => array('order_status_id' => $newOrderStatus->order_status_id)));
        if(empty($newOrders)){
            $notifier->notifyEvent("No new orders was found", IntegrationEventNotify::SUCCESS_MESSAGE);
            return;
        }
        else{
            $notifier->notifyEvent(count($newOrders)." new orders was found, processing..", IntegrationEventNotify::SUCCESS_MESSAGE);
        }

        foreach ($newOrders as $newOrder){

            $item = new \LHGroup\From1cToWeb\Item\OrderItem();
            $item->setId($newOrder->id);
            $item->setShopId("LH");
            $item->setWarehouse("Guliver");
            $item->setDate($newOrder->date_added);
            $item->setCurrency("грн");
            $item->setTotalPrice($newOrder->total);
            $item->setDelivery($newOrder->shipping_method.' '.$newOrder->shipping_address_1.' '.$newOrder->shipping_city);
            $item->setPayment($newOrder->payment_method);
            $item->setComment($newOrder->comment);

            $status = new \LHGroup\From1cToWeb\Item\Order\Status();
            $status->setName($newOrderStatus->name);
            $status->setIdErp($newOrderStatus->erp_id);
            $item->setStatus($status);

            $user = new \LHGroup\From1cToWeb\Item\Order\User();
            $user->setName($newOrderStatus->firstname.' '.$newOrderStatus->lastname);
            $user->setEmail($newOrderStatus->email);
            $user->setPhone($newOrderStatus->telephone);
            $user->setRole('Покупатель');
            $user->setId($newOrderStatus->customer_id);
            $item->setUser($user);


            foreach ($newOrder->order_product as $orderedProduct){
                $orderItem = new \LHGroup\From1cToWeb\Item\Order\Item();
                $orderItem->setName($orderedProduct->name);
                $orderItem->setEan($orderedProduct->ean);
                $orderItem->setPrice($orderedProduct->price);
                $orderItem->setQuantity($orderedProduct->quantity);
                $orderItem->setTotalPrice($orderedProduct->price * $orderedProduct->quantity);

                $item->addItem($orderItem);
            }

            try {
                $orderPublisher->sendOrder($item);

                $newOrder->order_status_id = $sendedOrderStatus->order_status_id;
                $newOrder->save();
            }
            catch (\Throwable $exception){
                throw $exception;
            }
        }
    }

}