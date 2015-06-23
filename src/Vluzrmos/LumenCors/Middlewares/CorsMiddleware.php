<?php

namespace Vluzrmos\LumenCors\Middlewares;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    /**
     * Access Control Headers.
     * @var array
     */
    protected $headers = [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
        'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin',
        'Access-Control-Allow-Credentials'=> 'true'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        return $this->setCorsHeaders($response);
    }

    /**
     * @param $response
     * @return mixed
     */
    public function setCorsHeaders($response)
    {
        foreach ($this->headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}
