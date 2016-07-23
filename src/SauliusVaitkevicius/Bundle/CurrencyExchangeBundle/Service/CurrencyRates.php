<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service;

use SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Entity\CurrencyExchangeRate;
use Doctrine\ORM\EntityManager;

class CurrencyRates 
{
    private $em;
    private $repo;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository('CurrencyExchangeBundle:CurrencyExchangeRate');
    }

    public function queryCurrencyRateData($url)
    {
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
    }

    //Checks DB cache before updating/storing data
    public function getCurrencyRate($provider, $from, $to): CurrencyExchangeRate
    {
        $repo = $this->em->getRepository('CurrencyExchangeBundle:CurrencyExchangeRate');
        $saved_rate = $repo->find($provider);

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