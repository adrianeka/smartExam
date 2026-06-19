<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LessonController extends Controller
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
    public function store(Request $request, \App\Models\Module $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
        ]);

        $module->lessons()->create([
            'title' => $request->title,
            'content' => $request->content,
            'video_url' => $request->video_url,
            'order_index' => $module->lessons()->count() + 1,
        ]);

        return redirect()->back()->with('success', 'Materi berhasil ditambahkan.');
    }

    public function destroy(\App\Models\Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->back()->with('success', 'Materi berhasil dihapus.');
    }
}
