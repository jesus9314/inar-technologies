<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectFilament
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user instanceof FilamentUser) {
            if (!$user->canAccessFilament()) {
                return redirect()->route('filament.auth.auth.login');
            }
        }
        return $next($request);
    }
}
