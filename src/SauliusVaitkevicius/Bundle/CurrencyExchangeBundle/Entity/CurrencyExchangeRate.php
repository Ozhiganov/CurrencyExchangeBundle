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
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $provider;
    
    /**
     * @ORM\Column(type="string")
     */
    private $from_currency;
    
    /**
     * @ORM\Column(type="string")
     */
    private $to_currency;
    
    /**
     * @ORM\Column(type="string")
     */
    private $rate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetime_updated;

    /**
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    /**
     * @return \DateTime
     */
    public function getDatetimeUpdated()
    {
        return $this->datetime_updated;
    }

    /**
     * @param \DateTime $datetime_updated
     */
    public function setDatetimeUpdated($datetime_updated)
    {
        $this->datetime_updated = $datetime_updated;
    }

    /**
     * CurrencyExchangeRate constructor.
     * @param $provider
     * @param $from
     * @param $to
     * @param $rate
     */
    public function __construct($provider, $from, $to, $rate)
    {
        $this->provider = $provider;
        $this->from_currency = $from;
        $this->to_currency = $to;
        $this->rate = $rate;
        $this->datetime_updated = new \DateTime();
    }
}
