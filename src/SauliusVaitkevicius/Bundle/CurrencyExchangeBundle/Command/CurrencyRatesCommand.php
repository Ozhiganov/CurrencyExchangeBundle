<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service\ExchangeRateProvidersCollection;

class CurrencyRatesCommand extends ContainerAwareCommand
{
    private $exchange_rate_providers_collection;

    public function __construct(ExchangeRateProvidersCollection $exchange_rate_providers_collection)
    {
        $this->exchange_rate_providers_collection = $exchange_rate_providers_collection;
        parent::__construct();
    }
    
    public function getCurrencyRates($from, $to)
    {
        $providers = [];
        $providers_collection = $this->exchange_rate_providers_collection->getProviders();
        foreach ($providers_collection as $provider) {
            $providers[] = $provider->getCurrencyRate($from, $to);
        }
        return $providers;
    }
    
    protected function configure()
    {
        $this
            ->setName('demo:greet')
            ->setDescription('Greet someone')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'Who do you want to greet?'
            )
            ->addOption(
                'yell',
                null,
                InputOption::VALUE_NONE,
                'If set, the task will yell in uppercase letters'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        if ($name) {
            $text = 'Hello '.$name;
        } else {
            $text = 'Hello';
        }

        if ($input->getOption('yell')) {
            $text = strtoupper($text);
        }

        $output->writeln($text);
    }
}
