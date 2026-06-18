<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function create()
    {
        // Get students and teachers (exclude admins if needed, or get everyone)
        $users = User::whereHas('roles', function($q) {
            $q->whereIn('name', ['student', 'teacher']);
        })->get();

        $courses = Course::all();

        return view('enrollments.create', compact('users', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
            'courses' => 'required|array',
            'courses.*' => 'exists:courses,id',
        ]);

        $courses = Course::whereIn('id', $request->courses)->get();
        
        foreach ($request->users as $userId) {
            $user = User::find($userId);
            if ($user) {
                // Attach courses without detaching existing ones, or use syncWithoutDetaching
                $user->courses()->syncWithoutDetaching($request->courses);
            }
        }

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan ke mata kuliah.');
    }
}
