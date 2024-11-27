<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityHistoryController extends Controller
{
    public function index()
    {
        $activities = ActivityHistory::with('users')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $users = User::all();

        return view('admin.activity-history.index', [
            'activities' => $activities,
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'activity_type' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'description' => 'nullable|string',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        DB::transaction(function () use ($validatedData, $request) {
            $activity = ActivityHistory::create([
                'user_id' => null, // Set a default null value
                'activity_type' => $validatedData['activity_type'],
                'activity_date' => $validatedData['activity_date'],
                'description' => $request->input('description')
            ]);

            // Only attach users if user_ids are provided
            if (!empty($validatedData['user_ids'])) {
                $activity->users()->attach($validatedData['user_ids']);
            }
        });

        return redirect()->route('admin.activity-history.index')
            ->with('success', 'Activity history entry created successfully.');
    }

    public function destroy(ActivityHistory $activityHistory)
    {
        DB::transaction(function () use ($activityHistory) {
            // Detach all users first
            $activityHistory->users()->detach();

            // Then delete the activity
            $activityHistory->delete();
        });

        return redirect()->route('admin.activity-history.index')
            ->with('success', 'Activity history entry deleted successfully.');
    }

    public function addUsers(Request $request, ActivityHistory $activityHistory)
    {
        $validatedData = $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id'
        ]);

        // Attach new users to the activity, avoiding duplicates
        $activityHistory->users()->syncWithoutDetaching($validatedData['user_ids']);

        return redirect()->route('admin.activity-history.index')
            ->with('success', 'Users added to activity successfully.');
    }

    public function manageUsers(Request $request, ActivityHistory $activityHistory)
    {
        $validatedData = $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id'
        ]);

        // Sync the users for this activity
        $activityHistory->users()->sync($validatedData['user_ids']);

        return redirect()->route('admin.activity-history.index')
            ->with('success', 'Users updated for activity successfully.');
    }

    public function update(Request $request, ActivityHistory $activityHistory)
    {
        $validatedData = $request->validate([
            'activity_type' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        $activityHistory->update([
            'activity_type' => $validatedData['activity_type'],
            'activity_date' => $validatedData['activity_date'],
            'description' => $request->input('description')
        ]);

        return redirect()->route('admin.activity-history.index')
            ->with('success', 'Activity updated successfully.');
    }
}