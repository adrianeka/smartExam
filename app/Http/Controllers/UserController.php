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
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            // 'username' => 'required|string|unique:users,username',
            'password' => 'required|min:5',
            'role' => 'required|in:admin,teacher,student',
        ]);

        $fullName = $request->first_name . ' ' . $request->last_name;

        $user = User::create([
            'name' => $fullName,
            'email' => $request->email,
            // 'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan dengan role ' . $request->role);
    }

    // public function edit(User $user)
    // {
    //     $roles        = Role::all();
    //     $userRoleIds  = $user->roles->pluck('id')->toArray();

    //     return view('users.edit', compact('user', 'roles', 'userRoleIds'));
    // }

    //  public function update(Request $request, User $user)
    // {
    //     $data = $request->validate([
    //         'name'    => ['required', 'string', 'max:255'],
    //         'email'   => ['required', 'email', "unique:users,email,{$user->id}"],
    //         'roles'   => ['required', 'array', 'min:1'],
    //         'roles.*' => ['exists:roles,id'],
    //     ]);

    //     $user->update([
    //         'name'  => $data['name'],
    //         'email' => $data['email'],
    //     ]);

    //     $user->syncRoles($data['roles']);

    //     return redirect()->route('users.index')
    //         ->with('success', "User \"{$user->name}\" updated successfully.");
    // }

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

}