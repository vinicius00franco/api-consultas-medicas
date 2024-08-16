<?php


use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    // consultas routes
    $routes->prefix('/consultas')
        ->add('update_consulta', '/{id}')
        ->controller([App\Controller\ConsultaController::class, 'update'])
        ->methods(['PUT'])
        ->requirements(['id' => '\d+']);

    $routes->add('delete_consulta', '/{id}')
        ->controller([App\Controller\ConsultaController::class, 'delete'])
        ->methods(['DELETE'])
        ->requirements(['id' => '\d+']);

    // consultas routes
};