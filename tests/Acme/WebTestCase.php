<?php

namespace Acme;

class WebTestCase extends \Silex\WebTestCase
{
    public function createApplication()
    {
        $app = new \Acme\AcmeApplication();
        $app['debug'] = true;
        $app['exception_handler']->disable();
        $app['session.test'] = true;
        $app->boot();

        return $app;
    }
}
