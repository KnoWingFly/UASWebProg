<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class admindash extends Controller
{
    // Dashboard Statistics
    public function index()
    {
        $totalUsers = User::count();
        $userUsers = User::where('roles', 'user')->count();
        $pendingUsers = User::where('is_approved', false)->count();

        return view('admin.dashboard', compact('totalUsers', 'userUsers', 'pendingUsers'));
    }

    // Manage Users
    public function manageUsers(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $users = $query->paginate(10);
        return view('admin.manage-users', compact('users'));
    }

    // Bulk Approve Users
    public function bulkApprove(Request $request)
    {
        $userIds = explode(',', $request->input('userIds'));
        User::whereIn('id', $userIds)->update(['is_approved' => true]);

        return redirect()->route('admin.manage-users')->with('success', 'Selected users have been approved.');
    }

    // Bulk Delete Users
    public function bulkDelete(Request $request)
    {
        $userIds = explode(',', $request->input('userIds'));
        User::whereIn('id', $userIds)->delete();

        return redirect()->route('admin.manage-users')->with('success', 'Selected users have been deleted.');
    }

    public function update(Request $request, User $user)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'is_approved' => 'nullable|boolean', // Nullable boolean validation
        ]);
    
        // Update the user with the form data
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            // Ensure is_approved is treated as a boolean
            'is_approved' => $request->has('is_approved') ? (bool) $request->input('is_approved') : false,
        ]);
    
        return redirect()->route('admin.manage-users')->with('success', 'User updated successfully.');
    }
    

}
