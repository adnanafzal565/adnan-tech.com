<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\RateLimiter;

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

        $api_key = ApiKey::with(["user"])
            ->where("key", $api_key_str)
            ->where("remaining", ">", 0)
            ->where("status", 1)
            ->first();

        if (!$api_key) {
            return response()->json([
                "status" => "error",
                "message" => "API credits exhausted."
            ], 403);
        }

        $requests_per_second = 0;
        $plans = get_plans();
        foreach ($plans as $plan) {
            if ($plan["id"] === $api_key->user->plan) {
                $requests_per_second = (int) $plan["requests_per_second"];
                break;
            }
        }

        if ($requests_per_second <= 0) {
            return response()->json([
                "status" => "error",
                "message" => "API rate limit is not configured for this plan."
            ], 403);
        }

        $rate_limit_key = "api:" . $api_key->user->id;

        $allowed = RateLimiter::attempt(
            $rate_limit_key,
            $requests_per_second,
            function () {
                return true;
            },
            1
        );

        // return response()->json([
        //     "allowed" => $allowed,
        //     "attempts" => RateLimiter::attempts($rate_limit_key),
        //     "limit" => $requests_per_second,
        //     "key" => $rate_limit_key,
        // ]);

        // return response()->json([
        //     "key" => $rate_limit_key,
        //     "limit" => $requests_per_second,
        //     "attempts" => RateLimiter::attempts($rate_limit_key),
        //     "too_many" => RateLimiter::tooManyAttempts(
        //         $rate_limit_key,
        //         $requests_per_second
        //     ),
        // ]);

        if (!$allowed) {
            $retry_after = RateLimiter::availableIn($rate_limit_key);

            return response()->json([
                "status" => "error",
                "message" => "Rate limit exceeded."
            ], 429)->withHeaders([
                "X-RateLimit-Limit" => $requests_per_second,
                "X-RateLimit-Remaining" => 0,
                "Retry-After" => $retry_after
            ]);
        }

        $remaining_attempts = RateLimiter::remaining($rate_limit_key, $requests_per_second);

        $api_key->decrement("remaining");

        $api_key->last_used_at = now()->utc();
        $api_key->save();

        $request->attributes->set("api_key", $api_key->key);
        $request->attributes->set("api_user", $api_key->user);

        $response = $next($request);

        $response->headers->set(
            "X-RateLimit-Limit", $requests_per_second
        );

        $response->headers->set(
            "X-RateLimit-Remaining",
            max(0, $remaining_attempts)
        );

        return $response;
    }
}
