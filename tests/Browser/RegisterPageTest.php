<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class RegisterPageTest extends DuskTestCase
{
    // use DatabaseMigrations;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::role('admin')->firstOrFail();
    }

    public function test_user_can_fill_and_submit_add_user_form(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
            ->visit('/admin/tambah-pengguna')
                    ->type('@first_name', 'Budi')
                    ->type('@last_name', 'Santoso')
                    ->type('@username', 'budisantoso')
                    ->type('@email', 'budi.santoso@example.com')
                    ->type('@password', 'Pass12!')
                    ->radio('status-true', 'active')
                    ->assertRadioSelected('status-true', 'active')
                    ->press('Simpan')
                    ->assertSee('berhasil');
        });
    }

    public function test_form_fails_validation_when_required_fields_are_empty(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/tambah-pengguna')
                    ->press('Simpan')
                    ->assertSee('The password field');
        });
    }

    public function test_password_fails_when_too_short(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/tambah-pengguna')
                    ->type('@first_name', 'Budi')
                    ->type('@last_name', 'Santoso')
                    ->type('@username', 'budisantoso')
                    ->type('@email', 'budi@example.com')
                    ->type('@password', 'ab1')
                    ->radio('status-true', 'active')
                    ->assertRadioSelected('status-true', 'active')
                    ->press('Simpan')
                    ->assertSee('Tambah Pengguna');
        });
    }

    public function test_password_fails_without_numbers(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/tambah-pengguna')
                    ->type('@first_name', 'Budi')
                    ->type('@last_name', 'Santoso')
                    ->type('@username', 'budisantoso')
                    ->type('@email', 'budi@example.com')
                    ->type('@password', 'Abcde!')
                    ->radio('status-true', 'active')
                    ->assertRadioSelected('status-true', 'active')
                    ->press('Simpan')
                    ->assertSee('Tambah Pengguna');
        });
    }

    public function test_password_fails_with_only_one_digit(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/tambah-pengguna')
                    ->type('@first_name', 'Budi')
                    ->type('@last_name', 'Santoso')
                    ->type('@username', 'budisantoso')
                    ->type('@email', 'budi@example.com')
                    ->type('@password', 'Abcd1!')
                    ->radio('status-true', 'active')
                    ->assertRadioSelected('status-true', 'active')
                    ->press('Simpan')
                    ->assertSee('Tambah Pengguna');
        });
    }

    public function test_password_fails_without_special_character(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/tambah-pengguna')
                    ->type('@first_name', 'Budi')
                    ->type('@last_name', 'Santoso')
                    ->type('@username', 'budisantoso')
                    ->type('@email', 'budi@example.com')
                    ->type('@password', 'Abcd12')
                    ->radio('status-true', 'active')
                    ->assertRadioSelected('status-true', 'active')
                    ->press('Simpan')
                    ->assertSee('Tambah Pengguna');
        });
    }

    public function test_password_passes_all_requirements(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/tambah-pengguna')
                    ->type('@first_name', 'Budi')
                    ->type('@last_name', 'Santoso')
                    ->type('@username', 'budisantoso')
                    ->type('@email', 'budi@example.com')
                    ->type('@password', 'Abc12!')
                    ->radio('status-true', 'active')
                    ->assertRadioSelected('status-true', 'active')
                    ->press('Simpan')
                    ->assertSee('berhasil');
        });
    }

    public function test_save_and_add_more_button_works(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/tambah-pengguna')
                    ->type('@first_name', 'Sari')
                    ->type('@last_name', 'Dewi')
                    ->type('@username', 'saridewi')
                    ->type('@email', 'sari.dewi@example.com')
                    ->type('@password', 'Pass12!')
                    ->radio('status-true', 'active')
                    ->assertRadioSelected('status-true', 'active')
                    ->press('Simpan dan Tambah Baru')
                    ->assertSee('Tambah Pengguna');
        });
    }
}