#! /usr/bin/env php

<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

require 'vendor/autoload.php';

$app = new Application('Pearl Demo', '1.0');

$app->register('hello')
    ->setDescription('Offer a greeting to a given person')
    ->addArgument('name', InputArgument::REQUIRED, 'Your name')
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        $name = $input->getArgument('name');
        $message = 'Hello '.$name;

        $output->writeln("<info>{$message}</info>");
    });

$app->run();