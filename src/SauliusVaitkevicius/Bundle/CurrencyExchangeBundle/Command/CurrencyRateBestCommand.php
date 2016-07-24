<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Command;

use SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service\ExchangeRateProvidersCollection;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CurrencyRateBestCommand extends ContainerAwareCommand
{
    private $exchange_rate_providers_collection;
    
    public function __construct(ExchangeRateProvidersCollection $exchange_rate_providers_collection)
    {
        $this->exchange_rate_providers_collection = $exchange_rate_providers_collection;
        parent::__construct();
    }

    public function getBestCurrencyRate($from, $to)
    {
        $providers_collection = $this->exchange_rate_providers_collection->getProviders();
        return $providers_collection[0]->getCurrencyRate($from, $to);
    }

    protected function configure()
    {
        $this
            ->setName('currency:rate:best')
            ->setDescription('Shows the best currency exchange rate for given currency')
            ->addArgument(
                'from currency',
                InputArgument::OPTIONAL,
                'Who do you want to greet?')
            ->addArgument(
                'to currency'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currencies = $input->getArguments();
        if (sizeof($currencies) == 3) {
            $text = 'worx';
        } else {
            $text = 'please specify two arguments delimited with a space';
        }

        $output->writeln($this->getBestCurrencyRate($currencies[1], $currencies[2]));
    }
}
