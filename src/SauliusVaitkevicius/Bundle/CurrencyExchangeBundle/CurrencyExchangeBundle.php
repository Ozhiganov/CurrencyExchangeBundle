<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\DependencyInjection\ProvidersCompilerPass;


class CurrencyExchangeBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ProvidersCompilerPass());
    }
}
