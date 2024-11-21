<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class admindash extends Controller
{
    /**
     * Display the admin dashboard with statistics.
     */
    public function index()
    {
        $totalUsers = User::count();
        $userUsers = User::where('roles', 'user')->count();
        $pendingUsers = User::where('is_approved', false)->count();

        return view('admin.dashboard', compact('totalUsers', 'userUsers', 'pendingUsers'));
    }

    /**
     * Display a list of users with optional filtering.
     */
    public function manageUsers(Request $request)
    {
        $query = User::query();

        // Search by name or email
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $users = $query->paginate(10);
        return view('admin.manage-users', compact('users'));
    }

    /**
     * Approve multiple users in bulk.
     */
    public function bulkApprove(Request $request)
    {
        $userIds = explode(',', $request->input('userIds'));

        if (empty($userIds)) {
            return redirect()->route('admin.manage-users')->withErrors('No users selected for approval.');
        }

        User::whereIn('id', $userIds)->update(['is_approved' => true]);
        return redirect()->route('admin.manage-users')->with('success', 'Selected users have been approved.');
    }

    /**
     * Delete multiple users in bulk.
     */
    public function bulkDelete(Request $request)
    {
        $userIds = explode(',', $request->input('userIds'));

        if (empty($userIds)) {
            return redirect()->route('admin.manage-users')->withErrors('No users selected for deletion.');
        }

        User::whereIn('id', $userIds)->delete();
        return redirect()->route('admin.manage-users')->with('success', 'Selected users have been deleted.');
    }

    /**
     * Delete a single user.
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.manage-users')->with('success', 'User deleted successfully.');
    }

    /**
     * Update user details.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'is_approved' => 'nullable|boolean',
        ]);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'is_approved' => $request->boolean('is_approved', false),
        ]);

        return redirect()->route('admin.manage-users')->with('success', 'User updated successfully.');
    }
}
