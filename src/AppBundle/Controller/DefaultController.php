<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Controller\DefaultController as CurrencyCtrl;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        //All of this is just for your ease of testing CurrencyExchangeBundle
        CurrencyCtrl::echoDu();
        return $this->render('base.html.twig');
    }
}
