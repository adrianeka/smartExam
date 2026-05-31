<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Spatie\Permission\Models\Role;
use Tests\DuskTestCase;

/**
 * Test Suite: Role Assignment (Spatie Permission)
 * Menguji penambahan role ke user menggunakan Spatie Laravel Permission
 *
 * Jalankan dengan:
 *   php artisan dusk --filter RoleAssignmentTest
 */
class RoleAssignmentTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Setup: buat roles dan user sebelum setiap test
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Reset cached roles & permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat roles yang tersedia
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'teacher']);
        Role::create(['name' => 'student']);
    }

    // =========================================================================
    // SECTION 1: Assign Role via UI (Admin Panel)
    // =========================================================================

    /**
     * @test
     * Admin dapat melihat halaman manajemen user
     */
    public function admin_dapat_melihat_halaman_manajemen_user(): void
    {
        $admin = User::factory()->create(['name' => 'Super Admin', 'email' => 'admin@test.com']);
        $admin->assignRole('admin');

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                    ->visit('/admin/users')
                    ->assertPathIs('/admin/users')
                    ->assertSee('Manajemen User')
                    ->assertSee('Daftar User');
        });
    }

    /**
     * @test
     * Admin dapat menetapkan role "teacher" ke user baru
     */
    public function admin_dapat_assign_role_teacher_ke_user(): void
    {
        $admin = User::factory()->create(['email' => 'admin@test.com']);
        $admin->assignRole('admin');

        $targetUser = User::factory()->create([
            'name'  => 'Budi Santoso',
            'email' => 'budi@test.com',
        ]);

        $this->browse(function (Browser $browser) use ($admin, $targetUser) {
            $browser->loginAs($admin)
                    ->visit("/admin/users/{$targetUser->id}/edit")
                    ->assertSee('Edit User')
                    ->assertSee('Budi Santoso')

                    // Pilih role teacher dari dropdown/select
                    ->select('role', 'teacher')
                    ->press('Simpan')

                    ->assertSee('Role berhasil diperbarui')
                    ->assertSee('teacher');

            // Verifikasi di database
            $this->assertTrue($targetUser->fresh()->hasRole('teacher'));
        });
    }

    /**
     * @test
     * Admin dapat menetapkan role "student" ke user
     */
    public function admin_dapat_assign_role_student_ke_user(): void
    {
        $admin = User::factory()->create(['email' => 'admin@test.com']);
        $admin->assignRole('admin');

        $targetUser = User::factory()->create([
            'name'  => 'Siti Rahayu',
            'email' => 'siti@test.com',
        ]);

        $this->browse(function (Browser $browser) use ($admin, $targetUser) {
            $browser->loginAs($admin)
                    ->visit("/admin/users/{$targetUser->id}/edit")
                    ->select('role', 'student')
                    ->press('Simpan')
                    ->assertSee('Role berhasil diperbarui');

            $this->assertTrue($targetUser->fresh()->hasRole('student'));
        });
    }

    /**
     * @test
     * Admin dapat mengubah role user dari teacher menjadi admin
     */
    public function admin_dapat_mengubah_role_dari_teacher_ke_admin(): void
    {
        $admin = User::factory()->create(['email' => 'admin@test.com']);
        $admin->assignRole('admin');

        $targetUser = User::factory()->create(['email' => 'teacher@test.com']);
        $targetUser->assignRole('teacher');

        $this->assertTrue($targetUser->hasRole('teacher'));

        $this->browse(function (Browser $browser) use ($admin, $targetUser) {
            $browser->loginAs($admin)
                    ->visit("/admin/users/{$targetUser->id}/edit")
                    ->assertSee('teacher') // role lama tampil
                    ->select('role', 'admin')
                    ->press('Simpan')
                    ->assertSee('Role berhasil diperbarui');

            $refreshed = $targetUser->fresh();
            $this->assertTrue($refreshed->hasRole('admin'));
            $this->assertFalse($refreshed->hasRole('teacher'));
        });
    }

    /**
     * @test
     * Daftar role tersedia di dropdown form edit user
     */
    public function dropdown_role_menampilkan_semua_role_yang_tersedia(): void
    {
        $admin = User::factory()->create(['email' => 'admin@test.com']);
        $admin->assignRole('admin');

        $targetUser = User::factory()->create(['email' => 'user@test.com']);

        $this->browse(function (Browser $browser) use ($admin, $targetUser) {
            $browser->loginAs($admin)
                    ->visit("/admin/users/{$targetUser->id}/edit")
                    ->assertSelectHasOption('role', 'admin')
                    ->assertSelectHasOption('role', 'teacher')
                    ->assertSelectHasOption('role', 'student');
        });
    }

    /**
     * @test
     * Halaman daftar user menampilkan role masing-masing user
     */
    public function halaman_daftar_user_menampilkan_role_user(): void
    {
        $admin = User::factory()->create(['name' => 'Admin User', 'email' => 'admin@test.com']);
        $admin->assignRole('admin');

        $teacher = User::factory()->create(['name' => 'Pak Guru', 'email' => 'guru@test.com']);
        $teacher->assignRole('teacher');

        $student = User::factory()->create(['name' => 'Murid Baru', 'email' => 'murid@test.com']);
        $student->assignRole('student');

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                    ->visit('/admin/users')
                    ->assertSee('Pak Guru')
                    ->assertSee('teacher')
                    ->assertSee('Murid Baru')
                    ->assertSee('student');
        });
    }

    // =========================================================================
    // SECTION 2: Assign Role via API / Direct Form
    // =========================================================================

    /**
     * @test
     * Form assign role menampilkan validasi jika role tidak dipilih
     */
    public function form_assign_role_validasi_jika_role_kosong(): void
    {
        $admin = User::factory()->create(['email' => 'admin@test.com']);
        $admin->assignRole('admin');

        $targetUser = User::factory()->create(['email' => 'user@test.com']);

        $this->browse(function (Browser $browser) use ($admin, $targetUser) {
            $browser->loginAs($admin)
                    ->visit("/admin/users/{$targetUser->id}/edit")
                    // Kosongkan pilihan role (pilih opsi default/kosong)
                    ->select('role', '')
                    ->press('Simpan')
                    ->assertSee('Role harus dipilih');
        });
    }
}
