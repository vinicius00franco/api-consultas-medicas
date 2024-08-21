<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\RouteCollection;
use App\Config;
use App\Config\EntityRouteConfigurator;

$routes = new RouteCollection();

// Instanciando os configuradores de rotas
$beneficiarioRoutes = new EntityRouteConfigurator(
    '/beneficiarios', 'App\Controller\BeneficiarioController');
$medicoRoutes = new EntityRouteConfigurator(
    '/medicos', 'App\Controller\MedicoController');
$hospitalRoutes = new EntityRouteConfigurator(
    '/hospitais', 'App\Controller\HospitalController');
$consultaRoutes = new EntityRouteConfigurator(
    '/consultas', 'App\Controller\ConsultaController');

// Aplicando as configurações
$beneficiarioRoutes->configureRoutes($routes);
$medicoRoutes->configureRoutes($routes);
$hospitalRoutes->configureRoutes($routes);
$consultaRoutes->configureRoutes($routes);

return $routes;

