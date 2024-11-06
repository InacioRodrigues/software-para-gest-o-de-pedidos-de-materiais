<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPerfil
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $perfil)
    {
        if (!auth()->check() || auth()->user()->perfil !== $perfil) {
            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}
