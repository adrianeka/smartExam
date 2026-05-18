<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\AccountApproved;
use App\Notifications\AccountRejected;
use Illuminate\Http\Request;

class UserActivationController extends Controller
{
    // Halaman list user pending (untuk admin)
    public function index()
    {
        $users = User::where('status', 'pending')->get();
        return view('admin.users.index', compact('users'));
    }

    // Approve user
    public function approve(User $user)
    {
        $user->update(['status' => 'active']);
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
