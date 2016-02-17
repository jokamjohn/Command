#! /usr/bin/env php

<?php

use Kagga\NewCommand;
use Kagga\RenderTabular;
use Symfony\Component\Console\Application;

require 'vendor/autoload.php';

$app = new Application('Pearl Demo', '1.0');

$app->add(new NewCommand(new GuzzleHttp\Client()));

$app->add(new RenderTabular());

$app->run();