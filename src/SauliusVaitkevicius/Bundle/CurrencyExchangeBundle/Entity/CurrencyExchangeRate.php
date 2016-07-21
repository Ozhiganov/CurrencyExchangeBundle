<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Doctrine\ORM\Mapping\Entity
 * @Doctrine\ORM\Mapping\Table(name="currency_exchange_rate")
 */
class CurrencyExchangeRate
{
    /**
     * @ORM\Column(type="string")
     */
    private $provider;
    
    /**
     * @ORM\Column(type="string")
     */
    private $from;
    
    /**
     * @ORM\Column(type="string")
     */
    private $to;
    
    /**
     * @ORM\Column(type="string")
     */
    private $rate;
    
    public function __construct($provider, $from, $to, $rate)
    {
        $this->provider = $provider;
        $this->from = $from;
        $this->to = $to;
        $this->rate = $rate;
    }
}
