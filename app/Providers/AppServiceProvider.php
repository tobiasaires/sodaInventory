<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Services\Contracts\SodaServiceInterface',
            'App\Services\SodaService',
        );

        $this->app->bind(
            'App\Repositories\Contracts\SodaRepositoryInterface',
            'App\Repositories\SodaRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
