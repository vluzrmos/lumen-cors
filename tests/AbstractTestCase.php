<?php

namespace Vluzrmos\LumenCors;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Illuminate\Http\Request;

/**
 * Class AbstractTestCase.
 */
abstract class AbstractTestCase extends OrchestraTestCase
{
    /**
     * Creates an instance of CorsMiddleware.
     * @return CorsMiddleware
     */
    public function createCorsMiddleware()
    {
        return $this->app->make('Vluzrmos\LumenCors\CorsMiddleware');
    }

    /**
     * Creates an instance of CorsService.
     * @return CorsService
     */
    public function createCorsService()
    {
        return $this->app->make('Vluzrmos\LumenCors\CorsService');
    }

    /**
     * Create a valid Preflight Request.
     * @param string $requestMethod Requested method on preflight.
     * @return Request
     */
    public function createPreflightRequest($requestMethod = 'get')
    {
        $request = new Request();

        $request->headers->set('Origin', 'localhost');
        $request->headers->set('Access-Control-Request-Method', $requestMethod);

        $request->setMethod('OPTIONS');

        $cors = $this->createCorsService();

        $this->assertTrue($cors->isPreflightRequest($request));

        return $request;
    }

    /**
     * Create a valid Request.
     * @param string $method HTTP Verb.
     * @return Request
     */
    public function createRequest($method = 'GET')
    {
        $request = new Request();

        $request->setMethod($method);

        $cors = $this->createCorsService();

        $this->assertFalse($cors->isPreflightRequest($request));

        return $request;
    }
}
