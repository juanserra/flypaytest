<?php

namespace App;

use App\Services\PaymentsService;
use Silex\Application;
use Carbon\Carbon;

class ServicesLoader
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * ServicesLoader constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Bind service classes into app container.
     */
    public function bindServicesIntoContainer()
    {
        $this->app['carbon'] = function () {
            return new Carbon();
        };

        $this->app['payments.service'] = function () {
            return new PaymentsService($this->app['orm.em'], $this->app['carbon']);
        };
    }
}
