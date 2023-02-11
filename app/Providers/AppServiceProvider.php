<?php

namespace App\Providers;

use App\Services\Paystar\PaystarGateway;
use Illuminate\Support\Facades\URL;
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
        $this->app->singleton('paystar', PaystarGateway::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (parse_url(config('app.url'), PHP_URL_SCHEME) == 'https') {
            URL::forceScheme('https');
        }
    }
}
