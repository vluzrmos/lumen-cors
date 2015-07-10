<?php

namespace Vluzrmos\LumenCors;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CorsService.
 */
class CorsService
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
    protected $allowedMethods = 'DELETE, GET, HEAD, OPTIONS, PATCH, POST, PUT';

    /**
     * HTTP Headers.
     * @var string|array
     */
    protected $allowedHeaders = '*';

    /**
     * Allowed Credentials.
     * @var string
     */
    protected $allowedCredentials = 'true';

    /**
     * Check if request is preflight.
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
     * @param Request $request
     * @return bool
     */
    public function isPreflightRequest(Request $request)
    {
        return $request->headers->has('Origin') &&
            $request->getMethod() == 'OPTIONS' &&
            $request->headers->has('Access-Control-Request-Method');
    }

    /**
     * Set the Cors headers to a given response.
     * @param Response $response
     * @return Response
     */
    public function setCorsHeaders(Response $response)
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
