<?php

declare(strict_types = 1);

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;

class Kernel
{
    /**
     * @var RouteCollection
     */
    protected $routeCollection;

    /**
     * @var ContainerBuilder
     */
    protected $containerBuilder;

    public function __construct(ContainerBuilder $containerBuilder)
    {
        $this->containerBuilder = $containerBuilder;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $configs = new \Framework\RegisterConfigs(new \Framework\ReceiverRegisterConfigs($this->containerBuilder));
        $configs->execute();
        $this->containerBuilder = $configs->containerBuilder;

        $routes = new \Framework\RegisterRoutes(new \Framework\ReceiverRegisterRoutes($this->containerBuilder));
        $routes->execute();
        $this->routeCollection = $routes->routeCollection;

        $process = new \Framework\Process($request, new \Framework\ReceiverProcess($this->routeCollection));
        $process->execute();

        return $process->Response;
    }
}
