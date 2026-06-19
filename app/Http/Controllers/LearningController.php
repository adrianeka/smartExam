<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LearningController extends Controller
{
    public function courses()
    {
        // Ambil mata kuliah yang diikuti oleh user yang sedang login
        $courses = auth()->user()->courses()->withPivot('progress', 'is_completed')->get();
        return view('learning.courses', compact('courses'));
    }

    public function activities()
    {
        return view('learning.activities');
    }

    public function evaluations()
    {
        return view('learning.evaluations');
    }

    public function reports()
    {
        return view('learning.reports');
    }
}
