<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('create', '/consultas')
        ->controller([App\Controller\ConsultaController::class, 'create'])
        ->methods(['POST']);

    $routes->add('list', '/consultas')
        ->controller([App\Controller\ConsultaController::class, 'list'])
        ->methods(['GET']);
    
    $routes->add('update', '/consultas/{id}')
        ->controller([App\Controller\ConsultaController::class, 'update'])
        ->methods(['PUT'])
        ->requirements(['id' => '\d+']);

    $routes->add('delete', '/consultas/{id}')
        ->controller([App\Controller\ConsultaController::class, 'delete'])
        ->methods(['DELETE'])
        ->requirements(['id' => '\d+']);
};

