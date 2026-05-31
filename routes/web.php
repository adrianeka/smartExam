<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route untuk menampilkan halaman form (Bisa diakses oleh Admin)
Route::get('/admin/tambah-pengguna', [UserController::class, 'create'])->name('user.create');

// Route untuk memproses data saat tombol "Simpan" diklik
Route::post('/admin/tambah-pengguna', [UserController::class, 'store'])->name('user.store');



// // =====================================================================
// // routes/web.php — Contoh konfigurasi route dengan middleware role
// // Salin bagian yang relevan ke file routes/web.php Anda
// // =====================================================================

// use App\Http\Controllers\Admin\ReportController;
// use App\Http\Controllers\Admin\RoleController;
// use App\Http\Controllers\Admin\SettingController;
// use App\Http\Controllers\Admin\UserController;
// use App\Http\Controllers\AssignmentController;
// use App\Http\Controllers\CourseController;
// use App\Http\Controllers\GradeController;
// use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\Student\StudentAssignmentController;
// use App\Http\Controllers\Student\StudentDashboardController;
// use App\Http\Controllers\Student\StudentGradeController;
// use App\Http\Controllers\Teacher\StudentListController;
// use App\Http\Controllers\Teacher\TeacherDashboardController;
// use Illuminate\Support\Facades\Route;

// // -----------------------------------------------------------------------
// // AUTH — Semua user yang sudah login
// // -----------------------------------------------------------------------
// Route::middleware(['auth'])->group(function () {

//     Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
//     Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

//     // -------------------------------------------------------------------
//     // ADMIN ONLY
//     // -------------------------------------------------------------------
//     Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {

//         Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');

//         Route::resource('users', UserController::class);
//         Route::resource('roles', RoleController::class);

//         Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
//         Route::get('/reports/{type}', [ReportController::class, 'show'])->name('reports.show');

//         Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
//         Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
//     });

//     // -------------------------------------------------------------------
//     // TEACHER ONLY
//     // -------------------------------------------------------------------
//     Route::middleware(['role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {

//         Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
//         Route::get('/students', [StudentListController::class, 'index'])->name('students.index');
//     });

//     // -------------------------------------------------------------------
//     // STUDENT ONLY
//     // -------------------------------------------------------------------
//     Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {

//         Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

//         Route::get('/assignments', [StudentAssignmentController::class, 'index'])->name('assignments.index');
//         Route::post('/assignments/{assignment}/submit', [StudentAssignmentController::class, 'submit'])->name('assignments.submit');

//         Route::get('/grades', [StudentGradeController::class, 'index'])->name('grades.index');
//     });

//     // -------------------------------------------------------------------
//     // ADMIN & TEACHER (keduanya boleh akses)
//     // -------------------------------------------------------------------
//     Route::middleware(['role:admin|teacher'])->group(function () {

//         Route::resource('courses', CourseController::class);
//         Route::resource('assignments', AssignmentController::class);

//         Route::get('/grades', [GradeController::class, 'index'])->name('grades.index');
//         Route::post('/grades', [GradeController::class, 'store'])->name('grades.store');
//         Route::put('/grades/{grade}', [GradeController::class, 'update'])->name('grades.update');

//         Route::get('/teacher/students', [StudentListController::class, 'index'])->name('teacher.students');
//     });

//     // -------------------------------------------------------------------
//     // PERMISSION-BASED (alternatif menggunakan can: middleware)
//     // -------------------------------------------------------------------
//     Route::middleware(['can:manage users'])->group(function () {
//         // Route dengan permission spesifik
//     });
// });

// // -----------------------------------------------------------------------
// // GUEST — Redirect berdasarkan role setelah login
// // Tambahkan method ini ke AuthenticatedSessionController
// // -----------------------------------------------------------------------
// /*
// protected function redirectTo(Request $request): string
// {
//     $user = $request->user();

//     if ($user->hasRole('admin')) {
//         return route('admin.dashboard');
//     }

//     if ($user->hasRole('teacher')) {
//         return route('teacher.dashboard');
//     }

//     if ($user->hasRole('student')) {
//         return route('student.dashboard');
//     }

//     return '/';
// }
// */
