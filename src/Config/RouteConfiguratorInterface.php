<?php

namespace App\Config;

use Symfony\Component\Routing\RouteCollection;

// Interface para definir a criação de rotas
interface RouteConfiguratorInterface
{
    public function configureRoutes(RouteCollection $routes): void;
}