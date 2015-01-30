<?php

namespace Acme;

use Silex\Application;
use Silex\Provider;

class AcmeApplication extends Application
{
    public function run()
    {
        $this->registerProviders();
        $this->registerControllers();

        parent::run();
    }

    protected function registerControllers()
    {
        $this->mount('/', new \Acme\AcmeHelloController());
        $this->mount('/', new \Acme\HelloController());
    }

    protected function registerProviders()
    {
        $this->register(new Provider\TwigServiceProvider(), array(
            'twig.path' => __DIR__.'/../../views',
        ));
        if ($this['debug']) {
            $this->register(new Provider\WebProfilerServiceProvider(), array(
                'profiler.cache_dir' => sys_get_temp_dir() . '/profiler',
                'profiler.mount_prefix' => '/_profiler', // this is the default
            ));
        }
        $this->register(new Provider\MonologServiceProvider(), array(
            'monolog.logfile' => __DIR__.'/../../logs/app.log',
        ));
        $this->register(new Provider\ServiceControllerServiceProvider());
        $this->register(new Provider\UrlGeneratorServiceProvider());
    }
}
