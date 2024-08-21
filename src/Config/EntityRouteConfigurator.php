<?php

namespace App\Config;

use Symfony\Component\Routing\RouteCollection;

use Symfony\Component\Routing\Route;


class EntityRouteConfigurator implements RouteConfiguratorInterface
{
    private string $prefix;
    private string $controller;

    public function __construct(string $prefix, string $controller)
    {
        $this->prefix = $prefix;
        $this->controller = $controller;
    }

    public function configureRoutes(RouteCollection $routes): void
    {
        $routes->add($this->prefix . '_create', new Route($this->prefix, [
            '_controller' => $this->controller . '::create',
            'methods' => ['POST'],
        ]));

        $routes->add($this->prefix . '_list', new Route($this->prefix, [
            '_controller' => $this->controller . '::list',
            'methods' => ['GET'],
        ]));

        $routes->add($this->prefix . '_update', new Route($this->prefix . '/{id}', [
            '_controller' => $this->controller . '::update',
            'methods' => ['PUT'],
            'requirements' => ['id' => '\d+'],
        ]));

        $routes->add($this->prefix . '_delete', new Route($this->prefix . '/{id}', [
            '_controller' => $this->controller . '::delete',
            'methods' => ['DELETE'],
            'requirements' => ['id' => '\d+'],
        ]));
    }
}
