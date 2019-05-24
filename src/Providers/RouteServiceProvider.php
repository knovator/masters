<?php

namespace Knovators\Masters\Providers;

use Knovators\Masters\Http\Routes\MasterRoute;
use Knovators\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Class     RouteServiceProvider
 *
 * @package  Knovators\Masters\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get Route attributes
     *
     * @return array
     */
    public function routeAttributes()
    {
        return array_merge($this->config('attributes', []), [
            'namespace' => 'Knovators\\Masters\\Http\\Controllers',
        ]);
    }

    /**
     * Check if routes is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->config('enabled', false);
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        if ($this->isEnabled()) {
            $this->group($this->routeAttributes(), function () {
                MasterRoute::register();
            });
        }
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get config value by key
     *
     * @param string $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    private function config($key, $default = null)
    {
        /** @var  \Illuminate\Config\Repository $config */
        $config = $this->app->make('config');

        return $config->get("masters.route.$key", $default);
    }
}
