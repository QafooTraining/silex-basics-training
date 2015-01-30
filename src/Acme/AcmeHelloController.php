<?php

namespace Acme;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AcmeHelloController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $controllers->match('/hello', array($this, 'helloAction'))->bind('hello');

        return $controllers;
    }

    public function helloAction(Request $request)
    {
        return new Response('Hello World!');
    }
}
