<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = $request->user(); 

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role !== $role) {
            return back()->with('error', 'Недостаточно прав.');
        }

        return $next($request);
    }
}
