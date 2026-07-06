<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('access_token')) {
            return redirect('/login');
        }

        if (session('tipo_usuario') !== 'admin') {
            return redirect('/dashboard')->with('error', 'Acesso negado. Apenas administradores podem acessar esta página.');
        }

        return $next($request);
    }
}
