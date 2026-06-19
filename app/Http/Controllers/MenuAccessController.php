<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenuAccessController extends Controller
{
    public function index(Request $request, Menu $menu)
    {
        // Don't manage access for categories since they don't have direct permissions
        if ($menu->type === 'category') {
            return redirect()->back()->with('error', 'Kategori tidak memerlukan pengaturan akses spesifik. Silakan atur akses pada sub-menunya.');
        }

        // Get all users except admin (since admin bypasses permissions)
        $query = User::whereDoesntHave('roles', function($q) {
            $q->where('name', 'admin');
        });

        // Filter by search
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role != '') {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->paginate(20)->withQueryString();
        $roles = Role::where('name', '!=', 'admin')->get();

        $viewPermissionName = 'view_menu_' . $menu->id;
        $editPermissionName = 'edit_menu_' . $menu->id;

        return view('admin.menus.access', compact('menu', 'users', 'roles', 'viewPermissionName', 'editPermissionName'));
    }

    public function update(Request $request, Menu $menu)
    {
        if ($menu->type === 'category') {
            return redirect()->back()->with('error', 'Kategori tidak memerlukan pengaturan akses.');
        }

        $viewPermissionName = 'view_menu_' . $menu->id;
        $editPermissionName = 'edit_menu_' . $menu->id;

        // Ensure permissions exist
        Permission::firstOrCreate(['name' => $viewPermissionName]);
        Permission::firstOrCreate(['name' => $editPermissionName]);

        // Automatically bind this permission to the menu if it's not set
        if (empty($menu->permission_name)) {
            $menu->update(['permission_name' => $viewPermissionName]);
        }

        // Sync roles
        $rolesData = $request->input('roles', []);
        foreach ($rolesData as $roleId => $perms) {
            $role = Role::findById($roleId);
            if ($role) {
                if (isset($perms['view'])) $role->givePermissionTo($viewPermissionName);
                else $role->revokePermissionTo($viewPermissionName);
                
                if (isset($perms['edit'])) $role->givePermissionTo($editPermissionName);
                else $role->revokePermissionTo($editPermissionName);
            }
        }

        // Sync users
        $usersData = $request->input('users', []);
        foreach ($usersData as $userId => $perms) {
            $user = User::find($userId);
            if ($user) {
                if (isset($perms['view'])) $user->givePermissionTo($viewPermissionName);
                else $user->revokePermissionTo($viewPermissionName);
                
                if (isset($perms['edit'])) $user->givePermissionTo($editPermissionName);
                else $user->revokePermissionTo($editPermissionName);
            }
        }

        // Revoke permissions from those who were completely removed from the list
        $activeRoleIds = array_keys($rolesData);
        $activeUserIds = array_keys($usersData);

        $viewPerm = Permission::findByName($viewPermissionName);
        $editPerm = Permission::findByName($editPermissionName);

        foreach ($viewPerm->roles as $role) {
            if (!in_array($role->id, $activeRoleIds) && $role->name !== 'admin') {
                $role->revokePermissionTo($viewPermissionName);
            }
        }
        foreach ($editPerm->roles as $role) {
            if (!in_array($role->id, $activeRoleIds) && $role->name !== 'admin') {
                $role->revokePermissionTo($editPermissionName);
            }
        }

        foreach ($viewPerm->users as $user) {
            if (!in_array($user->id, $activeUserIds) && !$user->hasRole('admin')) {
                $user->revokePermissionTo($viewPermissionName);
            }
        }
        foreach ($editPerm->users as $user) {
            if (!in_array($user->id, $activeUserIds) && !$user->hasRole('admin')) {
                $user->revokePermissionTo($editPermissionName);
            }
        }

        return redirect()->back()->with('success', 'Pengaturan akses untuk menu ' . $menu->name . ' berhasil diperbarui!');
    }
}
