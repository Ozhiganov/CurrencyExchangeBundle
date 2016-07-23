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
        $yahoo = $this->get('currency_exchange.currency_rates_yahoo');
        var_dump($yahoo->getCurrencyRate("USD", "EUR")->getDatetimeUpdated());
        $tags = $this->get('exchange_rate_providers_collection');
        var_dump($tags);
        
        return $this->render('base.html.twig');
    }
}
