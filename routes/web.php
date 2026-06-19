<?php
require __DIR__ . '/auth.php';
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserActivationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CourseController;
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
        $stats = [];
        if (auth()->user()->hasRole('admin')) {
            $stats['users_count'] = \App\Models\User::count();
            $stats['courses_count'] = \App\Models\Course::count();
            $stats['pending_count'] = \App\Models\User::where('status', 'pending')->count();
        } elseif(auth()->user()->hasRole('teacher') || auth()->user()->hasRole('student')) {
            $stats['courses_count'] = auth()->user()->courses()->count();
        }
        return view('dashboard', compact('stats'));
    })->name('dashboard');

    // Profile routes should be accessible to all logged-in users
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pembelajaran Routes
    Route::get('/learning/courses', [App\Http\Controllers\LearningController::class, 'courses'])->name('learning.courses');
    Route::get('/learning/activities', [App\Http\Controllers\LearningController::class, 'activities'])->name('learning.activities');
    Route::get('/learning/evaluations', [App\Http\Controllers\LearningController::class, 'evaluations'])->name('learning.evaluations');
    Route::get('/learning/reports', [App\Http\Controllers\LearningController::class, 'reports'])->name('learning.reports');

    // Admin specific routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserActivationController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/approve', [UserActivationController::class, 'approve'])->name('users.approve');
        Route::post('/users/{user}/reject', [UserActivationController::class, 'reject'])->name('users.reject');

        // Route untuk menampilkan halaman form (Bisa diakses oleh Admin)
        Route::get('/tambah-pengguna', [UserController::class, 'create'])->name('user.create');
        // Route untuk memproses data saat tombol "Simpan" diklik
        Route::post('/tambah-pengguna', [UserController::class, 'store'])->name('user.store');
        
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/bulk', [UserController::class, 'bulkAction'])->name('users.bulk');
        
        // Route untuk Tambah Pengguna ke Mata Kuliah
        Route::get('/enroll', [App\Http\Controllers\EnrollmentController::class, 'create'])->name('enroll.create');
        Route::post('/enroll', [App\Http\Controllers\EnrollmentController::class, 'store'])->name('enroll.store');

        // Route untuk Laporan Perusahaan
        Route::get('/laporan', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
        
        // Route untuk Daftar Mata Kuliah
        Route::get('/mata-kuliah', [App\Http\Controllers\CourseController::class, 'index'])->name('courses.index');

        // Route untuk Kategori Sesi
        Route::get('/kategori-sesi', function () {
            return view('admin.session-categories.index');
        })->name('session-categories.index');

        Route::resource('courses', CourseController::class);
        Route::post('/courses/bulk', [CourseController::class, 'bulkAction'])->name('courses.bulk');
        
        // Course Content & Exams
        Route::resource('courses.modules', App\Http\Controllers\ModuleController::class)->shallow();
        Route::resource('modules.lessons', App\Http\Controllers\LessonController::class)->shallow();
        Route::resource('courses.exams', App\Http\Controllers\ExamController::class)->shallow();
        Route::resource('exams.questions', App\Http\Controllers\QuestionController::class)->shallow();
        
        // Route untuk Manajemen Role
        Route::resource('roles', App\Http\Controllers\RoleController::class);
    });

});