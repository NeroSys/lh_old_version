<?php

namespace App\ErpIntegration;


use LHGroup\From1cToWeb\Notify\NotifyInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IntegrationEventNotify implements NotifyInterface {

    protected $consoleOutput;

    public function __construct(OutputInterface $consoleOutput)
    {
        $this->consoleOutput = $consoleOutput;
    }

    public function notifyError(\Throwable $exception){
        $this->consoleOutput->writeln("<error>".$exception->getMessage()."</error>");
        throw $exception;
    }

    public function notifyEvent(string $message, string $type = 'info', $event = null){
        switch ($type){
            case static::SUCCESS_MESSAGE:
                $message = "<info>".$message."</info>";
                break;
        }
        $this->consoleOutput->writeln($message);
        echo $message."<br>";
    }
}