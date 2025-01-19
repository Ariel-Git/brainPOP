<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTokenExpiration
{
    public function handle(Request $request, Closure $next)
    {
        $tokenExpiration = $request->user()->tokens()
            ->latest('created_at')
            ->value('expires_at');

        if ($tokenExpiration && now()->greaterThan($tokenExpiration)) {
            return response()->json(['message' => 'Token expired'], 401);
        }

        return $next($request);
    }
}