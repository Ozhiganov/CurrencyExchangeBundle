<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Service;

use Doctrine\ORM\EntityManager;

class CurrencyRates
{
    protected $repo;
    
    public function __construct(EntityManager $entityManager)
    {
        $this->repo = $entityManager->getRepository('CurrencyExchangeBundle:CurrencyExchangeRate');
    }

    //checks to see if it's been more than 3 hours since last currency exchange rate update
    public function checkCache()
    {
        
    }

    public function persist($provider, $from, $to, $rate):bool 
    {
        
    }

}