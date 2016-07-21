<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service;


class CurrencyRatesECB //implements CurrencyRatesInterface
{
    public function queryCurrencyRate($from, $to)//: float
    {
        $url = 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20("' . $from . $to . '")&env=store://datatables.org/alltableswithkeys';

        $ch = curl_init();
        $timeout = 0;
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt ($ch, CURLOPT_USERAGENT,
            "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $rawdata = curl_exec($ch);
        curl_close($ch);
        return $rawdata;

        $pattern = "/0.([0-9])\w+/";
        if (preg_match($pattern, $rawdata, $matches)) {
            return $rawdata[0];
        } 

        return 0;
    }
}