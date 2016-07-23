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

    public function isStored($provider, $from, $to)
    {
        $query = $this->em->createQuery("SELECT r FROM CurrencyExchangeBundle:CurrencyExchangeRate r WHERE r.provider = :provider AND r.from_currency = :from AND r.to_currency = :to");
        $query->setParameters(['provider' => $provider, 'from' => $from, 'to' => $to]);
        if ($query->getResult()) {
            return $query->getResult()[0];
        }
        return false;
    }
    
    public function isCached(CurrencyExchangeRate $rate)
    {
        $diff = $rate->getDatetimeUpdated()->diff(new \DateTime());
        if (($diff->h > 3) || ($diff->d > 0) || ($diff->m > 0) || ($diff->y > 0)) {
            return false;
        }
        return true;
    }

    public function updateRate(CurrencyExchangeRate $old_rate, CurrencyExchangeRate $new_rate)
    {
        $old_rate->setRate($new_rate->getRate());
        $old_rate->setDatetimeUpdated($new_rate->getDatetimeUpdated());
        $this->em->flush();
        
        return $old_rate;
    }
    
    public function persistNewRate(CurrencyExchangeRate $rate)
    {
        $this->em->persist($rate);
        $this->em->flush();
         return $rate;
    }

    public function getBestCurrencyRate($from, $to)
    {
        $query = $this->em->createQuery("SELECT r FROM CurrencyExchangeRate r WHERE r.from_currency = $from AND r.to_currency = $to ORDER BY r.rate");
        $rates = $query->getResult();
        return $rates;
    }
}