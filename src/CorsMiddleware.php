<?php

namespace Vluzrmos\LumenCors;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class CorsMiddleware.
 */
class CorsMiddleware
{
    /**
     * LumenCors Service.
     * @var CorsService
     */
    private $cors;

    /**
     * A middleware to handle Cors Preflighted Requests.
     * @param \Vluzrmos\LumenCors\CorsService $cors
     */
    public function __construct(CorsService $cors)
    {
        $this->cors = $cors;
    }

    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->setTrustedProxiesForRequest($request);

        if ($this->cors->isPreflightRequest($request)) {
            return $this->cors->setCorsHeaders(new Response('OK'), $request);
        }

        $response = $next($request);

        return $this->cors->setCorsHeaders($response, $request);
    }

    /**
     * Set trusted proxies for the request.
     * @param \Illuminate\Http\Request $request
     */
    public function setTrustedProxiesForRequest(Request $request)
    {
        if (empty($request->getTrustedProxies())) {
            $request->setTrustedProxies($request->getClientIps());
        }
    }

    /**
     * Get the instance of Cors Service.
     * @return \Vluzrmos\LumenCors\CorsService
     */
    public function getCorsService()
    {
        return $this->cors;
    }
}
