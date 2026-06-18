<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Get students who have enrolled in courses, eager load courses with pivot
        $users = User::whereHas('roles', function($q) {
            $q->where('name', 'student');
        })->with(['courses' => function($q) {
            // we can sort or filter courses if needed
        }])->get();

        // In order to display a flat table (each row is User-Course), we can flatten the data or loop through it in the view.
        // For the view, it's easier to loop through users, then loop through their courses.
        // Wait, the table in the screenshot is flat: "Mata Kuliah | Pengguna | Email | Jam Kerja | Hasil | Selesai | Mata Kuliah (%)"
        // Let's create a flat collection.
        $reports = collect();

        foreach ($users as $user) {
            foreach ($user->courses as $course) {
                $reports->push((object)[
                    'course_name' => $course->name,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'working_time' => $course->pivot->working_time,
                    'result' => $course->pivot->result,
                    'is_completed' => $course->pivot->is_completed,
                    'progress' => $course->pivot->progress,
                ]);
            }
        }

        // We can paginate if needed, but for now we pass the collection
        // Let's use simple manual pagination logic if needed, or just pass all.
        // Or we can just use DB queries to get flat data and paginate it.
        // To keep it simple, we will just use Eloquent flat mapping.

        return view('reports.index', compact('reports'));
    }
}
