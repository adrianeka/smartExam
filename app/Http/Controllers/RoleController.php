<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        // Gate-keep every action with the matching permission
        $this->middleware('permission:role.view',   ['only' => ['index', 'show']]);
        $this->middleware('permission:role.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role.edit',   ['only' => ['edit', 'update']]);
        $this->middleware('permission:role.delete', ['only' => ['destroy']]);
    }

    // ── List all roles ────────────────────────────────────────────────────────
    public function index()
    {
        $roles = Role::withCount('permissions', 'users')->latest()->paginate(10);

        return view('roles.index', compact('roles'));
    }

    // ── Create form ───────────────────────────────────────────────────────────
    public function create()
    {
        $permissions = Permission::all()->groupBy(fn ($p) => explode('.', $p->name)[0]);

        return view('roles.create', compact('permissions'));
    }

    // ── Store new role ────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:roles,name'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role = Role::create(['name' => $data['name']]);
        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('roles.index')
            ->with('success', "Role \"{$role->name}\" created successfully.");
    }

    // ── Show single role ──────────────────────────────────────────────────────
    public function show(Role $role)
    {
        $role->load('permissions', 'users');

        return view('roles.show', compact('role'));
    }

    // ── Edit form ─────────────────────────────────────────────────────────────
    public function edit(Role $role)
    {
        $permissions    = Permission::all()->groupBy(fn ($p) => explode('.', $p->name)[0]);
        $rolePermIds    = $role->permissions->pluck('id')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermIds'));
    }

    // ── Update role ───────────────────────────────────────────────────────────
    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:100', "unique:roles,name,{$role->id}"],
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role->update(['name' => $data['name']]);
        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('roles.index')
            ->with('success', "Role \"{$role->name}\" updated successfully.");
    }

    // ── Delete role ───────────────────────────────────────────────────────────
    public function destroy(Role $role)
    {
        // Prevent deletion of the core roles
        if (in_array($role->name, ['admin', 'manager', 'user'])) {
            return back()->with('error', "Cannot delete the built-in role \"{$role->name}\".");
        }

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
