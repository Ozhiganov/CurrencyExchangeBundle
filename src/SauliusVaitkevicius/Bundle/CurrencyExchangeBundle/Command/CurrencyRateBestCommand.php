<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Command;

use SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Entity\CurrencyExchangeRate;
use SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service\ExchangeRateProvidersCollection;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CurrencyRateBestCommand extends ContainerAwareCommand
{
    private $exchange_rate_providers_collection;
    
    public function __construct(ExchangeRateProvidersCollection $exchange_rate_providers_collection)
    {
        $this->exchange_rate_providers_collection = $exchange_rate_providers_collection;
        parent::__construct();
    }

    //used in getBestCurrencyRate to sort objects by provider currency exchange rates
    private function cmp(CurrencyExchangeRate $a, CurrencyExchangeRate $b)
    {
        if ($a->getRate() == $b->getRate()) {
            return 0;
        }
        return ($a->getRate() < $b->getRate()) ? -1 : 1;
    }

    public function getBestCurrencyRate($from, $to)
    {
        $providers_collection = $this->exchange_rate_providers_collection->getProviders();
        $providers = [];
        foreach ($providers_collection as $provider) {
            $providers[] = $provider->getCurrencyRate($from, $to);
        }
        usort($providers, array($this, "cmp"));
        return array_pop($providers);
    }

    protected function configure()
    {
        $this
            ->setName('currency:rate:best')
            ->setDescription('Shows the best currency exchange rate for given currency')
            ->addArgument(
                'from currency')
            ->addArgument(
                'to currency'
            );
    }

    //TODO write more validations to see if everything's going through smoothly (not more than 2 arguments, etc.)
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currencies = $input->getArguments();
        if ($currencies['from currency'] AND $currencies['to currency']) {
            $rateObj = $this->getBestCurrencyRate($currencies['from currency'], $currencies['to currency']);
            $rate = $rateObj->getRate();
            $provider = $rateObj->getProvider();
            $text = $provider . ' => ' . $rate;
        } else {
            $text = 'please specify two arguments delimited with a space';
        }
        $output->writeln($text);
    }
}
