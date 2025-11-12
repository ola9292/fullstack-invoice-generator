<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Subscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $pollsCount = $user->polls()->count();

        if (! $user) {
            return redirect()->route('login');
        }

        $planLimits = [
            'free' => 2,
            'pro' => 3,
            'enterprise' => PHP_INT_MAX,
        ];

        if (auth()->user()->subscribedToProduct('prod_TGa42zsUEijf3p')) {
            $limit = $planLimits['pro'];
        } elseif (auth()->user()->subscribedToProduct('prod_TGa6prGUN4PrDp')) {
            $limit = $planLimits['enterprise'];
        } else {
            $limit = $planLimits['free'];
        }
        if ($pollsCount >= $limit) {
            return redirect()->route('billing.plan')->with('message', 'You have reached your limit, please upgrade!');
        }

        return $next($request);
    }
}
