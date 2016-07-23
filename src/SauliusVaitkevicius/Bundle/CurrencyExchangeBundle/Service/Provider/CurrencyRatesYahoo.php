<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service\Provider;

use SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service\CurrencyRates;
use SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service\CurrencyRatesInterface;
use Doctrine\ORM\EntityManager;
use SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Entity\CurrencyExchangeRate;

class CurrencyRatesYahoo implements CurrencyRatesInterface
{
    private $provider = 'Yahoo';
    private $currency_rates_service;
    
    public function __construct(CurrencyRates $currency_rates_service)
    {
        $this->currency_rates_service = $currency_rates_service;
    }

    public function queryCurrencyRate($from, $to): CurrencyExchangeRate
    {
        $url = 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20("' . $from . $to . '")&env=store://datatables.org/alltableswithkeys';

        $rawdata = $this->currency_rates_service->queryCurrencyRateData($url);
        
        $pattern = "/(0\.\d{4})/";
        preg_match($pattern, $rawdata, $matches);
        $rate = $matches[0];

        $currency_exchange_rate = new CurrencyExchangeRate($this->provider, $from, $to, $rate);

        return $currency_exchange_rate;
    }

    public function getCurrencyRate($from, $to): CurrencyExchangeRate
    {
        return $this->currency_rates_service->getCurrencyRate($this->provider, $from, $to);
    }
}