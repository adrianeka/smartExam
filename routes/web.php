<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route untuk menampilkan halaman form (Bisa diakses oleh Admin)
Route::get('/admin/tambah-pengguna', [UserController::class, 'create'])->name('user.create');

// Route untuk memproses data saat tombol "Simpan" diklik
Route::post('/admin/tambah-pengguna', [UserController::class, 'store'])->name('user.store');