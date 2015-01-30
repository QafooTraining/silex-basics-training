<?php

namespace Acme;

use Silex\Application;
use Silex\Provider;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AcmeApplication extends Application
{
    /**
     * Add new controllers in this method.
     */
    private function registerControllers()
    {
        $this->mount('/', new \Acme\Hello\HelloController());
    }

    use Application\TwigTrait;
    use Application\UrlGeneratorTrait;
    use Application\MonologTrait;
    use Application\TranslationTrait;

    /**
     * INI settings from config/config.ini
     *
     * @var array
     */
    private $config = array();

    public function __construct(array $values = array())
    {
        parent::__construct($values);

        $this->loadConfiguration();
        $this->registerProviders();
        $this->registerControllers();

        $this->before(function(Request $request, Application $app) {
            // Implement Session checks here!!!
            if ($request->getPathInfo() !== "/login") {
                $user = $app['session']->get('user');

                if (false) {
                    return new RedirectResponse('/login');
                }
            }
        });
    }

    private function loadConfiguration()
    {
        $configFile = __DIR__ . '/../../config/config.ini';

        if(!file_exists($configFile)) {
            die('Configuration file is missing. Cannot run application. Copy config/config.ini.dist to config/config.ini and adjust values.');
        }

        $this->config = parse_ini_file($configFile);
        $this['debug'] = (bool)$this->config['debug'];
    }

    private function registerProviders()
    {
        $this->register(new Provider\TwigServiceProvider(), array(
            'twig.path' => __DIR__.'/../../views',
        ));
        if ($this['debug']) {
            $this->register(new Provider\WebProfilerServiceProvider(), array(
                'profiler.cache_dir' => sys_get_temp_dir() . '/profiler',
                'profiler.mount_prefix' => '/_profiler', // this is the default
            ));
            $this->register(new \Sorien\Provider\DoctrineProfilerServiceProvider());
        }
        $this->register(new Provider\MonologServiceProvider(), array(
            'monolog.logfile' => __DIR__.'/../../logs/app.log',
        ));
        $this->register(new Provider\ServiceControllerServiceProvider());
        $this->register(new Provider\UrlGeneratorServiceProvider());
        $this->register(new Provider\SessionServiceProvider());

        $this->register(new Provider\TranslationServiceProvider(), array(
            'locale_fallbacks' => array('de'),
        ));

        $this['translator'] = $this->share($this->extend('translator', function($translator, $app) {
            // TODO: Add database translator
            return $translator;
        }));

        $this->register(new Provider\DoctrineServiceProvider(), array(
            'db.options' => array(
                'driver'   => 'mysqli',
                'dbname'   => $this->config['database.name'],
                'user'     => $this->config['database.user'],
                'password' => $this->config['database.password'],
                'charset'  => 'UTF8',
            ),
        ));
    }
}
