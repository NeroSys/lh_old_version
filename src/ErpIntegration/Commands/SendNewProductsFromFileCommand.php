<?php

namespace App\ErpIntegration\Commands;

use App\Entity\Order;
use App\Entity\OrderStatus;
use App\ErpIntegration\IntegrationEventNotify;
use LHGroup\From1cToWeb\ConnectionConfig;
use LHGroup\From1cToWeb\Notify\ConsoleNotify;
use LHGroup\From1cToWeb\Publisher;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use \App\ErpIntegration\Queue;

class SendNewProductsFromFileCommand extends Command
{
    protected $ampqConfig;

    public function __construct($name = null, ConnectionConfig $ampqConfig)
    {
        parent::__construct($name);
        $this->ampqConfig = $ampqConfig;
    }

    protected function configure()
    {
        $this->setName('integration:publish:new-products-from-file')
            ->setDescription('Sends new product to queue: ' . Queue\Product::QUEUE_NAME)->addOption(
                'file_location',
                null,
                InputOption::VALUE_REQUIRED,
                'Sends data to product queue from file',
                null
            )
            ->setHelp("Usage example: php bin/console.php ntegration:publish:new-products-from-file --file_location=/var/www/file.txt");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getOption('file_location');
        if (empty($file)) {
            throw new \Exception("Укажите файл с которого вытягивать сообщение");
        }
        elseif(!file_exists($file)){
            throw new \Exception("Файл $file не найден!");
        }
        $message = file_get_contents($file);
        $notifier = new ConsoleNotify($output);
        $publisher = new Publisher($this->ampqConfig, $notifier);
        $publisher->publishMessage(Queue\Product::QUEUE_NAME, $message);
    }

}