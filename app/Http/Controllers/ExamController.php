<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, \App\Models\Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);

        $course->exams()->create($request->only('title', 'duration_minutes', 'passing_score'));

        return redirect()->back()->with('success', 'Ujian berhasil ditambahkan.');
    }

    public function show(\App\Models\Exam $exam)
    {
        $exam->load('questions.options');
        return view('admin.exams.show', compact('exam'));
    }

    public function destroy(\App\Models\Exam $exam)
    {
        $exam->delete();
        return redirect()->back()->with('success', 'Ujian berhasil dihapus.');
    }
}
