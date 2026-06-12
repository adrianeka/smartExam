<?php

// namespace Tests\Browser;

// use App\Models\User;
// use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Laravel\Dusk\Browser;
// use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;
// use Tests\DuskTestCase;

// /**
//  * Test Suite: Role Middleware & Route Protection
//  * Menguji middleware role:admin, role:teacher, role:student pada route
//  *
//  * Jalankan dengan:
//  *   php artisan dusk --filter RoleMiddlewareTest
//  */
// class RoleMiddlewareTest extends DuskTestCase
// {
//     // use DatabaseMigrations;

//     // protected function setUp(): void
//     // {
//     //     parent::setUp();

//     //     app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

//     //     Role::create(['name' => 'admin']);
//     //     Role::create(['name' => 'teacher']);
//     //     Role::create(['name' => 'student']);
//     // }

//     // =========================================================================
//     // SECTION A: Route yang hanya boleh diakses Admin
//     // =========================================================================

//     /**
//      * @dataProvider adminOnlyRoutes
//      * @test
//      */
//     public function admin_dapat_akses_route_khusus_admin(string $route): void
//     {
//         $admin = User::factory()->create(['email' => 'admin@test.com']);
//         $admin->assignRole('admin');

//         $this->browse(function (Browser $browser) use ($admin, $route) {
//             $browser->loginAs($admin)
//                     ->visit($route)
//                     ->assertPathIs($route)
//                     ->assertDontSee('403')
//                     ->assertDontSee('Forbidden');
//         });
//     }

//     /**
//      * @dataProvider adminOnlyRoutes
//      * @test
//      */
//     public function teacher_tidak_dapat_akses_route_khusus_admin(string $route): void
//     {
//         $teacher = User::factory()->create(['email' => 'teacher@test.com']);
//         $teacher->assignRole('teacher');

//         $this->browse(function (Browser $browser) use ($teacher, $route) {
//             $browser->loginAs($teacher)
//                     ->visit($route)
//                     ->assertPathIsNot($route);
//         });
//     }

//     /**
//      * @dataProvider adminOnlyRoutes
//      * @test
//      */
//     public function student_tidak_dapat_akses_route_khusus_admin(string $route): void
//     {
//         $student = User::factory()->create(['email' => 'student@test.com']);
//         $student->assignRole('student');

//         $this->browse(function (Browser $browser) use ($student, $route) {
//             $browser->loginAs($student)
//                     ->visit($route)
//                     ->assertPathIsNot($route);
//         });
//     }

//     public static function adminOnlyRoutes(): array
//     {
//         return [
//             'manajemen user'     => ['/admin/users'],
//             'manajemen role'     => ['/admin/roles'],
//             'pengaturan sistem'  => ['/admin/settings'],
//             'laporan'            => ['/admin/reports'],
//             'buat user'          => ['/admin/users/create'],
//         ];
//     }

//     // =========================================================================
//     // SECTION B: Route yang boleh diakses Admin & Teacher
//     // =========================================================================

//     /**
//      * @dataProvider teacherAndAboveRoutes
//      * @test
//      */
//     public function admin_dapat_akses_route_teacher(string $route): void
//     {
//         $admin = User::factory()->create(['email' => 'admin@test.com']);
//         $admin->assignRole('admin');

//         $this->browse(function (Browser $browser) use ($admin, $route) {
//             $browser->loginAs($admin)
//                     ->visit($route)
//                     ->assertDontSee('403');
//         });
//     }

//     /**
//      * @dataProvider teacherAndAboveRoutes
//      * @test
//      */
//     public function teacher_dapat_akses_route_teacher(string $route): void
//     {
//         $teacher = User::factory()->create(['email' => 'teacher@test.com']);
//         $teacher->assignRole('teacher');

//         $this->browse(function (Browser $browser) use ($teacher, $route) {
//             $browser->loginAs($teacher)
//                     ->visit($route)
//                     ->assertDontSee('403');
//         });
//     }

//     /**
//      * @dataProvider teacherAndAboveRoutes
//      * @test
//      */
//     public function student_tidak_dapat_akses_route_teacher(string $route): void
//     {
//         $student = User::factory()->create(['email' => 'student@test.com']);
//         $student->assignRole('student');

//         $this->browse(function (Browser $browser) use ($student, $route) {
//             $browser->loginAs($student)
//                     ->visit($route)
//                     ->assertPathIsNot($route);
//         });
//     }

//     public static function teacherAndAboveRoutes(): array
//     {
//         return [
//             'kelola kursus'  => ['/courses'],
//             'kelola tugas'   => ['/assignments'],
//             'daftar siswa'   => ['/teacher/students'],
//             'buat kursus'    => ['/courses/create'],
//         ];
//     }

//     // =========================================================================
//     // SECTION C: Halaman Error 403 Tampil Dengan Benar
//     // =========================================================================

//     /** @test */
//     public function halaman_403_tampil_saat_akses_ditolak(): void
//     {
//         $student = User::factory()->create(['email' => 'student@test.com']);
//         $student->assignRole('student');

//         $this->browse(function (Browser $browser) use ($student) {
//             $browser->loginAs($student)
//                     ->visit('/admin/users')
//                     ->assertSee('403')
//                     ->assertSee('Akses Ditolak');
//         });
//     }

//     /** @test */
//     public function halaman_403_memiliki_tombol_kembali(): void
//     {
//         $teacher = User::factory()->create(['email' => 'teacher@test.com']);
//         $teacher->assignRole('teacher');

//         $this->browse(function (Browser $browser) use ($teacher) {
//             $browser->loginAs($teacher)
//                     ->visit('/admin/settings')
//                     ->assertSee('Kembali')
//                     ->clickLink('Kembali')
//                     ->assertPathIsNot('/admin/settings');
//         });
//     }

//     // =========================================================================
//     // SECTION D: Redirect Setelah Login Berdasarkan Role
//     // =========================================================================

//     /** @test */
//     public function admin_diarahkan_ke_dashboard_admin_setelah_login(): void
//     {
//         $admin = User::factory()->create([
//             'email'    => 'admin@test.com',
//             'password' => bcrypt('password123'),
//         ]);
//         $admin->assignRole('admin');

//         $this->browse(function (Browser $browser) use ($admin) {
//             $browser->visit('/login')
//                     ->type('email', 'admin@test.com')
//                     ->type('password', 'password123')
//                     ->press('Login')
//                     ->assertPathIs('/admin/dashboard');
//         });
//     }

//     /** @test */
//     public function teacher_diarahkan_ke_dashboard_teacher_setelah_login(): void
//     {
//         $teacher = User::factory()->create([
//             'email'    => 'teacher@test.com',
//             'password' => bcrypt('password123'),
//         ]);
//         $teacher->assignRole('teacher');

//         $this->browse(function (Browser $browser) use ($teacher) {
//             $browser->visit('/login')
//                     ->type('email', 'teacher@test.com')
//                     ->type('password', 'password123')
//                     ->press('Login')
//                     ->assertPathIs('/teacher/dashboard');
//         });
//     }

//     /** @test */
//     public function student_diarahkan_ke_dashboard_student_setelah_login(): void
//     {
//         $student = User::factory()->create([
//             'email'    => 'student@test.com',
//             'password' => bcrypt('password123'),
//         ]);
//         $student->assignRole('student');

//         $this->browse(function (Browser $browser) use ($student) {
//             $browser->visit('/login')
//                     ->type('email', 'student@test.com')
//                     ->type('password', 'password123')
//                     ->press('Login')
//                     ->assertPathIs('/student/dashboard');
//         });
//     }
// }
