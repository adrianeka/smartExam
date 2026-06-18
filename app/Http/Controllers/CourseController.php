<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with(['users' => function($q) {
            $q->whereHas('roles', function($q) {
                $q->where('name', 'teacher');
            });
        }]);

        // Standard Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
        }

        // Advanced Search
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('code')) {
            $query->where('code', 'like', '%' . $request->code . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('language')) {
            $query->where('language', $request->language);
        }
        if ($request->filled('access_type')) {
            $query->where('access_type', $request->access_type);
        }

        $perPage = $request->input('per_page', 10);
        $courses = $query->latest()->paginate($perPage)->withQueryString();
        
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $teachers = \App\Models\User::whereHas('roles', function($q) {
            $q->where('name', 'teacher');
        })->get();

        return view('admin.courses.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:courses',
            'category' => 'nullable|string',
            'department' => 'nullable|string',
            'department_url' => 'nullable|string',
            'language' => 'nullable|string',
            'template_course_id' => 'nullable|string',
            'access_type' => 'nullable|string',
            'storage_limit_mb' => 'nullable|integer',
            'tags' => 'nullable|string',
            'video_url' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['is_demo_content'] = $request->has('is_demo_content');
        $data['is_special_course'] = $request->has('is_special_course');
        
        // Handling radio buttons explicitly if needed
        $data['subscription_allowed'] = $request->input('subscription_type') === 'allowed';
        $data['unsubscription_allowed'] = $request->input('unsubscription_type') === 'allowed';

        $course = Course::create($data);

        if ($request->filled('teachers')) {
            $course->users()->attach($request->teachers);
        }

        return redirect()->route('admin.courses.index')->with('success', 'Mata Kuliah berhasil ditambahkan.');
    }

    public function edit(Course $course)
    {
        $teachers = \App\Models\User::whereHas('roles', function($q) {
            $q->where('name', 'teacher');
        })->get();
        return view('admin.courses.edit', compact('course', 'teachers'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:courses,code,'.$course->id,
            // Add other validations as needed
        ]);

        $data = $request->all();
        $data['is_demo_content'] = $request->has('is_demo_content');
        $data['is_special_course'] = $request->has('is_special_course');
        
        if($request->has('subscription_type')) {
            $data['subscription_allowed'] = $request->input('subscription_type') === 'allowed';
        }
        if($request->has('unsubscription_type')) {
            $data['unsubscription_allowed'] = $request->input('unsubscription_type') === 'allowed';
        }

        $course->update($data);

        if ($request->has('teachers')) {
            // Only sync teachers, preserving students
            $students = $course->users()->whereHas('roles', function($q) {
                $q->where('name', '!=', 'teacher');
            })->pluck('users.id')->toArray();
            
            $course->users()->sync(array_merge($students, $request->teachers));
        }

        return redirect()->route('admin.courses.index')->with('success', 'Mata Kuliah berhasil diperbarui.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Mata Kuliah berhasil dihapus.');
    }
}
