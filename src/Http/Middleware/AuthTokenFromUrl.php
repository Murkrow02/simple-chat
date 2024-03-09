<?php

namespace Murkrow\Chat\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class AuthTokenFromUrl
{
    public function handle($request, Closure $next)
    {
        $token = $request->route('token');

        if ($token) {
            $request->headers->set('Authorization', 'Bearer ' . base64_decode($token));
        }

        return $next($request);
    }
}
