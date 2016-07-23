<?php

namespace SauliusVaitkevicius\Bundle\CurrencyExchangeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CurrencyRateBestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('currency:rate:best')
            ->setDescription('Shows the best currency exchange rate for given currency')
            ->addArgument(
                'from currency',
                InputArgument::OPTIONAL,
                'Who do you want to greet?')
            ->addArgument(
                'to currency'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currencies = $input->getArguments();
        if (sizeof($currencies) == 3) {
            $text = 'worx';
        } else {
            $text = 'please specify two arguments delimited with a space';
        }

        $output->writeln($text);
    }
}
