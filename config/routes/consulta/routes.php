<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->prefix('/consultas')
        ->add('create', '')
        ->controller([App\Controller\ConsultaController::class, 'create'])
        ->methods(['POST']);

    $routes->add('list', '')
        ->controller([App\Controller\ConsultaController::class, 'list'])
        ->methods(['GET']);
    
    $routes->add('update', '/{id}')
        ->controller([App\Controller\ConsultaController::class, 'update'])
        ->methods(['PUT'])
        ->requirements(['id' => '\d+']);

    $routes->add('delete', '/{id}')
        ->controller([App\Controller\ConsultaController::class, 'delete'])
        ->methods(['DELETE'])
        ->requirements(['id' => '\d+']);
};
