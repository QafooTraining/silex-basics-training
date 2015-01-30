<?php

namespace Acme;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Abstract controller for modular Silex applications.
 *
 * Simplifies access to service locator and registration of routes.
 */
abstract class AcmeController implements ControllerProviderInterface
{
    /**
     * @var \Acme\AcmeApplication
     */
    protected $app;

    private $controllers;

    /**
     * implement this in your controller and call `registerRoute`
     * for each action.
     *
     * @return void
     */
    abstract protected function registerRoutes();

    /**
     * Register Routes for this controller.
     *
     * @param string $name
     * @param string $pattern
     * @param string $actionMethod
     * @return void
     */
    protected function registerRoute($name, $pattern, $actionMethod)
    {
        $this->controllers->match($pattern, array($this, $actionMethod))->bind($name);
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
