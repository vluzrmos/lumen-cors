<?php

namespace Vluzrmos\LumenCors\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Response;

class CorsServiceProvider extends ServiceProvider
{
    /**
     * Register OPTIONS route to any requests.
     */
    public function register()
    {
        /** @var \Illuminate\Http\Request $request */
        $request = $this->app->make('request');

        if ($request->isMethod("options")) {
            $this->app->options($request->path(), function () {
                return new Response('OK', 200);
            });
        }
    }
}
