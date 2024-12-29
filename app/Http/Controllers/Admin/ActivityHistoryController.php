    <?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use App\Models\ActivityHistory;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

    class ActivityHistoryController extends Controller
    {
        public function index(Request $request)
        {
            // Fetch all activities with related users (optional, not paginated)
            $allActivities = ActivityHistory::with('users')->get();
        
            // Paginate activities with related users
            $activities = ActivityHistory::with('users')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        
            return view('admin.activity-history.index', [
                'allActivities' => $allActivities,
                'activities' => $activities,
            ]);
        }

        public function fetchUsers(Request $request)
        {
            $users = User::paginate(10);

            // Check if the request is an AJAX call
            if ($request->ajax()) {
                return view('partials.user-table', compact('users'))->render();
            }

            // For normal requests, return the full page
            return view('your-main-view', compact('users'));
        }

        public function manageUsers(Request $request, ActivityHistory $activityHistory)
        {
            $validatedData = $request->validate([
                'user_ids' => 'nullable|array',
                'user_ids.*' => 'exists:users,id',
            ]);

            // Sync the users for this activity
            $activityHistory->users()->sync($validatedData['user_ids']);

            return redirect()->route('admin.activity-history.index')
                ->with('success', 'Users updated for activity successfully.');
        }

        public function showActivityHistory($id)
        {
            $activity = ActivityHistory::findOrFail($id);
            $users = User::all();

            return view('admin.activity-history.index', compact('activity', 'users'));
        }

        public function show($id)
        {
            $activity = ActivityHistory::with('users')->findOrFail($id);
            $users = User::all(); // Ambil semua data pengguna
        
            return view('admin.activity-history.show', [
                'activity' => $activity,
                'users' => $users,
            ]);
        }
        

        public function store(Request $request)
        {
            $validatedData = $request->validate([
                'activity_type' => 'required|string|max:255',
                'activity_date' => 'required|date',
                'description' => 'nullable|string',
                'user_ids' => 'nullable|array',
                'user_ids.*' => 'exists:users,id',
            ]);

            DB::transaction(function () use ($validatedData, $request) {
                $activity = ActivityHistory::create([
                    'user_id' => null,
                    'activity_type' => $validatedData['activity_type'],
                    'activity_date' => $validatedData['activity_date'],
                    'description' => $request->input('description'),
                ]);

                if (!empty($validatedData['user_ids'])) {
                    $activity->users()->attach($validatedData['user_ids']);
                }
            });

            return redirect()->route('admin.activity-history.index')
                ->with('success', 'Activity history entry created successfully.');
        }

        public function getUsers(ActivityHistory $activity, Request $request)
        {
            $page = $request->query('page', 1);
            $users = $activity->users()->paginate(10, ['*'], 'page', $page);

            $html = view('partials.user-rows', ['users' => $users, 'activity' => $activity])->render();
            $hasMorePages = $users->hasMorePages();

            return response()->json([
                'html' => $html,
                'hasMorePages' => $hasMorePages,
            ]);
        }

        public function destroy(ActivityHistory $activityHistory)
        {
            DB::transaction(function () use ($activityHistory) {
                $activityHistory->users()->detach();
                $activityHistory->delete();
            });

            return redirect()->route('admin.activity-history.index')
                ->with('success', 'Activity history entry deleted successfully.');
        }

        public function addUsers(Request $request, ActivityHistory $activityHistory)
        {
            $validatedData = $request->validate([
                'user_ids' => 'required|array|min:1',
                'user_ids.*' => 'exists:users,id',
            ]);

            $activityHistory->users()->syncWithoutDetaching($validatedData['user_ids']);

            return redirect()->route('admin.activity-history.index')
                ->with('success', 'Users added to activity successfully.');
        }

        public function updateUsers(Request $request, ActivityHistory $activityHistory)
        {
            $validatedData = $request->validate([
                'user_ids' => 'required|array|min:1',
                'user_ids.*' => 'exists:users,id',
            ]);

            $activityHistory->users()->sync($validatedData['user_ids']);

            return redirect()->route('admin.activity-history.index')
                ->with('success', 'Users updated for activity successfully.');
        }

        public function update(Request $request, ActivityHistory $activityHistory)
        {
            $validatedData = $request->validate([
                'activity_type' => 'required|string|max:255',
                'activity_date' => 'required|date',
                'description' => 'nullable|string',
            ]);

            $activityHistory->update([
                'activity_type' => $validatedData['activity_type'],
                'activity_date' => $validatedData['activity_date'],
                'description' => $request->input('description'),
            ]);

            return redirect()->route('admin.activity-history.index')
                ->with('success', 'Activity updated successfully.');
        }
    }
