<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::get('user_role') !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}