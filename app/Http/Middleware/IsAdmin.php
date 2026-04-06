<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next): Response
    {
        // تحقق إن المستخدم مسجل دخول
        if (! $request->user()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Forbidden: Admins only'
            ], 403);
        }

        return $next($request);
    }

}
