<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\ApiKey;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $api_key = $request->header(api_key_header_key());

        $updated = ApiKey::where("key", $api_key)
            ->where("remaining", ">", 0)
            ->decrement("remaining", 1, [
                "last_used_at" => now()->utc()
            ]);

        if ($updated === 0) {
            return response()->json([
                "status" => "error",
                "message" => "API credits exhausted."
            ], 403);
        }

        return $next($request);
    }
}
