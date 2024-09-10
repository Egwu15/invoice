<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class EnsureUserBusinessIsRegistered
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

        if (!$hasBusiness) {
            return redirect('business/create');
        };
        
        return $next($request);
    }
}
