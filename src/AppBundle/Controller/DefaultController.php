<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        //All of this is just for your ease of testing CurrencyExchangeBundle
        $providers_collection = $this->get('exchange_rate_providers_collection')->getProviders();
        foreach ($providers_collection as $provider) {
            var_dump($provider->getCurrencyRate("USD", "EUR")->getDatetimeUpdated());
        }
        
        echo $this->get('currency_exchange.currency_rates')->getBestCurrencyRate("USD", "EUR");
        
        var_dump($this->get('currency_exchange.currency_rates')->getCurrencyRates("USD", "EUR"));
        
        return $this->render('base.html.twig');
    }
}
