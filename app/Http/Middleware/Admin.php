<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check())
        {
            $user = auth()->user();

            if (in_array($user->type, ["admin", "super_admin"]))
            {
                return $next($request);
            }
        }

        if (request()->expectsJson()) {
            return response()->json([
                "status" => "error",
                "message" => "Un-authorized."
            ]);
        }

        return redirect("/admin/login");
    }
}
