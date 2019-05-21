<?php

namespace Knovators\Masters\Http\Routes;

use Knovators\Support\Routing\RouteRegistrar;

/**
 * Class MasterRoute
 *
 * @package  Knovators\Masters\Http\Routes
 *
 * @codeCoverageIgnore
 */
class MasterRoute extends RouteRegistrar
{
    /**
     * Map all routes.
     */
    public function map()
    {
        $this->group($this->adminRouteAttributes(), function () {
            $this->resource('masters', 'MasterController');

            $this->name('masters.')->group(function () {
                $this->name('partially.update')->put('masters/partiallyUpdate/{masters}', 'MasterController@partiallyUpdate');
                $this->name('childs.index')->get('sub-masters/list', 'MasterController@childMasters');
            });
        });


        $this->group($this->clientRouteAttributes(), function () {
            $this->get('list', 'MasterController@index');
        });


        $this->model('masters', $this->config('model'));
    }


    /**
     * @return mixed
     */
    public function adminRouteAttributes()
    {
        return $this->config('route.admin_attributes', []);
    }


    /**
     * @return mixed
     */
    public function clientRouteAttributes()
    {
        return $this->config('route.client_attributes', []);
    }

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
        return config("masters.$key", $default);
    }


}
