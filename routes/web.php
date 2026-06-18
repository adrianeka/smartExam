<?php
require __DIR__ . '/auth.php';
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserActivationController;
use App\Http\Controllers\UserController;
use Spatie\Permission\Models\Role;
use App\Http\Middleware\RoleRedirectMiddleware;

Route::get('/', function () {
    return redirect('login');
});

Route::get('/register/pending', function () {
    return view('auth.pending');
})->name('register.pending');


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware('role:admin')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserActivationController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/approve', [UserActivationController::class, 'approve'])->name('users.approve');
        Route::post('/users/{user}/reject', [UserActivationController::class, 'reject'])->name('users.reject');

        // Route untuk menampilkan halaman form (Bisa diakses oleh Admin)
        Route::get('/tambah-pengguna', [UserController::class, 'create'])->name('user.create');
        Route::resource('users', UserController::class)
            ->only(['edit', 'update'])
            ->names([
                'edit' => 'user.edit',
                'update' => 'user.update',
            ]);
        // Route untuk memproses data saat tombol "Simpan" diklik
        Route::post('/tambah-pengguna', [UserController::class, 'store'])->name('user.store');
    });

});