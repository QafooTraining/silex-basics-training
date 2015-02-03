<?php

namespace Acme\Hello;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Acme\AcmeController;

class HelloController extends AcmeController
{
    public function registerRoutes()
    {
        $this->registerRoute('helloworld', '/hello/{name}', 'helloAction');
        $this->registerRoute('hello_twig', '/hello-twig', 'twigAction');
    }

    public function helloAction($name, Request $request)
    {
        $string = $this->app['db']->fetchColumn(
            'SELECT CONCAT("Hello", ?)', array($name)
        );

        return new Response($string);
    }

    public function twigAction(Request $request)
    {
        return $this->app->render('Hello/twig.html.twig');
    }
}
