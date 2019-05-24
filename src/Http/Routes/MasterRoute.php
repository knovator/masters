<?php

namespace Knovators\Masters\Http\Routes;

use Knovators\Support\Routing\RouteRegistrar;

/**
 * Class     MasterRoute
 *
 * @package  Knovators\Masters\Http\Routes
 *
 * @codeCoverageIgnore
 */
class MasterRoute extends RouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Map all routes.
     */
    public function map()
    {
        $this->resource('masters', 'MasterController');
    }

}
