<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiToken
{
    public function handle(Request $request, Closure $next): Response|JsonResponse
    {
        //todo: some token logic
        if ($request->header('token') !== config('api.key')) {
            return response()->json('Unauthorized', 401);
        }

        return $next($request);
    }
}
