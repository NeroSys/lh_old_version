<?php

namespace App\ErpIntegration;


use Apix\Log\Logger;
use LHGroup\From1cToWeb\Notify\NotifyInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IntegrationEventNotify implements NotifyInterface {

    protected $consoleOutput;
    protected $logger;

    public function __construct(
        OutputInterface $consoleOutput
        )
    {
        $this->consoleOutput = $consoleOutput;
        $this->logger = new Logger\File($this->generateFileLoggerLocation());
    }

    public function notifyError(\Throwable $exception){
        $this->consoleOutput->writeln("<error>".$exception->getMessage()."</error>");
        $this->logger->error($exception);
        //throw $exception;
    }

    public function notifyEvent(string $message, string $type = 'info', $event = null){
        $this->logger->info($message);

        switch ($type){
            case static::SUCCESS_MESSAGE:
                $message = "<info>".$message."</info>";
                break;
        }
        $this->consoleOutput->writeln($message);
    }

    protected function generateFileLoggerLocation(){
        return DIR_LOGS.'erp/'.date("YY.m.d").'.log';
    }
}