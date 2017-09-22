<?php

use App\RoutesLoader;

$app->register(new Silex\Provider\ServiceControllerServiceProvider());

// Load routes
$routesLoader = new RoutesLoader($app);
$routesLoader->bindRoutesToControllers();

return $app;
