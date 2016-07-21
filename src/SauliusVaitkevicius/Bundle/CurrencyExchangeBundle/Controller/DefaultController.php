<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CurrencyExchangeBundle:Default:index.html.twig');
    }
}
