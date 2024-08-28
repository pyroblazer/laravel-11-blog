<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class HttpClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Client::class, function ($app) {
            return new Client([
                'base_uri' => env('API_BASE_URL', 'http://localhost:8000/api/'), // Set your base URI
                'timeout'  => 2.0, // Set default timeout
            ]);
        });
    }
}
