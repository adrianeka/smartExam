<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Menu;

class CheckMenuAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Admin bypasses all checks
        if (auth()->user()->hasRole('admin')) {
            return $next($request);
        }

        $routeName = $request->route() ? $request->route()->getName() : null;

        if ($routeName && str_starts_with($routeName, 'admin.')) {
            $menu = null;

            // 1. If it's an action route, map it to the corresponding index menu to keep permissions consistent
            $actionSuffixes = ['.create', '.edit', '.store', '.update', '.destroy', '.approve', '.reject'];
            $isActionRoute = false;
            foreach ($actionSuffixes as $suffix) {
                if (str_ends_with($routeName, $suffix)) {
                    $isActionRoute = true;
                    $baseRoute = substr($routeName, 0, -strlen($suffix)); // admin.user or admin.users
                    
                    // Handle singular vs plural mismatch (e.g. admin.user.create -> admin.users.index)
                    $pluralBaseRoute = str_ends_with($baseRoute, 's') ? $baseRoute : $baseRoute . 's';
                    
                    $menu = Menu::where('url', $baseRoute . '.index')
                                ->orWhere('url', $pluralBaseRoute . '.index')
                                ->first();
                    break;
                }
            }

            // 2. Try exact match (e.g. admin.users.index)
            if (!$menu) {
                $menu = Menu::where('url', $routeName)->first();
            }

            // 3. Handle shallow child resources that belong to the courses menu
            if (!$menu) {
                $parts = explode('.', $routeName);
                $childResources = ['modules', 'lessons', 'exams', 'questions'];
                if (isset($parts[1]) && in_array($parts[1], $childResources)) {
                    $menu = Menu::where('url', 'LIKE', 'admin.courses.%')->first();
                }
            }

            // 4. Try base route match as fallback (e.g. admin.something.custom -> admin.something.index)
            if (!$menu) {
                $parts = explode('.', $routeName);
                if (count($parts) >= 2) {
                    $baseRoute = $parts[0] . '.' . $parts[1]; // admin.users
                    $menu = Menu::where('url', 'LIKE', $baseRoute . '.%')->first();
                }
            }

            if ($menu) {
                // Determine action type based on method and route name
                $method = $request->method();
                $action = 'view';
                
                if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
                    $action = 'edit';
                } else {
                    if (str_ends_with($routeName, '.create') || str_ends_with($routeName, '.edit')) {
                        $action = 'edit';
                    }
                }

                $editPermissionName = 'edit_menu_' . $menu->id;
                $permissionToCheck = $action === 'edit' ? $editPermissionName : 'view_menu_' . $menu->id;

                // Share the edit permission name globally for blade views to hide/show buttons
                \Illuminate\Support\Facades\View::share('currentMenuEditPermission', $editPermissionName);

                // Check if user has permission
                if (!auth()->user()->hasPermissionTo($permissionToCheck)) {
                    abort(403, 'Akses Ditolak. Anda tidak memiliki izin (' . $permissionToCheck . ') untuk ' . ($action == 'edit' ? 'mengubah' : 'melihat') . ' halaman ini.');
                }
            } else {
                // If it's an admin route but no menu matches, deny access for non-admins
                abort(403, 'User does not have the right roles.');
            }
        }

        return $next($request);
    }
}
