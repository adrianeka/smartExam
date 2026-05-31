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
            Permission::create(['name' => 'manage users']);
            Permission::create(['name' => 'create courses']);
            Permission::create(['name' => 'view courses']);

            // 2. Buat Role dan Berikan Permission
            
            // Admin: Punya semua akses
            $adminRole = Role::create(['name' => 'admin']);
            $adminRole->givePermissionTo(Permission::all());

            // Teacher: Bisa membuat dan melihat materi/kelas
            $teacherRole = Role::create(['name' => 'teacher']);
            $teacherRole->givePermissionTo(['create courses', 'view courses']);

            // Student: Hanya bisa melihat materi/kelas
            $studentRole = Role::create(['name' => 'student']);
            $studentRole->givePermissionTo('view courses');
        }
    }