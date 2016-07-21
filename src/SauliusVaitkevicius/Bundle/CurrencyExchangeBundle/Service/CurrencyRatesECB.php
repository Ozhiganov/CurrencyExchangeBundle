<?php
/**
 * Created by PhpStorm.
 * User: saulius.vaitkevicius
 * Date: 7/21/2016
 * Time: 11:25 PM
 */

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service;


class CurrencyRatesECB //implements CurrencyRatesInterface
{
    public function queryCurrencyRate()//: float
    {
        $url = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22USDEUR%22,%20%22USDJPY%22,%20%22USDISK%22)&env=store://datatables.org/alltableswithkeys";

        $ch = curl_init();
        $timeout = 0;
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt ($ch, CURLOPT_USERAGENT,
            "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $rawdata = curl_exec($ch);
        return $rawdata;
        curl_close($ch);
        $data = explode('bld>', $rawdata);
        $data = explode($to_Currency, $data[1]);

        return round($data[0], 2);
    }
}