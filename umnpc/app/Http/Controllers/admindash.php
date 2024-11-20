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
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function userApprovals()
    {
        $pendingUsers = User::where('is_approved', false)->get();
        return view('admin.approvals', compact('pendingUsers'));
    }

    public function approveUser(User $user)
    {
        $user->is_approved = true;
        $user->save();

        return redirect()->route('admin.approvals')
            ->with('success', 'User approved successfully.');
    }

    public function settings()
    {
        return view('admin.settings');
    }
}