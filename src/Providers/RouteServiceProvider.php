<?php

namespace Knovators\Masters\Providers;

use Illuminate\Support\Facades\Route;
use Knovators\Masters\Http\Routes\MasterRoute;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Class     RouteServiceProvider
 *
 * @package  Knovators\Masters\Providers
 */
class RouteServiceProvider extends ServiceProvider
{


    protected $namespace = 'Knovators\\Masters\\Http\\Controllers';


    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Define the routes for the application.
     */
    public function map() {
        Route::namespace($this->namespace)
             ->group(function () {
                 MasterRoute::register();
             });
    }


}
