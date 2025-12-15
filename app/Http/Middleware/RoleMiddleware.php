<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * ihi: proverava da li korisnik ima dozvoljenu rolu
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // ihi: ako korisnik nije prijavljen ili nema dozvoljenu rolu, baca 403
        if (!$user || !in_array($user->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
