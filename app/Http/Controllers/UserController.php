<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:user.view',   ['only' => ['index', 'show']]);
        // $this->middleware('permission:user.create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:user.edit',   ['only' => ['edit', 'update']]);
        // $this->middleware('permission:user.delete', ['only' => ['destroy']]);
    }

    // public function index()
    // {
    //     $users = User::with('roles')->latest()->paginate(15);

    //     return view('users.index', compact('users'));
    // }
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,teacher,student',
            'status' => 'required|in:active,rejected',
            'image' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:102400', // max 100MB
        ];

        if ($request->password_type === 'manual') {
            $rules['password'] = 'required|min:5';
        }

        $request->validate($rules);

        $fullName = $request->first_name . ' ' . $request->last_name;
        $password = $request->password_type === 'auto' ? \Illuminate\Support\Str::random(8) : $request->password;

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('user_documents', 'public');
        }

        $user = User::create([
            'name' => $fullName,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => $request->role,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        $user->assignRole($request->role);

        $message = 'Pengguna berhasil ditambahkan dengan role ' . ucfirst($request->role);

        if ($request->action === 'save_and_add_more') {
            return redirect()->route('admin.user.create')->with('success', $message);
        }

        return redirect()->route('admin.users.index')->with('success', $message);
    }

    public function edit(User $user)
    {
        $roles        = Role::all();
        $userRoleIds  = $user->roles->pluck('id')->toArray();

        return view('users.edit', compact('user', 'roles', 'userRoleIds'));
    }

     public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', "unique:users,email,{$user->id}"],
            'roles'   => ['required', 'array', 'min:1'],
            'roles.*' => ['exists:roles,id'],
            'status' => ['required', 'in:active,rejected,pending']
        ]);

        $user->update([
            'name'  => $data['name'],
            'email' => $data['email'],
            'status' => $data['status']
        ]);

        $user->syncRoles($data['roles']);

        return redirect()->route('users.index')
            ->with('success', "User \"{$user->name}\" updated successfully.");
    }

    // // ── Delete user ───────────────────────────────────────────────────────────
    // public function destroy(User $user)
    // {
    //     // Prevent self-deletion
    //     if ($user->id === auth()->id()) {
    //         return back()->with('error', 'You cannot delete your own account.');
    //     }

    //     $user->delete();

    //     return redirect()->route('users.index')
    //         ->with('success', 'User deleted successfully.');
    // }

    public function show(User $user)
    {
        // Load courses with pivot data
        $user->load(['courses' => function ($query) {
            $query->withPivot(['time_spent_seconds', 'total_posts']);
        }]);

        return view('users.show', compact('user'));
    }
}