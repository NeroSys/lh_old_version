<?php

namespace App\ContentGenerator\Commands;

use App\ContentGenerator\SeoGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class SeoGeneratorCommand extends Command
{

    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('site:generate:meta-tags')
			->setDescription('Generate meta tags for products')
			->addOption(
				'update',
				null,
				InputOption::VALUE_OPTIONAL,
				'Update existing data',
				null
			);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Run generate meta-tags");
        // TODO: You need implements cepeus/seo-generator package
		$output->writeln("Package cepeus/seo-generator not yet implemented");
    }
}
