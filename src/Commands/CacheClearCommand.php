<?php

namespace App\Commands;

use App\Engine\Cache\Memcached;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CacheClearCommand extends Command
{
    protected $cache;

    public function __construct($name = null, CacheInterface $cache)
    {
        parent::__construct($name);
        $this->cache = $cache;
    }

    protected function configure()
    {
        $this->setName('site:cache:clear')
            ->setDescription('Flushes site cache');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln("Flushing memcached...");
        $this->cache->clear();
        $output->writeln("<info>Cache cleared</info>");

    }
}