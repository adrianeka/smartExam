# Laravel Dusk Test — Role & Permission (Spatie)

Test suite lengkap untuk menguji penambahan role ke user dan akses halaman 
berdasarkan role menggunakan **Spatie Laravel Permission** + **Laravel Dusk**.

---

## 📁 Struktur File

```
tests/Browser/
├── RoleAssignmentTest.php     # Uji assign role ke user via UI
├── PermissionAccessTest.php   # Uji akses halaman per role
└── RoleMiddlewareTest.php     # Uji middleware & redirect setelah login

tests/
└── DuskTestCase.php           # Base class Dusk

database/seeders/
└── RolePermissionSeeder.php   # Seed roles, permissions & sample users

routes/
└── web-example.php            # Contoh konfigurasi route dengan middleware
```

---

## ⚙️ Prasyarat & Instalasi

### 1. Install dependensi

```bash
composer require spatie/laravel-permission
composer require --dev laravel/dusk
```

### 2. Publish & migrate

```bash
# Spatie
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate

# Dusk
php artisan dusk:install
```

### 3. Tambahkan trait ke model User

```php
// app/Models/User.php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    // ...
}
```

### 4. Konfigurasi database testing

```ini
# .env.dusk.local
APP_ENV=testing
DB_DATABASE=laravel_dusk_test
```

### 5. Seed data awal

```bash
php artisan db:seed --class=RolePermissionSeeder
```

---

## 🚀 Menjalankan Test

```bash
# Semua test Dusk
php artisan dusk

# Per file test
php artisan dusk tests/Browser/RoleAssignmentTest.php
php artisan dusk tests/Browser/PermissionAccessTest.php
php artisan dusk tests/Browser/RoleMiddlewareTest.php

# Filter per nama method
php artisan dusk --filter admin_dapat_assign_role_teacher_ke_user
php artisan dusk --filter student_tidak_dapat_mengakses_panel_admin

# Dengan output verbose
php artisan dusk --verbose
```

---

## 📋 Daftar Test Case

### `RoleAssignmentTest` — Assign Role via UI

| # | Test | Deskripsi |
|---|------|-----------|
| 1 | `admin_dapat_melihat_halaman_manajemen_user` | Admin bisa akses `/admin/users` |
| 2 | `admin_dapat_assign_role_teacher_ke_user` | Assign role teacher via form edit user |
| 3 | `admin_dapat_assign_role_student_ke_user` | Assign role student via form edit user |
| 4 | `admin_dapat_mengubah_role_dari_teacher_ke_admin` | Ganti role yang sudah ada |
| 5 | `dropdown_role_menampilkan_semua_role_yang_tersedia` | Semua role ada di `<select>` |
| 6 | `halaman_daftar_user_menampilkan_role_user` | Tabel user menampilkan kolom role |
| 7 | `form_assign_role_validasi_jika_role_kosong` | Validasi form jika role tidak dipilih |

### `PermissionAccessTest` — Akses Halaman per Role

**Admin (akses penuh):**
- Dashboard admin, manajemen user, manajemen role, laporan, pengaturan, kursus

**Teacher (akses terbatas):**
- ✅ Dashboard teacher, kursus, tugas, daftar siswa, penilaian
- ❌ Manajemen user, pengaturan, manajemen role

**Student (akses minimal):**
- ✅ Dashboard student, lihat kursus, nilai saya, profil, tugas saya
- ❌ Panel admin, buat kursus, kelola penilaian, daftar semua user

**Guest (belum login):**
- Redirect ke `/login` saat akses semua halaman protected

**Navigasi UI:**
- Menu yang tampil sesuai role masing-masing

### `RoleMiddlewareTest` — Middleware & Redirect

| Test | Deskripsi |
|------|-----------|
| Data provider admin routes | 5 route admin diuji untuk 3 role |
| Data provider teacher routes | 4 route teacher diuji untuk 3 role |
| Halaman 403 tampil benar | Error page dengan pesan "Akses Ditolak" |
| Tombol kembali di 403 | Navigasi balik dari halaman error |
| Redirect admin setelah login | → `/admin/dashboard` |
| Redirect teacher setelah login | → `/teacher/dashboard` |
| Redirect student setelah login | → `/student/dashboard` |

---

## 🗺️ Konfigurasi Route yang Diperlukan

Pastikan route Anda menggunakan middleware Spatie:

```php
// Admin only
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', ...);
    Route::resource('/admin/users', ...);
    Route::resource('/admin/roles', ...);
    Route::get('/admin/reports', ...);
    Route::get('/admin/settings', ...);
});

// Teacher only
Route::middleware(['role:teacher'])->group(function () {
    Route::get('/teacher/dashboard', ...);
    Route::get('/teacher/students', ...);
});

// Student only
Route::middleware(['role:student'])->group(function () {
    Route::get('/student/dashboard', ...);
    Route::get('/student/grades', ...);
    Route::get('/student/assignments', ...);
});

// Admin & Teacher
Route::middleware(['role:admin|teacher'])->group(function () {
    Route::resource('/courses', ...);
    Route::resource('/assignments', ...);
});
```

---

## 🔧 Tips & Troubleshooting

### Reset permission cache di setiap test

```php
protected function setUp(): void
{
    parent::setUp();
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
}
```

### Pastikan `DatabaseMigrations` dipakai (bukan `RefreshDatabase`)

```php
// ✅ Benar untuk Dusk
use Illuminate\Foundation\Testing\DatabaseMigrations;

// ❌ Jangan pakai ini di Dusk
use Illuminate\Foundation\Testing\RefreshDatabase;
```

### Jalankan dalam mode non-headless untuk debugging

```bash
# Edit tests/DuskTestCase.php, hapus --headless flag
# Atau set environment variable:
DUSK_HEADLESS_DISABLED=true php artisan dusk
```

### Screenshot otomatis saat test gagal

Laravel Dusk otomatis menyimpan screenshot di `tests/Browser/screenshots/` saat test gagal.

```bash
# Lihat screenshot
ls tests/Browser/screenshots/
```

---

## 📝 Penyesuaian

Sesuaikan selector HTML dan teks yang diharapkan dengan implementasi UI Anda:

```php
// Contoh jika menggunakan ID selector
->assertSeeIn('#role-badge', 'teacher')

// Contoh jika menggunakan data attribute
->assertAttributeContains('[data-role]', 'data-role', 'admin')

// Contoh jika dropdown menggunakan select2 / livewire
->waitFor('@role-select')
->select('@role-select', 'teacher')
```
