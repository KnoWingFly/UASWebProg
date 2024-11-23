<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityHistory;
use App\Models\Achievement;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Method to show the user profile
    public function profile()
    {
        // Get the currently authenticated user
        $user = auth()->user();
        
        // Fetch the user's achievements from the database
        $userAchievements = Achievement::where('user_id', $user->id)->get();
        
        // Fetch the user's activity history
        $userActivities = ActivityHistory::where('user_id', $user->id)->get();
    
        // Log the data for debugging
        \Log::info('User Achievements:', $userAchievements->toArray());
        \Log::info('User Activities:', $userActivities->toArray());
        
        // Pass the data to the view
        return view('user.profile', compact('user', 'userAchievements', 'userActivities'));
    }    
}
