<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service;

interface CurrencyRatesInterface
{
    /**
     * @param integer $from
     * @param integer $to
     * @return float
     */
    public function queryCurrencyRate($from, $to): float;
}

