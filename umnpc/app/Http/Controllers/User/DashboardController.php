<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * User dashboard view
     */
    public function userDashboard()
    {
        $user = Auth::user();
        
        // Example: Fetch some user-specific data
        $userData = [
            'name' => $user->name,
            'email' => $user->email,
            // Add more user-specific data as needed
        ];

        return view('user.dashboard', compact('userData'));
    }

    /**
     * Admin dashboard view
     */
    public function adminDashboard()
    {
        // Example: Fetch admin-specific statistics
        $userStats = [
            'total_users' => User::count(),
            'pending_approvals' => User::where('approved', false)->count(),
        ];

        return view('admin.dashboard', compact('userStats'));
    }
}