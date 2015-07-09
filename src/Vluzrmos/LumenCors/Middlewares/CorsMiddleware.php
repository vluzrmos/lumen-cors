<?php

namespace Vluzrmos\LumenCors\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class CorsMiddleware.
 */
class CorsMiddleware
{
    /**
     * Access Control Headers.
     * @var array
     */
    protected $headers = [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
        'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, X-Requested-With, Origin',
        'Access-Control-Allow-Credentials' => 'true',
    ];

    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('options')) {
            return $this->setCorsHeaders(new Response('OK'));
        }

        $response = $next($request);

        return $this->setCorsHeaders($response);
    }

    /**
     * Set the Cors headers to a given response.
     * @param SymfonyResponse $response
     * @return SymfonyResponse
     */
    public function setCorsHeaders(SymfonyResponse $response)
    {
        foreach ($this->getCorsHeaders() as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
    }

    /**
     * Cors Headers.
     * @return array
     */
    public function getCorsHeaders()
    {
        return $this->headers;
    }
}
