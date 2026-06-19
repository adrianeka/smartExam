<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Tampilkan semua role.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Tampilkan form untuk membuat role baru.
     */
    public function create()
    {
        // Kelompokkan permission untuk UI yang rapi (Discord Style)
        $permissions = Permission::all()->groupBy(function($permission) {
            if (str_contains($permission->name, 'user')) return 'User Management';
            if (str_contains($permission->name, 'role')) return 'Role Management';
            if (str_contains($permission->name, 'course')) return 'Course Management';
            if (str_contains($permission->name, 'enrollment')) return 'Enrollment Management';
            if (str_contains($permission->name, 'report')) return 'Report Management';
            return 'Other Permissions';
        });

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Simpan role baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role = Role::create(['name' => $request->name]);
        
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dibuat!');
    }

    /**
     * Tampilkan form untuk mengedit role.
     */
    public function edit(Role $role)
    {
        // Jangan izinkan edit role super admin
        if ($role->name === 'admin') {
            return redirect()->route('admin.roles.index')->with('error', 'Role Admin utama tidak dapat diubah hak aksesnya.');
        }

        $permissions = Permission::all()->groupBy(function($permission) {
            if (str_contains($permission->name, 'user')) return 'User Management';
            if (str_contains($permission->name, 'role')) return 'Role Management';
            if (str_contains($permission->name, 'course')) return 'Course Management';
            if (str_contains($permission->name, 'enrollment')) return 'Enrollment Management';
            if (str_contains($permission->name, 'report')) return 'Report Management';
            return 'Other Permissions';
        });

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update role.
     */
    public function update(Request $request, Role $role)
    {
        if ($role->name === 'admin') {
            return redirect()->route('admin.roles.index')->with('error', 'Role Admin utama tidak dapat diedit.');
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($role->id)
            ],
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        // Role bawaan selain admin tidak boleh diganti namanya
        if (in_array($role->name, ['teacher', 'student']) && $request->name !== $role->name) {
            return redirect()->back()->with('error', 'Nama role bawaan (teacher/student) tidak dapat diubah.');
        }

        $role->update(['name' => $request->name]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil diperbarui!');
    }

    /**
     * Hapus role.
     */
    public function destroy(Role $role)
    {
        if (in_array($role->name, ['admin', 'teacher', 'student'])) {
            return redirect()->route('admin.roles.index')->with('error', 'Role sistem bawaan tidak dapat dihapus.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dihapus!');
    }
}
