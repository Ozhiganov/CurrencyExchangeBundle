<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service;


use Doctrine\ORM\EntityManager;
use SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Entity\CurrencyExchangeRate;

class CurrencyRatesYahoo implements CurrencyRatesInterface
{
    private $provider = 'Yahoo';
    private $em;
    private $repo;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository('CurrencyExchangeBundle:CurrencyExchangeRate');
    }

    //TODO perkelti visa logika i CurrencyRates servisa ir cia tik naudoti metodus is jo
    public function queryCurrencyRate($from, $to): CurrencyExchangeRate
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

        $pattern = "/(0\.\d{4})/";
        preg_match($pattern, $rawdata, $matches);
        $rate = $matches[0];

        $currency_exchange_rate = new CurrencyExchangeRate($this->provider, $from, $to, $rate);

        return $currency_exchange_rate;
    }

    public function getCurrencyRate($from, $to): CurrencyExchangeRate
    {
        $repo = $this->em->getRepository('CurrencyExchangeBundle:CurrencyExchangeRate');
        $saved_rate = $repo->find($this->provider);

        if ($saved_rate) {
            $diff = $saved_rate->getDatetimeUpdated()->diff(new \DateTime());
            if (($diff->h > 3) || ($diff->d > 0) || ($diff->m > 0) || ($diff->y > 0)) {
                $currency_exchange_rate = $this->queryCurrencyRate($from, $to);
                
                $saved_rate->setRate($currency_exchange_rate->getRate());
                $saved_rate->setDatetimeUpdated($currency_exchange_rate->getDatetimeUpdated());

                $this->em->flush();
                
                return $saved_rate;
            } else {
                return $saved_rate;
            }
        } else {
            $currency_exchange_rate = $this->queryCurrencyRate($from, $to);

            $this->em->persist($currency_exchange_rate);
            $this->em->flush();
            
            return $currency_exchange_rate;
        }
    }
}