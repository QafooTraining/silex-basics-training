<?php

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;
use Silex\Provider;

$app = new Silex\Application();

$app['debug'] = true;

// Register additional plugins
$app->register(new Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));
if ($app['debug']) {
    $app->register(new Provider\WebProfilerServiceProvider(), array(
        'profiler.cache_dir' => sys_get_temp_dir() . '/profiler',
        'profiler.mount_prefix' => '/_profiler', // this is the default
    ));
}
$app->register(new Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/logs/app.log',
));
$app->register(new Provider\ServiceControllerServiceProvider());
$app->register(new Provider\UrlGeneratorServiceProvider());

// Register controllers
$app->mount('/', new \Acme\AcmeHelloController());
$app->mount('/', new \Acme\HelloController());

$app->run();
