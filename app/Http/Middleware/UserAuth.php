<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAuth
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
            if (auth()->user()->is_block)
            {
                if (request()->expectsJson())
                {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'You have been blocked.',
                    ]);
                }

                abort(403, "You have been blocked.");
            }
            return $next($request);
        }

        if (request()->expectsJson())
        {
            // abort(401);

            return response()->json([
                'status' => 'error',
                'message' => 'You are not logged-in.',
            ]);
        }

        return redirect(route("login"));
    }
}
