<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service\Provider;

use SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service\CurrencyRates;
use SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service\CurrencyRatesInterface;
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
        
        $pattern = "/(\d\.\d{4})/";
        preg_match($pattern, $rawdata, $matches);
        $rate = $matches[0];

        $currency_exchange_rate = new CurrencyExchangeRate($this->provider, $from, $to, $rate);

        return $currency_exchange_rate;
    }

    public function getCurrencyRate($from, $to): CurrencyExchangeRate
    {
        $stored_rate = $this->currency_rates_service->isStored($this->provider, $from, $to);
        if ($stored_rate) {
            if ($this->currency_rates_service->isCached($stored_rate)) {
                return $stored_rate;
            } else {
                return $this->currency_rates_service->updateRate($stored_rate, $this->queryCurrencyRate($from, $to));
            }
        } else {
            return $this->currency_rates_service->persistNewRate($this->queryCurrencyRate($from, $to));
        }
    }
}
