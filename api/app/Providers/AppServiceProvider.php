<?php

namespace App\Providers;

use App\Services\Providers\BrasilApiProvider;
use App\Services\Providers\IbgeApiProvider;
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
        $this->app->bind(\App\Services\CitiesService::class, function ($app) {
            $providerName = env('CITIES_PROVIDER', 'brasilapi');
            if ($providerName === 'brasilapi') {
                $provider = new BrasilApiProvider();
            } else {
                $provider = new IbgeApiProvider();
            }
            $cache = $app->make('cache');
            return new \App\Services\CitiesService($provider, $cache);
        });
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
