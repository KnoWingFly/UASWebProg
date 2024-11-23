<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Event;
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
        $users = User::query();

        if ($request->filled('search')) {
            $users->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('date_filter')) {
            $filter = $request->date_filter;
            switch ($filter) {
                case 'today':
                    $users->whereDate('created_at', date('Y-m-d'));
                    break;
                case 'yesterday':
                    $users->whereDate('created_at', date('Y-m-d', strtotime('yesterday')));
                    break;
                case 'last_week':
                    $startOfLastWeek = date('Y-m-d', strtotime('last Monday -1 week'));
                    $endOfLastWeek = date('Y-m-d', strtotime('last Sunday -1 week'));
                    $users->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek]);
                    break;
                case 'last_month':
                    $users->whereMonth('created_at', date('m', strtotime('-1 month')));
                    break;
                default:
                    break;
            }
        }

        $users = $users->paginate(10);

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
        $userIds = json_decode($request->input('userIds'));
        User::whereIn('id', $userIds)->update(['is_approved' => true]);

        return redirect()->route('admin.manage-users')->with('success', 'Selected users have been approved.');
    }

    /**
     * Disapprove multiple users in bulk.
     */
    public function bulkDisapprove(Request $request)
    {
        $userIds = json_decode($request->input('userIds'));
        User::whereIn('id', $userIds)->update(['is_approved' => false]);

        return redirect()->route('admin.manage-users')->with('success', 'Selected users have been disapproved.');
    }

    /**
     * Delete multiple users in bulk.
     */
    public function bulkDelete(Request $request)
    {
        $userIds = json_decode($request->input('userIds'));
        User::whereIn('id', $userIds)->delete();

        return redirect()->route('admin.manage-users')->with('success', 'Selected users have been deleted.');
    }

    /**
     * Delete a user.
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

    // Event management methods
    public function indexEvents()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.manage-events', compact('events'));
    }

    public function createEvent()
    {
        return view('admin.events.create-events');
    }

    private function generateSecureImageName($file)
    {
        $extension = $file->getClientOriginalExtension();
        $randomName = Str::uuid() . '_' . time();
        return $randomName . '.' . $extension;
    }

    private function storeEventBanner($file)
    {
        if (!$file) {
            return null;
        }

        $fileName = $this->generateSecureImageName($file);
        $path = $file->storeAs('events', $fileName, 'public');

        return $path;
    }

    private function deleteEventBanner($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'participant_limit' => 'nullable|integer|min:1',
            'event_start_date' => 'required|date',
            'event_start_time' => 'required',
            'event_end_date' => 'required|date',
            'event_end_time' => 'required',
        ]);

        try {
            $startDateTime = Carbon::parse($request->event_start_date . ' ' . $request->event_start_time);
            $endDateTime = Carbon::parse($request->event_end_date . ' ' . $request->event_end_time);

            if ($endDateTime <= $startDateTime) {
                return back()
                    ->withInput()
                    ->withErrors(['event_end_date' => 'Event end time must be after the start time']);
            }

            $bannerPath = $request->file('banner')->store('events', 'public');

            Event::create([
                'name' => $validated['name'],
                'banner' => $bannerPath,
                'description' => $validated['description'],
                'participant_limit' => $validated['participant_limit'],
                'registration_start' => $startDateTime,
                'registration_end' => $endDateTime,
            ]);

            return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'There was an error creating the event: ' . $e->getMessage());
        }
    }

    public function editEvent(Event $event)
    {
        $event->event_start_date = Carbon::parse($event->registration_start)->format('Y-m-d');
        $event->event_start_time = Carbon::parse($event->registration_start)->format('H:i');
        $event->event_end_date = Carbon::parse($event->registration_end)->format('Y-m-d');
        $event->event_end_time = Carbon::parse($event->registration_end)->format('H:i');

        return view('admin.events.edit-events', compact('event'));
    }

    public function updateEvent(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'participant_limit' => 'nullable|integer|min:1',
            'event_start_date' => 'required|date',
            'event_start_time' => 'required',
            'event_end_date' => 'required|date',
            'event_end_time' => 'required',
        ]);

        try {
            $startDateTime = Carbon::parse($request->event_start_date . ' ' . $request->event_start_time);
            $endDateTime = Carbon::parse($request->event_end_date . ' ' . $request->event_end_time);

            if ($endDateTime <= $startDateTime) {
                return back()
                    ->withInput()
                    ->withErrors(['event_end_date' => 'Event end time must be after event start time']);
            }

            $bannerPath = $event->banner;
            if ($request->hasFile('banner')) {
                $newBannerPath = $this->storeEventBanner($request->file('banner'));
                if ($newBannerPath) {
                    $this->deleteEventBanner($event->banner);
                    $bannerPath = $newBannerPath;
                }
            }

            $event->update([
                'name' => $validated['name'],
                'banner' => $bannerPath,
                'description' => $validated['description'],
                'participant_limit' => $validated['participant_limit'],
                'registration_start' => $startDateTime,
                'registration_end' => $endDateTime,
            ]);

            return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'There was an error updating the event: ' . $e->getMessage());
        }
    }

    public function deleteEvent(Event $event)
    {
        $this->deleteEventBanner($event->banner);
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}
