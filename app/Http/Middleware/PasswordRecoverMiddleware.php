<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PasswordRecoverMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('password_recover_user_id')) {
            return redirect()->route('vista_verificar_usuario')->withErrors(['expired' => 'La sesión de recuperación de contraseña ha expirado. Por favor, inténtalo de nuevo.']);
        }

        return $next($request);
    }
}