<?php

namespace App\ErpIntegration\Commands;

use App\ErpIntegration\IntegrationEventNotify;
use App\ErpIntegration\Processors\ProductProcessor;
use LHGroup\From1cToWeb\ConnectionConfig;
use LHGroup\From1cToWeb\Exceptions\SomeoneConsumingQueueException;
use LHGroup\From1cToWeb\Item\ProductItem;
use LHGroup\From1cToWeb\Item\Unserializer\XmlItemFactory;
use LHGroup\From1cToWeb\Item\Validator\ProductValidator;
use LHGroup\From1cToWeb\QueueConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use \LHGroup\From1cToWeb\Queue;
use Tymosh\ErpExchangeReader\Reader;

class ConsumeProductsCommand extends Command
{
    protected $ampqConfig;

    public function __construct($name = null, ConnectionConfig $ampqConfig)
    {
        parent::__construct($name);
        $this->ampqConfig = $ampqConfig;
    }

    protected function configure()
    {
        $this->setName('integration:consume-products:start')
            ->setDescription('Run product consuming from queue: '.Queue\Product::QUEUE_NAME);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
         $notifier = new IntegrationEventNotify($output);
         $itemEntity = ProductItem::class;

        $itemFactory = new XmlItemFactory(
            $itemEntity,
            $notifier,
            new ProductValidator(),
            new ProductProcessor()
        );

        $reader = new Reader\Xml($itemFactory);

        $queue = new Queue\Product(
            $reader
        );
        $queueConsumer = new QueueConsumer(
            $this->ampqConfig,
            $notifier,
            $queue
        );

        try {
            $queueConsumer->run($runForever = true);
        }
        catch (SomeoneConsumingQueueException $exception){
            $output->writeln("You already consuming product queue in background.");
        }
    }

}