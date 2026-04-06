<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('jsonUtf8', function ($data, $status = 200, $headers = [], $options = 0) {
            $options |= JSON_UNESCAPED_UNICODE;
            return response()->json($data, $status, $headers, $options);
        });
    }
}
