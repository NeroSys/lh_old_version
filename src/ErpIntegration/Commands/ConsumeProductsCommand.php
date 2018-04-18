<?php

namespace App\ErpIntegration\Commands;

use Apix\Log\Logger;
use App\ErpIntegration\IntegrationEventNotify;
use App\ErpIntegration\Processors\ProductProcessor;
use LHGroup\From1cToWeb\ConnectionConfig;
use LHGroup\From1cToWeb\Exceptions\SomeoneConsumingQueueException;
use LHGroup\From1cToWeb\Item\ProductItem;
use LHGroup\From1cToWeb\Item\Unserializer\XmlItemFactory;
use LHGroup\From1cToWeb\Item\Validator\ProductValidator;
use LHGroup\From1cToWeb\QueueConsumer;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use \App\ErpIntegration\Queue;
use Tymosh\ErpExchangeReader\Reader;

class ConsumeProductsCommand extends Command
{
    protected $ampqConfig;
    protected $cache;

    public function __construct(
        $name = null,
        ConnectionConfig $ampqConfig,
        CacheInterface $cache
    )
    {
        parent::__construct($name);
        $this->ampqConfig = $ampqConfig;
        $this->cache = $cache;
    }

    protected function configure()
    {
        $this->setName('integration:consume-products:start')
            ->setDescription('Run product consuming from queue: ' . Queue\Product::QUEUE_NAME);
             $this->addOption(
                 'permanent',
                 null,
                 InputOption::VALUE_OPTIONAL,
                 'Quit listening queue after '.QueueConsumer::QUEUE_TIMEOUT_SEC.' sec. 
                    If not set then true and it will listen permanently',
                 null
             );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $notifier = new IntegrationEventNotify(
            $output
         );

        $runForever = true;
        $permanent = $input->getOption('permanent');
        if ($permanent == "false") {
            $runForever = false;
            $notifier->notifyEvent("Queue listening will not be permanent. And will be finished after ".QueueConsumer::QUEUE_TIMEOUT_SEC." sec");
        }


        $itemEntity = ProductItem::class;

        $itemFactory = new XmlItemFactory(
            $itemEntity,
            $notifier,
            new ProductValidator(),
            new ProductProcessor()
        );

        $reader = new Reader\Xml($itemFactory);

        $queue = new Queue\Product(
            $reader,
            $this->cache
        );
        $queueConsumer = new QueueConsumer(
            $this->ampqConfig,
            $notifier,
            $queue
        );

        try {
            $queueConsumer->run($runForever);
        } catch (SomeoneConsumingQueueException $exception) {
            $notifier->notifyEvent("Try to close all connection for this queue and then rerun this command");
        }
    }

}