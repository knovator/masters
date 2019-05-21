<?php

namespace Knovators\Masters;

use Knovators\Support\PackageServiceProvider;

class MasterServiceProvider extends PackageServiceProvider
{
    /* -----------------------------------------------------------------
    |  Properties
    | -----------------------------------------------------------------
    */

    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'masters';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the service provider.
     */
    public function register()
    {
        parent::register();

        $this->registerConfig();

        $this->registerProviders([
            Providers\RouteServiceProvider::class,
        ]);
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        parent::boot();
        $this->publishConfig();
        $this->loadMigrations();
        $this->publishTranslations();
    }


}
