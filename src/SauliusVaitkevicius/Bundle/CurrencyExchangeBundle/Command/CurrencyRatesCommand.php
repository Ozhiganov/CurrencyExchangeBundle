<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
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
            ->setName('currency:rates')
            ->setDescription('get currency rates for given currencies')
            ->addArgument(
                'from currency')
            ->addArgument(
                'to currency');
    }

    //TODO write more validations to see if everything's going through smoothly (not more than 2 arguments, etc.)
    //TODO draw a better table :D 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currencies = $input->getArguments();
        if ($currencies['from currency'] AND $currencies['to currency']) {
            $providers = $this->getCurrencyRates($currencies['from currency'], $currencies['to currency']);
            $text = ''; 
            foreach ($providers as $provider) {
                $rate = $provider->getRate();
                $provider_name = $provider->getProvider();
                $text .= "\n--------------------";
                $text .= "\n| " . $provider_name . " | " . $rate . " |";
            }
            $text.= "\n--------------------";
        } else {
            $text = 'please specify two arguments delimited with a space';
        }
        $output->writeln($text);
    }
}
