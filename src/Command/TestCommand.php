<?php
/**
 * Created by Evis Bregu <evis.bregu@gmail.com>.
 * Date: 12/21/17
 * Time: 3:02 PM
 */

namespace App\Command;


use App\Log\LoggerFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var bool|\Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * TestCommand constructor.
     *
     * @param array $config
     * @param string|null $name
     *
     * @throws \Exception
     */
    public function __construct(array $config, string $name = null)
    {
        $this->config = $config;
        $this->logger = LoggerFactory::create($this->config['log']);

        parent::__construct($name);

    }


    protected function configure()
    {
        $this->setName('app:test')
            ->setDescription('Test Command');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Hello World!");
    }
}