<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service;


class ExchangeRateProvidersCollection
{
    private $providers;

    public function __construct()
    {
        $this->providers = [];
    }

    public function addProvider(CurrencyRatesInterface $provider)
    {
        $this->providers[] = $provider;   
    }

    public function getProviders()
    {
        return $this->providers;
    }
}