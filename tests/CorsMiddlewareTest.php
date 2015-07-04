<?php

namespace Vluzrmos\LumenCors;

use Illuminate\Http\Request;

/**
 * Class CorsMiddlewareTest
 * @package Vluzrmos\LumenCors
 */
class CorsMiddlewareTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testShouldSeeOKToMethodOptions()
    {
        $middleware = new Middlewares\CorsMiddleware();

        /** @var \Illuminate\Http\Request $request */
        $request = Request::create('http://localhost', 'OPTIONS');

        $response = $middleware->handle($request, function ($request) {
            return response('Welcome!');
        });

        $this->assertEquals('OK', $response->getContent());
    }

    /**
     * @return void
     */
    public function testShouldSeeWelcomeWithCorsHeaders()
    {
        $middleware = new Middlewares\CorsMiddleware();

        /** @var \Illuminate\Http\Request $request */
        $request = Request::create('http://localhost', 'GET');

        $response = $middleware->handle($request, function ($request) {
            return response('Welcome!');
        });

        foreach ($middleware->getCorsHeaders() as $key => $value) {
            $this->assertEquals($value, $response->headers->get($key));
        }

        $this->assertEquals('Welcome!', $response->getContent());
    }

    /**
     * @return void
     */
    public function testShouldDownloadWithCorsHeaders()
    {
        $middleware = new Middlewares\CorsMiddleware();

        /** @var \Illuminate\Http\Request $request */
        $request = Request::create('http://localhost', 'GET');

        $response = $middleware->handle($request, function ($request) {
            return response()->download(__DIR__.'/stubs/download.txt');
        });

        foreach ($middleware->getCorsHeaders() as $key => $value) {
            $this->assertEquals($value, $response->headers->get($key));
        }

        $this->assertStringMatchesFormat("File was downloaded!", file_get_contents($response->getFile()));
    }
}
