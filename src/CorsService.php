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
     * @param Request  $request
     * @return Response
     */
    public function setCorsHeaders(Response $response, Request $request)
    {
        foreach ($this->getCorsHeaders($request) as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
    }

    /**
     * Cors Headers.
     * @param Request $request
     * @return array
     */
    public function getCorsHeaders(Request $request)
    {
        $headers = 'Authorization, X-Requested-With, X-Auth-Token, Content-Type';

        if ($request->headers->has('Access-Control-Request-Headers')) {
            $headers = $request->headers->get('Access-Control-Request-Headers');
        }

        $methods = 'DELETE, GET, HEAD, OPTIONS, PATCH, POST, PUT';

        if ($request->headers->has('Access-Control-Request-Method')) {
            $methods = $request->headers->get('Access-Control-Request-Method');
        }

        return [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => $methods,
            'Access-Control-Allow-Headers' => $headers,
            'Access-Control-Allow-Credentials' => 'true',
        ];
    }
}
