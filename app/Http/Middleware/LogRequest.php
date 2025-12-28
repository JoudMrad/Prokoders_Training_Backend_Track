<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        Log::channel('api')->info('API Request:', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);

        $response = $next($request);

        Log::channel('api')->info('API Response:', [
            'status' => $response->status(),
            'url' => $request->fullUrl(),
            'timestamp' => now()->toDateTimeString(),
        ]);

        return $response;
    }
}