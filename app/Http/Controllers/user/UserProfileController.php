<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Fixed: Load the event relationship first, then access its attributes
        $participatedEvents = $user->eventUsers()
            ->with('event') // First load the event relationship
            ->paginate(6, ['*'], 'events_page');

        $userActivities = $user->activityHistories()
            ->latest()
            ->paginate(5, ['*'], 'activities_page');

        return view('user.profile.index', compact('user', 'participatedEvents', 'userActivities'));
    }
}