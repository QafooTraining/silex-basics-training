<?php

namespace Acme;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class HelloController extends AcmeController
{
    public function registerRoutes()
    {
        $this->registerRoute('helloworld', '/hello-world', 'helloAction');
        $this->registerRoute('hello_twig', '/hello-twig', 'twigAction');
    }

    public function helloAction(Request $request)
    {
        return new Response('Hello World!');
    }

    public function twigAction(Request $request)
    {
        return $this->app->render('Hello/twig.html.twig');
    }
}
