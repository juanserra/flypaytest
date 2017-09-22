<?php

namespace App;

use App\Controllers\PaymentsController;
use Silex\Application;

class RoutesLoader
{
    /**
     * @var Application
     */
    private $app;

    /**
     * RoutesLoader constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->instantiateControllers();
    }

    /**
     * Add controller instances into app container.
     */
    private function instantiateControllers()
    {
        $this->app['payments.controller'] = function () {
            return new PaymentsController($this->app['payments.service']);
        };
    }

    /**
     * Bind routes into app container.
     */
    public function bindRoutesToControllers()
    {
        $this->app->get('/api/hello', 'payments.controller:hello');
        $this->app->get('/api/payments', 'payments.controller:get');
        $this->app->post('/api/payments', 'payments.controller:create');
    }
}
