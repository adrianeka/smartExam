<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionController extends Controller
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
    public function store(Request $request, \App\Models\Exam $exam)
    {
        $request->validate([
            'question_text' => 'required|string',
            'points' => 'required|integer|min:1',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_option' => 'required|integer',
        ]);

        $question = $exam->questions()->create([
            'question_text' => $request->question_text,
            'type' => 'multiple_choice',
            'points' => $request->points,
        ]);

        foreach ($request->options as $index => $optionText) {
            $question->options()->create([
                'option_text' => $optionText,
                'is_correct' => $index == $request->correct_option,
            ]);
        }

        return redirect()->back()->with('success', 'Soal berhasil ditambahkan.');
    }

    public function destroy(\App\Models\Question $question)
    {
        $question->delete();
        return redirect()->back()->with('success', 'Soal berhasil dihapus.');
    }
}
