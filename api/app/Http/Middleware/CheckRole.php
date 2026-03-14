<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        if (!$user || !in_array($user->role_id, $roles)) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền truy cập',
                'status_code' => 403
            ], 403);
        }

        return $next($request);
    }
}
