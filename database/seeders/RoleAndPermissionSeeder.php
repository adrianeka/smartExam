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

            // 1. Buat Permission (Contoh opsional untuk memperjelas hak akses)
            Permission::firstOrCreate(['name' => 'manage users']);
            Permission::firstOrCreate(['name' => 'create courses']);
            Permission::firstOrCreate(['name' => 'view courses']);

            // 2. Buat Role dan Berikan Permission
            
            // Admin: Punya semua akses
            $adminRole = Role::firstOrCreate(['name' => 'admin']);
            $adminRole->syncPermissions(Permission::all());

            // Teacher: Bisa membuat dan melihat materi/kelas
            $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
            $teacherRole->syncPermissions(['create courses', 'view courses']);

            // Student: Hanya bisa melihat materi/kelas
            $studentRole = Role::firstOrCreate(['name' => 'student']);
            $studentRole->syncPermissions(['view courses']);
        }
    }