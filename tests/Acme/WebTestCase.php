<?php

namespace Acme;

class WebTestCase extends \Silex\WebTestCase
{
    public function createApplication()
    {
        $app = new \Acme\AcmeApplication();
        $app['debug'] = true;
        $app['exception_handler']->disable();
        $app->boot();

        return $app;
    }
}
