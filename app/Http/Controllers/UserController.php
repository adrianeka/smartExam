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
        // Don't allow editing the main admin unless it's the admin themselves doing it
        if ($user->hasRole('admin') && auth()->id() !== $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat mengedit akun Super Admin lain.');
        }

        $roles        = Role::all();
        $userRoleIds  = $user->roles->pluck('id')->toArray();

        return view('admin.users.edit', compact('user', 'roles', 'userRoleIds'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->hasRole('admin') && auth()->id() !== $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat mengedit akun Super Admin lain.');
        }

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', "unique:users,email,{$user->id}"],
            'roles'      => ['required', 'array', 'min:1'],
            'roles.*'    => ['exists:roles,name'],
            'status'     => ['required', 'in:active,pending,rejected'],
            'password'   => ['nullable', 'min:5'],
        ]);

        $fullName = $data['first_name'] . ' ' . $data['last_name'];

        $updateData = [
            'name'   => $fullName,
            'email'  => $data['email'],
            'status' => $data['status'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        // Jangan izinkan menghilangkan role admin dari diri sendiri
        if ($user->id === auth()->id() && !in_array('admin', $data['roles'])) {
            $data['roles'][] = 'admin'; // paksa admin tetap ada
        }

        $user->syncRoles($data['roles']);

        return redirect()->route('admin.users.index')
            ->with('success', "Pengguna \"{$user->name}\" berhasil diperbarui.");
    }

    // ── Delete user ───────────────────────────────────────────────────────────
    public function destroy(User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->hasRole('admin')) {
            return back()->with('error', 'Akun Super Admin tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,approve,reject',
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:users,id',
        ]);

        $action = $request->action;
        $ids = $request->ids;

        $users = User::whereIn('id', $ids)->get();
        $count = 0;

        foreach ($users as $user) {
            if ($action === 'delete') {
                if ($user->id !== auth()->id() && !$user->hasRole('admin')) {
                    $user->delete();
                    $count++;
                }
            } elseif ($action === 'approve') {
                if ($user->status !== 'active') {
                    $user->update(['status' => 'active']);
                    $count++;
                }
            } elseif ($action === 'reject') {
                if ($user->id !== auth()->id() && !$user->hasRole('admin') && $user->status !== 'rejected') {
                    $user->update(['status' => 'rejected']);
                    $count++;
                }
            }
        }

        $message = "Berhasil memproses $count pengguna.";
        if ($count < count($ids)) {
            $message .= " (Beberapa pengguna tidak dapat diproses karena alasan keamanan/status).";
        }

        return redirect()->back()->with('success', $message);
    }

    public function show(User $user)
    {
        // Load courses with pivot data
        $user->load(['courses' => function ($query) {
            $query->withPivot(['time_spent_seconds', 'total_posts']);
        }]);

        return view('users.show', compact('user'));
    }
}