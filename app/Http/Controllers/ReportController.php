<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        
        $reports = \Illuminate\Support\Facades\DB::table('course_user')
            ->join('users', 'course_user.user_id', '=', 'users.id')
            ->join('courses', 'course_user.course_id', '=', 'courses.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', 'student')
            ->select(
                'courses.name as course_name',
                'users.name as user_name',
                'users.email as user_email',
                'course_user.working_time',
                'course_user.result',
                'course_user.is_completed',
                'course_user.progress'
            )
            ->paginate($perPage)
            ->withQueryString();

        return view('reports.index', compact('reports'));
    }
}
