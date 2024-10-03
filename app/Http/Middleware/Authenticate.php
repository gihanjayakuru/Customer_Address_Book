<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            return parent::handle($request, $next, ...$guards);
        } catch (\Illuminate\Auth\AuthenticationException $exception) {
            return response()->json(['message' => 'Unauthorized or invalid token'], 401);
        }
    }

    protected function redirectTo($request)
    {

        if (!$request->expectsJson()) {
            return null;
        }
    }
}