<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * RoleRedirectMiddleware
 *
 * Redirects authenticated users to role-appropriate dashboards after login.
 * Register in bootstrap/app.php or Kernel.php as 'role.redirect'.
 *
 * Usage in routes:
 *   Route::get('/dashboard', ...)->middleware('role.redirect');
 */
class RoleRedirectMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->hasRole('admin')) {
                // Admins get full access – no redirect needed
                return $next($request);
            }

            if ($user->hasRole('manager')) {
                // Managers cannot access role management routes
                if ($request->routeIs('roles.*')) {
                    abort(403, 'Managers cannot manage roles.');
                }
                return $next($request);
            }

            // Regular users: restrict to read-only areas
            if ($user->hasRole('user')) {
                $allowed = ['dashboard', 'home'];
                if (!$request->routeIs($allowed)) {
                    abort(403, 'Access restricted.');
                }
                return $next($request);
            }
        }

        return $next($request);
    }
}
