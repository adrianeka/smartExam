<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModuleController extends Controller
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course->modules()->create([
            'name' => $request->name,
            'description' => $request->description,
            'order_index' => $course->modules()->count() + 1,
        ]);

        return redirect()->back()->with('success', 'Modul berhasil ditambahkan.');
    }

    public function destroy(\App\Models\Module $module)
    {
        $module->delete();
        return redirect()->back()->with('success', 'Modul berhasil dihapus.');
    }
}
