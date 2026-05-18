<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserActivationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/register/pending', function () {
    return view('auth.pending');
})->name('register.pending');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserActivationController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/approve', [UserActivationController::class, 'approve'])->name('users.approve');
    Route::post('/users/{user}/reject', [UserActivationController::class, 'reject'])->name('users.reject');
});

require __DIR__ . '/auth.php';
