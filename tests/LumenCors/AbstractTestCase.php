<?php

namespace Vluzrmos\LumenCors\Testing;

use Illuminate\Http\Request;
use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\TestCase;
use Vluzrmos\LumenCors\CorsMiddleware;
use Vluzrmos\LumenCors\CorsService;

/**
 * Class AbstractTestCase.
 */
abstract class AbstractTestCase extends TestCase
{
    /**
     * @return Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap.php';
    }

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

        /** @var  $cors */
        $cors = $this->createCorsService();

        $this->assertFalse($cors->isPreflightRequest($request));

        return $request;
    }

    /**
     * Get path to stub.
     * @param string $path
     * @return string
     */
    protected function stubsPath($path = null)
    {
        return __DIR__.'/../stubs'.($path ? '/'.trim($path, '/') : '');
    }
}
