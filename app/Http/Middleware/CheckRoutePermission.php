<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoutePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user->type === "super_admin")
            return $next($request);

        $route = $request->route()->getName();

        $allowed = $user->route_permissions()
            ->where('route_name', $route)
            ->exists();

        if (!$allowed) {
            if (request()->expectsJson()) {
                return response()->json([
                    "status" => "error",
                    "message" => "Un-authorized."
                ]);
            }
            abort(403);
        }

        return $next($request);
    }
}
