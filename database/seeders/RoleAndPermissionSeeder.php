<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Buat Semua Permissions yang Tersedia di Sistem
        $permissions = [
            // User Management
            'view users',
            'manage users',
            
            // Role Management
            'manage roles',

            // Course Management
            'view courses',
            'create courses',
            'edit courses',
            'delete courses',

            // Enrollment & Reporting
            'manage enrollments',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Buat Role dan Berikan Permission Default
        
        // Admin: Punya semua akses
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        // Teacher: Mengelola Course & Melihat Report
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $teacherRole->syncPermissions([
            'view courses',
            'create courses',
            'edit courses',
            'delete courses',
            'view reports'
        ]);

        // Student: Hanya melihat Course
        $studentRole = Role::firstOrCreate(['name' => 'student']);
        $studentRole->syncPermissions([
            'view courses'
        ]);
    }
}