<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service;

use SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Entity\CurrencyExchangeRate;

interface CurrencyRatesInterface
{
    /**
     * @param string $from
     * @param string $to
     * @return CurrencyExchangeRate
     */
    public function queryCurrencyRate($from, $to): CurrencyExchangeRate;

    /**
     * @param string $from
     * @param string $to
     * @return CurrencyExchangeRate
     */
    public function getCurrencyRate($from, $to): CurrencyExchangeRate;
}
