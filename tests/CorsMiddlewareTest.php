<?php

namespace Vluzrmos\LumenCors;

/**
 * Class CorsMiddlewareTest.
 */
class CorsMiddlewareTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testShouldHandlePreflightRequest()
    {
        $middleware = $this->createCorsMiddleware();

        $requestedMethods = ['get', 'post', 'delete', 'put', 'patch', 'head', 'options', 'anyMethod'];

        foreach ($requestedMethods as $method) {
            /** @var \Illuminate\Http\Request $request */
            $request = $this->createPreflightRequest($method);

            $response = $middleware->handle($request, function ($request) {
                return response('Welcome!');
            });

            $this->assertEquals('OK', $response->getContent());
        }
    }

    /**
     * @return void
     */
    public function testShouldSeeWelcomeWithCorsHeaders()
    {
        $middleware = $this->createCorsMiddleware();

        /** @var \Illuminate\Http\Request $request */
        $request = $this->createRequest();

        $response = $middleware->handle($request, function ($request) {
            return response('Welcome!');
        });

        $cors = $this->createCorsService();

        foreach ($cors->getCorsHeaders() as $key => $value) {
            $this->assertEquals($value, $response->headers->get($key));
        }

        $this->assertEquals('Welcome!', $response->getContent());
    }

    /**
     * @return void
     */
    public function testShouldDownloadWithCorsHeaders()
    {
        $middleware = $this->createCorsMiddleware();

        /** @var \Illuminate\Http\Request $request */
        $request = $this->createRequest();

        $response = $middleware->handle($request, function ($request) {
            return response()->download(__DIR__.'/stubs/download.txt');
        });

        $cors = $middleware->getCorsService();

        foreach ($cors->getCorsHeaders() as $key => $value) {
            $this->assertEquals($value, $response->headers->get($key));
        }

        $this->assertStringMatchesFormat('File was downloaded!', file_get_contents($response->getFile()));
    }
}
