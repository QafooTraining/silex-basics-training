<?php

namespace Acme;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class HelloController extends AcmeController
{
    public function registerRoutes()
    {
        $this->registerRoute('hello2', '/hello2', 'helloAction');
    }

    public function helloAction(Request $request)
    {
        return new Response('Hello World 2!');
    }
}
