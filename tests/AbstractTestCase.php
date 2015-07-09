<?php

namespace Vluzrmos\LumenCors;

use Illuminate\Http\Request;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * Class AbstractTestCase.
 */
abstract class AbstractTestCase extends OrchestraTestCase
{
    /**
     * Creates an instance of CorsMiddleware.
     * @return CorsMiddleware
     */
    protected function createCorsMiddleware()
    {
        return $this->app->make('Vluzrmos\LumenCors\CorsMiddleware');
    }

    /**
     * Create a valid Preflight Request.
     * @param string $requestMethod Requested method on preflight.
     * @param string $verb HTTP Verb.
     * @return Request
     */
    protected function createPreflightRequest($requestMethod = 'get', $verb = 'OPTIONS')
    {
        $request = new Request();

        $request->headers->set('Origin', 'localhost');
        $request->headers->set('Access-Control-Request-Method', $requestMethod);

        $request->setMethod($verb);

        $cors = $this->createCorsService();

        if (strtolower($verb) == 'options') {
            $this->assertTrue(
                $cors->isPreflightRequest($request),
                'It should be a valid preflight request.'
            );
        } else {
            $this->assertFalse(
                $cors->isPreflightRequest($request),
                'It should be an invalid preflight request.'
            );
        }

        return $request;
    }

    /**
     * Creates an instance of CorsService.
     * @return CorsService
     */
    protected function createCorsService()
    {
        return $this->app->make('Vluzrmos\LumenCors\CorsService');
    }

    /**
     * Create a valid Request.
     * @param string $method HTTP Verb.
     * @return Request
     */
    protected function createRequest($method = 'GET')
    {
        $request = new Request();

        $request->setMethod($method);

        $cors = $this->createCorsService();

        $this->assertFalse($cors->isPreflightRequest($request));

        return $request;
    }
}
