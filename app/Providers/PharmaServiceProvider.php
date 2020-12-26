<?php

namespace App\Providers;

use App\Helpers\Pharma;
use Illuminate\Support\ServiceProvider;

class PharmaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Pharma', function () {
            return new Pharma();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
