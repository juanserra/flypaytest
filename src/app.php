<?php

use App\RoutesLoader;
use App\ServicesLoader;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

$app->register(new Silex\Provider\ServiceControllerServiceProvider());

// Load DB Provider
$app->register(new DoctrineServiceProvider(), [
    'db.options' => $app['db.options']
]);

// Load Doctrine ORM
$app->register(new DoctrineOrmServiceProvider, [
    'orm.em.options' => [
        'mappings' => [
            [
                'type' => 'annotation',
                'use_simple_annotation_reader' => false,
                'namespace' => 'App\Models',
                'path' => __DIR__.'/App/Models',
            ],
        ],
    ],
]);

// Load Symfony validator
$app->register(new ValidatorServiceProvider());

// Load services
$servicesLoader = new ServicesLoader($app);
$servicesLoader->bindServicesIntoContainer();

// Load routes
$routesLoader = new RoutesLoader($app);
$routesLoader->bindRoutesToControllers();

return $app;
