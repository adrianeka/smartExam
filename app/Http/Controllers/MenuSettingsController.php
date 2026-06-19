<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenuSettingsController extends Controller
{
    public function show(Request $request, Menu $menu)
    {
        $parentMenus = Menu::whereNull('parent_id')->where('id', '!=', $menu->id)->get();
        
        $tab = $request->query('tab', 'overview');

        // Permissions Tab Data
        $users = collect();
        $roles = collect();
        $viewPermissionName = '';
        $editPermissionName = '';

        if ($tab === 'permissions' && $menu->type !== 'category') {
            $viewPermissionName = 'view_menu_' . $menu->id;
            $editPermissionName = 'edit_menu_' . $menu->id;

            // Ensure permissions exist before querying to prevent Spatie Exception
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $viewPermissionName]);
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $editPermissionName]);

            // We only need all roles with their users
            $allRoles = Role::where('name', '!=', 'admin')->with('users')->get();

            return view('admin.menus.settings', compact(
                'menu', 'parentMenus', 'tab', 
                'viewPermissionName', 'editPermissionName',
                'allRoles'
            ));
        }

        return view('admin.menus.settings', compact('menu', 'parentMenus', 'tab'));
    }
}
