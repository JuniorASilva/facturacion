<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FacturacionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        \App::bind('facturacion',function(){
            return new \App\Extras\Facturacion;
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
