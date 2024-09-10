<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectUserWithBusiness
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User $user */
        $user = Auth::user();

        $hasBusiness = cache()->remember("user_{$user->id}_has_business", 60, function () use ($user) {
            return $user->business()->exists();
        });

        if ($hasBusiness) {
            return redirect('dashboard');
        };
        return $next($request);
    }
}
