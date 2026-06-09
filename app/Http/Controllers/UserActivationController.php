<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\AccountApproved;
use App\Notifications\AccountRejected;
use Illuminate\Http\Request;

class UserActivationController extends Controller
{
    // Halaman list user pending (untuk admin)
    public function index(Request $request)
    {
        $query = User::with('roles')->latest();

        // Main search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Advanced Search
        if ($firstName = $request->input('first_name')) {
            $query->where('name', 'like', "{$firstName}%");
        }
        if ($lastName = $request->input('last_name')) {
            $query->where('name', 'like', "%{$lastName}");
        }
        if ($email = $request->input('email')) {
            $query->where('email', 'like', "%{$email}%");
        }
        if ($userId = $request->input('user_id')) {
            $query->where('id', $userId);
        }

        // Role filtering
        if ($role = $request->input('role')) {
            if ($role !== 'Semua') {
                $roleName = strtolower($role);
                if ($roleName === 'mahasiswa') $roleName = 'student';
                if ($roleName === 'dosen') $roleName = 'teacher';
                
                $query->whereHas('roles', function($q) use ($roleName) {
                    $q->where('name', $roleName);
                });
            }
        }

        // Status filtering
        if ($status = $request->input('status')) {
            if ($status === 'Aktif') {
                $query->where('status', 'active');
            } elseif ($status === 'Nonaktif') {
                $query->where('status', 'rejected');
            }
        }

        $limit = $request->input('limit', 10);
        $users = $query->paginate($limit)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    // Approve user
    public function approve(User $user)
    {
        $user->update([
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $user->notify(new AccountApproved());

        return back()->with('success', 'Akun ' . $user->name . ' berhasil disetujui.');
    }

    // Reject user
    public function reject(User $user)
    {
        $user->update(['status' => 'rejected']);
        $user->notify(new AccountRejected());

        return back()->with('success', 'Akun ' . $user->name . ' telah ditolak.');
    }
}
