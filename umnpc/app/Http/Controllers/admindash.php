<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class admindash extends Controller
{
    public function index()
    {
        // Calculate the required statistics
        $totalUsers = User::count(); // Total number of users
        $userUsers = User::where('roles', 'user')->count(); // Users with 'user' role
        $pendingUsers = User::where('is_approved', false)->count(); // Users pending approval

        // Pass these variables to the view
        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'userUsers' => $userUsers,
            'pendingUsers' => $pendingUsers,
        ]);
    }

    public function manageUsers()
    {
        $users = User::all(); // Mengambil semua data pengguna
        return view('admin.manage-users', compact('users'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'is_approved' => 'required|boolean',
        ]);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'is_approved' => $request->input('is_approved'),
        ]);

        return redirect()->route('admin.manage-users')->with('success', 'User updated successfully.');
    }

    // Menghapus pengguna
    public function deleteUser(User $user)
    {
        $user->delete();

        return redirect()->route('admin.manage-users')->with('success', 'User deleted successfully.');
    }

// Di dalam AdminDash Controller
    public function userApprovals()
    {
        // Mengambil semua pengguna yang belum disetujui
        $users = User::where('is_approved', false)->get();

        // Mengirim data pengguna ke view
        return view('admin.approvals', compact('users'));
    }


// Di dalam AdminDash Controller
    public function approveUser(User $user)
    {
        // Mengupdate status approval user
        $user->is_approved = true;
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.approvals')->with('success', 'User approved successfully!');
    }


    public function bulkApprove(Request $request)
    {
        // Ambil data user_ids dari form
        $userIds = $request->input('user_ids');

        // Jika tidak ada checkbox yang dipilih
        if (!$userIds || count($userIds) === 0) {
            return redirect()->route('admin.approvals')->with('error', 'No users selected for approval.');
        }

        // Lanjutkan proses approve
        User::whereIn('id', $userIds)->update(['is_approved' => true]);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.approvals')->with('success', 'Selected users approved successfully!');
    }

    public function settings()
    {
        return view('admin.settings');
    }
}