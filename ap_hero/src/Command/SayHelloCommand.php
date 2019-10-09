<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SayHelloCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'say:hello';


	public function __construct() {
        parent::__construct();
	}

    protected function configure() {
		$this->setDescription('Say Hello.')
        	->setHelp('This command allows you to say hello on terminal...');
    }

    protected function execute( InputInterface $input, OutputInterface $output ) {
		$output->writeln('Hello World!');
	}

}
