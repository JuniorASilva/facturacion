<?php

namespace App\Providers;

use App\Services\Sunat;
use Illuminate\Support\ServiceProvider;

class SunatServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Sunat::class, function ($app) {
            return new Sunat();
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
