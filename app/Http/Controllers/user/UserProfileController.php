<?php

// app/Http/Controllers/UserProfileController.php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Make sure to use the base controller
use Auth;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
    if (!$user) {
        return redirect()->route('login');
    }

    // Fetch the events the user has participated in
    $participatedEvents = $user->eventUsers;

    // If you want to include user achievements or activities from the previous code
    $userAchievements = []; // Add your logic to fetch user achievements if needed
    $userActivities = $user->activityHistories()->latest()->get();

    return view('user.profile.index', compact('user', 'participatedEvents', 'userAchievements', 'userActivities'));
    }
}



