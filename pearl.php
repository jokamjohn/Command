#! /usr/bin/env php

<?php

use Kagga\NewCommand;
use Symfony\Component\Console\Application;

require 'vendor/autoload.php';

$app = new Application('Pearl Demo', '1.0');

$app->add(new NewCommand(new GuzzleHttp\Client()));

$app->run();