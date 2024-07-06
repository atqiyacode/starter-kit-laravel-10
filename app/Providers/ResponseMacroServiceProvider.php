<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Response::macro('jsonDownload', function ($data, $filename) {
            $json = json_encode($data, JSON_PRETTY_PRINT);
            $headers = [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename=' . $filename,
            ];

            return response()->make($json, 200, $headers);
        });
    }
}
