<?php

namespace App\Http\Middleware;
use Closure;
// this middleware is supposed to handle CORS
class CrossOriginMiddleware
{

    public function __construct()
    {
    }
    public function handle($req, Closure $next)
    {

        $headers = [
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => '',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With, sentry-trace'
        ];

        if ($req->isMethod('OPTIONS')) {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $res = $next($req);
        foreach ($headers as $key => $value) {
            $res->header($key, $value);
        }

        return $res;
    }

}
