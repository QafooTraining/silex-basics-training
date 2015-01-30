<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Acme\AcmeApplication();
$app['debug'] = true;

$app->run();
