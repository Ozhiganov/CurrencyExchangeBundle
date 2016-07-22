<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service;

use SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Entity\CurrencyExchangeRate;

interface CurrencyRatesInterface
{
    /**
     * @param integer $from
     * @param integer $to
     * @return CurrencyExchangeRate
     */
    public function queryCurrencyRate($from, $to): CurrencyExchangeRate;
}

