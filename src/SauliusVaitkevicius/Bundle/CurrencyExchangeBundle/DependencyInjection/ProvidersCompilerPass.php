<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ProvidersCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('exchange_rate_providers_collection')) {
            return;
        }

        $definition = $container->findDefinition(
            'exchange_rate_providers_collection'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'exchange.rate.provider'
        );
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'addProvider',
                array(new Reference($id))
            );
        }
    }
}