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
        $api_key_str = $request->header(api_key_header_key()) ?? $request->query("api_key");

        $api_key = ApiKey::where("key", $api_key_str)
            ->where("remaining", ">", 0)
            ->where("status", 1)
            ->first();

        if (!$api_key) {
            return response()->json([
                "status" => "error",
                "message" => "API credits exhausted."
            ], 403);
        }

        $api_key->decrement("remaining");

        $api_key->last_used_at = now()->utc();
        $api_key->save();

        $request->api_key = $api_key->key;
        $request->api_user = $api_key->user;

        return $next($request);
    }
}
