<?php

namespace App\Http\Middleware;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    /**
     * Handle an incoming request.
     * Check limit based on resource type and plan.
     */
    public function handle(Request $request, Closure $next, string $resource, int $limit): Response
    {
        $user = auth()->user();

        if ($user && $user->isLite()) {
            $count = match($resource) {
                'book' => \App\Models\Book::count(),
                'user' => \App\Models\User::count(),
                'loan' => \App\Models\Loan::where('user_id', $user->id)->count(),
                default => 0,
            };

            if ($count >= $limit) {
                return redirect()->route('upgrade')
                    ->with('message', "Limit {$limit} {$resource} tercapai. Upgrade ke Full untuk unlimited!");
            }
        }

        return $next($request);
    }
}
