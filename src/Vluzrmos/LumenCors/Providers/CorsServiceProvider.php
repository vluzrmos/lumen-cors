<?php

namespace Vluzrmos\LumenCors\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Response;

class CorsServiceProvider extends ServiceProvider
{
    /*
     * Keeping that for compatibility,
     * That will be no longer necessary on version 1.1.*
     */
    public function register()
    {
    }
}
