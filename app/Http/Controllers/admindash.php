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
        // Filter users based on search and category filter
        $users = User::query();
    
        // Apply search filter if present
        if ($request->filled('search')) {
            $users->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
    
        // Apply category filter if present
        if ($request->filled('date_filter')) {
            $filter = $request->date_filter;
            switch ($filter) {
                case 'today':
                    $users->whereDate('created_at', date('Y-m-d')); // Today
                    break;
                case 'yesterday':
                    $users->whereDate('created_at', date('Y-m-d', strtotime('yesterday'))); // Yesterday
                    break;
                case 'last_week':
                    // Get the start and end date of the last week (Monday to Sunday)
                    $startOfLastWeek = date('Y-m-d', strtotime('last Monday -1 week'));
                    $endOfLastWeek = date('Y-m-d', strtotime('last Sunday -1 week'));
                    $users->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek]); // Last week (Monday to Sunday)
                    break;
                case 'last_month':
                    $users->whereMonth('created_at', date('m', strtotime('-1 month'))); // Last month
                    break;
                default:
                    // No filter
                    break;
            }
        }
    
        // Get the filtered users
        $users = $users->paginate(10);
    
        // Check if no users are found, and redirect with a message
        if ($users->isEmpty()) {
            return redirect()->route('admin.manage-users')->with('error', 'No users found for the selected filter.');
        }
    
        return view('admin.manage-users', compact('users'));
    }    

    /**
     * Approve multiple users in bulk.
     */
    public function bulkApprove(Request $request)
    {
        // Decode the JSON string to an array of user IDs
        $userIds = json_decode($request->input('userIds'));

        // Perform the bulk approve action for the users
        User::whereIn('id', $userIds)->update(['is_approved' => true]);

        return redirect()->route('admin.manage-users')->with('success', 'Selected users have been approved.');
    }

    public function bulkDisapprove(Request $request)
    {
        // Decode the JSON string to an array of user IDs
        $userIds = json_decode($request->input('userIds'));

        // Perform the bulk disapprove action for the users
        User::whereIn('id', $userIds)->update(['is_approved' => false]);

        return redirect()->route('admin.manage-users')->with('success', 'Selected users have been disapproved.');
    }

    public function bulkDelete(Request $request)
    {
        // Decode the JSON string to an array of user IDs
        $userIds = json_decode($request->input('userIds'));

        // Perform the bulk delete action for the users
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
