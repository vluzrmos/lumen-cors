<?php

namespace Vluzrmos\LumenCors;

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
     * Request Origin.
     * @var string
     */
    protected $allowedOrigin = '*';

    /**
     * HTTP Verbs.
     * @var string|array
     */
    protected $allowedMethods = 'POST, GET, OPTIONS, PUT, DELETE';

    /**
     * HTTP Headers.
     * @var string|array
     */
    protected $allowedHeaders = [
        'Accept', //Allow specify spected content-type
        'Authorization', //Allow Authentication Methods
        'Content-Type', //Allow specify sented content-type
        'Origin', //Request origin header
        'X-Auth-Token', //Allow Auth Token
        'X-Csrf-Token', //Allow CSRF Token
        'X-XSRF-TOKEN', //Allow CSRF Token
        'X-Requested-With', //Allow Ajax XmlHttpRequest
    ];

    /**
     * Allowed Credentials.
     * @var string
     */
    protected $allowedCredentials = 'true';

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
        return [
            'Access-Control-Allow-Origin' => commaSeparated($this->allowedOrigin),
            'Access-Control-Allow-Methods' => commaSeparated($this->allowedMethods),
            'Access-Control-Allow-Headers' => commaSeparated($this->allowedHeaders),
            'Access-Control-Allow-Credentials' => commaSeparated($this->allowedCredentials),
        ];
    }
}
