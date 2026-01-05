<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPlan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    /**
     * Handle an incoming request.
     * Check if user has Full plan, otherwise redirect to upgrade page.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isLite()) {
            return redirect()->route('upgrade')
                ->with('message', 'Fitur ini hanya tersedia untuk plan Full. Upgrade sekarang untuk mengakses semua fitur!');
        }

        return $next($request);
    }
}
