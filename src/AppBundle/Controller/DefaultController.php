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
        
//        var_dump($this->get('currency_exchange.rate_best')->getBestCurrencyRate("USD", "EUR"));
//        var_dump($this->get('currency_exchange.currency_rates')->getCurrencyRates("USD", "EUR"));
//        foreach ($this->get('currency_exchange.rates')->getCurrencyRates('EUR', "USD") as $provider) {
//            var_dump($provider);
//        }
//        var_dump($this->get('currency_exchange.currency_rates_google')->getCurrencyRate("EUR", 'USD'));
        
        return $this->render('base.html.twig');
    }
}
