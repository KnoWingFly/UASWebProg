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
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('email', 'LIKE', '%' . $request->search . '%');
            });
        }
    
        // Filter by date range
        if ($request->has('date_filter') && !empty($request->date_filter)) {
            $dateFilter = $request->date_filter;
            switch ($dateFilter) {
                case 'today':
                    $query->whereDate('created_at', now()->format('Y-m-d'));
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', now()->subDay()->format('Y-m-d'));
                    break;
                case 'last_week':
                    $query->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', now()->subMonth()->format('m'))
                        ->whereYear('created_at', now()->subMonth()->format('Y'));
                    break;
            }
        }
    
        $users = $query->paginate(10);
    
        // If no users are found and a filter is applied, redirect with the default filter
        if ($users->isEmpty() && $request->has('date_filter') && $request->date_filter != '') {
            return redirect()->route('admin.manage-users', ['search' => $request->search])
                             ->with('message', 'No users found for the selected filter.');  // optional message
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
