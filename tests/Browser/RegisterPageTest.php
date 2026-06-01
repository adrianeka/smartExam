<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterPageTest extends DuskTestCase
{
    use DatabaseMigrations;
     public function test_user_can_fill_and_submit_add_user_form(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/tambah-pengguna')
                    // ->assertSee('Tambah Pengguna')
 
                    // Fill first name & last name
                    ->type('@first_name', 'Budi')
                    ->type('@last_name', 'Santoso')
 
                    // Fill username & email
                    ->type('@username', 'budisantoso')
                    ->type('@email', 'budi.santoso@example.com')
 
                    // Fill password: min 5 chars, 2 numbers, 1 special char
                    ->type('@password', 'Pass12!')
 
                    // Select the "Aktif" (active) radio button for account status
                    ->radio('status-true', 'active')
                    ->assertRadioSelected('status-true', 'active')
 
                    // Submit form
                    ->press('Simpan')
 
                    // Assert redirect or success message
                    ->assertSee('berhasil');
        });
    }
 
    /**
     * Test: Validation fails when required fields are empty.
     */
    public function test_form_fails_validation_when_required_fields_are_empty(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/tambah-pengguna')
                    ->press('Simpan')
                    ->assertSee('The password field'); 
        });
    }
 
    /**
     * Test: Password must meet complexity requirements
     * (min 5 chars, at least 2 digits, at least 1 special character).
     */
    public function test_password_fails_when_too_short(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/tambah-pengguna')
                    ->type('@first_name', 'Budi')
                    ->type('@last_name', 'Santoso')
                    ->type('@username', 'budisantoso')
                    ->type('@email', 'budi@example.com')
                    ->type('@password', 'ab1') // too short, no special char
                    ->radio('status-true', 'active')
                    ->press('Simpan')
                    ->assertSee('Tambah Pengguna'); // should stay on page
        });
    }
 
    /**
     * Test: Password fails when it has no numeric characters.
     */
    public function test_password_fails_without_numbers(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/tambah-pengguna')
                    ->type('@first_name', 'Budi')
                    ->type('@last_name', 'Santoso')
                    ->type('@username', 'budisantoso')
                    ->type('@email', 'budi@example.com')
                    ->type('@password', 'Abcde!') // no digits
                    ->radio('status-true', 'active')
                    ->press('Simpan')
                    ->assertSee('Tambah Pengguna');
        });
    }
 
    /**
     * Test: Password fails when it has only one digit (needs at least 2).
     */
    public function test_password_fails_with_only_one_digit(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/tambah-pengguna')
                    ->type('@first_name', 'Budi')
                    ->type('@last_name', 'Santoso')
                    ->type('@username', 'budisantoso')
                    ->type('@email', 'budi@example.com')
                    ->type('@password', 'Abcd1!') // only 1 digit
                    ->radio('status-true', 'active')
                    ->press('Simpan')
                    ->assertSee('Tambah Pengguna');
        });
    }
 
    /**
     * Test: Password fails when it has no special character.
     */
    public function test_password_fails_without_special_character(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/tambah-pengguna')
                    ->type('@first_name', 'Budi')
                    ->type('@last_name', 'Santoso')
                    ->type('@username', 'budisantoso')
                    ->type('@email', 'budi@example.com')
                    ->type('@password', 'Abcd12') // no special char
                    ->radio('status-true', 'active')
                    ->press('Simpan')
                    ->assertSee('Tambah Pengguna');
        });
    }
 
    /**
     * Test: Password succeeds with all requirements met.
     */
    public function test_password_passes_all_requirements(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/tambah-pengguna')
                    ->type('@first_name', 'Budi')
                    ->type('@last_name', 'Santoso')
                    ->type('@username', 'budisantoso')
                    ->type('@email', 'budi@example.com')
                    ->type('@password', 'Abc12!') // 6 chars, 2 digits, 1 special
                    ->radio('status-true', 'active')
                    ->press('Simpan')
                    ->assertSee('berhasil');
        });
    }
 
    /**
     * Test: "Aktif" radio button is selected by default and can be interacted with.
     */
    // public function test_active_radio_button_is_selectable(): void
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/users/create')
 
    //                 // "Aktif" should be pre-selected (checked attribute in the blade)
    //                 ->assertRadioSelected('status-true', 'active')
 
    //                 // Switch to "Tidak aktif"
    //                 ->radio('status-true', 'inactive')
    //                 ->assertRadioSelected('status-true', 'inactive')
 
    //                 // Switch back to "Aktif"
    //                 ->radio('status-true', 'active')
    //                 ->assertRadioSelected('status-true', 'active');
    //     });
    // }
 
    /**
     * Test: "Save and Add More" button submits and resets the form.
     */
    public function test_save_and_add_more_button_works(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/tambah-pengguna')
                    ->type('@first_name', 'Sari')
                    ->type('@last_name', 'Dewi')
                    ->type('@username', 'saridewi')
                    ->type('@email', 'sari.dewi@example.com')
                    ->type('@password', 'Pass12!')
                    ->radio('status-true', 'active')
                    ->press('Simpan dan Tambah Baru')
                    ->assertSee('Tambah Pengguna'); // should reload the create form
        });
    }

}




    