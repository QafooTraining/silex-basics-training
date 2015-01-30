<?php

namespace Acme;

use Silex\Application;
use Silex\ControllerProviderInterface;

abstract class AcmeController implements ControllerProviderInterface
{
    private $app;
    private $controllers;

    abstract protected function registerRoutes();

    protected function registerRoute($name, $pattern, $action)
    {
        $this->controllers->match($pattern, array($this, $action))->bind($name);
    }

    final public function connect(Application $app)
    {
        $this->app = $app;

        $this->controllers = $app['controllers_factory'];
        $this->registerRoutes();

        // cleanup state
        $controllers = $this->controllers;
        $this->controllers = null;

        return $controllers;
    }
}
