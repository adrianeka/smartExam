<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\DuskTestCase;

/**
 * Test Suite: Page Permission Access per Role
 * Menguji akses halaman berdasarkan role: admin, teacher, student
 *
 * Jalankan dengan:
 *   php artisan dusk --filter PermissionAccessTest
 */
class PermissionAccessTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected User $adminUser;
    protected User $teacherUser;
    protected User $studentUser;

    // protected function setUp(): void
    // {
    //     parent::setUp();

    //     app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    //     // --- Buat Permissions ---
    //     // Admin
    //     Permission::create(['name' => 'manage users']);
    //     Permission::create(['name' => 'manage roles']);
    //     Permission::create(['name' => 'view reports']);
    //     Permission::create(['name' => 'manage settings']);

    //     // Teacher
    //     Permission::create(['name' => 'manage courses']);
    //     Permission::create(['name' => 'manage assignments']);
    //     Permission::create(['name' => 'grade students']);
    //     Permission::create(['name' => 'view students']);

    //     // Student
    //     Permission::create(['name' => 'view courses']);
    //     Permission::create(['name' => 'submit assignments']);
    //     Permission::create(['name' => 'view grades']);
    //     Permission::create(['name' => 'view profile']);

    //     // --- Buat Roles & assign permissions ---
    //     $adminRole = Role::create(['name' => 'admin']);
    //     $adminRole->givePermissionTo([
    //         'manage users', 'manage roles', 'view reports', 'manage settings',
    //         'manage courses', 'manage assignments', 'grade students',
    //         'view students', 'view courses', 'view grades',
    //     ]);

    //     $teacherRole = Role::create(['name' => 'teacher']);
    //     $teacherRole->givePermissionTo([
    //         'manage courses', 'manage assignments', 'grade students',
    //         'view students', 'view courses',
    //     ]);

    //     $studentRole = Role::create(['name' => 'student']);
    //     $studentRole->givePermissionTo([
    //         'view courses', 'submit assignments', 'view grades', 'view profile',
    //     ]);

    //     // --- Buat Users ---
    //     $this->adminUser = User::factory()->create([
    //         'name'  => 'Administrator',
    //         'email' => 'admin@test.com',
    //     ]);
    //     $this->adminUser->assignRole('admin');

    //     $this->teacherUser = User::factory()->create([
    //         'name'  => 'Pak Guru',
    //         'email' => 'teacher@test.com',
    //     ]);
    //     $this->teacherUser->assignRole('teacher');

    //     $this->studentUser = User::factory()->create([
    //         'name'  => 'Murid',
    //         'email' => 'student@test.com',
    //     ]);
    //     $this->studentUser->assignRole('student');
    // }

    // =========================================================================
    // SECTION A: Admin — Akses Penuh
    // =========================================================================

    /** @test */
    public function test_admin_dapat_mengakses_dashboard_admin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                    ->visit('/admin/dashboard')
                    ->assertPathIs('/admin/dashboard')
                    ->assertSee('Dashboard Admin')
                    ->assertDontSee('403')
                    ->assertDontSee('Forbidden');
        });
    }

    /** @test */
    public function test_admin_dapat_mengakses_halaman_manajemen_user(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                    ->visit('/admin/users')
                    ->assertPathIs('/admin/users')
                    ->assertSee('Manajemen User')
                    ->assertDontSee('403');
        });
    }

    /** @test */
    public function test_admin_dapat_mengakses_halaman_manajemen_role(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                    ->visit('/admin/roles')
                    ->assertPathIs('/admin/roles')
                    ->assertSee('Manajemen Role')
                    ->assertDontSee('403');
        });
    }

    /** @test */
    public function test_admin_dapat_mengakses_laporan(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                    ->visit('/admin/reports')
                    ->assertPathIs('/admin/reports')
                    ->assertSee('Laporan')
                    ->assertDontSee('403');
        });
    }

    /** @test */
    public function test_admin_dapat_mengakses_pengaturan_sistem(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                    ->visit('/admin/settings')
                    ->assertPathIs('/admin/settings')
                    ->assertSee('Pengaturan')
                    ->assertDontSee('403');
        });
    }

    /** @test */
    public function test_admin_dapat_mengakses_manajemen_kursus(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                    ->visit('/courses')
                    ->assertPathIs('/courses')
                    ->assertDontSee('403');
        });
    }

    // =========================================================================
    // SECTION B: Teacher — Akses Terbatas (kursus & siswa)
    // =========================================================================

    /** @test */
    public function test_teacher_dapat_mengakses_dashboard_teacher(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->teacherUser)
                    ->visit('/teacher/dashboard')
                    ->assertPathIs('/teacher/dashboard')
                    ->assertSee('Dashboard Guru')
                    ->assertDontSee('403');
        });
    }

    /** @test */
    public function test_teacher_dapat_mengakses_halaman_kursus(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->teacherUser)
                    ->visit('/courses')
                    ->assertPathIs('/courses')
                    ->assertSee('Kursus')
                    ->assertDontSee('403');
        });
    }

    /** @test */
    public function test_teacher_dapat_mengakses_halaman_tugas(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->teacherUser)
                    ->visit('/assignments')
                    ->assertPathIs('/assignments')
                    ->assertSee('Tugas')
                    ->assertDontSee('403');
        });
    }

    /** @test */
    public function test_teacher_dapat_mengakses_daftar_siswa(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->teacherUser)
                    ->visit('/teacher/students')
                    ->assertPathIs('/teacher/students')
                    ->assertSee('Daftar Siswa')
                    ->assertDontSee('403');
        });
    }

    /** @test */
    public function test_teacher_dapat_mengakses_halaman_penilaian(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->teacherUser)
                    ->visit('/grades')
                    ->assertPathIs('/grades')
                    ->assertDontSee('403');
        });
    }

    /** @test */
    public function test_teacher_tidak_dapat_mengakses_manajemen_user(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->teacherUser)
                    ->visit('/admin/users')
                    ->assertPathIsNot('/admin/users'); // redirect atau 403

            // Pastikan diarahkan ke halaman error atau home
            $browser->assertSee('403')
                    ->orElse(function (Browser $b) {
                        $b->assertPathIs('/'); // redirect ke home
                    });
        });
    }

    /** @test */
    public function test_teacher_tidak_dapat_mengakses_pengaturan_sistem(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->teacherUser)
                    ->visit('/admin/settings')
                    ->assertDontSee('Pengaturan Sistem');
        });
    }

    /** @test */
    public function test_teacher_tidak_dapat_mengakses_manajemen_role(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->teacherUser)
                    ->visit('/admin/roles')
                    ->assertDontSee('Manajemen Role');
        });
    }

    // =========================================================================
    // SECTION C: Student — Akses Paling Terbatas
    // =========================================================================

    /** @test */
    public function test_student_dapat_mengakses_dashboard_student(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->studentUser)
                    ->visit('/student/dashboard')
                    ->assertPathIs('/student/dashboard')
                    ->assertSee('Dashboard Siswa')
                    ->assertDontSee('403');
        });
    }

    /** @test */
    public function test_student_dapat_melihat_daftar_kursus(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->studentUser)
                    ->visit('/courses')
                    ->assertPathIs('/courses')
                    ->assertSee('Kursus')
                    ->assertDontSee('403');
        });
    }

    /** @test */
    public function test_student_dapat_mengakses_halaman_nilai(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->studentUser)
                    ->visit('/student/grades')
                    ->assertPathIs('/student/grades')
                    ->assertSee('Nilai Saya')
                    ->assertDontSee('403');
        });
    }

    /** @test */
    public function test_student_dapat_mengakses_profil(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->studentUser)
                    ->visit('/profile')
                    ->assertPathIs('/profile')
                    ->assertDontSee('403');
        });
    }

    /** @test */
    public function test_student_dapat_melihat_dan_mengumpulkan_tugas(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->studentUser)
                    ->visit('/student/assignments')
                    ->assertPathIs('/student/assignments')
                    ->assertSee('Tugas Saya')
                    ->assertDontSee('403');
        });
    }

    /** @test */
    public function test_student_tidak_dapat_mengakses_panel_admin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->studentUser)
                    ->visit('/admin/dashboard')
                    ->assertPathIsNot('/admin/dashboard')
                    ->assertDontSee('Dashboard Admin');
        });
    }

    /** @test */
    public function test_student_tidak_dapat_mengakses_manajemen_kursus(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->studentUser)
                    ->visit('/courses/create')
                    ->assertDontSee('Buat Kursus Baru');
        });
    }

    /** @test */
    public function test_student_tidak_dapat_menilai_siswa_lain(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->studentUser)
                    ->visit('/grades/manage')
                    ->assertDontSee('Kelola Penilaian');
        });
    }

    /** @test */
    public function test_student_tidak_dapat_mengakses_daftar_semua_user(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->studentUser)
                    ->visit('/admin/users')
                    ->assertDontSee('Manajemen User');
        });
    }

    // =========================================================================
    // SECTION D: Guest (Belum Login)
    // =========================================================================

    /** @test */
    public function test_guest_diarahkan_ke_halaman_login_saat_akses_dashboard(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/dashboard')
                    ->assertPathIs('/login')
                    ->assertSee('Login')
                    ->assertSee('Email');
        });
    }

    /** @test */
    public function test_guest_diarahkan_ke_login_saat_akses_kursus(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/courses')
                    ->assertPathIs('/login');
        });
    }

    /** @test */
    public function test_guest_diarahkan_ke_login_saat_akses_profil(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/profile')
                    ->assertPathIs('/login');
        });
    }

    // =========================================================================
    // SECTION E: Navigasi UI — Elemen Menu Sesuai Role
    // =========================================================================

    /** @test */
    public function test_admin_melihat_menu_navigasi_lengkap(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                    ->visit('/admin/dashboard')
                    ->assertSee('Manajemen User')
                    ->assertSee('Manajemen Role')
                    ->assertSee('Laporan')
                    ->assertSee('Pengaturan');
        });
    }

    /** @test */
    public function test_teacher_melihat_menu_navigasi_teacher(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->teacherUser)
                    ->visit('/teacher/dashboard')
                    ->assertSee('Kursus')
                    ->assertSee('Tugas')
                    ->assertSee('Daftar Siswa')
                    ->assertDontSee('Manajemen User')
                    ->assertDontSee('Manajemen Role');
        });
    }

    /** @test */
    public function test_student_melihat_menu_navigasi_terbatas(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->studentUser)
                    ->visit('/student/dashboard')
                    ->assertSee('Kursus')
                    ->assertSee('Tugas Saya')
                    ->assertSee('Nilai Saya')
                    ->assertDontSee('Manajemen User')
                    ->assertDontSee('Daftar Siswa')
                    ->assertDontSee('Laporan');
        });
    }
}
