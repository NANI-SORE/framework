<?php


namespace Framework;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\RouteCollection;

class ReceiverRegisterRoutes
{
    /**
     * @var RouteCollection
     */
    private $routeCollection;

    /**
     * @var ContainerBuilder
     */
    private $containerBuilder;

    public function __construct(ContainerBuilder $containerBuilder)
    {
        $this->containerBuilder = $containerBuilder;
    }

    /**
     * @return RouteCollection
     */
    public function registerRoutes(): RouteCollection
    {
        $this->routeCollection = require  '../app/config/routing.php'; //__DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'routing.php';
        $this->containerBuilder->set('route_collection', $this->routeCollection);
        return $this->routeCollection;
    }
}
